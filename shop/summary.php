<?php
session_start();

require 'dbfunc.php';
?>

<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="shortcut icon" href="res/img/logo.ico">
	<title>Sklep Komputerowy - Podsumowanie zamówienia</title>

	<meta name="description" content="Sklep internetowy z podzespołami komputerowymi pozwalający skonfigurować twojego własnego PC. Posiadamy wysokiej jakości komputery i podzespoły komputerowe, bez względu na to, czy jest to urządzenie do pracy, czy też do codziennego użytku.">
	<meta name="keywords" content="sklep, komputer, zbuduj, pc, konfiguracja, ram, procesor, płyta, główna, mobo, cpu, gpu, karta, graficzna, zasilacz, psu, obudowa, dysk, hdd, ssd, psu">

	<link href="https://fonts.googleapis.com/css?family=Lato:400,700&display=swap&subset=latin-ext" rel="stylesheet">
	<link rel="stylesheet" href="res/fontello/css/fontello.css" type="text/css">

	<link rel="stylesheet" href="css/core.css" type="text/css">
	<link rel="stylesheet" href="css/config.css" type="text/css">
	<style>
		body {
			color: #FFF;
		}
	</style>
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
    </div>
    <?php DrawProgressBar(isset($_SESSION['buy_now']), 10); ?>
    <div id="content">
        <div style="padding: 20px;float:left;">
            <h2 style="margin-bottom: 10px;">Koszyk: </h2>
            <?php
                $products = [];
                if(isset($_SESSION['id_MOBO'])) $products[] = new ProductByID("plyty_glowne", "id_MOBO", $_SESSION['id_MOBO']);
                if(isset($_SESSION['id_CPU'])) $products[] = new ProductByID("procesory", "id_CPU", $_SESSION['id_CPU']);
                if(isset($_SESSION['id_GPU'])) $products[] = new ProductByID("karty_graficzne", "id_GPU", $_SESSION['id_GPU']);
                if(isset($_SESSION['id_PSU'])) $products[] = new ProductByID("zasilacze", "id_PSU", $_SESSION['id_PSU']);
                if(isset($_SESSION['id_RAM'])) $products[] = new ProductByID("ram", "id_RAM", $_SESSION['id_RAM']);
                if(isset($_SESSION['id_dysk1'])) $products[] = new ProductByID("dyski", "id_dysk", $_SESSION['id_dysk1']);
                if(isset($_SESSION['id_dysk2'])) $products[] = new ProductByID("dyski", "id_dysk", $_SESSION['id_dysk2']);
                if(isset($_SESSION['id_obudowa'])) $products[] = new ProductByID("obudowy", "id_obudowa", $_SESSION['id_obudowa']);
                CreateProductDivsFromDB($products);
            ?>
        </div>
        <div style="padding: 20px;float:left;">
            <h2 style="margin-bottom: 10px;">Dane zamawiającego: </h2>
            <?php
                echo $_SESSION['name']." ".$_SESSION['lname']."<br>";
                echo "Telefon: ".$_SESSION['phone']."<br>";
                echo "E-mail: ".$_SESSION['email']."<br>";
                echo "Adres: <br>";
                echo $_SESSION['city']." ".$_SESSION['pcode']."<br>";
                echo $_SESSION['address']."<br>";
            ?>
            <form method="POST" action="order.php">
                <textarea style="margin: 20px; width: 100%; height: 70px; resize: none;" placeholder="Uwagi dotyczące zamówienia.." name="comment"></textarea><br>
                <input style="font-size: 19px; padding: 9px; width: 300px;" type="submit" name="send" value="Zamów"><br>
            </form>
            <form method="POST" action="address.php">
                <input style="letter-spacing: 0; padding: 10px; width: 180px; font-size: 13px; margin-left: 90px;" type="submit" name="index" value="Powrót na stronę główną">
            </form>
        </div>
        <div class="clear"></div>
    </div>
    <div id="footer">
        Sklep <span style="color: #138DA0">Komputerowy</span> &copy; 2022 Wszelkie prawa zastrzeżone
    </div>

	<script src="js/jquery-3.4.1.min.js"></script>
	<script src="js/center_img_sm.js">	</script>
</body>
</html>
