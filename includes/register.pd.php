<?php
include_once 'conect.php';
 
$error_msg = "";
$error_msg_idPedido = "";
$error_msg_dist = "";
$error_msg_fecha = "";
$error_msg_cant = "";
$error_msg_id_inv = "";

if (isset($_POST['dist'],$_POST['fecha'], $_POST['cant'],$_POST['id'])) 
{
    if (empty($error_msg)) 
    {
        $stid = oci_parse($conn,"insert into PEDIDOS(ID_PEDIDO,DISTRIBUIDOR,FECHA,CANTIDAD,ID_INVENTARIO) values (select id_pedido (:dist,:fecha,:cant,:id)");    
        
        
    }
}

