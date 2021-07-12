<?php
require_once("../../LDLRIVS.php");

my_session_start();

// give data from session and post
$password = $_POST["password"];
$email_code = $_POST["email_code"];
$email = $_POST["email"];
$first_name = $_POST["first_name"];
$middle_name = $_POST["middle_name"];
$last_name = $_POST["last_name"];
$phone = $_POST["phone"];
$verification_token = $_POST["verification_token"];
$verification_token1 = $_SESSION["verification_token"];

//variables for response
$response = new stdClass();
$response->success = true;

//checking verification tokens
if ($verification_token == null || $verification_token1 == null) {
  $response->success = false;
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

  // checking email secure code
  if ($stmt = $mysqli->prepare("SELECT EmailCode, ExpiredDate FROM register_email_codes WHERE Email=?")) {
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($email_code2, $expired_date);
    $stmt->fetch();
    $stmt->close();
  }
  if (strlen($first_name) > 32) {
    $response->success = false;
    $response->first_name = "Имя должно быть длиной менее 32 символов";
  }

  if (strlen($last_name) > 64) {
    $response->success = false;
    $response->last_name = "Фамилия должна быть длиной менее 64 символов";
  }

  if (strlen($middle_name) > 32) {
    $response->success = false;
    $response->middle_name = "Имя отчество должно быть длиной менее 32 символов";
  }
  if (preg_match('/^(\+\d{3}\(\d{2}\)\d{3}[ -]\d{2}[ -]\d{2})|(\+\d{12})|(\+\d{3}\ \d{2}\ \d{3}\ \d{2}\ \d{2})$/m', $phone) != 1) {
    $response->success = false;
    $response->phone = 'Телефон должен соответствовать формату "+380123456789"';
  }

  if ($expired_date == null || time() > strtotime($expired_date)) {
    $response->success = false;
    $response->expired = "Этот код подтверждения стал недействительным, пожалуйста нажмите кнопку для повторной отправки";
  } else if ($email_code != $email_code2 || $email_code == null) {
    $response->success = false;
    $response->email_code = "Этот код не совпадает с тем, что выслан на вашу почту";
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
  $_SESSION['verification_token'] = $verification_token;

  $cipher = "aes-256-gcm";

  //read key from file 
  $key = base64_decode(file_get_contents('../../../../key.txt'));

  //hashing password
  $hash = password_hash(hash('sha512', $password), PASSWORD_ARGON2ID);

  //variables for encryption
  $ivlen = openssl_cipher_iv_length($cipher);
  $iv = openssl_random_pseudo_bytes($ivlen);

  //encryption
  $hashedpassword = openssl_encrypt($hash, $cipher, $key, $options = 0, $iv, $tag);

  //write to database iv, tag, hashed password and other stuff
  if ($stmt = $mysqli->prepare("INSERT INTO passwords (UserLogin, HashedPassword, Nonce, Tag, `Version`, Compromised, Rotation) VALUES (?, ?, ?, ?, 1, 0, 0)")) {
    $stmt->bind_param("ssss", $email, $hashedpassword, base64_encode($iv), base64_encode($tag));
    if ($stmt->execute() == false) {
    };
    $userID = $stmt->insert_id;
    $stmt->close();
  }

  $new_key = $key . md5($email, true);
  $first_name_iv = openssl_random_pseudo_bytes($ivlen);
  $middle_name_iv = openssl_random_pseudo_bytes($ivlen);
  $last_name_iv = openssl_random_pseudo_bytes($ivlen);
  $phone_iv = openssl_random_pseudo_bytes($ivlen);

  $first_name_encrypted = openssl_encrypt($first_name, $cipher, $new_key, $options = 0, $first_name_iv, $first_name_tag);
  $middle_name_encrypted = openssl_encrypt($middle_name, $cipher, $new_key, $options = 0, $middle_name_iv, $middle_name_tag);
  $last_name_encrypted = openssl_encrypt($last_name, $cipher, $new_key, $options = 0, $last_name_iv, $last_name_tag);
  $phone_encrypted = openssl_encrypt($phone, $cipher, $new_key, $options = 0, $phone_iv, $phone_tag);

  if ($userID != null) {
    if ($stmt = $mysqli->prepare("INSERT INTO `customers` (`Email`, `FirstName`, `FirstNameNonce`,
     `FirstNameTag`, `MiddleName`, `MiddleNameNonce`, `MiddleNameTag`, `LastName`, `LastNameNonce`, `LastNameTag`,
      `Phone`, `PhoneNonce`, `PhoneTag`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")) {
      $stmt->bind_param(
        "sssssssssssss",
        $email,
        $first_name_encrypted,
        base64_encode($first_name_iv),
        base64_encode($first_name_tag),
        $middle_name_encrypted,
        base64_encode($middle_name_iv),
        base64_encode($middle_name_tag),
        $last_name_encrypted,
        base64_encode($last_name_iv),
        base64_encode($last_name_tag),
        $phone_encrypted,
        base64_encode($phone_iv),
        base64_encode($phone_tag),
      );
      if ($stmt->execute() == false) {
      };
      $stmt->close();
    }
  }

  //delete email_code
  if ($stmt = $mysqli->prepare("DELETE FROM register_email_codes WHERE Email=?")) {
    $stmt->bind_param("s", $email);
    if ($stmt->execute() == false) {
    };
    $stmt->close();
  }
  $mysqli->close();

  //generate security token for access to protected resources
  $security_token = base64_encode(openssl_random_pseudo_bytes(32));
  $_SESSION["security_token"] = $security_token;
  setcookie('security_token', $security_token, time() + 60 * 60 * 24 * 30, '/', 'rivs.com.ua', true, true);
}
$response->success = true;
echo json_encode($response, JSON_UNESCAPED_UNICODE);
exit();
