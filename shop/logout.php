<?php
session_start();
if(isset($_SESSION['log']))
{
	unset($_SESSION['log']);
    unset($_SESSION['name']);
    unset($_SESSION['lname']);
}
session_destroy();
header('location:index.php');
exit();
?>
