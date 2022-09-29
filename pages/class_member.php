<?php
require_once "controller/class_member_controller.php";
?>
<link rel="stylesheet" href="assets/css/classroom-style.css">
<link rel="stylesheet" href="assets/css/class-member-style.css">
<script src="assets/js/jquery-1.9.1.min.js"></script>
<div class="header-page">
  <div class="page-title">
    <h5 class="notosans"><a href="template?page=home" class="home-link">ໜ້າຫຼັກ</a> <i class="fas fa-chevron-right"></i> <a href="template?page=classroom" class="home-link">ຫ້ອງເສັງ</a>
    <i class="fas fa-chevron-right"></i> ນັກສອບເສັງ</h5>
  </div>
</div>
<div class="page-wrapper">
  <div class="content-wrapper">
    <?php
      $user_id = @$user_data['id'];
      if(isset($_POST['new_class'])){
        add_class($_POST['class_des'],$user_id);
      }
      if(isset($_GET['class_id'])){
        $class_id_param = "&class_id=".$_GET['class_id'];
      }else{
          echo "<script>window.location.href = 'template?page=classroom'</script>";
      }
      if(isset($_GET['class_des'])){
        $class_des_param = "&class_des=".$_GET['class_des'];
      }
      $filter = "";
      if(isset($_GET['filter'])){
        $filter = " AND u.fullname LIKE '%".$_GET['filter']."%'";
      }
      if(isset($_POST['del_class'])){
        del_member($_POST['id']);
      }
      $data = load_member($_GET['class_id'],$filter)->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="cus-card card">
          <div class="card-body">
            <h4 class="card-title notosans">ຂໍ້ມູນນັກສອບເສັງ ຫ້ອງ (<?=isset($_GET['class_des'])?$_GET['class_des']:''?>)</h4>
            <div class="top-content">
              <div  class="top-act">
                <button onclick="window.location.href='template?page=classroom&sub_page=select_member<?=@$class_id_param.@$class_des_param?>'" type="button" class="btn-newclass btn btn-primary btn-icon-text none-select none-outline notosans">
                    <i class="ti-import"></i>
                </button>
                <input class="txt-search notosans f12" id="txt-search" type="text" name="txt_search" placeholder="Search" value="<?=@$_GET['filter']?>">
                <button onclick="search()" type="button" class="btn-search btn btn-secondary notosans">ຄົ້ນຫາ</button>
            </div>

            <div class="paginate">
                <?php           
                $current_page = 1;
                $row_num = load_member($_GET['class_id'],$filter)->rowCount();
                include_once 'paginate.php';
                ?>
            </div>
            </div>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th class="col-id notosans" width="60">ລະຫັດ</th>
                    <th class="notosans">ນັກສອບເສັງ</th>
                    <th class="notosans">ພະແນກ</th>
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
                      <td class="col-id"><?=$data[$i]['id']?></td>
                      <td class="notosans"><?=$data[$i]['fullname']?></td>
                      <td class="notosans"><?=$data[$i]['dep_name']?></td>
                      <td>
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
  function search(){
    var txt_search = document.getElementById('txt-search').value;
    var url = '';
    if(txt_search==""){
      url = 'template?page=classroom&sub_page=class_member'+'<?=$class_id_param?>'+'<?=$class_des_param?>';
    }else{
      url = 'template?page=classroom&sub_page=class_member'+'<?=$class_id_param?>'+'<?=$class_des_param?>'+'&filter='+encode(txt_search);
    }
    window.location.href = url;
  }
</script>