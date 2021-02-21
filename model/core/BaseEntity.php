<?php
    require_once 'database.php';

    class BaseEntity {
        // En parametro $table : se asigna el nombre de la tabla de la bd.
        private $table = '';

        // El nombre de la tabla será cargado dentro del constructor.
        public function __constructTable( $table ) {
            $this->table = $table;
        }
        /**
         * Retorna todos los registros de la tabla.
         *  - Los setter y getters se colocan en el modelo.
         */
        public function getAllBase(){      
            $sql = $this->query("SELECT * FROM view_{$this->table}");
            $number = $sql->rowCount(); 
            ( $number != 0 ) ? $data = $sql->fetchAll( PDO::FETCH_OBJ ): $data = 0;
            return $data;
        }
        /**
         * Retorna un sólo arreglo.
         * - Los setter y getters se colocan en el modelo.
         */
        public function getIdBase( int $id ){      
            $sql = $this->query("CALL ps_{$this->table}_id( $id )");
            $number = $sql->rowCount(); 
            ( $number !=0 ) ? $data = $sql->fetch( PDO::FETCH_OBJ ): $data ='0';
            return $data;
        }  
        /**
         * Inserta y actualiza un registro - En el modelo que heredara de esta clase se colocan los querys de insert y update.
         */
        public function insertUpdateBase( $sql ){
            return $this->query( $sql ) ? 0: 1;
        }
        /** Elimina un registro. */
        public function delete( int $id ){
            $sql=$this->query("DELETE FROM tb_{$this->table} WHERE id = $id");
            return $sql ? 0 : 1;
        }
        /**
         * Función genérica para realizar el CRUD.
         * - Pide como parámetro la consulta de la base de datos. 
        */ 
        public function query( $sql ){
            // Conexión a la BD.
            $conexion = dataBase::conexion();
            // Prepara la consulta.
            $sql = $conexion->prepare( $sql );
            // Ejecuta y retorna la consulta.
            $sql->execute();
            return $sql ;   
        }
    }// End class

?>