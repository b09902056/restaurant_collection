<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: register_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Generated by Codia AI</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap" />
    <link rel="stylesheet" href="search.css" />
  </head>
  <body>
    <div class="main-container">
      <div class="flex-row-af">
        <span class="restaurant-system">餐廳收藏系統</span>
        <div class="page-links">
          <button class="search-button">
            <span class="search-restaurant">搜尋<br />餐廳</span></button
          ><button class="hope-button">
            <span class="heart-list">心願<br />清單</span></button
          ><button class="love-button">
            <span class="favorite-list">我的<br />最愛</span></button
          ><button class="friend-button">
            <span class="friend">好友</span></button
          ><button class="button-setting">
            <span class="setting">設定</span>
          </button>
        </div>
      </div>
      <div class="flex-row-d">
        <div class="rectangle"></div>
        <div class="rectangle-1"></div>
        <button class="button">
          <span class="start-search">開始搜尋</span></button
        ><span class="search-condition">搜尋條件</span>
        <div class="rectangle-2"></div>
        <div class="radius"></div>
        <span class="half-radius">半徑</span>
        <div class="sort"></div>
      </div>
      <div class="line"></div>
    </div>
    <!-- Generated by Codia AI - https://codia.ai/ -->
  </body>
</html>