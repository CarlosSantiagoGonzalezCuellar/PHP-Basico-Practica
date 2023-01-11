<?php
require_once "Conexion/conexion.php";
require_once "respuestas.php";

class pacientes extends conexionBd
{

    private $pacienteId = "";
    private $dni = "";
    private $nombre = "";
    private $direccion = "";
    private $codigoPostal = "";
    private $genero = "";
    private $telefono = "";
    private $fechaNacimiento = "0000-00-00";
    private $correo = "";
    private $token = "";
    private $imagen = "";

    //<-- ========== LISTAR PACIENTES POR PAGINA DE 100 EN 100 ========== -->
    public function listaPacientes($pagina = 1)
    {
        $_pdo = new conexionBd;
        $inicio = 0;
        $cantidad = 100;
        if ($pagina > 1) {
            $inicio = ($cantidad * ($pagina - 1)) + 1;
            $cantidad = $cantidad * $pagina;
        }

        $sql = $_pdo->prepare("SELECT * FROM pacientes LIMIT $inicio, $cantidad");
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $datos = $sql->fetchAll();
        $resultArray = array();

        foreach ($datos as $key) {
            $resultArray[] = $key;
        }
        $resp = $this->convertirUtf8($resultArray);
        return $resp;
    }

    //<-- ========== OBTENER PACIENTE EN ESPECIFIO SEGUN SU ID ========== -->
    public function obtenerPaciente($id)
    {
        $_pdo = new conexionBd;
        $sql = $_pdo->prepare("SELECT * FROM pacientes WHERE pacienteId=:id");
        $sql->bindValue(':id', $id);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $datos = $sql->fetchAll();
        $resultArray = array();

        foreach ($datos as $key) {
            $resultArray[] = $key;
        }
        $resp = $this->convertirUtf8($resultArray);
        return $resp;
    }

    //<-- ========== METODO POST CON VALIDACIONES ========== -->
    public function post($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);

