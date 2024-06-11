<?php
    session_start();
    $user_name = $_SESSION['username'];

    $hostname = "140.122.184.129:3310";
    $db_username = "team14";
    $db_password = "3n/S(z!Uk-mRxs_Z";
    $database = "team14";

    if(isset($_POST['action']) && $_POST['action'] == 'delete_hope') {
        $conn = new mysqli($hostname, $db_username, $db_password, $database);            
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $restaurant_id = $_POST["restaurant_id"];

        $sql = "DELETE FROM `hope` WHERE `hope`.`restaurant_id` = '$restaurant_id' AND `hope`.`user_name` = '$user_name'";
        
        $conn->query($sql);

        $conn->close();
    }

    if(isset($_POST['action']) && $_POST['action'] == 'delete_love') {
        $conn = new mysqli($hostname, $db_username, $db_password, $database);            
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $restaurant_id = $_POST["restaurant_id"];

        $sql = "DELETE FROM `love` WHERE `love`.`restaurant_id` = '$restaurant_id' AND `love`.`user_name` = '$user_name'";
        
        $conn->query($sql);

        $conn->close();
    }

    if(isset($_POST['action']) && $_POST['action'] == 'delete_key') {
        $conn = new mysqli($hostname, $db_username, $db_password, $database);            
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $keyword = $_POST["keyword"];

        $sql = "DELETE FROM `tag` WHERE `tag`.`keyword` = '$keyword' AND `tag`.`user_name` = '$user_name'";
        
        $conn->query($sql);

        $conn->close();
    }

?>