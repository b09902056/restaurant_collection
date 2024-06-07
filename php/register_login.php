<!DOCTYPE html>
<html>
<head>
    <title>Register and Login</title>
</head>
<body>
    <h2>餐廳收藏系統</h2>
    <form action="register.php" method="post">
        <label for="username">名字:</label><br>
        <input type="text" id="username" name="username" required><br>
        <label for="password">密碼:</label><br>
        <input type="password" id="password" name="password" required><br>
        <input type="submit" name="register" value="註冊">
    </form>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $conn = new mysqli('140.122.184.129:3310', 'team14', '3n/S(z!Uk-mRxs_Z', 'team14');
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM user WHERE name = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
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
?>
