<?php
session_start();
include_once "db.php";
$update = mysqli_real_escape_string($db,$_POST['update']);
$sql = "UPDATE users SET status = '$update' WHERE uid = '{$_SESSION['uid']}'";
mysqli_query($db,$sql);
?>