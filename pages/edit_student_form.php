<?php
require_once "controller/student_controller.php";
?>
<link rel="stylesheet" href="assets/css/classroom-style.css">
<link rel="stylesheet" href="assets/css/student_form_style.css">
<div class="header-page">
  <div class="page-title">
    <h5 class="notosans">
      <a href="template?page=home" class="home-link">ໜ້າຫຼັກ</a>
      <i class="fas fa-chevron-right"></i>
      <a href="template?page=student" class="home-link">ຂໍ້ມູນນັກສືກສາ</a>
      <i class="fas fa-chevron-right"></i>
      ແກ້ໄຂຂໍ້ມູນນັກສຶກສາໃໝ່
    </h5>
  </div>
</div>
<div class="page-wrapper">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title notosans">ແກ້ຂໍ້ມູນນັກສຶກສາ</h4>
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
                  <input id="name_en" type="text" class="inp form-control notosans f12" placeholder="Name"/>
                </div>
              </div>
              <div class="col-md-6">
                <div class="col-sm-12" style="padding:15px 15px 0px 0px;">
                  <input id="surname_en" type="text" class="inp form-control notosans f12" placeholder="Surname"/>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6" style="padding:15px 15px 0px 30px; display:grid; grid-template-columns:86px 1fr;">
                <label class="col-form-label notosans f12">ເພດ</label>
                <div>
                  <select id="gender" onchange="gender_selected(this.value)" class="inp form-control notosans f12">
                    <option id='male' value="ທ້າວ">ທ້າວ</option>
                    <option id='female' value="ນາງ">ນາງ</option>
                    <option id='other' value="3">ອື່ນໆ</option>
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
              <div class="col-md-6" style="padding-left:30px;">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label notosans f12">ວັນເດືອນປີເກີດ</label>
                  <div class="col-sm-9">
                    <label class="lb">
                      <input type="date" id="date_of_birth" name="date_of_birth" onchange="date_changed(this.value)">
                      <button class="btn-calendar" id="calendar_text">
                        <div id="date-of-birth-lb" class="notosans f12" style="line-height:42px">ວັນເດືອນປີເກີດ</div>
                        <div class="calender-ico"><img src="assets/svg/calendar.svg" width="20"></div>
                      </button>
                    </label>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="col-sm-12" style="padding-left:0px;">
                  <input id="remark" type="text" class="inp form-control notosans f12" placeholder="Remark"/>
                </div>
              </div>
              <div></div>
            </div>
            <div class="row submit">
              <div class="col-md-12 center">
                <button onclick="save()" type="submit" name="save_ans_choice" class="cus-btn btn btn-primary btn-icon-text notosans none-outline none-select">
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
    const gender_section = document.getElementById('gender');
    const name_la = document.getElementById('name_la');
    const surname_la = document.getElementById('surname_la');
    const student_code = document.getElementById('student_code');
    const address_la = document.getElementById('address_la');
    const address_en = document.getElementById('address_en');
    const birthdate = document.getElementById('date_of_birth');
    const remark = document.getElementById('remark');
    const male = document.getElementById('male');
    const female = document.getElementById('female');
    const g_other = document.getElementById('other');

    var _username = '<?=$user_data['username']?>';
    var course_id = '';
    let std_data = sessionStorage.getItem('std_param');
    std_data = JSON.parse(std_data);
    if(std_data){
      student_code.value = decode(std_data.student_code);
      name_la.value = decode(std_data.name_la);
      surname_la.value = decode(std_data.surname_la);
      name_en.value = decode(std_data.name_en);
      surname_en.value = decode(std_data.surname_en);
      let gender_str = decode(std_data.gender);
      if(gender_str=="ທ້າວ"){
        male.selected = true;
      }else if(gender_str=="ນາງ"){
        female.selected = true;
      }else{
        g_other.selected = true;
        gender_inp.value = gender_str;
      }
      address_en.value = decode(std_data.birth_address_en);
      address_la.value = decode(std_data.birth_address_la);
      remark.value = decode(std_data.remark);
      let _birthdate = decode(std_data.date_of_birthday);
      if(_birthdate){
        birthdate.value = _birthdate;
        var _date = new Date( _birthdate );
        document.getElementById( "date-of-birth-lb" ).innerHTML = _date.getDate().toString().padStart( 2, "0" ) + "/" + ( _date.getMonth() + 1 ).toString().padStart( 2, "0" ) + "/" + _date.getFullYear();
      }
    }
    console.log(std_data);
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
    function date_changed( data ) {
      var _date = new Date( data );
      document.getElementById( "date-of-birth-lb" ).innerHTML = _date.getDate().toString().padStart( 2, "0" ) + "/" + ( _date.getMonth() + 1 ).toString().padStart( 2, "0" ) + "/" + _date.getFullYear();
    }
    function save() {
      if(student_code.value==""){
        Swal.fire({
          icon: 'info',
          html: '<span class=notosans>ກະລຸນາປ້ອນລະຫັດນັກສຶກສາ !</span>'
        }).then(()=>{
          student_code.focus();
        });
      }else if(name_la.value==""){
        Swal.fire({
          icon: 'info',
          html: '<span class=notosans>ກະລຸນາປ້ອນຊື່ !</span>'
        });
      }else if(surname_la.value==""){
        Swal.fire({
          icon: 'info',
          html: '<span class=notosans>ກະລຸນາປ້ອນນາມສະກຸນ !</span>'
        });
      }else{
        if(gender_section.value=="3" && gender_inp.value==""){
          Swal.fire({
            icon: 'info',
            html: '<span class=notosans>ກະລຸນາລະບຸເພດຂອງນັກສຶກສາ !</span>'
          });
        }else{
          let param = {
            student_id:std_data?.student_id,
            old_student_code:decode(std_data.student_code),
            student_code:student_code.value,
            name_la:name_la.value,
            surname_la:surname_la.value,
            name_en:name_en.value,
            surname_en:surname_en.value,
            gender:(gender_section.value==3)?gender_inp.value:gender_section.value,
            address_la:address_la.value,
            address_en:address_en.value,
            birthdate:birthdate.value,
            remark:remark.value,
            course_id:course_id,
            username:_username
          }
          console.log(param);
          var http = new XMLHttpRequest();
          http.open("POST", 'controller/student_controller.php', true);
          http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
          http.onreadystatechange = function() {
            if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
              eval(this.responseText);
            }
          }
          var _param = encode(JSON.stringify(param));
          http.send("update_student=" + _param);
        }
      }
    }
  function decode( text ) {
    return text
        .replaceAll( "#amp;",'&' )
        .replaceAll( "#quot;",'"' )
        .replaceAll( "#plus;",'+' )
        .replaceAll( "#039;","'" )
  }
  function encode( text ) {
    return text
        .replace( /&/g, "#amp;" )
        .replace( /"/g, "#quot;" )
        .replace( /\+/g, "#plus;" )
        .replace( /'/g, "#039;" );
  }
  </script>