        if (!isset($datos["token"])) {
            return $_respuestas->error_401();
        } else {
            $this->token = $datos["token"];
            $arrayToken = $this->buscarToken();
            if ($arrayToken) {
                if (!isset($datos["nombre"]) || !isset($datos["dni"]) || !isset($datos["correo"])) {
                    return $_respuestas->error_400();
                } else {
                    $this->nombre = $datos["nombre"];
                    $this->dni = $datos["dni"];
                    $this->correo = $datos["correo"];
                    if (isset($datos["telefono"])) {
                        $this->telefono = $datos["telefono"];
                    }
                    if (isset($datos["direccion"])) {
                        $this->direccion = $datos["direccion"];
                    }
                    if (isset($datos["codigoPostal"])) {
                        $this->codigoPostal = $datos["codigoPostal"];
                    }
                    if (isset($datos["genero"])) {
                        $this->genero = $datos["genero"];
                    }
                    if (isset($datos["fechaNacimiento"])) {
                        $this->fechaNacimiento = $datos["fechaNacimiento"];
                    }
                    if (isset($datos["imagen"])) {
                        $resp = $this->procesarImagen($datos["imagen"]);
                        $this->imagen = $resp;
                    }
                    $resp = $this->insertarPaciente();
                    if ($resp) {
                        $respuesta = $_respuestas->response;
                        $respuesta["result"] = array(
                            "pacienteId" => $resp
                        );
                        return $respuesta;
                    } else {
                        return $_respuestas->error_500();
                    }
                }
            } else {
                return $_respuestas->error_401("El token enviado es invalido o ha caducado!!");
            }
        }
    }

    //<-- ========== METODO PARA PROCESAR IMAGEN CON BASE64 ========== -->
    private function procesarImagen($img)
    {
        $direccion = dirname(__DIR__) . "\Public\Img\\";
        $partes = explode(";base64,", $img);
        $extension = explode("/", mime_content_type($img))[1];
        $imagenBase64 = base64_decode($partes[1]);
        $file = $direccion . uniqid() . "." . $extension;
        file_put_contents($file, $imagenBase64);
        $nuevaDireccion = str_replace("\\", "/", $file);

        return $nuevaDireccion;
    }

    //<-- ========== METODO PARA AÑADIR NUEVO PACIENTE ========== -->
    private function insertarPaciente()
    {
        $_pdo = new conexionBd;
        $sql = $_pdo->prepare("INSERT INTO pacientes (DNI, Nombre, Direccion, CodigoPostal, Telefono, Genero, FechaNacimiento, Correo, Imagen) 
        VALUES (:dni, :nombre, :direccion, :codigoPostal, :telefono, :genero, :fechaNacimiento, :correo, :imagen)");
        $sql->bindValue(':dni', $this->dni);
        $sql->bindValue(':nombre', $this->nombre);
        $sql->bindValue(':direccion', $this->direccion);
        $sql->bindValue(':codigoPostal', $this->codigoPostal);
        $sql->bindValue(':telefono', $this->telefono);
        $sql->bindValue(':genero', $this->genero);
        $sql->bindValue(':fechaNacimiento', $this->fechaNacimiento);
        $sql->bindValue(':correo', $this->correo);
        $sql->bindValue(':imagen', $this->imagen);
        $sql->execute();
        $respuesta = $sql;
        if ($respuesta == true) {
            $resp = $_pdo->lastInsertId();
        } else {
            $resp = 0;
        }

        if ($resp) {
            return $resp;
        } else {
            return 0;
        }
    }

    //<-- ========== METODO PUT CON VALIDACIONES ========== -->
    public function put($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);

        if (!isset($datos["token"])) {
            return $_respuestas->error_401();
        } else {
            $this->token = $datos["token"];
            $arrayToken = $this->buscarToken();
            if ($arrayToken) {
                if (!isset($datos["pacienteId"])) {
                    return $_respuestas->error_400();
                } else {
                    $this->pacienteId = $datos["pacienteId"];
                    if (isset($datos["nombre"])) {
                        $this->nombre = $datos["nombre"];
                    }
                    if (isset($datos["dni"])) {
                        $this->dni = $datos["dni"];
                    }
                    if (isset($datos["correo"])) {
                        $this->correo = $datos["correo"];
                    }
                    if (isset($datos["telefono"])) {
                        $this->telefono = $datos["telefono"];
                    }
                    if (isset($datos["direccion"])) {
                        $this->direccion = $datos["direccion"];
                    }
                    if (isset($datos["codigoPostal"])) {
                        $this->codigoPostal = $datos["codigoPostal"];
                    }
                    if (isset($datos["genero"])) {
                        $this->genero = $datos["genero"];
                    }
                    if (isset($datos["fechaNacimiento"])) {
                        $this->fechaNacimiento = $datos["fechaNacimiento"];
                    }
                    $resp = $this->modificarPaciente();
                    if ($resp) {
                        $respuesta = $_respuestas->response;
                        $respuesta["result"] = array(
                            "pacienteId" => $this->pacienteId
                        );
                        return $respuesta;
                    } else {
                        return $_respuestas->error_500();
                    }
                }
            } else {
                return $_respuestas->error_401("El token enviado es invalido o ha caducado!!");
            }
        }
    }

    //<-- ========== METODO PARA MODIFICAR UN PACIENTE SEGUN SU ID ========== -->
    private function modificarPaciente()
    {
        $_pdo = new conexionBd;
        $sql = $_pdo->prepare("UPDATE pacientes SET DNI=:dni, Nombre=:nombre, Direccion=:direccion, CodigoPostal=:codigoPostal, 
        Telefono=:telefono, Genero=:genero, FechaNacimiento=:fechaNacimiento, Correo=:correo, Imagen=:imagen 
        WHERE PacienteId=:id");
        $sql->bindValue(':dni', $this->dni);
        $sql->bindValue(':nombre', $this->nombre);
        $sql->bindValue(':direccion', $this->direccion);
        $sql->bindValue(':codigoPostal', $this->codigoPostal);
        $sql->bindValue(':telefono', $this->telefono);
        $sql->bindValue(':genero', $this->genero);
        $sql->bindValue(':fechaNacimiento', $this->fechaNacimiento);
        $sql->bindValue(':correo', $this->correo);
        $sql->bindValue(':imagen', $this->imagen);
        $sql->bindValue(':id', $this->pacienteId);
        $sql->execute();

        $resp = $sql;
        if ($resp == true) {
            return $resp;
        } else {
            return 0;
        }
    }

    //<-- ========== METODO DELETE CON VALIDACIONES ========== -->
    public function delete($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);

        if (!isset($datos["token"])) {
            return $_respuestas->error_401();
        } else {
            $this->token = $datos["token"];
            $arrayToken = $this->buscarToken();
            if ($arrayToken) {
                if (!isset($datos["pacienteId"])) {
                    return $_respuestas->error_400();
                } else {
                    $this->pacienteId = $datos["pacienteId"];

                    $resp = $this->eliminarPaciente();
                    if ($resp) {
                        $respuesta = $_respuestas->response;
                        $respuesta["result"] = array(
                            "pacienteId" => $this->pacienteId
                        );
                        return $respuesta;
                    } else {
                        return $_respuestas->error_500();
                    }
                }
            } else {
                return $_respuestas->error_401("El token enviado es invalido o ha caducado!!");
            }
        }
    }

    //<-- ========== METODO PARA ELIMINAR UN PACIENTE SEGUN SU ID ========== -->
    private function eliminarPaciente()
    {
        $_pdo = new conexionBd;
        $sql = $_pdo->prepare("DELETE FROM pacientes WHERE PacienteId=:id");
        $sql->bindValue(':id', $this->pacienteId);
        $sql->execute();

        $resp = $sql;
        if ($resp == true) {
            return $resp;
        } else {
            return 0;
        }
    }

    //<-- ========== METODO PARA OBTENER EL TOKEN ========== -->
    private function buscarToken()
    {
        $_pdo = new conexionBd;
        $sql = $_pdo->prepare("SELECT TokenId, UsuarioId, Estado FROM usuarios_token WHERE Token = :token AND Estado = 'Activo'");
        $sql->bindValue(':token', $this->token);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $datos = $sql->fetchAll();
        $resultArray = array();

        foreach ($datos as $key) {
            $resultArray[] = $key;
        }
        $resp = $this->convertirUtf8($resultArray);
        if ($resp) {
            return $resp;
        } else {
            return 0;
        }
    }
}
