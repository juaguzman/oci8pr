<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
include_once 'includes/login.inc.php';
include_once 'includes/functions.php';
session_start();
if(isset($_SESSION["autentificado"]))
{
  if($_SESSION["autentificado"]=="SI")
            {
             header("Location:./vistas/index.php");
             return false;
             }  
}
?>
<html>
    <head>
        <link rel="stylesheet" href="styles/login_style.css" />
        <link rel="stylesheet" href="../styles/mndstyle.css" />
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
             <form class="login" action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" method="post">
                <h1 class="login-title">Inicio de Sesion</h1>
                <input type="email" class="login-input" name="email" placeholder="Email Adress" autofocus>
                <input type="password" class="login-input" name="pass" placeholder="Password">
                <?php if(!empty($msj_nologin)){echo $msj_nologin;} 
                      if(!empty($msj_bloqueo)){echo $msj_bloqueo;}?>
                <input type="submit" value="Iniciar Session" class="login-button">
              <p class="login-lost"><a href="">Olvido su Contraseña?</a></p>
              </form>
    </body>
</html>
