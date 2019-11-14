<?php
// Exercise :
// Vous creez la page de gestion des membres.
// 1- Seul un admin a accés a cette page. Les autres sont redirigés vers connexion.php.
// 2- Afficher sous forme de <table> tous les membres inscrits, avec toutes les infos SAUF le mot de passe.
// 3- Afficher le nombre de membres.
// 4- Pour chaque membre, vous ajoutez un lien "supprimer" qui permet de supprimer le nombre en BDD SAUF vous-meme.

require_once("../inc/init.php");

// 1- Vérification si Admin :
if(!Est_admin())
{
	header("location:../connexion.php");
	exit();
}

// 3- Suppression d'un membre :
if(isset($_GET['supprimer_membre']))
{	// on ne peut pas supprimer son propre profil :
	if ($_GET['supprimer_membre'] != $_SESSION['membre']['id_membre']) {
		execute_requete("DELETE FROM membre WHERE id_membre=:id_membre", array(':id_membre' => $_GET['supprimer_membre']));
	} else {
		$contenu .= '<div class="alert alert-danger mt-4">Vous ne pouvez pas supprimer votre propre profil ! </div>';
	}
	
}

// 4- Modification du statut :
    if(isset($_GET['modifier_statut'])){
        execute_requete("UPDATE membre SET statut  WHERE id_membre=:id_membre", array(':id_membre' =>$_GET['modifier_statut']));
    }

// 2- Préparation de l'affichage :

$resultat = execute_requete("SELECT id_membre,pseudo, nom, prenom, email, civilite, ville, code_postal, adresse, statut FROM membre"); // tous les champs SAUF le mdp que l'on ne veut pas afficher

$contenu .= '<h1 class="mt-4"> Membres </h1>';
$contenu .=  "Nombre de membre(s) : " . $resultat->rowCount();

$contenu .=  '<div class="table-responsive">
              <table class="table">';
		// Affichage des entêtes :
		$contenu .=  '<tr>';
			$contenu .=  '<th> id_membre </th>';
			$contenu .=  '<th> pseudo </th>';
			$contenu .=  '<th> nom </th>';
			$contenu .=  '<th> prénom </th>';
			$contenu .=  '<th> email </th>';
			$contenu .=  '<th> civilité </th>';
			$contenu .=  '<th> ville </th>';
			$contenu .=  '<th> code postal </th>';
			$contenu .=  '<th> adresse </th>';
			$contenu .=  '<th> statut </th>';
			$contenu .=  '<th> Supprimer </th>';
		$contenu .=  '</tr>';

		// Affichage des lignes :
		while ($membre = $resultat->fetch(PDO::FETCH_ASSOC))
		{
			$contenu .=  '<tr>';
				foreach ($membre as $information)
				{
					$contenu .=  '<td>' . $information . '</td>';
				}
				
				$contenu .=  '<td><a href="?supprimer_membre=' . $membre['id_membre'] . '" onclick="return(confirm(\'Etes-vous sûr de vouloir supprimer ce membre?\'));"> X </a></td>';
				$contenu .=  '<td><a href="?modifier_statut=' . $membre['id_membre'] . '" onclick="return(confirm(\'Etes-vous sûr de vouloir modifier le statut de ce membre?\'));"> X </a></td>';
		
			$contenu .=  '</tr>';
		}
$contenu .=  '</table>
              </div>';


//---------------- Affichage -------------------
require_once("../inc/header.php");
echo $contenu;
require_once("../inc/footer.php");