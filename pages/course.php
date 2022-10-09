<?php
    require_once "controller/employee_controller.php";
    require_once "controller/course_controller.php";
?>
<link rel="stylesheet" href="assets/css/classroom-style.css">
<script src="assets/js/jquery-1.9.1.min.js"></script>
<div class="header-page">
  <div class="page-title">
    <h5 class="notosans"><a href="template?page=home" class="home-link">ໜ້າຫຼັກ</a> <i class="fas fa-chevron-right"></i> ຂໍ້ມູນຫຼັກສູດ</h5>
  </div>
</div>
<div class="page-wrapper">
  <div class="content-wrapper">
    <?php
      $show_all=isset($_GET['show_all'])?true:false;
      $user_id = @$user_data['user_id'];
      if(isset($_POST['del_course'])){
        change_status($_POST['id'],0);
      }
      if(isset($_POST['restore_course'])){
        change_status($_POST['id'],1);
      }
      if(isset($_POST['add_course'])){
        add_course($_POST['course_des'],$_POST['class_pattern'],$_POST['scheme']);
      }
      if(isset($_POST['update_pwd'])){
        $password = $_POST['password'];
        if($password!="edlquiz"){
          update_pwd($_POST['u_id'],$password);
        }
      }
      $filter = $show_all?'':' AND c.course_status = 1';
      $course_data = load_course($filter);
      $data = $course_data->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="cus-card card">
          <div class="card-body">
            <h4 class="card-title notosans">ຂໍ້ມູນຫຼັກສູດ</h4>
            <div class="top-content">
              <div class="top-act">
                <button type="button" class="btn-newclass btn btn-primary btn-icon-text none-select none-outline notosans"
                data-bs-toggle="modal" data-bs-target="#add_course" data-bs-backdrop="static">
                  <i class="ti-plus btn-icon-prepend"></i> ເພີ່ມໃໝ່
                </button>
                <select onChange="filter_selected(this.value)" class="form-select notosans" aria-label="Default select" id="cb_filter">
                  <option value="active">ສະແດງສະເພາະທີ່ໃຊ້ງານ</option>
                  <option value="all" <?=$show_all?'selected':''?>>ສະແດງທັງໝົດ</option>
                </select>
              </div>

              <div class="paginate">
                <?php
                $current_page = 1;
                $row_num = $course_data->rowCount();
                include_once 'paginate.php';
                ?>

              </div>
            </div>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th class="col-id notosans" width="30">ລ/ດ</th>
                    <th class="notosans">ຫຼັກສູດ</th>
                    <th class="notosans center">ໄລຍະເວລາຮຽນ</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $limit_start = ($current_page - 1) * $limit_row;
                  for ($i = $limit_start; $i < ($limit_start + 10); $i++) {
                    if ($i == $row_num) {
                      break;
                    }
                  ?>
                    <tr>
                        <td class="col-id <?=$data[$i]['course_status']?'':'disable-text'?>"><?=$i+1?></td>
                        <td class="notosans <?=$data[$i]['course_status']?'':'disable-text'?>"><?=$data[$i]['course_des']?>-<?=$data[$i]['scheme_des']?></td>
                        <td class="notosans center <?=$data[$i]['course_status']?'':'disable-text'?>"><?=$data[$i]['duration_year']?> ປີ</td>
                        <td>
                          <button type="button" class="btn btn-warning btn-icon-text btn-rounded none-select none-outline" <?=$data[$i]['course_status']?'':'disabled'?> >
                            <i class="fas fa-pencil-alt"></i>
                          </button>
                          <button type="button" class="btn <?=$data[$i]['course_status']?'btn-danger':'btn-success'?> btn-icon-text btn-rounded none-select none-outline" 
                          data-id="<?=$data[$i]['course_id']?>" 
                          data-act="<?=$data[$i]['course_status']?'del':'restore'?>"
                          data-bs-toggle="modal" data-bs-target="#confirm_dialog" data-bs-backdrop="static">
                          <?=$data[$i]['course_status']?'<i class="fas fa-trash-alt"></i>':'<i class="ti-reload"></i>'?> 
                          </button>
                        </td>
                    </tr>
                  <?php } ?>
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
  include_once("modals/add_course_modal.php");
?>
<script>
  var confirm_dialog = document.getElementById('confirm_dialog');
  confirm_dialog.addEventListener('show.bs.modal',function(event){
    var course_data = $(event.relatedTarget);
    var course_id = course_data.data('id');
    var act = course_data.data('act');
    var modal = $(this);
    modal.find('.modal-body #id').val(course_id);
    if(act=="del"){
      document.getElementById('title').innerHTML = "ທ່ານຕ້ອງການລຶບຂໍ້ມູນແມ່ນບໍ່";
      document.getElementById('btn_yes').setAttribute("name","del_course");
    }else{
      document.getElementById('title').innerHTML = "ທ່ານຕ້ອງການກູ້ຄືນຂໍ້ມູນແມ່ນບໍ່";
      document.getElementById('btn_yes').setAttribute("name","restore_course");
    }
  });
  function filter_selected(value){
    if(value=="all"){
      window.location.href="template?page=course&show_all=true";
    }else{
      window.location.href="template?page=course";
    }
  }
</script>