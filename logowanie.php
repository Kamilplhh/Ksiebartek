<?php 
	session_start();
	?>

<html lang="en">
  <head>
    
    <meta charset="utf-8">
	<link href="style1.css" rel="stylesheet" />


    <title>Księbartek</title>
  </head>
  <body>
    <div class="logo">
	<center><div class="logo"><a href="index.php"><img class="logof" src="logof.png"></center></a>
	</div>
	<div class="panel">
	<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<center><input type="text" name="flog" placeholder="Login"></input><br>
	<input type="password" name="fpass" placeholder="Hasło"></input><br>
	<button type="submit" value="Zaloguj"><span>Zaloguj</span></button><center>
	</form>
	<br>Nie masz konta?
	<form>
	<button formaction="rejestracja.php" value="Zarejestruj">Zarejestruj się</button>
</form>
	</div>
<?php
$servername = "localhost";
$username = "id19534183_root";
$password = "CtlxSApbL4#Qi\lJ";
$dbname = "id19534183_ksiazki";
$conn = new mysqli($servername, $username, $password, $dbname);


if($_SERVER["REQUEST_METHOD"] == "POST"){
	$login = $_POST['flog'];
	$pass = $_POST['fpass'];
	$pass = md5($pass);
if(empty($pass)){
		echo '<script>alert("Prosze podać hasło")</script>';
	}
	if(empty($login)){
		echo '<script>alert("Prosze podać login")</script>';
	}


	$sql = "SELECT pseudonim, login, haslo FROM uzytkownik ";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
  		while($row = $result->fetch_assoc()) {
			if($login==$row["login"] && $pass==$row["haslo"]){
			$_SESSION['valid'] = true;
        	$_SESSION['username'] = $login;
			echo '<script>alert("Witaj '.$row["pseudonim"].'")</script>';
			echo '<script> location.replace("index.php") </script>';
		}
}


}
}

	
		?>
    
  </body>
</html>