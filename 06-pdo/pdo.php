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
//----------------------------------------------------------------------------------
echo '<h2> 1) Connection à la BDD </h2>'; 
//----------------------------------------------------------------------------------

$pdo= new PDO('mysql:host=localhost;dbname=entreprise', # args : 'driver:host;dbname'
            'root', # username
            '', # password
            array( # via l'array, on va passer des options
                PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, # Ici, on active le rapport d'erreurs de seuil de criticité minimum warning
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8' # Là, on passe une commande cli pour caler le charset utilisé en utf8 
            )
);
// $pdo est l'objet qui represente la connection à la bdd entreprise, cet objet est issu de la classe prédéfinie PDO.

//----------------------------------------------------------------------------------
echo '<h2> 2) La methode "exec()" avec INSERT, UPDATE, DELETE </h2>';
//----------------------------------------------------------------------------------

// Exec est une methode d'objet pdo permettant d'executer des requetes-actions, pour l'exemple nous allons enregistrer un nouvel employé :
$resultat = $pdo->exec("INSERT INTO employes (prenom, nom, sexe, service, date_embauche, salaire) values ('test','test','m','test','2016-02-08',2000)");
# En cas de succes exec retourne le nombre de row affectés, dans le cas échéant : 1

echo 'Nb de lignes affectées par la requete $resultat : '.$resultat.'<br>';

/* On utilise la methode exec pour les requetes qui ne retournent pas de resultat comme le insert / update / delete etc
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

//----------------------------------------------------------------------------------
echo '<h2> 3) La methode "query()" avec un seul resultat </h2>';
//----------------------------------------------------------------------------------
$resultat= $pdo->query("SELECT * from employes where prenom='daniel';");

debug($resultat);
// On obtient dans $resultat un objet qui vient de la classe prédefinie PDOStatement, a contrario d'exec, query est utilisé pour la formulation de requetes retournant des resultats, comme select par exemple
# On voit bien qu'il s'agit d'un objet PDOStatement, mais on ne voit pas le resultat pour l'employé daniel, il faut donc transformer cet objet sous une forme exploitable directementgrace à la methode fetch()

/* Valeur de retour :
        Succès : retourne un objet PDOStatement
        Echec : etat false
*/

// La methode fetch()
$employe= $resultat->fetch(PDO::FETCH_ASSOC); # Là, on utilise fetch pour transformer l'objet en array associatif ( peut generer un array associatif, numerique, le mix des deux, ou un objet)

debug($employe);
echo 'je suis '.$employe['prenom'].' '.$employe['nom'].', du service '.$employe['service'].'<br>';
# La methode fetch() avec comme parametre PDO::FETCH_ASSOC permet de transformer l'objet $resultat en un tableau associatif dont les données sont exploitables ( -> $employe), l'indexation se fait donc a partir des champs de la requete (pseudo-clé -> valeur)

//-------------------------
// On peut aussi utiliser l'une des trois methodes suivantes :
//
# 1) Obtenir un array numérique 
$resultat= $pdo->query("SELECT * from employes where prenom='daniel';");
$employe= $resultat->fetch(PDO::FETCH_NUM);
debug($employe);
echo $employe['1'].'<br>'; // Retourne donc Daniel
# Oui, l'objet ayant été transformé au prealable, il faut le regenerer.

# 2) Obtenir un array mixte ( melange d'array associatif ET numerique )
$resultat= $pdo->query("SELECT * from employes where prenom='daniel';");
$employe= $resultat->fetch(PDO::FETCH_BOTH);
debug($employe);
echo $employe['1'].'<br>';
echo $employe['prenom'].'<br>';
# On remarque que les deux methodes d'appel fonctionnent

# 3 ) Obtenir un objet
$resultat= $pdo->query("SELECT * from employes where prenom='daniel';");
$employe= $resultat->fetch(PDO::FETCH_OBJ);
debug($employe);
echo $employe->prenom.'<br>'; // Retourne daniel en faisant appel à la proprieté nom de l'objet

