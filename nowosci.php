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
<div class="col-4 col-lg-3">
  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
    <div>
        <select name="kategorie" id="kategorie">
        <option value="" disabled selected>Kategorie</option>
            <option value="1">Bestseller</option>
            <option value="4">Fantasy</option>
            <option value="3">Dramat</option>
            <option value="2">Thiller</option>
            <option value="5">Przygodowe</option>
            <option value="6">Science fiction</option>
            <option value="8">Powieść historyczna</option>
            <option value="9">Romans</option>
            <option value="10">Sensacja</option>
            <option value="7">Kryminał</option>
            <option value="11">Horror</option>
            <option value="12">Literatura obyczajowa</option>
        </select>
        <button type="submit">Szukaj</button>
    </div>
</form>
</div><div class="col-4 col-lg-2">
  <form method="get" action="/autorzy.php">
	<center><button class="btn btn-six">Autorzy</button></form></center>
</div><div class="col-4 col-lg-2">
  <form method="get" action="/ksiazkaroku.php">
	<center><button class="btn btn-six">Książka roku</button></form></center>
</div><div class="col-4 col-lg-2">
  <form method="get" action="/nowosci.php">
	<center><button class="btn btn-six">Nowości</button></form></center>
</div><div class="col-4 col-lg-3">
	 <div class="box">
        <form name="search" action="nowosci.php" method="post">
            <input name="sear" type="text" class="input" name="txt" >
        </form>
            <i class="fas fa-search"></i>
    </div>
</div></div></div>
<div class="row">
<div class="col-lg-2 col-2">
</div>


	
  <div class="col-lg-8 col-8">
	<div class ="container">
	<div class="wrapper">
<?php
    $sql = "SELECT ID, miniaturka_okladki, tytul, bestseller FROM ksiazka WHERE bestseller = 1  ORDER BY rand () limit 1 ";
    $result = $conn->query($sql);
    $data = $result;
    if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      echo '<a href="selected.php?data='.$row['ID'].'"  class="profile">';
      echo '<h2 class="profile__name">bestseller</h2>';
      echo '<p>'.$row['tytul'].'</p>';
      echo '<img src="data:miniaturkakladki/jpeg;base64,'.base64_encode($row['miniaturka_okladki']).'" /> </a>';
    }
  }
  
      
  $sql = "SELECT ksiazka.ID, ksiazka.miniaturka_okladki, ksiazka.tytul, recenzja.KsiazkaID, recenzja.ocena FROM ksiazka INNER JOIN recenzja ON ksiazka.ID = recenzja.KsiazkaID WHERE recenzja.ocena >= 4 ORDER BY rand () limit 1 ";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      echo '<a href="selected.php?data='.$row['ID'].'"  class="profile">';
      echo '<h2 class="profile__name">najpopularniejsza ksiazka</h2>';
      echo '<p>'.$row['tytul'].'</p>';
      echo '<img src="data:miniaturkakladki/jpeg;base64,'.base64_encode($row['miniaturka_okladki']).'" /> </a>';
    }
  }

  $sql = "SELECT autor.lp, autor.zdjecie, autor.imie, autor.nazwisko, autor.ocena, recenzja.AutorID, recenzja.ocenaA FROM autor INNER JOIN recenzja ON autor.Lp = recenzja.AutorID WHERE recenzja.ocenaA >= 4 ORDER BY rand () limit 1";
  $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      echo '<a href="autor.php?data='.$row['lp'].'"  class="profile">';
      echo '<h2 class="profile__name">najpopularniejsza autor</h2>';
      echo '<p>'.$row['imie']. ' '.$row['nazwisko'].'</p>';
      echo '<img src="data:zdjecie/jpeg;base64,'.base64_encode($row['zdjecie']).'" /> </a>';
    }
  }
       ?> 
       
      
  </div>
  <div class="bio">


<?php 
$kategorie = filter_input(INPUT_POST, 'kategorie', FILTER_SANITIZE_STRING);
$search = filter_input(INPUT_POST, 'sear', FILTER_SANITIZE_STRING);

// KATEGORIE

