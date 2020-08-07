<?php
require_once("../LDLRIVS.php");
require_once("functions/mainFunctions.php");

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
                <button id="sendButton" style="margin-top:10px" type="submit" class="btn btn-dark btn-lg"><span id="sendButtonSpinner" style="width: 20px; height: 20px;"></span>Надіслати</a>
              </div>
              <div style="margin-top:10px" id="status"></div>
            </form>
          </div>
          <div class="col-md-3 text-center">
            <ul class="list-unstyled mb-0">
              <li>
                <svg height="32" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                  <g>
                    <path fill="currentColor" class="gray4" d="M554.06 161.16L416 224v288l139.88-55.95A32 32 0 0 0 576 426.34V176a16 16 0 0 0-21.94-14.84zM20.12 216A32 32 0 0 0 0 245.66V496a16 16 0 0 0 21.94 14.86L160 448V214.92a302.84 302.84 0 0 1-21.25-46.42zM288 359.67a47.78 47.78 0 0 1-36.51-17C231.83 319.51 210.92 293.09 192 266v182l192 64V266c-18.92 27.09-39.82 53.52-59.49 76.72A47.8 47.8 0 0 1 288 359.67z" class="fa-secondary"></path>
                    <path fill="currentColor" d="M288 0a126 126 0 0 0-126 126c0 56.26 82.35 158.8 113.9 196a15.77 15.77 0 0 0 24.2 0C331.65 284.8 414 182.26 414 126A126 126 0 0 0 288 0zm0 168a42 42 0 1 1 42-42 42 42 0 0 1-42 42z" class="fa-primary"></path>
                  </g>
                </svg>
                <p>Місто Київ, вулиця Північна 3</p>
              </li>

              <li>
                <svg class="bi bi-telephone-fill" height="32" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M2.267.98a1.636 1.636 0 0 1 2.448.152l1.681 2.162c.309.396.418.913.296 1.4l-.513 2.053a.636.636 0 0 0 .167.604L8.65 9.654a.636.636 0 0 0 .604.167l2.052-.513a1.636 1.636 0 0 1 1.401.296l2.162 1.681c.777.604.849 1.753.153 2.448l-.97.97c-.693.693-1.73.998-2.697.658a17.47 17.47 0 0 1-6.571-4.144A17.47 17.47 0 0 1 .639 4.646c-.34-.967-.035-2.004.658-2.698l.97-.969z" />
                </svg>
                <p><a class="phone-ph" href="tel:+380660125020"><strong>+38(066)012-50-20</strong></a></p>
                <p><a class="phone-ph" href="tel:+380636491060"><strong>+38(063)649-10-60</strong></a></p>
                <a class="link waves-effect waves-light">
                  <p><a href="viber://chat?number=+380504400767" style="font-size:28px;"><img height="40" src="/icons/viber-logo.png" style="margin-right:5px;">Viber</a></p>
                  <p><a href="https://t.me/rivs_com_ua_sales" style="font-size:28px;"><img height="40" src="/icons/telegram.svg" style="margin-right:5px;">Telegram</a></p>
                  <p><a href="https://wa.me/380504400767" style="font-size:28px;"><img height="40" src="/icons/whatsapp-logo.svg" style="margin-right:5px;">WhatsApp</a></p>
                </a>
              </li>

              <li>
                <svg height="32" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                  <g>
                    <path fill="currentColor" class="gray4" d="M64,257.6,227.9,376a47.72,47.72,0,0,0,56.2,0L448,257.6V96a32,32,0,0,0-32-32H96A32,32,0,0,0,64,96ZM160,160a16,16,0,0,1,16-16H336a16,16,0,0,1,16,16v16a16,16,0,0,1-16,16H176a16,16,0,0,1-16-16Zm0,80a16,16,0,0,1,16-16H336a16,16,0,0,1,16,16v16a16,16,0,0,1-16,16H176a16,16,0,0,1-16-16Z" class="fa-secondary"></path>
                    <path fill="currentColor" d="M352,160a16,16,0,0,0-16-16H176a16,16,0,0,0-16,16v16a16,16,0,0,0,16,16H336a16,16,0,0,0,16-16Zm-16,64H176a16,16,0,0,0-16,16v16a16,16,0,0,0,16,16H336a16,16,0,0,0,16-16V240A16,16,0,0,0,336,224ZM329.4,41.4C312.6,29.2,279.2-.3,256,0c-23.2-.3-56.6,29.2-73.4,41.4L152,64H360ZM64,129c-23.9,17.7-42.7,31.6-45.6,34A48,48,0,0,0,0,200.7v10.7l64,46.2Zm429.6,34c-2.9-2.3-21.7-16.3-45.6-33.9V257.6l64-46.2V200.7A48,48,0,0,0,493.6,163ZM256,417.1a80,80,0,0,1-46.9-15.2L0,250.9V464a48,48,0,0,0,48,48H464a48,48,0,0,0,48-48V250.9l-209.1,151A80,80,0,0,1,256,417.1Z" class="fa-primary"></path>
                  </g>
                </svg>
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
  <footer class="page-footer font-small bottom bg-dark accent-4 mt-4">

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
  </script>

  <!-- Script for submitting form -->
  <script type="text/javascript">
    var form = $('#contact-form');

    form.submit(function(e) {

      document.getElementById("sendButtonSpinner").classList.add("spinner-border");
      document.getElementById("sendButton").disabled = true;
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

            document.getElementById("sendButtonSpinner").classList.add("spinner-border");
            document.getElementById("sendButton").disabled = true;

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