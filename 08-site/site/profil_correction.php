<?php
/* Correction Exercice : créer la page profil
    1) si le visiteur n'est pas connecté, vous le redirigerez vers la page de connection ( il ne doit pas acceder au profil )
    2) Vous affichez son profil selon le schema au tableau
*/
require_once 'inc/init.php';
# 1)
if (!estConnecte()){
    header('location:connection.php');
    exit();
}

# 2)
debug($_SESSION);
# Fonction sympa:
extract($_SESSION['membre']); // on recupere les index / valeurs des arrays et on genere des variables en suivant leur schem : $_SESSION['membre']['nom'] -> $nom = machin 
echo $nom;


require_once 'inc/header.php';
?>

<h1 class="mt-4">Profil</h1>
<h2>Bonjour <?php echo $prenom.' '.$nom; ?></h2>

<?php
if (estAdmin()){
    echo '<p> Vous etes administrateur </p>';
}
?>

<h3>Vos coordonnées</h3>
<div>Email: <?php echo $email;?></div>
<div>Adresse: <?php echo $adresse;?></div>
<div>Code postal: <?php echo $code_postal;?></div>
<div>Ville: <?php echo $ville;?></div>

<?php
require_once 'inc/footer.php';
?>