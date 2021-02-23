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
         * Retorna registros
         * - Si en el parámetro $id se coloca un número retorna un registro.
         * - Si en el parámetro $id se coloca un 0 o vacío retorna todos los registros.
         * - Se settean los valores de la base de datos.
         */
        protected function getArray( int $id = 0 )
        {
            $dataBase = $this->getAllBase( $id ); // Consulta a la base de datos.  
                if($id !=0){         
                    $book = new BookModel(); // Objetos
                    self::databaseObjects( $book , $dataBase ); // Retorna un registro.
                    return $book;
                }else{
                    $books=[]; // Se inicia un arreglo vacío para después asignarlo foreach.
                    $book = new BookModel(); // Objetos
                    foreach( $dataBase as $row ){
                        self::databaseObjects( $book , $row ); // Retorna todos los registros.
                        $books[] = $book;
                    }
                    return $books;
                }
            
        }
        /**
         *  Esta función hace referencia a las propiedades de la base de datos.
         * - Parámetro $book Hace referncia a la clase donde se encuentran los setters y los getters.
         * - Parámetro $row  Hace referencia a la instancia de la base de datos.
         * */ 
        protected function databaseObjects($book,$row)
        {
            $book->setCode      ($row->book_code  );
            $book->setName      ($row->book_name  );
            $book->setPageCount ($row->page_count );
            $book->setPoint     ($row->POINT      );
            $book->setAuthorCode($row->author_id  );
            $book->setAuthorName($row->author_name);
            $book->setTypeCode  ($row->type_id    );
            $book->setTypeName  ($row->type_name  );
            return $book;
        }
        /** Inserta o actualiza un registro 
        * Si en el método setCode() se asigna un 0 se inserta un nuevo registro.
        * Si en el método setCode() se asgina un valor distinto a cero se actualiza el registro.
        */
        protected function insertUpdate()
        {          
            $sql = "CALL ps_book_insert_update({$this->code},'{$this->name}',{$this->pageCount},{$this->point},{$this->authorCode},{$this->typeCode})" ; // Consulta BD.         
            $this->query( $sql );
            return $sql;
        }
        /** Busca un registro pasándole como párametro un ID. */ 
        public function getId($code)
        {
            $book = $this->getArray($code); // Consulta a la base de datos.  
            if(isset($code))
            {
                if($book!=0){
                    $element = ['code'=>$book->getCode(),'name'=>$book->getName(),'pages'=>$book->getPageCount(),'point'=>$book->getPoint(),'author'=>$book->getAuthorName(),'type'=> $book->getTypeName()];
                    return $element;
                }else{              
                    return 0;
                }
            }else{
                return 0;
            }
        }
        /** Retorna todos los registros */ 
        public function getAll()
        {
            // Cuenta el número de registros.
            $response = self::getArray();
            $numberRecords=count($response); 
            if($numberRecords !=0)
            {
                $bookArray['books']=[];
                $bookArray['numberRecords']=$numberRecords; // Se asgina al arreglo el número de registros.
                // Se recorre todos los registros y se asignan al arreglo.
                foreach($response as $book){
                    $element = ['code'   => $book->getCode(),'name'=> $book->getName(),'pages'  => $book->getPageCount(),'point'  => $book->getPoint(),'author'=> $book->getAuthorName(),'type'=> $book->getTypeName()];
                    array_push($bookArray['books'], $element ); 
                }
                // Muestra los registros a el usuario.
                return $bookArray;
            }else{
                return 0;
            }
        }
        /** Actualiza un registro existente
         *  Si algún campo en el cuerpo del json viene vacío, realiza una búsqueda y retorna el valor almacenado en la base de datos.
         */
        public function update( $code, $name, $pages, $point, $authorCode, $typeCode )
        {
            $searchBook=  $this->getArray($code);  // Busca el registro por id.
            /* Verifica si las propiedades vienen vacías de ser así retorna el valor que se encuentra en la base de datos, caso contrario 
            * actualiza el nuevo valor. */                       
            $name      = $name==""      ?  $searchBook->getName()       : $searchBook->setName      ($name);
            $pages     = $pages==""     ?  $searchBook->getPageCount()  : $searchBook->setPageCount ($pages);
            $point     = $point==""     ?  $searchBook->getPoint()      : $searchBook->setPoint     ($point);
            $authorCode= $authorCode==""?  $searchBook->getAuthorCode() : $searchBook->setAuthorCode($authorCode);
            $typeCode  = $typeCode==""  ?  $searchBook->getTypeCode  () : $searchBook->setTypeCode  ($typeCode);   
            $searchBook->insertUpdate();
        }
        /** Guarda un nuevo registro. */      
        public function insert( $code, $name, $pages, $point, $authorCode, $typeCode ){
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