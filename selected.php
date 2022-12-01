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


<?php
if (isset($_SESSION['username'])){
  $uzytkownik = $_SESSION['username'];
  }
if (isset($_GET['data'])){
    $id = $_GET['data'];
    $_SESSION['id'] = $id;
  }
  if (isset($_GET['data'])){
  echo '<input type="hidden" name="numer" value='.$id.'></input>'; 
	$sql = "SELECT ksiazka.ID, ksiazka.tytul, ksiazka.miniaturka_okladki, ksiazka.opis, ksiazka.ISBN, ksiazka.autor, autor.lp, autor.imie, autor.nazwisko FROM ksiazka  INNER JOIN autor ON ksiazka.autor = autor.lp WHERE ksiazka.ID = $id.";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
  $id = $row["ID"];
  echo '<h1><center>'.$row["tytul"]. '<br> <a href="autor.php?data='.$row['lp'].'">'.$row["imie"]. ' ' .$row["nazwisko"]. '</a></center></h1><br>';
  echo '<div class="row">';
	echo '<img class="col-12 col-lg-6 col-xl-4" src="data:miniaturkakladki/jpeg;base64,'.base64_encode($row['miniaturka_okladki']).'"/>';
	echo '<div class="col-lg-6 col-12 col-xl-8"> '.$row["opis"]. '<br></div>';
	echo '</div>ISBN: '.$row["ISBN"];
  }}
}
?>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">

<?php
 if (isset($_SESSION['username'])){
  $id = $_SESSION['id'];
  $div = 'visible';
  $user = $_SESSION['username'];
  $sql4 = "SELECT lp FROM uzytkownik WHERE login = '$user'";
  $result4 = $conn->query($sql4);
  if ($result4->num_rows > 0) {
    while($row4 = $result4->fetch_assoc()) {
    $lp = $row4['lp'];
  }}

  $sql17 = "SELECT przeczytane FROM recenzja WHERE KsiazkaID = $id AND uzytkownik = $lp";
  $result17 = $conn->query($sql17);
	if ($result17->num_rows > 0) {   
    while($row17 = $result17->fetch_assoc()) {
      if ($row17['przeczytane'] > 0){  
        $status = 'hidden';
      }
      else{
        $status = 'checkbox';
        echo 'Przeczytane:';
      }    
    }
  }
  else{
    $status = 'checkbox';
    echo 'Przeczytane:';
  }
  }
  else{
    $status = 'hidden';
    $div = 'hidden';
  }
  ?>
  <div id="divCheckbox" style="visibility: <?php echo $div ;?>">
  <input type="<?php echo $status ;?>" name="przeczytane" ></input><br>
  <select required name="ocena" id="ocena">
            <option value="0" disabled selected>Ocena</option>
            <option value="1">☆</option>
            <option value="2">☆☆</option>
            <option value="3">☆☆☆</option>
            <option value="4">☆☆☆☆</option>
            <option value="5">☆☆☆☆☆</option>
  </select>
  <br><input type="Submit"></form> 
  </div>
<?php

  echo '<center><a class= "a" href="comments.php?data='.$id.'"><div class="col-4 col-lg-2"><button class="btn btn-six">Recenzje</button></center></div></div></a>';
