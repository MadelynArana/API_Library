<?php
    require_once 'PersonModel.php';

 
    class AuthorModel extends PersonModel{

        function __construct(){
            parent::__constructTable('tb_author');
        }

        public function getId(int $code){
            $row= $this->getIdBase($code); // Consulta BD.
            if($row!='0'){
                $author = new AuthorModel();   // Objetos
                $author->setCode($row->id);
                $author->setName($row->name_author);
                $author->setSurname($row->sur_name);
                return $author;
            }else{
                return '0';
            }
        }

        public function getAll(){
            $data = $this->getAllBase(); // Consulta BD.    
            if($data!=0){
                foreach($data as $row){
                    $author = new AuthorModel();    // Objetos
                    $author->setCode($row->id);
                    $author->setName($row->name_author);
                    $author->setSurname($row->sur_name);
                    $authors[] =$author;
                }
                return $authors;
            }else{
                return 0;
            }
        }

        public function insertUpdate(){        
            $sql = "CALL ps_author($this->code,'$this->name','$this->surname')" ;
            return $this->insertUpdateBase($sql);
        }
    }// End class

?>