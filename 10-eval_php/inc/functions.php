<?php
function debug($param){
    echo '<pre>';
        var_dump($param);
    echo '</pre>';
}

function execute_Requete($requete, $params = array()){
    if (!empty($params)){
        foreach($params as $indice => $valeur){
            $params[$indice] = htmlspecialchars($valeur);
        }
    }
    global $pdo;
    $resultat= $pdo->prepare($requete);
    $succes = $resultat->execute($params);
    if($succes){
        return $resultat;
    } else {
        return FALSE;
    }
}

function imageResize($imageSource,$width,$height) {
    $thumbWidth = 300;
    $thumbHeight = 300;
    $thumb=imagecreatetruecolor($thumbWidth,$thumbHeight);
    imagecopyresampled($thumb,$imageSource,0,0,0,0,$thumbWidth,$thumbHeight, $width,$height);
    return $thumb;
}
?>