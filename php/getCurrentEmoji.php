<?php
session_start();
include_once "db.php";
$msgId = mysqli_real_escape_string($db,$_POST['msgId']);
$sql = mysqli_query($db,"SELECT emoji FROM messages WHERE msg_id = '{$msgId}'");
$row = mysqli_fetch_assoc($sql);
echo $row['emoji'];
?>