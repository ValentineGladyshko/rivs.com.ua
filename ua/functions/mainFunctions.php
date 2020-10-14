<?php
// function to get cart button
function get_cart_button_html($email, $is_authorized)
{
  $empty_cart_button_html =
    '<li class="nav-item">
      <button class="btn btn-outline-warning rounded-xl" data-toggle="modal" data-target="#cartModal" style="padding: 5 8 5 8;">
        <svg width="28px" height="28px" viewBox="0 0 16 16" class="bi bi-cart-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" d="M11.354 5.646a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L8 8.293l2.646-2.647a.5.5 0 0 1 .708 0z" />
          <path fill-rule="evenodd" d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm7 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
        </svg>
        <div class="align-middle d-inline">
          <span id="cart_count_span" class="badge badge-light">0</span>
        </div>
      </button>
    </li>';
  $cart_button_html = '';
  if ($is_authorized == true) {
    $mysqli = mysqli_connect("localhost", "chba7f54c7_LDLRIVS", "8e5cktmvx6", "chba7f54c7_LDLRIVS");
    if ($mysqli->connect_errno) {
      return $empty_cart_button_html;
    }

    if ($stmt = $mysqli->prepare("SELECT UserID FROM passwords WHERE UserLogin=?")) {
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $stmt->bind_result($userID);
      $stmt->fetch();
      $stmt->close();
    }
    if ($userID != null) {
      if ($stmt = $mysqli->prepare("SELECT Count(`PriceListID`) FROM cart_items WHERE UserID=?")) {
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $stmt->bind_result($count);
        if ($stmt->fetch()) {
          $cart_button_html = sprintf(
            '<li class="nav-item">
              <button class="btn btn-outline-warning rounded-xl" data-toggle="modal" data-target="#cartModal" style="padding: 5 8 5 8;">
                <svg width="28px" height="28px" viewBox="0 0 16 16" class="bi bi-cart-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M11.354 5.646a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L8 8.293l2.646-2.647a.5.5 0 0 1 .708 0z" />
                  <path fill-rule="evenodd" d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm7 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                </svg>
                <div class="align-middle d-inline">
                  <span id="cart_count_span" class="badge badge-light">%s</span>
                </div>
              </button>
            </li>',
            $count
          );
        }
        $stmt->close();
      }
    }
    $mysqli->close();
    return $cart_button_html != '' ? $cart_button_html : $empty_cart_button_html;
  } else {
    $cart = $_COOKIE["cart"];
    if ($cart != null) {
      $cart = json_decode($cart, true);
      $cart_button_html = sprintf(
        '<li class="nav-item">
          <button class="btn btn-outline-warning rounded-xl" data-toggle="modal" data-target="#cartModal" style="padding: 5 8 5 8;">
            <svg width="28px" height="28px" viewBox="0 0 16 16" class="bi bi-cart-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M11.354 5.646a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L8 8.293l2.646-2.647a.5.5 0 0 1 .708 0z" />
              <path fill-rule="evenodd" d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm7 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
            </svg>
            <div class="align-middle d-inline">
              <span id="cart_count_span" class="badge badge-light">%s</span>
            </div>
          </button>
        </li>',
        count($cart)
      );
      return $cart_button_html != '' ? $cart_button_html : $empty_cart_button_html;
    } else {
      return $empty_cart_button_html;
    }
  }
}

function penny_price_to_normal_price($penny_price)
{
  if ($penny_price < 100) {
    $normal_price = sprintf("%03d", $penny_price);
    $str = substr_replace($normal_price, '.', (strlen($normal_price) - 2), 0);
    return $str;
  } else {
    $normal_price = sprintf("%d", $penny_price);
    $str = substr_replace($normal_price, '.', (strlen($normal_price) - 2), 0);
    return $str;
  }
}

