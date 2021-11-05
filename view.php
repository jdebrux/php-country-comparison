<?php
  //database connection details
  include "connection.php";

  //create connection
  $conn = mysqli_connect($servername, $username, $password, $dbName);
  //check connection
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,500" rel="stylesheet">

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Country Comparison</title>
    <link rel="stylesheet" href="stylesheet.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        $(document).ready(function(){
          $('#cyclistForm').on('submit', function(e){
            var countryA='';
            var countryB='';
            $('#stub2').empty();
            $('#stub4').empty();
            $('#stub6').empty();
            $('#stub8').empty();
            $('#stub10').empty();
            e.preventDefault();
            var country_a = $('#country_idA').val();
            var country_b = $('#country_idB').val();
            countryA+="<h1>"+country_a+"</h1>";
            countryB+="<h1>"+country_b+"</h1>";
            if(country_a === country_b){
              alert("Please make sure the input countries do not match, and that you have selected an input for both fields.");
            } else {
            //alert(country_a + country_b);
            $.get('cyclists.php', {country_idA: country_a, country_idB: country_b},function(value,responseStatus){
              //$("#stub1").text("Detailed value from JSON: " + value);
               var arrayOfCyclists = JSON.parse(value);
               var prevCountry = '';
               var output='';
              for(country in arrayOfCyclists) {
              if(arrayOfCyclists[country].country_name != prevCountry){
                if(prevCountry != ''){
                  output+="</ul></div><br>";
                  //countryB+="<h1>"+arrayOfCyclists[country].country_name+"</h1>";
                } else {
                  //countryA+="<h1>"+arrayOfCyclists[country].country_name+"</h1>";
                }
                output+="<div class = 'cyclists'> <h1>"+arrayOfCyclists[country].country_name+"</h1><ul>";
              }
              output+="<li>"+arrayOfCyclists[country].name+"</li>";
              prevCountry = arrayOfCyclists[country].country_name;
            }
            output+="</ul></div></section>";
            $("#stub2").html(output);
            });

            var totalMedalsChecked = $('#totalMedals:checkbox:checked').length > 0;
            if(totalMedalsChecked){ //total medals table output
              $.get('totalMedals.php',function(value,responseStatus){
                //$("#stub3").text("Detailed value from JSON: " + value);
                var arrayOfCountries = JSON.parse(value);
                var prevCountry = '';
                var totalMedalsOut='';
                totalMedalsOut +="<div class='scroll-y scrollbar'>"
                +"<table class = 'table table-hover table-dark'><tr><th>Country</th><th>Total Medals Won</th><th>Rank</th></tr>";
                var rank=0;
                for(country in arrayOfCountries) {
                  rank++;
                  var class_name = '';
                  if((arrayOfCountries[country].ISO_id===country_a) || ((arrayOfCountries[country].ISO_id===country_b))){
                    class_name = 'selected';
                    if(arrayOfCountries[country].ISO_id===country_a){
                      countryA+="<p>Total Medals: "+arrayOfCountries[country].medal_total+"</p>";
                    } else if (arrayOfCountries[country].ISO_id===country_b){
                      countryB+="<p>Total Medals: "+arrayOfCountries[country].medal_total+"</p>";
                    }
                  }
                  totalMedalsOut+="<tr class='"+class_name+"'>"+
                     "<td>"+arrayOfCountries[country].country_name+"</td>"+
                     "<td>"+arrayOfCountries[country].medal_total+"</td>"+
                     "<td>"+rank+"</td>"+
                    "</tr>";
                }
                totalMedalsOut+='</table></div>';
                $("#stub4").html(totalMedalsOut);
              });
            }

            var totalGoldsChecked = $('#totalGolds:checkbox:checked').length > 0;
            if(totalGoldsChecked){//total golds table output
              $.get('totalGold.php',function(value,responseStatus){
                //$("#stub5").text("Detailed value from JSON: " + value);
                var arrayOfCountries = JSON.parse(value);
                var prevCountry = '';
                var goldMedalsOut='';
                goldMedalsOut +="<div class='scroll-y scrollbar'>"
                +"<table class='table table-hover table-dark'><tr><th>Country</th><th>Gold Medals Won</th><th>Rank</th></tr>";
                var rank=0;
                for(country in arrayOfCountries) {
                  rank++;
                  var class_name = '';
                  if((arrayOfCountries[country].ISO_id===country_a) || ((arrayOfCountries[country].ISO_id===country_b))){
                    class_name = 'selected';
                    if(arrayOfCountries[country].ISO_id===country_a){
                      countryA+="<p>Total Gold Medals: "+arrayOfCountries[country].gold_total+"</p>";
                    } else if (arrayOfCountries[country].ISO_id===country_b){
                      countryB+="<p>Total Gold Medals: "+arrayOfCountries[country].gold_total+"</p>";
                    }
                  }
                  goldMedalsOut+="<tr class='"+class_name+"'>"+
                     "<td>"+arrayOfCountries[country].country_name+"</td>"+
                     "<td>"+arrayOfCountries[country].gold_total+"</td>"+
                     "<td>"+rank+"</td>"+
                    "</tr>";
                }
                goldMedalsOut+="</div>";
                $("#stub6").html(goldMedalsOut);
              });
            }
            
            var totalCyclistsChecked = $('#totalCyclists:checkbox:checked').length > 0;
            if(totalCyclistsChecked){ //total cyclists table output
              $.get('totalCyclists.php',function(value,responseStatus){
                //$("#stub7").text("Detailed value from JSON: " + value);
                var arrayOfCountries = JSON.parse(value);
                var prevCountry = '';
                var totalCyclistsOut='';
                totalCyclistsOut +="<div class='scroll-y scrollbar'>"
                +"<table class='table table-hover table-dark'><tr><th>Country</th><th>Total Cyclists</th><th>Rank</th></tr>";
                var rank=0;
                for(country in arrayOfCountries) {
                  rank++;
                  var class_name = '';
                  if((arrayOfCountries[country].ISO_id===country_a) || ((arrayOfCountries[country].ISO_id===country_b))){
                    class_name = 'selected';
                    if(arrayOfCountries[country].ISO_id===country_a){
                      countryA+="<p>Total Cyclists: "+arrayOfCountries[country].total_cyclists+"</p>";
                    } else if (arrayOfCountries[country].ISO_id===country_b){
                      countryB+="<p>Total Cyclists: "+arrayOfCountries[country].total_cyclists+"</p>";
                    }
                  }
                  totalCyclistsOut+="<tr class='"+class_name+"'>"+
                     "<td>"+arrayOfCountries[country].country_name+"</td>"+
                     "<td>"+arrayOfCountries[country].total_cyclists+"</td>"+
                     "<td>"+rank+"</td>"+
                    "</tr>";
                }
                totalCyclistsOut+="</div>";
                $("#stub8").html(totalCyclistsOut);
              });
            }
            

            var averageAgeChecked = $('#averageAge:checkbox:checked').length > 0;
            if(averageAgeChecked){ //average age table output
              $.get('averageAge.php',function(value,responseStatus){
                //$("#stub9").text("Detailed value from JSON: " + value);
                var arrayOfCountries = JSON.parse(value);
                var prevCountry = '';
                var averageAgeOut='';
                averageAgeOut +="<div class='scroll-y scrollbar'>"
                +"<table class='table table-hover table-dark'><tr><th>Country</th><th>Average Age</th><th>Rank</th></tr>";
                var rank=0;
                for(country in arrayOfCountries) {
                  rank++;
                  var class_name = '';
                  if((arrayOfCountries[country].ISO_id===country_a) || ((arrayOfCountries[country].ISO_id===country_b))){
                    class_name = 'selected';
                    if(arrayOfCountries[country].ISO_id===country_a){
                      countryA+="<p>Average Age of Cyclists: "+arrayOfCountries[country].average_age+"</p>";
                    } else if (arrayOfCountries[country].ISO_id===country_b){
                      countryB+="<p>Average Age of Cyclists: "+arrayOfCountries[country].average_age+"</p>";
                    }
                  }
                  averageAgeOut+="<tr class='"+class_name+"'>"+
                     "<td>"+arrayOfCountries[country].country_name+"</td>"+
                     "<td>"+arrayOfCountries[country].average_age+"</td>"+
                     "<td>"+rank+"</td>"+
                    "</tr>";
                }
                averageAgeOut+="</div>";
                $("#stub10").html(averageAgeOut);
                $("#name_a").html("<div class='summary'>"+countryA+"</div>");
                $("#name_b").html("<div class='summary'><h1>"+countryB+"</h1></div>");
              });
            }
          }
          });
        });
    </script>
  </head>
  <body style="margin: 0">

    <?php
      //sql get ISO_ids
      $sqlISO = "SELECT DISTINCT ISO_id FROM Cyclist ORDER BY ISO_id";
      $resultISO = mysqli_query($conn,$sqlISO);

      print "
        <form action='' method='post' id='cyclistForm' class='filters'>
          <div class='form-row align-items-center'>
            <div class='col-auto'>
              <select name='country_idA' id='country_idA' class='form-control form-control-sm'>
                <option selected disabled hidden>First Country ID</option>";
                while($row = mysqli_fetch_array($resultISO)) {
                  print "<option value='{$row['ISO_id']}'>{$row['ISO_id']}</option>"; //fill form options with countries that have data in Cyclist
                }
              print "</select>
            </div>";
            

            $resultISO = mysqli_query($conn,$sqlISO);

            print"
            <div class='col-auto'>
              <select name='country_idB' id='country_idB' class='form-control form-control-sm'>
                <option selected disabled hidden>Second Country ID</option>";
                while($row = mysqli_fetch_array($resultISO)) {
                  print "<option value='{$row['ISO_id']}'>{$row['ISO_id']}</option>";
                }
              print "</select>
            </div>

            <div class='form-check form-check-inline'>
              <input class='form-check-input' type='checkbox' id='totalMedals' name='totalMedals' value='total'>
              <label for='totalMedals'>Total Medals</label>
            </div>

            <div class='form-check form-check-inline'>
              <input class='form-check-input' type='checkbox' id='totalGolds' name='totalGolds' value='golds'>
              <label for='totalGolds'>Gold Medals</label>
            </div>

            <div class='form-check form-check-inline'>
              <input class='form-check-input' type='checkbox' id='totalCyclists' name='totalCyclists' value='totalCyclists'>
              <label for='totalCyclists'>Total Cyclists</label>
            </div>

            <div class='form-check form-check-inline'>
              <input class='form-check-input' type='checkbox' id='averageAge' name='averageAge' value='averageAge'>
              <label for='averageAge'>Average Age</label>
            </div>

            <div class='col-auto'>
              <button type='submit' name='submit' id='submit' class='btn btn-primary'>Submit</button>
            </div>
          </div>
        </form>";
    ?>

    <header>
      <h1>&#127941;COUNTRY COMPARISON&#128692;</h1>
    </header>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-3">
      <p id="stub2"></p>
    </div>
    <div class="col-md-9">
      <div class="row">
        <div class="col-md-6">
          <p id=name_a></p>          
        </div>
        <div class="col-md-6">
          <p id=name_b></p>          
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <p id="stub4"></p>
        </div>
        <div class="col-md-6">
          <p id="stub6"></p>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <p id="stub8"></p>
        </div>
        <div class="col-md-6">
          <p id="stub10"></p>
        </div>
      </div>
    </div>
  </div>
</div>
   

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

  </body>
</html>
