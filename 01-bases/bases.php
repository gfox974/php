<style>
    h2 {
        border-top: 1px solid black;
        border-bottom: 1px solid black;
        color: grey;
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

?>