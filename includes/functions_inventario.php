<?php
//include 'conect.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class inventario
{
static function darInventario()
{
   $conn = oci_connect('zapateria', '5243', 'localhost/XE');
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}
    
   $stid = oci_parse($conn, 'SELECT * FROM inventario');
oci_execute($stid);

echo "<table border='1'>\n";
echo "<tr><td>Codigo</td><td>Marca</td><td>Modelo</td><td>Disponibles</td><td>Precio Venta</td><td>Precio Compra</td></tr>";
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
    echo "<tr>\n";
    foreach ($row as $item) 
    {
        echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "") . "</td>\n";
    }
    echo "</tr>\n";
}
echo "</table>\n";
}

}