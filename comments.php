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

  <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<center><textarea rows="4" cols="70" type="text" name="comment" placeholder="Podziel się opinią!"></textarea><br>
<?php 
  if (isset($_GET['data'])){
    $numer = $_GET['data'];
    echo '<input type="hidden" name="numer" value='.$numer.'></input>'; 
  }

  ?>
	</form>
	<button type="submit" value="comment">Prześlij</button></center>
<?php
  if (isset($_SESSION['username'])){
    $uzytkownik = $_SESSION['username'];
    if (isset($_GET['data'])){
      $numer = $_GET['data'];
    } 
    }
  if (isset($_GET['data'])){
  $id = $_GET['data'];
  $sql = "SELECT recenzja.uzytkownik, komentarz.kom, recenzja.ocena, recenzja.KsiazkaID FROM recenzja INNER JOIN komentarz ON recenzja.komentarz = komentarz.ID WHERE KsiazkaID = $id.";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()){
    $numerid = $row["uzytkownik"];
    $sql11 = "SELECT pseudonim FROM uzytkownik WHERE lp = $numerid";
    $result11 = $conn->query($sql11);
    if ($result11->num_rows > 0) {
      while($row2 = $result11->fetch_assoc()){
      echo '<div><br>Komentarz użytkownika '.$row2["pseudonim"].' :<br>' ;
      echo $row["kom"].'</div>';
      
  if ($row["ocena"] > 0){
    echo 'Gwiazdek: '.$row["ocena"]; 
    echo '<br><br>';
  }}}
  else{
    echo '<br>';
  }
  }}
}




  if($_SERVER["REQUEST_METHOD"] == "POST"){
    $kom = $_POST['comment'];
    $numer = $_POST['numer'];
  }

  
  if (isset($kom)){
    if (isset($_SESSION['username'])){
      $sql9 = "SELECT lp FROM uzytkownik WHERE login = '$uzytkownik' ";
      $result9 = $conn->query($sql9);
      if ($result9->num_rows > 0) {
        $row = $result9->fetch_assoc(); 
        $lp = $row['lp'];
        $sql7 = "SELECT ID FROM komentarz ORDER BY ID DESC";
        $result7 = $conn->query($sql7);
        if ($result7->num_rows > 0) {
          $row = $result7->fetch_assoc(); 
          $IDk = $row['ID'];
          $IDk++;
          $sql2 = "INSERT INTO komentarz (ID, kom) VALUES ('$IDk', '$kom')";
		      $result2 = $conn->query($sql2);
          $sql3 = "INSERT INTO recenzja (uzytkownik, Komentarz, KsiazkaID) VALUES ('$lp','$IDk', '$numer')";
          $result3 = $conn->query($sql3);
          
        
            if ($result2 === TRUE){
			      echo '<script>alert("Komentarz został dodany")</script>';
            echo '<script> location.replace("index.php") </script>';
    }
    else{
      echo '<script>alert("Coś poszło nie tak")</script>';
    }}}}
    else{
      echo '<script>alert("Prosze się zalogować")</script>';
      echo '<script> location.replace("logowanie.php") </script>';
    }}
  

  
  






  ?>
</div>