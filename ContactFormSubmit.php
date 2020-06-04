<?php
require_once("PHPMailer/Exception.php");
require_once("PHPMailer/OAuth.php");
require_once("PHPMailer/PHPMailer.php");
require_once("PHPMailer/POP3.php");
require_once("PHPMailer/SMTP.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$response = new stdClass();
$response->success = true;

$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];
$from_email = '55coursework99@gmail.com';

if ($name == null) {
    $response->success = false;
    $response->name = 'Поле "Ваше ім`я" не може бути пустим!';
}

if ($email == null) {
    $response->success = false;
    $response->email = 'Поле "Ваш email" не може бути пустим!';
} else {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response->success = false;
        $response->email = 'Email введено некоректно.';
    }
}

if ($message == null) {
    $response->success = false;
    $response->message = 'Поле "Введіть повідомлення" не може бути пустим!';
}

if ($response->success == false) {
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit();
}
$cipher = "aes-256-gcm";
$myfile = fopen("key.txt", "r");
$key = base64_decode(fread($myfile, filesize("key.txt")));
fclose($myfile);

$hashedpassword = "i6/Qv5L9B7Hd";
$iv= "RucZWE5OFpqG0UlE";
$tag = "OUZcLNNGYuiakaNdQgRyDw==";

$iv = base64_decode($iv);
$tag = base64_decode($tag);

$password = openssl_decrypt($hashedpassword, $cipher, $key, $options = 0, $iv, $tag);

$mail = new PHPMailer;
$mail->SMTPDebug = SMTP::DEBUG_SERVER;
$mail->CharSet = 'UTF-8';
 
// Настройки SMTP
$mail->isSMTP();
$mail->SMTPDebug = 0;
 
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->SMTPAuth = true;
$mail->Username = $from_email;
$mail->Password = $password;
 
// От кого
$mail->setFrom($from_email, $name);		
 
// Кому
$mail->addAddress($from_email, 'Site');
 
// Тема письма
$mail->Subject = 'From: rivs.com.ua';
 
// Тело письма
$mail->Body = "From: $name \nEmail: $email \nMessage: $message";
 
$mail->send();
$response->success = true;
$response->send = 'Повідомлення успішно відправлено!';
echo json_encode($response, JSON_UNESCAPED_UNICODE);
exit();

//$content = "From: $name \nEmail: $email \nMessage: $message";
//$recipient = "sales@rivs.com.ua";
//$mailheader = "From: $email \r\n";
//if (!mail($recipient, $content, $mailheader)) {
//    $response->success = false;
    //$response->send = 'Повідомлення успішно не відправлено!';
 //   echo json_encode($response, JSON_UNESCAPED_UNICODE);
 //   exit();
//}
//$response->success = true;
//$response->send = 'Повідомлення успішно відправлено!';
//echo json_encode($response, JSON_UNESCAPED_UNICODE);
//exit();
