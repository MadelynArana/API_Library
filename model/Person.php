<?php

    class Person extends BaseEntity{

        // Se coloca el nombre de la tabla de la BD.
        private $table ='persona';

        private $code = 0;
        private $name = null;
        private $desc = null;

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
        /** Retorna descripción. */
        public function getDesc(){
            return $this->desc;
        }

        /** Asigna código. */
        public function setCode($code) {
            $this->code = $code;
        }
        /** Asigna descripción. */
        public function setDesc($desc){
            $this->desc = $desc;
        }
        /** Asigna nombre. */
        public function setName($name){
            $this->name=$name;
        }

        /**
         * Inserta o actualiza un registro.
         * - Pide como parámetro la consulta hacia la BD.
         * - Se válida si el código viene en blanco de ser así se agrega un nuevo registro y caso contrario se 
         * actualiza.
         */
        public function insertUpdate(){
            if($this->code==''){
                $sql="INSERT INTO persona(nombre_persona,apellido_persona)values('$this->name','$this->desc')";
                
            }else{
                $sql="UPDATE persona set nombre_persona='$this->name', apellido_persona='$this->desc' where codigo_persona=$this->code";
            }
            return $this->insertUpdateBase($sql);
        }
        
        /**
         * Devuelve un arreglo con un sólo registro.
         * - Se pide como parámetro el id.
         */
        public function getId($code){
        // Consulta BD.
            $row= $this->getIdBase($code);
            $person = new Person();
            $person->setCode($row->codigo_persona);
            $person->setName($row->nombre_persona);
            $person->setDesc($row->apellido_persona);
            return $person;  
        }

        /**
         * Devuelve todos los registros. 
         */
        public function getAll(){
            // Consulta BD.
            $data =$this->getAllBase();
            foreach($data as $row){
                $person = new Person();
                $person->setCode($row->codigo_persona);
                $person->setName($row->nombre_persona);
                $person->setDesc($row->apellido_persona);
                $persons[] =$person;
            }
            return $persons;
        }
    }// End class

?>







