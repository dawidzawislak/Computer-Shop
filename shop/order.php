<?php
session_start();

require 'dbfunc.php';

UnsetClientDataInSessionVars();
if(!isset($_SESSION['log']))
{
    ReleaseSessionVar('name');
    ReleaseSessionVar('lname');
}

$conn = new mysqli($host, $dbuser, $dbpass, $dbname);
if($conn->connect_error)
    die("Connection to \"sklep\" failed: ".$conn->connect_error);

class Product {
    public $type;
    public $id;

    function __construct($type, $id)
    {
        $this->type = $type;
        $this->id = $id;
    }
}

$products = [];

function AddProduct($type)
{
    if(isset($_SESSION[$type]))
    {
        global $products;
        $products[] = new Product($type, $_SESSION[$type]);
        unset($_SESSION[$type]);
    }
}

AddProduct('id_CPU');
AddProduct('id_GPU');
AddProduct('id_RAM');
AddProduct('id_dysk1');
AddProduct('id_dysk2');
AddProduct('id_MOBO');
AddProduct('id_PSU');
AddProduct('id_obudowa');

$columns = ' (';
$values = ' (';

foreach ($products as $product) {
    $columns .= $product->type.",";
    $values .= "\"".$product->id."\",";
}

$columns = substr($columns, 0, -1).") ";
$values = substr($values, 0, -1).") ";

if($columns != " ) " && $values != " ) ")
{
    $query = "INSERT INTO produkty ".$columns."VALUES".$values.";";

    if (!$conn->query($query) === TRUE)
      echo "Error: " . $query . "<br>" . $conn->error;

    $id = $conn->insert_id;

    $query = "INSERT INTO zamowienia (id_klienta, id_produkty, cena_zamowienia, uwagi) VALUES "."(\"".$_SESSION['client_id']."\",\"".$id."\",\"".$_SESSION['price']."\",\"".(isset($_POST['comment']) ? $_POST['comment'] : '')."\");";
    if (!$conn->query($query) === TRUE)
      echo "Error: " . $query . "<br>" . $conn->error;
    unset($_SESSION['client_id']);
    unset($_SESSION['price']);
}

$conn->close();

ReleaseSessionVar('buy_now');
?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="shortcut icon" href="res/img/logo.ico">
	<title>Sklep komputerowy - Zamównie przyjęte</title>

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
        <div id="h">Zamówienie przyjęte</div>
        <form method="POST" action="index.php">
            <input style="margin-top: 30px; font-size: 19px; padding: 9px; width: 300px;" type="submit" name="go" value="Przejdź na stronę główną"><br>
        </form>
    </div>
</body>
</html>
