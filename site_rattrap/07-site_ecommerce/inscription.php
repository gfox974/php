<?php
require_once "inc/init.php";
$affiche_formulaire = true; // Pour notre condition qui affiche le formulaire tant que le membre n'est pas inscrit.



// Traitement du $_POST

//debug($_POST);

if($_POST) { // si le formulaire 
    if(!isset($_POST["pseudo"]) || strlen($_POST["pseudo"]) < 4 || strlen($_POST["pseudo"]) > 20) {
        $contenu .= '<div class="alert alert-danger"> Le pseudo doit comprendre entre 4 et 20 caractère.</div>';
    }

    if(!isset($_POST["mdp"]) || strlen($_POST["mdp"]) < 4 || strlen($_POST["mdp"]) > 20) {
        $contenu .= '<div class="alert alert-danger"> Le mot de passe doit comprendre entre 4 et 20 caractère.</div>';
    }

    if(!isset($_POST["nom"]) || strlen($_POST["nom"]) < 4 || strlen($_POST["nom"]) > 20) {
        $contenu .= '<div class="alert alert-danger"> Le nom doit comprendre entre 4 et 20 caractère.</div>';
    }

    if(!isset($_POST["prenom"]) || strlen($_POST["prenom"]) < 4 || strlen($_POST["prenom"]) > 20) {
        $contenu .= '<div class="alert alert-danger"> Le prenom doit comprendre entre 4 et 20 caractère.</div>';
    }

    if(!isset($_POST["email"]) || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $contenu .= '<div class="alert alert-danger"> L\'email est invalide.</div>';
    }

    if(!isset($_POST["civilite"]) || ($_POST["civilite"] != "m" && $_POST["civilite"] != "f" )) {
        $contenu .= '<div class="alert alert-danger> Le sexe n\'est pas valide.</div>';
    }

    if(!isset($_POST["ville"]) || strlen($_POST["ville"]) < 4 || strlen($_POST["ville"]) > 20) {
        $contenu .= '<div class="alert alert-danger"> Le ville doit comprendre entre 4 et 20 caractère.</div>';
    }

    if(!isset($_POST["code_postal"]) || !preg_match("#^[0-9]{5}$#", $_POST["code_postal"])) {
        $contenu .= '<div class="alert alert-danger"> Le code postal doit comprendre 5 chiffres.</div>';
    }

    if(!isset($_POST["adresse"]) || strlen($_POST["adresse"]) < 4 || strlen($_POST["adresse"]) > 50) {
        $contenu .= '<div class="alert alert-danger"> L\'adresse doit comprendre entre 4 et 20 caractère.</div>';
    }

// Si pas d'erreur sur le formulaire, on verifie l'unicité du pseudo :
    if (empty($contenu)) {

        $membre = execute_requete("SELECT * FROM membre WHERE pseudo = :pseudo", 
        array(':pseudo' => $_POST["pseudo"]));

        if(!empty($membre) && $membre->rowCount() > 0  ){ // si $membre contient des lignes, c'est que le pseudo est en BDD
            $contenu .= "<div class='alert alert-danger'>Pseudo indisponible. Veuillez en choisir un autre.</div>";
        } else { // Dans le cas contraire on, peut inscrire le membre.
            $mdp= password_hash($_POST["mdp"], PASSWORD_DEFAULT); // Si nous hachons le mdp, il faudra sur la page de connexion, comparer le hash de la BDD avec celui du mdp de l'internaute. PASSWORD_DEFAULT utilise l'agorythme mbcrypt a l'heure actulle.
            $succes = execute_requete("INSERT INTO membre (pseudo, mdp, nom, prenom, email, ville, code_postal, adresse, statut) VALUES (:pseudo, :mdp, :nom, :prenom, :email, :ville, :code_postal, :adresse, 0)",
            array(
                "pseudo" => $_POST["pseudo"],
                "mdp" => "$mdp",
                "nom" => $_POST["nom"],
                "prenom" => $_POST["prenom"],
                "email" => $_POST["email"],
                "ville" => $_POST["ville"],
                "code_postal" => $_POST["code_postal"],
                "adresse" => $_POST["adresse"]
            ));

            if ($succes) {
                $contenu .= "<div class='alert alert-success'> Vous etes inscrit. <a href='connexion.php'>Cliquez ici pour vous connecter.</a></div>";
            } else  {
                $contenu .= "<div class='alert alert-danger'> Erreur lors de l'inscription.</div>";
            }
        }

    }// fin de if (empty($contenu))



} // de if($_POST)



// insert into
//$affiche_formulaire = false;

// ----------------------------------- affichage --------------------------------------------
require_once "inc/header.php";
?>

<h1 class="mt-4">Inscription</h1>

<?php

echo $contenu; // pour les messages
if ($affiche_formulaire) :
?>
<form method="post" action="">

    <label for="pseudo">Pseudo :</label><br>
    <input type="text" name="pseudo" id="pseudo" value=""><br>



    <label for="mdp">Mot de passe :</label><br>
    <input type="password" name="mdp" id="mdp" value=""><br>

    <label for="nom">Nom :</label><br>
    <input type="text" name="nom" id="nom" value=""><br>



    <label for="prenom">Prenom :</label><br>
    <input type="text" name="prenom" id="prenom" value=""><br>



    <label for="email">Email :</label><br>
    <input type="text" name="email" id="email" value=""><br>



    <label for="civilite">Civilité :</label><br>
    <input type="radio" name="civilite" id="m" value="m" checked><label for"m">Homme</label>
    <input type="radio" name="civilite" id="m" value="f"><label for"f">Femme</label><br>



    <label for="ville">Ville :</label><br>
    <input type="text" name="ville" id="ville" value=""><br>



    <label for="code_postal">Code postal :</label><br>
    <input type="text" name="code_postal" id="code_postal" value=""><br>



    <label for="adresse">Adresse :</label><br>
    <input type="text" name="adresse" id="adresse" value=""><br>


    <input type="submit" value="S'inscrire" class="btn">





</form>


<?php
endif;


require_once "inc/footer.php";
?>