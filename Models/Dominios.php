<?php
	/**
	 * Modelo de Tabla dominios
	 * Almacena datos de la relacion de los registros de dominios
	 */
	require(VENDOR_PATH.'autoload.php');
	use Illuminate\Database\Eloquent\Model;

	class Dominios extends Model{
		protected $table = 'dominios';
		protected $primaryKey = null;
		public $timestamps = false;
	}