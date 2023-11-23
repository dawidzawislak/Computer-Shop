<?php
session_start();
if(!isset($_SESSION['log_adm']))
{
  header('location:login.php');
  exit();
}
require 'dbfunc.php';

if(isset($_POST['del']))
{
  $conn = new mysqli($host, $dbuser, $dbpass, $dbname);
  if($conn->connect_error)
    die("Connection to \"sklep\" failed: ".$conn->connect_error);
  
  $query = "DELETE FROM ".$_POST['cat']." WHERE ".$_POST['id_name']." = ".$_POST['id'].";";
  echo $query;
  if ($conn->query($query) !== TRUE) 
    echo "Error while deleting ".$_POST['name'];

  header("location:products.php");
  exit();
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="shortcut icon" href="img/logo.ico">
	<title>Logowanie - Usuwanie</title>

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
        <h3>Czy napewno chcesz usunąć: <?php echo $_POST['name'] ?></h3>
        <form action="" method="POST">
          <input type="hidden" name="name" value="<?php echo $_POST['name']; ?>">
					<input type="hidden" name="id" value="<?php echo $_POST['id']; ?>">
					<input type="hidden" name="cat" value="<?php echo $_POST['cat']; ?>">
					<input type="hidden" name="id_name" value="<?php echo $_POST['id_name']; ?>">
          <input type="submit" name="del" value="Tak">
        </form>
        <form action="products.php" method="POST">
          <input type="submit" value="Nie">
        </form>
    </div>
</body>
</html>
