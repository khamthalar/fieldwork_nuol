<?php
    date_default_timezone_set("Asia/Vientiane");
    if(isset($_POST['student_data'])){
      require "../config.php";
      include_once("app_module.php");
      $student_data = json_decode(decode($_POST['student_data']));
      $course_id = $student_data->course_id;
      $school_year = $student_data->school_year;
      $sql = "SELECT register_id,s.student_id,s.gender,s.name_la,s.surname_la, sr.student_code,s.course_id, school_year, year_no, classroom_id, create_date, last_update, user_update, register_status, (SELECT CONCAT('[', json_child, ']') AS classroom_json_str FROM(
      SELECT GROUP_CONCAT('{', classroom_data, '}' SEPARATOR ',') AS json_child,course_id FROM
      (SELECT CONCAT(
              '\"classroom_id\":\"', c.classroom_id, '\",', 
              '\"classroom_des\":\"', c.classroom_des, '\",',
              '\"class_no\":\"', c.class_no,'\"'
            ) AS classroom_data,course_id FROM tb_classroom c WHERE year_no=1 AND classroom_status = 1) AS classroom_json GROUP BY course_id) AS classroom_json_final WHERE classroom_json_final.course_id = s.course_id) 'class_data'
      FROM tb_student_register sr INNER JOIN tb_student s ON sr.student_code = s.student_code WHERE sr.school_year=? AND year_no = 1 AND s.course_id=?;";
      $query = $dbcon->prepare($sql);
      $query->execute(array($school_year,$course_id));
      $result = $query->fetchAll(PDO::FETCH_ASSOC);
      if($result){
        $response_data=[
          "success"=>true,
          "body"=>$result
        ];
        echo json_encode($response_data);
      }else{
        $response_data = [
          "success"=>false,
          "body"=>[]
        ];
        echo json_encode($response_data);
      }
    }
    if(isset($_POST["classroom_data"])){
      require "../config.php";
      include_once("app_module.php");
      $param = json_decode(decode($_POST['classroom_data']));
      $course_id = $param->course_id;
      $sql = "SELECT * FROM tb_classroom WHERE course_id = ? AND year_no = 1 AND classroom_status = 1;";
      $query = $dbcon->prepare($sql);
      $query->execute(array($course_id));
      $result = $query->fetchAll(PDO::FETCH_ASSOC);
      if($result){
        $response_data=[
          "success"=>true,
          "body"=>$result
        ];
        echo json_encode($response_data);
      }else{
        $response_data = [
          "success"=>false,
          "body"=>[]
        ];
        echo json_encode($response_data);
      }
    }
    function load_course(){
        require "config.php";
        $sql = "SELECT `course_id`,c.`scheme_id`,s.scheme_des,s.duration_year,`course_des`,`class_pattern` FROM `tb_course` c 
        INNER JOIN tb_scheme s ON c.scheme_id = s.scheme_id WHERE c.course_status = 1 AND s.scheme_status = 1";
        $query = $dbcon->prepare($sql);
        $query->execute();
        return $query;
    }
    if(isset($_POST["setClassroomData"])){
      require "../config.php";
      include_once("app_module.php");
      $data = json_decode(decode($_POST['setClassroomData']));
      $student_data = $data->student_data;
      $class_no = $data->class_no;
      $sql = "SELECT*from tb_student_register WHERE student_code = ?";
      $query = $dbcon->prepare($sql);
      $query->execute(array($student_data->student_code));
      if($query){
        $register_data = $query->fetchAll(PDO::FETCH_ASSOC);
        $dbcon->beginTransaction();
        try{
          foreach($register_data as $item){
            $sql = "UPDATE tb_student_register SET last_update = now() ,classroom_id=(SELECT classroom_id FROM tb_classroom WHERE classroom_des = 
            (SELECT REPLACE(REPLACE(class_pattern,'[year_no]','".$item['year_no']."'),'[class_no]','".$class_no."') 
            FROM tb_course WHERE course_id='".$student_data->course_id."')), classroom_des=(SELECT REPLACE(REPLACE(class_pattern,
            '[year_no]','".$item['year_no']."'),'[class_no]','".$class_no."') FROM tb_course WHERE course_id='".$student_data->course_id."') 
            WHERE student_code='".$student_data->student_code."' AND year_no=".$item['year_no'].";";
            $query = $dbcon->prepare($sql);
            $query->execute();
          }
          $dbcon->commit();
          $response = [
            "success"=>true,
            "message"=>"update data success"
          ];
        }catch (PDOException $e){
          $dbcon->rollBack();
          $response = [
            "success"=>false,
            "message"=>"Internal Server Error"
          ];
        }
      }else{
        //error: can not found student data
        $response = [
          "success"=>false,
          "message"=>"Data not found"
        ];
      }
      echo json_encode($response);
    }
    // function load_class_data($course_id){
    //     require "config.php";
    //     $sql = "SELECT classroom_id, classroom_des, year_no, class_no, course_id, classroom_status, (SELECT count(*) FROM tb_student_register WHERE classroom_id = c.classroom_id)'std_count',
    //     (SELECT CONCAT('[', better_result, ']') AS best_result FROM
    //     (SELECT GROUP_CONCAT('{', student, '}' SEPARATOR ',') AS better_result,classroom_id FROM
    //     (SELECT CONCAT
    //         (
    //           '\"student_id\":\"', s.student_id, '\",', 
    //           '\"student_code\":\"', sr.student_code, '\",',
    //           '\"gender\":\"', s.gender,'\",',
    //           '\"name_la\":\"', s.name_la,'\",',
    //           '\"surname_la\":\"', s.surname_la,'\"' 
    //         ) AS student, sr.classroom_id
    //       FROM tb_student_register sr INNER JOIN tb_student s ON sr.student_code = s.student_code WHERE sr.year_no = 1 AND course_id = ?
    //       ) AS student_json GROUP BY classroom_id)AS js WHERE js.classroom_id = c.classroom_id) as std_data
    //       FROM tb_classroom c WHERE year_no=1 AND course_id = ?;";
    //     $query = $dbcon->prepare($sql);
    //     $query->execute(array($course_id,$course_id));
    //     return $query;
    // }
    // function load_student($course_id,$school_year){
    //   require "config.php";
    //   $sql = "SELECT register_id,s.student_id,s.gender,s.name_la,s.surname_la, sr.student_code,s.course_id, school_year, year_no, classroom_id, create_date, last_update, user_update, register_status, (SELECT CONCAT('[', json_child, ']') AS classroom_json_str FROM(
    //     SELECT GROUP_CONCAT('{', classroom_data, '}' SEPARATOR ',') AS json_child,course_id FROM
    //     (SELECT CONCAT(
    //           '\"classroom_id\":\"', c.classroom_id, '\",', 
    //           '\"classroom_des\":\"', c.classroom_des, '\",',
    //           '\"class_no\":\"', c.class_no,'\"'
    //         ) AS classroom_data,course_id FROM tb_classroom c WHERE year_no=1 AND classroom_status = 1) AS classroom_json GROUP BY course_id) AS classroom_json_final WHERE classroom_json_final.course_id = s.course_id) 'class_data'
    //     FROM tb_student_register sr INNER JOIN tb_student s ON sr.student_code = s.student_code WHERE sr.school_year=? AND year_no = 1 AND s.course_id=?;";
    //     $query = $dbcon->prepare($sql);
    //     $query->execute(array($school_year,$course_id));
    //     return $query;
    // }
?>