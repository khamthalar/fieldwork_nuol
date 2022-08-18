<?php
    date_default_timezone_set("Asia/Vientiane");
    function load_test_quiz(){
        require "config.php";
        include_once("controller/app_module.php");
        $status = 1;
        $quiz_id_filter = "";
        $subj_id_filter = "";
        $class_id_filter = "";
        $sql = "SELECT test_id,test_number,subj_name,q.subj_id,tq.quiz_title,tq.start_time,tq.submit_time,tq.user_id,q.quiz_id,cq.class_id,c.class_des,tq.status 
        FROM test_quiz tq INNER JOIN class_quiz cq ON tq.class_quiz_id = cq.class_quiz_id INNER JOIN quiz q on cq.quiz_id = q.quiz_id INNER JOIN class_rooms c on 
        cq.class_id = c.id WHERE tq.status=$status $class_id_filter $subj_id_filter $quiz_id_filter";
        $query = $dbcon->prepare($sql);
        $query->execute();
        return $query;
    }
    if(isset($_POST['load_ans'])){
        require "../config.php";
        include_once("app_module.php");
        $data = json_decode(decode($_POST['load_ans']));
        $sql = "SELECT * FROM answer WHERE test_number=? AND question_type = 2";
        $query = $dbcon->prepare($sql);
        $query->execute(array($data->quiz_no));
        $ans_data = $query->fetchAll(PDO::FETCH_ASSOC);
        $res_data = array();
        foreach($ans_data as $_ans){
            $ans = array(
                "ans_id"=>$_ans['ans_id'],
                "question_title"=>$_ans['question_title'],
                "question_des"=>$_ans['question_des'],
                "answer"=>$_ans['answer'],
                "full_point"=>$_ans['full_point'],
                "show_ques_content"=>intval($_ans['show_ques_content']),
                "point"=>0
            );
            array_push($res_data,$ans);
        }
        echo json_encode($res_data);
    }
?>