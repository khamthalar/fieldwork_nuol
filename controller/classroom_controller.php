<?php
    date_default_timezone_set("Asia/Vientiane");
    function add_new_classroom($course_id,$full_classroom_des,$year_no){
        require "config.php";
        $sql = "INSERT INTO `tb_classroom`(`classroom_des`, `year_no`, `course_id`) VALUES ";
        for ($i=1; $i <= $year_no; $i++) { 
            $classroom_des = str_replace('[year_no]',$i,$full_classroom_des);
            $sql .="('".$classroom_des."','".$i."','".$course_id."'),";
        }
        $sql = substr($sql,0,(strlen($sql)-1)).";";
        $query = $dbcon->prepare($sql);
        $query->execute();
        if($query){
            ?>
                <script>
                    Swal.fire('<span class=phetsarath>ບັນທຶກສໍາເລັດ!</span>', '', 'success')
                </script>
            <?php
        }else{
            ?>
                <script>
                    Swal.fire('<span class=phetsarath>ບັນທຶກຂໍ້ມູນບໍ່ສໍາເລັດ<br>ເກີດຂໍ້ຜິດພາດລະຫວ່າງການບັນທຶກ!</span>', '', 'error')
                </script>
            <?php 
        }
    }
    function change_classroom_status($classroom_id,$current_status){
        require "config.php";
        $classroom_status = ($current_status==1)?0:1;
        $sql = "UPDATE tb_classroom SET classroom_status=? WHERE classroom_id=?";
        $query = $dbcon->prepare($sql);
        $query->execute(array($classroom_status,$classroom_id));
        if($query){
            ?>
                <script>
                    Swal.fire('<span class=phetsarath>ບັນທຶກສໍາເລັດ!</span>', '', 'success')
                </script>
            <?php
        }else{
            ?>
                <script>
                    Swal.fire('<span class=phetsarath>ບັນທຶກຂໍ້ມູນບໍ່ສໍາເລັດ<br>ເກີດຂໍ້ຜິດພາດລະຫວ່າງການບັນທຶກ!</span>', '', 'error')
                </script>
            <?php 
        }
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