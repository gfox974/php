<?php
if (isset($_GET['type'])){
    $details = ['banane' => 'jaune','kiwi' => 'vert','cerise' => 'rouge'];
    echo 'Couleur de '.$_GET['type'].' = '.$details[$_GET['type']].'<br>';
} else {
    echo "<p> No action, ou URL malformée :'( </p>";
}
echo '<a href="./fruits.php">Retour</a>';
/* WIP tests à ma façon
require_once('./classifications.inc.php');
if (isset($_GET['type']) ){
    $banane = new banane();
    $kiwi = new kiwi();
    $cerise = new cerise();
    $banane::printCol();
    $kiwi::printCol();
    $cerise::printCol();
} else {
    echo "<p> No action, ou URL malformée :'( </p>";
}
echo '<a href="./fruits.php">Retour</a>';
*/
?>