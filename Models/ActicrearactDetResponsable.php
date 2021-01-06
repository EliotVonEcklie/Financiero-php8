<?php
	/**
	 * Modelo de Tabla acticrearact_det_responsable
	 * Almacena datos de la relacion de los activos con funcionarios-terceros
	 */
	require(VENDOR_PATH.'autoload.php');
	use Illuminate\Database\Eloquent\Model;

	class ActicrearactDetResponsable extends Model{
		protected $table = 'acticrearact_det_responsable';
		protected $primaryKey = 'id';
		public $timestamps = false;
	}
