<?php
require_once("../LDLRIVS.php");
require_once("functions/mainFunctions.php");

my_session_start();

$verification_token = base64_encode(openssl_random_pseudo_bytes(32));
$_SESSION['verification_token'] = $verification_token;
$security_token = $_SESSION["security_admin_token"];
$security_token1 = $_COOKIE["security_admin_token"];

if ($security_token == null || $security_token1 == null) {
    include("../scripts.php");
    echo "<script>$(document).ready(function() { $.redirect('login.php'); });</script>";
    exit();
}

if (hash_equals($security_token, $security_token1)) {
    $orderId = $_GET['id'];
    $order = new stdClass();

    $mysqli = mysqli_connect("localhost", "chba7f54c7_LDLRIVS", "8e5cktmvx6", "chba7f54c7_LDLRIVS");
    if ($mysqli->connect_errno) {
        echo "<script>$(document).ready(function() { $.redirect('login.php'); });</script>";
        exit();
    }
    $key = base64_decode(file_get_contents('../../../key.txt'));
    $cipher = "aes-256-gcm";
?>
    <? include("functions/header.php"); ?>

    <? if ($stmt = $mysqli->prepare("SELECT DISTINCT `o`.`Email`, `o`.`Date`, `c`.`FirstName`, `c`.`FirstNameNonce`, `c`.`FirstNameTag`,
                `c`.`MiddleName`, `c`.`MiddleNameNonce`, `c`.`MiddleNameTag`, `c`.`LastName`, `c`.`LastNameNonce`, `c`.`LastNameTag`,
                `c`.`Phone`, `c`.`PhoneNonce`, `c`.`PhoneTag` FROM `orders_in_process` AS `o` 
                JOIN `customers` AS `c` ON `o`.`Email` = `c`.`Email` WHERE `o`.`OrderId` = ?")) {
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $stmt->bind_result(
            $email,
            $date,
            $first_name_encrypted,
            $first_name_iv,
            $first_name_tag,
            $middle_name_encrypted,
            $middle_name_iv,
            $middle_name_tag,
            $last_name_encrypted,
            $last_name_iv,
            $last_name_tag,
            $phone_encrypted,
            $phone_iv,
            $phone_tag,
        );
        $stmt->fetch();

        $order->orderId = sprintf("%06d", $orderId);
        $date = new DateTime($date);
        $order->date = $date->format('d/m/Y H:i');
        $order->email = $email;

        $iv = base64_decode($first_name_iv);
        $tag = base64_decode($first_name_tag);
        $first_name = openssl_decrypt($first_name_encrypted, $cipher, $key, $options = 0, $iv, $tag);

        $iv = base64_decode($middle_name_iv);
        $tag = base64_decode($middle_name_tag);
        $middle_name = openssl_decrypt($middle_name_encrypted, $cipher, $key, $options = 0, $iv, $tag);

        $iv = base64_decode($last_name_iv);
        $tag = base64_decode($last_name_tag);
        $last_name = openssl_decrypt($last_name_encrypted, $cipher, $key, $options = 0, $iv, $tag);

        $order->name = $last_name . " " . $first_name . " " . $middle_name;

        $iv = base64_decode($phone_iv);
        $tag = base64_decode($phone_tag);
        $order->phone = openssl_decrypt($phone_encrypted, $cipher, $key, $options = 0, $iv, $tag);

        $order->totalPrice = 0;

        $stmt->close();
    }

    if ($stmt = $mysqli->prepare("SELECT `orders_items`.`PriceListID`, `Count`, `orders_items`.`Price`, `ProductName`, `Image`
                FROM `orders_items` JOIN `pricelist` ON `orders_items`.`PriceListID` = `pricelist`.`PriceListID` WHERE `OrderId` = ?")) {

        $stmt->bind_param("i", $orderId);
        $stmt->execute();

        $stmt->bind_result(
            $priceListID,
            $count,
            $price,
            $productName,
            $image
        );
        $order->products = "";
        while ($stmt->fetch()) {
            $order->totalPrice += $price * $count;

            $order->products .= sprintf('<div class="card mb-sm-1 mb-1 shadow-none">
            <div class="card-body row">
                <div class="col-lg-2 col-sm-2 px-0">
                    <a href="../ua/product.php?id=%1$d">
                        <img src="../%2$s" class="m-auto" style="display: block; max-height: 120px; max-width: 100px;" alt="">
                    </a>
                </div>
                <div class="col-lg-10 col-sm-10 pl-sm-0 pl-lg-2">
                    <div class="container px-0" style="min-height:60px">
                        <div class="row product-name-sm">
                            <div class="col-sm-12">
                                <a style="font-size:20px;" href="../ua/product.php?id=%1$d">%3$s</a>
                            </div>
                        </div>
                        <div class="row align-items-center order-sm mt-sm-2 mt-xl-0" style="min-height: 40px;">
                            <div class="pr-0 col-xl-8 col-lg-7 col-md-6 col-sm-5">
                                <div class="h5 mb-0 py-2 pl-0 pr-3 float-left">Ціна:</div>
                                <div class="rounded-xl h5 mb-0 py-2 float-left">%4$s</div>
                            </div>
                            <div class="px-sm-0 col-lg-2 col-sm-2">
                                <div class="h5 mb-0 float-left py-2 pl-1 pr-0">%5$d шт.</div>
                            </div>
                            <div class="pl-sm-0 col-xl-2 col-lg-3 col-md-4 col-sm-5">
                                <div class="rounded-xl h5 mb-0 float-sm-right float-left py-2">%6$s</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>', $priceListID, $image, $productName, penny_price_to_normal_price($price), $count, penny_price_to_normal_price($price * $count));
        }
        $order->totalPrice = penny_price_to_normal_price($order->totalPrice);
        $stmt->close();
    }

    if ($stmt = $mysqli->prepare("SELECT `orders_statuses`.`StatusId`, `statuses`.`StatusName`, `orders_statuses`.`Date` 
                FROM `orders_statuses` JOIN `statuses` ON `orders_statuses`.`StatusId` = `statuses`.`StatusId` 
                WHERE `orders_statuses`.`OrderId` = ? ORDER BY `orders_statuses`.`Date` DESC")) {

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
                $order->status = sprintf('<div class=%3$s %1$s %3$s>%2$s</div>', text_status_color($statusId), $statusName, "'");

                if ($statusId != 5 && $statusId != 6) {
                    $order->buttons = sprintf(
                        '<div class="col-lg-8"><button type="button" onclick="changeOrderStatus(`%3$s`,`%4$s`,`%5$s`)" class="dropdown-item p-0"><div class="badge %1$s badge-pill my-1" style="font-size: 1rem;">%2$s</div></button>
                    <button type="button" onclick="changeOrderStatus(`%3$s`,`6`,`%5$s`)" class="dropdown-item p-0"><div class="badge badge-danger-soft text-danger badge-pill my-1" style="font-size: 1rem;">Відмінено</div></button></div>',
                        badge_soft_status_color($statusId + 1),
                        status_text_by_id($statusId + 1),
                        $orderId,
                        $statusId + 1,
                        $verification_token
                    );
                } else {
                    $order->buttons = '<div class="col-lg-8">Статус не можна змінити</div>';
                }
            }

            $order->statuses = "";
            foreach ($statuses as $statusDate => $statusValue) {
                $order->statuses .= sprintf(
                    '<div class=%2$scol-12%2$s>
                            <hr class=%2$ssolid mt-1 mb-1%2$s>
                            <div>%1$s</div>
                            <hr class=%2$ssolid mt-1 mb-1%2$s>
                        </div>',
                    $statusDate,
                    "'"
                );

                foreach ($statusValue as $status) {
                    $order->statuses .= sprintf(
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
        }
    }
    $stmt->close();

    ?>
    <div class="card mb-4">
        <div class="card-header">Замовлення №<? echo $order->orderId; ?></div>
        <div class="card-body row">
            <div class="col-lg-4 row">
                <div class="col-lg-4">Електронна адреса:</div>
                <div class="col-lg-8"><? echo $order->email; ?></div>
                <div class="col-lg-12 py-2"></div>
                <div class="col-lg-4">Телефон:</div>
                <div class="col-lg-8"><? echo $order->phone; ?></div>
                <div class="col-lg-12 py-2"></div>
                <div class="col-lg-4">ПІБ:</div>
                <div class="col-lg-8"><? echo $order->name; ?></div>
                <div class="col-lg-12 py-2"></div>
                <div class="col-lg-4">Дата прийняття:</div>
                <div class="col-lg-8"><? echo $order->date; ?></div>
                <div class="col-lg-12 py-2"></div>
                <div class="col-lg-4">Загальна сума:</div>
                <div class="col-lg-8"><? echo $order->totalPrice; ?></div>
                <div class="col-lg-12 py-2"></div>
                <div class="col-lg-4">Поточний статус:</div>
                <div class="col-lg-8"><? echo $order->status; ?></div>
                <div class="col-lg-12 py-2"></div>
                <div class="col-lg-4">Змінити статус:</div>
                <? echo $order->buttons; ?>
                <div class="col-lg-12 py-2"></div>
                <div class="card shadow-none ml-3">
                    <div class="card-header text-dark">Історія статусів</div>
                    <div class="card-body row">
                        <? echo $order->statuses; ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <? echo $order->products; ?>
            </div>
        </div>
    </div>
    <? include("functions/footer.php"); ?>
    <? include("functions/myScripts.php"); ?>
    <script>
        function changeOrderStatus(orderId, statusId, verificationToken) {
            formData = {
                'verification_token': verificationToken,
                'orderId': orderId,
                'statusId': statusId
            };
            $.ajax({
                type: "POST",
                url: "functions/changeOrderStatus.php",
                data: formData,
                success: function(response) {
                    if (response != null) {

                        // parse response from server
                        var jsonData = JSON.parse(response);
                        if (jsonData.success == true) {
                            document.location.reload();
                        }
                    }
                },
                error: function(data) {
                    console.log('An error occurred.');
                    console.log(data);
                },
            });
        }
    </script>
<?php } else {
    include("../scripts.php");
    echo "<script>$(document).ready(function() { $.redirect('login.php'); });</script>";
    exit();
} ?>