<?php
require_once("../LDLRIVS.php");
require_once("../PHPMailer/Exception.php");
require_once("../PHPMailer/OAuth.php");
require_once("../PHPMailer/PHPMailer.php");
require_once("../PHPMailer/POP3.php");
require_once("../PHPMailer/SMTP.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

my_session_start();

// give data from session and post
$password = $_POST["password"];
$repeat_password = $_POST["repeat_password"];
$email = $_POST["email"];
$verification_token = $_POST["verification_token"];
$verification_token1 = $_SESSION["verification_token"];

$password_length = 8;

//variables for response
$response = new stdClass();
$response->success = true;
$response->password = array();
$response->email = array();
$response->repeat_password = array();

$from_email = '55coursework99@gmail.com';

//checking verification tokens
if ($verification_token == null || $verification_token1 == null) {
  $response->success = false;
  echo json_encode($response, JSON_UNESCAPED_UNICODE);
  exit();
}
if (hash_equals($verification_token, $verification_token1)) {
  $mysqli = mysqli_connect("localhost", "Noob", "noob", "webapp");
  if ($mysqli->connect_errno) {
    $response->success = false;
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit();
  }

  //validating email adress
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $response->success = false;
    array_push($response->email, "Невалідна електронна адреса");
  }

  //checking the length of password
  if (strlen($password) < $password_length) {
    $response->success = false;
    array_push($response->password, "Пароль повинен бути довжиною мінімум " . $password_length . " символів");
  }

  //checking the existence of account
  if ($stmt = $mysqli->prepare("SELECT UserLogin FROM passwords WHERE UserLogin=?")) {
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($email2);
    $stmt->fetch();
    $stmt->close();
  }
  if ($email == $email2) {
    $response->success = false;
    array_push($response->email, "Ця електронна адреса вже зареєстрована");
  }

  //checking for common passwords
  if ($stmt = $mysqli->prepare("SELECT `Password` FROM common_passwords WHERE password=?")) {
    $stmt->bind_param("s", strtolower($password));
    $stmt->execute();
    $stmt->bind_result($password2);
    $stmt->fetch();
    $stmt->close();
  }
  if (strtolower($password) == $password2) {
    $response->success = false;
    array_push($response->password, "Цей пароль належить до ненадійних");
  }

  //checking password and repeat password
  if ($password != $repeat_password) {
    $response->success = false;
    array_push($response->repeat_password, "Паролі не однакові");
  }

  //go out if we have any errors
  if ($response->success == false) {
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit();
  }

  my_session_regenerate_id_with_prefix($email);

  //saving data to session
  $_SESSION['email'] = $email;
  $_SESSION["verification_token"] = $verification_token;

  //generating security code
  $email_code = 0;
  while (true) {
    $ert = openssl_random_pseudo_bytes(4);
    $array = unpack("I", $ert);
    if ($array[1] < 4000000000) {
      $email_code = $array[1] % 1000000;
      break;
    }
  }
  $email_code = sprintf("%06d", $email_code);

  // write to db security code
  if ($stmt = $mysqli->prepare("INSERT INTO email_codes (Email, EmailCode, ExpiredDate) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE EmailCode = ?, ExpiredDate = ?")) {
    $stmt->bind_param("sssss", $email, $email_code, date('Y-m-d H:i:s', (time() + 60 * 30)), $email_code, date('Y-m-d H:i:s', (time() + 60 * 30)));
    if ($stmt->execute() == false) {
      $rt = false;
    };
    $stmt->close();
  }
  $mysqli->close();

  // read key to decrypt password
  $cipher = "aes-256-gcm";
  $myfile = fopen("../key.txt", "r");
  $key = base64_decode(fread($myfile, filesize("../key.txt")));
  fclose($myfile);

  //variables to decrypt
  $hashedpassword = "i6/Qv5L9B7Hd";
  $iv = "RucZWE5OFpqG0UlE";
  $tag = "OUZcLNNGYuiakaNdQgRyDw==";

  // decode variables
  $iv = base64_decode($iv);
  $tag = base64_decode($tag);

  // decrypting password
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
  $mail->setFrom($from_email, 'rivs.com.ua');

  // To who
  $mail->addAddress($email, $email);

  // Mail subject
  $mail->Subject = 'From: rivs.com.ua';
  $mail->isHTML(true);
  // Mail message
  $mail->Body = file_get_contents("emailConfirmation1.html") . $email_code . file_get_contents("emailConfirmation2.html") . $email_code . file_get_contents("emailConfirmation3.html");

  // Mail sending
  if ($mail->send()) {
  }

  $response->success = true;
  echo json_encode($response, JSON_UNESCAPED_UNICODE);
  exit();
}
