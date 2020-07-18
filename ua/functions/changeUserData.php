<?php
require_once("../../LDLRIVS.php");

// give data from session and post
my_session_start();
$email = $_SESSION['email'];
$verification_token = $_POST['verification_token'];
$verification_token1 = $_SESSION['verification_token'];
$security_token = $_SESSION["security_token"];
$security_token1 = $_COOKIE["security_token"];
$first_name = $_POST["first_name"];
$middle_name = $_POST["middle_name"];
$last_name = $_POST["last_name"];
$phone = $_POST["phone"];

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
$mysqli = mysqli_connect("localhost", "AuthorizedUser", "pWNqyljrhML90CHc", "rivs");
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

if (hash_equals($verification_token, $verification_token1) && hash_equals($security_token, $security_token1)) {

  //starting autentificacion
  $cipher = "aes-256-gcm";

  //read key from file 
  $myfile = fopen("../../key.txt", "r");
  $key = base64_decode(fread($myfile, filesize("../../key.txt")));
  fclose($myfile);


  my_session_regenerate_id_with_prefix($email);

  //starting saving data
  $_SESSION['email'] = $email;
  $_SESSION['verification_token'] = $verification_token;

  $new_key = $key . md5($email, true);
  $ivlen = openssl_cipher_iv_length($cipher);

  if ($stmt = $mysqli->prepare("SELECT UserID FROM passwords WHERE UserLogin=?")) {
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($userID);
    $stmt->fetch();
    $stmt->close();
  }
  if ($userID != null) {
    if (!is_null($first_name)) {
      $first_name_iv = openssl_random_pseudo_bytes($ivlen);
      $first_name_encrypted = openssl_encrypt($first_name, $cipher, $new_key, $options = 0, $first_name_iv, $first_name_tag);
      if ($stmt = $mysqli->prepare("UPDATE `customers` SET `FirstName`=?, `FirstNameNonce`=?, `FirstNameTag`=? WHERE `UserID`=?")) {
        $stmt->bind_param("sssi", $first_name_encrypted, base64_encode($first_name_iv), base64_encode($first_name_tag), $userID);
        if ($stmt->execute() == false) {
        };
        $stmt->close();
      }
    }

    if (!is_null($middle_name)) {
      $middle_name_iv = openssl_random_pseudo_bytes($ivlen);
      $middle_name_encrypted = openssl_encrypt($middle_name, $cipher, $new_key, $options = 0, $middle_name_iv, $middle_name_tag);
      if ($stmt = $mysqli->prepare("UPDATE `customers` SET `MiddleName`=?, `MiddleNameNonce`=?, `MiddleNameTag`=? WHERE `UserID`=?")) {
        $stmt->bind_param("sssi", $middle_name_encrypted, base64_encode($middle_name_iv), base64_encode($middle_name_tag), $userID);
        if ($stmt->execute() == false) {
        };
        $stmt->close();
      }
    }

    if (!is_null($last_name)) {
      $last_name_iv = openssl_random_pseudo_bytes($ivlen);
      $last_name_encrypted = openssl_encrypt($last_name, $cipher, $new_key, $options = 0, $last_name_iv, $last_name_tag);
      if ($stmt = $mysqli->prepare("UPDATE `customers` SET `LastName`=?, `LastNameNonce`=?, `LastNameTag`=? WHERE `UserID`=?")) {
        $stmt->bind_param("sssi", $last_name_encrypted, base64_encode($last_name_iv), base64_encode($last_name_tag), $userID);
        if ($stmt->execute() == false) {
        };
        $stmt->close();
      }
    }

    if (!is_null($phone)) {
      $phone_iv = openssl_random_pseudo_bytes($ivlen);
      $phone_encrypted = openssl_encrypt($phone, $cipher, $new_key, $options = 0, $phone_iv, $phone_tag);
      if ($stmt = $mysqli->prepare("UPDATE `customers` SET `Phone`=?, `PhoneNonce`=?, `PhoneTag`=? WHERE `UserID`=?")) {
        $stmt->bind_param("sssi", $phone_encrypted, base64_encode($phone_iv), base64_encode($phone_tag), $userID);
        if ($stmt->execute() == false) {
        };
        $stmt->close();
      }
    }
  }

  $mysqli->close();

  $security_token = base64_encode(openssl_random_pseudo_bytes(32));
  $_SESSION["security_token"] = $security_token;
  setcookie('security_token', $security_token, time() + 60 * 60 * 24 * 30, '/', 'rivs.com.ua', false, true);
  setcookie('security_token', $security_token, time() + 60 * 60 * 24 * 30, '/', '25.142.71.242', false, true);

  //sending success code
  $response->success = true;

  echo json_encode($response, JSON_UNESCAPED_UNICODE);
  exit();
}
