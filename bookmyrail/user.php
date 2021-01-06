<?php
//error_reporting(E_ALL ^ E_WARNING); 
    session_start();
    require "connectdb.php";

    $numberErr = $ticketErr = $coachErr =$idErr= $dateErr= "";
    $ticket = $coach = $date= "";
    $id=0;
    $number="0";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (empty($_POST["number"])) {
        $numberErr = "Train Number is required";
      } else {
        $number = ($_POST["number"]);
      }
      if (empty($_POST["id"])) {
        $idErr = "Train ID is required";
      } else {
        $id = ($_POST["id"]);
      }
      if (empty($_POST["ticket"])) {
        $ticketErr = "Number of tickets is required";
      } else {
        $ticket = ($_POST["ticket"]);
      }
        
      if (empty($_POST["coach"])) {
        $coachErr = "Destination is required";
      } else {
        $coach = ($_POST["coach"]);
      }
    
      if (empty($_POST["date"])) {
        $dateErr = "Date is required";
      } else {
        $date = ($_POST["date"]);
      }
    
    $uu =$_SESSION['ID'];

    $fetch_trains = "Select * from rail_data_schema.trains as T where T.train_number = '$number' and T.train_id='$id'";
    $trains_with_this_number = pg_query($fetch_trains);
    $data = pg_fetch_row($trains_with_this_number);
    $status = $data[6];
    $last_date = $data[8];
    $min_date = $data[7];
    // echo $data[5];
    if(($_SERVER["REQUEST_METHOD"] == "POST"))
    {
      $ac_seats=$data[4];
      $sleeper_seats=$data[5];
    }    
    if($date < date("Y-m-d")){
      echo "Please enter a valid Date :/";
    }
    if($status == 't' and $date >= $min_date and $date <= $last_date and $date>=date("Y-m-d")){
      $fetch_info = "select * from rail_data_schema.bookings as B , rail_data_schema.calender as C where B.date_dim_id = C.date_dim_id and C.date_actual = '$date' and B.train_number = '$number' and B.train_id=$id";
      
      $info = pg_fetch_row(pg_query($fetch_info));
      $q5 = "select * from rail_data_schema.calender as C where C.date_actual = '$date'";
      $date_dim_id = pg_fetch_row(pg_query($q5));
      if($info){
        $ac_booked = $info[2];
        $sleeper_booked = $info[3];
      }
      else{
        $ac_booked = 0;
        $sleeper_booked = 0;
        pg_query("insert into rail_data_schema.bookings(date_dim_id, train_number,train_id,ac_booked, sleeper_booked) values('$date_dim_id[0]','$number','$id' , 0,0)");
      }
    }
    if(isset($_POST['number']) && $numberErr =="" && $ticketErr =="" && $coachErr =="" &&  $data && $date>=$data[7] && $date <= $last_date &&  $date>=date("Y-m-d") && (($coach=='ac'&& $ticket+$ac_booked<=$ac_seats)||($coach=='sleeper' && $ticket+$sleeper_booked<=$sleeper_seats)) && $status == 't' ){
        // print("Your Train exists\n");
        $tt=time();
        $psql = "insert into rail_data_schema.tickets(ticket_no,train_number,train_id,num_of_ticket,coach,booked, released_on) values('$tt','$number','$id','$ticket', '$coach', 'YES',CURRENT_TIMESTAMP)";
        $psql2 = "insert into rail_data_schema.books(user_id,train_number,train_id,ticket_number) values('$uu','$number','$id','$tt')";

        if($coach=='ac'){
          $cc=$ac_booked;
          $ac_booked=$ac_booked+$ticket;
          $psql3 = "update rail_data_schema.bookings set ac_booked='$ac_booked' where train_number='$number' and train_id='$id' and date_dim_id = '$date_dim_id[0]'";
        }
        else if($coach=='sleeper'){
          $cc=$sleeper_booked;
          $sleeper_booked=$sleeper_booked+$ticket;
          $psql3 = "update rail_data_schema.bookings set sleeper_booked='$sleeper_booked' where train_number='$number'and train_id='$id'and date_dim_id = '$date_dim_id[0]'";
        }
        $result = pg_query($psql);
        $result2 = pg_query($psql2);
        $result3=pg_query($psql3);
        if($result){
          echo "first";
        }
        if($result2){
          echo "second";
        }
        if($result3){
          echo "third";
        }
        if($result and $result2 and $result3){
            echo "success";
            $_SESSION['ticket_number'] = $tt;
            $_SESSION['current_number']=$cc;
            $_SESSION['qty']=$ticket;
            $_SESSION['date']=$date;
            $_SESSION['coach']=$coach;

            header("Location:passenger.php");
        }
        else{
            echo " ERRrrtr";
        }
        if(isset($_POST['number']) && !$data)
        {
            echo "\nMaybe the train does not exist";
        }
       else{
         echo 'SORRY :(';
       }
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
  <title>Book your rail</title>
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
      <?php echo "Hello,".$_SESSION['name']."!!"?>
        <h1 class="mt-4" style="font-family: cursive;">Ticket Booking form</h1>
    <form style="font-family: cursive;" method="post">
        Train ID: <input type="number" name="id"><span class="error">* <?php echo $idErr;?></span><br><br>
        Train Number: <input type="number" name="number"><span class="error">* <?php echo $numberErr;?></span><br><br>
        Number of Tickets <input type="number" name="ticket"><span class="error">* <?php echo $ticketErr;?></span><br><br>
        Date of Journey <input type="date" name="date"><span class="error">* <?php echo $dateErr;?></span><br><br>
        Coach: <input type="radio" name="coach"value="ac" checked>AC</input><input type="radio"name="coach"value="sleeper">Sleeper</input><span class="error">* <?php echo $coachErr;?></span><br><br>
        <input type="submit">
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
