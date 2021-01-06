<?php
	/**
	 * Modelo de Tabla acti_prototipo
	 * Almacena datos de detalle de los prototipos del control de activos
	 */
	require(VENDOR_PATH.'autoload.php');
	use Illuminate\Database\Eloquent\Model;

	class ActiPrototipo extends Model{
		protected $table = 'acti_prototipo';
		public $timestamps = false;
	}
