<?php
	/**
	 * Modelo de Tabla tesogastosbancarios
	 * Almacena datos de la relacion de los gasto bancarios
	 */
	require(VENDOR_PATH.'autoload.php');
	use Illuminate\Database\Eloquent\Model;

	class TesoGastosBancarios extends Model{
		protected $table = 'tesogastosbancarios';
		protected $primaryKey = 'codigo';
		public $timestamps = false;
	}