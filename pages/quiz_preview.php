<?php
    require_once "controller/quiz_preview_controller.php";
    $user_id = @$user_data['id'];
    if(isset($_GET['quiz_id'])){
        $quiz_id = $_GET['quiz_id'];
        $subj_id = $_GET['subj_id'];
        $subj_name = $_GET['subj_name'];
        $quiz_title = $_GET['quiz_title'];
    }else{
        ?>
            <script>window.location.href = 'template?page=subject'</script>
        <?php
    }
?>
<link rel="stylesheet" href="assets/css/quiz_preview_style.css">
<script src="assets/js/jquery-1.9.1.min.js"></script>
<div class="header-page">
  <div class="page-title">
    <h5 class="phetsarath">
      <a href="template?page=home" class="home-link">ໜ້າຫຼັກ</a> <i class="fas fa-chevron-right"></i>
      <a href="template?page=subject" class="home-link">ວິຊາເສັງ</a> <i class="fas fa-chevron-right"></i>
      <a href="template?page=subject&sub_page=quiz&subj_id=<?=$subj_id?>&subj_name=<?=$subj_name?>" class="home-link">ຫົວຂໍ້ສອບເສັງ</a> <i class="fas fa-chevron-right"></i>
      ລາຍລະອຽດຫົວຂໍ້ເສັງ
    </h5>
  </div>
</div>
<div class="page-wrapper">
  <div class="content-wrapper">
    <div class="subj-info">
        <span class="subj-frame">
            <span class="phetsarath f14">ວິຊາເສັງ: </span><span id="subj_name" class="phetsarath f14"></span>
        </span>
        <button type="button" onclick="window.location.href='template?page=subject&sub_page=select_question&quiz_id=<?=$quiz_id?>&quiz_title=<?=$quiz_title?>&subj_id=<?=$subj_id?>&subj_name=<?=$subj_name?>'" class="btn-import btn btn-primary btn-icon-text none-select none-outline phetsarath">
            <i class="ti-import"></i>
        </button>
    </div>
    <div class="questions">
        <div class="question-content" id="quest_content"></div>
    </div>
  </div>
</div>
<?php
    include_once("modals/confirm_dialog.php");
?>
<script>
    var user_id = <?=$user_id?>;
    var param = {
        quiz_id:'<?=$quiz_id?>',
        subj_id:'<?=$subj_id?>'
    }
</script>
<script src="assets/js/crypto-js.js"></script>
<script src="assets/js/custom_js/quiz_preview.js"></script>
<script src="module/ckeditor/ckeditor.js"></script>
