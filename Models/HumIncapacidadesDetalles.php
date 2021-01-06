<?php
	require('vendor/autoload.php');
	use Illuminate\Database\Eloquent\Model;
	
	class HumIncapacidadesDetalles extends Model
	{
		protected $table = 'hum_incapacidades_det';
		protected $primaryKey = 'id_det';
		public $timestamps = false;
	}