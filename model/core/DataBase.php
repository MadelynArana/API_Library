<?php

    require_once __DIR__."/../../resource/config/DataBaseConfig.php";

    class dataBase {
        private static $conexion = NULL;
        /**
         * Conexión a la base de datos.
         */
        public static function conexion() {   
            try{
                $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
                self::$conexion = new PDO('mysql:host=localhost;dbname='.DATABASE,USER,PASSWORD, $pdo_options);
                return self::$conexion;
            }catch(Exception $ex){
                return 0;
                echo 'Error al conectar la base de datos';
            }
        }
    } // End class

?>