<?php
require_once "controller/employee_controller.php";

?>
<link rel="stylesheet" href="assets/css/classroom-style.css">
<script src="assets/js/jquery-1.9.1.min.js"></script>
<div class="header-page">
  <div class="page-title">
    <h5 class="phetsarath"><a href="template?page=home" class="home-link">ໜ້າຫຼັກ</a> <i class="fas fa-chevron-right"></i> ຂໍ້ມູນພະນັກງານ</h5>
  </div>
</div>
<div class="page-wrapper">
  <div class="content-wrapper">
    <?php
      $user_id = @$user_data['id'];
      if(isset($_POST['del_emp'])){
        del_emp($_POST['id']);
      }
      $dep_id = 0;
      if(isset($_GET['dep_id'])){
        $dep_id = $_GET['dep_id'];
      }
      $data = load_employee($dep_id)->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="cus-card card">
          <div class="card-body">
            <h4 class="card-title phetsarath">ຂໍ້ມູນພະນັກງານ</h4>
            <div class="top-content">
              <div class="top-act">
                <button onclick="window.location.href='template?page=employee&sub_page=new_employee<?=($dep_id==0)?'':'&dep_id='.$dep_id?>'" type="button" class="btn-newclass btn btn-primary btn-icon-text none-select none-outline phetsarath">
                  <i class="ti-plus btn-icon-prepend"></i> ເພີ່ມໃໝ່
                </button>
                <select onchange="cb_depart_changed(this.value)" class="form-select phetsarath" aria-label="Default select">
                    <option value="0" <?=($dep_id==0)?"selected":""?> >---ສະແດງທັງໝົດ---</option>
                    <?php
                      $departments = load_department()->fetchAll(PDO::FETCH_ASSOC);
                      foreach($departments as $department){
                        ?>
                          <option value='<?=$department['dep_id']?>' <?=($dep_id==$department['dep_id'])?"selected":""?> ><?=$department['dep_name']?></option>
                        <?php
                      }
                    ?>
                </select>
              </div>

              <div class="paginate">
                <?php
                $current_page = 1;
                $row_num = load_employee($dep_id)->rowCount();
                include_once 'paginate.php';
                ?>

              </div>
            </div>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th class="col-id phetsarath" width="30"></th>
                    <th class="phetsarath">ຊື່ພະນັກງານ</th>
                    <th class="phetsarath" width="50">ອາຍຸ (ປີ)</th>
                    <th class="phetsarath">ເບິໂທ</th>
                    <th class="phetsarath">ພະແນກ</th>
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
                        <td class="col-id" style="font-size: larger;">
                            <?php
                                if($data[$i]['gender']=="male"){
                                    echo('<i class="fas fa-solid fa-mars" style="color:dodgerblue"></i>');
                                }elseif($data[$i]['gender']=="female"){
                                    echo('<i class="fas fa-solid fa-venus" style="color:mediumvioletred"></i>');
                                }else{
                                    echo('<i class="fas fa-solid fa-venus-mars"></i>');
                                }
                            ?>
                          <!-- <?=$data[$i]['id']?> -->
                        </td>
                        <td class="phetsarath">
                            <label style="width: 20px; font-size: larger;">
                                <?=($data[$i]['user_type']==2)?'<i class="fas fa-solid fa-graduation-cap"></i>':''?>
                            </label>
                            <?=$data[$i]['fullname']?>
                        </td>
                        <td style="text-align: center;"><?=$data[$i]['age']?></td>
                        <td><?=$data[$i]['tel']?></td>
                        <td class="phetsarath"><?=$data[$i]['dep_name']?></td>
                        <td>
                        <button onclick="window.location.href='template?page=employee&sub_page=update_employee<?=($dep_id==0)?'':'&dep_id='.$dep_id?>&emp_id=<?=$data[$i]['id']?>'" type="button" class="btn btn-warning btn-icon-text btn-rounded none-select none-outline">
                          <i class="fas fa-pencil-alt"></i>
                        </button>
                        <!-- <button type="button" class="btn btn-primary btn-icon-text btn-rounded none-select none-outline">

                          <i class="fas fa-eye"></i>

                        </button> -->
                        <button type="button" class="btn btn-danger btn-icon-text btn-rounded none-select none-outline" data-id="<?=$data[$i]['id']?>" data-bs-toggle="modal" data-bs-target="#confirm_dialog" data-bs-backdrop="static">
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
?>
<script>
  function cb_depart_changed(value){
    if(value == 0){
      window.location.href = "template?page=employee";
    }else{
      window.location.href = "template?page=employee&dep_id="+value;
    }
  }
  var confirm_dialog = document.getElementById('confirm_dialog');
  confirm_dialog.addEventListener('show.bs.modal',function(event){
    var dep_data = $(event.relatedTarget);
    var dep_id = dep_data.data('id');
    var modal = $(this);
    modal.find('.modal-body #id').val(dep_id);
    document.getElementById('title').innerHTML = "ທ່ານຕ້ອງການລຶບຂໍ້ມູນແມ່ນບໍ່";
    document.getElementById('btn_yes').setAttribute("name","del_emp");
  });
</script>