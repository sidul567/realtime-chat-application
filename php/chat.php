<?php
session_start();
if (isset($_SESSION['uid'])) {
    include_once "db.php";
    $incoming_id = mysqli_real_escape_string($db, $_POST['incoming_id']);
    $outgoing_id = mysqli_real_escape_string($db, $_POST['outgoing_id']);
    $message = mysqli_real_escape_string($db, $_POST['message']);
    date_default_timezone_set("Asia/Dhaka");
    $time = date("m/d/Y, h:i:s a");
    if(isset($_POST['voice'])){
        $voice = mysqli_real_escape_string($db, $_POST['voice']);
    }
    if (isset($_FILES['image'])) {
        $imgName = $_FILES['image']['name'];
        $imgTime = time();
        $newImgName = $imgTime . $imgName;
        $tmpName = $_FILES['image']['tmp_name'];

        // Get the extension of image
        $imgExplode = explode('.',$imgName);
        $imgExtension = end($imgExplode);

        $extensions = ['jpg','png','jpeg'];
        if(in_array($imgExtension,$extensions)){
            if(!is_dir("files")){
                mkdir("files");
            }
            move_uploaded_file($tmpName,"files/".$newImgName);
            $sql = mysqli_query($db,"INSERT INTO messages(incoming_id,outgoing_id,message,time,type) VALUES('{$incoming_id}', '{$outgoing_id}', '{$newImgName}','{$time}', 'img') ") or die();
        }
    }else if(isset($_FILES['file'])){
        $fileName = $_FILES['file']['name'];
        $fileTime = time();
        $newFileName = $fileTime . $fileName;
        $newFileName = str_replace(" ","_",$newFileName);
        $tmpName = $_FILES['file']['tmp_name'];
        // Get the extension of file
        $fileExplode = explode('.',$fileName);
        $fileExtension = end($fileExplode);

        $extensions = ['pdf','doc','docx','xls','xlsx','ppt','pptx','zip','rar'];
        if(in_array($fileExtension,$extensions)){
            if(!is_dir("files")){
                mkdir("files");
            }
            move_uploaded_file($tmpName,"files/".$newFileName);
            $sql = mysqli_query($db,"INSERT INTO messages(incoming_id,outgoing_id,message,time,type) VALUES('{$incoming_id}', '{$outgoing_id}', '{$newFileName}','{$time}', 'file') ") or die();
        }else if($fileExtension == "mp3"){
            if(!is_dir("files")){
                mkdir("files");
            }
            move_uploaded_file($tmpName,"files/".$newFileName);
            $sql = mysqli_query($db,"INSERT INTO messages(incoming_id,outgoing_id,message,time,type) VALUES('{$incoming_id}', '{$outgoing_id}', '{$newFileName}','{$time}', 'music') ") or die();
        }
    }else if($voice){
        $sql = mysqli_query($db,"INSERT INTO messages(incoming_id,outgoing_id,message,time,type) VALUES('{$incoming_id}', '{$outgoing_id}', '{$voice}','{$time}','voice')") or die();
    }else if(!empty($message)){
        $sql = mysqli_query($db,"INSERT INTO messages(incoming_id,outgoing_id,message,time,type) VALUES('{$incoming_id}', '{$outgoing_id}', '{$message}','{$time}','text') ") or die();
    }
}
else {
    header("location: ../login.php");
}
?>