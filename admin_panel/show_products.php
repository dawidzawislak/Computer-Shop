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
	<title>Panel Administracyjny - Produkty zamówienia</title>

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
    <div style="float: left;">
      <form action="client.php" method="POST">
          <input type="hidden" name="id" value="<?php echo $_POST['id_k'] ?>">
          <input type="submit" value="Dane klienta">
      </form>
    </div>
    <div style="float: right;">
      <?php echo "<h2>Zamówienie nr ".$_POST['id_o']." klienta ".$_POST['name']." ".$_POST['lname']."</h2>" ?>
    </div>
    <div class="clear"></div>
    <table>
      <thead>
        <tr>
            <th>Procesor</th>
            <th>Karta Graficzna</th>
            <th>RAM</th>
            <th>Dysk 1</th>
            <th>Dysk 2</th>
            <th>Płyta Główna</th>
            <th>Zasilacz</th>
            <th>Obudowa</th>
        </tr>
      </thead>
      <tbody>
      <tr>
      <?php
        if(isset($_POST['id']))
        {
          $conn = new mysqli($host, $dbuser, $dbpass, $dbname);
            if($conn->connect_error)
              die("Connection to \"sklep\" failed: ".$conn->connect_error);

            $query = "SELECT * FROM produkty WHERE id_produkty=".$_POST['id'].";";
            $result = $conn->query($query);
            $products = $result->fetch_assoc();
            $t_name = array("procesory", "karty_graficzne", "ram", "dyski", "dyski", "plyty_glowne", "zasilacze", "obudowy");
            $index = array("id_CPU", "id_GPU", "id_RAM", "id_dysk", "id_dysk", "id_MOBO", "id_PSU", "id_obudowa");
            $i = -1;
            foreach($products as $product)
            {
              if($i == -1)
              {
                $i += 1;
                continue;
              }
              echo "<td>";
              if(!empty($product))
              {
                $query = "SELECT firma, model FROM ".$t_name[$i]." WHERE ".$index[$i]." = ".$product.";";
                $result = $conn->query($query);
                $row = $result->fetch_row();

                echo $row[0]." ".$row[1];
              }
              echo "</td>";
              $i += 1;
            }

            $conn->close();
          }
        ?>
        </tr>
        </tbody>
      </table>
	  </div>
	<div id="footer">
		Sklep <span style="color: #138DA0">Komputerowy</span> &copy; 2022 Wszelkie prawa zastrzeżone
	</div>
</div>
</body>
</html>
