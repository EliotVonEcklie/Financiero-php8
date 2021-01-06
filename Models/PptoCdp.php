<?php
	/**
	 * Modelo de Tabla pptocdp
	 * Almacena datos de los CDP
	 */
	require(VENDOR_PATH.'autoload.php');
	use Illuminate\Database\Eloquent\Model;

	class PptoCdp extends Model{
		protected $table = 'pptocdp';
		protected $primaryKey = 'id_cdp';
		public $timestamps = false;
	}
?>
