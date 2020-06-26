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
                <div class="row">
                    <div class="col-md-7 mb-4">
                        <div class="view overlay z-depth-1-half">
                            <div class="mask rgba-white-light">
                            </div>
                        </div>
                    </div>
                </div>

                <form id="changeUserDataForm" method="post">
                    <input id="change_user_data_verification_token" type="hidden" value=<?= $verification_token ?>>
                    <div class="form-group row">
                        <label for="change_user_data_email" class="col-sm-2 col-form-label">Електронна адреса</label>
                        <div class="col-sm-10 my-vertical-centered">
                            <input type="text" readonly="true" class="form-control-plaintext my-padding" id="change_user_data_email" value=<?= $email ?>>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="change_user_data_last_name" class="col-sm-2 col-form-label">Прізвище</label>
                        <div class="col-sm-3 my-vertical-centered">
                            <input type="text" readonly="true" class="form-control-plaintext my-padding" id="change_user_data_last_name" value=<?= $last_name ?> required>
                        </div>
                        <div onclick="activateInput(getElementById('change_user_data_last_name'))" class="col-auto my-vertical-centered" data-toggle="tooltip" data-placement="right" title="Змінити прізвище">
                            <svg class="my-svg-button" width="24px" height="24px" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                            </svg>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="change_user_data_first_name" class="col-sm-2 col-form-label">Ім'я</label>
                        <div class="col-sm-3 my-vertical-centered">
                            <input type="text" readonly="true" class="form-control-plaintext my-padding" id="change_user_data_first_name" value=<?= $first_name ?> required>
                        </div>
                        <div onclick="activateInput(getElementById('change_user_data_first_name'))" class="col-auto my-vertical-centered" data-toggle="tooltip" data-placement="right" title="Змінити ім'я">
                            <svg class="my-svg-button" width="24px" height="24px" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                            </svg>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="change_user_data_middle_name" class="col-sm-2 col-form-label">Ім'я по-батькові</label>
                        <div class="col-sm-3 my-vertical-centered">
                            <input type="text" readonly="true" class="form-control-plaintext my-padding" id="change_user_data_middle_name" value=<?= $middle_name ?> required>
                        </div>
                        <div onclick="activateInput(getElementById('change_user_data_middle_name'))" class="col-auto my-vertical-centered" data-toggle="tooltip" data-placement="right" title="Змінити ім'я по-батькові">
                            <svg class="my-svg-button" width="24px" height="24px" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                            </svg>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="change_user_data_phone" class="col-sm-2 col-form-label">Номер телефону</label>
                        <div class="col-sm-3 my-vertical-centered">
                            <input type="text" readonly="true" class="form-control-plaintext my-padding" id="change_user_data_phone" value=<?= $phone ?> required>
                        </div>
                        <div onclick="activateInput(getElementById('change_user_data_phone'))" class="col-auto my-vertical-centered" data-toggle="tooltip" data-placement="right" title="Змінити номер телефону">
                            <svg class="my-svg-button" width="24px" height="24px" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                            </svg>
                        </div>
                    </div>
                    <button id="changeUserDataDismissButton" hidden="true" type="button" class="btn btn-outline-dark button-margin">Відмінити</button>
                    <button id="changeUserDataSubmitButton" hidden="true" type="submit" class="btn btn-outline-primary button-margin">Змінити особисті дані</button>
                </form>

                <hr>
                <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#changePasswordModal">Змінити пароль</button>
                <hr>
                <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#deleteAccountModal">Видалити аккаунт</button>

        </main>
        <!--Main layout-->

        <!-- Footer -->
        <footer class="page-footer font-small bottom cyan accent-4 mt-4">

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
            var ru_link = document.getElementById("ru_link");
            ru_link.href = "/ru/userAccount.php";
            var ua_link = document.getElementById("ua_link");
            ua_link.href = "/ua/userAccount.php";
        </script>

        <!-- Script for submitting form -->
        <script type="text/javascript">
            $("[data-toggle=tooltip]").tooltip();

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
                            } else {}
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