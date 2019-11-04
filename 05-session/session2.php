<?php 
// Ouverture de la sesion existante :
session_start(); # demarrage de session : elle n'est pas recrée car grace à la page1 on a un cookie de sessionid correspondant au domaine
echo 'La session est accesible partout sur le site comme ici : <br>';
print_r($_SESSION);
// ce fichier n'a rien à voir avec l'autre : il n'y a pas d'inclusion, il pourrait etre dans un autre dossier, porter n'importe quel nom, les informations contenues dans la session lui restent accessibles


?>