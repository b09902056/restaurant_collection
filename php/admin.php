<?php
    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: register_login.php");
        exit();
    }

    $message = '';

    $hostname = "140.122.184.129:3310";
    $db_username = "team14";
    $db_password = "3n/S(z!Uk-mRxs_Z";
    $database = "team14";

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['form_submitted']) && $_POST['form_submitted'] == '1') {
        $id = $_POST["id-input"];
        $name = $_POST["name-input"];
        $latitude = $_POST["latitude-input"];
        $longitude = $_POST["longitude-input"];
        $rating = $_POST["rating-input"];
        $comment_num = $_POST["comment_num-input"];

        $conn = new mysqli($hostname, $db_username, $db_password, $database);            
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM restaurant WHERE id='$id'";
        $result = $conn->query($sql);

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
                    WHERE id = $id";
            
            if ($conn->query($sql) === TRUE) {
                $message = "修改成功!";
            }
            else {
                $message = "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        $conn->close();
    }
    
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Generated by Codia AI</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap" />
    <link rel="stylesheet" href="admin.css" />
  </head>
  <body>
    <div class="main-container">
      <div class="flex-column-ef">
        <div class="page-links">
          <button class="friend"><span class="data-modify">資料<br />修改</span></button>
          <button class="setting-button"><span class="rank-list-span">排行榜</span></button>
          <form action="logout.php" method="post">
            <button class="logout-button" type="submit"><span class="logout-span">登出</span></button>
          </form>
        </div>
        <span class="restaurant-edit-span">新增/修改餐廳</span>
        <div class="modify-form">
          <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <table>
                <tr>
                    <td>id</td>
                    <td><input type="text" name="id-input" required></td>
                </tr>
                <tr>
                    <td>name</td>
                    <td><input type="text" name="name-input" required></td>
                </tr>
                <tr>
                    <td>latitude</td>
                    <td><input type="number" min="-90" max="90" name="latitude-input" required></td>
                </tr>
                <tr>
                    <td>longitude</td>
                    <td><input type="number"  min="-180" max="180" name="longitude-input" required></td>
                </tr>
                <tr>
                    <td>rating</td>
                    <td><input type="number" step="0.1" min="1" max="5" name="rating-input" required></td>
                </tr>
                <tr>
                    <td>comment_num</td>
                    <td><input type="number" min="0" name="comment_num-input" required></td>
                </tr>
            </table>
            <input type="hidden" name="form_submitted" value="1">
            <br>
            <input type="submit" value="儲存" class="submit-button">
            <?php
            if ($message) {
                echo "<p style=\"color:red;\">$message</p>";
            }
            ?>
        </form>
        </div>
      </div>
      <div class="flex-column-e">
        <span class="restaurant-collection-system">餐廳收藏系統(管理員)</span>
        <span class="restaurant-name">餐廳名字</span>
        <div class="restaurant-name-2"></div>
        <button class="frame"><span class="search">搜尋</span></button>
        <div class="restaurant-table">
          <table>
            <thead>
                <tr>
                    <th>搜尋結果</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="table-body">
            </tbody>
          </table>
        </div>
      </div>
      <div class="line"></div>
    </div>
    <!-- Generated by Codia AI - https://codia.ai/ -->
  </body>
</html>