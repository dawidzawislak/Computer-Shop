<?php
session_start();
if(isset($_SESSION['log_adm']))
{
  header('location:index.php');
  exit();
}
require 'dbfunc.php';
?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="shortcut icon" href="res/img/logo.ico">
	<title>Logowanie - Panel Administracyjny</title>

	<link href="https://fonts.googleapis.com/css?family=Lato:400,700&display=swap&subset=latin-ext" rel="stylesheet">

  <link rel="stylesheet" href="css/core.css" type="text/css">
	<link rel="stylesheet" href="css/logreg.css" type="text/css">
</head>
<body>
    <div id="header">
        <div id="logo">
            <img src="res/img/logo.png" alt="logo" style="height: 85px;float: left;">
            <div style="float: left; padding-top: 20px;">Panel Administracyjny Sklepu <span style="color: #138DA0;text-shadow: 1px 1px 1px #138DA0;">Komputerowego</span></div>
            <div class="clear"></div>
        </div>
    </div>


    <div id="wrapper">
        <form method="POST" action="login.php">
            <div id="h">Logowanie</div>
            <p>Login: <br>
            <input name="login" type="text"></p>
            <p>Hasło: <br />
            <input name="pass" type="password"></p>

            <?php
            if(isset($_POST['login']) && isset($_POST['pass']))
            {
                $login = trim($_POST['login']);
                $pass = trim($_POST['pass']);

                $conn = new mysqli($host, $dbuser, $dbpass, $dbname);
                if($conn->connect_error)
                    die("Connection to \"sklep\" failed: ".$conn->connect_error);

                $query = "SELECT login, haslo FROM admini;";
                $result = $conn->query($query);
                if ($result === FALSE)
                    echo "Error: ".$query ."<br>".$conn->error;

                if($result->num_rows > 0)
                {
                    while($row = $result->fetch_assoc())
                    {
                        if($login == $row['login'] && password_verify($pass, $row['haslo']))
                        {
                            $_SESSION['log_adm'] = $login;
                            header('location:index.php');
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
    </div>
</body>
</html>
