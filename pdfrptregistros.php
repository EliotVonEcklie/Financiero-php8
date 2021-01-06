<?php
//V 1000 12/12/16 
require('fpdf.php');
require('comun.inc');
require"funciones.inc";
session_start();
	
date_default_timezone_set("America/Bogota");
class PDF extends FPDF{
	function Header(){//Cabecera de página************************************************************
	  	$linkbd=conectar_bd();	
		$sqlr="select *from configbasica where estado='S'";
		$res=mysql_query($sqlr,$linkbd);
		while($row=mysql_fetch_row($res)){
		  $nit=$row[0];
		  $rs=$row[1];
	 	}
		$detalles='Reporte de Auxiliar de Registros del '.$_POST[fechaini].' al '.$_POST[fechafin];
		
		//Parte Izquierda
		$this->Image('imagenes/eng.jpg',23,10,25,25);
		$this->SetFont('Arial','B',10);
		$this->SetY(10);
		$this->RoundedRect(10, 10, 199, 31, 1,'' );
		$this->Cell(0.1);
		$this->Cell(50,31,'','R',0,'L'); 
		$this->SetY(31);
		$this->Cell(0.1);
		$this->Cell(50,5,''.$rs,0,0,'C'); 
		$this->SetFont('Arial','B',8);
		$this->SetY(35);
		$this->Cell(0.1);
		$this->Cell(50,5,''.$nit,0,0,'C'); //Cuadro Izquierda
		//*****************************************************************************************************************************
		$this->SetFont('Arial','B',14);
		$this->SetY(10);
		$this->Cell(50.1);
		$this->Cell(149,31,'',0,1,'C'); 
		$this->SetY(8);
		$this->Cell(50.1);
		$this->Cell(149,20,'AUXILIAR DE REGISTROS',0,0,'C'); 
//************************************
		$this->SetFont('Arial','I',10);
		$this->SetY(27);
		$this->Cell(50.2);
		$this->multiCell(149,5,''.strtoupper($detalles),'T','L');
		$this->SetFont('Arial','B',10);
		$this->MultiCell(105.7,4,'',0,'L');		
		$this->SetFont('times','B',10);
		$this->ln(12);

	//ENCABEZADO DEL DETALLE
	
		$this->line(10,42,209,42);
		$this->RoundedRect(10,43, 199, 5, 1,'' );
		$this->line(10,49,209,49);
	
		$this->SetFont('Arial','B',10);
		$this->SetY(43.5);
		$this->Cell(1);
		$this->Cell(10,5,'TIPO COMPROBANTE',0,1,'L'); 
		$this->SetY(43.5);
		$this->Cell(40.1);
		$this->Cell(24,5,'No.',0,1,'C');
		$this->SetY(43.5);
		$this->Cell(60.1);
		$this->Cell(24,5,'FECHA',0,1,'C');
		$this->SetY(43.5);
		$this->Cell(80.1);
		$this->Cell(24,5,'VIGENCIA',0,1,'C');
		$this->SetY(43.5);
		$this->Cell(120.1);
		$this->Cell(24,5,'CONCEPTO',0,1,'C');
		$this->SetY(43.5);
		$this->Cell(170.1);
		$this->Cell(24,5,'VALOR',0,1,'C');
		$this->Ln(2);
	}

	function Footer(){
		$this->SetY(-15);
		$this->SetFont('Arial','I',8);
		$this->Cell(0,10,'Impreso por: Software SPID - G&C Tecnoinversiones SAS. - Pagina '.$this->PageNo().' de 1',0,0,'R');  	
	}

//MULTICOLUMNA
	var $widths;
	var $aligns;

	function SetWidths($w){
		//Set the array of column widths
		$this->widths=$w;
	}

	function SetAligns($a){
		//Set the array of column alignments
		$this->aligns=$a;
	}

	function fill($f){
		//juego de arreglos de relleno
		$this->fill=$f;
	}

