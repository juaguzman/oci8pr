<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class cliente
{
static function darCliente()
{
   $conn = oci_connect('zapateria', '5243', 'localhost/XE');
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

$sql = oci_parse($conn, 'SELECT * FROM clientes');
oci_execute($sql);

echo "<table border='1'>\n";
echo "<tr><td>Cedula</td><td>Nombres</td><td>Apellido</td><td>Celular</td><td>Email</td></tr>";
while ($row = oci_fetch_array($sql, OCI_ASSOC+OCI_RETURN_NULLS)) 
        {
    echo "<tr>";
        echo "<td>". $row['CEDULA_CLIENTE'].'</td>';
        echo "<td>". $row['NOMBRES'].'</td>';
        echo "<td>". $row['APELIDOS'].'</td>';
        echo "<td>". $row['CELULAR'].'</td>';
        echo "<td>". $row['EMAIL'].'</td>';      
        echo "</tr>";
}
echo "</table>\n";
}
}