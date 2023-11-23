<?php
    session_start();
    require 'dbfunc.php';

    $conn = new mysqli($host, $dbuser, $dbpass, $dbname);
    if($conn->connect_error)
        die("Connection to \"sklep\" failed: ".$conn->connect_error);

    if(isset($_POST['update']))
    {
        $query = "UPDATE klienci SET ";
        if(!empty($_POST['name']))       $query .= "imie = \"".ucwords($_POST['name'])."\" ,";
        if(!empty($_POST['lname']))      $query .= "nazwisko = \"".ucwords($_POST['lname'])."\" ,";
        if(!empty($_POST['phone']))
        {
			$phone_num = trim($_POST['phone']);
			if(strlen($phone_num) != 9)
				$_SESSION['err2'] = "Numer telefonu musi mieć 9 cyfr<br>";
			else
				$query .= "telefon = \"".ucwords($_POST['phone'])."\" ,";
        }
        if(!empty($_POST['email']))      $query .= "email = \"".$_POST['email']."\" ,";
        if(!empty($_POST['city']))       $query .= "miasto = \"".ucwords($_POST['city'])."\" ,";
        if(!empty($_POST['pcode']))
        {
            $code = trim($_POST['pcode']);
            if($code[2] == '-' && strlen($code) == 6)
                $query .= "kod_pocztowy = \"".$code."\" ,";
            else
                $_SESSION['err2'] = "Nieprawidłowy kod pocztowy";
        }
        if(!empty($_POST['address']))    $query .= "adres = \"".$_POST['address']."\" ,";

        if(strlen($query) > 19)
        {
            $query = substr($query, 0, -1);
            $query .= "WHERE login LIKE \"".$_SESSION['log']."\";";
            $result = $conn->query($query);
            if ($result === FALSE)
                echo "Error: ".$query ."<br>".$conn->error;
        }
    }

    if(isset($_POST['update2']))
    {
        $query = "SELECT haslo FROM klienci WHERE login LIKE \"".$_SESSION['log']."\";";
        $result = $conn->query($query);
        if ($result === FALSE)
            echo "Error: ".$query ."<br>".$conn->error;

        $pass = $result->fetch_assoc()['haslo'];

        $query = "UPDATE klienci SET ";

        if(!empty($_POST['login']))
        {
            if(!empty($_POST['old_pass']) && password_verify($_POST['old_pass'], $pass))
            {
                if ((strlen($_POST['login'])<3) || (strlen($_POST['login'])>20))
                {
                    if(isset($_SESSION['err'])) $_SESSION['err'] .= "Login musi posiadać od 3 do 20 znaków<br>";
                    else $_SESSION['err'] = "Login musi posiadać od 3 do 20 znaków<br>";
                }
                if (ctype_alnum($_POST['login'])==false)
                {
                    if(isset($_SESSION['err'])) $_SESSION['err'] .= "Login może składać się tylko z liter i cyfr (bez polskich znaków)<br>";
                    else $_SESSION['err'] = "Login może składać się tylko z liter i cyfr (bez polskich znaków)<br>";
                }

                if(!isset($_SESSION['err']))
                    $query .= "login = \"".$_POST['login']."\" ,";
            }
            else
            {
                $_SESSION['err'] = "Podaj poprawne stare hasło<br>";
            }
        }

        if(!empty($_POST['new_pass']))
        {
            if(!empty($_POST['old_pass']) && password_verify($_POST['old_pass'], $pass))
            {
                if ((strlen($_POST['new_pass'])<8) || (strlen($_POST['new_pass'])>20))
                {
        			if(isset($_SESSION['err'])) $_SESSION['err'] .= "Hasło musi posiadać od 8 do 20 znaków<br>";
                    else $_SESSION['err'] = "Hasło musi posiadać od 8 do 20 znaków<br>";
                }
        		else if ($_POST['new_pass'] != (isset($_POST['new_pass2']) ? $_POST['new_pass2'] : ''))
                {
        			if(isset($_SESSION['err'])) $_SESSION['err'] .= "Podane hasła nie są identyczne<br>";
                    else $_SESSION['err'] = "Podane hasła nie są identyczne<br>";
                }
                else
                    $query .= "haslo = \"".password_hash($_POST['new_pass'], PASSWORD_DEFAULT)."\" ,";
            }
            else
            {
                $_SESSION['err'] = "Podaj poprawne stare hasło<br>";
            }
        }

        if(strlen($query) > 19)
        {
            $query = substr($query, 0, -1);
            $query .= "WHERE login LIKE \"".$_SESSION['log']."\";";
            $result = $conn->query($query);
            if ($result === FALSE)
                echo "Error: ".$query ."<br>".$conn->error;
            else if(!empty($_POST['login']))
                $_SESSION['log'] = $_POST['login'];
        }
    }

    $query = "SELECT * FROM klienci WHERE login = \"".$_SESSION['log']."\";";
    $result = $conn->query($query);
    if ($result === FALSE)
        echo "Error: ".$query ."<br>".$conn->error;

    $row = $result->fetch_assoc();

    ClientDataToSessionVars();

    $conn->close();
