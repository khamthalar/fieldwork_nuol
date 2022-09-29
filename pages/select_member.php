<?php
require_once "controller/class_member_controller.php";
$class_id = 0;
$filter = "";
if (isset($_GET['class_des'])) {
  $class_des_param = "&class_des=" . $_GET['class_des'];
  $class_des = $_GET['class_des'];
}
if (isset($_GET['class_id'])) {
  $class_id_param = "&class_id=" . $_GET['class_id'];
  $class_id = $_GET['class_id'];
}
?>
<link rel="stylesheet" href="assets/css/classroom-style.css">
<link rel="stylesheet" href="assets/css/class-member-style.css">
<script src="assets/js/jquery-1.9.1.min.js"></script>
<div class="header-page">
  <div class="page-title">
    <h5 class="notosans"><a href="template?page=home" class="home-link">ໜ້າຫຼັກ</a> <i class="fas fa-chevron-right"></i> <a href="template?page=classroom" class="home-link">ຫ້ອງເສັງ</a>
    <i class="fas fa-chevron-right"></i> <a href="template?page=class_member<?=@$class_id_param.@$class_des_param?>" class="home-link">ນັກສອບເສັງ</a>
    <i class="fas fa-chevron-right"></i> ເລືອກນັກສອບເສັງ</h5>
  </div>
</div>
<div class="page-wrapper">
  <div class="content-wrapper">
    <?php
      $user_id = @$user_data['id'];
    //   if(isset($_POST['update_class'])){
    //     update_class($_POST['id'],$_POST['class_des'],$user_id);
    //   }
      // $data = load_data()->fetchAll(PDO::FETCH_ASSOC);
      $menbers = load_user($class_id,$filter)->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="cus-card card">
          <div class="card-body">
            <h4 class="card-title notosans">ເລືອກນັກສອບເສັງ</h4>
            <div class="top-content">
              <div  class="top-act">
                <select class="form-select notosans" aria-label="Default select">
                    <option selected>---ສະແດງທັງໝົດ---</option>
                    <?php
                        $departments = load_department()->fetchAll(PDO::FETCH_ASSOC);
                        foreach($departments as $department){
                            echo " <option value='".$department['dep_id']."'>".$department['dep_name']."</option>";
                        }
                    ?>
                </select>
                <input class="txt-search notosans f12" id="txt-search" type="text" name="txt_search" placeholder="Search">
                <button type="button" class="btn-search btn btn-secondary notosans">ຄົ້ນຫາ</button>
            </div>

            <div class="paginate">
                <?php           
                $current_page = 1;
                $row_num = load_user($class_id,$filter)->rowCount();
                include_once 'paginate.php';
                ?>
            </div>
            </div>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th class="col-id" width="60">
                        <div class="chb-check-all center">
                        &nbsp;<input onClick="toggle(this)" class="form-check-input" type="checkbox" value="" id="check-all">
                        </div>
                    </th>
                    <th class="notosans">ນັກສອບເສັງ</th>
                    <th class="notosans">ພະແນກ</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $limit_start = ($current_page - 1) * $limit_row;
                  for ($i = $limit_start; $i < ($limit_start + $limit_row); $i++) {
                    if ($i == $row_num) {
                      break;
                    }
                  ?>
                    <tr>
                        <td class="col-id center">
                            &nbsp;<input name="cb_member[]" class="form-check-input cb_member" type="checkbox" value="<?= $menbers[$i]['id'] ?>" id="cb<?= $menbers[$i]['id'] ?>">
                        </td>
                        <td class="notosans">
                            <label class="form-check-label lb-fullname" for="cb<?= $menbers[$i]['id'] ?>">
                                <?=$menbers[$i]['fullname']?>
                            </label>
                        </td>
                        <td class="notosans">
                            <label class="form-check-label lb-department" for="cb<?= $menbers[$i]['id'] ?>">
                                <?=$menbers[$i]['dep_name']?>
                            </label>
                        </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>

            </div>
            <div class="submit-btn">
                <button onclick="save()" type="submit" name="save_ans_choice" class="btn btn-primary btn-icon-text notosans none-outline none-select">
                        ບັນທຶກ
                  <i class="fas fa-save btn-icon-append"></i>                                                                             
                </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
    function toggle(source){
        var chb = document.getElementsByName('cb_member[]');
        for(let i=0; i < chb.length; i++){
            chb[i].checked = source.checked;
        }
    }
    function save(){
        var member = document.getElementsByName('cb_member[]');
        var member_checked = [];
        member.forEach(_member=>{
            if(_member.checked){
                member_checked.push(_member.value);
            }
        });
        if(member_checked.length == 0){
            Swal.fire({icon:'info',html:'<span class=notosans>ກະລຸນາເລືອກນັກສອບເສັງ!</span>'});
        }else{
            var param = {
                class_id:'<?=$class_id?>',
                class_des:'<?=$class_des?>',
                selected_member:member_checked
            };
            var http = new XMLHttpRequest();
            http.open("POST", 'controller/class_member_controller.php', true);
            http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            http.onreadystatechange = function() {
                if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                // console.log(this.responseText);
                    eval(this.responseText);
                }
            }
            var _param = JSON.stringify(param);
            http.send("submit_member=" + _param);
            }
    }
</script>