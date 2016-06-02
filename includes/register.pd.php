<?php
include_once 'conect.php';
 
$error_msg = "";


if (isset($_POST['id_p'],$_POST['dist'],$_POST['fecha'], $_POST['cant'],$_POST['id_i'])) 
{
    $id_p = filter_input(INPUT_POST, 'id_p', FILTER_SANITIZE_NUMBER_INT);
    $dist = filter_input(INPUT_POST, 'dist', FILTER_SANITIZE_STRING);
    $fecha = $_POST['fecha'];
    $cant = filter_input(INPUT_POST, 'cant', FILTER_SANITIZE_NUMBER_INT);
    $id_i = filter_input(INPUT_POST, 'id_i', FILTER_SANITIZE_STRING);
    $valu = filter_input(INPUT_POST, 'vlrunit', FILTER_SANITIZE_NUMBER_INT);
    
    if (empty($error_msg)) 
    {
        $valt = $valu*$cant;
        $stid = oci_parse($conn,"insert into PEDIDOS(ID_PEDIDO,DISTRIBUIDOR,FECHA,CANTIDAD,ID_INVENTARIO,VALORUN,VALORTOT) values ((select max(id_pedido)+1 from pedidos), :dist, SYSDATE, :cant,:id_p,:valun,:valto )");
        oci_bind_by_name($stid, ":dist", $dist);
         oci_bind_by_name($stid, ":cant", $cant);
        oci_bind_by_name($stid,":id_p", $id_i);
        oci_bind_by_name($stid,":valun", $valu);
        oci_bind_by_name($stid,":valto", $valt);
//        oci_bind_by_name($stid, ":fecha", $fecha);
      if (oci_execute($stid)) 
        {       
                oci_commit($conn);
                $msj='<div id=dialog-message title=Pedido> <p> <span class=ui-icon ui-icon-circle-check style=float:left; margin:0 7px 50px 0;></span> Pedido Realizado Satisfactoriamente </p>  <p> Valor nuevo <b> Agregado a inventario</b>.</p></div>';
                header('Location: index.php?msj='.$msj);
                
                
        }
        else 
        {
            header('Location: ../error.php?err=Registration failure: INSERT');
        }
        
        
    }
}

