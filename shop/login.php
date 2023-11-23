<?php
session_start();

require 'dbfunc.php';

if(isset($_SESSION['log']))
{
  header('location:index.php');
  exit();
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="shortcut icon" href="res/img/logo.ico">
	<title>Sklep Komputerowy - Logowanie</title>

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

    <div id="wrapper">
        <form method="POST" action="login.php">
            <div id="h">Logowanie</div>
        	<p>Login: <br>
        	<input name="login" type="text" required></p>
        	<p>Hasło: <br />
        	<input name="pass" type="password" required></p>

            <?php
            if(isset($_POST['log_in']))
            {
                $login = trim($_POST['login']);
                $pass = trim($_POST['pass']);

                $conn = new mysqli($host, $dbuser, $dbpass, $dbname);
                if($conn->connect_error)
                    die("Connection to \"sklep\" failed: ".$conn->connect_error);

                $query = "SELECT login,haslo,email,imie,nazwisko FROM klienci;";
                $result = $conn->query($query);
                if ($result === FALSE)
                    echo "Error: ".$query ."<br>".$conn->error;

                if($result->num_rows > 0)
                {
                    while($row = $result->fetch_assoc())
                    {
                        if($login == $row['login'] && password_verify($pass, $row['haslo']))
                        {
                            $_SESSION['log'] = $login;
                            $_SESSION['name'] = $row['imie'];
                            $_SESSION['lname'] = $row['nazwisko'];
                            $file = isset($_SESSION['reg_addr']) ? $_SESSION['reg_addr'] : "index.php";
                            header('location:'.$file);
                            exit();
                        }
                    }
                }
                $conn->close();
                echo '<div id="err">Niepoprawne dane logowania</div>';
            }
            ?>

        	<input type="submit" value="Zaloguj" name="log_in">
        </form>
        <?php
        if(!isset($_SESSION['reg_addr']))
            echo '<div style="font-size: 16px; text-align: center;">Jeśli nie posiadasz konta <a href="reg.php">Zarejestruj się</a></div>';
        ?>
    </div>
</body>
</html>
