<?php
	/**
	 * Modelo de Tabla actiubicacion
	 * Almacena datos de detalle de las ubicaciones del control de activos
	 */
	require(VENDOR_PATH.'autoload.php');
	use Illuminate\Database\Eloquent\Model;

	class ActiUbicacion extends Model{
		protected $table = 'actiubicacion';
		protected $primaryKey = 'id_cc';
		public $timestamps = false;
	}
