<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanea los datos html, para evitar injecciones sql. 
function sanear($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}