if (isset($_SESSION['username'])){
  $user = $_SESSION['username'];
  $sql4 = "SELECT lp FROM uzytkownik WHERE login = '$user'";
  $result4 = $conn->query($sql4);
	if ($result4->num_rows > 0) {
  while($row4 = $result4->fetch_assoc()) {
  $lp = $row4['lp'];
  
  }}



if($_SERVER["REQUEST_METHOD"] == "POST"){
  $ocena = $_POST['ocena'];
  $przeczytane = $_POST['przeczytane'] ? 1 : 0;
  $numer = $_SESSION['id'];
 
  
}
  if(isset($ocena) && ($przeczytane)){
    $sql4 = "SELECT ocena FROM recenzja WHERE KsiazkaID = '$numer' AND uzytkownik = '$lp'";
    $result4 = $conn->query($sql4);
	    if ($result4->num_rows > 0) {
        $sql3 = "UPDATE `recenzja` SET `ocena` = '$ocena', `Przeczytane` = '$przeczytane' WHERE KsiazkaID = '$numer' AND uzytkownik = '$lp'";
        $result3 = $conn->query($sql3);
        if ($result3 === TRUE){
          $sql7 = "SELECT ocena FROM recenzja WHERE KsiazkaID = '$numer'";
			    $result7 = $conn->query($sql7);
		  	  if ($result7->num_rows > 0) {
				    $x = 0;
				    $y = 0;
		  		while($row7 = $result7->fetch_assoc()) {
					  $x = $row7['ocena'] + $x;
					  $y++;
				    }	
			    }
			    $x = $x/$y;
			    $x = round($x);
			    $sql = "UPDATE `ksiazka` SET `ocena` = '$x' WHERE `ksiazka`.`ID` = '$numer'";
			    $result = $conn->query($sql);
          echo '<script>alert("Ocena zaktualizowana")</script>';
          echo '<script> location.replace("index.php") </script>';
          }
        }
      else{
        $sql2 = "INSERT INTO `recenzja` (`Lp`, `ocena`, `ocenaA`, `uzytkownik`, `Komentarz`, `AutorID`, `KsiazkaID`, `Przeczytane`) 
        VALUES (NULL, '$ocena', NULL, '$lp', NULL, NULL, '$numer', '$przeczytane');";
        $result2 = $conn->query($sql2);
          if ($result2 === TRUE){
            $sql7 = "SELECT ocena FROM recenzja WHERE KsiazkaID = '$numer'";
			      $result7 = $conn->query($sql7);
		  	    if ($result7->num_rows > 0) {
				      $x = 0;
				      $y = 0;
		  		  while($row7 = $result7->fetch_assoc()) {
					    $x = $row7['ocena'] + $x;
					   $y++;
				    }	
			    }
			    $x = $x/$y;
			    $x = round($x);
			    $sql = "UPDATE `ksiazka` SET `ocena` = '$x' WHERE `ksiazka`.`ID` = '$numer'";
			    $result = $conn->query($sql);
			      echo '<script>alert("Ocena dodana")</script>';
			      echo '<script> location.replace("index.php") </script>';
          }
        }
    }
    elseif (isset($ocena)){
      $sql2 = "SELECT Lp, ocena, Przeczytane FROM recenzja WHERE KsiazkaID = '$numer' AND uzytkownik = '$lp'";
      $result2 = $conn->query($sql2);
	    if ($result2->num_rows > 0) {
        while($row2 = $result2->fetch_assoc()) {
        $lpi = $row2['Lp'];
        }
        $sql3 = "UPDATE `recenzja` SET `ocena` = '$ocena' WHERE `recenzja`.`Lp` = '$lpi'";
        $result3 = $conn->query($sql3);
        if ($result3 === TRUE){
          $sql7 = "SELECT ocena FROM recenzja WHERE KsiazkaID = '$numer'";
			    $result7 = $conn->query($sql7);
		  	  if ($result7->num_rows > 0) {
				    $x = 0;
				    $y = 0;
		  		while($row7 = $result7->fetch_assoc()) {
					  $x = $row7['ocena'] + $x;
					  $y++;
				  }	
			    }
			    $x = $x/$y;
			    $x = round($x);
			    $sql = "UPDATE `ksiazka` SET `ocena` = '$x' WHERE `ksiazka`.`ID` = '$numer'";
			    $result = $conn->query($sql);
          echo '<script>alert("Ocena zaktualizowana")</script>';
          echo '<script> location.replace("index.php") </script>';
          }
        }
      else{
        $sql2 = "INSERT INTO `recenzja` (`Lp`, `ocena`, `ocenaA`, `uzytkownik`, `Komentarz`, `AutorID`, `KsiazkaID`, `Przeczytane`) 
        VALUES (NULL, '$ocena', NULL, '$lp', NULL, NULL, '$numer', NULL);";
        $result2 = $conn->query($sql2);
          if ($result2 === TRUE){
            $sql7 = "SELECT ocena FROM recenzja WHERE KsiazkaID = '$numer'";
			    $result7 = $conn->query($sql7);
		  	  if ($result7->num_rows > 0) {
				    $x = 0;
				    $y = 0;
		  		while($row7 = $result7->fetch_assoc()) {
					  $x = $row7['ocena'] + $x;
					  $y++;
				    }	
			     }
			      $x = $x/$y;
			      $x = round($x);
			      $sql = "UPDATE `ksiazka` SET `ocena` = '$x' WHERE `ksiazka`.`ID` = '$numer'";
			      $result = $conn->query($sql);
            echo '<script>alert("Ocena dodana")</script>';
            echo '<script> location.replace("index.php") </script>';   
          }
        }  
      }
    elseif (isset($przeczytane)){
        $sql2 = "SELECT ocena FROM recenzja WHERE KsiazkaID = '$numer' AND uzytkownik = $lp";
        $result2 = $conn->query($sql2);
	    if ($result2->num_rows > 0) {
        $sql3 = "UPDATE `recenzja` SET `Przeczytane` = '$przeczytane' WHERE KsiazkaID = '$numer' AND uzytkownik = '$lp'";
        $result3 = $conn->query($sql3);
        if ($result3 === TRUE){
          echo '<script>alert("Status zaktualizowano")</script>';
          echo '<script> location.replace("index.php") </script>';   
          }
        }
      else{
        $sql2 = "INSERT INTO `recenzja` (`Lp`, `ocena`, `ocenaA`, `uzytkownik`, `Komentarz`, `AutorID`, `KsiazkaID`, `Przeczytane`) 
        VALUES (NULL, NULL, NULL, '$lp', NULL, NULL, '$numer', '$przeczytane');";
        $result2 = $conn->query($sql2);
          if ($result2 === TRUE){
            echo '<script>alert("Status zaktualizowano")</script>';
            echo '<script> location.replace("index.php") </script>'; 
          }
        }  
      }
  }

    


	?>




	
	
	
	
	
	
	</div>
	</div>
    
  </body>
</html>