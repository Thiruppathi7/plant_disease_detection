<?php
session_start();
if(!isset($_SESSION['userid'])) {
    header("Location:index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Crop Disease</title>
<meta charset="utf-8">
<link rel="stylesheet" href="css/style.css">

<script>

</script>
<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<link rel="stylesheet" media="screen" href="css/ie.css">
<![endif]-->
</head>
<body>
<div class="main">
  <header>
    <div class="container_12">
      <div class="grid_12">
        <h1><img src="images/logo.png" alt=""></h1>
        <div class="menu_block">
          <nav>
            <ul class="sf-menu">
              <li class="current"><a href="userhome.php">Upload Image</a></li>
              <li><a href="signout.php">Signout</a></li>
            </ul>
          </nav>
          
        </div>
        
      </div>
    </div>
  </header>
  
  <div class="content page1">
    <div class="container_12 mh">      
       <?php
   include './db.php';
   echo "<div class='right'><i>Welcome, </i><b>$_SESSION[username]</b></div>";
   ?>