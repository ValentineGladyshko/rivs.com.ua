<?php
require_once("LDLRIVS.php");
?>
<!--DOCTYPE html-->
<html lang="en">

<head>
  <link rel="alternate" hreflang="uk" href="/store.php" />
  <link rel="shortcut icon" href="/Images/webicon.png" type="image/x-icon">
  <title>
    ТОВ ТВД "РІВС" | Магазин
  </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <!-- Font Awesome -->
  <? include("scripts.php"); ?>
  <link href="main.css" rel="stylesheet">

</head>

<body>
<? include("header.php"); ?>

  <!--Main Navigation-->

  <!--Main layout-->
  <main class="mt-5 mb-5">

    <!--Main container-->
    <div class="container">

      <!--Grid row-->
      <div class="row">
        <h1 class="text-center">ГУАНПОЛІСЕПТ ВИПРАВЛЯЄ ТЕ, ЩО СПИРТОВІ АНТИСЕПТИКИ НАКОЇЛИ З ВАШИМИ РУКАМИ</h1>
        <? $CARDS = query_db('SELECT * FROM pricelist ORDER BY ProductAvailability DESC'); ?>
        <? foreach ($CARDS as $CARD) { ?>
          <!--Grid column-->
          <div class="col-lg-4 col-md-6 mb-md-3 mb-3">

            <!--Card-->
            <? if ($CARD['Image'] != NULL) { ?>
              <div class="card" style="height:100%;">

                <!--Card image-->
                <div class="view overlay zoom">
                  <img class="img-fluid mx-auto" src="<?= $CARD['Image'] ? $CARD['Image'] : 'Store_photos/default.jpg'; ?>" style="max-height: 400px; padding:20px" alt="">
                  <a href="product?id=<?= $CARD['PriceListID']; ?>">
                    <div class="mask rgba-white-slight"></div>
                  </a>
                </div>
                <!--Card content-->
                <div class="card-body text-center">
                  <!--Title-->
                  <h5 class="card-title"><?= $CARD['ProductName']; ?></h5>
                  <? if ($CARD['Price'] != 0) { ?>
                    <b class="text-center" style="margin: auto; margin-bottom:1.5rem; width: 8rem;">Ціна – <?= $CARD['Price']; ?> грн.</b>
                  <? } ?>
                </div>
                <a href="product?id=<?= $CARD['PriceListID']; ?>" class="btn btn-bottom-outline-info-dark-green rounded" style="margin: auto; margin-bottom:1.5rem;">Детальніше</a>
                <? if ($CARD['ProductAvailability'] == 0) { ?>
                  <a href="product?id=<?= $CARD['PriceListID']; ?>" class="text-center bd-highlight" style="margin: auto; margin-bottom:1.5rem; width: 8rem;">Немає тари</a>
                <? } ?>
              <? } ?>
              </div>
              <!--/.Card-->

          </div>
          <!--Grid column-->
        <? } ?>

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

<? include("myScripts.php"); ?>

  <script type="text/javascript">
    var elem = document.getElementById("store");
    elem.classList.add('active');
  </script>

</html>