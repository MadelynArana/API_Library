<?php
    require 'BaseEntity.php';

    class PersonModel extends BaseEntity
    {
        // Se coloca el nombre del procedimiento almacenado que será utilizado en cada modelo.
        public $table   ='',
                $code    = 0,
                $name    = NULL,
                $surname = NULL;
        
        public function __construct(){
            parent::__constructTable( $this->table );
        }
        // Métodos getters
        public function getCode   () { return $this->code   ; }
        public function getName   () { return $this->name   ; }
        public function getSurname() { return $this->surname; }
        // Métodos setters
        public function setCode   ( int    $code    )  { $this->code    = $code   ; }
        public function setSurname( string $surname )  { $this->surname = $surname; }
        public function setName   ( string $name    )  { $this->name    = $name   ; }
    }// End class

?>