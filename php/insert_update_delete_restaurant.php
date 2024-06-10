<?php
    $hostname = "140.122.184.129:3310";
    $db_username = "team14";
    $db_password = "3n/S(z!Uk-mRxs_Z";
    $database = "team14";

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'delete') {
        $id = $_POST["id"];

        $conn = new mysqli($hostname, $db_username, $db_password, $database);            
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "DELETE FROM restaurant WHERE id='$id'";

        if ($conn->query($sql) === TRUE) {
            $message = "刪除成功!";
        }

        $conn->close();

        echo $message;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST["action"] == "insertUpdate") {
        $id = $_POST["id"];
        $name = $_POST["name"];
        $latitude = $_POST["latitude"];
        $longitude = $_POST["longitude"];
        $rating = $_POST["rating"];
        $comment_num = $_POST["comment_num"];

        $conn = new mysqli($hostname, $db_username, $db_password, $database);            
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM restaurant WHERE id='$id'";
        $result = $conn->query($sql);

        $message = "";

        if ($result->num_rows == 0) {
            $sql = "INSERT INTO restaurant (id, name, latitude, longitude, rating, comment_num) 
                    VALUES ('$id', '$name', '$latitude', '$longitude', '$rating', '$comment_num')";
        
            if ($conn->query($sql) === TRUE) {
                $message = "新增成功!";
            }
            else {
                $message = "Error: " . $sql . "<br>" . $conn->error;
            }
        }
        else {
            $sql = "UPDATE restaurant
                    SET name = '$name', latitude = '$latitude', longitude = '$longitude', rating = '$rating', comment_num = '$comment_num'
                    WHERE id = '$id'";
            
            if ($conn->query($sql) === TRUE) {
                $message = "修改成功!";
            }
            else {
                $message = "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        $conn->close();

        echo $message;
    }
?>