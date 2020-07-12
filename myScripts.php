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

    function sumTotalPriceOfCart() {
      var totalCartPrice = 0;
      document.getElementsByName('item_total_price').forEach((el) => {
        totalCartPrice += Number(el.innerText.substring(0, el.innerText.length - 2))
      });
      document.getElementById("cart_total_price").innerHTML = totalCartPrice + " ₴";
    };

    function changeItemButtons(item) {

      var itemMinusButton = item.parentNode.childNodes[1].childNodes[1];
      var itemPlusButton = item.parentNode.childNodes[5].childNodes[1];

      if (item.value <= 1) {
        itemMinusButton.disabled = true;
      } else {
        itemMinusButton.disabled = false;
      }

      if (item.value >= 999) {
        itemPlusButton.disabled = true;
      } else {
        itemPlusButton.disabled = false;
      }
    }

    function cartItemPlus(itemId, itemPrice, itemCount, itemTotalPrice, verificationToken) {

      itemCount.value++;
      itemTotalPrice.innerHTML = ((itemCount.value * itemPrice) + " ₴");
      changeItemButtons(itemCount);
      sumTotalPriceOfCart();

      formData = {
        'verification_token': verificationToken,
        'pricelistID': itemId,
        'count': itemCount.value
      };
      $.ajax({
        type: "POST",
        url: "functions/changeCart.php",
        data: formData,
        success: function(response) {
          if (response != null) {

            // parse response from server
            var jsonData = JSON.parse(response);
            if (jsonData.success == true) {} else {
              itemCount.value = jsonData.count;
              itemTotalPrice.innerHTML = ((itemCount.value * itemPrice) + " ₴");
            }
            changeItemButtons(itemCount);
            sumTotalPriceOfCart();
          }
        },
        error: function(data) {
          console.log('An error occurred.');
          console.log(data);
        },
      });
    };

    function cartItemMinus(itemId, itemPrice, itemCount, itemTotalPrice, verificationToken) {
      itemCount.value--;
      itemTotalPrice.innerHTML = ((itemCount.value * itemPrice) + " ₴");
      changeItemButtons(itemCount);
      sumTotalPriceOfCart();

      formData = {
        'verification_token': verificationToken,
        'pricelistID': itemId,
        'count': itemCount.value
      };
      $.ajax({
        type: "POST",
        url: "functions/changeCart.php",
        data: formData,
        success: function(response) {
          if (response != null) {

            // parse response from server
            var jsonData = JSON.parse(response);
            if (jsonData.success == true) {} else {
              itemCount.value = jsonData.count;
              itemTotalPrice.innerHTML = ((itemCount.value * itemPrice) + " ₴");
            }
            changeItemButtons(itemCount);
            sumTotalPriceOfCart();
          }
        },
        error: function(data) {
          console.log('An error occurred.');
          console.log(data);
        },
      });
    };

    function cartCountInputChange(itemId, itemPrice, itemCount, itemTotalPrice, verificationToken) {

      itemTotalPrice.innerHTML = ((itemCount.value * itemPrice) + " ₴");
      changeItemButtons(itemCount);
      sumTotalPriceOfCart();

      formData = {
        'verification_token': verificationToken,
        'pricelistID': itemId,
        'count': itemCount.value
      };
      $.ajax({
        type: "POST",
        url: "functions/changeCart.php",
        data: formData,
        success: function(response) {
          if (response != null) {

            // parse response from server
            var jsonData = JSON.parse(response);
            if (jsonData.success == true) {} else {
              itemCount.value = jsonData.count;
              itemTotalPrice.innerHTML = ((itemCount.value * itemPrice) + " ₴");
            }
            changeItemButtons(itemCount);
            sumTotalPriceOfCart();
          }
        },
        error: function(data) {
          console.log('An error occurred.');
          console.log(data);
        },
      });
    };

    function productBuyButton(itemId, itemPrice, itemCount, itemImage, verificationToken) {
      formData = {
        'verification_token': verificationToken,
        'pricelistID': itemId,
        'count': itemCount
      };
      $.ajax({
        type: "POST",
        url: "functions/addItemToCart.php",
        data: formData,
        success: function(response) {
          if (response != null) {

            // parse response from server
            var jsonData = JSON.parse(response);
            if (jsonData.success == true) {
              cartTotalPrice = (itemCount * Number(itemPrice));
              const itemHTML =
                `<div class="card mb-md-3 mb-3" id="item_card_${itemId}">
                  <div class="card-body row">
                    <div class="col-md-2 pr-0">
                      <a href="product.php?id=${itemId}">
                        <img class="m-auto" src="/${itemImage}" style="display: block; max-height: 120px; max-width: 100px;" alt="">
                      </a>
                    </div>
                    <div class="col-md-10">
                      <div class="container" style="height:120px">           
                        <div class="row" style="min-height:25%">
                          <div class="col-md-10">
                            <a style="font-size:20px;" href="product.php?id=${itemId}">${jsonData.itemName}</a>
                          </div>
                          <div class="col-md-2">
                            <svg width="30px" height="30px" style="float:right;" viewBox="0 0 16 16" onclick="deleteItemFromCart(${itemId}, document.getElementById('item_card_${itemId}'), '${verificationToken}')" class="my-svg my-button bi bi-x-circle text-danger" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                              <path class="defaultSVG" fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                              <path class="defaultSVG" fill-rule="evenodd" d="M11.854 4.146a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708-.708l7-7a.5.5 0 0 1 .708 0z"/>
                              <path class="defaultSVG" fill-rule="evenodd" d="M4.146 4.146a.5.5 0 0 0 0 .708l7 7a.5.5 0 0 0 .708-.708l-7-7a.5.5 0 0 0-.708 0z"/>
                              <path class="altSVG" fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.146-3.146a.5.5 0 0 0-.708-.708L8 7.293 4.854 4.146a.5.5 0 1 0-.708.708L7.293 8l-3.147 3.146a.5.5 0 0 0 .708.708L8 8.707l3.146 3.147a.5.5 0 0 0 .708-.708L8.707 8l3.147-3.146z"/>
                            </svg>
                          </div>                 
                        </div> 
                        <div class="row align-items-center divfillHeight">
                          <div class="col-md-5">
                            <div class="rounded-xl h5 mb-0" style="background: #D3D3D3; padding: 8 14 8 14; float:left;" id="item_price_${itemId}">${itemPrice} ₴</div>
                          </div>
                          <div class="col-md-4">
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <button class="btn btn-outline-secondary" style="padding: 6px;" type="button" onclick="cartItemMinus(${itemId}, ${itemPrice}, 
                                document.getElementById('item_count_${itemId}'), document.getElementById('item_total_price_${itemId}'), '${verificationToken}')">
                                  <svg width="26px" height="26px" viewBox="0 0 16 16" class="bi bi-dash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M3.5 8a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.5-.5z"/>
                                  </svg>
                                </button>
                              </div>
                              <input type="number" name="item_count" class="form-control" style="font-size: 1.25rem; font-weight: 500; height:40px;" id="item_count_${itemId}" value="${itemCount}" min="1" max="999"
                                oninput="cartCountInputChange(${itemId}, ${itemPrice}, document.getElementById('item_count_${itemId}'), document.getElementById('item_total_price_${itemId}'), '${verificationToken}')">
                              <div class="input-group-append">
                                <button class="btn btn-outline-secondary" style="padding: 6px;" type="button" onclick="cartItemPlus(${itemId}, ${itemPrice}, 
                                  document.getElementById('item_count_${itemId}'), document.getElementById('item_total_price_${itemId}'), '${verificationToken}')">
                                  <svg width="26px" height="26px" viewBox="0 0 16 16" class="bi bi-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 3.5a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5H4a.5.5 0 0 1 0-1h3.5V4a.5.5 0 0 1 .5-.5z"/>
                                    <path fill-rule="evenodd" d="M7.5 8a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1H8.5V12a.5.5 0 0 1-1 0V8z"/>
                                  </svg>
                                </button>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="rounded-xl h5 mb-0" style="background: #D3D3D3; padding: 8 14 8 14; float:right;" name="item_total_price" id="item_total_price_${itemId}">${cartTotalPrice} ₴</div>
                          </div>
                        </div>                        
                      </div>
                      </div>
                  </div>     
                </div>`;
              if (document.getElementById('cartContent') == null) {
                const cartStartHTML =
                  `<div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="cartModalLabel">Кошик</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div id="cartContent" class="container" style="padding:0">`;

                const cartEndHTML =
                  `</div>
                    <div class="row">
                      <div class="col-md-12" style="padding: 0 36 0 0;">          
                        <div id="cart_total_price" class="rounded-xl h5 mb-0" style="background: #D3D3D3; padding: 8 14 8 14; float:right;">${cartTotalPrice} ₴</div>
                        <div class="h5 mb-0" style=" padding: 8 14 8 14; float:right;">Разом:</div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрити</button>
                    <button type="button" class="btn btn-dark" data-dismiss="modal">Оформити замовлення</button>
                  </div>
                  </div>
                  </div>`
                document.getElementById('cartModal').innerHTML = (cartStartHTML + itemHTML + cartEndHTML);
              } else {
                document.getElementById('cartContent').insertAdjacentHTML('beforeend', itemHTML);
              }

              sumTotalPriceOfCart();
              var cartCountSpan = document.getElementById('cart_count_span');
              var cartCount = Number(cartCountSpan.innerText);
              cartCount++;
              cartCountSpan.innerText = cartCount;
            } else {}
            $('#cartModal').modal();
          }
        },
        error: function(data) {
          console.log('An error occurred.');
          console.log(data);
        },
      });
    };

    function deleteItemFromCart(itemId, itemCard, verificationToken) {
      removedChild = document.getElementById('cartContent').removeChild(itemCard);
      formData = {
        'verification_token': verificationToken,
        'pricelistID': itemId
      };
      $.ajax({
        type: "POST",
        url: "functions/deleteItemFromCart.php",
        data: formData,
        success: function(response) {
          if (response != null) {
            // parse response from server
            var jsonData = JSON.parse(response);
            if (jsonData.success == true) {
              sumTotalPriceOfCart();
              var cartCountSpan = document.getElementById('cart_count_span');
              var cartCount = Number(cartCountSpan.innerText);
              cartCount--;
              cartCountSpan.innerText = cartCount;
              if (cartCount == 0) {
                const emptyCartHTML =
                  `<div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="cartModalLabel">Кошик</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body" style="margin:auto;">
                        <svg width="40px" height="40px" viewBox="0 0 16 16" class="bi bi-cart d-inline" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                          <path fill-rule="evenodd" d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm7 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                        </svg>
                        <p class="align-middle d-inline" style="margin:auto; font-size:24px;">Кошик порожній</p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрити</button>
                      </div>
                    </div>
                </div>`;

                document.getElementById('cartModal').innerHTML = emptyCartHTML;
              }
            } else {
              document.getElementById('cartContent').appendChild(removedChild);
            }
          }
        },
        error: function(data) {
          console.log('An error occurred.');
          console.log(data);
        },
      });
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
      inputRemoveValidationStatus(document.getElementById("login_email"));
      inputRemoveValidationStatus(document.getElementById("login_password"));

      inputRemoveValidationStatus(document.getElementById("register_email"));
      inputRemoveValidationStatus(document.getElementById("register_password"));
      inputRemoveValidationStatus(document.getElementById("register_repeat_password"));

      inputRemoveValidationStatus(document.getElementById("register_confirmation_email_code"));
      inputRemoveValidationStatus(document.getElementById("register_confirmation_last_name"));
      inputRemoveValidationStatus(document.getElementById("register_confirmation_first_name"));
      inputRemoveValidationStatus(document.getElementById("register_confirmation_middle_name"));
      inputRemoveValidationStatus(document.getElementById("register_confirmation_phone"));

      inputRemoveValidationStatus(document.getElementById("remember_email"));

      inputRemoveValidationStatus(document.getElementById("reset_password_email"));
      inputRemoveValidationStatus(document.getElementById("reset_password_password"));
      inputRemoveValidationStatus(document.getElementById("reset_password_repeat_password"));
    }
  }

  // forms section
  {
    var loginForm = $('#loginForm');
    loginForm.submit(function(e) {

      // give data from form
      formData = {
        'verification_token': document.getElementById("login_verification_token").value,
        'email': document.getElementById("login_email").value,
        'password': document.getElementById("login_password").value
      };
      e.preventDefault();

      // ajax request
      $.ajax({
        type: "POST",
        url: "functions/login.php",
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
        'verification_token': document.getElementById("register_verification_token").value,
        'email': document.getElementById("register_email").value,
        'password': document.getElementById("register_password").value,
        'repeat_password': document.getElementById("register_repeat_password").value
      };
      e.preventDefault();

      // ajax request
      $.ajax({
        type: "POST",
        url: "functions/registerStart.php",
        data: formData,
        success: function(response) {
          if (response != null) {

            // parse response from server
            var jsonData = JSON.parse(response);

            // if success code is true login and reload
            if (jsonData.success == true) {
              $('#registerModal').modal('hide');
              document.getElementById("register_confirmation_email").value = document.getElementById("register_email").value;
              document.getElementById("register_confirmation_password").value = document.getElementById("register_password").value;
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
        'verification_token': document.getElementById("register_confirmation_verification_token").value,
        'email': document.getElementById("register_confirmation_email").value,
        'last_name': document.getElementById("register_confirmation_last_name").value,
        'first_name': document.getElementById("register_confirmation_first_name").value,
        'middle_name': document.getElementById("register_confirmation_middle_name").value,
        'phone': document.getElementById("register_confirmation_phone").value,
        'password': document.getElementById("register_confirmation_password").value,
        'email_code': document.getElementById("register_confirmation_email_code").value
      };
      e.preventDefault();

      // ajax request
      $.ajax({
        type: "POST",
        url: "functions/registerConfirmation.php",
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

              changeInputStatus(email_code, email_code_feedback, jsonData, "email_code");
              changeInputStatus(document.getElementById("register_confirmation_first_name"),
                document.getElementById("register_confirmation_first_name_feedback"), jsonData, "first_name");
              changeInputStatus(document.getElementById("register_confirmation_last_name"),
                document.getElementById("register_confirmation_last_name_feedback"), jsonData, "last_name");
              changeInputStatus(document.getElementById("register_confirmation_middle_name"),
                document.getElementById("register_confirmation_middle_name_feedback"), jsonData, "middle_name");
              changeInputStatus(document.getElementById("register_confirmation_phone"),
                document.getElementById("register_confirmation_phone_feedback"), jsonData, "phone");

              if (jsonData.hasOwnProperty("expired") && jsonData.expired != '') {
                email_code.classList.add('is-invalid');
                email_send_code.hidden = false;
                email_code_feedback.innerHTML = jsonData.expired;
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
        'verification_token': document.getElementById("remember_verification_token").value,
        'email': document.getElementById("remember_email").value,
      };
      e.preventDefault();

      // ajax request
      $.ajax({
        type: "POST",
        url: "functions/remember.php",
        data: formData,
        success: function(response) {
          if (response != null) {

            // parse response from server
            var jsonData = JSON.parse(response);

            // if success code is true login and reload
            if (jsonData.success == true) {
              $('#rememberModal').modal('hide');
              document.getElementById("reset_password_email").value = document.getElementById("remember_email").value;
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
        'verification_token': document.getElementById("reset_password_verification_token").value,
        'email': document.getElementById("reset_password_email").value,
        'email_code': document.getElementById("reset_password_email_code").value,
        'password': document.getElementById("reset_password_password").value,
        'repeat_password': document.getElementById("reset_password_repeat_password").value
      };
      e.preventDefault();

      // ajax request
      $.ajax({
        type: "POST",
        url: "functions/resetPassword.php",
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
            'verification_token': document.getElementById("logout_verification_token").value,
          };
          e.preventDefault();

          // ajax request
          $.ajax({
            type: "POST",
            url: "functions/logout.php",
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
            'verification_token': document.getElementById("register_confirmation_verification_token").value,
            'email': document.getElementById("register_confirmation_email").value,
            'password': document.getElementById("register_confirmation_password").value,
            'repeat_password': document.getElementById("register_confirmation_password").value
          };
          e.preventDefault();

          // ajax request
          $.ajax({
            type: "POST",
            url: "functions/registerStart.php",
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

  {
    $.fn.fillHeight = function() {

      this.each(function() {
        var siblingsHeight = 0;
        $(this).siblings().each(function() {
          siblingsHeight += $(this).height();
        });

        var height = $(this).parent().height() - siblingsHeight;
        $(this).height(height);
      });
    };


    $.fn.fillWidth = function() {

      this.each(function() {
        var siblingsWidth = 0;
        $(this).siblings().each(function() {
          siblingsWidth += $(this).width();
        });

        var width = $(this).parent().width() - siblingsWidth;
        $(this).width(width);
      });
    }

    $('#cartModal').on('shown.bs.modal', function() {
      $(".divfillHeight").fillHeight();
      $(".divfillWidth").fillWidth();
      document.getElementsByName('item_count').forEach((el) => {
        changeItemButtons(el);
      });

    });

    window.onresize = function(event) {
      $(".divfillHeight").fillHeight();
      $(".divfillWidth").fillWidth();
    }
  }
</script>