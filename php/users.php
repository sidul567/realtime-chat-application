<?php
    include_once "db.php";
    session_start();
    $sql = mysqli_query($db,"SELECT * FROM users WHERE uid != '{$_SESSION['uid']}'");
    $user = "";
    if(mysqli_num_rows($sql) == 0){
        echo "No users are available now.";
    }else{
        include_once "userData.php" ;
    }
    echo $user;
?>