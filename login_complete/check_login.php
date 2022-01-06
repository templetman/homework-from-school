<?php 
#Create Session
    session_start();
#Connection
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "ecommerce";
    $connect = mysqli_connect($host,$username,$password,$database);
    #Check Connection
    if (!$connect) {
        die("การเชื่อมต่อผิดพลาด: <br>" . mysqli_connect_error());
    }
#Recived Username & Password from login.php
    $login_user = $_POST['log_username'];
    $login_pass = md5($_POST['log_password']); #encrypt with MD5
#Query Database
    $table = "SELECT * FROM users WHERE user_name = '".$login_user."' and user_password = '".$login_pass."'";
    $query = mysqli_query($connect,$table);
#Check Username & Password
    if (mysqli_num_rows($query)==1) {
        #Fetch data from database
        $row = mysqli_fetch_array($query);
        #Create Session
        $_SESSION["id"] = $row["user_id"];
        $_SESSION["username"] = $row["user_name"];
        $_SESSION["role"] = $row["user_roles"];
        
        #Check User's Role
        if ($_SESSION["role"]=="5") {
            header("Location: member.php");
        }
        if ($_SESSION["role"]=="99") {
            header("Location: admin.php");
        }
    }else {
        echo "<script>";
            echo "alert(\"ชื่อผู้ใช้งาน หรือ รหัสผ่าน ไม่ถูกต้อง\");";
            echo "history.back()";
        echo "</script>";
    }
#Connection Closed
    mysqli_close($connect);
?>