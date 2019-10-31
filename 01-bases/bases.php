<style>
    h2 {
        border-top: 1px solid black;
        border-bottom: 1px solid black;
        color: grey;
    }
    table, tr, td {
        border: solid 1px;
    }
</style>

<!-- Ici, on commence le bloc en php : -->
<?php
// c'est parti.
echo '<h2>les balises PHP</h2>';
# Done
/* Y'a plein de methodes de com,
c'est genial. */
?>
<br><hr>
<p>Ici, je suis en HTML</p>
<br>
<?php
echo '<h2>Affichage</h2>';
print 'Bonjour !<br><hr>';
# Comme constaté, on peut passer des balises html dans les strings, elles seront interpretées par le browser

# instructions destinées au debug
print_r("Coucou, je suis du debug <br>");
var_dump("Moi aussi"); # donne le type du contenu et sa longueur
?>

<?php
echo '<h2>Variables</h2>';
$name = "Toto";
echo " Name : $name";
$a = 127;
$b = 2;
$c = 1.5; #type double ( = float)
echo gettype($a);
echo "$a x $b = ".($a * $b);
?>

<?php
# concatenation en php 
$x = 'Hello';
$y = 'World';
echo $x."<br>".$y."<br>";
# Concatenation lors de l'affectation avec l'operateur combiné .=
$prenom="nicolas";
$prenom .= "-marie";
echo $prenom;
?>

<?php
echo '<h2> Guillemets et quotes </h2>';
$message="Aujourd'hui";
$message='Aujourd\'hui'; # on doit caler un caractere d'echappement pour proteger l'utilisation du meme caractere que le delimiteur

$txt='Bonjour';
echo "$txt tout le monde"; # En simple quote, le contenu est traité comme une chaine de caractere, avec des double les variables sont interpretées
?>

<?php
echo '<h2> Les constantes magiques </h2>';
# une constante permet de conserver une valeur, contrairement à une variable une fois definie celle-ci ne peut pas changer
# Utile pour conserver de facon certaine des definitions telles que les parametres de connection en bdd
# En php on peut les declarer de deux façons :
define('CAPITALE_FRANCE','Paris');
echo CAPITALE_FRANCE . '<br>';
# Methode introduite depuis php 5.3 :
const TAUX = 6.55957;
echo TAUX . '<br>';

// Quelques constantes magiques ( constantes predefinies )
echo __DIR__  .'<br>'; # Affiche le path complet vers le dossier 
echo __FILE__  .'<br>'; # Affiche le path complet vers le fichier
echo __LINE__  .'<br>'; # Affiche le numero de ligne du script
?>

<!-- Exercices -->
<!-- Afficher : bleu-blanc-rouge en mettant le texte de chaque couleur dans une variable -->
<?php
$values = ['bleu','-','blanc','-','rouge'] ; $conc = "";
foreach( $values as $colors ){
    $conc .=  $colors;
}
echo $conc ."<br>";

# correction :
$color1 = "bleu";
$color2 = "blanc";
$color3 = "rouge";
echo $color1."-".$color2."-".$color3;

?>

<?php
echo '<hr><h2> Operateurs arithmetiques </h2><br>';
$a = 10;
$b = 2;

echo $a + $b ."<br>";
echo $a - $b ."<br>";
echo $a * $b ."<br>";
echo $a / $b ."<br>";
echo $a % $b ."<br>";

echo '<hr><h3> Operateurs arithmetiques combinés </h3><br>';
echo ($a += $b)."<br>"; # soit a= valeur de a + <- valeur de b = 12
echo ($a -= $b)."<br>"; # soit a= valeur de a - <- valeur de b = 10
echo ($a *= $b)."<br>"; # soit a= valeur de a x <- valeur de b = 20
echo ($a /= $b)."<br>"; # soit a= valeur de a / <- valeur de b = 10
echo ($a %= $b)."<br>"; # soit a= valeur de a module <- valeur de b = 0

echo '<hr><h3> Incrementation / Decrementation </h3><br>';
$i = 0;
$i++;
echo $i;

$j = 10;
$j--;
echo $j;
?>

