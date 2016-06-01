<?php
include_once '../../includes/conect.php';

$error_msg = "";


if (isset($_POST['ceduvd'],$_POST['usern'],$_POST['ceducl'],$_POST['nomcl'],$_POST['dircl'],$_POST['telcl'])) 
{
    $ceduvd = filter_input(INPUT_POST, 'ceduvd', FILTER_SANITIZE_NUMBER_INT);
    $usern = filter_input(INPUT_POST, 'usern', FILTER_SANITIZE_STRING);
    $cedcl = filter_input(INPUT_POST, 'ceducl', FILTER_SANITIZE_NUMBER_INT);
    $nomcl = filter_input(INPUT_POST, 'nomcl', FILTER_SANITIZE_STRING);
    $dircl = filter_input(INPUT_POST, 'dircl', FILTER_SANITIZE_STRING);
    $telc1 = filter_input(INPUT_POST, 'telcl', FILTER_SANITIZE_NUMBER_INT);
    $idV = $_POST[ 'id'];
    $pventa = $_POST['pventa'];
    $cantidadC = $_POST['cantidadC'];
    

}

 