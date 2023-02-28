<?php
    date_default_timezone_set("Asia/Vientiane");
    if(isset($_POST['stdFilterData'])){
        require "../config.php";
        include_once("app_module.php");
        $data = json_decode(decode($_POST['stdFilterData']));
        $course_id = $data->course_id;
        $classroom_id=$data->classroom_id;
        $year_no = $data->selected_year;
        $school_year = $data->school_year;
        if($classroom_id==0) {
            $sql = "SELECT s.student_id,s.student_code,s.gender,ifnull(s.name_la,'')name_la,ifnull(s.name_en,'')name_en,ifnull(s.surname_la,'')surname_la,
            ifnull(s.surname_en,'')surname_en,s.start_year,s.end_year,s.course_id,s.current_year,s.student_status ,r.school_year,r.classroom_id,
            c.classroom_des,r.year_no,ifnull(date_of_birthday,'')date_of_birthday,birth_address_la,birth_address_en,'',remark 
            FROM tb_student s INNER JOIN tb_student_register r ON s.student_code=r.student_code INNER JOIN tb_classroom c 
            ON r.classroom_id=c.classroom_id WHERE r.school_year=? AND s.course_id=? AND r.year_no=?";
            $query = $dbcon->prepare($sql);
            $query->execute(array($school_year,$course_id,$year_no));
        }else{
            $sql = "SELECT s.student_id,s.student_code,s.gender,ifnull(s.name_la,'')name_la,ifnull(s.name_en,'')name_en,ifnull(s.surname_la,'')surname_la,
            ifnull(s.surname_en,'')surname_en,s.start_year,s.end_year,s.course_id,s.current_year,s.student_status ,r.school_year,r.classroom_id,
            c.classroom_des,r.year_no,ifnull(date_of_birthday,'')date_of_birthday,birth_address_la,birth_address_en,'',remark 
            FROM tb_student s INNER JOIN tb_student_register r ON s.student_code=r.student_code INNER JOIN tb_classroom c 
            ON r.classroom_id=c.classroom_id WHERE r.school_year=? AND s.course_id=? AND r.year_no=? AND r.classroom_id=?";
            $query = $dbcon->prepare($sql);
            $query->execute(array($school_year,$course_id,$year_no,$classroom_id));
        }
        if($query){
            $res_data = $query->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($res_data);
        }else{
            echo "[]";
        }
    }
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
    if(isset($_POST["upload_student"])){
        require "../config.php";
        include_once("app_module.php");
        $data_param = json_decode(decode($_POST['upload_student']));
        $course_id = $data_param->course_id;
        $duration_year = $data_param->duration_year;
        $username = $data_param->username;
        $student_data = $data_param->data;
        $username = $data_param->username;
        $return_data = [];
        foreach($student_data as $student){
            // check data
            $sql = "SELECT COUNT(*)'num' FROM tb_student WHERE student_code=?";
            $query = $dbcon->prepare($sql);
            $query->execute(array($student->student_code));
            $num = $query->fetch(PDO::FETCH_ASSOC)["num"];
            if($num==0){
                $start_year = date("Y");
                $end_year = date("Y")+ $duration_year;
                $sql = "INSERT INTO tb_student(student_code, gender, name_la, surname_la, start_year, end_year,course_id,remark) 
                VALUES ('".$student->student_code."', '".$student->gender."', '".$student->name_la."', 
                '".$student->surname_la."', '".$start_year."', '".$end_year."','".$course_id."','".$student->remark."');";
                for($i=0;$i < $duration_year; $i++){
                    $school_year = (date("Y")+$i) . "-" . (date("Y") + ($i+1));
                    $sql .="INSERT INTO tb_student_register(student_code, school_year,year_no,create_date, user_update) 
                    VALUES ('".$student->student_code."','".$school_year."','"+($i+1)+"',now(),'".$username."');";
                }
                // echo $sql;
                $query = $dbcon->prepare($sql);
                $query->execute();
                if($query){
                    //success
                    $item = array(
                        "student_code"=>$student->student_code,
                        "gender"=>$student->gender,
                        "name_la"=>$student->name_la,
                        "surname_la"=>$student->surname_la,
                        "remake"=>$student->remark,
                        "status"=>"success"
                    );
                }else{
                    //error
                    $item = array(
                        "student_code"=>$student->student_code,
                        "gender"=>$student->gender,
                        "name_la"=>$student->name_la,
                        "surname_la"=>$student->surname_la,
                        "remake"=>$student->remark,
                        "status"=>"error !"
                    );
                }
            }else{
                //duplicate student_code
                $item = array(
                    "student_code"=>$student->student_code,
                    "gender"=>$student->gender,
                    "name_la"=>$student->name_la,
                    "surname_la"=>$student->surname_la,
                    "remake"=>$student->remark,
                    "status"=>"ລະຫັດນັກສຶກສາຊໍ້າກັນ"
                );
            }
            array_push($return_data,$item);
        }
        echo json_encode($return_data);
    }
    function load_course(){
        require "config.php";
        $sql = "SELECT `course_id`,c.`scheme_id`,s.scheme_des,s.duration_year,`course_des`,`class_pattern` FROM `tb_course` c 
        INNER JOIN tb_scheme s ON c.scheme_id = s.scheme_id WHERE c.course_status = 1 AND s.scheme_status = 1";
        $query = $dbcon->prepare($sql);
        $query->execute();
        return $query;
    }
    function get_course_data($course_id){
        require "config.php";
        $sql = "SELECT c.course_des,s.scheme_des,s.duration_year,s.scheme_id FROM tb_course c INNER JOIN tb_scheme s 
        ON c.scheme_id = s.scheme_id WHERE course_id = ?;";
        $query = $dbcon->prepare($sql);
        $query->execute(array($course_id));
        return $query;
    }
    function load_classroom_data(){
        require "config.php";
        $sql = "select*from tb_classroom where classroom_status=1";
        $query = $dbcon->prepare($sql);
        $query->execute();
        return $query;
    }
    function load_student($course_id,$start_year){
        require "config.php";
        $sql="SELECT*FROM tb_student WHERE course_id = ? AND start_year = ?;";
        $query = $dbcon->prepare($sql);
        $query->execute(array($course_id,$start_year));
        return $query;
    }
?>