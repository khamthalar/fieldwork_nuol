<?php
    session_start();
    date_default_timezone_set("Asia/Vientiane");
    if (empty($_SESSION["user_login"])) {
        header("location:login");
    } else {
        $user_data = $_SESSION["user_login"];
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>EDL Quiz System</title>
    <link rel="icon" type="image/png" href="assets/favicon.png">

    <link rel="stylesheet" href="assets/css/main-style.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <link href="module/fontawesome-5.15.4/css/all.css" rel="stylesheet">
    <script src="module/fontawesome-5.15.4/js/all.js"></script>
    <!-- bootstrap -->
    <link rel="stylesheet" href="module/bootstrap-5.1.3/css/bootstrap.min.css">
    <script src="module/bootstrap-5.1.3/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="assets/css/loader_style.css">
    <!-- sweetalert -->
    <link rel="stylesheet" href="module/sweetalert2/dist/sweetalert2.min.css">
    <script src="module/sweetalert2/dist/sweetalert2.all.min.js"></script>

    <script src="assets/js/jquery-1.9.1.min.js"></script>

    <link rel="stylesheet" href="assets/css/vertical-layout-light/style.css">
</head>

<body>
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">Loading...</p>
        </div>
    </div>
    <div class="nav">
        <?php include_once "student/student_nav.php"; ?>
    </div>
    <div class="_container">
        <?php 
            if(isset($_GET['page'])){
                $content_page = $_GET['page'];
                include_once "student/$content_page.php";
            }else{
        ?>
        <header class="header">
            <div id="material-tabs">
                <a id="tab1-tab" href="#tab1">
                    <!-- <div class="tab-ico">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" height="30" fill="#424f5a">
                            <path d="M511.8 287.6L512.5 447.7C512.5 450.5 512.3 453.1 512 455.8V472C512 494.1 494.1 512 472 512H456C454.9 512 453.8 511.1 452.7 511.9C451.3 511.1 449.9 512 448.5 512H392C369.9 512 352 494.1 352 472V384C352 366.3 337.7 352 320 352H256C238.3 352 224 366.3 224 384V472C224 494.1 206.1 512 184 512H128.1C126.6 512 125.1 511.9 123.6 511.8C122.4 511.9 121.2 512 120 512H104C81.91 512 64 494.1 64 472V360C64 359.1 64.03 358.1 64.09 357.2V287.6H32.05C14.02 287.6 0 273.5 0 255.5C0 246.5 3.004 238.5 10.01 231.5L266.4 8.016C273.4 1.002 281.4 0 288.4 0C295.4 0 303.4 2.004 309.5 7.014L416 100.7V64C416 46.33 430.3 32 448 32H480C497.7 32 512 46.33 512 64V185L564.8 231.5C572.8 238.5 576.9 246.5 575.8 255.5C575.8 273.5 560.8 287.6 543.8 287.6L511.8 287.6z"/>
                        </svg>
                    </div> -->
                    <div class="phetsarath">ໜ້າຫຼັກ</div>
                </a>
                <a id="tab2-tab" href="#tab2">
                    <!-- <div class="tab-ico">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" height="30" fill="#424f5a">
                            <path d="M336 64h-53.88C268.9 26.8 233.7 0 192 0S115.1 26.8 101.9 64H48C21.5 64 0 85.48 0 112v352C0 490.5 21.5 512 48 512h288c26.5 0 48-21.48 48-48v-352C384 85.48 362.5 64 336 64zM96 392c-13.25 0-24-10.75-24-24S82.75 344 96 344s24 10.75 24 24S109.3 392 96 392zM96 296c-13.25 0-24-10.75-24-24S82.75 248 96 248S120 258.8 120 272S109.3 296 96 296zM192 64c17.67 0 32 14.33 32 32c0 17.67-14.33 32-32 32S160 113.7 160 96C160 78.33 174.3 64 192 64zM304 384h-128C167.2 384 160 376.8 160 368C160 359.2 167.2 352 176 352h128c8.801 0 16 7.199 16 16C320 376.8 312.8 384 304 384zM304 288h-128C167.2 288 160 280.8 160 272C160 263.2 167.2 256 176 256h128C312.8 256 320 263.2 320 272C320 280.8 312.8 288 304 288z"/>
                        </svg>
                    </div> -->
                    <div class="phetsarath">ປະຫວັດການສອບເສັງ</div>
                </a>
                <span class="yellow-bar"></span>
            </div>
        </header>
        <div class="tab-content">
            <div id="tab1">
                <?php include_once "student/home.php"; ?>
            </div>
            <div id="tab2">
                <?php include_once "student/history.php"; ?>
            </div>
        </div>
        <?php } ?>
    </div>
</body>
<script src="assets/js/custom_js/main-page.js"></script>

<?php include 'modals/logout_confirm.php' ?>

<!-- plugins:js -->
<script src="assets/vendors/js/vendor.bundle.base.js"></script>

</html>