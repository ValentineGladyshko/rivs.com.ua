<?php
require_once("../../LDLRIVS.php");

// give data from session and post
my_session_start();
$email = $_SESSION['email'];
$pricelistID = $_POST['pricelistID'];
$count = $_POST['count'];
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

if ($security_token == null || $security_token1 == null) {
  $response->success = false;
  echo json_encode($response, JSON_UNESCAPED_UNICODE);
  exit();
}
if (hash_equals($verification_token, $verification_token1) && hash_equals($security_token, $security_token1)) {

  $mysqli = mysqli_connect("localhost", "AuthorizedUser", "pWNqyljrhML90CHc", "rivs");
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
  if ($db_pricelistID != null) {
    $response->success = false;
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit();
  }

  if ($count < 1) {
    $response->success = false;
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit();
  }

  if ($stmt = $mysqli->prepare("SELECT `ProductName` FROM `pricelist` WHERE PriceListID=?")) {
    $stmt->bind_param("i", $pricelistID);
    $stmt->execute();
    $stmt->bind_result($productName);
    $stmt->fetch();
    $stmt->close();
  }

  if ($stmt = $mysqli->prepare("INSERT INTO `cart_items` (`UserID`, `PriceListID`, `Count`) VALUES (?, ?, ?)")) {
    $stmt->bind_param("iii", $userID, $pricelistID, $count);
    if ($stmt->execute() == false) {
    };
    $stmt->close();
  }
  $mysqli->close();
  //sending success code
  $response->success = true;
  $response->itemName = $productName;
  echo json_encode($response, JSON_UNESCAPED_UNICODE);
  exit();
}

$response->success = false;
echo json_encode($response, JSON_UNESCAPED_UNICODE);
exit();
