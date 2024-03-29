<?php
require_once("../../PHPMailer/Exception.php");
require_once("../../PHPMailer/OAuth.php");
require_once("../../PHPMailer/PHPMailer.php");
require_once("../../PHPMailer/POP3.php");
require_once("../../PHPMailer/SMTP.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// create object for response
$response = new stdClass();
$response->success = true;

// give values from post request
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];
$from_email = 'rivs.com.ua@gmail.com';

// check validity of name
if ($name == null) {
    $response->success = false;
    $response->name = 'Поле "Ваше имя" не может быть пустым!';
}

// check validity of email
if ($email == null) {
    $response->success = false;
    $response->email = 'Поле "Ваш email" не может быть пустым!';
} else {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response->success = false;
        $response->email = 'Email введен некорректно.';
    }
}

// check validity of message
if ($message == null) {
    $response->success = false;
    $response->message = 'Поле "Введите сообщение" не может быть пустым!';
}


// if something wrong go out with error response
if ($response->success == false) {
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit();
}

// read key to decrypt password
$cipher = "aes-256-gcm";
$key = base64_decode(file_get_contents('../../../../key.txt'));

//variables to decrypt
$hashedpassword = "cFfcdgW4MT5vYyeiieg01AG9FiwyxtHsbYcztJO+rj8F";
$tag = "7BI92KFxt2uNzjjzXseKvw==";
$iv = "2hB/dnRnfqhQdvFK";

// decode variables
$iv = base64_decode($iv);
$tag = base64_decode($tag);

// decrypting password
$password = openssl_decrypt($hashedpassword, $cipher, $key, $options = 0, $iv, $tag);
// create object for email
$mail = new PHPMailer;
$mail->SMTPDebug = SMTP::DEBUG_SERVER;
$mail->CharSet = 'UTF-8';

// SMTP settings
$mail->isSMTP();
$mail->SMTPDebug = 0;

$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->SMTPAuth = true;
$mail->Username = $from_email;
$mail->Password = $password;

// from who
$mail->setFrom($from_email, $name);

// to who
$mail->addAddress($from_email, 'Site');

// mail subject
$mail->Subject = 'From: rivs.com.ua';

// mail body
$mail->Body = "From: $name \nEmail: $email \nMessage: $message";

// send email
$mail->send();

$response->success = true;
$response->send = 'Сообщение успешно отправлено!';
echo json_encode($response, JSON_UNESCAPED_UNICODE);
exit();
