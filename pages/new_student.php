<?php
require_once "controller/classroom_controller.php";
$course_data = load_course()->fetchAll(PDO::FETCH_ASSOC);
?>
<link rel="stylesheet" href="assets/css/new_student_style.css">
<section class="action">
    <button type="button" class="btn-defualt btn btn-primary btn-icon-text none-select none-outline notosans">
        <i class="ti-plus btn-icon-prepend"></i> ເພີ່ມໃໝ່
    </button>
    <button onclick="DownloadFile('Student_From_Data.xlsx')" type="button" class="btn-defualt btn btn-secondary btn-icon-text none-select none-outline notosans">
        <i class="ti-import btn-icon-prepend"></i> ດາວໂຫຼດແບບຟອມ
    </button>
    <button type="button" class="btn-defualt btn btn-success btn-icon-text none-select none-outline notosans">
        <i class="fas fa-sharp fa-solid fa-file-excel btn-icon-prepend"></i> ອັບໂຫຼດ Excel
    </button>
</section>
<section class="row">
    <div class="form-group filter">
        <div class="notosans f12">ສົກຮຽນ: <?= date("Y") . "-" . (date("Y") + 1) ?></div>
        <select class="form-select notosans" aria-label="Default select" name="cb_course" id="cb_course">
            <?php
            foreach ($course_data as $course) {
                $checked = "";
                if ($course['course_id'] == $course_id) {
                    $checked = "selected";
                }
            ?>
                <option value="<?= $course['course_id'] . ',' . $course['duration_year'] ?>" <?= $checked ?>><?= $course['course_des'] . "-" . $course['scheme_des'] ?></option>
            <?php
            }
            ?>
        </select>
        <button type="button" class="btn-defualt btn btn-primary btn-icon-text none-select none-outline notosans">
            <i class="ti-search btn-icon-prepend"></i> ຄົ້ນຫາ
        </button>
    </div>
</section>
<script src="assets/js/custom_js/new_student.js"></script>