	function Row($data, $item){
		//Calculate the height of the row
		$nb=0;
		for($i=0;$i<count($data);$i++)
			$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
		$h=5*$nb;
		//Issue a page break first if needed
		$this->CheckPageBreak($h);
		//Draw the cells of the row
		for($i=0;$i<count($data);$i++){
			$w=$this->widths[$i];
			$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
			//Save the current position
			$x=$this->GetX();
			$y=$this->GetY();
			//Draw the border
			//$this->Rect($x,$y,'0',$h,$style);
			//Print the text
			if ($item%2==0){
				$this->SetFillColor(245,245,245);
				$this->MultiCell($w,5,$data[$i],'0',$a,1);
			}
			else{
				$this->SetFillColor(255,255,255);
				$this->MultiCell($w,5,$data[$i],'0',$a);
			}
			//Put the position to the right of the cell
			$this->SetXY($x+$w,$y);
			//$this->Rect($x+$w,$y,'0',$h,$style);
		}
		//Go to the next line
		$this->Ln($h);
	}

	function CheckPageBreak($h){
		//If the height h would cause an overflow, add a new page immediately
		if($this->GetY()+$h>$this->PageBreakTrigger)
			$this->AddPage($this->CurOrientation);
		}

	function NbLines($w,$txt){
		//Computes the number of lines a MultiCell of width w will take
		$cw=&$this->CurrentFont['cw'];
		if($w==0)
			$w=$this->w-$this->rMargin-$this->x;
		$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
		$s=str_replace("\r",'',$txt);
		$nb=strlen($s);
		if($nb>0 and $s[$nb-1]=="\n")
			$nb–;
		$sep=-1;
		$i=0;
		$j=0;
		$l=0;
		$nl=1;
		while($i<$nb){
			$c=$s[$i];
			if($c=="\n"){
				$i++;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
				continue;
			}
			if($c=='')
				$sep=$i;
			$l+=$cw[$c];
			if($l>$wmax){
				if($sep==-1){
					if($i==$j)
						$i++;
				}
				else
					$i=$sep+1;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
			}
			else
				$i++;
		}
		return $nl;
	}
	//FIN MULTICOLUMNA
}
	$linkbd=conectar_bd();	
	//Creación del objeto de la clase heredada
	$pdf=new PDF('P','mm','Letter'); 
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Times','',10);
	$pdf->SetAutoPageBreak(true,20);
	$pdf->SetFont('Arial','B',12);


	//MULTICOLUMNAS CONCEPTOS
	$pdf->SetWidths(array(1,46,15,25,15,65,30));
	$pdf->SetAligns(array('L','L','L','L','L','L','R'));

	$pdf->SetFont('Times','',10);
	if($_POST[estado]!="-1")
		$crit1=" AND estado='$_POST[estado]'";
	$sqlr="SELECT pptocomprobante_cab.tipo_comp, pptocomprobante_cab.numerotipo, pptocomprobante_cab.fecha, pptocomprobante_cab.concepto, pptocomprobante_cab.vigencia, pptotipo_comprobante.nombre FROM pptocomprobante_cab INNER JOIN pptotipo_comprobante ON pptocomprobante_cab.tipo_comp=pptotipo_comprobante.id_tipo WHERE pptotipo_comprobante.id_tipo='7'".$crit1." AND pptocomprobante_cab.fecha BETWEEN '$_POST[fechaini]' AND '$_POST[fechafin]' ORDER BY pptocomprobante_cab.fecha, pptocomprobante_cab.numerotipo";
	$resp = mysql_query($sqlr,$linkbd);
	$cont=1;
	while ($row =mysql_fetch_row($resp)){
		$sqld="SELECT SUM(valdebito) FROM pptocomprobante_det WHERE vigencia='$row[4]' AND tipo_comp='$row[0]' AND numerotipo='$row[1]'";
		$resd=mysql_query($sqld, $linkbd);
		$rowd =mysql_fetch_row($resd);
		
		$pdf->Row(array('',$row[0].' - '.$row[5],$row[1],$row[2],$row[4],$row[3],'$'.number_format($rowd[0],2)),$cont);
		$cont=$cont+1;
	}
		
	$pdf->Output();
?>