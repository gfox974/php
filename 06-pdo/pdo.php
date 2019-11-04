<?php
//----------------------------------
//               PDO
//----------------------------------

function debug($param){
    echo '<pre>';
        var_dump($param);
    echo '</pre>';
}

/* PDO = Php Data Objects

L'extension php data objects definit une interface pour acceder a une base de données depuis le langage php, et permet d'y executer des requetes sql

*/
echo '<h2> 1) Connection à la BDD </h2>'; 
$pdo= new PDO('mysql:host=localhost;dbname=entreprise', # args : 'driver:host;dbname'
            'root', # username
            '', # password
            array( # via l'array, on va passer des options
                PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, # Ici, on active le rapport d'erreurs de seuil de criticité minimum warning
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8' # Là, on passe une commande cli pour caler le charset utilisé en utf8 
            )
);
// $pdo est l'objet qui represente la connection à la bdd entreprise, cet objet est issu de la classe prédéfinie PDO.

echo '<h2> 2) La methode "exec()" avec INSERT, UPDATE, DELETE </h2>';
// Exec est une methode d'objet pdo permettant d'executer des requetes-actions, pour l'exemple nous allons enregistrer un nouvel employé :
$resultat = $pdo->exec("INSERT INTO employes (prenom, nom, sexe, service, date_embauche, salaire) values ('test','test','m','test','2016-02-08',2000)");
# En cas de succes exec retourne le nombre de row affectés, dans le cas échéant : 1

echo 'Nb de lignes affectées par la requete $resultat : '.$resultat.'<br>';

/* On utilise la methode exec pour les requetes qui ne retournent pas de resultat comme le select / insert / update / delete
    Valeurs de retour :
        succes : renvoie le nombre de lignes affectées
        echec : renvoie false
*/

echo 'dernier id généré en bdd : '.$pdo->lastInsertId().'<br>'; # On va utiliser la methode lastinsertid pour recuperer l'id du dernier insert

/* Exercice : 
Supprimer tous les enregistrements de la table employes dont le prenom est test depuis PHP.
*/

$deletethis= $pdo->exec("DELETE FROM employes where prenom='test';");
echo 'Nb de lignes affectées par la requete $deletethis : '.$deletethis.'<br>';
?>