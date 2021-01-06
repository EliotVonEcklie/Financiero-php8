<?php
	/**
	 * Modelo de Tabla terceros
	 * Almacena datos de los terceros
	 */
	require(VENDOR_PATH.'autoload.php');
	use Illuminate\Database\Eloquent\Model;

	class Terceros extends Model
	{
		protected $table = 'terceros';
		protected $primaryKey = 'id_tercero';
		public $timestamps = false;
	}
