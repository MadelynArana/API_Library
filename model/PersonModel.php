<?php
  require __DIR__.'/core/BaseEntity.php';

    class PersonModel extends BaseEntity{

        // Se coloca el nombre de la tabla de la BD.
        private $table ='';

        public $code = 0;
        public $name = null;
        public $surname = '';

        public function __construct(){
            parent::__constructTable($this->table);
        }
        /**Retorna código. */
        public function getCode() {
            return $this->code;
        }
        /** Retorna nombre. */
        public function getName(){
            return $this->name;
        }
        /** Retorna apellido. */
        public function getSurname(){
            return $this->surname;
        }
        /** Asigna código. */
        public function setCode(int $code) {
            $this->code = $code;
        }
        /** Asigna descripción. */
        public function setSurname($surname){
            $this->surname = $surname;
        }
        /** Asigna nombre. */
        public function setName($name){
            $this->name=$name;
        }

    }// End class

?>







