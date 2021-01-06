<?php
	require('vendor/autoload.php');
	use Illuminate\Database\Eloquent\Model;
	
	class HumIncapacidades extends Model
	{
		protected $table = 'hum_incapacidades';
		protected $primaryKey = 'num_inca';
		public $timestamps = false;
	}