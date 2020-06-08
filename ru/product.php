<?
    require_once('LDLRIVS.php');
    $PRODUCT = query_db('SELECT * FROM `pricelist` WHERE PriceListID = ' . $_GET['id'])[0];
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
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
  <!-- Bootstrap core CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!-- Material Design Bootstrap -->
  <link href="css/mdb.min.css" rel="stylesheet">
  <!-- Your custom styles (optional) -->
  <link href="css/style.css" rel="stylesheet">
  <link href="style.css" rel="stylesheet">
  <link href="main.css" rel="stylesheet">
  
</head>
  <body style="overflow-y: overlay;">
      <header>
  <!--Navbar -->
  <nav class="mb-1 navbar sticky-top navbar-expand-lg navbar-light cyan accent-2 scrolling-navbar">
    <div class="container">
    <a class="navbar-brand" href="https://www.rivs.com.ua/">
        <img src="/Images/logo.png" width="30" height="40" alt="logo">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-333"
      aria-controls="navbarSupportedContent-333" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarSupportedContent-333">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="https://www.rivs.com.ua/rus">Главная
            <span class="sr-only">(current)</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="https://www.rivs.com.ua/ru/contacts">Контакты</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="https://www.rivs.com.ua/ru/store">Продукция</a>
        </li>
        </li>
      </ul>
      <ul class="navbar-nav navbar-right">
        <li class="nav-item">
        <i class="russia flag"></i>
        </li>
      <li class="nav-item">
          <!-- Button trigger modal -->
          <a class="nav-link" data-toggle="modal" data-target="#MobileModal">
            <i class="fas fa-phone"></i>Телефоны
          </a>
      </li>
      <li class="nav-item active disabled">
          <a class="nav-link" href="https://www.rivs.com.ua/ru/">RU
            <span class="sr-only">(current)</span>
          </a>
          <i class="russia flag"></i>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="https://www.rivs.com.ua/<?=$PRODUCT['ProductName'];?>">UA
            <span class="sr-only">(current)</span>
          </a>
        </li>
      </ul>
        </div>
  </div>
  </nav>
  <!-- Modal -->
  <div class="modal fade" id="MobileModal" tabindex="-1" role="dialog" aria-labelledby="MobileModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="MobileModalLabel">Наші телефони</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                <p class="text-justify">Консультації та замовлення за телефонами:</p>
                <p><a class="phone-ph" href="tel:+380660125020"><strong>+38(066)012-50-20</strong></a></p>
                <p><a class="phone-ph" href="tel:+380636491060"><strong>+38(063)649-10-60</strong></a></p>
                <p class="text-justify">Графік прийому замовлень:</p>
                <p class="text-justify">Будні: з 10:00 до 20:00</p>
                <p class="text-justify">Вихідні: з 11:00 до 19:00</p>
                </div>
                </div>
            </div>
          </div>
</header>

<!--Main Navigation-->

  <!--Main layout-->
  <main class="mt-5 mb-3">

      <!--Main container-->
      <div class="container">
        <div class="row">
            <div class="col-md-4">
            <img src="<?=$PRODUCT['Image'] ? $PRODUCT['Image'] : 'Store_photos/default.jpg';?>" 
                    class="img-fluid mx-auto"
                    alt="">
            </div>
            <div class="col-md-8">
            <h2 class="h1-responsive font-weight-bold text-center my-4"><?=$PRODUCT['ProductName'];?></h2>
              <p class="text-center w-responsive mx-auto mb-5"><?=$PRODUCT['Description'];?></p>
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

  <!-- SCRIPTS -->
  <!-- JQuery -->
  <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
  <!-- Bootstrap tooltips -->
  <script type="text/javascript" src="js/popper.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <!-- MDB core JavaScript -->
  <script type="text/javascript" src="js/mdb.min.js"></script>

</html>
