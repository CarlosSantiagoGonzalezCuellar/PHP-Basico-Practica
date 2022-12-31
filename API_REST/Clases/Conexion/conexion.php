<?php
class conexion
{
    private $server;
    private $user;
    private $password;
    private $database;
    private $port;
    private $conexion;

    function __construct()
    {
        $listaDatos = $this->datosConexion();
        foreach ($listaDatos as $key => $value) {
            $this->server = $value["server"];
            $this->user = $value["user"];
            $this->password = $value["password"];
            $this->database = $value["database"];
            $this->port = $value["port"];
        }

        $this->conexion = new mysqli($this->server, $this->user, $this->password, $this->database, $this->port);
        if ($this->conexion->connect_errno) {
            echo "Ha ocurrido un error en la conexion";
            die();
        }
    }

    private function datosConexion()
    {
        $direccion = dirname(__FILE__);
        $jsonData = file_get_contents($direccion . "/" . "config");
        return json_decode($jsonData, true);
    }

    private function convertirUtf8($array)
    {
        array_walk_recursive($array, function (&$item, $key) {
            if (!mb_detect_encoding($item, "utf-8", true)) {
                $item = utf8_encode($item);
            }
        });
        return $array;
    }

    public function obtenerDatos($sqlStr)
    {
        $resultados = $this->conexion->query($sqlStr);
        $resultArray = array();

        foreach ($resultados as $key) {
            $resultArray[] = $key;
        }
        return $this->convertirUtf8($resultArray);
    }

    public function nonQuery($sqlStr)
    {
        $resultados = $this->conexion->query($sqlStr);
        return $this->conexion->affected_rows;
    }

    //INSERT
    public function nonQueryId($sqlStr)
    {
        $resultados = $this->conexion->query($sqlStr);
        $filas = $this->conexion->affected_rows;

        if ($filas >= 1) {
            return $this->conexion->insert_id;
        } else {
            return 0;
        }
    }

    //ENCRIPTAR
    protected function encriptar($string){
        return md5($string);
    }
}
