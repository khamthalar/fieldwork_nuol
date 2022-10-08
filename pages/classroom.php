<?php
require_once "controller/classroom_controller.php";
?>
<link rel="stylesheet" href="assets/css/classroom-style.css">
<script src="assets/js/jquery-1.9.1.min.js"></script>
<div class="header-page">
  <div class="page-title">
    <h5 class="notosans"><a href="template?page=home" class="home-link">ໜ້າຫຼັກ</a> <i class="fas fa-chevron-right"></i> ຫ້ອງຮຽນ</h5>
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
    ?>
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="cus-card card">
          <div class="card-body">
            <h4 class="card-title notosans">ຂໍ້ມູນຫ້ອງຮຽນ</h4>
            <div class="top-contents">
              <div style="padding-bottom: 3px;">
                <button type="button" class="btn-newclass btn btn-primary btn-icon-text none-select none-outline notosans" data-toggle="modal" data-target="#addclass" data-backdrop="static">
                  <i class="ti-plus btn-icon-prepend"></i> ເພີ່ມໃໝ່
                </button>
              </div>
              <div class="filter row">
                <div class="col-lg-5 col-sm-8 mb-2">
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
                <div class="col-lg-3 col-sm-4 mb-2">
                  <select class="form-select notosans" aria-label="Default select" name="year_no" id="year_no">
                  </select>
                </div>
                <div class="col-lg-2">
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
                    <th class="col-id notosans" width="60">ລະຫັດ</th>
                    <th class="notosans">ຫ້ອງເສັງ</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // $limit_start = ($current_page - 1) * $limit_row;
                  // for ($i = $limit_start; $i < ($limit_start + 10); $i++) {
                  //   if ($i == $row_num) {
                  //     break;
                  //   }
                  ?>
                    <tr>
                      <td class="col-id"></td>
                      <td class="notosans"></td>
                      <td>
                        <button type="button" class="btn btn-warning btn-icon-text btn-rounded none-select none-outline" >
                          <i class="fas fa-pencil-alt"></i>
                        </button>
                        <button type="button" class="btn btn-primary btn-icon-text btn-rounded none-select none-outline">
                          <i class="fas fa-user-friends btn-icon-prepend"></i>
                        </button>
                          <button type="button" class="btn btn-secondary btn-icon-text btn-rounded none-select none-outline" id="log">
                            <i class="ti-book btn-icon-prepend"></i>
                          </button>
                        <button type="button" class="btn btn-danger btn-icon-text btn-rounded none-select none-outline" >
                          <i class="fas fa-trash-alt"></i>
                        </button>                       
                      </td>
                    </tr>
                  <?php 
                    // }
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
?>
<script src="assets/js/custom_js/classroom.js"></script>
<script>
  var course_id = <?=$course_id?>;
  var selected_year = <?=$selected_year?>;
  var cb_year = document.getElementById('year_no');
  // var edit_class = document.getElementById('editclass')
  // edit_class.addEventListener('show.bs.modal', function(event) {
  //   var class_data = $(event.relatedTarget);
  //   var class_id = class_data.data('id');
  //   var class_des = class_data.data('class_des');
  //   var modal = $(this);
  //   modal.find('.modal-body #class_id').val(class_id);
  //   modal.find('.modal-body #class_des').val(class_des);
  // });
  // var confirm_dialog = document.getElementById('confirm_dialog');
  // confirm_dialog.addEventListener('show.bs.modal',function(event){
  //   var class_data = $(event.relatedTarget);
  //   var class_id = class_data.data('id');
  //   var modal = $(this);
  //   modal.find('.modal-body #id').val(class_id);
  //   document.getElementById('title').innerHTML = "ທ່ານຕ້ອງການລຶບຂໍ້ມູນແມ່ນບໍ່";
  //   document.getElementById('btn_yes').setAttribute("name","del_class");
  // });
</script>