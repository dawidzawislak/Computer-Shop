<?php
session_start();
if(!isset($_SESSION['log']))
{
  header('location:login.php');
  exit();
}
require 'dbfunc.php';
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="shortcut icon" href="res/img/logo.ico">
	<title>Sklep komputerowy - Historia zamówień</title>

  <meta name="description" content="Sklep internetowy z podzespołami komputerowymi pozwalający skonfigurować twojego własnego PC. Posiadamy wysokiej jakości komputery i podzespoły komputerowe, bez względu na to, czy jest to urządzenie do pracy, czy też do codziennego użytku.">
	<meta name="keywords" content="sklep, komputer, zbuduj, pc, konfiguracja, ram, procesor, płyta, główna, mobo, cpu, gpu, karta, graficzna, zasilacz, psu, obudowa, dysk, hdd, ssd, psu">

	<link href="https://fonts.googleapis.com/css?family=Lato:400,700&display=swap&subset=latin-ext" rel="stylesheet">
	<link rel="stylesheet" href="res/fontello/css/fontello.css" type="text/css">

	<link rel="stylesheet" href="css/core.css" type="text/css">
	<link rel="stylesheet" href="css/nav.css" type="text/css">

  <style>
    table {
      border: 2px solid black;
      width: 100%;
    }
    table, td, th {
      border-collapse: collapse;
      border: 1px solid black;
    }
    td {
      font-size: 14px;
      padding: 3px;
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
			<div id="side">
				<?php ProfileInfo(); ?>
			</div>
	</div>
	<div id="nav">
		<ul>
			<li>	<a href="index.php">Kategorie          			</a></li>
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

  <div style="padding: 15px; width: 970px;" id="content">
  <?php echo "<h1>".$_SESSION['name']." ".$_SESSION['lname']."</h1>" ?>
  <h3>Historia zamówień:</h3><br>
    <table>
      <thead>
        <tr>
          <th>Zamówiono</th>
          <th>Cena [zł]</th>
          <th>Realizacja</th>
          <th>MOBO</th>
          <th>CPU</th>
          <th>GPU</th>
          <th>Zasilacz</th>
          <th>RAM</th>
          <th>Dysk1</th>
          <th>Dysk2</th>
          <th>Obudowa</th>
        </tr>
      </thead>
      <tbody>
      <?php
        $conn = new mysqli($host, $dbuser, $dbpass, $dbname);
          if($conn->connect_error)
            die("Connection to \"sklep\" failed: ".$conn->connect_error);

          $query = "SELECT zamowienia.data_zamowienia, zamowienia.cena_zamowienia, zamowienia.data_realizacji, produkty.id_MOBO, produkty.id_CPU, produkty.id_GPU, produkty.id_PSU, produkty.id_RAM, produkty.id_dysk1, produkty.id_dysk2, produkty.id_obudowa FROM produkty NATURAL JOIN zamowienia NATURAL JOIN klienci WHERE login LIKE \"".$_SESSION['log']."\" ORDER BY zamowienia.data_zamowienia DESC;";

          $result = mysqli_query($conn, $query);

          $empty = true;
          $t_name = array("plyty_glowne", "procesory", "karty_graficzne", "zasilacze", "ram", "dyski", "dyski", "obudowy");
          $index = array("id_MOBO", "id_CPU", "id_GPU", "id_PSU", "id_RAM", "id_dysk", "id_dysk", "id_obudowa");

          while($row = $result->fetch_row())
          {
            $p = 0;
            $col = 1;
            echo "<tr>";
            foreach($row as $val)
            {
              $empty = false;
              if($col == 3 && !$val)
              {
                echo "<td>W trakcie</td>";
              }
              else if($col >= 4)
              {
                if (empty($val)) { echo "<td></td>"; continue; }
                $query = "SELECT firma, model FROM ".$t_name[$p]." WHERE ".$index[$p]." = ".$val.";";
                $result2 = $conn->query($query);
                if($result2) {
                  $row2 = $result2->fetch_row();
                  echo "<td>".$row2[0]." ".$row2[1]."</td>";
                }
                else
                  echo "<td></td>";

                $p += 1;
              }
              else
                echo "<td>".$val."</td>";

              $col += 1;
            }

            echo "</tr>";
          }
          if($empty)
          echo "<tr><td style=\"text-align:center;\" colspan=\"11\">Brak zamówień powiązanych z kontem</td></tr>";
          $conn->close();
      ?>
      </tbody>
    </table>
	</div>
	<div id="footer">
		Sklep <span style="color: #138DA0">Komputerowy</span> &copy; 2022 Wszelkie prawa zastrzeżone
	</div>
</body>
</html>
