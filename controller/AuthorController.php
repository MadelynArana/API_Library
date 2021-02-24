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
                    $response = $dataBase->getArray(1);
                    $this->messageJson($response);
                    break;

                    default: 
                        $this->response(400,"error","non-existing element");  
                    break;
                }
            }
        }
    }// End class
?>