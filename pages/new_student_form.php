<?php
require_once "controller/employee_controller.php";
?>
<link rel="stylesheet" href="assets/css/classroom-style.css">
<link rel="stylesheet" href="assets/css/student_form_style.css">
<script src="assets/js/jquery-1.9.1.min.js"></script>
<div class="header-page">
  <div class="page-title">
    <h5 class="notosans">
      <a href="template?page=home" class="home-link">ໜ້າຫຼັກ</a>
      <i class="fas fa-chevron-right"></i>
      <a href="template?page=student" class="home-link">ຂໍ້ມູນນັກສືກສາ</a>
      <i class="fas fa-chevron-right"></i>
      ເພີ່ມຂໍ້ມູນນັກສຶກສາໃໝ່
    </h5>
  </div>
</div>
<div class="page-wrapper">
  <div class="content-wrapper">
    <?php
    $user_id = @$user_data['user_id'];
    $user_group = get_user_group()->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div class="row">
      <div class="col-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title notosans">ເພີ່ມຂໍ້ມູນນັກສຶກສາ</h4>
            <div class="row">
              <div class="col-md-12">
                  <div class="col-sm-12">
                    <input id="student_code" type="text" class="inp form-control notosans f12" placeholder="ລະຫັດນັກສຶກສາ*"/>
                  </div>
              </div>
              <div class="col-md-6">
                <div class="col-sm-12" style="padding:15px 0px 0px 15px;">
                  <input id="name_la" type="text" class="inp form-control notosans f12" placeholder="ຊື່*"/>
                </div>
              </div>
              <div class="col-md-6">
                <div class="col-sm-12" style="padding:15px 15px 0px 0px;">
                  <input id="surname_la" type="text" class="inp form-control notosans f12" placeholder="ນາມສະກຸນ*"/>
                </div>
              </div>
              <div class="col-md-6">
                <div class="col-sm-12" style="padding:15px 0px 0px 15px;">
                  <input id="name_en" type="text" class="inp form-control notosans f12" placeholder="Name*"/>
                </div>
              </div>
              <div class="col-md-6">
                <div class="col-sm-12" style="padding:15px 15px 0px 0px;">
                  <input id="surname_en" type="text" class="inp form-control notosans f12" placeholder="Surname*"/>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6" style="padding:15px 15px 0px 30px; display:grid; grid-template-columns:86px 1fr;">
                <label class="col-form-label notosans f12">ເພດ</label>
                <div>
                  <select id="gender" onchange="gender_selected(this.value)" class="inp form-control notosans f12">
                    <option value="ທ້າວ">ທ້າວ</option>
                    <option value="ນາງ">ນາງ</option>
                    <option value="3">ອື່ນໆ</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6" style="padding:15px 15px 0px 0px;">
                <div class="col-sm-12">
                  <input id="gender_inp" type="text" class="inp form-control inp notosans f12" placeholder="ລະບຸເພດອື່ນໆ" hidden/>
                </div>
              </div>
              <div class="col-md-12">
                <div class="col-sm-12" style="padding-top:15px;">
                  <input id="address_la" type="text" class="inp form-control notosans f12" placeholder="ສະຖານທີ່ເກີດ"/>
                </div>
              </div>
              <div class="col-md-12">
                <div class="col-sm-12" style="padding-top:15px; padding-bottom:15px;">
                  <input id="address_en" type="text" class="inp form-control notosans f12" placeholder="Address of birth"/>
                </div>
              </div>
            </div>
            <div class="row submit">
              <div class="col-md-12 center">
                <button type="submit" name="save_ans_choice" class="cus-btn btn btn-primary btn-icon-text notosans none-outline none-select">
                  ບັນທຶກ
                  <i class="fas fa-save btn-icon-append"></i>
                </button>
                <button onclick="window.location.href='template?page=student'" type="submit" name="save_ans_choice" class="cus-btn btn btn-danger btn-icon-text notosans none-outline none-select">
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
    const name_en = document.getElementById('name_en');
    const surname_en = document.getElementById('surname_en');
    const gender_inp = document.getElementById('gender_inp');
    const address_of_birth = document.getElementById('address_en');
    const englishRegex = /^[a-zA-Z]*$/;
    name_en.addEventListener("input",function(){
      if (!englishRegex.test(name_en.value)) {
        name_en.value = name_en.value.replace(/[^a-zA-Z]/g, '');
      }
    });
    surname_en.addEventListener("input",function(){
      if (!englishRegex.test(surname_en.value)) {
        surname_en.value = surname_en.value.replace(/[^a-zA-Z]/g, '');
      }
    });
    address_of_birth.addEventListener("input",function(){
      if (!englishRegex.test(address_of_birth.value)) {
        address_of_birth.value = address_of_birth.value.replace(/[^a-zA-Z]/g, '');
      }
    });
    function gender_selected(value){
      if(value=="3"){
        gender_inp.hidden = false;
        gender_inp.focus();
      }else{
        gender_inp.hidden = true;
      }
    }
    function save() {
      var _fullname = $('#fullname').val();
      var _gender = $('#gender').val();
      var _user_group_id = $('#user_group').val();
      var _username = $('#username').val();
      var _password = $('#password').val();
      var confirm_password = $('#confirm_password').val();
      var _phone_number = $("#tel").val();
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
      } else if (_password == "" || confirm_password == "") {
        Swal.fire({
          icon: 'info',
          html: '<span class=notosans>ກະລຸນາປ້ອນ ລະຫັດຜ່ານ !</span>'
        });
      } else {
        if (_password != confirm_password) {
          Swal.fire({
            icon: 'info',
            html: '<span class=notosans>ລະຫັດຜ່ານບໍ່ກົງກັນ !</span>'
          });
        } else {
          var param = {
            fullname: _fullname,
            gender: _gender,
            user_group_id: _user_group_id,
            username: _username,
            password: _password,
            phone_number: _phone_number
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
          http.send("new_employee=" + _param);
        }
      }
    }
  </script>