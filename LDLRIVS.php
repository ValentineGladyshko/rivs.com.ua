<?php

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
            ('<b class="text-center" style="margin: auto; margin-bottom:1.5rem; width: 8rem;">Ціна – ' . $row['Price'] . ' грн.</b>') : ''),
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
          </div>
          <div class="col-md-8">
            <h2 class="h1-responsive font-weight-bold text-center my-4">%s</h2>
            %s%s%s%s%s%s%s%s%s
            <div class="text-justify w-responsive mx-auto mb-5">%s</div>',
          $image,
          (($price != 0) ? ('<b>Ціна – ' . $price . ' грн.</b>') : ''),
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
