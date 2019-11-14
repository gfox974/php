<?php
// Exercise : creer la page profil.
// 1- Si le visiteur n'est pas connecté on le redirige vers la page de connexion (il ne doit pas accecder au profil).
// 2- Vous affichez son profil selon le shema du tableau.
/*
$contenu = "";
require_once "inc/init.php";

if (!est_connecte()) {
    header("location:connexion.php");
    exit();
}



 


require_once "inc/header.php";

?>




<h1 class="mt-4">PROFIL</h1>
<h2 class="mt-4">Bonjour</h2>
<p class="mt-4"><?php echo $contenu ?></p>
<h3 class="mt-4">Vos coordonnées :</h3>
<p class="mt-4">email :<?php echo $_SESSION["membre"]["pseudo"]?></p>
<?php









require_once "inc/footer.php";
*/
require_once "inc/init.php";

if (!est_connecte()) {
    header("location:connexion.php");
    exit();
}
// on affiche son profil
extract($_SESSION["membre"]); // Extraint tous les indices de l'array sous forme de variable auxquelle on affecte la valeur. Exemple $_SESSION ["membre"]["pseudo"] devient $pseudo

require_once "inc/header.php";
if (est_connecte() && $_SESSION["membre"]["statut"] == 1) {
    $contenu .= "<p>Vous etes administateur</p>";
}
?>

<h1 class="mt-4">PROFIL</h1><br>

<h2>Bonjour <?php echo $prenom . " " .$nom; ?>!!!</h2>
<p><?php echo $contenu?></p>

<h2 class="mt-4">Vos coordonnées</h2><br>
<div>Email :<?php echo $email; ?></div><br>
<div>Adress :<?php echo $adresse; ?></div><br>
<div>Code postal :<?php echo $code_postal; ?></div><br>
<div>Ville :<?php echo $ville; ?></div><br>


<?php
require_once "inc/footer.php";

