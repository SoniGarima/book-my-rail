<?php
// error_reporting(E_ALL ^ E_WARNING); 
    require "connectdb.php";
    session_start();
    session_unset();
    session_destroy();
    header('location:index.html');
    exit();
?>
