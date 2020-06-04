<?php

session_start();
$security_token = $_SESSION["security_token"];
$security_token1 = $_COOKIE["security_token"];
if ($security_token == null || $security_token1 == null) {
?>
    <!DOCTYPE html>
    <html lang="ru">

    <head>
        <meta charset="utf-8">
        <title>Название</title>
        <meta name="description" content="Содержание" />
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
        <script type="text/javascript" src="js/bootstrap.js"></script>
    </head>

    <body>
        <main class="mt-5 mb-3">
            <!--Main container-->
            <div class="row" style="background-color: #eee;">

                <div class="col-md-8">
                    <p>
                        Неавторизований
                    </p>
                </div>
            </div>

        </main>

    </body>
    <?
} else {
    if (hash_equals($security_token, $security_token1)) {
    ?>
        <!DOCTYPE html>
        <html lang="ru">

        <head>
            <meta charset="utf-8">
            <title>Название</title>
            <meta name="description" content="Содержание" />
            <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
            <script type="text/javascript" src="js/bootstrap.js"></script>
        </head>

        <body>
            <main class="mt-5 mb-3">
                <!--Main container-->
                <div class="row" style="background-color: #eee;">

                    <div class="col-md-8">
                        <p>
                            Шановні відвідувачі! Торгово-виробничий Дім «РІВС» пропонує вашій увазі дезинфікуючий засіб «ГУАНПОЛІСЕПТ», свідоцтво № 000860 від 11.02.2010 р МОЗ України. Повна відсутність хлору, свинцю, міді та інших шкідливих для людини хімічних сполук. Дезінфікуючий засіб, який зберігає свої антимікробні властивості протягом усього часу присутності, в той час як інші існуючі дезинфікуючі засоби втрачають свої властивості через короткий період часу після їх нанесення і зростання бактерій відновлюється.
                        </p>
                    </div>
                </div>

            </main>

        </body>
<? }
}
?>