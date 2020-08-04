<?php
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
