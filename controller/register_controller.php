<?php
    date_default_timezone_set("Asia/Vientiane");
    if(isset($_POST['class_data'])){
        require "../config.php";
        include_once("app_module.php");
        $data = json_decode(decode($_POST['class_data']));
        $course_id = $data->course_id;
        $year_no = $data->year_no;
        $sql="SELECT * FROM tb_classroom WHERE course_id=? AND year_no=?";
        $query = $dbcon->prepare($sql);
        $query->execute(array($course_id,$year_no));
        if($query){
            $res_data = $query->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($res_data);
        }else{
            echo "[]";
        }
    }
    if(isset($_POST["register_status"])){
        require "../config.php";
        include_once("app_module.php");
        $data = json_decode(decode($_POST['register_status']));
        $register_id = $data->register_id;
        $username = $data->username;
        $regster_status = $data->register_status;
        $sql = "UPDATE tb_student_register SET register_status = ?, user_update = ?, last_update=now() WHERE register_id = ?;";
        // $sql .="INSERT INTO `tb_student_log`(`student_code`, `desc`, `userparse`) VALUES ('".$student->student_code."', 'created', '".$username."');";
        $query = $dbcon->prepare($sql);
        $query->execute(array($regster_status,$username,$register_id));
        if($query){
            echo json_encode(array("success"=>true));
        }else{
            echo json_encode(array("success"=>false));
        }
    }
    function load_student($filter){
        require "config.php";
        $school_year = date('Y').'-'.(date('Y')+1);
        $sql = "SELECT r.register_id,s.student_id,s.student_code,s.gender,s.name_la,s.surname_la,school_year,c.classroom_des,register_status
        FROM tb_student_register r INNER JOIN tb_student s ON r.student_code = s.student_code LEFT JOIN tb_classroom c ON 
        r.classroom_id = c.classroom_id WHERE r.school_year='".$school_year."' AND s.student_status='ACTIVE' ".$filter." ORDER BY c.classroom_des";
        // return $sql;
        $query = $dbcon->prepare($sql);
        $query->execute();
        return $query;
    }
    function load_classroom($course_id,$year_no){
        require "config.php";
        $sql = "SELECT * FROM tb_classroom WHERE course_id=? AND year_no=?";
        $query = $dbcon->prepare($sql);
        $query->execute(array($course_id,$year_no));
        return $query;
    }
    function load_course(){
        require "config.php";
        $sql = "SELECT `course_id`,c.`scheme_id`,s.scheme_des,s.duration_year,`course_des`,`class_pattern` FROM `tb_course` c 
        INNER JOIN tb_scheme s ON c.scheme_id = s.scheme_id WHERE c.course_status = 1 AND s.scheme_status = 1";
        $query = $dbcon->prepare($sql);
        $query->execute();
        return $query;
    }
    function get_class_des($course_id){
        require "config.php";
        $sql = "SELECT REPLACE(class_pattern,'[class_no]',(SELECT COUNT(*)+1 FROM tb_classroom cr 
        WHERE cr.course_id=? AND cr.year_no=1))'class_des' FROM tb_course c WHERE course_id = ?;";
        $query = $dbcon->prepare($sql);
        $query->execute(array($course_id,$course_id));
        return $query->fetch(PDO::FETCH_ASSOC)['class_des'];
    }
?>