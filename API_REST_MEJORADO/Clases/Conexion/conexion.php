<?php
class conexionBd
{
    public static function conex($db)
    {
        try {
            $con = new PDO("mysql:host={$db['host']};dbname={$db['db']}", $db['username'], $db['password']);
            return $con;
        } catch (PDOException $error1) {
            echo "Ha ocurrido un error, no se ha podido conectar a la BD!" . $error1->getMessage();
        } catch (PDOException $error2) {
            echo "Error generico!" . $error2->getMessage();
        }
    }
}
