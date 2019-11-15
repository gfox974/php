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
1) done
	2- Créer un formulaire HTML (avec doctype...) afin d'ajouter un contact dans la bdd. 
	   Le champ type_contact doit être géré via un "select option".
	   On doit pouvoir uploader une photo par le formulaire. 
2) done
	3- Effectuer les vérifications nécessaires :
	   Les champs nom et prénom contiennent 2 caractères minimum, le téléphone 10 chiffres
	   Le type de contact doit être conforme à la liste des types de contacts
	   L'email doit être valide
	   Si une photo est uploadée, le type du fichier doit être png ou jpg ou jpeg.
	   En cas d'erreur de saisie, afficher des messages d'erreurs au-dessus du formulaire
3) done
	4- Ajouter les infos du contact dans la BDD et afficher un message en cas de succès ou en cas d'échec.
4) done
	5- Ajouter la photo du contact en BDD et uploader le fichier sur le serveur de votre site. Son nom est contact_12.jpg où 12 correspond à l'identifiant du contact.
5) done
--- end 1st day (~5h prevues). Done en ~2h
	6- Une fois la photo d'origine uploadée, créer une vignette 50% plus petite que la taille d'origine que vous uploadez sur votre serveur sous le nom de thumbnail_12.jpg où 12 correspond à l'identifiant du contact.
6) WIP
*/
require_once 'inc/init.php';
debug($_POST);

debug($_FILES);

