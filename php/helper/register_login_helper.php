<?php
    $hostname = "140.122.184.129:3310";
    $db_username = "team14";
    $db_password = "3n/S(z!Uk-mRxs_Z";
    $database = "team14";

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'register') {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $conn = new mysqli($hostname, $db_username, $db_password, $database);
        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM user WHERE name = '$username'";
        $result = $conn->query($sql);
            

        if ($username == "admin" || $result->num_rows > 0) {
            $message = "Username already exists. Please choose a different username.";
        }
        else{
            $sql = "INSERT INTO user (name, password) VALUES ('$username', '$password')";

            if ($conn->query($sql) === TRUE) {
                $message = "New account created successfully!";
            }
            else {
                $message = "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        echo $message;

        $conn->close();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'login') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if ($username == "admin"){
            if ($password != "admin123"){
                echo "Invalid password.";
            }
            else{
                session_start();
                $_SESSION['username'] = "admin";
                echo "Location: admin.php";
            }
        }
        else{
            $conn = new mysqli($hostname, $db_username, $db_password, $database);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM user WHERE name='$username'";
            $result = $conn->query($sql);
            $conn->close();

            if ($result->num_rows == 0) {
                echo "No user found with this username.";
            }
            else {
                $row = $result->fetch_assoc();
                if (password_verify($password, $row['password'])) {
                    session_start();
                    $_SESSION['username'] = $username;
                    echo "Location: search.php";
                }
                else {
                    echo "Invalid password.";
                }
            }
        }
    }

?>