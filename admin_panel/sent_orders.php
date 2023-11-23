<?php
session_start();
if(!isset($_SESSION['log_adm']))
{
  header('location:login.php');
  exit();
}
require 'dbfunc.php';
ReleaseSessionVar("cat");
?>

<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="shortcut icon" href="res/img/logo.ico">
	<title>Panel Administracyjny - Zrealizowane zamówienia</title>

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
        <li>	<a href="index.php">Nowe zamówienia         </a></li>
				<li>	<a href="sent_orders.php">Zrealizowane zamówienia	</a></li>
				<li>	<a href="products.php">Produkty    			</a></li>
				<li>	<a href="add_product.php">Dodaj produkt  	</a></li>
			</ul>
		</div>

  <div id="content">
    <h2>Zrealizowane zamówienia</h2>
    <table>
      <thead>
        <tr>
          <th>Id</th>
          <th>Klient</th>
          <th>Data zamówienia</th>
          <th>Cena zamówienia[zł]</th>
          <th>Data realizacji</th>
          <th>Uwagi</th>
          <th>Produkty</th>
        </tr>
      </thead>
      <tbody>
      <?php
        $conn = new mysqli($host, $dbuser, $dbpass, $dbname);
          if($conn->connect_error)
            die("Connection to \"sklep\" failed: ".$conn->connect_error);

          $query = "SELECT klienci.imie, klienci.nazwisko, zamowienia.* FROM klienci NATURAL JOIN zamowienia ORDER BY id_zamowienia DESC";

          $result = mysqli_query($conn, $query);
          while($row = $result->fetch_assoc())
          {
            if($row["wyslano"] == 1)
            {
              echo "<tr>";
                echo "<td>".$row['id_zamowienia']."</td>";
                echo "<td>".$row['imie']." ".$row['nazwisko'];
                echo '<form action="client.php" method="POST">';
                echo '<input type="hidden" name="id" value="'.htmlentities($row['id_klienta']).'">';
                echo '<input type="submit" value="Szczegóły">';
                echo '</form></td>';
                echo "<td>".$row['data_zamowienia']."</td>";
                echo "<td>".$row['cena_zamowienia']."</td>";
                echo "<td>".$row['data_realizacji']."</td>";
                echo '<td>';
                if (empty($row["uwagi"]))
                    echo "Brak";
                else
                    echo ($row['uwagi']); 
                echo '</td>';
                echo '<td><form action="show_products.php" method="POST">';
                echo '<input type="hidden" name="id" value="'.htmlentities($row['id_produkty']).'">';
                echo '<input type="hidden" name="id_k" value="'.htmlentities($row['id_klienta']).'">';
                echo '<input type="hidden" name="name" value="'.htmlentities($row['imie']).'">';
                echo '<input type="hidden" name="lname" value="'.htmlentities($row['nazwisko']).'">';
                echo '<input type="hidden" name="id_o" value="'.htmlentities($row['id_zamowienia']).'">';
                echo '<input type="submit" value="Wyświetl">';
                echo '</form></td>';
              echo "</tr>";
            }
          }

          $conn->close();
      ?>
      </tbody>
    </table>
	</div>
	<div id="footer">
		Sklep <span style="color: #138DA0">Komputerowy</span> &copy; 2022 Wszelkie prawa zastrzeżone
	</div>
</div>
</body>
</html>
