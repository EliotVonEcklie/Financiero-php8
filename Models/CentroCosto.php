<?php
	require(VENDOR_PATH.'autoload.php');
	use Illuminate\Database\Eloquent\Model;

	class CentroCosto extends Model
	{
		protected $table = 'centrocosto';
		protected $primaryKey = 'id';
		public $timestamps = false;
	}
