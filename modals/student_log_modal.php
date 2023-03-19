<div class="modal fade" id="student_log" tabindex="-1" role="dialog" aria-labelledby="student_log">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
            <div class="modal-header" 
                style="
                    background-color:var(--main-color); 
                    color:white; 
                    border-top-left-radius: .1rem;
                    border-top-right-radius: .1rem;">
                <h4 class="modal-title notosans" id="student_log_title">Student Log</h4>
                <button type="button" class="close none-outline" data-bs-dismiss="modal" aria-label="Close" style="padding: 0px; margin: 0px -10px 0px 0px;"><span class="modal-close-lb" aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">
                    <div class="header-content">
                        <div class="notosans bold">Long Time</div>
                        <div class="notosans bold">Description</div>
                        <div class="notosans bold">User issue</div>
                    </div>
                    <div class="body-content" id="log_body_content"></div>
                </div>
                <div class="modal-footer" style="justify-content:center;">
                    <button type="button" class="cus-btn btn btn-primary btn-icon-text notosans none-outline none-select" data-bs-dismiss="modal">
                        ຕົກລົງ                                                                        
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .bold{
        font-weight: bolder;
    }
    .header-content,.log_item{
        display: grid;
        grid-template-columns: 153px 1fr auto;
        gap: 10px;
    }
</style>