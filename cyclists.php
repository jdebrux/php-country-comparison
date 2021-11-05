<?php
  //database connection details
  include "connection.php";

  //create connection
  $conn = mysqli_connect($servername, $username, $password, $dbName);
  //check connection
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

    $country_idA = $_REQUEST['country_idA'];
    $country_idB = $_REQUEST['country_idB'];

    //country names sql
    $sqlCountryNameA = "SELECT country_name FROM `Country` WHERE ISO_id = '$country_idA'";
    $resultCountryNameA = mysqli_query($conn,$sqlCountryNameA);
    $sqlCountryNameB = "SELECT country_name FROM `Country` WHERE ISO_id = '$country_idB'";
    $resultCountryNameB = mysqli_query($conn,$sqlCountryNameB);

    $name_a = mysqli_fetch_array($resultCountryNameA)['country_name'];
    $name_b = mysqli_fetch_array($resultCountryNameB)['country_name'];

    //cyclists list sql
    $sqlCyclists = "SELECT Country.country_name, Cyclist.name FROM Cyclist INNER JOIN Country ON Country.ISO_id = Cyclist.ISO_id WHERE Cyclist.ISO_id IN ('".$country_idA."','".$country_idB."') ORDER BY Country.country_name, Cyclist.name";
    $resultCyclists = mysqli_query($conn,$sqlCyclists);
    while ($row = mysqli_fetch_array($resultCyclists, MYSQLI_ASSOC)) {
       $cylclistsDataArray[] = $row;
    }
    $cyclist_value = json_encode($cylclistsDataArray);
    print($cyclist_value);
?>