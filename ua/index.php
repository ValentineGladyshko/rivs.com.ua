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
        <ul>
          Наша мета – турбота про здоров'я і підвищення якості життя людей. Ми працюємо для забезпечення надійного захисту проти вірусних та бактеріальних загроз, очищення води та предметів повсякденного вжитку.</p>
        </ul>
        <ul>
          Продукція має відповідні свідоцтва, висновки державної епідеміологічної експертизи.</p>
        </ul>
        <ul>
          Завдяки унікальному складу засіб «Гуанполісепт» залишається на обробленій поверхні шкіри до 8 годин, на поверхні предметів до 20 діб.</p>
        </ul>
        <ul>
          Засіб «Гуанполісепт» має широкий спектр застосування: дезінфекція поверхні шкіри, рідина для дезінфекції поверхонь або предметів з будь-яких матеріалів, знезараження питної води та басейнів громадського призначення, знезараження кулерів, вендингових та водних автоматів або пуріфайерів. Присітній антигрибковий та ранозагоюючий ефект.</p>
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
            <h5 class="modal-title" id="CertificateModalLabel1">Свідоцтво про державну реєстрацію дезінфекційного засобу <p>Засіб дезінфекційний "Гуанполісепт"</p>
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body" id="PDFmodal1">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary waves-effect waves-light" data-dismiss="modal">Закрити документ</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="CertificateModal2" tabindex="-1" role="dialog" aria-labelledby="CertificateModalLabel2" style="display: none;" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-lg modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="CertificateModalLabel2">Сертифікат відповідності для <p>Засобу "Гуанполісепт" для дезінфекції поверхні шкіри</p>
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body" id="PDFmodal2">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary waves-effect waves-light" data-dismiss="modal">Закрити документ</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="CertificateModal3" tabindex="-1" role="dialog" aria-labelledby="CertificateModalLabel3" style="display: none;" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-lg modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="CertificateModalLabel3">Свідоцтво про державну реєстрацію дезінфекційного засобу <p>Засіб "Гуанполісепт" для дезінфекції поверхні шкіри</p>
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body" id="PDFmodal3">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary waves-effect waves-light" data-dismiss="modal">Закрити документ</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="Conclusion1" tabindex="-1" role="dialog" aria-labelledby="CertificateModalLabel4" style="display: none;" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-lg modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="CertificateModalLabel4">Висновок державної санітарно-епідеміологічної експертизи <p>Засіб дезінфекційний "Гуанполісепт"</p>
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body" id="PDFmodal4">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary waves-effect waves-light" data-dismiss="modal">Закрити документ</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="Conclusion2" tabindex="-1" role="dialog" aria-labelledby="CertificateModalLabel5" style="display: none;" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-lg modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="CertificateModalLabel5">Висновок державної санітарно-епідеміологічної експертизи <p>Засіб "Гуанполісепт" для дезінфекції поверхні шкіри</p>
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body" id="PDFmodal5">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary waves-effect waves-light" data-dismiss="modal">Закрити документ</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->

  </main>
  <footer class="page-footer font-small bottom bg-dark accent-4 mt-4">

    <!-- Copyright -->
    <div class="footer-copyright text-center py-3">© 2015 - 2020 ТОВАРИСТВО З ОБМЕЖЕНОЮ ВІДПОВІДАЛЬНІСТЮ — ТОРГОВО-ВИРОБНИЧИЙ ДІМ "РІВС"
    </div>

  </footer>

</body>

<? include("../myScripts.php"); ?>
<? include("../indexdocfunctions.php"); ?>

<script type="text/javascript">
  var elem = document.getElementById("main");
  elem.classList.add('active');
</script>

</html>