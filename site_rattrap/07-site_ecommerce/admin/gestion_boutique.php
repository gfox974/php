<?php
require_once "../inc/init.php";


// 1- verification que le membre est admin :
    if (!est_admin()) {
        header("location:../connexion.php"); // On redirige les membres classiques vers la page de connexion.
        exit();
    }
    
// 7- suppresion du produit : Quand on clique sur un lien supprmier un produits, vous supprimez un produit en BDD et laisser un message de de reussite ou echec.
if(isset($_GET["id_produit"])) {
    $succes = execute_requete("DELETE FROM produit WHERE id_produit = :id_produit", array(':id_produit'=> $_GET['id_produit']));

    if ($succes->rowCount() ==1 ) { // rowCount() compte le nombre de ligne dans l'objet PDOStatement retourné par la requete DELETE. Dans le cas ou l'identifiant du produit n'existe pas DELETE retourne 0 ligne, donc on va dans le else pour afficher "erreur de suppresion..."
        $contenu .= "<div class='alert alert-success'>Vous avez supprimez le produit</div>";
    }else {
        $contenu .= "<div class='alert alert-danger'>Erreur de suppression du produit</div>";
    }
}


// 6- affichage des articles : 
$resultat = execute_requete ("SELECT * FROM produit"); // On selectionne TOUS les prduits


$contenu.= '<p>Nombre de produits dans la boutique : '.$resultat->rowCount().'</p>';



require_once "../inc/header.php";
?>
<h1 class="mt-4">GESTION BOUTIQUE</h1>
  
<ul class= "nav nav-tabs">
    <li><a href="gestion_boutique.php" class="nav-link active">Affichage des produits</a></li>
    <li><a href="formulaire_produit.php" class="nav-link">Ajout d'un produits</a></li>
</ul>

<?php


$resultat = execute_requete("SELECT * FROM produit");

$contenu .=  '<div class="table-responsive">
              <table class="table">';
		// Affichage des entêtes :
            $contenu .= '<tr>';
            
			$contenu .= '<th> id_produit </th>';
			$contenu .= '<th> reference </th>';
			$contenu .= '<th> categorie </th>';
			$contenu .= '<th> titre </th>';
			$contenu .= '<th> description </th>';
			$contenu .= '<th> couleur </th>';
			$contenu .= '<th> taille </th>';
			$contenu .= '<th> public </th>';
			$contenu .= '<th> photo </th>';
			$contenu .= '<th> prix </th>';
			$contenu .= '<th> stock </th>';
			$contenu .= '<th> action </th>';
		$contenu .=  '</tr>';

        while ($produit = $resultat->fetch(PDO::FETCH_ASSOC))
		{
			$contenu .=  '<tr>';
				foreach ($produit as $indice => $valeur) {
                    if ($indice == "photo") {
                        $contenu .= '<td><img src="../'.$valeur.'"style="width:90px"></td>';
                    } elseif ($indice == 'description') {
                        $contenu .= '<td>' .substr($valeur, 0, 15) . '...</td>';
                    }else {
                        $contenu .='<td>'.$valeur.'</td>';
                    }
                } 

                //  Ajout des liens modifier et supprimer :
                    $contenu .= '<td>

                    <a href="formulaire_produit.php?id_produit='.$produit['id_produit'].'">modifier</a> |
                    <a href="?id_produit='.$produit['id_produit'].'">supprimer</a> 

                    </td>';
            $contenu .='</tr>';
            
        }
         

$contenu .=  '</table>
              </div>';
              
echo ($contenu);
require_once "../inc/footer.php";

