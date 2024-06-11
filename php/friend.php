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
    <link rel="stylesheet" href="./css/comment.css" />
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC064S8Zgb8lJGUeGG2-tX6vN2VFBW5bbM&language=zh-TW"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
      function gotoSearch(){
          window.location.href = 'search.php';
      }
      function gotoHope(){
          window.location.href = 'hope.php';
      }
      function gotoLove(){
          window.location.href = 'love.php';
      }
      function gotoFriend(){
          window.location.href = 'friend.php';
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
          <button class="love-button" onclick="gotoLove()"><span class="love">我的<br />最愛</span></button>
          <button class="friend-button"><span class="friend">好友</span></button>
          <form action="logout.php" method="post">
            <button class="logout-button" type="submit"><span class="logout">登出</span></button>
          </form>
        </div>
    </div>
    <div class="flex-row-d">
        <div class="restaurant-table">
            <span class="coming-soon"><?php echo "好友功能 未來將推出!!!"; ?></span>
        </div>
    </div>
    <div class="line"></div>
    </div>
    <!-- Restaurant Collection - https://codia.ai/ -->
  </body>
</html>