<?php
    require_once __DIR__.'/core/PersonModel.php';
 
    class BorrowModel extends BaseEntity
    {
        public $code  = 0;
        public $takenDate    = NULL;
        public $broughtDate  = NULL;
        public $studentCode  = 0;
        public $bookCode     = 0;

        // Se agrega el nombre del procedimiento almacenado a ser utilizado.
        function __construct(){
            parent::__constructTable('borrow');
        }
        // Métodos getters
        public function getCode       () { return $this->code;        }
        public function getStudentCode() { return $this->studentCode; }
        public function getbookCode   () { return $this->bookCode ;   }
        public function getTakenDate  () { return $this->takenDate;   }
        public function getBroughtDate() { return $this->broughtDate; }
        // Métodos setters
        public function setCode       ( int $code    ) { $this->code        = $code; }
        public function setStudentCode( int $code    ) { $this->studentCode = $code; }
        public function setbookCode   ( int $code    ) { $this->bookCode    = $code; }
        public function setBroughtDate( string $date ) { $this->broughtDate = $date; }
        public function setTakenDate  ( string $date ) { $this->takenDate   = $date; }
/**
         * Settea la clase con las propiedades de la base de datos.
        *   - Párametro $class, instancia de una clase por ejemplo $borrow = new BorrowModel.
        *   - Párametro $row, hace referencia a la fila de la base de datos por 
         */
        protected function setDatabaseProperties( $class , $row )
        {  
            $class->setCode       ( $row->id           );
            $class->setStudentCode( $row->student_id   );
            $class->setBookCode   ( $row->book_id      );
            $class->setBroughtDate( $row->taken_date   );
            $class->setTakenDate  ( $row->brought_date );
        }
        /** 
         * Obtiene información de la base de datos. 
         * */
        protected function getObjects( $data )
        {
            $element = [
                'code'        => $data->getCode(),
                'studentCode' => $data->getStudentCode(),
                'bookCode'    => $data->getbookCode(),
                'broughtDate' => $data->getBroughtDate(),
                'takenDate'   => $data->getTakenDate()
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
            $borrow = new BorrowModel();
            return $this->getArray( $id , $borrow );
        }
        /** 
         * Inserta o actualiza un registro 
        *   - Si en el método setCode() se asigna un 0 se inserta un nuevo registro de lo contrario se actualiza.
        */
        protected function insertUpdate()
        {          
            $sql = "CALL ps_borrow_insert_update($this->code,$this->studentCode,{$this->bookCode},'{$this->takenDate}','{$this->broughtDate}')" ; // Consulta BD.         
            $this->query( $sql );
            return $sql;
        }
        /** Filtra entre dos fecha cuando el libro fue regresado.  */
        public function getDateBroughtFilter($initialDate, $finalDate){
            $borrow = new BorrowModel();
            $sql="CALL ps_borrow_date_brought('{$initialDate}','{$finalDate}')";
            $data =$this->setDate( $borrow , $sql );
            return $data; 
        }    
         /** Filtra entre dos fecha cuando el libro fue prestado.  */
        public function getDateTakenFilter($initialDate, $finalDate){
            $borrow = new BorrowModel();
            $sql="CALL ps_borrow_date_taken('{$initialDate}','{$finalDate}')";
            $data =$this->setDate( $borrow , $sql );
            return $data; 
        }    
        /** 
         * Actualiza un registro existente
         *  - Si algún campo en el cuerpo del json viene vacío, realiza una búsqueda y retorna el valor almacenado en la base de datos.
         */
        public function update( $code, $studentCode, $bookCode, $broughtDate, $takenDate )
        {
            $Borrow = new BorrowModel();
            $searchBorrow = $this->setArray( $code , $Borrow ); // Busca el registro por id.
            /* Verifica si las propiedades vienen vacías de ser así retorna el valor que se encuentra en la base de datos, caso contrario 
            *  actualiza el nuevo valor. */                       
            $studentCode = $studentCode =="" ? $searchBorrow->getStudentCode() : $searchBorrow->setStudentCode( $studentCode );
            $bookCode    = $bookCode    =="" ? $searchBorrow->getbookCode()    : $searchBorrow->setbookCode( $bookCode );
            $broughtDate = $broughtDate =="" ? $searchBorrow->getBroughtDate() : $searchBorrow->setBroughtDate( $broughtDate );
            $takenDate   = $takenDate   =="" ? $searchBorrow->getTakenDate()   : $searchBorrow->setTakenDate( $takenDate );
            $searchBorrow->insertUpdate();
        }
        /** 
         * Guarda un nuevo registro. 
         * */      
        public function insert( $code, $studentCode, $bookCode, $broughtDate, $takenDate )
        {
            $this->setStudentCode( $studentCode );
            $this->setbookCode( $bookCode );
            $this->setBroughtDate( $broughtDate );
            $this->setTakenDate( $takenDate );
            $this->insertUpdate(); // Guarda un nuevo registro.  
        }
    }// End class
?>