<?php
echo '<hr><h2> Structures de controles | Opérateurs de comparaison </h2><br>';
$a = 10; $b = 5; $c = 2;
if ($a > $b){
    echo "$a est superieur a $b<br>";
} else {
    echo "$a n'est pas superieur a $b<br>";
}
# Operateur AND
if ($a > $b && $b > $c){
    echo 'and OK';
} else {
    echo 'and NOK';
}
# Operateur OR
if ($a == 9 || $b > $c){
    echo 'or OK';
} else {
    echo 'or NOK';
}
# else if
if ($a == 8) {
    echo 'reponse 1 : a = 8';
} elseif ($a != 10){
    echo 'reponse 2 : a n\'est pas 10';
} else {
    echo 'reponse 3 : Les deux autres conditions n\'ont pas match';
}
# Operateur XOR ( "ou" exclusif )
# Exemple d'un questionnaire etes vous majeur ? oui | non, avez-vous voté dernierement ? oui | non, on souhaite soumettre les reponses à des conditions de cohérence
$question1 = 'mineur'; $question2 = 'a voté';
if ($question1 == 'mineur' XOR $question2 == 'a voté') {
    # Dans ce cas, l'un des deux criteres n'est pas rempli, donc coherence good
    echo 'xor OK';
} else {
    # Si les deux criteres sont vrai, on passe dans le else
    echo 'xor NOK';
}

?>

<?php
echo '<hr><h2> Formes ternaires </h2><br>';
$a = 10;
# si (Condition) vrai ? alors execute ca : sinon ca 
echo ($a == 10) ? '$a est egal a 10' : '$a different de 10';
# Les conditions ternaires sont construites pour etre verifiées en fin de chaine apres une instruction / affectation de variable, etc

echo '<hr><h2> Comparaisons en "==" et "===" </h2><br>';
$varA = 1;
$varB = '1';
if ($varA == $varB) { # Ici on se limite a comparer la valeur
    echo 'varA == varB';
} 
elseif ($varA === $varB) { # Là on fait une comparaison stricte sur la valeur et son type, ne matchera pas car on compare un int et un str
    echo 'varA === varB';
} else {
    echo 'varA not === varB';
}

// Operateurs isset() et empty()
$varTest="toto";
#$var=1;
#$var1='toto';
$var2='titi';

echo(empty($varTest)) ? 'varTest est déclaré mais vide':"varTest est affecté et vaut $varTest";
echo(isset($var))?'var est déclarée et non-nulle':'var n\'est pas definie ou est vide';

if (empty($var1)) echo 'match car $var1 est vide, 0, NULL, FALSE ou non defini<br>';
if (isset($var2)) echo 'match car $var2 existe et est non-null<br>';

// Operateur not ( ! )
$var3 = 'quelque chose';
if (!empty($var3)) {
    echo '$var3 est n\'est pas vide et vaut: '.$var3;
}

//phpinfo(); -> print de la version et de toutes les features installées

// exo : afficher une valeur a condition qu'elle existe, avec l'operateur "null coalescent" ( s'ecrit "??" )
#$maVar = "she's aliiiiiive";
echo $maVar ?? 'valeur par defaut'; # affiche la valeur si elle existe, sinon message default. Pourrait par exemple etre utilisé pour laisser les valeurs saisies par un internaute dans un formulaire

?>

<?php
echo '<hr><h2> Conditions switch </h2><br>';
// le switch est une autre methode pour ecrire une condition if / elseif / else lorsqu'on veut comparer des valeurs multiples
$langue = 'Espagnol';
switch ($langue) { # Contrairement a js, php ne teste ici que la valeur, js compare la valeur et le typage
    case 'Francais':
        echo 'Bonjour !';
    break;
    case 'Chinois':
        echo 'Ni hao !';
    break;
    case 'Italien':
        echo 'Buongiorno !';
    break;
    case 'Espagnol':
        echo '¡ Hola !';
    break;
    case 'Allemand':
        echo 'Gutentag !';
    break;
    default:
        echo 'Hello !';
    break;
}
// exo : réecrire le switch precedent sous forme de ifs classiques pour obtenir le meme resultat
if (!empty($langue)) {
    if ($langue == 'Français') {
        echo 'Bonjour !';
    } else if ($langue == 'Chinois') {
        echo 'Ni hao !';
    }
    else {
        echo 'Hello';
    }
}
// autre vite fait pour le fun
$dicLang = array("Francais"=>"Bonjour","Chinois"=>"Ni hao","Allemand"=>"Gutentag"); $whichlang = "Chinois"; echo $dicLang[$whichlang];
// correction :
if ($langue == 'Francais') {
    echo 'Bonjour !';
} elseif ($langue == 'Italien') {
    echo 'Buongiorno !';
} elseif ($langue == 'Espagnol') {
    echo '¡ Hola !';
} else {
    echo 'Hello';
}
?>