?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="shortcut icon" href="res/img/logo.ico">
	<title>Sklep komputerowy - Edytuj profil</title>

    <meta name="description" content="Sklep internetowy z podzespołami komputerowymi pozwalający skonfigurować twojego własnego PC. Posiadamy wysokiej jakości komputery i podzespoły komputerowe, bez względu na to, czy jest to urządzenie do pracy, czy też do codziennego użytku.">
	<meta name="keywords" content="sklep, komputer, zbuduj, pc, konfiguracja, ram, procesor, płyta, główna, mobo, cpu, gpu, karta, graficzna, zasilacz, psu, obudowa, dysk, hdd, ssd, psu">

	<link href="https://fonts.googleapis.com/css?family=Lato:400,700&display=swap&subset=latin-ext" rel="stylesheet">

    <link rel="stylesheet" href="css/core.css" type="text/css">
	<link rel="stylesheet" href="css/logreg.css" type="text/css">
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
    <div id="wrapper2">
        <div id="h" style="margin-bottom: 10px;">Edytuj profil</div>
        <div id="left">
            <form name="form1" id="form1" method="POST" action="">
            	<p>Imię: <br>
            	<input name="name" type="text" placeholder="<?php echo $_SESSION['name']; ?>"></p>
            	<p>Nazwisko: <br />
            	<input name="lname" type="text" placeholder="<?php echo $_SESSION['lname']; ?>"></p>
                <p>Telefon: <br />
            	<input name="phone" type="number" max="999999999" step="1" placeholder="<?php if(isset($_SESSION['phone'])) { echo $_SESSION['phone']; } ?>"></p>
                <p>Adres e-mail: <br />
            	<input name="email" type="email" placeholder="<?php if(isset($_SESSION['email'])) { echo $_SESSION['email']; } ?>"></p>
                <h3>Adres</h3>
                <p>Miejscowość: <br />
            	<input name="city" type="text" placeholder="<?php if(isset($_SESSION['city'])) { echo $_SESSION['city']; unset($_SESSION['city']); } ?>"></p>
                <p>Kod pocztowy: <br />
            	<input name="pcode" type="text" placeholder="<?php if(isset($_SESSION['pcode'])) { echo $_SESSION['pcode']; unset($_SESSION['city']); } ?>"></p>
                <p>Adres: <br />
            	<input name="address" type="text" placeholder="<?php if(isset($_SESSION['address'])) { echo $_SESSION['address']; unset($_SESSION['address']); } ?>"></p>

                <?php
                    if(isset($_SESSION['err2']))
                    {
                        echo '<div id="err" style="width:90%; margin-left: 50px;">'.$_SESSION['err2'].'</div>';
                        unset($_SESSION['err2']);
                    }
                ?>

            	<input type="submit" value="Zaaktualizuj" name="update">
              </form>
              <?php
                UnsetClientDataInSessionVars();
              ?>

        </div>
        <div id="right">
            <form name="form2" id="form2" method="POST" action="">
            <h3>Zmień login i/lub hasło</h3>
            <p>Login: <br>
            <input name="login" type="text" placeholder="<?php echo $_SESSION['log']; ?>"></p>
            <div style="border-bottom: 2px dashed #767676;"></div>
            <p>Nowe hasło: <br />
            <input name="new_pass" type="password"></p>
            <p>Powtórz hasło: <br />
            <input name="new_pass2" type="password"></p>
            <div style="border-bottom: 2px dashed #767676;"></div>
            <p>Stare hasło: <br />
            <input name="old_pass" type="password" placeholder="**********" required></p>

            <?php
                if(isset($_SESSION['err']))
                {
                    echo '<div id="err" style="width:100%; margin-left: 50px;">'.$_SESSION['err'].'</div>';
                    unset($_SESSION['err']);
                }
            ?>

            <input type="submit" value="Zmień" name="update2">
            </form>
        </div>
        <div style="clear: both;font-size: 18px; padding-top: 15px; text-align: center;">Przejdź do <a href="index.php">strony głównej</a></span></div>
    </div>
</body>
</html>
