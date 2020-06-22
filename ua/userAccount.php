<?php
require_once("../LDLRIVS.php");

my_session_start();
// give security and verification tokens from session, post and cookies
$verification_token = $_POST['user_verification_token'];
$verification_token1 = $_SESSION['verification_token'];
$security_token = $_SESSION["security_token"];
$security_token1 = $_COOKIE["security_token"];

// if some token empty go out
if ($verification_token == null || $verification_token1 == null || $security_token == null || $security_token1 == null) {
    exit();
}

if (hash_equals($verification_token, $verification_token1)) {
    if (hash_equals($security_token, $security_token1)) {
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
            <? include("header.php"); ?>
            <div class="modal fade" id="changePasswordModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form id="changePasswordForm" name="changePasswordForm" action="changePassword.php" method="post">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title" id="changePasswordModalLabel">Скидання паролю</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input name="change_password_verification_token" id="change_password_verification_token" type="hidden" value=<?= $verification_token ?>>
                                <input name="change_password_email" id="change_password_email" type="hidden">
                                <div class="form-group">
                                    <label class="control-label" for="change_password_password">Поточний пароль</label>
                                    <div class="input-group" id="change_password_password_group">
                                        <input type="password" class="form-control" id="change_password_password" name="change_password_password" placeholder="Введіть поточний пароль" required>
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
                                        <input type="password" class="form-control" id="change_password_new_password" name="change_password_new_password" placeholder="Введіть новий пароль" required>
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
                                        <input type="password" class="form-control" id="change_password_repeat_password" name="change_password_repeat_password" placeholder="Введіть новий пароль повторно" required>
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

                    <form>
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=<?= $_SESSION["email"] ?>>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <button style="margin:0; padding:0;" class="btn btn-link" data-toggle="modal" data-target="#changePasswordModal">Змінити пароль</button>

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
        </body>

        </html>
<?php
    } else exit();
} else exit();

?>