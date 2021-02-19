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
            $sql = "SELECT * FROM $this->table";
            $sql=$this->query($sql);
            return $sql->fetchAll( PDO::FETCH_OBJ ); 
        }
        /**
         * Retorna un sólo arreglo.
         * - Los setter y getters se colocan en el modelo.
         */
        public function getIdBase( $id ){      
            $sql = "SELECT * FROM $this->table where id = $id";
            $sql=$this->query($sql);
            return $sql->fetch( PDO::FETCH_OBJ );
        }  
        /**
         * Inserta y actualiza un registro - En el modelo que heredara de esta clase se colocan los querys de insert y update.
         */
        public function insertUpdateBase( $sql ){
            $sql=$this->query( $sql );
            return $sql ? 0: 1;
        }
        /** Elimina un registro. */
        public function delete( $id ){
            $sql = "DELETE FROM $this->table WHERE id = $id";
            $sql=$this->query( $sql );
            return $sql ? 0: 1;
        }
        /**
         * Función genérica para realizar el CRUD.
         * - Pide como parámetro la consulta de la base de datos. 
        */ 
        public function query( $sql ){
            // Conexión a la BD.
            $conectar = dataBase::conexion();
            // Prepara la consulta.
            $sql = $conectar->prepare( $sql );
            // Ejecuta y retorna la consulta.
            $sql->execute();
            return $sql ;   
        }

    }// End class

?>