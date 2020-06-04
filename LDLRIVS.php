<?php
function query_db($query)
{
  $mysqli = mysqli_connect("localhost", "ForHack", "kEHf5NAi", "LDLRIVS");
  $mysqli->set_charset("utf8");
  $res = mysqli_query($mysqli, $query);
  $rows = [];
  while ($row = $res->fetch_assoc()) {
    $rows[] = $row;
  }
  $res->close();
  $mysqli->close();
  return $rows;
}

function my_session_start()
{
  session_start();
  if (isset($_SESSION['deleted_time'])) {
    if ($_SESSION['deleted_time'] < time() - 300) {
      session_destroy();
      session_start();
      $_SESSION['expired'] = time() + 60 * 60 * 24;
    }
    if (isset($_SESSION['new_session_id'])) {
      session_commit();
      session_id($_SESSION['new_session_id']);
      session_start();
      unset($_SESSION['new_session_id']);
      $_SESSION['expired'] = time() + 60 * 60 * 24;
      return;
    }
  } else if (isset($_SESSION['expired'])) {
    if ($_SESSION['expired'] < time()) {

      $email = $_SESSION["email"];
      $security_token = $_SESSION["security_token"];
      $security_token1 = $_COOKIE["security_token"];
      if (hash_equals($security_token, $security_token1)) {
        my_session_regenerate_id_with_prefix($email);
        $_SESSION["email"] = $email;
        $security_token = base64_encode(openssl_random_pseudo_bytes(32));
        $_SESSION['security_token'] = $security_token;
        setcookie('security_token', $security_token, time()+60*60*24*30, '/', 'rivs.com.ua', false, true);
      } else {
        my_session_regenerate_id();
      }
    }
  }
}

function my_session_regenerate_id()
{
  if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
  }
  $new_session_id = session_create_id('NonAuth-');
  $_SESSION['new_session_id'] = $new_session_id;
  $_SESSION['deleted_time'] = time();
  session_commit();

  session_id($new_session_id);
  ini_set('session.use_strict_mode', 0);
  session_start();
  unset($_SESSION['deleted_time']);
  session_write_close();
  ini_set('session.use_strict_mode', 1);
  session_start();
  $_SESSION['expired'] = time() + 60 * 60 * 24;
}

function my_session_regenerate_id_with_prefix($prefix)
{
  if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
  }
  $new_session_id = session_create_id(preg_replace("/[^A-Za-z0-9 ]/", '', base64_encode($prefix)) . "-");
  $_SESSION['new_session_id'] = $new_session_id;
  $_SESSION['deleted_time'] = time();
  session_commit();

  session_id($new_session_id);
  ini_set('session.use_strict_mode', 0);
  session_start();
  unset($_SESSION['deleted_time']);
  session_write_close();
  ini_set('session.use_strict_mode', 1);
  session_start();
  $_SESSION['expired'] = time() + 60 * 60 * 24;
}