<?php
require_once '../inc/init.php';
# 1) Vérification que le membre est admin
if (!estAdmin()){
    header('location:../connection.php'); // on redirige les non-admin vers la page de connection
    exit();
}

// affichage
require_once '../inc/header.php';
?>

<h1 class="mt-4">Gestion boutique</h1>

<ul class="nav nav-tabs">
    <li><a class="nav-link active" href="gestion_boutique.php"> Affichage des produits </a></li>
    <li><a class="nav-link" href="formulaire_produit.php"> Ajout d'un produit </a></li>
</ul>

<?php
// contenu main
echo $contenu;
?>

<?php
require_once '../inc/footer.php';
?>