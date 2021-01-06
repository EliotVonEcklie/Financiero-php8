<?php
	require('vendor/autoload.php');
	use Illuminate\Database\Eloquent\Model;
	class Humvariablesdetalles extends Model
	{
		protected $table = 'humvariables_det';
		protected $primaryKey = 'id_det';
		public $timestamps = false;
	}
?>