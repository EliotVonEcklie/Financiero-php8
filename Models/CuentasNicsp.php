<?php
	/**
	 * Modelo de Tabla cuentasnicsp
	 * Almacena datos con información de las cuentas nicsp
	 */
	require(VENDOR_PATH.'autoload.php');
	use Illuminate\Database\Eloquent\Model;

	class CuentasNicsp extends Model{
		protected $table = 'cuentasnicsp';
		protected $primaryKey = 'cuenta';
		public $timestamps = false;
	}
