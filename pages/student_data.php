<?php
    $course_data  = load_course()->fetchAll(PDO::FETCH_ASSOC);
    $classroom = load_classroom_data()->fetchAll(PDO::FETCH_ASSOC);
    $select_course = "";
    $start_year = date('Y');
    $end_year = (date('Y')+1);
    if(isset($_GET['schoolyear'])){
        $schoolyear = explode("-",$_GET['schoolyear']);
        $start_year = $schoolyear[0];
        $end_year = $schoolyear[1];
    }
    $school_year = $start_year."-".$end_year;
?>
<link rel="stylesheet" href="assets/css/student_data_style.css">
<div class="action-section">
    <button data-bs-toggle="modal" data-bs-target="#stdfilter" data-bs-backdrop="static"
            type="button" id="filter_btn"
            class="btn-defualt btn btn-primary btn-icon-text none-select none-outline notosans">
        <i class="ti-filter btn-icon-prepend"></i> filter
        <span id="std_filter_mark" class="std-filter-mark">*</span>
    </button>
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
                    <th class="notosans center">ສະຖານະ</th>
                </tr>
            </thead>
            <tbody id="std-data">

            </tbody>
        </table>
    </div>
</div>


<?php
    include_once("modals/filter_student_model.php");
    include_once("modals/student_log_modal.php");
?>
<script src="module/xlsx-style/dist/xlsx.core.min.js"></script>
<script src="module/file-saver/dist/FileSaver.min.js"></script>
<script src="assets/script/student_data.js"></script>
<script>
    let filter_str='';
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
    let std_log = document.getElementById('student_log');
    std_filter_dialog.addEventListener('show.bs.modal',function(event){
        setCourseOption(course_data);
    })
    std_log.addEventListener('show.bs.modal',function(event){
        var student_info = $(event.relatedTarget);
        let student_code = student_info.data('student_code');
        let http = new XMLHttpRequest();
        http.open( "POST", 'controller/student_controller.php', true );
        http.setRequestHeader( 'Content-type', 'application/x-www-form-urlencoded' );
        http.onreadystatechange = function () {
            if ( this.readyState === XMLHttpRequest.DONE && this.status === 200 ) {
                try{
                    let body_content = document.getElementById('log_body_content');
                    let html_str = ``;
                    let log_data = [];
                    log_data = JSON.parse(this.responseText);
                    if(log_data){
                        log_data.forEach((item)=>{
                            html_str+=`
                            <div class="log_item">
                                <div class="notosans">`+item.issue_date+`</div>
                                <div class="notosans">`+item.desc+`</div>
                                <div class="notosans">`+item.userparse+`</div>
                            </div>`;
                        });
                    }
                    body_content.innerHTML = html_str;
                }catch(e){
                    console.log(e);
                }
            }
        }
        var _param = encode( JSON.stringify( {student_code} ) );
        http.send( "student_log=" + _param );
    })
</script>