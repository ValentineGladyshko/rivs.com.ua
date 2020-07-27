<?php
require_once("../LDLRIVS.php");

my_session_start();
// give security and verification tokens from session, post and cookies
$verification_token = $_POST['user_verification_token'];
$verification_token1 = $_SESSION['verification_token'];
$security_token = $_SESSION["security_token"];
$security_token1 = $_COOKIE["security_token"];
$email = $_SESSION["email"];

// if some token empty go out
if ($verification_token == null || $verification_token1 == null || $security_token == null || $security_token1 == null) {
    include("../scripts.php");
    echo "<script>$(document).ready(function() { $.redirect('index.php'); });</script>";
    exit();
}

if (hash_equals($verification_token, $verification_token1) && hash_equals($security_token, $security_token1)) {
    $mysqli = mysqli_connect("localhost", "AuthorizedUser", "pWNqyljrhML90CHc", "rivs");
    if ($mysqli->connect_errno) {
        include("../scripts.php");
        echo "<script>$.redirect('index.php');</script>";
        exit();
    }

    if ($stmt = $mysqli->prepare("SELECT UserID FROM passwords WHERE UserLogin=?")) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($userID);
        $stmt->fetch();
        $stmt->close();
    }

    if ($userID != null) {
        if ($stmt = $mysqli->prepare("SELECT `FirstName`, `FirstNameNonce`, `FirstNameTag`,
         `MiddleName`, `MiddleNameNonce`, `MiddleNameTag`, `LastName`, `LastNameNonce`, `LastNameTag`,
          `Phone`, `PhoneNonce`, `PhoneTag` FROM `customers` WHERE UserID=?")) {
            $stmt->bind_param("i", $userID);
            $stmt->execute();
            $stmt->bind_result(
                $first_name_encrypted,
                $first_name_iv,
                $first_name_tag,
                $middle_name_encrypted,
                $middle_name_iv,
                $middle_name_tag,
                $last_name_encrypted,
                $last_name_iv,
                $last_name_tag,
                $phone_encrypted,
                $phone_iv,
                $phone_tag
            );
            $stmt->fetch();
            $stmt->close();
        }


        $cipher = "aes-256-gcm";

        $myfile = fopen("../key.txt", "r");
        $key = base64_decode(fread($myfile, filesize("../key.txt")));
        fclose($myfile);

        $new_key = $key . md5($email, true);

        $first_name = openssl_decrypt($first_name_encrypted, $cipher, $new_key, $options = 0, base64_decode($first_name_iv), base64_decode($first_name_tag));
        $middle_name = openssl_decrypt($middle_name_encrypted, $cipher, $new_key, $options = 0, base64_decode($middle_name_iv), base64_decode($middle_name_tag));
        $last_name = openssl_decrypt($last_name_encrypted, $cipher, $new_key, $options = 0, base64_decode($last_name_iv), base64_decode($last_name_tag));
        $phone = openssl_decrypt($phone_encrypted, $cipher, $new_key, $options = 0, base64_decode($phone_iv), base64_decode($phone_tag));

        $orders = array();
        if ($stmt = $mysqli->prepare("SELECT `orders_in_process`.`OrderId`, `orders_items`.`PriceListID`, `Count`, `orders_items`.`Price`, `ProductName`, `Image`, `Date` 
            FROM `orders_in_process` JOIN `orders_items` ON `orders_in_process`.`OrderId` = `orders_items`.`OrderId` 
            JOIN `pricelist` ON `orders_items`.`PriceListID` = `pricelist`.`PriceListID` WHERE Email = ? ORDER BY `Date` DESC")) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result(
                $orderId,
                $priceListID,
                $count,
                $price,
                $productName,
                $image,
                $date
            );
            while ($stmt->fetch()) {
                $order = new stdClass();
                $order->orderId = $orderId;
                $order->date = $date;
                if (array_key_exists($orderId, $orders)) {
                    $order = $orders[$orderId];
                }

                $item = new stdClass();
                $item->priceListID = $priceListID;
                $item->count = $count;
                $item->price = $price;
                $item->productName = $productName;
                $item->image = $image;

                $order->items[] = $item;

                $orders[$orderId] = $order;
            }
            $stmt->close();
        }

        if ($stmt = $mysqli->prepare("SELECT `orders_statuses`.`StatusId`, `statuses`.`StatusName`, `orders_statuses`.`Date` 
            FROM `orders_in_process` JOIN `orders_statuses` ON `orders_in_process`.`OrderId` = `orders_statuses`.`OrderId` 
            JOIN `statuses` ON `orders_statuses`.`StatusId` = `statuses`.`StatusId` WHERE `orders_in_process`.`OrderId` = ? ORDER BY `orders_statuses`.`Date` DESC")) {
            foreach ($orders as $key => $value) {
                $stmt->bind_param("i", $key);
                $stmt->execute();
                $stmt->bind_result(
                    $statusId,
                    $statusName,
                    $date
                );
                while ($stmt->fetch()) {

                    $item = new stdClass();
                    $item->statusId = $statusId;
                    $item->statusName = $statusName;
                    $item->date = $date;

                    $orders[$key]->statuses[] = $item;
                }
                $orders[$key]->status = $orders[$key]->statuses[0];
            }
            $stmt->close();
        }
        if (1 == true) {
        }
    }
?>
    <!--DOCTYPE html-->
    <html lang="en">

    <head>

        <link rel="shortcut icon" href="/Images/webicon.png" type="image/x-icon">
        <title>
            ТОВ ТВД "РІВС" | Особистий кабінет
        </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">

        <link rel="shortcut icon" href="/Images/favicon.ico" type="image/x-icon">
        <!-- Font Awesome -->
        <? include("../scripts.php"); ?>
    </head>

    <body style="overflow-y: overlay;">
        <? include("functions/header.php"); ?>
        <div class="modal fade" id="changePasswordModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form id="changePasswordForm">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title" id="changePasswordModalLabel">Змінення паролю</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input id="change_password_verification_token" type="hidden" value=<?= $verification_token ?>>
                            <div class="form-group">
                                <label class="control-label" for="change_password_password">Поточний пароль</label>
                                <div class="input-group" id="change_password_password_group">
                                    <input type="password" class="form-control" id="change_password_password" placeholder="Введіть поточний пароль" required>
                                    <div class="input-group-append">
                                        <div onclick="passwordToggle(document.getElementById('change_password_password_img'), document.getElementById('change_password_password'))" class="input-group-text" style="cursor: pointer;">
                                            <img id="change_password_password_img" height="20" src="/icons/eye-fill.svg">
                                        </div>
                                    </div>
                                </div>
                                <div id="change_password_password_feedback" class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="change_password_new_password">Новий пароль</label>
                                <div class="input-group" id="change_password_new_password_group">
                                    <input type="password" class="form-control" id="change_password_new_password" placeholder="Введіть новий пароль" required>
                                    <div class="input-group-append">
                                        <div onclick="passwordToggle(document.getElementById('change_password_new_password_img'), document.getElementById('change_password_new_password'))" class="input-group-text" style="cursor: pointer;">
                                            <img id="change_password_new_password_img" height="20" src="/icons/eye-fill.svg">
                                        </div>
                                    </div>
                                </div>
                                <div id="change_password_new_password_feedback" class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="change_password_repeat_password">Повторний пароль</label>
                                <div class="input-group" id="change_password_repeat_password_group">
                                    <input type="password" class="form-control" id="change_password_repeat_password" placeholder="Введіть новий пароль повторно" required>
                                    <div class="input-group-append">
                                        <div onclick="passwordToggle(document.getElementById('change_password_repeat_password_img'), document.getElementById('change_password_repeat_password'))" class="input-group-text" style="cursor: pointer;">
                                            <img id="change_password_repeat_password_img" height="20" src="/icons/eye-fill.svg">
                                        </div>
                                    </div>
                                </div>
                                <div id="change_password_repeat_password_feedback" class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрити</button>
                            <button type="submit" class="btn btn-primary">Підтвердити</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal" tabindex="-1" role="dialog" id="deleteAccountModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">УВАГА! Небезпечна дія!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Ви впевнені що хочете видалити аккаунт?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="width:75px">Ні</button>
                        <button id="deleteAccountButton" type="button" class="btn btn-danger" data-dismiss="modal" data-toggle="modal" data-target="#deleteConfirmationModal">Так, я хочу видалити аккаунт</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteConfirmationModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form id="deleteAccountForm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteConfirmationModalLabel">Видалення аккаунту</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!--Grid row-->
                            <input name="delete_account_verification_token" id="delete_account_verification_token" type="hidden" value=<?= $verification_token ?>>
                            <div class="form-group">
                                <label class="control-label" for="delete_account_password">Пароль</label>
                                <div class="input-group" id="delete_account_password_group">
                                    <input type="password" class="form-control" id="delete_account_password" placeholder="Введіть пароль" required>
                                    <div class="input-group-append">
                                        <div onclick="passwordToggle(document.getElementById('delete_account_password_img'), document.getElementById('delete_account_password'))" class="input-group-text" style="cursor: pointer;">
                                            <img id="delete_account_password_img" height="20" src="/icons/eye-fill.svg">
                                        </div>
                                    </div>
                                </div>
                                <div id="delete_account_password_feedback" class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрити</button>
                            <button type="submit" class="btn btn-danger">Видалити аккаунт</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--Main Navigation-->
        <!--Main layout-->
        <main class="mt-5 mb-3">

            <!-- style="background-color: #eee;" -->
            <div class="container">
                <!--Grid row-->

                <form id="changeUserDataForm" method="post">
                    <input id="change_user_data_verification_token" type="hidden" value=<?= $verification_token ?>>
                    <div class="form-group row">
                        <label for="change_user_data_email" class="col-lg-2 col-md-3 col-sm-4 col-form-label">Електронна адреса</label>
                        <div class="col-lg-10 col-md-9 col-sm-8 my-vertical-centered">
                            <input type="text" readonly="true" class="form-control-plaintext my-padding" id="change_user_data_email" value=<?= $email ?>>
                        </div>
                    </div>
                    <div class="form-group row" id="">
                        <label for="change_user_data_last_name" class="col-lg-2 col-md-3 col-sm-4 col-form-label">Прізвище</label>
                        <div class="col-lg-3 col-md-4 col-sm-5 col-10 my-vertical-centered">
                            <input type="text" readonly="true" class="form-control-plaintext my-padding" id="change_user_data_last_name" value=<?= $last_name ?> required>
                        </div>
                        <div onclick="activateInput(getElementById('change_user_data_last_name'))" id="change_user_data_last_name_button" class="col-auto my-vertical-centered" data-toggle="tooltip" data-placement="right" title="Змінити прізвище">
                            <svg class="my-svg-button" width="24px" height="24px" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                            </svg>
                        </div>
                        <div id="change_user_data_last_name_feedback" class="invalid-feedback"></div>
                    </div>
                    <div class="form-group row">
                        <label for="change_user_data_first_name" class="col-lg-2 col-md-3 col-sm-4 col-form-label">Ім'я</label>
                        <div class="col-lg-3 col-md-4 col-sm-5 col-10 my-vertical-centered">
                            <input type="text" readonly="true" class="form-control-plaintext my-padding" id="change_user_data_first_name" value=<?= $first_name ?> required>
                        </div>
                        <div onclick="activateInput(getElementById('change_user_data_first_name'))" id="change_user_data_first_name_button" class="col-auto my-vertical-centered" data-toggle="tooltip" data-placement="right" title="Змінити ім'я">
                            <svg class="my-svg-button" width="24px" height="24px" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                            </svg>
                        </div>
                        <div id="change_user_data_first_name_feedback" class="invalid-feedback"></div>
                    </div>
                    <div class="form-group row">
                        <label for="change_user_data_middle_name" class="col-lg-2 col-md-3 col-sm-4 col-form-label">Ім'я по-батькові</label>
                        <div class="col-lg-3 col-md-4 col-sm-5 col-10 my-vertical-centered">
                            <input type="text" readonly="true" class="form-control-plaintext my-padding" id="change_user_data_middle_name" value=<?= $middle_name ?> required>
                        </div>
                        <div onclick="activateInput(getElementById('change_user_data_middle_name'))" id="change_user_data_middle_name_button" class="col-auto my-vertical-centered" data-toggle="tooltip" data-placement="right" title="Змінити ім'я по-батькові">
                            <svg class="my-svg-button" width="24px" height="24px" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                            </svg>
                        </div>
                        <div id="change_user_data_middle_name_feedback" class="invalid-feedback"></div>
                    </div>
                    <div class="form-group row">
                        <label for="change_user_data_phone" class="col-lg-2 col-md-3 col-sm-4 col-form-label">Номер телефону</label>
                        <div class="col-lg-3 col-md-4 col-sm-5 col-10 my-vertical-centered">
                            <input type="text" readonly="true" class="form-control-plaintext my-padding" id="change_user_data_phone" value=<?= $phone ?> required>
                        </div>
                        <div onclick="activateInput(getElementById('change_user_data_phone'))" id="change_user_data_phone_button" class="col-auto my-vertical-centered" data-toggle="tooltip" data-placement="right" title="Змінити номер телефону">
                            <svg class="my-svg-button" width="24px" height="24px" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                            </svg>
                        </div>
                        <div id="change_user_data_phone_feedback" class="invalid-feedback"></div>
                    </div>
                    <button id="changeUserDataDismissButton" hidden="true" type="button" class="btn btn-secondary my-1 mr-1">Відмінити</button>
                    <button id="changeUserDataSubmitButton" hidden="true" type="submit" class="btn btn-dark m-1">Змінити особисті дані</button>
                </form>

                <hr>
                <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#changePasswordModal">Змінити пароль</button>
                <hr>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteAccountModal">Видалити аккаунт</button>
                <hr>
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <div class="row align-items-center">
                            <div class="col-lg-4 col-md-6 col-sm-7">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <button id="order_button" onclick="chevronToggle(document.getElementById('order_img'), document.getElementById('order_button'))" class="btn btn-link chevron-down p-0" style="font-weight: 500; font-size: 18px;" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            <img id="order_img" height="18" src="/icons/chevron-down.svg">
                                            №000001
                                        </button>
                                    </div>
                                    <div class="col-6 px-0">
                                        <h6 class="mb-0">
                                            21/06/2020 20:02
                                        </h6>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-5 col-md-6 col-sm-5">
                                <div class="row">
                                    <a href="product.php?id=1" class="mx-2">
                                        <img src="/Store_photos/ForHands0.15L.png" class="m-auto" style="display: block; max-height: 60px; max-width: 50px;" alt="">
                                    </a>
                                    <a href="product.php?id=4" class="mx-2">
                                        <img src="/Store_photos/ForHands0.1L.png" class="m-auto" style="display: block; max-height: 60px; max-width: 50px;" alt="">
                                    </a>
                                    <a href="product.php?id=8" class="mx-2">
                                        <img src="/Store_photos/ForHands10L.png" class="m-auto" style="display: block; max-height: 60px; max-width: 50px;" alt="">
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-12 mt-3 mt-lg-0 border-lg-left border-lg-top">
                                <div class="row align-items-center">
                                    <div class="col-lg-7 col-md-10 col-sm-9 col-7">
                                        <div class="text-body float-sm-right">Обробка оператором</div>
                                    </div>
                                    <div class="col-lg-5 col-md-2 col-sm-3 col-5 p-0">
                                        <button id="status_button" onclick="chevronToggle(document.getElementById('status_img'), document.getElementById('status_button'))" class="btn btn-link pl-0 chevron-down float-sm-right" style="font-weight: 500;" type="button" data-toggle="popover" title="Popover title" data-html="true" data-placement="bottom" data-content="<div class='row'>
                                                <div class='col-12'>
                                                    <div class='h6'>26/07/2020</div>
                                                    <hr class='solid mt-0'>
                                                </div>
                                                <div class='divider'></div>
                                                <div class='col-3'>
                                                    <div class='h6 font-weight-normal'>20:02</div>
                                                </div>
                                                <div class='col-9'>
                                                    <div class='h6 text-danger font-weight-normal'>Відмінено</div>
                                                </div>
                                                <div class='col-3'>
                                                    <div class='h6 font-weight-normal'>20:02</div>
                                                </div>
                                                <div class='col-9'>
                                                    <div class='h6 text-success font-weight-normal'>Виконано</div>
                                                </div>
                                                <div class='col-12'>
                                                    <div class='h6'>25/07/2020</div>
                                                    <hr class='solid mt-0'>
                                                </div>
                                                <hr/>
                                                <div class='col-3'>
                                                    <div class='h6 font-weight-normal'>20:02</div>
                                                </div>                                                
                                                <div class='col-9'>
                                                    <div class='h6 text-info font-weight-normal'>Очікує в пункті видачі</div>
                                                </div>
                                                <div class='col-3'>
                                                    <div class='h6 font-weight-normal'>20:02</div>
                                                </div>
                                                <div class='col-9'>
                                                    <div class='h6 text-primary font-weight-normal'>Оплачено</div>
                                                </div>
                                                <div class='col-3'>
                                                    <div class='h6 font-weight-normal'>20:02</div>
                                                </div>
                                                <div class='col-9'>
                                                    <div class='h6 text-primary font-weight-normal'>Прийнято</div>
                                                </div>
                                                <div class='col-3'>
                                                    <div class='h6 font-weight-normal'>20:02</div>
                                                </div>
                                                <div class='col-9'>
                                                    <div class='h6 text-body font-weight-normal'>Обробка оператором</div>
                                                </div>
                                            </div>">
                                            Історія
                                            <img id="status_img" height="16" src="/icons/chevron-down.svg">
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne">
                        <div class="card-body">
                            <div class="card mb-lg-3 mb-3">
                                <div class="card-body row">
                                    <div class="col-lg-1 pr-0">
                                        <a href="product.php?id=7">
                                            <img src="/Store_photos/ForHands5L.png" class="m-auto" style="display: block; max-height: 60px; max-width: 50px;" alt="">
                                        </a>
                                    </div>
                                    <div class="col-lg-11">
                                        <div class="container pr-0 pl-1" style="min-height:60px">
                                            <div class="row" style="min-height:25%">
                                                <div class="col-lg-12">
                                                    <a style="font-size:20px;" href="product.php?id=7">ГУАНПОЛІСЕПТ Антисептик для рук | 5 л</a>
                                                </div>
                                            </div>
                                            <div class="row align-items-center" style="min-height:40px;">
                                                <div class="col-lg-8">
                                                    <div class="h5 mb-0" style="float:left; padding: 8 14 8 0;">Ціна:</div>
                                                    <div class="rounded-xl h5 mb-0" style="background: #D3D3D3; padding: 8 14 8 14; float:left;">480 ₴</div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="h5 mb-0" style="float:left; padding: 8 14 8 0;">3 шт.</div>
                                                </div>
                                                <div class="col-lg-2 pl-0">
                                                    <div class="rounded-xl h5 mb-0 float-lg-right float-left" style="background: #D3D3D3; padding: 8 14 8 14;">1440 ₴</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-sm-3 mb-3">
                                <div class="card-body row">
                                    <div class="col-sm-1 pr-0">
                                        <a href="product.php?id=13">
                                            <img src="/Store_photos/ForPools1L.png" class="m-auto" style="display: block; max-height: 60px; max-width: 50px;" alt="">
                                        </a>
                                    </div>
                                    <div class="col-sm-11">
                                        <div class="container pr-0 pl-1" style="min-height:60px">
                                            <div class="row" style="min-height:25%">
                                                <div class="col-sm-12">
                                                    <a style="font-size:20px;" href="product.php?id=13">Дезінфекційний засіб "Гуанполісепт" для ран опіків (Гель-пов`язка) 9х10 | 1 шт.</a>
                                                </div>
                                            </div>
                                            <div class="row align-items-center" style="min-height: 40px;">
                                                <div class="col-lg-8 col-md-6 col-sm-6">
                                                    <div class="h5 mb-0" style="float:left; padding: 8 14 8 0;">Ціна:</div>
                                                    <div class="rounded-xl h5 mb-0" style="background: #D3D3D3; padding: 8 14 8 14; float:left;">5555 ₴</div>
                                                </div>
                                                <div class="col-lg-2 col-md-3 col-sm-2">
                                                    <div class="h5 mb-0" style="float:left; padding: 8 14 8 0;">100 шт.</div>
                                                </div>
                                                <div class="col-lg-2 pl-0 col-md-3 col-sm-4">
                                                    <div class="rounded-xl h5 mb-0 float-lg-right float-left" style="background: #D3D3D3; padding: 8 14 8 14;">555500 ₴</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

        </main>
        <!--Main layout-->

        <!-- Footer -->
        <footer class="page-footer font-small bottom bg-dark accent-4 mt-4">

            <!-- Copyright -->
            <div class="footer-copyright text-center py-3">© 2015 - 2020 ТОВАРИСТВО З ОБМЕЖЕНОЮ ВІДПОВІДАЛЬНІСТЮ — ТОРГОВО-ВИРОБНИЧИЙ ДІМ "РІВС"
            </div>

        </footer>
        <!-- Footer -->

        <!-- SCRIPTS -->
        <!-- JQuery -->
        <? include("../myScripts.php"); ?>

        <script type="text/javascript">
            var elem = document.getElementById("user");
            elem.classList.add('active');
        </script>

        <!-- Script for submitting form -->
        <script type="text/javascript">
            $("[data-toggle=tooltip]").tooltip();
            $('[data-toggle="popover"]').popover();

            function activateInput(input) {
                document.getElementById("changeUserDataDismissButton").hidden = false;
                document.getElementById("changeUserDataSubmitButton").hidden = false;
                input.classList.remove('form-control-plaintext');
                input.classList.add('form-control');
                input.readOnly = false;
            };

            function deactivateInput(input, value) {
                input.value = value;
                input.classList.remove('form-control');
                input.classList.add('form-control-plaintext');
                input.readOnly = true;
            };

            $(document).ready(function() {
                $("#changeUserDataDismissButton").click(
                    function(e) {
                        document.getElementById("changeUserDataDismissButton").hidden = true;
                        document.getElementById("changeUserDataSubmitButton").hidden = true;
                        deactivateInput(document.getElementById("change_user_data_last_name"), "<?= $last_name ?>");
                        deactivateInput(document.getElementById("change_user_data_first_name"), "<?= $first_name ?>");
                        deactivateInput(document.getElementById("change_user_data_middle_name"), "<?= $middle_name ?>");
                        deactivateInput(document.getElementById("change_user_data_phone"), "<?= $phone ?>");
                    }
                );
            });

            inputRemoveValidationStatus(document.getElementById("delete_account_password"));
            inputRemoveValidationStatus(document.getElementById("change_password_password"));
            inputRemoveValidationStatus(document.getElementById("change_password_new_password"));
            inputRemoveValidationStatus(document.getElementById("change_password_repeat_password"));

            var deleteAccountForm = $('#deleteAccountForm');
            deleteAccountForm.submit(function(e) {

                // give data from form
                formData = {
                    'verification_token': document.getElementById("delete_account_verification_token").value,
                    'password': document.getElementById("delete_account_password").value
                };
                e.preventDefault();

                // ajax request
                $.ajax({
                    type: "POST",
                    url: "functions/deleteAccount.php",
                    data: formData,
                    success: function(response) {
                        if (response != null) {

                            // parse response from server
                            var jsonData = JSON.parse(response);

                            // if success code is true login and reload
                            if (jsonData.success == true) {
                                $.redirect('index.php');

                                // else give html fields and show error messages
                            } else {
                                changeInputGroupStatus(document.getElementById("delete_account_password_group"),
                                    document.getElementById("delete_account_password"),
                                    document.getElementById("delete_account_password_feedback"), jsonData, "password")
                            }
                        }
                    },
                    error: function(data) {
                        console.log('An error occurred.');
                        console.log(data);
                    },
                });
            });

            var changePasswordForm = $('#changePasswordForm');
            changePasswordForm.submit(function(e) {

                // give data from form
                formData = {
                    'verification_token': document.getElementById("change_password_verification_token").value,
                    'password': document.getElementById("change_password_password").value,
                    'new_password': document.getElementById("change_password_new_password").value,
                    'repeat_password': document.getElementById("change_password_repeat_password").value
                };
                e.preventDefault();

                // ajax request
                $.ajax({
                    type: "POST",
                    url: "functions/changePassword.php",
                    data: formData,
                    success: function(response) {
                        if (response != null) {

                            // parse response from server
                            var jsonData = JSON.parse(response);

                            // if success code is true login and reload
                            if (jsonData.success == true) {
                                location.reload();

                                // else give html fields and show error messages
                            } else {
                                changeInputGroupStatus(document.getElementById("change_password_password_group"),
                                    document.getElementById("change_password_password"),
                                    document.getElementById("change_password_password_feedback"), jsonData, "password")
                                changeInputGroupStatusArray(document.getElementById("change_password_new_password_group"),
                                    document.getElementById("change_password_new_password"),
                                    document.getElementById("change_password_new_password_feedback"), jsonData, "new_password")
                                changeInputGroupStatus(document.getElementById("change_password_repeat_password_group"),
                                    document.getElementById("change_password_repeat_password"),
                                    document.getElementById("change_password_repeat_password_feedback"), jsonData, "repeat_password")
                            }
                        }
                    },
                    error: function(data) {
                        console.log('An error occurred.');
                        console.log(data);
                    },
                });
            });

            inputGroupRemoveValidationStatus(document.getElementById("change_user_data_last_name"), document.getElementById("change_user_data_last_name_button"));
            inputGroupRemoveValidationStatus(document.getElementById("change_user_data_first_name"), document.getElementById("change_user_data_first_name_button"));
            inputGroupRemoveValidationStatus(document.getElementById("change_user_data_middle_name"), document.getElementById("change_user_data_middle_name_button"));
            inputGroupRemoveValidationStatus(document.getElementById("change_user_data_phone"), document.getElementById("change_user_data_phone_button"));

            var changeUserDataForm = $('#changeUserDataForm');
            changeUserDataForm.submit(function(e) {
                // give data from form
                formData = {
                    'verification_token': document.getElementById("change_user_data_verification_token").value,
                };
                if (document.getElementById("change_user_data_last_name").readOnly == false)
                    formData['last_name'] = document.getElementById("change_user_data_last_name").value;
                if (document.getElementById("change_user_data_first_name").readOnly == false)
                    formData['first_name'] = document.getElementById("change_user_data_first_name").value;
                if (document.getElementById("change_user_data_middle_name").readOnly == false)
                    formData['middle_name'] = document.getElementById("change_user_data_middle_name").value;
                if (document.getElementById("change_user_data_phone").readOnly == false)
                    formData['phone'] = document.getElementById("change_user_data_phone").value;


                e.preventDefault();

                // ajax request
                $.ajax({
                    type: "POST",
                    url: "functions/changeUserData.php",
                    data: formData,
                    success: function(response) {
                        if (response != null) {

                            // parse response from server
                            var jsonData = JSON.parse(response);

                            // if success code is true login and reload
                            if (jsonData.success == true) {
                                location.reload();

                                // else give html fields and show error messages
                            } else {
                                changeInputGroupStatus(document.getElementById("change_user_data_phone_button"),
                                    document.getElementById("change_user_data_phone"),
                                    document.getElementById("change_user_data_phone_feedback"), jsonData, "phone");
                                changeInputGroupStatus(document.getElementById("change_user_data_first_name_button"),
                                    document.getElementById("change_user_data_first_name"),
                                    document.getElementById("change_user_data_first_name_feedback"), jsonData, "first_name");
                                changeInputGroupStatus(document.getElementById("change_user_data_last_name_button"),
                                    document.getElementById("change_user_data_last_name"),
                                    document.getElementById("change_user_data_last_name_feedback"), jsonData, "last_name");
                                changeInputGroupStatus(document.getElementById("change_user_data_middle_name_button"),
                                    document.getElementById("change_user_data_middle_name"),
                                    document.getElementById("change_user_data_middle_name_feedback"), jsonData, "middle_name");
                            }
                        }
                    },
                    error: function(data) {
                        console.log('An error occurred.');
                        console.log(data);
                    },
                });
            });
        </script>
    </body>

    </html>
<?php
} else {
    include("../scripts.php");
    echo "<script>$.redirect('index.php');</script>";
    exit();
}
?>