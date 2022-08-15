<?php
session_start();
include_once "db.php";
$msgId = mysqli_real_escape_string($db,$_POST['msgId']);
$emoji = mysqli_real_escape_string($db,$_POST['emoji']);
$sql = "UPDATE messages SET emoji = '$emoji' WHERE msg_id = '{$msgId}'";
mysqli_query($db,$sql);
?>