<?php
    $hostname = "140.122.184.129:3310";
    $db_username = "team14";
    $db_password = "3n/S(z!Uk-mRxs_Z";
    $database = "team14";


    $conn = new mysqli($hostname, $db_username, $db_password, $database);
        
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM restaurant";
    $result = $conn->query($sql);

    $array = array();
    if ($result->num_rows > 0) {	
        while($row = mysqli_fetch_assoc($result)){
            array_push($array, array($row["name"], $row["id"]));
        }
    }

    $conn->close();

// Receive the data
// $radius = $_POST['radius'];
// $condition = $_POST['condition'];

// Process the data (You can call your PHP function here)
// $result = your_php_function($radius, $condition);

// Output the result as JSON
    echo json_encode($array);

// Define your_php_function to generate a 2D array
function your_php_function($input, $select) {
    // Perform your logic here to generate a 2D array
    // For example:
    $array = array(
        array("馬辣頂級麻辣鴛鴦火鍋 台北公館店", "ChIJycu5coupQjQRl9dmANfpHuw"),
        array("馬辣頂級麻辣鴛鴦火鍋 台北公館店", "ChIJycu5coupQjQRl9dmANfpHuw"),
    );
    return $array;

    //  return "<td>$input - $select</td>";
}
?>