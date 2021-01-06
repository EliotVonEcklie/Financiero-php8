<?php
	require('vendor/autoload.php');
	use Illuminate\Database\Eloquent\Model;
	class Humvariables extends Model
	{
		protected $table = 'humvariables';
		protected $primaryKey = 'id';
		public $timestamps = false;
	}
?>