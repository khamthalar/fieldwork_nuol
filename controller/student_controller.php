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
            c.classroom_des,r.year_no,ifnull(date_of_birthday,'')date_of_birthday,ifnull(birth_address_la,'')birth_address_la,ifnull(birth_address_en,'')birth_address_en,remark 
            FROM tb_student s INNER JOIN tb_student_register r ON s.student_code=r.student_code INNER JOIN tb_classroom c 
            ON r.classroom_id=c.classroom_id WHERE r.school_year=? AND s.course_id=? AND r.year_no=?";
            $query = $dbcon->prepare($sql);
            $query->execute(array($school_year,$course_id,$year_no));
        }else{
            $sql = "SELECT s.student_id,s.student_code,s.gender,ifnull(s.name_la,'')name_la,ifnull(s.name_en,'')name_en,ifnull(s.surname_la,'')surname_la,
            ifnull(s.surname_en,'')surname_en,s.start_year,s.end_year,s.course_id,s.current_year,s.student_status ,r.school_year,r.classroom_id,
            c.classroom_des,r.year_no,ifnull(date_of_birthday,'')date_of_birthday,ifnull(birth_address_la,'')birth_address_la,ifnull(birth_address_en,'')birth_address_en,remark 
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
    if(isset($_POST['student_log'])){
        require "../config.php";
        include_once("app_module.php");
        $data = json_decode(decode($_POST['student_log']));
        $student_code = $data->student_code;
        $sql = "SELECT `student_code`,`desc`,DATE_FORMAT(`issue_date`,'%d/%m/%Y %H:%i:%s')issue_date,`userparse` 
        FROM `tb_student_log` WHERE student_code=? ORDER BY issue_date ASC;";
        $query = $dbcon->prepare($sql);
            $query->execute(array($student_code));
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
    if(isset($_POST['new_student'])){
        require "../config.php";
        include_once("app_module.php");
        $data = json_decode(decode($_POST['new_student']));
        $student_code = preg_replace('/[^A-Za-z0-9\/]/', '',$data->student_code);
        $student_code = str_replace(" ","",strtoupper(trim($student_code," \n\r\t\v\x00")));
        $name_la = input_data($data->name_la);
        $surname_la = input_data($data->surname_la);
        $name_en = preg_replace('/[^A-Za-z0-9\-]/', '',$data->name_en);
        $surname_en = preg_replace('/[^A-Za-z0-9\-]/', '',$data->surname_en);
        $gender = input_data($data->gender);
        $address_la = input_data($data->address_la);
        $address_en = preg_replace('/[^A-Za-z0-9\-]/', '',$data->address_en);
        $birthdate = preg_replace('/[^A-Za-z0-9\-]/', '',$data->birthdate);
        $remark = input_data($data->remark);
        $course_id = preg_replace('/[^A-Za-z0-9\-]/', '',$data->course_id);
        $username = preg_replace('/[^A-Za-z0-9\-]/', '',$data->username);

        // check data
        $sql = "SELECT COUNT(*)'num',(SELECT s.duration_year FROM tb_course c INNER JOIN tb_scheme s ON c.scheme_id = s.scheme_id WHERE course_id=?)'duration_year' FROM tb_student WHERE student_code=? AND student_status!='DELETED';";
        $query = $dbcon->prepare($sql);
        $query->execute(array($course_id,$student_code));
        $query_data = $query->fetch(PDO::FETCH_ASSOC);
        $num = $query_data["num"];
        $duration_year = $query_data["duration_year"];
        if($num==0){
            //insert data here
            $start_year = date("Y");
            $end_year = date("Y")+ $duration_year;
            if($birthdate){
            $sql = "INSERT INTO tb_student(student_code, gender, name_la, name_en, surname_la, surname_en, date_of_birthday, birth_address_la, birth_address_en, start_year, end_year, course_id, remark) 
            VALUES (
                '".$student_code."',
                '".$gender."', 
                '".$name_la."', 
                '".$name_en."', 
                '".$surname_la."', 
                '".$surname_en."', 
                '".$birthdate."', 
                '".$address_la."', 
                '".$address_en."', 
                '".$start_year."', 
                '".$end_year."', 
                '".$course_id."', 
                '".$remark."');";
            }else{
                $sql = "INSERT INTO tb_student(student_code, gender, name_la, name_en, surname_la, surname_en, birth_address_la, birth_address_en, start_year, end_year, course_id, remark) 
                VALUES (
                '".$student_code."',
                '".$gender."', 
                '".$name_la."', 
                '".$name_en."', 
                '".$surname_la."', 
                '".$surname_en."', 
                '".$address_la."', 
                '".$address_en."', 
                '".$start_year."', 
                '".$end_year."', 
                '".$course_id."', 
                '".$remark."');";
            }
            $sql .="INSERT INTO `tb_student_log`(`student_code`, `desc`, `userparse`) VALUES ('".$student_code."', 'created', '".$username."');";
            for($i=0;$i < $duration_year; $i++){
                $school_year = (date("Y")+$i) . "-" . (date("Y") + ($i+1));
                $sql .="INSERT INTO `tb_student_register`(`student_code`, `school_year`, `year_no`, `create_date`, `user_update`)  
                VALUES ('".$student_code."','".$school_year."','".($i+1)."',now(),'".$username."');";
            }
            $query = $dbcon->prepare($sql);
            $query->execute();
            if($query){
                echo "Swal.fire({icon:'success',html:'<span class=notosans>ບັນທຶກຂໍ້ມູນສໍາເລັດ!</span>',allowOutsideClick: false}).then((result) => {if (result.isConfirmed) {window.location.href='template?page=student'}});";
            }else{
                echo "Swal.fire({icon:'error',html:'<span class=notosans>ບັນທຶກຂໍ້ມູນບໍ່ສໍາເລັດ<br>ເກີດຂໍ້ຜິດພາດລະຫວ່າງການບັນທຶກ!</span>'})";
            }
        

        }else{
            //duplicate data
            echo "Swal.fire({icon:'error',html:'<span class=notosans>ລະຫັດນັກສຶກສາຊໍ້າກັນ !</span>'})";
        }
    }
    if(isset($_POST['update_student'])){
        require "../config.php";
        include_once("app_module.php");
        $data = json_decode(decode($_POST['update_student']));
        $student_id = $data->student_id;
        $old_student_code = $data->old_student_code;
        $student_code = $data->student_code;
        $name_la = $data->name_la;
        $surname_la = $data->surname_la;
        $name_en = $data->name_en;
        $surname_en = $data->surname_en;
        $gender = $data->gender;
        $address_la = $data->address_la;
        $address_en = $data->address_en;
        $birthdate = $data->birthdate;
        $remark = $data->remark;
        $course_id = $data->course_id;
        $username = $data->username;
        // check data
        $sql = "SELECT COUNT(*)'num',(SELECT s.duration_year FROM tb_course c INNER JOIN tb_scheme s ON c.scheme_id = s.scheme_id WHERE course_id=?)'duration_year' FROM tb_student WHERE student_code=? AND student_id!=? AND student_status!='DELETED';";
        $query = $dbcon->prepare($sql);
        $query->execute(array($course_id,$student_code,$student_id));
        $query_data = $query->fetch(PDO::FETCH_ASSOC);
        $num = $query_data["num"];
        $duration_year = $query_data["duration_year"];

        if($num==0){
            //insert data here
            if($birthdate){
                $sql = "UPDATE `tb_student` SET 
                `student_code`='".$student_code."',
                `gender`='".$gender."',
                `name_la`='".$name_la."',
                `name_en`='".$name_en."',
                `surname_la`='".$surname_la."',
                `surname_en`='".$surname_en."',
                `date_of_birthday`='".$birthdate."',
                `birth_address_la`='".$address_la."',
                `birth_address_en`='".$address_en."',
                `remark`='".$remark."',
                `last_update`= NOW() WHERE `student_id`='".$student_id."';";
            }else{
                $sql = "UPDATE `tb_student` SET 
                `student_code`='".$student_code."',
                `gender`='".$gender."',
                `name_la`='".$name_la."',
                `name_en`='".$name_en."',
                `surname_la`='".$surname_la."',
                `surname_en`='".$surname_en."',
                `birth_address_la`='".$address_la."',
                `birth_address_en`='".$address_en."',
                `remark`='".$remark."',
                `last_update`= NOW() WHERE `student_id`='".$student_id."';";
            }
            $sql .="INSERT INTO `tb_student_log`(`student_code`, `desc`, `userparse`) VALUES ('".$student_code."', 'Update Info', '".$username."');
                    UPDATE tb_student_log SET student_code='".$student_code."' WHERE student_code = '".$old_student_code."';";
            $query = $dbcon->prepare($sql);
            $query->execute();
            if($query){
                echo "Swal.fire({icon:'success',html:'<span class=notosans>ບັນທຶກຂໍ້ມູນສໍາເລັດ!</span>',allowOutsideClick: false}).then((result) => {if (result.isConfirmed) {window.location.href='template?page=student'}});";
            }else{
                echo "Swal.fire({icon:'error',html:'<span class=notosans>ບັນທຶກຂໍ້ມູນບໍ່ສໍາເລັດ<br>ເກີດຂໍ້ຜິດພາດລະຫວ່າງການບັນທຶກ!</span>'})";
            }
        

        }else{
            //duplicate data
            echo "Swal.fire({icon:'error',html:'<span class=notosans>ລະຫັດນັກສຶກສາຊໍ້າກັນ !</span>'})";
        }

    }
    if(isset($_POST['upload_student_update'])){
        require "../config.php";
        include_once("app_module.php");
        $data_param = json_decode(decode($_POST['upload_student_update']));
        $username = preg_replace('/[^A-Za-z0-9\-]/', '', $data_param->username);
        $student_data = $data_param->data;
        $return_data = [];
        foreach($student_data as $student){
            // check data
            $student_code = preg_replace('/[^A-Za-z0-9\/]/', '',$student->student_code);
            $sql = "SELECT COUNT(*)'num' FROM tb_student WHERE student_code=? AND student_status!='DELETED'";
            $query = $dbcon->prepare($sql);
            $query->execute(array($student_code));
            $num = $query->fetch(PDO::FETCH_ASSOC)["num"];
            
            if($num!=0){
                $student_code = $student->student_code;
                $name_la = $student->name_la;
                $surname_la = $student->surname_la;
                $name_en = $student->name_en;
                $surname_en = $student->surname_en;
                $gender = $student->gender;
                $address_la = $student->address_la;
                $address_en = $student->address_en;
                $birthdate = $student->birthdate;
                $remark = $student->remark;
                $course_id = $student->course_id;
                if($birthdate){
                    $sql = "UPDATE `tb_student` SET 
                    `gender`='".$gender."',
                    `name_la`='".$name_la."',
                    `name_en`='".$name_en."',
                    `surname_la`='".$surname_la."',
                    `surname_en`='".$surname_en."',
                    `date_of_birthday`='".$birthdate."',
                    `birth_address_la`='".$address_la."',
                    `birth_address_en`='".$address_en."',
                    `remark`='".$remark."',
                    `last_update`= NOW() WHERE `student_code`='".$student_code."' AND student_status!='DELETED';";
                }else{
                    $sql = "UPDATE `tb_student` SET 
                    `gender`='".$gender."',
                    `name_la`='".$name_la."',
                    `name_en`='".$name_en."',
                    `surname_la`='".$surname_la."',
                    `surname_en`='".$surname_en."',
                    `birth_address_la`='".$address_la."',
                    `birth_address_en`='".$address_en."',
                    `remark`='".$remark."',
                    `last_update`= NOW() WHERE `student_code`='".$student_code."' AND student_status!='DELETED';";
                }
                $sql .="INSERT INTO `tb_student_log`(`student_code`, `desc`, `userparse`) VALUES ('".$student_code."', 'Update Info', '".$username."');";
                $query = $dbcon->prepare($sql);
                $query->execute();
                if($query){
                    $student = array_merge((array)$student,array("status"=>"success"));
                }else{
                    $student = array_merge((array)$student,array("status"=>"error !"));
                }
            }else{
                $student = array_merge((array)$student,array("status"=>"ລະຫັດນັກສຶກສາບໍ່ຖຶກຕ້ອງ"));
            }
            array_push($return_data,$student);
        }
        echo json_encode($return_data);
    }
    if(isset($_POST['delete_student'])){
        require "../config.php";
        include_once("app_module.php");
        $data_param = json_decode(decode($_POST['delete_student']));
        $username = $data_param->username;
        $student_code = $data_param->student_code;
        $log_desc = 'Deleted by '.$username;
        $sql = "DELETE FROM tb_student_register WHERE student_code='".$student_code."';";
        $sql .="UPDATE tb_student SET student_status='DELETED', last_update=NOW() WHERE student_code='".$student_code."';";
        $sql .="INSERT INTO tb_student_log(student_code, desc,userparse) VALUES ('".$student_code."','".$log_desc."','".$username."');";
        $query = $dbcon->prepare($sql);
        $query->execute();
        if($query){
            echo json_encode(array("success"=>true));
        }else{
            echo json_encode(array("success"=>false));
        }
    }
    function load_course(){
        require "config.php";
        $sql = "SELECT course_id,c.scheme_id,s.scheme_des,s.duration_year,course_des,class_pattern FROM tb_course c 
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
    function load_student_newstudent($course_id,$start_year){
        require "config.php";
        $sql="SELECT s.* FROM tb_student s INNER JOIN tb_student_register r ON s.student_code = r.student_code 
        WHERE r.year_no=1 and r.register_status=0 AND s.student_status!='DELETED' AND s.course_id = ? AND s.start_year = ?;";
        $query = $dbcon->prepare($sql);
        $query->execute(array($course_id,$start_year));
        return $query;
    }
?>