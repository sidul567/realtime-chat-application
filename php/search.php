<?php
    include_once "db.php";
    session_start();
    $searchValue = mysqli_real_escape_string($db,$_POST['searchValue']);
    $sql = mysqli_query($db,"SELECT * FROM users WHERE uid != '{$_SESSION['uid']}' AND (fname LIKE '%{$searchValue}%' OR lname LIKE '%{$searchValue}%') ");
    $user = "";
    if(mysqli_num_rows($sql) == 0){
        echo "Not found any user.";
    }else{
        include_once "userData.php" ;
    }
    echo $user;
?>