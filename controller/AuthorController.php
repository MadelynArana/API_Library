<?php
    header('Content-Type: application/JSON');  
    require_once __DIR__."/../model/AuthorModel.php";
    require_once __DIR__."/response/Message.php";

    class AuthorController extends Message{

        public function getAuthor( $data ){
            if($_GET['action']=='author'){
                // Base de datos con objetos
                $dataBase = new AuthorModel();
                switch( $data ){
                    
                    case 'get':       
                        if(isset( $_GET['id'] )){
                            $response = $dataBase->getId( $_GET['id'] );
                            $response !=0 ?  $this->messageJson( $response ) :  $this->response(200,"Warning","No records found.");
                        }else{
                            $response = $dataBase->getAll();
                            $response !=0 ?  $this->messageJson( $response ) :  $this->response(200,"Warning","No records found.");              
                        }
                    break;
                    
                    case 'save':
                        $jsonObject = json_decode( file_get_contents('php://input') ); // Se obtienen los datos enviados en el cuerpo de la petición.   
                        $name    = $jsonObject->name;
                        $surname = $jsonObject->surname;         
                        if(isset($_GET['id'])){
                            $code = $_GET['id'];     
                            $author = $dataBase->getId($code);                           
                            // Verfica si viene en blanco los valores de ser así se asigna los valores de la bd.                          
                            $name   = $name == "" ? $author->getName() : $author->setName( $name );
                            $surname   = $surname == "" ? $author->getSurname() : $author->setSurname( $surname );
                            $author->insertUpdate(); // Guarda el nuevo registro.
                            $this->response(200,"Success","Record was updated.");     
                            }else{
                                $dataBase->setCode(0);
                                $dataBase->setName($name);
                                $dataBase->setSurname($surname);
                                $dataBase->insertUpdate();
                                $this->response(200,"Success","New record added.");
                        }      
                    break;

                    case 'delete':
                        if(isset($_GET['id'])){
                            $dataBase->delete($_GET['id']);
                            $this->response(200,"Success","Record delete.");
                        }
                    break;
                    
                    default: 
                        $this->response(400,"error","non-existing element");  
                    break;
                }
            }else{
                $this->response(400,"error","non-existing element");  
            }
        }
    }// End class
?>