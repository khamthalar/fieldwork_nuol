<?php
    require_once "controller/open_exam_controller.php";
    $user_id = @$user_data["id"];
    $quiz_data = load_quiz_by_user($user_id)->fetchAll(PDO::FETCH_ASSOC);
    // echo "<pre>";
    // print_r($quiz_data);
    // echo "</pre>";
?>
<div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="cus-card card">
                <div class="card-body">
                    <h4 class="card-title phetsarath">ຫົວບົດເສັງ</h4>
                    <div class="grid-margin transparent">
                        <div class="row">
                            <?php
                                foreach($quiz_data as $quiz){
                            ?>
                            <div class="col-lg-3 col-md-4 col-sm-6 mb-4 stretch-card transparent">
                                <div class="deskboard-card card" style="background-color:darkorange">
                                    <div class="card-body">
                                        <h3 class="phetsarath col-white"><?=$quiz['quiz_title']?></h3>
                                        <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                            <span class="display-5 text-info pointer">
                                                <img src="assets/svg/quiz2.svg" width="70">
                                            </span>
                                            <!-- <h1 class="ml-auto col-white">test</h1> -->
                                            <div class="ml-auto">
                                                <div class="quiz_time phetsarath">ເວລາເສັງ <?=$quiz['quiz_time']?> ນາທີ</div>
                                                
                                                <div class="btn-open-test">
                                                    <button id="open_test" onclick="window.location.href='main?page=invite&quiz_id=<?=$quiz['quiz_id']?>'" type="button" class="btn btn-primary phetsarath" <?=($quiz['can_test']==0)?'disabled':''?>>ເລີ່ມສອບເສັງ</button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <?php } ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // $('#open_test').click(function(){
    //     window.history.pushState(null, "", window.location.href);        
    //     window.onpopstate = function() {
    //         window.history.pushState(null, "", window.location.href);
    //     };
    // });
    // $(document).ready(function() {
    //     window.history.pushState(null, "", window.location.href);        
    //     window.onpopstate = function() {
    //         window.history.pushState(null, "", window.location.href);
    //     };
    // });
    // function preventBack() {window.history.forward();}  setTimeout("preventBack()", 0);  window.onunload = function () {null};
</script>