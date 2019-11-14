<?php

function debug($param) {
    echo "<pre>";
        var_dump($param);
    echo "</pre>";
}

// Fonctions relatives au membre :
    // Fonction qui verifie si le membre est connecté :
function est_connecte() {
    if(isset($_SESSION["membre"])) { // Si l'indice "membre" existe dans la session, c'est que le membre est passé par la page de connexion et  qu'il s'est correctement identifé (voir connexion.php)
        return true; // Il est connecté
    }else {
        return false; // Il n'est pas connecté.
    }
}

    // Fconction qui verifie si le membre est administrateur connecté :
function est_admin(){
    if(est_connecte() && $_SESSION["membre"]["statut"] == 1) { // si le membre est connecté ET que son statut vaut 1, il est donc admin connecté.
        return true;
    }else {
        return false;
    }
}


// function qui realise les requetes preparées pour nous :
//$membre = execute_requete("SELECT * FROM membre WHERE pseudo = :pseudo", array(':pseudo => $_POST["pseudo"]'));

function execute_requete($requete, $param = array()) { // $requete attend une requete SQL sous forme de string. $param attend un array qui associe les marqueurs a leur valeur, sinon prend un array vide par defaut si on le lui donne rien.
if (!empty($param)){ // Si on a bien un tableau, on peut faire la boucle dessus.

    foreach ($param as $indice => $valeur) {
        $param[$indice] = htmlspecialchars($valeur);
    }
}
    global $pdo; // Pour accerder a cette variable definie dans l'espace global du fichier.

    $resultat = $pdo->prepare($requete); // On prépare la requete reçue
    $succes = $resultat->execute($param); // on execute la requete avec le tableau qui associe les marqueurs aux valeurs.
    if ($succes){  
        return $resultat;
    }else {
        return false; // Retourne false en cas d'echec de la requete
    }
    
}
?>

