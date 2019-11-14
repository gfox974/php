<?php
// Ce fichier sera inclus dans tous les scripts (hors les inclusions) pour initialiser les elements suivants :
//    - la connection à la base de données:
$pdo = new PDO("mysql:host=localhost;dbname=repertoire","root","", array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
   ));

//  - une constante contenant le chemin du site:
define('RACINE_SITE','/php/09-projet/'); # Va etre utilisé car on va faire une integration header <- index -> footer de façon séparée, il faut utiliser des paths en absolus via la constante, la structure de l'arbo n'ayant pas a changer

// Definition des variables d'affichage :
$contenu = "";
$contenu_gauche = "";
$contenu_droite = "";

// Inclusion de la lib de fonctions:
require_once 'functions.php'; # le fichier functions est dans le meme dossier que l'init
?>