<?php
session_start();
if(!isset($_SESSION['adminuserid'])) {
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
            <?php include './menu2.php';?>
          </nav>
          
        </div>
        
      </div>
    </div>
  </header>
  
  <div class="content page1">
    <div class="container_12 mh">      
       <?php
   include './db.php';
   ?>