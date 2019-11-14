<?php
require_once "../inc/init.php";
// 1- verification que le membre est admin :
if (!est_admin()) {
    header("location:../connexion.php"); // On redirige les membres classiques vers la page de connexion.
    exit();
}

    // 4 - enregistrement du produit en BDD :
    //debug ($_POST);

    if ($_POST) { // si le formulaire est envoyé

        // ici il faudrait mettre tous les contrôles sur le formulaire

        $photo_bdd = ''; // par défaut il n'y a pas de photo sur le produit

        // traitement de la photo a venir...
        if (isset($_POST['photo_actuelle'])) {
            $photo_bdd = $_POST['photo_actuelle']; // On prend la photo du formulaire et on la remet en BDD
        }
        // Suite Upload de la photo : 

        //debug($_FILES); //$_FILES est une superglobale, donc un array. Ce tableau possede un indice "photo" qui provient de "name" de l'input type "file" fu formulaire. A l'interieur, il y aun sous array avec des indices predefinis, dont "name" qui contient le nom du fichier en cours d'Upload.

        // Si $_FILES est remplie, on traite la photo :
        if (!empty($_FILES["photo"]["name"])) {
            $fichier_photo = "ref" . $_POST["reference"] . "_" . $_FILES["photo"]["name"]; // On definit le nom du fichier pour pouvoir l'enregistrer sur notre serveur.
            $photo_bdd = "photo/" . $fichier_photo; // on definit le chemin relatif de la photo enregistrée en BDD et utilisé par les attributs src des images.
            copy($_FILES["photo"]["tmp_name"], "../".$photo_bdd); // On compie le fichier temporaire qui se trouve a l'adresse $_FILES["photo"]["ymp_name"] vers notre chemin qui est dans $photo_bdd (note : on remonte vers le dossier parent pour allez vers le dossier "photo" car nous sommes ici dans "admin")
        }

        // insertion du produit en BDD :
        $requete = execute_requete("REPLACE INTO produit VALUES (:id_produit, :reference, :categorie, :titre, :description, :couleur, :taille, :public, :photo, :prix, :stock)", 
        array(
    ':id_produit'=> $_POST['id_produit'],
    ':reference'=> $_POST['reference'],
    ':categorie'=> $_POST['categorie'],
    ':titre'=> $_POST['titre'],
    ':description'=> $_POST['description'],
    ':couleur'=> $_POST['couleur'],
    ':taille'=> $_POST['taille'],
    ':public'=> $_POST['public'],
    ':photo'=> $photo_bdd,
    ':prix'=> $_POST['prix'],
    ':stock'=> $_POST['stock'],
        ));


// replace INTO fait un INSERT INTO quand l'id_produit n'existe pas, et comme un update quand l'id_produit existe en BDD.
if ($requete) { // Si la variable contient un ojet PDOStatement, la condition est evalué a true.
    $contenu .="<div class='alert alert-success'>Le produit a été enregistrer avec succès</div>";
} else { //Sinon la variable contient false, la requete n'a pas marché.
    $contenu .="<div class='alert alert-danger'>Erreur lors de l'enregistrement...</div>";
}

    } // fin du if ($_POST)
// Remplissage du formulaire de modification :
   
    // 8- Remplissage du formulaire de modification :
        if (isset($_GET['id_produit'])) { // si on a reçu "id_produit" dans l'url, c'est qu'on a cliqué sur "modifier". On selectionne en BDD toutes les infos de ce produit pour remplir le formulaire
            $resultat = execute_requete("SELECT * FROM produit WHERE id_produit = :id_produit", array(':id_produit' => $_GET['id_produit']));
            $produit_actuel = $resultat->fetch(PDO::FETCH_ASSOC); // Pas de while car un seul produit par id

    }
  
// affichage :
require_once "../inc/header.php";
?>
<h1 class="mt-4">GESTION BOUTIQUE</h1>

