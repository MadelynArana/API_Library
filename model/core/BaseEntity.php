<?php
    require_once 'database.php';

    class BaseEntity 
    {
        // Esta propiedad hace referencia al procedimiento almacenado que será utilizado en cada modelo.
        private $table = '';
        // El nombre de la tabla será cargado dentro del constructor.
        public function __constructTable( $table ) 
        {
            $this->table = $table;
        }
        /**
         * Retorna registros
         * - Si en el parámetro $id se coloca un número retorna un registro.
         * - Si en el parámetro $id se coloca un 0 o vacío retorna todos los registros.
         */
        protected function getAllBase( int $id )
        {      
            $sql = $this->query("CALL ps_{$this->table}_get( $id )"); // Procedimiento almacenado para buscar registros.
            $number = $sql->rowCount(); // Cuenta el número de registros.
            if( $number != 0 ){       // Devuelve un registro        // Devuelve varios registros.              
                ( $id!=0 ) ?  $data= $sql->fetch( PDO::FETCH_OBJ ) : $data= $sql->fetchAll( PDO::FETCH_OBJ );
                return $data; 
            }
            else{
                return 0;
            }
        }
        /** Elimina un registro. */
        public function delete( int $id )
        {
            $sql=$this->query("DELETE FROM tb_{$this->table} WHERE id = $id");
            return $sql ? 0 : 1;
        }
        /**
         * Función genérica para realizar el CRUD.
         * - Pide como parámetro la consulta de la base de datos. 
        */ 
        protected function query( $sql )
        {   
            $conexion = dataBase::conexion();  // Conexión a la BD.
            $sql = $conexion->prepare( $sql ); // Prepara la consulta.
            $sql->execute(); // Ejecuta y retorna la consulta.
            return $sql ;   
        }
    }// End class

?>