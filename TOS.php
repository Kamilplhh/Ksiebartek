<?php 
session_start();

?>
<html lang="en">
  <head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" 
  integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" 
  crossorigin="anonymous">
	<link href="style.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <title>Księbartek</title>
  </head>
  <body>
  <?php
$servername = "localhost";
$username = "id19534183_root";
$password = "CtlxSApbL4#Qi\lJ";
$dbname = "id19534183_ksiazki";
$conn = new mysqli($servername, $username, $password, $dbname);
?>
<div class="row">
  <div class="col-10 col-lg-11 col-md-10"><center><a href="index.php"><img class="logo" src="logof.png"></center></a></div>
<div class="col-1 col-lg-1 col-md-1">
  	<form>
	<?php
  if (isset($_SESSION['username'])){
    echo '<button formaction="logout.php" class="btn btn-three"  value="Wyloguj">Wyloguj</button>';
    }
    else {
    echo '<button formaction="logowanie.php" class="btn btn-three"  value="Zaloguj">Zaloguj</button>';
    }
    if (isset($_SESSION['username'])){
      if ($_SESSION['username']=="admin"){
        echo '<button formaction="apanel.php" class="btn btn-three"  value="apanel">Panel</button>';
      }
      else{
        echo '<button formaction="upanel.php" class="btn btn-three"  value="upanel">Panel</button>';
      }
    }
  ?>
</form>
</div>
</div> 
</div>
</div>
	<div class="menu">
  <div class="row">
  <div class="col-4 col-lg-4">
  <form method="get" action="/seminarium/autorzy.php">
	<center><button class="btn btn-six">Autorzy</button></form></center>
</div><div class="col-4 col-lg-4">
  <form method="get" action="/seminarium/ksiazkaroku.php">
	<center><button class="btn btn-six">Książka roku</button></form></center>
</div><div class="col-4 col-lg-4">
  <form method="get" action="/seminarium/nowosci.php">
	<center><button class="btn btn-six">Nowości</button></form></center>
</div></div></div>
<div class="row">
<div class="col-lg-2 col-2">
</div>
<div class="col-lg-8 col-8">
  <div class ="container">


  </div>