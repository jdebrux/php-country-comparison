<?php
//SELECT Country.country_name, AVG(2012-YEAR(Cyclist.dob)) FROM `Cyclist` JOIN `Country` ON Cyclist.ISO_id = Country.ISO_id GROUP BY Cyclist.ISO_id

//database connection details
  include "connection.php";

  //create connection
  $conn = mysqli_connect($servername, $username, $password, $dbName);
  //check connection
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }
    //total medals sql
    $sqlAverageAge = "SELECT Country.ISO_id, Country.country_name, ROUND(AVG(2012-YEAR(Cyclist.dob)),1) as average_age FROM `Cyclist` JOIN `Country` ON Cyclist.ISO_id = Country.ISO_id GROUP BY Cyclist.ISO_id ORDER BY average_age DESC";
    $resultAverageAge = mysqli_query($conn,$sqlAverageAge);

    while ($row = mysqli_fetch_array($resultAverageAge, MYSQLI_ASSOC)) {
       $averageAgeArray[] = $row;
    }
    $age_value  = json_encode($averageAgeArray);
    print($age_value);

?>