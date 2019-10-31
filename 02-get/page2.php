<?php
//------------------------------
// La superglobale $_GET
//------------------------------
/*
$_GET represente l'url,
Il s'agit d'une superglobale, et comme toutes les superglobales, c'est un array.
Superglobale signifie que cette variable est disponible dans tous les contextes d'execution du script, y compris au sein des espaces locaux de fonctions (pas besoin de déclarer global $_GET)
Les informations transitent dans l'url selon la syntaxe suivante :
    page.php?indice1=valeur1&indiceN=valeurN

$_GET receptionne les données de la maniere suivante:
$_GET= array('indice1' => 'valeur1','indiceN' => 'valeurN');
( ca ressemble donc au modele d'un tableau associatif, sauf que c'est la methode qui build l'array)


*/

print_r($_GET); # là en terminal c'est a vide, mais on peut verifier ce qu'on receptionne par ce biais en cliquant sur le lien en page1 via le navigateur.


# echo '<h1>'.$_GET['article'].'</h1>';
# echo '<p>Couleur: '.$_GET['couleur'].'</p>';
# echo '<p>Prix: '.$_GET['prix'].'€ </p>';

// Pouur eviter de flinguer la page2 qui ne s'affiche qu'en resultat de requetes via url, on va les gerer en implicite à coup de conditions pour l'affichage.
if (isset($_GET['article']) && isset($_GET['couleur']) && isset($_GET['prix']) ){  # Là, on verifie l'existence des indices dans la requete
    echo '<h1>'.$_GET['article'].'</h1>';
    echo '<p>Couleur: '.$_GET['couleur'].'</p>';
    echo '<p>Prix: '.$_GET['prix'].'€ </p>';
} else {
    echo "<p> Produit indisponible :'( </p>";
}


?>