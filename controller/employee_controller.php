<?php
    date_default_timezone_set("Asia/Vientiane");
    if(isset($_POST['new_employee'])){
        require "../config.php";
        include_once("app_module.php");
        date_default_timezone_set("Asia/Vientiane");
        $emp_data = json_decode(decode($_POST['new_employee']));
        $fullname = input_data($emp_data->fullname);
        $gender = input_data($emp_data->gender);
        $dep_id = input_data($emp_data->dep_id);
        $username = $emp_data->username;
        $password = password_hash($emp_data->password,true);
        $address = ($emp_data->address=="")?null:input_data($emp_data->address);
        $tel = ($emp_data->tel=="")?null:input_data($emp_data->tel);
        $user_type = input_data($emp_data->user_type);
        $date_of_birth = ($emp_data->date_of_birth=="")?null:input_data($emp_data->date_of_birth);
        $sql = "INSERT INTO users (fullname, gender, date_of_birth, address, tel, dep_id, username, password, user_type, status)
        VALUES(?,?,?,?,?,?,?,?,?,?)";
        $query = $dbcon->prepare($sql);
        $query->execute(array($fullname,$gender,$date_of_birth,$address,$tel,$dep_id,$username,$password,$user_type,1));
        if($query){
            echo "Swal.fire({icon:'success',html:'<span class=phetsarath>ບັນທຶກຂໍ້ມູນສໍາເລັດ!</span>',allowOutsideClick: false}).then((result) => {if (result.isConfirmed) {window.location.href='template?page=employee'}});";
        }else{
            echo "Swal.fire({icon:'error',html:'<span class=phetsarath>ບັນທຶກຂໍ້ມູນບໍ່ສໍາເລັດ<br>ເກີດຂໍ້ຜິດພາດລະຫວ່າງການບັນທຶກ!</span>'})";
        }
    }
    if(isset($_POST['update_employee'])){
        require "../config.php";
        include_once("app_module.php");
        date_default_timezone_set("Asia/Vientiane");
        $emp_data = json_decode(decode($_POST['update_employee']));
        $id = input_data($emp_data->emp_id);
        $fullname = input_data($emp_data->fullname);
        $gender = input_data($emp_data->gender);
        $dep_id = input_data($emp_data->dep_id);
        $dep_id_param = input_data($emp_data->dep_id_param);
        $username = $emp_data->username;
        $password = $emp_data->password;
        $password_hash = password_hash($emp_data->password,true);
        $address = ($emp_data->address=="")?null:input_data($emp_data->address);
        $tel = ($emp_data->tel=="")?null:input_data($emp_data->tel);
        $user_type = input_data($emp_data->user_type);
        $date_of_birth = ($emp_data->date_of_birth=="")?null:input_data($emp_data->date_of_birth);
        if($password==""||$password=="edlquiz"){
            $sql = "UPDATE users SET fullname=?,gender=?,date_of_birth=?,address=?,tel=?,dep_id=?,username=?,user_type=? WHERE id=?";
            $query = $dbcon->prepare($sql);
            $query->execute(array($fullname,$gender,$date_of_birth,$address,$tel,$dep_id,$username,$user_type,$id));
            if($query){
                echo "Swal.fire({icon:'success',html:'<span class=phetsarath>ບັນທຶກຂໍ້ມູນສໍາເລັດ!</span>',allowOutsideClick: false}).then((result) => {if (result.isConfirmed) {window.location.href='template?page=employee$dep_id_param'}});";
            }else{
                echo "Swal.fire({icon:'error',html:'<span class=phetsarath>ບັນທຶກຂໍ້ມູນບໍ່ສໍາເລັດ<br>ເກີດຂໍ້ຜິດພາດລະຫວ່າງການບັນທຶກ!</span>'})";
            }
        }else{
            $sql = "UPDATE users SET fullname=?,gender=?,date_of_birth=?,address=?,tel=?,dep_id=?,username=?,password=?,user_type=? WHERE id=?";
            $query = $dbcon->prepare($sql);
            $query->execute(array($fullname,$gender,$date_of_birth,$address,$tel,$dep_id,$username,$password_hash,$user_type,$id));
            if($query){
                echo "Swal.fire({icon:'success',html:'<span class=phetsarath>ບັນທຶກຂໍ້ມູນສໍາເລັດ!</span>',allowOutsideClick: false}).then((result) => {if (result.isConfirmed) {window.location.href='template?page=employee$dep_id_param'}});";
            }else{
                echo "Swal.fire({icon:'error',html:'<span class=phetsarath>ບັນທຶກຂໍ້ມູນບໍ່ສໍາເລັດ<br>ເກີດຂໍ້ຜິດພາດລະຫວ່າງການບັນທຶກ!</span>'})";
            }
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
        $sql = "UPDATE users SET status = 0 WHERE id=$emp_id";
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
    function load_employee($dep_id){
        require "config.php";
        if($dep_id==0){
            $sql = "SELECT u.id,fullname,gender,date_of_birth,TRUNCATE((DATEDIFF(NOW(),date_of_birth)/365),0) 'age',tel,address,u.dep_id,d.dep_name,username,user_type
            FROM users u INNER JOIN departments d ON u.dep_id = d.dep_id WHERE u.status = 1 ORDER BY u.dep_id";
            $query = $dbcon->prepare($sql);
            $query->execute();
            return $query;
        }else{
            $sql = "SELECT u.id,fullname,gender,date_of_birth,TRUNCATE((DATEDIFF(NOW(),date_of_birth)/365),0) 'age',tel,address,u.dep_id,d.dep_name,username,user_type
            FROM users u INNER JOIN departments d ON u.dep_id = d.dep_id WHERE u.status = 1 AND u.dep_id = ? ORDER BY u.dep_id";
            $query = $dbcon->prepare($sql);
            $query->execute(array($dep_id));
            return $query;
        }
        
    }
    function get_emp_by_id($emp_id){
        require "config.php";
        $sql = "SELECT * FROM users WHERE id = ?";
        $query = $dbcon->prepare($sql);
        $query->execute(array($emp_id));
        return $query;
    }
?>