<?php
	/**
	 * Modelo de Tabla acti_disposicionactivos
	 * Almacena datos de detalle de la disposción del control de activos
	 */
	require(VENDOR_PATH.'autoload.php');
	use Illuminate\Database\Eloquent\Model;

	class ActiDisposicionActivos extends Model{
		protected $table = 'acti_disposicionactivos';
		public $timestamps = false;
	}
