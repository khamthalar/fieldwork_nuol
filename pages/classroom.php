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
      if(isset($_POST['new_class'])){
        add_new_classroom($_POST['course_id'],$_POST['full_classroom_des'],$_POST['year_num']);
      }
      if(isset($_POST['change_status'])){
        change_classroom_status($_POST['classroom_id'],$_POST['classroom_status']);
      }
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
            <h4 class="card-title notosans">ຂໍ້ມູນຫ້ອງຮຽນ</h4>
            <div class="top-contents">
              <div style="padding-bottom: 3px;">
                <button type="button" class="btn-newclass btn btn-primary btn-icon-text none-select none-outline notosans" 
                data-bs-toggle="modal" data-bs-target="#addclass" data-bs-backdrop="static">
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
                    <th class="col-id notosans center" width="60">ລ/ດ</th>
                    <th class="notosans">ຫ້ອງຮຽນ</th>
                    <th class="notosans">ສະຖານະ</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $index = 0;
                    foreach($data as $classroom){
                      $index++;
                  ?>
                    <tr>
                      <td class="col-id center"><?=$index?></td>
                      <td class="notosans"><?=$classroom['classroom_des']?></td>
                      <td>
                        <div class="class_status"
                        data-bs-toggle="modal" 
                        data-classroom_id="<?=$classroom['classroom_id']?>" 
                        data-classroom_status="<?=$classroom['classroom_status']?>"
                        data-classroom_des="<?=$classroom['classroom_des']?>" 
                        data-bs-target="#change_status" data-bs-backdrop="static">
                          <?=($classroom['classroom_status']==1)?'<span class="btn btn-success btn-rounded notosans">ເປີດໃຊ້ງານ</span>':'<span class="btn btn-secondary btn-rounded notosans">ປິດໃຊ້ງານ</span>'?>
                        </div>
                      </td>
                      <td>
                        <button type="button" class="btn btn-primary btn-icon-text btn-rounded none-select none-outline">
                          <i class="fas fa-user-friends"></i>
                        </button>        
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
  include_once("modals/add_classroom_modal.php");
  include_once("modals/change_classroom_status_modal.php");
?>
<script>
  var course_id = <?=$course_id?>;
  var selected_course_id = <?=$course_id?>;
  var selected_year = <?=$selected_year?>;
  var year_no = 0;
  var cb_year = document.getElementById('year_no');
  var add_classroom = document.getElementById('addclass');
  var change_status_modal = document.getElementById('change_status');
  add_classroom.addEventListener('show.bs.modal', function(event) {
    var data = $(event.relatedTarget);
    var modal = $(this);
    document.getElementById('course_id').value = selected_course_id;
    var full_classroom_des = '<?=get_class_des($course_id)?>';
    document.getElementById('full_classroom_des').value = full_classroom_des;
    var course = document.getElementById("cb_course");
    var course_des = '';
    var selected_year_no = 0;
    for(let opt of course){
      var id = opt.value.split(",")[0];
      var no = opt.value.split(",")[1];
      if(id==selected_course_id){
        course_des = opt.innerHTML;
        selected_year_no = no;
      }
    }
    document.getElementById('year_num').value = selected_year_no;
    var detail = `ສາຂາວິຊາ: `+course_des+`<br>`;
    detail +=`ຫ້ອງຮຽນ: `;
    for(let i=1;i<=selected_year_no;i++){
      var classroom_des = full_classroom_des.replace('[year_no]',i);
      detail +=`<br>&emsp;&emsp;`+classroom_des
    }
    document.getElementById('des').innerHTML = detail;
  });
  
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
<script src="assets/script/classroom.js"></script>