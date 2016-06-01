<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class factura
{
    static function darFactura()
    {
        $conn = oci_connect('zapateria', '5243', 'localhost/XE');
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

$sql = oci_parse($conn, 'Select f.id_factura, f.cedula_cliente, u.nick  from facturas f INNER JOIN usuarios u on f.id_usuario=u.id_usuario');
oci_execute($sql);

echo "<table border='1'>\n";
echo "<tr><td>N° de Factura</td><td>Cedula del Cliente</td><td>Nick Cliente</td></tr>";
while ($row = oci_fetch_array($sql, OCI_ASSOC+OCI_RETURN_NULLS)) 
{
    echo "<td>". $row['ID_FACTURA'].'</td>';
    echo "<td>". $row['CEDULA_CLIENTE'].'</td>';
    echo "<td>". $row['NICK'].'</td>';
}
    echo "</table>\n";
}
}