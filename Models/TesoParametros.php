<?php
	/**
	 * Modelo de Tabla tesoparametros
	 * Almacena datos de la relacion de los parametros estandares de tesoreria
	 */
	require(VENDOR_PATH.'autoload.php');
	use Illuminate\Database\Eloquent\Model;

	class TesoParametros extends Model{
		protected $table = 'tesoparametros';
		protected $primaryKey = 'id';
		public $timestamps = false;
	}
