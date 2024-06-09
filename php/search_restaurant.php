<?php
    session_start();
    $user_name = $_SESSION['username'];

    $hostname = "140.122.184.129:3310";
    $db_username = "team14";
    $db_password = "3n/S(z!Uk-mRxs_Z";
    $database = "team14";


    $conn = new mysqli($hostname, $db_username, $db_password, $database);
        
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_POST['condition'] == "by-rating"){
        $sql = "SELECT * FROM restaurant 
                ORDER BY rating DESC";
    } 
    elseif ($_POST['condition'] == "by-comment-num"){
        $sql = "SELECT * FROM restaurant
                ORDER BY comment_num DESC";
    } 
    elseif ($_POST['condition'] == "in-hope"){
        $sql = "SELECT * FROM restaurant
                WHERE id IN (SELECT restaurant_id FROM hope WHERE user_name = '$user_name') 
                ORDER BY rating DESC";
    } 
    elseif ($_POST['condition'] == "in-love"){
        $sql = "SELECT * FROM restaurant
                WHERE id IN (SELECT restaurant_id FROM love WHERE user_name = '$user_name') 
                ORDER BY rating DESC";
    }
    else{
        $sql = "SELECT * FROM restaurant";
    }

    $result = $conn->query($sql);

    $restaurants = array();
    if ($result->num_rows > 0) {	
        while($row = mysqli_fetch_assoc($result)){
            $restaurants[] = array($row["name"], $row["id"], $row["latitude"], $row["longitude"]);
        }
    }

    
    $latitudeFrom = $_POST["latitude"];
    $longitudeFrom = $_POST["longitude"];
    $radius = $_POST["radius"];

    foreach ($restaurants as &$restaurant) {
        $restaurant[] = getDistance($latitudeFrom, $longitudeFrom, $restaurant[2], $restaurant[3]);
    }

    if ($_POST['condition'] == "by-distance"){
        usort($restaurants, 'sortByDistance');
    }

    $restaurantsInRadius = array();
    foreach ($restaurants as &$restaurant) {
        if ($restaurant[4] < $radius){
            $restaurantsInRadius[] = array($restaurant[0], $restaurant[1]);
        }
    }

    $conn->close();

    echo json_encode($restaurantsInRadius);



    function getDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371)
    {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return 1000 * round($angle * $earthRadius, 4);
    }
    
    function sortByDistance($a, $b) {
        return $a[4] - $b[4];
    }
?>