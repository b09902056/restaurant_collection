<?php
    $hostname = "140.122.184.129:3310";
    $db_username = "team14";
    $db_password = "3n/S(z!Uk-mRxs_Z";
    $database = "team14";


    $conn = new mysqli($hostname, $db_username, $db_password, $database);
        
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $name = $_POST['name'];
    $sql = "SELECT * FROM restaurant WHERE name LIKE '%$name%'";

    $result = $conn->query($sql);

    $restaurants = array();
    if ($result->num_rows > 0) {	
        while($row = mysqli_fetch_assoc($result)){
            $restaurants[] = array($row["name"], $row["id"]);
        }
    }

    $conn->close();

    echo json_encode($restaurants);
?>