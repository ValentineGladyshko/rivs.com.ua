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
                        <a class="rounded-xl nav-link" href="index.php">Главная</a>
                    </li>
                    <li id="contacts" class="nav-item">
                        <a class="rounded-xl nav-link" href="contacts.php">Контакты</a>
                    </li>
                    <li id="store" class="nav-item">
                        <a class="rounded-xl nav-link" href="store.php">Продукция</a>
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
                                Телефоны
                            </div>
                        </a>
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
                            <a id="logoutButton" class="rounded nav-link">Выйти</a>
                        </form>
                    </li>
                    <? } else { ?>
                    <li class="nav-item"><a class="rounded-xl nav-link" data-toggle="modal" data-target="#registerModal">Регистрация</a></li>
                    <li class="nav-item"><a class="rounded-xl nav-link" data-toggle="modal" data-target="#loginModal">Войти</a></li>
                    <? } ?>
                    <li style="min-width:10px">
                    </li>
                    <? echo get_cart_button_html($_SESSION["email"], $is_authorized); ?>
                    <form style="margin:0px" class="nav-item" id="checkoutCartForm" action="checkoutCart.php" method="post">
                        <input name="cart_verification_token" id="cart_verification_token" type="hidden" value=<?= $verification_token ?>>
                        <input name="cart_is_authorized" id="cart_is_authorized" type="hidden" value=<?= $is_authorized ?>>
                    </form>
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
                        <h5 class="modal-title" id="loginModalLabel">Вход</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!--Grid row-->
                        <input id="login_verification_token" type="hidden" value=<?= $verification_token ?>>
                        <div class="form-group">
                            <label class="control-label" for="login_email">Электронный адрес</label>
                            <input type="email" class="form-control" id="login_email" placeholder="Введите адрес электронной почты" required>
                            <div id="login_email_feedback" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="login_password">Пароль</label>
                            <div class="input-group" id="login_password_group">
                                <input type="password" class="form-control" id="login_password" placeholder="Введите пароль" required>
                                <div class="input-group-append">
                                    <div onclick="passwordToggle(document.getElementById('login_password_img'), document.getElementById('login_password'))" class="input-group-text" style="cursor: pointer;">
                                        <img id="login_password_img" height="20" src="/icons/eye-fill.svg">
                                    </div>
                                </div>
                            </div>
                            <div id="login_password_feedback" class="invalid-feedback"></div>
                        </div>
                        <button style="margin:0; padding:0;" class="btn btn-link" data-dismiss="modal" data-toggle="modal" data-target="#rememberModal">Забыли пароль?</button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        <button id="loginButton" type="submit" class="btn btn-dark"><span id="loginButtonSpinner" style="width: 20px; height: 20px;"></span>Подтвердить</button>
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
                        <h5 class="modal-title" id="registerModalLabel">Регистрация</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input id="register_verification_token" type="hidden" value=<?= $verification_token ?>>
                        <div class="form-group">
                            <label class="control-label" for="register_email">Электронный адрес</label>
                            <input type="email" class="form-control" id="register_email" placeholder="Введите адрес электронной почты" required>
                            <div id="register_email_feedback" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="register_password">Пароль</label>
                            <div class="input-group" id="register_password_group">
                                <input type="password" class="form-control" id="register_password" placeholder="Введите пароль" required>
                                <div class="input-group-append">
                                    <div onclick="passwordToggle(document.getElementById('register_password_img'), document.getElementById('register_password'))" class="input-group-text" style="cursor: pointer;">
                                        <img id="register_password_img" height="20" src="/icons/eye-fill.svg">
                                    </div>
                                </div>
                            </div>
                            <div id="register_password_feedback" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="register_repeat_password">Повторите ввод нового пароля</label>
                            <div class="input-group" id="register_repeat_password_group">
                                <input type="password" class="form-control" id="register_repeat_password" placeholder="Введите новый пароль повторно" required>
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
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        <button id="registerButton" type="submit" class="btn btn-dark"><span id="registerButtonSpinner" style="width: 20px; height: 20px;"></span>Подтвердить</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="orderModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="orderModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderModalLabel">Заказ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Ваш заказ получен и обрабатывается. В ближайшее время с Вами свяжется сотрудник компании для подтверждения заказа.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="registerConfirmationModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="registerConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form id="registerConfirmationForm">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="registerConfirmationModalLabel">Завершение регистрации</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input id="register_confirmation_verification_token" type="hidden" value=<?= $verification_token ?>>
                        <input id="register_confirmation_email" type="hidden">
                        <input id="register_confirmation_password" type="hidden">
                        <div class="form-group">
                            <label class="control-label" for="register_confirmation_email_code">Код для подтверждения электронного адреса</label>
                            <input type="text" class="form-control" id="register_confirmation_email_code" placeholder="Введіть код" required>
                            <div id="register_confirmation_email_code_feedback" class="invalid-feedback"></div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-lg-4">
                                <label class="control-label" for="register_confirmation_last_name">Фамилия</label>
                                <input type="text" class="form-control" id="register_confirmation_last_name" placeholder="Введите фамилию" required>
                                <div id="register_confirmation_last_name_feedback" class="invalid-feedback"></div>
                            </div>
                            <div class="form-group col-lg-4">
                                <label class="control-label" for="register_confirmation_first_name">Имя</label>
                                <input type="text" class="form-control" id="register_confirmation_first_name" placeholder="Введите имя" required>
                                <div id="register_confirmation_first_name_feedback" class="invalid-feedback"></div>
                            </div>

                            <div class="form-group col-lg-4">
                                <label class="control-label" for="register_confirmation_middle_name">Имя отчество</label>
                                <input type="text" class="form-control" id="register_confirmation_middle_name" placeholder="Введите имя отчество" required>
                                <div id="register_confirmation_middle_name_feedback" class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="register_confirmation_phone">Номер телефона</label>
                            <input type="tel" class="form-control" id="register_confirmation_phone" pattern="^([+]\d{3}[(]\d{2}[)]\d{3}[ -]\d{2}[ -]\d{2})|([+]\d{12})|([+]\d{3} \d{2} \d{3} \d{2} \d{2})$/m" value="+380" required>
                            <div id="register_confirmation_phone_feedback" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        <button id="registerConfirmationSendCodeButton" hidden="true" class="btn btn-dark"><span id="registerConfirmationSendCodeButtonSpinner" style="width: 20px; height: 20px;"></span>Отправить код повторно</button>
                        <button id="registerConfirmationButton" type="submit" class="btn btn-dark"><span id="registerConfirmationButtonSpinner" style="width: 20px; height: 20px;"></span>Подтвердить</button>
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
                        <h5 class="modal-title" id="rememberModalLabel">Восстановление пароля</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!--Grid row-->
                        <input id="remember_verification_token" type="hidden" value=<?= $verification_token ?>>
                        <div class="form-group">
                            <label class="control-label" for="remember_email">Электронный адрес</label>
                            <input type="email" class="form-control" id="remember_email" placeholder="Введите адрес электронной почты" required>
                            <div id="remember_email_feedback" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        <button id="rememberButton" type="submit" class="btn btn-dark"><span id="rememberButtonSpinner" style="width: 20px; height: 20px;"></span>Отправить код</button>
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
                        <h5 class="modal-title" id="resetPasswordModalLabel">Сброс пароля</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input id="reset_password_verification_token" type="hidden" value=<?= $verification_token ?>>
                        <input id="reset_password_email" type="hidden">
                        <div class="form-group">
                            <label class="control-label" for="reset_password_email_code">Код для сброса пароля</label>
                            <input type="text" class="form-control" id="reset_password_email_code" placeholder="Введіть код" required>
                            <div id="reset_password_email_code_feedback" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="reset_password_password">Новый пароль</label>
                            <div class="input-group" id="reset_password_password_group">
                                <input type="password" class="form-control" id="reset_password_password" placeholder="Введите новый пароль" required>
                                <div class="input-group-append">
                                    <div onclick="passwordToggle(document.getElementById('reset_password_password_img'), document.getElementById('reset_password_password'))" class="input-group-text" style="cursor: pointer;">
                                        <img id="reset_password_password_img" height="20" src="/icons/eye-fill.svg">
                                    </div>
                                </div>
                            </div>
                            <div id="reset_password_password_feedback" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="reset_password_repeat_password">Повторите ввод нового пароля</label>
                            <div class="input-group" id="reset_password_repeat_password_group">
                                <input type="password" class="form-control" id="reset_password_repeat_password" placeholder="Введите новый пароль повторно" required>
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
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        <button id="resetPasswordButton" type="submit" class="btn btn-dark"><span id="resetPasswordButtonSpinner" style="width: 20px; height: 20px;"></span>Подтвердить</button>
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
                    <h5 class="modal-title" id="mobileModalLabel">Наши телефоны</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-justify">Консультации и заказ по телефонам:</p>
                    <p><a class="phone-ph" href="tel:+380443324517"><strong>+38(044)332-45-17</strong></a></p>
                    <p><a class="phone-ph" href="tel:+380660125020"><strong>+38(066)012-50-20</strong></a></p>
                    <p><a class="phone-ph" href="tel:+380636491060"><strong>+38(063)649-10-60</strong></a></p>
                    <p><a class="phone-ph" href="tel:+380674061192"><strong>+38(067)406-11-92</strong></a></p>
                    <p class="text-justify">График приема заказов:</p>
                    <p class="text-justify">Будни: с 10:00 до 20:00</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
</header>