<?php
	require(VENDOR_PATH.'autoload.php');
	use Illuminate\Database\Eloquent\Model;
	
	class TesoRetencionesDet extends Model
	{
		protected $table = 'tesoretenciones_det';
		public $timestamps = false;
	}