<?php
	/**
	 * Modelo de Tabla configbasica
	 * Almacena datos de la relacion con la configuració basica de la entidad
	 */
	require(VENDOR_PATH.'autoload.php');
	use Illuminate\Database\Eloquent\Model;

	class ConfigBasica extends Model{
		protected $table = 'configbasica';
		protected $primaryKey = 'nit';
		public $timestamps = false;
	}
