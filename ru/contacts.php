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

  <link rel="shortcut icon" href="/Images/favicon.ico" type="image/x-icon">
  <!-- Font Awesome -->
  <? include("../scripts.php"); ?>
  <link href="/css/googlemap.css" rel="stylesheet">

</head>

<body style="overflow-y: overlay;">
  <? include("header.php"); ?>

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

            <form id="contact-form" name="contact-form" method="post">

              <!--Grid row-->
              <div class="row">

                <!--Grid column-->
                <div class="col-md-6">
                  <div class="md-form">
                    <input type="text" id="name" name="name" class="form-control" required>
                    <label for="name">Ваше имя</label>
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
                    <label for="message">Введите сообщение</label>
                    <div id="message_feedback" class="invalid-feedback"></div>
                  </div>
                </div>
              </div>
              <!--Grid row-->

              <div class="center-on-small-only">
                <button type="submit" class="btn btn-primary">Отправить</a>
              </div>
              <div class="status" id="status"></div>

            </form>
            <!--Grid column-->

            <!--Grid column-->
          </div>
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