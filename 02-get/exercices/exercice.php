
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">    
    <title>Exercices PHP</title>
</head>
<body>
    <h1>Mon compte</h1>
    <h2>Nosmas Julien</h2>
    <a href="./exercice.php?action=modifier">Modifier mon compte</a>
    <a href="./exercice.php?action=supprimer">Supprimer mon compte</a>
</body>
</html>

<?php
// Exercice :
# 1) Afficher dans cette page : un titre "mon compte", un nom et un prenom (simuler une page de profil)
# 2) Y ajouter un lien en get "modifier mon profil" et un second "supprimer mon profil", ces liens passent dans l'url à cette meme page que l'action demandée soit modification ou suppression
# 3) Quand on clique sur modifier, on affiche : Vous avez demandé la modification de votre compte
# 3) Quand on clique sur supprimer, on affiche : Vous avez demandé la suppression de votre compte

if (isset($_GET['action']) ){
    switch($_GET['action']){
        case 'modifier':
            echo '<p> Vous avez demandé la modification de votre compte. </p>';
        break;
        case 'supprimer':
            echo '<p> Vous avez demandé la suppression de votre compte. </p>';
        break;
        default:
            echo 'Action inconnue';
        break;
    }
} else {
    echo "<p> No action, ou URL malformée :'( </p>";
}

?>