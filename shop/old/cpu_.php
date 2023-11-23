<?php
session_start();
if(isset($_POST['reset']))
{
	$_SESSION['reset'] = "reset";
	header('location:cpu.php');
	exit();
}
if(isset($_POST['filter']))
	unset($_SESSION['reset']);

if(isset($_POST['product_id']))
{
	$_SESSION['id_CPU'] = $_POST['product_id'];
	$_SESSION['buy_now'] = TRUE;
	header('location:address.php');
	exit();
}

require 'dbfunc.php';
$_SESSION['table_name'] = "procesory";
?>

<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="shortcut icon" href="res/img/logo.ico">
	<title>Sklep Komputerowy - Procesory</title>

	<meta name="description" content="Sklep internetowy z podzespołami komputerowymi pozwalający skonfigurować twojego własnego PC. Posiadamy wysokiej jakości komputery i podzespoły komputerowe, bez względu na to, czy jest to urządzenie do pracy, czy też do codziennego użytku.">
	<meta name="keywords" content="sklep, komputer, zbuduj, pc, konfiguracja, ram, procesor, płyta, główna, mobo, cpu, gpu, karta, graficzna, zasilacz, psu, obudowa, dysk, hdd, ssd, psu">

	<link href="https://fonts.googleapis.com/css?family=Lato:400,700&display=swap&subset=latin-ext" rel="stylesheet">
	<link rel="stylesheet" href="res/fontello/css/fontello.css" type="text/css">

	<link rel="stylesheet" href="css/core.css" type="text/css">
	<link rel="stylesheet" href="css/products.css" type="text/css">
	<link rel="stylesheet" href="css/nav.css" type="text/css">

</head>
<body>
	<div id="header">
			<div id="logo">
					<img src="res/img/logo.png" alt="logo" style="height: 90px;float: left;">
					<div style="float: left; padding-top: 15px;">Sklep <span style="color: #138DA0;text-shadow: 1.5px 1.5px 1.5px #138DA0;">Komputerowy</span></div>
					<div class="clear"></div>
			</div>
			<div id="side">
					<?php ProfileInfo(); ?>
			</div>
	</div>
	<div id="nav">
		<ul>
			<li>	<a href="index.php">Kategorie  			</a></li>
			<li>	<a href="mobo.php">Płyty główne			</a></li>
			<li>	<a href="#">Procesory    				</a></li>
			<li>	<a href="gpu.php">Karty Graficzne   	</a></li>
			<li>	<a href="psu.php">Zasilacze         	</a></li>
							<li>	<a href="ram.php">RAM               	</a></li>
							<li>	<a href="disk.php">Dyski            	</a></li>
							<li>	<a href="case.php">Obudowy          	</a></li>
			<li>	<a href="config_mobo.php">Konfigurator PC </a></li>
		</ul>
	</div>

	<div id="content">
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

					CreateCheckboxesForProperty("Gniazdo procesora", "socket", $_SESSION['table_name'], $conn);
					CreateCheckboxesForProperty("Taktowanie [GHz]", "taktowanie", $_SESSION['table_name'], $conn);
					CreateCheckboxesForProperty("Ilość rdzeni", "ilosc_rdzeni", $_SESSION['table_name'], $conn);
					CreateCheckboxesForProperty("TDP [W]", "TDP", $_SESSION['table_name'], $conn);
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

				$query = "SELECT * FROM ".$_SESSION['table_name']." WHERE 1=1 AND";

				if(isset($_POST['filter']))
				{
					FilterByNameAndPrice($query, $_POST['name'], $_POST['pricemin'], $_POST['pricemax']);
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

						CreateProductDiv($row['id_CPU'], $row['firma'].' '.$row['model'], $row['img_path'], $row['cena'], $row['ilosc_sztuk'], $props, FALSE);
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
	<script src="js/sticky.js">	</script>
	<script src="js/script.js">	</script>
	<script src="js/center_img.js">	</script>
</body>
</html>
