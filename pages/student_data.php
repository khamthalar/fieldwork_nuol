<?php

?>
<link rel="stylesheet" href="assets/css/student_data_style.css">
<div class="filter-section row">
    <div class="col-lg-4">
    <div class="form-group">
        <label for="school_year" class="notosans f12">ສົກຮຽນ</label>
        <div class="school_year_item">
            <input value="<?=date('Y')?>" type="number" class="year-inp form-control notosans f12" 
            id="school_year1"  placeholder="yyyy" onKeyPress="if(this.value.length==4) return false;"
            onchange="school_year('start')">
            <div class="center"><i class="ti-minus"></i></div>
            <input value="<?=date('Y')+1?>" type="number" class="year-inp form-control notosans f12" 
            id="school_year2"  placeholder="yyyy" onKeyPress="if(this.value.length==4) return false;"
            onchange="school_year('end')">
        </div>
    </div>
    </div>
</div>
<div class="data-section"></div>
<script>
    document.getElementById("school_year1").addEventListener("keydown", e => e.keyCode != 38 && e.keyCode != 40 && e.preventDefault());
    document.getElementById("school_year2").addEventListener("keydown", e => e.keyCode != 38 && e.keyCode != 40 && e.preventDefault());
    function school_year(param){
        if(param=="start"){
            document.getElementById('school_year2').value=parseInt(document.getElementById('school_year1').value)+1;
        }else{
            document.getElementById('school_year1').value=parseInt(document.getElementById('school_year2').value)-1;
        }
    }
</script>