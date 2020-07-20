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

$cart_modal_html = '';
$cart_items = null;
$user_data_html = '';
$cart_price = 0;

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

        if ($userID == null) {
            include("../scripts.php");
            echo "<script>$.redirect('index.php');</script>";
            exit();
        }
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

        $user_data_html = sprintf(
            '<div class="row">
                <div class="col-sm-6">
                    <label for="checkout_email" class=>Електронна адреса</label>
                    <input type="text" readonly="true" class="form-control text-body" id="checkout_email" value="%2$s">
                </div>
                <div class="col-sm-6">
                    <label for="checkout_phone">Номер телефону</label>
                    <input type="text" readonly="true" class="form-control text-body" id="checkout_phone" value="%3$s">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <label for="checkout_last_name" class=>Прізвище</label>
                    <input type="text" readonly="true" class="form-control text-body" id="checkout_last_name" value="%4$s">
                </div>
                <div class="col-sm-4">
                    <label for="checkout_first_name" class=>Ім%1$sя</label>
                    <input type="text" readonly="true" class="form-control text-body" id="checkout_first_name" value="%5$s">
                </div>
                <div class="col-sm-4">
                    <label for="checkout_middle_name" class=>Ім%1$sя по-батькові</label>
                    <input type="text" readonly="true" class="form-control text-body" id="checkout_middle_name" value="%6$s">
                </div>
            </div>',
            "'",
            $email,
            $phone,
            $last_name,
            $first_name,
            $middle_name
        );

        if ($stmt = $mysqli->prepare("SELECT `cart_items`.`PriceListID`, ProductName, Price, `Image`, `Count` FROM cart_items JOIN `pricelist` ON `cart_items`.`PriceListID` = `pricelist`.`PriceListID` WHERE UserID=?")) {
            $stmt->bind_param("i", $userID);
            $stmt->execute();
            $stmt->bind_result($pricelistID, $product_name, $price, $image, $count);
            while ($stmt->fetch()) {
                if ($image != null) {
                    $cart_price += ($count * $price);
                    $item["pricelistID"] = $pricelistID;
                    $item["image"] = $image;
                    $item["product_name"] = $product_name;
                    $item["price"] = $price;
                    $item["count"] = $count;
                    $item["total_count"] = ($count * $price);

                    $cart_items[] = $item;
                }
            }
            $stmt->close();
        }
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
        $mysqli = mysqli_connect("localhost", "RegisterUser", "E9aZc4DgpWEaRlY2", "rivs");
        if ($mysqli->connect_errno) {
            $response->success = false;
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
            exit();
        }

        $user_data_html = sprintf(
            '<div class="form-row">
                <div class="form-group col-sm-6">
                    <label for="checkout_email" class=>Електронна адреса</label>
                    <input type="email" class="form-control" id="checkout_email" placeholder="Введіть електронну адресу" required>
                    <div id="checkout_email_feedback" class="invalid-feedback"></div>
                </div>
                <div class="form-group col-sm-6">
                    <label for="checkout_phone">Номер телефону</label>
                    <input type="tel" class="form-control" id="checkout_phone" 
                        pattern="^([+]\d{3}[(]\d{2}[)]\d{3}[ -]\d{2}[ -]\d{2})|([+]\d{12})|([+]\d{3} \d{2} \d{3} \d{2} \d{2})$/m" value="+380" required>
                    <div id="checkout_phone_feedback" class="invalid-feedback"></div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-sm-4">
                    <label for="checkout_last_name" class=>Прізвище</label>
                    <input type="text" class="form-control" id="checkout_last_name" placeholder="Введіть прізвище" required>
                    <div id="checkout_last_name_feedback" class="invalid-feedback"></div>
                </div>
                <div class="form-group col-sm-4">
                    <label for="checkout_first_name" class=>Ім%1$sя</label>
                    <input type="text" class="form-control" id="checkout_first_name" placeholder="Введіть ім%1$sя" required>
                    <div id="checkout_first_name_feedback" class="invalid-feedback"></div>
                </div>
                <div class="form-group col-sm-4">
                    <label for="checkout_middle_name" class=>Ім%1$sя по-батькові</label>
                    <input type="text" class="form-control" id="checkout_middle_name" placeholder="Введіть ім%1$sя по-батькові" required>
                    <div id="checkout_middle_name_feedback" class="invalid-feedback"></div>
                </div>
            </div>',
            "'"
        );

        $cart = $_COOKIE["cart"];
        if ($cart == null) {
            include("../scripts.php");
            echo "<script>$(document).ready(function() { $.redirect('index.php'); });</script>";
            exit();
        }

        $cart = json_decode($cart, true);

        foreach ($cart as $value) {
            $my_pricelistID = $value["priceListID"];
            $count = $value["count"];

            if ($stmt = $mysqli->prepare("SELECT `PriceListID`, ProductName, Price, `Image` FROM `pricelist` WHERE `PriceListID`=?")) {
                $stmt->bind_param("i", $my_pricelistID);
                $stmt->execute();
                $stmt->bind_result($pricelistID, $product_name, $price, $image);
                $stmt->fetch();
                if ($image != null) {
                    $cart_price += ($count * $price);
                    $item["pricelistID"] = $pricelistID;
                    $item["image"] = $image;
                    $item["product_name"] = $product_name;
                    $item["price"] = $price;
                    $item["count"] = $count;
                    $item["total_count"] = ($count * $price);

                    $cart_items[] = $item;
                }
                $stmt->close();
            }
        }
    } else {
        include("../scripts.php");
        echo "<script>$(document).ready(function() { $.redirect('index.php'); });</script>";
        exit();
    }
}

