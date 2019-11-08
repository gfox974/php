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
    <li><a class="nav-link" href="gestion_boutique.php"> Affichage des produits </a></li>
    <li><a class="nav-link active" href="formulaire_produit.php"> Ajout d'un produit </a></li>
</ul>

<?php
// contenu main
echo $contenu;
?>

<form method="post" action="" enctype="multipart/form-data"> <!-- enctype multipart/form-data specifie que ce formulaire peut etre amené a traiter different types de donnees, dont du binaire (comme de l'import de files) -->
    
    <input type="hidden" name="id_produit" id="id_produit" value=""> <!-- on va recuperer l'id du produit dans le post pour ses modifs, mais par securité le champ sera caché pour ne pas etre modifié par erreur -->
    
    <label for="reference">Référence</label><br>
    <input type="text" name="reference" id="reference"><br>

    <label for="categorie">Catégorie</label><br>
    <input type="text" name="categorie" id="categorie"><br>

    <label for="titre">Titre</label><br>
    <input type="text" name="titre" id="titre"><br>

    <label for="description">Description</label><br>
    <textarea name="description" id="description"></textarea><br>

    <label for="couleur">Couleur</label><br>
    <input type="text" name="couleur" id="couleur"><br>

    <label for="taille">Taille</label><br>
    <select name="taille" id="taille">
        <option value="s">S</option>
        <option value="m">M</option>
        <option value="l">L</option>
        <option value="xl">XL</option>
    </select><br>

    <label for="public">Public</label><br>
    <input type="radio" name="public" id="m" value=""><label for="m">Masculin</label>
    <input type="radio" name="public" id="f" value=""><label for="f">Féminin</label>
    <input type="radio" name="public" id="mixte" value="" checked><label for="mixte">Mixte</label><br>

    <label for="photo">Photo</label><br>
    <!-- todo -->

    <label for="prix">Prix</label><br>
    <input type="text" name="prix" id="prix" value=""><br>

    <label for="stock">Stock</label><br>
    <input type="text" name="stock" id="stock" value=""><br>

    <input type="submit" value="enregistrer" class="btn">

</form>


<?php
require_once '../inc/footer.php';
?>