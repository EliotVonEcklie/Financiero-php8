<?php
	/**
	 * Modelo de Tabla tesogastosbancarios_det
	 * Almacena datos de la relacion de los detalles de gasto bancarios
	 */
	require(VENDOR_PATH.'autoload.php');
	use Illuminate\Database\Eloquent\Model;

	class TesoGastosBancariosDet extends Model{
		protected $table = 'tesogastosbancarios_det';
		protected $primaryKey = 'id_det';
		public $timestamps = false;
	}