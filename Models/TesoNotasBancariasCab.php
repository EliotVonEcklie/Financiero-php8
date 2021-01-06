<?php
	/**
	 * Modelo de Tabla tesonotasbancarias_cab
	 * Almacena datos de cabecera de la notas bancarias
	 */
	require(VENDOR_PATH.'autoload.php');
	use Illuminate\Database\Eloquent\Model;

	class TesoNotasBancariasCab extends Model{
		protected $table = 'tesonotasbancarias_cab';
		protected $primaryKey = 'id_comp';
		public $timestamps = false;
	}
