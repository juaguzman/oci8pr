<?php

if(isset($_POST['cedvd'],$_POST['cedc1'],$_POST['nomc1'],$_POST['dirc1'],$_POST['telc1']
        ,$_POST['ids'],$_POST['cant'],$_POST['totpar'],$_POST['tot']))
{
include '../../includes/conect.php';

    $cedvn=$_POST['cedvd'];
    $cedcl=$_POST['cedc1'];
    $nomcl=$_POST['nomc1'];
    $dircl=$_POST['dirc1'];
    $telcl=$_POST['telc1'];
    $ids=$_POST['ids'];
    $cant=$_POST['cant'];
    $tot=$_POST['totpar'];
    
    
    $stid = oci_parse($conn,"SELECT FACTURA_ID FROM FACTURAS WHERE FACTURA_ID =(SELECT MAX(FACTURA_ID) FROM FACTURAS)"); 
    if(oci_execute($stid))
    {
    $row = oci_fetch_object($stid);
    $nfct = $row ->FACTURA_ID;
    }
    
    
    
    
    $stid = oci_parse($conn, 'SELECT * FROM CLIENTES WHERE CEDULA_CLIENTE = :id_cl AND rownum = 1');

    oci_bind_by_name($stid, ':id_cl', $cedcl);
    oci_execute($stid);
    $row = oci_fetch_object($stid);
    $sum = count($row);
    $fila = oci_num_rows($stid);
    if(empty($row))
    {
       $stid = oci_parse($conn,"BEGIN ADDCLIENTE(:cedu,:nom,:cel,:dir); END;");
        
        oci_bind_by_name($stid, ":cedu", $cedcl);
        oci_bind_by_name($stid, ":nom", $nomcl);
        oci_bind_by_name($stid, ":cel", $telcl);
        oci_bind_by_name($stid, ":dir", $dircl);
        
        if(oci_execute($stid))
        {
            oci_commit($conn);
            $fnfct = $nfct+1;
            
                    $stid = oci_parse($conn,"INSERT INTO FACTURAS VALUES(:idf, :cdcl, :idus, SYSDATE)"); 
                     oci_bind_by_name($stid,":idf", $fnfct);
                     oci_bind_by_name($stid,":cdcl", $cedcl );
                     oci_bind_by_name($stid,":idus", $cedvn);
             if(oci_execute($stid))
                    {
                        oci_commit($conn);
                        $longitud= count($ids);
                        for($i=0; $i<$longitud; $i++)
                        {
                            $id=$ids[$i];
                            $cnt=$cant[$i];
                            $tt=$tot[$i];


                         $stid = oci_parse($conn,"INSERT INTO VENTAS VALUES(:idf,:idv,:cant,:vlr,(SELECT max(ID_VENTAS)+1 FROM VENTAS))"); 
                         oci_bind_by_name($stid, ":idf",$fnfct);                          
                         oci_bind_by_name($stid, ":idv",$id);
                         oci_bind_by_name($stid, ":cant",$cnt );
                         oci_bind_by_name($stid, ":vlr", $tt);
                         $r= oci_execute($stid);
                         if(!$r)
                         {
                            $e = oci_error($stid);  // Para errores de oci_execute, pase el gestor de sentencia
                            print htmlentities($e['message']);
                             print "\n<pre>\n";
                            print htmlentities($e['sqltext']);
                            printf("\n%".($e['offset']+1)."s", "^");
                            print  "\n</pre>\n";
                         }

                        }
                        oci_commit($conn);
                        header("Location:../inventario/index.php");
                    } 
        }
        
    }
    else
    {
        $fnfct = $nfct+1;
        $stid = oci_parse($conn,"INSERT INTO FACTURAS VALUES(:idf, :cdcl, :idus, SYSDATE)"); 
                     oci_bind_by_name($stid,":idf", $fnfct);
                     oci_bind_by_name($stid,":cdcl", $cedcl );
                     oci_bind_by_name($stid,":idus", $cedvn);
             if(oci_execute($stid))
                    {
                        oci_commit($conn);
                        $longitud= count($ids);
                        for($i=0; $i<$longitud; $i++)
                        {
                            $id=$ids[$i];
                            $cnt=$cant[$i];
                            $tt=$tot[$i];


                         $stid = oci_parse($conn,"INSERT INTO VENTAS VALUES(:idf,:idv,:cant,:vlr,(SELECT max(ID_VENTAS)+1 FROM VENTAS))"); 
                         oci_bind_by_name($stid, ":idf",$fnfct);                          
                         oci_bind_by_name($stid, ":idv",$id);
                         oci_bind_by_name($stid, ":cant",$cnt );
                         oci_bind_by_name($stid, ":vlr", $tt);
                         $r= oci_execute($stid);
                         if(!$r)
                         {
                            $e = oci_error($stid);  // Para errores de oci_execute, pase el gestor de sentencia
                            print htmlentities($e['message']);
                             print "\n<pre>\n";
                            print htmlentities($e['sqltext']);
                            printf("\n%".($e['offset']+1)."s", "^");
                            print  "\n</pre>\n";
                         }

                        }
                        oci_commit($conn);
                        header("Location:../inventario/index.php");
                    }        
    } 
    
}