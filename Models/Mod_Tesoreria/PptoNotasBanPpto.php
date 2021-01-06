<?php
	require(VENDOR_PATH.'autoload.php');
	use Illuminate\Database\Eloquent\Model;
	
	class PptoNotasBanPpto extends Model
	{
		protected $table = 'pptonotasbanppto';
		public $timestamps = false;
	}