/* Exercice :
    - Afficher le service de l'employé dont l'id_employes est 417 (utiliser la methode qui vous parait la plus naturelle)
*/
$resultat= $pdo->query("SELECT * from employes where id_employes=417;");
$employe= $resultat->fetch(PDO::FETCH_OBJ);
echo $employe->prenom.' '.$employe->nom.' est dans le service : '.$employe->service.'<br>';

//----------------------------------------------------------------------------------
echo '<h2> 4) La methode "query()" avec plusieurs resultats </h2>';
//----------------------------------------------------------------------------------
$resultat= $pdo->query("SELECT * from employes;");
echo 'Nbr d\'employes dans la requete :'.$resultat->rowCount().'<br>';
# La methode rowCount() permet de retourner le nombre de lignes retournées par la requete

/// Comme nous avons plusieurs lignes dans le jeu de resultats, nous devons faire une boucle pour les parcourir.
while ($employe=$resultat->fetch(PDO::FETCH_ASSOC)){ # tant que le fetching du pdo est en cours, va chercher la ligne suivante du resultat et transforme la en array associatif ($employe), la boucle permet de faire avancer le curseur interne dans l'objet $resultat - elle s'arrete quand il est arrivé à la fin et que le fetch fini par retourner false
    #debug($employe);
    echo '<div style="border: solid 1px; text-align: center;>'; # On build un seul tableau par tour de boucle, soit : un employé. Ici il est indexé avec le nom des champs de la requete
        echo '<p>'.$employe['prenom'].' '.$employe['nom'].'</p>';
        echo '<p> service: '.$employe['service'].'</p>';
        echo '<p> mensuel: '.$employe['salaire'].'</p>';
    echo '</div><hr>';
}
// Si vous etes certains de n'avoir qu'un seul resultat (par identifiant par exemple), il n'y a pas besoin de faire une boucle. 
// Si la requete retourne potentiellement 0 1 ou plusieurs resultats, on en utilise une pour les traiter.

//----------------------------------------------------------------------------------
echo '<h2> 5) La methode "fetchAll()" </h2>';
//----------------------------------------------------------------------------------
$resultat= $pdo->query("SELECT * from employes;");
$donnees = $resultat->fetchAll(PDO::FETCH_ASSOC); # idem, prends plusieurs methodes, on va choisir l'array associatif.
// retourne toutes les lignes de resultats dans un tableau multidimensionnel : on a un array associatif dans chaque indice, fonctionne aussi avec fetch_num ou fetchAll()
# debug($donnees); # On constate qu'on obtient un array general contenant les resultats (des sous-array associatifs du coup) -> dans ce cas on se passe donc de boucle pour parser, mais on se retrouve avec un array multidimensionnel.
// On parcours ce tableau multidimensionnel avec une boucle foreach pour en afficher le contenu :
foreach ($donnees as $employe){
    #debug($employe);
    echo '<div style="border: solid 1px; text-align: center;>';
        echo '<p>'.$employe['prenom'].' '.$employe['nom'].'</p>';
        echo '<p> service: '.$employe['service'].'</p>';
        echo '<p> mensuel: '.$employe['salaire'].'</p>';
    echo '</div><hr>';
}
# On voit que $employe correspond à 1 sous-array, soit un seul employé. On y trouve à l'interieur tous les champs de la requete en tant qu'indices.

//----------------------------------------------------------------------------------
echo '<h2> 6) Exercices </h2>';
//----------------------------------------------------------------------------------
/* Affichez la liste des differents services dans une seule liste ul avec un service par li */
$data= $pdo->query("select distinct service from employes;");
echo '<ul style="border: 1px solid;"><span style="color:blue;"> Services : </span>';
while ($service= $data->fetch(PDO::FETCH_NUM)){  
        echo '<li>'.$service[0].'</li>';
    }
echo '</ul><hr>';

// correction :
$resultat = $pdo->query('SELECT DISTINCT service FROM employes;');
$donnees = $resultat->fetchAll(PDO::FETCH_ASSOC);
echo '<ul>';
    foreach($donnees as $employe){
        echo '<li>'.$employe['service'].'</li>';
    }
