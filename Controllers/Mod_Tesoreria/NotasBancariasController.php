<?php
include_once ($_SERVER['DOCUMENT_ROOT'].'/financiero/dirs.php');
require_once (MODELS_PATH.'TesoNotasBancariasCab.php');
require_once (MODELS_PATH.'PptoNotasBanPpto.php');
require_once (MODELS_PATH.'TesoGastosBancarios.php');
require_once (MODELS_PATH.'ComprobanteDet.php');
require_once (ROOT_PATH.'conexion.php');
require_once "/../../teso-funciones.php";
class NotasBancariasController
{
    private $NotaBancaria = 0;
    public function __construct()
    {
        $this->NotaBancaria = $this->generarConsecutivo() + 1;
    }
    public function generarConsecutivo()
    {
        return TesoNotasBancariasCab::max('id_comp');
    }

    public function generarConsecutivoMin($notaBancaria)
    {
        return TesoNotasBancariasCab::min('id_comp');
    }

    public function buscarNotaBancaria($notaBancaria)
    {
        $condiciones = ['id_comp' => $notaBancaria];
        return TesoNotasBancariasCab::where($condiciones)->get();
    }
    
    
    public function guardarNotaBancaria($data)
    {
        $fechaListaParaGuardar = cambiarFormatoFecha($data['fecha']);
        $arrayFecha = explode("-",$fechaListaParaGuardar);
        
        $guardaNotasBancarias = new TesoNotasBancariasCab();
        $guardaNotasBancarias -> id_comp = $data['numeroNota'];
        $guardaNotasBancarias -> fecha = $fechaListaParaGuardar;
        $guardaNotasBancarias -> vigencia = $arrayFecha[0];
        $guardaNotasBancarias -> estado = 'S';
        $guardaNotasBancarias -> concepto = $data['concepto'];
        $guardaNotasBancarias -> tipo_mov = $data['tipoMovimiento'];
        $guardaNotasBancarias -> user = $data['nickusu'];
        $res = $guardaNotasBancarias -> save();

        $guardaNotasBancariasContaCab = new ComprobanteCab();
        $guardaNotasBancariasContaCab -> numerotipo = $data['numeroNota'];
        $guardaNotasBancariasContaCab -> tipo_comp = '9';
        $guardaNotasBancariasContaCab -> fecha = $fechaListaParaGuardar;
        $guardaNotasBancariasContaCab -> concepto = $data['concepto'];
        $guardaNotasBancariasContaCab -> estado = '1';
        $guardaNotasBancariasContaCab -> save();

        $cantDetalleGen = count($data['detalle']);
        
        for($j = 0; $j<$cantDetalleGen; $j++)
        {
            $gastoBancarioCodigo = 0;
            $arrayGastosBancarios = explode("-",$data['detalle'][$j][4]);
            $gastoBancarioCodigo = $this->ceroIzquierda($arrayGastosBancarios[1]);

            $guardaNotasBancariasDet = new TesoNotasBancariasDet();
            $guardaNotasBancariasDet -> id_notabancab = $data['numeroNota'];
            $guardaNotasBancariasDet -> docban = $data['detalle'][$j][2];
            $guardaNotasBancariasDet -> cc = $data['detalle'][$j][1];
            $guardaNotasBancariasDet -> ncuentaban = $data['detalle'][$j][3];
            $guardaNotasBancariasDet -> tercero = $data['terceroBanco'];
            $guardaNotasBancariasDet -> gastoban = $gastoBancarioCodigo;
            $guardaNotasBancariasDet -> valor = $data['detalle'][$j][5];
            $guardaNotasBancariasDet -> estado = 'S';
            $guardaNotasBancariasDet -> tipo_mov = $data['tipoMovimiento'];
            $guardaNotasBancariasDet -> save();

            $cuentaPresupuestal = buscaCuentaPresupuestalNotaBanco($gastoBancarioCodigo,$arrayFecha[0]);
            $cuentaConceptoGastoBancario = buscaCuentaContable($cuentaPresupuestal['concepto'],'GB',$data['detalle'][$j][1],4,$fechaListaParaGuardar);
            if($cuentaConceptoGastoBancario["cuenta"] == '')
			{
				$cuentaConceptoGastoBancario["cuenta"]='';
			}
      
            if($arrayGastosBancarios[0]=='G')
            {
                $guardaNotasBancariasContaDet = new ComprobanteDet();
                $guardaNotasBancariasContaDet -> id_comp = '9 '.$data['numeroNota'];
                $guardaNotasBancariasContaDet -> cuenta = $cuentaConceptoGastoBancario["cuenta"];
                $guardaNotasBancariasContaDet -> tercero = $data['terceroBanco'];
                $guardaNotasBancariasContaDet -> centrocosto = $data['detalle'][$j][1];
                $guardaNotasBancariasContaDet -> detalle = 'Nota bancaria '.$data['detalle'][$j][2];
                $guardaNotasBancariasContaDet -> valdebito = $data['detalle'][$j][5];
                $guardaNotasBancariasContaDet -> valcredito = 0;
                $guardaNotasBancariasContaDet -> estado = 'S';
                $guardaNotasBancariasContaDet -> vigencia = $arrayFecha[0];
                $guardaNotasBancariasContaDet -> tipo_comp = '9';
                $guardaNotasBancariasContaDet -> numerotipo = $data['numeroNota'];
                $guardaNotasBancariasContaDet -> save();

                $guardaNotasBancariasContaDet = new ComprobanteDet();
                $guardaNotasBancariasContaDet -> id_comp = '9 '.$data['numeroNota'];
                $guardaNotasBancariasContaDet -> cuenta = $data['cuentaContable'];
                $guardaNotasBancariasContaDet -> tercero = $data['terceroBanco'];
                $guardaNotasBancariasContaDet -> centrocosto = $data['detalle'][$j][1];
                $guardaNotasBancariasContaDet -> detalle = 'Nota bancaria '.$data['detalle'][$j][2];
                $guardaNotasBancariasContaDet -> valdebito =0;
                $guardaNotasBancariasContaDet -> valcredito =  $data['detalle'][$j][5];
                $guardaNotasBancariasContaDet -> estado = 'S';
                $guardaNotasBancariasContaDet -> vigencia = $arrayFecha[0];
                $guardaNotasBancariasContaDet -> tipo_comp = '9';
                $guardaNotasBancariasContaDet -> numerotipo = $data['numeroNota'];
                $guardaNotasBancariasContaDet -> save();
            }
            else
            {
                $guardaNotasBancariasContaDet = new ComprobanteDet();
                $guardaNotasBancariasContaDet -> id_comp = '9 '.$data['numeroNota'];
                $guardaNotasBancariasContaDet -> cuenta = $cuentaConceptoGastoBancario["cuenta"];
                $guardaNotasBancariasContaDet -> tercero = $data['terceroBanco'];
                $guardaNotasBancariasContaDet -> centrocosto = $data['detalle'][$j][1];
                $guardaNotasBancariasContaDet -> detalle = 'Nota bancaria '.$data['detalle'][$j][2];
                $guardaNotasBancariasContaDet -> valdebito = 0;
                $guardaNotasBancariasContaDet -> valcredito = $data['detalle'][$j][5];
                $guardaNotasBancariasContaDet -> estado = 'S';
                $guardaNotasBancariasContaDet -> vigencia = $arrayFecha[0];
                $guardaNotasBancariasContaDet -> tipo_comp = '9';
                $guardaNotasBancariasContaDet -> numerotipo = $data['numeroNota'];
                $guardaNotasBancariasContaDet -> save();

                $guardaNotasBancariasContaDet = new ComprobanteDet();
                $guardaNotasBancariasContaDet -> id_comp = '9 '.$data['numeroNota'];
                $guardaNotasBancariasContaDet -> cuenta = $data['cuentaContable'];
                $guardaNotasBancariasContaDet -> tercero = $data['terceroBanco'];
                $guardaNotasBancariasContaDet -> centrocosto = $data['detalle'][$j][1];
                $guardaNotasBancariasContaDet -> detalle = 'Nota bancaria '.$data['detalle'][$j][2];
                $guardaNotasBancariasContaDet -> valdebito = $data['detalle'][$j][5];
                $guardaNotasBancariasContaDet -> valcredito =  0;
                $guardaNotasBancariasContaDet -> estado = 'S';
                $guardaNotasBancariasContaDet -> vigencia = $arrayFecha[0];
                $guardaNotasBancariasContaDet -> tipo_comp = '9';
                $guardaNotasBancariasContaDet -> numerotipo = $data['numeroNota'];
                $guardaNotasBancariasContaDet -> save();

                if($cuentaPresupuestal["cuentapres"]!='')
                {
                    $guardaCuentaGastoBanco = new PptoNotasBanPpto();
                    $guardaCuentaGastoBanco -> cuenta = $cuentaPresupuestal["cuentapres"];
                    $guardaCuentaGastoBanco -> idrecibo = $data['numeroNota'];
                    $guardaCuentaGastoBanco -> valor = $data['detalle'][$j][5];
                    $guardaCuentaGastoBanco -> vigencia = $arrayFecha[0];
                    $guardaCuentaGastoBanco -> save();
                }
            }
        }
        
        return $res;
    }
	
