<?php
require_once "./Clases/authClase.php";
require_once "./Clases/Conexion/conexion.php";
require_once "./Clases/respuestas.php";

$_auth = new auth;
$_pdo = new conexionBd;
$_respuestas = new respuestas;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Recibe datos enviados 
    $postBody = file_get_contents("php://input");
    //Envia datos al manejador
    $datosArray = $_auth->login($postBody);
    //Devuelve respuesta
    header("Content-Type: application/json");
    if (isset($datosArray["result"]["error_id"])) {
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    } else {
        http_response_code(200);
    }
    echo json_encode($datosArray);

    /*//PARA UTILIZAR CON HEADER
    $headers = getallheaders();
    if (isset($headers["usuario"]) && isset($headers["password"])) {
        //Recibe datos enviados 
        $send = [
            "usuario" => $headers["usuario"],
            "password" => $headers["password"]
        ];
        $postBody = json_encode($send);
    } else {
        //Recibe datos enviados 
        $postBody = file_get_contents("php://input");
    }*/
} else {
    header("Content-Type: application/json");
    $datosArray = $_respuestas->error_405();
    echo json_encode($datosArray);
}
