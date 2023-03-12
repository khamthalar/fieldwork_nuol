<div class="modal fade" id="stdinfo" tabindex="-1" role="dialog" aria-labelledby="stdinfo">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
            <div class="modal-header" 
                style="
                    background-color:var(--main-color); 
                    color:white; 
                    border-top-left-radius: .1rem;
                    border-top-right-radius: .1rem;">
                <h4 class="modal-title notosans f12" id="stdinfo">ຂໍ້ມູນນັກສຶກສາ</h4>
                <button type="button" class="close none-outline" data-bs-dismiss="modal" aria-label="Close" style="padding: 0px; margin: 0px -10px 0px 0px;"><span class="modal-close-lb" aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="notosans f12">ລະຫັດນັກສືກສາ: <span class="notosans f12 bold" id="student_code"></span></div>
                        <div class="notosans f12">ຊື່ ແລະ ນາມສະກຸນ: <span class="notosans f12 bold" id="fullname_la"></span></div>
                        <div class="notosans f12">Name and Surname: <span class="notosans f12 bold" id="fullname_en"></span></div>
                        <div class="notosans f12">ວັນເດືອນປີເກີດ: <span class="notosans f12 bold" id="dateofbirth"></span></div>
                        <div class="notosans f12">ຫ້ອງຮຽນ: <span class="notosans f12 bold" id="class_des"></span></div>
                        <div class="notosans f12">ສະຖານທີ່ເກີດ: <span class="notosans f12 bold" id="address_la"></span></div>
                        <div class="notosans f12">Address of birth: <span class="notosans f12 bold" id="address_en"></span></div>
                    </div>
                    
                </div>
                <div class="modal-footer" style="justify-content:center;">
                    <button type="button" name="new_class" class="cus-btn btn btn-primary btn-icon-text notosans f12 none-outline none-select" data-bs-dismiss="modal">
                        ຕົກລົງ                                                                            
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .bold{
        font-weight: bolder !important;
    }
</style>