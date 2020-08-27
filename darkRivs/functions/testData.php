<?php
require_once("../../LDLRIVS.php");
require_once("mainFunctions.php");

$mysqli = mysqli_connect("localhost", "chba7f54c7_LDLRIVS", "8e5cktmvx6", "chba7f54c7_LDLRIVS");
if ($mysqli->connect_errno) {
    exit();
}

$emails = array("55valentine99@gmail.com", "leonid.drapei@gmail.com", "55coursework99@gmail.com", "example@gmail.com", "JohnSmith@gmail.com", "SteveJobs@apple.com");
$statuses = array(1, 2, 3, 4, 5);

$result = $mysqli->query('SELECT `PriceListID`, `Price` FROM `pricelist` WHERE `Price` != 0');
$products = $result->fetch_all();


for ($i = 1; $i < 50; $i++) {
    $product = null;
    $canceled = rand(1, 5);
    $status = rand(1, 5);
    $count = rand(1, 5);
    for ($j = 1; $j <= $count; $j++) {
        $product[] = $products[rand(0, count($products) - 1)];
    }
    $email = $emails[rand(0, count($emails) - 1)];

    $orderID = 1;

    if ($stmt = $mysqli->prepare("INSERT INTO `orders_in_process` (`Email`, `Date`) VALUES (?, ?)")) {
        $stmt->bind_param("ss", $email, date('Y-m-d H:i:s', time()));
        if ($stmt->execute() == false) {
        };
        $orderID = $stmt->insert_id;
        $stmt->close();
    }

    if ($stmt2 = $mysqli->prepare("INSERT INTO `orders_statuses` (`OrderId`, `StatusId`, `Date`) VALUES (?, ?, ?)")) {
        for ($k = 1; $k < $status; $k++) {
            $stmt2->bind_param("iis", $orderID, $k, date('Y-m-d H:i:s', (time() - (360 * ($status - $k)))));
            if ($stmt2->execute() == false) {
            };
        }
        if ($canceled == 5) {
            $t = 6;
            $stmt2->bind_param("iis", $orderID, $t, date('Y-m-d H:i:s', time()));
            if ($stmt2->execute() == false) {
            };
        } else {
            $stmt2->bind_param("iis", $orderID, $status, date('Y-m-d H:i:s', time()));
            if ($stmt2->execute() == false) {
            };
        }

        $stmt2->close();
    }
    if ($stmt3 = $mysqli->prepare("INSERT INTO `orders_items` (`OrderId`, `PriceListId`, `Count`, `Price`) VALUES (?, ?, ?, ?)")) {
        foreach ($product as $value) {

            $stmt3->bind_param("iiid", $orderID, $value[0], rand(1, 100), $value[1]);
            if ($stmt3->execute() == false) {
            };
        }
        $stmt3->close();
    }
}
$mysqli->close();