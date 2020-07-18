<?php
require_once("../../LDLRIVS.php");

// give data from session and post
my_session_start();
$password = $_POST['password'];
$email = $_POST['email'];
$verification_token = $_POST['verification_token'];
$verification_token1 = $_SESSION['verification_token'];

//variables for response
$response = new stdClass();
$response->success = true;

//checking verification tokens
if ($verification_token == null || $verification_token1 == null) {
  $response->success = false;
  echo json_encode($response, JSON_UNESCAPED_UNICODE);
  exit();
}

//checking the existence of account
$mysqli = mysqli_connect("localhost", "RegisterUser", "E9aZc4DgpWEaRlY2", "rivs");
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
  $response->email = "Ця електронна адреса не зареєстрована";
  echo json_encode($response, JSON_UNESCAPED_UNICODE);
  exit();
}

if (hash_equals($verification_token, $verification_token1)) {

  //starting autentificacion
  $cipher = "aes-256-gcm";

  //read key from file 
  $myfile = fopen("../../key.txt", "r");
  $key = base64_decode(fread($myfile, filesize("../../key.txt")));
  fclose($myfile);

  //read from database data for autentificacion of current user
  if ($stmt = $mysqli->prepare("SELECT Nonce, Tag, HashedPassword FROM passwords WHERE UserLogin=?")) {
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($iv, $tag, $hashedpassword);
    $stmt->fetch();
    $stmt->close();
  }
  $mysqli->close();

  //preparing parameters for decrypting
  $iv = base64_decode($iv);
  $tag = base64_decode($tag);

  //decrypting hashed password
  $checkinghash = openssl_decrypt($hashedpassword, $cipher, $key, $options = 0, $iv, $tag);

  //verifing password
  $is_valid = password_verify(hash('sha512', $password), $checkinghash);
  if ($is_valid == 1) {

    my_session_regenerate_id_with_prefix($email);
    $_SESSION["email"] = $email;
    $_SESSION["verification_token"] = $verification_token;

    //generate security token for access to protected resources
    $security_token = base64_encode(openssl_random_pseudo_bytes(32));
    $_SESSION['security_token'] = $security_token;
    setcookie('security_token', $security_token, time() + 60 * 60 * 24 * 30, '/', 'rivs.com.ua', false, true);
    setcookie('security_token', $security_token, time() + 60 * 60 * 24 * 30, '/', '25.142.71.242', false, true);

    //sending success code
    $response->success = true;

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit();
  } else {

    //exiting with error
    $response->success = false;
    $response->password = "Невірний пароль";

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit();
  }
}
