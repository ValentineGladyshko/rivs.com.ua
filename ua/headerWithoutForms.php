<header style="font-family: Helios,sans-serif;">
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
                        <i class="russia flag"></i>
                    </li>

                    <li class="nav-item">
                        <!-- Button trigger modal -->
                        <a class="nav-link" data-toggle="modal" data-target="#MobileModal">
                            <i class="fas fa-phone"></i>Телефони
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
                </ul>
            </div>
        </div>
    </nav>
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
            </div>
        </div>
    </div>
</header>