<?php
    session_start();
    $user_name = $_SESSION['username'];

    $hostname = "140.122.184.129:3310";
    $db_username = "team14";
    $db_password = "3n/S(z!Uk-mRxs_Z";
    $database = "team14";

    $conn = new mysqli($hostname, $db_username, $db_password, $database);            
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $res_name = $_POST['hid-com'];
    $comment = $_POST['com-input-name'];
    $res_id = $_POST['res_id'];

    $sql = "SELECT * FROM `message` WHERE `restaurant_id` = '$res_id' AND `user_name` = '$user_name'";
    $result = $conn->query($sql);

    if( $result->num_rows > 0 ){
        $sql = "UPDATE `message` SET `restaurant_id` = '$res_id', `user_name` = '$user_name', `text` = '$comment' WHERE `restaurant_id` = '$res_id' AND `user_name` = '$user_name'";
    }
    else{
        $sql = "INSERT INTO `message` (`restaurant_id`, `user_name`,`text`) VALUES ('$res_id', '$user_name', '$comment')";
    }

    $conn->query($sql);

    $conn->close();

    header("Location: love.php");
?>