<?php
    require_once "controller/new_student_controller.php";
?>
<link rel="stylesheet" href="assets/css/student-style.css">
<link rel="stylesheet" href="assets/css/student-excel-upload-style.css">
<script src="assets/js/jquery-1.9.1.min.js"></script>
<div class="header-page">
  <div class="page-title">
    <h5 class="notosans">
        <a href="template?page=home" class="home-link">ໜ້າຫຼັກ</a> 
        <i class="fas fa-chevron-right"></i> 
        <a href="template?page=student" class="home-link">ຂໍ້ມູນນັກສືກສາ</a>
        <i class="fas fa-chevron-right"></i> ອັບໂຫຼດຂໍ້ມູນນັກສຶກສາ
    </h5>
  </div>
</div>
<div class="page-wrapper">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="cus-card card">
            <div class="card-body">
                <h4 class="card-title notosans">ອັບໂຫຼດຂໍ້ມູນນັກສຶກສາ,
                    ສົກຮຽນ: <?= date("Y") . "-" . (date("Y") + 1) ?>
                </h4>
                <section class="file-upload">
                    <button onclick="open_file()" type="button" class="btn-file btn btn-primary btn-icon-text none-select none-outline notosans">
                        <i class="ti-clip btn-icon-prepend"></i> ເລືອກຟາຍ
                    </button>
                    <div class="path notosans f12" id="path"></div>
                    <input id="upload" type=file name="files[]" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" hidden>
                </section>
                <section class="body">
                    <table>
                        <thead>
                            <tr>
                                <th class="notosans f12 center">ລ/ດ</th>
                                <th class="notosans f12 center" colspan="2">ລະຫັດນັກສຶກສາ</th>
                                <th class="notosans f12 center">ເພດ</th>
                                <th class="notosans f12" colspan="2">ຊື່ ແລະ ນາມສະກຸນ</th>
                                <th class="notosans f12">ໝາຍເຫດ</th>
                            </tr>
                        </thead>
                        <tbody id="tb_body">
                        </tbody>
                    </table>
                    <div class="center pt-2">
                        <button type="button" class="btn-file btn btn-primary btn-icon-text none-select none-outline notosans">
                            <i class="ti-export btn-icon-prepend"></i> ອັບໂຫຼດ
                        </button>
                    </div>
                </section>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php 
  include_once("modals/confirm_dialog.php");
?>
<script src="module/sheetJS/xlsx.full.min.js"></script>
<script src="assets/js/custom_js/new_student_excel_upload.js"></script>
