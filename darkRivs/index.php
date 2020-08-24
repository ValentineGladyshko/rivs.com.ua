<?php
require_once("../LDLRIVS.php");

my_session_start();

$verification_token = base64_encode(openssl_random_pseudo_bytes(32));
$_SESSION['verification_token'] = $verification_token;
$security_token = $_SESSION["security_admin_token"];
$security_token1 = $_COOKIE["security_admin_token"];

if ($security_token == null || $security_token1 == null) {
    include("../scripts.php");
   echo "<script>$(document).ready(function() { $.redirect('login.php'); });</script>";
   exit();
}

if (hash_equals($security_token, $security_token1)) {
?>
    <? include("functions/header.php"); ?>
    <div class="row">
        <div class="col-xl-6">
            <div class="card mb-4 card-header-actions">
                <div class="card-header">
                    Recent Activity
                    <div class="dropdown no-caret">
                        <button class="btn btn-transparent-dark btn-icon dropdown-toggle" id="dropdownMenuButton" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical text-gray-500">
                                <circle cx="12" cy="12" r="1"></circle>
                                <circle cx="12" cy="5" r="1"></circle>
                                <circle cx="12" cy="19" r="1"></circle>
                            </svg>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right animated--fade-in-up" aria-labelledby="dropdownMenuButton" style="position: absolute; transform: translate3d(-118px, 42px, 0px); top: 0px; left: 0px; will-change: transform;" x-placement="bottom-end">
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

    <? include("functions/footer.php"); ?>
    <? include("functions/myScripts.php"); ?>
    <script>
        var elem = document.getElementById("main-nav");
        elem.classList.add('active');
    </script>
<?php } else {
    include("../scripts.php");
    echo "<script>$(document).ready(function() { $.redirect('login.php'); });</script>";
    exit();
} ?>