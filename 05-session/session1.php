<?php
//--------------------------
// la superglobale $_SESSION
//--------------------------

/* Principes :
Un fichier temporaire appellé "session" est crée coté serveur avec un identifiant unique,
cette session est liée à un utilisateur, car dans le meme temps un cookie contenant cet identifiant est déposé coté client. (ce cookie est souvent appellé : PHPSESSID)
Ce cookie se détruit lorsqu'on quitte le navigateur, le fichier de session peut contenir toutes sortes d'informations, y compris sensibles - car il n'est pas accessible par l'internaute

Si l'internaute parvient a modifier le cookie relatif a sa session, le lien avec celle-ci est rompu et l'internaute est déconnecté.
Les données du fichier de session sont accessibles et manipulable à partir de la superglobale $_SESSION
*/

// Mise en pratique :
// Creation d'une session ou acces à celle-ci si elle est existe au préalable

session_start(); # begin d'une session, permet de créer le fichier ou y acceder s'il existe deja et qu'on a recu un cookie lui correspondant
// remplir la session :
$_SESSION['pseudo']='tintin'; # fonctionne sur un modele d'array associatif (et peut fonctionner en multidimensionnel), on accede donc a ses valeurs par le biais d'indices
$_SESSION['mdp']='milou';

echo '- 1) la session remplie: ';
print_r($_SESSION); # avec l'inspect du browser on peut voir le session id -> son fichier se trouve dans le tmp du server

// vider une partie de la session :
unset($_SESSION['mdp']); # Ici, unset supprime l'element 'mdp'
echo '<br> echo des elements de session apres la suppression de mdp : '.print_r($_SESSION);

// supprimer entierement une session :
# session_destroy();
# echo '<br> echo des elements de session apres la suppression complete : '.print_r($_SESSION); # on la voit toujours dans le navigateur, mais elle a bien disparu coté serveur
// le destroy se fait en differé quand le script a fini de s'executer !


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Session</title>
</head>
<body>
    
</body>
</html>