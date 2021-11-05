<?php
    //database connection details
    include "connection.php";

    //create connection
    $conn = mysqli_connect($servername, $username, $password, $dbName);
    //check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    //total cyclists sql
    $sqlCyclistTotal = "SELECT Country.ISO_id,Country.country_name, count(Cyclist.name) as total_cyclists FROM Cyclist INNER JOIN Country ON Cyclist.ISO_id = Country.ISO_id GROUP BY Country.country_name  ORDER BY total_cyclists DESC";
    $resultCyclistTotal = mysqli_query($conn,$sqlCyclistTotal);

    while ($row = mysqli_fetch_array($resultCyclistTotal, MYSQLI_ASSOC)) {
       $cyclitsDataArray[] = $row;
    }
    $cyclists_value = json_encode($cyclitsDataArray);
    print($cyclists_value);
?>