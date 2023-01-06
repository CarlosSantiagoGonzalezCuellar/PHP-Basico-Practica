<?php
include "Clases/Conexion/conexion.php";
require_once "Clases/respuestas.php";
//require_once "Clases/pacienteClase.php";
$_pdo = new conexionBd();
$_respuestas = new respuestas;
//$_pacientes = new pacientes;

//Listar registros y consultar registro de pacientes
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
        $sql = $_pdo->prepare("SELECT * FROM pacientes WHERE pacienteId=:id");
        $sql->bindValue(':id', $_GET['id']);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        header("Content-Type: application/json");
        echo json_encode($sql->fetchAll());
        http_response_code(200);
    } else {

        $sql = $_pdo->prepare("SELECT * FROM pacientes");
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        header("Content-Type: application/json");
        echo json_encode($sql->fetchAll());
        http_response_code(200);
    }

//Agregar registros de pacientes
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "INSERT INTO pacientes (DNI, Nombre, Direccion, CodigoPostal, Telefono, Genero, FechaNacimiento, Correo, Imagen) 
        VALUES (:dni, :nombre, :direccion, :codigoPostal, :telefono, :genero, :fechaNacimiento, :correo, :imagen)";
    $stmt = $_pdo->prepare($sql);
    $stmt->bindValue(':dni', $_POST['dni']);
    $stmt->bindValue(':nombre', $_POST['nombre']);
    $stmt->bindValue(':direccion', $_POST['direccion']);
    $stmt->bindValue(':codigoPostal', $_POST['codigoPostal']);
    $stmt->bindValue(':telefono', $_POST['telefono']);
    $stmt->bindValue(':genero', $_POST['genero']);
    $stmt->bindValue(':fechaNacimiento', $_POST['fechaNacimiento']);
    $stmt->bindValue(':correo', $_POST['correo']);
    $stmt->bindValue(':imagen', $_POST['imagen']);
    $stmt->execute();
    $idPost = $_pdo->lastInsertId();
    if ($idPost) {
        header("Content-Type: application/json");
        echo json_encode($idPost);
        http_response_code(200);
    }

//Actualizar registros de pacientes
} elseif ($_SERVER["REQUEST_METHOD"] == "PUT") {
    $sql = "UPDATE pacientes SET DNI=:dni, Nombre=:nombre, Direccion=:direccion, CodigoPostal=:codigoPostal, 
        Telefono=:telefono, Genero=:genero, FechaNacimiento=:fechaNacimiento, Correo=:correo, Imagen=:imagen 
        WHERE PacienteId=:id";
    $stmt = $_pdo->prepare($sql);
    $stmt->bindValue(':dni', $_GET['dni']);
    $stmt->bindValue(':nombre', $_GET['nombre']);
    $stmt->bindValue(':direccion', $_GET['direccion']);
    $stmt->bindValue(':codigoPostal', $_GET['codigoPostal']);
    $stmt->bindValue(':telefono', $_GET['telefono']);
    $stmt->bindValue(':genero', $_GET['genero']);
    $stmt->bindValue(':fechaNacimiento', $_GET['fechaNacimiento']);
    $stmt->bindValue(':correo', $_GET['correo']);
    $stmt->bindValue(':imagen', $_GET['imagen']);
    $stmt->bindValue(':id', $_GET['id']);
    $stmt->execute();
    $idPut = $_GET['id'];
    if ($idPut) {
        header("Content-Type: application/json");
        echo json_encode($idPut);
        http_response_code(200);
    }

//Eliminar registros de pacientes
} elseif ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    $sql = "DELETE FROM pacientes WHERE pacienteId=:id";
    $stmt = $_pdo->prepare($sql);
    $stmt->bindValue(':id', $_GET['id']);
    $stmt->execute();
    $idDelete = $_GET['id'];
    if ($idDelete) {
        header("Content-Type: application/json");
        echo json_encode($idDelete);
        http_response_code(200);
    }
} else {
    header("Content-Type: application/json");
    $datosArray = $_respuestas->error_405();
    echo json_encode($datosArray);
}

/*

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["page"])) {
        $pagina = $_GET["page"];
        $listaPacientes = $_pacientes->listaPacientes($pagina);
        header("Content-Type: application/json");
        echo json_encode($listaPacientes);
        http_response_code(200);
    } elseif (isset($_GET["id"])) {
        $pacienteId = $_GET["id"];
        $datosPaciente = $_pacientes->obtenerPaciente($pacienteId);
        header("Content-Type: application/json");
        echo json_encode($datosPaciente);
        http_response_code(200);
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Recibe datos enviados 
    $postBody = file_get_contents("php://input");
    //Envia al manejador
    $datosArray = $_pacientes->post($postBody);
    //Devuelve respuesta
    header("Content-Type: application/json");
    if (isset($datosArray["result"]["error_id"])) {
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    } else {
        http_response_code(200);
    }
    echo json_encode($datosArray);
} elseif ($_SERVER["REQUEST_METHOD"] == "PUT") {
    //Recibe datos enviados 
    $postBody = file_get_contents("php://input");
    //Envia datos al manejador
    $datosArray = $_pacientes->put($postBody);
    //Devuelve respuesta
    header("Content-Type: application/json");
    if (isset($datosArray["result"]["error_id"])) {
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    } else {
        http_response_code(200);
    }
    echo json_encode($datosArray);
} elseif ($_SERVER["REQUEST_METHOD"] == "DELETE") {
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
} else {
    header("Content-Type: application/json");
    $datosArray = $_respuestas->error_405();
    echo json_encode($datosArray);
}*/
