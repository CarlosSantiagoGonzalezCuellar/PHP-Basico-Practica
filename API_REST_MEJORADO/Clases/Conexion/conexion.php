<?php

class conexionBd
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

        try {
            $this->conexion = new PDO(
                "mysql:host={$this->server};dbname={$this->database};port={$this->port}",
                $this->user,
                $this->password
            );
        } catch (PDOException $error1) {
            echo "Ha ocurrido un error, no se ha podido conectar a la BD! " . $error1->getMessage();
            die();
        } catch (PDOException $error2) {
            echo "Error generico! " . $error2->getMessage();
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
                $item = iconv("ISO-8859-1", "UTF-8", $item);
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
        $resultados = $this->conexion->exec($sqlStr);
        return $resultados;
    }

    //INSERT
    public function nonQueryId($sqlStr)
    {
        $resultados = $this->conexion->exec($sqlStr);

        if ($resultados >= 1) {
            return $this->conexion->lastInsertId();
        } else {
            return 0;
        }
    }

    //ENCRIPTAR
    protected function encriptar($string){
        return md5($string);
    }
}
