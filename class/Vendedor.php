<?php 

    namespace App;

    class Vendedor extends ActiveRecord {
        
        //Sobrescritura (sobrecarga) del atributo $tabla
        protected static $tabla = 'vendedores';
        protected static $columnasDB = ['id', 'nombre', 'apellido', 'telefono', 'email'];

        public $id;
        public $nombre;
        public $apellido;
        public $telefono;
        public $email;

        public function __construct ($args = []) {

            $this->id = $args['id'] ?? NULL;
            $this->nombre = $args['nombre'] ?? '';
            $this->apellido = $args['apellido'] ?? '';
            $this->telefono = $args['telefono'] ?? '';
            $this->email = $args['email'] ?? '';
        }


        //sobrecarga del método validarAtributos
        public function validarAtributos () {

            /**validar que los campos del formulario no esten vacíos */
            if(!$this->nombre) {
                self::$errores[] = 'Captura un nombre de vendedor';
            }
            if(!$this->apellido) {
                self::$errores[] = 'Captura un apellido de vendedor';
            }
            if(!$this->telefono) {
                self::$errores[] = 'Captura un telefono de vendedor';
            }
            if(!preg_match('/[0-9]{10}/', $this->telefono)) {
                self::$errores[] = 'Formato no válido para telefóno';
            }
            if(!$this->email) {
                self::$errores[] = 'Captura un email de vendedor';
            }

            return self::$errores;
        }


    }


?>