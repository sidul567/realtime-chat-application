<?php
    session_start();
    include_once "db.php";

    $email = mysqli_real_escape_string($db,$_POST['email']);
    $password = mysqli_real_escape_string($db,md5($_POST['password']));

    if(!empty($email) && !empty($password)){
        $sql = mysqli_query($db,"SELECT * FROM users WHERE email='$email' AND password='$password'");

        if(mysqli_num_rows($sql) > 0){
            $row = mysqli_fetch_assoc($sql);
            $_SESSION['uid'] = $row['uid'];
            $sql = mysqli_query($db,"UPDATE users SET status = 'Active Now' WHERE uid='{$row['uid']}'");
            echo "success";
        }else{
            echo "Wrong email or password!";
        }
    }else{
        echo "All input fields must be filled up!";
    }

?>