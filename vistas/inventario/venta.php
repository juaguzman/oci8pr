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
                $("#auto").autocomplete({
                    source: "search_1.php",
                    minLength: 1
                });  
                   });
        </script>
        <script type="text/javascript">
        $(function()
            {   
                //autocomplete
                $("#auto2").autocomplete({
                    source: "search_2.php",
                    minLength: 0
                }); 
                 });
        </script>
        <meta charset="UTF-8">
        <title>Sistema de Facturacion</title>
        <script type="text/javascript">

        icremento =1;
        function crear(obj) 
        {
          icremento++;

          field = document.getElementById('field'); 
         contenedor = document.createElement('tr'); 
         contenedor.id = 'div'+icremento;
//          contenedor.className = "divct";
          field.appendChild(contenedor); 
          
          tr = document.createElement('td')
          tr.id='trcod'+icremento;
          contenedor.appendChild(tr);

          boton = document.createElement('input'); 
          boton.type = 'text'; 
          boton.placeholder = "Codigo";
          boton.name = 'text'+'[]'; 
          boton.className = 'form-field ui-autocomplete-input';
          boton.id='auto';
          tr.appendChild(boton); 
//          tr de marca
          tr = document.createElement('td')
          tr.id='trmar'+icremento;
          contenedor.appendChild(tr);

          boton = document.createElement('input'); 
          boton.type = 'text'; 
          boton.placeholder = "Marca";
          boton.name = 'textm'+'[]'; 
          boton.className = 'form-field';
          tr.appendChild(boton); 
//          tr de modelo
          tr = document.createElement('td')
          tr.id='trmar'+icremento;
          contenedor.appendChild(tr);

          boton = document.createElement('input'); 
          boton.type = 'text'; 
          boton.placeholder = "Modelo";
          boton.name = 'textmo'+'[]'; 
          boton.className = 'form-field';
          tr.appendChild(boton);
          
//          tr de vvalor
          tr = document.createElement('td')
          tr.id='trvlr'+icremento;
          contenedor.appendChild(tr);

          boton = document.createElement('input'); 
          boton.type = 'text'; 
          boton.placeholder = "Valor";
          boton.name = 'textvl'+'[]'; 
          boton.className = 'form-field';
          tr.appendChild(boton);
//          tr de cantidad
          tr = document.createElement('td')
          tr.id='trct'+icremento;
          contenedor.appendChild(tr);

          boton = document.createElement('input'); 
          boton.type = 'text'; 
          boton.placeholder = "Cantidad";
          boton.name = 'textcn'+'[]'; 
          boton.className = 'form-field';
          tr.appendChild(boton);
          
          //          tr de cantidad
          tr = document.createElement('td')
          tr.id='trct'+icremento;
          contenedor.appendChild(tr);

          boton = document.createElement('input'); 
          boton.type = 'text'; 
          boton.placeholder = "Total";
          boton.name = 'textto'+'[]'; 
          boton.className = 'form-field';
          tr.appendChild(boton);
          
//        tr de Eliminar
          tr = document.createElement('td')
          tr.id='trct'+icremento;
          contenedor.appendChild(tr);

          boton = document.createElement('input'); 
          boton.type = 'button'; 
          boton.value = ' - '; 
          boton.name = 'div'+icremento; 
          boton.className = 'submit-button-env';
          boton.onclick = function () {borrar(this.name)} //aqui llamamos a la funcion borrar
          tr.appendChild(boton); 
          return contenedor.id;
        }
        function borrar(obj) {//aqui la ejecutamos
          field = document.getElementById('field'); 
          field.removeChild(document.getElementById(obj)); 
        }
        
       
</script>
    </head>
    <body>
        <div class="mnd">
            <?php include './header.php';?>
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
                            <td><input type="number" name="ceducl" id="auto2" placeholder="Cedula Cliente" value="<?php if(isset($cedcl)){echo $cedcl;}?>"/></td>
                            <td colspan="3"><input type="text" name="nomcl" id="nomb" placeholder="Nombre Cliente" value="<?php  if(isset($nombrecl)){echo $nombrecl;}?>"/></td>
                            <td colspan="2" ><input type="text" name="dircl" id="dir" placeholder="Direccion"    value="<?php if(isset($dircl)){echo $dircl;}?>"/></td>
                            <td><input type="number" name="telcl" placeholder="Celular" id="cel"   value="<?php if(isset($telcl)){echo $telcl;}?>"/></td>
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
                                <td >                                
                                    <input type='text' name='txt[]' value='' id="auto" class="form-field" placeholder="Codigo">                     
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
