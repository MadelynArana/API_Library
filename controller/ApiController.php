<?php

    header('Content-Type: application/JSON');  

    require_once __DIR__."/AuthorController.php";

    class ApiController extends Message{   
        public function API(){       
            $method = $_SERVER['REQUEST_METHOD'];  // Se obtiene el request 

            // Controlador autor  
            $author = new AuthorController();

            $get='get';
            $save="save";
            $delete='delete';

            switch ( $method ){ 
                case 'GET': // Consulta.
                    $author->getAuthor($get);
                break;     
                case 'POST': // Inserta.
                    $author->getAuthor($save);
                break;
                case 'PUT': // Actualiza.
                    $author->getAuthor($save);
                break;        
            
                case 'DELETE': // Elimina.
                    $author->getAuthor($delete);
                break; 
                default: // Método no soportado.
                $this->response(400,"error","¡Ups!, método no soportado seleccione un método válido. Ejemplo: PUT,GET, DELETE, POST");  
                break;
            }

        }

        public function get(){

        }
        public function save(){}

        
        
    }// End class
?>

