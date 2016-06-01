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
if (isset($_POST['ceduvd'],$_POST['usern'],$_POST['ceduc1'],$_POST['nomc1'],$_POST['dirc1'],$_POST['telc1'],$_POST['id[]'],$_POST['pventa'],$_POST['cantidadC'] )) 
{
                $ceduvd = filter_input(INPUT_POST, 'ceduvd', FILTER_SANITIZE_NUMBER_INT);
                $usern = filter_input(INPUT_POST, 'usern', FILTER_SANITIZE_STRING);
                $cedcl = filter_input(INPUT_POST, 'cedc1', FILTER_SANITIZE_NUMBER_INT);
                $nomcl = filter_input(INPUT_POST, 'nomc1', FILTER_SANITIZE_STRING);
                $dircl = filter_input(INPUT_POST, 'dirc1', FILTER_SANITIZE_STRING);
                $telc1 = filter_input(INPUT_POST, 'telc1', FILTER_SANITIZE_NUMBER_INT);
                $idV = $_POST[ 'id[]'];
                $pventa = $_POST['pventa[]'];
                $cantidadC = $_POST['cantidadC[]'];
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
        <meta charset="UTF-8">
        <title>Sistema de Facturacion</title>
    </head>
    <body>
    </body>
</html>
<?php } else {}   ?>