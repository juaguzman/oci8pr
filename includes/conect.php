<?php

// Conecta al servicio XE (esto es, una base de datos) en la máquina "localhost"
$conn = oci_connect('zapateria', '5243', 'localhost/XE');
if (!$conn) 
    {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }