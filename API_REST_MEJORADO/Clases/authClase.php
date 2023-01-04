<?php
require_once "Conexion/conexion.php";
require_once "respuestas.php";

class auth extends conexionBd{
    public function login($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);
        if (!isset($datos["usuario"]) || !isset($datos["password"])) {
            // error en los campos
            return $_respuestas->error_400();
        }else {
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
                        }else {
                            //No se guardo
                            return $_respuestas->error_500("Error interno, no se ha podido guardar!!");
                        }
                    }else {
                        //Usuario inactivo
                        return $_respuestas->error_200("Usuario inactivo!!");
                    }
                }else {
                    return $_respuestas->error_200("La contraseña es invalida!!");
                }
            }else {
                // Si no existe el usuario
                return $_respuestas->error_200("El usuario $usuario no existe!!");
            }
        }
    }

    private function obtenerDatosUsuario($correo){
        $query = "SELECT UsuarioId, Password, Estado FROM usuarios WHERE Usuario = '$correo'";
        $datos = parent::obtenerDatos($query);
        if (isset($datos[0]["UsuarioId"])) {
            return $datos;
        }else {
            return 0;
        }
    }

    private function insertarToken($usuarioId){
        $val = true;
        $token = bin2hex(openssl_random_pseudo_bytes(16, $val));
        $fecha = date("Y-m-d H:i");
        $estado = "Activo";
        $query = "INSERT INTO usuarios_token (UsuarioId, Token, Estado, Fecha) VALUES ('$usuarioId', '$token', '$estado', '$fecha')";
        $verifica = parent::nonQuery($query);

        if ($verifica) {
            return $token;
        }else {
            return 0;
        }
        
    }
}
