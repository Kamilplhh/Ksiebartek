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
  $row = $result->fetch_assoc();
  $pseudonim = $row['pseudonim'];
  $lp = $row['lp'];
  echo '<center><h3>'.$pseudonim. '</h3><a href ="eupanel.php">Edytuj</a></center>';

  $sql7 = "SELECT recenzja.Przeczytane, ksiazka.ID, ksiazka.tytul FROM recenzja INNER JOIN ksiazka ON recenzja.KsiazkaID = ksiazka.ID WHERE uzytkownik = '$lp' AND Przeczytane = '1'";
    $result7 = $conn->query($sql7);
    if ($result7->num_rows > 0){
      echo '<center></h3><br><h4>Przeczytane książki:</center></h4>';
    while($row = $result7->fetch_assoc()) {
      echo '<br><center><a href="selected.php?data='.$row['ID'].'"> '.$row['tytul'].'</a></center>';
    }}
 
  $sql1 = "SELECT recenzja.Lp, recenzja.ocena, recenzja.Komentarz, ksiazka.tytul, ksiazka.ID FROM recenzja INNER JOIN ksiazka ON recenzja.KsiazkaID = ksiazka.ID WHERE uzytkownik = '$lp'";
  $result1 = $conn->query($sql1);
  if ($result1->num_rows > 0){
    echo '<center><br></h3><br><h4>Twoje recenzje:</center></h4>';
    while($row = $result1->fetch_assoc()) {
        $com = $row['Komentarz'];
        $lp = $row['Lp'];
        $sql8 = "SELECT ocena FROM recenzja WHERE Lp = '$lp'";
        $result8 = $conn->query($sql8);
        if ($result8->num_rows > 0){
          $row8 = $result8->fetch_assoc(); 
          if ($row8["ocena"] > 0){
            echo '<br>Tytuł:<a href="selected.php?data='.$row['ID'].'"> '.$row['tytul'].'</a>';
            echo '<br>Gwiazdek: '.$row8["ocena"];  
          }
        }
        $sql2 = "SELECT * FROM komentarz WHERE ID = '$com'";
        $result2 = $conn->query($sql2);
        if ($result2->num_rows > 0){
          if ($row8["ocena"] < 0){
            echo '<br>Tytuł:<a href="selected.php?data='.$row['ID'].'"> '.$row['tytul'].'</a>';
          }
          $row2 = $result2->fetch_assoc(); 
          echo 'Komentarz: ';
          echo $row2['kom'].'<br>';
        }
        else{
          echo '<br>';
        }
      }
      
    }
    else{
        echo '<center></h3><br><h4>Nie zamieściłeś jeszcze żadnej recenzji!</center></h4>';
      }
    }

    
    

?>
</div>