<?php
session_start();
if (isset($_SESSION['uid'])) {
    include_once "db.php";

    $incoming_id = mysqli_real_escape_string($db, $_POST['incoming_id']);
    $outgoing_id = mysqli_real_escape_string($db, $_POST['outgoing_id']);

    $sql = mysqli_query($db, "SELECT * FROM messages LEFT JOIN users ON messages.outgoing_id = users.uid WHERE (incoming_id = '{$incoming_id}' AND outgoing_id = '{$outgoing_id}') OR (outgoing_id = '{$incoming_id}' AND incoming_id = '{$outgoing_id}') ORDER BY msg_id DESC LIMIT 1");
    $output = "";
    if (mysqli_num_rows($sql) > 0) {
        $row = mysqli_fetch_assoc($sql);
        $sql3 = mysqli_query($db, "SELECT * FROM users WHERE uid = '{$_SESSION['uid']}'");
        $row2 = mysqli_fetch_assoc($sql3);
        if($outgoing_id != $row['outgoing_id'] && $row2['status'] != "Active Now" && $row['notify'] != "yes"){
            $name = $row['fname']." ".$row['lname'];
            $arr = array($row['msg_id'],$row['message'],$name,$row['img'],$row['type']);
            print json_encode($arr);
            mysqli_query($db,"UPDATE messages SET notify = 'yes' WHERE msg_id = '{$row['msg_id']}'");
        }else if($outgoing_id != $row['outgoing_id'] && $row2['status'] == "Active Now" && $row['notify'] != "yes"){
            mysqli_query($db,"UPDATE messages SET notify = 'yes' WHERE msg_id = '{$row['msg_id']}'");
        }
    }
}
?>