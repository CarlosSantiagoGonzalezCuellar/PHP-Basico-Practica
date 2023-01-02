<?php
    require_once '../Clases/token.php';
    $_token = new token;
    $fecha = date('Y-m-d H:i');
    echo $_token->actualizarTokens($fecha);
?>