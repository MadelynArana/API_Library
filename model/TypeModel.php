<?php
    require_once __DIR__.'/core/PersonModel.php';

    class TypeModel extends PersonModel
    {
        // Se agrega el nombre del procedimiento almacenado a ser utilizado.
        function __construct()
        {
            parent::__constructTable('type');
        }
        /**
         * Settea la clase con las propiedades de la base de datos.
        *   - Párametro $class, instancia de una clase por ejemplo $type = new typeModel.
        *   - Párametro $row, hace referencia a la fila de la base de datos por 
         */
        protected function setDatabaseProperties( $class, $row )
        {  
            $class->setCode      ( $row->id   );   
            $class->setName      ( $row->name_type );
        }
        /** 
         * Obtiene información de la base de datos. 
         * */
        protected function getObjects( $data )
        {
            $element = [
                'code'       => $data->getCode(),
                'name'       => $data->getName(),
            ]; 
            return $element;
        }
        /**
         * Obtiene registros 
         *  - Parámetro $id recibe un número distinto a 0 devuelve un sólo registro.
         *  - Parámetro $id recibe un 0 devuelve todos los registros.
         */ 
        public function getData( $id )
        {  
            $type = new TypeModel();
            return $this->getArray( $id , $type );
        }
        /** 
         * Inserta o actualiza un registro 
        *   - Si en el método setCode() se asigna un 0 se inserta un nuevo registro de lo contrario se actualiza.
        */
        protected function insertUpdate()
        {          
            $sql = "CALL ps_type_insert_update({$this->code},'{$this->name}');" ; // Consulta BD.         
            $this->query( $sql );
            return $sql;
        }
        /** 
         * Actualiza un registro existente
         *  - Si algún campo en el cuerpo del json viene vacío, realiza una búsqueda y retorna el valor almacenado en la base de datos.
         */
        public function update( $code, $name )
        {
            $typeClass = new TypeModel();
            $searchType = $this->setArray( $code , $typeClass ); // Busca el registro por id.
            /* Verifica si las propiedades vienen vacías de ser así retorna el valor que se encuentra en la base de datos, caso contrario 
            *  actualiza el nuevo valor. */                       
            $name = $name =="" ? $searchType->getName() : $searchType->setName( $name );
            $searchType->insertUpdate();
        }
        /** 
         * Guarda un nuevo registro. 
         * */      
        public function insert( $code, $name )
        {
            $this->setCode( $code=0 );
            $this->setName( $name );
            $this->insertUpdate(); // Guarda un nuevo registro.  
        }
    }// End class
?>