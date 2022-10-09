<?php
    date_default_timezone_set("Asia/Vientiane");
    function add_course($course_des,$class_pattern,$scheme_id){
        require "config.php";
        $sql = "SELECT * FROM tb_course WHERE course_des=? AND course_status = 1 AND scheme_id=?";
        $course= $dbcon->prepare($sql);
        $course->execute(array($course_des,$scheme_id));
        if($course->rowCount()==0){
            $sql = "INSERT INTO tb_course(course_des,class_pattern,scheme_id) VALUES (?,?,?)";
            $query = $dbcon->prepare($sql);
            $query->execute(array($course_des,$class_pattern,$scheme_id));
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
        }else{
            ?>
                <script>
                    Swal.fire('<span class=phetsarath>ຂໍ້ມູນຊໍ້າກັນ !</span>', '', 'warning')
                </script>
            <?php
        }
    }
    function load_course($filter){
        require "config.php";
        $sql = "SELECT `course_id`,c.`scheme_id`,s.scheme_des,s.duration_year,`course_des`,`class_pattern`,c.course_status FROM `tb_course` c 
        INNER JOIN tb_scheme s ON c.scheme_id = s.scheme_id WHERE s.scheme_status = 1 ".$filter;
        $query = $dbcon->prepare($sql);
        $query->execute();
        return $query;
    }
    function load_scheme(){
        require "config.php";
        $sql = "SELECT * FROM tb_scheme WHERE scheme_status=1";
        $query = $dbcon->prepare($sql);
        $query->execute();
        return $query;
    }
    function change_status($course_id,$status){
        require "config.php";
        $sql = "UPDATE tb_course SET course_status=? WHERE course_id=?";
        $query = $dbcon->prepare($sql);
        $query->execute(array($status,$course_id));
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
?>