<?php
echo '<hr><h2> Fonctions prédéfinies </h2><br>';
// Une fonction predefinie permet de réaliser un traitement spécifique, prédéterminée dans le langage php
# strpos(); - string position
$email1 = 'prenom@domaine.fr';
echo strpos($email1, '@').'<br>'; # retourne 6, car @ est le 7eme carac (mais en l'etat s'arretera a la premiere occurence)
# strlen() - string length
$phrase = 'je suis une phrâse'; # retourne le nombre d'octets d'une chaine ( l'accent du a compte aussi en plus)
echo strlen($phrase).'<br>';
# Pour compter le nombre de caracteres au sens strict, il y a mb_strlen()
# substr() - substitute string
$text = 'je suis un tres, tres, tres long texte';
echo substr($text, 0, 10).'....<a href="">lire la suite</a>'; # coupe une partie de la chaine de caractere entre les positions indiquées, ici entre 0 et 11
# strtolower() - string to lower, strtoupper() - string to upper , trim() - virer les espaces
$message = "      PaRce QuE Cay Notre Proo jeT    ";
echo strtolower($message)."<br>";
echo strtoupper($message)."<br>";
echo '$message avec les espaces : '.strlen($message).'<br>';
echo '$message sans les espaces : '.strlen(trim($message)).'<br>'; # trim ne vire que les espaces en debut et fin de chaine

?>

<?php
echo '<hr><h2> Fonctions utilisateurs </h2><br>';
// Une fonction est un morceau de code encapsulé dans des acolades et portant un nom,
// On appelle la fonction au besoin pour l'executer

// exemple de fonction sans parametres :
function sayHello() {
    echo 'Hello'.'<br><hr>';
}

sayHello();

// Fonction avec parametre et return
function mult($a,$b) {
    return $a * $b;
}
$a = 2; $b = 5;
echo mult($a,$b).'<br>';

// Exercice :
// Enonce  
function exometeo($saison) {
    echo "Nous sommes en $saison".'<br>';
}
// Faire en sorte que l'article "en" change en "au" pour le printemps
function meteo($saison) {
    $article = 'en';
    if ($saison == 'Printemps') {
        $article = 'au';
    }
    // TODO : ternaire pour le fun
    echo "Nous sommes $article $saison<br>";
}

$saisons = ['Printemps','Ete','Automne','Hiver'];
foreach( $saisons as $curSais ){
    meteo($curSais);
}

// Exercice:
// Ecrire une fonction facture essence qui calcule le cout total de votre plein en fonction du nombre de litres et le prix de ce dernier, elle doit retourner une estimation, il doit aussi y avoir une fonction prixliste qui donne le prix du litre
function prixLitre() {
    return 1.5;
}

function factureEssence($nblitres){
    $prixlitre = prixLitre();
    $facture = $nblitres * $prixlitre;
    echo "Votre facture est de $facture € pour $nblitres litres<br>";
}
factureEssence(20);

// autre pour le fun
class essence {
    static $Diesel = '1.5';
    static $Essence = '1.4';

    function affichePrix($typeCarbu){
        echo self::$$typeCarbu; # todo: Interpole ma variable sombre pute ! edit: variable par reference fonctionne, pas utiliser de constantes ..
    }
    function afficheDiesel(){
        echo self::Diesel;
    }
    function afficheEssence(){
        echo self::Essence;
    }
    function estimePlein($litres,$typeCarbu) {
        $estim = $litres * self::$$typeCarbu;
        return $estim;
    }
}

$litres = 10; $type = 'Diesel';
#echo(essence::afficheDiesel()).'<br>';
#echo(essence::afficheEssence()).'<br>';
#echo(essence::affichePrix($type));
echo "votre plein de $litres litres de $type va vous couter ".(essence::estimePlein($litres,$type)).'€.';

