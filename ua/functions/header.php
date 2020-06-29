<?php
$is_authorized = false;
$security_token = $_SESSION["security_token"];
$security_token1 = $_COOKIE["security_token"];
if ($security_token == null || $security_token1 == null || !isset($_SESSION["email"])) {
    $is_authorized = false;
} else if (hash_equals($security_token, $security_token1) && isset($_SESSION["email"])) {
    $is_authorized = true;
}
?>

<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="/Images/logo.png" width="30" height="40" alt="logo">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapsedContent" aria-controls="navbarCollapsedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarCollapsedContent">
                <ul class="navbar-nav mr-auto">
                    <li id="main" class="nav-item">
                        <a class="rounded-xl nav-link" href="index.php">Головна</a>
                    </li>
                    <li id="contacts" class="nav-item">
                        <a class="rounded-xl nav-link" href="contacts.php">Контакти</a>
                    </li>
                    <li id="store" class="nav-item">
                        <a class="rounded-xl nav-link" href="store.php">Продукція</a>
                    </li>
                </ul>

                <ul class="navbar-nav navbar-right">

                    <li class="nav-item">
                        <!-- Button trigger modal -->
                        <a class="rounded-xl nav-link" data-toggle="modal" data-target="#mobileModal" style="padding: 7 8 7 8;">
                            <svg class="bi bi-telephone-fill d-inline" width="24px" height="24px" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M2.267.98a1.636 1.636 0 0 1 2.448.152l1.681 2.162c.309.396.418.913.296 1.4l-.513 2.053a.636.636 0 0 0 .167.604L8.65 9.654a.636.636 0 0 0 .604.167l2.052-.513a1.636 1.636 0 0 1 1.401.296l2.162 1.681c.777.604.849 1.753.153 2.448l-.97.97c-.693.693-1.73.998-2.697.658a17.47 17.47 0 0 1-6.571-4.144A17.47 17.47 0 0 1 .639 4.646c-.34-.967-.035-2.004.658-2.698l.97-.969z" />
                            </svg>
                            <div class="align-middle d-inline">
                                Телефони
                            </div>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a id="ruLink" class="rounded-xl nav-link" href="/">RU
                        </a>
                    </li>
                    <li class="nav-item active disabled">
                        <a id="uaLink" class="rounded-xl nav-link" href="/">UA
                        </a>
                    </li>
                    <li style="min-width:10px; min-height:5px">
                    </li>
                    <? if($is_authorized) { ?>
                    <li id="user" class="nav-item">
                        <form style="margin:0px" class="nav-item" id="userForm" action="userAccount.php" method="post">
                            <input name="user_verification_token" id="user_verification_token" type="hidden" value=<?= $verification_token ?>>
                        </form>
                        <a id="userButton" class="rounded-xl nav-link" style="padding: 7 8 7 8;">
                            <svg width="24px" height="24px" viewBox="0 0 16 16" class="bi bi-person-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                            </svg>
                            <div class="align-middle d-inline">
                                <?= $_SESSION["email"] ?>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <form style="margin:0px" class="nav-item" id="logoutForm">
                            <input id="logout_verification_token" type="hidden" value=<?= $verification_token ?>>
                            <a id="logoutButton" class="rounded nav-link">Вийти</a>
                        </form>
                    </li>
                    <? } else { ?>
                    <li class="nav-item"><a class="rounded-xl nav-link" data-toggle="modal" data-target="#registerModal">Реєстрація</a></li>
                    <li class="nav-item"><a class="rounded-xl nav-link" data-toggle="modal" data-target="#loginModal">Увійти</a></li>
                    <? } ?>
                    <li style="min-width:10px">
                    </li>
                    <? echo get_cart_button_html($_SESSION["email"], $is_authorized); ?>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Modal login -->
    <? echo get_cart_modal_html($_SESSION["email"], $is_authorized, $_SESSION["verification_token"]); ?>
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="loginForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="loginModalLabel">Вхід</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!--Grid row-->
                        <input id="login_verification_token" type="hidden" value=<?= $verification_token ?>>
                        <div class="form-group">
                            <label class="control-label" for="login_email">Електронна адреса</label>
                            <input type="email" class="form-control" id="login_email" placeholder="Введіть електронну адресу" required>
                            <div id="login_email_feedback" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="login_password">Пароль</label>
                            <div class="input-group" id="login_password_group">
                                <input type="password" class="form-control" id="login_password" placeholder="Введіть пароль" aria-describedby="login_password_addon" required>
                                <div class="input-group-append">
                                    <div onclick="passwordToggle(document.getElementById('login_password_img'), document.getElementById('login_password'))" class="input-group-text" style="cursor: pointer;">
                                        <img id="login_password_img" height="20" src="/icons/eye-fill.svg">
                                    </div>
                                </div>
                            </div>
                            <div id="login_password_feedback" class="invalid-feedback"></div>
                        </div>
                        <button style="margin:0; padding:0;" class="btn btn-link" data-dismiss="modal" data-toggle="modal" data-target="#rememberModal">Забули пароль?</button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрити</button>
                        <button type="submit" class="btn btn-dark">Підтвердити</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal register-->
    <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="registerForm">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="registerModalLabel">Реєстрація</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input id="register_verification_token" type="hidden" value=<?= $verification_token ?>>
                        <div class="form-group">
                            <label class="control-label" for="register_email">Електронна адреса</label>
                            <input type="email" class="form-control" id="register_email" placeholder="Введіть електронну адресу" required>
                            <div id="register_email_feedback" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="register_password">Пароль</label>
                            <div class="input-group" id="register_password_group">
                                <input type="password" class="form-control" id="register_password" placeholder="Введіть пароль" required>
                                <div class="input-group-append">
                                    <div onclick="passwordToggle(document.getElementById('register_password_img'), document.getElementById('register_password'))" class="input-group-text" style="cursor: pointer;">
                                        <img id="register_password_img" height="20" src="/icons/eye-fill.svg">
                                    </div>
                                </div>
                            </div>
                            <div id="register_password_feedback" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="register_repeat_password">Повторний пароль</label>
                            <div class="input-group" id="register_repeat_password_group">
                                <input type="password" class="form-control" id="register_repeat_password" placeholder="Введіть пароль повторно" required>
                                <div class="input-group-append">
                                    <div onclick="passwordToggle(document.getElementById('register_repeat_password_img'), document.getElementById('register_repeat_password'))" class="input-group-text" style="cursor: pointer;">
                                        <img id="register_repeat_password_img" height="20" src="/icons/eye-fill.svg">
                                    </div>
                                </div>
                            </div>
                            <div id="register_repeat_password_feedback" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрити</button>
                        <button type="submit" class="btn btn-dark">Підтвердити</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="registerConfirmationModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="registerConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form id="registerConfirmationForm">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="registerConfirmationModalLabel">Завершення реєстрації</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input id="register_confirmation_verification_token" type="hidden" value=<?= $verification_token ?>>
                        <input id="register_confirmation_email" type="hidden">
                        <input id="register_confirmation_password" type="hidden">
                        <div class="form-group">
                            <label class="control-label" for="register_confirmation_email_code">Код для підтвердження електронної адреси</label>
                            <input type="text" class="form-control" id="register_confirmation_email_code" placeholder="Введіть код" required>
                            <div id="register_confirmation_email_code_feedback" class="invalid-feedback"></div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-lg-4">
                                <label class="control-label" for="register_confirmation_last_name">Прізвище</label>
                                <input type="text" class="form-control" id="register_confirmation_last_name" placeholder="Введіть прізвище" required>
                                <div id="register_confirmation_last_name_feedback" class="invalid-feedback"></div>
                            </div>
                            <div class="form-group col-lg-4">
                                <label class="control-label" for="register_confirmation_first_name">Ім'я</label>
                                <input type="text" class="form-control" id="register_confirmation_first_name" placeholder="Введіть ім'я" required>
                                <div id="register_confirmation_first_name_feedback" class="invalid-feedback"></div>
                            </div>

                            <div class="form-group col-lg-4">
                                <label class="control-label" for="register_confirmation_middle_name">Ім'я по-батькові</label>
                                <input type="text" class="form-control" id="register_confirmation_middle_name" placeholder="Введіть ім'я по-батькові" required>
                                <div id="register_confirmation_middle_name_feedback" class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="register_confirmation_phone">Номер телефону</label>
                            <input type="tel" class="form-control" id="register_confirmation_phone" pattern="^([+]\d{3}[(]\d{2}[)]\d{3}[ -]\d{2}[ -]\d{2})|([+]\d{12})|([+]\d{3} \d{2} \d{3} \d{2} \d{2})$/m" value="+380" required>
                            <div id="register_confirmation_phone_feedback" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрити</button>
                        <button id="register_confirmation_send_code" hidden="true" class="btn btn-dark">Відправити код повторно</button>
                        <button type="submit" class="btn btn-dark">Підтвердити</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="rememberModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="rememberModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="rememberForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rememberModalLabel">Відновлення паролю</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!--Grid row-->
                        <input id="remember_verification_token" type="hidden" value=<?= $verification_token ?>>
                        <div class="form-group">
                            <label class="control-label" for="remember_email">Електронна адреса</label>
                            <input type="email" class="form-control" id="remember_email" placeholder="Введіть електронну адресу" required>
                            <div id="remember_email_feedback" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрити</button>
                        <button type="submit" class="btn btn-dark">Надіслати код</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="resetPasswordModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="resetPasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="resetPasswordForm">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="resetPasswordModalLabel">Скидання паролю</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input id="reset_password_verification_token" type="hidden" value=<?= $verification_token ?>>
                        <input id="reset_password_email" type="hidden">
                        <div class="form-group">
                            <label class="control-label" for="reset_password_email_code">Код для скидання паролю</label>
                            <input type="text" class="form-control" id="reset_password_email_code" placeholder="Введіть код" required>
                            <div id="reset_password_email_code_feedback" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="reset_password_password">Новий пароль</label>
                            <div class="input-group" id="reset_password_password_group">
                                <input type="password" class="form-control" id="reset_password_password" placeholder="Введіть новий пароль" required>
                                <div class="input-group-append">
                                    <div onclick="passwordToggle(document.getElementById('reset_password_password_img'), document.getElementById('reset_password_password'))" class="input-group-text" style="cursor: pointer;">
                                        <img id="reset_password_password_img" height="20" src="/icons/eye-fill.svg">
                                    </div>
                                </div>
                            </div>
                            <div id="reset_password_password_feedback" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="reset_password_repeat_password">Повторний пароль</label>
                            <div class="input-group" id="reset_password_repeat_password_group">
                                <input type="password" class="form-control" id="reset_password_repeat_password" placeholder="Введіть новий пароль повторно" required>
                                <div class="input-group-append">
                                    <div onclick="passwordToggle(document.getElementById('reset_password_repeat_password_img'), document.getElementById('reset_password_repeat_password'))" class="input-group-text" style="cursor: pointer;">
                                        <img id="reset_password_repeat_password_img" height="20" src="/icons/eye-fill.svg">
                                    </div>
                                </div>
                            </div>
                            <div id="reset_password_repeat_password_feedback" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрити</button>
                        <button type="submit" class="btn btn-dark">Підтвердити</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="mobileModal" tabindex="-1" role="dialog" aria-labelledby="mobileModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mobileModalLabel">Наші телефони</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-justify">Консультації та замовлення за телефонами:</p>
                    <p><a class="phone-ph" href="tel:+380660125020"><strong>+38(066)012-50-20</strong></a></p>
                    <p><a class="phone-ph" href="tel:+380636491060"><strong>+38(063)649-10-60</strong></a></p>
                    <p class="text-justify">Графік прийому замовлень:</p>
                    <p class="text-justify">Будні: з 10:00 до 20:00</p>
                    <p class="text-justify">Вихідні: з 11:00 до 19:00</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрити</button>
                </div>
            </div>
        </div>
    </div>
</header>