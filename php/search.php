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
    <link rel="stylesheet" href="./css/search.css" />
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC064S8Zgb8lJGUeGG2-tX6vN2VFBW5bbM&language=zh-TW"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
      var map;
      var marker;
      var circle;
      var latitude = 25.0151;
      var longitude = 121.5340;

      function initMap() {

        var location = new google.maps.LatLng(latitude, longitude);
        var mapProp= {
            center: location,
            zoom: 15,
        };

        // https://developers.google.com/maps/documentation/javascript/reference/map#MapOptions
        map = new google.maps.Map(document.getElementById("google-map"), mapProp);

        placeMarker(location);

        google.maps.event.addListener(map, 'click', function(event) {
            const location = event.latLng;
            latitude = location.lat();
            longitude = location.lng();
            placeMarker(location);
            if (circle) {
                circle.setMap(null);
            }
            map.panTo(location);
        });
      }

      function placeMarker(location) {
          if (marker) {
              marker.setMap(null);
          }
          marker = new google.maps.Marker({
              position: location,
              map: map
          });
      }

      function placeCircle(location, radius) {
          if (circle) {
              circle.setMap(null);
          }
          circle = new google.maps.Circle({
              center:location,
              radius:parseFloat(radius),
              strokeColor:"#FF0000",
              strokeOpacity:0.8,
              strokeWeight:2,
              fillColor:"#FF0000",
              fillOpacity:0.05,
              map: map
          });
      }

      $(document).ready(function(){
          $("#start-search-button").click(function(){
              var radius = $("#radius-input").val();
              var condition = $("#select-option").val();

              placeCircle(new google.maps.LatLng(latitude, longitude), radius);

              $.ajax({
                  type: "POST",
                  url: "helper/search_helper.php",
                  data: { action: "search", radius: radius, condition: condition, latitude: latitude, longitude, longitude },
                  dataType: 'json', // Expect JSON response
                  success: function(response){
                      $("#table-body").empty();
                      
                      $.each(response, function(index, row) {
                          var name = row[0];
                          var place_id = row[1];
                          var tr = $("<tr>");
                          tr.append("<td>" + name + "</td>");              
                          var link = "https://www.google.com/maps/place/?q=place_id:" + place_id + "&hl=zh-TW";
                          var td = $("<td>").addClass("actions");
                          td.append("<a href=\"" + link + "\" target=\"_blank\">Link</a>");              
                          td.append("<button onclick=\"insert_hope('" + place_id + "')\">加入心願</button>");              
                          td.append("<button onclick=\"insert_love('" + place_id + "')\">加入最愛</button>");              
                          tr.append(td);          
                          $("#table-body").append(tr);
                      });
                  }
              });
          });
      });

      function insert_hope(restaurant_id){
          $.ajax({
            url: "helper/search_helper.php",
            type: "POST",
            data: { action: 'insert_hope', restaurant_id: restaurant_id },
            success: function(response){
                alert("成功加入心願清單");
            }
          });
      }
      function insert_love(restaurant_id){
          $.ajax({
            url: "helper/search_helper.php",
            type: "POST",
            data: { action: 'insert_love', restaurant_id: restaurant_id },
            success: function(response){
                alert("成功加入我的最愛");
            }
          });
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
  <body onload="initMap()">
    <div class="main-container">
      <div class="flex-row-af">
        <span class="restaurant-system">餐廳收藏系統</span>
        <div class="page-links">
          <button class="search-button"><span class="search">搜尋<br />餐廳</span></button>
          <button class="hope-button" onclick="gotoHope()"><span class="hope">心願<br />清單</span></button>
          <button class="love-button" onclick="gotoLove()"><span class="love">我的<br />最愛</span></button>
          <button class="friend-button" onclick="gotoFriend()"><span class="friend">好友</span></button>
          <form action="logout.php" method="post">
            <button class="logout-button" type="submit"><span class="logout">登出</span></button>
          </form>
        </div>
      </div>
      <div class="flex-row-d">
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
        <div id="google-map"></div>
        <span class="radius">半徑(m)</span>
        <input type="number" class="radius-input" id="radius-input" min="1" max="100000" required>
        <span class="search-condition">搜尋條件</span>
        <select class="search-condition-input" id="select-option">
          <option value="by-rating">依評分</option>
          <option value="by-distance">依距離</option>
          <option value="by-comment-num">依評論數</option>
          <option value="in-hope">在心願清單</option>
          <option value="in-love">在我的最愛</option>
        </select>
        <button class="start-search-button" id="start-search-button"><span class="start-search">開始搜尋</span></button>
      </div>
      <!-- <div class="line"></div> -->
    </div>
    <!-- Restaurant Collection - https://codia.ai/ -->
  </body>
</html>
