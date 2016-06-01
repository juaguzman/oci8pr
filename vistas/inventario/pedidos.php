<?php
include_once '../../includes/register.pd.php';
include_once '../../includes/functions.php';

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
                $id = $_GET['Id'];
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
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>pedidos</title>
        <script type="text/JavaScript" src="../../js/sha512.js"></script> 
        <script type="text/JavaScript" src="../../js/forms.js"></script>
        <link rel="stylesheet" href="../../styles/login_style.css" />
        <link rel="stylesheet" href="../../styles/mndstyle.css" />
        <link rel="stylesheet" href="../../styles/jquery-ui.css" />
         <script src="http://code.jquery.com/jquery-1.8.2.js"></script>
        <script src="/resources/demos/external/jquery.bgiframe-2.1.2.js"></script>
        <script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>
        <link rel="stylesheet" href="../../styles/login_style.css" />
        <link rel="stylesheet" href="../../styles/mndstyle.css" />
        <link rel="stylesheet" href="../../styles/menuvar.css" />
        <meta charset="UTF-8">
        <title>Pedidos</title>
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
    </head>
     <body>
        <div class="mnd">
            <?php include './header.php';?>
        </div>
       <div class="mnd">
          
          <form class="login" action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>"  method="post" name="registration_form">
           
            <h1 class="login-title">Pedidos</h1>
            <input type="hidden" name="id_p"/><br>
            <input class="login-input" type="text" name="dist" id="dist" required placeholder="Distribuidor"/><br>
            <input class="login-input" type='date'name='fecha' id='' required="fecha" placeholder="Fecha" /><br>
            <input class="login-input" type='number'name='cant' id='cant' required="" placeholder="Cantidad" /><br>
            <input type='hidden' name='id_i' value='<?php  ?>' />
            <a href="index.php"><input class="login-button" type="button" value="Pedir" onclick="" /></a> 
           
        </form>
        
    </body>


