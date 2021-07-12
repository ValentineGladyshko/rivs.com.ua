<?php
require_once("../LDLRIVS.php");
require_once("functions/mainFunctions.php");

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
    $mysqli = mysqli_connect("localhost", "chba7f54c7_LDLRIVS", "8e5cktmvx6", "chba7f54c7_LDLRIVS");
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

        $key = base64_decode(file_get_contents('../../../key.txt'));

        $new_key = $key . md5($email, true);

        $first_name = openssl_decrypt($first_name_encrypted, $cipher, $new_key, $options = 0, base64_decode($first_name_iv), base64_decode($first_name_tag));
        $middle_name = openssl_decrypt($middle_name_encrypted, $cipher, $new_key, $options = 0, base64_decode($middle_name_iv), base64_decode($middle_name_tag));
        $last_name = openssl_decrypt($last_name_encrypted, $cipher, $new_key, $options = 0, base64_decode($last_name_iv), base64_decode($last_name_tag));
        $phone = openssl_decrypt($phone_encrypted, $cipher, $new_key, $options = 0, base64_decode($phone_iv), base64_decode($phone_tag));

        $orders = array();
        if ($stmt = $mysqli->prepare("SELECT `orders_in_process`.`OrderId`, `orders_items`.`PriceListID`, `Count`, `orders_items`.`Price`, `ProductName`, `Image`, `Date` 
            FROM `orders_in_process` JOIN `orders_items` ON `orders_in_process`.`OrderId` = `orders_items`.`OrderId` 
            JOIN `pricelistru` ON `orders_items`.`PriceListID` = `pricelistru`.`PriceListID` WHERE Email = ? ORDER BY `Date` DESC")) {
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
                $date = new DateTime($date);
                $order->date = $date->format('d/m/Y H:i');
                $order->totalPrice = 0;
                if (array_key_exists($orderId, $orders)) {
                    $order = $orders[$orderId];
                }

                $item = new stdClass();
                $item->priceListID = $priceListID;
                $item->count = $count;
                $item->price = $price;
                $item->productName = $productName;
                $item->image = $image;
                $item->totalPrice = $price * $count;

                $order->totalPrice += $item->totalPrice;
                $order->items[] = $item;

                $orders[$orderId] = $order;
            }
            $stmt->close();
        }

        if ($stmt = $mysqli->prepare("SELECT `orders_statuses`.`StatusId`, `statusesru`.`StatusName`, `orders_statuses`.`Date` 
            FROM `orders_in_process` JOIN `orders_statuses` ON `orders_in_process`.`OrderId` = `orders_statuses`.`OrderId` 
            JOIN `statusesru` ON `orders_statuses`.`StatusId` = `statusesru`.`StatusId` WHERE `orders_in_process`.`OrderId` = ? ORDER BY `orders_statuses`.`Date` DESC")) {
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
                    $date = new DateTime($date);
                    $item->time = $date->format('H:i');

                    $orders[$key]->statuses[$date->format('d/m/Y')][] = $item;
                }
                foreach ($orders[$key]->statuses as $statusDate => $statusValue) {
                    $orders[$key]->status = $statusValue[0];
                    break;
                }
            }
            $stmt->close();
        }
        $order_html = '';
        foreach ($orders as $orderKey => $order) {

            $order_header = '';
            $order_items = '';
            $order_statuses = '';

            foreach ($order->items as $item) {
                $order_header .= sprintf(
                    '<a href="product.php?id=%1$s" class="mx-2">
                            <img src="/%2$s" class="m-auto" style="display: block; max-height: 60px; max-width: 50px;" alt="">
                         </a>',
                    $item->priceListID,
                    $item->image
                );
                $order_items .= sprintf(
                    '<div class="card mb-sm-3 mb-3">
                            <div class="card-body row">
                                <div class="col-lg-1 col-sm-2 px-0">
                                    <a href="product.php?id=%1$s">
                                        <img src="/%2$s" class="m-auto" style="display: block; max-height: 60px; max-width: 50px;" alt="">
                                    </a>
                                </div>
                                <div class="col-lg-11 col-sm-10 pl-sm-0 pl-lg-2">
                                    <div class="container px-0" style="min-height:60px">
                                        <div class="row product-name-sm">
                                            <div class="col-sm-12">
                                                <a style="font-size:20px;" href="product.php?id=%1$s">%3$s</a>
                                            </div>
                                        </div>
                                        <div class="row align-items-center order-sm mt-sm-2 mt-xl-0" style="min-height: 40px;">
                                            <div class="pr-0 col-xl-8 col-lg-7 col-md-6 col-sm-5">
                                                <div class="h5 mb-0 py-2 pl-0 pr-3 float-left">Цена:</div>
                                                <div class="rounded-xl h5 mb-0 py-2 float-left">%4$s ₴</div>
                                            </div>
                                            <div class="px-sm-0 col-lg-2 col-sm-2">
                                                <div class="h5 mb-0 float-left py-2 pl-1 pr-0">%5$s шт.</div>
                                            </div>
                                            <div class="pl-sm-0 col-xl-2 col-lg-3 col-md-4 col-sm-5">
                                                <div class="rounded-xl h5 mb-0 float-sm-right float-left py-2">%6$s ₴</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>',
                    $item->priceListID,
                    $item->image,
                    $item->productName,
                    penny_price_to_normal_price($item->price),
                    $item->count,
                    penny_price_to_normal_price($item->totalPrice)
                );
            };

            foreach ($order->statuses as $statusDate => $statusValue) {
                $order_statuses .= sprintf(
                    '<div class=%2$scol-12%2$s>
                            <hr class=%2$ssolid mt-2 mb-2%2$s>
                            <div class=%2$sh6%2$s>%1$s</div>
                            <hr class=%2$ssolid mt-0 mb-2%2$s>
                        </div>',
                    $statusDate,
                    "'"
                );

                foreach ($statusValue as $status) {
                    $order_statuses .= sprintf(
                        '<div class=%4$scol-3%4$s>
                                <div class=%4$sh6 font-weight-normal%4$s>%1$s</div>
                            </div>
                            <div class=%4$scol-9%4$s>
                                <div class=%4$sh6 %2$s font-weight-normal%4$s>%3$s</div>
                            </div>',
                        $status->time,
                        text_status_color($status->statusId),
                        $status->statusName,
                        "'"
                    );
                }
            };
            $order_html .= sprintf(
                '<div class="card mt-4">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-lg-4 col-md-6 col-sm-7">
                                    <div class="row align-items-center">
                                        <div class="col-6">
                                            <button id="order_button_%1$s" onclick="chevronToggle(document.getElementById(`order_img_%1$s`), 
                                                document.getElementById(`order_button_%1$s`))" class="btn btn-link chevron-down p-0" 
                                                style="font-weight: 500; font-size: 18px;" type="button" data-toggle="collapse" 
                                                data-target="#order_collapse_%1$s" aria-expanded="true" aria-controls="order_collapse_%1$s">
                                                <img id="order_img_%1$s" height="18" src="/icons/chevron-down.svg">
                                                №%1$s
                                            </button>
                                        </div>
                                        <div class="col-6 px-0">
                                            <h6 class="mb-0">
                                                %2$s
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-6 col-sm-5 border-lg-right">
                                    <div class="row align-items-center">
                                        <div class="col-lg-9 col-md-8 col-sm-6">
                                            <div class="row">
                                                %3$s
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-4 col-sm-6 pl-0 pr-2">
                                            <div class="float-right h6 mb-0">
                                                %4$s ₴
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-12 mt-3 mt-lg-0 border-lg-top">
                                    <div class="row align-items-center">
                                        <div class="col-lg-7 col-md-10 col-sm-9 col-7">
                                            <div class="%5$s float-sm-right float-lg-left">%6$s</div>
                                        </div>
                                        <div class="col-lg-5 col-md-2 col-sm-3 col-5 p-0">
                                            <button id="status_button_%1$s" onclick="chevronToggle(document.getElementById(`status_img_%1$s`), 
                                                document.getElementById(`status_button_%1$s`))" class="btn btn-link pl-0 chevron-down float-sm-right" 
                                                style="font-weight: 500;" type="button" data-toggle="popover" title="История заказа" data-html="true" 
                                                data-placement="bottom" data-content="<div class=%9$srow%9$s>%7$s</div>">
                                                История
                                                <img id="status_img_%1$s" height="16" src="/icons/chevron-down.svg">
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="order_collapse_%1$s" class="collapse">
                            <div class="card-body">
                                %8$s
                                <div class="row">
                                    <div class="col-md-12 pr-3 py-2 pl-2">
                                        <div class="rounded-xl h5 mb-0 px-3 py-2 float-right bg-grey-alt">%4$s ₴</div>
                                        <div class="h5 mb-0" style=" padding: 8 14 8 14; float:right;">Итого:</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>',
                sprintf("%06d", $order->orderId),
                $order->date,
                $order_header,
                penny_price_to_normal_price($order->totalPrice),
                text_status_color($order->status->statusId),
                $order->status->statusName,
                $order_statuses,
                $order_items,
                "'"
            );
        }
    }
