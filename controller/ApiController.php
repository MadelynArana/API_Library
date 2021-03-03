<?php

    header('Content-Type: application/JSON');  

    require_once __DIR__."/AuthorController.php";
    require_once __DIR__."/BookController.php";
    require_once __DIR__."/StudentController.php";
    require_once __DIR__."/BorrowController.php";
    require_once __DIR__."/TypeController.php";

    class ApiController extends Message
    {   

        public function API()
        {       
            $method = $_SERVER['REQUEST_METHOD'];  // Se obtiene el request 

            $author  = new AuthorController(); // Controlador autor
            $book    = new BookController();
            $student = new StudentController();
            $borrow  = new BorrowController();
            $type    = new TypeController();
        
            switch ( $method )
            { 
                case 'GET': // Consulta.
                        $author ->getAuthor("get");
                        $book   ->getBook("get");
                        $student->getStudent("get");
                        $borrow->getBorrow("get");
                        $type->getType("get");
                    break;     

                case 'POST': // Inserta.
                        $author->getAuthor("save");
                        $book->getBook("save");
                        $student->getStudent("save");
                        $borrow->getBorrow("save");
                        $type->getType("save");
                    break;

                case 'PUT': // Actualiza.
                        $author->getAuthor("save");
                        $book->getBook("save");
                        $student->getStudent("save");
                        $borrow->getBorrow("save");
                        $type->getType("save");
                    break;        
            
                case 'DELETE': // Elimina.
                        $author->getAuthor("delete");
                        $book->getBook("delete");
                        $student->getStudent("delete");
                        $borrow->getBorrow("delete");
                       // $borrow->getType("delete");

                    break; 

                default: // Método no soportado.
                        $this->response(400,"error","Oops!, method not supported select a valid method. Example: PUT, GET, DELETE, POST.");  
                    break;
            }
        }
    }// End class
?>

