<?php
require 'dbfunc.php';
session_start();
ReleaseSessionVar("log_adm");
session_destroy();
header('location:login.php');
exit();
?>
