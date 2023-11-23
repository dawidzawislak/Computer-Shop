<?php
session_start();
if(!isset($_SESSION['log_adm']))
{
  header('location:login.php');
  exit();
}
require 'dbfunc.php';
if(isset($_POST['save']))
{
  $conn = new mysqli($host, $dbuser, $dbpass, $dbname);
  if($conn->connect_error)
    die("Connection to \"sklep\" failed: ".$conn->connect_error);
  
  $id = $_POST['id'];
  $firma = $_POST['firma'];
  $model = $_POST['model'];
  $cena = $_POST['cena'];
  $ilosc = $_POST['ilosc'];
  $img_path = $_POST['img_path'];

  switch($_SESSION['cat'])
  {
    case "Płyty główne":
      $query = "UPDATE plyty_glowne SET firma = '".$firma."', model = '".$model."', socket = '".$_POST['socket']."', sloty_pcie = '".$_POST['pcie']."', sloty_ram = '".$_POST['ram']."', format = '".$_POST['format']."', cena = '".$cena."', ilosc_sztuk = '".$ilosc."', img_path = '".$img_path."' WHERE id_MOBO = ".$id.";";
    break;
    case "Procesory":
      $query = "UPDATE procesory SET firma = '".$firma."', model = '".$model."', socket = '".$_POST['socket']."', taktowanie = '".$_POST['takt']."', ilosc_rdzeni = '".$_POST['rdzenie']."', TDP = '".$_POST['tdp']."', pobor_mocy = '".$_POST['moc']."', chlodzenie_box = '".$_POST['box']."', odblokowany_mnoznik = '".$_POST['odbl']."', cena = '".$cena."', ilosc_sztuk = '".$ilosc."', img_path = '".$img_path."' WHERE procesory.id_CPU = ".$id.";";
    break;
    case "Karty graficzne":
      $query = "UPDATE karty_graficzne SET firma = '".$firma."', model = '".$model."', pamiec = '".$_POST['pam']."m', rodzaj_pamieci = '".$_POST['rodz']."', zlacza = '".$_POST['zlacza']."', TDP = '".$_POST['tdp']."', pobor_mocy = '".$_POST['moc']."', rdzenie_CUDA =".(!empty($_POST['cuda']) ? "'".$_POST['cuda']."'" : "NULL").", cena = '".$cena."', ilosc_sztuk = '".$ilosc."', img_path = '".$img_path."' WHERE karty_graficzne.id_GPU = ".$id.";";
    break;
    case "Zasilacze":
      $query = "UPDATE zasilacze SET firma = '".$firma."', model = '".$model."', moc = '".$_POST['moc']."', sprawnosc = '".$_POST['sprawnosc']."', certyfikat = ".(!empty($_POST['cert']) ? "'".$_POST['cert']."'" : "NULL").",modularnosc = '".$_POST['mod']."', cena = '".$cena."', ilosc_sztuk = '".$ilosc."', img_path = '".$img_path."' WHERE zasilacze.id_PSU = ".$id.";";
    break;
    case "RAM":
      $query = "UPDATE ram SET firma = '".$firma."', model = '".$model."', rodzaj_pamieci = '".$_POST['rodz']."', pojemnosc = '".$_POST['poj']."', taktowanie = '".$_POST['takt']."', opoznienie = '".$_POST['op']."', cena = '".$cena."', ilosc_sztuk = '".$ilosc."', img_path = '".$img_path."' WHERE ram.id_RAM = ".$id.";";
    break;
    case 'Dyski':
      $query = "UPDATE dyski SET firma = '".$firma."', model = '".$model."', pojemnosc = '".$_POST['poj']."', technologia = '".$_POST['tech']."', interfejs = '".$_POST['int']."', rodzaj_kosci_pamieci = ".(!empty($_POST['rodz']) ? "'".$_POST['rodz']."'" : "NULL").", predkosc_odczytu = '".$_POST['pr_o']."', predkosc_zapisu = '".$_POST['pr_z']."', cena = '".$cena."', ilosc_sztuk = '".$ilosc."', img_path = '".$img_path."' WHERE dyski.id_dysk = ".$id.";";
    break;
    case 'Obudowy':
      $temp = explode(",", $_POST['stand']);
      $tab = [];
      foreach($temp as $stand) 
      {
        $tab[] = trim($stand);
      }
      sort($tab);
      $standards = implode(",", $tab);

      $query = "UPDATE obudowy SET firma = '".$firma."', model = '".$model."', typ = '".$_POST['typ']."', standard_plyty = '".$standards."', rgb = '".$_POST['rgb']."', wentylator = '".$_POST['went']."', ilosc_kieszeni_dysk = '".$_POST['kiesz']."', cena = '".$cena."', ilosc_sztuk = '".$ilosc."', img_path = '".$img_path."' WHERE obudowy.id_obudowa = ".$id.";";
    break;
  }
  if(!$conn->query($query))
        echo "Product update failed(".$firma." ".$model.")";
  $conn->close();

  header("location:products.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="shortcut icon" href="res/img/logo.ico">
	<title>Panel Administracyjny - Edycja produktu</title>

	<link href="https://fonts.googleapis.com/css?family=Lato:400,700&display=swap&subset=latin-ext" rel="stylesheet">
	<link rel="stylesheet" href="res/fontello/css/fontello.css" type="text/css">

	<link rel="stylesheet" href="css/core.css" type="text/css">
	<link rel="stylesheet" href="css/nav.css" type="text/css">

</head>
<body>
	<div id="site">
			<div id="header">
					<div id="logo">
							<img src="res/img/logo.png" alt="logo" style="height: 90px;float: left;">
							<div style="float: left; padding-top: 20px;">Panel Administracyjny Sklepu <span style="color: #138DA0;text-shadow: 1px 1px 1px #138DA0;">Komputerowego</span></div>
							<div class="clear"></div>
					</div>
					<div id="side">
            <?php echo $_SESSION['log_adm']."<br>"; ?>
            <a href="logout.php">Wyloguj <i class="icon-logout"></i></a>
					</div>
			</div>

		<div id="nav">
			<ul>
        <li>	<a href="index.php">Nowe zamówienia               </a></li>
				<li>	<a href="sent_orders.php">Zrealizowane zamówienia	</a></li>
				<li>	<a href="products.php">Produkty    			          </a></li>
				<li>	<a href="add_product.php">Dodaj produkt  	        </a></li>
			</ul>
		</div>

  <div id="content">
    <div style="float: left;">
      <form action="products.php" method="POST">
          <input type="submit" value="Powrót do produktów">
      </form>
    </div>
    <div style="float: right;">
      <?php echo "<h2>Edycja: ".$_POST['name']."</h2>"; ?>
    </div>
    <div class="clear"></div>
    <br>
    <form action="" method="POST">
      
      <?php 
        if(isset($_POST['cat']))
        {
          $conn = new mysqli($host, $dbuser, $dbpass, $dbname);
          if($conn->connect_error)
            die("Connection to \"sklep\" failed: ".$conn->connect_error);

          $query = "SELECT * FROM ".$_POST['cat']." WHERE ".$_POST['id_name']." = ".$_POST['id'].";";
          $result = $conn->query($query);
          $product = $result->fetch_all(MYSQLI_ASSOC);
          
          $name = $product[0]['firma']." ".$product[0]['model'];

          $conn->close();
          echo "Firma: <br>";
          echo '<input type="hidden" name="id" value="'.$product[0][$_POST['id_name']].'">';
          echo '<input type="text" name="firma" value="'.$product[0]['firma'].'"><br><br>';
          echo "Model: <br>";
          echo '<input type="text" name="model" value="'.$product[0]['model'].'"><br><br>';
          echo "Cena [zł]: <br>";
          echo '<input type="number" name="cena" step="0.01" min="0" value="'.$product[0]['cena'].'"><br><br>';
          echo "Ilość sztuk: <br>";
          echo '<input type="number" name="ilosc" step="1" min="0" value="'.$product[0]['ilosc_sztuk'].'"><br><br>';
          echo "Scieżka do pliku z rozszerzeniem: <br>";
          echo '<input type="text" name="img_path" value="'.$product[0]['img_path'].'"><br><br>';

          switch($_POST['cat']) {
            case 'plyty_glowne':
              echo "Socket: <br>";
              echo '<input type="text" name="socket" value="'.$product[0]['socket'].'"><br><br>';
              echo "Sloty PCIe: <br>";
              echo '<input type="number" name="pcie" step="1" min="0" value="'.$product[0]['sloty_pcie'].'"><br><br>';
              echo "Sloty RAM: <br>";
              echo '<input type="number" name="ram" step="1" min="0" value="'.$product[0]['sloty_ram'].'"><br><br>';
              echo "Format: <br>";
              echo '<input type="text" name="format" value="'.$product[0]['format'].'">';
            break;
            case 'procesory':
              echo "Socket: <br>";
              echo '<input type="text" name="socket" value="'.$product[0]['socket'].'"><br><br>';
              echo "Sloty PCIe: <br>";
              echo '<input type="number" name="takt" step="0.1" min="0" value="'.$product[0]['taktowanie'].'"><br><br>';
              echo "Ilość rdzeni: <br>";
              echo '<input type="number" name="rdzenie" step="1" min="0" value="'.$product[0]['ilosc_rdzeni'].'"><br><br>';
              echo "TDP: <br>";
              echo '<input type="number" name="tdp" step="1" min="0" value="'.$product[0]['TDP'].'"><br><br>';
              echo "Pobór mocy [W]: <br>";
              echo '<input type="number" name="moc" step="1" min="0" value="'.$product[0]['pobor_mocy'].'"><br><br>';
              echo "Chłodzenie box: <br>";
              echo '<select name="box">';
              echo '<option value="1" '.($product[0]['chlodzenie_box'] == 1 ? "selected" : "").'>Tak</option>';
              echo '<option value="0" '.($product[0]['chlodzenie_box'] == 0 ? "selected" : "").'>Nie</option>';
              echo '</select><br><br>';
              echo "Odblokowany mnożnik: <br>";
              echo '<select name="odbl">';
              echo '<option value="1" '.($product[0]['odblokowany_mnoznik'] == 1 ? "selected" : "").'>Tak</option>';
              echo '<option value="0" '.($product[0]['odblokowany_mnoznik'] == 0 ? "selected" : "").'>Nie</option>';
              echo '</select>';
            break;
            case 'karty_graficzne':
              echo "Pamięć [GB]: <br>";
              echo '<input type="number" name="pam" step="1" min="0" value="'.$product[0]['pamiec'].'"><br><br>';
              echo "Rodzaj pamięci: <br>";
              echo '<input type="text" name="rodz" value="'.$product[0]['rodzaj_pamieci'].'"><br><br>';
              echo "Złącza: <br>";
              echo '<input type="text" name="zlacza" value="'.$product[0]['zlacza'].'"><br><br>';
              echo "TDP: <br>";
              echo '<input type="number" name="tdp" step="1" min="0" value="'.$product[0]['TDP'].'"><br><br>';
              echo "Pobór mocy [W]: <br>";
              echo '<input type="number" name="moc" step="1" min="0" value="'.$product[0]['pobor_mocy'].'"><br><br>';
              echo "Ilość rdzeni CUDA: <br>";
              echo '<input type="text" name="cuda" patern="[0-9]" value="'.$product[0]['rdzenie_CUDA'].'">';
            break;
            case 'zasilacze':
              echo "Moc [W]: <br>";
              echo '<input type="number" name="moc" step="1" min="0" value="'.$product[0]['moc'].'"><br><br>';
              echo "Sprawność: <br>";
              echo '<input type="number" name="sprawnosc" step="1" min="0" value="'.$product[0]['sprawnosc'].'"><br><br>';
              echo "Certifikat: <br>";
              echo '<input type="text" name="cert" value="'.$product[0]['certyfikat'].'"><br><br>';
              echo "Modularność: <br>";
              echo '<select name="mod">';
              echo '<option value="1" '.($product[0]['modularnosc'] == 1 ? "selected" : "").'>Tak</option>';
              echo '<option value="0" '.($product[0]['modularnosc'] == 0 ? "selected" : "").'>Nie</option>';
              echo '</select>';
            break;
            case 'ram':
              echo "Rodzaj pamięci: <br>";
              echo '<input type="text" name="rodz" value="'.$product[0]['rodzaj_pamieci'].'"><br><br>';
              echo "Pojemność [GB]: <br>";
              echo '<input type="number" name="poj" step="1" min="0" value="'.$product[0]['pojemnosc'].'"><br><br>';
              echo "Taktowanie [MHz]: <br>";
              echo '<input type="number" name="takt" step="1" min="0" value="'.$product[0]['taktowanie'].'"><br><br>';
              echo "Opóźnienie: <br>";
              echo '<input type="number" name="op" step="1" min="0" value="'.$product[0]['opoznienie'].'">';
            break;
            case 'dyski':
              echo "Pojemność [GB]: <br>";
              echo '<input type="number" name="poj" step="1" min="0" value="'.$product[0]['pojemnosc'].'"><br><br>';
              echo "Technologia: <br>";
              echo '<select name="tech">';
              echo '<option value="HDD" '.($product[0]['technologia'] == 'HDD' ? "selected" : "").'>HDD</option>';
              echo '<option value="SSD" '.($product[0]['technologia'] == 'SSD' ? "selected" : "").'>SSD</option>';
              echo '</select><br><br>';
              echo "Interfejs: <br>";
              echo '<input type="text" name="int" value="'.$product[0]['interfejs'].'"><br><br>';
              echo "Rodzaj kości pamięci: <br>";
              echo '<select name="rodz">';
              echo '<option value="" '.(empty($product[0]['rodzaj_kosci_pamieci']) ? "selected" : "").'></option>';
              echo '<option value="SLC" '.($product[0]['rodzaj_kosci_pamieci'] == 'SLC' ? "selected" : "").'>SLC</option>';
              echo '<option value="MLC" '.($product[0]['rodzaj_kosci_pamieci'] == 'MLC' ? "selected" : "").'>MLC</option>';
              echo '<option value="TLC" '.($product[0]['rodzaj_kosci_pamieci'] == 'TLC' ? "selected" : "").'>TLC</option>';
              echo '<option value="QLC" '.($product[0]['rodzaj_kosci_pamieci'] == 'QLC' ? "selected" : "").'>QLC</option>';
              echo '<option value="PLC" '.($product[0]['rodzaj_kosci_pamieci'] == 'PLC' ? "selected" : "").'>PLC</option>';
              echo '</select><br><br>';
              echo "Prędkość odczytu [MB/s]: <br>";
              echo '<input type="number" name="pr_o" step="1" min="0" value="'.$product[0]['predkosc_odczytu'].'"><br><br>';
              echo "Prędkość zapisu [MB/s]: <br>";
              echo '<input type="number" name="pr_z" step="1" min="0" value="'.$product[0]['predkosc_zapisu'].'">';
            break;
            case 'obudowy':
              echo "Typ: <br>";
              echo '<input type="text" name="typ" value="'.$product[0]['typ'].'"><br><br>';
              echo "Standard płyty: <br>";
              echo '<input type="text" name="stand" value="'.$product[0]['standard_plyty'].'"><br><br>';
              echo "Podświetlenie RGB: <br>";
              echo '<select name="rgb">';
              echo '<option value="1" '.($product[0]['rgb'] == 1 ? "selected" : "").'>Tak</option>';
              echo '<option value="0" '.($product[0]['rgb'] == 0 ? "selected" : "").'>Nie</option>';
              echo '</select><br><br>';
              echo "Wbudowany wentylator: <br>";
              echo '<select name="went">';
              echo '<option value="1" '.($product[0]['wentylator'] == 1 ? "selected" : "").'>Tak</option>';
              echo '<option value="0" '.($product[0]['wentylator'] == 0 ? "selected" : "").'>Nie</option>';
              echo '</select><br><br>';
              echo "Ilość kieszeni na dysk: <br>";
              echo '<input type="number" name="kiesz" step="1" min="0" value="'.$product[0]['ilosc_kieszeni_dysk'].'">';
            break;
          }
        }
        
      ?>
      <br><br>
      <input style="width: 100%; font-size: 130%;" name="save" type="submit" value="Zapisz">
    </form>
		
	</div>
	<div id="footer">
		Sklep <span style="color: #138DA0">Komputerowy</span> &copy; 2022 Wszelkie prawa zastrzeżone
	</div>
</div>
</body>
</html>
