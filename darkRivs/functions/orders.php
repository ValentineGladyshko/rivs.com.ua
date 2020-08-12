<?php
require_once("../../LDLRIVS.php");
require_once("mainFunctions.php");

$mysqli = mysqli_connect("localhost", "AuthorizedUser", "pWNqyljrhML90CHc", "rivs");
if ($mysqli->connect_errno) {
    exit();
}

$orders = array();
if ($stmt = $mysqli->prepare("SELECT `OrderId`, `Email`, `Date` 
        FROM `orders_in_process` ORDER BY `Date` DESC")) {
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
        FROM `orders_in_process` JOIN `orders_statuses` ON `orders_in_process`.`OrderId` = `orders_statuses`.`OrderId` 
        JOIN `statuses` ON `orders_statuses`.`StatusId` = `statuses`.`StatusId` WHERE `orders_in_process`.`OrderId` = ? ORDER BY `orders_statuses`.`Date` DESC")) {
    foreach ($orders as  &$order) {
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
                $order->status = sprintf('<div class="badge %1$s badge-pill">%2$s</div>', badge_status_color($statusId), $statusName);
                //sprintf('<div class=%3$sh6 %1$s font-weight-normal%3$s>%2$s</div>', text_status_color($statusId), $statusName, "'");
            }
        }
        $order->buttons =
            '<button class="btn btn-datatable btn-icon btn-transparent-dark mr-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical">
                    <circle cx="12" cy="12" r="1"></circle>
                    <circle cx="12" cy="5" r="1"></circle>
                    <circle cx="12" cy="19" r="1"></circle>
                </svg>
            </button>
            <button class="btn btn-datatable btn-icon btn-transparent-dark">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    <line x1="10" y1="11" x2="10" y2="17"></line>
                    <line x1="14" y1="11" x2="14" y2="17"></line>
                </svg>
            </button>';
        $order_statuses  = "";
        foreach ($statuses as $statusDate => $statusValue) {
            $order_statuses .= sprintf(
                '<div class=%2$scol-12%2$s>
                            <hr class=%2$ssolid mt-2 mb-2%2$s>
                            <div class=%2$sh6%2$s>%1$s</div>
                            <hr class=%2$ssolid mt-0 mb-2%2$s>
                        </div>',
                $statusDate,
                "'"
            );

            foreach ($statusValue as $status) {
                $order_statuses .= sprintf(
                    '<div class=%4$scol-3%4$s>
                                <div class=%4$sh6 font-weight-normal%4$s>%1$s</div>
                            </div>
                            <div class=%4$scol-9%4$s>
                                <div class=%4$sh6 %2$s font-weight-normal%4$s>%3$s</div>
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
                document.getElementById(`status_button_%1$s`))" class="btn btn-link pl-0 chevron-down float-sm-right" 
                style="font-weight: 500;" type="button" data-toggle="popover" title="Історія замовлення" data-html="true" 
                data-placement="bottom" data-content="<div class=%2$srow%2$s>%3$s</div>">
                Історія
                <img id="status_img_%1$s" height="16" src="/icons/chevron-down.svg">
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