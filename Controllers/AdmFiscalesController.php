<?php
	require_once ('/../Models/AdmFiscales.php');
	require_once ('/../conexion.php');
	class AdmFiscalesController
	{
		public $tadmfiscales;
		public function __construct(){}
		public function AdmFiscalesAll($vigencia='')
		{
			$this->tadmfiscales = AdmFiscales::where('vigencia', $vigencia)->get();
		}
		
	}
?>