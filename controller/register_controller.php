<?php
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