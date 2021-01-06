<?php
	/**
	 * Modelo de Tabla cuentas
	 * Almacena datos con información de las cuentas
	 */
	require(VENDOR_PATH.'autoload.php');
	use Illuminate\Database\Eloquent\Model;

	class Cuentas extends Model{
		protected $table = 'cuentas';
		protected $primaryKey = 'cuenta';
		public $timestamps = false;
	}
