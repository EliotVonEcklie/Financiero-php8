<?php
	/**
	 * Modelo de Tabla comprobante_cab
	 * Almacena datos de la relacion con la cabecera de los comprobantes
	 */
	require(VENDOR_PATH.'autoload.php');
	use Illuminate\Database\Eloquent\Model;

	class ComprobanteCab extends Model{
		protected $table = 'comprobante_cab';
		protected $primaryKey = 'id_comp';
		public $timestamps = false;
	}
