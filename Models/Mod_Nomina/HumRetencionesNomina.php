<?php
	require(VENDOR_PATH.'autoload.php');
	use Illuminate\Database\Eloquent\Model;
	class HumRetencionesNomina extends Model
	{
		protected $table = 'hum_retencionesfun';
		protected $primaryKey = 'id';
		public $timestamps = false;
	}
?>