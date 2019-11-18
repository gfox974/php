<?php
require_once 'inc/init.php';

if($_POST) {
    $photo_bdd = '';
    $description_bdd = '';

    if(!isset($_POST["titre"]) || strlen($_POST["titre"]) > 50) {
        $contenu .= '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert"> L\'annonce doit avoir un titre comprenant au maximum 50 caracteres.</div>';
    }

    if(!isset($_POST["adresse"]) || strlen($_POST["adresse"]) >50) {
        $contenu .= '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert"> Le bien doit avoir une adresse comprenant au maximum 50 caracteres.</div>';
    }

    if(!isset($_POST["ville"]) || strlen($_POST["ville"]) > 50) {
        $contenu .= '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert"> La ville doit comprendre au maximum 50 caracteres.</div>';
    }

	if(!isset($_POST["cp"]) || !preg_match("#^[0-9]{5}$#", $_POST["cp"])) {
        $contenu .= '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert"> Le code postal doit etre composé de 5 chiffres.</div>';
    }

    if(!isset($_POST["surface"]) || !preg_match("#^[0-9]#", $_POST["surface"]) || !is_numeric($_POST["surface"])) {
        $contenu .= '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert"> La surface doit etre exprimée en chiffres.</div>';
    }

    if(!isset($_POST["prix"]) || !preg_match("#^[0-9]#", $_POST["prix"])|| !is_numeric($_POST["prix"]))  {
        $contenu .= '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert"> Le prix doit etre exprimé en chiffres.</div>';
    }

    if(!isset($_POST["type"]) || ($_POST["type"] != "location" && $_POST["type"] != "vente")) {
        $contenu .= '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert"> Le type d\'annonce n\'est pas valide.</div>';
	}

	if (isset($_POST['photo'])) {
		$photo_bdd = $_POST['photo'];
    }
    
    if (isset($_POST['description'])) {
		$description_bdd = $_POST['description'];
	}

	if (!empty($_FILES["photo"]["name"])) {
		if(!isset($_FILES["photo"]["type"]) || ($_FILES["photo"]["type"] != "image/png" && $_FILES["photo"]["type"] != "image/jpg" && $_FILES["photo"]["type"] != "image/jpeg")) {
			$contenu .= '<div class="alert alert-danger"> Le format d\'image n\'est pas valide.</div>';
		} else {
            $get_id = execute_requete("SELECT MAX(id_logement) + 1 FROM logement");
			if ($get_id) {
				$next_id = $get_id->fetch(PDO::FETCH_NUM);
				$id= $next_id[0];
			} else {
				$contenu .= 'soucis id';
			}
			$ext ="";
			switch ($_FILES["photo"]["type"]) {
				case 'image/png':
					$ext =".png";
					break;
				case 'image/jpeg':
					$ext =".jpeg";
					break;
				default:
					$ext =".jpg";
					break;
            }
            if (filesize($_FILES["photo"]["tmp_name"]) < 15728640) { 
                $fichier_photo = "logement_" .$id.$ext; 
			    $photo_bdd = "photos/" . $fichier_photo; 
			    copy($_FILES["photo"]["tmp_name"], $photo_bdd);
			    $file = $_FILES['photo']['tmp_name']; 
			    $sourceProperties = getimagesize($file);
			    $fileNewName = "logement_";
			    $folderPath = "thumbnails/";
			    $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
			    $imageType = $sourceProperties[2];
			    switch ($imageType) {
				    case IMAGETYPE_PNG:
					    $imageResourceId = imagecreatefrompng($file); 
					    $targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
					    imagepng($targetLayer,$folderPath.$fileNewName.$id."_300x300.".$ext);
				    break;
				    default:
					    $imageResourceId = imagecreatefromjpeg($file); 
					    $targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
					    imagejpeg($targetLayer,$folderPath.$fileNewName.$id."_300x300.".$ext);
				    break;
			    }
            } else {
                $contenu .= '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert"> L\'image est trop lourde (> 15mb).</div>';
            }
		}
	}
	
	if (empty($contenu)) {
            $succes = execute_requete("INSERT INTO logement (titre, adresse, ville, cp, surface, prix, type, photo, description) VALUES (:titre, :adresse, :ville, :cp, :surface, :prix, :type, :photo, :description)",
            array(
                "titre" => $_POST["titre"],
                "adresse" => $_POST["adresse"],
                "ville" => $_POST["ville"],
                "cp" => $_POST["cp"],
                "surface" => $_POST["surface"],
                "prix" => $_POST["prix"],
                "type" => $_POST["type"],
                "photo" => $photo_bdd,
                "description" => $description_bdd
            ));
            if ($succes) {
                $contenu .= '<div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md" role="alert"> Le bien a été enregistré.</div>';
            } else  {
                $contenu .= '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert"> Erreur lors de l\'enregistrement.</div>';
            }
        }
}


