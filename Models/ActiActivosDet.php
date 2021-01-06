<?php
	/**
	 * Modelo de Tabla acti_activos_det
	 * Almacena datos de la relacion con los detalles de los comprobante y cuentas
	 */
	require(VENDOR_PATH.'autoload.php');
	use Illuminate\Database\Eloquent\Model;

	class ActiActivosDet extends Model{
		protected $table = 'acti_activos_det';
		protected $primaryKey = 'id';
		public $timestamps = false;
	}
