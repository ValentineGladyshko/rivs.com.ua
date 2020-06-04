<?php
require_once("LDLRIVS.php");

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
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
  <!-- Bootstrap core CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!-- Material Design Bootstrap -->
  <link href="css/mdb.min.css" rel="stylesheet">
  <!-- Your custom styles (optional) -->
  <link href="css/style.css" rel="stylesheet">
  <link href="style.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
  <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.js"></script>

</head>

<body>
  <header style="font-family: Helios,sans-serif;">
    <!--Navbar -->
    <nav class="mb-1 navbar sticky-top navbar-expand-lg navbar-light cyan accent-2 scrolling-navbar">
      <div class="container">
        <a class="navbar-brand" href="/">
          <img src="/Images/logo.png" width="30" height="40" alt="logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-333" aria-controls="navbarSupportedContent-333" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent-333">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="/">Головна
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/contacts.php">Контакти</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/store">Продукція</a>
            </li>
            </li>
          </ul>



          <ul class="navbar-nav navbar-right">
            <li class="nav-item">
              <i class="russia flag"></i>
            </li>

            <li class="nav-item">
              <!-- Button trigger modal -->
              <a class="nav-link" data-toggle="modal" data-target="#MobileModal">
                <i class="fas fa-phone"></i>Телефони
              </a>
            </li>



            <li class="nav-item">
              <a class="nav-link" href="https://www.rivs.com.ua/rus">RU
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item active disabled">
              <a class="nav-link" href="https://www.rivs.com.ua/">UA
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <?
            $security_token = $_SESSION["security_token"];
            $security_token1 = $_COOKIE["security_token"];
            if ($security_token == null || $security_token1 == null || !isset($_SESSION["email"])) { ?>
              <li class="nav-item"><a class="nav-link" data-toggle="modal" data-target="#RegisterModal">Реєстрація</a></li>
              <li class="nav-item"><a class="nav-link" data-toggle="modal" data-target="#LoginModal">Увійти</a></li>
            <? } else if (hash_equals($security_token, $security_token1) && isset($_SESSION["email"])) { ?>
              <li class="nav-item"><a class="nav-link"><?= $_SESSION["email"] ?></a></li>
              <li class="nav-item">
                <form style="margin:0px" class="nav-item" id="logout-form" name="logout-form" action="logout.php" method="post">
                  <input name="verification_token" id="verification_token2" type="hidden" value=<?= $verification_token ?>>
                  <a id="LogoutButton" class="nav-link">Вийти</a>
                </form>
              </li>
            <? } else { ?>
              <li class="nav-item"><a class="nav-link" data-toggle="modal" data-target="#RegisterModal">Реєстрація</a></li>
              <li class="nav-item"><a class="nav-link" data-toggle="modal" data-target="#LoginModal">Увійти</a></li>
            <? } ?>
          </ul>
        </div>
      </div>
    </nav>
    <!-- Modal login -->
    <div class="modal fade" id="LoginModal" tabindex="-1" role="dialog" aria-labelledby="LoginModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="MobileModalLabel">Вхід</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <!--Grid row-->
            <form id="login-form" name="login-form" action="login.php" method="post">
              <input name="verification_token" id="verification_token" type="hidden" value=<?= $verification_token ?>>
              <div class="form-group">
                <label class="control-label" for="email">Email address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                <div id="email_feedback" class="invalid-feedback"></div>
              </div>
              <div class="form-group">
                <label class="control-label" for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                <div id="password_feedback" class="invalid-feedback"></div>
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>

          </div>
        </div>
      </div>
    </div>
    <!-- Modal register-->
    <div class="modal fade" id="RegisterModal" tabindex="-1" role="dialog" aria-labelledby="RegisterModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="MobileModalLabel">Реєстрація</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <form id="register-form" name="register-form" action="register.php" method="post">
              <input name="verification_token" id="verification_token1" type="hidden" value=<?= $verification_token ?>>
              <div class="form-group">
                <label class="control-label" for="email1">Email address</label>
                <input type="email" class="form-control" id="email1" name="email1" placeholder="Enter email" required>
                <div id="email1_feedback" class="invalid-feedback"></div>
              </div>
              <div class="form-group">
                <label class="control-label" for="password1">Password</label>
                <input type="password" class="form-control" id="password1" name="password1" required>
                <div id="password1_feedback" class="invalid-feedback"></div>
              </div>
              <div class="form-group">
                <label class="control-label" for="repeat_password">Repeat Password</label>
                <input type="password" class="form-control" id="repeat_password" name="repeat_password" required>
                <div id="repeat_password_feedback" class="invalid-feedback"></div>
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>

          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="MobileModal" tabindex="-1" role="dialog" aria-labelledby="MobileModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="MobileModalLabel">Наші телефони</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p class="text-justify">Консультації та замовлення за телефонами:</p>
            <p><a class="phone-ph" href="tel:+380660125020"><strong>+38(066)012-50-20</strong></a></p>
            <p><a class="phone-ph" href="tel:+380636491060"><strong>+38(063)649-10-60</strong></a></p>
            <p class="text-justify">Графік прийому замовлень:</p>
            <p class="text-justify">Будні: з 10:00 до 20:00</p>
            <p class="text-justify">Вихідні: з 11:00 до 19:00</p>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!--Main Navigation-->

  <!--Main layout-->
  <main class="mt-5 mb-3">

    <!--Main container-->
    <blockquote class="blockquote">
      <div class="container" style="background-color: #eee;">
        <img src="https://www.rivs.com.ua/Images/main.jpg" class="img-fluid rounded mx-auto d-block">
        <p>
          Шановні відвідувачі! Торгово-виробничий Дім «РІВС» пропонує вашій увазі <b>дезінфікуючий засіб «ГУАНПОЛІСЕПТ», який здатен виправити наслідки використання спиртових антисептиків, а також повністю їх замінити. Адже він має дезінфікуючу дію доки знаходиться на поверхні, а спирт лише до першого вашого контакту з вірусами або бактеріями.</b> Свідоцтво № 000860 від 11.02.2010 р МОЗ України. Повна відсутність хлору, свинцю, міді та інших шкідливих для людини хімічних сполук. Дезінфікуючий засіб, який <b>зберігає свої антимікробні властивості протягом усього часу присутності</b>, в той час як інші існуючі дезинфікуючі засоби втрачають свої властивості через короткий період часу після їх нанесення і зростання бактерій відновлюється.
        </p>
        <p>
          "ГУАНПОЛІСЕПТ" — реагент для доочищення питної води, дезінфекції систем водного кондиціонування повітря, водопідготовки басейнів для плавання.
          Володіє сильною біоцидною дією по відношенню до всіх патогенних мікроорганізмів які викликають гнійні, респіраторні, кишкові та інші захворювання у людей і тварин.
        </p>
        <p class="bq-title">Антимікробний, водорозчинний засіб "Гуанполісепт"</p>
        <p>
          Дезінфікуючий засіб ГУАНПОЛІСЕПТ відноситься до дезінфектантів нового покоління (полімерні гуанідинові антисептичні препарати), що не містить активного хлору, альдегідів і випускається у вигляді 15%-ового водного розчину, що представляє собою прозору безбарвну рідину без запаху з необмеженою розчинністю у воді.
          <p>
            Препарат ГУАНПОЛІСЕПТ має високу антимікробну активність до широкого кола бактерій, цвілевих грибів, дріжджів. Розчини препарату вже в 0,05% концентрації викликають загибель грам-позитивних і грам-негативних бактерій протягом 5-25 хвилин, високоактивні по відношенню до санітарно-показової мікрофлори переробних підприємств м'ясо-молочної та інших харчових галузей.</p>
          <p>
            ГУАНПОЛІСЕПТ негорючий, не вибухонебезпечний, при кімнатній температурі стабільний необмежений час, водний розчин не летючий, pH 1% водного розчину становить 7,0.
          </p>
          <p>
            Розчини препарату ГУАНПОЛІСЕПТ не агресивні по відношенню до нержавіючої сталі, алюмінію, інших металів, а також до бетону, дерева, керамічної плитки, гуми та до пластмас.
          </p>
          <p> 
            За параметрами гострої токсичності засіб ГУАНПОЛІСЕПТ (у вигляді концентрату) відноситься до 3 класу помірно небезпечних речовин по ГОСТ 12.1.001-76 при потраплянні у шлунок.
            При інгаляційному впливі летючих компонентів (пари) до 4 класу малонебезпечних речовин при нанесенні на шкіру.
            До малотоксичних сполук при парентеральному введенні.
          </p>
          <p>
            Внаслідок низької летючості препарат малонебезпечний при інгаляційному впливі. ГУАНПОЛІСЕПТ відрізняється від відомих антисептиків тривалим часом антимікробної дії і більш високою активністю. Обробку поверхонь в приміщеннях способом протирання і зрошення можна проводити без засобів захисту органів дихання, а протирання навіть в присутності персоналу (обробку проводять розведеними робочими розчинами).
          </p>
          <p>
            Препарат ГУАНПОЛІСЕПТ в антимікробній активності перевершує такі відомі антимікробні препарати як хлорамін, хлорне вапно, пергідроль, карболову кислоту в 2-3 рази, четвертинні амонієві солі (ЧАС) в 10 разів, багато антибіотиків (ампіцилін, карбеніцилін та ін.) в 2-3 рази. Найближчий зарубіжний аналог - хлоргексидин (Гібітан).
          </p>
          <p>
            Гарантований термін зберігання препарату – 3 роки.
          </p>
          <p>
            Для обробки 1 м² поверхонь з метою профілактики витрачається 100-200 мл 0,1-0,05% робочого розчину препарату ГУАНПОЛІСЕПТ.
          </p>
          <p>
            1 л концентрату (25%) препарату ГУАНПОЛІСЕПТ досить для приготування 250 літрів робочого розчину концентрації 0,1% яким можна обробити з метою профілактики 2500 м² поверхні. Термін зберігання робочих розчинів - 6 місяців.
          </p>
          <p>
            Наносити робочий розчин препарату ГУАНПОЛІСЕПТ з метою профілактики слід на попередньо очищену від бруду поверхню.
          </p>
          <p class="bq-title">Антимікробний водонерозчинний засіб "ГУАНПОЛІСЕПТ"</p>
          <p>
            Приклад дії порошку, змішаного з фарбою, нанесеною на метал у розчині з негативними для людини бактеріями:
          </p>
          <div class="row">

            <figure class="col-md-3" data-toggle="modal" data-target="#ExamplesModal1">
              <img src="/WithPaintExample/10.jpg" alt="1 example" class="img-fluid">
            </figure>

            <figure class="col-md-3" data-toggle="modal" data-target="#ExamplesModal2">
              <img src="/WithPaintExample/2.png" alt="2 example" class="img-fluid" />
            </figure>

            <figure class="col-md-3" data-toggle="modal" data-target="#ExamplesModal3">
              <img src="/WithPaintExample/30.jpg" alt="3 example" class="img-fluid" />

            </figure>

            <figure class="col-md-3" data-toggle="modal" data-target="#ExamplesModal4">
              <img src="/WithPaintExample/40.jpg" alt="4 example" class="img-fluid" />
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
            <img src="/WithPaintExample/10.jpg" class="img-fluid rounded mx-auto d-block">
          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="ExamplesModal2" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <img src="/WithPaintExample/2.png" class="img-fluid rounded mx-auto d-block">
          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="ExamplesModal3" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <img src="/WithPaintExample/30.jpg" class="img-fluid rounded mx-auto d-block">
          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="ExamplesModal4" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <img src="/WithPaintExample/40.jpg" class="img-fluid rounded mx-auto d-block">
          </div>
        </div>
      </div>
    </div>
  </main>
  <!--Main layout-->

  <!-- Footer -->
  <footer class="page-footer font-small bottom cyan accent-4 mt-4">

    <!-- Copyright -->
    <div class="footer-copyright text-center py-3">© 2015 - 2020 ТОВАРИСТВО З ОБМЕЖЕНОЮ ВІДПОВІДАЛЬНІСТЮ — ТОРГОВО-ВИРОБНИЧИЙ ДІМ "РІВС"
    </div>
    <!-- Copyright -->

  </footer>
  <!-- Footer -->

