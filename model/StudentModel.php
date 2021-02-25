<?php
    require_once __DIR__.'/core/PersonModel.php';

    class StudentModel extends PersonModel
    {
        public  $birthday = NULL,
                $gender   = NULL,
                $class    = NULL,
                $point    = 0;

        // Se agrega el nombre del procedimiento almacenado a ser utilizado.
        function __construct()
        {
            parent::__constructTable('student');
        }
        // Métodos getters
        public function getClass   () { return $this->class;    }
        public function getPoint   () { return $this->point;    }
        public function getGender  () { return $this->gender;   }
        public function getBirthday() { return $this->birthday; }
        // Métodos setters
        public function setClass   ( String $class    ) { $this->class    = $class;    }
        public function setPoint   ( int    $point    ) { $this->point    = $point;    }
        public function setGender  ( String $gender   ) { $this->gender   = $gender;   }
        public function setBirthday( String $birthday ) { $this->birthday = $birthday; }
        /**
         * Settea la clase con las propiedades de la base de datos.
        *   - Párametro $class, instancia de una clase por ejemplo $book = new BookModel.
        *   - Párametro $row, hace referencia a la fila de la base de datos por 
         */
        protected function setDatabaseProperties( $class , $row )
        {  
            $class->setCode    ( $row->code             );
            $class->setName    ( $row->student_name     );
            $class->setPoint   ( $row->student_point    );
            $class->setClass   ( $row->student_class    );
            $class->setGender  ( $row->student_gender   );
            $class->setSurname ( $row->student_surname  );
            $class->setBirthday( $row->student_birthday );       
        }
        /** 
         * Obtiene información de la base de datos. 
         * */
        protected function getObjects( $data )
        {
            $element = [
                'code'    => $data->getCode(),
                'name'    => $data->getName(),
                'surname' => $data->getSurname (),
                'birthday'=> $data->getBirthday(),
                'gender'  => $data->getGender(),
                'point'   => $data->getPoint(),
                'class'   => $data->getClass()
            ]; 
            return $element;
        }
        /**
         * Obtiene registros 
         *  - Parámetro $id recibe un número distinto a 0 devuelve un sólo registro.
         *  - Parámetro $id recibe un 0 devuelve todos los registros.
         */ 
        public function getData( $id )
        {  
            $book = new StudentModel();
            return $this->getArray( $id , $book );
        }
        /** 
         * Inserta o actualiza un registro 
        *   - Si en el método setCode() se asigna un 0 se inserta un nuevo registro de lo contrario se actualiza.
        */
        protected function insertUpdate()
        {          
            $sql = "CALL ps_student_insert_update({$this->code},'{$this->name}','{$this->surname}','{$this->birthday}','{$this->gender}','{$this->class}','{$this->point}')" ; // Consulta BD.         
            $this->query( $sql );
            return $sql;
        }
        /** 
         * Actualiza un registro existente
         *  - Si algún campo en el cuerpo del json viene vacío, realiza una búsqueda y retorna el valor almacenado en la base de datos.
         */
        public function update( $code, $name, $surname, $birthday, $gender, $class, $point )
        {
            $Student = new StudentModel();
            $searchStudent = $this->setArray( $code , $Student ); // Busca el registro por id.
            /* Verifica si las propiedades vienen vacías de ser así retorna el valor que se encuentra en la base de datos, caso contrario 
            *  actualiza el nuevo valor. */                       
            $name     = $name    ==""  ?  $searchStudent->getName()     : $searchStudent->setName( $name  );
            $class    = $class   ==""  ?  $searchStudent->getClass()    : $searchStudent->setClass( $class );   
            $point    = $point   ==""  ?  $searchStudent->getPoint()    : $searchStudent->setPoint( $point );   
            $gender   = $gender  ==""  ?  $searchStudent->getGender()   : $searchStudent->setGender( $gender );
            $surname  = $surname ==""  ?  $searchStudent->getSurname()  : $searchStudent->setSurname( $surname );
            $birthday = $birthday==""  ?  $searchStudent->getBirthday() : $searchStudent->setBirthday( $birthday);
            $searchStudent->insertUpdate();
        }
        /** 
         * Guarda un nuevo registro. 
         * */      
        public function insert( $code, $name, $surname, $birthday, $gender, $class, $point )
        {
            $this->setCode( $code = 0 );
            $this->setName( $name );
            $this->setClass( $class );
            $this->setPoint( $point );
            $this->setGender( $gender );
            $this->setSurname( $surname );
            $this->setBirthday( $birthday );
            $this->insertUpdate(); // Guarda un nuevo registro.  
        }
    }// End class
?>