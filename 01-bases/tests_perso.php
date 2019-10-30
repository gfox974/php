<?php
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
########################################## MAIN #############################
$litres = 10; $type = 'Diesel';
#echo(essence::afficheDiesel()).'<br>';
#echo(essence::afficheEssence()).'<br>';
#echo(essence::affichePrix($type));
echo "votre plein de $litres litres de $type va vous couter ".(essence::estimePlein($litres,$type)).'€.';
?>