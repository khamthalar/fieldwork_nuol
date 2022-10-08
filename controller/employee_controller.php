<?php
    date_default_timezone_set("Asia/Vientiane");
    if(isset($_POST['new_employee'])){
        require "../config.php";
        include_once("app_module.php");
        date_default_timezone_set("Asia/Vientiane");
        $emp_data = json_decode(decode($_POST['new_employee']));
        $fullname = input_data($emp_data->fullname);
        $gender = input_data($emp_data->gender);
        $user_group_id = input_data($emp_data->user_group_id);
        $username = $emp_data->username;
        $password = password_hash($emp_data->password,PASSWORD_DEFAULT);
        $phone_number = ($emp_data->phone_number=="")?null:input_data($emp_data->phone_number);
        $sql = "SELECT CASE WHEN (SELECT COUNT(*) FROM tb_user WHERE fullname=?)=1 THEN 'ຊື່ພະນັກງານຊໍ້າກັນ' 
                WHEN (SELECT COUNT(*) FROM tb_user WHERE username=?)=1 THEN 'ຊື່ເຂົ້າໃຊ້ລະບົບຊໍ້າກັນ' 
                ELSE FALSE END AS result";
        $return_data = $dbcon->prepare($sql);
        $return_data->execute(array($fullname,$username));
        $result = $return_data->fetch(PDO::FETCH_ASSOC)['result'];
        if(!$result){
            $sql = "INSERT INTO tb_user(fullname, gender, phone_number, user_group_id, username, password) VALUES (?,?,?,?,?,?)";
            $query = $dbcon->prepare($sql);
            $query->execute(array($fullname,$gender,$phone_number,$user_group_id,$username,$password));
            if($query){
                echo "Swal.fire({icon:'success',html:'<span class=phetsarath>ບັນທຶກຂໍ້ມູນສໍາເລັດ!</span>',allowOutsideClick: false}).then((result) => {if (result.isConfirmed) {window.location.href='template?page=employee'}});";
            }else{
                echo "Swal.fire({icon:'error',html:'<span class=phetsarath>ບັນທຶກຂໍ້ມູນບໍ່ສໍາເລັດ<br>ເກີດຂໍ້ຜິດພາດລະຫວ່າງການບັນທຶກ!</span>'})";
            }
        }else{
            echo "Swal.fire({icon:'error',html:'<span class=phetsarath>".$result."!</span>'})";
        }
    }
    if(isset($_POST['update_employee'])){
        require "../config.php";
        include_once("app_module.php");
        date_default_timezone_set("Asia/Vientiane");
        $emp_data = json_decode(decode($_POST['update_employee']));
        $emp_id = $emp_data->emp_id;
        $fullname = input_data($emp_data->fullname);
        $gender = input_data($emp_data->gender);
        $user_group_id = input_data($emp_data->user_group_id);
        $username = $emp_data->username;
        // $password = password_hash($emp_data->password,PASSWORD_DEFAULT);
        $phone_number = ($emp_data->phone_number=="")?null:input_data($emp_data->phone_number);


        $password = $emp_data->password;
        $password_hash = password_hash($emp_data->password,PASSWORD_DEFAULT);
        $sql = "SELECT CASE WHEN (SELECT COUNT(*) FROM tb_user WHERE fullname=? AND user_id!=?)=1 THEN 'ຊື່ພະນັກງານຊໍ້າກັນ' 
        WHEN (SELECT COUNT(*) FROM tb_user WHERE username=? AND user_id!=?)=1 THEN 'ຊື່ເຂົ້າໃຊ້ລະບົບຊໍ້າກັນ' 
        ELSE FALSE END AS result";
        $return_data = $dbcon->prepare($sql);
        $return_data->execute(array($fullname,$emp_id,$username,$emp_id));
        $result = $return_data->fetch(PDO::FETCH_ASSOC)['result'];

        if(!$result){
            if($password==""||$password=="nuolpwd"){
                $sql = "UPDATE tb_user SET fullname=?,gender=?,phone_number=?,username=?,user_group_id=? WHERE user_id=?";
                $query = $dbcon->prepare($sql);
                $query->execute(array($fullname,$gender,$phone_number,$username,$user_group_id,$emp_id));
                if($query){
                    echo "Swal.fire({icon:'success',html:'<span class=phetsarath>ບັນທຶກຂໍ້ມູນສໍາເລັດ!</span>',allowOutsideClick: false}).then((result) => {if (result.isConfirmed) {window.location.href='template?page=employee'}});";
                }else{
                    echo "Swal.fire({icon:'error',html:'<span class=phetsarath>ບັນທຶກຂໍ້ມູນບໍ່ສໍາເລັດ<br>ເກີດຂໍ້ຜິດພາດລະຫວ່າງການບັນທຶກ!</span>'})";
                }
            }else{
                $sql = "UPDATE tb_user SET fullname=?,gender=?,phone_number=?,username=?,user_group_id=?,password=? WHERE user_id=?";
                $query = $dbcon->prepare($sql);
                $query->execute(array($fullname,$gender,$phone_number,$username,$user_group_id,$password_hash,$emp_id));
                if($query){
                    echo "Swal.fire({icon:'success',html:'<span class=phetsarath>ບັນທຶກຂໍ້ມູນສໍາເລັດ!</span>',allowOutsideClick: false}).then((result) => {if (result.isConfirmed) {window.location.href='template?page=employee'}});";
                }else{
                    echo "Swal.fire({icon:'error',html:'<span class=phetsarath>ບັນທຶກຂໍ້ມູນບໍ່ສໍາເລັດ<br>ເກີດຂໍ້ຜິດພາດລະຫວ່າງການບັນທຶກ!</span>'})";
                }
            }
        }else{
            echo "Swal.fire({icon:'error',html:'<span class=phetsarath>".$result."!</span>'})";
        }
    }
    function update_pwd($user_id,$password){
        require "config.php";
        $password = password_hash($password,PASSWORD_DEFAULT);
        $sql = "UPDATE tb_user SET password=? WHERE user_id = ?";
        $query = $dbcon->prepare($sql);
        $query->execute(array($password,$user_id));
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
    function load_department(){
        require "config.php";
        include_once("controller/app_module.php");
        $sql = "SELECT*FROM departments WHERE dep_status = 1";
        $query = $dbcon->prepare($sql);
        $query->execute();
        return $query;
    }
    function del_emp($emp_id){
        require "config.php";
        include_once("controller/app_module.php");
        $emp_id = input_data($emp_id);
        $sql = "UPDATE tb_user SET user_status = 0 WHERE user_id=$emp_id";
        $query = $dbcon->exec($sql);
        if($query){
            ?>
                <script>
                    Swal.fire('<span class=phetsarath>ລຶບຂໍ້ມູນສໍາເລັດ!</span>', '', 'success')
                </script>
            <?php
        }else{
            ?>
                <script>
                    Swal.fire('<span class=phetsarath>ເກີດຂໍ້ຜິດພາດລະຫວ່າງການລຶບຂໍ້ມູນ!</span>', '', 'error')
                </script>
            <?php    
        }
    }
    function load_employee(){
        require "config.php";
        $sql = "SELECT * FROM tb_user WHERE user_status = 1";
        $query = $dbcon->prepare($sql);
        $query->execute();
        return $query;
        
    }
    function set_user_group($user_id,$user_group_id){
        require "config.php";
        $sql = "UPDATE tb_user SET user_group_id = ? WHERE user_id = ?";
        $query = $dbcon->prepare($sql);
        $query->execute(array($user_group_id,$user_id));
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
    function get_emp_by_id($emp_id){
        require "config.php";
        $sql = "SELECT * FROM tb_user WHERE user_id = ?";
        $query = $dbcon->prepare($sql);
        $query->execute(array($emp_id));
        return $query;
    }
    function get_user_group(){
        require "config.php";
        $sql = "SELECT*FROM tb_user_group WHERE user_group_status=1";
        $query = $dbcon->prepare($sql);
        $query->execute();
        return $query;
    }
?>