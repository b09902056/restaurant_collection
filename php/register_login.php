<!DOCTYPE html>
<html>
<head>
    <title>Restaurant Collection</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./css/register_login.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function register_login(){
            event.preventDefault();

            var username = document.getElementById("username").value;
            var password = document.getElementById("password").value;

            var submitType = event.submitter.value;
            if (submitType === "登入") {
                var action = "login";
            } else if (submitType === "註冊") {
                var action = "register";
            }

            $.ajax({
                type: "POST",
                url: "helper/register_login_helper.php",
                data: { action: action, username: username, password: password },
                dataType: 'text',
                success: function(response){
                    if (response == "Location: admin.php"){
                        window.location.href = "admin.php";
                    }
                    else if (response == "Location: search.php"){
                        window.location.href = "search.php";
                    }
                    else{
                        document.getElementById("message").textContent = response;
                    }
                }
            });
        }
    </script>
</head>
<body>
    <h1>餐廳收藏系統</h1>
    <form onsubmit="register_login()" method="post">
        <label for="username">名字</label><br>
        <input type="text" id="username" name="username" required><br>
        <label for="password">密碼</label><br>
        <input type="password" id="password" name="password" required><br>
        <input type="submit" name="login" value="登入">
        <input type="submit" name="register" value="註冊">
        <p id="message" style="color:red;"></p>
    </form>
</body>
</html>