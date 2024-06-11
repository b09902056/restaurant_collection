<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: register_login.php");
    exit();
}

$user_name = $_SESSION['username'];

$hostname = "140.122.184.129:3310";
$db_username = "team14";
$db_password = "3n/S(z!Uk-mRxs_Z";
$database = "team14";

$conn = new mysqli($hostname, $db_username, $db_password, $database);
       
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Restaurant Collection</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap" />
    <link rel="stylesheet" href="./css/hope_love.css" />
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC064S8Zgb8lJGUeGG2-tX6vN2VFBW5bbM&language=zh-TW"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
      function insert_love(restaurant_id){
          $.ajax({
            url: "insert_hope_love.php",
            type: "POST",
            data: { action: 'insert_love', restaurant_id: restaurant_id },
            success: function(response){
                alert("成功加入我的最愛");
            }
          });
      }
      
      function delete_love(restaurant_id){
          $.ajax({
            url: "delete_hope_love.php",
            type: "POST",
            data: { action: 'delete_love', restaurant_id: restaurant_id },
            success: function(response){
                alert("成功刪除");
            }
          });
          refresh();
      }

      function delete_key(keyword){
          $.ajax({
            url: "delete_hope_love.php",
            type: "POST",
            data: { action: 'delete_key', keyword: keyword },
            success: function(response){
                alert("成功刪除");
            }
          });
          refresh();
      }

      function gotoSearch(){
          window.location.href = 'search.php';
      }
      function gotoHope(){
          window.location.href = 'hope.php';
      }
      function gotoFriend(){
          window.location.href = 'friend.php';
      }
      function refresh(){
          window.location.href = 'love.php';
      }

    </script>
  </head>
  <body>
    <div class="main-container">
    <div class="flex-row-af">
        <span class="restaurant-system">餐廳收藏系統</span>
        <div class="page-links">
          <button class="search-button" onclick="gotoSearch()"><span class="search">搜尋<br />餐廳</span></button>
          <button class="hope-button" onclick="gotoHope()"><span class="hope">心願<br />清單</span></button>
          <button class="love-button"><span class="love">我的<br />最愛</span></button>
          <button class="friend-button" onclick="gotoFriend()"><span class="friend">好友</span></button>
          <form action="logout.php" method="post">
            <button class="logout-button" type="submit"><span class="logout">登出</span></button>
          </form>
        </div>
    </div>
    <div class="flex-row-d">
        <span class="key">關鍵字</span>
        <form method="post">
            <input type="text" class="key-input" id="key-input" name="key-input-name">
            <button class="search-but" id="search-but"><span class="start-search">搜尋</span></button>
        </form>
        <?php $keyw = ""; if (isset($_POST['key-input-name'])) {$keyw = $_POST['key-input-name'];} ?>
        <div class="restaurant-table">
            <table>
                <thead>
                    <tr>
                        <th>搜尋結果</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    <?php
                        if(isset($_POST['key-input-name'])) $sql = "SELECT * FROM `tag` INNER JOIN `restaurant` ON `restaurant_id` = `id` WHERE `user_name` = '$user_name' AND `tag`.`keyword` = '$keyw'";
                        else $sql = "SELECT * FROM `love` INNER JOIN `restaurant` ON `restaurant_id` = `id` WHERE `user_name` = '$user_name'";

                        $result = $conn->query($sql);
                        
                        if ($result->num_rows > 0) {	
                            while($row = mysqli_fetch_assoc($result)){
                                echo "<tr>";
                                echo "<td>" . $row['name'] . "</td>";
                                echo "<td class=\"actions\">";
                                echo "<a href=\"https://www.google.com/maps/place/?q=place_id:" . $row['id'] . "&hl=zh-TW\" target=\"_blank\">Link</a>";
                                echo "<form action=\"comment.php\" method=\"post\">";
                                echo "<input type=\"hidden\" name=\"res_id\" value=\"" . $row['id'] . "\">";
                                echo "<button name=\"com\" value=\"" . $row['name'] . "\">評論</button>";
                                echo "</form>";
                                echo "<button onclick=\"delete_love('" . $row['id'] . "')\">刪除</button>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <span class="search-res">選擇餐廳</span>
        <form method="post">
            <select class="search-res-input" id="search-res-option" name="res_option">
                <?php
                    $sql = "SELECT * FROM `hope` INNER JOIN `restaurant` ON `restaurant_id` = `id` WHERE `user_name` = '$user_name'";
                    $result = $conn->query($sql);
                    
                    if ($result->num_rows > 0) {	
                        while($row = mysqli_fetch_assoc($result)){
                            echo "<option value=\"" . $row['restaurant_id'] . "\">" . $row['name'] . "</option>";
                        }
                    }
                ?>
            </select>
            <button class="confirm-but0" id="confirm-but0"><span class="save">確認</span></button>
        </form>
        <?php $res = ""; if (isset($_POST['res_option'])) {$res = $_POST['res_option'];} ?>
        <div class="key-table">
            <table>
                <thead>
                    <tr>
                        <th>關鍵字</th>
                        <th></th>
                    </tr>
                </thead>
            <tbody id="key-body">
                <?php
                    $sql = "SELECT * FROM `tag` WHERE `restaurant_id` = '$res'";

                    $result = $conn->query($sql);
                    
                    if ($result->num_rows > 0) {	
                        while($row = mysqli_fetch_assoc($result)){
                            echo "<tr>";
                            echo "<td>" . $row['keyword'] . "</td>";
                            echo "<td class=\"actions\">";
                            echo "<button onclick=\"delete_key('" . $row['keyword'] . "')\">刪除</button>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    }
                ?>
            </tbody>
            </table>
        </div>
        <span class="add-key">新增關鍵字</span>
        <form action="insert_key.php" method="post">
            <input type="text" class="add-key-input" name="add-key-input">
            <?php echo "<input type=\"hidden\" name=\"res_opt\" value=\"" . $res . "\">"; ?>
            <button class="confirm-but" id="confirm-but"><span class="save">儲存</span></button>
        </form>
    </div>
    <div class="line"></div>
    </div>
    <!-- Restaurant Collection - https://codia.ai/ -->
  </body>
</html>