<ul class= "nav nav-tabs">
    <li><a href="gestion_boutique.php" class="nav-link">Affichage des produits</a></li>
    <li><a href="formulaire_produit.php" class="nav-link active">Ajout d'un produits</a></li>
</ul>

<?php

//contenu main


?>

<form method="post" action="" enctype="multipart/form-data"> <!-- multipart/form-data spécifie que ce formulaire envoie des données binaires (fichier) et du texte (champ de formulaire : permet de uploader des fichiers) -->

        <input type="hidden" name="id_produit" id="id_produit" value="<?php echo $produit_actuel["id_produit"] ?? ''; ?>"> <!-- Le type "hidden" permet de cacher le champ mais de l'avoir dans $_POST. Nécaissaire pour la modification d'un produit pas son id. Le ?? signifie on prend la premiere variable qui existe, sachant que le string vide existe par defaut --> 

        <label for="reference">Reference</label><br>
        <input type="text" name="reference" id="reference" value="<?php echo $produit_actuel["reference"] ?? ''; ?>"><br>

        <label for="categorie">categorie</label><br>
        <input type="text" name="categorie" id="categorie" value="<?php echo $produit_actuel["categorie"] ?? ''; ?>"><br>

        <label for="titre">titre</label><br>
        <input type="text" name="titre" id="titre" value="<?php echo $produit_actuel["titre"] ?? ''; ?>"><br>

        <label for="description">description</label><br>
        <textarea id="description" name="description"><?php echo $produit_actuel["description"] ?? ''; ?></textarea><br>

        <label for="couleur">Couleur</label><br>
        <input type="text" name="couleur" id="couleur" value="<?php echo $produit_actuel["couleur"] ?? ''; ?>"><br>

        <label for="taille">taille</label><br>
        <select name="taille">
            <option>S</option>
            <option <?php if (isset($produit_actuel['taille']) && $produit_actuel['taille']=="M")echo'selected';?>>M</option>
            <option <?php if (isset($produit_actuel['taille']) && $produit_actuel['taille']=="L")echo'selected';?>>L</option>
            <option <?php if (isset($produit_actuel['taille']) && $produit_actuel['taille']=="XL")echo'selected';?>>XL</option>
           
            
        </select>

        <label>Public</label><br>
        <input type="radio" name="public" id="m" value="m" checked ><label for="m">masculin</label>
        <input type="radio" name="public" id="m" value="f"<?php if (isset($_produit_actuel['public']) && $produit_actuel['public'] == 'f')echo'checked';?>><label for="f">feminin</label>
        <input type="radio" name="public" id="m" value="mixte"><?php if (isset($_produit_actuel['public']) && $produit_actuel['public'] == 'mixte')echo'checked';?><label for="mixte">mixte</label>
<br>
<br>
        <label for="photo">Photo</label><br>
        <!-- Upload de la photo -->
        <input type="file" name="photo" id="photo"><br>
        <?php 
         if (isset($produit_actuel)) { // si on est en modification, on affiche la photo actuelle :
            echo '<p class="mt-4">Photo actuelle : </p>';
            echo '<img src="../' . $produit_actuel['photo'] . '" style="width:90px;"></img><br>';
            echo '<p class="mt-4"><input type="hidden" name="photo_actuelle" value="' . $produit_actuel['photo'] . '"></p>'; // on renseigne $_POST['photo_actuelle'] avec la valeur de notre photo pour la remettre en BDD
        }
    
        ?>

        <label for="prix">Prix</label><br>
        <input type="text" name="prix" id="prix" value="<?php echo $produit_actuel["prix"] ?? ''; ?>"><br>

        <label for="stock">stock</label><br>
        <input type="number" name="stock" id="stock" value="<?php echo $produit_actuel["stock"] ?? ''; ?>"><br>

        <input type="submit" value="Enregistrer" class="btn">
</form>




<?php
echo $contenu;
require_once "../inc/footer.php";
?>