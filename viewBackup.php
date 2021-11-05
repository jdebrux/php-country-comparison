<!DOCTYPE html>
<html>
<head>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Quicksand:300,500" rel="stylesheet">
<title>Country Comparison</title>
<link rel="stylesheet" href="stylesheet.css">
</head>
<body style="margin: 0">
    <header>
      <h1>&#127941;COUNTRY COMPARISON&#128692;</h1>
    </header>

<?php
  //database connection details
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

  //sql get ISO_ids
  $sqlISO = "SELECT DISTINCT ISO_id FROM Cyclist ORDER BY ISO_id";
  $resultISO = mysqli_query($conn,$sqlISO);

  print "
    <form action='' method='post' class='form'>
      <label for='country_idA'>First Country ID:</label>
      <select name='country_idA' id='country_idA'>";
      while($row = mysqli_fetch_array($resultISO)) {
        print "<option value='{$row['ISO_id']}'>{$row['ISO_id']}</option>";
      }
      print "</select>";

      $resultISO = mysqli_query($conn,$sqlISO);

      print"<label for='country_idB'>Second Country ID:</label>
      <select name='country_idB' id='country_idB'>";
      while($row = mysqli_fetch_array($resultISO)) {
        print "<option value='{$row['ISO_id']}'>{$row['ISO_id']}</option>";
      }
      print "</select>

      <input type='checkbox' id='totalMedals' name='totalMedals' value='total'>
      <label for='totalMedals'>Total Medals</label>

      <input type='checkbox' id='totalGolds' name='totalGolds' value='golds'>
      <label for='totalGolds'>Gold Medals</label>

      <input type='checkbox' id='totalCyclists' name='totalCyclists' value='totalCyclists'>
      <label for='totalCyclists'>Total Cyclists</label>

      <input type='submit' name='submit' id='submit' value='submit'>
    </form>";

  if(isset($_REQUEST['submit'])){

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
    //total medals sql
    $sqlAllMedals = "SELECT country_name, sum(total) as medal_total FROM Country GROUP BY country_name ORDER BY medal_total DESC";
    $resultAllMedals = mysqli_query($conn,$sqlAllMedals);
    //total gold medals sql
    $sqlGoldMedals = "SELECT country_name, sum(gold) as gold_total FROM `Country` GROUP BY country_name ORDER BY sum(gold) DESC";
    $resultGoldMedals = mysqli_query($conn,$sqlGoldMedals);
    //total cyclists sql
    $sqlCyclistTotal = "SELECT Country.country_name, count(Cyclist.name) as total_cyclists FROM Cyclist INNER JOIN Country ON Cyclist.ISO_id = Country.ISO_id GROUP BY Country.country_name  ORDER BY total_cyclists DESC";
    $resultCyclistTotal = mysqli_query($conn,$sqlCyclistTotal);

    echo "<section class='aside'>";
        //cyclists output
        $prev_country = '';
        while($row = mysqli_fetch_array($resultCyclists)) {
          if($row['country_name'] != $prev_country) {
            if($prev_country != '') {
              print "</ul></div>";
            }
          
            print "
            <div class = 'cyclists'>
              <h1>{$row['country_name']}</h1>
              <ul>";
          }
          print "<li>".$row['name']."</li>";
          $prev_country = $row['country_name'];
        }
        print "
              </ul>
          </div>
          </section>
        ";

        echo "<section class='content'>";
        if(isset($_REQUEST['totalMedals'])){
        //total medals output
        print "<table class = 'data'>
          <tr>
            <th>Country</th>
            <th>Total Medals Won</th>
            <th>Rank</th>
          </tr>";

        if ($resultAllMedals->num_rows > 0) {
          // output data of each row
          $rank=0;
          while($row = mysqli_fetch_array($resultAllMedals)) {
            $rank++;
            $class = '';
            if(($row['country_name']==$name_a) OR (($row['country_name']==$name_b))){
              $class = 'selected';
            }
            print "<tr class='$class'>
               <td>{$row['country_name']}</td>
               <td>{$row['medal_total']}</td>
               <td>$rank</td>
            </tr>";
          }
        } else {
          echo "0 results";
        }
        echo "</table><br>";
      }

      if(isset($_REQUEST['totalGolds'])){
        //gold medals output
        print "<table class = 'data'>
          <tr>
            <th>Country</th>
            <th>Gold Medals Won</th>
            <th>Rank</th>
          </tr>";

        if ($resultGoldMedals->num_rows > 0) {
          // output data of each row
          $rank=0;
          while($row = mysqli_fetch_array($resultGoldMedals)) {
            $rank++;
            $class = '';
            if(($row['country_name']==$name_a) OR (($row['country_name']==$name_b))){
              $class = 'selected';
            }
            print "<tr class='$class'>
               <td>{$row['country_name']}</td>
               <td>{$row['gold_total']}</td>
               <td>$rank</td>
            </tr>";
          }
        } else {
          echo "0 results";
        }
        echo "</table> <br>";
      }

      if(isset($_REQUEST['totalCyclists'])){
        //total cylists output
        print "<table class='data'>
          <tr>
            <th>Country</th>
            <th>Total Cyclists</th>
            <th>Rank</th>
          </tr>";

        if ($resultCyclistTotal->num_rows > 0) {
          // output data of each row
          $rank=0;
          while($row = mysqli_fetch_array($resultCyclistTotal)) {
            $rank++;
            $class = '';
            if(($row['country_name']==$name_a) OR (($row['country_name']==$name_b))){
              $class = 'selected';
            }
            print "<tr class='$class'>
               <td>{$row['country_name']}</td>
               <td>{$row['total_cyclists']}</td>
               <td>$rank</td>
            </tr>";
          }
        } else {
          echo "0 results";
        }
        echo "</table> <br>";
      }
    echo "</section>";
  }
?>
</body>
</html>
