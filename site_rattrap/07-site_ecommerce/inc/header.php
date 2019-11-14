<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Site e-commerce</title>

    <!-- lien vers le CDN TWITER BOOTSTRAP -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</head>

<body>

    <!-- navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <!-- marque -->
            <a class="navbar-brand" href="<?php echo RACINE_SITE; ?>index.php" >Ma boutique</a>
                

            <!-- Le menu -->
            <div class="collapse navbar-collapse" id="nav1">
                <ul class="navbar-nav ml-auto">
                <?php 
                echo '<li><a class="nav-link" href="'. RACINE_SITE .'index.php" >Boutique</a></li>';

                if(est_connecte()){ // Menu du membre connecté
                    echo '<li><a class="nav-link" href="'. RACINE_SITE .'profil.php" >Profil</a></li>';
                    echo '<li><a class="nav-link" href="'. RACINE_SITE .'connexion.php?action=deconnexion">Se deconnecter</a></li>';
                } else { // Menu du membre non connecté
                    echo '<li><a class="nav-link" href="'. RACINE_SITE .'inscription.php" >Inscription</a></li>';
                    echo '<li><a class="nav-link" href="'. RACINE_SITE .'connexion.php" >Connexion</a></li>';
                }

                if (est_admin()) { // Menu de l'admin
                    echo '<li><a class="nav-link" href="'. RACINE_SITE .'admin/gestion_boutique.php">Gestion de la boutique</a></li>';
                    echo '<li><a class="nav-link" href="'. RACINE_SITE .'admin/gestion_membre.php">Gestion des membres</a></li>';
                }
                ?>
                </ul>
             </div> <!--fin menu -->
         </div> <!-- fin container -->
    </nav>

<!-- ouverture du contenu de la page -->
<div class="container" style="min-height: 80vh;">
    <div class="row">
        <div class="col-12">

      