<?php
require_once "controller/class_member_controller.php";
$school_year = date("Y") . "-" . (date("Y") + 1);
$course = load_course();
$course_data = $course->fetchAll(PDO::FETCH_ASSOC);
$course_id = isset($_GET["course_id"])?$_GET["course_id"]:(($course->rowCount()>0)?$course_data[0]['course_id']:0);
$show_status = isset($_GET["status"])?$_GET["status"]:1;
$classroom_id = isset($_GET["classroom_id"])?$_GET["classroom_id"]:0;
?>
<link rel="stylesheet" href="assets/css/classroom-style.css">
<link rel="stylesheet" href="assets/css/class-member-style.css">
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
            <h4 class="card-title notosans">ຈັດຫ້ອງຮຽນ, ສົກຮຽນ <?= $school_year ?></h4>
            <div class="top-contents">
              <div style="padding-left:10px;padding-right:10px;" class="filter row">
                <div style="padding-left:5px;padding-right:5px;" class="col-lg-4 col-sm-6 mb-2">
                  <select onChange="course_selected(this.value)" class="form-select notosans" aria-label="Default select" name="cb_course" id="cb_course">
                    <?php
                    foreach ($course_data as $course) {
                      $checked = "";
                      if ($course['course_id'] == $course_id) {
                        $checked = "selected";
                      }
                    ?>
                      <option value="<?= $course['course_id'] ?>" <?= $checked ?> <?= ($course_id == $course['course_id']) ? "selected" : "" ?>>
                        <?= $course['course_des'] . "-" . $course['scheme_des'] ?>
                      </option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
                <div style="padding-left:5px;padding-right:5px;" class="col-lg-2 col-sm-4 mb-2">
                    <select onChange="classroom_selected(this.value)" class="form-select notosans" aria-label="Default select" name="cb_class" id="cb_class">
                    </select>
                </div>
                <div style="padding-left:5px;padding-right:5px;" class="col-lg-3 col-sm-5  mb-2">
                  <select onchange="status_change(this.value)" name="cb_status" id="cb_status" class="form-select notosans" aria-label="Default select">
                    <option value="1" <?=($show_status==1)?"selected":""?>>ສະແດງສະເພາະຜູ້ທີ່ບໍ່ທັນໄດ້ຈັດຫ້ອງ</option>
                    <option value="2" <?=($show_status==2)?"selected":""?>>ສະແດງສະເພາະຜູ້ທີ່ຈັດຫ້ອງແລ້ວ</option>
                    <option value="3" <?=($show_status==3)?"selected":""?>>ສະແດງທັງໝົດ</option>
                  </select>
                </div>
              </div>
            </div>
            <section class="body-content">
              <div class="">
              <table class="table">
                <thead>
                    <tr>
                        <th class="col-id notosans f12" width="30">ລ/ດ</th>
                        <th class="notosans">ລະຫັດນັກສຶກສາ</th>
                        <th class="notosans">ຊື່ ແລະ ນາມສະກຸນ</th>
                        <th class="notosans">ຫ້ອງຮຽນ</th>
                    </tr>
                </thead>
                <tbody id="student-data"></tbody>
            </table>
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
<script>
  var school_year = '<?=$school_year?>';
  var course_id = '<?=$course_id ?>';
  var show_status = '<?=$show_status?>';
  var classroom_id = '<?=($classroom_id)?>'
</script>
<script src="assets/script/class_member.js"></script>