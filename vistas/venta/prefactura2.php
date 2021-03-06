<!DOCTYPE html>
<?php

session_start();
if(isset($_SESSION["autentificado"]))
    {
        $fechaGuardada = $_SESSION["ultimoAcceso"]; 
        $ahora = date("Y-n-j H:i:s");
        if($_SESSION["autentificado"]!="SI")
            {
             header("Location:../sesionCerrada.html");
             return false;
             }
            else
            {
            $tiempo_transcurrido = (strtotime($ahora)-strtotime($fechaGuardada)); 
            if($tiempo_transcurrido >= 300)
                {//1200 milisegundos = 1200/60 = 20 Minutos...
                    session_destroy();
                    header("Location:../sesionCerrada.html");
                    return false;
                }
            else{
                $_SESSION["ultimoAcceso"] = $ahora;
                include '../../includes/functions_inventario.php';
               
            } 
            }
    }
        else
            {
                header("Location:../sesionCerrada.html");
                return false;
            }
if (isset($_POST['ceduvd'],$_POST['usern'],$_POST['ceducl'],$_POST['nomcl'],$_POST['dircl'],$_POST['telcl'])) 
{
                $ceduvd = filter_input(INPUT_POST, 'ceduvd', FILTER_SANITIZE_NUMBER_INT);
                $usern = filter_input(INPUT_POST, 'usern', FILTER_SANITIZE_STRING);
                $cedcl = filter_input(INPUT_POST, 'ceducl', FILTER_SANITIZE_NUMBER_INT);
                $nomcl = filter_input(INPUT_POST, 'nomcl', FILTER_SANITIZE_STRING);
                $dircl = filter_input(INPUT_POST, 'dircl', FILTER_SANITIZE_STRING);
                $telc1 = filter_input(INPUT_POST, 'telcl', FILTER_SANITIZE_NUMBER_INT);
                $idV = $_POST[ 'id'];
                $pventa = $_POST['pventa'];
                $canti = $_POST['cantidadC'];
?>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <link rel="stylesheet" href="../../styles/login_style.css" />
        <link rel="stylesheet" href="../../styles/mndstyle.css" />
        <link rel="stylesheet" href="../../styles/menuvar.css" />
        <link rel="stylesheet" href="../../styles/btns.css" />
        <link rel="stylesheet" href="../../styles/tablepr.css" />
        <meta charset="UTF-8">
        <title>Sistema de Facturacion</title>
    </head>
    <body>
         <div class="mnd">
            <?php include './header.php';?>
             <div class="generatecss_dot_com_table">
                 <form action="facturafin.php" method="POST">
        <table>
            <thead>
                <tr><td colspan="4">Factura Final</td></tr>
                <tr><td colspan="2">Cedula vendedor</td><td colspan="2">Usuario</td></tr>
                <tr><td colspan="2"><input value="<?php echo $ceduvd; ?>" name="cedvd" readonly/></td>
                    <td colspan="2"><input value="<?php echo $usern; ?>" name="usu" readonly/></td></tr>
            </thead>
            <tbody>
            <tr>
            <td> Cedula Comprador</td>
            <td>Nombre del Comprador</td>
            <td>Direccion de Comprador</td>
            <td>Celular</td>
            </tr>
            <tr>
                <td><input value="<?php echo $cedcl; ?>" name="cedc1"/></td>
                <td><input value="<?php echo $nomcl; ?>" name="nomc1"/></td>
                <td><input value="<?php echo $dircl; ?>" name="dirc1"/> </td>
                <td><input value="<?php echo $telc1; ?>" name="telc1"/></td> 
            </tr>
            </tbody>
            <tfoot>
                <tr><td colspan="4">Items Facturados</td></tr>
                <tr><td>id</td><td>Precio C/U</td><td>Cantidad</td><td>Valor Total</td></tr>
            <?php 
            $longitud= count($idV);
            $sumtot=0;
            $sumpar=0;
                    for($i=0; $i<$longitud; $i++)
                    {
                        $cant=$canti[$i];
                        if($cant>=1)
                        {
                            echo "<tr>";
                            $sumpar=$pventa[$i]*$canti[$i];
                            $sumtot=$sumtot+$sumpar;
                            echo "<td>$idV[$i]</td><td>$pventa[$i]</td><td>$canti[$i]</td><td>$sumpar</td>";
                            
                            ?>
                            <input type="hidden" value="<?php echo "$idV[$i]";?>" name="ids[]" />
                            <input type="hidden" value="<?php echo "$canti[$i]";?>" name="cant[]"/>
                            <input type="hidden" value="<?php echo "$sumpar";?>" name="totpar[]" />
                            <?php
                            $sumpar=0;
                            echo "</tr>";
                        }
            
                    } ?>
                <tr><td colspan="3">TOTAL</td><td><?php echo "$sumtot"?></td></tr>
                 <input type="hidden" value="<?php echo "$sumtot";?>" name="tot" />
            </tfoot>
        </table>
                     <input type="submit" value="Fin Venta" class="login-button">
            </form>
                 </div>
     </div>
    </body>
</html>
<?php } else {}   ?>
