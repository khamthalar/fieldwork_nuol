<?php
require_once "controller/question_controller.php";
$class_id = 0;
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
<link rel="stylesheet" href="assets/css/select-class-style.css">
<script src="assets/js/jquery-1.9.1.min.js"></script>
<div class="header-page">
  <div class="page-title">
    <h5 class="phetsarath">
      <a href="template?page=home" class="home-link">ໜ້າຫຼັກ</a> <i class="fas fa-chevron-right"></i>
      <a href="template?page=classroom" class="home-link">ຫ້ອງເສັງ</a> <i class="fas fa-chevron-right"></i>
      <a href="template?page=classroom&sub_page=class_subject<?= @$class_id_param . @$class_des_param ?>" class="home-link">ວິຊາເສັງ</a>
      <i class="fas fa-chevron-right"></i> ເລືອກວິຊາເສັງ
    </h5>
  </div>
</div>

<div class="page-wrapper">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="cus-card card">
          <div class="card-body">
            <h4 class="card-title phetsarath">ກະລຸນາເລືອກວິຊາເສັງ</h4>
            <div class="content">
              <div class="form-check">
                <?php
                $data = load_question_selection($class_id)->fetchAll(PDO::FETCH_ASSOC);
                ?>
              </div>
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <!-- <th class="col-id phetsarath" width="60">ລະຫັດ</th> -->
                      <th class="phetsarath">ຊື່ວິຊາເສັງ</th>
                      <!-- <th></th> -->
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($data as $subject) {
                    ?>
                      <tr>
                        <td class="col-id">
                          <div class="form-check">
                            <input name="cb_subjest[]" class="form-check-input cb_subject" type="checkbox" value="<?= $subject['subj_id'] ?>" id="cb<?= $subject['subj_id'] ?>">
                            <label class="form-check-label" for="cb<?= $subject['subj_id'] ?>">
                              <?= $subject['subj_name'] ?>
                            </label>
                          </div>
                        </td>
                        <!-- <td class="phetsarath"><?= $subject['subj_name'] ?></td> -->
                        <!-- <td>
                            <button type="button" class="btn btn-danger btn-icon-text btn-rounded none-select none-outline" data-id="<?= $data[$i]['id'] ?>" data-bs-toggle="modal" data-bs-target="#confirm_dialog" data-bs-backdrop="static">
                            <i class="fas fa-trash-alt"></i>
                            </button>
                            <button  type="button" class="btn btn-secondary btn-icon-text btn-rounded none-select none-outline" id="log">
                            <i class="fas fa-list"></i>
                            </button>
                        </td> -->
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
              <div class="submit-btn">
                <button onclick="save()" type="submit" name="save_ans_choice" class="btn btn-primary btn-icon-text phetsarath none-outline none-select">
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
</div>
  <script>
    function save(){
      var subjects = document.getElementsByName('cb_subjest[]');
      var subjects_checked = [];
      subjects.forEach(subject=>{
        if(subject.checked){
          subjects_checked.push(subject.value);
        }
      });
      // console.log(subjects_checked.length);
      if(subjects_checked.length==0){
        Swal.fire({icon:'info',html:'<span class=phetsarath>ກະລຸນາເລືອກວິຊາສອບເສັງໃດໜຶ່ງ!</span>'})
      }else{
        var param = {
          class_id:'<?=$class_id?>',
          class_des:'<?=$class_des?>',
          selected_subjected:subjects_checked
        };
        var http = new XMLHttpRequest();
        http.open("POST", 'controller/select_class_controller.php', true);
        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        http.onreadystatechange = function() {
            if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
              // console.log(this.responseText);
              eval(this.responseText);
            }
        }
        var _param = JSON.stringify(param);
        http.send("load_subject=" + _param);
        // console.log(param);
      }
    }
  </script>