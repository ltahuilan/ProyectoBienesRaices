<?php 

namespace App;

    class ActiveRecord {

        /**BASE DE DATOS */
        //Atributo estatico para almacenar la conexion a la DB
        protected static $db;
        //Atributo utilizado para mapear los valores del objeto en memoria
        protected static $columnasDB = [];
        //Atributo para asignar dinamicamente la tabla
        protected static $tabla = '';

        //Array para almacenar errores durante la validacion
        protected static $errores = [];

        
        /**método que recibe como parametro la conexión a la DB
         * desde config/database.php y lo almacena en el atributo
         * protected
         */
        public static function setDB ($database) {
            self::$db = $database;
        }


        public function guardar () {

            if (!is_null($this->id)) {
                $this->editar();
            }else {
                $this->crear();
            }
        }


        public function crear () {

            //llamada a método desde otro método
            $atributos = $this->sanitizaAtributos();

            /**Inserta valores en la DB 
             * join() convierte en un string las llaves y valores del arreglo, Se concatena todo en un solo string
             * static:: para acceder a métodos o atributos sobrecargados en otra clase
             */
            
            $query = "INSERT INTO " . static::$tabla . " ( ";
            $query .= join( ', ', array_keys($atributos) );
            $query .= ") VALUES ( '";
            $query .= join( "', '", array_values($atributos) );
            $query .= "' )";
            
            $resultado = self::$db->query($query);

            /**query string: permite pasar cualquier tipo de valor por medio de la url */
            if ($resultado ){
                header('Location: /admin/?resultado=1');
            }
            
            return $resultado;
        }


        public function editar () {

            //llamada a método desde otro método
            $atributos = $this->sanitizaAtributos();

            $valores = [];

            foreach ($atributos as $llave => $valor ) {
                $valores[] = " {$llave} = '$valor' ";

            }
            
            $query = "UPDATE " . static::$tabla . " SET ";
            $query .= join(', ', $valores);
            $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
            $query .= " LIMIT 1";

            $resultado = self::$db->query($query);

            if($resultado) {
                /**query string: permite pasar cualquier tipo de valor por medio de la url */
                header('Location: /admin?resultado=2');
            }
        }

        public function eliminar () {

            //Elima el registro de la DB
            $query = "DELETE FROM " . static::$tabla . " WHERE id = '" . self::$db->escape_string($this->id) . "' LIMIT 1";

            $resultado = self::$db->query($query);

            if ($resultado) {                
                $this->borrarImagen();
                header('Location: /admin?resultado=3');
            }

        }


        public function mapeoAtributos () {

            $atributos = [];
            
            foreach(static::$columnasDB as $columna) {

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

            //verificar si existe imagen para borrar
            if (!is_null( $this->id) ) {
                //verificar si existe imagen para borrar    
                $existeArchivo = file_exists(DIR_IMAGENES . $this->imagen);

                if ($existeArchivo) {
                    unlink(DIR_IMAGENES . $this->imagen);
                }

            }

            //asignar al atributo el nombre de la imagen
            if ($nombre_imagen) {
                $this->imagen = $nombre_imagen;

            }
        }


        public function borrarImagen() {
            
            //verificar si existe imagen para borrar    
            $existeArchivo = file_exists('../upload_img/' . $this->imagen);

            if ($existeArchivo) {
                unlink('../upload_img/' . $this->imagen);
            }
        }


        public static function getErrores () {

            return static::$errores;      
        }


        public function validarAtributos () {
            static::$errores = [];
            return static::$errores;
        }

        //consultar todos los registros
        public static function getTodo () {

            $query = "SELECT * FROM " . static::$tabla;
            $resultado = self::consultaSQL($query);        
            return $resultado;
        }


        //consultar número determinado de registros
        public static function getLimit ($limit) {

            $query = "SELECT * FROM " . static::$tabla . " LIMIT " . $limit;
            $resultado = self::consultaSQL($query);        
            return $resultado;
        }


        //consultar registro por id
        public static function getById ($id) {

            $query = "SELECT * FROM " . static::$tabla . " WHERE id = ${id}";

            $resultado = self::consultaSQL($query);

            return array_shift($resultado); //array_shift devuelve el primer elemento dentro de un arreglo

        }


        /**Método que crea un arreglo de objetos con el objeto
         * que recibe desde crearObjeto()
         */
        public static function consultaSQL($query) {

            //consultar la base de datos
            $resultado = self::$db->query($query);

            //iterar los resultados
            $array = [];
            while ($registro = $resultado->fetch_assoc() ) {

                /**Por cada iteración se agrega en el array un objeto
                 * creado con el método crearObjeto
                 * */
                $array[] = static::crearObjeto($registro);
            }

            //liberar memoria 
            $resultado->free();

            //devolver los resultados
            return $array;
        }


        /**Método que crea un objeto con los datos que recibe 
         * desde consultaSQL()
         */
        protected static function crearObjeto (&$registro) {

            //se crea una copia en memoria del objeto
            $objeto = new static;

            foreach ($registro as $llave => $valor) {
                
                // //si la llave existe dentro del objeto...
                if (property_exists($objeto, $llave)) {
                    
                    //mapear la llave con el valor...
                    $objeto->$llave = $valor;
                }
            }
            return $objeto;
        }


        /**Método que sincroniza el objeto en memoria con
         * los datos modificados en el formulario
         */

        public function sincronizar ($args = []) {

            //recorrer arreglo
            foreach ($args as $llave => $valor) {
                if ( property_exists($this, $llave) && !is_null($valor)) {
                    $this->$llave = $valor;
                }
            }

        }

    }
?>