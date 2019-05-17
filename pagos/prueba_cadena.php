<?php
$encontradme = '403-18-01';
$micadena1 = 'xyz';
$micadena2 = '01-01-01-00-403-18-01-00';

$pos1 = stripos($micadena1, $encontradme);
$pos2 = stripos($micadena2, $encontradme);

// No, ciertamente 'a' no esta en 'xyz'
if ($pos1 === false) {
    echo "La cadena '$encontradme' no fue encontrada en la cadena '$micadena1' ";
}

// Note nuestro uso de ===.  Simplemente == no funcionaría como es de
// esperarse, ya que la posición de 'a' es el caracter 0 (el primero).
if ($pos2 !== false) {
    echo " Encontramos '$encontradme' en '$micadena2' en la posición $pos2";
}
?>
