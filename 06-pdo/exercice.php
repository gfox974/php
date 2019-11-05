<?php
/* Exercice :
En deux temps,
    1- Afficher les noms, prénoms, et salaires des commerciaux dans un ul / li, avec un commercial par li (en utilisant les requetes préparées)
    2- Afficher le nombre total de commerciaux
*/
function debug($param){
    echo '<pre>';
        var_dump($param);
    echo '</pre>';
}

if (isset($_GET['service'])){
    $service = $_GET['service'];
} else {
    echo '<p style="border:1px solid; color:red;"> selectionner un service </p>';
}

$pdo= new PDO('mysql:host=localhost;dbname=entreprise', 
            'root',
            '', 
            array( 
                PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
            )
);

if (isset($service)){
    $resultat= $pdo->prepare('SELECT nom,prenom,salaire from employes where service= :service;'); 
    $resultat->bindParam(':service',$service);
    $resultat->execute();
    echo '<ul>';
    while ($donnees = $resultat->fetchAll(PDO::FETCH_ASSOC)){ 
        foreach($donnees as $employe){
            echo "<li> $employe[nom] $employe[prenom] $employe[salaire]€ </li>";
        }
    }
    echo '<li> Total service: '.$resultat->rowCount().'</li>';
    echo '</ul><hr>';
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Exercice</title>
</head>
<body style="text-align:center;">
    <h1>Exercice PDO</h1>
    <h2>Services enregistrés : </h2>
    <?php
    // Build de la liste de services
    // init du timer
    $start = microtime(TRUE);
    for ($a = 0; $a < 10000000; $a++)
    {
        $b = $a*$a;
    }
    # fonction a chrono
    $resultat = $pdo->query('SELECT DISTINCT service FROM employes;'); # Bonus : on pourrait build un array et verifier si le service passé en get y est avant de set
    $donnees = $resultat->fetchAll(PDO::FETCH_ASSOC);
    echo '<ul>';
        foreach($donnees as $employe){
            echo '<li style="list-style-type: none;"><button style="width: 300px;"><a href="?service='.$employe['service'].'">'.$employe['service'].'</a></button></li>';
        }
    echo '</ul>';
    # end func
    // cut du timer
    $end = microtime(TRUE);
    echo 'Liste generée en '.round(($end - $start),2).' secondes.';
    ?>
</body>
</html>