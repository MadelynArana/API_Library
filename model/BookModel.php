<?php
    require_once __DIR__.'/core/PersonModel.php';
 
    class BookModel extends PersonModel
    {
        public $pageCount  = 0;
        public $point  = 0;
        public $type     = 0;
        public $authorCode = NULL;
        
        function __construct(){
            parent::__constructTable('book');
        }

        public function getPageCount(){
            return $this->pageCount;
        }
        public function getPoint(){
            return $this->point;
        }
        public function getType(){
            return $this->typeId;
        }
        public function getAuthorCode(){
            return $this->authorCode;
        }
        public function setPageCount( int $page ){
            $this->pageCount = $page;
        }
        public function setPoint( int $point ){
            $this->point = $point;
        }
        public function setType( int $type ){
            $this->type = $type;
        }
        public function setAuthorCode( int $code ){
            $this->authorCode = $code;
        }

        /** Busca un registro pide como parámetro un id entero */
        public function getId(int $code ){
            $row= $this->getIdBase( $code ); // Consulta BD.
            if($row!='0')
            {
                $book = new BookModel(); // Objetos
                $book->setCode($row->id);
                $book->setName($row->name_book);
                $book->setPageCount($row->page_count);
                $book->setPoint($row->point_book);
                $book->setAuthorCode($row->author_id);
                return $book;
            }
            else{
                return '0';
                }
        }
        /** Regresa un arreglo con todos los registros */
        public function getAll()
        {
            $data = $this->getAllBase(); // Consulta BD.    
            if($data!=0)
            {
                foreach($data as $row)
                {
                    $book = new BookModel(); // Objetos
                    $book->setCode($row->id);
                    $book->setName($row->name_book);
                    $book->setPageCount($row->page_count);
                    $book->setPoint($row->point_book);
                    $book->setAuthorCode($row->author_id);
                    $books[]= $book;
                }
                return $books;
            } 
            else{
                return 0;
            }
        }
        /** Inserta o actualiza un registro dependiendo si el parámetro id tiene el número 0 inserta de lo contrario actualiza */
        public function insertUpdate()
        {        
            $sql = "CALL ps_book_isert_update({$this->code},'$this->name',{$this->pageCount},{$this->point},{$this->authorCode},{$this->type})" ; // Consulta BD.  
            return $this->insertUpdateBase($sql); // Ingresa o actualiza un registro.  
        }
    }// End class
?>