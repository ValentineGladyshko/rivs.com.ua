<?php
require_once("../../LDLRIVS.php");

my_session_start();

// give data from session and post
$password = $_POST["password"];
$repeat_password = $_POST["repeat_password"];
$email_code = $_POST["email_code"];
$email = $_POST["email"];
$verification_token = $_POST["verification_token"];
$verification_token1 = $_SESSION["verification_token"];

$password_length = 8;

//variables for response
$response = new stdClass();
$response->success = true;
$response->password = array();

//checking verification tokens
if ($verification_token == null || $verification_token1 == null) {
  $response->success = false;
  echo json_encode($response, JSON_UNESCAPED_UNICODE);
  exit();
}
if (hash_equals($verification_token, $verification_token1)) {
  $mysqli = mysqli_connect("localhost", "RegisterUser", "E9aZc4DgpWEaRlY2", "rivs");
  if ($mysqli->connect_errno) {
    $response->success = false;
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit();
  }

  //checking the length of password
  if (strlen($password) < $password_length) {
    $response->success = false;
    array_push($response->password, "Пароль повинен бути довжиною мінімум " . $password_length . " символів");
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
    $response->repeat_password = "Паролі не однакові";
  }

  // checking email secure code
  if ($stmt = $mysqli->prepare("SELECT EmailCode, ExpiredDate FROM remember_email_codes WHERE Email=?")) {
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($email_code2, $expired_date);
    $stmt->fetch();
    $stmt->close();
  }
  if ($email_code != $email_code2 || $email_code == null || $expired_date == null) {
    $response->success = false;
    $response->email_code = "Цей код не співпадає з тим що висланий на вашу пошту";
  }
  else if (time() > strtotime($expired_date)) {
    $response->success = false;
    $response->email_code = "Цей код підтвердження став недійсним";
  }
  
  //go out if we have any errors
  if ($response->success == false) {
    $mysqli->close();
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit();
  }

  my_session_regenerate_id_with_prefix($email);

  //starting saving data
  $_SESSION['email'] = $email;
  $_SESSION["verification_token"] = $verification_token;

  $cipher = "aes-256-gcm";

  //read key from file 
  $myfile = fopen("../../key.txt", "r");
  $key = base64_decode(fread($myfile, filesize("../../key.txt")));
  fclose($myfile);

  //hashing password
  $hash = password_hash(hash('sha512', $password), PASSWORD_ARGON2ID);

  //variables for encryption
  $ivlen = openssl_cipher_iv_length($cipher);
  $iv = openssl_random_pseudo_bytes($ivlen);

  //encryption
  $hashedpassword = openssl_encrypt($hash, $cipher, $key, $options = 0, $iv, $tag);

  //write to database iv, tag, hashed password and other stuff
  if ($stmt = $mysqli->prepare("UPDATE passwords SET HashedPassword=?, Nonce=?, Tag=? WHERE UserLogin=?")) {
    $stmt->bind_param("ssss", $hashedpassword, base64_encode($iv), base64_encode($tag), $email);
    if ($stmt->execute() == false) {
    };
    $stmt->close();
  }

  //delete email_code
  if ($stmt = $mysqli->prepare("DELETE FROM remember_email_codes WHERE Email=?")) {
    $stmt->bind_param("s", $email);
    if ($stmt->execute() == false) {
    };
    $stmt->close();
  }
  $mysqli->close();

  //generate security token for access to protected resources
  $security_token = base64_encode(openssl_random_pseudo_bytes(32));
  $_SESSION["security_token"] = $security_token;
  setcookie('security_token', $security_token, time() + 60 * 60 * 24 * 30, '/', 'rivs.com.ua', false, true);
  setcookie('security_token', $security_token, time() + 60 * 60 * 24 * 30, '/', '25.87.94.182', false, true);
}
$response->success = true;
echo json_encode($response, JSON_UNESCAPED_UNICODE);
exit();
