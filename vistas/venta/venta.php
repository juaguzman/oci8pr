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
        <link rel="stylesheet" href="../../styles/tablepr.css" />
        <link rel="stylesheet" href="../../styles/btns.css" />
           <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" />  
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>    
        <script type="text/javascript">
        <script type="text/javascript">
        $(function()
            {   
                //autocomplete
                $("#auto2").autocomplete({
                    source: "search_2.php",
                    minLength: 0
                }); 
                 });
        </script>;
        </script>
        <meta charset="UTF-8">
        <title>Sistema de Facturacion</title>

    </head>
    <body>
        <div class="mnd">
            <?php include './header.php';?>
            <form action="prefactura2.php" method="POST">
                <div class="generatecss_dot_com_table">
                    <table>
                        <thead>
                        <tr><td colspan="7">Informacion Vendedor</td></tr>
                        <tr>
                            <td colspan="3"><input type="number" name="ceduvd" placeholder="Cedula" readonly value="<?php echo $_SESSION['user_id'];?>"/></td>
                            <td colspan="4"><input type="text"  name="usern" placeholder="nombrevd" readonly value="<?php echo $_SESSION['username'];?>"/></td>
                        </tr>
                        </thead>
                        <tbody>
                            <tr><td colspan="7">Informacion Comprador</td></tr>
                        <tr>
                            <td><input type="number" name="ceducl" required id="auto2" placeholder="Cedula Cliente" value="<?php if(isset($cedcl)){echo $cedcl;}?>"/></td>
                            <td colspan="3"><input type="text" required name="nomcl" id="nomb" placeholder="Nombre Cliente" value="<?php  if(isset($nombrecl)){echo $nombrecl;}?>"/></td>
                            <td colspan="2" ><input type="email" required name="dircl" id="dir" placeholder="Email"    value="<?php if(isset($dircl)){echo $dircl;}?>"/></td>
                            <td><input type="number" name="telcl" required placeholder="Celular" id="cel"   value="<?php if(isset($telcl)){echo $telcl;}?>"/></td>
                        </tr>
                   
                        </tbody> 
                    </table>  
                    <?php inventario::darInventarioVenta()?>
                     
                    <input type="submit" value="Fin Venta" class="login-button">
                </div>
            </form>
        </div>
    </body>
</html>
