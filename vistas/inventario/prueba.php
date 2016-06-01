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
        <link rel="stylesheet" href="../../styles/btns.css" />
         <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" />  
<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>    
<script type="text/javascript">
$(function()
{
    
    //autocomplete
    $(".auto").autocomplete({
        source: "search_1.php",
        minLength: 1
    });                

});
</script>
    </head>
    <body>
        <div class="mnd">
            <?php include './header.php';?>
                <form action='' method='post'>
                    
                </form>
            <form>
                <div class="tbl">
                    <table>
                        <thead>
                        <tr><td colspan="7">Informacion Vendedor</td></tr>
                        <tr>
                            <td colspan="3"><input type="number" name="ceduvd" placeholder="Cedula" readonly value="<?php echo $_SESSION['user_id'];?>"/></td>
                            <td colspan="4"><input type="text" placeholder="nombrevd" readonly value="<?php echo $_SESSION['username'];?>"/></td>
                        </tr>
                        </thead>
                        <tbody>
                            <tr><td colspan="7">Informacion Comprador</td></tr>
                        <tr>
                            <td><input type="text" name="ceducl" id="auto" placeholder="Cedula Cliente" class="auto" value="<?php if(isset($cedcl)){echo $cedcl;}?>"/></td>
                            <td colspan="3"><input type="text" name="nomcl" placeholder="Nombre Cliente" value="<?php  if(isset($nombrecl)){echo $nombrecl;}?>"/></td>
                            <td colspan="2" ><input type="text" name="dircl" placeholder="Direccion"    value="<?php if(isset($dircl)){echo $dircl;}?>"/></td>
                            <td><input type="number" name="telcl" placeholder="Celular"    value="<?php if(isset($telcl)){echo $telcl;}?>"/></td>
                        </tr>
                   
                        </tbody> 
                    </table>  
                    
                    <table>
                            <tbody id="field" >
                            <tr><td colspan="7">Items a Facturar</td></tr>
                            <tr>
                            <td>Codigo</td>
                            <td>Marca</td>
                            <td>Modelo</td>
                            <td>Valor</td>
                            <td>Cantidad</td>
                            <td>Total</td>
                            <td>Eliminar</td>
                            </tr>
                             <tr>
                            <td colspan="7">
                         <input class="login-btn" type="button" value="Nueva Item" onClick="crear(this)">
                            </td>
                         </tr>
                            <tr>
                                <td>                                
                                    <input type="text" name="country" value="" class="auto" id="auto">                       
                                </td>
                                <td>                                
                                    <input type="text" name="textm[]" class="form-field" placeholder="Marca"/>                       
                                </td>
                                <td>                                
                                    <input type="text" name="textmo[]" class="form-field" placeholder="Modelo"/>                       
                                </td>
                                <td>                                
                                    <input type="number" name="textvl[]" class="form-field" placeholder="Valor"/>                       
                                </td>
                                  <td>                                
                                    <input type="text" name="textcn[]" class="form-field" placeholder="Cantidad"/>                       
                                </td>
                                 <td>                                
                                    <input type="text" name="textto[]" class="form-field" placeholder="Total"/>                       
                                </td>
                                 <td></td>                                
                            </tr>
                           
                            </tbody>  
                              <tfoot>
                                 
                        </tfoot>
                        </table>  
                    
                </div>
            </form>
        </div>
    </body>
</html>
