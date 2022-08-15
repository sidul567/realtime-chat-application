<?php
include_once "db.php";
$uid = mysqli_real_escape_string($db, $_POST['fid']);
$sql = mysqli_query($db, "SELECT * FROM users WHERE uid='{$uid}'");
if (mysqli_num_rows($sql) > 0) {
    $row = mysqli_fetch_assoc($sql);
    echo $row['status'];
}
?>