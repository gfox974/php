<?php
// -------------------------------
// Validation de formulaire
// -------------------------------

// Exercise :
/* Vous creez un formulaire pour saisir un nouvel employé dans la BDD "entreprise".
        1- Creation du formulaire HTML : tous les champs sont de type "text" sauf le sexe qui est de "radio".
        2- Connexion à la BDD "entreprise".
        3- Lorsque le formalaire est envoyé, insertion des données en BDD avec une requete preparée.
        4- Faire en sorte que les données saisies dans le formulaire ne s'effacent pas.
*/
function debug($param) {
    echo "<pre>";
        var_dump($param);
    echo "</pre>";
}

$texte = ""; // pour afficher nos messages


$pdo = new PDO("mysql:host=localhost;dbname=entreprise","root","", array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
   ));

   if($_POST) { // si le formulaire est envoyé, $_POST est rempli : il vaut donc true implicitement

        if(!isset($_POST["prenom"]) || strlen($_POST["prenom"]) < 3 || strlen($_POST["prenom"]) > 20) {
            $texte .= "<p> Le prenom doit comprendre entre 3 et 20 caractère.</p>";
        }

        if(!isset($_POST["nom"]) || strlen($_POST["nom"]) < 3 || strlen($_POST["nom"]) > 20) {
            $texte .= "<p> Le prenom doit comprendre entre 3 et 20 caractère.</p>";
        }
        
        if(!isset($_POST["service"]) || strlen($_POST["service"]) < 3 || strlen($_POST["service"]) > 20) {
            $texte .= "<p> Le prenom doit comprendre entre 3 et 20 caractère.</p>";
        }

        if(!isset($_POST["sexe"]) || ($_POST["sexe"] != "m" && $_POST["sexe"] != "f" )) {
            $texte .= "<p> Le sexe n'est pas valide.</p>";
        }

        if(!isset($_POST["salaire"]) || !is_numeric($_POST["salaire"]) ) {
            $texte .= "<p> Le salaire doit etre un nombre uniquement.</p>";
        }

        // controle de la date ( 1er temps : validation si pas vide, et si le format attendu est correct - le format de date fr)
        if (!isset($_POST["date_embauche"]) || 
        !preg_match('#^[0-9]{2}/[0-9]{2}/[0-9]{4}$#', $_POST["date_embauche"]) || 
        !strtotime(str_replace("/","-", $_POST["date_embauche"])) ){ 
            # # regex en php pour verifier le format de date jj/mm/aaaa :  # debut regex ^ commence par, [authorized]{nbchars}/ : symbole   $ finis par # end
            # strtotime convertis en timestamp unix (attention, les dates incoherentes jusqu'au 32 sont extrapolées), par contre il ne prends que le format us, on va donc devoir faire un replace pour changer de delimiteurs,
            # PUIS transposer l'ordre de la date pour le mettre au format de la base de données
            $texte .= "<p> La date n'est pas valide.</p>";
        }

 if(empty($texte)) { // si la variable est vide, c'est qu'il n'y a pas d'erreur
// on assainit les données du $_POST avant insertion de BDD :
    foreach ($_POST as $indice => $valeur) {
        $_POST[$indice] = htmlspecialchars($valeur); // a chaque tour de boucle, on prend la valeur que l'on passe dans htmlspecialchars pour retraiter les chevrons. Puis on remet cette valeur a sa place dans $_POST[$indice].
    }

// on reformate ici la date en format y-m-d pour la bdd. (methode objet)
$date = new DateTime(str_replace("/","-", $_POST["date_embauche"])); # on fournit la date au format jj/mm/aaaa à la methode datetime
$date_embauche = $date->format('Y-m-d'); # on fait appel à la methode objet pour definir le format d'output

 $resultat = $pdo->prepare("INSERT INTO employes (prenom, nom, sexe, service, date_embauche, salaire) VALUES (:prenom, :nom, :sexe, :service, :date_embauche, :salaire)");
 $succes = $resultat->execute(array(
 ":prenom" => $_POST["prenom"], 
 ":nom" => $_POST["nom"], 
 ":sexe" => $_POST["sexe"], 
 ":service" => $_POST["service"], 
 ":date_embauche" => $date_embauche, # on insert donc la date vérifiée et reformatée 
 ":salaire" => $_POST["salaire"]
));

if ($succes) {
    $texte = "<p> L'employé a bien été ajouté.</p>";
}else {
    $texte = "<p> Une erreur est survenue...</p>";
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
    <title>Document</title>
</head>

<body>

<?php
echo $texte;
?>
    <form method="post" action="">
        <div>
            <label for="prenom">Prénom</label>
            <input type="text" name="prenom" id="prenom" value="<?php echo $_POST['prenom'] ?? ''; ?>">
        </div>

        <div>
            <label for="nom">Nom</label>
            <input type="text" name="nom" id="nom" value="<?php echo $_POST['nom'] ?? ''; ?>">
        </div>

        <div>
        <label for="sexe">Sexe</label>
            <input type="radio" name="sexe" id="sexe" value="m" checked>Homme
            <input type="radio" name="sexe" id="sexe" value="f" <?php if (isset($_POST['sexe']) && $_POST['sexe'] == 'f' ) echo "checked"; ?> >Femme
        </div>

        <div>
            <label for="service">service</label>
            <input type="text" name="service" id="prenom" value="<?php echo $_POST['service'] ?? ''; ?>" >
        </div>

        <div>
            <label for="date_embauche">Date d'embauche</label>
            <input type="text" name="date_embauche" id="prenom" value="<?php echo $_POST['date_embauche'] ?? ''; ?>" placeholder="jj/mm/aaaa">
        </div>

        <div>
            <label for="salaire">Salaire</label>
            <input type="text" name="salaire" id="prenom" value="<?php echo $_POST['salaire'] ?? ''; ?>">
        </div>

        <div>
            <input type="submit" name="validation" value="Envoyer">
        </div>

</body>

</html>

<?php


//debug($employes);