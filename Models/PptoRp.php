<?php
	/**
	 * Modelo de Tabla pptorp
	 * Almacena datos de los RP
	 */
	require(VENDOR_PATH.'autoload.php');
	use Illuminate\Database\Eloquent\Model;

	class PptoRp extends Model{
		protected $table = 'pptorp';
		//protected $primaryKey = 'vigencia';
		public $timestamps = false;
	}
?>
