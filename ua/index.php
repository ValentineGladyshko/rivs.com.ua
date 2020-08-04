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