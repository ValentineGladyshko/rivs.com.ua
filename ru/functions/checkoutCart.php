<?php
require_once("../../LDLRIVS.php");
require_once("mainFunctions.php");

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
        $mysqli = mysqli_connect("localhost", "chba7f54c7_LDLRIVS", "8e5cktmvx6", "chba7f54c7_LDLRIVS");
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
          `Phone`, `PhoneNonce`, `PhoneTag` FROM `customers` WHERE Email=?")) {
            $stmt->bind_param("s", $email);
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

        $key = $key = base64_decode(file_get_contents('../../../key.txt'));

        $new_key = $key . md5($email, true);

        $first_name = openssl_decrypt($first_name_encrypted, $cipher, $new_key, $options = 0, base64_decode($first_name_iv), base64_decode($first_name_tag));
        $middle_name = openssl_decrypt($middle_name_encrypted, $cipher, $new_key, $options = 0, base64_decode($middle_name_iv), base64_decode($middle_name_tag));
        $last_name = openssl_decrypt($last_name_encrypted, $cipher, $new_key, $options = 0, base64_decode($last_name_iv), base64_decode($last_name_tag));
        $phone = openssl_decrypt($phone_encrypted, $cipher, $new_key, $options = 0, base64_decode($phone_iv), base64_decode($phone_tag));

        $user_data_html = sprintf(
            '<div class="row">
                <div class="col-sm-6">
                    <label for="checkout_email" class=>Электронный адрес</label>
                    <input type="text" readonly="true" class="form-control text-body" id="checkout_email" value="%1$s">
                </div>
                <div class="col-sm-6">
                    <label for="checkout_phone">Номер телефона</label>
                    <input type="text" readonly="true" class="form-control text-body" id="checkout_phone" value="%2$s">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <label for="checkout_last_name" class=>Фамилия</label>
                    <input type="text" readonly="true" class="form-control text-body" id="checkout_last_name" value="%3$s">
                </div>
                <div class="col-sm-4">
                    <label for="checkout_first_name" class=>Имя</label>
                    <input type="text" readonly="true" class="form-control text-body" id="checkout_first_name" value="%4$s">
                </div>
                <div class="col-sm-4">
                    <label for="checkout_middle_name" class=>Имя отчество</label>
                    <input type="text" readonly="true" class="form-control text-body" id="checkout_middle_name" value="%5$s">
                </div>
            </div>',
            $email,
            $phone,
            $last_name,
            $first_name,
            $middle_name
        );

        if ($stmt = $mysqli->prepare("SELECT `cart_items`.`PriceListID`, ProductName, Price, `Image`, `Count` FROM cart_items JOIN `pricelistru` ON `cart_items`.`PriceListID` = `pricelistru`.`PriceListID` WHERE UserID=?")) {
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
        $mysqli = mysqli_connect("localhost", "chba7f54c7_LDLRIVS", "8e5cktmvx6", "chba7f54c7_LDLRIVS");
        if ($mysqli->connect_errno) {
            $response->success = false;
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
            exit();
        }

        $user_data_html = sprintf(
            '<div class="form-row">
                <div class="form-group col-sm-6">
                    <label for="checkout_email" class=>Электронный адрес</label>
                    <input type="email" class="form-control" id="checkout_email" placeholder="Введите адрес электронной почты" required>
                    <div id="checkout_email_feedback" class="invalid-feedback"></div>
                </div>
                <div class="form-group col-sm-6">
                    <label for="checkout_phone">Номер телефона</label>
                    <input type="tel" class="form-control" id="checkout_phone" 
                        pattern="^([+]\d{3}[(]\d{2}[)]\d{3}[ -]\d{2}[ -]\d{2})|([+]\d{12})|([+]\d{3} \d{2} \d{3} \d{2} \d{2})$/m" value="+380" required>
                    <div id="checkout_phone_feedback" class="invalid-feedback"></div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-sm-4">
                    <label for="checkout_last_name" class=>Фамилия</label>
                    <input type="text" class="form-control" id="checkout_last_name" placeholder="Введите фамилию" required>
                    <div id="checkout_last_name_feedback" class="invalid-feedback"></div>
                </div>
                <div class="form-group col-sm-4">
                    <label for="checkout_first_name" class=>Имя</label>
                    <input type="text" class="form-control" id="checkout_first_name" placeholder="Введите имя" required>
                    <div id="checkout_first_name_feedback" class="invalid-feedback"></div>
                </div>
                <div class="form-group col-sm-4">
                    <label for="checkout_middle_name" class=>Имя отчество</label>
                    <input type="text" class="form-control" id="checkout_middle_name" placeholder="Введите имя отчество" required>
                    <div id="checkout_middle_name_feedback" class="invalid-feedback"></div>
                </div>
            </div>',
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

            if ($stmt = $mysqli->prepare("SELECT `PriceListID`, ProductName, Price, `Image` FROM `pricelistru` WHERE `PriceListID`=?")) {
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
        '<div class="card mb-sm-3 mb-3">
            <div class="card-body row">
                <div class="col-lg-1 col-sm-2 px-0">
                    <a href="product.php?id=%1$s">
                        <img src="/%2$s" class="m-auto" style="display: block; max-height: 60px; max-width: 50px;" alt="">
                    </a>
                </div>
                <div class="col-lg-11 col-sm-10 pl-sm-0 pl-lg-2">
                    <div class="container px-0" style="min-height:60px">
                        <div class="row product-name-sm">
                            <div class="col-sm-12">
                                <a style="font-size:20px;" href="product.php?id=%1$s">%3$s</a>
                            </div>
                        </div>
                        <div class="row align-items-center order-sm mt-sm-2 mt-xl-0" style="min-height: 40px;">
                            <div class="pr-0 col-xl-8 col-lg-7 col-md-6 col-sm-5">
                                <div class="h5 mb-0 py-2 pl-0 pr-3 float-left">Цена:</div>
                                <div class="rounded-xl h5 mb-0 py-2 float-left">%4$s ₴</div>
                            </div>
                            <div class="px-sm-0 col-lg-2 col-sm-2">
                                <div class="h5 mb-0 float-left py-2 pl-1 pr-0">%5$s шт.</div>
                            </div>
                            <div class="pl-sm-0 col-xl-2 col-lg-3 col-md-4 col-sm-5">
                                <div class="rounded-xl h5 mb-0 float-sm-right float-left py-2">%6$s ₴</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>',
        $item["pricelistID"],
        $item["image"],
        $item["product_name"],
        penny_price_to_normal_price($item["price"]),
        $item["count"],
        penny_price_to_normal_price($item["total_count"])
    );
}

$cart_modal_html .= sprintf(
    '<div class="row">
        <div class="col-md-12 pr-3 py-2 pl-2">          
            <div class="rounded-xl h2 mb-0 font-weight-normal px-3 py-2 float-right bg-grey-alt">%1$s ₴</div>
            <div class="h2 mb-0 font-weight-normal px-3 py-2 float-right">Разом:</div>
        </div>
    </div>',
    penny_price_to_normal_price($cart_price)
);


?>
<!--DOCTYPE html-->
<html lang="en">

<head>

    <link rel="shortcut icon" href="/Images/webicon.png" type="image/x-icon">
    <title>
        ООО ТПП "РИВС" | Оформление заказа
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
                <button id="checkoutDismissButton" type="button" class="btn btn-secondary my-1 mr-1">Отменить</button>
                <button id="checkoutSubmitButton" type="submit" class="btn btn-dark m-1"><span id="checkoutSubmitButtonSpinner" style="width: 20px; height: 20px;"></span>
                    Подтвердить заказ</button>
            </div>
        </form>

    </main>
    <!--Main layout-->

    <!-- Footer -->
    <footer class="page-footer font-small bottom bg-dark accent-4 mt-4">

        <!-- Copyright -->
        <div class="footer-copyright text-center py-3">© 2015 ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ — ТОРГОВО-ПРОИЗВОДСТВЕННОЕ ПРЕДПРИЯТИЕ "РИВС"
        </div>

    </footer>
    <!-- Footer -->

    <!-- SCRIPTS -->
    <!-- JQuery -->
    <? include("myScripts.php"); ?>

    <!-- Script for submitting form -->
    <script type="text/javascript">
        $(document).ready(function() {
            $("#checkoutDismissButton").click(
                function(e) {
                    window.history.back();
                }
            );
        });
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

            document.getElementById("checkoutSubmitButtonSpinner").classList.add("spinner-border");
            document.getElementById("checkoutSubmitButton").disabled = true;
            // ajax request
            $.ajax({
                type: "POST",
                url: "functions/checkoutConfirmation.php",
                data: formData,
                success: function(response) {
                    if (response != null) {

                        document.getElementById("checkoutSubmitButtonSpinner").classList.remove("spinner-border");
                        document.getElementById("checkoutSubmitButton").disabled = false;

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