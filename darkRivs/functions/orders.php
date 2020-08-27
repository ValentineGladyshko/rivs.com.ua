<?php
require_once("../../LDLRIVS.php");
require_once("mainFunctions.php");

my_session_start();
$type = $_POST['type'];
$verification_token = $_POST['verification_token'];
$verification_token1 = $_SESSION['verification_token'];
$security_token = $_SESSION["security_admin_token"];
$security_token1 = $_COOKIE["security_admin_token"];

if ($verification_token == null || $verification_token1 == null || $security_token == null || $security_token1 == null || !isset($_SESSION["email"])) {
    exit();
}
if (hash_equals($verification_token, $verification_token1) && hash_equals($security_token, $security_token1) && isset($_SESSION["email"])) {
    $mysqli = mysqli_connect("localhost", "chba7f54c7_LDLRIVS", "8e5cktmvx6", "chba7f54c7_LDLRIVS");
    if ($mysqli->connect_errno) {
        exit();
    }

    $orders = array();
    if ($type == 'finished') {
        if ($stmt = $mysqli->prepare("SELECT DISTINCT `o`.`OrderId`, `o`.`Email`, `o`.`Date` FROM `orders_in_process` AS `o` 
        JOIN `orders_statuses` AS `os` ON `o`.`OrderId` = `os`.`OrderId` WHERE `os`.`StatusId` BETWEEN 5 AND 6 ORDER BY `Date` DESC")) {
            $stmt->execute();
            $stmt->bind_result(
                $orderId,
                $email,
                $date
            );
            while ($stmt->fetch()) {
                $order = new stdClass();
                $order->orderId = $orderId;
                $date = new DateTime($date);
                $order->date = $date->format('d/m/Y H:i');
                $order->email = $email;
                $order->totalPrice = 0;
                $orders[] = $order;
            }
            $stmt->close();
        }
    } else if ($type == 'active') {
        if ($stmt = $mysqli->prepare("SELECT * FROM `orders_in_process` WHERE `OrderId` NOT IN 
        (SELECT DISTINCT `o`.`OrderId` FROM `orders_in_process` AS `o` 
        JOIN `orders_statuses` AS `os` ON `o`.`OrderId` = `os`.`OrderId` WHERE `os`.`StatusId` BETWEEN 5 AND 6) ORDER BY `Date` DESC")) {
            $stmt->execute();
            $stmt->bind_result(
                $orderId,
                $email,
                $date
            );
            while ($stmt->fetch()) {
                $order = new stdClass();
                $order->orderId = $orderId;
                $date = new DateTime($date);
                $order->date = $date->format('d/m/Y H:i');
                $order->email = $email;
                $order->totalPrice = 0;
                $orders[] = $order;
            }
            $stmt->close();
        }
    } else {
        if ($stmt = $mysqli->prepare("SELECT `OrderId`, `Email`, `Date` FROM `orders_in_process` ORDER BY `Date` DESC")) {
            $stmt->execute();
            $stmt->bind_result(
                $orderId,
                $email,
                $date
            );
            while ($stmt->fetch()) {
                $order = new stdClass();
                $order->orderId = $orderId;
                $date = new DateTime($date);
                $order->date = $date->format('d/m/Y H:i');
                $order->email = $email;
                $order->totalPrice = 0;
                $orders[] = $order;
            }
            $stmt->close();
        }
    }
    if ($stmt = $mysqli->prepare("SELECT `orders_items`.`PriceListID`, `Count`, `orders_items`.`Price`, `ProductName`, `Image`
                FROM `orders_items` JOIN `pricelist` ON `orders_items`.`PriceListID` = `pricelist`.`PriceListID` WHERE `OrderId` = ?")) {

        foreach ($orders as &$order) {
            $totalPrice = 0;
            $orderId = $order->orderId;

            $stmt->bind_param("i", $orderId);
            $stmt->execute();
            $stmt->bind_result(
                $priceListID,
                $count,
                $price,
                $productName,
                $image
            );
            while ($stmt->fetch()) {

                $item = new stdClass();

                $item->priceListID = $priceListID;
                $item->count = $count;
                $item->price = penny_price_to_normal_price($price);
                $item->productName = $productName;
                $item->image = $image;
                $totalPrice += $price * $count;
                $item->totalPrice = penny_price_to_normal_price($price * $count);

                $order->items[] = $item;
            }
            $order->totalPrice = penny_price_to_normal_price($totalPrice);
        }
        $stmt->close();
    }

    if ($stmt = $mysqli->prepare("SELECT `orders_statuses`.`StatusId`, `statuses`.`StatusName`, `orders_statuses`.`Date` 
        FROM `orders_statuses` JOIN `statuses` ON `orders_statuses`.`StatusId` = `statuses`.`StatusId` 
        WHERE `orders_statuses`.`OrderId` = ? ORDER BY `orders_statuses`.`Date` DESC")) {
        foreach ($orders as &$order) {
            $orderId = $order->orderId;
            $order->orderId = sprintf("%06d", $orderId);
            $stmt->bind_param("i", $orderId);
            $stmt->execute();
            $stmt->bind_result(
                $statusId,
                $statusName,
                $date
            );
            $statuses = null;
            while ($stmt->fetch()) {
                $item = new stdClass();
                $item->statusId = $statusId;
                $item->statusName = $statusName;
                $date = new DateTime($date);
                $item->time = $date->format('H:i');

                $statuses[$date->format('d/m/Y')][] = $item;

                if ($order->status == null) {
                    $order->status = //sprintf('<div class="badge %1$s badge-pill">%2$s</div>', badge_status_color($statusId), $statusName);
                        sprintf('<div class=%3$s %1$s %3$s>%2$s</div>', text_status_color($statusId), $statusName, "'");
                    $order->buttons = sprintf(
                        '<button class="btn btn-datatable btn-icon btn-transparent-dark mr-2" id="dropdownMenuButton" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical">
                                <circle cx="12" cy="5" r="1"></circle>
                                <circle cx="12" cy="12" r="1"></circle>    
                                <circle cx="12" cy="19" r="1"></circle>
                            </svg>
                        </button>
                        <div class="dropdown-menu dropdown-menu-left animated--fade-in-up" aria-labelledby="dropdownMenuButton" style="position: absolute; transform: translate3d(-118px, 42px, 0px); top: 0px; left: 0px; will-change: transform;" x-placement="bottom-end">
                            <h6 class="dropdown-header">Наступний статус:</h6>
                            <button type="button" onclick="changeOrderStatus(`%3$s`,`%4$s`,`%5$s`)" class="dropdown-item"><div class="badge %1$s badge-pill my-1">%2$s</div></button>
                            <button type="button" onclick="changeOrderStatus(`%3$s`,`6`,`%5$s`)" class="dropdown-item"><div class="badge badge-danger-soft text-danger badge-pill my-1">Відмінено</div></button>
                        </div>',
                        badge_soft_status_color($statusId + 1),
                        status_text_by_id($statusId + 1),
                        $orderId,
                        $statusId + 1,
                        $verification_token
                    );
                }
            }
            $order_statuses  = "";
            foreach ($statuses as $statusDate => $statusValue) {
                $order_statuses .= sprintf(
                    '<div class=%2$scol-12%2$s>
                            <hr class=%2$ssolid mt-1 mb-1%2$s>
                            <div>%1$s</div>
                            <hr class=%2$ssolid mt-1 mb-1%2$s>
                        </div>',
                    $statusDate,
                    "'"
                );

                foreach ($statusValue as $status) {
                    $order_statuses .= sprintf(
                        '<div class=%4$scol-3%4$s>
                                <div>%1$s</div>
                            </div>
                            <div class=%4$scol-9%4$s>
                                <div class=%4$s%2$s%4$s>%3$s</div>
                            </div>',
                        $status->time,
                        text_status_color($status->statusId),
                        $status->statusName,
                        "'"
                    );
                }
            };
            $order->statuses = sprintf(
                '<button id="status_button_%1$s" onclick="chevronToggle(document.getElementById(`status_img_%1$s`), 
                document.getElementById(`status_button_%1$s`))" class="btn btn-link p-0 chevron-down float-sm-right" 
                style="font-size:14px" type="button" data-toggle="popover" title="Історія замовлення" data-html="true" 
                data-placement="bottom" data-content="<div class=%2$srow%2$s>%3$s</div>">
                Історія
                <img id="status_img_%1$s" height="14" src="/icons/chevron-down.svg">
            </button>',
                sprintf("%06d", $order->orderId),
                "'",
                $order_statuses
            );
        }
        $stmt->close();
    }
    echo json_encode($orders, JSON_UNESCAPED_UNICODE);
    //file_put_contents("data.json", json_encode($orders, JSON_UNESCAPED_UNICODE));
}