?>
    <!--DOCTYPE html-->
    <html lang="en">

    <head>

        <link rel="shortcut icon" href="/Images/webicon.png" type="image/x-icon">
        <title>
            ООО ТПП "РИВС" | Личный кабинет
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
                            <h5 class="modal-title" id="changePasswordModalLabel">Изменение пароля</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input id="change_password_verification_token" type="hidden" value=<?= $verification_token ?>>
                            <div class="form-group">
                                <label class="control-label" for="change_password_password">Текущий пароль</label>
                                <div class="input-group" id="change_password_password_group">
                                    <input type="password" class="form-control" id="change_password_password" placeholder="Введите текущий пароль" required>
                                    <div class="input-group-append">
                                        <div onclick="passwordToggle(document.getElementById('change_password_password_img'), document.getElementById('change_password_password'))" class="input-group-text" style="cursor: pointer;">
                                            <img id="change_password_password_img" height="20" src="/icons/eye-fill.svg">
                                        </div>
                                    </div>
                                </div>
                                <div id="change_password_password_feedback" class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="change_password_new_password">Новый пароль</label>
                                <div class="input-group" id="change_password_new_password_group">
                                    <input type="password" class="form-control" id="change_password_new_password" placeholder="Введите новый пароль" required>
                                    <div class="input-group-append">
                                        <div onclick="passwordToggle(document.getElementById('change_password_new_password_img'), document.getElementById('change_password_new_password'))" class="input-group-text" style="cursor: pointer;">
                                            <img id="change_password_new_password_img" height="20" src="/icons/eye-fill.svg">
                                        </div>
                                    </div>
                                </div>
                                <div id="change_password_new_password_feedback" class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="change_password_repeat_password">Повторите ввод нового пароля</label>
                                <div class="input-group" id="change_password_repeat_password_group">
                                    <input type="password" class="form-control" id="change_password_repeat_password" placeholder="Введите новый пароль повторно" required>
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
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                            <button id="changePasswordButton" type="submit" class="btn btn-dark">
                                <span id="changePasswordButtonSpinner" style="width: 20px; height: 20px;"></span>
                                Подтвердить
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal" tabindex="-1" role="dialog" id="deleteAccountModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">ВНИМАНИЕ! Опасное действие!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Вы уверены, что хотите удалить аккаунт?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="width:75px">Нет</button>
                        <button id="deleteAccountButton" type="button" class="btn btn-danger" data-dismiss="modal" data-toggle="modal" data-target="#deleteConfirmationModal">
                            Да, я хочу удалить аккаунт
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteConfirmationModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form id="deleteAccountForm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteConfirmationModalLabel">Удаление аккаунта</h5>
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
                                    <input type="password" class="form-control" id="delete_account_password" placeholder="Введите пароль" required>
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
                            <button id="deleteConfirmationButton" type="submit" class="btn btn-danger">
                                <span id="deleteConfirmationButtonSpinner" style="width: 20px; height: 20px;"></span>
                                Видалити аккаунт
                            </button>
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
                        <label for="change_user_data_email" class="col-lg-2 col-md-3 col-sm-4 col-form-label">Электронный адрес</label>
                        <div class="col-lg-10 col-md-9 col-sm-8 my-vertical-centered">
                            <input type="text" readonly="true" class="form-control-plaintext my-padding" id="change_user_data_email" value=<?= $email ?>>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="change_user_data_last_name" class="col-lg-2 col-md-3 col-sm-4 col-form-label">Фамилия</label>
                        <div class="col-lg-3 col-md-4 col-sm-5 col-10 my-vertical-centered">
                            <input type="text" readonly="true" class="form-control-plaintext my-padding" id="change_user_data_last_name" value=<?= $last_name ?> required>
                        </div>
                        <div onclick="activateInput(getElementById('change_user_data_last_name'))" id="change_user_data_last_name_button" class="col-auto my-vertical-centered" data-toggle="tooltip" data-placement="right" title="Изменить фамилию">
                            <svg class="my-svg-button" width="24px" height="24px" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                            </svg>
                        </div>
                        <div id="change_user_data_last_name_feedback" class="invalid-feedback"></div>
                    </div>
                    <div class="form-group row">
                        <label for="change_user_data_first_name" class="col-lg-2 col-md-3 col-sm-4 col-form-label">Имя</label>
                        <div class="col-lg-3 col-md-4 col-sm-5 col-10 my-vertical-centered">
                            <input type="text" readonly="true" class="form-control-plaintext my-padding" id="change_user_data_first_name" value=<?= $first_name ?> required>
                        </div>
                        <div onclick="activateInput(getElementById('change_user_data_first_name'))" id="change_user_data_first_name_button" class="col-auto my-vertical-centered" data-toggle="tooltip" data-placement="right" title="Изменить имя">
                            <svg class="my-svg-button" width="24px" height="24px" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                            </svg>
                        </div>
                        <div id="change_user_data_first_name_feedback" class="invalid-feedback"></div>
                    </div>
                    <div class="form-group row">
                        <label for="change_user_data_middle_name" class="col-lg-2 col-md-3 col-sm-4 col-form-label">Имя отчество</label>
                        <div class="col-lg-3 col-md-4 col-sm-5 col-10 my-vertical-centered">
                            <input type="text" readonly="true" class="form-control-plaintext my-padding" id="change_user_data_middle_name" value=<?= $middle_name ?> required>
                        </div>
                        <div onclick="activateInput(getElementById('change_user_data_middle_name'))" id="change_user_data_middle_name_button" class="col-auto my-vertical-centered" data-toggle="tooltip" data-placement="right" title="Изменить имя отчество">
                            <svg class="my-svg-button" width="24px" height="24px" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                            </svg>
                        </div>
                        <div id="change_user_data_middle_name_feedback" class="invalid-feedback"></div>
                    </div>
                    <div class="form-group row">
                        <label for="change_user_data_phone" class="col-lg-2 col-md-3 col-sm-4 col-form-label">Номер телефона</label>
                        <div class="col-lg-3 col-md-4 col-sm-5 col-10 my-vertical-centered">
                            <input type="text" readonly="true" class="form-control-plaintext my-padding" id="change_user_data_phone" value=<?= $phone ?> required>
                        </div>
                        <div onclick="activateInput(getElementById('change_user_data_phone'))" id="change_user_data_phone_button" class="col-auto my-vertical-centered" data-toggle="tooltip" data-placement="right" title="Изменить номер телефона">
                            <svg class="my-svg-button" width="24px" height="24px" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                            </svg>
                        </div>
                        <div id="change_user_data_phone_feedback" class="invalid-feedback"></div>
                    </div>
                    <button id="changeUserDataDismissButton" hidden="true" type="button" class="btn btn-secondary my-1 mr-1">Отменить</button>
                    <button id="changeUserDataSubmitButton" hidden="true" type="submit" class="btn btn-dark m-1">
                        <span id="changeUserDataSubmitButtonSpinner" style="width: 20px; height: 20px;"></span>
                        Изменить личные данные
                    </button>
                </form>

                <hr>
                <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#changePasswordModal">Изменить пароль</button>
                <hr>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteAccountModal">Удалить аккаунт</button>
                <hr>
                <?php echo $order_html; ?>
        </main>
        <!--Main layout-->

        <!-- Footer -->
        <footer class="page-footer font-small bottom bg-dark accent-4 mt-4">

            <!-- Copyright -->
            <div class="footer-copyright text-center py-3">© 2015 ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ — ТОРГОВО-ПРОИЗВОДСТВЕННОЕ ПРЕДПРИЯТИЕ "РИВС"
            </div>

        </footer>
        <!-- Footer -->

        <!-- SCRIPTS -->
        <!-- JQuery -->
        <? include("myScripts.php"); ?>

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

                document.getElementById("deleteConfirmationButtonSpinner").classList.add("spinner-border");
                document.getElementById("deleteConfirmationButton").disabled = true;
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

                            document.getElementById("deleteConfirmationButtonSpinner").classList.remove("spinner-border");
                            document.getElementById("deleteConfirmationButton").disabled = false;
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

                document.getElementById("changePasswordButtonSpinner").classList.add("spinner-border");
                document.getElementById("changePasswordButton").disabled = true;
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

                            document.getElementById("changePasswordButtonSpinner").classList.remove("spinner-border");
                            document.getElementById("changePasswordButton").disabled = false;
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

                document.getElementById("changeUserDataSubmitButtonSpinner").classList.add("spinner-border");
                document.getElementById("changeUserDataSubmitButton").disabled = true;
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

                            document.getElementById("changeUserDataSubmitButtonSpinner").classList.remove("spinner-border");
                            document.getElementById("changeUserDataSubmitButton").disabled = false;
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