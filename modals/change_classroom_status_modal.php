<div class="modal fade" id="change_status" tabindex="-1" role="dialog" aria-labelledby="change_status">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
            <div class="modal-header" 
                style="
                    background-color:var(--main-color); 
                    color:white; 
                    border-top-left-radius: .1rem;
                    border-top-right-radius: .1rem;">
                <h4 class="modal-title notosans f12" id="change_status">ສະຖານະ</h4>
                <button type="button" class="close none-outline" data-bs-dismiss="modal" aria-label="Close" style="padding: 0px; margin: 0px -10px 0px 0px;"><span class="modal-close-lb" aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" action="">
                <input type="hidden" id="classroom_id" name="classroom_id">
                <input type="hidden" id="classroom_status" name="classroom_status">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="des" class="notosans f12" id="detail">detail</label>
                    </div>
                    
                </div>
                <div class="modal-footer" style="justify-content:center;">
                    <button id="btn_save" type="submit" name="change_status" class="cus-btn btn btn-primary btn-icon-text notosans f12 none-outline none-select">
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
        $('#change_status').modal({
            backdrop:'static'
        });
    });
</script>