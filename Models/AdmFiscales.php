<?php
	require('vendor/autoload.php');
	use Illuminate\Database\Eloquent\Model;
	class AdmFiscales extends Model
	{
		protected $table = 'admfiscales';
		protected $primaryKey = 'id';
		public $timestamps = false;
	}
?>