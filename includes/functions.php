<?php
include_once 'conect.php';
 
/*
 * Funcion de inicio de secion segura
 */
function sec_session_start()
{
    $session_name = 'sec_session_id';   // Configura un nombre de sesión personalizado.
    $secure = SECURE;
    // Esto detiene que JavaScript sea capaz de acceder a la identificación de la sesión.
    $httponly = true;
    // Obliga a las sesiones a solo utilizar cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) 
            {
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }
    // Obtiene los params de los cookies actuales.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"],
        $cookieParams["path"], 
        $cookieParams["domain"], 
        $secure,
        $httponly);
    // Configura el nombre de sesión al configurado arriba.
    session_name($session_name);
    session_start();            // Inicia la sesión PHP.
    session_regenerate_id();    // Regenera la sesión, borra la previa. 
}

/*
 * Funcion de logeo para una conexion segura a la aplicacion
 */
function login($email, $password, $mysqli) 
        {
    // Usar declaraciones preparadas significa que la inyección de SQL no será posible.
    if ($stmt = $mysqli->prepare("SELECT id, username, password, salt,rol FROM members WHERE email = ? LIMIT 1")) 
            {
        $stmt->bind_param('s', $email);  // Une “$email” al parámetro.
        $stmt->execute();    // Ejecuta la consulta preparada.
        $stmt->store_result();
 
        // Obtiene las variables del resultado.
        $stmt->bind_result($user_id, $username, $db_password, $salt,$rol);
        $stmt->fetch();
 
        // Hace el hash de la contraseña con una sal única.
        $password = hash('sha512', $password . $salt);
        if ($stmt->num_rows == 1) 
            {
            // Si el usuario existe, revisa si la cuenta está bloqueada
            // por muchos intentos de conexión.
 
            if (checkbrute($user_id, $mysqli) == true) 
            {
                // La cuenta está bloqueada.
                // Envía un correo electrónico al usuario que le informa que su cuenta está bloqueada.
                return false;
            } 
            else 
                {
                // Revisa que la contraseña en la base de datos coincida 
                // con la contraseña que el usuario envió.
                if ($db_password == $password)
                    {
                    // ¡La contraseña es correcta!
                    // Obtén el agente de usuario del usuario.
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    //  Protección XSS ya que podríamos imprimir este valor.
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                    $_SESSION['user_id'] = $user_id;
                    // Protección XSS ya que podríamos imprimir este valor.
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);
                    $_SESSION['username'] = $username;
                    $_SESSION['rol'] = $rol;
                    $_SESSION['login_string'] = hash('sha512',$password . $user_browser);
                    $_SESSION['reconf']=FALSE;
                    // Inicio de sesión exitoso
                    return true;
                } 
                else 
                    {
                    // La contraseña no es correcta.
                    // Se graba este intento en la base de datos.
                    $now = time();
                    
                    $mysqli->query("INSERT INTO login_attempts(user_id, time)VALUES ('$user_id', $now)");
                    return false;
                    }
            }
        }
        else 
            {
            // El usuario no existe.
            return false;
        }
    }
}

/*
 * funcion para prevenir ataques de fuerza bruta
 */
function checkbrute($user_id) 
        {
    include 'conect.php';
    // Obtiene el timestamp del tiempo actual.
    $now = time();
 
    // Todos los intentos de inicio de sesión se cuentan desde las 2 horas anteriores.
    $valid_attempts = $now - (2 * 60 * 60);
 
    $stid = oci_parse($conn, 'SELECT count(TIEMPO) time FROM LOGINS WHERE ID_USUARIO = :id_us AND TIEMPO > :t_time');

        oci_bind_by_name($stid, ':id_us', $user_id);
        oci_bind_by_name($stid, ':t_time', $valid_attempts);
        oci_execute($stid);
        // Si ha habido más de 5 intentos de inicio de sesión fallidos.
        $row = oci_fetch_object($stid);
        $sali = $row->TIME;
        if ($sali > 5) 
        {
            return true;
        } 
        else 
        {
            return false;
        }
    
}

/*
 * Funcion que revisa si existe o no una session inisiada
 */
function login_check($mysqli) 
{
    // Revisa si todas las variables de sesión están configuradas.
    if (isset($_SESSION['user_id'], 
                        $_SESSION['username'],
                        $_SESSION['rol'],
                        $_SESSION['login_string'])) {
 
        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];
        $band=$_SESSION['reconf'];
 
        // Obtiene la cadena de agente de usuario del usuario.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
 
        if ($stmt = $mysqli->prepare("SELECT password 
                                      FROM members 
                                      WHERE id = ? LIMIT 1")) {
            // Une “$user_id” al parámetro.
            $stmt->bind_param('i', $user_id);
            $stmt->execute();   // Ejecuta la consulta preparada.
            $stmt->store_result();
 
            if ($stmt->num_rows == 1) {
                // Si el usuario existe, obtiene las variables del resultado.
                $stmt->bind_result($password);
                $stmt->fetch();
                $login_check = hash('sha512', $password . $user_browser);
 
                if ($login_check == $login_string) {
                    // ¡¡Conectado!! 
                    return true;
                } else {
                    // No conectado.
                    return false;
                }
            } else {
                // No conectado.
                return false;
            }
        } else {
            // No conectado.
            return false;
        }
    } else {
        // No conectado.
        return false;
    }
}

/*
 * función sanea la salida de la variable del servidor PHP_SELF.
 */
function esc_url($url) {
 
    if ('' == $url) {
        return $url;
    }
 
    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
 
    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;
 
    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }
 
    $url = str_replace(';//', '://', $url);
 
    $url = htmlentities($url);
 
    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);
 
    if ($url[0] !== '/') {
        // Solo nos interesan los enlaces relativos de  $_SERVER['PHP_SELF']
        return '';
    } else {
        return $url;
    }
}