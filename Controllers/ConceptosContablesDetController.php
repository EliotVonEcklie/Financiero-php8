<?php  
    
    require_once '/../Models/ConceptosContablesDetalles.php';
    require_once '/../conexion.php';
    
	class ConceptosContablesDetController
    {
        public $cuentaContable;

        public function generarCuentaContable($codigo, $tipo, $cc, $modulo, $fechaInicial)
        {
            $condiciones = ['codigo' => $codigo, 'tipo' => $tipo, 'cc' => $cc, 'modulo' => $modulo];
            $this->cuentaContable = ConceptosContablesDetalles::where($condiciones)->where('fechainicial', '<=', $fechaInicial)->orderBy('fechainicial','DESC')->first();
        }
    }
    