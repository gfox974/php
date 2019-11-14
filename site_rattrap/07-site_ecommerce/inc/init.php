<?php
// ce fichier sera inclus dans tous les scripts(hors les inclusions) pour initialiser les elements suivants :

//La connexion a la BDD

$pdo = new PDO("mysql:host=localhost;dbname=site",
               "root",
               "",
               array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"         
            ));

// La creation ou l'ouverture des sessions : 
session_start();

// Une constante contenant le chemin du site :
define("RACINE_SITE", "/php/site_rattrap/07-site_ecommerce/"); // Indiquer le ou les dossiers dans lesquels se situe le site sans "localhost". Permet de creer des chemins absolus utilisés notamment dans le header.php du site.

// Les variables d'affichages : 
$contenu = "";
$contenu_gauche = "";
$contenu_droite = "";

// Inclusion des fonctions :
require_once "function.php"; // le fichier functions.php est dans le meme dossier que ce fichier init.php 


?> 