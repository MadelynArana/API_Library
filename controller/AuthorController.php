<?php
    header('Content-Type: application/JSON');  
    require_once __DIR__."/../model/AuthorModel.php";
    require_once __DIR__."/../model/core/response/Message.php";

    class AuthorController extends Message
    {
        public function getAuthor( $data )
        {
            if($_GET['action']=='author')
            {    
                // Instancias del modelo de base de datos. 
                $dataBase = new AuthorModel();

                switch( $data )
                {
                    case 'get': // Muestra todos los registros o sólo uno.       
                        if(isset( $_GET['id'] ))
                        {  // Obtiene el código por medio del $_GET.
                            $response = $dataBase->getId( $_GET['id'] ); // Muestra un registro.
                            $response !='0' ?  $this->messageJson( $response ) :  $this->response(200,"Warning","No records found.");
                        }
                        else{
                                $response = $dataBase->getAll(); // Muestra todos los registros.
                                $response !=0 ?  $this->messageJson( $response ) :  $this->response(200,"Warning","No records found.");              
                            }
                    break;
                    
                    case 'save': // Guarda o actualiza un registro.
                        // Se obtienen los datos enviados en el cuerpo de la petición.  
                        $jsonObject = json_decode( file_get_contents('php://input') ); 
                        $name    = $jsonObject->name;
                        $surname = $jsonObject->surname;         
                        
                        if(isset($_GET['id'])) // Actualiza un registro por medio del id enviado.
                        {
                            $code = $_GET['id'];     
                            $author = $dataBase->getId($code); // Busca el registro en la BD.
                            
                            // Verfica si viene en blanco los valores de ser así se asigna los valores de la bd.                          
                            $name   = $name == "" ? $author->getName() : $author->setName( $name );
                            $surname   = $surname == "" ? $author->getSurname() : $author->setSurname( $surname );
                            
                            $author->insertUpdate(); // Actualiza el registro.
                            $this->response(200,"Success","Record was updated.");  
                        }
                        else
                            {
                                $dataBase->setCode(0); // Se settean los valores con los obtenidos del $jsonObject
                                $dataBase->setName($name);
                                $dataBase->setSurname($surname);
                            
                                $dataBase->insertUpdate(); // Guarda el nuevo registro.
                                $this->response(200,"Success","New record added.");
                            }      
                    break;

                    case 'delete': // Elimina un registro de la bd pide como parametro $_GET['id']
                        if(isset($_GET['id']))
                        {
                            $dataBase->delete($_GET['id']); // Elimina un registro.
                            $this->response(200,"Success","Record delete.");
                        }
                    break;
                    
                    default: 
                        $this->response(400,"error","non-existing element");  
                    break;
                }
            }else
                {
                    $this->response(400,"error","non-existing element");  
                }
        }
    }// End class
?>