<?php
	/**
	 * Modelo de Tabla planacareas
	 * Almacena datos de detalle de las areas del control de activos
	 */
	require(VENDOR_PATH.'autoload.php');
	use Illuminate\Database\Eloquent\Model;

	class PlanacAreas extends Model{
		protected $table = 'planacareas';
		protected $primaryKey = 'codarea';
		public $timestamps = false;
	}
