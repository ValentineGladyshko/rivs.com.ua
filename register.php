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
  
  <? include("scripts.php"); ?>

</head>

<body>
<? include("header.php"); ?>

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