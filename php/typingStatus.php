<?php
include_once "db.php";
$type_from = mysqli_real_escape_string($db, $_POST['outgoing_id']);
$type_to = mysqli_real_escape_string($db, $_POST['incoming_id']);
$sql = mysqli_query($db, "SELECT * FROM typing WHERE type_to='{$type_from}' AND type_from='{$type_to}'");
if (mysqli_num_rows($sql) > 0) {
    $row = mysqli_fetch_assoc($sql);
    if($row['type'] == "true"){
        echo "active";
    }else{
        echo "inactive";
    }
}else{
    echo "inactive";
}
?>