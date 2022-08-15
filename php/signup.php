<?php
    session_start();
    include_once "db.php";

    $fname = mysqli_real_escape_string($db,$_POST['fname']);
    $lname = mysqli_real_escape_string($db,$_POST['lname']);
    $email = mysqli_real_escape_string($db,$_POST['email']);
    $password = mysqli_real_escape_string($db,$_POST['password']);
    if(!empty($fname) && !empty($lname) && !empty($email) && !empty($password)){
        // Check email address exist or not
        if(filter_var($email,FILTER_VALIDATE_EMAIL)){
            $sql = mysqli_query($db,"SELECT email FROM users WHERE email='$email'");
            if(mysqli_num_rows($sql) > 0){
                echo "$email is already exist!";
            }else{
                // Check selected image is valid or not
                if(isset($_FILES['img'])){
                    $imgName = $_FILES['img']['name'];
                    $tmpName = $_FILES['img']['tmp_name'];
                    $imgType = $_FILES['img']['type'];

                    // Get the extension of image
                    $imgExplode = explode('.',$imgName);
                    $imgExtension = end($imgExplode);

                    $extensions = ['jpg','png','jpeg'];

                    if(in_array($imgExtension,$extensions)){
                        $time = time();

                        $newImgName = $time.$imgName;

                        if(move_uploaded_file($tmpName,"images/".$newImgName)){
                            $sql2 = mysqli_query($db,"INSERT INTO users (fname, lname, email, password, img, status) VALUES('$fname','$lname','$email','$password','$newImgName','Active Now')");

                            if($sql2){
                                $sql3 = mysqli_query($db,"SELECT * FROM users WHERE email='$email'");

                                if(mysqli_num_rows($sql3) > 0){
                                    $row = mysqli_fetch_assoc($sql3);
                                    $_SESSION['uid'] = $row['uid'];
                                    echo "success";
                                }else{
                                    echo "Something went wrong!";
                                }
                            }else{
                                echo "Something went wrong!";
                            }
                        }
                    }else{
                        echo "Please select an image type - jpg, png, jpeg!";
                    }
                }else{
                    echo "Please select an image!";
                }
            }
        }else{
            echo "$email - This email is not valid!";
        }
    }else{
        echo "All input fields must be filled up!";
    }
?>