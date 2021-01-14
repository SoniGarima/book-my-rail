<?php
// error_reporting(E_ALL ^ E_WARNING); 
require "connectdb.php";
    session_start();
    // print_r($_SESSION);
    if(empty($_SESSION['type'])  || empty($_SESSION['auth'] || empty($_SESSION['ID']))){
      header('location:existing_admin.php');
    }
    if(!($_SESSION['auth'] == 'yes' && $_SESSION['type'] == 'admin'))
        {header('location:existing_admin.php');}
    $uu =$_SESSION['ID'];
// define variables and set to empty values
$numberErr = $sourceErr = $destErr =$dateErr=$acErr=$sleepErr= $runningErr = $lastdateErr= "";
$number = $source = $dest = $date = $ac = $sleep = $running = $last_date = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if(!empty($_POST['last_date']))
    $last_date = ($_POST["last_date"]);
  else
    $last_date= '2100-11-25';
    if (empty($_POST["number"])) {
    $numberErr = "Train Number is required";
  } else {
    $number = ($_POST["number"]);
  }
  
  if (empty($_POST["source"])) {
    $sourceErr = "source is required";
  } else {
    $source = ($_POST["source"]);
  }

  if (empty($_POST["date"])) {
    $dateErr = "Date is required";
  } else {
    $date = ($_POST["date"]);
  } 
  
  if (empty($_POST["destination"])) {
    $destErr = "Destination is required";
  } else {
    $dest = ($_POST["destination"]);
  }

  if (empty($_POST["ac"])) {
    $acErr = "Number is required";
  } else {
    $ac = ($_POST["ac"]) *18;
  } 
  
  if (empty($_POST["sleeper"])) {
    $sleepErr = "Number is required";
  } else {
    $sleep = ($_POST["sleeper"]) * 24;
  }

  if (empty($_POST["running"])) {
    $runningErr = "Status is required";
  } else {
    $running = ($_POST["running"]);
  }
}

if(isset($_POST['number']) && $numberErr =="" && $sourceErr =="" && $destErr =="" && $dateErr== "" &&$acErr=="" &&$sleepErr=="" && $runningErr == "" && $lastdateErr == ""){
    $uu =$_SESSION['ID'];
    $date_id_query = "select * from rail_data_schema.trains as T where T.train_number=$number";
    $data_check = pg_fetch_all(pg_query($date_id_query));

    $index=0;
    if(!empty($data_check)){
    for($x=0;$x<count($data_check);$x++)
    {
      if(($data_check[$x]['released_for']>$last_date or $data_check[$x]['released_till']<$date))
      { continue;}
      else
      { $index=-1;break;}
    }
  }
    if($index!=-1){
    $psql = "insert into rail_data_schema.trains(train_number,train_source,train_destination,ac_coaches, sleeper_coaches,running, released_for,released_till,released_on,admin_id) values($number, '$source', '$dest', '$ac', '$sleep','$running','$date', '$last_date',CURRENT_TIMESTAMP,'$uu')";
    
    $result = pg_query($psql);
  }
  }

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Add the trains! </title>
  <link rel="icon" href="Assets/3843.svg" type="image/gif" sizes="16x16">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link href="simple-sidebar.css" rel="stylesheet">
</head>

<body>

  <div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <div class="bg-light border-right" id="sidebar-wrapper">
    <div class="sidebar-heading">
                <tr>
                    <td><img src="Assets/3843.png" sizes="16x16"></td>
                    <td><b>bookmyrail</b></td>
                </tr>
            </div>
      <div class="list-group list-group-flush">
        <a href="index.html" class="list-group-item list-group-item-action bg-light">Home</a>
        <a href="trains.php" class="list-group-item list-group-item-action bg-light">Trains Running Today</a>
        <a href="existing_admin.php" class="list-group-item list-group-item-action bg-light">Admins</a>
        <a href="existing_user.php" class="list-group-item list-group-item-action bg-light">Users</a>
        <a href="search.php" class="list-group-item list-group-item-action bg-light">Search</a>
        <a href="bookings.php" class="list-group-item list-group-item-action bg-light">Bookings</a>
        <a href="all-users.php" class="list-group-item list-group-item-action bg-light">Users</a>
        <a href="logout.php" class= "list-group-item list-group-item-action bg-warning">Log Out</a>
      </div>
    </div>
    <!-- /#sidebar-wrapper -->
    <!-- Page Content -->
    <div id="page-content-wrapper">

      
    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom justify-content-between">
        <button class="btn btn-primary" id="menu-toggle">Toggle Menu</button>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
          
        </button>
        <form   action='tickets.php'  method="POST" class="form-inline my-2 my-lg-0 ">
      <input class="form-control mr-sm-2"name="ticket_number" type="search" placeholder="Ticket Number" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" ><a href= >Search</a></button>
    </form>
      </nav>

      <div class="container-fluid">
        <?php echo "Hello,".$_SESSION['name']."!!"?>
        <h1 class="mt-4" style="font-family: cursive;">Train Addition form</h1>
    <form style="font-family: cursive;" method="post">
        Train Number: <input type="number" name="number"><span class="error">* <?php echo $numberErr;?></span><br><br>
        Source : <input type="text" name="source"><span class="error">* <?php echo $sourceErr;?></span><br><br>
        Destination : <input type="text" name="destination"><span class="error">* <?php echo $destErr;?></span><br><br>
        AC Coach Number : <input type='number' name='ac'><span class="error">* <?php echo $acErr;?></span><br><br>
        Sleeper Coach Number: <input type='number' name='sleeper'><span class="error">* <?php echo $sleepErr;?></span><br><br>
        Date of Running: <input type='date' name='date'><span class="error">* <?php echo $dateErr;?></span><br><br>
        Last Running Date: <input type='date' name='last_date'><span class="error"> <?php echo $lastdateErr;?></span><br><br>
        Running: <input type="radio" name="running"value="yes" checked>Yes</input><input type="radio"name="running"value="no">No</input><span class="error">* <?php echo $runningErr;?></span><br><br>
        <button type="submit" class="btn btn-primary" style="font-family: cursive;">Submit</button>
    </form>
    
  <h4 style="font-family: cursive;margin: auto;text-align:center;"> TRAINS RELEASED BY YOU </h4>
  <table class="table table-dark table-striped">
    <tr>
    <th>Train ID</th>
    <th>Train Number</th>
    <th>Source</th>
    <th>Destination</th>
    <th>Running</th>
    <th>Released from</th>
    <th>Released Till</th>
  </tr>
      <?php
      $uu =$_SESSION['ID'];
      $fetch_trains = "Select  T.train_number,T.train_source,T.train_destination,T.running,T.train_id,T.released_for,T.released_till from  rail_data_schema.trains as T where T.admin_id = '$uu' and T.released_till >= CURRENT_DATE";
      $trains_from_this_admin = pg_query($fetch_trains);
      while($data = pg_fetch_row($trains_from_this_admin)){
        if($data[3]=='t')
        $data[3]='YES';
        else$data[3]='NO';
          echo "<tr>
                  <td>$data[4]</td>
                  <td>$data[0]</td>
                  <td>$data[1]</td>
                  <td>$data[2]</td>
                  <td>$data[3]</td>
                  <td>$data[5]</td>
                  <td>$data[6]</td>
                </tr>";
      }
      ?>
    </table>
      </div>
    </div>
    <!-- /#page-content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

  <!-- Menu Toggle Script -->
  <script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });
  </script>

</body>

</html>