// Depuis PHP7 on peut preciser le type des valeurs entrantes dans une fonction :
function identité(string $nom,int $age){ // on peut typer les variables array, bool, string, int, float, etc..
    echo gettype($nom).'<br>';
    echo gettype($age).'<br>';
    return $nom.' a '.$age.' ans<br>';
}
echo identité('gerard',53);
#echo identité('gerard','53'); // Ca marche quand meme, car l'interpreteur n'est pas en mode strict par defaut, alors il convertis la valeur du string en int (parce que la valeur telle qu'elle est transformable)
// Depuis PHP7, on peut typer la valeur de retour que doit sortir la fonction. (obligatoire en mode strict)
function isAdult(int $age) : bool {
    if($age >= 18) {
        return true;
    } else {
        return false;
    }
}

var_dump(isAdult(7)); # retourne false, le return est bien une valeur booléene

?>

<?php
echo '<hr><h2> Espace local / Espace global (scopes) </h2><br>';
// 1) Aller de l'espace local à l'espace global
function jour(){
    $jour = 'Mercredi'; # variable locale, car déclarée dans l'espace memoire de la fonction
    return $jour;
}
#echo $jour; // va se vautrer en undefined, car elle n'existe qu'au sein de la fonction appellée. Il faut la sortir de la fonction avec return. 
echo jour();
// 2) Aller de l'espace global vers l'espace local
$pays = 'France'; # variable globale, car déclarée à l'exterieur de toute fonction
function pays() {
    global $pays; # le mot clé global permet de recuperer une variable globale à l'exterieur de l'espace local
    echo $pays;
}
pays();

?>

<?php
echo '<hr><h2> Les boucles </h2><br>';
echo '<hr><h3> Boucle while </h3><br>';
// les boucles (structures itératives) sont destinées à repeter des lignes de code de facon automatique

// Boucle WHILE
$i = 0; # Valeur de départ, va servir a comptabiliser le nombre de tours
while ($i < 3) { #Tant que i est inferieur a trois, loop
    echo "iteration : $i<br>";
    $i++; # i +1 a chaque tour
}
echo "Il y a eu $i iterations.";
// ne jamais oublier de definir les conditions de sortie d'un while, sinon boucle infinie.

// Exercice :
// A l'aide d'une boucle while, afficher dans un selecteur (menu déroulant) les années depuis 1919 jusqu'a 2019
/* Selecteur :
echo <select>;
    echo <option>1</option>
    echo <option>2</option>
    echo <option>3</option>
    echo <option>etc</option>
echo </select>
*/
$startYear = 1919;
$endYear = 2019;
// TODO pour le fun : des input pour le start / end
function generateMenu($from,$To){
    $whereAmI = $from;
    echo '<br><select>';
    while($whereAmI <= $To){
        echo "<option>$whereAmI</option>";
        $whereAmI++;
    }
    echo '</select>';
}

echo '<br>Choisissez une année :';
generateMenu($startYear,$endYear);

// boucle do while
echo '<hr><h3> Boucle do while </h3><br>';
// attention, le do s'execute avant la boucle, y'a donc une entree gratuite dans le bloc !
// le do fait qu'elle s'execute au moins une fois, PUIS loop tant que la condition de sortie n'est pas remplie
// A comprendre que contrairement au while, la structure signifie : FAIT tant que la CONDITION est vraie
$j = 1;
do {
    echo "<br>J'ai fait $j tour(s) de boucle.<br>";
    $j++;
} while ($j > 10);
/// Dans cet exemple la condition est false, mais on voit que la boucle a quand meme démarré

// boucle for
echo '<hr><h3> Boucle for </h3><br>';
// La boucle for est une autre syntaxe de la boucle while
for ($i=0;$i <= 10;$i++){
    echo "<br>Je suis l'iteration $i de for.<br>";
}

// Exercice :
// Afficher les mois de 1 à 12 dans un menu deroulant avec une boucle for
$Mois = ['Janvier','Fevier','Mars','Avril','Mai','Juin','Juillet','Aout','Septembre','Octobre','Novembre','Decembre'];
$idx = 1;
for ($i=0;$i < sizeof($Mois);$i++){
    echo "Mois $idx : $Mois[$i]<br>";
    $idx++;
}