function text_status_color($statusId)
{
  if ($statusId == 1) {
    return "text-body";
  } elseif ($statusId == 2) {
    return "text-primary";
  } elseif ($statusId == 3) {
    return "text-primary";
  } elseif ($statusId == 4) {
    return "text-info";
  } elseif ($statusId == 5) {
    return "text-success";
  } elseif ($statusId == 6) {
    return "text-danger";
  } else {
    return "text-body";
  }
}
// function to get cart modal
function get_cart_modal_html($email, $is_authorized, $verification_token)
{
  $empty_cart_modal_html =
    '<div class="modal fade" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="cartModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
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
      </div>
    </div>';
  $cart_modal_html = '';
  if ($is_authorized == true) {
    $mysqli = mysqli_connect("localhost", "chba7f54c7_LDLRIVS", "8e5cktmvx6", "chba7f54c7_LDLRIVS");
    if ($mysqli->connect_errno) {
      return $empty_cart_modal_html;
    }

    if ($stmt = $mysqli->prepare("SELECT UserID FROM passwords WHERE UserLogin=?")) {
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $stmt->bind_result($userID);
      $stmt->fetch();
      $stmt->close();
    }
    if ($userID != null) {
      if ($stmt = $mysqli->prepare("SELECT Count(`PriceListID`) FROM cart_items WHERE UserID=?")) {
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $stmt->bind_result($total_count);
        $stmt->fetch();
        $stmt->close();
      }
      if ($total_count == 0)
        return $empty_cart_modal_html;

      $cart_price = 0;
      $cart_modal_html =
        '<div class="modal fade" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="cartModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="cartModalLabel">Кошик</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div id="cartContent" class="container" style="padding:0">';
      if ($stmt = $mysqli->prepare("SELECT `cart_items`.`PriceListID`, ProductName, Price, `Image`, `Count` FROM cart_items JOIN `pricelist` ON `cart_items`.`PriceListID` = `pricelist`.`PriceListID` WHERE UserID=?")) {
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $stmt->bind_result($pricelistID, $product_name, $price, $image, $count);
        while ($stmt->fetch()) {
          if ($image != null) {
            $cart_price += ($count * $price);
            $cart_modal_html .= sprintf(
              '<div class="card mb-md-3 mb-3" id="item_card_%1$s">
                <div class="card-body row">
                  <div class="col-lg-2 col-12 pr-0">
                    <a href="product.php?id=%1$s">
                      <img src="/%2$s" class="m-auto" style="display: block; max-height: 120px; max-width: 100px;" alt="">
                    </a>
                  </div>
                  <div class="col-lg-10 col-12">
                    <div class="container pr-0 pl-1" style="min-height:120px">           
                      <div class="row" style="min-height:25%%">
                        <div class="col-lg-11 col-sm-10 col-10 pr-0">
                          <a style="font-size:20px;" href="product.php?id=%1$s">%3$s</a>
                        </div>
                        <div class="col-lg-1 col-sm-2 col-2 pl-0">
                          <svg width="30px" height="30px" style="float:right;" viewBox="0 0 16 16" onclick="deleteItemFromCart(`%1$s`, document.getElementById(`item_card_%1$s`), `%7$s`)" class="my-svg my-button bi bi-x-circle text-danger" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path class="defaultSVG" fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path class="defaultSVG" fill-rule="evenodd" d="M11.854 4.146a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708-.708l7-7a.5.5 0 0 1 .708 0z"/>
                            <path class="defaultSVG" fill-rule="evenodd" d="M4.146 4.146a.5.5 0 0 0 0 .708l7 7a.5.5 0 0 0 .708-.708l-7-7a.5.5 0 0 0-.708 0z"/>
                            <path class="altSVG" fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.146-3.146a.5.5 0 0 0-.708-.708L8 7.293 4.854 4.146a.5.5 0 1 0-.708.708L7.293 8l-3.147 3.146a.5.5 0 0 0 .708.708L8 8.707l3.146 3.147a.5.5 0 0 0 .708-.708L8.707 8l3.147-3.146z"/>
                          </svg>
                        </div>
                      </div> 
                      <div class="row align-items-lg-center minHeight90">
                        <div class="col-lg-4 col-sm-6">
                            <div class="h5 mb-0 pl-0 pr-3 py-2 float-left">Ціна:</div>
                          <div class="rounded-xl h5 mb-0 py-2 float-left" id="item_price_%1$s">%4$s ₴</div>
                        </div>
                        <div class="col-lg-4 col-sm-6 pr-lg-0 m-sm-0 my-2">
                          <div class="input-group float-sm-right" style="max-width:170px;">
                            <div class="input-group-prepend">
                              <button class="btn btn-outline-secondary" style="padding: 6px;" type="button" onclick="cartItemMinus(`%1$s`, `%4$s`, 
                              document.getElementById(`item_count_%1$s`), document.getElementById(`item_total_price_%1$s`), `%7$s`)">
                                <svg width="26px" height="26px" viewBox="0 0 16 16" class="bi bi-dash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                  <path fill-rule="evenodd" d="M3.5 8a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.5-.5z"/>
                                </svg>
                              </button>
                            </div>
                            <input type="number" name="item_count" class="form-control" style="font-size: 1.25rem; font-weight: 500; height:40px;" id="item_count_%1$s" value="%5$s" min="1" max="9999"
                              oninput="cartCountInputChange(`%1$s`, `%4$s`, document.getElementById(`item_count_%1$s`), document.getElementById(`item_total_price_%1$s`), `%7$s`)">
                            <div class="input-group-append">
                              <button class="btn btn-outline-secondary" style="padding: 6px;" type="button" onclick="cartItemPlus(`%1$s`, `%4$s`, 
                                document.getElementById(`item_count_%1$s`), document.getElementById(`item_total_price_%1$s`), `%7$s`)">
                                <svg width="26px" height="26px" viewBox="0 0 16 16" class="bi bi-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                  <path fill-rule="evenodd" d="M8 3.5a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5H4a.5.5 0 0 1 0-1h3.5V4a.5.5 0 0 1 .5-.5z"/>
                                  <path fill-rule="evenodd" d="M7.5 8a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1H8.5V12a.5.5 0 0 1-1 0V8z"/>
                                </svg>
                              </button>
                            </div>
                          </div>
                        </div>

                        <div class="col-lg-4 pl-sm-0">
                          <div class="rounded-xl h5 mb-0 py-2 float-sm-right float-left" name="item_total_price" id="item_total_price_%1$s">%6$s ₴</div>
                        </div>
                      </div>                        
                    </div>
                  </div>
                </div>     
              </div>',
              $pricelistID,
              $image,
              $product_name,
              penny_price_to_normal_price($price),
              $count,
              penny_price_to_normal_price($count * $price),
              $verification_token
            );
          }
        }
        $stmt->close();
      }
      $cart_modal_html .= sprintf(
        '</div>
        <div class="row">
          <div class="col-md-12 pr-3">          
            <div id="cart_total_price" class="rounded-xl h5 mb-0 px-3 py-2 float-right bg-grey-alt">%1$s ₴</div>
            <div class="h5 mb-0 px-3 py-2 float-right">Разом:</div>
          </div>
        </div>
      </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Продовжити покупки</button>
                <button type="button" class="btn btn-dark" data-dismiss="modal" onclick="checkoutCart(`%2$s`, true)">Оформити замовлення</button>
              </div>
            </div>
          </div>
        </div>',
        penny_price_to_normal_price($cart_price),
        $verification_token
      );
    }
    $mysqli->close();
    return $cart_modal_html != '' ? $cart_modal_html : $empty_cart_modal_html;
  } else {
    $cart = $_COOKIE["cart"];
    if ($cart != null) {
      $cart = json_decode($cart, true);

      $mysqli = mysqli_connect("localhost", "chba7f54c7_LDLRIVS", "8e5cktmvx6", "chba7f54c7_LDLRIVS");
      if ($mysqli->connect_errno) {
        return $empty_cart_modal_html;
      }

      $cart_price = 0;
      $cart_modal_html =
        '<div class="modal fade" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="cartModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="cartModalLabel">Кошик</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div id="cartContent" class="container" style="padding:0">';

      foreach ($cart as $value) {
        $count = $value["count"];
        if ($stmt = $mysqli->prepare("SELECT `PriceListID`, ProductName, Price, `Image` FROM `pricelist` WHERE `PriceListID`=?")) {
          $stmt->bind_param("i", $value["priceListID"]);
          $stmt->execute();
          $stmt->bind_result($pricelistID, $product_name, $price, $image);
          $stmt->fetch();
          if ($image != null) {
            $cart_price += ($count * $price);
            $cart_modal_html .= sprintf(
              '<div class="card mb-md-3 mb-3" id="item_card_%1$s">
                <div class="card-body row">
                  <div class="col-lg-2 col-12 pr-0 pr-0">
                    <a href="product.php?id=%1$s">
                      <img src="/%2$s" class="m-auto" style="display: block; max-height: 120px; max-width: 100px;" alt="">
                    </a>
                  </div>
                  <div class="col-lg-10 col-12">
                    <div class="container pr-0 pl-1" style="min-height:120px">           
                      <div class="row" style="min-height:25%%">
                        <div class="col-lg-11 col-sm-10 col-10 pr-0">
                          <a style="font-size:20px;" href="product.php?id=%1$s">%3$s</a>
                        </div>
                        <div class="col-lg-1 col-sm-2 col-2 pl-0">
                          <svg width="30px" height="30px" style="float:right;" viewBox="0 0 16 16" onclick="deleteItemFromCart(`%1$s`, document.getElementById(`item_card_%1$s`), `%7$s`)" class="my-svg my-button bi bi-x-circle text-danger" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path class="defaultSVG" fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path class="defaultSVG" fill-rule="evenodd" d="M11.854 4.146a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708-.708l7-7a.5.5 0 0 1 .708 0z"/>
                            <path class="defaultSVG" fill-rule="evenodd" d="M4.146 4.146a.5.5 0 0 0 0 .708l7 7a.5.5 0 0 0 .708-.708l-7-7a.5.5 0 0 0-.708 0z"/>
                            <path class="altSVG" fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.146-3.146a.5.5 0 0 0-.708-.708L8 7.293 4.854 4.146a.5.5 0 1 0-.708.708L7.293 8l-3.147 3.146a.5.5 0 0 0 .708.708L8 8.707l3.146 3.147a.5.5 0 0 0 .708-.708L8.707 8l3.147-3.146z"/>
                          </svg>
                        </div>
                      </div> 
                      <div class="row align-items-lg-center minHeight90">
                        <div class="col-lg-4 col-sm-6">
                          <div class="h5 mb-0 pl-0 pr-3 py-2 float-left">Ціна:</div>
                          <div class="rounded-xl h5 mb-0 py-2 float-left" id="item_price_%1$s">%4$s ₴</div>
                        </div>
                        <div class="col-lg-4 col-sm-6 pr-lg-0 m-sm-0 my-2">
                          <div class="input-group float-sm-right" style="max-width:170px;">
                            <div class="input-group-prepend">
                              <button class="btn btn-outline-secondary" style="padding: 6px;" type="button" onclick="cartItemMinus(`%1$s`, `%4$s`, 
                              document.getElementById(`item_count_%1$s`), document.getElementById(`item_total_price_%1$s`), `%7$s`)">
                                <svg width="26px" height="26px" viewBox="0 0 16 16" class="bi bi-dash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                  <path fill-rule="evenodd" d="M3.5 8a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.5-.5z"/>
                                </svg>
                              </button>
                            </div>
                            <input type="number" name="item_count" class="form-control" style="font-size: 1.25rem; font-weight: 500; height:40px;" id="item_count_%1$s" value="%5$s" min="1" max="9999"
                              oninput="cartCountInputChange(`%1$s`, `%4$s`, document.getElementById(`item_count_%1$s`), document.getElementById(`item_total_price_%1$s`), `%7$s`)">
                            <div class="input-group-append">
                              <button class="btn btn-outline-secondary" style="padding: 6px;" type="button" onclick="cartItemPlus(`%1$s`, `%4$s`, 
                                document.getElementById(`item_count_%1$s`), document.getElementById(`item_total_price_%1$s`), `%7$s`)">
                                <svg width="26px" height="26px" viewBox="0 0 16 16" class="bi bi-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                  <path fill-rule="evenodd" d="M8 3.5a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5H4a.5.5 0 0 1 0-1h3.5V4a.5.5 0 0 1 .5-.5z"/>
                                  <path fill-rule="evenodd" d="M7.5 8a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1H8.5V12a.5.5 0 0 1-1 0V8z"/>
                                </svg>
                              </button>
                            </div>
                          </div>
                        </div>

                        <div class="col-lg-4 pl-sm-0">
                          <div class="rounded-xl h5 mb-0 py-2 float-sm-right float-left" name="item_total_price" id="item_total_price_%1$s">%6$s ₴</div>
                        </div>
                      </div>                        
                    </div>
                  </div>
                </div>     
              </div>',
              $pricelistID,
              $image,
              $product_name,
              penny_price_to_normal_price($price),
              $count,
              penny_price_to_normal_price($count * $price),
              $verification_token
            );
          }
          $stmt->close();
        }
      }
      $cart_modal_html .= sprintf(
        '</div>
                <div class="row">
                  <div class="col-md-12 pr-3">          
                    <div id="cart_total_price" class="rounded-xl h5 mb-0 px-3 py-2 float-right bg-grey-alt">%1$s ₴</div>
                    <div class="h5 mb-0 px-3 py-2 float-right">Разом:</div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Продовжити покупки</button>
                <button type="button" class="btn btn-dark" data-dismiss="modal" onclick="checkoutCart(`%2$s`, true)">Оформити замовлення</button>
              </div>
            </div>
          </div>
        </div>',
        penny_price_to_normal_price($cart_price),
        $verification_token
      );
      return $cart_modal_html != '' ? $cart_modal_html : $empty_cart_modal_html;
    } else {
      return $empty_cart_modal_html;
    }
  }
}

