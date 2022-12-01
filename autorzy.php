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
  <form method="get" action="/autorzy.php">
	<center><button class="btn btn-six">Autorzy</button></form></center>
</div><div class="col-4 col-lg-4">
  <form method="get" action="/ksiazkaroku.php">
	<center><button class="btn btn-six">Książka roku</button></form></center>
</div><div class="col-4 col-lg-4">
  <form method="get" action="/nowosci.php">
	<center><button class="btn btn-six">Nowości</button></form></center>
</div></div></div>

<div class="row">
<div class="col-lg-2 col-2">
</div>


	
  <div class="col-lg-8 col-8">
	<div class ="container">
  <div class="bio">
<?php


$sql = "SELECT lp, imie, zdjecie, nazwisko FROM autor";
$result = $conn->query($sql);

$i = 0;
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {




$i++;
}
}



if (isset($_GET['data'])){
  $i = $_GET['data'];
  $z = $i;
  $sql = "SELECT lp, imie, zdjecie, nazwisko FROM autor WHERE Lp >= $i ORDER BY Lp ASC";
  $result = $conn->query($sql);
}
  else{
  $sql = "SELECT lp, imie, zdjecie, nazwisko FROM autor ORDER BY Lp ASC";
  $result = $conn->query($sql);
  $i = 1;
  }
  
  $d = $i + 9; 
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      if ($i < $d){
        echo '<br><center><img alt="brak zdjęcia autora" src="data:zdjecie/jpeg;base64,'.base64_encode($row['zdjecie']).'"/><br>';
        echo '<a href="autor.php?data='.$row['lp'].'">'.$row["imie"]. ' ' .$row["nazwisko"]. '</center></a><br>';

    $i++;
  
    }
    }
  echo '<div class="row">';
  if (isset($_GET['data'])){
    if (($_GET['data']) > 1 ){
      $z = $z - 9;  
      echo '<div class="col"><center><a href=autorzy.php?data='.$z.'>Poprzednia strona</a></center></div>';
    }}
  if ($i >= $d){
    echo '<div class="col"><center><a href=autorzy.php?data='.$i.'>Nastepna strona</a></center></div>';
  }
  echo '</div>';    
  }
?>
    </div></div>
  </body>
</html>