foreach ($cart_items as $item) {
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
        $item["pricelistID"],
        $item["image"],
        $item["product_name"],
        $item["price"],
        $item["count"],
        $item["total_count"]
    );
}

$cart_modal_html .= sprintf(
    '<div class="row">
        <div class="col-md-12" style="padding: 8 36 8 8;">          
            <div class="rounded-xl h2 mb-0 font-weight-normal" style="background: #D3D3D3; padding: 8 14 8 14; float:right;">%1$s ₴</div>
            <div class="h2 mb-0 font-weight-normal" style=" padding: 8 14 8 14; float:right;">Разом:</div>
        </div>
    </div>',
    $cart_price
);


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
        <form id="checkoutForm">
            <div class="container">
                <!--Grid row-->

                <? echo $user_data_html ?>
                <div class="row">
                    <div class="col-md-7 mb-4">
                        <div class="view overlay z-depth-1-half">
                            <div class="mask rgba-white-light">
                            </div>
                        </div>
                    </div>
                </div>

                <? echo $cart_modal_html ?>
                <button id="checkoutDismissButton" type="button" class="btn btn-secondary my-1 mr-1">Відмінити</button>
                <button id="checkoutSubmitButton" type="submit" class="btn btn-dark m-1">Підтвердити замовлення</button>
            </div>
        </form>

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

    <!-- Script for submitting form -->
    <script type="text/javascript">
        var checkoutForm = $('#checkoutForm');
        checkoutForm.submit(function(e) {
            var isAuthorized = <?php if ($is_authorized) { ?>1<?php } else { ?>0<?php } ?>;
            // give data from form
            formData = {
                'verification_token': '<?= $verification_token ?>',
                'is_authorized': isAuthorized,
                'email': document.getElementById("checkout_email").value,
                'phone': document.getElementById("checkout_phone").value,
                'last_name': document.getElementById("checkout_last_name").value,
                'first_name': document.getElementById("checkout_first_name").value,
                'middle_name': document.getElementById("checkout_middle_name").value
            };
            e.preventDefault();

            // ajax request
            $.ajax({
                type: "POST",
                url: "functions/checkoutConfirmation.php",
                data: formData,
                success: function(response) {
                    if (response != null) {

                        // parse response from server
                        var jsonData = JSON.parse(response);

                        // if success code is true login and reload
                        if (jsonData.success == true) {
                            if (isAuthorized == true) {
                                document.getElementById('userForm').submit();
                            } else {
                                $('#orderModal').modal('show');
                            }

                            // else give html fields and show error messages
                        } else {
                            changeInputStatus(document.getElementById("checkout_email"),
                                document.getElementById("checkout_email_feedback"), jsonData, "email");
                            changeInputStatus(document.getElementById("checkout_phone"),
                                document.getElementById("checkout_phone_feedback"), jsonData, "phone");
                            changeInputStatus(document.getElementById("checkout_first_name"),
                                document.getElementById("checkout_first_name_feedback"), jsonData, "first_name");
                            changeInputStatus(document.getElementById("checkout_last_name"),
                                document.getElementById("checkout_last_name_feedback"), jsonData, "last_name");
                            changeInputStatus(document.getElementById("checkout_middle_name"),
                                document.getElementById("checkout_middle_name_feedback"), jsonData, "middle_name");
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