<?php
	require(VENDOR_PATH.'autoload.php');
	use Illuminate\Database\Eloquent\Model;

	class TesobBancosCtas extends Model{
		protected $table = 'tesobancosctas';
		protected $primaryKey = 'cuenta';
		public $timestamps = false;
	}