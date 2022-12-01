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
 </div>
  </div> 
  </div>
  </div>
  <div class ="container">
<center><h3>Autor</h3></center>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
<input type="text" name="imie" placeholder="Imie" required></input><br>
<input type="text" name="nazwisko" placeholder="Nazwisko" required></input><br>
<textarea rows="4" cols="30" name="opisa" placeholder="Opis" required></textarea><br>
<input type="submit">
<br></form>
<form>
<center><button formaction="apanel.php" class="btn btn-three"  value="Ksiazka">Ksiazka</button></center>
</form>
<?php 

if($_SERVER["REQUEST_METHOD"] == "POST"){
  $imie = $_POST['imie'];
  $nazwisko = $_POST['nazwisko'];
  $opisa = $_POST['opisa'];


if(isset($imie) & $imie != 0){
  $sql2 = "SELECT Lp FROM autor ORDER BY Lp DESC LIMIT 1";
  $result2 = $conn->query($sql2);
    if ($result2->num_rows > 0) {
      $row = $result2->fetch_assoc(); 
      $lp = $row['Lp'];
      $lp++;
   
  $sql = "INSERT INTO `autor` (`Lp`, `Imie`, `nazwisko`, `zdjecie`, `opis`, `ocena`, `views`) VALUES ('$lp', '$imie', '$nazwisko', '', '$opisa', NULL, NULL);";
        $result = $conn->query($sql);
        echo '<script>alert("Autor dodany")</script>';
        echo '<script> location.replace("apanel.php") </script>';
} }}



?>


</div>


