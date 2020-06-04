<?php
require_once("PHPMailer/Exception.php");
require_once("PHPMailer/OAuth.php");
require_once("PHPMailer/PHPMailer.php");
require_once("PHPMailer/POP3.php");
require_once("PHPMailer/SMTP.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Response data for AJAX
$response = new stdClass();
$response->success = true;

// Getting data from post
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];
$from_email = 'rivsremailemail@gmail.com';

// Name checking
if ($name == null) {
    $response->success = false;
    $response->name = 'Поле "Ваше ім`я" не може бути пустим!';
}

// Email Checking
if ($email == null) {
    $response->success = false;
    $response->email = 'Поле "Ваш email" не може бути пустим!';
} else {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response->success = false;
        $response->email = 'Email введено некоректно.';
    }
}

// Message checking
if ($message == null) {
    $response->success = false;
    $response->message = 'Поле "Введіть повідомлення" не може бути пустим!';
}

// If something wrong go out
if ($response->success == false) {
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit();
}

// data for decrypting
$cipher = "aes-256-gcm";
$myfile = fopen("../../logs/key.php", "r");
$key = base64_decode(fread($myfile, filesize("../../logs/key.php")));
fclose($myfile);

// another data for decrypting
$hashedpassword = "sWNFIwGtS5G0jA==";
$iv= "BSZrfXmE1sBkoswl";
$tag = "28UmEDo+KdYlBF7PQtKNtw==";

$iv = base64_decode($iv);
$tag = base64_decode($tag);

// decrypting
$password = openssl_decrypt($hashedpassword, $cipher, $key, $options = 0, $iv, $tag);

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
$mail->setFrom($from_email, $name);		
 
// To who
$mail->addAddress($from_email, 'Site');
 
// Mail subject
$mail->Subject = 'From: rivs.com.ua';
 
// Mail message
$mail->Body = "From: $name \nEmail: $email \nMessage: $message";
 
// Mail sending
$mail->send();
$response->success = true;
$response->send = 'Повідомлення успішно відправлено!';
echo json_encode($response, JSON_UNESCAPED_UNICODE);
exit();