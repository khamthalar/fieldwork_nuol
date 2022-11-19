<?php
    date_default_timezone_set("Asia/Vientiane");
    function load_course(){
        require "config.php";
        $sql = "SELECT `course_id`,c.`scheme_id`,s.scheme_des,s.duration_year,`course_des`,`class_pattern` FROM `tb_course` c 
        INNER JOIN tb_scheme s ON c.scheme_id = s.scheme_id WHERE c.course_status = 1 AND s.scheme_status = 1";
        $query = $dbcon->prepare($sql);
        $query->execute();
        return $query;
    }
    function load_class_data($course_id){
        require "config.php";
        $sql = "SELECT classroom_id, classroom_des, year_no, class_no, course_id, classroom_status, (SELECT count(*) FROM tb_student_register WHERE classroom_id = c.classroom_id)'std_count',
        (SELECT CONCAT('[', better_result, ']') AS best_result FROM
        (SELECT GROUP_CONCAT('{', student, '}' SEPARATOR ',') AS better_result,classroom_id FROM
        (SELECT CONCAT
            (
              '\"student_id\":\"', s.student_id, '\",', 
              '\"student_code\":\"', sr.student_code, '\",',
              '\"gender\":\"', s.gender,'\",',
              '\"name_la\":\"', s.name_la,'\",',
              '\"surname_la\":\"', s.surname_la,'\"' 
            ) AS student, sr.classroom_id
          FROM tb_student_register sr INNER JOIN tb_student s ON sr.student_code = s.student_code WHERE sr.year_no = 1 AND course_id = ?
          ) AS student_json GROUP BY classroom_id)AS js WHERE js.classroom_id = c.classroom_id) as std_data
          FROM tb_classroom c WHERE year_no=1 AND course_id = ?;";
        $query = $dbcon->prepare($sql);
        $query->execute(array($course_id,$course_id));
        return $query;
    }
?>