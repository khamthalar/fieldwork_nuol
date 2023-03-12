<?php
require_once "controller/employee_controller.php";
require_once "controller/student_controller.php";
?>
<link rel="stylesheet" href="assets/css/classroom-style.css">
<link rel="stylesheet" href="assets/css/student-style.css">
<script src="assets/js/jquery-1.9.1.min.js"></script>
<div class="header-page">
  <div class="page-title">
    <h5 class="notosans"><a href="template?page=home" class="home-link">ໜ້າຫຼັກ</a> <i class="fas fa-chevron-right"></i> ຂໍ້ມູນນັກສືກສາ</h5>
  </div>
</div>
<div class="page-wrapper">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="cus-card card">
            <div class="card-body">
                <div class="container report-box">
                    <header class="header">
                        <div id="material-tabs">
                            <a id="tab1-tab" href="#tab1" class="notosans f12">ຂໍ້ມູນນັກສຶກສາ</a>
                            <a id="tab2-tab" href="#tab2" class="notosans f12">ນັກສຶກສາໃໝ່</a>
                            <span class="yellow-bar"></span>
                        </div>
                    </header>

                    <div class="tab-content">
                        <div id="tab1" class="left">
                            <?php include_once "pages/student_data.php"; ?>
                        </div>
                        <div id="tab2">
                            <?php include_once "pages/new_student.php"; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php 
  include_once("modals/confirm_dialog.php");
  include_once("modals/student_info_modal.php");
?>
<script src="assets/script/student.js"></script>
<script>
  var student_info = document.getElementById('stdinfo');
  student_info.addEventListener('show.bs.modal',function(event){
    var stddata = $(event.relatedTarget);
    let student_code = stddata.data('student_code');
    let fullname_la = stddata.data('fullname_la');
    let fullname_en = stddata.data('fullname_en');
    let birthdate = stddata.data('birthdate');
    let classroom_des = stddata.data('classroom_des');
    let address_la = stddata.data('address_la'); 
    let address_en = stddata.data('address_en');
    var modal = $(this);
    modal.find('.modal-body #student_code')[0].innerHTML=student_code;
    modal.find('.modal-body #fullname_la')[0].innerHTML=fullname_la;
    modal.find('.modal-body #fullname_en')[0].innerHTML=fullname_en;
    modal.find('.modal-body #dateofbirth')[0].innerHTML=birthdate;
    modal.find('.modal-body #class_des')[0].innerHTML=classroom_des;
    modal.find('.modal-body #address_la')[0].innerHTML=address_la;
    modal.find('.modal-body #address_en')[0].innerHTML=address_en;
  })
</script>