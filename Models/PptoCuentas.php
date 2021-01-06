<?php
	/**
	 * Modelo de Tabla pptocuentas
	 * Almacena datos de la cuentas
	 */
	require(VENDOR_PATH.'autoload.php');
	use Illuminate\Database\Eloquent\Model;

	class PptoCuentas extends Model{
		protected $table = 'pptocuentas';
		protected $primaryKey = 'cuenta';
		public $timestamps = false;
	}