// function for making db query
function store($query, $verification_token)
{
  $html = '';
  $mysqli = mysqli_connect("localhost", "chba7f54c7_LDLRIVS", "8e5cktmvx6", "chba7f54c7_LDLRIVS");
  if ($mysqli->connect_errno) {
    exit();
  }
  $mysqli->set_charset("utf8");
  if ($result = mysqli_query($mysqli, $query)) {
    while ($row = $result->fetch_assoc()) {
      $html .= sprintf(
        '<div class="col-lg-4 col-md-6 mb-md-3 mb-3">
            <div class="card" style="height:100%%;">
              <div class="view overlay zoom">
                <a href="product.php?id=%1$s">
                  <img class="img-fluid mx-auto" src="/%2$s" style="max-height: 400px; padding:20px" alt="">
                </a>
              </div>
              <div class="card-body text-center" style="padding-top:0; padding-bottom:0;">
                <h5 class="card-title" style="margin-bottom:0;">%3$s</h5>
              </div>%4$s
              <div class="container text-center">
                <div class="row">
                  %6$s
                  <div class="col">
                    <a href="product.php?id=%1$s" class="btn btn-dark" style="margin: auto; margin-bottom:1.5rem; height:42px;">Детальніше</a>
                  </div>
                </div>
              </div>
              %5$s
            </div>
          </div>',
        $row['PriceListID'],
        $row['Image'],
        $row['ProductName'],
        (($row['Price'] != 0) ?
          ('<b class="text-center" style="margin: auto; margin-top:1rem; margin-bottom:1rem;">Ціна – ' . penny_price_to_normal_price($row['Price']) . ' ₴</b>') : ''),
        (($row['ProductAvailability'] == 0) ?
          ('<p class="text-center bd-highlight" style="margin: auto; margin-bottom:1.5rem;">Немає в наявності</p>') : ''),
        (($row['ProductAvailability'] != 0) ?
          '<div class="col">
            <button id="productBuyButton'.$row['PriceListID'].'" type="button" class="btn btn-dark" style="margin: auto; margin-bottom:1.5rem;" onclick="productBuyButton(`' . $row['PriceListID'] . '`, `' . penny_price_to_normal_price($row['Price']) . '`, 1, `' . $row['Image'] . '`, `' . $verification_token . '`)">
              <span id="productBuyButtonSpinner'.$row['PriceListID'].'" style="width: 28px; height: 28px;"></span>
              <svg width="28px" height="28px" viewBox="0 0 16 16" class="bi bi-cart-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M8.5 5a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1H8V5.5a.5.5 0 0 1 .5-.5z"/>
                <path fill-rule="evenodd" d="M8 7.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1H9v1.5a.5.5 0 0 1-1 0v-2z"/>
                <path fill-rule="evenodd" d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm7 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
              </svg>
            </button>
          </div>'
          : '')
      );
    }
    $result->close();
  }
  $mysqli->close();
  return $html;
}

