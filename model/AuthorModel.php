<?php
    require_once __DIR__.'/core/PersonModel.php';

 
    class AuthorModel extends PersonModel
    {
        function __construct(){
            parent::__constructTable('author');
        }
        /** Busca un registro pide como parámetro un id entero */
        public function getId(int $code){
            $row= $this->getIdBase($code); // Consulta BD.
            if($row!='0')
            {
                $author = new AuthorModel();   // Objetos
                $author->setCode($row->id);
                $author->setName($row->name_author);
                $author->setSurname($row->sur_name);
                return $author;
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
                    $author = new AuthorModel(); // Objetos
                    $author->setCode($row->id);
                    $author->setName($row->name_author);
                    $author->setSurname($row->sur_name);
                    $authors[] =$author;
                }
                return $authors;
            } 
            else{
                return 0;
            }
        }
        /** Inserta o actualiza un registro dependiendo si el parámetro id tiene el número 0 inserta de lo contrario actualiza */
        public function insertUpdate()
        {        
            $sql = "CALL ps_author_isert_update($this->code,'$this->name','$this->surname')" ; // Consulta BD.  
            return $this->insertUpdateBase($sql); // Ingresa o actualiza un registro.  
        }
    }// End class

?>