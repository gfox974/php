<?php

function debug($param){
    echo '<pre>';
        var_dump($param);
    echo '</pre>';
}

// Fonctions relatives aux membres:

# Fonction qui verifie si le membre est connecté
function estConnecte(){
    if (isset($_SESSION['membre'])){ // Si l'indice 'membre' existe dans la session, c'est que le membre est passé par la page de connection et qu'il s'est correctement identifié, c'est à cet instant qu'on va y mettre une valeur (dans connection.php)
        return TRUE;
    } else {
        return FALSE;
    }
}

# Fonction qui vérifie si le membre loggé est un administrateur du site
function estAdmin(){
    if (estConnecte() && $_SESSION['membre']['statut'] == 1 ){ # On separe les membres des admins avec un statut admin = 0 ou 1
        return TRUE;
    } else {
        return FALSE;
    }
}

# Fonctions d'appels de requetes préparées 
function executeRequete($requete, $params = array()){ # Là en guise de parametres par defaut on lui colle un array vide, le second argument est donc optionnel pour preparer la requete
    if (!empty($params)){ # Si on a bien un tableau rempli, on boucle dessus pour transformer les chevrons en entités html et ainsi eviter les injections xss et css:
        foreach($params as $indice => $valeur){
            $params[$indice] = htmlspecialchars($valeur);
        }
    }
    global $pdo; // pour acceder à cette variable definie dans l'init sans importer l'init.
    $resultat= $pdo->prepare($requete);
    $succes = $resultat->execute($params); #on execute la requete en lui passant les arguments associés aux marqueurs
    if($succes){
        return $resultat; # Là on affiche le resultat (statement) car ca existe
    } else {
        return FALSE; # si false : good pseudo dispo !
    }
}
?>