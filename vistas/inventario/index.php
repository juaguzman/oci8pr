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
                include_once '../../includes/functions_inventario.php';
                if(isset($_GET['msj'])){$msj=$_GET['msj'];}
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
        <script src="http://code.jquery.com/jquery-1.8.2.js"></script>
        <script src="/resources/demos/external/jquery.bgiframe-2.1.2.js"></script>
        <script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script>
        $(function() {
    $( "#dialog-message" ).dialog({
      modal: true,
      buttons: {
        Ok: function() {
          $( this ).dialog( "close" );
        }
      }
    });
  });
  </script>
        <meta charset="UTF-8">
        <title>Inventario Zapateria</title>
    </head>
    <body>
        <div class="mnd">
            <?php include './header.php';?>
            <div class="generatecss_dot_com_table ">
             <?php
                 inventario::darInventario();
             ?>
            </div>    
        </div>
       <?php if(isset($_REQUEST['msj'])){
        $msj = $_REQUEST['msj'];
             echo "$msj";
             }?>
    </body>
</html>
