<?php
require_once("../../LDLRIVS.php");
require_once("mainFunctions.php");
require_once("../../PHPMailer/Exception.php");
require_once("../../PHPMailer/OAuth.php");
require_once("../../PHPMailer/PHPMailer.php");
require_once("../../PHPMailer/POP3.php");
require_once("../../PHPMailer/SMTP.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

// give data from session and post
my_session_start();
$email = $_SESSION['email'];
$verification_token = $_POST['verification_token'];
$verification_token1 = $_SESSION['verification_token'];
$is_authorized = $_POST['is_authorized'];
$security_token = $_SESSION["security_token"];
$security_token1 = $_COOKIE["security_token"];
$first_name = $_POST["first_name"];
$middle_name = $_POST["middle_name"];
$last_name = $_POST["last_name"];
$phone = $_POST["phone"];
$email2 = $_POST["email"];

$from_email = 'rivs.com.ua@gmail.com';

//variables for response
$response = new stdClass();
$response->success = true;

if ($is_authorized) {
    if ($verification_token == null || $verification_token1 == null || $security_token == null || $security_token1 == null) {
        $response->success = false;
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit();
    }

    if (hash_equals($verification_token, $verification_token1) && hash_equals($security_token, $security_token1)) {

        $mysqli = mysqli_connect("localhost", "chba7f54c7_LDLRIVS", "8e5cktmvx6", "chba7f54c7_LDLRIVS");
        if ($mysqli->connect_errno) {
            $response->success = false;
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
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
            $mysqli->close();
            $response->success = false;
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
            exit();
        }
        $orderID = 1;

        if ($stmt = $mysqli->prepare("INSERT INTO `orders_in_process` (`Email`, `Date`) VALUES (?, ?)")) {
            $stmt->bind_param("ss", $email, date('Y-m-d H:i:s', time()));
            if ($stmt->execute() == false) {
            };
            $orderID = $stmt->insert_id;
            $stmt->close();
        }

        $status = 1;
        if ($stmt = $mysqli->prepare("INSERT INTO `orders_statuses` (`OrderId`, `StatusId`, `Date`) VALUES (?, ?, ?)")) {
            $stmt->bind_param("iis", $orderID, $status, date('Y-m-d H:i:s', time()));
            if ($stmt->execute() == false) {
            };
            $stmt->close();
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
        $key = base64_decode(file_get_contents('../../../../key.txt'));

        $new_key = $key . md5($email, true);

        $first_name = openssl_decrypt($first_name_encrypted, $cipher, $new_key, $options = 0, base64_decode($first_name_iv), base64_decode($first_name_tag));
        $middle_name = openssl_decrypt($middle_name_encrypted, $cipher, $new_key, $options = 0, base64_decode($middle_name_iv), base64_decode($middle_name_tag));
        $last_name = openssl_decrypt($last_name_encrypted, $cipher, $new_key, $options = 0, base64_decode($last_name_iv), base64_decode($last_name_tag));
        $phone = openssl_decrypt($phone_encrypted, $cipher, $new_key, $options = 0, base64_decode($phone_iv), base64_decode($phone_tag));

        $email_body = sprintf(
            '<html lang="en" style="box-sizing: border-box;">
                <head>
                    <meta charset="utf-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                    <meta http-equiv="x-ua-compatible" content="ie=edge">
                </head>
                <body style="box-sizing: border-box;">
                    <table width="100%%" style="box-sizing: border-box; background-color: #f1f1f1; min-width: 700px;" bgcolor="#f1f1f1">
                        <tr height="50" style="box-sizing: border-box;">
                            <td width="100%%" height="50" style="box-sizing: border-box; line-height: 1px; font-size: 1px;">
                                &nbsp;</td>
                        </tr>
                        <tr style="box-sizing: border-box;">
                            <td valign="middle" align="center" style="box-sizing: border-box;">
                                <a style="box-sizing: border-box;">
                                    <img align="none" alt="rivs.com.ua" border="0" hspace="0"
                                        src="https://www.rivs.com.ua/Images/logo.png"
                                        style="box-sizing: border-box; max-width: 70px; height: auto; display: block; margin: 0px;"
                                        title="rivs.com.ua" vspace="0" width="70px">
                                </a>
                            </td>
                        </tr>
                        <tr style="box-sizing: border-box;">
                            <td align="center"
                                style="box-sizing: border-box; font-family:%1$sSegoe UI%1$s, sans-serif; font-size: 16px; color: #313131; line-height: 24px;">
                                &nbsp;</td>
                        </tr>
                        <tr style="box-sizing: border-box;">
                            <td align="center" style="box-sizing: border-box;">
                                &nbsp;</td>
                        </tr>
                        <tr style="box-sizing: border-box;">
                            <td align="center" style="box-sizing: border-box;">
                                <table width="700" border="0" cellpadding="0" cellspacing="0"
                                    style="box-sizing: border-box; min-width: 700px;">
                                    <tr style="box-sizing: border-box;">
                                        <td style="box-sizing: border-box;">
                                            <div
                                                style="box-sizing: border-box; font-family:arial,helvetica,sans-serif; font-size: 24px; color: #313131; text-align: center;">
                                                Дякуємо за замовлення в інтернет-магазині</div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr style="box-sizing: border-box;">
                            <td width="100%%" height="50" style="box-sizing: border-box; line-height: 1px; font-size: 1px;">
                                <div id="email_code"
                                    style="box-sizing: border-box; font-family:arial,helvetica,sans-serif; color: #313131; text-align: center; font-size: 32px; font-weight: 500;
                                     letter-spacing: 3px; line-height: 60px;">
                                    Rivs.com.ua
                                </div>
                            </td>
                        </tr>
                        <tr style="box-sizing: border-box;">
                            <td align="center" style="box-sizing: border-box;">
                                &nbsp;</td>
                        </tr>
                        <tr style="box-sizing: border-box;">
                            <td align="center" style="box-sizing: border-box;">
                                <table width="700" style="box-sizing: border-box; min-width: 700px; background-color: #ffffff;"
                                    bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0">
                                    <tr style="box-sizing: border-box;">
                                        <td align="center" style="box-sizing: border-box;">
                                            <table width="600" border="0" cellpadding="0" cellspacing="0"
                                                style="box-sizing: border-box; min-width: 600px;">
                                                <tr height="30" style="box-sizing: border-box;">
                                                    <td width="100%%" height="30"
                                                        style="box-sizing: border-box; line-height: 1px; font-size: 1px;">
                                                        &nbsp;</td>
                                                </tr>
                                                <tr style="box-sizing: border-box;">
                                                    <td align="center" 
                                                        style="box-sizing: border-box; font-family:%1$sSegoe UI%1$s, sans-serif; font-size: 16px; color: #313131; line-height: 24px;">
                                                        <div 
                                                            style="box-sizing: border-box; font-family:%1$sSegoe UI%1$s, sans-serif; font-size: 16px; color: #313131; line-height: 24px;">
                                                            Вітаємо, %2$s,<br style="box-sizing: border-box;">
                                                            <br style="box-sizing: border-box;">
                                                            Ваше замовлення отримано і потрапило на обробку. Найближчим часом з Вами
                                                            зв%1$sяжеться співробітник компанії для підтвердження замовлення.</div>
                                                    </td>
                                                </tr>
                                                <tr height="20" style="box-sizing: border-box;">
                                                    <td width="100%%" height="20"
                                                        style="box-sizing: border-box; line-height: 1px; font-size: 1px;">
                                                        &nbsp;</td>
                                                </tr>
                                                <tr style="box-sizing: border-box;">
                                                    <td style="box-sizing: border-box;">
                                                        <div 
                                                            style="box-sizing: border-box; font-family:%1$sSegoe UI%1$s, sans-serif; font-size: 1rem; font-weight: 400; line-height: 1.5; 
                                                            display: -ms-flexbox; display: flex; -ms-flex-wrap: wrap; flex-wrap: wrap;
                                                            -ms-flex-pack: center; justify-content: center;">
                                                            <div 
                                                                style="box-sizing: border-box; position: relative; -ms-flex: 0 0 auto; flex: 0 0 auto; width: auto; max-width: 100%%;
                                                                padding-bottom: 1.5rem; margin: 0px; padding-right: 0px; padding-left: 0px;">
                                                                <div 
                                                                    style="box-sizing: border-box; font-weight: 500; line-height: 1.2; font-size: 1.25rem; padding: 8px 14px 8px 0px; margin-bottom: 0px;">
                                                                    Номер замовлення:
                                                                </div>
                                                            </div>
                                                            <div 
                                                                style="box-sizing: border-box; position: relative; -ms-flex: 0 0 auto; flex: 0 0 auto; width: auto; max-width: 100%%; padding-bottom: 1.5rem; 
                                                                margin: 0px; padding-right: 0px; padding-left: 0px;">
                                                                <div 
                                                                    style="box-sizing: border-box; font-weight: 500; line-height: 1.2; font-size: 1.25rem; background: #D3D3D3; padding: 8px 14px 8px 14px; 
                                                                    border-radius: .6rem; margin-bottom: 0px;">
                                                                    %3$s
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div 
                                                            style="box-sizing: border-box; font-family:%1$sSegoe UI%1$s, sans-serif; 
                                                            font-size: 1rem; font-weight: 400; line-height: 1.5; display: -ms-flexbox; display: flex; -ms-flex-wrap: wrap; flex-wrap: wrap;">
                                                            <div 
                                                                style="box-sizing: border-box; position: relative; width: 100%%; padding-right: 15px; padding-left: 0px; -ms-flex: 0 0 50%%; 
                                                                flex: 0 0 50%%; max-width: 50%%;">
                                                                <label for="checkout_email"
                                                                    style="box-sizing: border-box; display: inline-block; margin-bottom: .5rem;">Електронна
                                                                    адреса</label>
                                                                <input type="text" readonly="true" 
                                                                    id="checkout_email" value="%4$s"
                                                                    style="box-sizing: border-box; margin: 0px; font-family:inherit; overflow: visible; display: block; width: 100%%; 
                                                                    height: calc(1.5em + .75rem + 2px); padding: .375rem .75rem; font-size: 1rem; font-weight: 400; line-height: 1.5; 
                                                                    background-clip: padding-box; border: 1px solid #ced4da; border-radius: .25rem; transition: border-color .15s ease-in-out, 
                                                                    box-shadow .15s ease-in-out; background-color: #e9ecef; opacity: 1; color: #212529;">
                                                            </div>
                                                            <div 
                                                                style="box-sizing: border-box; position: relative; width: 100%%; padding-right: 0px; padding-left: 15px; -ms-flex: 0 0 50%%; 
                                                                flex: 0 0 50%%; max-width: 50%%;">
                                                                <label for="checkout_phone"
                                                                    style="box-sizing: border-box; display: inline-block; margin-bottom: .5rem;">Номер
                                                                    телефону</label>
                                                                <input type="text" readonly="true" 
                                                                    id="checkout_phone" value="%5$s"
                                                                    style="box-sizing: border-box; margin: 0px; font-family:inherit; overflow: visible; display: block; 
                                                                    width: 100%%; height: calc(1.5em + .75rem + 2px); padding: .375rem .75rem; font-size: 1rem; font-weight: 400; 
                                                                    line-height: 1.5; background-clip: padding-box; border: 1px solid #ced4da; border-radius: .25rem; 
                                                                    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out; background-color: #e9ecef; opacity: 1; color: #212529;">
                                                            </div>
                                                        </div>
                                                        <div 
                                                            style="box-sizing: border-box; font-family:%1$sSegoe UI%1$s, sans-serif; 
                                                            font-size: 1rem; font-weight: 400; line-height: 1.5; display: -ms-flexbox; display: flex; -ms-flex-wrap: wrap; flex-wrap: wrap;">
                                                            <div 
                                                                style="box-sizing: border-box; position: relative; width: 100%%; padding-right: 15px; padding-left: 0px; -ms-flex: 0 0 33.333333%%; 
                                                                flex: 0 0 33.333333%%; max-width: 33.333333%%;">
                                                                <label for="checkout_last_name"
                                                                    style="box-sizing: border-box; display: inline-block; margin-bottom: .5rem;">Прізвище</label>
                                                                <input type="text" readonly="true"
                                                                    id="checkout_last_name" value="%6$s"
                                                                    style="box-sizing: border-box; margin: 0px; font-family:inherit; overflow: visible; display: block; width: 100%%; 
                                                                    height: calc(1.5em + .75rem + 2px); padding: .375rem .75rem; font-size: 1rem; font-weight: 400; line-height: 1.5; 
                                                                    background-clip: padding-box; border: 1px solid #ced4da; border-radius: .25rem; 
                                                                    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out; background-color: #e9ecef; opacity: 1; color: #212529;">
                                                            </div>
                                                            <div
                                                                style="box-sizing: border-box; position: relative; width: 100%%; padding-right: 15px; padding-left: 15px; -ms-flex: 0 0 33.333333%%; 
                                                                flex: 0 0 33.333333%%; max-width: 33.333333%%;">
                                                                <label for="checkout_first_name"
                                                                    style="box-sizing: border-box; display: inline-block; margin-bottom: .5rem;">Ім%1$sя</label>
                                                                <input type="text" readonly="true" 
                                                                    id="checkout_first_name" value="%2$s"
                                                                    style="box-sizing: border-box; margin: 0px; font-family:inherit; overflow: visible; display: block; width: 100%%; 
                                                                    height: calc(1.5em + .75rem + 2px); padding: .375rem .75rem; font-size: 1rem; font-weight: 400; line-height: 1.5; 
                                                                    background-clip: padding-box; border: 1px solid #ced4da; border-radius: .25rem; 
                                                                    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out; background-color: #e9ecef; opacity: 1; color: #212529;">
                                                            </div>
                                                            <div 
                                                                style="box-sizing: border-box; position: relative; width: 100%%; padding-right: 0px; padding-left: 15px; -ms-flex: 0 0 33.333333%%; 
                                                                flex: 0 0 33.333333%%; max-width: 33.333333%%;">
                                                                <label for="checkout_middle_name"
                                                                    style="box-sizing: border-box; display: inline-block; margin-bottom: .5rem;">Ім%1$sя
                                                                    по-батькові</label>
                                                                <input type="text" readonly="true"
                                                                    id="checkout_middle_name" value="%7$s"
                                                                    style="box-sizing: border-box; margin: 0px; font-family:inherit; overflow: visible; display: block; width: 100%%; 
                                                                    height: calc(1.5em + .75rem + 2px); padding: .375rem .75rem; font-size: 1rem; font-weight: 400; line-height: 1.5; 
                                                                    background-clip: padding-box; border: 1px solid #ced4da; border-radius: .25rem; 
                                                                    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out; background-color: #e9ecef; opacity: 1; color: #212529;">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr height="15" style="box-sizing: border-box;">
                                                    <td width="100%%" height="15"
                                                        style="box-sizing: border-box; line-height: 1px; font-size: 1px;">
                                                        &nbsp;</td>
                                                </tr>
                                                <tr style="box-sizing: border-box;">
                                                    <td align="center" style="box-sizing: border-box;">
                                                        <div 
                                                            style="box-sizing: border-box; font-family:%1$sSegoe UI%1$s, sans-serif; 
                                                            font-size: 1rem; font-weight: 400; line-height: 1.5; width: 100%%;
                                                            margin-right: auto; margin-left: auto;">',
            "'",
            $first_name,
            sprintf("%06d", $orderID),
            $email,
            $phone,
            $last_name,
            $middle_name
        );
        $total_cart_price = 0;
        $cart_items = array();

        if ($stmt = $mysqli->prepare("SELECT `cart_items`.`PriceListID`, `Count`, `Price`, `ProductName`, `Image` FROM `cart_items` JOIN `pricelist` 
        ON `cart_items`.`PriceListID` = `pricelist`.`PriceListID` WHERE UserID=?")) {
            $stmt->bind_param("i", $userID);
            $stmt->execute();
            $stmt->bind_result($db_pricelistID, $db_count, $db_price, $db_product_name, $db_image);
            while ($stmt->fetch()) {
                $total_item_price = $db_count * $db_price;
                $total_cart_price += $total_item_price;
                $email_body .= sprintf(
                    '<div
                        style="box-sizing: border-box; position: relative; display: -ms-flexbox; display: flex; -ms-flex-direction: column; flex-direction: column; min-width: 0; 
                        word-wrap: break-word; background-color: #fff; background-clip: border-box; border: 1px solid rgba(0, 0, 0, .125); border-radius: .25rem; margin-bottom: 1rem;">
                            <div 
                                style="box-sizing: border-box; position: relative; width: 100%%; -ms-flex: 0 0 8.333333%%; flex: 0 0 8.333333%%; max-width: 8.333333%%; padding-top: 15px; padding-right: 15px; padding-left: 15px;">
                                <img src="https://www.rivs.com.ua/%1$s"
                                    style="box-sizing: border-box; display: block; max-height: 60px; max-width: 50px;"
                                    alt="">
                            </div>
                            <div
                                style="box-sizing: border-box; position: relative; width: 100%%; -ms-flex: 0 0 91.666667%%; flex: 0 0 91.666667%%; max-width: 91.666667%%;">
                                <div 
                                    style="box-sizing: border-box; width: 100%%; margin-right: auto; margin-left: auto; min-height: 95px; padding-right: 0px; padding-left: .25rem;">
                                    <div 
                                        style="box-sizing: border-box; display: -ms-flexbox; display: flex; -ms-flex-wrap: wrap; flex-wrap: wrap; min-height: 25%%;">
                                        <div 
                                            style="box-sizing: border-box; position: relative; width: 100%%; padding-right: 15px; padding-left: 15px; -ms-flex: 0 0 100%%; flex: 0 0 100%%; max-width: 100%%; 
                                            font-size: 20px;">%2$s</div>
                                    </div>
                                    <div
                                        style="box-sizing: border-box; display: -ms-flexbox; display: flex; -ms-flex-wrap: wrap; flex-wrap: wrap; height: 30px; 
                                        padding-top: .5rem;">
                                        <div
                                            style="box-sizing: border-box; position: relative; width: 100%%; padding-right: 15px; padding-left: 15px; -ms-flex: 0 0 41.666667%%; flex: 0 0 41.666667%%; 
                                            max-width: 41.666667%%;">
                                            <div
                                                style="box-sizing: border-box; font-weight: 500; line-height: 1.2; font-size: 1.25rem; float: left; padding: 8px 14px 8px 0px; margin-bottom: 0px;">
                                                Ціна:
                                            </div>
                                            <div
                                                style="box-sizing: border-box; font-weight: 500; line-height: 1.2; font-size: 1.25rem; background: #D3D3D3; padding: 8px 14px 8px 14px; float: left; 
                                                border-radius: .6rem; margin-bottom: 0px;">
                                                %3$s ₴</div>
                                        </div>
                                        <div
                                            style="box-sizing: border-box; position: relative; width: 100%%; padding-right: 15px; padding-left: 15px; -ms-flex: 0 0 25%%; flex: 0 0 25%%; max-width: 25%%;">
                                            <div
                                                style="box-sizing: border-box; font-weight: 500; line-height: 1.2; font-size: 1.25rem; float: left; padding: 8px 14px 8px 0px; margin-bottom: 0px;">
                                                %4$s шт.
                                            </div>
                                        </div>
                                        <div
                                            style="box-sizing: border-box; position: relative; width: 100%%; padding-right: 15px; padding-left: 15px; -ms-flex: 0 0 33.333333%%; 
                                            flex: 0 0 33.333333%%; max-width: 33.333333%%;">
                                            <div
                                                style="box-sizing: border-box; font-weight: 500; line-height: 1.2; font-size: 1.25rem; background: #D3D3D3; padding: 8px 14px 8px 14px; float: right; 
                                                border-radius: .6rem; margin-bottom: 0px;">
                                                %5$s ₴</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>',
                    $db_image,
                    $db_product_name,
                    penny_price_to_normal_price($db_price),
                    $db_count,
                    penny_price_to_normal_price($total_item_price)
                );
                $item = new stdClass();

                $item->pricelistID = $db_pricelistID;
                $item->count = $db_count;
                $item->price = $db_price;

                array_push($cart_items, $item);
            }
            $stmt->close();
        }
        foreach ($cart_items as $value) {
            if ($stmt = $mysqli->prepare("INSERT INTO `orders_items` (`OrderId`, `PriceListId`, `Count`, `Price`) VALUES (?, ?, ?, ?)")) {
                $stmt->bind_param("iiid", $orderID, $value->pricelistID, $value->count, $value->price);
                if ($stmt->execute() == false) {
                };
                $stmt->close();
            }
        }

        $email_body .= sprintf(
            '<div class="row"
                                                                style="box-sizing: border-box; display: -ms-flexbox; display: flex; -ms-flex-wrap: wrap; flex-wrap: wrap;">
                                                                <div
                                                                    style="box-sizing: border-box; position: relative; width: 100%%; padding-left: 15px; -ms-flex: 0 0 100%%; flex: 0 0 100%%; 
                                                                    max-width: 100%%; padding-right: 16px;">
                                                                    <div
                                                                        style="box-sizing: border-box; font-weight: 500; line-height: 1.2; font-size: 1.25rem; float: right; background: #D3D3D3; 
                                                                        padding: 8px 14px 8px 14px; border-radius: .6rem; margin-bottom: 0px;">
                                                                        %1$s ₴</div>
                                                                    <div
                                                                        style="box-sizing: border-box; font-weight: 500; line-height: 1.2; font-size: 1.25rem; float: right; 
                                                                        padding: 8px 14px 8px 14px; margin-bottom: 0px;">
                                                                        Разом:
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr style="box-sizing: border-box;">
                                                    <td align="center"
                                                        style="box-sizing: border-box; font-family:%1$sSegoe UI%1$s, sans-serif; font-size: 16px; color: #313131; line-height: 24px;">
                                                        <div
                                                            style="box-sizing: border-box; font-family:%1$sSegoe UI%1$s, sans-serif; font-size: 16px; color: #313131; line-height: 24px;">
                                                            <br style="box-sizing: border-box;">З повагою,<br
                                                                style="box-sizing: border-box;">
                                                            Команда Rivs.com.ua</div>
                                                    </td>
                                                </tr>
                                                <tr height="50" style="box-sizing: border-box;">
                                                    <td width="100%%" height="30"
                                                        style="box-sizing: border-box; line-height: 1px; font-size: 1px;">
                                                        &nbsp;</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr height="15" style="box-sizing: border-box;">
                            <td width="100%%" height="20" style="box-sizing: border-box; line-height: 1px; font-size: 1px;">
                                &nbsp;</td>
                        </tr>
                        <tr style="box-sizing: border-box;">
                            <td align="center" style="box-sizing: border-box;">
                                <table width="700" border="0" cellpadding="0" cellspacing="0"
                                    style="box-sizing: border-box; min-width: 700px;">
                                    <tr height="20" style="box-sizing: border-box;">
                                        <td width="100%%" height="20" style="box-sizing: border-box; line-height: 1px; font-size: 1px;">
                                            &nbsp;</td>
                                    </tr>
                                    <tr style="box-sizing: border-box;">
                                        <td align="center" style="box-sizing: border-box;">
                                            <div
                                                style="box-sizing: border-box; font-family:arial,helvetica,sans-serif; font-size: 12px; color: #858585; text-align: center; line-height: 20px;">
                                                <p style="box-sizing: border-box;">
                                                    © 2015 ТОВАРИСТВО З ОБМЕЖЕНОЮ ВІДПОВІДАЛЬНІСТЮ — ТОРГОВО-ВИРОБНИЧИЙ ДІМ
                                                    "РІВС"</p>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr height="20" style="box-sizing: border-box;">
                                        <td width="100%%" height="20" style="box-sizing: border-box; line-height: 1px; font-size: 1px;">
                                            &nbsp;</td>
                                    </tr>
                                    <tr style="box-sizing: border-box;">
                                        <td width="100%%" height="20" align="center"
                                            style="box-sizing: border-box; font-family:arial,helvetica,sans-serif; font-size: 12px; color: #858585; text-align: center; line-height: 20px;">
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </body>
            </html>',
            penny_price_to_normal_price($total_cart_price)
        );

        if ($stmt = $mysqli->prepare("DELETE FROM `cart_items` WHERE UserID=?")) {
            $stmt->bind_param("i", $userID);
            if ($stmt->execute() == false) {
            };
            $stmt->close();
        }

        //variables to decrypt
        $hashedpassword = "cFfcdgW4MT5vYyeiieg01AG9FiwyxtHsbYcztJO+rj8F";
        $tag = "7BI92KFxt2uNzjjzXseKvw==";
        $iv = "2hB/dnRnfqhQdvFK";

        // decode variables
        $iv = base64_decode($iv);
        $tag = base64_decode($tag);

        // decrypting password
        $password = openssl_decrypt($hashedpassword, $cipher, $key, $options = 0, $iv, $tag);

        $mail2 = new PHPMailer;
        $mail2->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail2->CharSet = 'UTF-8';

        // SMTP options
        $mail2->isSMTP();
        $mail2->SMTPDebug = 0;

        $mail2->Host = 'smtp.gmail.com';
        $mail2->Port = 587;
        $mail2->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail2->SMTPAuth = true;
        $mail2->Username = $from_email;
        $mail2->Password = $password;

        // From who
        $mail2->setFrom($from_email, 'rivs.com.ua');

        // To who
        $mail2->addAddress($email, $first_name);

        // Mail subject
        $mail2->Subject = 'From: rivs.com.ua';
        $mail2->isHTML(true);
        // Mail message
        $mail2->Body = $email_body;

        // Mail sending
        if ($mail2->send()) {
        }

        // mail options
        $mail = new PHPMailer;
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->CharSet = 'UTF-8';

        // SMTP options
        $mail->isSMTP();
        $mail->SMTPDebug = 0;

        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->SMTPAuth = true;
        $mail->Username = $from_email;
        $mail->Password = $password;

        // From who
        $mail->setFrom($from_email, 'rivs.com.ua');

        // To who
        $mail->addAddress($from_email, 'rivs.com.ua');

        if ($stmt = $mysqli->prepare("SELECT Email FROM spam_emails")) {
            $stmt->execute();
            $stmt->bind_result($spam_email);
            while ($stmt->fetch()) {
                $mail->addCC($spam_email, 'admin rivs.com.ua');
            }
            $stmt->close();
        }

        // Mail subject
        $mail->Subject = 'From: rivs.com.ua';
        $mail->isHTML(true);
        // Mail message
        $mail->Body = $email_body;

        // Mail sending
        if ($mail->send()) {
        }

        $mysqli->close();
        //sending success code
        $response->success = true;

        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit();
    }

    $response->success = false;
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit();
} else {
    if ($verification_token == null || $verification_token1 == null) {
        $response->success = false;
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit();
    }

    if (!filter_var($email2, FILTER_VALIDATE_EMAIL)) {
        $response->success = false;
        array_push($response->email, "Недійсна електронна адреса");
    }

    if (strlen($first_name) > 32) {
        $response->success = false;
        $response->first_name = "ім'я повинно бути довжиною меншою за 32 символи";
    }

    if (strlen($last_name) > 64) {
        $response->success = false;
        $response->last_name = "Прізвище повинно бути довжиною меншою за 64 символи";
    }

    if (strlen($middle_name) > 32) {
        $response->success = false;
        $response->middle_name = "ім'я по-батькові повинно бути довжиною меншою за 32 символи";
    }
    if (preg_match('/^(\+\d{3}\(\d{2}\)\d{3}[ -]\d{2}[ -]\d{2})|(\+\d{12})|(\+\d{3}\ \d{2}\ \d{3}\ \d{2}\ \d{2})$/m', $phone) != 1 && !is_null($phone)) {
        $response->success = false;
        $response->phone = 'Телефон повинен відповідати формату "+380123456789"';
    }

    if ($response->success == false) {
        $mysqli->close();
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit();
    }

    if (hash_equals($verification_token, $verification_token1)) {

        $mysqli = mysqli_connect("localhost", "chba7f54c7_LDLRIVS", "8e5cktmvx6", "chba7f54c7_LDLRIVS");
        if ($mysqli->connect_errno) {
            $response->success = false;
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
            exit();
        }
        $cart = $_COOKIE["cart"];

        if ($cart == null) {
            $mysqli->close();
            $response->success = false;
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
            exit();
        }

        $orderID = 1;

        if ($stmt = $mysqli->prepare("INSERT INTO `orders_in_process` (`Email`, `Date`) VALUES (?, ?)")) {
            $stmt->bind_param("ss", $email2, date('Y-m-d H:i:s', time()));
            if ($stmt->execute() == false) {
            };
            $orderID = $stmt->insert_id;
            $stmt->close();
        }

        $status = 1;
        if ($stmt = $mysqli->prepare("INSERT INTO `orders_statuses` (`OrderId`, `StatusId`, `Date`) VALUES (?, ?, ?)")) {
            $stmt->bind_param("iis", $orderID, $status, date('Y-m-d H:i:s', time()));
            if ($stmt->execute() == false) {
            };
            $stmt->close();
        }

        $email_body = sprintf(
            '<html lang="en" style="box-sizing: border-box;">
                <head>
                    <meta charset="utf-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                    <meta http-equiv="x-ua-compatible" content="ie=edge">
                </head>
                <body style="box-sizing: border-box;">
                    <table width="100%%" style="box-sizing: border-box; background-color: #f1f1f1; min-width: 700px;" bgcolor="#f1f1f1">
                        <tr height="50" style="box-sizing: border-box;">
                            <td width="100%%" height="50" style="box-sizing: border-box; line-height: 1px; font-size: 1px;">
                                &nbsp;</td>
                        </tr>
                        <tr style="box-sizing: border-box;">
                            <td valign="middle" align="center" style="box-sizing: border-box;">
                                <a style="box-sizing: border-box;">
                                    <img align="none" alt="rivs.com.ua" border="0" hspace="0"
                                        src="https://www.rivs.com.ua/Images/logo.png"
                                        style="box-sizing: border-box; max-width: 70px; height: auto; display: block; margin: 0px;"
                                        title="rivs.com.ua" vspace="0" width="70px">
                                </a>
                            </td>
                        </tr>
                        <tr style="box-sizing: border-box;">
                            <td align="center"
                                style="box-sizing: border-box; font-family:%1$sSegoe UI%1$s, sans-serif; font-size: 16px; color: #313131; line-height: 24px;">
                                &nbsp;</td>
                        </tr>
                        <tr style="box-sizing: border-box;">
                            <td align="center" style="box-sizing: border-box;">
                                &nbsp;</td>
                        </tr>
                        <tr style="box-sizing: border-box;">
                            <td align="center" style="box-sizing: border-box;">
                                <table width="700" border="0" cellpadding="0" cellspacing="0"
                                    style="box-sizing: border-box; min-width: 700px;">
                                    <tr style="box-sizing: border-box;">
                                        <td style="box-sizing: border-box;">
                                            <div
                                                style="box-sizing: border-box; font-family:arial,helvetica,sans-serif; font-size: 24px; color: #313131; text-align: center;">
                                                Дякуємо за замовлення в інтернет-магазині</div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr style="box-sizing: border-box;">
                            <td width="100%%" height="50" style="box-sizing: border-box; line-height: 1px; font-size: 1px;">
                                <div id="email_code"
                                    style="box-sizing: border-box; font-family:arial,helvetica,sans-serif; color: #313131; text-align: center; font-size: 32px; font-weight: 500;
                                     letter-spacing: 3px; line-height: 60px;">
                                    Rivs.com.ua
                                </div>
                            </td>
                        </tr>
                        <tr style="box-sizing: border-box;">
                            <td align="center" style="box-sizing: border-box;">
                                &nbsp;</td>
                        </tr>
                        <tr style="box-sizing: border-box;">
                            <td align="center" style="box-sizing: border-box;">
                                <table width="700" style="box-sizing: border-box; min-width: 700px; background-color: #ffffff;"
                                    bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0">
                                    <tr style="box-sizing: border-box;">
                                        <td align="center" style="box-sizing: border-box;">
                                            <table width="600" border="0" cellpadding="0" cellspacing="0"
                                                style="box-sizing: border-box; min-width: 600px;">
                                                <tr height="30" style="box-sizing: border-box;">
                                                    <td width="100%%" height="30"
                                                        style="box-sizing: border-box; line-height: 1px; font-size: 1px;">
                                                        &nbsp;</td>
                                                </tr>
                                                <tr style="box-sizing: border-box;">
                                                    <td align="center" 
                                                        style="box-sizing: border-box; font-family:%1$sSegoe UI%1$s, sans-serif; font-size: 16px; color: #313131; line-height: 24px;">
                                                        <div 
                                                            style="box-sizing: border-box; font-family:%1$sSegoe UI%1$s, sans-serif; font-size: 16px; color: #313131; line-height: 24px;">
                                                            Вітаємо %2$s,<br style="box-sizing: border-box;">
                                                            <br style="box-sizing: border-box;">
                                                            Ваше замовлення отримано і потрапило на обробку. Найближчим часом з Вами
                                                            зв%1$sяжеться співробітник компанії для підтвердження замовлення.</div>
                                                    </td>
                                                </tr>
                                                <tr height="20" style="box-sizing: border-box;">
                                                    <td width="100%%" height="20"
                                                        style="box-sizing: border-box; line-height: 1px; font-size: 1px;">
                                                        &nbsp;</td>
                                                </tr>
                                                <tr style="box-sizing: border-box;">
                                                    <td style="box-sizing: border-box;">
                                                        <div 
                                                            style="box-sizing: border-box; font-family:%1$sSegoe UI%1$s, sans-serif; font-size: 1rem; font-weight: 400; line-height: 1.5; 
                                                            display: -ms-flexbox; display: flex; -ms-flex-wrap: wrap; flex-wrap: wrap;
                                                            -ms-flex-pack: center; justify-content: center;">
                                                            <div 
                                                                style="box-sizing: border-box; position: relative; -ms-flex: 0 0 auto; flex: 0 0 auto; width: auto; max-width: 100%%;
                                                                padding-bottom: 1.5rem; margin: 0px; padding-right: 0px; padding-left: 0px;">
                                                                <div 
                                                                    style="box-sizing: border-box; font-weight: 500; line-height: 1.2; font-size: 1.25rem; padding: 8px 14px 8px 0px; margin-bottom: 0px;">
                                                                    Номер замовлення:
                                                                </div>
                                                            </div>
                                                            <div 
                                                                style="box-sizing: border-box; position: relative; -ms-flex: 0 0 auto; flex: 0 0 auto; width: auto; max-width: 100%%; padding-bottom: 1.5rem; 
                                                                margin: 0px; padding-right: 0px; padding-left: 0px;">
                                                                <div 
                                                                    style="box-sizing: border-box; font-weight: 500; line-height: 1.2; font-size: 1.25rem; background: #D3D3D3; padding: 8px 14px 8px 14px; 
                                                                    border-radius: .6rem; margin-bottom: 0px;">
                                                                    %3$s
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div 
                                                            style="box-sizing: border-box; font-family:%1$sSegoe UI%1$s, sans-serif; 
                                                            font-size: 1rem; font-weight: 400; line-height: 1.5; display: -ms-flexbox; display: flex; -ms-flex-wrap: wrap; flex-wrap: wrap;">
                                                            <div 
                                                                style="box-sizing: border-box; position: relative; width: 100%%; padding-right: 15px; padding-left: 0px; -ms-flex: 0 0 50%%; 
                                                                flex: 0 0 50%%; max-width: 50%%;">
                                                                <label for="checkout_email"
                                                                    style="box-sizing: border-box; display: inline-block; margin-bottom: .5rem;">Електронна
                                                                    адреса</label>
                                                                <input type="text" readonly="true" 
                                                                    id="checkout_email" value="%4$s"
                                                                    style="box-sizing: border-box; margin: 0px; font-family:inherit; overflow: visible; display: block; width: 100%%; 
                                                                    height: calc(1.5em + .75rem + 2px); padding: .375rem .75rem; font-size: 1rem; font-weight: 400; line-height: 1.5; 
                                                                    background-clip: padding-box; border: 1px solid #ced4da; border-radius: .25rem; transition: border-color .15s ease-in-out, 
                                                                    box-shadow .15s ease-in-out; background-color: #e9ecef; opacity: 1; color: #212529;">
                                                            </div>
                                                            <div 
                                                                style="box-sizing: border-box; position: relative; width: 100%%; padding-right: 0px; padding-left: 15px; -ms-flex: 0 0 50%%; 
                                                                flex: 0 0 50%%; max-width: 50%%;">
                                                                <label for="checkout_phone"
                                                                    style="box-sizing: border-box; display: inline-block; margin-bottom: .5rem;">Номер
                                                                    телефону</label>
                                                                <input type="text" readonly="true" 
                                                                    id="checkout_phone" value="%5$s"
                                                                    style="box-sizing: border-box; margin: 0px; font-family:inherit; overflow: visible; display: block; 
                                                                    width: 100%%; height: calc(1.5em + .75rem + 2px); padding: .375rem .75rem; font-size: 1rem; font-weight: 400; 
                                                                    line-height: 1.5; background-clip: padding-box; border: 1px solid #ced4da; border-radius: .25rem; 
                                                                    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out; background-color: #e9ecef; opacity: 1; color: #212529;">
                                                            </div>
                                                        </div>
                                                        <div 
                                                            style="box-sizing: border-box; font-family:%1$sSegoe UI%1$s, sans-serif; 
                                                            font-size: 1rem; font-weight: 400; line-height: 1.5; display: -ms-flexbox; display: flex; -ms-flex-wrap: wrap; flex-wrap: wrap;">
                                                            <div 
                                                                style="box-sizing: border-box; position: relative; width: 100%%; padding-right: 15px; padding-left: 0px; -ms-flex: 0 0 33.333333%%; 
                                                                flex: 0 0 33.333333%%; max-width: 33.333333%%;">
                                                                <label for="checkout_last_name"
                                                                    style="box-sizing: border-box; display: inline-block; margin-bottom: .5rem;">Прізвище</label>
                                                                <input type="text" readonly="true"
                                                                    id="checkout_last_name" value="%6$s"
                                                                    style="box-sizing: border-box; margin: 0px; font-family:inherit; overflow: visible; display: block; width: 100%%; 
                                                                    height: calc(1.5em + .75rem + 2px); padding: .375rem .75rem; font-size: 1rem; font-weight: 400; line-height: 1.5; 
                                                                    background-clip: padding-box; border: 1px solid #ced4da; border-radius: .25rem; 
                                                                    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out; background-color: #e9ecef; opacity: 1; color: #212529;">
                                                            </div>
                                                            <div
                                                                style="box-sizing: border-box; position: relative; width: 100%%; padding-right: 15px; padding-left: 15px; -ms-flex: 0 0 33.333333%%; 
                                                                flex: 0 0 33.333333%%; max-width: 33.333333%%;">
                                                                <label for="checkout_first_name"
                                                                    style="box-sizing: border-box; display: inline-block; margin-bottom: .5rem;">Ім%1$sя</label>
                                                                <input type="text" readonly="true" 
                                                                    id="checkout_first_name" value="%2$s"
                                                                    style="box-sizing: border-box; margin: 0px; font-family:inherit; overflow: visible; display: block; width: 100%%; 
                                                                    height: calc(1.5em + .75rem + 2px); padding: .375rem .75rem; font-size: 1rem; font-weight: 400; line-height: 1.5; 
                                                                    background-clip: padding-box; border: 1px solid #ced4da; border-radius: .25rem; 
                                                                    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out; background-color: #e9ecef; opacity: 1; color: #212529;">
                                                            </div>
                                                            <div 
                                                                style="box-sizing: border-box; position: relative; width: 100%%; padding-right: 0px; padding-left: 15px; -ms-flex: 0 0 33.333333%%; 
                                                                flex: 0 0 33.333333%%; max-width: 33.333333%%;">
                                                                <label for="checkout_middle_name"
                                                                    style="box-sizing: border-box; display: inline-block; margin-bottom: .5rem;">Ім%1$sя
                                                                    по-батькові</label>
                                                                <input type="text" readonly="true"
                                                                    id="checkout_middle_name" value="%7$s"
                                                                    style="box-sizing: border-box; margin: 0px; font-family:inherit; overflow: visible; display: block; width: 100%%; 
                                                                    height: calc(1.5em + .75rem + 2px); padding: .375rem .75rem; font-size: 1rem; font-weight: 400; line-height: 1.5; 
                                                                    background-clip: padding-box; border: 1px solid #ced4da; border-radius: .25rem; 
                                                                    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out; background-color: #e9ecef; opacity: 1; color: #212529;">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr height="15" style="box-sizing: border-box;">
                                                    <td width="100%%" height="15"
                                                        style="box-sizing: border-box; line-height: 1px; font-size: 1px;">
                                                        &nbsp;</td>
                                                </tr>
                                                <tr style="box-sizing: border-box;">
                                                    <td align="center" style="box-sizing: border-box;">
                                                        <div 
                                                            style="box-sizing: border-box; font-family:%1$sSegoe UI%1$s, sans-serif; 
                                                            font-size: 1rem; font-weight: 400; line-height: 1.5; width: 100%%;
                                                            margin-right: auto; margin-left: auto;">',
            "'",
            $first_name,
            sprintf("%06d", $orderID),
            $email2,
            $phone,
            $last_name,
            $middle_name
        );

        if ($stmt = $mysqli->prepare("INSERT INTO `customersnoreg` (`UserID`, `FirstName`, `MiddleName`, `LastName`,
         `Phone`, `Email`) VALUES (?, ?, ?, ?, ?)")) {
         $stmt->bind_param("issss", $userID, $first_name, $middle_name, $last_name, $phone, $email2);
         if ($stmt->execute()) {};
         $stmt->close();
       }

        $total_cart_price = 0;
        $cart_items = array();

        $cart = json_decode($cart, true);

        foreach ($cart as $value) {
            $my_pricelistID = $value["priceListID"];
            $count = (int) ($value["count"]);

            if ($stmt = $mysqli->prepare("SELECT `PriceListID`, ProductName, Price, `Image` FROM `pricelist` WHERE `PriceListID`=?")) {
                $stmt->bind_param("i", $my_pricelistID);
                $stmt->execute();
                $stmt->bind_result($pricelistID, $product_name, $price, $image);
                $stmt->fetch();
                if ($image != null) {
                    $total_item_price = ($count * $price);
                    $total_cart_price += $total_item_price;
                    $email_body .= sprintf(
                        '<div
                            style="box-sizing: border-box; position: relative; display: -ms-flexbox; display: flex; -ms-flex-direction: column; flex-direction: column; min-width: 0; 
                            word-wrap: break-word; background-color: #fff; background-clip: border-box; border: 1px solid rgba(0, 0, 0, .125); border-radius: .25rem; margin-bottom: 1rem;">
                            <div 
                                style="box-sizing: border-box; position: relative; width: 100%%; -ms-flex: 0 0 8.333333%%; flex: 0 0 8.333333%%; max-width: 8.333333%%; padding-top: 15px; padding-right: 15px; padding-left: 15px;">
                                <img src="https://www.rivs.com.ua/%1$s"
                                    style="box-sizing: border-box; display: block; max-height: 60px; max-width: 50px;"
                                    alt="">
                            </div>
                            <div
                                style="box-sizing: border-box; position: relative; width: 100%%; -ms-flex: 0 0 91.666667%%; flex: 0 0 91.666667%%; max-width: 91.666667%%;">
                                <div 
                                    style="box-sizing: border-box; width: 100%%; margin-right: auto; margin-left: auto; min-height: 95px; padding-right: 0px; padding-left: .25rem;">
                                    <div 
                                        style="box-sizing: border-box; display: -ms-flexbox; display: flex; -ms-flex-wrap: wrap; flex-wrap: wrap; min-height: 25%%;">
                                        <div 
                                            style="box-sizing: border-box; position: relative; width: 100%%; padding-right: 15px; padding-left: 15px; -ms-flex: 0 0 100%%; flex: 0 0 100%%; max-width: 100%%; 
                                            font-size: 20px;">%2$s</div>
                                    </div>
                                    <div
                                        style="box-sizing: border-box; display: -ms-flexbox; display: flex; -ms-flex-wrap: wrap; flex-wrap: wrap; height: 30px; 
                                        padding-top: .5rem;">
                                        <div
                                            style="box-sizing: border-box; position: relative; width: 100%%; padding-right: 15px; padding-left: 15px; -ms-flex: 0 0 41.666667%%; flex: 0 0 41.666667%%; 
                                            max-width: 41.666667%%;">
                                            <div
                                                style="box-sizing: border-box; font-weight: 500; line-height: 1.2; font-size: 1.25rem; float: left; padding: 8px 14px 8px 0px; margin-bottom: 0px;">
                                                Ціна:
                                            </div>
                                            <div
                                                style="box-sizing: border-box; font-weight: 500; line-height: 1.2; font-size: 1.25rem; background: #D3D3D3; padding: 8px 14px 8px 14px; float: left; 
                                                border-radius: .6rem; margin-bottom: 0px;">
                                                %3$s ₴</div>
                                        </div>
                                        <div
                                            style="box-sizing: border-box; position: relative; width: 100%%; padding-right: 15px; padding-left: 15px; -ms-flex: 0 0 25%%; flex: 0 0 25%%; max-width: 25%%;">
                                            <div
                                                style="box-sizing: border-box; font-weight: 500; line-height: 1.2; font-size: 1.25rem; float: left; padding: 8px 14px 8px 0px; margin-bottom: 0px;">
                                                %4$s шт.
                                            </div>
                                        </div>
                                        <div
                                            style="box-sizing: border-box; position: relative; width: 100%%; padding-right: 15px; padding-left: 15px; -ms-flex: 0 0 33.333333%%; 
                                            flex: 0 0 33.333333%%; max-width: 33.333333%%;">
                                            <div
                                                style="box-sizing: border-box; font-weight: 500; line-height: 1.2; font-size: 1.25rem; background: #D3D3D3; padding: 8px 14px 8px 14px; float: right; 
                                                border-radius: .6rem; margin-bottom: 0px;">
                                                %5$s ₴</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>',
                        $image,
                        $product_name,
                        penny_price_to_normal_price($price),
                        $count,
                        penny_price_to_normal_price($total_item_price)
                    );
                    $item = new stdClass();

                    $item->pricelistID = $pricelistID;
                    $item->count = $count;
                    $item->price = $price;

                    $cart_items[] = $item;
                }
                $stmt->close();
            }
        }

        foreach ($cart_items as $value) {
            if ($stmt = $mysqli->prepare("INSERT INTO `orders_items` (`OrderId`, `PriceListId`, `Count`, `Price`) VALUES (?, ?, ?, ?)")) {
                $stmt->bind_param("iiii", $orderID, $value->pricelistID, $value->count, $value->price);
                if ($stmt->execute() == false) {
                };
                $stmt->close();
            }
        }

        $email_body .= sprintf(
            '<div class="row"
                                                                style="box-sizing: border-box; display: -ms-flexbox; display: flex; -ms-flex-wrap: wrap; flex-wrap: wrap;">
                                                                <div
                                                                    style="box-sizing: border-box; position: relative; width: 100%%; padding-left: 15px; -ms-flex: 0 0 100%%; flex: 0 0 100%%; 
                                                                    max-width: 100%%; padding-right: 16px;">
                                                                    <div
                                                                        style="box-sizing: border-box; font-weight: 500; line-height: 1.2; font-size: 1.25rem; float: right; background: #D3D3D3; 
                                                                        padding: 8px 14px 8px 14px; border-radius: .6rem; margin-bottom: 0px;">
                                                                        %1$s ₴</div>
                                                                    <div
                                                                        style="box-sizing: border-box; font-weight: 500; line-height: 1.2; font-size: 1.25rem; float: right; 
                                                                        padding: 8px 14px 8px 14px; margin-bottom: 0px;">
                                                                        Разом:
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr style="box-sizing: border-box;">
                                                    <td align="center"
                                                        style="box-sizing: border-box; font-family:%1$sSegoe UI%1$s, sans-serif; font-size: 16px; color: #313131; line-height: 24px;">
                                                        <div
                                                            style="box-sizing: border-box; font-family:%1$sSegoe UI%1$s, sans-serif; font-size: 16px; color: #313131; line-height: 24px;">
                                                            <br style="box-sizing: border-box;">З повагою,<br
                                                                style="box-sizing: border-box;">
                                                            Команда Rivs.com.ua</div>
                                                    </td>
                                                </tr>
                                                <tr height="50" style="box-sizing: border-box;">
                                                    <td width="100%%" height="30"
                                                        style="box-sizing: border-box; line-height: 1px; font-size: 1px;">
                                                        &nbsp;</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr height="15" style="box-sizing: border-box;">
                            <td width="100%%" height="20" style="box-sizing: border-box; line-height: 1px; font-size: 1px;">
                                &nbsp;</td>
                        </tr>
                        <tr style="box-sizing: border-box;">
                            <td align="center" style="box-sizing: border-box;">
                                <table width="700" border="0" cellpadding="0" cellspacing="0"
                                    style="box-sizing: border-box; min-width: 700px;">
                                    <tr height="20" style="box-sizing: border-box;">
                                        <td width="100%%" height="20" style="box-sizing: border-box; line-height: 1px; font-size: 1px;">
                                            &nbsp;</td>
                                    </tr>
                                    <tr style="box-sizing: border-box;">
                                        <td align="center" style="box-sizing: border-box;">
                                            <div
                                                style="box-sizing: border-box; font-family:arial,helvetica,sans-serif; font-size: 12px; color: #858585; text-align: center; line-height: 20px;">
                                                <p style="box-sizing: border-box;">
                                                    © 2015 ТОВАРИСТВО З ОБМЕЖЕНОЮ ВІДПОВІДАЛЬНІСТЮ — ТОРГОВО-ВИРОБНИЧИЙ ДІМ
                                                    "РІВС"</p>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr height="20" style="box-sizing: border-box;">
                                        <td width="100%%" height="20" style="box-sizing: border-box; line-height: 1px; font-size: 1px;">
                                            &nbsp;</td>
                                    </tr>
                                    <tr style="box-sizing: border-box;">
                                        <td width="100%%" height="20" align="center"
                                            style="box-sizing: border-box; font-family:arial,helvetica,sans-serif; font-size: 12px; color: #858585; text-align: center; line-height: 20px;">
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </body>
            </html>',
            penny_price_to_normal_price($total_cart_price)
        );

        setcookie('cart', null, time() - 60 * 60, '/', 'rivs.com.ua', true, true);
        $cipher = "aes-256-gcm";
        $key = base64_decode(file_get_contents('../../../../key.txt'));
        $hashedpassword = "cFfcdgW4MT5vYyeiieg01AG9FiwyxtHsbYcztJO+rj8F";
        $tag = "7BI92KFxt2uNzjjzXseKvw==";
        $iv = "2hB/dnRnfqhQdvFK";

        // decode variables
        $iv = base64_decode($iv);
        $tag = base64_decode($tag);

        // decrypting password
        $password = openssl_decrypt($hashedpassword, $cipher, $key, $options = 0, $iv, $tag);


        $mail2 = new PHPMailer;
        $mail2->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail2->CharSet = 'UTF-8';

        // SMTP options
        $mail2->isSMTP();
        $mail2->SMTPDebug = 0;

        $mail2->Host = 'smtp.gmail.com';
        $mail2->Port = 587;
        $mail2->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail2->SMTPAuth = true;
        $mail2->Username = $from_email;
        $mail2->Password = $password;

        // From who
        $mail2->setFrom($from_email, 'rivs.com.ua');

        // To who
        $mail2->addAddress($email2, $first_name);

        // Mail subject
        $mail2->Subject = 'From: rivs.com.ua';
        $mail2->isHTML(true);
        // Mail message
        $mail2->Body = $email_body;

        // Mail sending
        if ($mail2->send()) {
        }

        // mail options
        $mail = new PHPMailer;
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->CharSet = 'UTF-8';

        // SMTP options
        $mail->isSMTP();
        $mail->SMTPDebug = 0;

        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->SMTPAuth = true;
        $mail->Username = $from_email;
        $mail->Password = $password;

        // From who
        $mail->setFrom($from_email, 'rivs.com.ua');

        // To who
        $mail->addAddress($from_email, 'rivs.com.ua');

        if ($stmt = $mysqli->prepare("SELECT Email FROM spam_emails")) {
            $stmt->execute();
            $stmt->bind_result($spam_email);
            while ($stmt->fetch()) {
                $mail->addCC($spam_email, 'admin rivs.com.ua');
            }
            $stmt->close();
        }

        // Mail subject
        $mail->Subject = 'From: rivs.com.ua';
        $mail->isHTML(true);
        // Mail message
        $mail->Body = $email_body;

        // Mail sending
        if ($mail->send()) {
        }

        $mysqli->close();
        //sending success code
        $response->success = true;

        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit();
    }
}

$response->success = false;
echo json_encode($response, JSON_UNESCAPED_UNICODE);
exit();
