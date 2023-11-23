<?php
session_start();

require 'dbfunc.php';
ReleaseSessionVar('reg_addr');
ReleaseSessionVar('config');

UnsetClientDataInSessionVars();
if(!isset($_SESSION['log']))
{
    ReleaseSessionVar('name');
    ReleaseSessionVar('lname');
}

ReleaseSessionVar('id_MOBO');
ReleaseSessionVar('id_CPU');
ReleaseSessionVar('id_GPU');
ReleaseSessionVar('id_PSU');
ReleaseSessionVar('id_RAM');
ReleaseSessionVar('id_dysk1');
ReleaseSessionVar('id_dysk2');
ReleaseSessionVar('id_obudowa');
?>

<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="shortcut icon" href="res/img/logo.ico">
	<title>Sklep Komputerowy - Kategorie</title>

	<meta name="description" content="Sklep internetowy z podzespołami komputerowymi pozwalający skonfigurować twojego własnego PC. Posiadamy wysokiej jakości komputery i podzespoły komputerowe, bez względu na to, czy jest to urządzenie do pracy, czy też do codziennego użytku.">
	<meta name="keywords" content="sklep, komputer, zbuduj, pc, konfiguracja, ram, procesor, płyta, główna, mobo, cpu, gpu, karta, graficzna, zasilacz, psu, obudowa, dysk, hdd, ssd, psu">

	<link href="https://fonts.googleapis.com/css?family=Lato:400,700&display=swap&subset=latin-ext" rel="stylesheet">
	<link rel="stylesheet" href="res/fontello/css/fontello.css" type="text/css">

	<link rel="stylesheet" href="css/core.css" type="text/css">
	<link rel="stylesheet" href="css/nav.css" type="text/css">
	<link rel="stylesheet" href="css/index.css" type="text/css">

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
			<div id="side">
				<?php ProfileInfo(); ?>
			</div>
	</div>
	<div id="nav">
		<ul>
			<li>	<a href="#">Kategorie          			</a></li>
			<li>	<a href="mobo.php">Płyty główne			</a></li>
			<li>	<a href="cpu.php">Procesory    			</a></li>
			<li>	<a href="gpu.php">Karty Graficzne   	</a></li>
			<li>	<a href="psu.php">Zasilacze         	</a></li>
			<li>	<a href="ram.php">RAM               	</a></li>
			<li>	<a href="disk.php">Dyski            	</a></li>
			<li>	<a href="case.php">Obudowy          	</a></li>
			<li>	<a href="config.php">Konfigurator PC </a></li>
		</ul>
	</div>

	<div id="content">
					<div class="category_frame"><a class="img_a" href="mobo.php"><div class="category"><img class="category_img" src="res/img/mobo.png" alt="mobo"><br>Płyty główne</div></a></div>
					<div class="category_frame"><a class="img_a" href="cpu.php"><div class="category"><img class="category_img" src="res/img/cpu.png" alt="cpu"><br>Procesory</div></a></div>
					<div class="category_frame"><a class="img_a" href="gpu.php"><div class="category"><img class="category_img" src="res/img/gpu.png" alt="gpu"><br>Karty graficzne</div></a></div>
					<div class="category_frame"><a class="img_a" href="psu.php"><div class="category"><img class="category_img" src="res/img/psu.png" alt="psu"><br>Zasilacze</div></a></div>
					<div class="category_frame"><a class="img_a" href="ram.php"><div class="category"><img class="category_img" src="res/img/ram.png" alt="ram"><br>RAM</div></a></div>
					<div class="category_frame"><a class="img_a" href="disk.php"><div class="category"><img class="category_img" src="res/img/disk2.png" alt="disk"><br>Dyski</div></a></div>
					<div class="category_frame"><a class="img_a" href="case.php"><div class="category"><img class="category_img" src="res/img/case.png" alt="case"><br>Obudowy</div></a></div>
					<div class="category_frame"><a class="img_a" href="#"><div class="category"><img class="category_img" style="width:210px" src="res/img/conf.png" alt="config_pc"><br>Skonfiguruj zestaw</div></a></div>
					<div class="clear"></div>
	</div>

	<div id="footer">
		Sklep <span style="color: #138DA0">Komputerowy</span> &copy; 2022 Wszelkie prawa zastrzeżone
	</div>

	<script src="js/jquery-3.4.1.min.js"></script>
	<script src="js/sticky.js">	</script>
</body>
</html>
