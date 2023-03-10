<?php
require_once "Conexion/conexion.php";
require_once "respuestas.php";

class auth extends conexionBd
{
    //<!-- ========== METODO DE INICIO DE SESION PARA OBTENER TOKEN DE AUTORIZACION ========== -->
    public function login($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);
        if (!isset($datos["usuario"]) || !isset($datos["password"])) {
            // error en los campos
            return $_respuestas->error_400();
        } else {
            // todo esta bien
            $usuario = $datos["usuario"];
            $password = $datos["password"];
            $password = parent::encriptar($password);
            $datos = $this->obtenerDatosUsuario($usuario);
            if ($datos) {
                // Verificar si la contraseña es igual
                if ($password == $datos[0]["Password"]) {
                    if ($datos[0]["Estado"] == "Activo") {
                        $verificar = $this->insertarToken($datos[0]["UsuarioId"]);
                        if ($verificar) {
                            //Se guardo
                            $result = $_respuestas->response;
                            $result["result"] = array(
                                "token" => $verificar
                            );
                            return $result;
                        } else {
                            //No se guardo
                            return $_respuestas->error_500("Error interno, no se ha podido guardar!!");
                        }
                    } else {
                        //Usuario inactivo
                        return $_respuestas->error_200("Usuario inactivo!!");
                    }
                } else {
                    //Contraseña incorrecta
                    return $_respuestas->error_200("La contraseña es invalida!!");
                }
            } else {
                // Si no existe el usuario
                return $_respuestas->error_200("El usuario $usuario no existe!!");
            }
        }
    }

    //<!-- ========== METODO PARA OBTENER USUARIOS CON SU CORREO Y CONTRASEÑA ========== -->
    public function obtenerDatosUsuario($correo)
    {
        $_pdo = new conexionBd;

        $sql = $_pdo->prepare("SELECT * FROM usuarios WHERE Usuario = :correo");
        $sql->bindValue(':correo', $correo);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $datos = $sql->fetchAll();
        $resultArray = array();

        foreach ($datos as $key) {
            $resultArray[] = $key;
        }

        $resp = $this->convertirUtf8($resultArray);
        if (isset($resp[0]["UsuarioId"])) {
            return $resp;
        } else {
            return 0;
        }
    }

    //<!-- ========== METODO PARA AGREGAR EL TOKEN CREADO ========== -->
    private function insertarToken($usuarioId)
    {
        $_pdo = new conexionBd;
        $val = true;
        $token = bin2hex(openssl_random_pseudo_bytes(16, $val));
        $fecha = date("Y-m-d H:i");
        $estado = "Activo";
        $sql = $_pdo->prepare("INSERT INTO usuarios_token (UsuarioId, Token, Estado, Fecha) VALUES (:usuarioId, :token, :estado, :fecha)");
        $sql->bindValue(':usuarioId', $usuarioId);
        $sql->bindValue(':token', $token);
        $sql->bindValue(':estado', $estado);
        $sql->bindValue(':fecha', $fecha);
        $sql->execute();
        $verifica = $sql;

        if ($verifica) {
            return $token;
        } else {
            return 0;
        }
    }
}
