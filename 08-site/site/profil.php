<?php
/* Exercice : créer la page profil
    1) si le visiteur n'est pas connecté, vous le redirigerez vers la page de connection ( il ne doit pas acceder au profil )
    2) Vous affichez son profil selon le schema au tableau
*/
// traitements
require_once 'inc/init.php';
$contenu="";
# 1) 
if (!estConnecte()){
    header('location:connection.php');
    exit();
} 
# 2) Mais si l'user est co no exit, on genere l'out selon le statut :
// Affichage
require_once 'inc/header.php';
$contenu .= '<h2> Bonjour '.$_SESSION['membre']['prenom'].' '.$_SESSION['membre']['nom'].'</h2>';
#if ($statut['statut'] == 1){
if (estAdmin()){
    $contenu .= '<p> Vous etes un admin </p>';
}
$contenu .= '<h3> Vos coordonnées: </h3>';
$contenu .= '<p> Votre e-mail: '.$_SESSION['membre']['email'].'</p>';
$contenu .= '<p> Votre adresse: '.$_SESSION['membre']['adresse'].'</p>';
$contenu .= '<p> Votre code postal: '.$_SESSION['membre']['code_postal'].'</p>';
$contenu .= '<p> Votre ville: '.$_SESSION['membre']['ville'].'</p>';
?>

<h1 class="mt-4">Profil</h1>

<?php
echo $contenu;
?>

<?php
require_once 'inc/footer.php';
?>