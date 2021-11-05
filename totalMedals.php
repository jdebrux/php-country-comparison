<?php
  //database connection details
  include "connection.php";

  //create connection
  $conn = mysqli_connect($servername, $username, $password, $dbName);
  //check connection
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }
    //total medals sql
    $sqlAllMedals = "SELECT ISO_id, country_name, sum(total) as medal_total FROM Country GROUP BY country_name ORDER BY medal_total DESC";
    $resultAllMedals = mysqli_query($conn,$sqlAllMedals);

    while ($row = mysqli_fetch_array($resultAllMedals, MYSQLI_ASSOC)) {
       $totalMedalsDataArray[] = $row;
    }
    $total_value = json_encode($totalMedalsDataArray);
    print($total_value);

?>