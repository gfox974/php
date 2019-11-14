<?php
require_once "inc/init.php";
$message = ""; // pour le message de deconnexion

// 2- Quand l'internaute clique sur deconnexion
//debug($_GET);
if(isset($_GET["action"]) && $_GET["action"] == "deconnexion"){ // Si existe l'indice "action" dans $_GET et que sa valeur est egale a "deconnexion" on deconnecte l'internaute :
    unset($_SESSION["membre"]); // on supprime les infos du membres de la session
    $message .= "<div class= 'alert alert-info'> Vous etes deconnectés</div>";

}
// 3- Si l'internaute est deja connecté, on le renvoie vers son profil :
if (est_connecte()) {
    header("location:profil.php"); // On refait une redirection vers le profil pour eviter de se conneter plusieur fois
    exit();
}

// 1- traitement du formulaire :
    //debug($_POST);

if ($_POST) { // Si le formulaire est envoyé
    // controle du formulaire :
    if (empty($_POST["pseudo"]) || empty($_POST["mdp"])) {
        $contenu .= "<div class='alert alert-danger'> Les identifiants sont obligatoires</div>";
    }
    // Si pas d'erreur d'afficher, on peut verifier le pseudo et le mdp en BDD:

    if (empty($contenu)) {
        $resultat = execute_requete("SELECT * FROM membre WHERE pseudo = :pseudo", array(":pseudo" => $_POST["pseudo"])); // On selectionne le membre avec le pseudo fourni pour verifier qu'il existe en BDD

        if ($resultat->rowCount() == 1){ // si il y a une ligne, c'est que le pseudo existe en BDD
            $membre = $resultat->fetch(PDO::FETCH_ASSOC); // on transforme l'objet PDOStatement en tableau pour en sxtraire le mdp.
            //debug($membre);
            // On verifie le mdp :
                if (password_verify($_POST["mdp"], $membre["mdp"])) { // Retrourne true si le hash du mdp en BDD correspond au mdp de connexion
                    $_SESSION["membre"] = $membre; // on remplit la session avec un indice "membre" et toutes les infos du membre provenant de la BDD en valeur.
                    header("location:profil.php"); // Une fois les identifiants corrects, et la session remplie, et on redirige l'utilisateur vers la page profil.php
                    exit(); // Pour quitter cette page. 
                } else { // Sinon il y a erreur sur le mot de passe
                    $contenu .= "<div class= 'alert alert-danger'>Erreur sur les identifiants</div>";
                }

        } else {
            $contenu .= "<div class= 'alert alert-danger'>Erreur sur les identifiants</div>";
        }
    } // Fin du if (empty($contenu))
} // Fin du if ($_POST)


// --------------------------- AFFICHAGE ----------------------
require_once "inc/header.php";
?>
<h1 class="mt-4">Connexion</h1>
<?php
echo $message; // Pour le message de la deconnexion
echo $contenu; // Pour les autres messages
?>
<form method="post" action="">
    <label for="pseudo">Pseudo</label><br>
    <input type="text" name="pseudo" id="pseudo"><br>

    <label for="mdp">Mot de passe</label><br>
    <input type="password" name="mdp" id="mdp"><br>

    <input type="submit" value="Se connecter" class="btn">




<?php
require_once "inc/footer.php"

?>