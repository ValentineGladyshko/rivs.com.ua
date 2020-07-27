<?php
require_once("../LDLRIVS.php");

my_session_start();

$verification_token = base64_encode(openssl_random_pseudo_bytes(32));
$_SESSION['verification_token'] = $verification_token;

?>
<html lang="en">

<head>

    <link rel="shortcut icon" href="/Images/webicon.png" type="image/x-icon">
    <title>
        ТОВ ТВД "РІВС" / Адміністративна сторінка
    </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!-- Font Awesome -->
    <? include("functions/scripts.php"); ?>
</head>

<body style="overflow-y: overlay;">
    <main class="mt-5 mb-3">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-auto" style="width:325px">
                    <form id="adminLoginForm">
                        <input id="admin_login_verification_token" type="hidden" value=<?= $verification_token ?>>
                        <div class="form-group">
                            <label class="control-label" for="admin_login_email">Електронна адреса</label>
                            <input type="email" class="form-control" id="admin_login_email" placeholder="Введіть електронну адресу" required>
                            <div id="admin_login_email_feedback" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="admin_login_password">Пароль</label>
                            <div class="input-group" id="admin_login_password_group">
                                <input type="password" class="form-control" id="admin_login_password" placeholder="Введіть пароль" required>
                                <div class="input-group-append">
                                    <div onclick="passwordToggle(document.getElementById('admin_login_password_img'), document.getElementById('admin_login_password'))" class="input-group-text" style="cursor: pointer;">
                                        <img id="admin_login_password_img" height="20" src="/icons/eye-fill.svg">
                                    </div>
                                </div>
                            </div>
                            <div id="admin_login_password_feedback" class="invalid-feedback"></div>
                        </div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрити</button>
                        <button type="submit" class="btn btn-dark">Підтвердити</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <footer class="page-footer font-small bottom bg-dark accent-4 mt-4">

        <!-- Copyright -->
        <div class="footer-copyright text-center py-3">© 2015 - 2020 ТОВАРИСТВО З ОБМЕЖЕНОЮ ВІДПОВІДАЛЬНІСТЮ — ТОРГОВО-ВИРОБНИЧИЙ ДІМ "РІВС"
        </div>

    </footer>

</body>
<script type="text/javascript">
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

    var adminLoginForm = $('#adminLoginForm');
    adminLoginForm.submit(function(e) {

        // give data from form
        formData = {
            'verification_token': document.getElementById("admin_login_verification_token").value,
            'email': document.getElementById("admin_login_email").value,
            'password': document.getElementById("admin_login_password").value
        };
        e.preventDefault();

        // ajax request
        $.ajax({
            type: "POST",
            url: "functions/adminLogin.php",
            data: formData,
            success: function(response) {
                if (response != null) {

                    // parse response from server
                    var jsonData = JSON.parse(response);

                    // if success code is true login and reload
                    if (jsonData.success == true) {
                        $.redirect('admin.php');

                        // else give html fields and show error messages
                    } else {
                        changeInputStatus(document.getElementById("admin_login_email"),
                            document.getElementById("admin_login_email_feedback"), jsonData, "email");
                        changeInputGroupStatus(document.getElementById("admin_login_password_group"),
                            document.getElementById("admin_login_password"),
                            document.getElementById("admin_login_password_feedback"), jsonData, "password");
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