<?php
	/**
	 * Modelo de Tabla acticrearact_det
	 * Almacena datos de la relacion de los activos
	 */
	require(VENDOR_PATH.'autoload.php');
	use Illuminate\Database\Eloquent\Model;

	class ActicrearactDet extends Model{
		protected $table = 'acticrearact_det';
		protected $primaryKey = 'placa';
		public $timestamps = false;
	}
