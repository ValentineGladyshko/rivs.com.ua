<?php
// function to get cart button
function get_cart_button_html($email, $is_authorized)
{
  $empty_cart_button_html =
    '<li class="nav-item">
      <button class="btn btn-outline-warning rounded-lg" data-toggle="modal" data-target="#cartModal" style="padding: 5 8 5 8;">
        <svg width="28px" height="28px" viewBox="0 0 16 16" class="bi bi-cart-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" d="M11.354 5.646a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L8 8.293l2.646-2.647a.5.5 0 0 1 .708 0z" />
          <path fill-rule="evenodd" d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm7 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
        </svg>
        <div class="align-middle d-inline">
          <span class="badge badge-light">0</span>
        </div>
      </button>
    </li>';
  $cart_button_html = '';
  if ($is_authorized == true) {
    $mysqli = mysqli_connect("localhost", "AuthorizedUser", "pWNqyljrhML90CHc", "rivs");
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
              <button class="btn btn-outline-warning rounded-lg" data-toggle="modal" data-target="#cartModal" style="padding: 5 8 5 8;">
                <svg width="28px" height="28px" viewBox="0 0 16 16" class="bi bi-cart-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M11.354 5.646a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L8 8.293l2.646-2.647a.5.5 0 0 1 .708 0z" />
                  <path fill-rule="evenodd" d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm7 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                </svg>
                <div class="align-middle d-inline">
                  <span class="badge badge-light">%s</span>
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
    return $empty_cart_button_html;
  }
}

// function to get cart modal
function get_cart_modal_html($email, $is_authorized)
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
    $mysqli = mysqli_connect("localhost", "AuthorizedUser", "pWNqyljrhML90CHc", "rivs");
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
              <div class="modal-body container">';
      if ($stmt = $mysqli->prepare("SELECT `cart_items`.`PriceListID`, ProductName, Price, `Image`, `Count` FROM cart_items JOIN `pricelist` ON `cart_items`.`PriceListID` = `pricelist`.`PriceListID` WHERE UserID=?")) {
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $stmt->bind_result($pricelistID, $product_name, $price, $image, $count);
        while ($stmt->fetch()) {
          if ($image != null) {
            $cart_modal_html .= sprintf(
              '<div class="card mb-md-3 mb-3">
                <div class="card-body row">
                  <div class="col-md-auto">
                    <a href="product.php?id=%s">
                      <img class="img-fluid mx-auto" src="/%s" style="height: 120px; margin:auto; padding: 0 20 0 20" alt="">
                    </a>
                  </div>
                  <div class="col-md-10">           
                    <div class="row" style="height:25%%">
                      <a style="font-size:20px;" href="product.php?id=%s">%s</a>
                    </div> 
                    <div class="row align-items-center" style="height:75%%">
                      <div class="col-md-8">
                        <div class="rounded-lg h5" style="background: #D3D3D3; padding: 8 14 8 14; float:left;">%s ₴</div>
                      </div>
                      <div class="col-md-2">
                        <h5>%s</h5>
                      </div>

                      <div class="col-md-2">
                        <div class="rounded-lg h5" style="background: #D3D3D3; padding: 8 14 8 14; float:right;">%s ₴</div>
                      </div>
                    </div>                        
                  </div>
                </div>     
              </div>',
              $pricelistID,
              $image,
              $pricelistID,
              $product_name,
              $price,
              $count,
              ($count * $price)
            );
          }
        }
        $stmt->close();
      }
      $cart_modal_html .=
        '</div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрити</button>
              </div>
            </div>
          </div>
        </div>';
    }
    $mysqli->close();
    return $cart_modal_html != '' ? $cart_modal_html : $empty_cart_modal_html;
  } else {
    return $empty_cart_modal_html;
  }
}

