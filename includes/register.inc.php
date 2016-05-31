<?php
include_once 'conect.php';
 
$error_msg = "";
$error_msg_cedu = "";
$error_msg_usu = "";
$error_msg_ema = "";
$error_msg_psw = "";

if (isset($_POST['cedu'],$_POST['username'], $_POST['email'], $_POST['p'], $_POST['name'], $_POST['apell'])) 
                {
    // Sanear y validar los datos provistos.
    $estd = $_POST['rol'];
    $nick = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $apell = filter_input(INPUT_POST, 'apell', FILTER_SANITIZE_STRING);
    $cedu = filter_input(INPUT_POST, 'cedu', FILTER_SANITIZE_NUMBER_INT);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    $psw = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $carg = filter_input(INPUT_POST, 'cargo', FILTER_SANITIZE_NUMBER_INT);
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
            {
        // No es un correo electrónico válido.
        $error_msg .= '<p class="error">el Correo electronico no es valido</p>';
        $error_msg_ema .= '<p class="error">el Correo electronico no es valido</p>';
             }
    if($carg==0)
    {
      $error_msg .= '<p class="error">El Cargo es invalido</p>';
      $error_msg_ema .= '<p class="error">Seleccione un cargo</p>';  
    }
 
    $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
    if (strlen($password) != 128)
        {
        // La contraseña con hash deberá ser de 128 caracteres.
        // De lo contrario, algo muy raro habrá sucedido. 
        $error_msg .= '<p class="error">Contraseña invalida o mal configurada.</p>';
        $error_msg_psw .= '<p class="error">Contraseña invalida o mal configurada.</p>';
    }
 
    // La validez del nombre de usuario y de la contraseña ha sido verificada en el cliente.
    // Esto será suficiente, ya que nadie se beneficiará de
    // violar estas reglas.
    //
 
    $stid = oci_parse($conn, 'SELECT ID_USUARIO FROM USUARIOS WHERE EMAIL = :email');
    oci_bind_by_name($stid, ":email", $email);
     
   // Verifica el correo electrónico existente.  
    if (oci_execute($stid)) 
    {
        $row = oci_fetch_object($stid);
        $cols = ocinumcols($stid);
        $fila = oci_num_rows($stid);
        $numrows = oci_fetch_all($stid, $results, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        if($fila > 0)  
        {
            // Ya existe otro usuario con este correo electrónico.
            $error_msg .= '<p class="error">El correo electronico ya existe con otro usuario.</p>';
            $error_msg_ema .= '<p class="error">El correo electronico ya existe.</p>';
           
                        
        }
            
    } 
    else 
    {
        $error_msg .= '<p class="error">error en la base de datos</p>';
        oci_free_statement($stid);
        oci_close($conn);
    }
    
     $stid = oci_parse($conn, 'SELECT ID_USUARIO FROM USUARIOS WHERE ID_USUARIO  = :cedu');
     oci_bind_by_name($stid, ':cedu', $cedu);
 
   // Verifica el correo electrónico existente.  
    if (oci_execute($stid)) 
        {
 
        $row = oci_fetch_object($stid);
        $fila = oci_num_rows($stid);
        $numrows = oci_fetch_all($stid, $results, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        if($fila > 0)   
            {
            // Ya existe otro usuario con este correo electrónico.
            $error_msg .= '<p class="error">La identificacion ya existe.</p>';
            $error_msg_cedu .= '<p class="error">La identificacion ya existe.</p>';
           
                        
            }
            
    } 
    else 
        {
        $error_msg .= '<p class="error">error en la base de datos</p>';
        oci_free_statement($stid);
        oci_close($conn);
    }
 
    // Verifica el nombre de usuario existente.
    $stid = oci_parse($conn, 'SELECT ID_USUARIO FROM USUARIOS WHERE NICK  = :nick');
    oci_bind_by_name($stid, ':nick', $nick);
  
 
    if (oci_execute($stid)) 
        {
    
        $row = oci_fetch_object($stid);
        $result = count($row);
        $fila = oci_num_rows($stid);
        $numrows = oci_fetch_all($stid, $results, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        if($fila > 0)   
                {
                        // Ya existe otro usuario con este nombre de usuario.
                        $error_msg .= '<p class="error">Ya existe otro usuario con este nombre de usuario.</p>';
                        $error_msg_usu .= '<p class="error">El usuario ya existe.</p>';
                        
                        
                }
                
        } 
        else 
            {
                $error_msg .= '<p class="error">Database error line 55</p>';
               
            }
 
    // Pendiente: 
    // También habrá que tener en cuenta la situación en la que el usuario no tenga
    // derechos para registrarse, al verificar qué tipo de usuario intenta
    // realizar la operación.
 
    if (empty($error_msg)) 
        {
        // Crear una sal aleatoria.
        //$random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE)); // Did not work
        $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true)); 
        // Crea una contraseña con sal. 
        $password = hash('sha512', $psw . $random_salt);
//        insert into USUARIOS(ID_USUARIO,NICK,NOMBRES,APELLIDOS,CONTRA,EMAIL,ID_CARGO) values ('123','juank89','Juan Carlos','Guzman E','0112358jK','juank1@gmail.com',1);
        // Inserta el nuevo usuario a la base de datos.  
        $stid = oci_parse($conn,"insert into USUARIOS(ID_USUARIO,NICK,NOMBRES,APELLIDOS,CONTRA,EMAIL,ID_CARGO,SALT) values (:cedu,:nick,:nombre,:apell,:contra,:email,:cargo,:salt)");
        oci_bind_by_name($stid, ":cedu", $cedu);
        oci_bind_by_name($stid, ":nick", $nick);
        oci_bind_by_name($stid, ":nombre", $name);
        oci_bind_by_name($stid, ":apell", $apell);
        oci_bind_by_name($stid, ":contra", $password);
        oci_bind_by_name($stid, ":email", $email);
        oci_bind_by_name($stid, ":cargo", $carg);
        oci_bind_by_name($stid, ":salt", $random_salt);
        if (oci_execute($stid)) 
        {
                oci_commit($conn);
                echo "<div id=dialog-message title=Cordinadores > <p> Cordinador Agregado Correctamente </p></div>";
        }
        else 
        {
            header('Location: ../error.php?err=Registration failure: INSERT');
        }
            
        
        }
       
    
}