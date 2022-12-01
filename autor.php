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
		$div = 'visible';
		}
	else{
		$div = 'hidden';
		}
	if (isset($_GET['data'])){
			$id = $_GET['data'];
			$_SESSION['id'] = $id;
		  }
		if (isset($_GET['data'])){
	$sql = "SELECT lp, imie, nazwisko, zdjecie, opis, ocena FROM autor WHERE lp = $id.";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
	
  echo '<h1><center>'.$row["imie"].' '.$row["nazwisko"]. '</center></h1><br>';
	echo '<center><img src="data:zdjecie/jpeg;base64,'.base64_encode($row['zdjecie']).'"/></center>';
	?>

  <div id="divCheckbox" style="visibility: <?php echo $div ;?>">
  <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
  <center>
  <select required name="ocena" id="ocena">
            <option value="0" disabled selected>Ocena</option>
            <option value="1">☆</option>
            <option value="2">☆☆</option>
            <option value="3">☆☆☆</option>
            <option value="4">☆☆☆☆</option>
            <option value="5">☆☆☆☆☆</option>
  </select>
  <br><input type="Submit"></form> 
  </center>
  </div>
  
<?php
	echo '<center><br>'.$row["opis"]. '<br>';
}
}}
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
	$numer = $_SESSION['id'];
	}

	if (isset($ocena)){
		$sql2 = "SELECT Lp, ocenaA FROM recenzja WHERE AutorID = '$numer' AND uzytkownik = '$lp'";
		$result2 = $conn->query($sql2);
		  if ($result2->num_rows > 0) {
		  while($row2 = $result2->fetch_assoc()) {
		  $lpi = $row2['Lp'];
		  }
		  $sql3 = "UPDATE `recenzja` SET `ocenaA` = '$ocena' WHERE `recenzja`.`Lp` = '$lpi'";
		  $result3 = $conn->query($sql3);
		  if ($result3 === TRUE){
			$sql4 = "SELECT ocenaA FROM recenzja WHERE AutorID = '$numer'";
			$result4 = $conn->query($sql4);
		  	if ($result4->num_rows > 0) {
				$x = 0;
				$y = 0;
		  		while($row4 = $result4->fetch_assoc()) {
					$x = $row4['ocenaA'] + $x;
					$y++;
				}	
			}
			$x = $x/$y;
			$x = round($x);
			$sql = "UPDATE `autor` SET `ocena` = '$x' WHERE `autor`.`Lp` = '$numer'";
			$result = $conn->query($sql);
			echo '<script>alert("Ocena zaktualizowana")</script>';
			echo '<script> location.replace("index.php") </script>';
			}
		  }
		else{
		  $sql6 = "INSERT INTO `recenzja` (`Lp`, `ocena`, `ocenaA`, `uzytkownik`, `Komentarz`, `AutorID`, `KsiazkaID`, `Przeczytane`) 
		  VALUES (NULL, NULL , '$ocena', '$lp', NULL, '$numer' , NULL, NULL);";
		  $result6 = $conn->query($sql6);
			if ($result6 === TRUE){
				$sql4 = "SELECT ocenaA FROM recenzja WHERE AutorID = '$numer'";
				$result4 = $conn->query($sql4);
		  		if ($result4->num_rows > 0) {
					$x = 0;
					$y = 0;
		  			while($row4 = $result4->fetch_assoc()) {
						$x = $row4['ocenaA'] + $x;
						$y++;
				}	
			}
			$x = $x/$y;
			$x = round($x);
			$sql = "UPDATE `autor` SET `ocena` = '$x' WHERE `autor`.`Lp` = '$numer'";
			$result = $conn->query($sql);
			  echo '<script>alert("Ocena dodana")</script>';
			  echo '<script> location.replace("index.php") </script>';
			}
		  }  
		}

	}
	?>



<?php 
	if (isset($_GET['data'])){
	$id = $_GET['data'];
	$sql = "SELECT ksiazka.ID, ksiazka.tytul, autor.Lp FROM ksiazka INNER JOIN autor ON ksiazka.autor = autor.lp WHERE autor.lp = $id. ORDER BY rand () limit 3 ";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		echo '<br>Książki:<br><br>';
		if ($result->num_rows == 1){
			while($row = $result->fetch_assoc()) {
				echo '<a class= "a" href="selected.php?data='.$row['ID'].'">
				<center><button class="btn btn-six">'.$row["tytul"].'</button>
				</center></a>';
		}}
		else{
			echo '<div class="row">';
			while($row = $result->fetch_assoc()) {
				echo '<div class="col-lg-3 col-md-2">';
		  
				echo '<a class= "a" href="selected.php?data='.$row['ID'].'"><div class="col-4 col-lg-2">
			  <button class="btn btn-six">'.$row["tytul"].'</button>
		  </div></div> </a>';
		}} 	
}}
?>

	
	
	
	
	
		</div>

	</div>
    
  </body>
</html>