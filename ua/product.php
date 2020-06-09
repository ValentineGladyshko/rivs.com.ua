<?php
require_once("../LDLRIVS.php");

my_session_start();

$verification_token = base64_encode(openssl_random_pseudo_bytes(32));
$_SESSION['verification_token'] = $verification_token;

$verification_token = base64_encode(openssl_random_pseudo_bytes(32));
$_SESSION['verification_token'] = $verification_token;
$PRODUCT = query_db('SELECT * FROM `pricelist` LEFT JOIN `productdescription` ON `pricelist`.`ProductDescriptionID` = `productdescription`.`ProductDescriptionID` WHERE PriceListID = ' . $_GET['id'])[0];

?>
<!--DOCTYPE html-->
<html lang="en">

<head>

  <link rel="shortcut icon" href="/Images/webicon.png" type="image/x-icon">
  <title>
    ТОВ ТВД "РІВС"
  </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <!-- Font Awesome -->
  <? include("../scripts.php"); ?>

</head>

<body style="overflow-y: overlay;">
  <? include("header.php"); ?>

  <!--Main Navigation-->

  <!--Main layout-->
  <main class="mt-5 mb-3">

    <!--Main container-->
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <div class="text-center">
            <img src="/<?= $PRODUCT['Image'] ? $PRODUCT['Image'] : 'Store_photos/default.jpg'; ?>" class="img-fluid center mx-auto" style="max-height: 500px;" alt="">
          </div>
          <div class="text-center" style="margin: auto; margin-bottom:1.5rem;">
            <p>Замовити можна по телефону</p>
            <p>
              <? if ($PRODUCT['Price'] != 0) { ?>
              <b>Ціна – <?= $PRODUCT['Price']; ?> грн.</b>
              <? } ?>

            </p>
          </div>
        </div>
        <div class="col-md-8">
          <h2 class="h1-responsive font-weight-bold text-center my-4"><?= $PRODUCT['ProductName']; ?></h2>
          <div class="text-justify w-responsive mx-auto mb-5">
            <? if ($PRODUCT['Appointment'] != NULL) { ?>
            <? } ?><?= $PRODUCT['Appointment']; ?></div>
          <div class="text-justify w-responsive mx-auto mb-5">
            <? if ($PRODUCT['Properties'] != NULL) { ?>
            <? } ?> <?= $PRODUCT['Properties']; ?></div>
          <div class="text-justify w-responsive mx-auto mb-5">
            <? if ($PRODUCT['Structure'] != NULL) { ?>
            <? } ?> <?= $PRODUCT['Structure']; ?></div>
          <div class="text-justify w-responsive mx-auto mb-5">
            <? if ($PRODUCT['ApplicationMethod'] != NULL) { ?>
            <? } ?> <?= $PRODUCT['ApplicationMethod']; ?></div>
          <div class="text-justify w-responsive mx-auto mb-5">
            <? if ($PRODUCT['Contraindications'] != NULL) { ?>
            <? } ?> <?= $PRODUCT['Contraindications']; ?></div>
          <div class="text-justify w-responsive mx-auto mb-5">
            <? if ($PRODUCT['Warnings'] != NULL) { ?>
            <? } ?> <?= $PRODUCT['Warnings']; ?></div>
          <div class="text-justify w-responsive mx-auto mb-5">
            <? if ($PRODUCT['StorageConditions'] != NULL) { ?>
            <? } ?> <?= $PRODUCT['StorageConditions']; ?></div>
          <div class="text-justify w-responsive mx-auto mb-5">
            <? if ($PRODUCT['ExpirationDate'] != NULL) { ?>
            <? } ?> <?= $PRODUCT['ExpirationDate']; ?></div>
          <div class="text-justify w-responsive mx-auto mb-5">
            <? if ($PRODUCT['Manufacturer'] != NULL) { ?>
            <? } ?> <?= $PRODUCT['Manufacturer']; ?></div>
          <div class="text-justify w-responsive mx-auto mb-5"><?= $PRODUCT['Info']; ?></div>
        </div>
      </div>

    </div>
    <!--Main container-->

  </main>
  <!--Main layout-->

  <!-- Footer -->
  <footer class="page-footer font-small bottom cyan accent-4 mt-4">

    <!-- Copyright -->
    <div class="footer-copyright text-center py-3">© 2015 - 2020 ТОВАРИСТВО З ОБМЕЖЕНОЮ ВІДПОВІДАЛЬНІСТЮ — ТОРГОВО-ВИРОБНИЧИЙ ДІМ "РІВС"
    </div>
    <!-- Copyright -->

  </footer>
  <!-- Footer -->

</body>

<? include("../myScripts.php"); ?>

<script type="text/javascript">
  var elem = document.getElementById("store");
  elem.classList.add('active');
  var ru_link = document.getElementById("ru_link");
  ru_link.href = "/ru/store.php";
  var ua_link = document.getElementById("ua_link");
  ua_link.href = "/ua/store.php";
</script>

</html>