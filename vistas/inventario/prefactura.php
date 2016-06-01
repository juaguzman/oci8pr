<?php
include_once 'conect.php';

$error_msg = "";


if (isset($_POST['ceduvd'],$_POST['usern'],$_POST['ceduc1'],$_POST['nomc1'],$_POST['dirc1'],$_POST['telc1'],$_POST['id[]'],$_POST['pventa'],$_POST['cantidadC'] )) 
{
    $ceduvd = filter_input(INPUT_POST, 'ceduvd', FILTER_SANITIZE_NUMBER_INT);
    $usern = filter_input(INPUT_POST, 'usern', FILTER_SANITIZE_STRING);
    $cedcl = filter_input(INPUT_POST, 'cedc1', FILTER_SANITIZE_NUMBER_INT);
    $nomcl = filter_input(INPUT_POST, 'nomc1', FILTER_SANITIZE_STRING);
    $dircl = filter_input(INPUT_POST, 'dirc1', FILTER_SANITIZE_STRING);
    $telc1 = filter_input(INPUT_POST, 'telc1', FILTER_SANITIZE_NUMBER_INT);
    $idV = $_POST[ 'id[]'];
    $pventa = $_POST['pventa[]'];
    $cantidadC = $_POST['cantidadC[]'];
    
    
}

 