</body>

<!-- SCRIPTS -->
<!-- JQuery -->
<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="js/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="js/mdb.min.js"></script>
<script type="text/javascript" src="js/jquery.redirect.js"></script>
<script type="text/javascript">
  var form = $('#login-form');

  form.submit(function(e) {
    formData = {
      'verification_token': $('input[name=verification_token]').val(),
      'email': $('input[name=email]').val(),
      'password': $('input[name=password]').val()
    };
    e.preventDefault();

    $.ajax({
      type: "POST",
      url: "login.php",
      data: formData,
      success: function(response) {
        if (response != null) {
          var jsonData = JSON.parse(response);
          if (jsonData.success == true) {
            location.reload();
          } else {
            var email = document.getElementById("email");
            var password = document.getElementById("password");
            var email_feedback = document.getElementById("email_feedback");
            var password_feedback = document.getElementById("password_feedback");
            if (jsonData.hasOwnProperty("email")) {
              email.classList.add('is-invalid');
              email.classList.remove('is-valid');
              email_feedback.innerHTML = jsonData.email;
            } else {
              email.classList.remove('is-invalid');
              email.classList.add('is-valid');
            }
            if (jsonData.hasOwnProperty("password")) {
              password.classList.add('is-invalid');
              password.classList.remove('is-valid');
              password_feedback.innerHTML = jsonData.password;
            } else {
              password.classList.remove('is-invalid');
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
</script>
<script type="text/javascript">
  //deleteValidation(e) {
  //  e.target.classList.remove('is-invalid');
 // };
  var email1 = document.getElementById("email1");
  email1.oninput = function() {
    email.classList.remove('is-invalid');
    email.classList.remove('is-valid');
  };

  var password1 = document.getElementById("password1");
  password1.oninput = function() {
    password1.classList.remove('is-invalid');
    password1.classList.remove('is-valid');
  };

  var repeat_password = document.getElementById("repeat_password");
  repeat_password.oninput = function() {
    repeat_password.classList.remove('is-invalid');
    repeat_password.classList.remove('is-valid');
  };

  var email = document.getElementById("email");
  email.oninput = function() {
    email.classList.remove('is-invalid');
    email.classList.remove('is-valid');
  };

  var password = document.getElementById("password");
  password.oninput = function() {
    password.classList.remove('is-invalid');
    password.classList.remove('is-valid');
  };

  var form = $('#register-form');

  form.submit(function(e) {


    formData = {
      'verification_token': $('input[name=verification_token]').val(),
      'email': $('input[name=email1]').val(),
      'password': $('input[name=password1]').val(),
      'repeat_password': $('input[name=repeat_password]').val()
    };
    e.preventDefault();

    $.ajax({
      type: "POST",
      url: "registerStart.php",
      data: formData,
      success: function(response) {
        if (response != null) {
          var jsonData = JSON.parse(response);
          if (jsonData.success == true) {
            $.redirect('register.php', formData);
          } else {
            var email = document.getElementById("email1");
            var password = document.getElementById("password1");
            var repeat_password = document.getElementById("repeat_password");
            var email_feedback = document.getElementById("email1_feedback");
            var password_feedback = document.getElementById("password1_feedback");
            var repeat_password_feedback = document.getElementById("repeat_password_feedback");

            if (jsonData.hasOwnProperty("email") && jsonData.email != '') {
              email.classList.add('is-invalid');
              email.classList.remove('is-valid');
              email_feedback.innerHTML = "";
              var data;
              for (data of jsonData.email) {
                email_feedback.innerHTML += ("<p>" + data + "</p>");
              }
            } else {
              email.classList.remove('is-invalid');
              email.classList.add('is-valid');
            }
            if (jsonData.hasOwnProperty("password") && jsonData.password != '') {
              password.classList.add('is-invalid');
              password.classList.remove('is-valid');
              password_feedback.innerHTML = "";
              var data;
              for (data of jsonData.password) {
                password_feedback.innerHTML += ("<p>" + data + "</p>");
              }
            } else {
              password.classList.remove('is-invalid');
              password.classList.add('is-valid');
            }
            if (jsonData.hasOwnProperty("repeat_password") && jsonData.repeat_password != '') {
              repeat_password.classList.add('is-invalid');
              repeat_password.classList.remove('is-valid');
              repeat_password_feedback.innerHTML = "";
              var data;
              for (data of jsonData.repeat_password) {
                repeat_password_feedback.innerHTML += ("<p>" + data + "</p>");
              }
            } else {
              repeat_password.classList.remove('is-invalid');
              repeat_password.classList.add('is-valid');
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
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $("#LogoutButton").click(
      function(e) {
        formData = {
          'verification_token': $('input[name=verification_token]').val(),
        };
        e.preventDefault();

        $.ajax({
          type: "POST",
          url: "logout.php",
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
</script>

</html>