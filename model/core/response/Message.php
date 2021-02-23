<?php
    header('Content-Type: application/JSON'); 
    
    class Message{   
        /**
         * Respuesta al cliente: 
         * Parámetro int $code Código de respuesta HTTP.
         * Parámetro String $status Indica el estado de la respuesta puede ser "success" o "error".
         * Parámetro String $message Descripción de lo ocurrido.
         */
        function response($code=200, $status="", $message=""){
            http_response_code( $code );
            if( !empty( $status ) && !empty( $message ) )
            {
                $response = array("status" => $status ,"message"=>$message);  
                echo json_encode($response,JSON_PRETTY_PRINT);    
            }  
        }
        /**
         * Respuesta al cliente:
         * Parámetro string $data: Imprime un mensaje en formato json_pretty_print de lo que ha ocurido en la BD.
         */
        function messageJson($data)
        {
            ob_end_clean();
            echo json_encode($data, JSON_PRETTY_PRINT);
        }
    }
?>