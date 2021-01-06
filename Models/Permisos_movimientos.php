<?php
	require('vendor/autoload.php');
	use Illuminate\Database\Eloquent\Model;
	class Permisos_movimientos extends Model
	{
		protected $table = 'permisos_movimientos';
		protected $primaryKey = 'codigo';
		public $timestamps = false;
	}
?>