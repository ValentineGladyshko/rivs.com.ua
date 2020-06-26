<?php
require_once("../LDLRIVS.php");

my_session_start();

$verification_token = base64_encode(openssl_random_pseudo_bytes(32));
$_SESSION['verification_token'] = $verification_token;
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
  <? include("functions/header.php"); ?>

  <!--Main Navigation-->

  <!--Main layout-->
  <main class="mt-5 mb-3">

    <!--Main container-->
    <div class="container">
      <div class="row">
        <? echo product('SELECT `Image`, `Price`, `ProductName`, `Appointment`, `Properties`, `Structure`, `ApplicationMethod`
        , `Contraindications`, `Warnings`, `StorageConditions`, `ExpirationDate`, `Manufacturer`, `Info` FROM `pricelist` 
        LEFT JOIN `productdescription` ON `pricelist`.`ProductDescriptionID` = `productdescription`.`ProductDescriptionID` WHERE PriceListID = ?', $_GET['id']); ?>
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