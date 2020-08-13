<!DOCTYPE html>
<html lang="en">

<head>

    <link rel="shortcut icon" href="/Images/webicon.png" type="image/x-icon">
    <title>
        ТОВ ТВД "РІВС" / Адміністративна сторінка
    </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="/css/mdb.css" rel="stylesheet">
    <!-- Your custom styles (optional) -->
    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/styles.css" rel="stylesheet">
    <link href="/css/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- SCRIPTS -->
    <!-- JQuery -->
    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <script type="text/javascript" src="/js/Chart.min.js"></script>
    <script type="text/javascript" src="/js/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="/js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="/js/mdb.js"></script>
    <script type="text/javascript" src="/js/jquery.redirect.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script data-search-pseudo-elements defer src="/js/all.min.js"></script>
    <script src="/js/feather.min.js"></script>
</head>

<body class="nav-fixed" style="overflow-x: overlay;">
    <nav class="topnav navbar py-0 pl-3 navbar-dark bg-dark" style="z-index:2">
        <a class="navbar-brand px-2" href="#" style="width:50px;">
            <img src="/Images/logo.png" width="30" height="40" alt="logo" style="width:30px; height:40px">
        </a>
        <svg xmlns="http://www.w3.org/2000/svg" height="30" viewBox="0 0 448 512">
            <g>
                <path fill="currentColor" class="golden" d="M352 96H96V0l64 32 64-32 64 32 64-32z"></path>
                <path fill="currentColor" class="text-light" d="M313.6 304h-16.71a174 174 0 0 1-145.78 0H134.4A134.4 134.4 0 0 0 0 438.4V464a48 48 0 0 0 48 48h352a48 48 0 0 0 48-48v-25.6A134.4 134.4 0 0 0 313.6 304zM224 272a128 128 0 0 0 128-128v-16H96v16a128 128 0 0 0 128 128z"></path>
            </g>
        </svg>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav" style="z-index:1">
            <nav class="sidenav bg-dark-alt sidebar">
                <ul class="nav flex-column py-4 pl-3">
                    <li class="nav-item">
                        <a id="main-nav" class="nav-link" href="index.php">
                            <svg width="24px" height="24px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path fill="currentColor" d="M139.61 35.5a12 12 0 0 0-17 0L58.93 98.81l-22.7-22.12a12 12 0 0 0-17 0L3.53 92.41a12 12 0 0 0 0 17l47.59 47.4a12.78 12.78 0 0 0 17.61 0l15.59-15.62L156.52 69a12.09 12.09 0 0 0 .09-17zm0 159.19a12 12 0 0 0-17 0l-63.68 63.72-22.7-22.1a12 12 0 0 0-17 0L3.53 252a12 12 0 0 0 0 17L51 316.5a12.77 12.77 0 0 0 17.6 0l15.7-15.69 72.2-72.22a12 12 0 0 0 .09-16.9zM64 368c-26.49 0-48.59 21.5-48.59 48S37.53 464 64 464a48 48 0 0 0 0-96zm432 16H208a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h288a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-320H208a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h288a16 16 0 0 0 16-16V80a16 16 0 0 0-16-16zm0 160H208a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h288a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16z" class=""></path>
                            </svg>
                            Головна
                        </a>
                    </li>
                    <li class="nav-item">
                        <a id="orders-nav" class="nav-link" href="orders.php">
                            <svg width="24px" height="24px" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M2 3a2 2 0 0 1 2-2h5.293a1 1 0 0 1 .707.293L13.707 5a1 1 0 0 1 .293.707V13a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V3zm7 2V2l4 4h-3a1 1 0 0 1-1-1zM4.5 8a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7zM4 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5z" />
                            </svg>
                            Замовлення
                        </a>
                    </li>
                    <li class="nav-item">
                        <a id="products-nav" class="nav-link" href="products.php">
                            <svg width="24px" height="24px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                <path fill="currentColor" d="M446.7 160c.4-.5.5-.7.9-1.2L391.3 53.9C386.9 40.8 374.7 32 360.9 32H256l32 128h158.7zM160 160l32-128H87.1c-13.8 0-26 8.8-30.4 21.9L.4 158.8c.4.5.5.7.9 1.2H160zm128 32v80c0 8.8-7.2 16-16 16h-96c-8.8 0-16-7.2-16-16v-80H0v256c0 17.7 14.3 32 32 32h384c17.7 0 32-14.3 32-32V192H288z" class=""></path>
                            </svg>
                            Товари
                        </a>
                    </li>
                    <li class="nav-item">
                        <a id="users-nav" class="nav-link" href="users.php">
                            <svg width="24px" height="24px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                                <path fill="currentColor" d="M192 256c61.9 0 112-50.1 112-112S253.9 32 192 32 80 82.1 80 144s50.1 112 112 112zm76.8 32h-8.3c-20.8 10-43.9 16-68.5 16s-47.6-6-68.5-16h-8.3C51.6 288 0 339.6 0 403.2V432c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48v-28.8c0-63.6-51.6-115.2-115.2-115.2zM480 256c53 0 96-43 96-96s-43-96-96-96-96 43-96 96 43 96 96 96zm48 32h-3.8c-13.9 4.8-28.6 8-44.2 8s-30.3-3.2-44.2-8H432c-20.4 0-39.2 5.9-55.7 15.4 24.4 26.3 39.7 61.2 39.7 99.8v38.4c0 2.2-.5 4.3-.6 6.4H592c26.5 0 48-21.5 48-48 0-61.9-50.1-112-112-112z" class=""></path>
                            </svg>
                            Користувачі
                        </a>
                    </li>
                    <li class="nav-item">
                        <a id="admins-nav" class="nav-link" href="admins.php">
                            <svg width="24px" height="24px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                                <path fill="currentColor" d="M96 224c35.35 0 64-28.65 64-64s-28.65-64-64-64-64 28.65-64 64 28.65 64 64 64zm224 32c53.02 0 96-42.98 96-96v-16H224v16c0 53.02 42.98 96 96 96zm256 0h-64c-17.59 0-33.5 7.11-45.07 18.59 40.27 22.06 68.86 62.03 75.13 109.41H608c17.67 0 32-14.33 32-32v-32c0-35.35-28.65-64-64-64zm-402.93 18.59C161.5 263.11 145.59 256 128 256H64c-35.35 0-64 28.65-64 64v32c0 17.67 14.33 32 32 32h65.94c6.27-47.38 34.85-87.34 75.13-109.41zM544 224c35.35 0 64-28.65 64-64s-28.65-64-64-64-64 28.65-64 64 28.65 64 64 64zm-147.2 64h-8.31c-20.84 9.96-43.89 16-68.49 16s-47.64-6.04-68.49-16h-8.31C179.58 288 128 339.58 128 403.2V432c0 26.51 21.49 48 48 48h288c26.51 0 48-21.49 48-48v-28.8c0-63.62-51.58-115.2-115.2-115.2zM416 32l-48 24-48-24-48 24-48-24v80h192V32z" class=""></path>
                            </svg>
                            Адміністратори
                        </a>
                    </li>
                    <li class="nav-item">
                        <a id="analytics-nav" class="nav-link" href="analytics.php">
                            <svg width="24px" height="24px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path fill="currentColor" d="M396.8 352h22.4c6.4 0 12.8-6.4 12.8-12.8V108.8c0-6.4-6.4-12.8-12.8-12.8h-22.4c-6.4 0-12.8 6.4-12.8 12.8v230.4c0 6.4 6.4 12.8 12.8 12.8zm-192 0h22.4c6.4 0 12.8-6.4 12.8-12.8V140.8c0-6.4-6.4-12.8-12.8-12.8h-22.4c-6.4 0-12.8 6.4-12.8 12.8v198.4c0 6.4 6.4 12.8 12.8 12.8zm96 0h22.4c6.4 0 12.8-6.4 12.8-12.8V204.8c0-6.4-6.4-12.8-12.8-12.8h-22.4c-6.4 0-12.8 6.4-12.8 12.8v134.4c0 6.4 6.4 12.8 12.8 12.8zM496 400H48V80c0-8.84-7.16-16-16-16H16C7.16 64 0 71.16 0 80v336c0 17.67 14.33 32 32 32h464c8.84 0 16-7.16 16-16v-16c0-8.84-7.16-16-16-16zm-387.2-48h22.4c6.4 0 12.8-6.4 12.8-12.8v-70.4c0-6.4-6.4-12.8-12.8-12.8h-22.4c-6.4 0-12.8 6.4-12.8 12.8v70.4c0 6.4 6.4 12.8 12.8 12.8z" class=""></path>
                            </svg>
                            Аналітика
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        <div id="layoutSidenav_content" style="background-color: #eff3f9; padding-bottom:56px">
            <main>
                <div class="col">
                    <div class="container-xxl py-4">