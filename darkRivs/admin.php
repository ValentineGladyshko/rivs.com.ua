<?php
require_once("../LDLRIVS.php");

my_session_start();

$verification_token = base64_encode(openssl_random_pseudo_bytes(32));
$_SESSION['verification_token'] = $verification_token;
$security_token = $_SESSION["security_admin_token"];
$security_token1 = $_COOKIE["security_admin_token"];

if ($security_token == null || $security_token1 == null) {
    include("../scripts.php");
    echo "<script>$(document).ready(function() { $.redirect('/index.php'); });</script>";
    exit();
}

if (hash_equals($security_token, $security_token1)) {
?>
    <html lang="en">

    <head>

        <link rel="shortcut icon" href="/Images/webicon.png" type="image/x-icon">
        <title>
            ТОВ ТВД "РІВС" / Адміністративна сторінка
        </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <!-- Font Awesome
        $('#example').DataTable( {
            language: {
                url: '/localisation/fr_FR.json'
            }
        } ); -->
        <? include("functions/scripts.php"); ?>
    </head>

    <body style="overflow-x: overlay;">
        <header>
            <nav class="navbar py-0 navbar-dark bg-dark">
                <a class="navbar-brand px-2" href="#">
                    <img src="/Images/logo.png" width="30" height="40" alt="logo">
                </a>
                <svg xmlns="http://www.w3.org/2000/svg" height="30" viewBox="0 0 448 512">
                    <g>
                        <path fill="currentColor" class="golden" d="M352 96H96V0l64 32 64-32 64 32 64-32z"></path>
                        <path fill="currentColor" class="text-light" d="M313.6 304h-16.71a174 174 0 0 1-145.78 0H134.4A134.4 134.4 0 0 0 0 438.4V464a48 48 0 0 0 48 48h352a48 48 0 0 0 48-48v-25.6A134.4 134.4 0 0 0 313.6 304zM224 272a128 128 0 0 0 128-128v-16H96v16a128 128 0 0 0 128 128z"></path>
                    </g>
                </svg>
            </nav>
        </header>
        <main>
            <div class="container-fluid">
                <div class="row">
                    <nav class="d-none d-md-block bg-dark-alt sidebar">
                        <div class="sidebar-sticky">
                            <ul class="nav flex-column py-4 pl-3">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#">
                                        <svg width="24px" height="24px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                            <path fill="currentColor" d="M139.61 35.5a12 12 0 0 0-17 0L58.93 98.81l-22.7-22.12a12 12 0 0 0-17 0L3.53 92.41a12 12 0 0 0 0 17l47.59 47.4a12.78 12.78 0 0 0 17.61 0l15.59-15.62L156.52 69a12.09 12.09 0 0 0 .09-17zm0 159.19a12 12 0 0 0-17 0l-63.68 63.72-22.7-22.1a12 12 0 0 0-17 0L3.53 252a12 12 0 0 0 0 17L51 316.5a12.77 12.77 0 0 0 17.6 0l15.7-15.69 72.2-72.22a12 12 0 0 0 .09-16.9zM64 368c-26.49 0-48.59 21.5-48.59 48S37.53 464 64 464a48 48 0 0 0 0-96zm432 16H208a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h288a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-320H208a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h288a16 16 0 0 0 16-16V80a16 16 0 0 0-16-16zm0 160H208a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h288a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16z" class=""></path>
                                        </svg>
                                        Головна
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <svg width="24px" height="24px" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M2 3a2 2 0 0 1 2-2h5.293a1 1 0 0 1 .707.293L13.707 5a1 1 0 0 1 .293.707V13a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V3zm7 2V2l4 4h-3a1 1 0 0 1-1-1zM4.5 8a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7zM4 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5z" />
                                        </svg>
                                        Замовлення
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <svg width="24px" height="24px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                            <path fill="currentColor" d="M446.7 160c.4-.5.5-.7.9-1.2L391.3 53.9C386.9 40.8 374.7 32 360.9 32H256l32 128h158.7zM160 160l32-128H87.1c-13.8 0-26 8.8-30.4 21.9L.4 158.8c.4.5.5.7.9 1.2H160zm128 32v80c0 8.8-7.2 16-16 16h-96c-8.8 0-16-7.2-16-16v-80H0v256c0 17.7 14.3 32 32 32h384c17.7 0 32-14.3 32-32V192H288z" class=""></path>
                                        </svg>
                                        Товари
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <svg width="24px" height="24px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                                            <path fill="currentColor" d="M192 256c61.9 0 112-50.1 112-112S253.9 32 192 32 80 82.1 80 144s50.1 112 112 112zm76.8 32h-8.3c-20.8 10-43.9 16-68.5 16s-47.6-6-68.5-16h-8.3C51.6 288 0 339.6 0 403.2V432c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48v-28.8c0-63.6-51.6-115.2-115.2-115.2zM480 256c53 0 96-43 96-96s-43-96-96-96-96 43-96 96 43 96 96 96zm48 32h-3.8c-13.9 4.8-28.6 8-44.2 8s-30.3-3.2-44.2-8H432c-20.4 0-39.2 5.9-55.7 15.4 24.4 26.3 39.7 61.2 39.7 99.8v38.4c0 2.2-.5 4.3-.6 6.4H592c26.5 0 48-21.5 48-48 0-61.9-50.1-112-112-112z" class=""></path>
                                        </svg>
                                        Користувачі
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <svg width="24px" height="24px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                                            <path fill="currentColor" d="M96 224c35.35 0 64-28.65 64-64s-28.65-64-64-64-64 28.65-64 64 28.65 64 64 64zm224 32c53.02 0 96-42.98 96-96v-16H224v16c0 53.02 42.98 96 96 96zm256 0h-64c-17.59 0-33.5 7.11-45.07 18.59 40.27 22.06 68.86 62.03 75.13 109.41H608c17.67 0 32-14.33 32-32v-32c0-35.35-28.65-64-64-64zm-402.93 18.59C161.5 263.11 145.59 256 128 256H64c-35.35 0-64 28.65-64 64v32c0 17.67 14.33 32 32 32h65.94c6.27-47.38 34.85-87.34 75.13-109.41zM544 224c35.35 0 64-28.65 64-64s-28.65-64-64-64-64 28.65-64 64 28.65 64 64 64zm-147.2 64h-8.31c-20.84 9.96-43.89 16-68.49 16s-47.64-6.04-68.49-16h-8.31C179.58 288 128 339.58 128 403.2V432c0 26.51 21.49 48 48 48h288c26.51 0 48-21.49 48-48v-28.8c0-63.62-51.58-115.2-115.2-115.2zM416 32l-48 24-48-24-48 24-48-24v80h192V32z" class=""></path>
                                        </svg>
                                        Адміністратори
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <svg width="24px" height="24px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                            <path fill="currentColor" d="M396.8 352h22.4c6.4 0 12.8-6.4 12.8-12.8V108.8c0-6.4-6.4-12.8-12.8-12.8h-22.4c-6.4 0-12.8 6.4-12.8 12.8v230.4c0 6.4 6.4 12.8 12.8 12.8zm-192 0h22.4c6.4 0 12.8-6.4 12.8-12.8V140.8c0-6.4-6.4-12.8-12.8-12.8h-22.4c-6.4 0-12.8 6.4-12.8 12.8v198.4c0 6.4 6.4 12.8 12.8 12.8zm96 0h22.4c6.4 0 12.8-6.4 12.8-12.8V204.8c0-6.4-6.4-12.8-12.8-12.8h-22.4c-6.4 0-12.8 6.4-12.8 12.8v134.4c0 6.4 6.4 12.8 12.8 12.8zM496 400H48V80c0-8.84-7.16-16-16-16H16C7.16 64 0 71.16 0 80v336c0 17.67 14.33 32 32 32h464c8.84 0 16-7.16 16-16v-16c0-8.84-7.16-16-16-16zm-387.2-48h22.4c6.4 0 12.8-6.4 12.8-12.8v-70.4c0-6.4-6.4-12.8-12.8-12.8h-22.4c-6.4 0-12.8 6.4-12.8 12.8v70.4c0 6.4 6.4 12.8 12.8 12.8z" class=""></path>
                                        </svg>
                                        Аналітика
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                    <div class="col " style="background-color: #eff3f9;">
                        <div class="container-xxl py-4">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="card mb-4 card-header-actions">
                                        <div class="card-header">
                                            Recent Activity
                                            <div class="dropdown no-caret show">
                                                <button class="btn btn-transparent-dark btn-icon dropdown-toggle" id="dropdownMenuButton" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical text-gray-500">
                                                        <circle cx="12" cy="12" r="1"></circle>
                                                        <circle cx="12" cy="5" r="1"></circle>
                                                        <circle cx="12" cy="19" r="1"></circle>
                                                    </svg></button>
                                                <div class="dropdown-menu dropdown-menu-right animated--fade-in-up show" aria-labelledby="dropdownMenuButton" style="position: absolute; transform: translate3d(-118px, 42px, 0px); top: 0px; left: 0px; will-change: transform;" x-placement="bottom-end">
                                                    <h6 class="dropdown-header">Filter Activity:</h6>
                                                    <a class="dropdown-item" href="#!"><span class="badge badge-green-soft text-green my-1">Commerce</span></a>
                                                    <a class="dropdown-item" href="#!"><span class="badge badge-blue-soft text-blue my-1">Reporting</span></a>
                                                    <a class="dropdown-item" href="#!"><span class="badge badge-yellow-soft text-yellow my-1">Server</span></a>
                                                    <a class="dropdown-item" href="#!"><span class="badge badge-purple-soft text-purple my-1">Users</span></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="timeline timeline-xs">
                                                <!-- Timeline Item 1-->
                                                <div class="timeline-item">
                                                    <div class="timeline-item-marker">
                                                        <div class="timeline-item-marker-text">27 min</div>
                                                        <div class="timeline-item-marker-indicator bg-green"></div>
                                                    </div>
                                                    <div class="timeline-item-content">
                                                        New order placed!
                                                        <a class="font-weight-bold text-dark" href="#!">Order #2912</a>
                                                        has been successfully placed.
                                                    </div>
                                                </div>
                                                <!-- Timeline Item 2-->
                                                <div class="timeline-item">
                                                    <div class="timeline-item-marker">
                                                        <div class="timeline-item-marker-text">58 min</div>
                                                        <div class="timeline-item-marker-indicator bg-blue"></div>
                                                    </div>
                                                    <div class="timeline-item-content">
                                                        Your
                                                        <a class="font-weight-bold text-dark" href="#!">weekly report</a>
                                                        has been generated and is ready to view.
                                                    </div>
                                                </div>
                                                <!-- Timeline Item 3-->
                                                <div class="timeline-item">
                                                    <div class="timeline-item-marker">
                                                        <div class="timeline-item-marker-text">2 hrs</div>
                                                        <div class="timeline-item-marker-indicator bg-purple"></div>
                                                    </div>
                                                    <div class="timeline-item-content">
                                                        New user
                                                        <a class="font-weight-bold text-dark" href="#!">Valerie Luna</a>
                                                        has registered
                                                    </div>
                                                </div>
                                                <!-- Timeline Item 4-->
                                                <div class="timeline-item">
                                                    <div class="timeline-item-marker">
                                                        <div class="timeline-item-marker-text">1 day</div>
                                                        <div class="timeline-item-marker-indicator bg-yellow"></div>
                                                    </div>
                                                    <div class="timeline-item-content">Server activity monitor alert</div>
                                                </div>
                                                <!-- Timeline Item 5-->
                                                <div class="timeline-item">
                                                    <div class="timeline-item-marker">
                                                        <div class="timeline-item-marker-text">1 day</div>
                                                        <div class="timeline-item-marker-indicator bg-green"></div>
                                                    </div>
                                                    <div class="timeline-item-content">
                                                        New order placed!
                                                        <a class="font-weight-bold text-dark" href="#!">Order #2911</a>
                                                        has been successfully placed.
                                                    </div>
                                                </div>
                                                <!-- Timeline Item 6-->
                                                <div class="timeline-item">
                                                    <div class="timeline-item-marker">
                                                        <div class="timeline-item-marker-text">1 day</div>
                                                        <div class="timeline-item-marker-indicator bg-purple"></div>
                                                    </div>
                                                    <div class="timeline-item-content">
                                                        Details for
                                                        <a class="font-weight-bold text-dark" href="#!">Marketing and Planning Meeting</a>
                                                        have been updated.
                                                    </div>
                                                </div>
                                                <!-- Timeline Item 7-->
                                                <div class="timeline-item">
                                                    <div class="timeline-item-marker">
                                                        <div class="timeline-item-marker-text">2 days</div>
                                                        <div class="timeline-item-marker-indicator bg-green"></div>
                                                    </div>
                                                    <div class="timeline-item-content">
                                                        New order placed!
                                                        <a class="font-weight-bold text-dark" href="#!">Order #2910</a>
                                                        has been successfully placed.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="card mb-4">
                                        <div class="card-header">Area Chart Example</div>
                                        <div class="card-body">
                                            <div class="chart-area">
                                                <div class="chartjs-size-monitor">
                                                    <div class="chartjs-size-monitor-expand">
                                                        <div class=""></div>
                                                    </div>
                                                    <div class="chartjs-size-monitor-shrink">
                                                        <div class=""></div>
                                                    </div>
                                                </div><canvas id="myAreaChart" width="842" height="240" style="display: block; width: 842px; height: 240px;" class="chartjs-render-monitor"></canvas>
                                            </div>
                                        </div>
                                        <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6">
                                    <!-- Bar chart example-->
                                    <div class="card mb-4">
                                        <div class="card-header">Bar Chart Example</div>
                                        <div class="card-body">
                                            <div class="chart-bar">
                                                <div class="chartjs-size-monitor">
                                                    <div class="chartjs-size-monitor-expand">
                                                        <div class=""></div>
                                                    </div>
                                                    <div class="chartjs-size-monitor-shrink">
                                                        <div class=""></div>
                                                    </div>
                                                </div><canvas id="myBarChart" width="386" height="240" class="chartjs-render-monitor" style="display: block; width: 386px; height: 240px;"></canvas>
                                            </div>
                                        </div>
                                        <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <!-- Pie chart example-->
                                    <div class="card mb-4">
                                        <div class="card-header">Pie Chart Example</div>
                                        <div class="card-body">
                                            <div class="chart-pie">
                                                <div class="chartjs-size-monitor">
                                                    <div class="chartjs-size-monitor-expand">
                                                        <div class=""></div>
                                                    </div>
                                                    <div class="chartjs-size-monitor-shrink">
                                                        <div class=""></div>
                                                    </div>
                                                </div><canvas id="myPieChart" width="386" height="240" class="chartjs-render-monitor" style="display: block; width: 386px; height: 240px;"></canvas>
                                            </div>
                                        </div>
                                        <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <footer class="page-footer font-small bottom bg-dark accent-4">

            <!-- Copyright -->
            <div class="footer-copyright text-center py-3">© 2015 - 2020 ТОВАРИСТВО З ОБМЕЖЕНОЮ ВІДПОВІДАЛЬНІСТЮ — ТОРГОВО-ВИРОБНИЧИЙ ДІМ "РІВС"
            </div>

        </footer>

    </body>

    </html>
    <script>
        // Set new default font family and font color to mimic Bootstrap's default styling
        (Chart.defaults.global.defaultFontFamily = "Segoe UI"),
        '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = "#858796";

        function number_format(number, decimals, dec_point, thousands_sep) {
            // *     example: number_format(1234.56, 2, ',', ' ');
            // *     return: '1 234,56'
            number = (number + "").replace(",", "").replace(" ", "");
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = typeof thousands_sep === "undefined" ? "," : thousands_sep,
                dec = typeof dec_point === "undefined" ? "." : dec_point,
                s = "",
                toFixedFix = function(n, prec) {
                    var k = Math.pow(10, prec);
                    return "" + Math.round(n * k) / k;
                };
            // Fix for IE parseFloat(0.55).toFixed(0) = 0;
            s = (prec ? toFixedFix(n, prec) : "" + Math.round(n)).split(".");
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || "").length < prec) {
                s[1] = s[1] || "";
                s[1] += new Array(prec - s[1].length + 1).join("0");
            }
            return s.join(dec);
        }

        // Area Chart Example
        var ctx = document.getElementById("myAreaChart");
        var myLineChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: [
                    "Jan",
                    "Feb",
                    "Mar",
                    "Apr",
                    "May",
                    "Jun",
                    "Jul",
                    "Aug",
                    "Sep",
                    "Oct",
                    "Nov",
                    "Dec"
                ],
                datasets: [{
                    label: "Earnings",
                    lineTension: 0.3,
                    backgroundColor: "rgba(0, 97, 242, 0.05)",
                    borderColor: "rgba(0, 97, 242, 1)",
                    pointRadius: 3,
                    pointBackgroundColor: "rgba(0, 97, 242, 1)",
                    pointBorderColor: "rgba(0, 97, 242, 1)",
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: "rgba(0, 97, 242, 1)",
                    pointHoverBorderColor: "rgba(0, 97, 242, 1)",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: [
                        0,
                        10000,
                        5000,
                        15000,
                        10000,
                        20000,
                        15000,
                        25000,
                        20000,
                        30000,
                        25000,
                        40000
                    ]
                }]
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                scales: {
                    xAxes: [{
                        time: {
                            unit: "date"
                        },
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 7
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            maxTicksLimit: 5,
                            padding: 10,
                            // Include a dollar sign in the ticks
                            callback: function(value, index, values) {
                                return "$" + number_format(value);
                            }
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }]
                },
                legend: {
                    display: false
                },
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    titleMarginBottom: 10,
                    titleFontColor: "#6e707e",
                    titleFontSize: 14,
                    borderColor: "#dddfeb",
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    intersect: false,
                    mode: "index",
                    caretPadding: 10,
                    callbacks: {
                        label: function(tooltipItem, chart) {
                            var datasetLabel =
                                chart.datasets[tooltipItem.datasetIndex].label || "";
                            return datasetLabel + ": $" + number_format(tooltipItem.yLabel);
                        }
                    }
                }
            }
        });
        // Set new default font family and font color to mimic Bootstrap's default styling
        (Chart.defaults.global.defaultFontFamily = "Segoe UI"),
        '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = "#858796";

        function number_format(number, decimals, dec_point, thousands_sep) {
            // *     example: number_format(1234.56, 2, ',', ' ');
            // *     return: '1 234,56'
            number = (number + "").replace(",", "").replace(" ", "");
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = typeof thousands_sep === "undefined" ? "," : thousands_sep,
                dec = typeof dec_point === "undefined" ? "." : dec_point,
                s = "",
                toFixedFix = function(n, prec) {
                    var k = Math.pow(10, prec);
                    return "" + Math.round(n * k) / k;
                };
            // Fix for IE parseFloat(0.55).toFixed(0) = 0;
            s = (prec ? toFixedFix(n, prec) : "" + Math.round(n)).split(".");
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || "").length < prec) {
                s[1] = s[1] || "";
                s[1] += new Array(prec - s[1].length + 1).join("0");
            }
            return s.join(dec);
        }

        // Bar Chart Example
        var ctx = document.getElementById("myBarChart");
        var myBarChart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: ["January", "February", "March", "April", "May", "June"],
                datasets: [{
                    label: "Revenue",
                    backgroundColor: "rgba(0, 97, 242, 1)",
                    hoverBackgroundColor: "rgba(0, 97, 242, 0.9)",
                    borderColor: "#4e73df",
                    data: [4215, 5312, 6251, 7841, 9821, 14984]
                }]
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                scales: {
                    xAxes: [{
                        time: {
                            unit: "month"
                        },
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 6
                        },
                        maxBarThickness: 25
                    }],
                    yAxes: [{
                        ticks: {
                            min: 0,
                            max: 15000,
                            maxTicksLimit: 5,
                            padding: 10,
                            // Include a dollar sign in the ticks
                            callback: function(value, index, values) {
                                return "$" + number_format(value);
                            }
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }]
                },
                legend: {
                    display: false
                },
                tooltips: {
                    titleMarginBottom: 10,
                    titleFontColor: "#6e707e",
                    titleFontSize: 14,
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: "#dddfeb",
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                    callbacks: {
                        label: function(tooltipItem, chart) {
                            var datasetLabel =
                                chart.datasets[tooltipItem.datasetIndex].label || "";
                            return datasetLabel + ": $" + number_format(tooltipItem.yLabel);
                        }
                    }
                }
            }
        });
        // Set new default font family and font color to mimic Bootstrap's default styling
        (Chart.defaults.global.defaultFontFamily = "Segoe UI"),
        '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = "#858796";

        // Pie Chart Example
        var ctx = document.getElementById("myPieChart");
        var myPieChart = new Chart(ctx, {
            type: "doughnut",
            data: {
                labels: ["Direct", "Referral", "Social"],
                datasets: [{
                    data: [55, 30, 15],
                    backgroundColor: [
                        "rgba(0, 97, 242, 1)",
                        "rgba(0, 172, 105, 1)",
                        "rgba(88, 0, 232, 1)"
                    ],
                    hoverBackgroundColor: [
                        "rgba(0, 97, 242, 0.9)",
                        "rgba(0, 172, 105, 0.9)",
                        "rgba(88, 0, 232, 0.9)"
                    ],
                    hoverBorderColor: "rgba(234, 236, 244, 1)"
                }]
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: "#dddfeb",
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10
                },
                legend: {
                    display: false
                },
                cutoutPercentage: 80
            }
        });
    </script>
<?php } else {
    include("../scripts.php");
    echo "<script>$(document).ready(function() { $.redirect('/index.php'); });</script>";
    exit();
} ?>