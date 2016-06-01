<?php
include_once 'conect.php';

$error_msg = "";
$error_msg_ceduvd = "";
$error_msg_usern = "";

if (isset($_POST['ceduvd'],$_POST['usern'])) 
{
     $ceduvd = filter_input(INPUT_POST, 'ceduvd', FILTER_SANITIZE_NUMBER_INT);
    $usern = filter_input(INPUT_POST, 'usern', FILTER_SANITIZE_STRING);
}
if (empty($error_msg)) 
{
     oci_bind_by_name($stid,":ceduvd", $ceduvd);
     oci_bind_by_name($stid, ":usern", $usern);
}
 