<?php
	require_once 'inc/init.php';
	
	$photo_bdd = '';

	$format = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "png" => "image/png",);
	
	if ($_POST) {
		// Ici il faudrait mettre tous les contrôles sur le formulaire...

		// Validation du formulaire :
		if ( !isset($_POST['titre']) || strlen($_POST['titre']) < 2 || strlen($_POST['titre']) > 20 ) {
			$message .= '<div class="alert alert-danger">Le titre doit contenir entre 4 et 20 caractères.</div>';
		}
		if ( !isset($_POST['adresse']) || strlen($_POST['adresse']) < 10 || strlen($_POST['adresse']) > 255 ) {
			$message .= '<div class="alert alert-danger">L\'adresse invalide</div>';
		}
		if ( !isset($_POST['ville']) || strlen($_POST['ville']) < 2 || strlen($_POST['ville']) > 20 ) {
			$message .= '<div class="alert alert-danger">Le titre doit contenir entre 4 et 20 caractères.</div>';
		}
		if ( !isset($_POST['cp']) || !preg_match('#^[0-9]{5}$#', $_POST['cp']) ) {
            $message .= '<div class="alert alert-danger">Le code postale est invalide.</div>';
		}
		if ( !isset($_POST['surface']) || !preg_match('#^[0-9]{3}$#', $_POST['surface']) ) {
			$message .= '<div class="alert alert-danger">Erreur surface invalide !</div>';
		}
		if ( !isset($_POST['prix']) || strlen($_POST['prix']) < 2 || strlen($_POST['prix']) > 10 ) {
			$message .= '<div class="alert alert-danger">Le prix  est invalide !</div>';
		}
		$filetype = $_FILES["photo"]["type"];
		if (!isset($_POST['type']) || !in_array($filetype, $format)) {
			$message .= '<div class="alert alert-danger">Erreur ! Mauvais choix du format ou poids de l\'image.</div>';
		}
		$type = array('location','vente');
		if (!isset($_POST['type']) || !in_array($_POST['type'], $type)) {
			$contenu .= '<div class="alert alert-danger">Le type d\'immobiler est incorrect.</div>';
		}
		if ( !isset($_POST['description']) || strlen($_POST['description']) < 10 || strlen($_POST['description']) > 255 ) {
			$message .= '<div class="alert alert-danger">Description invalide !</div>';
		}

		if (empty($message)) {
			// Insertion du produit en BDD :
			$requete = executeRequete("INSERT INTO logement (titre, adresse, ville, cp, surface, prix, type, description) 
			VALUES (:titre, :adresse, :ville, :cp, :surface, :prix, :type, :description)",array(
				':titre' => $_POST['titre'],
				':adresse' => $_POST['adresse'],
				':ville' => $_POST['ville'],
				':cp' => $_POST['cp'],
				':surface' => $_POST['surface'],
				':prix' => $_POST['prix'],
				':type' => $_POST['type'],
				':description' => $_POST['description'],
			));

			// traitement de la photo :
			debug($_FILES);  
			$id_logement = $pdo -> lastInsertId();
			if ($_FILES['photo']['type'] == 'image/png'){
				$photo = 'logement_'. $id_logement .'.png';
			} else {
				$photo = 'logement_'. $id_logement .'.jpg';
			}
			$photo_bdd = 'img/'. $photo; // on définit le chemein relatif de la photo enregistrer en BDD et utiliser pour les attributs scr des images.
			copy($_FILES['photo']['tmp_name'], $photo_bdd); // on copie le fichier temporaire qui se trouve à l'adresse $_FILES['photo']['tmp_name'] vers notre chemin qui est dans $photo_bdd (note : on remonte vers le dossier parent pour aller ver le dossier "images" car nous sommes dans "admin") 
			// fin traitement Image.

			list($width, $height) = getimagesize($photo_bdd);
			$newwidth = 300;
			$newheight = 300;
			$thumb = imagecreatetruecolor($newwidth, $newheight);

			if ($_FILES['photo']['type'] == 'image/png'){
				$source = imagecreatefrompng($photo_bdd);
				imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
				imagepng($thumb,'img/logement_'. $id_logement .'_300x300.png');
			} else {
				$source = imagecreatefromjpeg($photo_bdd);
				imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
				imagejpeg($thumb,'img/logement_'. $id_logement .'_300x300.jpeg');
			}

			// insertion du cheim de la photo en BDD.
			$resultat = $pdo -> exec("UPDATE logement SET photo = '$photo' WHERE id_logement = '$id_logement' ");

			if ($resultat) {
				$message .= '<div class="alert alert-success">Le logement à bien été enregistré. <a href="affichage.php">Voir affichage logement</a></div>';
			} else {
				$message .= '<div class="alert alert-danger">Le logement n\'a pas été enregistré.</div>';
			}
		}
	}

    // Afficher
    require_once 'inc/header.php';
?>

<main class="container d-flex flex-column justify-content-center align-items-center p-4" style="min-height:80vh;">

	<form method="post" action="" class="" enctype="multipart/form-data">

        <label for="titre">Titre</label><br>
        <input type="text" name="titre" id="titre" value="" require><br>

        <label for="adresse">Adresse</label><br>
		<input type="text" name="adresse" id="adresse" value="" require><br><br>
		
        <label for="ville">Ville</label><br>
        <input type="text" name="ville" id="ville" value="" require><br>

        <label for="cp">Code Postal</label><br>
		<input type="number" name="cp" id="cp" value="" require><br>

        <label for="surface">Surface</label><br>
		<input type="number" name="surface" id="surface" value="" require><br>

        <label for="prix">Prix</label><br>
		<input type="number" name="prix" id="prix" value="" require><br><br>

        <label for="photo">Upload File</label><br>
		<input id="photo" type="file" name="photo"><br><br>

		<select name="type" id="type"> 
			<option value="vente" selected>vente</option>
			<option value="location">location</option>
		</select><br><br>

		<label for="description">Description</label><br>
		<textarea name="description" id="description" cols="60" rows="10"></textarea><br>

        <input type="submit" value="Enregistrer" class="btn btn-dark">

	</form>
	
	<?php echo $message; ?>

</main>

<?php
    require_once 'inc/footer.php';
?>