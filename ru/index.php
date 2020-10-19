<?php
require_once("../LDLRIVS.php");
require_once("functions/mainFunctions.php");

my_session_start();

$verification_token = base64_encode(openssl_random_pseudo_bytes(32));
$_SESSION['verification_token'] = $verification_token;

?>
<!--DOCTYPE html-->
<html lang="en">

<head>

  <link rel="shortcut icon" href="/Images/webicon.png" type="image/x-icon">
  <title>
    ООО ТПП "РИВС" | Главная страница | ГУАНПОЛИСЕПТ
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
        <ul>
          Наша цель – забота о здоровье и повышение качества жизни людей. Мы работаем для обеспечения надежной защиты против вирусных и бактериальных угроз, очистки воды и предметов повседневного обихода.
        </ul>
        <ul>
          Продукция имеет соответствующие свидетельства, заключения государственной эпидемиологической экспертизы.
        </ul>
        <ul>
          Благодаря уникальному составу средство «Гуанполисепт» остается на обработанной поверхности кожи до 8 часов, на поверхности предметов до 20 суток.
        </ul>
        <ul>
          Средство «ГУАНПОЛИСЕПТ» имеет широкий спектр применения: дезинфекция кожи, поверхностей или предметов с любых материалов, обеззараживание питьевой воды, бассейнов общественного назначения, обеззараживание кулеров, вендинговых и водных автоматов или пурифайеров. Присутствует антигрибковый и ранозаживляющий эффект.
        </ul>
        <div class="row justify-content-md-center justify-content-sm-center justify-content-center">

          <figure class="col-md-2 col-sm-4 col-4" data-toggle="modal" data-target="#CertificateModal1">
            <img src="/Documents/CertificateGuanpolisept.png" class="img-fluid">
          </figure>

          <figure class="col-md-2 col-sm-4 col-4" data-toggle="modal" data-target="#CertificateModal2">
            <img src="/Documents/Certificate.png" class="img-fluid">
          </figure>

          <figure class="col-md-2 col-sm-4 col-4" data-toggle="modal" data-target="#CertificateModal3">
            <img src="/Documents/CertificateGuanpoliseptSkin.png" class="img-fluid">
          </figure>

          <figure class="col-md-2 col-sm-4 col-4" data-toggle="modal" data-target="#Conclusion1">
            <img src="/Documents/GuanpoliseptConclusion.png" class="img-fluid">
          </figure>

          <figure class="col-md-2 col-sm-4 col-4" data-toggle="modal" data-target="#Conclusion2">
            <img src="/Documents/GuanpoliseptSkinConclusion.png" class="img-fluid">
          </figure>
        </div>

      </div>
    </blockquote>
    <!--Main container-->
    <!-- Modal -->
    <div class="modal fade" id="CertificateModal1" tabindex="-1" role="dialog" aria-labelledby="CertificateModalLabel1" style="display: none;" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-lg modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="CertificateModalLabel1">Свидетельство о государственной регистрации дезинфицирующего средства "Гуанполисепт"</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body" id="PDFmodal1">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary waves-effect waves-light" data-dismiss="modal">Закрыть документ</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="CertificateModal2" tabindex="-1" role="dialog" aria-labelledby="CertificateModalLabel2" style="display: none;" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-lg modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="CertificateModalLabel2">Сертификат соответствия средства "Гуанполисепт" для дезинфекции поверхности кожи</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body" id="PDFmodal2">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary waves-effect waves-light" data-dismiss="modal">Закрыть документ</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="CertificateModal3" tabindex="-1" role="dialog" aria-labelledby="CertificateModalLabel3" style="display: none;" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-lg modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="CertificateModalLabel3">Свидетельство о государственной регистрации средства "Гуанполисепт" для дезинфекции поверхности кожи</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body" id="PDFmodal3">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary waves-effect waves-light" data-dismiss="modal">Закрыть документ</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="Conclusion1" tabindex="-1" role="dialog" aria-labelledby="CertificateModalLabel4" style="display: none;" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-lg modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="CertificateModalLabel4">Заключение государственной санитарно-эпидемиологической экспертизы для дезинфицирующего средства "Гуанполисепт"</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body" id="PDFmodal4">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary waves-effect waves-light" data-dismiss="modal">Закрыть документ</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="Conclusion2" tabindex="-1" role="dialog" aria-labelledby="CertificateModalLabel5" style="display: none;" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-lg modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="CertificateModalLabel5">Заключение государственной санитарно-эпидемиологической экспертизы для средства "Гуанполисепт" для дезинфекции поверхности кожи</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body" id="PDFmodal5">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary waves-effect waves-light" data-dismiss="modal">Закрыть документ</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->

  </main>
  <footer class="page-footer font-small bottom bg-dark accent-4 mt-4">

    <!-- Copyright -->
    <div class="footer-copyright text-center py-3">© 2015 - 2020 ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ — ТОРГОВО-ПРОИЗВОДСТВЕННОЕ ПРЕДПРИЯТИЕ "РИВС"
    </div>

  </footer>

</body>

<? include("myScripts.php"); ?>
<? include("../indexdocfunctions.php"); ?>

<script type="text/javascript">
  var elem = document.getElementById("main");
  elem.classList.add('active');
</script>

</html>