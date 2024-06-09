<!DOCTYPE html>
<html>
<head>
    <title>Register and Login</title>
</head>
<body>
    <h1>餐廳收藏系統</h1>
    <form action="register_login.php" method="post">
        <label for="username">名字:</label><br>
        <input type="text" id="username" name="username" required><br>
        <label for="password">密碼:</label><br>
        <input type="password" id="password" name="password" required><br>
        <input type="submit" name="login" value="登入">
        <input type="submit" name="register" value="註冊">
    </form>
</body>
</html>

<?php
    $hostname = "140.122.184.129:3310";
    $db_username = "team14";
    $db_password = "3n/S(z!Uk-mRxs_Z";
    $database = "team14";

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $conn = new mysqli($hostname, $db_username, $db_password, $database);
        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM user WHERE name = '$username'";
        $result = $conn->query($sql);

        if ($username == "admin" || $result->num_rows > 0) {
            echo "Username already exists. Please choose a different username.";
        }
        else{
            $sql = "INSERT INTO user (name, password) VALUES ('$username', '$password')";
        
            if ($conn->query($sql) === TRUE) {
                echo "New account created successfully!";
            }
            else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if ($username == "admin"){
            if ($password != "admin123"){
                echo "Invalid password.";
            }
            else{
                session_start();
                $_SESSION['username'] = "admin";
                header("Location: admin.php");
            }
        }
        else{
            $conn = new mysqli($hostname, $db_username, $db_password, $database);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM user WHERE name='$username'";
            $result = $conn->query($sql);

            if ($result->num_rows == 0) {
                echo "No user found with this username.";
            }
            else {
                $row = $result->fetch_assoc();
                if (password_verify($password, $row['password'])) {
                    session_start();
                    $_SESSION['username'] = $username;
                    header("Location: search.php");
                }
                else {
                    echo "Invalid password.";
                }
            }

            $conn->close();
        }
    }

?>
