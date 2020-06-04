<?php
require_once("LDLRIVS.php");

my_session_start();
$verification_token = $_POST['verification_token'];
$verification_token1 = $_SESSION['verification_token'];
$security_token = $_SESSION["security_token"];
$security_token1 = $_COOKIE["security_token"];

if ($verification_token == null || $verification_token1 == null || $security_token == null || $security_token1 == null) {
  exit();
}
if (hash_equals($verification_token, $verification_token1)) { 
  if (hash_equals($security_token, $security_token1))
  {
    my_session_regenerate_id();
    setcookie('security_token', null, time() - 60 * 60, '/', 'rivs.com.ua', false, true);
    setcookie('security_token', null, time() - 60 * 60, '/', '25.142.71.242', false, true);
  } 
}
exit();
