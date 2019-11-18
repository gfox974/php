<?php
require_once 'inc/init.php';
require_once 'inc/header.php';
?>

<ul class="flex flex-col mt-4 -mx-4 pt-4 border-t md:flex-row md:items-center md:mx-0 md:ml-auto md:mt-0 md:pt-0 md:border-0">
        <li>
          <a class="block px-4 py-1 md:p-2 lg:px-4" href="ajout.php" title="Ajout de bien">Ajout de bien</a>
        </li>
        <li>
          <a class="block px-4 py-1 md:p-2 lg:px-4 text-purple-600" href="liste.php" title="Link">Liste des biens</a>
        </li>
      </ul>
    </div>
  </div>
</nav>


<div class="w-2/3 mx-auto">
  <div class="bg-white shadow-md rounded my-6">
    <table class="text-left w-full border-collapse">
    <thead>
        <tr>
          <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Photo</th>
          <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Titre</th>
          <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Description</th>
          <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Type</th>
          <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Prix</th>
        </tr>
    </thead>
    <tbody>
		<?php
        $resultat = $pdo->query('SELECT * FROM logement');
        $donnees = $resultat->fetchAll(PDO::FETCH_ASSOC);
            foreach($donnees as $indice => $bien){
                echo '<tr class="hover:bg-grey-lighter">';
                if (!empty($bien['photo'])) {
                    echo '<td class="inline-block rounded-full bg-gray-300 h-32 line-height-username3">
                    <img class="rounded-full float-left h-full" title="avatar_user" src="thumbnails/logement_'.$bien['id_logement'].'_300x300.jpg"></td>';    
                } else {
                echo '<td class="inline-block rounded-full bg-gray-300 h-32 line-height-username3">
                    <img class="rounded-full float-left h-full" title="avatar_user" src="photos/noimage.png"></td>';
                }
                echo '<td class="py-4 px-6 border-b border-grey-light"><span class="ml-4 text-3xl">'.$bien['titre'].'</td>';
                if (strlen($bien['description']) >= 40) {
                  echo '<td class="py-4 px-6 border-b border-grey-light"><span class="ml-4 ">'.substr($bien['description'], 0, 40).' «...» </td>';
                } else {
                  echo '<td class="py-4 px-6 border-b border-grey-light"><span class="ml-4 ">'.$bien['description'].' </td>';
                }
                echo '<td class="py-4 px-6 border-b border-grey-light"><span class="ml-4 ">'.$bien['type'].'</td>';
                echo '<td class="py-4 px-6 border-b border-grey-light"><span class="ml-4 ">'.$bien['prix'].'€</td></tr>';
            }
        ?>
    </tbody>
    </table>
    </div>
    </div>



<?php
require_once 'inc/footer.php';
?>