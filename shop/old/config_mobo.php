<?php
session_start();
require 'dbfunc.php';

ReleaseSessionVar('buy_now');

if(isset($_POST['reset']))
{
	$_SESSION['reset'] = "reset";
	header('location:config_mobo.php');
	exit();
}
if(isset($_POST['filter']))
	unset($_SESSION['reset']);

if(isset($_POST['id']))
{
	$_SESSION['id_MOBO'] = $_POST['product_id'];
	header('location:config_cpu.php');
	exit();
}

if(isset($_POST['index']))
{
	header('location:index.php');
	exit();
}
if(isset($_POST['skip']))
{
	header('location:config_cpu.php');
	exit();
}

$_SESSION['table_name'] = "plyty_glowne";
?>

<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="shortcut icon" href="res/img/logo.ico">
	<title>Sklep Komputerowy - Konfigurator PC</title>

	<meta name="description" content="Sklep internetowy z podzespołami komputerowymi pozwalający skonfigurować twojego własnego PC. Posiadamy wysokiej jakości komputery i podzespoły komputerowe, bez względu na to, czy jest to urządzenie do pracy, czy też do codziennego użytku.">
	<meta name="keywords" content="sklep, komputer, zbuduj, pc, konfiguracja, ram, procesor, płyta, główna, mobo, cpu, gpu, karta, graficzna, zasilacz, psu, obudowa, dysk, hdd, ssd, psu">

	<link href="https://fonts.googleapis.com/css?family=Lato:400,700&display=swap&subset=latin-ext" rel="stylesheet">
	<link rel="stylesheet" href="res/fontello/css/fontello.css" type="text/css">

	<link rel="stylesheet" href="css/core.css" type="text/css">
	<link rel="stylesheet" href="css/products.css" type="text/css">
	<link rel="stylesheet" href="css/config.css" type="text/css">

</head>
<body>
	<div id="header">
			<div id="logo">
					<img src="res/img/logo.png" alt="logo" style="height: 90px;float: left;">
					<div style="float: left; padding-top: 15px;">Sklep <span style="color: #138DA0;text-shadow: 1.5px 1.5px 1.5px #138DA0;">Komputerowy</span></div>
					<div class="clear"></div>
			</div>
	</div>
	<?php DrawProgressBar(isset($_SESSION['buy_now']), 1); ?>
	<div id="content">
		<div id="config_h">
			<form method="POST" action="">
				<input style="width: 180px; margin: 0;" type="submit" name="index" value="Powrót na stronę główną">

				&nbsp;&nbsp;&nbsp;&nbsp; Elementy pasujące do konfiguracji: &nbsp;&nbsp;&nbsp;&nbsp;

				<input style="width: 80px; margin: 0;  margin-left: 85px;" type="submit" name="skip" value="Pomiń">
			</form>
		</div>
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
						CreateCheckboxesForProperty("Format", "format", $_SESSION['table_name'], $conn);
						CreateCheckboxesForProperty("Ilość slotów na RAM", "sloty_ram", $_SESSION['table_name'], $conn);
						CreateCheckboxesForProperty("Ilość slotów PCIe", "sloty_pcie", $_SESSION['table_name'], $conn);

					$conn->close();
				?>

				<input type="submit" id="send" name="filter" value="Filtruj"><br>
				<input type="submit" class="reset" name="reset" value="Resetuj"><br>
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
					FilterByCheckboxProp($query, "format");
					FilterByCheckboxProp($query, "sloty_ram");
					FilterByCheckboxProp($query, "sloty_pcie");
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
						$props[] = new ProductProp('Format', $row['format']);
						$props[] = new ProductProp('Ilość gniazd PCIe', $row['sloty_pcie']);
						$props[] = new ProductProp('Ilość slotów na RAM', $row['sloty_ram']);

						CreateProductDiv($row['id_MOBO'], $row['firma'].' '.$row['model'], $row['img_path'], $row['cena'], $row['ilosc_sztuk'], $props);
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
	<script src="js/script.js">	</script>
	<script src="js/center_img.js">	</script>
</body>
</html>
