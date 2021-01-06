<?php
	require(VENDOR_PATH.'autoload.php');
	use Illuminate\Database\Eloquent\Model;
	
	class TesoRetenciones extends Model
	{
		protected $table = 'tesoretenciones';
		public $timestamps = false;
	}