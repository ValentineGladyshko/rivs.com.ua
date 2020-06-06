<!-- Script for login form -->
<script type="text/javascript">
  var form = $('#login-form');

  form.submit(function(e) {

    // give data from form
    formData = {
      'verification_token': $('input[name=verification_token]').val(),
      'email': $('input[name=email]').val(),
      'password': $('input[name=password]').val()
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
            var email = document.getElementById("email");
            var password = document.getElementById("password");
            var email_feedback = document.getElementById("email_feedback");
            var password_feedback = document.getElementById("password_feedback");
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
  var email1 = document.getElementById("email1");
  email1.oninput = function() {
    email.classList.remove('is-invalid');
    email.classList.remove('is-valid');
  };

  var password1 = document.getElementById("password1");
  password1.oninput = function() {
    password1.classList.remove('is-invalid');
    password1.classList.remove('is-valid');
  };

  var repeat_password = document.getElementById("repeat_password");
  repeat_password.oninput = function() {
    repeat_password.classList.remove('is-invalid');
    repeat_password.classList.remove('is-valid');
  };

  var email = document.getElementById("email");
  email.oninput = function() {
    email.classList.remove('is-invalid');
    email.classList.remove('is-valid');
  };

  var password = document.getElementById("password");
  password.oninput = function() {
    password.classList.remove('is-invalid');
    password.classList.remove('is-valid');
  };
</script>

<!-- Script for register form -->
<script type="text/javascript">
  var form = $('#register-form');

  form.submit(function(e) {

    // give data from form
    formData = {
      'verification_token': $('input[name=verification_token]').val(),
      'email': $('input[name=email1]').val(),
      'password': $('input[name=password1]').val(),
      'repeat_password': $('input[name=repeat_password]').val()
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
            var email = document.getElementById("email1");
            var password = document.getElementById("password1");
            var repeat_password = document.getElementById("repeat_password");
            var email_feedback = document.getElementById("email1_feedback");
            var password_feedback = document.getElementById("password1_feedback");
            var repeat_password_feedback = document.getElementById("repeat_password_feedback");

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
          'verification_token': $('input[name=verification_token]').val(),
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