<?php
session_start();

require 'dbfunc.php';

if(isset($_SESSION['log']))
{
  header('location:index.php');
  exit();
}

if(isset($_POST["register"]))
{
    $name = trim($_POST["name"]);
    $lname = trim($_POST["lname"]);
    $login = trim($_POST["login"]);
    $pass = trim($_POST["pass"]);
    $pass2 = trim($_POST["pass2"]);
    $email = trim($_POST["email"]);

    $fields_ok = TRUE;

    $error = "";

    $conn = new mysqli($host, $dbuser, $dbpass, $dbname);
    if ($conn->connect_error)
        die("Connection to \"sklep\" failed: ".$conn->connect_error);
    
    $query = "SELECT * FROM klienci WHERE login LIKE \"".$login."\"";
    $res = $conn->query($query);
    if($res->num_rows > 0)
    {
        $error .= "Użytkownik o takim loginie już istnieje<br>";
    }
    else
    {
        if ((strlen($login)<3) || (strlen($login)>20))
            $error .= "Login musi posiadać od 3 do 20 znaków<br>";
        else if (ctype_alnum($login)==false)
            $error .= "Login może składać się tylko z liter i cyfr (bez polskich znaków)<br>";
        else
            $login_ok = TRUE;
    }
    $conn->close();

    if ((strlen($pass)<8) || (strlen($pass)>20))
        $error .= "Hasło musi posiadać od 8 do 20 znaków<br>";

    if ($pass!=$pass2)
        $error .= "Podane hasła nie są identyczne<br>";

    $pass_hash = password_hash($pass, PASSWORD_DEFAULT);
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="shortcut icon" href="res/img/logo.ico">
	<title>Sklep Komputerowy - Rejestracja</title>

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
        <form method="POST" action="reg.php">
            <div id="h">Rejestracja</div>
            <p>Imię: <br>
        	<input name="name" type="text" pattern="[A-zżźćńółęąśŻŹĆĄŚĘŁÓŃ]+"  title="Imię może zawierać tylko litery" <?php echo (isset($fields_ok) ? "value=\"".$name."\"" : "") ?> required></p>
            <p>Nazwisko: <br>
        	<input name="lname" type="text" pattern="[A-zżźćńółęąśŻŹĆĄŚĘŁÓŃ-]+" title="Imię może zawierać tylko litery" <?php echo (isset($fields_ok) ? "value=\"".$lname."\"" : "") ?> required></p>
        	<p>Adres e-mail: <br>
        	<input name="email" type="email" <?php echo (isset($fields_ok) ? "value=\"".$email."\"" : "") ?> required></p>
        	<p>Login: <br>
        	<input name="login" type="text" <?php echo (isset($login_ok) ? "value=\"".$login."\"" : "") ?> required></p>
            <p>Hasło: <br>
        	<input name="pass" oninput="check(this)" type="password" required></p>
            <div id="indicator1" style="display:none; float: left; height: 3px; width: 65%; background-color: #BBB;">
                <div id="indicator2" style="height: 100%;"></div>
            </div>
            <div style="font-size: 80%; float: right; margin-top: -8px;" id="strength"></div>
            <div class="clear"></div>
            <p style="margin-top: 4px;">Powtórz hasło: <br>
        	<input name="pass2" type="password" required></p>

            <?php
            if(isset($_POST["register"]))
            {
                if($error != "")
                    echo '<div id="err">'.$error.'</div>';
                else
                {
                    $conn = new mysqli($host, $dbuser, $dbpass, $dbname);
                    if ($conn->connect_error)
                        die("Connection to \"sklep\" failed: ".$conn->connect_error);

                    $query = "INSERT INTO klienci (imie, nazwisko, email, login, haslo) VALUES ('$name','$lname','$email','$login','$pass_hash');";

                    if ($conn->query($query) !== TRUE)
                        echo "Error: ".$query ."<br>".$conn->error;

                    $conn->close();

                    $_SESSION['log'] = $login;
                    $_SESSION['name'] = $name;
                    $_SESSION['lname'] = $lname;
                    $file = isset($_SESSION['reg_addr']) ? $_SESSION['reg_addr'] : "index.php";
                    ReleaseSessionVar('reg_addr');

                    header("location:".$file);
                    exit();
                }
            }
            ?>

        	<input type="submit" value="Zarejestruj" name="register">
          </form>

          <div style="font-size: 16px; text-align: center;">Jeśli posiadasz już konto <a href="login.php">Zaloguj się</a></div>
    </div>
    <script src="js/jquery-3.4.1.min.js"></script>
	<script src="js/pass_strength.js">	</script>
</body>
</html>
