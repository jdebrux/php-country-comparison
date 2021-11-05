<!DOCTYPE html>
<html lang ="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width"/>
<style>
body {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	background-color: bisque;
	color:brown;
}
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
th, td {
  padding: 5px;
  text-align: center;
  color: black;
}
</style>
<title>Athletes Task 2</title>
</head>

<body>

<?php
$dbName = "coa123cdb";
$servername = "localhost";
$username = "coa123cycle";
$password = "bgt87awx";

//create connection
$conn = mysqli_connect($servername, $username, $password, $dbName);
//check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$country_id = $_GET['country_id'];
$part_name = $_GET['part_name'];

$sql = "SELECT name, gender, height, weight FROM Cyclist WHERE ISO_id = '$country_id' AND name LIKE '%$part_name%'";

$result = mysqli_query($conn,$sql);

if(is_numeric($country_id) or is_numeric($part_name)){
  echo "ERROR: Please enter a string.";
} else {
  if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr>";
    echo "<th>Name</th>";
    echo "<th>Gender</th>";
    echo "<th>BMI</th>";
    echo "</tr>";
    // output data of each row
    while($row = mysqli_fetch_array($result)) {
      echo "<tr>";
      echo "<td>".$row['name']."</td>";
      echo "<td>".$row['gender']."</td>";
      $height = ($row['height'])/100;
      $heightSq = $height*$height;
      $weight = $row['weight'];
      $BMI = $weight/$heightSq;
      echo "<td>".round($BMI,3)."</td>";
      echo "</tr>";
    }
  } else {
    echo "0 results";
  }
  echo "</table>";
}

?>


</body>
</html>
