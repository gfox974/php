<?php
require_once "inc/init.php";
// 1- Affichage des categories :
$resultat = execute_requete("SELECT DISTINCT categorie FROM produit");

$contenu_gauche .="<div class= 'list-group mb-4'>";
// La categorie" Tous les produit" :
    $contenu_gauche .= "<a href='?categorie=all' class='list-group-item'>Tous les produit</a>";


    while ($cat = $resultat->fetch(PDO::FETCH_ASSOC) ) {
        $contenu_gauche .= "<a href='?categorie=".$cat["categorie"]."' class='list-group-item'>".ucfirst($cat['categorie'])."</a>"; // On met la premiere lettre en majuscule avec la fonction predefinie ucfirst().
    }

    

$contenu_gauche .="</div>";

// 2- Affichage des article selon la categorie choisie :


if(isset($_GET["categorie"]) && $_GET["categorie"] != "all") {// si on a choisie une categorie qui n'est pas "Tous les produits".
    $resultat =execute_requete("SELECT * FROM  produit WHERE categorie = :categorie", array(":categorie" => $_GET["categorie"]));

} else { // Sinon dans les autres cas on selectionne tous les produits.
    $resultat =execute_requete("SELECT * FROM produit");  
}
while ($produit = $resultat->fetch(PDO::FETCH_ASSOC)) {
    $contenu_droite .= '<div class="col-sm-4 mb-4">';
        $contenu_droite .= '<div class= "card">';
            // image cliquable :
            $contenu_droite .= '<a href="fiche_produit.php?id_produit='.$produit['id_produit'].'">
                                    <img src ="'.$produit["photo"].'" alt="'.$produit["titre"].'" title="'.$produit["titre"].'" class="card-img-top">
                                </a>';
        // Info produit
        $contenu_droite .= '<div class="card-body">';
        $contenu_droite .= '<h2>'. $produit['titre'].' </h2>';
        $contenu_droite .= '<h2>'. number_format($produit['prix'],2, ',', ' ' ).' €</h3>'; // fonction qui formate le prix : nombre de decimale, separateur des decimales, seperateur des milier
        $contenu_droite .= '<p>'. $produit['description'].' </p>';

        $contenu_droite .= '</div>';

        
        $contenu_droite .= '</div>';
    $contenu_droite .= '</div>';
}

// Affichage
require_once "inc/header.php";
?>
<h1 class="mt-4">vêtement</h1>

<div class="row">

    <div class="col-md-3">
        <?php echo $contenu_gauche; // Pour afficher les categorie de vetements ?>
        </div>

    <div class="col-md-9">
        <div class="row">
        <?php echo $contenu_droite; // Pour afficher les articles ?>
        </div>
    </div>


</div> <!-- .row -->



<?php
require_once "inc/footer.php";

