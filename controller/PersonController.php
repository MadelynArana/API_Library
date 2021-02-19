<?php

    header('Content-Type: application/JSON');  
    require_once __DIR__."/../model/core/BaseEntity.php";
    require_once __DIR__."/../model/Person.php";

    class PersonController {   

        public function API(){       
            $method = $_SERVER['REQUEST_METHOD'];  // Se obtiene el request 
            switch ( $method ){ 
                case 'GET': // Consulta.
                    $this->getPerson();                         
                    break;     
                case 'POST': // Inserta.
                    $this->savePerson();                        
                    break;
                case 'PUT': // Actualiza.
                    $this->updatePerson();                      
                    break;        
                case 'DELETE': // Elimina.
                    $this->deletePerson();                   
                    break; 
                default: // Método no soportado.
                $this->response(400,"error","¡Ups!, método no soportado seleccione un método válido. Ejemplo: PUT,GET, DELETE, POST");  
                    break;
            }
        }   
        /** Mostrar registro
         * - Muestra uno o varios registros dependiendo del action.
         */
        public function getPerson(){
            if( $_GET['action']=='person' ){
                // Modelo de BD y objetos.              
                $data = new Person(); 
                if(isset( $_GET['id'] )){
                    // Consulta BD por id.  
                    $person = $data->getId( $_GET['id'] ); 
                    $dataArray =[// Se devuelve un arreglo.
                        'codigoPersona'=>intval($person->getCode()),
                        'nombrePersona'  => $person->getName(), 
                        'apellidoPersona'=>$person->getDesc()
                    ];
                    $this->messageJson( $dataArray ); // Respuesta al cliente
                }else{
                    // Consulta BD todos los registros.    
                    $persons = $data->getAll();           
                    $personArray = [];  // Se inicia un  arreglo vacío de personas.
                    $personArray['data']=[];
                    $numberPerson = count( $persons ); // Cuenta el número de registros.
                    $personArray['recordsNumbers'] = $numberPerson;
                    // Se recorren los valores de las propiedades y se agregan al arreglo.
                    foreach ($persons as $person){ 
                        $element = [
                            'codigoPersona' => intval( $person->getCode() ),
                            'nombrePersona' => $person->getName(),
                            'apellidoPersona' => $person->getDesc()
                            
                        ];
                        array_push( $personArray['data'], $element ); // Se agrega los elementos al arreglo personaArray['datos']
                    }
                    $this->messageJson( $personArray );
                }
            }else{
                $this->response(400,"error","no existe el elemento");  
            }       
        }  
        /**
         * Guarda un nuevo registro.
         */
        function savePerson(){
            if($_GET['action']=='person'){
                // Modelo de BD y objetos.
                $data = new Person(); 
                $obj  = json_decode( file_get_contents('php://input') ); // Se obtienen los datos enviados en el cuerpo de la petición.                   // Se settean los datos del modelo con los obtenidos de la petición json.
                $data->setName( $obj->nombrePersona );
                $data->setDesc( $obj->apellidoPersona );  
                // Guarda el nuevo registro.
                $data->insertUpdate(); 
                $this->response(200,"success","new record added");     
            }
            else{               
                $this->response(400,"error","non-existing element");  
            }  
        }
        /**
         * Actualiza un registro existen.
         * Recibe en el $_GET['id'] en código que se desea actualizar.
         */
        function updatePerson(){       
            if($_GET['action']=='person'){
                if(isset( $_GET['id'] )){
                    // Modelo de BD y objetos.
                    $data   = new Person();
                    $obj  = json_decode( file_get_contents('php://input') ); // Se obtienen los datos enviados en el cuerpo de la petición.   
                    // Se settean los datos del modelo con los obtenidos de la petición json.
                    $name   = $obj->nombrePersona;
                    $desc   = $obj->apellidoPersona;  
                    // Consulta el registro por id.
                    $person = $data->getId( $_GET['id'] ); 
                    // Verfica si viene en blanco los valores de ser así se asigna los valores de la bd.
                    $name   = $name == "" ? $person->getName() : $person->setName( $name );
                    $desc   = $desc == "" ? $person->getDesc() : $person->setDesc( $desc );
                    $person->insertUpdate(); // Guarda el nuevo registro.
                    $this->response(200,"success","updated record");  
                }
                else{
                    $this->response(400,"error","add a parameter");  
                }    
            }else{               
                $this->response(400,"error","non-existing element");  
            }  
        }
        /**
         * Elimina un registro.
         * Recibe en el $_GET['id'] el código  que se desea eliminar.
         */
        function deletePerson(){
            if($_GET['action']=='person'){
                // Modelo de BD y objetos.
                $data = new Person(); 
                if(isset( $_GET['id'] )){
                    $data->delete( $_GET['id'] ); // Elimina un registro de la BD.
                    $this->response(200,"success","record was deleted");
                }else{
                    $this->response(400,"error","no record was deleted");   
                }
            }else{
                $this->response(400,"error","non-existing element");  
            }
        }
        /**
         * Respuesta al cliente: 
         * Parámetro int $code Código de respuesta HTTP.
         * Parámetro String $status Indica el estado de la respuesta puede ser "success" o "error".
         * Parámetro String $message Descripción de lo ocurrido.
         */
        function response($code=200, $status="", $message=""){
            http_response_code( $code );
            if( !empty( $status ) && !empty( $message ) ){
                $response = array("status" => $status ,"message"=>$message);  
                ob_end_clean();
                echo json_encode($response,JSON_PRETTY_PRINT);    
            } 
        }
        /**
         * Respuesta al cliente:
         * Parámetro string $data: Imprime un mensaje en formato json_pretty_print de lo que ha ocurido en la BD.
         */
        public function messageJson($data){
            ob_end_clean();
            echo json_encode($data, JSON_PRETTY_PRINT);
        }
    } //End class

?>

