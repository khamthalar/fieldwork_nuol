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
      $user_id = @$user_data['user_id'];
      if(isset($_POST['del_emp'])){
        del_emp($_POST['id']);
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
      $course_data = load_course();
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
                    <th class="notosans">ໄລຍະເວລາຮຽນ</th>
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
                        <td class="col-id"><?=$i+1?></td>
                        <td class="notosans"><?=$data[$i]['course_des']?>-<?=$data[$i]['scheme_des']?></td>
                        <td class="notosans"><?=$data[$i]['duration_year']?> ປີ</td>
                        <td>
                          <button type="button" class="btn btn-warning btn-icon-text btn-rounded none-select none-outline">
                            <i class="fas fa-pencil-alt"></i>
                          </button>
                          <button type="button" class="btn btn-danger btn-icon-text btn-rounded none-select none-outline" data-id="<?=$data[$i]['user_id']?>" data-bs-toggle="modal" data-bs-target="#confirm_dialog" data-bs-backdrop="static">
                            <i class="fas fa-trash-alt"></i>
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