<?php
//--------------------------------------
// la superglobale $_COOKIE
//--------------------------------------

/* Un cookie est un petit fichier (4ko max actuellement) déposé par le serveur coté client, (path et normes selon les navigateurs) qui peut contenir des informations diverses et variées.
les cookies sont automatiquement envoyés au serveur par le navigateur lorsque l'internaute navigue dans les pages concernées par les cookies.
php permet de recuperer facilement les données contenues dans ces derniers, ses informations sont stockées dans la superglobale $_COOKIE.
*/
# ne jamais mettre d'informations sensibles (dans le sens cruciales secu / fonctionnement ) dedans , failles xss tout ca ..

/* Mise en application :
    - Nous allons stocker la langue selectionnée dans un cookie afin de l'afficher dans cette derniere à chaque visite
*/
print_r($_GET); # debug: print de controle

/* Reflexion gestion de $langue :
    - J'ai cliqué sur un lien, je me retrouve ici -> j'ai un cookie ou pas ?
        - Si oui, restitution de la valeur presente dans le cookie
        - Si non, set une langue par defaut, choix de la langue, creation du cookie
*/
// affectation d'une valeur à la variable $langue pour determiner la langue a afficher :
if (isset($_GET['langue'])){ # si l'indice langue du get est set, c'est qu'on a cliqué sur un choix
    $langue= $_GET['langue'];
} elseif (isset($_COOKIE['langue'])){ # On entre dans le elsif que si on a le cookie 'langue'
    $langue= $_COOKIE['langue'];
} else {
    $langue= 'en'; # Si ni l'un ni l'autre -> parametre par defaut
}

// Maintenant qu'on a verifié, dans tous les cas on envoie le cookie ( Trois infos : Nom du cookie, valeur de langue, date d'expiration ) :
echo time(); # Visu du timestamp actuel format epoch (secondes ecoulées depuis 01/01/1970)
$un_an= time() + 365*24*60*60; # là on calcule le timestamp de dans un an : actuel + j * h * m * s

setcookie('langue',$langue,$un_an); # Là on crée le cookie : nom du cookie, valeur, date d'expiration

?>

<!DOCTYPE html>
<?php echo '<html lang="'.$langue.'">'; # Ici on change de façon dynamique l'attribut langue du html selon la variable ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cookie</title>
</head>
<body>
    <h1>Votre langue</h1> <!-- Ici, on va recuperer le choix de langue par un get -->
    <ul>
        <li><a href="?langue=fr">Français</a></li>
        <li><a href="?langue=en">English</a></li>
        <li><a href="?langue=es">Español</a></li>
        <li><a href="?langue=it">Italiano</a></li>
    </ul>
    
</body>
</html>