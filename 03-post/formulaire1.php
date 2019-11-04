<?php
//-----------------------------------
// La superglobale $_POST 
//-----------------------------------
/*
$_POST est une superglobale au meme titre que $_GET, il s'agit aussi d'un array disponible dans tous les contextes d'un script sans avoir besoin de déclarer "global $_POST", y compris au sein des fonctions.
Elle permet de récuperer des données ( par exemple des saisies dans un formulaire ),

 - Remplissage de l'array $_POST: 
    les "name" des input du formulaire constituent les indices du tableau et les valeurs saisies dans le formulaire constituent les valeurs de ce dernier. ( meme schema fonctionnel que le get)

 - Contexte:
    nous pourrons plus tard envoyer ces données dans une base de données

    */

var_dump($_POST);
if (!empty($_POST)){ # Ce bloc ne s'executera que si le post est rempli et envoyé ( ! : F5 repete la derniere action du navigateur, donc renverra les dernieres données du formulaire. Cliquer sollicite le script comme pour la premiere fois, donc le reinitialise )
    echo '<br> Prénom :'.$_POST['prenom'];
    echo '<br> Description :'.$_POST['description'];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Formulaire 1</title>
</head>
<body>
    <h1>Formulaire</h1>
    <!-- Un formulaire DOIT TOUJOURS etre dans une balise form pour pouvoir envoyer des données. l'attribut method spécifie comment les données vont circuler entre client et serveur --> 
    <form method ="post" action="#"> <!-- method : post, attribut action = precise l'url de destination du formulaire, dans notre cas la meme -->
        <label for="prenom">Prénom</label>
        <input type="text" name="prenom" id="prenom"> <!-- L'attribut name corresponds à l'indice de la valeur de destination dans $_POST -->

        <br>
        <label for="description">Description</label> <!-- Les attributs for et id sont liés ! ils permettent de positionner le curseur dans l'input quand on clique sur le label -->
        <textarea name="description" id="description" cols="20" rows="5"></textarea>

        <br>
        <input type="submit" name="validation" value="Envoyer">
    </form>
</body>
</html>