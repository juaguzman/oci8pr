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
            else{$_SESSION["ultimoAcceso"] = $ahora;} 
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
        <meta charset="UTF-8">
        <title>Sistema de Facturacion</title>
    </head>
    <body>
        <div class="mnd">
            <?php include './header.php';?>
            <form>
                <div class="tbl">
                    <table>
                        <thead>
                        <tr><td colspan="4">Informacion Vendedor</td></tr>
                        <tr>
                            <td><input type="number" placeholder="Cedula" value="<?php echo $_SESSION['user_id'];?>"/></td>
                            <td><input type="number" placeholder="Cedula" value="<?php echo $_SESSION['username'];?>"/></td>
                            <td><input type="number" placeholder="Cedula" value="<?php echo $_SESSION['user_id'];?>"/></td>
                            <td><input type="number" placeholder="Cedula" value="<?php echo $_SESSION['user_id'];?>"/></td>
                        </tr>
                        </thead>
                        <tbody>
                            <tr><td colspan="4">Informacion Comprador</td></tr>
                        <tr>
                            <td><input type="number" placeholder="cedulac" value="<?php echo $_SESSION['user_id'];?>"/></td>
                            <td><input type="number" placeholder="nombrec" value="<?php echo $_SESSION['username'];?>"/></td>
                            <td><input type="number" placeholder="dirc"    value="<?php echo $_SESSION['user_id'];?>"/></td>
                            <td><input type="number" placeholder="telc"    value="<?php echo $_SESSION['user_id'];?>"/></td>
                        </tr>
                        </tbod
                        y>
                    </table>
                </div>
            </form>
        </div>
    </body>
</html>
