<div class="modal fade" id="schoolyear" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" role="document" style="max-width:350px;">
    <div class="modal-content">
            <div class="modal-header" 
                style="
                    background-color:var(--main-color); 
                    color:white; 
                    border-top-left-radius: .1rem;
                    border-top-right-radius: .1rem;">
                <h4 class="modal-title notosans" id="exampleModalLabel1">ເລືອກສົກຮຽນ</h4>
                <button type="button" class="close none-outline" data-bs-dismiss="modal" aria-label="Close" style="padding: 0px; margin: 0px -10px 0px 0px;"><span class="modal-close-lb" aria-hidden="true">&times;</span></button>
            </div>
            <!-- <form method="POST" action=""> -->
                <div class="modal-body">
                    <div class="school-year-el">
                        <input 
                            onchange="year_changed(true)"
                            onkeydown="input_keydown(event)" 
                            id="start_year" type="number" class=" notosans f12">
                        <div class="connector">-</div>
                        <input 
                            onchange="year_changed(true)"
                            onkeydown="input_keydown(event)" 
                            id="end_year" type="number" class="notosans f12">
                    </div>
                </div>
                <div class="modal-footer" style="justify-content:center;">
                    <button onclick="submit_schoolyear(this)" id="btn_shcoolyear" type="submit" class="btn btn-secondary none-outline none-select notosans" style="min-width:100px;">ຕົກລົງ</button>
                    <button type="button" class="btn btn-secondary none-outline none-select notosans" data-bs-dismiss="modal" style="min-width:100px;">ຍົກເລີກ</button>
                </div>
            <!-- </form> -->
        </div>
    </div>
</div>

<script>
    const el_start_year = document.getElementById('start_year');
    const el_end_year = document.getElementById('end_year');
    function input_keydown(e){
        e.preventDefault();
    }
    function year_changed(isStartYear){
        if(isStartYear)
            el_end_year.value = Number(el_start_year.value)+1;
        else
            el_start_year.value = Number(el_end_year.value)-1;
    }
</script>