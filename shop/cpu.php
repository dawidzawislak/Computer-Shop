<?php
session_start();
require 'dbfunc.php';

if(isset($_POST['reset']))
{
	$_SESSION['reset'] = "reset";
	header('location:cpu.php');
	exit();
}
if(isset($_POST['filter']))
	unset($_SESSION['reset']);

if(!isset($_SESSION['config']))
{
	if(isset($_POST['product_id']))
	{
		$_SESSION['id_CPU'] = $_POST['product_id'];
		$_SESSION['buy_now'] = TRUE;
		header('location:address.php');
		exit();
	}
}
else
{
	if(isset($_POST['product_id']))
	{
		$_SESSION['id_CPU'] = $_POST['product_id'];
		header('location:gpu.php');
		exit();
	}

	if(isset($_POST['index']))
	{
		header('location:index.php');
		exit();
	}
	if(isset($_POST['skip']))
	{
		header('location:gpu.php');
		exit();
	}
	if(isset($_POST['back']))
	{
		header('location:mobo.php');
		exit();
	}

	$_SESSION['socket'] = '%';
	$_SESSION['format'] = '%';

	if(isset($_SESSION['id_MOBO']))
	{
		$conn = new mysqli($host, $dbuser, $dbpass, $dbname);
		if($conn->connect_error)
				die("Connection to \"sklep\" failed: ".$conn->connect_error);

		$query = "SELECT * FROM plyty_glowne WHERE id_MOBO LIKE \"".$_SESSION['id_MOBO']."\";";

		$result = $conn->query($query);
		if ($result === FALSE)
				echo "Error: ".$query ."<br>".$conn->error;

		if($result->num_rows > 0)
		{
				$row = $result->fetch_assoc();

				$_SESSION['socket'] = $row['socket'];

				$_SESSION['format'] = $row['format'];
		}

		$conn->close();
	}
}

$_SESSION['table_name'] = "procesory";
?>

<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="shortcut icon" href="res/img/logo.ico">
	<title>Sklep Komputerowy - <?php echo (isset($_SESSION['config']) ? "Konfigurator PC" : "Procesory")?></title>

	<meta name="description" content="Sklep internetowy z podzespołami komputerowymi pozwalający skonfigurować twojego własnego PC. Posiadamy wysokiej jakości komputery i podzespoły komputerowe, bez względu na to, czy jest to urządzenie do pracy, czy też do codziennego użytku.">
	<meta name="keywords" content="sklep, komputer, zbuduj, pc, konfiguracja, ram, procesor, płyta, główna, mobo, cpu, gpu, karta, graficzna, zasilacz, psu, obudowa, dysk, hdd, ssd, psu">

	<link href="https://fonts.googleapis.com/css?family=Lato:400,700&display=swap&subset=latin-ext" rel="stylesheet">
	<link rel="stylesheet" href="res/fontello/css/fontello.css" type="text/css">

	<link rel="stylesheet" href="css/zoom.lib.css">
	<link rel="stylesheet" href="css/core.css">
	<link rel="stylesheet" href="css/products.css">
	<?php echo '<link rel="stylesheet" href="css/'.(isset($_SESSION['config']) ? "config" : "nav").'.css">'; ?>

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
				echo '<li>	<a href="index.php">Kategorie  				</a></li>';
				echo '<li>	<a href="mobo.php">Płyty główne				</a></li>';
				echo '<li>	<a href="#">Procesory    							</a></li>';
				echo '<li>	<a href="gpu.php">Karty Graficzne   	</a></li>';
				echo '<li>	<a href="psu.php">Zasilacze         	</a></li>';
				echo '<li>	<a href="ram.php">RAM               	</a></li>';
				echo '<li>	<a href="disk.php">Dyski            	</a></li>';
				echo '<li>	<a href="case.php">Obudowy          	</a></li>';
				echo '<li>	<a href="config.php">Konfigurator PC 	</a></li>';
			echo '</ul>';
		echo '</div>';
	}
	else {
		DrawProgressBar(isset($_SESSION['buy_now']), 2);
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

					$query_mod = isset($_SESSION['config']) ? "socket LIKE \"".$_SESSION['socket']."\"" : "";

					if(!isset($_SESSION['config']))
						CreateCheckboxesForProperty("Gniazdo procesora", "socket", $_SESSION['table_name'], $conn);

					CreateCheckboxesForProperty("Taktowanie [GHz]", "taktowanie", $_SESSION['table_name'], $conn, $query_mod);
					CreateCheckboxesForProperty("Ilość rdzeni", "ilosc_rdzeni", $_SESSION['table_name'], $conn, $query_mod);
					CreateCheckboxesForProperty("TDP [W]", "TDP", $_SESSION['table_name'], $conn, $query_mod);
					CreateCheckboxesForBoolProperty("Odblokowany mnożnik", "odblokowany_mnoznik");

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

				$query_mod = isset($_SESSION['config']) ? "socket LIKE \"".$_SESSION['socket']."\"" : "1=1";
				$query = "SELECT * FROM ".$_SESSION['table_name']." WHERE ".$query_mod." AND";

				if(isset($_POST['filter']))
				{
					FilterByNameAndPrice($query, $_POST['name'], $_POST['pricemin'], $_POST['pricemax']);
					if(!isset($_SESSION['config']))
						FilterByCheckboxProp($query, "socket");
					FilterByCheckboxProp($query, "taktowanie");
					FilterByCheckboxProp($query, "ilosc_rdzeni");
					FilterByCheckboxProp($query, "TDP");
					FilterByCheckboxBoolProp($query, "odblokowany_mnoznik");
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
						$props[] = new ProductProp('Gniazdo procesora', $row['socket']);
						$props[] = new ProductProp('Taktowanie', $row['taktowanie']." GHz");
						$props[] = new ProductProp('Ilość rdzeni', $row['ilosc_rdzeni']);
						$props[] = new ProductProp('TDP', $row['TDP']." W");
						$props[] = new ProductProp('Pobór mocy', $row['pobor_mocy']." W");
						$props[] = new ProductProp('Chłodzenie box', BoolToStr($row['chlodzenie_box']));
						$props[] = new ProductProp('Odblokowany mnożnik', BoolToStr($row['odblokowany_mnoznik']));

						CreateProductDiv($row['id_CPU'], $row['firma'].' '.$row['model'], $row['img_path'], $row['cena'], $row['ilosc_sztuk'], $props, isset($_SESSION['config']));
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
