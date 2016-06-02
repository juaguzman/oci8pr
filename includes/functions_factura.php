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

$sql = oci_parse($conn, 'Select f.factura_id, f.cedula_cliente, f.fecha, u.nombres  from facturas f INNER JOIN CLIENTES u on f.CEDULA_CLIENTE = u.CEDULA_CLIENTE');
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
    echo "<td><a href=resumen.php?id=".$row['FACTURA_ID']."><img src=../../imagenes/ver.png></a></td>";
    
    echo "</tr>";
}
    echo "</table>\n";
}

static function resumen($id)
{
    $conn = oci_connect('zapateria', '5243', 'localhost/XE');
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

$stid = oci_parse($conn, 'SELECT f.*, u.*,c.nombres nomc, c.EMAIL emac, c.CELULAR celuc from FACTURAS f INNER JOIN USUARIOS u ON f.ID_USUARIO = u.ID_USUARIO INNER JOIN CLIENTES c on f.CEDULA_CLIENTE = c.CEDULA_CLIENTE WHERE f.FACTURA_ID = :idf');
oci_bind_by_name($stid,":idf", $id);
oci_execute($stid);
$row = oci_fetch_object($stid);
echo "<table>";
echo "<thead>";
echo "<tr>";
echo "<td colspan=6>Resumen de compra</td>";
echo "</tr>";
echo "<tr>";
echo "<td colspan=2>FECHA</td><td>$row->FECHA</td><td colspan=2>N. FACTURA</td><td>$row->FACTURA_ID</td>";
echo "</tr>";
echo "<tr>";
echo "<td colspan=6>Vendedor</td>";
echo "</tr>";
echo "<tr>";
echo "<td>Identificacion</td><td>$row->ID_USUARIO</td><td>Nombres</td><td>$row->NOMBRES</td><td>Apellidos</td><td>$row->APELLIDOS</td>";
echo "</tr>";
echo "<tr>";
echo "<td colspan=6>Comprador</td>";
echo "</tr>";
echo "<tr>";
echo "<td colspan=2>Identificacion</td><td>$row->CEDULA_CLIENTE</td><td colspan=2>Telefono</td><td>$row->CELUC</td>";
echo "</tr>";
echo "<tr>";
echo "<td colspan=2>Nombre</td><td>$row->NOMC</td><td colspan=2>Email</td><td>$row->EMAC</td>";
echo "</tr>";
echo "</thead>";
$stid = oci_parse($conn, 'SELECT v.CANTIDAD cant,v.ID_INVENTARIO,v.VALOR,inv.MARCA, inv.MODELO,inv.PRECIO_VENTA from ventas v inner join inventario inv on v.ID_INVENTARIO= inv.ID_INVENTARIO where v.ID_FACTURA = :idf');
oci_bind_by_name($stid,":idf", $id);
oci_execute($stid);
echo "<tbody>";
echo "<tr>";
echo "<td colspan=6>Items</td>";
echo "</tr>";
 echo "<tr>";
    echo "<td>Cantidad </td>";
    echo "<td>Codigo</td>";
    echo "<td colspan=2>Descripcion</td>";
    echo "<td>Vlr C/U</td>";
    echo "<td>Vlr Total</td>";
    $sump=0;
    $sumt=0;
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) 
{
    $sump=$row['VALOR']*$row['CANT'];
    $sumt=$sumt+$sump;
    echo "<tr>";
    echo "<td>". $row['CANT'].'</td>';
    echo "<td>". $row['ID_INVENTARIO'].'</td>';
    echo "<td colspan=2>". $row['MARCA'].'---------'.$row['MODELO'].'</td>';
    echo "<td>". $row['VALOR'].'</td>';
    echo "<td>". $sump.'</td>';
    echo "</tr>";
}
echo "<tr><td colspan=4>TOTAL</td><td colspan=2>$sumt</td></tr>";
echo "</tbody>";
echo "</table>";
}
}