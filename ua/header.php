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
                        <a class="nav-link" href="index.php">Головна</a>
                    </li>
                    <li id="contacts" class="nav-item">
                        <a class="nav-link" href="contacts.php">Контакти</a>
                    </li>
                    <li id="store" class="nav-item">
                        <a class="nav-link" href="store.php">Продукція</a>
                    </li>
                    </li>
                </ul>

                <ul class="navbar-nav navbar-right">

                    <li class="nav-item">
                        <!-- Button trigger modal -->
                        <a class="nav-link" data-toggle="modal" data-target="#MobileModal">
                            <img height="20" src="/icons/telephone-fill.svg">Телефони
                        </a>
                    </li>

                    <li class="nav-item">
                        <a id="ru_link" class="nav-link" href="/">RU
                        </a>
                    </li>
                    <li class="nav-item active disabled">
                        <a id="ua_link" class="nav-link" href="/">UA
                        </a>
                    </li>
                    <?

            // getting security tokens from session and cookies
            $security_token = $_SESSION["security_token"];
            $security_token1 = $_COOKIE["security_token"];

            // if security tokens are unset show registration and login
            if ($security_token == null || $security_token1 == null || !isset($_SESSION["email"])) { ?>
                    <li class="nav-item"><a class="nav-link" data-toggle="modal" data-target="#RegisterModal">Реєстрація</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="modal" data-target="#LoginModal">Увійти</a></li>
                    <? 

            // if tokens are equal show logout
            } else if (hash_equals($security_token, $security_token1) && isset($_SESSION["email"])) { ?>
                    <li style="margin-left:15px" id="user" class="nav-item">
                        <form style="margin:0px" class="nav-item" id="user-form" name="user-form" action="userAccount.php" method="post">
                            <input name="user_verification_token" id="user_verification_token" type="hidden" value=<?= $verification_token ?>>
                        </form>
                        <a id="UserButton" class="nav-link"><?= $_SESSION["email"] ?></a>
                    </li>
                    <li class="nav-item">
                        <form style="margin:0px" class="nav-item" id="logout-form" name="logout-form" action="logout.php" method="post">
                            <input name="logout_verification_token" id="logout_verification_token" type="hidden" value=<?= $verification_token ?>>
                            <a id="LogoutButton" class="nav-link">Вийти</a>
                        </form>
                    </li>
                    <? 

            // if security tokens are not equal show registration and login
              } else { ?>
                    <li class="nav-item"><a class="nav-link" data-toggle="modal" data-target="#RegisterModal">Реєстрація</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="modal" data-target="#LoginModal">Увійти</a></li>
                    <? } ?>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Modal login -->
    <div class="modal fade" id="LoginModal" tabindex="-1" role="dialog" aria-labelledby="LoginModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="login-form" name="login-form" action="login.php" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="MobileModalLabel">Вхід</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!--Grid row-->
                        <input name="login_verification_token" id="login_verification_token" type="hidden" value=<?= $verification_token ?>>
                        <div class="form-group">
                            <label class="control-label" for="email">Електронна адреса</label>
                            <input type="email" class="form-control" id="login_email" name="login_email" placeholder="Введіть електронну адресу" required>
                            <div id="login_email_feedback" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="password">Пароль</label>
                            <input type="password" class="form-control" id="login_password" name="login_password" placeholder="Введіть пароль" required>
                            <div id="login_password_feedback" class="invalid-feedback"></div>
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
    <!-- Modal register-->
    <div class="modal fade" id="RegisterModal" tabindex="-1" role="dialog" aria-labelledby="RegisterModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="register-form" name="register-form" action="register.php" method="post">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="MobileModalLabel">Реєстрація</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input name="register_verification_token" id="register_verification_token" type="hidden" value=<?= $verification_token ?>>
                        <div class="form-group">
                            <label class="control-label" for="email1">Електронна адреса</label>
                            <input type="email" class="form-control" id="register_email" name="register_email" placeholder="Введіть електронну адресу" required>
                            <div id="register_email_feedback" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="password1">Пароль</label>
                            <input type="password" class="form-control" id="register_password" name="register_password" placeholder="Введіть пароль" required>
                            <div id="register_password_feedback" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="repeat_password">Повторний пароль</label>
                            <input type="password" class="form-control" id="register_repeat_password" name="register_repeat_password" placeholder="Введіть пароль повторно" required>
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
    <!-- Modal -->
    <div class="modal fade" id="MobileModal" tabindex="-1" role="dialog" aria-labelledby="MobileModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="MobileModalLabel">Наші телефони</h5>
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