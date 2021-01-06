<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Search Trains</title>
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
          <h1 style="font-family: cursive;">Search trains</h1>
<form method="post">
<?php
    session_start();
    require "connectdb.php";

if(($_SERVER["REQUEST_METHOD"] == "GET"))
{
echo " <label style=\"font-family: cursive;\">Source</label> <input type='text' name='source'><br> 
<label style=\"font-family: cursive;\">Destination</label> <input type='text' name='dest'>"; 
echo "<br><button type=\"submit\" class=\"btn btn-primary\" style=\"font-family: cursive;\">Submit</button>";
}
if(($_SERVER["REQUEST_METHOD"] == "POST"))
{
    
    if($_POST['source']){
    $uu=$_POST['source'];
    $fetch_trains = "select * from rail_data_schema.trains where '$uu' like rail_data_schema.trains.train_source";
      $trains_from_this_source = pg_query($fetch_trains);
        echo "
        <h4>Trains from the source</h4>
        <table class='table table-dark table-striped'>
        <tr>
        <th>Train ID</th>
        <th>Train Number</th>
        <th>Source</th>
        <th>Destination</th>
        <th>AC Coaches</th>
        <th>Sleeper Coaches</th>
        <th>Running or Not</th>
        <th>Released for</th>
        <th>Released till</th>
        </tr>";

        $data=pg_fetch_all($trains_from_this_source);
        while($data = pg_fetch_row($trains_from_this_source)){
            echo "<tr>
                    <td>$data[0]</td>
                    <td>$data[1]</td>
                    <td>$data[2]</td>
                    <td>$data[3]</td>
                    <td>$data[4]</td>
                    <td>$data[5]</td>
                    <td>$data[6]</td>
                    <td>$data[7]</td>
                    <td>$data[8]</td>
                </tr>
                ";
        }
    }
    echo "</table>";
    if($_POST['dest']){
    $uu=$_POST['dest'];
    $fetch_trains = "select * from rail_data_schema.trains where '$uu' like rail_data_schema.trains.train_destination";
        $trains_to_this_dest = pg_query($fetch_trains);
        echo "
        <h4>Trains from the source</h4>
        <table class='table table-dark table-striped'>
        <tr>
        <th>Train ID</th>
        <th>Train Number</th>
        <th>Source</th>
        <th>Destination</th>
        <th>AC Coaches</th>
        <th>Sleeper Coaches</th>
        <th>Running or Not</th>
        <th>Released for</th>
        <th>Released till</th>
        </tr>";
        while($data = pg_fetch_row($trains_to_this_dest)){
            echo "<tr>
                    <td>$data[0]</td>
                    <td>$data[1]</td>
                    <td>$data[2]</td>
                    <td>$data[3]</td>
                    <td>$data[4]</td>
                    <td>$data[5]</td>
                    <td>$data[6]</td>
                    <td>$data[7]</td>
                    <td>$data[8]</td>
                </tr>
            ";
        }
    }
    echo "</table>";
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
