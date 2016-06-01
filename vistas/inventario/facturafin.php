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
if (isset($_POST['id'],$_POST['cant'],$_POST['val'],$_POST['cedc'],$_POST['ceduvd']) 
{
    $ceduvd = filter_input(INPUT_POST, 'ceduvd', FILTER_SANITIZE_NUMBER_INT);
    

    
}