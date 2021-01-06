<?php
	/**
	 * Modelo de Tabla tesonotasbancarias_det
	 * Almacena datos detalles de la notas bancarias
	 */
	require(VENDOR_PATH.'autoload.php');
	use Illuminate\Database\Eloquent\Model;

	class TesoNotasBancariasDet extends Model{
		protected $table = 'tesonotasbancarias_det';
		protected $primaryKey = 'id_notabandet';
		public $timestamps = false;
	}