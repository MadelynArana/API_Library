<?php
    require_once 'PersonModel.php';

 
class AuthorModel extends PersonModel{

    function __construct(){
        parent::__constructTable('tb_author');
    }

    public function getId($code){
        $row= $this->getIdBase($code); // Consulta BD.
        $author = new AuthorModel();   // Objetos
        $author->setCode($row->id);
        $author->setName($row->name_author);
        $author->setSurname($row->sur_name);
        return $author;
    }

    public function getAll(){
        $data = $this->getAllBase(); // Consulta BD.
        foreach($data as $row){
            $author = new AuthorModel();    // Objetos
            $author->setCode($row->id);
            $author->setName($row->name_author);
            $author->setSurname($row->sur_name);
            $authors[] =$author;
        }
        return $authors;
    }
    
    public function insertUpdate(){        
      $sql = "CALL ps_author($this->code,'$this->name','$this->surname')" ;
        return $this->insertUpdateBase($sql);
    }
}

?>