<?php
/* Exercice : 
    - Créer un formulaire dans cette page avec les champs : ville, code postal, ainsi qu'un textarea pour l'adresse
    - Afficher les données saisies par l'internaute dans la page formulaire2-traitement
*/
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Formulaire 2</title>
</head>
<body>
    <h1>Formulaire 2</h1>
    <form method ="post" action="./formulaire2-traitement.php">
        <label for="ville">Ville</label>
        <input type="text" name="ville" id="ville">

        <label for="code_postal">Code postal</label>
        <input type="text" name="code_postal" id="code_postal">

        <br>
        <label for="adresse">Adresse</label>
        <textarea name="adresse" id="adresse" cols="20" rows="1"></textarea>

        <br>
        <input type="submit" name="validation" value="Envoyer">
    </form>
</body>
</html>