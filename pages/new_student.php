<?php
    $course_data = load_course()->fetchAll(PDO::FETCH_ASSOC);
    if (isset($_GET['course_id2'])) {
        $course_id = $_GET['course_id2'];
    }else{
        $course_id = @$course_data[0]['course_id'];
    }
    $n_start_year = date('Y');
    $n_end_year = (date('Y')+1);
    if(isset($_GET['n_schoolyear'])){
        $n_schoolyear = explode("-",$_GET['n_schoolyear']);
        $n_start_year = $n_schoolyear[0];
        $n_end_year = $n_schoolyear[1];
    }
    $n_schoolyear = $n_start_year."-".$n_end_year;
?>
<link rel="stylesheet" href="assets/css/new_student_style.css">
<section class="action">
    <button type="button" onclick="location.href = 'template?page=student&sub_page=new_student_form&course_id=<?=$course_id?>';"
    class="btn-defualt btn btn-primary btn-icon-text none-select none-outline notosans">
        <i class="ti-plus btn-icon-prepend"></i> ເພີ່ມໃໝ່
    </button>
    <button onclick="DownloadFile('Student_From_Data.xlsx')" type="button" class="btn-defualt btn btn-secondary btn-icon-text none-select none-outline notosans">
        <i class="ti-import btn-icon-prepend"></i> ດາວໂຫຼດແບບຟອມ
    </button>
    <?php 
        if($n_start_year >= date('Y')){
    ?>
    <button onclick="goto_excel_upload()" type="button" class="btn-defualt btn btn-success btn-icon-text none-select none-outline notosans">
        <i class="fas fa-sharp fa-solid fa-file-excel btn-icon-prepend"></i> ອັບໂຫຼດ Excel
    </button>
    <?php } ?>
</section>
<section class="row">
    <div class="form-group" style="margin-bottom: 5px !important;">
        <div class="notosans f12">ສົກຮຽນ: </div>
        <div class="filter">
            <div class="notosans f12 school-year">
                <button onclick="openSchoolyearModal(true)" class="btn-nst-schoolyear">
                    <?=$n_start_year.'-'.$n_end_year?>
                </button>
            </div>
            <select onchange="course_selected(this.value)" class="form-select notosans" aria-label="Default select" name="cb_course" id="cb_course">
                <?php
                $checked = "selected";
                foreach ($course_data as $course) {
                    if (isset($_GET['course_id2'])) {
                        $course_id = $_GET['course_id2'];
                        if ($course['course_id'] == $course_id) {
                            $checked = "selected";
                        } else {
                            $checked = "";
                        }
                ?>
                        <option value="<?= $course['course_id'] ?>" <?= $checked ?>><?= $course['course_des'] . "-" . $course['scheme_des'] ?></option>
                    <?php
                    } else {
                        if ($checked == "selected") {
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
        </div>
        <!-- <button type="button" class="btn-defualt btn btn-primary btn-icon-text none-select none-outline notosans">
            <i class="ti-search btn-icon-prepend"></i> ຄົ້ນຫາ
        </button> -->
    </div>
</section>
<section class="body">
    <?php
    $student_data = load_student_newstudent($course_id, $n_start_year);
    $data = $student_data->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div class="table-responsive">
        <?php
            $current_page = 1;
            $row_num = $student_data->rowCount();
            if ($row_num > $limit_row) {
                $last_page = ceil($row_num / $limit_row);
                if (isset($_GET['page_no'])) {
                    $current_page = $_GET['page_no'];
                }
            }
        ?>
        <table class="table">
            <thead>
                <tr>
                    <th class="col-id notosans f12" width="30">ລ/ດ</th>
                    <th class="notosans">ລະຫັດນັກສຶກສາ</th>
                    <th class="notosans">ຊື່ ແລະ ນາມສະກຸນ</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $limit_start = ($current_page - 1) * $limit_row;
                for ($i = $limit_start; $i < ($limit_start + 10); $i++) {
                    if ($i == $row_num) {
                        break;
                    }
                ?>
                    <tr>
                        <td class="col-id notosans f12 center"><?= $i + 1 ?></td>
                        <td class="notosans f12">
                            <?= $data[$i]['student_code'] ?>
                        </td>
                        <td class="notosans f12">
                            <?= $data[$i]['gender'] . " " . $data[$i]['name_la'] . " " . $data[$i]["surname_la"] ?>
                        </td>
                        <td class="notosans center">
                            <button
                            onclick="openUpdateForm(
                                '<?=encode($data[$i]['student_id'])?>',
                                '<?=encode($data[$i]['student_code'])?>',
                                '<?=encode($data[$i]['gender'])?>',
                                '<?=encode($data[$i]['name_la'])?>',
                                '<?=encode($data[$i]['surname_la'])?>',
                                '<?=encode($data[$i]['name_en'])?>',
                                '<?=encode($data[$i]['surname_en'])?>',
                                '<?=encode($data[$i]['date_of_birthday'])?>',
                                '<?=encode($data[$i]['birth_address_la'])?>',
                                '<?=encode($data[$i]['birth_address_en'])?>',
                                '<?=encode($data[$i]['remark'])?>')"
                            type="button" class="btn btn-warning btn-icon-text btn-rounded none-select none-outline">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <button type="button" class="btn btn-primary btn-icon-text btn-rounded none-select none-outline"
                            data-student_code="<?=$data[$i]['student_code']?>" 
                            data-fullname_la="<?=$data[$i]['gender'] . " " . $data[$i]['name_la'] . " " . $data[$i]["surname_la"] ?>" 
                            data-fullname_en="<?=$data[$i]['name_en'] . " " . $data[$i]["surname_en"]?>" 
                            data-birthdate="<?=$data[$i]['date_of_birthday']?>" 
                            data-classroom_des="-" 
                            data-address_la="<?=$data[$i]['birth_address_la']?>" 
                            data-address_en="<?=$data[$i]['birth_address_en']?>"
                            data-bs-toggle="modal" data-bs-target="#stdinfo" data-bs-backdrop="static">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button onclick="delete_student('<?=$data[$i]['student_code']?>')" type="button" class="btn btn-danger btn-icon-text btn-rounded none-select none-outline" >
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="paginate">
            <?php
            include_once 'paginate.php';
            ?>
        </div>
    </div>
</section>
<script>
    sessionStorage.removeItem('std_param');
    var _username = '<?=$user_data['username']?>';
    var course_id = '<?= $course_id ?>';
    const st_start_year = document.getElementById('newst_start_year');
    const st_end_year = document.getElementById('newst_end_year');
    function openUpdateForm(student_id,student_code, gender, name_la, surname_la, name_en, surname_en, 
    date_of_birthday, birth_address_la, birth_address_en, remark ){
        let param = {
            student_id,
            student_code,
            gender,
            name_la,
            surname_la,
            name_en,
            surname_en,
            date_of_birthday,
            birth_address_la,
            birth_address_en,
            remark
        }
        sessionStorage.setItem('std_param',JSON.stringify(param));
        location.href = 'template?page=student&sub_page=edit_student_form';
    }
    function input_keydown(e){
        e.preventDefault();
    }
    function year_changed(isStartYear){
        if(isStartYear)
            st_end_year.value = Number(st_start_year.value)+1;
        else
            st_start_year.value = Number(st_end_year.value)-1;
            
        location.href = 'template?page=student<?=isset($_GET['course_id2'])?('&course_id2='.$_GET['course_id2']):''?>&school_year='+st_start_year.value+'-'+st_end_year.value;
    }
</script>
<script src="assets/script/new_student.js"></script>