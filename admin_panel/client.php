<?php
session_start();
if(!isset($_SESSION['log_adm']))
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
	<title>Panel Administracyjny - Dane klienta</title>

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
    <table>
      <thead>
        <tr>
          <th>Imię</th>
          <th>Nazwisko</th>
          <th>Telefon</th>
          <th>E-mail</th>
          <th>Miasto</th>
          <th>Kod pocztowy</th>
          <th>Adres</th>
        </tr>
      </thead>
      <tbody>
      <?php
        $conn = new mysqli($host, $dbuser, $dbpass, $dbname);
          if($conn->connect_error)
            die("Connection to \"sklep\" failed: ".$conn->connect_error);

          $id = isset($_POST['id']) ? $_POST['id'] : -1;
          $query = "SELECT imie, nazwisko, telefon, email, miasto, kod_pocztowy, adres FROM klienci WHERE id_klienta=".$id.";";
          $result = mysqli_query($conn, $query);
          while($row = $result->fetch_assoc())
          {
            echo "<tr>";
              echo "<td>".$row['imie']."</td>";
              echo "<td>".$row['nazwisko']."</td>";
              echo "<td>".$row['telefon']."</td>";
              echo "<td>".$row['email']."</td>";
              echo "<td>".$row['miasto']."</td>";
              echo "<td>".$row['kod_pocztowy']."</td>";
              echo "<td>".$row['adres']."</td>";
            echo "</tr>";
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
