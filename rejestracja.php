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
	<center><input type="text" name="fimie" placeholder="Nazwa użytkownika"></input><br>
	<input type="text" name="flog" placeholder="Login"></input><br>
	<input type="password" name="fpass" placeholder="Hasło"></input><br>
	</form>
	<button type="submit" value="Zarejestruj">Zarejestruj się</button><br>
	<form>
	<button formaction="logowanie.php" value="Zaloguj">Zaloguj się</button>
</form>
	</div>
<?php 
$servername = "localhost";
$username = "id19534183_root";
$password = "CtlxSApbL4#Qi\lJ";
$dbname = "id19534183_ksiazki";
$conn = new mysqli($servername, $username, $password, $dbname);
$errors =[];


if($_SERVER["REQUEST_METHOD"] == "POST"){
$log = $_POST['flog'];
$pass = $_POST['fpass'];
$nazwa = $_POST['fimie'];
$pass = md5($pass);
}
if (isset($log) && ($pass) && ($nazwa)){
$sql = "SELECT * FROM uzytkownik WHERE pseudonim = '$nazwa' LIMIT 1 ";
$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		echo '<script>alert("Ta nazwa użytkownika jest już zajęta")</script>';
  }
  	else{
		$sql5 = "SELECT * FROM uzytkownik WHERE login = '$log' LIMIT 1 ";
		$result5 = $conn->query($sql5);
			if ($result5->num_rows > 0) {
			echo '<script>alert("Ten login jest już zajęty")</script>';
  			}
		else{
			$sql1 = "INSERT INTO uzytkownik (pseudonim, login, haslo) VALUES ('$nazwa', '$log', '$pass')";
			$result2 = $conn->query($sql1);

			if ($result2 === TRUE){
			echo '<script>alert("Użytkownik ' .$nazwa. ' został dodany pomyślnie")</script>';
			echo '<script> location.replace("logowanie.php") </script>';
		}
		}
		}
		}

?>	
	
	  
  </body>
</html>