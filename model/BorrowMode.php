<?php
    require_once __DIR__.'/core/PersonModel.php';
 
    class BorrowModel extends BaseEntity
    {
        public $code  = 0;
        public $takenDate    = NULL;
        public $broughtDate  = NULL;
        public $codeStudent  = 0;
        public $codeBook     = 0;

        function __construct(){
            parent::__constructTable('borrow');
        }

        public function getCode() {
            return $this->code;
        }
        public function getTakenDate(){
            return $this->takenDate;
        }
        public function getBroughtDate(){
            return $this->broughtBate;
        }
        public function getCodeStudent(){
            return $this->codeStudent;
        }
        public function getCodeBook(){
            return $this->codeBook;
        }
        public function setCode( int $code ) {
            $this->code = $code;
        }
        public function setTakenDate( $date ){
            $this->takenDate = $date;
        }
        public function setBroughtDate( $date ){
            $this->broughtDate = $date;
        }
        public function setCodeStudent( int $code ){
            $this->codeStudent = $code;
        }
        public function setCodeBook( int $code ){
            $this->codeBook = $code;
        }

        /** Busca un registro pide como parámetro un id entero. */
        public function getId(int $code )
        {
            $row= $this->getIdBase( $code ); // Consulta BD.
            ($row!='0') ?  $row : $row='0';
            return $row;
        }
        /** Regresa un arreglo con todos los registros. */
        public function getAll()
        {
            $data = $this->getAllBase(); // Consulta BD.    
            ($data!='0') ?  $data : $data='0';
            return $data;
        }

        /** Regresa un arreglo pidiendo como parámetro fecha inicial string y fecha final string.*/
        public function showTakenDate( $initial , $final )
        {
            $sql=$this->query("CALL ps_borrow_date_taken('{$initial}','{$final}')");
            $number = $sql->rowCount(); 
            ($number !=0) ? $data=$sql->fetchAll( PDO::FETCH_OBJ ) : $data='0';
            return $data;
        }

        /** Regresa un arreglo pidiendo como parámetro fecha inicial string y fecha final string.*/
        public function showBroughtDate( $initial , $final )
        {
            $sql=$this->query("CALL ps_borrow_date_brought('{$initial}','{$final}')");
            $number = $sql->rowCount(); 
            ($number !=0) ? $data = $sql->fetchAll( PDO::FETCH_OBJ ) : $data = '0';
            return $data;
        }
        /** Inserta o actualiza un registro dependiendo si el parámetro code tiene el número 0 inserta de lo contrario actualiza. */
        public function insertUpdate()
        {        
            $sql = "CALL ps_borrow_insert_update({$this->code},{$this->codeStudent},{$this->codeBook},'{$this->takenDate}','{$this->broughtDate}')"; // Consulta BD.  
            return $this->insertUpdateBase( $sql ); // Ingresa o actualiza un registro.  
        }
    }// End class

?>