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
?>