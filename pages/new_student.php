<?php
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
    <button onclick="goto_excel_upload()" type="button" class="btn-defualt btn btn-success btn-icon-text none-select none-outline notosans">
        <i class="fas fa-sharp fa-solid fa-file-excel btn-icon-prepend"></i> ອັບໂຫຼດ Excel
    </button>
</section>
<section class="row">
    <div class="form-group filter" style="margin-bottom: 5px !important;">
        <div class="notosans f12">ສົກຮຽນ: <?= date("Y") . "-" . (date("Y") + 1) ?></div>
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
        <!-- <button type="button" class="btn-defualt btn btn-primary btn-icon-text none-select none-outline notosans">
            <i class="ti-search btn-icon-prepend"></i> ຄົ້ນຫາ
        </button> -->
    </div>
</section>
<section class="body">
    <?php
    $start_year = date("Y");
    $student_data = load_student($course_id, $start_year);
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
                        <td class="notosans center"></td>
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
    var course_id = '<?= $course_id ?>';
</script>
<script src="assets/script/new_student.js"></script>