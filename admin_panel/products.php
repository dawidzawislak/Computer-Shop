<?php
session_start();
if(!isset($_SESSION['log_adm']))
{
  header('location:login.php');
  exit();
}
require 'dbfunc.php';
?>

<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="shortcut icon" href="res/img/logo.ico">
	<title>Panel Administracyjny - Produkty</title>

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
		<table id="t_prod">
			<thead>
				<tr>
				<?php
					$cat = isset($_POST['cat']) ? $_POST['cat'] : (isset($_SESSION['cat']) ? $_SESSION['cat'] : "Płyty główne");
					$_SESSION['cat'] = $cat;

					$conn = new mysqli($host, $dbuser, $dbpass, $dbname);
					if($conn->connect_error)
						die("Connection to \"sklep\" failed: ".$conn->connect_error);

					$t_name = "plyty_glowne";
					$id_name = "id_MOBO";
					$id = -1;
					$query = "";

					switch($cat) {
						case "Płyty główne":
							echo "<th>Id</th><th>Firma</th><th>Model</th><th>Socket</th><th>Sloty PCIe</th><th>Sloty RAM</th><th>Format</th><th>Cena[zł]</th><th>Ilość sztuk</th><th>Ścieżka do zdjęcia</th><th>Edytuj</th><th>Usuń</th></tr></thead><tbody>";
							$t_name = "plyty_glowne";
							$id_name = "id_MOBO";
						break;
						case "Procesory":
							echo "<th>Id</th> <th>Firma</th> <th>Model</th> <th>Socket</th> <th>Taktowanie [GHz]</th> <th>Ilość Rdzeni</th> <th>TDP</th> <th>Pobór mocy[W]</th> <th>Chłodzenie Box</th> <th>Odblokowany mnożnik</th> <th>Cena[zł]</th> <th>Ilość sztuk</th><th>Ścieżka do zdjęcia</th><th>Edytuj</th><th>Usuń</th></tr></thead><tbody>";
							$t_name = "procesory";
							$id_name = "id_CPU";
						break;
						case "Karty graficzne":
							echo "<th>Id</th> <th>Firma</th> <th>Model</th> <th>Pamięć</th> <th>Rodzaj Pamięci</th> <th>Złącza</th> <th>TDP</th> <th>Pobór mocy [W]</th> <th>Rdzenie CUDA</th> <th>Cena [zł]</th> <th>Ilość Sztuk</th><th>Ścieżka do zdjęcia</th><th>Edytuj</th> <th>Usuń</th></tr></thead><tbody>";
							$t_name = "karty_graficzne";
							$id_name = "id_GPU";
						break;
						case "Zasilacze":
							echo "<th>Id</th> <th>Firma</th> <th>Model</th> <th>Moc [W]</th> <th>Sprawność [%]</th> <th>Certyfikat</th> <th>Modularność</th> <th>Cena [zł]</th> <th>Ilość Sztuk</th> <th>Ścieżka do zdjęcia</th><th>Edytuj</th> <th>Usuń</th></tr></thead><tbody>";
							$t_name = "zasilacze";
							$id_name = "id_PSU";
						break;
						case "RAM":
							echo "<th>Id</th> <th>Firma</th> <th>Model</th> <th>Rodzaj Pamięci</th> <th>Pojemność [GB]</th> <th>Taktowanie [MHz]</th> <th>Opóźnienie</th> <th>Cena [zł]</th> <th>Ilość Sztuk</th><th>Ścieżka do zdjęcia</th> <th>Edytuj</th> <th>Usuń</th></tr></thead><tbody>";
							$t_name = "ram";
							$id_name = "id_RAM";
						break;
						case "Dyski":
							echo "<th>Id</th> <th>Firma</th> <th>Model</th> <th>Pojemność [GB]</th> <th>Technologia</th> <th>Interfejs</th> <th>Rodzaj</th> <th>Pręd. Odczytu [MB/s]</th> <th>Pręd. Zapisu [MB/s]</th> <th>Cena [zł]</th> <th>Ilość Sztuk</th><th>Ścieżka do zdjęcia</th> <th>Edytuj</th> <th>Usuń</th></thead><tbody>";
							$t_name = "dyski";
							$id_name = "id_dysk";
						break;
						case "Obudowy":
							echo "<th>Id</th> <th>Firma</th> <th>Model</th> <th>Typ</th> <th>Standard płyty</th> <th>RGB</th> <th>Wentylator</th> <th>Ilość kieszeni na dysk</th> <th>Cena [zł]</th> <th>Ilość Sztuk</th><th>Ścieżka do zdjęcia</th> <th>Edytuj</th> <th>Usuń</th></thead><tbody>";
							$t_name = "obudowy";
							$id_name = "id_obudowa";
						break;
					}
					$query = "SELECT * FROM ".$t_name." ORDER BY ".$id_name;
					$result = $conn->query($query);
					while($row = $result->fetch_row())
					{
						$id = $row[0];
						$name = $row[1]." ".$row[2];
						echo "<tr>";
						$i = 1;
						foreach($row as $val)
						{
							if(($t_name == "procesory" && ($i == 9 || $i == 10)) || ($t_name == "zasilacze" && $i == 7) || ($t_name == "obudowy" && ($i == 6 || $i == 7)))
								$val = BoolToStr($val);

							echo "<td>".$val."</td>";
							$i += 1;
						}
						echo '<td><form action="edit.php" method="POST">';
						echo '<input type="hidden" name="name" value="'.$name.'">';
						echo '<input type="hidden" name="id" value="'.$id.'">';
						echo '<input type="hidden" name="id_name" value="'.$id_name.'">';
						echo '<input type="hidden" name="cat" value="'.$t_name.'">';
						echo '<input value="Edytuj" type="submit"></form></td>';
						echo '<td><form action="delete.php" method="POST">';
						echo '<input type="hidden" name="name" value="'.$name.'">';
						echo '<input type="hidden" name="id" value="'.$id.'">';
						echo '<input type="hidden" name="cat" value="'.$t_name.'">';
						echo '<input type="hidden" name="id_name" value="'.$id_name.'">';
						echo '<input value="Usuń" type="submit"></form></td></tr>';
					}
					$conn->close();
				?>
			</tbody>
		</table>
	</div>
	<div id="footer">
		Sklep <span style="color: #138DA0">Komputerowy</span> &copy; 2022 Wszelkie prawa zastrzeżone
	</div>
</div>
</body>
</html>
