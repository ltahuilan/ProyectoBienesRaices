<?php 

    namespace App;

    class Propiedad {

        //Atributo estatico para almacenar la conexion a la DB
        protected static $db;

        //Atributo utilizado para mapear los valores del objeto en memoria
        protected static $columnasDB = ['id', 'titulo', 'precio', 'descripcion', 'imagen', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedorId'];

        //Array para almacenar errores durante la validacion
        protected static $errores = [];

        public $id;
        public $titulo;
        public $precio;
        public $descripcion;
        public $imagen;
        public $habitaciones;
        public $wc;
        public $estacionamiento;
        public $creado;
        public $vendedorId;


        public function __construct($args = [])
        {
            $this->titulo = $args['titulo'] ?? '';
            $this->precio = $args['precio'] ?? '';
            $this->descripcion = $args['descripcion'] ?? '';
            $this->imagen = '';
            $this->habitaciones = $args['habitaciones'] ?? '';
            $this->wc = $args['wc'] ?? '';
            $this->estacionamiento = $args['estacionamiento'] ?? '';
            $this->creado = date('Y/m/d H:i:s');
            $this->vendedorId = $args['vendedorId'] ?? '';
        }

        
        /**método que recibe como parametro la conexión a la DB
         * desde config/database.php y lo almacena en el atributo
         * protected
         */
        public static function setDB ($database) {
            self::$db = $database;
        }


        public function guardar () {

            //llamada a método desde otro método
            $atributos = $this->sanitizaAtributos();

            /**Inserta valores en la DB 
             * Empleo de join() para convertir en un string las llaves y valores del arreglo
             * Se concatena todo en un solo string
             */
            
            $query = "INSERT INTO propiedades ( ";
            $query .= join( ', ', array_keys($atributos) );
            $query .= ") VALUES ( '";
            $query .= join( "', '", array_values($atributos) );
            $query .= "' )";
            
            $resultado = self::$db->query($query);
            
            return $resultado;
        }


        public function mapeoAtributos () {

            $atributos = [];
            
            foreach(self::$columnasDB as $columna) {

                if ($columna == 'id') continue; //ignorar elemento 'id'
                $atributos[$columna] = $this->$columna; //VER: NOTA IMPORTANTE

            }

            return $atributos;

            /** NOTA IMPORTANTE
            * $this contiene la referencia al objeto en memoria.
            * $this->$columna accede al valor de la posición del arreglo mapeada como $columna
            * Es decir:  $atributos['nombre'] = $propiedad['Casa en la playa'];
            * Donde $propiedad es la instancia de objeto en memoria con el elemento pasado desde el objeto $_POST 
            */

        }


        public function sanitizaAtributos () {

            $atributos = $this->mapeoAtributos();

            $sanitizado = [];

            foreach ($atributos as $llave => $valor) {
                $sanitizado[$llave] = self::$db->real_escape_string($valor);
            }
            return $sanitizado;

        }


        public function setImagen ($nombre_imagen) {

            //asignar al atributo el nombre de la imagen
            if ($nombre_imagen) {
                $this->imagen = $nombre_imagen;

            }
            // debuguear($this->imagen);
        }


        public static function getErrores () {

            return self::$errores;      
        }


        public function validarAtributos () {

            /**validar que los campos del formulario no esten vacíos */
            if(!$this->titulo) {
                self::$errores[] = 'El titulo no puede estar vacío';
            }
            if(!$this->precio) {
                self::$errores[] = 'Debes añadir un precio a la propiedad';
            }
            if(strlen($this->descripcion) < 30) {
                self::$errores[] = 'Falta una descripción o debe tener al menos 30 caracteres';
            }
            if(!$this->habitaciones) {
                self::$errores[] = 'Indica el número de habitaciones';
            }
            if(!$this->wc) {
                self::$errores[] = 'Indica el número de baños';
            }
            if(!$this->estacionamiento) {
                self::$errores[] = 'Indica el número de estacionamientos';
            }

            /**Validación de imagen */
            
            if(!$this->imagen) {
                self::$errores[] = 'No se ha seleccionado una IMAGEN';
            }

            return self::$errores;
        }


        public static function getTodo () {

            $query = "SELECT * FROM propiedades";
            $resultado = self::consultaSQL($query);        
            return $resultado;
        }


        public static function consultaSQL($query) {

            //consultar la base de datos
            $resultado = self::$db->query($query);

            //iterar los resultados
            $array = [];
            while ($registro = $resultado->fetch_assoc() ) {

                /**Por cada iteración se agrega en el array un objeto
                 * creado con el método crearObjeto
                 * */
                $array[] = self::crearObjeto($registro);
            }

            //liberar memoria 
            $resultado->free();

            //devolver los resultados
            return $array;
        }


        /**Método que crea un objeto con los datos que recibe como parametros */
        protected static function crearObjeto (&$registro) {

            //se crea una copia en memoria del objeto
            $objeto = new self;

            foreach ($registro as $llave => $valor) {
                
                // //si la llave existe dentro del objeto...
                if (property_exists($objeto, $llave)) {
                    
                    //mapear la llave con el valor...
                    $objeto->$llave = $valor;
                }
            }
            return $objeto;
        }

    }

?>