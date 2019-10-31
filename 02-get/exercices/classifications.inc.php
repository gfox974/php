<?php
// TESTING
class Fruits {
    const categorie = 'Fruits';
    
    function printCat() {
        echo self::categorie;
    }
    function printCol() {
        echo self::couleur;
    }
}
class Banane extends Fruits {
    const couleur = 'Jaune';
}
class Kiwi extends Fruits {
    const couleur = 'Vert';
}
class Cerise extends Fruits {
    const couleur = 'Rouge';
}
?>