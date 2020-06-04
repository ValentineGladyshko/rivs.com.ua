<?php
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];
header('Content-Type: application/json');
if ($name === ''){
  print json_encode(array('message' => 'Поле "Ваше ім`я" не може бути пустим!', 'code' => 0));
  exit();
}
if ($email === ''){
  print json_encode(array('message' => 'Поле "Ваш email" не може бути пустим!', 'code' => 0));
  exit();
} else {
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
  print json_encode(array('message' => 'Email введено некоректно.', 'code' => 0));
  exit();
  }
}

}
if ($message === ''){
  print json_encode(array('message' => 'Поле "Введіть повідомлення" не може бути пустим!', 'code' => 0));
  exit();
}

$content="From: $name \nEmail: $email \nMessage: $message";
$recipient = "rivs.com.ua@gmail.com";
$mailheader = "From: $email \r\n";
mail($recipient,$subject, $content, $mailheader) or die("Помилка!");
print json_encode(array('message' => 'Повідомлення успішно відправлено!', 'code' => 1));
exit();
?>