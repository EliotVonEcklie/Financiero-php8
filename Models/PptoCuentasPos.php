<?php
	/**
	 * Modelo de Tabla pptocuentas_pos
	 * Almacena datos de la posición de las cuentas
	 */
	require(VENDOR_PATH.'autoload.php');
	use Illuminate\Database\Eloquent\Model;

	class PptoCuentasPos extends Model{
		protected $table = 'pptocuentas_pos';
		public $timestamps = false;
	}
