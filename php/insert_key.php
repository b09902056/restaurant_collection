<?php
    session_start();
    $user_name = $_SESSION['username'];

    $hostname = "140.122.184.129:3310";
    $db_username = "team14";
    $db_password = "3n/S(z!Uk-mRxs_Z";
    $database = "team14";

    if(isset($_POST['add-key-input'])) {
        $conn = new mysqli($hostname, $db_username, $db_password, $database);            
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $keyword = $_POST["add-key-input"];
        $restaurant_id = $_POST['res_opt'];

        $sql = "INSERT IGNORE INTO tag (restaurant_id, user_name, keyword) VALUES ('$restaurant_id', '$user_name', '$keyword')";
        
        $conn->query($sql);

        $conn->close();

        header("Location: hope.php");
    }
?>