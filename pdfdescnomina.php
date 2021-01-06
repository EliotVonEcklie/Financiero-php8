<?php
//V 1000 12/12/16 
require('fpdf.php');
require('comun.inc');
require"funciones.inc";
session_start();
	
$sqlrjn="SELECT nombrejnomina FROM humparametrosnomina WHERE estado='S'";
$rowjn =mysql_fetch_row(mysql_query($sqlrjn,$linkbd));
$jnomina=ucwords(strtolower($rowjn[0]));
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
		$detalles='Relación Descuentos de Nómina periodo laborado '.$_POST[pdfmes].' del '.$_POST[pdfvigen];
		
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
		$this->Cell(149,20,'DESCUENTOS DE NOMINA',0,0,'C'); 
//************************************
		$this->SetFont('Arial','I',10);
		$this->SetY(27);
		$this->Cell(50.2);
		$this->multiCell(110.7,5,''.strtoupper($detalles),'T','L');
		$this->SetFont('Arial','B',10);
		$this->SetY(27);
		$this->Cell(161.1);
		$this->Cell(37.8,14,'','TL',0,'L');
		$this->SetY(27);
		$this->Cell(162);
		$this->Cell(35,5,'NUMERO : '.$_POST[pdfidnom],0,0,'L');
		$this->SetY(31);
		$this->Cell(162);
		$this->Cell(35,5,'MES: '.$_POST[pdfmes],0,0,'L');
		$this->SetY(35);
		$this->Cell(162);
		$this->Cell(35,5,'VIGENCIA: '.$_POST[pdfvigen],0,0,'L');
		$this->SetY(27);
		$this->Cell(50.2);
		$this->MultiCell(105.7,4,'',0,'L');		
		$this->SetFont('times','B',10);
		$this->ln(12);
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
	$nresul=buscatercero($_POST[pdftercero]);
	$pdf=new PDF('P','mm','Letter'); 
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Times','',10);
	$pdf->SetAutoPageBreak(true,20);
	$pdf->SetFont('Arial','B',12);

	$pdf->SetY(41);   
	$pdf->cell(125);
	$pdf->cell(27,8,'TOTAL A PAGAR: ',0,0,'R');
	$pdf->RoundedRect(161, 42 ,48, 6, 1,'');
	$pdf->cell(45,8,'$'.number_format($_POST[pdftotalpago],2),0,0,'R',0);
	$pdf->ln(10);
	
	$pdf->SetFillColor(255,255,255);
	$pdf->cell(0.2);
	$pdf->SetFont('Arial','B',10);
	$pdf->cell(35,5,'Beneficiario: ',0,0,'L',1);
	$pdf->SetFont('Arial','',10);
	$pdf->cell(80,5,''.substr(ucwords(strtolower($nresul)),0,100),0,0,'L',1);
	$pdf->cell(0.2); 

	$pdf->SetFont('Arial','B',10);
	$pdf->cell(35,5,'C.C. o NIT: ',0,0,'L',1);
	$pdf->SetFont('Arial','',10);
	$pdf->cell(50,5,''.$_POST[pdftercero],0,1,'L',1);
	$pdf->SetFillColor(245,245,245);
	$pdf->cell(0.2);
	$pdf->SetFont('Arial','B',10);
	$pdf->cell(35,5,'Días Laborales: ',0,0,'L',1);
	$pdf->SetFont('Arial','',10);
	$pdf->cell(80,5,''.$_POST[pdfdiaslab],0,0,'L',1);
	$pdf->SetFont('Arial','B',10);
	$pdf->cell(35,5,'Salario Básico: ',0,0,'L',1);
	$pdf->SetFont('Arial','',10);
	$pdf->cell(49,5,'$ '.number_format($_POST[pdfsalbasico],2),0,1,'L',1);
	$pdf->cell(0.2); 
	$pdf->RoundedRect(10, 49 ,199 , 12, 1,'' );
	$pdf->ln(6);	
	
	$pdf->line(10,62,209,62);
	$pdf->RoundedRect(10,63, 199, 5, 1,'' );
	$pdf->line(10,69,209,69);

	$pdf->SetFont('Arial','B',10);
	$pdf->SetY(63.5);
    $pdf->Cell(11);
    $pdf->Cell(10,5,'CONCEPTO',0,1,'L'); 
	$pdf->SetY(63.5);
    $pdf->Cell(117.1);
    $pdf->Cell(24,5,'SALARIO',0,1,'C');
	$pdf->SetY(63.5);
    $pdf->Cell(170.1);
    $pdf->Cell(24,5,'DESCUENTOS',0,1,'C');

	//MULTICOLUMNAS CONCEPTOS
	$pdf->SetWidths(array(5,105,30,55));
	$pdf->SetAligns(array('L','L','R','R'));
	$fill1='245,245,245';
	$fill2='255,255,255';
	$pdf->fill(array(1, 0));

	$pdf->SetFont('Times','',10);
	$pdf->Ln(1);
	$suming=0;
	$sumegr=0;

	$pdf->Row(array('','Salario Básico','$'.number_format($_POST[pdfsalbasico],2),'$'.number_format(0,2)),0);
	$pdf->Row(array('','Salud','$'.number_format(0,2),'$'.number_format($_POST[pdfsalud],2)),5);
	$pdf->Row(array('','Pensión','$'.number_format(0,2),'$'.number_format($_POST[pdfpension],2)),6);
	$pdf->Row(array('','Fondo de Solidaridad','$'.number_format(0,2),'$'.number_format($_POST[pdffondos],2)),7);
	$pdf->Row(array('','Retención en la Fuente','$'.number_format(0,2),'$'.number_format($_POST[pdfrete],2)),8);
	$suming=$_POST[pdfdeveng]+$_POST[pdfauxali]+$_POST[pdfauxtran]+$_POST[pdfhorax];
	$sumegr=$_POST[pdfsalud]+$_POST[pdfpension]+$_POST[pdffondos]+$_POST[pdfrete];
	$sqlr="SELECT hp.descripcion,hp.ncta,hr.ncuotas,hr.valorcuota FROM humnominaretenemp hp, humretenempleados hr WHERE hp.id_nom='$_POST[pdfidnom]' AND hp.cedulanit='$_POST[pdftercero]' AND hr.id=hp.id ORDER BY hr.id";
	$resp = mysql_query($sqlr,$linkbd);
	$cont=1;
	$interv=4.5;
	while ($row =mysql_fetch_row($resp)){
		$sumegr+=$row[3];
		if ($cont%2==0){$pdf->SetFillColor(245,245,245);}
		else{$pdf->SetFillColor(255,255,255);}
		$pdf->Row(array('',ucwords(strtolower($row[0])).' '.$row[1].' de '.$row[2],'$'.number_format(0,2),'$'.number_format($row[3],2)),$cont);
		$cont=$cont+1;
		$interv=$interv+4.5;
	}
	$interv=$interv+4.5;
	$pdf->line(10,106+$interv,209,106+$interv);
	$pdf->Row(array('','','$'.number_format($suming,2),'$'.number_format($sumegr,2)),1);
	$pdf->line(10,127+$interv,110,127+$interv);
	$pdf->SetFont('Arial','I',8);
	$pdf->SetY(128+$interv);
	$pdf->Cell(0.2);
	$pdf->cell(100,5,'Elaborado por: '.$jnomina,0,0,'L',1);
		
	$pdf->Output();
?>