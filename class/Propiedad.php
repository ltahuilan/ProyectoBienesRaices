<?php 

    namespace App;

    class Propiedad extends ActiveRecord {

        //Sobrescritura (sobrecarga) del atributo $tabla
        protected static $tabla = 'propiedades';
        protected static $columnasDB = ['id', 'titulo', 'precio', 'descripcion', 'imagen', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedorId'];

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
            $this->id = $args['id'] ?? NULL;
            $this->titulo = $args['titulo'] ?? '';
            $this->precio = $args['precio'] ?? '';
            $this->descripcion = $args['descripcion'] ?? '';
            $this->imagen = NULL;
            $this->habitaciones = $args['habitaciones'] ?? '';
            $this->wc = $args['wc'] ?? '';
            $this->estacionamiento = $args['estacionamiento'] ?? '';
            $this->creado = date('Y/m/d H:i:s');
            $this->vendedorId = $args['vendedorId'] ?? '';
        }


        public function validarAtributos () {
            //sobrecarga del método validarAtributos

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
            if (!$this->vendedorId) {
                self::$errores[] = 'Selecciona un vendedor';
            }
            /**Validación de imagen */            
            if(!$this->imagen) {
                self::$errores[] = 'No se ha seleccionado una IMAGEN';
            }

            return self::$errores;
        }



    }

?>