<?php
session_start();
require 'dbfunc.php';

if(isset($_POST['reset']))
{
	$_SESSION['reset'] = "reset";
	header('location:psu.php');
	exit();
}

if(!isset($_SESSION['config']))
{
	if(isset($_POST['product_id']))
	{
		$_SESSION['id_PSU'] = $_POST['product_id'];
		$_SESSION['buy_now'] = TRUE;
		header('location:address.php');
		exit();
	}
}
else
{
	if(isset($_POST['id']))
	{
		$_SESSION['id_PSU'] = $_POST['product_id'];
		header('location:ram.php');
		exit();
	}

	if(isset($_POST['index']))
	{
		header('location:index.php');
		exit();
	}
	if(isset($_POST['skip']))
	{
		header('location:ram.php');
		exit();
	}
	if(isset($_POST['back']))
	{
		header('location:gpu.php');
		exit();
	}

	if(isset($_POST['filter']))
		unset($_SESSION['reset']);

	$conn = new mysqli($host, $dbuser, $dbpass, $dbname);
	if($conn->connect_error)
			die("Connection to \"sklep\" failed: ".$conn->connect_error);

	$_SESSION['power_consump2'] = 0;

	if(isset($_SESSION['id_GPU']))
	{
		$query = "SELECT * FROM karty_graficzne WHERE id_GPU LIKE \"".$_SESSION['id_GPU']."\";";

		$result = $conn->query($query);
		if ($result === FALSE)
				echo "Error: ".$query ."<br>".$conn->error;

		if($result->num_rows > 0)
		{
				$row = $result->fetch_assoc();

				$_SESSION['power_consump2'] = $row['pobor_mocy'];
		}

		$conn->close();
	}
}

$_SESSION['table_name'] = "zasilacze";
?>

<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="shortcut icon" href="res/img/logo.ico">
	<title>Sklep Komputerowy - <?php echo (isset($_SESSION['config']) ? "Konfigurator PC" : "Zasilacze")?></title>

	<meta name="description" content="Sklep internetowy z podzespołami komputerowymi pozwalający skonfigurować twojego własnego PC. Posiadamy wysokiej jakości komputery i podzespoły komputerowe, bez względu na to, czy jest to urządzenie do pracy, czy też do codziennego użytku.">
	<meta name="keywords" content="sklep, komputer, zbuduj, pc, konfiguracja, ram, procesor, płyta, główna, mobo, cpu, gpu, karta, graficzna, zasilacz, psu, obudowa, dysk, hdd, ssd, psu">

	<link href="https://fonts.googleapis.com/css?family=Lato:400,700&display=swap&subset=latin-ext" rel="stylesheet">
	<link rel="stylesheet" href="res/fontello/css/fontello.css" type="text/css">

	<link rel="stylesheet" href="css/zoom.lib.css">
	<link rel="stylesheet" href="css/core.css" type="text/css">
	<link rel="stylesheet" href="css/products.css" type="text/css">
	<?php echo '<link rel="stylesheet" href="css/'.(isset($_SESSION['config']) ? "config" : "nav").'.css" type="text/css">'; ?>

