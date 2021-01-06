<?php
	/**
	 * Modelo de Tabla pptonotasbanppto
	 * Almacena datos de las notas bancarias con relación presupuesto
	 */
	require(VENDOR_PATH.'autoload.php');
	use Illuminate\Database\Eloquent\Model;

	class PptoNotasBanPpto extends Model{
		protected $table = 'pptonotasbanppto';
		protected $primaryKey = 'id';
		public $timestamps = false;
	}