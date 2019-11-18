<?php
/*
// local
$pdo = new PDO("mysql:host=localhost;dbname=immobilier","root","", array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
   )
);
*/

// remote ( test maquette : http://testmaquette.epizy.com/ )
$pdo = new PDO("mysql:host=sql311.epizy.com;dbname=epiz_24799830_repertoire","epiz_24799830","QuVt554mGxelU", array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
   )
);


$contenu = "";

require_once 'functions.php';
?>