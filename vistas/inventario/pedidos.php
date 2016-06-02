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
                if(isset($_GET['Id'])){$id = $_GET['Id'];}
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
         <link rel="stylesheet" href="../../styles/menuvar.css" />
        <link rel="stylesheet" href="../../styles/mndstyle.css" />
        <!--<link rel="stylesheet" href="../../styles/jquery-ui.css" />-->
          <script src="//code.jquery.com/jquery-1.10.2.js"></script>
          <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
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
        <title>Pedidos</title>
    </head>
     <body>
        <div class="mnd">
            <?php include './header.php';?>      
            <div class="generatecss_dot_com_table">
          <form class="login" action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>"  method="post" name="registration_form">           
            <h1 class="login-title">Pedidos</h1>
            <input type="hidden" name="id_p"/><br>
            <input class="login-input" type="text" name="dist" id="dist" required placeholder="Distribuidor"/><br>
            <input class="login-input" type='date'name='fecha' id='' required="fecha" placeholder="Fecha" /><br>
            <input class="login-input" type='number'name='cant' id='cant' required="" placeholder="Cantidad" /><br>
            <input class="login-input" type='number'name='vlrunit' id='cant' required="" placeholder="Valor Unitario" /><br>
            <input type='hidden' name='id_i' value='<?php if(isset($id)){echo $id;} ?>' />
            <input type="submit" value="Fin Venta" class="login-button">          
        </form>
          </div>
      </div>  
    </body>


