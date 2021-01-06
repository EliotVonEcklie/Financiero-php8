<?php
require('vendor/autoload.php');
	use Illuminate\Database\Eloquent\Model;
	class Meses extends Model
	{
		protected $table = 'meses';
		protected $primaryKey = 'id';
		public $timestamps = false;
	}
?>