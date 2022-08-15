<?php
    session_start();
    if(isset($_SESSION['uid'])){
        include_once "db.php";
        date_default_timezone_set("Asia/Dhaka");
        $time = date("m/d/Y, h:i:s a");
        $sql = mysqli_query($db,"UPDATE users SET status = '{$time}' WHERE uid='{$_SESSION['uid']}'");
        if($sql){
            session_unset();
            session_destroy();
            header("location: ../login.php");
        }
    }else{
        header("location: ../login.php");
    }
?>