require_once 'inc/header.php';
?>

<ul class="flex flex-col mt-4 -mx-4 pt-4 border-t md:flex-row md:items-center md:mx-0 md:ml-auto md:mt-0 md:pt-0 md:border-0">
        <li>
          <a class="block px-4 py-1 md:p-2 lg:px-4 text-purple-600" href="ajout.php" title="Ajout de bien">Ajout de bien</a>
        </li>
        <li>
          <a class="block px-4 py-1 md:p-2 lg:px-4" href="liste.php" title="Link">Liste des biens</a>
        </li>
      </ul>
    </div>
  </div>
</nav>



<?php
echo $contenu;
?>

<div class="leading-loose w-2/5 mx-auto">
  <form class="max-w-xl m-4 p-10 bg-white rounded shadow-xl" method="post" action="" enctype="multipart/form-data">
    <p class="text-gray-800 font-medium">Ajouter un bien</p>

    <div class="">
      <label class="block text-sm text-gray-00" for="titre">Titre</label>
      <input class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" id="titre" name="titre" type="text" require placeholder="Titre de l'annonce" aria-label="Email">
    </div>

    <div class="">
      <label class="block text-sm text-gray-00" for="adresse">Adresse</label>
      <input class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" id="adresse" name="adresse" type="text" require placeholder="Adresse du bien" aria-label="Email">
    </div>

    <div class="inline-block mt-2 w-1/2 pr-1">
      <label class="hidden block text-sm text-gray-600" for="ville">Ville</label>
      <input class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" id="ville" name="ville" type="text" require placeholder="Ville" aria-label="Name">
    </div>
    <div class="inline-block mt-2 -mx-1 pl-1 w-1/2">
      <label class="hidden block text-sm text-gray-600" for="cp">Code postal</label>
      <input class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" id="cp"  name="cp" type="number" require placeholder="Code postal" aria-label="Name">
    </div>

    <div class="inline-block mt-2 w-1/2 pr-1">
      <label class="block text-sm text-gray-600" for="surface">Surface</label>
      <input class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" id="surface" name="surface" type="number" require placeholder="Surface en m²" aria-label="Name">
    </div>
    <div class="inline-block mt-2 -mx-1 pl-1 w-1/2">
      <label class="block text-sm text-gray-600" for="prix">Prix</label>
      <input class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" id="prix" name="prix" type="number" require placeholder="Prix en €" aria-label="Name">
    </div>

    <div class="mt-2">
      <label class=" block text-sm text-gray-600" for="type">Type d'annonce</label>
      <select class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" name="type" id="type" require>
        <option value="location">Location</option>
        <option value="vente">Vente</option>
    </select><br>
    </div>
    <div class="mt-2">
      <label class="text-sm block text-gray-600" for="photo">Photo</label>
      <input class="w-full px-2 py-2 text-gray-700 rounded" type="file" name="photo" id="photo" accept=".jpg, .jpeg, .png"><br>
    </div>

    <div class="">
      <label class="block text-sm text-gray-00" for="description">Description</label>
      <textarea class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" id="description" name="description" type="text" placeholder="texte d'annonce (facultatif)" aria-label="Email" pattern="[0-9]{10}"></textarea>
    </div>

    <div class="mt-4">
      <button class="px-4 py-1 text-white font-light tracking-wider bg-blue-400 rounded" type="submit" value="enregistrer"> Ajouter </button>
    </div>
  </form>
</div>


<?php
require_once 'inc/footer.php';
?>