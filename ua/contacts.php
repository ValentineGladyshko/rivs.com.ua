<?php
require_once("../LDLRIVS.php");

my_session_start();

$verification_token = base64_encode(openssl_random_pseudo_bytes(32));
$_SESSION['verification_token'] = $verification_token;

?>
<!--DOCTYPE html-->
<html lang="uk">

<head>

  <link rel="shortcut icon" href="/Images/webicon.png" type="image/x-icon">
  <title>
    ТОВ ТВД "РІВС" | Контакти
  </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta https-equiv="x-ua-compatible" content="ie=edge">

  <link rel="shortcut icon" href="/Images/favicon.ico" type="image/x-icon">
  <!-- Bootstrap core CSS -->
  <? include("../scripts.php"); ?>
  <link href="/css/googlemap.css" rel="stylesheet">

</head>

<body style="overflow-y: overlay;">
  <? include("functions/header.php"); ?>

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
            <form id="contact-form">

              <!--Grid row-->
              <div class="row">

                <!--Grid column-->
                <div class="col-md-6">
                  <div class="md-form">
                    <label for="name">Ваше ім'я</label>
                    <input type="text" id="name" class="form-control" required>
                    <div id="name_feedback" class="invalid-feedback"></div>
                  </div>
                </div>
                <!--Grid column-->

                <!--Grid column-->
                <div class="col-md-6">
                  <div class="md-form">
                    <label for="email">Ваш email</label>
                    <input type="email" id="email" class="form-control" required>
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
                    <label for="message">Введіть повідомлення</label>
                    <textarea type="text" id="message" rows="2" class="form-control md-textarea" required></textarea>
                    <div id="message_feedback" class="invalid-feedback"></div>
                  </div>
                </div>
              </div>
              <!--Grid row-->

              <div class="center-on-small-only">
                <button style="margin-top:10px" type="submit" class="btn btn-primary">Надіслати</a>
              </div>
              <div style="margin-top:10px" id="status"></div>
            </form>
          </div>
          <div class="col-md-3 text-center">
            <ul class="list-unstyled mb-0">
              <li><img height="32" src="/icons/geo-alt.svg">
                <p>Місто Київ, вулиця Північна 3</p>
              </li>

              <li><img height="32" src="/icons/telephone-fill.svg">
                <p><a class="phone-ph" href="tel:+380660125020"><strong>+38(066)012-50-20</strong></a></p>
                <p><a class="phone-ph" href="tel:+380636491060"><strong>+38(063)649-10-60</strong></a></p>
                <a class="link waves-effect waves-light">
                  <p><a href="viber://chat?number=+380504400767" style="font-size:28px;"><img height="40" src="/icons/viber-logo.png" style="margin-right:5px;">Viber</a></p>
                  <p><a href="https://t.me/rivs_com_ua_sales" style="font-size:28px;"><img height="40" src="/icons/telegram.svg" style="margin-right:5px;">Telegram</a></p>
                  <p><a href="https://wa.me/380504400767" style="font-size:28px;"><img height="40" src="/icons/whatsapp-logo.svg" style="margin-right:5px;">WhatsApp</a></p>
                </a>
              </li>

              <li><img width="32" src="/icons/envelope-open-fill.svg">
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

  <? include("../myScripts.php"); ?>

  <script type="text/javascript">
    var elem = document.getElementById("contacts");
    elem.classList.add('active');
    var ru_link = document.getElementById("ru_link");
    ru_link.href = "/ru/contacts.php";
    var ua_link = document.getElementById("ua_link");
    ua_link.href = "/ua/contacts.php";
  </script>

  <!-- Script for submitting form -->
  <script type="text/javascript">
    var form = $('#contact-form');

    form.submit(function(e) {

      // data for request
      formData = {
        'name': $document.getElementById("name").value,
        'email': $document.getElementById("email").value,
        'message': $document.getElementById("message").value
      };

      e.preventDefault();

      // ajax post request
      $.ajax({
        url: "functions/contactFormSubmit.php",
        data: formData,
        type: "POST",
        success: function(response) {
          if (response != null) {
            // parsing response from back-end
            var jsonData = JSON.parse(response);

            // checking status of operation 
            if (jsonData.success == true) {

              // clearing values of fields in form and show success status
              document.getElementById("status").innerHTML = '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>' + jsonData.send +
                '</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
              $('#contact-form').closest('form').find("input[type=email], input[type=text], textarea").val("");
            } else {
              changeInputStatus(document.getElementById("email"), document.getElementById("email_feedback"), jsonData, "email");
              changeInputStatus(document.getElementById("name"), document.getElementById("name_feedback"), jsonData, "name");
              changeInputStatus(document.getElementById("message"), document.getElementById("message_feedback"), jsonData, "message")
              
              // change status field
              if (jsonData.hasOwnProperty("send")) {
                document.getElementById("status").innerHTML = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>' + jsonData.send +
                  '</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
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