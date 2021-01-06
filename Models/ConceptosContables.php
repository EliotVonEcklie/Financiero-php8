<?php
	require('vendor/autoload.php');
	use Illuminate\Database\Eloquent\Model;
	class ConceptosContables extends Model
	{
		protected $table = 'conceptoscontables';
		protected $primaryKey = 'id';
		public $timestamps = false;
	}
?>