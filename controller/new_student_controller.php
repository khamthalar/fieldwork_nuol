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
    function get_course_data($course_id){
        require "config.php";
        $sql = "SELECT c.course_des,s.scheme_des,s.duration_year,s.scheme_id FROM tb_course c INNER JOIN tb_scheme s 
        ON c.scheme_id = s.scheme_id WHERE course_id = ?;";
        $query = $dbcon->prepare($sql);
        $query->execute(array($course_id));
        return $query;
    }
?>