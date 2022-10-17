<?php
  require_once "controller/register_controller.php";
?>
<link rel="stylesheet" href="assets/css/classroom-style.css">
<script src="assets/js/jquery-1.9.1.min.js"></script>
<div class="header-page">
  <div class="page-title">
    <h5 class="notosans"><a href="template?page=home" class="home-link">ໜ້າຫຼັກ</a> <i class="fas fa-chevron-right"></i> ແຈ້ງລົງທະບຽນ</h5>
  </div>
</div>
<div class="page-wrapper">
  <div class="content-wrapper">
    <?php
      $user_id = @$user_data['id'];
      $course_data = load_course()->fetchAll(PDO::FETCH_ASSOC);
      $course_id = 0;
      $selected_year = 1;
      if(count( $course_data)!=0){
        $course_id = isset($_GET['course_id'])?$_GET['course_id']:$course_data[0]['course_id'];
        $selected_year = isset($_GET['selected_year'])?$_GET['selected_year']:1;
      }
      $data = load_classroom($course_id,$selected_year)->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="cus-card card">
          <div class="card-body">
            <h4 class="card-title notosans">ແຈ້ງລົງທະບຽນປະຈໍາສົກຮຽນ <?= date("Y") . "-" . (date("Y") + 1) ?></h4>
            <div class="top-contents">
              <div style="padding-left:10px;padding-right:10px;" class="filter row">
                <div style="padding-left:5px;padding-right:5px;" class="col-lg-4 col-sm-6 mb-2">
                  <select onChange="course_selected(this.value)" class="form-select notosans" aria-label="Default select" name="cb_course" id="cb_course">
                    <?php
                      foreach($course_data as $course){
                        $checked = "";
                        if($course['course_id']==$course_id){
                          $checked = "selected";
                        }
                        ?>
                        <option value="<?=$course['course_id'].','.$course['duration_year']?>" <?=$checked?>><?=$course['course_des']."-".$course['scheme_des']?></option>
                        <?php
                      }
                    ?>
                  </select>
                </div>
                <div style="padding-left:5px;padding-right:5px;"  class="col-lg-2 col-sm-2 mb-2">
                  <select class="form-select notosans" aria-label="Default select" 
                  name="year_no" id="year_no">
                  </select>
                </div>
                <div style="padding-left:5px;padding-right:5px;" class="col-lg-3 col-sm-4 mb-2">
                  <select class="form-select notosans" aria-label="Default select" name="status" id="status">
                    <option value="0">ສະແດງສະເພາະທີ່ບໍ່ທັນລົງທະບຽນ</option>
                    <option value="1">ສະແດງທັງໝົດ</option>
                  </select>
                </div>
                <div style="padding-left:5px;padding-right:5px;" class="col-lg-3 col-sm-4 mb-2">
                  <select class="form-select notosans" aria-label="Default select" name="status" id="status">
                    <option value="0">ສະແດງສະເພາະທີ່ບໍ່ທັນລົງທະບຽນ</option>
                    <option value="1">ສະແດງທັງໝົດ</option>
                  </select>
                </div>
                <div style="padding-left:5px;padding-right:5px;" class="col-lg-3 col-sm-4 mb-2">
                    <input style="padding: .375rem 2.25rem .375rem .75rem !important;line-height:1.5 !important; height:38px !important;" 
                    id="search" type="text" class="form-control notosans" placeholder="Search..."/>
                </div>
                <div style="padding-left:5px;padding-right:5px;" class="col-lg-2">
                  <button onclick="showdata()" type="button" class="btn-newclass btn btn-primary btn-icon-text none-select none-outline notosans">
                    <i class="ti-search btn-icon-prepend"></i> ຄົ້ນຫາ
                  </button>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th class="col-id notosans center f12" width="60">ລ/ດ</th>
                    <th class="notosans f12">ລະຫັດນັກສຶກສາ</th>
                    <th class="notosans f12">ຊື່ ແລະ ນາມສະກຸນ</th>
                    <th class="notosans f12">ຫ້ອງຮຽນ</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>

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
<script>
  var course_id = <?=$course_id?>;
  var selected_course_id = <?=$course_id?>;
  var selected_year = <?=$selected_year?>;
  var year_no = 0;
  var cb_year = document.getElementById('year_no');
  var add_classroom = document.getElementById('addclass');
</script>
<script src="assets/js/custom_js/classroom.js"></script>