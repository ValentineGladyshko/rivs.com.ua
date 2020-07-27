<?php
require_once("../LDLRIVS.php");

my_session_start();

$verification_token = base64_encode(openssl_random_pseudo_bytes(32));
$_SESSION['verification_token'] = $verification_token;

?>
<!--DOCTYPE html-->
<html lang="en">

<head>

  <link rel="shortcut icon" href="/Images/webicon.png" type="image/x-icon">
  <title>
    ТОВ ТВД "РІВС" | Головна сторінка | Гуанполісепт
  </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <!-- Font Awesome -->
  <? include("../scripts.php"); ?>
</head>

<body style="overflow-y: overlay;">
  <? include("functions/header.php"); ?>

  <!--Main Navigation-->

  <!--Main layout-->
  <main class="mt-5 mb-3">

    <!--Main container-->
    <blockquote class="blockquote">
      <div class="container" style="background-color: #eee;">
        <img src="/Images/main.jpg" class="img-fluid rounded mx-auto d-block">
        <div class="row">

          <figure class="col-md-3" data-toggle="modal" data-target="#ExamplesModal1">
            <img src="/Images/WithPaintExample/1.jpg" alt="1 example" class="img-fluid">
          </figure>

          <figure class="col-md-3" data-toggle="modal" data-target="#ExamplesModal2">
            <img src="/Images/WithPaintExample/2.jpg" alt="2 example" class="img-fluid" />
          </figure>

          <figure class="col-md-3" data-toggle="modal" data-target="#ExamplesModal3">
            <img src="/Images/WithPaintExample/3.jpg" alt="3 example" class="img-fluid" />

          </figure>

          <figure class="col-md-3" data-toggle="modal" data-target="#ExamplesModal4">
            <img src="/Images/WithPaintExample/4.jpg" alt="4 example" class="img-fluid" />
          </figure>
        </div>
      </div>
      </div>
      </div>
    </blockquote>
    <!--Main container-->
    <!-- Modal -->
    <div class="modal fade" id="ExamplesModal1" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <img src="/Images/WithPaintExample/1.jpg" class="img-fluid rounded mx-auto d-block">
          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="ExamplesModal2" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <img src="/Images/WithPaintExample/2.jpg" class="img-fluid rounded mx-auto d-block">
          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="ExamplesModal3" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <img src="/Images/WithPaintExample/3.jpg" class="img-fluid rounded mx-auto d-block">
          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="ExamplesModal4" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <img src="/Images/WithPaintExample/4.jpg" class="img-fluid rounded mx-auto d-block">
          </div>
        </div>
      </div>
    </div>
  </main>

  <footer class="page-footer font-small bottom bg-dark accent-4 mt-4">

    <!-- Copyright -->
    <div class="footer-copyright text-center py-3">© 2015 - 2020 ТОВАРИСТВО З ОБМЕЖЕНОЮ ВІДПОВІДАЛЬНІСТЮ — ТОРГОВО-ВИРОБНИЧИЙ ДІМ "РІВС"
    </div>

  </footer>

</body>

<? include("../myScripts.php"); ?>

<script type="text/javascript">
  var elem = document.getElementById("main");
  elem.classList.add('active');
</script>

</html>