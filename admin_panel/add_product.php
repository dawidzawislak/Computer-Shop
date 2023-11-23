<?php
session_start();
if(!isset($_SESSION['log_adm']))
{
  header('location:login.php');
  exit();
}
require 'dbfunc.php';
ReleaseSessionVar("cat");
?>

<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="shortcut icon" href="res/img/logo.ico">
	<title>Panel Administracyjny - Dodaj produkt</title>

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
    <form action="" method="POST">
			<input class="btn" type="submit" name="cat" value="Płyty główne">
      <input class="btn" type="submit" name="cat" value="Procesory">
      <input class="btn" type="submit" name="cat" value="Karty graficzne">
			<input class="btn" type="submit" name="cat" value="Zasilacze">
			<input class="btn" type="submit" name="cat" value="RAM">
			<input class="btn" type="submit" name="cat" value="Dyski">
			<input class="btn" type="submit" name="cat" value="Obudowy">
    </form>
    <?php
      $cat = isset($_POST['cat']) ? $_POST['cat'] : "Płyty główne";
      echo "<br><h2>Dodawanie produktu z kategori: ".$cat."</h2><br>";
    ?>
    <form action="added.php" method="POST">
      <input type="hidden" name="cat" value="<?php echo $cat; ?>">
      Firma: <br>
      <input type="text" name="firma" required><br><br>
      Model: <br>
      <input type="text" name="model" required><br><br>
      Cena [zł]: <br>
      <input type="number" name="cena" step="0.01" min="0" required><br><br>
      Ilość sztuk: <br>
      <input type="number" name="ilosc" step="1" min="0" required><br><br>
      Scieżka do pliku z rozszerzeniem: <br>
      <input type="text" name="img_path" required><br><br>

      <?php       
        switch($cat) {
          case "Płyty główne":
            echo "Socket: <br>";
            echo '<input type="text" name="socket" required><br><br>';
            echo "Sloty PCIe: <br>";
            echo '<input type="number" name="pcie" step="1" min="0" required><br><br>';
            echo "Sloty RAM: <br>";
            echo '<input type="number" name="ram" step="1" min="0" required><br><br>';
            echo "Format: <br>";
            echo '<input type="text" name="format" required>';
          break;
          case "Procesory":
            echo "Socket: <br>";
            echo '<input type="text" name="socket" required><br><br>';
            echo "Taktowanie [GHz]: <br>";
            echo '<input type="number" name="takt" step="0.1" min="0" required><br><br>';
            echo "Ilość rdzeni: <br>";
            echo '<input type="number" name="rdzenie" step="1" min="0" required><br><br>';
            echo "TDP: <br>";
            echo '<input type="number" name="tdp" step="1" min="0" required><br><br>';
            echo "Pobór mocy [W]: <br>";
            echo '<input type="number" name="moc" step="1" min="0" required><br><br>';
            echo "Chłodzenie box: <br>";
            echo '<select name="box">';
            echo '<option value="1" selected>Tak</option>';
            echo '<option value="0">Nie</option>';
            echo '</select><br><br>';
            echo "Odblokowany mnożnik: <br>";
            echo '<select name="odbl">';
            echo '<option value="1" selected>Tak</option>';
            echo '<option value="0">Nie</option>';
            echo '</select>';
          break;
          case "Karty graficzne":
            echo "Pamięć [GB]: <br>";
            echo '<input type="number" name="pam" step="1" min="0" required><br><br>';
            echo "Rodzaj pamięci: <br>";
            echo '<input type="text" name="rodz" required><br><br>';
            echo "Złącza: <br>";
            echo '<input type="text" name="zlacza" required><br><br>';
            echo "TDP: <br>";
            echo '<input type="number" name="tdp" required><br><br>';
            echo "Pobór mocy [W]: <br>";
            echo '<input type="number" name="moc" step="1" min="0" required><br><br>';
            echo "Ilość rdzeni CUDA(pozostaw puste jeśli karta nie posiada): <br>";
            echo '<input type="text" name="cuda" patern="[0-9]">';
          break;
          case "Zasilacze":
            echo "Moc [W]: <br>";
            echo '<input type="number" name="moc" step="1" min="0" required><br><br>';
            echo "Sprawność: <br>";
            echo '<input type="number" name="sprawnosc" step="1" min="0" required><br><br>';
            echo "Certifikat(pozostaw puste jeśli nie posiada): <br>";
            echo '<input type="text" name="cert"><br><br>';
            echo "Modularność: <br>";
            echo '<select name="mod">';
            echo '<option value="1" selected>Tak</option>';
            echo '<option value="0">Nie</option>';
            echo '</select>';
          break;
          case "RAM":
            echo "Rodzaj pamięci: <br>";
            echo '<input type="text" name="rodz" required><br><br>';
            echo "Pojemność [GB]: <br>";
            echo '<input type="number" name="poj" step="1" min="0" required><br><br>';
            echo "Taktowanie [MHz]: <br>";
            echo '<input type="number" name="takt" step="1" min="0" required><br><br>';
            echo "Opóźnienie: <br>";
            echo '<input type="number" name="op" step="1" min="0" required>';
          break;
          case "Dyski":
            echo "Pojemność [GB]: <br>";
            echo '<input type="number" name="poj" step="1" min="0" required><br><br>';
            echo "Technologia: <br>";
            echo '<select name="tech">';
            echo '<option value="HDD" selected>HDD</option>';
            echo '<option value="SDD">SSD</option>';
            echo '</select><br><br>';
            echo "Interfejs: <br>";
            echo '<input type="text" name="int" required><br><br>';
            echo "Rodzaj kości pamięci(jeśli dysk HDD pozostaw puste): <br>";
            echo '<select name="rodz">';
            echo '<option value="" selected></option>';
            echo '<option value="SLC">SLC</option>';
            echo '<option value="MLC">MLC</option>';
            echo '<option value="TLC">TLC</option>';
            echo '<option value="QLC">QLC</option>';
            echo '<option value="PLC">PLC</option>';
            echo '</select><br><br>';
            echo "Prędkość odczytu [MB/s]: <br>";
            echo '<input type="number" name="pr_o" step="1" min="0" required><br><br>';
            echo "Prędkość zapisu [MB/s]: <br>";
            echo '<input type="number" name="pr_z" step="1" min="0" required>';
          break;
          case "Obudowy":
            echo "Typ: <br>";
            echo '<input type="text" name="typ" required><br><br>';
            echo "Standard płyty: <br>";
            echo '<input type="text" name="stand" required><br><br>';
            echo "Podświetlenie RGB: <br>";
            echo '<select name="rgb">';
            echo '<option value="1" selected>Tak</option>';
            echo '<option value="0">Nie</option>';
            echo '</select><br><br>';
            echo "Wbudowany wentylator: <br>";
            echo '<select name="went">';
            echo '<option value="1" selected>Tak</option>';
            echo '<option value="0">Nie</option>';
            echo '</select><br><br>';
            echo "Ilość kieszeni na dysk: <br>";
            echo '<input type="number" name="kiesz" step="1" min="0" required>';
          break;
        }
      ?>
      <br><br>
      <input style="width: 100%; font-size: 130%;" name="add" type="submit" value="Dodaj">
    </form>
	</div>
	<div id="footer">
		Sklep <span style="color: #138DA0">Komputerowy</span> &copy; 2022 Wszelkie prawa zastrzeżone
	</div>
</div>
</body>
</html>
