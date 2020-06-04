<!--DOCTYPE html-->
<html lang="en">

<head>

  <link rel="shortcut icon" href="/Images/webicon.png" type="image/x-icon">
  <title>
    ООО ТПП "РИВС" | Контакты
  </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
  <!-- Bootstrap core CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!-- Material Design Bootstrap -->
  <link href="css/mdb.min.css" rel="stylesheet">
  <!-- Your custom styles (optional) -->
  <link href="css/style.css" rel="stylesheet">
  <link href="style.css" rel="stylesheet">
  <link href="googlemap.css" rel="stylesheet">

</head>

<body>
  <header>
    <!--Navbar -->
    <nav class="mb-1 navbar sticky-top navbar-expand-lg navbar-light cyan accent-2 scrolling-navbar">
      <div class="container">
        <a class="navbar-brand" href="https://www.rivs.com.ua/rus">
          <img src="/Images/logo.png" width="30" height="40" alt="logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-333" aria-controls="navbarSupportedContent-333" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent-333">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="https://www.rivs.com.ua/rus">Главная
              </a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="https://www.rivs.com.ua/ru/contacts">Контакты
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="https://www.rivs.com.ua/ru/store">Продукция</a>
            </li>
            </li>
          </ul>
          <ul class="navbar-nav navbar-right">
            <li class="nav-item">
              <!-- Button trigger modal -->
              <a class="nav-link" data-toggle="modal" data-target="#MobileModal">
                <i class="fas fa-phone"></i>Телефоны
              </a>
            </li>
            <li class="nav-item active disabled">
              <a class="nav-link" href="https://www.rivs.com.ua/rus">RU
                <span class="sr-only">(current)</span>
              </a>
              <i class="russia flag"></i>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="https://www.rivs.com.ua/contacts">UA
                <span class="sr-only">(current)</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
      </div>
    </nav>
    <!-- Modal -->
    <div class="modal fade" id="MobileModal" tabindex="-1" role="dialog" aria-labelledby="MobileModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="MobileModalLabel">Наши телефоны</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p class="text-justify">Консультации и заказ по телефонам:</p>
            <p><a class="phone-ph" href="tel:+380660125020"><strong>+38(066)012-50-20</strong></a></p>
            <p><a class="phone-ph" href="tel:+380636491060"><strong>+38(063)649-10-60</strong></a></p>
            <p class="text-justify">График работы:</p>
            <p class="text-justify">Будни: с 10:00 до 21:00</p>
            <p class="text-justify">Выходные: с 11:00 до 19:00</p>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!--Main Navigation-->
  <!--Main layout-->
  <main class="mt-5 mb-3">
    <!--Main container-->
    <div class="container" style="background-color: #eee;">
      <!--Grid row-->
      <div class="row">

        <!--Grid column-->
        <div class="col-md-7 mb-4">
          <div class="view overlay z-depth-1-half">
            <div class="mask rgba-white-light">
            </div>
          </div>

        </div>
        <!--Grid column-->

      </div>
      <!--Grid row-->

      <!-- Contact form -->
      <section class="mb-4">

        <!--Section heading-->
        <h2 class="h1-responsive font-weight-bold text-center my-4">Связь с нами</h2>
        <!--Section description-->
        <p class="text-center w-responsive mx-auto mb-5">У вас есть какие-то вопросы? Пожалуйста, не стесняйтесь обратится к нам напрямую. Мы ответим вам в скором времени.</p>

        <div class="row">

          <!--Grid column-->
          <div class="col-md-8 col-xl-9">
            <form id="contact-form" name="contact-form" action="ContactFormSubmit.php" method="POST" onsubmit="return validateForm()">

              <!--Grid row-->
              <div class="row">

                <!--Grid column-->
                <div class="col-md-6">
                  <div class="md-form">
                    <div class="md-form">
                      <input type="text" id="name" name="name" class="form-control">
                      <label for="name" class="">Ваше имя</label>
                    </div>
                  </div>
                </div>
                <!--Grid column-->

                <!--Grid column-->
                <div class="col-md-6">
                  <div class="md-form">
                    <div class="md-form">
                      <input type="text" id="email" name="email" class="form-control">
                      <label for="email" class="">Ваш email</label>
                    </div>
                  </div>
                </div>
                <!--Grid column-->

              </div>

              <!--Grid row-->
              <div class="row">

                <!--Grid column-->
                <div class="col-md-12">

                  <div class="md-form">
                    <textarea type="text" id="message" name="message" rows="2" class="form-control md-textarea"></textarea>
                    <label for="message">Введите сообщение</label>
                  </div>

                </div>
              </div>
              <!--Grid row-->

            </form>

            <div class="center-on-small-only">
              <a class="btn btn-primary disabled" onclick="validateForm()">Отправить</a>
            </div>
            <div class="status" id="status"></div>
          </div>
          <!--Grid column-->

          <!--Grid column-->
          <div class="col-md-3 text-center">
            <ul class="list-unstyled mb-0">
              <li><i class="fas fa-map-marker-alt fa-2x"></i>
                <p>Город Киев, улица Северная 3</p>
              </li>

              <li><i class="fas fa-phone mt-4 fa-2x"></i>
                <p><a class="phone-ph" href="tel:+380660125020"><strong>+38(066)012-50-20</strong></a></p>
                <p><a class="phone-ph" href="tel:+380636491060"><strong>+38(063)649-10-60</strong></a></p>
                <a class="link waves-effect waves-light">
                  <p><a href="viber://chat?number=+380504400767"><i class="fab fa-viber fa-2x">Viber</i> </a></p>
                  <p><a href="https://t.me/rivs_com_ua_sales"><i class="fab fa-telegram fa-2x">Telegram</i> </a></p>
                  <p><a href="https://wa.me/380504400767"><i class="fab fa-whatsapp fa-2x">WhatsApp</i></a></p>
                </a>
              </li>

              <li><i class="fas fa-envelope mt-4 fa-2x"></i>
                <p>avtomagnetik@gmail.com</p>
              </li>
            </ul>
          </div>
          <!--Grid column-->

        </div>
        <div id="map-container" class="z-depth-1-half map-container">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d543.5598323529164!2d30.506472261855496!3d50.528346787935796!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40d4d248ea28a11d%3A0x33034c222f15706a!2z0LLRg9C70LjRhtGPINCf0ZbQstC90ZbRh9C90LAsIDUsINCa0LjRl9CyLCAwMjAwMA!5e0!3m2!1suk!2sua!4v1558130679616!5m2!1suk!2sua" style="border:0" frameborder="0" style="border:0" allowfullscreen>></iframe>
        </div>
      </section>

      <!--Main container-->

  </main>
  <!--Main layout-->

  <!-- Footer -->
  <footer class="page-footer font-small bottom cyan accent-4 mt-4">

    <!-- Copyright -->
    <div class="footer-copyright text-center py-3">© 2015 - 2020 ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ — ТОРГОВО-ПРОИЗВОДСТВЕННОЕ ПРЕДПРИЯТИЕ "РИВС"
    </div>
    <!-- Copyright -->

  </footer>
  <!-- Footer -->

  <!-- SCRIPTS -->
  <!-- JQuery -->
  <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <!-- Bootstrap tooltips -->
  <script type="text/javascript" src="js/popper.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <!-- MDB core JavaScript -->
  <script type="text/javascript" src="js/mdb.min.js"></script>
  <script>
    function validateForm() {

      document.getElementById('status').innerHTML = "Відправлення...";
      formData = {
        'name': $('input[name=name]').val(),
        'email': $('input[name=email]').val(),
        'subject': $('input[name=subject]').val(),
        'message': $('textarea[name=message]').val()
      };


      $.ajax({
        url: "ContactFormSubmit.php",
        type: "POST",
        data: formData,
        success: function(data, textStatus, jqXHR) {

          $('#status').text(data.message);
          if (data.code)
            $('#contact-form').closest('form').find("input[type=text], textarea").val("");
        },
        error: function(jqXHR, textStatus, errorThrown) {
          $('#status').text(jqXHR);
        }
      });
    }
  </script>
</body>

</html>