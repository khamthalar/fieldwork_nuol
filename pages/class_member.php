<?php
  require_once "controller/class_member_controller.php";
?>
<link rel="stylesheet" href="assets/css/classroom-style.css">
<script src="assets/js/jquery-1.9.1.min.js"></script>
<div class="header-page">
  <div class="page-title">
    <h5 class="notosans"><a href="template?page=home" class="home-link">ໜ້າຫຼັກ</a> <i class="fas fa-chevron-right"></i> ຈັດຫ້ອງຮຽນ</h5>
  </div>
</div>
<div class="page-wrapper">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="cus-card card">
          <div class="card-body">
            <h4 class="card-title notosans">ຈັດຫ້ອງຮຽນ, ສົກຮຽນ <?= date("Y") . "-" . (date("Y") + 1) ?></h4>
            <div class="top-contents">
              <form action="" method="POST">
                <div style="padding-left:10px;padding-right:10px;" class="filter row">
                  <div style="padding-left:5px;padding-right:5px;" class="col-lg-4 col-sm-6 mb-2">
                    <select class="form-select notosans" aria-label="Default select" name="cb_course" id="cb_course">
                    </select>
                  </div>
                  <div style="padding-left:5px;padding-right:5px;" class="col-lg-2 col-sm-2 mb-2">
                    <select class="form-select notosans" aria-label="Default select" name="year_no" id="year_no">
                    </select>
                  </div>
                  <div style="padding-left:5px;padding-right:5px;" class="col-lg-3 col-sm-4 mb-2">
                    <select class="form-select notosans" aria-label="Default select" name="cb_class" id="cb_class">
                    </select>
                  </div>
                  <div style="padding-left:5px;padding-right:5px;" class="col-lg-3 col-sm-4 mb-2">
                    <select class="form-select notosans" aria-label="Default select" name="status" id="status">
                    </select>
                  </div>
                  <div style="padding-left:5px;padding-right:5px;" class="col-lg-3 col-sm-4 mb-2">
                    <input name="txt_search" style="padding: .375rem 2.25rem .375rem .75rem !important;line-height:1.5 !important; height:38px !important;" id="search" type="text" class="form-control notosans" placeholder="Search..." />
                  </div>
                  <div style="padding-left:5px;padding-right:5px;" class="col-lg-2">
                    <button name="search" type="submit" class="btn-newclass btn btn-primary btn-icon-text none-select none-outline notosans">
                      <i class="ti-search btn-icon-prepend"></i> ຄົ້ນຫາ
                    </button>
                  </div>
                </div>
              </form>
            </div>
            <div class="table-responsive">
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
include_once("modals/confirm_dialog.php");
?>