	public function editarNotaBancaria($data)
    {
        $fechaListaParaGuardar = cambiarFormatoFecha($data['fecha']);
        $arrayFecha = explode("-",$fechaListaParaGuardar);
        
		// Conseguimos el objeto
		$notaBancaria = TesoNotasBancariasCab::find($data['numeroNota']);
		 
		// Si existe
		if(count($notaBancaria)>=1)
		{
			// Seteamos un nuevo titulo
			$notaBancaria -> fecha = $fechaListaParaGuardar;
			$notaBancaria -> vigencia = $arrayFecha[0];
			$notaBancaria -> estado = 'S';
			$notaBancaria -> concepto = $data['concepto'];
			$notaBancaria -> tipo_mov = $data['tipoMovimiento'];
			$notaBancaria -> user = $data['nickusu'];
			$res = $notaBancaria -> save();
		}
		
		$condiciones=[
				'tipo_comp' => 9,
				'numerotipo' => $data['numeroNota']
			];
		
		ComprobanteDet::where($condiciones)->delete();
		$notaBancariaContCab = ComprobanteCab::where($condiciones)->get()->first();
		
		if(count($notaBancariaContCab)>=1)
		{
			$notaBancariaContCab -> fecha = $fechaListaParaGuardar;
			$notaBancariaContCab -> concepto = $data['concepto'];
			$notaBancariaContCab -> estado = '1';
			$notaBancariaContCab -> save();
		}
		else
		{
			$guardaNotasBancariasContaCab = new ComprobanteCab();
			$guardaNotasBancariasContaCab -> numerotipo = $data['numeroNota'];
			$guardaNotasBancariasContaCab -> tipo_comp = '9';
			$guardaNotasBancariasContaCab -> fecha = $fechaListaParaGuardar;
			$guardaNotasBancariasContaCab -> concepto = $data['concepto'];
			$guardaNotasBancariasContaCab -> estado = '1';
			$guardaNotasBancariasContaCab -> save();
		}
		
		$condiciones=[
				'id_notabancab' => $data['numeroNota']
			];
			
		TesoNotasBancariasDet::where($condiciones)->delete();
		
		$condiciones=[
				'idrecibo' => $data['numeroNota']
			];
		PptoNotasBanPpto::where($condiciones)->delete();
		
		
        $cantDetalleGen = count($data['detalle']);
        
        for($j = 0; $j<$cantDetalleGen; $j++)
        {
            $gastoBancarioCodigo = 0;
            $arrayGastosBancarios = explode("-",$data['detalle'][$j][4]);
			$encuentraGuion = strpos($data['detalle'][$j][4], "-");
			if($encuentraGuion === false)
			{
				$arrayGastosBancarios[0] = $this->buscarTipoGastoBancario($data['detalle'][$j][4]);
				$arrayGastosBancarios[1] = $data['detalle'][$j][4];
			}
            $gastoBancarioCodigo = $this->ceroIzquierda($arrayGastosBancarios[1]);

            $guardaNotasBancariasDet = new TesoNotasBancariasDet();
            $guardaNotasBancariasDet -> id_notabancab = $data['numeroNota'];
            $guardaNotasBancariasDet -> docban = $data['detalle'][$j][2];
            $guardaNotasBancariasDet -> cc = $data['detalle'][$j][1];
            $guardaNotasBancariasDet -> ncuentaban = $data['detalle'][$j][3];
            $guardaNotasBancariasDet -> tercero = $data['terceroBanco'];
            $guardaNotasBancariasDet -> gastoban = $gastoBancarioCodigo;
            $guardaNotasBancariasDet -> valor = $data['detalle'][$j][5];
            $guardaNotasBancariasDet -> estado = 'S';
            $guardaNotasBancariasDet -> tipo_mov = $data['tipoMovimiento'];
            $guardaNotasBancariasDet -> save();
			
			print($gastoBancarioCodigo);
            $cuentaPresupuestal = buscaCuentaPresupuestalNotaBanco($gastoBancarioCodigo,$arrayFecha[0]);
            $cuentaConceptoGastoBancario = buscaCuentaContable($cuentaPresupuestal['concepto'],'GB',$data['detalle'][$j][1],4,$fechaListaParaGuardar);
            if($cuentaConceptoGastoBancario["cuenta"] == '')
			{
				$cuentaConceptoGastoBancario["cuenta"]='';
			}	
            if($arrayGastosBancarios[0]=='G')
            {
                $guardaNotasBancariasContaDet = new ComprobanteDet();
                $guardaNotasBancariasContaDet -> id_comp = '9 '.$data['numeroNota'];
                $guardaNotasBancariasContaDet -> cuenta = $cuentaConceptoGastoBancario["cuenta"];
                $guardaNotasBancariasContaDet -> tercero = $data['terceroBanco'];
                $guardaNotasBancariasContaDet -> centrocosto = $data['detalle'][$j][1];
                $guardaNotasBancariasContaDet -> detalle = 'Nota bancaria '.$data['detalle'][$j][2];
                $guardaNotasBancariasContaDet -> valdebito = $data['detalle'][$j][5];
                $guardaNotasBancariasContaDet -> valcredito = 0;
                $guardaNotasBancariasContaDet -> estado = 'S';
                $guardaNotasBancariasContaDet -> vigencia = $arrayFecha[0];
                $guardaNotasBancariasContaDet -> tipo_comp = '9';
                $guardaNotasBancariasContaDet -> numerotipo = $data['numeroNota'];
                $guardaNotasBancariasContaDet -> save();

                $guardaNotasBancariasContaDet = new ComprobanteDet();
                $guardaNotasBancariasContaDet -> id_comp = '9 '.$data['numeroNota'];
                $guardaNotasBancariasContaDet -> cuenta = $data['cuentaContable'];
                $guardaNotasBancariasContaDet -> tercero = $data['terceroBanco'];
                $guardaNotasBancariasContaDet -> centrocosto = $data['detalle'][$j][1];
                $guardaNotasBancariasContaDet -> detalle = 'Nota bancaria '.$data['detalle'][$j][2];
                $guardaNotasBancariasContaDet -> valdebito =0;
                $guardaNotasBancariasContaDet -> valcredito =  $data['detalle'][$j][5];
                $guardaNotasBancariasContaDet -> estado = 'S';
                $guardaNotasBancariasContaDet -> vigencia = $arrayFecha[0];
                $guardaNotasBancariasContaDet -> tipo_comp = '9';
                $guardaNotasBancariasContaDet -> numerotipo = $data['numeroNota'];
                $guardaNotasBancariasContaDet -> save();
            }
            else
            {
                $guardaNotasBancariasContaDet = new ComprobanteDet();
                $guardaNotasBancariasContaDet -> id_comp = '9 '.$data['numeroNota'];
                $guardaNotasBancariasContaDet -> cuenta = $cuentaConceptoGastoBancario["cuenta"];
                $guardaNotasBancariasContaDet -> tercero = $data['terceroBanco'];
                $guardaNotasBancariasContaDet -> centrocosto = $data['detalle'][$j][1];
                $guardaNotasBancariasContaDet -> detalle = 'Nota bancaria '.$data['detalle'][$j][2];
                $guardaNotasBancariasContaDet -> valdebito = 0;
                $guardaNotasBancariasContaDet -> valcredito = $data['detalle'][$j][5];
                $guardaNotasBancariasContaDet -> estado = 'S';
                $guardaNotasBancariasContaDet -> vigencia = $arrayFecha[0];
                $guardaNotasBancariasContaDet -> tipo_comp = '9';
                $guardaNotasBancariasContaDet -> numerotipo = $data['numeroNota'];
                $guardaNotasBancariasContaDet -> save();

                $guardaNotasBancariasContaDet = new ComprobanteDet();
                $guardaNotasBancariasContaDet -> id_comp = '9 '.$data['numeroNota'];
                $guardaNotasBancariasContaDet -> cuenta = $data['cuentaContable'];
                $guardaNotasBancariasContaDet -> tercero = $data['terceroBanco'];
                $guardaNotasBancariasContaDet -> centrocosto = $data['detalle'][$j][1];
                $guardaNotasBancariasContaDet -> detalle = 'Nota bancaria '.$data['detalle'][$j][2];
                $guardaNotasBancariasContaDet -> valdebito = $data['detalle'][$j][5];
                $guardaNotasBancariasContaDet -> valcredito =  0;
                $guardaNotasBancariasContaDet -> estado = 'S';
                $guardaNotasBancariasContaDet -> vigencia = $arrayFecha[0];
                $guardaNotasBancariasContaDet -> tipo_comp = '9';
                $guardaNotasBancariasContaDet -> numerotipo = $data['numeroNota'];
                $guardaNotasBancariasContaDet -> save();

                if($cuentaPresupuestal["cuentapres"]!='')
                {
                    $guardaCuentaGastoBanco = new PptoNotasBanPpto();
                    $guardaCuentaGastoBanco -> cuenta = $cuentaPresupuestal["cuentapres"];
                    $guardaCuentaGastoBanco -> idrecibo = $data['numeroNota'];
                    $guardaCuentaGastoBanco -> valor = $data['detalle'][$j][5];
                    $guardaCuentaGastoBanco -> vigencia = $arrayFecha[0];
                    $guardaCuentaGastoBanco -> save();
                }
            }
        }
        
        return $res;
    }
	public function buscarTipoGastoBancario($codigo)
	{
		$gastoBancarioTipo = TesoGastosBancarios::find($codigo);
		return $gastoBancarioTipo['tipo'];
	}
    public function ceroIzquierda($numero)
    {
        if($numero < 10 && strlen($numero)==1)
        {
            $numero = '0'.$numero;
        }
        return $numero;
    }
    public function getNotaBancaria()
    {
        return $this->NotaBancaria;
    }
}