function empty_or_html($var)
{
  if ($var == null) {
    return '';
  } else return ('<div class="text-justify w-responsive mx-auto mb-5">' . $var . '</div>');
}

function product($query, $id, $verification_token)
{
  $mysqli = mysqli_connect("localhost", "chba7f54c7_LDLRIVS", "8e5cktmvx6", "chba7f54c7_LDLRIVS");
  if ($mysqli->connect_errno) {
    exit();
  }
  $mysqli->set_charset("utf8");
  if ($stmt = $mysqli->prepare($query)) {
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $stmt->bind_result(
      $image,
      $price,
      $product_name,
      $appointment,
      $properties,
      $structure,
      $application_method,
      $contraindications,
      $warnings,
      $storage_conditions,
      $expiration_date,
      $manufacturer,
      $info,
      $product_availability,
      $imageHighQuality
    );
    if ($stmt->fetch()) {

      $html = sprintf(
        '<div class="col-md-4">
            <div class="text-center">
              <img src="/%1$s" class="img-fluid center mx-auto" style="max-height: 500px;" alt="">
            </div>
            <div class="text-center" style="margin: auto; margin-bottom:1.5rem;">
              %3$s
              <p>%2$s</p>
            </div>',
        $image,
        (($price != 0) ? ('<b>Ціна – ' . penny_price_to_normal_price($price) . ' ₴</b>') : ''),
        (($imageHighQuality != null) ? ('<a href="/'. $imageHighQuality .'" target="_blank">Відкрити велике зображення</a>') : '')        
      );
      if ($product_availability == 1) {
        $html .= sprintf(
          '<div class="text-center">
              <button id="productBuyButton%1$s" type="button" class="btn btn-dark rounded-xl btn-lg" onclick="productBuyButton(`%1$s`, `%2$s`, 1, `%3$s`, `%4$s`)" style="width:200px">
                <span id="productBuyButtonSpinner%1$s" style="width: 28px; height: 28px;"></span>
                <svg width="28px" height="28px" viewBox="0 0 16 16" class="bi bi-cart-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M8.5 5a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1H8V5.5a.5.5 0 0 1 .5-.5z"/>
                  <path fill-rule="evenodd" d="M8 7.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1H9v1.5a.5.5 0 0 1-1 0v-2z"/>
                  <path fill-rule="evenodd" d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm7 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                </svg> Придбати
              </button>
            </div>',
          $id,
          penny_price_to_normal_price($price),
          $image,
          $verification_token
        );
      }

      $html .= sprintf(
        '</div>
        <div class="col-md-8">
          <h2 class="h1-responsive font-weight-bold text-center my-4">%1$s</h2>
          %2$s%3$s%4$s%5$s%6$s%7$s%8$s%9$s%10$s
          <div class="text-justify w-responsive mx-auto mb-5">%11$s</div>
        </div>',
        $product_name,
        empty_or_html($appointment),
        empty_or_html($properties),
        empty_or_html($structure),
        empty_or_html($application_method),
        empty_or_html($contraindications),
        empty_or_html($warnings),
        empty_or_html($storage_conditions),
        empty_or_html($expiration_date),
        empty_or_html($manufacturer),
        $info
      );
    }
    $stmt->close();
  }
  $mysqli->close();
  return $html;
}
