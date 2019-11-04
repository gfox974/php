<?php
if (!empty($_POST)){
    echo '<br> ville :'.$_POST['ville'];
    echo '<br> cp :'.$_POST['code_postal'];
    echo '<br> adress :'.$_POST['adresse'];
/* Ecrire les données dans un fichier txt déposé sur le serveur :
Contexte : Si l'on souhaite enregistrer les abonnées d'une newsletter et qu'on ne possede pas de base de données, on pourrait generer un fichier txt avec ces informations crée dynamiquement
*/
$file= fopen('adresses.txt','a'); # meme fonction qu'en ruby ? permet d'ouvrir' le fichier 'adresses.txt', mode : a signifie que si le fichier n'existe pas il est crée
$adresse = $_POST['ville'].' - '.$_POST['code_postal'].' - '.$_POST['adresse']."\n"; # Ici on formate donc pour qu'une ligne = une adresse
fwrite($file, $adresse); # Ici, on donne les instructions de la creation du fichier / remplissage
fclose($file); # ferme le fichier pour liberer les ressources


 } # fin if not empty

?>