// function for making db query
function store($query)
{
  $mysqli = mysqli_connect("localhost", "RegisterUser", "E9aZc4DgpWEaRlY2", "rivs");
  if ($mysqli->connect_errno) {
    exit();
  }
  $mysqli->set_charset("utf8");
  if ($result = mysqli_query($mysqli, $query)) {
    $html = '';
    while ($row = $result->fetch_assoc()) {
      if ($row['Image'] != null) {
        $html .= sprintf(
          '<div class="col-lg-4 col-md-6 mb-md-3 mb-3">
            <div class="card" style="height:100%%;">
              <div class="view overlay zoom">
                <a href="product.php?id=%s">
                  <img class="img-fluid mx-auto" src="/%s" style="max-height: 400px; padding:20px" alt="">
                </a>
              </div>
              <div class="card-body text-center">
                <h5 class="card-title">%s</h5>%s
              </div>
              <a href="product.php?id=%s" class="btn mybtn btn-bottom-outline-info-dark-green rounded" style="margin: auto; margin-bottom:1.5rem;">Детальніше</a>%s
            </div>
          </div>',
          $row['PriceListID'],
          $row['Image'],
          $row['ProductName'],
          (($row['Price'] != 0) ?
            ('<b class="text-center" style="margin: auto; margin-bottom:1.5rem; width: 8rem;">Ціна – ' . $row['Price'] . ' ₴</b>') : ''),
          $row['PriceListID'],
          (($row['ProductAvailability'] == 0) ?
            ('<a href="product.php?id=' . $row['PriceListID'] . '" class="text-center bd-highlight" style="margin: auto; margin-bottom:1.5rem; width: 8rem;">Немає тари</a>') : '')
        );
      }
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

function product($query, $id)
{
  $mysqli = mysqli_connect("localhost", "RegisterUser", "E9aZc4DgpWEaRlY2", "rivs");
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
      $info
    );
    if ($stmt->fetch()) {
      $html = '';
      if ($image != null) {
        $html .= sprintf(
          '<div class="col-md-4">
            <div class="text-center">
              <img src="/%s" class="img-fluid center mx-auto" style="max-height: 500px;" alt="">
            </div>
            <div class="text-center" style="margin: auto; margin-bottom:1.5rem;">
              <p>Замовити можна по телефону</p>
              <p>%s</p>
            </div>
            <div class="text-center">
              <button type="button" class="btn btn-primary btn-lg" style="width:150px">Купити</button>
            </div>
          </div>
          <div class="col-md-8">
            <h2 class="h1-responsive font-weight-bold text-center my-4">%s</h2>
            %s%s%s%s%s%s%s%s%s
            <div class="text-justify w-responsive mx-auto mb-5">%s</div>',
          $image,
          (($price != 0) ? ('<b>Ціна – ' . $price . ' ₴</b>') : ''),
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
    }
    $stmt->close();
  }
  $mysqli->close();
  return $html;
}

function my_session_start()
{
  session_start();

  if (isset($_SESSION['deleted_time'])) {
    // if session was deleted more than 5 minutes ago destroy it and another one
    if ($_SESSION['deleted_time'] < time() - 300) {
      session_destroy();
      session_start();

      // set expired date 1 day for new session
      $_SESSION['expired'] = time() + 60 * 60 * 24;
    }

    // if session was deleted during regeneration but new doesn't started 
    if (isset($_SESSION['new_session_id'])) {

      // close old session
      session_commit();

      // generate new session with new id
      session_id($_SESSION['new_session_id']);
      session_start();

      // delete unnecessary variable from session
      unset($_SESSION['new_session_id']);

      // set expired date 1 day for new session
      $_SESSION['expired'] = time() + 60 * 60 * 24;
      return;
    }
  } else if (isset($_SESSION['expired'])) {
    // if session was expired but not deleted
    if ($_SESSION['expired'] < time()) {

      // give email and security token from session and cookies
      $email = $_SESSION["email"];
      $security_token = $_SESSION["security_token"];
      $security_token1 = $_COOKIE["security_token"];

      // if some token empty create new empty session
      if ($security_token == null || $security_token1 == null) {
        my_session_regenerate_id();
      }

      // if security tokens are equal create new authorized session
      else if (hash_equals($security_token, $security_token1)) {

        // create new session with email prefix
        my_session_regenerate_id_with_prefix($email);

        // set email into session
        $_SESSION["email"] = $email;

        // generate new security token
        $security_token = base64_encode(openssl_random_pseudo_bytes(32));

        // write token to session and cookie
        $_SESSION['security_token'] = $security_token;
        setcookie('security_token', $security_token, time() + 60 * 60 * 24 * 30, '/', 'rivs.com.ua', false, true);
      } else {

        // if session security token is incorrect create new empty session
        my_session_regenerate_id();
      }
    }
  }
}

function my_session_regenerate_id()
{
  // if session doesn't started start new one
  if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
  }

  // give nonauthorized prefix for id
  $new_session_id = session_create_id('NonAuth-');

  // set id and deleted_time to variables and save session for case of unstable internet connection
  $_SESSION['new_session_id'] = $new_session_id;
  $_SESSION['deleted_time'] = time();
  session_commit();

  // set new session id
  session_id($new_session_id);

  // change ini settings to change session
  ini_set('session.use_strict_mode', 0);
  session_start();

  // delete variable deleted time
  unset($_SESSION['deleted_time']);
  session_write_close();

  // return ini settings to the previous state
  ini_set('session.use_strict_mode', 1);

  session_start();
  // set expired date 1 day for new session
  $_SESSION['expired'] = time() + 60 * 60 * 24;
}

function my_session_regenerate_id_with_prefix($prefix)
{
  // if session doesn't started start new one
  if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
  }

  // create new session_id with prefix with email
  $new_session_id = session_create_id(preg_replace("/[^A-Za-z0-9 ]/", '', base64_encode($prefix)) . "-");

  // set id and deleted_time to variables and save session for case of unstable internet connection
  $_SESSION['new_session_id'] = $new_session_id;
  $_SESSION['deleted_time'] = time();
  session_commit();

  session_id($new_session_id);

  // change ini settings to change session
  ini_set('session.use_strict_mode', 0);
  session_start();

  unset($_SESSION['deleted_time']);
  session_write_close();

  // return ini settings to the previous state
  ini_set('session.use_strict_mode', 1);
  session_start();

  // set expired date 1 day for new session
  $_SESSION['expired'] = time() + 60 * 60 * 24;
}
