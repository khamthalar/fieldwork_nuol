<?php
require_once "controller/employee_controller.php";
$emp_id = 0;
if (isset($_GET['emp_id'])) {
  $emp_id = $_GET['emp_id'];
} else {
?>
  <script>
    window.location.href = 'template?page=employee'
  </script>
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
      <a href="template?page=employee" class="home-link">ຂໍ້ມູນພະນັກງານ</a>
      <i class="fas fa-chevron-right"></i>
      ແກ້ໄຂຂໍ້ມູນພະນັກງານ
    </h5>
  </div>
</div>
<div class="page-wrapper">
  <div class="content-wrapper">
    <?php
    $user_id = @$user_data['id'];
    $emp_data = get_emp_by_id($emp_id)->fetchAll(PDO::FETCH_ASSOC)[0];
    $user_group = get_user_group()->fetchAll(PDO::FETCH_ASSOC);
    // print_r($emp_data);
    ?>
    <div class="row">
      <div class="col-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title notosans">ແກ້ໄຂຂໍ້ມູນພະນັກງານ</h4>
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group row">
                          <label class="col-form-label notosans f12">ຊື່ ແລະ ນາມສະກຸນ*</label>
                          <div class="col-sm-12">
                            <input id="fullname" type="text" value="<?= $emp_data['fullname'] ?>" class="inp form-control notosans f12" />
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
                              <option value="1" <?= ($emp_data['gender'] == '1') ? "selected" : '' ?>>ຊາຍ</option>
                              <option value="2" <?= ($emp_data['gender'] == '2') ? "selected" : '' ?>>ຍິງ</option>
                              <option value="3" <?= ($emp_data['gender'] == '3') ? "selected" : '' ?>>ອື່ນໆ</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label notosans f12">ເບີໂທ</label>
                          <div class="col-sm-9">
                            <input id="tel" type="text" class="inp form-control inp notosans f12" value="<?=$emp_data['phone_number']?>"/>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label notosans f12">ກຸ່ມຜູ້ໃຊ້</label>
                          <div class="col-sm-9">
                            <select id="user_group" class="inp form-control notosans f12">
                              <?php
                              foreach ($user_group as $item) {
                              ?>
                                <option value='<?= $item['user_group_id'] ?>' <?=($emp_data['user_group_id']==$item['user_group_id'])?'selected':''?>><?= $item['group_des'] ?></option>
                              <?php
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label notosans f12">ຊື່ເຂົ້າໃຊ້ລະບົບ*</label>
                          <div class="col-sm-9">
                            <input id="username" type="text" class="form-control notosans f12" value='<?=$emp_data['username']?>'/>
                          </div>
                        </div>
                      </div>

                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label notosans f12">ລະຫັດຜ່ານ*</label>
                          <div class="col-sm-9">
                            <input value="nuolpwd" id="password" type="password" class="form-control" />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label notosans f12">ຢືນຢັນລະຫັດຜ່ານ*</label>
                          <div class="col-sm-9">
                            <input value="nuolpwd" id="confirm_password" type="password" class="form-control" />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row submit">
                      <div class="col-md-12 center">
                        <button onclick="save()" type="submit" class="cus-btn btn btn-primary btn-icon-text notosans none-outline none-select">
                          ບັນທຶກ
                          <i class="fas fa-save btn-icon-append"></i>
                        </button>
                        <button onclick="window.location.href='template?page=employee'" type="button" class="cus-btn btn btn-danger btn-icon-text notosans none-outline none-select">
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
        </div>
      </div>
    </div>
  </div>
  <script>
    function save() {
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
      if (_fullname == "") {
        Swal.fire({
          icon: 'info',
          html: '<span class=notosans>ກະລຸນາປ້ອນ ຊື່ ແລະ ນາມສະກຸນ !</span>'
        });
      } else if (_username == "") {
        Swal.fire({
          icon: 'info',
          html: '<span class=notosans>ກະລຸນາປ້ອນ ຊື່ເຂົ້າໃຊ້ລະບົບ !</span>'
        });
      } else {
        if (_password != confirm_password) {
          Swal.fire({
            icon: 'info',
            html: '<span class=notosans>ລະຫັດຜ່ານບໍ່ກົງກັນ !</span>'
          });
        } else {
          var param = {
            emp_id: <?= $emp_id ?>,
            fullname: _fullname,
            gender: _gender,
            dep_id: _dep_id,
            username: _username,
            password: _password,
            address: _address,
            tel: _tel,
            user_type: _user_type,
            date_of_birth: _date_of_birth,
            dep_id_param: '<?= $dep_id_param ?>'

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

    function date_changed(data) {
      var _date = new Date(data);
      document.getElementById("date-of-birth-lb").innerHTML = _date.getDate().toString().padStart(2, "0") + "/" + (_date.getMonth() + 1).toString().padStart(2, "0") + "/" + _date.getFullYear();
    }
  </script>