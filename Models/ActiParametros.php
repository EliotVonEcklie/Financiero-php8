<?php
	/**
	 * Modelo de Tabla actiparametros
	 * Almacena datos de la relacion de los parametros estandares de control de activos
	 */
	require(VENDOR_PATH.'autoload.php');
	use Illuminate\Database\Eloquent\Model;

	class ActiParametros extends Model{
		protected $table = 'actiparametros';
		public $timestamps = false;
	}
