<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Lien vers le cdn bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" integrity="sha384-xrRywqdh3PHs8keKZN+8zzc5TX0GRTLCcmivcbNJWm2rs5C8PRhcEn3czEjhAO9o" crossorigin="anonymous"></script>
    <title>Ma boutique</title>
</head>
<body>
    <!-- Partie nav -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <!-- marque -->
            <a class="navbar-brand" href="<?php echo RACINE_SITE; ?>index.php">
            MA BOUTIQUE</a>
            <!-- le menu -->
            <div class="collapse navbar-collapse" id="nav1">
                <ul class="navbar-nav ml-auto">
                    <?php
                    echo '<li><a class="nav-link" href="'.RACINE_SITE.'index.php">Boutique</a></li>';
                    if (estConnecte()){ # menu du membre connecté
                        echo '<li><a class="nav-link" href="'.RACINE_SITE.'profil.php">Profil</a></li>';
                        echo '<li><a class="nav-link" href="'.RACINE_SITE.'connection.php?action=deconnection">Se deconnecter</a></li>';
                        if (estAdmin()){ # fonctionalités admin - acces backoffice
                            echo '<li><a class="nav-link" href="'.RACINE_SITE.'admin/gestion_boutique.php">Gestion de la boutique</a></li>';
                        }
                    } else { # menu du membre non-connecté
                        echo '<li><a class="nav-link" href="'.RACINE_SITE.'inscription.php">Inscription</a></li>';
                        echo '<li><a class="nav-link" href="'.RACINE_SITE.'connection.php?action=connection">Se connecter</a></li>';
                    }
                    ?>
                </ul>
            </div> <!-- end menu -->
        </div> <!-- end container -->
    </nav>
    <!-- Ouverture du contenu de la page index, fermetures dans le footer -->
    <div class="container" style="min-height:80vh;">
        <div class="rox">
            <div class="col-12">