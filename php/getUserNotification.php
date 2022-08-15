<?php
include_once "db.php";
session_start();
$sql = mysqli_query($db, "SELECT * FROM users WHERE uid != '{$_SESSION['uid']}'");
$sql3 = mysqli_query($db, "SELECT * FROM users WHERE uid = '{$_SESSION['uid']}'");
$row3 = mysqli_fetch_assoc($sql3);
$user = "";
if (mysqli_num_rows($sql) != 0) {
    while ($row = mysqli_fetch_assoc($sql)) {
        $sql2 = mysqli_query($db, "SELECT * FROM messages WHERE (incoming_id = '{$row['uid']}' AND outgoing_id = '{$_SESSION['uid']}') OR (outgoing_id = '{$row['uid']}' AND incoming_id = '{$_SESSION['uid']}') ORDER BY msg_id DESC LIMIT 1");
        if (mysqli_num_rows($sql2) > 0) {
            $row2 = mysqli_fetch_assoc($sql2);
            if ($row2['outgoing_id'] != $_SESSION['uid'] && $row3['status'] != "Active Now" && $row2['notify'] != "yes") {
                $name = $row['fname'] . " " . $row['lname'];
                $arr = array($row2['msg_id'], $row2['message'], $name, $row['img'],$row2['type']);
                print json_encode($arr);
                mysqli_query($db,"UPDATE messages SET notify = 'yes' WHERE msg_id = '{$row2['msg_id']}'");
            }else if($row2['outgoing_id'] != $_SESSION['uid'] && $row3['status'] == "Active Now" && $row2['notify'] != "yes"){
                mysqli_query($db,"UPDATE messages SET notify = 'yes' WHERE msg_id = '{$row2['msg_id']}'");
            }
        }
    }
}
?>