<?php
    require_once "controller/course_controller.php";
    $scheme_data =  load_scheme()->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="modal fade" id="update_course" tabindex="-1" role="dialog" aria-labelledby="update_course">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
            <div class="modal-header" 
                style="
                    background-color:var(--main-color); 
                    color:white; 
                    border-top-left-radius: .1rem;
                    border-top-right-radius: .1rem;">
                <h4 class="modal-title notosans" id="addclass">ເພີ່ມຂໍ້ມູນຫຼັກສູດ</h4>
                <button type="button" class="close none-outline" data-bs-dismiss="modal" aria-label="Close"><span class="modal-close-lb" aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">
                    <input type="hidden" name="course_id_update" id="course_id_update">
                    <div class="form-group">
                    <?php
                        $checked = "checked";
                        foreach($scheme_data as $scheme){
                            ?>
                            <br>
                            <input type="radio" id="scheme<?=$scheme['scheme_id']?>" name="scheme_id_udate" value="<?=$scheme['scheme_id']?>" <?=$checked?> >
                            <label class="notosans" for="scheme<?=$scheme['scheme_id']?>"><?=$scheme['scheme_des']?></label>
                            <?php
                            $checked = "";
                        }
                    ?>
                    </div>
                    <div class="form-group">
                        <label for="course_des" class="notosans">ກະລຸນາປ້ອນຊື່ຫຼັກສູດ</label>
                        <input type="text" class="form-control notosans center none-select none-outline" id="course_des_update" name="course_des_update" required>
                    </div>
                    <div class="form-group">
                        <label for="class_pattern" class="notosans">ຮູບແບບຊື່ຫ້ອງຮຽນ</label>
                        <input type="text" class="form-control notosans center none-select none-outline" id="class_pattern_update" name="class_pattern_update" required>
                    </div>
                </div>
                <div class="modal-footer" style="justify-content:center;">
                    <button type="submit" name="update_course" class="cus-btn btn btn-primary btn-icon-text notosans none-outline none-select">
                        ບັນທຶກ
                        <i class="fas fa-save btn-icon-append"></i>                                                                             
                    </button>
                    <button type="button" class="cus-btn btn btn-warning btn-icon-text notosans none-outline none-select" data-bs-dismiss="modal">
                        ຍົກເລີກ
                        <i class="fas fa-times btn-icon-append"></i>                                                                            
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){ 
        $('#update_course').modal({
            backdrop:'static'
        });
    });
</script>
