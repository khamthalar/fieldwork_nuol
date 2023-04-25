<?php
require_once "controller/register_controller.php";
if(isset($_POST["search"])){
  $id =explode(",", $_POST["cb_course"]);
  $rg_filter["course_id"]=$id[0];
  $rg_filter["year_no"]=$_POST["year_no"];
  $rg_filter["classroom_id"]=$_POST["cb_class"];
  $rg_filter["register_status"]=$_POST["status"];
  $rg_filter["search_text"]=$_POST["txt_search"];
  $_SESSION["rg_filter"]=$rg_filter;
}
$start_year = date('Y');
$end_year = date('Y')+1;

?>
<link rel="stylesheet" href="assets/css/classroom-style.css">
<link rel="stylesheet" href="assets/css/register-style.css">
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
    $selected_year = isset($_SESSION["rg_filter"]) ? $_SESSION["rg_filter"]["year_no"] : 1;
    $classroom_id = isset($_SESSION["rg_filter"]) ? $_SESSION["rg_filter"]["classroom_id"] : 0;
    $register_status = isset($_SESSION["rg_filter"]) ? $_SESSION["rg_filter"]["register_status"] : 0;
    $search_text = isset($_SESSION["rg_filter"]) ? $_SESSION["rg_filter"]["search_text"] : "";
    $course_data = load_course()->fetchAll(PDO::FETCH_ASSOC);
    $student_data = array();
    if(count($course_data)>0){
      $course_id = isset($_SESSION["rg_filter"]) ? $_SESSION["rg_filter"]["course_id"] : $course_data[0]["course_id"];
      $data = load_classroom($course_id, $selected_year)->fetchAll(PDO::FETCH_ASSOC);
      $filter = " AND r.year_no='".$selected_year."' ";
      $filter .=($classroom_id==0)?"":" AND r.classroom_id='".$classroom_id."' ";
      $filter .=($register_status==1)?"":" AND r.register_status='".$register_status."' ";
      $filter .=" AND s.course_id='".$course_id."' ";
      $filter .=($search_text=="")?"":" AND (CONCAT(s.name_la,' ',s.surname_la) LIKE '%".$search_text."%' OR r.student_code LIKE '%".$search_text."%' ) ";
      $student_data = load_student($filter)->fetchAll(PDO::FETCH_ASSOC);
      // print_r(load_student($filter));
    }else{
      $course_id = 0;
    }
    ?>
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="cus-card card">
          <div class="card-body">
            <div class="register-schoolyear">
              <h4 class="card-title notosans" style="margin:0;">ແຈ້ງລົງທະບຽນປະຈໍາສົກຮຽນ</h4>
              <button onclick="openSchoolyearModal(false)" class="btn-schoolyear"><?= date("Y") . "-" . (date("Y") + 1) ?></button>
            </div>
            <div class="top-contents">
              <form action="" method="POST">
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
                        <option 
                          value="<?= $course['course_id'] . ',' . $course['duration_year'] ?>" <?= $checked ?>
                          <?=($course_id==$course['course_id'])?"selected":""?>
                          >
                          <?= $course['course_des'] . "-" . $course['scheme_des'] ?>
                        </option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div style="padding-left:5px;padding-right:5px;" class="col-lg-2 col-sm-2 mb-2">
                    <select onChange="year_selected(this.value)" class="form-select notosans" aria-label="Default select" name="year_no" id="year_no">
                    </select>
                  </div>
                  <div style="padding-left:5px;padding-right:5px;" class="col-lg-3 col-sm-4 mb-2">
                    <select class="form-select notosans" aria-label="Default select" name="cb_class" id="cb_class">
                    </select>
                  </div>
                  <div style="padding-left:5px;padding-right:5px;" class="col-lg-3 col-sm-4 mb-2">
                    <select class="form-select notosans" aria-label="Default select" name="status" id="status">
                      <option value="0" <?=($register_status=="0")?"selected":""?>>ສະແດງສະເພາະທີ່ບໍ່ທັນລົງທະບຽນ</option>
                      <option value="1" <?=($register_status=="1")?"selected":""?>>ສະແດງທັງໝົດ</option>
                    </select>
                  </div>
                  <div style="padding-left:5px;padding-right:5px;" class="col-lg-3 col-sm-4 mb-2">
                    <input value="<?=$search_text?>" name="txt_search" style="padding: .375rem 2.25rem .375rem .75rem !important;line-height:1.5 !important; height:38px !important;" id="search" type="text" class="form-control notosans" placeholder="Search..." />
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
                  <?php
                    $index = 0;
                    foreach($student_data as $student){
                      $index++;
                      ?>
                      <tr>
                        <td class="notosans f12"><?=$index?></td>
                        <td class="notosans f12"><?=$student["student_code"]?></td>
                        <td class="notosans f12">
                          <?=$student["gender"]." ".$student["name_la"]." ".$student["surname_la"]?>
                        </td>
                        <td class="notosans f12"><?=$student["classroom_des"]?></td>
                        <td class="notosans f12">
                          <?php
                            if($student["register_status"]==0){
                              ?>
                              <button onclick="change_register_status(
                                '<?=$student['register_id']?>',
                                '<?=$student['gender'].' '.$student['name_la'].' '.$student['surname_la']?>',
                                1,
                                '<?=$student['student_code']?>',
                               )" type="button" class="btn btn-success btn-icon-text btn-rounded none-select none-outline">
                                ລົງທະບຽນ
                              </button>
                              <?php
                            }else{
                              ?>
                              <button onclick="change_register_status(
                                '<?=$student['register_id']?>',
                                '<?=$student['gender'].' '.$student['name_la'].' '.$student['surname_la']?>',
                                0,
                                '<?=$student['student_code']?>',
                                )" type="button" class="btn btn-danger btn-icon-text btn-rounded none-select none-outline">
                              &nbsp;&nbsp;ຍົກເລີກ&nbsp;&nbsp;
                              </button>
                              <?php
                            }
                          ?>
                        </td>
                      </tr>
                      <?php
                    }
                  ?>
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
  include_once("modals/schoolyear_modal.php");
?>
<script>
  var _username = '<?=$user_data["username"]?>';
  var course_id = <?= $course_id ?>;
  var selected_course_id = <?= $course_id ?>;
  var selected_year = <?= $selected_year ?>;
  var classroom_id = <?=$classroom_id?>;
  var year_no = 0;
  var cb_year = document.getElementById('year_no');
  var add_classroom = document.getElementById('addclass');
  var cb_class = document.getElementById('cb_class');
  var shcoolyear_modal = document.getElementById('schoolyear');
  const btn_schoolyear = document.getElementById('btn_shcoolyear');
  // var el_start_year = document.getElementById('start_year');
  // var el_end_year = document.getElementById('end_year');
  shcoolyear_modal.addEventListener('show.bs.modal',function(event){
    btn_schoolyear.name = "schoolyear";
  });
  function openSchoolyearModal(isNewStudent){
    $(shcoolyear_modal).modal("show");
  }
  function submit_schoolyear(e){
    let today = new date();
    let schoolyear_param = '';
    if(el_start_year.value!=today.getFullYear()){
      schoolyear_param = '&schoolyear='+el_start_year.value+'-'+el_end_year.value;
    }
    location.href = 'template?page=register'+schoolyear_param;
  }
</script>
<script src="assets/script/register.js"></script>