<?php
require_once("../LDLRIVS.php");

my_session_start();
// give security and verification tokens from session, post and cookies
$verification_token = $_POST['cart_verification_token'];
$verification_token1 = $_SESSION['verification_token'];
$is_authorized = $_POST['cart_is_authorized'];
$security_token = $_SESSION["security_token"];
$security_token1 = $_COOKIE["security_token"];
$email = $_SESSION["email"];


if ($is_authorized) {
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
            
            $cart_price = 0;
            $cart_modal_html = '';
            if ($stmt = $mysqli->prepare("SELECT `cart_items`.`PriceListID`, ProductName, Price, `Image`, `Count` FROM cart_items JOIN `pricelist` ON `cart_items`.`PriceListID` = `pricelist`.`PriceListID` WHERE UserID=?")) {
                $stmt->bind_param("i", $userID);
                $stmt->execute();
                $stmt->bind_result($pricelistID, $product_name, $price, $image, $count);
                while ($stmt->fetch()) {
                    if ($image != null) {
                        $cart_price += ($count * $price);
                        $cart_modal_html .= sprintf(
                            '<div class="card mb-md-3 mb-3">
                                <div class="card-body row">
                                    <div class="col-md-1 pr-0">
                                        <a href="product.php?id=%1$s">
                                            <img src="/%2$s" class="m-auto" style="display: block; max-height: 60px; max-width: 50px;" alt="">
                                        </a>
                                    </div>
                                    <div class="col-md-11">
                                        <div class="container pr-0 pl-1" style="height:60px">           
                                            <div class="row" style="min-height:25%%">
                                                <div class="col-md-12">
                                                    <a style="font-size:20px;" href="product.php?id=%1$s">%3$s</a>
                                                </div>                                
                                            </div> 
                                            <div class="row align-items-center divfillHeight">
                                                <div class="col-md-8">
                                                    <div class="h5 mb-0" style="float:left; padding: 8 14 8 0;">Ціна:</div>
                                                    <div class="rounded-xl h5 mb-0" style="background: #D3D3D3; padding: 8 14 8 14; float:left;">%4$s ₴</div>
                                                </div>
                                                <div class="col-md-2">                              
                                                    <div class="h5 mb-0" style="float:left; padding: 8 14 8 0;">%5$s шт.</div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="rounded-xl h5 mb-0" style="background: #D3D3D3; padding: 8 14 8 14; float:right;">%6$s ₴</div>
                                                </div>
                                            </div>                        
                                        </div>
                                    </div>
                                </div>     
                            </div>',
                            $pricelistID,
                            $image,
                            $product_name,
                            $price,
                            $count,
                            ($count * $price)
                        );
                    }
                }
                $stmt->close();

                $cart_modal_html .= sprintf(
                    '<div class="row">
                        <div class="col-md-12" style="padding: 8 36 8 8;">          
                            <div class="rounded-xl h2 mb-0 font-weight-normal" style="background: #D3D3D3; padding: 8 14 8 14; float:right;">%1$s ₴</div>
                            <div class="h2 mb-0 font-weight-normal" style=" padding: 8 14 8 14; float:right;">Разом:</div>
                        </div>
                    </div>',
                    $cart_price
                );
            }
        }
?>
        <!--DOCTYPE html-->
        <html lang="en">

        <head>

            <link rel="shortcut icon" href="/Images/webicon.png" type="image/x-icon">
            <title>
                ТОВ ТВД "РІВС" | Оформлення замовлення
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

            <!--Main Navigation-->
            <!--Main layout-->
            <main class="mt-5 mb-3">

                <!-- style="background-color: #eee;" -->
                <div class="container">
                    <!--Grid row-->
                    <div class="row">
                        <div class="col-sm-6">
                            <label for="checkout_email" class=>Електронна адреса</label>
                            <input type="text" readonly="true" class="form-control text-body" id="checkout_email" value=<?= $email ?>>
                        </div>
                        <div class="col-sm-6">
                            <label for="checkout_phone">Номер телефону</label>
                            <input type="text" readonly="true" class="form-control text-body" id="checkout_phone" value=<?= $phone ?>>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <label for="checkout_last_name" class=>Прізвище</label>
                            <input type="text" readonly="true" class="form-control text-body" id="checkout_last_name" value=<?= $last_name ?>>
                        </div>
                        <div class="col-sm-4">
                            <label for="checkout_first_name" class=>Ім'я</label>
                            <input type="text" readonly="true" class="form-control text-body" id="checkout_first_name" value=<?= $first_name ?>>
                        </div>
                        <div class="col-sm-4">
                            <label for="checkout_middle_name" class=>Ім'я по-батькові</label>
                            <input type="text" readonly="true" class="form-control text-body" id="checkout_middle_name" value=<?= $middle_name ?>>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-7 mb-4">
                            <div class="view overlay z-depth-1-half">
                                <div class="mask rgba-white-light">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="row">
                        <label for="checkout_email" class="col-sm-2 col-form-label">Електронна адреса</label>
                        <div class="col-sm-10 my-vertical-centered">
                            <input type="text" readonly="true" class="form-control-plaintext my-padding" id="checkout_email" value=>
                        </div>
                    </div>
                    <div class="row">
                        <label for="checkout_last_name" class="col-sm-2 col-form-label">Прізвище</label>
                        <div class="col-sm-10 my-vertical-centered">
                            <input type="text" readonly="true" class="form-control-plaintext my-padding" id="checkout_last_name" value=>
                        </div>
                    </div>
                    <div class="row">
                        <label for="checkout_first_name" class="col-sm-2 col-form-label">Ім'я</label>
                        <div class="col-sm-10 my-vertical-centered">
                            <input type="text" readonly="true" class="form-control-plaintext my-padding" id="checkout_first_name" value=>
                        </div>
                    </div>
                    <div class="row">
                        <label for="checkout_middle_name" class="col-sm-2 col-form-label">Ім'я по-батькові</label>
                        <div class="col-sm-10 my-vertical-centered">
                            <input type="text" readonly="true" class="form-control-plaintext my-padding" id="checkout_middle_name" value=>
                        </div>
                    </div>
                    <div class="row">
                        <label for="checkout_phone" class="col-sm-2 col-form-label">Номер телефону</label>
                        <div class="col-sm-10 my-vertical-centered">
                            <input type="text" readonly="true" class="form-control-plaintext my-padding" id="checkout_phone" value=>
                        </div>
                    </div>-->
                    <? echo $cart_modal_html ?>
                    <button id="changeUserDataDismissButton" type="button" class="btn btn-secondary my-1 mr-1">Відмінити</button>
                    <button id="changeUserDataSubmitButton" type="submit" class="btn btn-dark m-1">Підтвердити замовлення</button>

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
                var ru_link = document.getElementById("ru_link");
                ru_link.href = "/ru/checkoutCart.php";
                var ua_link = document.getElementById("ua_link");
                ua_link.href = "/ua/checkoutCart.php";
            </script>

            <!-- Script for submitting form -->
        </body>

        </html>
<?php
    } else {
        include("../scripts.php");
        echo "<script>$.redirect('index.php');</script>";
        exit();
    }
} else {
    if ($verification_token == null || $verification_token1 == null) {
        include("../scripts.php");
        echo "<script>$(document).ready(function() { $.redirect('index.php'); });</script>";
        exit();
    }

    if (hash_equals($verification_token, $verification_token1)) {
    }
    include("../scripts.php");
    echo "<script>$(document).ready(function() { $.redirect('index.php'); });</script>";
    exit();
}
?>