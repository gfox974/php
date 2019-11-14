<?php 

require_once 'inc/init.php';

$suggestion =''; // Pour afficher les suggestions de produits (exercise)






// 1- Controle de l'existence du produit demande :
if(isset($_GET['id_produit'])) { // Si le detail d'un produit est demandé
    $resultat=execute_requete("SELECT * FROM produit WHERE id_produit = :id_produit",array('id_produit' => $_GET['id_produit'])); // on met un marqueur dans la requetes quand la variable contient des données qui proviennent de l'internaute ($_GET, $_POST, $_COOKIE, $_FILES...)

    if ($resultat->rowCount() == 0) { // Si le SELECT ne retourne pas de ligne c'est que le produit n',existe pas ou plus.
        header('location:index.php'); // on redirige alors l'internaute vers la boutique
        exit();
    }
    
} else { // Si l'interanute accede directement a la page ou que l'URL est alteré
    header("location:index.php");
	exit();
}

// 2- Preparation des données du produit selectionné :

$produit = $resultat->fetch(PDO::FETCH_ASSOC); // Pas de boucle car on est certain de n'avoir qu'un seul produit par identifiant.

extract($produit); // crée des variable au nom des indices avec dedans la valeur correspondante
        
// Exercise "suggestion de produits" :
// Afficher 2 produits aleatoirement appartenant a la categorie du produit affiiché. Ces produits doivent etre differents du produit actuelement  affiché

$aleatoire=execute_requete("SELECT id_produit, categorie, titre, photo, prix FROM produit WHERE categorie = '$categorie' AND id_produit <> $id_produit ORDER BY RAND() LIMIT 2");
while ($aleatoire_1 = $aleatoire->fetch(PDO::FETCH_ASSOC)){


    $suggestion .= '<div class="col-sm-3 mb-2">';
    $suggestion .= '<div class= "card">';
    $suggestion .= '<a href="fiche_produit.php?id_produit='.$aleatoire_1['id_produit'].'">
                                    <img src ="'.$aleatoire_1["photo"].'" alt="'.$aleatoire_1["titre"].'" title="'.$aleatoire_1["titre"].'" class="card-img-top img-fluid">
                                </a>';
                             
        $suggestion .= '<h2>'. $aleatoire_1['titre'].' </h2>';
        $suggestion .= '<h2>'. number_format($aleatoire_1['prix'],2, ',', ' ' ).' €</h2>'; // fonction qui formate le prix : nombre de decimale, separateur des decimales, seperateur des milier

        $suggestion .='</div>';
        $suggestion .='</div>';
    


}








// Affichage :
require_once 'inc/header.php';
?>
    <div class="row">

        <div class="col-12">
            <h1><?php echo ucfirst($titre);?></h1>
        </div>

        <div class="col-md-8">
            <img src="<?php echo $photo;?>" alt="<?php echo $titre;?>" title ="<?php echo $titre;?>" class="img-fluid">
        </div>

        <div class="col-md-4">
            <h2>Description</h2>
            <p><?php echo $description;?></p>

            <h3>Details</h3>
        <ul>
            <li>Categorie: <?php echo $categorie;?></li>
            <li>couleur: <?php echo $couleur;?></li>
            <li>taille: <?php echo $taille;?></li>
        </ul>

        <h4>Prix : <?php echo number_format($prix,2, ',', ' ');?>€</h4>

       
            <div class="mt-2">
            <a class="btn btn-dark" href="index.php?categorie=<?php echo $categorie?>" role="button">Retour vers la categorie <?php echo $categorie;?></a> 
            </div>

            <div class="mt-2">
            <a class="btn btn-dark" href="index.php">Retour vers la boutique</a>
            </div>
</div> 
</div>  
       <!-- Exercise -->
       <hr>
<div class="row">
    <div class="col-12">
        <h3>Suggestion de produits</h3>
    </div>
    <?php echo $suggestion; ?>
</div>      
 



<!-- exercise crée un liens qui fasse un reetour dans la categorie actuel -->


<?php
require_once 'inc/footer.php';
?>

