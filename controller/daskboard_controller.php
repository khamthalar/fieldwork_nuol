<?php
    function load_data(){
        require "config.php";
        $sql = "SELECT 
        (SELECT COUNT(*) FROM tb_classroom WHERE year_no=1 AND classroom_status=1)'classroom',
        (SELECT COUNT(*) FROM tb_course WHERE course_status=1)'course',
        (SELECT COUNT(*) FROM tb_student WHERE YEAR(NOW()) BETWEEN start_year AND end_year AND (student_status IN ('ACTIVE','DROPPED')))'student',
        (SELECT COUNT(*) FROM tb_user WHERE user_status=1)'user'
        FROM DUAL;";
        $query = $dbcon->prepare($sql);
        $query->execute();
        return $query;
    }
?>