// Exercice : une boucle qui affiche 0 à 9 sur la meme ligne dans une table html
/* echo <table>
echo <tr>; -- debut d'une ligne
    echo <td> contenu </td> -- une cell (table data)
echo </tr>;
echo </table>
*/
function tableThis($To){
    echo '<br><table>';
    echo '<tr>';
    for ($i=0; $i <= $To; $i++){
        echo "<td style='border: solid 1px'>$i</td>";
    }
    echo '</tr>';
    echo '</table><br>';
}

$num = 9;
#$num = readline("Tableau jusqu'a ?"); fun TODO : caler une input  
tableThis($num);

// Exercice : faites une boucle qui affiche de 0 à 9 sur la meme ligne, repetée sur 10 lignes dans une table html
function tableThisTen($To){
    echo '<br><table>';
    for ($i=0; $i <= 10; $i++){
        echo '<tr>';
        for ($j=0; $j <= $To; $j++){
            echo "<td style='border: solid 1px'>$j</td>";
        }
        echo '</tr>';
    }
    echo '</table><br>';
}

tableThisTen($num);

// la meme en remplissant les valeurs jusqu'a 99
$z=0;
echo '<br><table>';
for ($j=0; $j<10;$j++) {
    echo '<tr>';
    for ($i=0;$i<=9;$i++) {
        echo '<td>'.$z.'</td>';
        $z++;
    }
    echo '</tr>';
}
echo '</table>';

?>

<?php
echo '<hr><h2> Les tableaux (arrays) </h2><br>';
// Un tableau (ou array en anglais) est une variable améliorée dans laquelle on peut stocker une multitude de valeurs, ces valeurs peuvent etre de n'importe quel type et possedent un indice (index) dont la numerotation commence à 0
// declaration d'un tableau, 
// Methode 1:
$liste = array('Gregoire','Nathalie','Emilie','François','Georges');
echo 'type de la variable liste : '.gettype($liste).' - yep, en php ce n\'est pas un objet.<br>';
// en php, on ne peut pas afficher tout le contenu de la liste en faisant un echo de cette dernieres (le langage ne sait pas le faire : erreur array to string conversion)
// On peut contouner le probleme :
echo '<pre>'; // Balise 'preformat' - peut servir pour la mise en page ( yum yum format json )
var_dump($liste); # Affiche le contenu du tableau plus certaines infos comme le typage du contenu
echo '</pre>';

echo '<br><pre>';
print_r($liste); # ne retourne que les index => valeurs
echo '</pre>';
// fonction personnelle d'affichage du print_r :
function debug($param){
    echo '<br><pre>';
    echo "[Debug] Contenu :";
    print_r($param);
    echo '</pre>';
} 
debug($liste);

// Methode 2:
$tab=['France','Italie','Espagne','Portugal']; # Methode de declaration la plus recente
// ajout d'une valeur en fin de liste :
$tab[] = 'Suisse'; // liste[] permet d'append, les listes n'etant pas des objets en php on ne peut pas faire appel à une methode d'objet :D
debug($tab);

// afficher 'Espagne' en passant par le tableau :
echo $tab[2].'<br>';

/// Tableau associatif :
// Dans un array associatif on peut choisir le nom des indices
$couleur = array(
    "j"=>"Jaune",
    "b"=>"Bleu",
    "v"=>"Vert"
);
// pour acceder à un element du tableau associatif :
echo $couleur['j'].'<br>'; # retourne bien la valeur de j : jaune
# exception de syntaxe :
echo "la seconde couleur du tableau est $couleur[b]<br>"; // il faut retirer les quotes dans une interpo


// mesurer la taille d'un array
// n'etant pas un objet, un array n'a pas d'attribut lenght, on peut donc proceder de deux façons (meme si elles fonctionnent de la meme façon) :
echo 'la taille de l\'array est de '.count($couleur).'<br>';
echo 'la taille de l\'array est de '.sizeof($couleur).'<br>';

?>

