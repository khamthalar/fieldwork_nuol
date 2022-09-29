<?php
    // require_once "controller/daskboard_controller.php";
    // $_data = load_data()->fetchAll(PDO::FETCH_ASSOC)[0]['data'];
    // $data = json_decode($_data);
?>
<link rel="stylesheet" href="assets/css/home-style.css">
<div class="header-page">
        <div class="page-title">
            <h5 class="notosans home-link">ໜ້າຫຼັກ</h5>
        </div>
    </div>
    <div class="page-wrapper">
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="deskboard-card card tale-bg">


                </div>
            </div>
            <div class="col-md-6 grid-margin transparent">
                <div class="row">
                    <div class="col-md-6 mb-4 stretch-card transparent">
                        <div class="deskboard-card card card-dark-blue">
                            <div class="card-body">
                                <h4 class="card-title notosans col-white">ຫ້ອງເສັງ</h4>
                                <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                    <span class="display-5 text-info">
                                        <img src="assets/svg/classroom.svg" width="70">
                                    </span>
                                    <a class="link display-5 ml-auto col-white"><?="data->class_num"?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4 stretch-card transparent">
                        <div class="deskboard-card card card-tale pointer" onclick="location.href = 'template?page=subject';">
                            <div class="card-body">
                                <h4 class="card-title notosans col-white">ວິຊາເສັງ</h4>
                                <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                    <span class="display-5 text-info">
                                        <img src="assets/svg/file.svg" width="70">
                                    </span>
                                    <a class="link display-5 ml-auto col-white"><?="data->subj_num"?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                        <div class="deskboard-card card card-light-blue">
                            <div class="card-body">
                                <h4 class="card-title notosans col-white">ຫົວຂໍ້ສອບ</h4>
                                <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                    <span class="display-5 text-purple">
                                        <img src="assets/svg/quiz.svg" width="70">
                                    </span>
                                    <a class="link display-5 ml-auto col-white"><?="data->quiz_num"?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 stretch-card transparent">
                        <div class="deskboard-card card card-light-danger">
                            <div class="card-body">
                                <h4 class="card-title notosans col-white">ຄໍາຖາມ</h4>
                                <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                    <span class="display-5 text-purple">
                                        <img src="assets/svg/qa.svg" width="70">
                                    </span>
                                    <a class="link display-5 ml-auto col-white"><?="data->question_num"?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>





        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="deskboard-card card position-relative">
                    <div class="card-body">
                        <div id="detailedReports" class="detailed-report-carousel position-static pt-2">
                            <div class="row">
                                <div class="col-md-12 col-xl-3 d-flex flex-column justify-content-start">
                                    <div class="ml-xl-4 mt-3">
                                        <p class="card-title notosans f16">ລາຍງານ</p>
                                        <h3 class="font-weight-500 mb-xl-4 text-primary notosans">ຜູ້ໃຊ້ງານລະບົບທັງໝົດ</h3>
                                        <h1 class="text-primary"><i class="fas fa-users"></i> <?="data->users_num"?></h1>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xl-9">
                                    <div class="row">
                                        <div class="col-md-6 border-right">
                                            <div class="table-responsive mb-3 mb-md-0 mt-3">
                                                
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <canvas id="north-america-chart"></canvas>
                                            <div id="north-america-legend"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>