<?php
require_once "Conexion/conexion.php";

class token extends conexion
{

    function actualizarTokens($fecha)
    {
        $query = "UPDATE usuarios_token SET Estado = 'Inactivo' WHERE  Fecha < '$fecha'";
        $verifica = parent::nonQuery($query);
        if ($verifica) {
            $this->escribirEntrada($verifica);
            return $verifica;
        } else {
            return 0;
        }
    }

    function crearTxt($direccion)
    {
        $archivo = fopen($direccion, 'w') or die("Error al crear el archivo de registros");
        $texto = "------------------------------------ Registros del CRON JOB ------------------------------------ \n";
        fwrite($archivo, $texto) or die("No se pudo escribir el registro!!");
        fclose($archivo);
    }

    function escribirEntrada($registros)
    {
        $direccion = "../Cron/Registros/registros.php";
        if (!file_exists($direccion)) {
            $this->crearTxt($direccion);
        }
        // Crear una entrada nueva 
        $this->escribirTxt($direccion, $registros);
    }

    function escribirTxt($direccion, $registros)
    {
        $date = date("Y-m-d H:i");
        $archivo = fopen($direccion, 'a') or die("Error al abrir el archivo de registros");
        $texto = "Se modificaron $registros registro(s) el dia [$date] \n";
        fwrite($archivo, $texto) or die("No pudimos escribir el registro");
        fclose($archivo);
    }
}
