<?php
require_once("../LDLRIVS.php");
require_once("functions/mainFunctions.php");

my_session_start();

$verification_token = base64_encode(openssl_random_pseudo_bytes(32));
$_SESSION['verification_token'] = $verification_token;
?>
<!--DOCTYPE html-->
<html lang="en">

<head>

  <link rel="shortcut icon" href="/Images/webicon.png" type="image/x-icon">
  <title>
    ТОВ ТВД "РІВС" | Продукція
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
        , `Contraindications`, `Warnings`, `StorageConditions`, `ExpirationDate`, `Manufacturer`, `Info`, `ProductAvailability`, `ImageHQ` FROM `pricelist` 
        LEFT JOIN `productdescription` ON `pricelist`.`ProductDescriptionID` = `productdescription`.`ProductDescriptionID` WHERE PriceListID = ?', $_GET['id'], $verification_token); ?>
      </div>

    </div>
    <!--Main container-->

  </main>
  <!--Main layout-->

  <!-- Footer -->
  <footer class="page-footer font-small bottom bg-dark accent-4 mt-4">

    <!-- Copyright -->
    <div class="footer-copyright text-center py-3">© 2015 ТОВАРИСТВО З ОБМЕЖЕНОЮ ВІДПОВІДАЛЬНІСТЮ — ТОРГОВО-ВИРОБНИЧИЙ ДІМ "РІВС"
    </div>
    <!-- Copyright -->

  </footer>
  <!-- Footer -->

</body>

<? include("myScripts.php"); ?>

<script type="text/javascript">
  var elem = document.getElementById("store");
  elem.classList.add('active');
  var ru_link = document.getElementById("ru_link");
  ru_link.href = "/ru/product.php?id=<?= $_GET['id'] ?>";
  var ua_link = document.getElementById("ua_link");
  ua_link.href = "/ua/product.php?id=<?= $_GET['id'] ?>";
</script>

</html>