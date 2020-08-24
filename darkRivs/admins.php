<?php
require_once("../LDLRIVS.php");

my_session_start();

$verification_token = base64_encode(openssl_random_pseudo_bytes(32));
$_SESSION['verification_token'] = $verification_token;
$security_token = $_SESSION["security_admin_token"];
$security_token1 = $_COOKIE["security_admin_token"];

if ($security_token == null || $security_token1 == null) {
  include("../scripts.php");
  echo "<script>$(document).ready(function() { $.redirect('login.php'); });</script>";
  exit();
}

if (hash_equals($security_token, $security_token1)) {
  $mysqli = mysqli_connect("localhost", "AdminUser", "GIrPMdpnUarMh3VY", "rivs");
  if ($mysqli->connect_errno) {
    exit();
  }

  $admins = '';
  if ($stmt = $mysqli->prepare("SELECT `UserLogin`, `Name` FROM admin_passwords")) {
    $stmt->execute();
    $stmt->bind_result($email, $name);
    while ($stmt->fetch()) {
      $admins .= sprintf('<tr><td>%2$s</td><td>%1$s</td></tr>', $email, $name);
    }
    $stmt->close();
  }
?>
  <? include("functions/header.php"); ?>
  <div class="card mb-4">
    <div class="card-header">Адміністратори</div>
    <div class="card-body">
      <div class="datatable">
        <table class="table table-bordered table-hover" id="adminsTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>І'мя</th>
              <th>Email</th>
            </tr>
          </thead>
          <tbody>
            <? echo $admins; ?>
          </tbody>
          <tfoot>
            <tr>
              <th>І'мя</th>
              <th>Email</th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
  <div class="card mb-4">
    <div class="card-header">Регістрація нового Адміністратора</div>
    <div class="card-body">
      <form id="registerAdminForm" method="post">

        <input id="register_admin_verification_token" type="hidden" value=<?= $verification_token ?>>

        <div class="form-group row">
          <label for="register_admin_name" class="col-lg-2 col-md-3 col-sm-4 col-form-label">І'мя</label>
          <div class="col-lg-10 col-md-9 col-sm-8 my-vertical-centered">
            <input type="text" class="form-control" id="register_admin_name" placeholder="Введіть і'мя" required>
            <div id="register_admin_name_feedback" class="invalid-feedback"></div>
          </div>         
        </div>

        <div class="form-group row">
          <label for="register_admin_email" class="col-lg-2 col-md-3 col-sm-4 col-form-label">Електронна адреса</label>
          <div class="col-lg-10 col-md-9 col-sm-8 my-vertical-centered">
            <input type="email" class="form-control" id="register_admin_email" placeholder="Введіть електронну адресу" required>
            <div id="register_admin_email_feedback" class="invalid-feedback"></div>
          </div>       
        </div>

        <div class="form-group row">
          <label for="register_admin_password" class="col-lg-2 col-md-3 col-sm-4 col-form-label">Пароль</label>
          <div class="col-lg-10 col-md-9 col-sm-8 my-vertical-centered">
            <div class="input-group" id="register_admin_password_group">
              <input type="password" class="form-control" id="register_admin_password" placeholder="Введіть пароль" required>
              <div class="input-group-append">
                <div onclick="passwordToggle(document.getElementById('register_admin_password_img'), document.getElementById('register_admin_password'))" class="input-group-text" style="cursor: pointer;">
                  <img id="register_admin_password_img" height="20" src="/icons/eye-fill.svg">
                </div>
              </div>
            </div>
            <div id="register_admin_password_feedback" class="invalid-feedback"></div>
          </div>
        </div>

        <div class="form-group row">
          <label for="register_admin_repeat_password" class="col-lg-2 col-md-3 col-sm-4 col-form-label">Повторний пароль</label>
          <div class="col-lg-10 col-md-9 col-sm-8 my-vertical-centered">
            <div class="input-group" id="register_admin_repeat_password_group">
              <input type="password" class="form-control" id="register_admin_repeat_password" placeholder="Введіть пароль повторно" required>
              <div class="input-group-append">
                <div onclick="passwordToggle(document.getElementById('register_admin_repeat_password_img'), document.getElementById('register_admin_repeat_password'))" class="input-group-text" style="cursor: pointer;">
                  <img id="register_admin_repeat_password_img" height="20" src="/icons/eye-fill.svg">
                </div>
              </div>
            </div>
            <div id="register_admin_repeat_password_feedback" class="invalid-feedback"></div>
          </div>         
        </div>

        <div class="row">
          <button id="registerAdminDismissButton" type="button" class="btn btn-secondary my-1 mr-1">Відмінити</button>
          <button id="registerAdminSubmitButton" type="submit" class="btn btn-dark m-1">
            Підтвердити
          </button>
          <div class="m-1">
            <span id="registerAdminSubmitButtonSpinner" style="width: 38px; height: 38px;"></span>
          </div>
        </div>
      </form>
    </div>
  </div>
  <? include("functions/footer.php"); ?>
  <? include("functions/myScripts.php"); ?>
  <script>
    function changeInputStatus(input, inputFeedback, jsonData, propertyName) {
      if (jsonData.hasOwnProperty(propertyName)) {
        input.classList.add('is-invalid');
        input.classList.remove('is-valid');
        inputFeedback.innerHTML = jsonData[propertyName];
      } else {
        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
      }
    };

    function changeInputGroupStatus(inputGroup, input, inputFeedback, jsonData, propertyName) {
      if (jsonData.hasOwnProperty(propertyName)) {
        inputGroup.classList.add('is-invalid');
        inputGroup.classList.remove('is-valid');
        input.classList.add('is-invalid');
        input.classList.remove('is-valid');
        inputFeedback.innerHTML = jsonData[propertyName];
      } else {
        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
        inputGroup.classList.remove('is-invalid');
        inputGroup.classList.add('is-valid');
      }
    };

    function passwordToggle(img, input) {
      if (input.type === "password") {
        input.type = "text";
        img.src = "/icons/eye-slash-fill.svg"
      } else {
        input.type = "password";
        img.src = "/icons/eye-fill.svg"
      }
    };

    $(document).ready(function() {
      $('#adminsTable').DataTable({
        language: {
          url: '/css/Ukrainian.lang.json'
        }
      });
    });
    var elem = document.getElementById("admins-nav");
    elem.classList.add('active');

    var registerAdminForm = $('#registerAdminForm');
    registerAdminForm.submit(function(e) {

      document.getElementById("registerAdminSubmitButtonSpinner").classList.add("spinner-border");
      document.getElementById("registerAdminSubmitButton").disabled = true;
      // give data from form
      formData = {
        'verification_token': document.getElementById("register_admin_verification_token").value,
        'name': document.getElementById("register_admin_name").value,
        'email': document.getElementById("register_admin_email").value,
        'password': document.getElementById("register_admin_password").value,
        'repeat_password': document.getElementById("register_admin_repeat_password").value,
      };
      e.preventDefault();

      // ajax request
      $.ajax({
        type: "POST",
        url: "functions/addAdmin.php",
        data: formData,
        success: function(response) {
          if (response != null) {

            document.getElementById("registerAdminSubmitButtonSpinner").classList.remove("spinner-border");
            document.getElementById("registerAdminSubmitButton").disabled = false;
            // parse response from server
            var jsonData = JSON.parse(response);

            // if success code is true login and reload
            if (jsonData.success == true) {
              location.reload();
              // else give html fields and show error messages
            } else {
              changeInputStatus(document.getElementById("register_admin_name"),
                document.getElementById("register_admin_name_feedback"), jsonData, "name");
              changeInputStatus(document.getElementById("register_admin_email"),
                document.getElementById("register_admin_email_feedback"), jsonData, "email");
              changeInputGroupStatus(document.getElementById("register_admin_password_group"),
                document.getElementById("register_admin_password"),
                document.getElementById("register_admin_password_feedback"), jsonData, "password");
                changeInputGroupStatus(document.getElementById("register_admin_repeat_password_group"),
                document.getElementById("register_admin_repeat_password"),
                document.getElementById("register_admin_repeat_password_feedback"), jsonData, "repeat_password");
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
<?php } else {
  include("../scripts.php");
  echo "<script>$(document).ready(function() { $.redirect('login.php'); });</script>";
  exit();
} ?>