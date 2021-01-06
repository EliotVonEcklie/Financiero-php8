<?php
	/**
	 * Modelo de Tabla pptocuentas_his
	 * Almacena datos de historial de carga de las cuentas
	 */
	require(VENDOR_PATH.'autoload.php');
	use Illuminate\Database\Eloquent\Model;

	class PptoCuentasHis extends Model{
		protected $table = 'pptocuentas_his';
		public $timestamps = false;
	}