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

            <!--Main Navigation-->
            <!--Main layout-->
            <main class="mt-5 mb-3">
                <div class="container" style="background-color: #eee;">
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