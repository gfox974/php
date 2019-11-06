<?php
//-----------------------------
// cas pratique : un formulaire pour poster des commentaires
//-----------------------------

// Objectif : securiser la requete sql dont les données viennent de l'internaute

/* modelisation des la bdd :
bdd : dialogue
table : commentaire
colonnes :
    id_commentaires : int pk ai, 
    pseudo : varchar(20)
    message: text
    date_enregistrement: DATETIME
*/

// 2. connection à la bdd / traitement du post
$pdo= new PDO('mysql:host=localhost;dbname=dialogue',
            'root',
            '',
            array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8' 
            )
);

if (!empty($_POST)){ # Si le formulaire a été envoyé
    // ici code a venir, on va faire degueulasse pour justement que le code ne soit pas protegé contre les injections ( et qui ne prends pas non plus les ' )

    // Nous faisons une injection de type JS : (gentille, juste pour faire chier)
    # <script>while (true){alert('coucou !');}</script>
    // La balise etant interpretée en html, quand le message en bdd est affiché le js est executé par le browser de l'utilisateur -> il faut virer le message de la bdd.
    # il faut assainir en amont les données envoyées pour qu'on ne puisse pas envoyer de langage interpretables en bdd par le browser (balises script, css etc)
    // Comment s'en prémunir :
    $_POST['pseudo'] = htmlspecialchars($_POST['pseudo']);
    $_POST['message'] = htmlspecialchars($_POST['message']);
    // cette fonction transforme l'encodage des balises ( < devient &lt, > devient &gt en bdd ) html en entités html -> elles sont affichables mais ne sont plus executées par les navigateurs

    # Injection SQL basique :
    # CACA, ne pas utiliser ! - $resultat= $pdo->query("INSERT INTO commentaire (pseudo, date_enregistrement, message) VALUES ('$_POST[pseudo]',NOW(),'$_POST[message]')");
    // La secure :
    $resultat = $pdo->prepare('INSERT INTO commentaire (pseudo, date_enregistrement, message) VALUES (:pseudo, NOW(), :message)');
    $resultat->execute(array(':pseudo' => $_POST['pseudo'], ':message' => $_POST['message']));

    // Pourquoi ca protege ?
    // le fait de mettre des marqueurs vides dans la requete permet d'eviter que notre requete et celle qui est injectée se concatenent : la requete injectée ne peut donc plus s'executer immédiatement.
    // De plus, en liant les marqueurs à leur valeur, pdo transforme leur contenu en chaine de caracteres brut, donc inoffensives.
    // Ainsi, le sgbd reçoit des string bruts qui ne sont plus des morceaux de code à executer.
    # ( ne protege pas via l'url / cookies et autres)

} # fin du if

// code à injecter :
// Nous allons faire l'injection suivante dans le champ message :
// ');DELETE FROM commentaire; #
// la table est vidée car on pete l'instruction du query pour executer autre chose :
# Visu :
# $niqueTaTable = $pdo->query("INSERT INTO commentaire (pseudo, date_enregistrement, message) VALUES ('$_POST[pseudo]',NOW(),');DELETE FROM commentaire; #)");

// Pour se premunir de ce genre d'injections, on va utiliser une requete préparée :

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dialogue</title>
</head>
<body>
 <!-- 1. Formulaire  -->
 <h1>Ecrire un commentaire</h1>
 <form method="post" action="">
     <label for="pseudo">pseudo</label>
     <input type="text" name="pseudo" id="pseudo" value="<?php echo $_POST['pseudo'] ?? ''; ?>"> <!-- Si pseudo existe, sinon vide -->
     <br>
     <label for="message">message</label>
     <textarea type="textarea" name="message" id="message"><?php echo $_POST['message'] ?? ''; ?></textarea>

     <input type="submit" name="envoi" value="envoyer">
 </form>  

 <?php 
// 3. Affichage des commentaires
$resultat = $pdo->query('SELECT * FROM commentaire ORDER BY date_enregistrement DESC;');
echo '<h2>'.$resultat->rowCount().' commentaires </h2>';
while ($commentaire = $resultat->fetch(PDO::FETCH_ASSOC)) {
    #echo '<pre>';
        #print_r($commentaire);
    #echo '</pre>';
        echo '<div style="border: solid 1px; height:50px; text-align:center; width:300px;">'.$commentaire['message'].'</div>';
        echo '<div> Par '.$commentaire['pseudo'].' le '.$commentaire['date_enregistrement'].'</div><br>';
}
 ?>

</body>
</html>