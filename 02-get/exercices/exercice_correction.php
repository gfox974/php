<?php
// Exercice :
# 1) Afficher dans cette page : un titre "mon compte", un nom et un prenom (simuler une page de profil)
# 2) Y ajouter un lien en get "modifier mon profil" et un second "supprimer mon profil", ces liens passent dans l'url à cette meme page que l'action demandée soit modification ou suppression
# 3) Quand on clique sur modifier, on affiche : Vous avez demandé la modification de votre compte
# 3) Quand on clique sur supprimer, on affiche : Vous avez demandé la suppression de votre compte
print_r($_GET);
if (isset($_GET['action']) && $_GET['action'] == 'modifier'){
    echo 'Vous avez demandé la modification de votre compte';
}
if (isset($_GET['action']) && $_GET['action'] == 'supprimer'){
    echo 'Vous avez demandé la suppression de votre compte';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Correction exercice</title>
</head>
<body>
    <h1>Mon compte</h1>
    <h2>Mon profil</h2>
    <p>John Doe</p>
    <a href="?action=modifier">Modifier mon compte</a>
    <a href="?action=supprimer">Supprimer mon compte</a>    
</body>
</html>