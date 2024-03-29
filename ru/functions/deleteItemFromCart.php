<?php
require_once("../../LDLRIVS.php");

// give data from session and post
my_session_start();
$email = $_SESSION['email'];
$pricelistID = $_POST['pricelistID'];
$verification_token = $_POST['verification_token'];
$verification_token1 = $_SESSION['verification_token'];
$security_token = $_SESSION["security_token"];
$security_token1 = $_COOKIE["security_token"];

//variables for response
$response = new stdClass();
$response->success = true;

//checking verification and security tokens
if ($verification_token == null || $verification_token1 == null) {
  $response->success = false;
  echo json_encode($response, JSON_UNESCAPED_UNICODE);
  exit();
}

if (hash_equals($verification_token, $verification_token1)) {

  $is_authorized = false;
  if ($security_token == null || $security_token1 == null || !isset($_SESSION["email"])) {
    $is_authorized = false;
  } else if (hash_equals($security_token, $security_token1) && isset($_SESSION["email"])) {
    $is_authorized = true;
  }

  if ($is_authorized) {

    $mysqli = mysqli_connect("localhost", "chba7f54c7_LDLRIVS", "8e5cktmvx6", "chba7f54c7_LDLRIVS");
    if ($mysqli->connect_errno) {
      $response->success = false;
      echo json_encode($response, JSON_UNESCAPED_UNICODE);
      exit();
    }

    if ($stmt = $mysqli->prepare("SELECT UserID FROM passwords WHERE UserLogin=?")) {
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $stmt->bind_result($userID);
      $stmt->fetch();
      $stmt->close();
    }
    if ($userID == null) {
      $mysqli->close();
      $response->success = false;
      echo json_encode($response, JSON_UNESCAPED_UNICODE);
      exit();
    }
    if ($stmt = $mysqli->prepare("SELECT `PriceListID` FROM cart_items WHERE UserID=? AND PriceListID=?")) {
      $stmt->bind_param("ii", $userID, $pricelistID);
      $stmt->execute();
      $stmt->bind_result($db_pricelistID);
      $stmt->fetch();
      $stmt->close();
    }

    if ($db_pricelistID == null) {
      $mysqli->close();
      $response->success = false;
      echo json_encode($response, JSON_UNESCAPED_UNICODE);
      exit();
    }

    if ($stmt = $mysqli->prepare("DELETE FROM cart_items WHERE UserID=? AND PriceListID=?")) {
      $stmt->bind_param("ii", $userID, $pricelistID);
      if ($stmt->execute() == false) {
      };
      $stmt->close();
    }

    $mysqli->close();
    //sending success code
    $response->success = true;
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit();
  } else {

    $mysqli = mysqli_connect("localhost", "chba7f54c7_LDLRIVS", "8e5cktmvx6", "chba7f54c7_LDLRIVS");
    if ($mysqli->connect_errno) {
      $response->success = false;
      echo json_encode($response, JSON_UNESCAPED_UNICODE);
      exit();
    }
    if ($stmt = $mysqli->prepare("SELECT `PriceListID` FROM `pricelistru` WHERE PriceListID=?")) {
      $stmt->bind_param("i", $pricelistID);
      $stmt->execute();
      $stmt->bind_result($db_pricelistID);
      $stmt->fetch();
      $stmt->close();
    }

    $mysqli->close();

    if ($db_pricelistID == null) {
      $response->success = false;
      echo json_encode($response, JSON_UNESCAPED_UNICODE);
      exit();
    }

    $cart = $_COOKIE["cart"];
    if ($cart == null) {
      $response->success = false;
      echo json_encode($response, JSON_UNESCAPED_UNICODE);
      exit();
    }

    $cart = json_decode($cart, true);

    $is_in_cart = false;
    foreach ($cart as $key => $value) {
      if ($value["priceListID"] == $pricelistID) {
        $is_in_cart = true;
        unset($cart[$key]);
      }
    }

    if ($is_in_cart == false) {
      $response->success = false;
      echo json_encode($response, JSON_UNESCAPED_UNICODE);
      exit();
    }
    if (count($cart) == 0) {
      $cart = null;
    } else {
      $cart = json_encode(array_values($cart));
    }

    setcookie('cart', $cart, time() + 60 * 60 * 24 * 90, '/', 'rivs.com.ua', true, true);

    $response->success = true;
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit();
  }
}

$response->success = false;
echo json_encode($response, JSON_UNESCAPED_UNICODE);
exit();
