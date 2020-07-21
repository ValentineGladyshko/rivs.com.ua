<?php
header("Location: /ua/index.php");
exit;
$security_token = $_SESSION["security_token"];
$security_token1 = $_COOKIE["security_token"];

if ($security_token == null || $security_token1 == null || !isset($_SESSION["email"])) {
  $language = $_COOKIE["language"];

  if ($language == null) {
    header("Location: /ua/index.php");
    exit;
  } else if ($language == "ua") {
    header("Location: /ua/index.php");
    exit;
  } else if ($language == "ru") {
    header("Location: /ru/index.php");
    exit;
  } else {
    header("Location: /ua/index.php");
    exit;
  }
}

else if (hash_equals($security_token, $security_token1) && isset($_SESSION["email"]))
{
  $email = $_SESSION["email"];
  $mysqli = mysqli_connect("localhost", "chba7f54c7_LDLRIVS", "8e5cktmvx6", "chba7f54c7_LDLRIVS");
  if ($mysqli->connect_errno) {
    $response->success = false;
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit();
  }

  if ($stmt = $mysqli->prepare("SELECT `Language` FROM passwords WHERE UserLogin=?")) {
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($language);
    $stmt->fetch();
    $stmt->close();
  }
  if ($language == null) {
    header("Location: /ua/index.php");
    exit;
  } else if ($language == "ua") {
    header("Location: /ua/index.php");
    exit;
  } else if ($language == "ru") {
    header("Location: /ru/index.php");
    exit;
  } else {
    header("Location: /ua/index.php");
    exit;
  }
}

else {
  $language = $_COOKIE["language"];

  if ($language == null) {
    header("Location: /ua/index.php");
    exit;
  } else if ($language == "ua") {
    header("Location: /ua/index.php");
    exit;
  } else if ($language == "ru") {
    header("Location: /ru/index.php");
    exit;
  } else {
    header("Location: /ua/index.php");
    exit;
  }
}
?>