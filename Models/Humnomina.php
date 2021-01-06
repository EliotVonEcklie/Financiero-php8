<?php
	require('vendor/autoload.php');
	use Illuminate\Database\Eloquent\Model;
	class Humnomina extends Model
	{
		protected $table = 'humnomina';
		protected $primaryKey = 'id_nom';
		public $timestamps = false;
	}
?>