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
<div class ="container">
<?php
$uzytkownik = $_SESSION['username'];

  $sql = "SELECT * FROM uzytkownik WHERE login = '$uzytkownik'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0){
    $pass = 0;
    $pseud = 0;
    $row = $result->fetch_assoc();
    $pseudonim = $row['pseudonim'];
    $haslo = $row['haslo'];
    echo '<center><h3>'.$pseudonim. '</h3></center>';
    ?>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
    <input type="text" name="ppass" value="<?php echo $pseudonim ?>" placeholder="<?php echo $pseudonim ?>"></input> Nazwa użytkownika<br>
    <input type="text" name="flog" value="<?php echo $row['login'] ?>" placeholder="<?php echo $row['login'] ?>"></input> Login<br>
    <input type="password" name="fpass"  placeholder="Nowe hasło"></input> Hasło<br>
    <button type="submit">Zmień</button>
    
    <center><button formaction="upanel.php" class="btn btn-three"  value="Edytuj">Komentarze</button></center>
    </form>
    <?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
      $log = $_POST['flog'];
      if (!empty($_POST['fpass'])){
        $pass = $_POST['fpass'];
        $pass = md5($pass);
      }
      else{
        $pass = $haslo;
      }
      
      $pseud = $_POST['ppass'];
    }
    $sql2 = "SELECT * FROM uzytkownik";
    $result2 = $conn->query($sql2);
    if ($result2->num_rows > 0){
      $row2 = $result2->fetch_assoc();
    }



    if (isset($log) || ($pass) || ($pseud)){
      $nazwa2 = $_POST['ppass'];
      if ($_POST['ppass'] = $row['pseudonim'] || $log = $row2['login']){
      if ($_POST['ppass'] = $uzytkownik || $log = $row['login']){
        $sql = "UPDATE `uzytkownik` SET `pseudonim` = '$nazwa2', `login` = '$log', `haslo` = '$pass' WHERE `uzytkownik`.`pseudonim` = '$pseudonim'";
        $result = $conn->query($sql);
        echo '<script>alert("Zmiany zostały zatwierdzone, prosze zalogować się ponownie")</script>';
        echo '<script> location.replace("logout.php") </script>';
      }}
      else{
        echo '<script>alert("Coś poszło nie tak")</script>';
      }
        
      }
  }

