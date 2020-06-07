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
    ООО ТПП "РИВС" | Главная страница | Гуанполисепт
  </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <!-- Font Awesome -->
  <? include("../scripts.php"); ?>
</head>

<body>
  <? include("header.php"); ?>

  <!--Main Navigation-->

  <!--Main layout-->
  <main class="mt-5 mb-3">

    <!--Main container-->
    <blockquote class="blockquote">
      <div class="container" style="background-color: #eee;">
        <img src="/Images/main.jpg" class="img-fluid rounded mx-auto d-block">
        <p>
          Уважаемые посетители! Торгово-производственное предприятие «РИВС» предлагает вашему вниманию дезинфицирующее средство «ГУАНПОЛИСЕПТ», свидетельство № 000860 от 11.02.2010 г. МОЗ Украины. Полное отсутствие хлора, свинца, меди и других вредных для человека химических соединений. Дезинфицирующее средство, которое сохраняет свои антимикробные свойства в течение всего времени присутствия, в то время как другие существующие дезинфицирующие средства почти сразу теряют свои свойства и через некоторый промежуток времени рост бактерий восстанавливается.
        </p>
        <p>
          "ГУАНПОЛИСЕПТ" – реагент для доочистки питьевой воды, дезинфекции систем водного кондиционирования воздуха, водоподготовки бассейнов для плавания.
          Обладает сильным биоцидным действием по отношению ко всем патогенным микроорганизмам которые вызывают гнойные, респираторные, кишечные и другие заболевания у людей и животных.</p>
        <p class="bq-title">Антимикробный, водорастворимое средство "ГУАНПОЛИСЕПТ"</p>
        <p>
          Дезинфицирующее средство ГУАНПОЛИСЕПТ относится к дезинфектантам нового поколения (полимерные гуанидиновые антисептические препараты), не содержит хлора, альдегидов и выпускается в виде 15%-ого водного раствора, представляет собой прозрачную бесцветную жидкость без запаха с неограниченной растворимостью в воде.
          <p>
            Препарат ГУАНПОЛИСЕПТ имеет высокую антимикробную активность к широкому кругу бактерий, плесневых грибов, дрожжей. Растворы препарата уже в 0,05% концентрации вызывают гибель грамположительных и грамотрицательных бактерий в течение 5-25 минут, высокоактивные по отношению к санитарно-показательной микрофлоре перерабатывающих предприятий мясо-молочной и других пищевых отраслей.
            <p>
              ГУАНПОЛИСЕПТ негорючий, не взрывоопасен, при комнатной температуре стабильный неограниченное время, водный раствор не летучий, pH 1% водного раствора составляет 7,0.
            </p>
            <p>
              Растворы препарата ГУАНПОЛИСЕПТ не агрессивны по отношению к нержавеющей стали, алюминию, другим металлам, а также к бетону, дереву, керамической плитке, резине и к пластмассам.
            </p>
            <p> 
              По параметрам острой токсичности средство ГУАНПОЛИСЕПТ (в виде концентрата) относится к 3 классу умеренно опасных веществ по ГОСТ 12.1.001-76 при попадании в желудок и при ингаляционном воздействии летучих компонентов (пары) к 4 классу малоопасных веществ при нанесении на кожу, а также к малотоксичным соединениям при парентеральном введении.</p>
            <p>
              Вследствие низкой летучести препарат малоопасен при ингаляционном воздействии. ГУАНПОЛИСЕПТ отличается от известных антисептиков длительным временем антимикробного действия и более высокой активностью. Обработку поверхностей в помещениях способом протирания и орошения можно проводить без средств защиты органов дыхания, а протирания даже в присутствии персонала (обработку проводят разбавленными рабочими растворами).</p>
            <p>
              Препарат ГУАНПОЛИСЕПТ по антимикробной активности превосходит такие антимикробные препараты как хлорамин, хлорная известь, пергидроль, карболовой кислоты в 2-3 раза, четвертичные аммониевые соли (ЧАС) в 10 раз, многие антибиотики (ампициллин, карбеницилин и др.) В 2-3 раза. Ближайший зарубежный аналог - хлоргексидин (Гибитан).
            </p>
            <p>
              Гарантированный срок хранения препарата - 36 месяцев.</p>
            <p>
              Для обработки 1 м² поверхности с целью профилактики расходуется 100-200 мл 0,1-0,05% рабочего раствора препарата ГУАНПОЛИСЕПТ.
            </p>
            <p>
              1 л концентрата (25%) препарата ГУАНПОЛИСЕПТ достаточно для приготовления 250 литров рабочего раствора с концентрацей 0,1%, которым можно обработать с целью профилактики 2500 м² поверхности. Срок хранения рабочих растворов - 6 месяцев.
            </p>
            <p>
              Наносить рабочий раствор препарата ГУАНПОЛИСЕПТ с целью профилактики следует на предварительно очищенную от грязи поверхность.
            </p>
            <p class="bq-title">Антимикробное водонерастворимое средство "ГУАНПОЛИСЕПТ"</p>
            <p>
              Пример действия порошка, смешанного с краской, нанесенной на металл в растворе с негативными для человека бактериями:
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
    <div class="footer-copyright text-center py-3">© 2015 - 2020 ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ — ТОРГОВО-ПРОИЗВОДСТВЕННОЕ ПРЕДПРИЯТИЕ "РИВС"
    </div>
    <!-- Copyright -->

  </footer>
  <!-- Footer -->

</body>

<!-- SCRIPTS -->
<!-- JQuery -->
<? include("../myScripts.php"); ?>

<script type="text/javascript">
  var elem = document.getElementById("main");
  elem.classList.add('active');
  var ru_link = document.getElementById("ru_link");
  ru_link.href = "/ru/index.php";
  var ua_link = document.getElementById("ua_link");
  ua_link.href = "/ua/index.php";
</script>

</html>