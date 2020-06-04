<!--DOCTYPE html-->
<html lang="uk">

<head>

  <link rel="shortcut icon" href="Images/webicon.png" type="image/x-icon">
  <title>
    ТОВ ТВД "РІВС" | Контакти
  </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta https-equiv="x-ua-compatible" content="ie=edge">

  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="css/all.css">
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
        <a class="navbar-brand" href="/">
          <img src="Images/logo.png" width="30" height="40" alt="logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-333" aria-controls="navbarSupportedContent-333" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent-333">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="/">Головна
              </a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="contacts">Контакти
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="store">Продукція</a>
            </li>
            </li>
          </ul>
          <ul class="navbar-nav navbar-right">
            <li class="nav-item">
              <!-- Button trigger modal -->
              <a class="nav-link" data-toggle="modal" data-target="#MobileModal">
                <i class="fas fa-phone"></i>Телефони
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="ru/contacts">RU
                <span class="sr-only">(current)</span>
              </a>
              <i class="russia flag"></i>
            </li>
            <li class="nav-item active disabled">
              <a class="nav-link" href="/">UA
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
        <h2 class="h1-responsive font-weight-bold text-center my-4">Зв'язок із нами</h2>
        <!--Section description-->
        <p class="text-center w-responsive mx-auto mb-5">У вас є які-небудь питання? Будь ласка, не соромтеся звертатися до нас безпосередньо. Ми відповімо вам, коли зможемо.</p>

        <div class="row">

          <!--Grid column-->
          <div class="col-md-8 col-xl-9">
            <form id="contact-form" name="contact-form" method="post"> 

              <!--Grid row-->
              <div class="row">

                <!--Grid column-->
                <div class="col-md-6">
                  <div class="md-form">
                    <input type="text" id="name" name="name" class="form-control" required>
                    <label for="name">Ваше ім'я</label>
                    <div id="name_feedback" class="invalid-feedback"></div>
                  </div>
                </div>
                <!--Grid column-->

                <!--Grid column-->
                <div class="col-md-6">
                  <div class="md-form">
                    <input type="email" id="email" name="email" class="form-control" required>
                    <label for="email">Ваш email</label>
                    <div id="email_feedback" class="invalid-feedback"></div>
                  </div>
                </div>
                <!--Grid column-->

              </div>
              <!--Grid row-->
              <div class="row">

                <!--Grid column-->
                <div class="col-md-12">
                  <div class="md-form">
                    <textarea type="text" id="message" name="message" rows="2" class="form-control md-textarea" required></textarea>
                    <label for="message">Введіть повідомлення</label>
                    <div id="message_feedback" class="invalid-feedback"></div>
                  </div>
                </div>
              </div>
              <!--Grid row-->

              <div class="center-on-small-only">
                <button type="submit" class="btn btn-primary">Надіслати</a>
              </div>
              <div class="status" id="status"></div>

            </form>


          </div>
          <!--Grid column-->

          <!--Grid column-->
          <div class="col-md-3 text-center">
            <ul class="list-unstyled mb-0">
              <li><i class="fas fa-map-marker-alt fa-2x"></i>
                <p>Місто Київ, вулиця Північна 3</p>
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
    <div class="footer-copyright text-center py-3">© 2015 - 2020 ТОВАРИСТВО З ОБМЕЖЕНОЮ ВІДПОВІДАЛЬНІСТЮ — ТОРГОВО-ВИРОБНИЧИЙ ДІМ "РІВС"
    </div>
    <!-- Copyright -->

  </footer>
  <!-- Footer -->

  <!-- SCRIPTS -->
  <!-- JQuery -->
  <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
  <!-- Bootstrap tooltips -->
  <script type="text/javascript" src="js/popper.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <!-- MDB core JavaScript -->
  <script type="text/javascript" src="js/mdb.min.js"></script>

  <!-- Script for submitting form -->
  <script type="text/javascript">
    var form = $('#contact-form');

    form.submit(function(e) {

      // data for request
      formData = {
        'name': $('input[name=name]').val(),
        'email': $('input[name=email]').val(),
        'message': $('textarea[name=message]').val()
      };

      e.preventDefault();

      // ajax post request
      $.ajax({
        url: "ContactFormSubmit.php",
        data: formData,
        type: "POST",
        success: function(response) {
          if (response != null) {
            // parsing response from back-end
            var jsonData = JSON.parse(response);

            // checking status of operation 
            if (jsonData.success == true) {

              // clearing values of fields in form and show success status
              document.getElementById("status").innerHTML = jsonData.send;
              $('#contact-form').closest('form').find("input[type=email], input[type=text], textarea").val("");
            } else {

              // giving elements of html to change
              var email = document.getElementById("email");
              var name = document.getElementById("name");
              var message = document.getElementById("message");
              var email_feedback = document.getElementById("email_feedback");
              var name_feedback = document.getElementById("name_feedback");
              var message_feedback = document.getElementById("message_feedback");

              // set invalid status to email field and show email error if email is invalid
              if (jsonData.hasOwnProperty("email")) {
                email.classList.add('is-invalid');
                email.classList.remove('is-valid');
                email_feedback.innerHTML = jsonData.email;
              } 
              
              // change status if email is valid
              else {
                email.classList.remove('is-invalid');
                email.classList.add('is-valid');
              }

              // set invalid status to name field and show name error if name is invalid
              if (jsonData.hasOwnProperty("name")) {
                name.classList.add('is-invalid');
                name.classList.remove('is-valid');
                name_feedback.innerHTML = jsonData.name;
              } 
              
              // change status if name is valid
              else {
                name.classList.remove('is-invalid');
                name.classList.add('is-valid');
              }

              // set invalid status to message field and show message error if message is invalid
              if (jsonData.hasOwnProperty("message")) {
                message.classList.add('is-invalid');
                message.classList.remove('is-valid');
                message_feedback.innerHTML = jsonData.message;
              } 
              
              // change status if message is valid
              else {
                message.classList.remove('is-invalid');
                message.classList.add('is-valid');
              }

              // change status field
              if (jsonData.hasOwnProperty("send")) {
                document.getElementById("status").innerHTML = jsonData.send;
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
</body>

</html>