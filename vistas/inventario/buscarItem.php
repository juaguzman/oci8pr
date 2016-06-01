<?php
include '../../includes/conect.php';

$cod = $_GET['term'];
 
 

 $stid = oci_parse($conn, 'SELECT ID_INVENTARIO FROM INVENTARIO WHERE ID_INVENTARIO LIKE :IDI');
 oci_bind_by_name($stid, ":IDI", $cod);
     
   // Verifica el correo electrónico existente.  
    if (oci_execute($stid)) 
{           
        $fila = oci_num_rows($stid);
        if($fila > 0)
            {
            
            while($row = oci_fetch_array($stid,OCI_ASSOC))
            {
                $json[] = $data;
                $cods[] = $data;
            }
        echo json_encode($cods);
            }
}