if ($kategorie) { 
$sql = "SELECT ksiazka.ID, ksiazka.tytul, ksiazka.miniaturka_okladki, ksiazka.krotki_opis, ksiazka.autor,autor.lp, autor.imie, autor.nazwisko FROM ksiazka  INNER JOIN autor ON ksiazka.autor = autor.lp WHERE ksiazka.nowosc >= 1 AND Kategoria = $kategorie OR Podkategoria = $kategorie";
$result = $conn->query($sql);
$b = 0;
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {

  echo '<div class="pozycja"><center><a href="selected.php?data='.$row['ID'].'">'.$row["tytul"].'</a><br><a href="autor.php?data='.$row['lp'].'">' .$row["imie"].' '. $row["nazwisko"]. '</center></a></div>';
  echo '<div class="row">';
  echo '<img class="col-4" src="data:miniaturkakladki/jpeg;base64,'.base64_encode($row['miniaturka_okladki']).'"/>';
  echo '<div class="col-8"> '.$row["krotki_opis"]. '<br> <a href="selected.php?data='.$row['ID'].'"> Więcej -></a>' ;
  echo '</div></div></form>';

  $b++;
  }
}
   }


// WYSZUKAJ

elseif(isset($_POST['sear'])){
$sql = "SELECT ksiazka.ID, ksiazka.tytul, ksiazka.miniaturka_okladki, ksiazka.krotki_opis, ksiazka.autor,autor.lp, autor.imie, autor.nazwisko FROM ksiazka INNER JOIN autor ON ksiazka.autor = autor.lp WHERE ksiazka.nowosc >= 1 AND ksiazka.tytul LIKE '%".$search."%' OR autor.imie LIKE '%".$search."%' OR autor.nazwisko LIKE '%".$search."%'";
$result= $conn -> query($sql);
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {

echo '<div class="pozycja"><a href="selected.php?data='.$row['ID'].'">'.$row["tytul"].'</a><br><a href="autor.php?data='.$row['lp'].'">' .$row["imie"].' '. $row["nazwisko"]. '</a></p></div>';
echo '<div class="row">';
echo '<img class="col-4" src="data:miniaturkakladki/jpeg;base64,'.base64_encode($row['miniaturka_okladki']).'"/>';
echo '<div class="col-8"> '.$row["krotki_opis"]. '<br> <a href="selected.php?data='.$row['ID'].'"> Więcej -></a>' ;
echo '</div></div></form>';  
}
}
}


else{
  
if (isset($_GET['data'])){
  $i = $_GET['data'];
  $z = $i;
  $sql = "SELECT ksiazka.ID, ksiazka.tytul, ksiazka.miniaturka_okladki, ksiazka.krotki_opis, ksiazka.autor,autor.lp, autor.imie, autor.nazwisko FROM ksiazka INNER JOIN autor ON ksiazka.autor = autor.lp WHERE ksiazka.nowosc >= 1 AND ID >= $i ORDER BY ID ASC";
  $result = $conn->query($sql);
}
  else{
  $sql = "SELECT ksiazka.ID, ksiazka.tytul, ksiazka.miniaturka_okladki, ksiazka.krotki_opis, ksiazka.autor,autor.lp, autor.imie, autor.nazwisko FROM ksiazka INNER JOIN autor ON ksiazka.autor = autor.lp WHERE ksiazka.nowosc >= 1 ORDER BY ID ASC";
  $result = $conn->query($sql);
  $i = 1;
  }
  
  $d = $i + 9; 
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      if ($i < $d){
    echo '<div class="pozycja"><a href="selected.php?data='.$row['ID'].'">'.$row["tytul"].'</a><br><a href="autor.php?data='.$row['lp'].'">' .$row["imie"].' '. $row["nazwisko"]. '</a></p></div>';
    echo '<div class="row">';
    echo '<img class="col-4" src="data:miniaturkakladki/jpeg;base64,'.base64_encode($row['miniaturka_okladki']).'"/>';
    echo '<div class="col-8"> '.$row["krotki_opis"]. '<br> <a href="selected.php?data='.$row['ID'].'"> Więcej -></a>' ;
    echo '</div></div></form>';

    $i++;
    }} 
    echo '<div class="row">';
    if (isset($_GET['data'])){
      if (($_GET['data']) > 1 ){
        $z = $z - 9;  
        echo '<div class="col"><center><a href=nowosci.php?data='.$z.'>Poprzednia strona</a></center></div>';
    }}
    if ($i >= $d){
      echo '<div class="col"><center><a href=nowosci.php?data='.$i.'>Nastepna strona</a></center></div>';
    }
    echo '</div>';    
    }
}


?>



  
    </div></div>
  </body>
</html>