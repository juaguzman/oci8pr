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

$sql = oci_parse($conn, 'Select f.factura_id, f.cedula_cliente, f.fecha, u.nombres  from facturas f INNER JOIN usuarios u on f.id_usuario=u.id_usuario');
oci_execute($sql);

echo "<table border='1'>\n";
echo "<tr><td>N° de Factura</td><td>Cedula del Cliente</td><td>Nombre</td><td>Fecha</td><td>Opciones</td></tr>";
while ($row = oci_fetch_array($sql, OCI_ASSOC+OCI_RETURN_NULLS)) 
{
    echo "<tr>";
    echo "<td>". $row['FACTURA_ID'].'</td>';
    echo "<td>". $row['CEDULA_CLIENTE'].'</td>';
    echo "<td>". $row['NOMBRES'].'</td>';
    echo "<td>". $row['FECHA'].'</td>';
    echo "<td><a href=../inventario/pedidos.php?Id=".$row['FACTURA_ID']."><img src=../../imagenes/ver.png></a></td>";
    
    echo "</tr>";
}
    echo "</table>\n";
}
}