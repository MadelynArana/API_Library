<?php
    require_once __DIR__.'/core/PersonModel.php';

    class AuthorModel extends PersonModel
    {
        // Se agrega el nombre del procedimiento almacenado a ser utilizado.
        function __construct()
        {
            parent::__constructTable('author');
        }
        /**
         * Settea la clase con las propiedades de la base de datos.
        *   - Párametro $class, instancia de una clase por ejemplo $book = new BookModel.
        *   - Párametro $row, hace referencia a la fila de la base de datos por 
         */
        protected function setDatabaseProperties( $class, $row )
        {  
            $class->setCode   ( $row->code    );   
            $class->setName   ( $row->name    );
            $class->setSurname( $row->surname );
        }
        /** 
         * Obtiene información de la base de datos. 
         * */
        protected function getObjects( $data )
        {
            $element = [
                'code'    => $data->getCode(),
                'name'    => $data->getName(),
                'surname' => $data->getSurname()
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
            $author = new AuthorModel();
            return $this->getArray( $id , $author );
        }
        /** 
         * Inserta o actualiza un registro 
        *   - Si en el método setCode() se asigna un 0 se inserta un nuevo registro de lo contrario se actualiza.
        */
        protected function insertUpdate()
        {          
            $sql = "CALL ps_author_insert_update({$this->code},'{$this->name}','{$this->surname}')" ; // Consulta BD.         
            $this->query( $sql );
            return $sql;
        }
        /** 
         * Actualiza un registro existente
         *  - Si algún campo en el cuerpo del json viene vacío, realiza una búsqueda y retorna el valor almacenado en la base de datos.
         */
        public function update( $code, $name, $surname )
        {
            $author = new AuthorModel();
            $searchAuthor = $this->setArray( $code , $author ); // Busca el registro por id.
            /* Verifica si las propiedades vienen vacías de ser así retorna el valor que se encuentra en la base de datos, caso contrario 
            *  actualiza el nuevo valor. */                       
            $name    = $name    =="" ? $searchAuthor->getName()    : $searchAuthor->setName( $name );
            $surname = $surname =="" ? $searchAuthor->getSurname() : $searchAuthor->setSurname( $surname );
            $searchAuthor->insertUpdate();
        }
        /** 
         * Guarda un nuevo registro. 
         * */      
        public function insert( $code, $name, $surname )
        {
            $this->setCode( $code=0 );
            $this->setName( $name );
            $this->setSurname ( $surname );
            $this->insertUpdate(); // Guarda un nuevo registro.  
        }
    }// End class
?>