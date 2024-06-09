<?php
    session_start();
    $user_name = $_SESSION['username'];

    $hostname = "140.122.184.129:3310";
    $db_username = "team14";
    $db_password = "3n/S(z!Uk-mRxs_Z";
    $database = "team14";

    if(isset($_POST['action']) && $_POST['action'] == 'insert_hope') {
        $conn = new mysqli($hostname, $db_username, $db_password, $database);            
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $restaurant_id = $_POST["restaurant_id"];

        $sql = "INSERT IGNORE INTO hope (restaurant_id, user_name) VALUES ('$restaurant_id', '$user_name')";
        
        $conn->query($sql);

        $conn->close();
    }

    if(isset($_POST['action']) && $_POST['action'] == 'insert_love') {
        $conn = new mysqli($hostname, $db_username, $db_password, $database);            
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $restaurant_id = $_POST["restaurant_id"];

        $sql = "INSERT IGNORE INTO love (restaurant_id, user_name) VALUES ('$restaurant_id', '$user_name')";
        
        $conn->query($sql);

        $conn->close();
    }

?>