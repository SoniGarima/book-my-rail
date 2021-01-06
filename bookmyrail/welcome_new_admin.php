<?php
   require "connectdb.php";
   if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])){

      $psql = "insert into rail_data_schema.admins(name,email,password,created_on) values('$_POST[name]','$_POST[email]','$_POST[password]',CURRENT_TIMESTAMP)";

      $result = pg_query($psql); 
      if($result){
         echo "Hello there $_POST[name]";
         header("Location:existing_admin.php");
      }
      else{
         $error = pg_last_error($db);
         $Message = urlencode("Some error occured please try after some time ");
         die;
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
  <title>Sign up new admin!</title>
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
        <h1 class="mt-4" style="font-family: cursive;">Sign up form</h1>
        
    <form method="post">

    <div class="form-group">
    <label for="exampleInputEmail1" style="font-family: cursive;">Name</label>
    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="name" placeholder="Enter Name">
    
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1" style="font-family: cursive;">Email address</label>
    <input type="" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" placeholder="Enter email">
    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1" style="font-family: cursive;">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password">
  </div>
  <button type="submit" class="btn btn-primary" style="font-family: cursive;">Submit</button>
</form>

    <p style="font-family: cursive;">Have an account??
        <a href="existing_admin.php">Click ME</a>
    </p>
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
