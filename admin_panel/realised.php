<?php
session_start();
if(!isset($_SESSION['log_adm']))
{
  header('location:login.php');
  exit();
}
require 'dbfunc.php';

$date=strtotime($_POST['date']);
$date_to_insert = date('Y-m-d',$date);
$conn = new mysqli($host, $dbuser, $dbpass, $dbname);
    if($conn->connect_error)
        die("Connection to \"sklep\" failed: ".$conn->connect_error);

    $query = "UPDATE zamowienia SET data_realizacji = '".$date_to_insert."' WHERE zamowienia.id_zamowienia = ".$_POST['id'].";";

    if ($conn->query($query) !== TRUE)
      echo "Setting realisation date failed!";

    $query = "UPDATE zamowienia SET wyslano = 1 WHERE zamowienia.id_zamowienia = ".$_POST['id'].";";
    $conn->query($query);

    $conn->close();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="shortcut icon" href="res/img/logo.ico">
	<title>Panel Administracyjny - Zrealizowano</title>

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
    <h2>Zrealizowano zamówienie nr <?php echo $_POST['id']?></h2>
    <form action="index.php" method="POST">
      <input type="submit" value="Powrót na stronę główną">
    </form>
    
	</div>
	<div id="footer">
		Sklep <span style="color: #138DA0">Komputerowy</span> &copy; 2022 Wszelkie prawa zastrzeżone
	</div>
</div>
</body>
</html>
