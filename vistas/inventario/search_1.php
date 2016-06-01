<?php



if (isset($_GET['term']))
    {
    $return_arr = array();
    
      $param = $_GET['term'];
      $pr='%';
      $pa=strtoupper($param.$pr);
        $conn = oci_connect('zapateria', '5243', 'localhost/XE');
            if (!$conn) 
            {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
            }
          $stid = oci_parse($conn, "SELECT ID_INVENTARIO FROM INVENTARIO WHERE ID_INVENTARIO LIKE :bv");
          $ciudad = "NI%";  // '%' es un comodín en SQL
          oci_bind_by_name($stid, ":bv", $pa);
          oci_execute($stid);
          while (($row = oci_fetch_array($stid, OCI_ASSOC)) != false)
          {
          $return_arr[]=$row['ID_INVENTARIO'];
          }
         echo json_encode($return_arr);

    /* Toss back results as json encoded array. */
   
}

