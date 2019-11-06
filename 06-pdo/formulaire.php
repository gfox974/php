<?php
//----------------------------
//  Validation de formulaires
//----------------------------
/* Exercice :
    - Créer un formulaire pour saisir un nouvel employé en base de données (bdd entreprise):
        1) création du formulaire en html - tous les champs sont de type texte, sauf le champ sexe qui est de type "radio"
        2) connection à la bdd entreprise
        3) lorsque le formulaire est envoyé, insertion des données en bdd avec une requete préparée
        4) faire en sorte que les données saisies dans le formulaire ne s'effacent pas ( operateur ?? )
*/
function debug($param){
    echo '<pre>';
        var_dump($param);
    echo '</pre>';
}
# GO
#debug($_POST);
$pdo= new PDO('mysql:host=localhost;dbname=entreprise', 
            'root',
            '', 
            array( 
                PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
            )
);

if (!empty($_POST)){
    foreach ($_POST as $idx => $val){
        $_POST[$idx] = htmlspecialchars($_POST[$idx]);
    }
    $resultat = $pdo->prepare('INSERT INTO employes (nom, prenom, sexe, salaire, service, date_embauche) VALUES (:nom, :prenom, :sexe, :salaire, :service, NOW())');
    $resultat->execute(array(':nom' => $_POST['nom'], ':prenom' => $_POST['prenom'], ':sexe' => $_POST['sexe'], ':salaire' => $_POST['salaire'], ':service' => $_POST['service']));
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Formulaire</title>
</head>
<body>
  <h1>Gestion des employés</h1>
  <br>
  <h2>Employés actuels :</h2>
  <?php
    $listing = $pdo->query('SELECT * FROM employes;');
    $liste = $listing->fetchAll(PDO::FETCH_ASSOC);
    echo '<ul style="border 2px solid; border-radius:4px;>';
        foreach($liste as $employe){
            if ($employe['sexe'] == 'f'){
                $prefixe= "Mme.";
            } else {
                $prefixe= "Mr.";
            }
            echo '<li style="list-style-type: none;"><button style="width: 300px;">'.$prefixe.' '.$employe['nom'].' '.$employe['prenom'].' : '.$employe['service'];
        }
    echo '</ul>';
  ?>
  <br><hr>
  <h2>Enregistrer un nouvel employé :</h2>
  <br>
  <form method="post" action="">
    <div>
        <label for="nom">Nom</label>
        <input type="text" name="nom" id="nom" value="<?php echo $_POST['nom'] ?? ''; ?>" required>
    </div>
    <br>
    <div>
        <label for="prenom">Prénom</label>
        <input type="text" name="prenom" id="prenom" value="<?php echo $_POST['prenom'] ?? ''; ?>" required>
    </div>
    <br>
    <div>
        <p>Genre :</p>
        <div>
            <label for="sexe">Masculin</label>
            <input type="radio" id="sexe" name="sexe" value="<?php echo $_POST['sexe'] ?? 'm'; ?>" checked >
            <label for="sexe">Féminin</label>
            <input type="radio" id="sexe" name="sexe" value="<?php echo $_POST['sexe'] ?? 'f'; ?>">
        </div>
    </div>
    <div>
        <label for="salaire">Salaire mensuel</label>
        <input type="number" name="salaire" id="salaire" value="<?php echo $_POST['salaire'] ?? ''; ?>" required>
    </div>
    <div>
        <label for="service">Service</label>
        <input type="text" name="service" id="service" value="<?php echo $_POST['service'] ?? ''; ?>" required>
    </div>
    <br>

    <input type="submit" name="envoi" value="envoyer">
 </form>
</body>
</html>