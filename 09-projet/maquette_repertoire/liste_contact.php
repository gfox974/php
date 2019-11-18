<?php
/*
	1- Afficher dans une table HTML la liste des contacts avec tous les champs. - done
	2- Le champ photo devra afficher la photo du contact en 80px de large. - done

*/
include_once 'inc/init.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.1.2/tailwind.min.css'/>

	   <!-- Lien vers le cdn bootstrap -->
	   <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" integrity="sha384-xrRywqdh3PHs8keKZN+8zzc5TX0GRTLCcmivcbNJWm2rs5C8PRhcEn3czEjhAO9o" crossorigin="anonymous"></script>
	<title>Repertoire</title>
    <style>
.line-height-username1 {
	line-height: 3.75rem;
}
  
.line-height-username2 {
	line-height: 5.5rem;
}
  
.line-height-username3 {
	line-height: 3.25rem;
}
</style>
</head>
<body>

<h1 class="mt-4">Répertoire</h1>

<ul class="nav nav-tabs">
    <li><a class="nav-link active" href="liste_contact.php"> Liste des contacts </a></li>
    <li><a class="nav-link" href="ajout_contact.php"> Ajouter un contact </a></li>
</ul>

<?php
$resultat = $pdo->query('SELECT * FROM contact');
    $donnees = $resultat->fetchAll(PDO::FETCH_ASSOC);
    echo '<ul>';
        foreach($donnees as $contact){
            //echo '<li style="list-style-type: none;"><button style="width: 300px;"><img src="'.$contact['photo'].'" style="height:80px;width:80px;"><br>'.$contact['nom'].' '.$contact['prenom'].'<br>'.$contact['telephone'].'<br>'.$contact['email'].'<br>'.$contact['type_contact'].'<br></button></li>';
            // test tw
            echo '<li style="list-style-type: none;"><div class="inline-block rounded-full bg-gray-300 h-32 pr-8 line-height-username3">
                    <img class="rounded-full float-left h-full" title="avatar_user" src="'.$contact['photo'].'" alt="minis/thumbnail_'.$contact['id_contact'].'.jpg"> 
                    <span class="ml-4 text-3xl">'.$contact['prenom'].' '.$contact['nom'].'<br>'.$contact['telephone'].'</span></div></li><br>';
        }
    echo '</ul>';
?>
</body>
</html>