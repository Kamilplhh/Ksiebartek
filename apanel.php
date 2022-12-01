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


  <center><h3>Ksiazka</h1></center>
 
  <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
  <input type="text" required name="title" placeholder="Tytuł"></input><br>
  <input type="text" required name="isbn" placeholder="ISBN"></input><br>
  <input type="text" required name="rok" placeholder="Rok wydania"></input><br>
  <input type="text" required name="autor" placeholder="Autor"></input><br>
  <input type="text" required name="opis" placeholder="Opis"></input><br>
  <input type="text" required name="k_opis" placeholder="Krótki opis"></input><br>
  <input type="checkbox" name="bestseller" value="bestseller">
  <label> Bestseller</label><br>
  <input type="checkbox" name="nowosc" value="nowosc">
  <label> Nowość</label><br>
  <input type="checkbox" name="yearbook" value="ksiazkaroku">
  <label> Książka Roku</label><br>

  
  
  
      <div>
          <select required name="kategorie" id="kategorie">
            <option value="" disabled selected>Kategorie</option>
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
      </div>
      <div>
          <select required name="podkategorie" id="kategorie">
              <option value="" disabled selected>Kategorie</option>
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
          <br><input type="submit"></form> 
          <form>
          <center><button formaction="apanela.php" class="btn btn-three"  >Autor</button></center>
          </form> 
      </div>
  
  </div>


<?php
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    $title = $_POST['title'];
    $isbn = $_POST['isbn'];
    $rok = $_POST['rok'];
    $autor = $_POST['autor'];
    $opis = $_POST['opis'];
    $k_opis = $_POST['k_opis'];
    $bestseller = $_POST['bestseller'] ? 1 : 0;
    $nowosc = $_POST['nowosc'] ? 1 : 0;
    $yearbook = $_POST['yearbook'] ? 1 : 0;
    $kategorie = $_POST['kategorie'];
    $podkategorie = $_POST['podkategorie'];
  

  if(isset($title) & $title != 0){
    $sql2 = "SELECT ID FROM ksiazka ORDER BY ID DESC LIMIT 1";
    $result2 = $conn->query($sql2);
    if ($result2->num_rows > 0) {
      if ($result2->num_rows > 0) {
        $row = $result2->fetch_assoc(); 
        $ID = $row['ID'];
        $ID++;
     
    $sql = "INSERT INTO `ksiazka` (`ID`, `tytul`, `ISBN`, `rok wydania`, `autor`, `okladka`, `miniaturka_okladki`, `opis`, `krotki_opis`, `Kategoria`, `Podkategoria`, `ocena`, `views`, `bestseller`, `nowosc`, `ksiazkaroku`) 
    VALUES  ('$ID', '$title', '$isbn', '$rok', '$autor', NULL, NULL, '$opis', '$k_opis', '$kategorie', '$podkategorie', NULL, NULL, '$bestseller', '$nowosc', '$yearbook');";
          $result = $conn->query($sql);
          echo '<script>alert("Ksiażka dodana")</script>';
          echo '<script> location.replace("index.php") </script>';
  } }}}

  

?>





</div>


