<?php
require_once "Clases/respuestas.php";
require_once "Clases/pacienteClase.php";

$_respuestas = new respuestas;
$_pacientes = new pacientes;

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["page"])) {
        $pagina = $_GET["page"];
        $listaPacientes = $_pacientes->listaPacientes($pagina);
        header("Content-Type: application/json");
        echo json_encode($listaPacientes);
        http_response_code(200);
    }elseif (isset($_GET["id"])) {
        $pacienteId = $_GET["id"];
        $datosPaciente = $_pacientes->obtenerPaciente($pacienteId);
        header("Content-Type: application/json");
        echo json_encode($datosPaciente);
        http_response_code(200);
    }
    
}elseif ($_SERVER["REQUEST_METHOD"] == "POST"){
    //Recibe datos enviados 
    $postBody = file_get_contents("php://input");
    //Envia al manejador
    $datosArray = $_pacientes->post($postBody);
    //Devuelve respuesta
    header("Content-Type: application/json");
    if (isset($datosArray["result"]["error_id"])) {
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    }else {
        http_response_code(200);
    }
    echo json_encode($datosArray);

}elseif ($_SERVER["REQUEST_METHOD"] == "PUT"){
    //Recibe datos enviados 
    $postBody = file_get_contents("php://input");
    //Envia datos al manejador
    $datosArray = $_pacientes->put($postBody);
    //Devuelve respuesta
    header("Content-Type: application/json");
    if (isset($datosArray["result"]["error_id"])) {
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    }else {
        http_response_code(200);
    }
    echo json_encode($datosArray);

}elseif ($_SERVER["REQUEST_METHOD"] == "DELETE"){
    $headers = getallheaders();
    if (isset($headers["token"]) && isset($headers["pacienteId"])) {
        //Recibe datos enviados 
        $send = [
            "token" => $headers["token"],
            "pacienteId" => $headers["pacienteId"]
        ];
        $postBody = json_encode($send);
    }else {
        //Recibe datos enviados 
        $postBody = file_get_contents("php://input");
    }

    //Envia datos al manejador
    $datosArray = $_pacientes->delete($postBody);
    //Devuelve respuesta
    header("Content-Type: application/json");
    if (isset($datosArray["result"]["error_id"])) {
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    }else {
        http_response_code(200);
    }
    echo json_encode($datosArray);
}else{
    header("Content-Type: application/json");
    $datosArray = $_respuestas->error_405();
    echo json_encode($datosArray);
}
