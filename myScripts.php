<!-- Script for login form -->
<script type="text/javascript">
  var form = $('#login-form');

  form.submit(function(e) {

    // give data from form
    formData = {
      'verification_token': $('input[name=login_verification_token]').val(),
      'email': $('input[name=login_email]').val(),
      'password': $('input[name=login_password]').val()
    };
    e.preventDefault();

    // ajax request
    $.ajax({
      type: "POST",
      url: "login.php",
      data: formData,
      success: function(response) {
        if (response != null) {

          // parse response from server
          var jsonData = JSON.parse(response);

          // if success code is true login and reload
          if (jsonData.success == true) {
            location.reload();

            // else give html fields and show error messages
          } else {
            var email = document.getElementById("login_email");
            var password = document.getElementById("login_password");
            var email_feedback = document.getElementById("login_email_feedback");
            var password_feedback = document.getElementById("login_password_feedback");
            if (jsonData.hasOwnProperty("email")) {
              email.classList.add('is-invalid');
              email.classList.remove('is-valid');
              email_feedback.innerHTML = jsonData.email;
            } else {
              email.classList.remove('is-invalid');
              email.classList.add('is-valid');
            }
            if (jsonData.hasOwnProperty("password")) {
              password.classList.add('is-invalid');
              password.classList.remove('is-valid');
              password_feedback.innerHTML = jsonData.password;
            } else {
              password.classList.remove('is-invalid');
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

<!-- Script for delete valid and invalid classes from fields -->
<script type="text/javascript">
  var email1 = document.getElementById("register_email");
  email1.oninput = function() {
    email1.classList.remove('is-invalid');
    email1.classList.remove('is-valid');
  };

  var password1 = document.getElementById("register_password");
  password1.oninput = function() {
    password1.classList.remove('is-invalid');
    password1.classList.remove('is-valid');
  };

  var repeat_password = document.getElementById("register_repeat_password");
  repeat_password.oninput = function() {
    repeat_password.classList.remove('is-invalid');
    repeat_password.classList.remove('is-valid');
  };

  var email = document.getElementById("login_email");
  email.oninput = function() {
    email.classList.remove('is-invalid');
    email.classList.remove('is-valid');
  };

  var password = document.getElementById("login_password");
  password.oninput = function() {
    password.classList.remove('is-invalid');
    password.classList.remove('is-valid');
  };

  var email2 = document.getElementById("reset_password_email");
  email2.oninput = function() {
    email2.classList.remove('is-invalid');
    email2.classList.remove('is-valid');
  };

  var password2 = document.getElementById("reset_password_password");
  password2.oninput = function() {
    password2.classList.remove('is-invalid');
    password2.classList.remove('is-valid');
  };

  var repeat_password2 = document.getElementById("reset_password_repeat_password");
  repeat_password2.oninput = function() {
    repeat_password2.classList.remove('is-invalid');
    repeat_password2.classList.remove('is-valid');
  };
</script>

<!-- Script for register form -->
<script type="text/javascript">
  var form = $('#register-form');

  form.submit(function(e) {

    // give data from form
    formData = {
      'verification_token': $('input[name=register_verification_token]').val(),
      'email': $('input[name=register_email]').val(),
      'password': $('input[name=register_password]').val(),
      'repeat_password': $('input[name=register_repeat_password]').val()
    };
    e.preventDefault();

    // ajax request
    $.ajax({
      type: "POST",
      url: "registerStart.php",
      data: formData,
      success: function(response) {
        if (response != null) {

          // parse response from server
          var jsonData = JSON.parse(response);

          // if success code is true login and reload
          if (jsonData.success == true) {
            $.redirect('register.php', formData);

            // else give html fields and show error messages
          } else {
            var email = document.getElementById("register_email");
            var password = document.getElementById("register_password");
            var repeat_password = document.getElementById("register_repeat_password");
            var email_feedback = document.getElementById("register_email_feedback");
            var password_feedback = document.getElementById("register_password_feedback");
            var repeat_password_feedback = document.getElementById("register_repeat_password_feedback");

            if (jsonData.hasOwnProperty("email_code") && jsonData.email != '') {
              email.classList.add('is-invalid');
              email.classList.remove('is-valid');
              email_feedback.innerHTML = "";
              var data;
              for (data of jsonData.email) {
                email_feedback.innerHTML += ("<p>" + data + "</p>");
              }
            } else {
              email.classList.remove('is-invalid');
              email.classList.add('is-valid');
            }
            if (jsonData.hasOwnProperty("password") && jsonData.password != '') {
              password.classList.add('is-invalid');
              password.classList.remove('is-valid');
              password_feedback.innerHTML = "";
              var data;
              for (data of jsonData.password) {
                password_feedback.innerHTML += ("<p>" + data + "</p>");
              }
            } else {
              password.classList.remove('is-invalid');
              password.classList.add('is-valid');
            }
            if (jsonData.hasOwnProperty("repeat_password") && jsonData.repeat_password != '') {
              repeat_password.classList.add('is-invalid');
              repeat_password.classList.remove('is-valid');
              repeat_password_feedback.innerHTML = "";
              var data;
              for (data of jsonData.repeat_password) {
                repeat_password_feedback.innerHTML += ("<p>" + data + "</p>");
              }
            } else {
              repeat_password.classList.remove('is-invalid');
              repeat_password.classList.add('is-valid');
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

<!-- Script for remember password form -->
<script type="text/javascript">
  var form = $('#remember-form');

  form.submit(function(e) {

    // give data from form
    formData = {
      'verification_token': $('input[name=remember_verification_token]').val(),
      'email': $('input[name=remember_email]').val(),
    };
    e.preventDefault();

    // ajax request
    $.ajax({
      type: "POST",
      url: "remember.php",
      data: formData,
      success: function(response) {
        if (response != null) {

          // parse response from server
          var jsonData = JSON.parse(response);

          // if success code is true login and reload
          if (jsonData.success == true) {
            $('#RememberModal').modal('hide');
            document.getElementById("reset_password_email").value = $('input[name=remember_email]').val();
            $('#ResetPasswordModal').modal();
            // else give html fields and show error messages
          } else {
            var email = document.getElementById("remember_email");
            var email_feedback = document.getElementById("remember_email_feedback");
            if (jsonData.hasOwnProperty("email") && jsonData.email != '') {
              email.classList.add('is-invalid');
              email.classList.remove('is-valid');
              email_feedback.innerHTML = "";
              var data;
              for (data of jsonData.email) {
                email_feedback.innerHTML += ("<p>" + data + "</p>");
              }
            } else {
              email.classList.remove('is-invalid');
              email.classList.add('is-valid');
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

<!-- Script fpr reset password form -->
<script type="text/javascript">
  var form = $('#reset-password-form');

  form.submit(function(e) {

    // give data from form
    formData = {
      'verification_token': $('input[name=reset_password_verification_token]').val(),
      'email': $('input[name=reset_password_email]').val(),
      'email_code': $('input[name=reset_password_email_code]').val(),
      'password': $('input[name=reset_password_password]').val(),
      'repeat_password': $('input[name=reset_password_repeat_password]').val()
    };
    e.preventDefault();

    // ajax request
    $.ajax({
      type: "POST",
      url: "resetPassword.php",
      data: formData,
      success: function(response) {
        if (response != null) {
          
          // parse response from server
          var jsonData = JSON.parse(response);

          // if success code is true login and reload
          if (jsonData.success == true) {
            location.reload();

            // else give html fields and show error messages
          } else {
            var email = document.getElementById("reset_password_email_code");
            var password = document.getElementById("reset_password_password");
            var repeat_password = document.getElementById("reset_password_repeat_password");
            var email_feedback = document.getElementById("reset_password_email_code");
            var password_feedback = document.getElementById("reset_password_password_feedback");
            var repeat_password_feedback = document.getElementById("reset_password_repeat_password_feedback");

            if (jsonData.hasOwnProperty("email_code")) {
              email.classList.add('is-invalid');
              email.classList.remove('is-valid');
              email_feedback.innerHTML = jsonData.email_code;
            } else {
              email.classList.remove('is-invalid');
              email.classList.add('is-valid');
            }
            if (jsonData.hasOwnProperty("password") && jsonData.password != '') {
              password.classList.add('is-invalid');
              password.classList.remove('is-valid');
              password_feedback.innerHTML = "";
              var data;
              for (data of jsonData.password) {
                password_feedback.innerHTML += ("<p>" + data + "</p>");
              }
            } else {
              password.classList.remove('is-invalid');
              password.classList.add('is-valid');
            }
            if (jsonData.hasOwnProperty("repeat_password") && jsonData.repeat_password != '') {
              repeat_password.classList.add('is-invalid');
              repeat_password.classList.remove('is-valid');
              repeat_password_feedback.innerHTML = "";
              var data;
              for (data of jsonData.repeat_password) {
                repeat_password_feedback.innerHTML += ("<p>" + data + "</p>");
              }
            } else {
              repeat_password.classList.remove('is-invalid');
              repeat_password.classList.add('is-valid');
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

<!-- Script for logout form -->
<script type="text/javascript">
  $(document).ready(function() {
    $("#LogoutButton").click(
      function(e) {

        // give data from form
        formData = {
          'verification_token': $('input[name=logout_verification_token]').val(),
        };
        e.preventDefault();

        // ajax request
        $.ajax({
          type: "POST",
          url: "logout.php",
          data: formData,
          success: function(data) {
            location.reload();
            console.log('Logout was successful.');
            console.log(data);
          },
          error: function(data) {
            console.log('An error occurred.');
            console.log(data);
          },
        });
      }
    );
  });
</script>

<script type="text/javascript">
  $(document).ready(function() {
    $("#UserButton").click(
      function(e) {
        e.preventDefault();
        document.getElementById('user-form').submit();
      }
    );
  });
</script>

<script type="text/javascript">
  $(document).ready(function() {
    $("#ua_link").click(
      function(e) {
        e.stopPropagation();
        document.cookie = "language=ua;path=/";
      }
    );
  });
</script>

<script type="text/javascript">
  $(document).ready(function() {
    $("#ru_link").click(
      function(e) {
        e.stopPropagation();
        document.cookie = "language=ru;path=/";
      }
    );
  });
</script>