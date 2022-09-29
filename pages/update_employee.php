<?php
require_once "controller/employee_controller.php";
$dep_id = isset($_GET['dep_id'])?$_GET['dep_id']:0;
$dep_id_param = isset($_GET['dep_id'])?"&dep_id=".$_GET['dep_id']:"";
$emp_id = 0;
if(isset($_GET['emp_id'])){
    $emp_id = $_GET['emp_id'];
}else{
    ?>
        <script>window.location.href = 'template?page=employee<?=$dep_id_param?>?>'</script>
    <?php
}
?>
<link rel="stylesheet" href="assets/css/classroom-style.css">
<link rel="stylesheet" href="assets/css/new_employee_style.css">
<script src="assets/js/jquery-1.9.1.min.js"></script>
<div class="header-page">
  <div class="page-title">
    <h5 class="notosans">
        <a href="template?page=home" class="home-link">ໜ້າຫຼັກ</a> 
        <i class="fas fa-chevron-right"></i> 
        <a href="template?page=employee<?=$dep_id_param?>" class="home-link">ຂໍ້ມູນພະນັກງານ</a> 
        <i class="fas fa-chevron-right"></i> 
        ແກ້ໄຂຂໍ້ມູນພະນັກງານ</h5>
  </div>
</div>
<div class="page-wrapper">
  <div class="content-wrapper">
    <?php
      $user_id = @$user_data['id'];
      $emp_data = get_emp_by_id($emp_id)->fetchAll(PDO::FETCH_ASSOC)[0];
      // print_r($emp_data);
    ?>
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                  <h4 class="card-title notosans">ແກ້ໄຂຂໍ້ມູນພະນັກງານ</h4>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group row">
                          <label class="col-form-label notosans f12">ຊື່ ແລະ ນາມສະກຸນ*</label>
                          <div class="col-sm-12">
                            <input id="fullname" type="text" class="inp form-control notosans f12" value="<?=$emp_data['fullname']?>" />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label notosans f12">ເພດ</label>
                          <div class="col-sm-9">
                            <select id="gender" class="inp form-control notosans f12">
                              <option value="male" <?=($emp_data['gender']=='male')?"selected":''?> >ຊາຍ</option>
                              <option value="female" <?=($emp_data['gender']=='female')?"selected":''?>>ຍິງ</option>
                              <option value="other" <?=($emp_data['gender']=='other')?"selected":''?> >ອື່ນໆ</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label notosans f12">ວັນເດືອນປີເກີດ</label>
                            <div class="col-sm-9">
                                <label class="lb">
                                    <input type="date" id="date_of_birth" name="date_of_birth" <?=($emp_data['date_of_birth']=="")?"":"value='".$emp_data['date_of_birth']."'"?> onchange="date_changed(this.value)">
                                    <button class="btn-calendar" id="calendar_text">
                                        <div id="date-of-birth-lb" class="notosans f12"><?=($emp_data['date_of_birth']=="")?"ວັນເດືອນປີເກີດ":date("d/m/Y", strtotime($emp_data['date_of_birth']))?></div>
                                        <div class="calender-ico"><img src="assets/svg/calendar.svg" width="20"></div>
                                    </button>
                                </label>
                            </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label notosans f12">ພະແນກ</label>
                            <div class="col-sm-9">
                                <select id="dep" class="inp form-control notosans f12">
                                    <?php 
                                        $departments = load_department()->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($departments as $depart){
                                          ?>
                                          <option value='<?=$depart['dep_id']?>' <?=($emp_data['dep_id']==$depart['dep_id'])?'selected':''?> ><?=$depart['dep_name']?></option>
                                          <?php
                                            // echo "<option value='".$depart['dep_id']."'>".$depart['dep_name']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label notosans f12">ເບີໂທ</label>
                            <div class="col-sm-9">
                                <input id="tel" type="text" class="inp form-control inp notosans f12" value="<?=$emp_data['tel']?>" />
                            </div>
                            </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 notosans f12" for="txt-address">ທີ່ຢູ່</label>
                            <div class="col-sm-9">
                                <textarea id="address" class="inp form-control notosans f12" id="txt-address" rows="5"><?=$emp_data['address']?></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 notosans f12"></label>
                                <div class="col-sm-5">
                                <div class="form-check">
                                <label class="form-check-label notosans f12">
                                    <input type="radio" class="form-check-input" name="user_type" id="student" value="2" <?=($emp_data['user_type']==2)?"checked":""?> >
                                    ນັກສອບເສັງ
                                </label>
                                </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-check">
                                    <label class="form-check-label notosans f12">
                                        <input type="radio" class="form-check-input" name="user_type" id="admin" value="1" <?=($emp_data['user_type']==1)?"checked":""?>>
                                        ອາຈານ
                                    </label>
                                    </div>
                                </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label notosans f12">ຊື່ເຂົ້າໃຊ້ລະບົບ*</label>
                          <div class="col-sm-9">
                            <input id="username" type="text" class="form-control notosans f12" value="<?=$emp_data['username']?>"/>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label notosans f12">ລະຫັດຜ່ານ*</label>
                          <div class="col-sm-9">
                            <input value="edlquiz" id="password" type="password" class="form-control" />
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label notosans f12">ຢືນຢັນລະຫັດຜ່ານ*</label>
                          <div class="col-sm-9">
                            <input value="edlquiz"  id="confirm_password" type="password" class="form-control" />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row submit">
                        <div class="col-md-12 center">
                            <button onclick="save()" type="submit" name="save_ans_choice" class="cus-btn btn btn-primary btn-icon-text notosans none-outline none-select">
                            ບັນທຶກ
                            <i class="fas fa-save btn-icon-append"></i>                                                                             
                            </button>
                            <button onclick="window.location.href='template?page=employee<?=$dep_id_param?>'" type="submit" name="save_ans_choice" class="cus-btn btn btn-danger btn-icon-text notosans none-outline none-select">
                            ຍົກເລີກ
                            <i class="fas fa-solid fa-trash btn-icon-append"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function save(){
        var _fullname = $('#fullname').val();
        var _gender = $('#gender').val();
        var _dep_id = $('#dep').val();
        var _username = $('#username').val();
        var _password = $('#password').val();
        var confirm_password = $('#confirm_password').val();
        var _address = $('#address').val();
        var _user_type = document.querySelector('input[name="user_type"]:checked').value;
        var _date_of_birth = $('#date_of_birth').val();
        var _tel = $("#tel").val();
        if(_fullname==""){
            Swal.fire({icon:'info',html:'<span class=notosans>ກະລຸນາປ້ອນ ຊື່ ແລະ ນາມສະກຸນ !</span>'});
        }else if(_username==""){
            Swal.fire({icon:'info',html:'<span class=notosans>ກະລຸນາປ້ອນ ຊື່ເຂົ້າໃຊ້ລະບົບ !</span>'});
        }else{
            if(_password != confirm_password){
                Swal.fire({icon:'info',html:'<span class=notosans>ລະຫັດຜ່ານບໍ່ກົງກັນ !</span>'});
            }else{
                var param = {
                    emp_id:<?=$emp_id?>,
                    fullname:_fullname,
                    gender:_gender,
                    dep_id:_dep_id,
                    username:_username,
                    password:_password,
                    address:_address,
                    tel:_tel,
                    user_type:_user_type,
                    date_of_birth:_date_of_birth,
                    dep_id_param:'<?=$dep_id_param?>'

                };
                var http = new XMLHttpRequest();
                http.open("POST", 'controller/employee_controller.php', true);
                http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                http.onreadystatechange = function() {
                    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                        eval(this.responseText);
                    }
                }
                var _param = encode(JSON.stringify(param));
                http.send("update_employee=" + _param);
            }
        }
    }
    function date_changed(data){
        var _date = new Date(data);
        document.getElementById("date-of-birth-lb").innerHTML=_date.getDate().toString().padStart(2, "0")+"/"+(_date.getMonth() + 1).toString().padStart(2, "0")+"/"+_date.getFullYear();
    }
</script>