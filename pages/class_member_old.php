<?php
require_once "controller/class_member_controller.php";
$school_year = date("Y") . "-" . (date("Y") + 1);
$course = load_course();
$course_data = $course->fetchAll(PDO::FETCH_ASSOC);
$course_id = isset($_GET["course_id"])?$_GET["course_id"]:(($course->rowCount()>0)?$course_data[0]['course_id']:0);
$classroom = load_class_data($course_id);
$classroom_data = $classroom->fetchAll(PDO::FETCH_ASSOC);
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
              </div>
            </div>
            <section class="body-content">
              <section class="classroom">
                <div class="row px-3">
                  <?php 
                    foreach($classroom_data as $class_item){
                  ?>
                  <div class="col-xl-3 col-md-4 col-sm-6 col-xs-12 mb-2 px-1 stretch-card transparent">
                    <div class="classroom-card card card-dark-blue pointer">
                      <div class="card-body">
                        <h4 class="card-title notosans col-white">ຫ້ອງຮຽນ <?=$class_item['classroom_des']?></h4>
                          <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                            <span class="display-5 text-info">
                              <img src="assets/svg/classroom.svg" width="70">
                            </span>
                          <a class="link display-5 ml-auto notosans col-white">ນັກຮຽນ <?= $class_item['std_count'] ?> ຄົນ</a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php } ?>
                </div>
                <pre>
                <?php 
                  print_r($classroom_data);
                ?>
                </pre>
              </section>
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
<script src="assets/js/custom_js/class_member.js"></script>