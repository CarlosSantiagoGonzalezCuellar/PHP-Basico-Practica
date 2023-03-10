<?php
require_once "Conexion/conexion.php";
require_once "respuestas.php";

class pacientes extends conexion
{

    private $table = "pacientes";
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

    public function listaPacientes($pagina = 1)
    {
        $inicio = 0;
        $cantidad = 100;
        if ($pagina > 1) {
            $inicio = ($cantidad * ($pagina - 1)) + 1;
            $cantidad = $cantidad * $pagina;
        }

        $query = "SELECT PacienteId, Nombre, DNI, Telefono, Correo FROM " . $this->table . " limit $inicio, $cantidad";
        $datos = parent::obtenerDatos($query);
        return $datos;
    }

    public function obtenerPaciente($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE PacienteId = '$id'";
        return parent::obtenerDatos($query);
    }

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

    private function insertarPaciente()
    {
        $query = "INSERT INTO " . $this->table . " (DNI, Nombre, Direccion, CodigoPostal, Telefono, Genero, FechaNacimiento, Correo, Imagen) 
        VALUES ('" . $this->dni . "', '" . $this->nombre . "', '" . $this->direccion . "', '" . $this->codigoPostal . "', '" . $this->telefono .
            "', '" . $this->genero . "', '" . $this->fechaNacimiento . "', '" . $this->correo . "', '" . $this->imagen . "')";
        $resp = parent::nonQueryId($query);
        if ($resp) {
            return $resp;
        } else {
            return 0;
        }
    }

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

    private function modificarPaciente()
    {
        $query = "UPDATE " . $this->table . " SET Nombre = '" . $this->nombre . "', Direccion = '" . $this->direccion . "', DNI = '" . $this->dni . "', CodigoPostal = '" . $this->codigoPostal .
            "', Telefono = '" . $this->telefono . "', Genero = '" . $this->genero . "', FechaNacimiento = '" . $this->fechaNacimiento . "', Correo = '" . $this->correo . "' 
        WHERE PacienteId = '" . $this->pacienteId . "'";

        $resp = parent::nonQuery($query);
        if ($resp >= 1) {
            return $resp;
        } else {
            return 0;
        }
    }

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

    private function eliminarPaciente()
    {
        $query = "DELETE FROM " . $this->table . " WHERE PacienteId = '" . $this->pacienteId . "'";

        $resp = parent::nonQuery($query);
        if ($resp >= 1) {
            return $resp;
        } else {
            return 0;
        }
    }

    private function buscarToken()
    {
        $query = "SELECT TokenId, UsuarioId, Estado FROM usuarios_token WHERE Token = '" . $this->token . "' AND Estado = 'Activo'";
        $resp = parent::obtenerDatos($query);
        if ($resp) {
            return $resp;
        } else {
            return 0;
        }
    }

    private function actualizarToken($tokenId)
    {
        $date = date("Y-m-d H:i");
        $query = "SELECT usuarios_token SET Fecha = '$date' WHERE TokenId = '$tokenId'";
        $resp = parent::nonQuery($query);
        if ($resp >= 1) {
            return $resp;
        } else {
            return 0;
        }
    }
}
