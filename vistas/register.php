<?php
include_once '../includes/register.inc.php';
include_once '../includes/functions.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Secure Login: Formulario de registro</title>
        <script type="text/JavaScript" src="../js/sha512.js"></script> 
        <script type="text/JavaScript" src="../js/forms.js"></script>
        <link rel="stylesheet" href="../styles/login_style.css" />
        <link rel="stylesheet" href="../styles/mndstyle.css" />
        <link rel="stylesheet" href="../styles/jquery-ui.css" />
         <script src="http://code.jquery.com/jquery-1.8.2.js"></script>
        <script src="/resources/demos/external/jquery.bgiframe-2.1.2.js"></script>
        <script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>
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
        <!-- Formulario de registro que se emitirá si las variables POST no se
          establecen o si la secuencia de comandos de registro ha provocado un error. -->
        <div class="mnd">
             <?php
        if (!empty($error_msg))
            {
            echo $error_msg;
             }
        ?>
    
          <form class="login" action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>"  method="post" name="registration_form">
           
            <h1 class="login-title">Registro Usuarios</h1>
            <?php if (!empty($error_msg_cedu)) { echo $error_msg_cedu;} ?>
            <input class="login-input" type="number" name="cedu" id="cedu" required placeholder="Cedula"/><br>
            <input class="login-input" type='text'name='name' id='name' required="" maxlength="45" placeholder="Nombres" /><br>
            <input class="login-input" type='text'name='apell' id='apell' required="" maxlength="45" placeholder="Apellidos" /><br>
            <?php if (!empty($error_msg_usu)) { echo $error_msg_usu;} ?> 
            <input class="login-input" type='text'name='username' id='username' required="" placeholder="Nombre de Usuario" /><br>
            <?php if (!empty($error_msg_ema)) { echo $error_msg_ema;} ?>
            <input class="login-input" type="text" name="email" id="email" required placeholder="Email" /><br>
            <?php if (!empty($error_msg_psw)) { echo $error_msg_psw;} ?>
            <input class="login-input" type="password" name="password" id="password" required placeholder="Contraseña"/><br>
            <input class="login-input" type="password" name="confirmpwd" id="confirmpwd" required/><br>
          
            <select name="cargo" class="login-input">
                <option value="1">Seleccione una Opcion</option>
                <option value="1">Encargado</option>
                <option value="2">Vendedor</option>
            </select>
            
          
            <input type="hidden" value="usua" name="rol"/>
            <input class="login-button" type="button" value="Register" onclick="return regformhash(this.form,this.form.username,this.form.email,this.form.password,this.form.confirmpwd);" /> 
           
        </form>
        
       
            <div>
                 <h1 class="login-title">ayuda de Creacion</h1>
        <ul>
            <li> Los nombres de usuario podrían contener solo dígitos, letras mayúsculas, minúsculas y guiones bajos.</li>
            <li> Los correos electrónicos deberán tener un formato válido. </li>
            <li> Las contraseñas deberán tener al menos 6 caracteres.</li>
            <li>Las contraseñas deberán estar compuestas por:
                <ul>
                    <li> Por lo menos una letra mayúscula (A-Z)</li>
                    <li> Por lo menos una letra minúscula (a-z)</li>
                    <li> Por lo menos un número (0-9)</li>
                </ul>
            </li>
            <li> La contraseña y la confirmación deberán coincidir exactamente.</li>
        </ul>
             </div>
        </div> 
    </body>
</html>