<?php
    require_once 'inc/init.php';
    
    $resultat = executeRequete("SELECT titre, adresse, ville, cp, surface, prix, photo, type, description FROM logement");
	
    $contenu .=  '<div class="table-responsive"><table class="table">';
		// Affichage des entÃªtes :
		$contenu .=  '<tr>';
			$contenu .=  '<th> Titre </th>';
			$contenu .=  '<th> Adresse </th>';
			$contenu .=  '<th> Ville </th>';
			$contenu .=  '<th> Code postal </th>';
			$contenu .=  '<th> Surface </th>';
			$contenu .=  '<th> Prix </th>';
			$contenu .=  '<th> Photo </th>';
			$contenu .=  '<th> Type </th>';
			$contenu .=  '<th> Description </th>';
		$contenu .=  '</tr>';

		// Affichage des lignes :
		while ($logement = $resultat->fetch(PDO::FETCH_ASSOC))
		{
            $contenu .=  '<tr>';
            
            foreach ($logement as $information => $valeur) {
                if (!empty($information) && $information == 'photo') {
                    $contenu .=  '<td><img style="width:90px;" src="img/'. $valeur .'" alt="'.$logement['titre'].'"></td>';
                } elseif ($information == 'surface') {
                    $contenu .=  '<td>' . $valeur .' m²</td>';
                } elseif ($information == 'prix') {
                    $contenu .=  '<td>' . $valeur .' €</td>';
                } elseif ($information == 'description') {
                    $contenu .=  '<td>' . substr($valeur, 0, 15) . '...</td>';
                } else {
                    $contenu .=  '<td>' . $valeur . '</td>';
                }
            }

			$contenu .=  '</tr>';
        }
        
    $contenu .=  '</table></div>';

    // Afficher
    require_once 'inc/header.php';
?>

<main class="container d-flex justify-content-center align-items-center p-4" style="height:80vh;">

    <?php echo $contenu;?>

</main>

<?php
    require_once 'inc/footer.php';
?>