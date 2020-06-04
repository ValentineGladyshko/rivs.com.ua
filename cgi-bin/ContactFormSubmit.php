<?php

$response = new stdClass();
$response->success = true;

$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

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

$content = "From: $name \nEmail: $email \nMessage: $message";
$recipient = "rivsremailemail@gmail.com";
$mailheader = "From: $email \r\n";
if (!mail($recipient, $mailheader, $content)) {
    $response->success = false;
    //$response->send = 'Повідомлення успішно не відправлено!';
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit();
}
$response->success = true;
$response->send = 'Повідомлення успішно відправлено!';
echo json_encode($response, JSON_UNESCAPED_UNICODE);
exit();
