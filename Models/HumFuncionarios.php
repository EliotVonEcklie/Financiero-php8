<?php
	/**
	 * Modelo de Tabla hum_funcionarios
	 * Almacena datos de los funcionarios-terceros nomina
	 */
	require(VENDOR_PATH.'autoload.php');
	use Illuminate\Database\Eloquent\Model;

	class HumFuncionarios extends Model{
		protected $table = 'hum_funcionarios';
		protected $primaryKey = 'codrad';
		public $timestamps = false;
	}
