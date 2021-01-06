<?php
	/**
	 * Modelo de Tabla pptorp_detalle
	 * Almacena datos de los detalles del RP
	 */
	require(VENDOR_PATH.'autoload.php');
	use Illuminate\Database\Eloquent\Model;

	class PptoRpDetalle extends Model{
		protected $table = 'pptorp_detalle';
		protected $primaryKey = 'id_cdpdetalle';
		public $timestamps = false;
	}
?>
