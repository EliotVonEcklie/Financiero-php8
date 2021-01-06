<?php
	require('vendor/autoload.php');
	use Illuminate\Database\Eloquent\Model;
	
	class Tipo_movdocumentos extends Model
	{
		protected $table = 'tipo_movdocumentos';
		public $timestamps = false;
	}