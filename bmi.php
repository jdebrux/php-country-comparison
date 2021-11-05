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
<title>BMI Task 1</title>
</head>

<body>


<?php
$min_weight = $_GET['min_weight'];
$max_weight = $_GET['max_weight'];
$min_height = $_GET['min_height'];
$max_height = $_GET['max_height'];

if(is_numeric($min_weight) and is_numeric($max_weight) and is_numeric($min_height) and is_numeric($max_height)) {

	echo "<b>Min Height:</b> ".$min_height." ";
	echo "<b>Max Height:</b> ".$max_height."<br>";
	echo "<b>Min Weight:</b> ".$min_weight." ";
	echo "<b>Max Weight:</b> ".$max_weight;

	echo "<table>";
	//height row/columns
	echo "<tr>";
	echo "<th> HEIGHT &#8594 <br> WEIGHT &#8595 </th>";
	for ($i=$min_height; $i<=$max_height; $i+=5) { 
		echo "<th>".$i."</th>";
	}
	echo "</tr>";
	//weight rows
	for ($j=$min_weight; $j<=$max_weight; $j+=5) { 
		echo "<tr>";
			echo "<th>".$j."</th>";
			for ($x=$min_height; $x <=$max_height; $x+=5) {
				$bmi = ($j / ($x*$x))*10000;
				echo "<td>".round($bmi,3)."</td>";
			}
		echo "</tr>";
	}

	/*for ($i=$min_weight; $i<=$max_weight; $i+=5) { //rows
		echo "<tr>";
		echo "<th>".$i."</th>";
		for ($j=$min_height; $j<=$max_height ; $j+=5) { //cols
			echo "<th>".$j."</th>";
		}
		echo "</tr>";
	}*/

	echo "</table>";
} else {
	echo "<br>Error: All inputs must be numbers.";
}

?>
</body>
</html>
