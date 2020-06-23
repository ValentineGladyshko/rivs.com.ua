<!-- Script for login form -->
<script type="text/javascript">
  // functions section
  {
    function passwordToggle(img, input) {
      if (input.type === "password") {
        input.type = "text";
        img.src = "/icons/eye-slash-fill.svg"
      } else {
        input.type = "password";
        img.src = "/icons/eye-fill.svg"
      }
    };

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

    function changeInputStatusArray(input, inputFeedback, jsonData, propertyName) {
      if (jsonData.hasOwnProperty(propertyName) && jsonData[propertyName] != '') {
        input.classList.add('is-invalid');
        input.classList.remove('is-valid');

        inputFeedback.innerHTML = "";
        var data;
        for (data of jsonData[propertyName]) {
          inputFeedback.innerHTML += ("<p>" + data + "</p>");
        }

      } else {
        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
      }
    };

    function changeInputGroupStatusArray(inputGroup, input, inputFeedback, jsonData, propertyName) {
      if (jsonData.hasOwnProperty(propertyName) && jsonData[propertyName] != '') {
        inputGroup.classList.add('is-invalid');
        inputGroup.classList.remove('is-valid');
        input.classList.add('is-invalid');
        input.classList.remove('is-valid');
        inputFeedback.innerHTML = "";
        var data;
        for (data of jsonData[propertyName]) {
          inputFeedback.innerHTML += ("<p>" + data + "</p>");
        }
      } else {
        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
        inputGroup.classList.remove('is-invalid');
        inputGroup.classList.add('is-valid');
      }
    };

    // function for delete valid and invalid classes from fields 
    function inputRemoveValidationStatus(input) {
      input.oninput = function() {
        input.classList.remove('is-invalid');
        input.classList.remove('is-valid');
      }
    }; {
      inputRemoveValidationStatus(document.getElementById("register_email"));
      inputRemoveValidationStatus(document.getElementById("register_password"));
      inputRemoveValidationStatus(document.getElementById("register_repeat_password"));
      inputRemoveValidationStatus(document.getElementById("reset_password_email"));
      inputRemoveValidationStatus(document.getElementById("reset_password_password"));
      inputRemoveValidationStatus(document.getElementById("reset_password_repeat_password"));
      inputRemoveValidationStatus(document.getElementById("login_email"));
      inputRemoveValidationStatus(document.getElementById("login_password"));
    }
  }

  // forms section
  {
    var loginForm = $('#loginForm');
    loginForm.submit(function(e) {

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
              changeInputStatus(document.getElementById("login_email"),
                document.getElementById("login_email_feedback"), jsonData, "email");
              changeInputGroupStatus(document.getElementById("login_password_group"),
                document.getElementById("login_password"),
                document.getElementById("login_password_feedback"), jsonData, "password")
            }
          }
        },
        error: function(data) {
          console.log('An error occurred.');
          console.log(data);
        },
      });
    });

    var registerForm = $('#registerForm');
    registerForm.submit(function(e) {

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
              $('#registerModal').modal('hide');
              document.getElementById("register_confirmation_email").value = $('input[name=register_email]').val();
              document.getElementById("register_confirmation_password").value = $('input[name=register_password]').val();
              $('#registerConfirmationModal').modal();

              // else give html fields and show error messages
            } else {
              changeInputStatusArray(document.getElementById("register_email"),
                document.getElementById("register_email_feedback"), jsonData, "email");
              changeInputGroupStatusArray(document.getElementById("register_password_group"),
                document.getElementById("register_password"),
                document.getElementById("register_password_feedback"), jsonData, "password");
              changeInputGroupStatusArray(document.getElementById("register_repeat_password_group"),
                document.getElementById("register_repeat_password"),
                document.getElementById("register_repeat_password_feedback"), jsonData, "repeat_password");
            }
          }
        },
        error: function(data) {
          console.log('An error occurred.');
          console.log(data);
        },
      });
    });

    var registerConfirmationForm = $('#registerConfirmationForm');
    registerConfirmationForm.submit(function(e) {

      // give data from form
      formData = {
        'verification_token': $('input[name=register_confirmation_verification_token]').val(),
        'email': $('input[name=register_confirmation_email]').val(),
        'password': $('input[name=register_confirmation_password]').val(),
        'email_code': $('input[name=register_confirmation_email_code]').val()
      };
      e.preventDefault();

      // ajax request
      $.ajax({
        type: "POST",
        url: "registerConfirmation.php",
        data: formData,
        success: function(response) {
          if (response != null) {
            var jsonData = JSON.parse(response);
            if (jsonData.success == true) {
              location.reload();

            } else {
              var send_code = document.getElementById("register_confirmation_send_code");
              var email_code = document.getElementById("register_confirmation_email_code");
              var email_code_feedback = document.getElementById("register_confirmation_email_code_feedback");

              changeInputStatusArray(email_code, email_code_feedback, jsonData, "email_code");

              if (jsonData.hasOwnProperty("expired") && jsonData.expired != '') {
                email_code.classList.add('is-invalid');
                email_send_code.hidden = false;
                email_code_feedback.innerHTML = jsonData.expired;
              } else {
                email_code.classList.remove('is-invalid');
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

    var rememberForm = $('#rememberForm');
    rememberForm.submit(function(e) {

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
              $('#rememberModal').modal('hide');
              document.getElementById("reset_password_email").value = $('input[name=remember_email]').val();
              $('#resetPasswordModal').modal();
              // else give html fields and show error messages
            } else {
              changeInputStatusArray(document.getElementById("remember_email"),
                document.getElementById("remember_email_feedback"), jsonData, "email")
            }
          }
        },
        error: function(data) {
          console.log('An error occurred.');
          console.log(data);
        },
      });
    });

    var resetPasswordForm = $('#resetPasswordForm');
    resetPasswordForm.submit(function(e) {

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
              changeInputStatus(document.getElementById("reset_password_email_code"),
                document.getElementById("reset_password_email_code_feedback"), jsonData, "email_code");
              changeInputGroupStatusArray(document.getElementById("reset_password_password_group"),
                document.getElementById("reset_password_password"),
                document.getElementById("reset_password_password_feedback"), jsonData, "password");
              changeInputGroupStatusArray(document.getElementById("reset_password_repeat_password_group"),
                document.getElementById("reset_password_repeat_password"),
                document.getElementById("reset_password_repeat_password_feedback"), jsonData, "repeat_password");
            }
          }
        },
        error: function(data) {
          console.log('An error occurred.');
          console.log(data);
        },
      });
    });
  }

  // buttons click event handlers section
  {
    // logout button
    $(document).ready(function() {
      $("#logoutButton").click(
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

    // account (user) button
    $(document).ready(function() {
      $("#userButton").click(
        function(e) {
          e.preventDefault();
          document.getElementById('userForm').submit();
        }
      );
    });

    // ua language button
    $(document).ready(function() {
      $("#uaLink").click(
        function(e) {
          e.stopPropagation();
          document.cookie = "language=ua;path=/";
        }
      );
    });

    // ru language button
    $(document).ready(function() {
      $("#ruLink").click(
        function(e) {
          e.stopPropagation();
          document.cookie = "language=ru;path=/";
        }
      );
    });

    // send code button

    $(document).ready(function() {
      $("#register_confirmation_send_code").click(
        function(e) {

          // give data from form
          formData = {
            'verification_token': $('input[name=register_confirmation_verification_token]').val(),
            'email': $('input[name=register_confirmation_email]').val(),
            'password': $('input[name=register_confirmation_password]').val(),
            'repeat_password': $('input[name=register_confirmation_password]').val()
          };
          e.preventDefault();

          // ajax request
          $.ajax({
            type: "POST",
            url: "registerStart.php",
            data: formData,
            success: function(data) {
              var send_code = document.getElementById("register_confirmation_send_code");
              var email_code = document.getElementById("register_confirmation_email_code");
              var email_code_feedback = document.getElementById("register_confirmation_email_code_feedback");
              send_code.hidden = true;
              email_code.classList.remove('is-invalid');
              email_code.value = "";
            },
            error: function(data) {
              console.log('An error occurred.');
              console.log(data);
            },
          });
        }
      );
    });
  }
</script>