// verifications
if($_POST) {
	$photo_bdd = '';

    if(!isset($_POST["nom"]) || strlen($_POST["nom"]) < 2) {
        $contenu .= '<div class="alert alert-danger"> Le nom doit comprendre au moins 2 caractères.</div>';
    }

    if(!isset($_POST["prenom"]) || strlen($_POST["prenom"]) < 2) {
        $contenu .= '<div class="alert alert-danger"> Le prenom doit comprendre au moins 2 caractères.</div>';
    }

	if(!isset($_POST["telephone"]) || !preg_match("#^[0-9]{10}$#", $_POST["telephone"])) {
        $contenu .= '<div class="alert alert-danger"> Le numero de telephone doit comprendre 10 chiffres.</div>';
    }

    if(!isset($_POST["email"]) || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $contenu .= '<div class="alert alert-danger"> L\'email est invalide.</div>';
    }

    if(!isset($_POST["type_contact"]) || ($_POST["type_contact"] != "ami" && $_POST["type_contact"] != "famille" && $_POST["type_contact"] != "professionnel" && $_POST["type_contact"] != "autre" )) {
        $contenu .= '<div class="alert alert-danger"> Le type de contact n\'est pas valide.</div>';
	}

	// ou variante not in array:
	/* $type_contact = array('ami', 'famille', 'professionnel', 'autre');
	if(!isset($_POST["type_contact"]) || !in_array($_POST["type_contact"],$type_contact)){

	} */

	if (isset($_POST['photo'])) {
		$photo_bdd = $_POST['photo'];
	}

	if (!empty($_FILES["photo"]["name"])) {
		if(!isset($_FILES["photo"]["type"]) || ($_FILES["photo"]["type"] != "image/png" && $_FILES["photo"]["type"] != "image/jpg" && $_FILES["photo"]["type"] != "image/jpeg")) {
			$contenu .= '<div class="alert alert-danger"> Le format d\'image n\'est pas valide.</div>';
		} else {
			// partie set id
			$get_id = execute_requete("SELECT MAX(id_contact) + 1 FROM contact");
			if ($get_id) {
				$next_id = $get_id->fetch(PDO::FETCH_NUM);
				$id= $next_id[0];
			} else {
				echo 'soucis id';
			}
			// partie set extension
			$ext ="";
			switch ($_FILES["photo"]["type"]) {
				case 'image/png':
					$ext =".png";
					echo 'match png';
					break;
				case 'image/jpeg':
					$ext =".jpeg";
					echo 'match jpeg';
					break;
				default:
					$ext =".jpg";
					echo 'match default';
					break;
			}
			$fichier_photo = "contact_" .$id.$ext; // partie rename du fichier
			$photo_bdd = "photos/" . $fichier_photo; // set du path -> file
			copy($_FILES["photo"]["tmp_name"], $photo_bdd); // on recupere le tmp uploadé et on le colle dans l'arbo definie
			// Partie 6  (apres le copy imposé - mais là ce serait mixable dans un meme bloc si on fait d'une pierre deux coups avant le copy du tmp ) - crea d'une miniature
			$file = $_FILES['photo']['tmp_name']; 
			$sourceProperties = getimagesize($file);
			$fileNewName = "thumbnail_";
			$folderPath = "minis/";
			$ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
			$imageType = $sourceProperties[2];
			switch ($imageType) { // case au lieu de if si on veut ajouter d'autres types
				case IMAGETYPE_PNG:
					$imageResourceId = imagecreatefrompng($file); 
					$targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
					imagepng($targetLayer,$folderPath.$fileNewName.$id.".".$ext);
				break;
				default:
					$imageResourceId = imagecreatefromjpeg($file); 
					$targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
					imagejpeg($targetLayer,$folderPath.$fileNewName.$id.".".$ext);
				break;
			}
			echo "Resize OK";
		}
	}
	// traitements
	if (empty($contenu)) {
            $succes = execute_requete("INSERT INTO contact (nom, prenom, telephone, email, type_contact, photo) VALUES (:nom, :prenom, :telephone, :email, :type_contact, :photo)",
            array(
                "nom" => $_POST["nom"],
                "prenom" => $_POST["prenom"],
                "telephone" => $_POST["telephone"],
                "email" => $_POST["email"],
                "type_contact" => $_POST["type_contact"],
                "photo" => $photo_bdd
            ));
            if ($succes) {
                $contenu .= "<div class='alert alert-success'>".$_POST["prenom"]." ".$_POST["nom"]." a été enregistré.</div>";
            } else  {
                $contenu .= "<div class='alert alert-danger'> Erreur lors de l'enregistrement.</div>";
            }
        }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	   <!-- Lien vers le cdn bootstrap -->
	   <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" integrity="sha384-xrRywqdh3PHs8keKZN+8zzc5TX0GRTLCcmivcbNJWm2rs5C8PRhcEn3czEjhAO9o" crossorigin="anonymous"></script>
	<title>Repertoire</title>
</head>
<body>

<h1 class="mt-4">Répertoire</h1>

<ul class="nav nav-tabs">
    <li><a class="nav-link" href="liste_contact.php"> Liste des contacts </a></li>
    <li><a class="nav-link active" href="ajout_contact.php"> Ajouter un contact </a></li>
</ul>
<?php
echo $contenu;
?>
<form method="post" action="" enctype="multipart/form-data" style="text-align:center;">

	<label for="nom">Nom</label><br>
    <input type="text" name="nom" id="nom" placeholder="Nom"><br>

    <label for="prenom">Prénom</label><br>
    <input type="text" name="prenom" id="prenom" placeholder="prénom"><br>

    <label for="telephone">Numero de tel</label><br>
    <input type="text" name="telephone" id="telephone" placeholder="Téléphone" pattern="[0-9]{10}"><br>

	<label for="email">E-mail</label><br>
    <input type="address" name="email" id="email" placeholder="e-mail" value=""><br>
    
    <label for="type_contact">Type de contact</label><br>
    <select name="type_contact" id="type_contact">
        <option value="ami">Ami</option>
        <option value="famille">Famille</option>
        <option value="professionnel">Professionnel</option>
        <option value="autre">Autre</option>
    </select><br>

    <label for="photo">Photo</label><br>
	<input type="file" name="photo" id="photo" accept=".jpg, .jpeg, .png"><br>

    <input type="submit" value="enregistrer" class="btn" role="button">

</form>

</body>
</html>