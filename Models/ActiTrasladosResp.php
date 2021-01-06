<?php
	/**
	 * Modelo de Tabla actitraslados_resp
	 * Almacena datos de la relacion de los traslados de los activos entre Funcionarios-Terceros
	 */
	require(VENDOR_PATH.'autoload.php');
	use Illuminate\Database\Eloquent\Model;

	class ActiTrasladosResp extends Model{
		protected $table = 'actitraslados_resp';
		public $timestamps = false;
	}
