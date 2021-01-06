<?php
	/**
	 * Modelo de Tabla actitraslados
	 * Almacena datos de la relacion de los traslados de los activos
	 */
	require(VENDOR_PATH.'autoload.php');
	use Illuminate\Database\Eloquent\Model;

	class ActiTraslados extends Model{
		protected $table = 'actitraslados';
		public $timestamps = false;
	}
