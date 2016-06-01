<?php
include_once 'conect.php';
 
$error_msg = "";
$error_msg_idPedido = "";
$error_msg_dist = "";
$error_msg_fecha = "";
$error_msg_cant = "";
$error_msg_id_inv = "";

if (isset($_POST['id_p'],$_POST['dist'],$_POST['fecha'], $_POST['cant'],$_POST['id_i'])) 
{
    $id_p = filter_input(INPUT_POST, 'id_p', FILTER_SANITIZE_NUMBER_INT);
    $dist = filter_input(INPUT_POST, 'dist', FILTER_SANITIZE_STRING);
    $fecha = filter_input(INPUT_POST, 'fecha');
    $cant = filter_input(INPUT_POST, 'cant', FILTER_SANITIZE_NUMBER_INT);
    $id_i = filter_input(INPUT_POST, 'id_i', FILTER_SANITIZE_STRING);
    if (empty($error_msg)) 
    {
        $stid = oci_parse($conn,"insert into PEDIDOS(ID_PEDIDO,DISTRIBUIDOR,FECHA,CANTIDAD,ID_INVENTARIO) values ((select max(id_pedido)+1 from pedidos), :dist, :fecha, :cant,:id_i )");
        oci_bind_by_name($stid,":id_p", $id_p);
        oci_bind_by_name($stid, ":dist", $dist);
        oci_bind_by_name($stid, ":fecha", $fecha);
        oci_bind_by_name($stid, ":cant", $can);
        if (oci_execute($stid)) 
        {
            oci_commit($conn);
                echo "<div id=dialog-message title=Pedido > <p> El pedido se agrego correctamente </p></div>";
        }
        else 
        {
            header('Location: ../error.php?err=Registration failure: INSERT');
        }
        
        
    }
}

