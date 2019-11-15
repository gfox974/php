<?php
/*  
********************************************************************************
                  Créer un répertoire de contacts avec photo
********************************************************************************

	1- Créer une base de données "repertoire" avec une table "contact" :
	  id_contact PK AI INT
	  nom VARCHAR(50)
	  prenom VARCHAR(50)
	  telephone VARCHAR(10)
	  email VARCHAR(255)
	  type_contact ENUM('ami', 'famille', 'professionnel', 'autre')
	  photo VARCHAR(255)

	2- Créer un formulaire HTML (avec doctype...) afin d'ajouter un contact dans la bdd. 
	   Le champ type_contact doit être géré via un "select option".
	   On doit pouvoir uploader une photo par le formulaire. 
	
	3- Effectuer les vérifications nécessaires :
	   Les champs nom et prénom contiennent 2 caractères minimum, le téléphone 10 chiffres
	   Le type de contact doit être conforme à la liste des types de contacts
	   L'email doit être valide
	   Si une photo est uploadée, le type du fichier doit être png ou jpg ou jpeg.
	   En cas d'erreur de saisie, afficher des messages d'erreurs au-dessus du formulaire

	4- Ajouter les infos du contact dans la BDD et afficher un message en cas de succès ou en cas d'échec.

	5- Ajouter la photo du contact en BDD et uploader le fichier sur le serveur de votre site. Son nom est contact_12.jpg où 12 correspond à l'identifiant du contact.

	------------------------------------

	6- Une fois la photo d'origine uploadée, créer une vignette 50% plus petite que la taille d'origine que vous uploadez sur votre serveur sous le nom de thumbnail_12.jpg où 12 correspond à l'identifiant du contact.

*/
$contenu = '';

$pdo = new PDO('mysql:host=localhost;dbname=repertoire', 
			   'root', 
			   '',     
			   array(
			       PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, 
			       PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8' 
			   )); 

function debug($param) {
	echo '<pre>';
		var_dump($param);
	echo '</pre>';
}

debug($_POST);

if ($_POST) {

	if (!isset($_POST['nom']) || strlen($_POST['nom']) < 2 || strlen($_POST['nom']) > 50 ) {
		$contenu .= 'Le nom est incorrect.';
	}

	if (!isset($_POST['prenom']) || strlen($_POST['prenom']) < 2 || strlen($_POST['prenom']) > 50 ) {
		$contenu .= 'Le prénom est incorrect.';
	}

	if (!isset($_POST['telephone']) || !preg_match('#^[0-9]{10}$#', $_POST['telephone'])) {
		$contenu .= 'Le téléphone est incorrect.';
	}

	$type_contact = array('ami', 'famille', 'professionnel', 'autre');
	if (!isset($_POST['type_contact']) || !in_array($_POST['type_contact'], $type_contact)) {
		$contenu .= 'Le type de contact est incorrect.';
	}

	if (!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$contenu .= 'Le mail est incorrect.';
	}
	debug($_FILES);

	if ($_FILES['photo']['type'] != 'image/png' && $_FILES['photo']['type'] != 'image/jpg' && $_FILES['photo']['type'] != 'image/jpeg') {
		$contenu .= 'Vous devez télécharger une photo.';
	}


	// 4- Ajouter les infos du contact dans la BDD 
	if (empty($contenu)) { // si pas d'erreur

		foreach ($_POST as $key => $value) {
			$_POST[$key] = htmlspecialchars($value); // contre les injections JS et CSS
		}

		$resultat = $pdo->prepare("INSERT INTO contact (nom, prenom, telephone, email, type_contact) VALUES (:nom, :prenom, :telephone, :email, :type_contact)");
		$resultat->execute(array(
			':nom'         => $_POST['nom'],
			':prenom'      => $_POST['prenom'],
			':telephone'   => $_POST['telephone'],
			':email'       => $_POST['email'],
			':type_contact'=> $_POST['type_contact'],
		)); 


		// 5- Ajouter la photo du contact en BDD et uploader le fichier sur le serveur
		$id_contact = $pdo->lastInsertId();  // on récupère le dernier id inséré

		$photo = 'photo/contact_' . $id_contact . '.jpg'; // toutes les photos s'appellent "contact_" suivi de l'identifiant du contact et d'extension ".jpg"

		copy($_FILES['photo']['tmp_name'], $photo); // on enregistre la photo sur notre serveur



		// insertion du chemin de la photo en BDD :
		$resultat = $pdo->exec("UPDATE contact SET photo = '$photo' WHERE id_contact = '$id_contact'"); // note : les variables sont entre quotes en SQL

		if ($resultat) {
			$contenu .= 'Le contact a été ajouté.';
		} else {
			$contenu .= 'Erreur lors de l\'ajout du contact.';
		}
		// partie thumbnails (creation de la vignette)
		$filename = $photo;
		$percent = 0.5;
		list($width, $height) = getimagesize($filename); // on crée une liste dont on affecte les valeurs a partir des valeurs de l'array retourné par la fonction
		$new_width = $width * $percent;
		$new_height = $height * $percent;
		$image_p = imagecreatetruecolor($new_width,$new_height); // là on crée un fichier image vide (noire) aux bonnes dimensions
		$image = imagecreatefromjpeg($filename); // retourne un identifiant de l'image dont le pointeur est filename, representant l'image d'origine
		imagecopyresampled($image_p,$image,0,0,0,0,$new_width,$new_height,$width,$height); // redimensionne une copie de $image vers une image $image_p, depuis les dimensions width/height vers les new, les quatre 0 representent les points de departs en abcisses / ordonnées des coins à partir desquels ont part 
		imagejpeg($image_p,'photo/thumbnail_'.$id_contact.'.jpg',100); // là on out l'image resizée vers un fichier

	} // fin du if (empty($contenu))


} // fin du if ($_POST)


//2- Créer un formulaire HTML (avec doctype...) afin d'ajouter un contact dans la bdd
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Répertoire</title>
</head>
<body>

	<h1>Ajouter un contact</h1>

	<?php echo $contenu; ?>

	<form method="post" action="" enctype="multipart/form-data">
		
		<div>
			<label for="nom">Nom</label>
			<input type="text" name="nom" id="nom">
		</div>

		<div>
			<label for="prenom">Prénom</label>
			<input type="text" name="prenom" id="prenom">
		</div>

		<div>
			<label for="telephone">Téléphone</label>
			<input type="text" name="telephone" id="telephone">
		</div>

		<div>
			<label for="type_contact">Type de contact</label>
			<select name="type_contact">
				<option>ami</option>
				<option>famille</option>
				<option>professionnel</option>
				<option>autre</option>
			</select>
		</div>

		<div>
			<label for="email">Email</label>
			<input type="text" name="email" id="email">
		</div>

		<div>
			<label for="photo">photo</label>
			<input type="file" name="photo" id="photo">
		</div>

		<input type="submit">
	</form>
</body>
</html>