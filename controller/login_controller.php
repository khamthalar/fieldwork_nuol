<?php
    date_default_timezone_set("Asia/Vientiane");
    include_once 'main_controller.php';
    if(!empty($_GET['func'])){
        if($_GET['func'] == 'login'){
            login();
        }
    }
    function login(){
        $user_type = 1;
        if(isset($_POST['login'])){
            $login_success = false;
            require "../config.php";
            $username = $_POST['username'];
            $password = $_POST['password'];
            $sql = "select * from users where status = 1 and username = ?";
            $query = $dbcon->prepare($sql);
            $query->execute(array($username));
            if($query->rowCount()==0){
                $data = array(
                    "error"=>true,
                    "message" => "ບໍ່ພົບຜູ້ໃຊ້ $username !",
                    "username" => $username,
                    "password" => $password
                );
                redirect('../login',$data);
            }else{
                while ($row = $query->fetch(PDO::FETCH_ASSOC)){
                    if(password_verify($password,$row['password'])){
                        if($row['user_type']==1){
                            $token_key = "user_".md5(time());
                            $login_success = true;
                            $file = "../assets/json/app.json";
                            $token = json_decode(file_get_contents($file),true);
                            $token = array_merge($token,array(getMachineID()=>$token_key));
                            // file_put_contents($file, json_encode(array('user_token_key'=>$token_key),true));
                            file_put_contents($file, json_encode($token,true));
                            $_SESSION[$token_key] = $row;
                        }else{
                            $login_success = true;
                            $user_type = 2;
                            $_SESSION['user_login'] = $row;
                            // echo "<script>console.log('test');window.location.href = '/main'</script>";
                            // header("location:../main");
                        }
                    }
                }
                if(!$login_success){
                    $data = array(
                        "error"=>true,
                        "message" => "ລະຫັດຜ່ານບໍ່ຖືກຕ້ອງ !",
                        "username" => $username,
                        "password" => $password
                    );
                    redirect('../login',$data);
                }else{
                    if($user_type==1){
                        header("location:../template?page=home");
                    }else{
                        header("location:../main");
                    }
                }
            }
            
        }
    }
?>