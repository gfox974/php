<?php
function debug($param){
    echo '<pre>';
        var_dump($param);
    echo '</pre>';
}

# Fonctions d'appels de requetes préparées 
function execute_Requete($requete, $params = array()){ # Là en guise de parametres par defaut on lui colle un array vide, le second argument est donc optionnel pour preparer la requete
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

function imageResize($imageSource,$width,$height) {
    $thumbWidth = $width/2;
    $thumbHeight =$height/2;
    $thumb=imagecreatetruecolor($thumbWidth,$thumbHeight);
    imagecopyresampled($thumb,$imageSource,0,0,0,0,$thumbWidth,$thumbHeight, $width,$height);
    return $thumb;
}
?>