<?php
echo '<hr><h2> Boucle foreach </h2><br>';
// La boucle foreach permet de parcourir un tableau de façon automatique, elle fonctionne uniquement sur les objets et les array
debug($tab);
// 1ere syntaxe (recupere la valeur)
foreach($tab as $pays) { // structure "pour chacune" do (from $source AS $valeur parcourue)
    echo $pays.'<br>';
}
// deuxieme syntaxe (recupere l'index en plus de la valeur)
foreach($tab as $indice => $pays){ // l'index est donc la premiere variable, les valeurs la deuxieme
    echo 'idx '.$indice.' = '.$pays.'<br>';
}
// Exercice : Declarer un array associatif, avec les indices "prenom" "nom" "email" "telephone" auquel on associe des valeurs (une seule personne, on verra le multidimension plus tard).
// avec une boucle foreach, afficher les valeurs dans des paragraphes, SAUF le prenom qui doit etre dans un h3. 
$jeanjacques = array(
    "prenom"=>"Jean",
    "nom"=>"Jacques",
    "email"=>"jj@gmail.com",
    "telephone"=>"0607080910"
);
foreach($jeanjacques as $indice => $info){
    $balS= '<p>' ; $balE= '</p>';
    if ($indice == 'prenom'){
        $balS= '<h3>' ; $balE= '</h3>';
    }
    echo $balS.$info.$balE;
}

echo '<hr><h2> Tableaux multi-dimensionnels </h2><br>';
// Nous parlons de tableau multidimensionnel quand un tableau est contenu dans un autre tableau, chacun des tableaux represente une dimension
// Declaration d'un array multidimensionnel:
$tab_multi= array(
    0 => array(
        'prenom' => 'Julien',
        'nom' => 'Dupont',
        'telephone' => '01....'
    ),
    1 => array(
        'prenom' => 'Nicolas',
        'nom' => 'Duran',
        'telephone' => '06....'
    ),
    2 => array(
        'prenom' => 'Pierre',
        'nom' => 'Dulac',
    ),
);

debug($tab_multi);
// afficher la valeur de julien
echo $tab_multi[0]['prenom'].'<hr>'; # On descends donc d'abord dans l'indice 0, puis on lit l'indice prenom, on change donc de niveau de données

// Pour parcourir le tableau multidimensionnel, nous pouvons utiliser une boucle for car les indices sont numeriques
for ($i=0;$i<count($tab_multi);$i++){ # tant que $i est inferieur au nombre d'elements contenus dans tab_multi (3), on boucle. 
    echo $tab_multi[$i]['prenom'].'<br>'; # $i passe de 0 à 2, on affiche donc successivement la valeur de $i au passage, donc les trois prenoms
}

// Exercice : Afficher les trois prenoms avec une boucle foreach
// 1st v
foreach ($tab_multi as $valeur){
    echo $valeur['prenom'].'<br>'; # $valeur contient à chaque tour le sous-array dans lequel on va chercher directement l'indice 'prenom'
}
// 2nd v
foreach ($tab_multi as $indice => $valeur){
    echo $tab_multi[$indice]['prenom'].'<br>'; # Dans cette version on passe par le premier tableau ($tab_multi), il faut donc indiquer tous les indices pour arriver au prenom
}


echo '<hr><h2> Les inclusions de fichiers </h2><br>';

echo '<br> Premiere inclusion :';
include('./exemple.inc.php'); #Fait l'inclusion du fichier dont le chemin est specifié, le .inc dans le nom est un indicatif precisant que le fichier est destiné à etre inclus. ( norme, pas obligatoire coté fonctionnel)

echo '<br> Deuxieme inclusion :';
include_once './exemple.inc.php'; # Ici ne retourne rien, car il y a verification de si l'include a deja été effectué, si c'est le cas il ne le réinclus pas
// nota bene : pas de notion d'import implicite en php, c'est tout le fichier ou rien ..

echo '<br> Troisieme inclusion :'; # Ne pas mixer require et les includes.
/*
require './exemple.inc.php'; # L'include de base continue l'execution meme si l'import foire, en require non, en cas d'erreur d'inclusion c'est erreur fatale -> stop (au lieu d'un warning et yolo je continue).

echo '<br> Quatrieme inclusion :';
require_once './exemple.inc.php'; # Mix des deux, evidemment.
*/



# isImported est present dans la lib :
isImported();

?>