echo '</ul>';
# Alternative au distinct : $resultat=$pdo->query('select service from employes group by 'service'); -> group by peut etre plus rapide que distinct selon le volume a traiter

//----------------------------------------------------------------------------------
echo '<h2> 7) Tables HTML </h2>';
//----------------------------------------------------------------------------------
/* On veut afficher l'ensemble d'un jeu de resultats sous forme de table HTML */
$resultat= $pdo->query("select * from employes;");
echo '<table border=1>';
// Affichage de la ligne d'en-tete :
echo '<tr>';
for ($i=0;$i<$resultat->columnCount();$i++){ # On se sert du nombre de colonnes (champs) du jeu de resultats à la maniere d'un length
    $colonne= $resultat->getColumnMeta($i);
    #debug($colonne);
    echo '<th>'.$colonne['name'].'</th>'; # l'indice name contient le nom du champ
}
echo '</tr>';
// Affichage des lignes du tableau :
while ($ligne= $resultat->fetch(PDO::FETCH_ASSOC)){ # $ligne devient un array associatif correspondant à l'employé
    echo '<tr>';
        foreach ($ligne as $info){ # On parcourt l'array pour afficher toutes les infos de cet employé
            echo '<td>'.$info.'</td>';
        }
    echo '</tr>';
}
echo '</table>';
// Quand la boucle while fait un tour (1 tour = 1 ligne employé), la foreach a l'interieur en fait 7 (vu qu'il y a 7 champs)


//----------------------------------------------------------------------------------
echo '<h2> 8) Requetes préparées et bindParam() </h2>';
//----------------------------------------------------------------------------------
/* Les requetes préparées sont à préconiser si on execute de nombreuses fois la meme requete, ainsi on peut éviter de répeter le cycle complet : analyse -> interpretation -> execution de la requete par le sgbd
Cela permet de faire des gains de performance, aussi, elles sont souvent utilisées pour assainir les données et se prémunir en particulier des injections de type sql.
*/
$nom = 'sennard';
/* Une requete préparée se réalise en trois étapes :
    1 - préparer la requete type */
$resultat= $pdo->prepare('SELECT * from employes where nom= :nom;'); # On définis un marqueur nominatif
#   2 - lier le marqueur à sa valeur
$resultat->bindParam(':nom',$nom);
#   3 - Execution de la requete
$resultat->execute();

# affichage du resultat de la procedure stockée :
$donnees = $resultat->fetch(PDO::FETCH_ASSOC);
debug($donnees);
echo "Je suis : $donnees[prenom] $donnees[nom] du service $donnees[service] <br>";  
// on voit que la requete ayant été executée en amont, on evite de perdre du temps en l'appellant à l'instant T pour affecter le resultat stocké en vars
/* Valeurs en retour :
   - prepare() : renvoie un objet PDOStatement
   - execute() : renvoie true en cas de succes, false en cas d'echec
*/

// On change la valeur de $nom et on réexecute la requete préparée
$nom='durand';
$resultat->execute();
$donnees = $resultat->fetch(PDO::FETCH_ASSOC);
debug($donnees);
# On obtient bien les données de durand sans avoir a refaire la preparation et le bindparam

//----------------------------------------------------------------------------------
echo '<h2> 9) Requetes préparées et bindValue() </h2>';
//----------------------------------------------------------------------------------
#   1 - préparer la requete type
$resultat= $pdo->prepare('SELECT * from employes where nom= :nom;');
#   2 - lier le marqueur à sa valeur
$resultat->bindValue(':nom','le dodo'); # Value prends des valeurs fixes ET des variables, si par contre la valeur de la variable change, il faut en actualiser la valeur en refaisant le bind
#   3 - Execution de la requete
$resultat->execute();
#   4 - fetch et affichage :
$employe = $resultat->fetch(PDO::FETCH_ASSOC);
echo 'Je suis '.$employe['prenom'].' '.$employe['nom'].' du service : '.$employe['service'].'.';

?>