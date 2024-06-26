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
    <title>Restaurant Collection</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap" />
    <link rel="stylesheet" href="./css/admin.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
      $(document).ready(function(){
          $("#search-button").click(function(){
              var name = $("#restaurant-name-input").val();
              $.ajax({
                  type: "POST",
                  url: "helper/admin_helper.php",
                  data: { action: "selectByNameLike", name: name },
                  dataType: 'json', // Expect JSON response
                  success: function(response){
                      $("#table-body").empty();
                      
                      $.each(response, function(index, row) {
                          var name = row[0];
                          var id = row[1];
                          var tr = $("<tr id=\"" + id + "\">");
                          tr.append("<td>" + name + "</td>");              
                          var td = $("<td>").addClass("actions");
                          td.append("<button onclick=\"modifyRestaurant('" + id + "')\">修改</button>");              
                          td.append("<button onclick=\"deleteRestaurant('" + id + "')\">刪除</button>");              
                          tr.append(td);          
                          $("#table-body").append(tr);
                      });
                  }
              });
          });
      });

      function modifyRestaurant(id){
          $.ajax({
            type: "POST",
            url: "helper/admin_helper.php",
            data: { action: 'selectById', id: id },
            dataType: 'json', // Expect JSON response
            success: function(response){
                document.getElementById("id-input").value = String(response['id']);
                document.getElementById("name-input").value = String(response['name']);
                document.getElementById("latitude-input").value = String(response['latitude']);
                document.getElementById("longitude-input").value = String(response['longitude']);
                document.getElementById("rating-input").value = String(response['rating']);
                document.getElementById("comment_num-input").value = String(response['comment_num']);
            }
          });
      }

      function deleteRestaurant(id){
          var row = document.getElementById(id);
          if (row) {
              row.remove();
          }
          $.ajax({
            type: "POST",
            url: "helper/admin_helper.php",
            data: { action: "delete", id: id },
            dataType: 'text',
            success: function(response){

            }
          });

      }

      function insert_update_restaurant(){
          event.preventDefault();

          var id = document.getElementById("id-input").value;
          var name = document.getElementById("name-input").value; 
          var latitude = document.getElementById("latitude-input").value;
          var longitude = document.getElementById("longitude-input").value;
          var rating = document.getElementById("rating-input").value;
          var comment_num = document.getElementById("comment_num-input").value;

          var submitType = event.submitter.value;
          if (submitType === "新增") {
              var action = "insert";
          } else if (submitType === "修改") {
              var action = "update";
          }

          $.ajax({
            type: "POST",
            url: "helper/admin_helper.php",
            data: { action: action, id: id, name: name, latitude: latitude, longitude: longitude, rating: rating, comment_num: comment_num },
            dataType: 'text',
            success: function(response){
              document.getElementById("message").textContent = response;
            }
          });
      }
    </script>
  </head>
  <body>
    <div class="main-container">
      <div class="flex-column-ef">
        <div class="page-links">
          <!-- <button class="friend"><span class="data-modify">資料<br />修改</span></button>
          <button class="setting-button"><span class="rank-list-span">排行榜</span></button> -->
          <form action="logout.php" method="post">
            <button class="logout-button" type="submit"><span class="logout-span">登出</span></button>
          </form>
        </div>
        <span class="restaurant-edit-span">新增/修改餐廳</span>
        <div class="modify-form">
          <form onsubmit="insert_update_restaurant()">
            <table>
                <tr>
                    <td>id</td>
                    <td><input id="id-input" type="text" name="id-input" style="width: 300px;" required></td>
                </tr>
                <tr>
                    <td>name</td>
                    <td><input id="name-input" type="text" name="name-input" style="width: 300px;" required></td>
                </tr>
                <tr>
                    <td>latitude</td>
                    <td><input id="latitude-input" type="number" step="0.0001" min="-90" max="90" name="latitude-input" style="width: 80px;" required></td>
                </tr>
                <tr>
                    <td>longitude</td>
                    <td><input id="longitude-input" type="number" step="0.0001" min="-180" max="180" name="longitude-input" style="width: 80px;" required></td>
                </tr>
                <tr>
                    <td>rating</td>
                    <td><input id="rating-input" type="number" step="0.1" min="1" max="5" name="rating-input" style="width: 80px;" required></td>
                </tr>
                <tr>
                    <td>comment_num</td>
                    <td><input id="comment_num-input" type="number" min="0" name="comment_num-input" style="width: 80px;" required></td>
                </tr>
            </table>
            <input type="hidden" name="form_submitted" value="1">
            <br>
            <input type="submit" value="新增">
            <input type="submit" value="修改">
            <p id="message" style="color:red;"></p>
        </form>
        </div>
      </div>
      <div class="flex-column-e">
        <span class="restaurant-collection-system">餐廳收藏系統(管理員)</span>

          <span class="restaurant-name">餐廳名字</span>
          <input type="text" class="name-input" id="restaurant-name-input" placeholder="餐廳名字 substring" required>
          <button class="search-button" id="search-button">搜尋</button>

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
    <!-- Restaurant Collection - https://codia.ai/ -->
  </body>
</html>
