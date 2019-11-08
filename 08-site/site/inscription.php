<?php
// ----------- partie traitements
require_once 'inc/init.php';

// on va afficher le formulaire seulement tant que le membre n'est pas inscrit
$affiche_formulaire = TRUE; # On va donc set une variable pour gerer cet etat

// Partie : Traitement du POST
#debug($_POST);
if ($_POST){ # Si le formulaire a été rempli,
# -> Validation du formulaire ( 9 conditions, vu qu'il y a 9 champs)
    # regles pseudo
    if (!isset($_POST['pseudo']) || strlen($_POST['pseudo']) < 4 || strlen($_POST['pseudo']) > 20 ) {
        $contenu .= '<div class="alert alert-danger">Le peudonyme doit contenir entre 4 et 20 caracteres.</div>';
    }
    # regles mdp
    if (!isset($_POST['mdp']) || strlen($_POST['mdp']) < 8  ) {
        $contenu .= '<div class="alert alert-danger">Le mot de passe doit contenir au moins 8 caracteres.</div>';
    }
    # regles nom
    if (!isset($_POST['nom']) || strlen($_POST['nom']) < 3 ) {
        $contenu .= '<div class="alert alert-danger">Le nom doit contenir au moins 3 caracteres.</div>';
    }
    # regles prenom
    if (!isset($_POST['prenom']) || strlen($_POST['prenom']) < 3 ) {
        $contenu .= '<div class="alert alert-danger">Le prénom doit contenir au moins 3 caracteres.</div>';
    }
    # regles mail
    if (!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ) { # filter_var permet de ne pas se faire chier a faire une regex, retourne true / false selon match des criteres
        $contenu .= '<div class="alert alert-danger">L\'e-mail n\'est pas valide.</div>';
    }
    # regles civ
    if (!isset($_POST['civilite']) || ($_POST['civilite'] != 'm' && $_POST['civilite'] != 'f') ) {
        $contenu .= '<div class="alert alert-danger">Civilité invalide.</div>';
    }
    # regles ville
    if (!isset($_POST['ville']) || strlen($_POST['ville']) < 3 ) {
        $contenu .= '<div class="alert alert-danger">La ville doit contenir au moins 3 caracteres.</div>';
    }
    # regles adresse
    if (!isset($_POST['adresse']) || strlen($_POST['adresse']) < 3 ) {
        $contenu .= '<div class="alert alert-danger">L\'adresse doit contenir au moins 3 caracteres.</div>';
    }
    # regles code postal
    if (!isset($_POST['code_postal']) || !preg_match('#^[0-9]{5}$#', $_POST["code_postal"]) ) {
        $contenu .= '<div class="alert alert-danger">Le code postal est incorrect.</div>';
    }

    // Maintenant, S'il n'y a pas d'erreurs, on va verifier en base si les données uniques style pseudo sont disponibles ( verifs d'unicité )
    if (empty($contenu)){ # Si contenu est vide = pas d'erreurs, donc ->
        # On va passer une requete secure definie dans functions
        $membre = executeRequete('SELECT * FROM membre WHERE pseudo = :pseudo',
            array(':pseudo' => $_POST['pseudo']));
        if(!empty($membre) && $membre->rowCount() > 0 ){ # Si membre n'est pas vide et contient des lignes, le pseudo existe deja en bdd
            $contenu .= '<div class="alert alert-danger">Ce pseudonyme est deja pris, veuillez en choisir un autre.</div>';
        } else {
            # Good, pseudo dispo, inscription ( hash du pass, insert etc)
            $mdp = password_hash($_POST['mdp'],PASSWORD_DEFAULT); # là on va utiliser l'algo par defaut pour generer le hash, en php7 c'est bcrypt
            $succes = executeRequete('INSERT INTO membre (pseudo, mdp, nom, prenom, email, civilite, ville, code_postal, adresse, statut) VALUES 
            (:pseudo, :mdp, :nom, :prenom, :email, :civilite, :ville, :code_postal, :adresse, 0)',
                array(
                    ':pseudo' => $_POST['pseudo'],
                    ':mdp' => $mdp,
                    ':nom' => $_POST['nom'],
                    ':prenom' => $_POST['prenom'],
                    ':email' => $_POST['email'],
                    ':civilite' => $_POST['civilite'],
                    ':ville' => $_POST['ville'],
                    ':code_postal' => $_POST['code_postal'],
                    ':adresse' => $_POST['adresse']
                )
            );
            if ($succes){
                $contenu .= '<div class="alert alert-success">Vous etes inscrit, <a href="connection.php">Cliquez ici pour vous connecter</a></div>';
            } else {
                $contenu .= '<div class="alert alert-danger"> Erreur lors de l\'inscription </div>';
            }
        }
    } # fin du if empty contenu
} # close if post

// --------- partie affichage
require_once 'inc/header.php';
?>

<h1 class="mt-4">Inscription</h1>

<?php
echo $contenu;
# ouverture d'un bloc if, fermé par un endif dans le bloc bas
if ($affiche_formulaire): # tant que vrai do 
?>

<form method="post" action="">
    <label for="pseudo">Pseudo</label><br>
    <input type="text" name="pseudo" id="pseudo" placeholder="entrer un pseudonyme" value=""><br>
    
    <label for="mdp">Mot de passe</label><br>
    <input type="password" name="mdp" id="mdp" placeholder="entrer un mot de passe" value=""><br>
    
    <label for="nom">Nom</label><br>
    <input type="text" name="nom" id="nom" placeholder="entrer votre patronyme" value=""><br>

    <label for="prenom">Prénom</label><br>
    <input type="text" name="prenom" id="prenom" placeholder="entrer votre prénom" value=""><br>
    
    <label for="email">E-mail</label><br>
    <input type="address" name="email" id="email" placeholder="entrer votre e-mail" value=""><br>
    
    <label>Civilité</label><br>
    <input type="radio" name="civilite" id="m" value="m" checked><label for="m">Monsieur</label>
    <input type="radio" name="civilite" id="f" value="f"><label for="f">Madame</label><br>

    <label for="ville">Ville</label><br>
    <input type="text" name="ville" id="ville" placeholder="Ville" value=""><br>

    <label for="code_postal">Code postal</label><br>
    <input type="number" name="code_postal" id="code_postal" placeholder="Code postal" value=""><br>

    <label for="adresse">Adresse</label><br>
    <input type="text" name="adresse" id="adresse" placeholder="entrer votre adresse" value=""><br>

    <input type="submit" value="S'inscrire" class="btn">
</form>



<?php
endif;

// start footer
require_once 'inc/footer.php';
?>