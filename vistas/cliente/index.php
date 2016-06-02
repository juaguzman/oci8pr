<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
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
            else
                {
                $_SESSION["ultimoAcceso"] = $ahora;
                include_once '../../includes/functions_client.php';
                } 
            }
    }
        else
            {
                header("Location:../../index.php");
                return false;
            }
?>

<html>
    <head>
        <link rel="stylesheet" href="../../styles/login_style.css" />
        <link rel="stylesheet" href="../../styles/mndstyle.css" />
        <link rel="stylesheet" href="../../styles/menuvar.css" />
        <link rel="stylesheet" href="../../styles/tablepr.css" />
        <meta charset="UTF-8">
        <title>Clientes de la Zapateria</title>
    </head>
    <body>
        <div class="mnd">
            <?php include './header.php';?>
        <div class="generatecss_dot_com_table">
            <?php
                cliente::darCliente();
             ?>
            </div>    
        </div>
       
    </body>
</html>

