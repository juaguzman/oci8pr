<?php
include 'conect.php';
include 'functions.php';

if(isset($_POST['email'], $_POST['pass'] ))
{
    $sum=0;
$msj_bloqueo="";
$msj_nologin="";
$email = $_POST['email'];
$pass = $_POST['pass'];


$stid = oci_parse($conn, 'SELECT * FROM USUARIOS WHERE EMAIL = :id_em AND rownum = 1');

oci_bind_by_name($stid, ':id_em', $email);
oci_execute($stid);
//oci_fetch_all($stid, $res);

$row = oci_fetch_object($stid);
$sum = count($row);
$fila = oci_num_rows($stid);
if(!empty($row))
{
    $user_id = $row -> ID_USUARIO;
    $nick = $row -> NICK;
    $salt = $row -> SALT;
    $cargo = $row -> ID_CARGO;
    $db_passw= $row -> CONTRA;
    // Use nombres de atributo en mayúsculas para cada columna estándar de Oracle
    // Use el nombre exacto para nombres de columnas sensibles al uso de mayúsculas/minúsculas 
    $password = hash('sha512', $pass . $salt);
    
    if(checkbrute($user_id)==TRUE)
    {
     $msj_bloqueo= '<p class="error">Cuenta bloqueada por demaciados intentos de ingreso.</p>';
     return FALSE; 
    }
    else
    {
      if($db_passw == $password)
      {
        // ¡La contraseña es correcta!
                    // Obtén el agente de usuario del usuario.
                    session_start();
                    $_SESSION["autentificado"]="SI";    
              //    $_SESSION['usua']= $row->NOMBRES;
                    $_SESSION["ultimoAcceso"] =date("Y-n-j H:i:s");
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    //  Protección XSS ya que podríamos imprimir este valor.
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                    $_SESSION['user_id'] = $user_id;
                    // Protección XSS ya que podríamos imprimir este valor.
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $nick);
                    $_SESSION['username'] = $username;
                    $_SESSION['rol'] = $cargo;
                    $_SESSION['login_string'] = hash('sha512',$password . $user_browser);
                    $_SESSION['reconf']=FALSE;
                    $_SESSION["autentificado"]="SI";
                    // Inicio de sesión exitoso
                    header('Location: vistas/index.php');
      }
      else
      {
          include 'conect.php';
          $now = time();          
          $stid = oci_parse($conn, 'insert into LOGINS(ID_LOG,ID_USUARIO,TIEMPO,FECHA) VALUES ((select max(ID_LOG) FROM LOGINS)+1, :id_user, :t_log, SYSTIMESTAMP)');
          oci_bind_by_name($stid, ":id_user", $user_id);
          oci_bind_by_name($stid, ":t_log", $now);
          oci_commit($conn);
         if(oci_execute($stid))
         {
          $msj_nologin='<p class="error">Nombre de ususario o contrsaña incorrectos</p>';
         }
        else 
            {
            $msj_nologin='<p class="error">Error de insersion en la base de datos</p>';
            }
      }
    }
}
else
{
  $msj_nologin='<p class="error">Nombre de ususario o contrsaña incorrectos</p>';   
}

//print $cant ;
// La salida es
//    Kochhar
oci_free_statement($stid);
oci_close($conn);

}


//    session_start();
//    $_SESSION["autentificado"]="SI";    
//    $_SESSION['usua']= $row->NOMBRES;
//    $_SESSION["ultimoAcceso"] =date("Y-n-j H:i:s");
//    header("Location:../vistas/index.php");