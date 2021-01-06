<?php
	require(VENDOR_PATH.'autoload.php');
	use Illuminate\Database\Eloquent\Model;

	class ConceptosContablesDetalles extends Model{
		protected $table = 'conceptoscontables_det';
		protected $primaryKey = 'id_det';
		public $timestamps = false;
	}
?>