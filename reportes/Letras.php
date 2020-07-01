<?php
//Convertimos a letras
$num = 7658.85;

$formatterES = new NumberFormatter("es-ES", NumberFormatter::SPELLOUT);

$izquierda = intval(floor($num));
$derecha = intval(($num - floor($num)) * 100);

$letras = strtoupper($formatterES->format($izquierda) . " bolivianos con " . $formatterES->format($derecha)." centavos");

echo $letras;