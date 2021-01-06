<?php
	require('vendor/autoload.php');
    use Illuminate\Database\Eloquent\Model;
    
	class Tesopagotercerosvigant extends Model
	{
        protected $table = 'tesopagotercerosvigant';
        protected $primaryKey = 'id_pago';
		public $timestamps = false;
	}
?>