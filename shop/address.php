<?php
session_start();
require 'dbfunc.php';

ReleaseSessionVar('format');

if(isset($_POST['index']))
{
	header('location:index.php');
	exit();
}

$conn = new mysqli($host, $dbuser, $dbpass, $dbname);
if($conn->connect_error)
	die("Connection to \"sklep\" failed: ".$conn->connect_error);

if(isset($_SESSION['log']))
{
	ClientDataToSessionVars();

	$_SESSION['err'] = '';

	if(isset($_POST['send']))
	{
		if(empty($_POST['name']))
			$_SESSION['err'] .= "Podaj imię<br>";

		if(empty($_POST['lname']))
			$_SESSION['err'] .= "Podaj nazwisko<br>";

		if(empty($_POST['phone']))
			$_SESSION['err'] .= "Podaj telefon<br>";
		else
		{
			$phone_num = trim($_POST['phone']);
			if(strlen($phone_num) != 9)
				$_SESSION['err'] .= "Numer telefonu musi mieć 9 cyfr<br>";
		}

		if(empty($_POST['email']))
			$_SESSION['err'] .= "Podaj email<br>";

		if(empty($_POST['city']))
			$_SESSION['err'] .= "Podaj miejscowość<br>";

		if(empty($_POST['pcode']))
			$_SESSION['err'] .= "Podaj kod pocztowy<br>";
		else
		{
			$code = trim($_POST['pcode']);
			if(strlen($code) >= 3)
			{
				if(!($code[2] == '-' && strlen($code) == 6))
					$_SESSION['err'] .= "Podaj prawidłowy kod pocztowy<br>";
			} else $_SESSION['err'] .= "Podaj prawidłowy kod pocztowy<br>";
		}

		if(empty($_POST['address']))
			$_SESSION['err'] .= "Podaj adres<br>";


		$query = "UPDATE klienci SET ";
		UpdateClientDataInDB($query, "imie", "name");
		UpdateClientDataInDB($query, "nazwisko", "lname");
		UpdateClientDataInDB($query, "telefon", "phone");
		UpdateClientDataInDB($query, "email", "email");
		UpdateClientDataInDB($query, "miasto", "city");
		UpdateClientDataInDB($query, "kod_pocztowy", "pcode");
		UpdateClientDataInDB($query, "adres", "address");

        if(strlen($query) > 19)
        {
            $query = substr($query, 0, -1);
            $query .= "WHERE login LIKE \"".$_SESSION['log']."\";";
            $result = $conn->query($query);
            if ($result === FALSE)
                echo "Error: ".$query ."<br>".$conn->error;

			ClientDataToSessionVars();
		}

		if($_SESSION['err'] == '')
		{
			$query = "SELECT id_klienta FROM klienci WHERE login LIKE \"".$_SESSION['log']."\";";
			$result = $conn->query($query);
			if ($result === FALSE)
				echo "Error: ".$query ."<br>".$conn->error;

			$row = $result->fetch_assoc();
			$_SESSION['client_id'] = $row['id_klienta'];

			ReleaseSessionVar('err');
			header('location:summary.php');
			exit();
		}
	}
}
else
{
	if(isset($_POST['send']))
	{
		$_SESSION['err'] = '';

		if(empty($_POST['name']))
			$_SESSION['err'] .= "Podaj imię<br>";
		else
			$_SESSION['name'] = $_POST['name'];

		if(empty($_POST['lname']))
			$_SESSION['err'] .= "Podaj nazwisko<br>";
		else
			$_SESSION['lname'] = $_POST['lname'];

		if(empty($_POST['phone']))
			$_SESSION['err'] .= "Podaj telefon<br>";
		else
		{
			$phone_num = trim($_POST['phone']);
			if(strlen($phone_num) != 9)
				$_SESSION['err'] .= "Numer telefonu musi mieć 9 cyfr<br>";
			else
				$_SESSION['phone'] = $_POST['phone'];
		}

		if(empty($_POST['email']))
			$_SESSION['err'] .= "Podaj email<br>";
		else
			$_SESSION['email'] = $_POST['email'];

		if(empty($_POST['city']))
			$_SESSION['err'] .= "Podaj miejscowość<br>";
		else
			$_SESSION['city'] = ucwords($_POST['city']);

		if(empty($_POST['pcode']))
			$_SESSION['err'] .= "Podaj kod pocztowy<br>";
		else
		{
			$code = trim($_POST['pcode']);
			if($code[2] == '-' && strlen($code) == 6)
				$_SESSION['pcode'] = $code;
			else
				$_SESSION['err'] .= "Podaj prawidłowy kod pocztowy<br>";
		}

		if(empty($_POST['address']))
			$_SESSION['err'] .= "Podaj adres<br>";
		else
			$_SESSION['address'] = $_POST['address'];

		if($_SESSION['err'] == '')
		{
			$query = "INSERT INTO klienci (imie, nazwisko, telefon, email, miasto, kod_pocztowy, adres) VALUES "."(\"".$_SESSION['name']."\",\"".$_SESSION['lname']."\",\"".$_SESSION['phone']."\",\"".$_SESSION['email']."\",\"".$_SESSION['city']."\",\"".$_SESSION['pcode']."\",\"".$_SESSION['address']."\");";

			if ($conn->query($query) !== TRUE)
				echo "Error: ".$query ."<br>".$conn->error;

			$_SESSION['client_id'] = $conn->insert_id;

			ReleaseSessionVar('err');
			header('location:summary.php');
			exit();
		}
	}
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="shortcut icon" href="res/img/logo.ico">
	<title>Sklep Komputerowy - Dane klienta</title>

	<meta name="description" content="Sklep internetowy z podzespołami komputerowymi pozwalający skonfigurować twojego własnego PC. Posiadamy wysokiej jakości komputery i podzespoły komputerowe, bez względu na to, czy jest to urządzenie do pracy, czy też do codziennego użytku.">
	<meta name="keywords" content="sklep, komputer, zbuduj, pc, konfiguracja, ram, procesor, płyta, główna, mobo, cpu, gpu, karta, graficzna, zasilacz, psu, obudowa, dysk, hdd, ssd, psu">

	<link href="https://fonts.googleapis.com/css?family=Lato:400,700&display=swap&subset=latin-ext" rel="stylesheet">
	<link rel="stylesheet" href="res/fontello/css/fontello.css" type="text/css">

	<link rel="stylesheet" href="css/core.css" type="text/css">
	<link rel="stylesheet" href="css/config.css" type="text/css">
	<link rel="stylesheet" href="css/logreg.css" type="text/css">
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
	<?php DrawProgressBar(isset($_SESSION['buy_now']), 9); ?>
	<div id="content" style="padding: 35px; width: 930px;">
		<form method="POST" action="">
			<div id="left">
				<form method="POST" action="">
				<input style="letter-spacing: 0; padding: 10px; width: 180px; font-size: 13px; margin: 0;" type="submit" name="index" value="Powrót na stronę główną">

				<p>Imię: <br>
							<input name="name" type="text" value="<?php if(isset($_SESSION['name'])) echo $_SESSION['name']; ?>"></p>
							<p>Nazwisko: <br />
							<input name="lname" type="text" value="<?php if(isset($_SESSION['lname'])) echo $_SESSION['lname']; ?>"></p>
								<p>Telefon: <br />
							<input name="phone" type="number" max="999999999" step="1" value="<?php if(isset($_SESSION['phone'])) echo $_SESSION['phone']; ?>"></p>
								<p>Adres e-mail: <br />
							<input name="email" type="email" value="<?php if(isset($_SESSION['email'])) echo $_SESSION['email']; ?>"></p>

				<?php
				if(!isset($_SESSION['log']))
				{
					$_SESSION['reg_addr'] = "address.php";
					echo '<div style="font-size: 18px; text-align: center;"><a href="login.php">Zaloguj się</a>, aby wczytac dane z konta. <a href="reg.php">Zarejestruj się</a> aby zapisać dane na koncie, lub kontynuuj bez konta.</div>';
				}
				?>

			</div>
			<div id="right">
								<h3>Adres</h3>
								<p>Miejscowość: <br />
							<input name="city" type="text" value="<?php if(isset($_SESSION['city'])) echo $_SESSION['city']; ?>"></p>
								<p>Kod pocztowy: <br />
							<input name="pcode" type="text" value="<?php if(isset($_SESSION['pcode'])) echo $_SESSION['pcode']; ?>"></p>
								<p>Adres: <br />
							<input name="address" type="text" value="<?php if(isset($_SESSION['address'])) echo $_SESSION['address']; ?>"></p>


				<?php
				if(!empty($_SESSION['err']))
				{
					echo '<div id="err" style="width: 100%; left: 0;">'.$_SESSION['err'].'</div>';
					unset($_SESSION['err']);
				}
				?>

					<input type="submit" value="Zapisz i przejdz dalej" name="send">
			</div>
						</form>
			<div class="clear"></div>
	</div>
	<div id="footer">
		Sklep <span style="color: #138DA0">Komputerowy</span> &copy; 2022 Wszelkie prawa zastrzeżone
	</div>

	<script src="js/jquery-3.4.1.min.js"></script>
	<script src="js/script.js">	</script>
</body>
</html>
