<?php

class conexionBd
{
    private $server;
    private $user;
    private $password;
    private $database;
    private $conexion;

    function __construct()
    {
        $listaDatos = $this->datosConexion();
        foreach ($listaDatos as $key => $value) {
            $this->server = $value["server"];
            $this->user = $value["user"];
            $this->password = $value["password"];
            $this->database = $value["database"];
        }

        try {
            $this->conexion = new PDO("mysql:host={$this->server};dbname={$this->database}", 
            $this->user, $this->password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        } catch (PDOException $error1){
            echo "Ha ocurrido un error, no se ha podido conectar a la BD! ". $error1->getMessage();
            die();
        }catch (PDOException $error2){
            echo "Error generico! ". $error2->getMessage();
            die();
        }
    }

    private function datosConexion()
    {
        $direccion = dirname(__FILE__);
        $jsonData = file_get_contents($direccion . "/" . "config");
        return json_decode($jsonData, true);
    }

    /*private function convertirUtf8($array)
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
    }*/
}

