<header>
    <!--Navbar -->
    <nav class="mb-1 navbar sticky-top navbar-expand-lg navbar-light cyan accent-2 scrolling-navbar">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="/Images/logo.png" width="30" height="40" alt="logo">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-333" aria-controls="navbarSupportedContent-333" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent-333">
                <ul class="navbar-nav mr-auto">
                    <li id="main" class="nav-item">
                        <a class="rounded-lg nav-link" href="index.php">Головна</a>
                    </li>
                    <li id="contacts" class="nav-item">
                        <a class="rounded-lg nav-link" href="contacts.php">Контакти</a>
                    </li>
                    <li id="store" class="nav-item">
                        <a class="rounded-lg nav-link" href="store.php">Продукція</a>
                    </li>
                    </li>
                </ul>

                <ul class="navbar-nav navbar-right">

                    <li class="nav-item">
                        <!-- Button trigger modal -->
                        <a class="nav-link" data-toggle="modal" data-target="#mobileModal">
                            <img height="20" src="/icons/telephone-fill.svg">Телефони
                        </a>
                    </li>

                    <li class="nav-item">
                        <a id="ruLink" class="rounded-lg nav-link" href="/">RU
                        </a>
                    </li>
                    <li class="nav-item active disabled">
                        <a id="uaLink" class="rounded-lg nav-link" href="/">UA
                        </a>
                    </li>
                    <?

            // getting security tokens from session and cookies
            $security_token = $_SESSION["security_token"];
            $security_token1 = $_COOKIE["security_token"];

            // if security tokens are unset show registration and login
            if ($security_token == null || $security_token1 == null || !isset($_SESSION["email"])) { ?>
                    <li class="nav-item"><a class="rounded-lg nav-link" data-toggle="modal" data-target="#registerModal">Реєстрація</a></li>
                    <li class="nav-item"><a class="rounded-lg nav-link" data-toggle="modal" data-target="#loginModal">Увійти</a></li>
                    <? 

            // if tokens are equal show logout
            } else if (hash_equals($security_token, $security_token1) && isset($_SESSION["email"])) { ?>
                    <li style="margin-left:15px" id="user" class="nav-item">
                        <form style="margin:0px" class="nav-item" id="userForm" name="userForm" action="userAccount.php" method="post">
                            <input name="user_verification_token" id="user_verification_token" type="hidden" value=<?= $verification_token ?>>
                        </form>
                        <a id="userButton" class="rounded-lg nav-link"><?= $_SESSION["email"] ?></a>
                    </li>
                    <li class="nav-item">
                        <form style="margin:0px" class="nav-item" id="logoutForm" name="logoutForm" action="logout.php" method="post">
                            <input name="logout_verification_token" id="logout_verification_token" type="hidden" value=<?= $verification_token ?>>
                            <a id="logoutButton" class="rounded nav-link">Вийти</a>
                        </form>
                    </li>
                    <? 

            // if security tokens are not equal show registration and login
              } else { ?>
                    <li class="nav-item"><a class="rounded-lg nav-link" data-toggle="modal" data-target="#registerModal">Реєстрація</a></li>
                    <li class="nav-item"><a class="rounded-lg nav-link" data-toggle="modal" data-target="#loginModal">Увійти</a></li>
                    <? } ?>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Modal login -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="loginForm" name="loginForm" action="login.php" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="loginModalLabel">Вхід</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!--Grid row-->
                        <input name="login_verification_token" id="login_verification_token" type="hidden" value=<?= $verification_token ?>>
                        <div class="form-group">
                            <label class="control-label" for="login_email">Електронна адреса</label>
                            <input type="email" class="form-control" id="login_email" name="login_email" placeholder="Введіть електронну адресу" required>
                            <div id="login_email_feedback" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="login_password">Пароль</label>
                            <div class="input-group" id="login_password_group">
                                <input type="password" class="form-control" id="login_password" name="login_password" placeholder="Введіть пароль" aria-describedby="login_password_addon" required>
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
                        <button type="submit" class="btn btn-primary">Підтвердити</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal register-->
    <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="registerForm" name="registerForm" action="register.php" method="post">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="registerModalLabel">Реєстрація</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input name="register_verification_token" id="register_verification_token" type="hidden" value=<?= $verification_token ?>>
                        <div class="form-group">
                            <label class="control-label" for="register_email">Електронна адреса</label>
                            <input type="email" class="form-control" id="register_email" name="register_email" placeholder="Введіть електронну адресу" required>
                            <div id="register_email_feedback" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="register_password">Пароль</label>
                            <div class="input-group" id="register_password_group">
                                <input type="password" class="form-control" id="register_password" name="register_password" placeholder="Введіть пароль" required>
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
                                <input type="password" class="form-control" id="register_repeat_password" name="register_repeat_password" placeholder="Введіть пароль повторно" required>
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
                        <button type="submit" class="btn btn-primary">Підтвердити</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="registerConfirmationModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="registerConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form id="registerConfirmationForm" name="registerConfirmationForm" action="registerConfirmation.php" method="post">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="registerConfirmationModalLabel">Завершення реєстрації</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input name="register_confirmation_verification_token" id="register_confirmation_verification_token" type="hidden" value=<?= $verification_token ?>>
                        <input name="register_confirmation_email" id="register_confirmation_email" type="hidden">
                        <input name="register_confirmation_password" id="register_confirmation_password" type="hidden">
                        <div class="form-group">
                            <label class="control-label" for="register_confirmation_email_code">Код для підтвердження електронної адреси</label>
                            <input type="text" class="form-control" id="register_confirmation_email_code" name="register_confirmation_email_code" placeholder="Введіть код" required>
                            <div id="register_confirmation_email_code_feedback" class="invalid-feedback"></div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-lg-4">
                                <label class="control-label" for="register_confirmation_last_name">Прізвище</label>
                                <input type="text" class="form-control" id="register_confirmation_last_name" name="register_confirmation_last_name" placeholder="Введіть прізвище" required>
                                <div id="register_confirmation_last_name_feedback" class="invalid-feedback"></div>
                            </div>
                            <div class="form-group col-lg-4">
                                <label class="control-label" for="register_confirmation_first_name">Ім'я</label>
                                <input type="text" class="form-control" id="register_confirmation_first_name" name="register_confirmation_first_name" placeholder="Введіть ім'я" required>
                                <div id="register_confirmation_first_name_feedback" class="invalid-feedback"></div>
                            </div>

                            <div class="form-group col-lg-4">
                                <label class="control-label" for="register_confirmation_middle_name">Ім'я по-батькові</label>
                                <input type="text" class="form-control" id="register_confirmation_middle_name" name="register_confirmation_middle_name" placeholder="Введіть ім'я по-батькові" required>
                                <div id="register_confirmation_middle_name_feedback" class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="register_confirmation_phone">Номер телефону</label>
                            <input type="tel" class="form-control" id="register_confirmation_phone" name="register_confirmation_phone" pattern="^([+]\d{3}[(]\d{2}[)]\d{3}[ -]\d{2}[ -]\d{2})|([+]\d{12})|([+]\d{3} \d{2} \d{3} \d{2} \d{2})$/m" value="+380" required>
                            <div id="register_confirmation_phone_feedback" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрити</button>
                        <button id="register_confirmation_send_code" hidden="true" class="btn btn-primary">Відправити код повторно</button>
                        <button type="submit" class="btn btn-primary">Підтвердити</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="rememberModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="rememberModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="rememberForm" name="rememberForm" action="remember.php" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rememberModalLabel">Відновлення паролю</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!--Grid row-->
                        <input name="remember_verification_token" id="remember_verification_token" type="hidden" value=<?= $verification_token ?>>
                        <div class="form-group">
                            <label class="control-label" for="remember_email">Електронна адреса</label>
                            <input type="email" class="form-control" id="remember_email" name="remember_email" placeholder="Введіть електронну адресу" required>
                            <div id="remember_email_feedback" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрити</button>
                        <button type="submit" class="btn btn-primary">Надіслати код</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="resetPasswordModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="resetPasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="resetPasswordForm" name="resetPasswordForm" action="resetPassword.php" method="post">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="resetPasswordModalLabel">Скидання паролю</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input name="reset_password_verification_token" id="reset_password_verification_token" type="hidden" value=<?= $verification_token ?>>
                        <input name="reset_password_email" id="reset_password_email" type="hidden">
                        <div class="form-group">
                            <label class="control-label" for="reset_password_email_code">Код для скидання паролю</label>
                            <input type="text" class="form-control" id="reset_password_email_code" name="reset_password_email_code" placeholder="Введіть код" required>
                            <div id="reset_password_email_code_feedback" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="reset_password_password">Новий пароль</label>
                            <div class="input-group" id="reset_password_password_group">
                                <input type="password" class="form-control" id="reset_password_password" name="reset_password_password" placeholder="Введіть новий пароль" required>
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
                                <input type="password" class="form-control" id="reset_password_repeat_password" name="reset_password_repeat_password" placeholder="Введіть новий пароль повторно" required>
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
                        <button type="submit" class="btn btn-primary">Підтвердити</button>
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