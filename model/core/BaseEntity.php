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
         * Función genérica para realizar el CRUD.
         *  - Pide como parámetro la consulta a la base de datos. 
         */ 
        protected function query( $sql )
        {   
            $conexion = dataBase::conexion();  // Conexión a la BD.
            $sql = $conexion->prepare( $sql ); // Prepara la consulta.
            $sql->execute(); // Ejecuta y retorna la consulta.
            return $sql ;   
        }
        /** 
         * Elimina un registro. 
         *  - Párametro $id se debe colocar un númeo entero.
         * */
        public function delete( int $id )
        {
            $sql=$this->query("DELETE FROM tb_{$this->table} WHERE id = {$id}");
            return $sql ? 0 : 1;
        }
        /**
        * Settea array
        *   - Parámetro $class, hace referencia la instancia de una clase.
        *   - Párametro $id, si se coloca un número settea sólo un registros.
        *   - Párametro $id, si se coloca un 0 settea todos los registros.
        */
        protected function setArray( $id , $class )
        {
            $sql = $this->query("CALL ps_{$this->table}_get( $id )"); // Procedimiento almacenado para consultar uno o todos los registros.
            $number = $sql->rowCount(); // Cuenta el número de registros.
            if( $number != 0 ){ // Válida que exista al menos un registro.             
                if( $id!=0 ){  // Válida que el id traiga un número.
                    $row = $sql->fetch( PDO::FETCH_OBJ ) ; // Recorre la consulta una vez.
                    $this->setDatabaseProperties( $class , $row ); // Está función hace referencia a las propiedades de la base de datos que serán setteadas por ejempo  $class->setName($row->book_name);
                    return $class; // Settea un sólo registro.
                }else{ 
                    $dataBase =  $sql->fetchAll( PDO::FETCH_OBJ ); // Recorre todos los registros.
                    foreach( $dataBase as $row ){
                        $object =new $class; // Instancia de una clase 
                        $this->setDatabaseProperties( $object , $row ); 
                        $array[] = $object; // Se asignan los objetos dentro del arreglo.
                    }
                    return $array; // Settea todos los registros.
                }
            }else{
                return 0; // Devuelve 0 al no encontrar registros.
            }
        }   
        /**
        * Get array
            * - Parámetro $class, hace referencia la instancia de una clase.
            * - Párametro $id, si se coloca un número devuelve sólo un registros.
            * - Párametro $id, si se coloca un 0 devuelve todos los registros.
        */
        protected function getArray( $id , $class )
        {
            $dataBase = $this->setArray( $id , $class ); 
        
                if( $id !=0 ){ 
                    $element = $this->getObjects( $dataBase ); // Objetos de la clase como $class->getName();
                    return $element; // Devuelve un registro.
                }else{
                    $array['data']=[];
                    foreach( $dataBase as $data ){
                        $element= $this->getObjects( $data ); 
                        array_push( $array['data'], $element ); // Se asignan los objetos al arreglo.
                    }
                    return $array; // Devuelve todos los registros.
                }
            
        }
    }// End class

?>