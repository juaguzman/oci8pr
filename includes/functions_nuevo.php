<?php
//include 'conect.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class inventarioN
{
static function darInventarioN()
{
   $conn = oci_connect('zapateria', '5243', 'localhost/XE');
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}
    
    $sql = oci_parse($conn, 'SELECT * FROM inventario');
    //$stid = oci_parse($conn, $sql);
    //oci_execute($stid);
    //$didbv = 60;
    //oci_bind_by_name($didbv);
    oci_execute($sql);
   
    echo "<form>";
    echo "<table border='1'>\n";
    echo "<tr><td>Codigo</td><td>Marca</td><td>Modelo</td><td>Disponibles</td><td>Precio Venta</td><td>Precio Compra</td></tr>";
    while ($row = oci_fetch_array($sql, OCI_ASSOC+OCI_RETURN_NULLS)) 
//    while (($row = oci_fetch_array($sql, OCI_ASSOC)) != false) 
    {   
        echo "<tr>";
        echo "<td><input name=id value='$row[ID_INVENTARIO]'/></td>";
        echo "<td> <input name=marca value='$row[MARCA]'/></td>";
        echo "<td><input name=modelo value='$row[MODELO]'/></td>"; 
        echo "<td><input name=cantidad value='$row[CANTIDAD]'/></td>";
        echo "<td><input name=pventa value='$row[PRECIO_VENTA]'/></td>";
        echo "<td><input name=pcompra value='$row[PRECIO_COMPRA]'/></td>";
        echo "</tr>";
        
        //foreach ($row as $item) 
    //{
      //  echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "") . "</td>";
    //}
    //echo"<td> <a href='../inventario/pedidos.php'><img src='../../imagenes/anadir.png'></a></td>";
    //echo "</tr>\n";
    }
    echo "</table>\n";
echo"</form>";
}

}