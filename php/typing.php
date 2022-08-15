<?php
include_once "db.php";
$type_from = mysqli_real_escape_string($db, $_POST['outgoing_id']);
$type_to = mysqli_real_escape_string($db, $_POST['incoming_id']);
$type = mysqli_real_escape_string($db, $_POST['type']);
$sql = mysqli_query($db, "SELECT * FROM typing WHERE type_from='{$type_from}' AND type_to='{$type_to}'");
if (mysqli_num_rows($sql) > 0) {
    $sql2 = mysqli_query($db, "UPDATE typing SET type='${type}' WHERE type_from='{$type_from}' AND type_to='{$type_to}'");
}else{
    $sql2 = mysqli_query($db, "INSERT INTO typing(type_from,type_to,type) VALUES('{$type_from}', '{$type_to}', '{$type}')");
}
?>