<?php
$userList = array();
while($row = mysqli_fetch_assoc($sql)){
    $sql2 = mysqli_query($db,"SELECT * FROM messages WHERE (incoming_id = '{$row['uid']}' AND outgoing_id = '{$_SESSION['uid']}') OR (outgoing_id = '{$row['uid']}' AND incoming_id = '{$_SESSION['uid']}') ORDER BY msg_id DESC LIMIT 1");
    $msg = "No Message Found!";
    $msgId = -1;
    if(mysqli_num_rows($sql2) > 0){
        $row2 = mysqli_fetch_assoc($sql2);
        $msg = $row2['message'];
        if($row2['type'] ==  "img"){
            if($row2['outgoing_id'] == $_SESSION['uid']){
                $msg = "You: Sent an image";
            }else{
                $msg = "Sent an image";
            }
        }else if($row2['type'] ==  "file"){
            if($row2['outgoing_id'] == $_SESSION['uid']){
                $msg = "You: Sent a file";
            }else{
                $msg = "Sent a file";
            }
        }else if($row2['type'] ==  "music"){
            if($row2['outgoing_id'] == $_SESSION['uid']){
                $msg = "You: Sent a music";
            }else{
                $msg = "Sent a music";
            }
        }else if($row2['type'] ==  "voice"){
            if($row2['outgoing_id'] == $_SESSION['uid']){
                $msg = "You: Sent a voice";
            }else{
                $msg = "Sent a voice";
            }
        }
        else if($row2['outgoing_id'] == $_SESSION['uid']){
            $msg = "You: ".$msg;
        }
        $msgId = $row2['msg_id'];
    }
    if(strlen($msg) > 25 && $msg){
        $msg = substr($msg,0,25);
    }
    if(mysqli_num_rows($sql2) > 0 && $row2['seen'] != "yes" && $row2['outgoing_id'] != $_SESSION['uid']){
        $msg = "<span style='color:blue;'>".$msg."</span>";
    }
    
    // Check Active Status
    $status = "";
    if($row['status'] != "Active Now"){
        $status = "offline";
    }
    $array = array("uid"=>$row['uid'],"img"=>$row['img'],"fname"=>$row['fname'],"lname"=>$row['lname'],"msg"=>$msg,"status"=>$status,"msgId"=>$msgId);
    array_push($userList,$array);
    $msgIdColumn = array_column($userList, "msgId");
    array_multisort($msgIdColumn, SORT_DESC, $userList);
}
    for($i=0;$i<count($userList);$i++){
        $user .= '<a href="chat.php?uid='.$userList[$i]["uid"].'">
        <div class="content">
            <img src="php/images/'.$userList[$i]["img"].'" alt="">
            <div class="details">
                <span>'.$userList[$i]["fname"]." ".$userList[$i]["lname"].'</span>
                <p>'.$userList[$i]["msg"].'</p>
            </div>
        </div>
        <div class="status-dot '.$userList[$i]["status"].'"><i class="fas fa-circle"></i></div>
        </a>';
    }
?>