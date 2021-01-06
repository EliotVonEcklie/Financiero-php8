<?php
	/**
	 * Modelo de Tabla pptoacuerdos
	 * Almacena datos de los acuerdos
	 */
	require(VENDOR_PATH.'autoload.php');
	use Illuminate\Database\Eloquent\Model;

	class PptoAcuerdos extends Model{
		protected $table = 'pptoacuerdos';
		protected $primaryKey = 'id_acuerdo';
		public $timestamps = false;
	}
?>