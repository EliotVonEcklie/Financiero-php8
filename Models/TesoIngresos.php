<?php
	/**
	 * Modelo de Tabla tesoingresos
	 * Almacena datos de la relacion de los ingresos de tesoreria
	 */
	require(VENDOR_PATH.'autoload.php');
	use Illuminate\Database\Eloquent\Model;

	class TesoIngresos extends Model{
		protected $table = 'tesoingresos';
		protected $primaryKey = 'codigo';
		public $timestamps = false;
	}
