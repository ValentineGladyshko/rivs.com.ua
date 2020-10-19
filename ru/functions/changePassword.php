<?php
require_once("../../LDLRIVS.php");

// give data from session and post
my_session_start();
$password = $_POST['password'];
$new_password = $_POST['new_password'];
$repeat_password = $_POST['repeat_password'];
$email = $_SESSION['email'];
$verification_token = $_POST['verification_token'];
$verification_token1 = $_SESSION['verification_token'];
$security_token = $_SESSION["security_token"];
$security_token1 = $_COOKIE["security_token"];

$password_length = 8;

//variables for response
$response = new stdClass();
$response->success = true;
$response->new_password = array();

//checking verification and security tokens
if ($verification_token == null || $verification_token1 == null || $security_token == null || $security_token1 == null) {
  $response->success = false;
  echo json_encode($response, JSON_UNESCAPED_UNICODE);
  exit();
}

//checking the existence of account
$mysqli = mysqli_connect("localhost", "chba7f54c7_LDLRIVS", "8e5cktmvx6", "chba7f54c7_LDLRIVS");
if ($mysqli->connect_errno) {
  $response->success = false;
  echo json_encode($response, JSON_UNESCAPED_UNICODE);
  exit();
}

if ($stmt = $mysqli->prepare("SELECT UserLogin FROM passwords WHERE UserLogin=?")) {
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $stmt->bind_result($email2);
  $stmt->fetch();
  $stmt->close();
}

if ($email != $email2 || $email == null) {

  //exiting with error
  $mysqli->close();
  $response->success = false;
  echo json_encode($response, JSON_UNESCAPED_UNICODE);
  exit();
}

//checking the length of password
if (strlen($new_password) < $password_length) {
  $response->success = false;
  array_push($response->new_password, "Пароль должен быть длиной минимум " . $password_length . " символов");
}

//checking for common passwords
if ($stmt = $mysqli->prepare("SELECT `Password` FROM common_passwords WHERE password=?")) {
  $stmt->bind_param("s", strtolower($new_password));
  $stmt->execute();
  $stmt->bind_result($password2);
  $stmt->fetch();
  $stmt->close();
}
if (strtolower($new_password) == $password2) {
  $response->success = false;
  array_push($response->new_password, "Этот пароль относится к ненадежным");
}

//checking password and repeat password
if ($new_password != $repeat_password) {
  $response->success = false;
  $response->repeat_password = "Пароли не одинаковы";
}

if (hash_equals($verification_token, $verification_token1) && hash_equals($security_token, $security_token1)) {

  //starting autentificacion
  $cipher = "aes-256-gcm";

  //read key from file 
  $key = base64_decode(file_get_contents('../../../../key.txt'));

  //read from database data for autentificacion of current user
  if ($stmt = $mysqli->prepare("SELECT Nonce, Tag, HashedPassword FROM passwords WHERE UserLogin=?")) {
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($iv, $tag, $hashedpassword);
    $stmt->fetch();
    $stmt->close();
  }

  //preparing parameters for decrypting
  $iv = base64_decode($iv);
  $tag = base64_decode($tag);

  //decrypting hashed password
  $checkinghash = openssl_decrypt($hashedpassword, $cipher, $key, $options = 0, $iv, $tag);

  //verifing password
  $is_valid = password_verify(hash('sha512', $password), $checkinghash);
  if ($is_valid == false) {
    $response->success = false;
    $response->password = "Неверный пароль";
  }

  if ($response->success == false) {
    $mysqli->close();
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit();
  }
  my_session_regenerate_id_with_prefix($email);

  //starting saving data
  $_SESSION['email'] = $email;
  $_SESSION['verification_token'] = $verification_token;

  $new_hash = password_hash(hash('sha512', $new_password), PASSWORD_ARGON2ID);

  //variables for encryption
  $new_ivlen = openssl_cipher_iv_length($cipher);
  $new_iv = openssl_random_pseudo_bytes($new_ivlen);

  //encryption
  $new_hashedpassword = openssl_encrypt($new_hash, $cipher, $key, $options = 0, $new_iv, $new_tag);

  if ($stmt = $mysqli->prepare("UPDATE passwords SET HashedPassword=?, Nonce=?, Tag=? WHERE UserLogin=?")) {
    $stmt->bind_param("ssss", $new_hashedpassword, base64_encode($new_iv), base64_encode($new_tag), $email);
    if ($stmt->execute() == false) {
    };
    $stmt->close();
  }
  $mysqli->close();

  $security_token = base64_encode(openssl_random_pseudo_bytes(32));
  $_SESSION["security_token"] = $security_token;
  setcookie('security_token', $security_token, time() + 60 * 60 * 24 * 30, '/', 'rivs.com.ua', true, true);

  //sending success code
  $response->success = true;

  echo json_encode($response, JSON_UNESCAPED_UNICODE);
  exit();
}
