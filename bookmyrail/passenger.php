<?php
    session_start();
    require "connectdb.php";
    
if(($_SERVER["REQUEST_METHOD"] == "POST"))
{
    for($i=0;$i<$_SESSION['qty'];$i++)
    {
        $name=$_POST["name$i"];
        $age=$_POST["age$i"];
        $gender=$_POST["gender$i"];
        $tt=$_SESSION['ticket_number'];
        $dd=$_SESSION['date']; 
        $cc=$_SESSION['current_number'];
        $ticket=$_SESSION['qty'];
        $coach=$_SESSION['coach'];
        $ccc=$cc+$i;
        if($coach=='ac'){
            $coach_no=floor(($ccc+18)/18);
            $berth_no=$ccc%18+1;
        }
        else{
            $coach_no=floor(($ccc+24)/24);
            $berth_no=$ccc%24+1;
        }
        $fetch_berths = "Select B.type from rail_data_schema.berths as B where B.coach='$coach' and B.berth_number=$berth_no";
        $berths_with_this_number = pg_query($fetch_berths);
        $data = pg_fetch_row($berths_with_this_number);


        $psql = "insert into rail_data_schema.passengers(ticket_no,name,age,gender,coach_no,berth_no,berth_type,date) values('$tt','$name','$age','$gender', '$coach_no', '$berth_no','$data[0]','$dd')";
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
  <title>Passengers details</title>
  <link rel="icon" href="Assets/3843.svg" type="image/gif" sizes="16x16">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link href="simple-sidebar.css" rel="stylesheet">
</head>

<body>

  <div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <div class="bg-light border-right" id="sidebar-wrapper">
      <div class="sidebar-heading"><b>bookmyrail</b></div>
      <div class="list-group list-group-flush">
        <a href="index.html" class="list-group-item list-group-item-action bg-light">Home</a>
        <a href="trains.php" class="list-group-item list-group-item-action bg-light">Trains Running Today</a>
        <a href="existing_admin.php" class="list-group-item list-group-item-action bg-light">Admins</a>
        <a href="existing_user.php" class="list-group-item list-group-item-action bg-light">Users</a>
        <a href="search.php" class="list-group-item list-group-item-action bg-light">Search</a>
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
          <h1 style="font-family: cursive;">Ticket Details Page</h1>
<form method="post">
<?php
if(($_SERVER["REQUEST_METHOD"] == "GET"))
{
for($i=0;$i<$_SESSION['qty'];$i++)
{

echo " <label style=\"font-family: cursive;\">NAME</label> <input type='text' name='name$i'> <br>
<label style=\"font-family: cursive;\">AGE</label><input type='number' name='age$i'> <br>
<label style=\"font-family: cursive;\">GENDER</label><input type='radio' name='gender$i' value='Male' checked>Male</input><input type='radio' name='gender$i' value='female'>Female</input> <br><br>";

}
echo "<button type=\"submit\" class=\"btn btn-primary\" style=\"font-family: cursive;\">Submit</button>";
}
if(($_SERVER["REQUEST_METHOD"] == "POST"))
{
    $uu=$_SESSION['ticket_number'];
    $fetch_trains = "select * from rail_data_schema.passengers where rail_data_schema.passengers.ticket_no=$uu";
      $trains_from_this_admin = pg_query($fetch_trains);
      $fetch_type = "select tickets.coach from rail_data_schema.tickets where rail_data_schema.tickets.ticket_no=$uu";
      $type = pg_fetch_row(pg_query($fetch_type));
        echo "<table class='table table-dark table-striped'>
        <tr>
        <th>Ticket Number</th>
        <th>Name</th>
        <th>Age</th>
        <th>Gender</th>
        <th>Coach Number</th>
        <th>Coach Type</th>
        <th>Berth Number</th>
        <th>Berth Type</th>
        <th> Date</th>
        </tr>";
        while($data = pg_fetch_row($trains_from_this_admin)){
            echo "<tr>
                    <td>$data[0]</td>
                    <td>$data[1]</td>
                    <td>$data[2]</td>
                    <td>$data[3]</td>
                    <td>$data[4]</td>
                    <td>$type[0]</td>
                    <td>$data[5]</td>
                    <td>$data[6]</td>
                    <td>$data[7]</td>
                </tr>";
        }
}
?>
</form>
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
