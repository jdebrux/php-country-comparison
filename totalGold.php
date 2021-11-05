<?php
	//database connection details
	include "connection.php";

	//create connection
	$conn = mysqli_connect($servername, $username, $password, $dbName);
	//check connection
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

	//total gold medals sql
    $sqlGoldMedals = "SELECT ISO_id, country_name, sum(gold) as gold_total FROM `Country` GROUP BY country_name ORDER BY sum(gold) DESC";
    $resultGoldMedals = mysqli_query($conn,$sqlGoldMedals);

    while ($row = mysqli_fetch_array($resultGoldMedals, MYSQLI_ASSOC)) {
       $goldMedalsDataArray[] = $row;
    }
    $gold_value = json_encode($goldMedalsDataArray);
    print($gold_value);
?>