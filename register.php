<?php
require_once("LDLRIVS.php");

my_session_start();
?>
<!--DOCTYPE html-->
<html lang="en">

<head>

  <link rel="shortcut icon" href="/Images/webicon.png" type="image/x-icon">
  <title>
    ТОВ ТВД "РІВС" | Головна сторінка | Гуанполісепт
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
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
  <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.js"></script>

</head>

<body>
  <header style="font-family: Helios,sans-serif;">
    <!--Navbar -->
    <nav class="mb-1 navbar sticky-top navbar-expand-lg navbar-light cyan accent-2 scrolling-navbar">
      <div class="container">
        <a class="navbar-brand" href="/">
          <img src="/Images/logo.png" width="30" height="40" alt="logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-333" aria-controls="navbarSupportedContent-333" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent-333">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="/">Головна
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/contacts.php">Контакти</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/store">Продукція</a>
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
                <i class="fas fa-phone"></i>Телефони
              </a>
            </li>



            <li class="nav-item">
              <a class="nav-link" href="https://www.rivs.com.ua/rus">RU
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item active disabled">
              <a class="nav-link" href="https://www.rivs.com.ua/">UA
                <span class="sr-only">(current)</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- Modal login -->
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
  <main class="mt-5 mb-3">
    <!--Main container-->
    <div class="container" style="background-color: #eee;">
      <!--Grid row-->
      <div class="row">
        <div class="col-md-7 mb-4">
          <div class="view overlay z-depth-1-half">
            <div class="mask rgba-white-light">
            </div>
          </div>
        </div>
      </div>
      <div class="mb-3">
        <h4 class="text-center mb-4">Ми вислали вам Email, будь-ласка вкажіть код зазначений в листі щоб підтвердити регістрацію</h4>
        <form id="email-form" name="email-form" action="registerConfirmation.php" method="post">
          <div class="form-group">
            <input type="text" class="form-control" id="email_code" name="email_code" placeholder="Enter code" required>
            <div id="email_code_feedback" class="invalid-feedback"></div>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </main>
</body>
<script type="text/javascript">
  var form = $('#email-form');

  form.submit(function(e) {


    formData = {
      'verification_token': <?php echo json_encode($_POST["verification_token"], JSON_UNESCAPED_UNICODE); ?>,
      'email': <?php echo json_encode($_POST["email"], JSON_UNESCAPED_UNICODE); ?>,
      'password': <?php echo json_encode($_POST["password"], JSON_UNESCAPED_UNICODE); ?>,
      'email_code': $('input[name=email_code]').val()
    };
    e.preventDefault();

    $.ajax({
      type: "POST",
      url: "registerConfirmation.php",
      data: formData,
      success: function(response) {
        if (response != null) {
          var jsonData = JSON.parse(response);
          if (jsonData.success == true) {
            window.location.replace("/");
          } else {
            var email_code = document.getElementById("email_code");
            var email_code_feedback = document.getElementById("email_code_feedback");
           
            if (jsonData.hasOwnProperty("email_code") && jsonData.email_code != '') {
              email_code.classList.add('is-invalid');
              email_code.classList.remove('is-valid');
              email_code_feedback.innerHTML = jsonData.email_code;       
            } else {
              email_code.classList.remove('is-invalid');
              email_code.classList.add('is-valid');
            }
          }
        }
      },
      error: function(data) {
        console.log('An error occurred.');
        console.log(data);
      },
    });
  });
</script>
</html>