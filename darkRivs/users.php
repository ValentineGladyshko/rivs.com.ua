<?php
require_once("../LDLRIVS.php");

my_session_start();

$verification_token = base64_encode(openssl_random_pseudo_bytes(32));
$_SESSION['verification_token'] = $verification_token;
$security_token = $_SESSION["security_admin_token"];
$security_token1 = $_COOKIE["security_admin_token"];

//if ($security_token == null || $security_token1 == null) {
//    include("../scripts.php");
//   echo "<script>$(document).ready(function() { $.redirect('/index.php'); });</script>";
//   exit();
//}

//if (hash_equals($security_token, $security_token1)) {
if (true) {
?>
    <? include("functions/header.php"); ?>
    <? include("functions/footer.php"); ?>
    <? include("functions/myScripts.php"); ?>
    <script>
        var elem = document.getElementById("users-nav");
        elem.classList.add('active');
    </script>
<?php } else {
    include("../scripts.php");
    echo "<script>$(document).ready(function() { $.redirect('/index.php'); });</script>";
    exit();
} ?>