<?php
session_start();
$_SESSION['config'] = TRUE;

header("location:mobo.php");
exit();
?>