<?php
    require_once "controller/new_student_controller.php";
    $course_data = load_course()->fetchAll(PDO::FETCH_ASSOC);
    $course_id = '';
?>
<link rel="stylesheet" href="assets/css/new_student_style.css">
<section class="action">
    <button type="button" class="btn-defualt btn btn-primary btn-icon-text none-select none-outline notosans">
        <i class="ti-plus btn-icon-prepend"></i> ເພີ່ມໃໝ່
    </button>
    <button onclick="DownloadFile('Student_From_Data.xlsx')" type="button" class="btn-defualt btn btn-secondary btn-icon-text none-select none-outline notosans">
        <i class="ti-import btn-icon-prepend"></i> ດາວໂຫຼດແບບຟອມ
    </button>
    <button onclick="goto_excel_upload()" 
        type="button" class="btn-defualt btn btn-success btn-icon-text none-select none-outline notosans">
        <i class="fas fa-sharp fa-solid fa-file-excel btn-icon-prepend"></i> ອັບໂຫຼດ Excel
    </button>
</section>
<section class="row">
    <div class="form-group filter">
        <div class="notosans f12">ສົກຮຽນ: <?= date("Y") . "-" . (date("Y") + 1) ?></div>
        <select onchange="course_selected(this.value)" class="form-select notosans" aria-label="Default select" name="cb_course" id="cb_course">
            <?php
            $checked = "selected";
            foreach ($course_data as $course) {
                if(isset($_GET['course_id2'])){
                    $course_id = $_GET['course_id2'];
                    if($course['course_id']==$course_id){
                        $checked = "selected";
                    }else{
                        $checked = "";
                    }
                    ?>
                        <option value="<?= $course['course_id'] ?>" <?= $checked ?>><?= $course['course_des'] . "-" . $course['scheme_des'] ?></option>
                    <?php
                }else{
                    if($checked=="selected"){
                        $course_id = $course['course_id'];
                    }
                    ?>
                        <option value="<?= $course['course_id'] ?>" <?= $checked ?>><?= $course['course_des'] . "-" . $course['scheme_des'] ?></option>
                    <?php
                    $checked = "";
                }
            }
            ?>
        </select>
        <!-- <button type="button" class="btn-defualt btn btn-primary btn-icon-text none-select none-outline notosans">
            <i class="ti-search btn-icon-prepend"></i> ຄົ້ນຫາ
        </button> -->
    </div>
</section>
<script>
    var course_id = '<?=$course_id?>';
</script>
<script src="assets/js/custom_js/new_student.js"></script>