</head>
<body>
		<div id="header">
				<div id="logo">
					<a href="index.php" title="Przejdź na stronę główną"><img src="res/img/logo.png" alt="logo" style="height: 90px;float: left;"></a>
					<a href="index.php" title="Przejdź na stronę główną">	
						<div style="float: left; margin-top: 15px;">Sklep <span style="color: #138DA0;text-shadow: 1.5px 1.5px 1.5px #138DA0;">Komputerowy</span></div>
					</a>
					<div class="clear"></div>
				</div>
				<?php 
					if(!isset($_SESSION['config'])) 
					{
						echo '<div id="side">';
						ProfileInfo();
						echo '</div>'; 
					}
				?>
		</div>
		<?php 
			if(!isset($_SESSION['config']))
			{
				echo '<div id="nav">';
					echo '<ul>';
						echo '<li>	<a href="index.php">Kategorie  			</a></li>';
						echo '<li>	<a href="mobo.php">Płyty główne				</a></li>';
						echo '<li>	<a href="#">Procesory    			</a></li>';
						echo '<li>	<a href="gpu.php">Karty Graficzne   	</a></li>';
						echo '<li>	<a href="psu.php">Zasilacze         	</a></li>';
						echo '<li>	<a href="ram.php">RAM               	</a></li>';
						echo '<li>	<a href="disk.php">Dyski            	</a></li>';
						echo '<li>	<a href="case.php">Obudowy          	</a></li>';
						echo '<li>	<a href="config.php">Konfigurator PC </a></li>';
					echo '</ul>';
				echo '</div>';
			}
			else {
				DrawProgressBar(isset($_SESSION['buy_now']), 4);
			}
		?>
		<div id="content">
			<?php
				if(isset($_SESSION['config']))
				{
					echo '<div id="config_h">';
						echo '<form method="POST" action="">';
							echo '<input style="width: 180px; margin: 0;" type="submit" name="index" value="Powrót na stronę główną">';
							echo '&nbsp;&nbsp;&nbsp;&nbsp; Elementy pasujące do konfiguracji: &nbsp;&nbsp;&nbsp;&nbsp;';
							echo '<input style="width: 80px; margin: 0;" type="submit" class="reset" name="back" value="Wstecz"> ';
							echo '<input style="width: 80px; margin: 0;" type="submit" name="skip" value="Pomiń">';
						echo '</form>';
					echo '</div>';
				}
			?>
			<div id="filters">
				<form method="POST" action="">
					<div class="filter_header">Sortuj według: </div>
					<select id="sort_sel" name="sort" onchange="sbmit()">
					    <option <?php RememberSlectedAsc("sort"); ?> value="ASC">Cena rosnąco</option>
					    <option <?php RememberSlectedDesc("sort"); ?> value="DESC">Cena malejąco</option>
					</select>

					<div class="filter_header" style="margin-top: 15px;">FILTRY:</div>

		            <p>Nazwa produktu: <br>
		        	<input name="name" type="text" value="<?php RememberParams("name"); ?>"></p>

					<p>Cena: <br>
				   	<input class="price_input" name="pricemin" type="number" step="0.01" placeholder="od" value="<?php RememberParams("pricemin"); ?>"> -
				   	<input class="price_input" name="pricemax" type="number" step="0.01" placeholder="do" value="<?php RememberParams("pricemax"); ?>"> zł</p>

					<?php
						$conn = new mysqli($host, $dbuser, $dbpass, $dbname);
						if($conn->connect_error)
							die("Connection to \"sklep\" failed: ".$conn->connect_error);

							$pc1 = (isset($_SESSION['power_consump']) ? $_SESSION['power_consump'] : 0);
							$pc2 = (isset($_SESSION['power_consump2']) ? $_SESSION['power_consump2'] : 0);
							$query_mod = (isset($_SESSION['config']) ? "moc > ".(($pc1+	$pc2) / 0.8) : "");
						
						CreateCheckboxesForProperty("Moc [W]", "moc", $_SESSION['table_name'], $conn, $query_mod);
						CreateCheckboxesForProperty("Certyfikat", "certyfikat", $_SESSION['table_name'], $conn, $query_mod);
						CreateCheckboxesForBoolProperty("Modularny", "modularnosc");

						$conn->close();
					?>

					<input type="submit" id="send" name="filter" value="Filtruj"><br>
					<input type="submit" id="reset" name="reset" value="Resetuj"><br>
				</form>
			</div>
			<div id="products">
				<?php
					$conn = new mysqli($host, $dbuser, $dbpass, $dbname);
					if($conn->connect_error)
						die("Connection to \"sklep\" failed: ".$conn->connect_error);

					$pc1 = (isset($_SESSION['power_consump']) ? $_SESSION['power_consump'] : 0);
					$pc2 = (isset($_SESSION['power_consump2']) ? $_SESSION['power_consump2'] : 0);
					$query_mod = (isset($_SESSION['config']) ? "moc > ".(($pc1+	$pc2) / 0.8) : "1=1");

					$query = "SELECT * FROM ".$_SESSION['table_name']." WHERE ".$query_mod." AND";

					if(isset($_POST['filter']))
					{
						FilterByNameAndPrice($query, $_POST['name'], $_POST['pricemin'], $_POST['pricemax']);
						FilterByCheckboxProp($query, "moc");
						FilterByCheckboxProp($query, "certyfikat");
						FilterByCheckboxBoolProp($query, "modularnosc");
					}

					$query = substr($query, 0, -3);

					$order = (isset($_POST['sort']) ? $_POST['sort'] : '');
					SortQuery($query, $order);

					$result = $conn->query($query);
					if ($result === FALSE)
						echo "Error: ".$query ."<br>".$conn->error;

					if($result->num_rows > 0)
					{
						while($row = $result->fetch_assoc())
						{
							$props = [];
							$props[] = new ProductProp('Moc', $row['moc']." W");
							$props[] = new ProductProp('Sprawność', $row['sprawnosc']." %");
                            if($row['certyfikat'] != '')
							    $props[] = new ProductProp('Certyfikat', $row['certyfikat']);
							$props[] = new ProductProp('Modularny', BoolToStr($row['modularnosc']));

							CreateProductDiv($row['id_PSU'], $row['firma'].' '.$row['model'], $row['img_path'], $row['cena'], $row['ilosc_sztuk'], $props, isset($_SESSION['config']));
						}
					}
					else
						echo '<div class="product_not_found"><h3 style="margin-bottom: 10px;">Przepraszamy, nie znaleźliśmy tego, czego szukasz</h2>Usuń wybrane filtry, aby rozszerzyć wyszukiwanie</div>';

					unset($_SESSION['table_name']);
					$conn->close();
				?>
		</div>
		<div class="clear"></div>
	</div>
	<div id="footer">
		Sklep <span style="color: #138DA0">Komputerowy</span> &copy; 2022 Wszelkie prawa zastrzeżone
	</div>

	<script src="js/jquery-3.4.1.min.js"></script>
	<script src="js/zoom.lib.js"></script>

	<?php 
		if(!isset($_SESSION['config'])) echo '<script src="js/sticky.js"></script>';
		else echo '<script src="js/sticky_prog.js"></script>';
	 ?>
	<script src="js/script.js">	</script>
	<script src="js/center_img.js">	</script>
</body>
</html>
