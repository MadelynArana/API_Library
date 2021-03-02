<?php

    require_once __DIR__."/../model/BorrowModel.php";
    require_once __DIR__."/../model/core/response/Message.php";

    class BorrowController extends Message
    {
        public function getBorrow( $option )
        {
            if($_GET['action']=='borrow')
            {
                $database = new BorrowModel(); // Base de datos

                switch( $option )
                {
                    case 'get': // Válida que exista un id en el $_GET['id']. Si existe busca por ID de lo contrario muestra todos los registros.                  
                            if(isset($_GET['id'])) {
                                $response = $database->getData($_GET['id']);
                                ( $response != 0 ) ? $this->messageJson( $response ):  $this->messageJson("Record does not exist.");
                            }else if(isset($_GET['fecha_inicial']) && $_GET['fecha_final']){                                                      
                                $response = $database->getDateBroughtFilter($_GET['fecha_inicial'],$_GET['fecha_final']);
                                ( $response != 0 ) ? $this->messageJson( $response ):  $this->messageJson("There are no records.");
                            }                            
                            else{
                                $response = $database->getData(0);             
                                ( $response != 0 ) ? $this->messageJson( $response ):  $this->messageJson("There are no records.");
                            }
                        break;

                    case 'save': // Guarda o actualiza un nuevo registro.
                            // Se obtienen los datos enviados en el cuerpo de la petición.  
                            $jsonObj = json_decode( file_get_contents('php://input') ); 
                            $studentCode = $jsonObj->studentCode;
                            $bookCode    = $jsonObj->bookCode;
                            $broughtDate = $jsonObj->broughtDate;
                            $takenDate   = $jsonObj->takenDate;

                            if(isset($_GET['id'])){
                                $database->update( $_GET['id'], $studentCode, $bookCode, $broughtDate, $takenDate ); // Actualiza un registro.                  
                                $this->response(200,"Success","Record was updated.");                         
                            }else{
                                $database->insert( 0 , $studentCode, $bookCode, $broughtDate, $takenDate );  // Guarda un nuevo registro.
                                $this->response(200,"Success","New record added.");
                            }
                        break;

                    case 'delete': // Elimina un registro de la base de datos. 
                            if(isset($_GET['id'])){
                                $database->delete($_GET['id']); 
                                $this->response(200,"Success","Record was deleted.");
                            }else{
                                $this->response(400,"error","Record was not deleted.");
                            }
                        break;
                        
                    default: 
                        $this->response(400,"error","default book non-existing element");  
                        break;
                }
            }
        }
    } // End class 
?>