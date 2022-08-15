<?php
    $db = mysqli_connect("localhost","root","","chat");
    if(!$db){
        echo mysqli_error($db);
    }
?>