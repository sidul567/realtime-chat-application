<?php
session_start();
if (isset($_SESSION['uid'])) {
    include_once "db.php";

    $incoming_id = mysqli_real_escape_string($db, $_POST['incoming_id']);
    $outgoing_id = mysqli_real_escape_string($db, $_POST['outgoing_id']);

    $sql = mysqli_query($db, "SELECT * FROM messages LEFT JOIN users ON messages.outgoing_id = users.uid WHERE (incoming_id = '{$incoming_id}' AND outgoing_id = '{$outgoing_id}') OR (outgoing_id = '{$incoming_id}' AND incoming_id = '{$outgoing_id}')");
    $output = "";
    if (mysqli_num_rows($sql) > 0) {
        while ($row = mysqli_fetch_assoc($sql)) {
            $center = "";
            if($row['type'] == "img"){
                $center = 'center';
                $msg = '<img src='."php/files/".$row['message'].' alt="">';
            }else if($row['type'] == "file"){
                $fileName = substr($row['message'],10);
                $msg = '<a href='."php/files/".$row['message'].' download='.$fileName.'>'.$fileName.'</a>';
            }else if($row['type'] == "voice"){
                $msg = '<i class="fa-solid fa-circle-play" onclick="playAudio(this)"></i><span class="currentTime">00:00</span><input type="range" min="0" max="100" value="20" step="1" id="seekSlider"><i class="fa-solid fa-volume-high"></i><audio src='.$row['message'].' data-id='.$row['msg_id'].' autobuffer preload="metadata"></audio>
                ';
            }else if($row['type'] == "music"){
                $msg = '<i class="fa-solid fa-circle-play" onclick="playAudio(this)"></i><span class="currentTime">00:00</span><input type="range" min="0" max="100" value="20" step="1" id="seekSlider"><i class="fa-solid fa-volume-high"></i><audio src='."php/files/".$row['message'].' data-id='.$row['msg_id'].' preload="none"></audio>
                ';
            }else{
                $msg = $row['message'];
            }
            // Unread message
            $sql2 = mysqli_query($db,"SELECT * FROM messages WHERE (incoming_id = '{$outgoing_id}' AND outgoing_id = '{$incoming_id}') ORDER BY msg_id DESC LIMIT 1");
            if(mysqli_num_rows($sql2) > 0){
                $row2 = mysqli_fetch_assoc($sql2);
                mysqli_query($db,"UPDATE messages SET seen='yes' WHERE msg_id='{$row2['msg_id']}'");
            }

            $time = explode(",",$row['time']);
            $time = explode(" ",$time[1]);
            if($outgoing_id == $row['outgoing_id']){
                $output .= '<div class="chat outgoing">
                    <div class="details">
                    <p title='.$time[1].$time[2].' class='.$center.'>'.$msg.'</p>
                    <div class="show-react" data-id='.$row['msg_id'].'>'.$row['emoji'].'</div>
                    </div>
                </div>';
            }else{
                $output .= '<div class="chat incoming">
                <img src="php/images/'.$row['img'].'" alt="">
                <div class="details">
                    <div class="emoji-wrapper">
                        <div class="emoji">
                            <i class="fa-solid fa-face-smile-beam" onclick="emojiIcon(this)" data-id='.$row['msg_id'].'></i>
                            <div class="emoji-list" data-id='.$row['msg_id'].'>
                                <div class="emoji-item" onclick="emojiItem(this)">&#128077;
                                </div>
                                <div class="emoji-item" onclick="emojiItem(this)">&#128150;
                                </div>
                                <div class="emoji-item" onclick="emojiItem(this)">&#129315;
                                </div>
                                <div class="emoji-item" onclick="emojiItem(this)">&#128558;
                                </div>
                                <div class="emoji-item" onclick="emojiItem(this)">&#128549;
                                </div>
                                <div class="emoji-item" onclick="emojiItem(this)">&#128545;
                                </div>
                            </div>
                        </div>
                    </div>
                    <p title='.$time[1].$time[2].' class='.$center.'>'.$msg.'</p>
                    <div class="show-react" data-id='.$row['msg_id'].'>'.$row['emoji'].'</div>
                </div>
                </div>';
            }
        }
        echo $output;
    }
}
?>