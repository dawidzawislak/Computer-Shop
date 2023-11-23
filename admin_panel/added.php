<?php
session_start();
if(!isset($_SESSION['log_adm']))
{
  header('location:login.php');
  exit();
}
require 'dbfunc.php';
if(isset($_POST['cat']))
{
  $_SESSION['cat'] = $_POST['cat'];

  $conn = new mysqli($host, $dbuser, $dbpass, $dbname);
  if($conn->connect_error)
    die("Connection to \"sklep\" failed: ".$conn->connect_error);

  $query = "";

  switch($_POST['cat']) {
    case "Płyty główne":
      $query = "INSERT INTO plyty_glowne VALUES (NULL, '".$_POST['firma']."', '".$_POST['model']."', '".$_POST['socket']."', ".$_POST['pcie'].", ".$_POST['ram'].", '".$_POST['format']."', ".$_POST['cena'].", ".$_POST['ilosc'].", '".$_POST['img_path']."');";
    break;
    case "Procesory":
      $query = "INSERT INTO procesory VALUES (NULL, '".$_POST['firma']."', '".$_POST['model']."', '".$_POST['socket']."', '".$_POST['takt']."', '".$_POST['rdzenie']."', '".$_POST['tdp']."', '".$_POST['moc']."', '".$_POST['box']."', '".$_POST['odbl']."', '".$_POST['cena']."', '".$_POST['ilosc']."', '".$_POST['img_path']."')";
    break;
    case "Karty graficzne":
      $query = "INSERT INTO karty_graficzne VALUES (NULL, '".$_POST['firma']."', '".$_POST['model']."', '".$_POST['pam']."', '".$_POST['rodz']."', '".$_POST['zlacza']."', '".$_POST['tdp']."', '".$_POST['moc']."', ".(!empty($_POST['cuda']) ? "'".$_POST['cuda']."'" : "NULL" ).", '".$_POST['cena']."', '".$_POST['ilosc']."', '".$_POST['img_path']."')";
    break;
    case "Zasilacze":
      $query = "INSERT INTO zasilacze VALUES (NULL, '".$_POST['firma']."', '".$_POST['model']."', '".$_POST['moc']."', '".$_POST['sprawnosc']."', ".(!empty($_POST['cert']) ? "'".$_POST['cert']."'" : "NULL" ).", '".$_POST['mod']."', '".$_POST['cena']."', '".$_POST['ilosc']."', '".$_POST['img_path']."')";
    break;
    case "RAM":
      $query = "INSERT INTO ram VALUES (NULL, '".$_POST['firma']."', '".$_POST['model']."', '".$_POST['rodz']."', '".$_POST['poj']."', '".$_POST['takt']."', '".$_POST['op']."', '".$_POST['cena']."', '".$_POST['ilosc']."', '".$_POST['img_path']."')";
    break;
    case "Dyski":
      $query = "INSERT INTO dyski VALUES (NULL, '".$_POST['firma']."', '".$_POST['model']."', '".$_POST['poj']."', '".$_POST['tech']."', '".$_POST['int']."', ".(!empty($_POST['rodz']) ? "'".$_POST['rodz']."'" : "NULL" ).", '".$_POST['pr_o']."', '".$_POST['pr_z']."', '".$_POST['cena']."', '".$_POST['ilosc']."', '".$_POST['img_path']."')";
    break;
    case "Obudowy":
      $temp = explode(",", $_POST['stand']);
      $tab = [];
      foreach($temp as $stand) 
      {
        $tab[] = trim($stand);
      }
      sort($tab);
      $standards = implode(",", $tab);

      $query = "INSERT INTO obudowy VALUES (NULL, '".$_POST['firma']."', '".$_POST['model']."', '".$_POST['typ']."', '".$standards."', '".$_POST['rgb']."', '".$_POST['went']."', '".$_POST['kiesz']."', '".$_POST['cena']."', '".$_POST['ilosc']."', '".$_POST['img_path']."')";
    break;
  }
  if(!$conn->query($query))
    echo "Error";
  $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="shortcut icon" href="res/img/logo.ico">
	<title>Panel Administracyjny - Dodano produkt</title>

	<link href="https://fonts.googleapis.com/css?family=Lato:400,700&display=swap&subset=latin-ext" rel="stylesheet">
	<link rel="stylesheet" href="res/fontello/css/fontello.css" type="text/css">

	<link rel="stylesheet" href="css/core.css" type="text/css">
	<link rel="stylesheet" href="css/nav.css" type="text/css">

</head>
<body>
	<div id="site">
			<div id="header">
					<div id="logo">
							<img src="res/img/logo.png" alt="logo" style="height: 90px;float: left;">
							<div style="float: left; padding-top: 20px;">Panel Administracyjny Sklepu <span style="color: #138DA0;text-shadow: 1px 1px 1px #138DA0;">Komputerowego</span></div>
							<div class="clear"></div>
					</div>
					<div id="side">
            <?php echo $_SESSION['log_adm']."<br>"; ?>
            <a href="logout.php">Wyloguj <i class="icon-logout"></i></a>
					</div>
			</div>

		<div id="nav">
			<ul>
				<li>	<a href="index.php">Nowe zamówienia         </a></li>
				<li>	<a href="sent_orders.php">Zrealizowane zamówienia	</a></li>
				<li>	<a href="products.php">Produkty    			</a></li>
				<li>	<a href="add_product.php">Dodaj produkt  	</a></li>
			</ul>
		</div>

  <div id="content">
    <h2>Dodano do bazy danych produkt o nazwie: <?php echo $_POST['firma']." ".$_POST['model']?></h2><br>
    <div style="float: left;">
    <form action="add_product.php" method="POST">
      <input type="submit" value="Kontynuuj dodawanie">
    </form>
    </div>
    <div style="float: left; margin-left: 30px;">
    <form action="products.php" method="POST">
      <input type="submit" value="Wyświetl produkty">
    </form>
    </div>
    <div class="clear"></div>
    
	</div>
	<div id="footer">
		Sklep <span style="color: #138DA0">Komputerowy</span> &copy; 2022 Wszelkie prawa zastrzeżone
	</div>
</div>
</body>
</html>
