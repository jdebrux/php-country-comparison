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

$date_1 = $_GET['date_1'];
$date_1 = str_replace('/', '-', $date_1);
$date_2 = $_GET['date_2'];
$date_2 = str_replace('/', '-', $date_2);

$date_1 = date('Y-m-d', strtotime($date_1));
$date_2 = date('Y-m-d', strtotime($date_2));


//echo "Results between ".$date_1." and ".$date_2."<br>";
$sql = "SELECT Cyclist.name, Country.country_name, Country.gdp, Country.population FROM Cyclist, Country WHERE Cyclist.dob BETWEEN "."'".$date_1."' AND '".$date_2."' AND Cyclist.ISO_id = Country.ISO_id";

$result = mysqli_query($conn,$sql);
//print_r(json_encode($result));

if ($result->num_rows > 0) {
  // output data of each row
  while($row = mysqli_fetch_array($result)) {
    echo json_encode($row);
  }
} else {
  echo "0 results";
}

?>


</body>
</html>
