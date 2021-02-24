<?php
    require_once __DIR__.'/core/PersonModel.php';

    class BookModel extends PersonModel
    {
        public  $pageCount  = 0,
                $point      = 0,
                $typeCode   = 0,
                $typeName   = 0,
                $authorCode = NULL,
                $authorName = NULL;
        // Se agrega el nombre del procedimiento almacenado a ser utilizado.
        function __construct()
        {
            parent::__constructTable('book');
        }
        // Métodos getters
        public function getPageCount (){ return $this->pageCount ; }
        public function getPoint     (){ return $this->point     ; }
        public function getTypeCode  (){ return $this->typeCode  ; }
        public function getTypeName  (){ return $this->typeName  ; }
        public function getAuthorCode(){ return $this->authorCode; }
        public function getAuthorName(){ return $this->authorName; }
        // Métodos setters
        public function setPageCount ( int    $page  ) { $this->pageCount  = $page ; }
        public function setPoint     ( int    $point ) { $this->point      = $point; }
        public function setTypeCode  ( int    $type  ) { $this->typeCode   = $type ; }
        public function setTypeName  ( string $name  ) { $this->typeName   = $name ; }
        public function setAuthorCode( int    $code  ) { $this->authorCode = $code ; }
        public function setAuthorName( string $name  ) { $this->authorName = $name ; }
        /**
         * Settea la clase con las propiedades de la base de datos.
        *   - Párametro $class, instancia de una clase por ejemplo $book = new BookModel.
        *   - Párametro $row, hace referencia a la fila de la base de datos por 
         */
        protected function setDatabaseProperties( $class, $row )
        {  
            $class->setCode ($row->book_code);   
            $class->setName      ($row->book_name  );
            $class->setPageCount ($row->page_count );
            $class->setPoint     ($row->POINT      );
            $class->setAuthorCode($row->author_id  );
            $class->setAuthorName($row->author_name);
            $class->setTypeCode  ($row->type_id    );
            $class->setTypeName  ($row->type_name  );
        }
        /** 
         * Obtiene información de la base de datos. 
         * */
        protected function getObjects( $data )
        {
            $element = ['code'=>$data->getCode(),'name'=>$data->getName(),'pages'=>$data->getPageCount(),'point'=>$data->getPoint(),'authorName'=>$data->getAuthorName(),'typeName'=>$data->getTypeName()]; 
            return $element;
        }
        /**
         * Obtiene registros 
         *  - Parámetro $id recibe un número distinto a 0 devuelve un sólo registro.
         *  - Parámetro $id recibe un 0 devuelve todos los registros.
         */ 
        public function getData( $id )
        {  
            $book = new BookModel();
            return $this->getArray( $id , $book );
        }
        /** 
         * Inserta o actualiza un registro 
        *   - Si en el método setCode() se asigna un 0 se inserta un nuevo registro de lo contrario se actualiza.
        */
        protected function insertUpdate()
        {          
            $sql = "CALL ps_book_insert_update({$this->code},'{$this->name}',{$this->pageCount},{$this->point},{$this->authorCode},{$this->typeCode})" ; // Consulta BD.         
            $this->query( $sql );
            return $sql;
        }
        /** 
         * Actualiza un registro existente
         *  - Si algún campo en el cuerpo del json viene vacío, realiza una búsqueda y retorna el valor almacenado en la base de datos.
         */
        public function update( $code, $name, $pages, $point, $authorCode, $typeCode )
        {
            $book = new BookModel();
            $searchBook = $this->setArray( $code , $book ); // Busca el registro por id.
            /* Verifica si las propiedades vienen vacías de ser así retorna el valor que se encuentra en la base de datos, caso contrario 
            *  actualiza el nuevo valor. */                       
            $name      = $name==""      ?  $searchBook->getName()       : $searchBook->setName      ($name);
            $pages     = $pages==""     ?  $searchBook->getPageCount()  : $searchBook->setPageCount ($pages);
            $point     = $point==""     ?  $searchBook->getPoint()      : $searchBook->setPoint     ($point);
            $authorCode= $authorCode==""?  $searchBook->getAuthorCode() : $searchBook->setAuthorCode($authorCode);
            $typeCode  = $typeCode==""  ?  $searchBook->getTypeCode  () : $searchBook->setTypeCode  ($typeCode);   
            $searchBook->insertUpdate();
        }
        /** 
         * Guarda un nuevo registro. 
         * */      
        public function insert( $code, $name, $pages, $point, $authorCode, $typeCode )
        {
            $this->setCode( $code=0 );
            $this->setName( $name );
            $this->setPageCount ( $pages );
            $this->setAuthorCode( $authorCode );
            $this->setPoint( $point );
            $this->setTypeCode( $typeCode );
            $this->insertUpdate(); // Guarda un nuevo registro.  
        }
    }// End class
?>