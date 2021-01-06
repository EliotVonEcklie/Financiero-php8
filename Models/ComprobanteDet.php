<?php
	/**
	 * Modelo de Tabla comprobante_det
	 * Almacena datos de la relacion con los detalles de los comprobantes
	 */
	require(VENDOR_PATH.'autoload.php');
	use Illuminate\Database\Eloquent\Model;

	class ComprobanteDet extends Model{
		protected $table = 'comprobante_det';
		protected $primaryKey = 'id_det';
		public $timestamps = false;
	}
