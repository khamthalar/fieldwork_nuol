<?php
    $school_year = date('Y')."-".(date('Y')+1);
    $course_data  = load_course()->fetchAll(PDO::FETCH_ASSOC);
    $classroom = load_classroom_data()->fetchAll(PDO::FETCH_ASSOC);
    $select_course = "";
?>
<link rel="stylesheet" href="assets/css/student_data_style.css">
<div class="action-section">
    <button data-bs-toggle="modal" data-bs-target="#stdfilter" data-bs-backdrop="static"
            type="button" id="filter_btn"
            class="btn-defualt btn btn-primary btn-icon-text none-select none-outline notosans">
        <i class="ti-filter btn-icon-prepend"></i> filter
        <span id="std_filter_mark" class="std-filter-mark">*</span>
    </button>
    <!-- <button onclick="DownloadFile('Student_From_Data_update.xlsx')" type="button" class="btn-defualt btn btn-secondary btn-icon-text none-select none-outline notosans">
        <i class="ti-import btn-icon-prepend"></i> ດາວໂຫຼດແບບຟອມ
    </button> -->
    <button onclick="goto_excel_update()" type="button" class="btn-defualt btn btn-success btn-icon-text none-select none-outline notosans">
        <i class="fas fa-sharp fa-solid fa-file-excel btn-icon-prepend"></i> ແກ້ໄຂດ້ວຍ Excel
    </button>
    <button onclick="download_data()" type="button" class="btn-defualt btn btn-secondary btn-icon-text none-select none-outline notosans">
        <i class="ti-import btn-icon-prepend"></i> ດາວໂຫຼດຂໍ້ມູນ
    </button>
    <button onclick="print_data()" type="button" class="btn-defualt btn btn-primary btn-icon-text none-select none-outline notosans">
        <i class="ti-printer btn-icon-prepend"></i> ພິມ
    </button>
</div>
<div class="filter-section">
    <div class="filter-content row align-items-center">
        <label for="school_year" class="notosans f12">ສົກຮຽນ: <?=$school_year?></label>
        <input name="st_search" style="padding: .375rem 2.25rem .375rem .75rem !important;line-height:1.5 !important; height:38px !important;" id="st_search" type="text" class="form-control notosans" placeholder="Search..." />
    </div>
    <div id="filter_label" class="filter-string notosans">
        *ນັກສຶກສາປະລິນຍາຕີ, ຫ້ອງ 1 COM 1
    </div>
</div>
<div class="data-section">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th class="col-id notosans f12" width="30">ລ/ດ</th>
                    <th class="notosans">ລະຫັດນັກສຶກສາ</th>
                    <th class="notosans">ຊື່ ແລະ ນາມສະກຸນ</th>
                    <th class="notosans">ຫ້ອງຮຽນ</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="std-data">

            </tbody>
        </table>
    </div>
</div>

<?php
include_once("modals/filter_student_model.php");
?>
<!-- <script src="module/sheetJS/xlsx.full.min.js"></script> -->
<script src="module/xlsx-style/dist/xlsx.core.min.js"></script>
<script src="module/file-saver/dist/FileSaver.min.js"></script>
<script src="assets/script/student_data.js"></script>
<script>
    let all_students = [];
    let student_data = [];
    let school_year = '<?=$school_year?>';
    let loading = document.getElementById('preload');
    let all_classrooms = JSON.parse('<?=json_encode($classroom)?>');
    let classroom_data = [];
    let course_data = JSON.parse('<?=json_encode($course_data)?>');
    let courseId;
    let std_filter_dialog = document.getElementById("stdfilter");
    let filter_data = (sessionStorage.getItem("std_filter"))?JSON.parse(sessionStorage.getItem("std_filter")):undefined;
    let std_filter_mark = document.getElementById("std_filter_mark");
    let filter_label = document.getElementById("filter_label");
    let std_data = document.getElementById('std-data');
    std_filter_dialog.addEventListener('show.bs.modal',function(event){
        setCourseOption(course_data);
    })
</script>