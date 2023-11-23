<?php
$host = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'sklep';

function ReleaseSessionVar($name) {
    if(isset($_SESSION["$name"]))
        unset($_SESSION["$name"]);
}

function BoolToStr($v)
{
    return ($v ? "Tak" : "Nie");
}

?>