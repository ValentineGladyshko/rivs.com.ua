<?php
require_once("../../LDLRIVS.php");
require_once("mainFunctions.php");

my_session_start();
$orderId = $_POST['orderId'];
$statusId = $_POST['statusId'];
$verification_token = $_POST['verification_token'];
$verification_token1 = $_SESSION['verification_token'];
$security_token = $_SESSION["security_admin_token"];
$security_token1 = $_COOKIE["security_admin_token"];

$response = new stdClass();
$response->success = true;

if ($verification_token == null || $verification_token1 == null || $security_token == null || $security_token1 == null || !isset($_SESSION["email"])) {
    $response->success = false;
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit();
}
if (hash_equals($verification_token, $verification_token1) && hash_equals($security_token, $security_token1) && isset($_SESSION["email"])) {
    $mysqli = mysqli_connect("localhost", "chba7f54c7_LDLRIVS", "8e5cktmvx6", "chba7f54c7_LDLRIVS");
    if ($mysqli->connect_errno) {
        $response->success = false;
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit();
    }

    if ($stmt = $mysqli->prepare("SELECT `OrderId` FROM `orders_in_process` WHERE `OrderId`=?")) {
        $stmt->bind_param("s", $orderId);
        $stmt->execute();
        $stmt->bind_result($newOrderId);
        $stmt->fetch();
        $stmt->close();
    }

    if ($newOrderId == null) {
        $mysqli->close();
        $response->success = false;
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit();
    }

    if ($stmt = $mysqli->prepare("SELECT `StatusId` FROM `orders_statuses` WHERE `OrderId` = ? AND `StatusId` = ?")) {
        $stmt->bind_param("ss", $orderId, $statusId);
        $stmt->execute();
        $stmt->bind_result($newStatusId);
        $stmt->fetch();
        $stmt->close();
    }

    if ($newStatusId !== null) {
        $mysqli->close();
        $response->success = false;
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit();
    }

    if ($stmt = $mysqli->prepare("INSERT INTO `orders_statuses` (`OrderId`, `StatusId`, `Date`) VALUES (?, ?, ?)")) {
        $stmt->bind_param("sss", $orderId, $statusId, date('Y-m-d H:i:s', time()));
        if ($stmt->execute() == false) {
        };
        $stmt->close();
    }
    $mysqli->close();
    $response->success = true;
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit();
}
