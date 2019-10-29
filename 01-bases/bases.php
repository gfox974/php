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
echo 'Bonjour !<br><hr>';
# Comme constaté, on peut passer des balises html dans les strings, elles seront interpretées par le browser
?>