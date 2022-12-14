<div class="modal fade" id="addclass" tabindex="-1" role="dialog" aria-labelledby="addclass">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
            <div class="modal-header" 
                style="
                    background-color:var(--main-color); 
                    color:white; 
                    border-top-left-radius: .1rem;
                    border-top-right-radius: .1rem;">
                <h4 class="modal-title notosans f12" id="addclass">ເພີ່ມຫ້ອງຮຽນໃໝ່</h4>
                <button type="button" class="close none-outline" data-bs-dismiss="modal" aria-label="Close" style="padding: 0px; margin: 0px -10px 0px 0px;"><span class="modal-close-lb" aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" action="">
                <input type="hidden" id="course_id" name="course_id">
                <input type="hidden" id="full_classroom_des" name="full_classroom_des">
                <input type="hidden" id="year_num" name="year_num">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="des" class="notosans f12" id="des">ກະລຸນາປ້ອນລາຍລະອຽດຫ້ອງເສັງ</label>
                    </div>
                    
                </div>
                <div class="modal-footer" style="justify-content:center;">
                    <button type="submit" name="new_class" class="cus-btn btn btn-primary btn-icon-text notosans f12 none-outline none-select">
                        ບັນທຶກ
                        <i class="fas fa-save btn-icon-append"></i>                                                                             
                    </button>
                    <button type="button" class="cus-btn btn btn-warning btn-icon-text notosans f12 none-outline none-select" data-bs-dismiss="modal">
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
        $('#addclass').modal({
            backdrop:'static'
        });
    });
</script>