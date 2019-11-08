<?php
// partie traitements
require_once 'inc/init.php';
$message=""; // pour le message de deconnection

// 2) Gestion de la deconnection
# debug($_GET);
if (isset($_GET['action']) && $_GET['action'] == 'deconnection'){
    // Si l'indice action dans get a une valeur deconnection -> deconnection de l'internaute
    unset($_SESSION['membre']); // on destroy pas la session pour que le panier reste persistant
    $message .= '<div class="alert alert-info">Vous etes déconnécté.</div>';
}

// 3 ) Traiter le cas où l'internaute est deja co et essaie de se co
if (estConnecte()){
    // si c'est le cas, on le renvoie vers son profil
    header('location:profil.php');
    exit();
}

// 1) traitement du formulaire
#debug($_POST);

if(!empty($_POST)){ // quand le formulaire envoyé n'est pas vide
    // -> controle du formulaire
    if (empty($_POST['pseudo'] || $_POST['mdp']) ){
        $contenu .= '<div class="alert alert-danger">Les identifiants sont obligatoires !</div>';
    }
    // si pas d'erreur d'affichée, on verifie l'info en bdd
    if (empty($contenu)){
        $resultat= executeRequete('SELECT * FROM membre where pseudo = :pseudo',
        array(':pseudo' => $_POST['pseudo']) ); // On verifie d'abord si le pseudonyme existe
        if ($resultat->rowCount() == 1 ){ # Si il y a une ligne, c'est que le pseudo est en base
            $membre = $resultat->fetch(PDO::FETCH_ASSOC); # on transforme l'objet pdo statement en tableau pour en extraire le mdp
            // On va recuperer le mot de passe hashé verifier la correspondance entre ce hash, et le hashage du mot de passe tapé, mais via une fonction car par defaut brypt utilise une clé random qu'il stocke 
            if (password_verify($_POST['mdp'], $membre['mdp']) ){ # retournera true si le hash en bdd corresponds au mot de passe en input
                $_SESSION['membre'] = $membre; # On cale tout l'array dans session, comme ca on a tout sous la main apres coté serv
                // Maitenant que l'utilisateur est loggé, redirection vers son profil ->
                header('location:profil.php');
                exit(); # fin d'execution du script
            } else {
                $contenu .= '<div class="alert alert-danger">Identifiants (pass)incorrects.</div>';    // on ne dit plus où ca foire pour eviter de donner des indications pour les bruteforce
            }
        } else {
            $contenu .= '<div class="alert alert-danger">Identifiants incorrects.</div>';
        }
    }
} # fin du post not empty

// Partie affichage
require_once 'inc/header.php';
?>

<h1 class="mt-4">Connection</h1>

<?php
echo $message; # messages de deconnection
echo $contenu; # les autres messages
?>

<form method="post" action="">
    <label for="pseudo">Pseudo</label><br>
    <input type="text" name="pseudo" id="pseudo" placeholder="entrer votre pseudonyme" value=""><br>
    <label for="mdp">Mot de passe</label><br>
    <input type="password" name="mdp" id="mdp" placeholder="entrer votre mot de passe" value=""><br>
    <input type="submit" value="Se connecter" class="btn">
</form>

<?php
require_once 'inc/footer.php';
?>