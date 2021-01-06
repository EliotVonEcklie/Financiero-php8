<?php
//V 1000 12/12/16 
require('fpdf.php');
require('comun.inc');
require"funciones.inc";
session_start();
class PDF extends FPDF{
	function Footer(){
		$linkbd=conectar_bd();
		$criterio="";
		$criterio2="";
		if($_POST[vigencias]!=""){$criterio=" AND hm.vigencia='$_POST[vigencias]' ";}
		if($_POST[mes]!=""){$criterio2=" AND hm.mes='$_POST[mes]' ";}
		$sqlrg="SELECT hm.id_nom FROM humnomina hm,humnomina_det ht WHERE hm.id_nom=ht.id_nom ".$criterio.$criterio2." AND hm.id_nom LIKE '%$_POST[nnomina]%' AND hm.estado <> 'N' ";
		$ntrg = (mysql_num_rows(mysql_query($sqlrg,$linkbd)))/2;
		$ntrgr=round($ntrg,0);
		$this->SetY(-15);
		$this->SetFont('Arial','I',8);
		$this->Cell(0,10,'Impreso por: Software SPID - G&C Tecnoinversiones SAS. - Pagina '.$this->PageNo().' de '.$ntrgr,0,0,'R'); 	
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
$sqlr="select *from configbasica where estado='S'";
//echo $sqlr;
$res=mysql_query($sqlr,$linkbd);
while($row=mysql_fetch_row($res)){
	$nit=$row[0];
	$rs=$row[1];
}
$pdf=new PDF('P','mm','Letter'); 
$pdf->AddPage(); 
	
$criterio="";
$criterio2="";	
$contmaes=0;
$intervmaes=2;
$sqlrjn="SELECT nombrejnomina FROM humparametrosnomina WHERE estado='S'";
$rowjn =mysql_fetch_row(mysql_query($sqlrjn,$linkbd));
$jnomina=ucwords(strtolower($rowjn[0]));

if($_POST[vigencias]!=""){$criterio=" AND hm.vigencia='$_POST[vigencias]' ";}
if($_POST[mes]!=""){$criterio2=" AND hm.mes='$_POST[mes]' ";}

$sqlrg="SELECT hm.id_nom,hm.mes,hm.vigencia,ht.netopagar,ht.diaslab,ht.devendias,ht.auxalim,ht.auxtran,ht.totaldeduc, ht.netopagar, ht.salbas,ht.valhorex,ht.salud,ht.pension,ht.fondosolid,ht.retefte,ht.cedulanit FROM humnomina hm,humnomina_det ht WHERE hm.id_nom=ht.id_nom ".$criterio.$criterio2." AND hm.id_nom LIKE '%$_POST[nnomina]%' AND hm.estado <> 'N' ORDER BY hm.id_nom DESC";
$respg = mysql_query($sqlrg,$linkbd);
while ($rowg =mysql_fetch_row($respg)){
	if ($intervmaes==0){$intervmaes=120+$interv;}
	else{$intervmaes=0;}
	$lastday = mktime (0,0,0,$rowg[1],1,$rowg[2]);
	$vmes=ucwords(strftime('%B',$lastday));	
	$nresult=buscatercero($rowg[16]);	
	/*$rs="Municipio de Cubarral";
	$nit="892000812-0";
	$nalca="RIVERA RINCON JAIRO ";*/
	$sqlp="SELECT * FROM humnomina_prima WHERE id_nom='$rowg[0]'";
	$rsp = mysql_query($sqlp,$linkbd);
	$filpri=mysql_num_rows($rsp);
	if($filpri>0){
		$detalles="Desprendible de Pago de Primas para el periodo laborado $vmes del $rowg[2]";
	}
	else{
		$detalles="Desprendible de nómina periodo laborado $vmes del $rowg[2]";
	}
		
	$pdf->Image('imagenes/eng.jpg',23,9+$intervmaes,25,25);
	$pdf->SetFont('Arial','B',10);
	$pdf->SetY(10+$intervmaes);
	$pdf->RoundedRect(10,10+$intervmaes,199, 28, 1,'' );
	$pdf->Cell(0.1);
	$pdf->Cell(50,28,'','R',0,'L'); 
	$pdf->SetY(30+$intervmaes);
	$pdf->Cell(0.1);
	$pdf->Cell(50,5,''.$rs,0,0,'C'); 
	$pdf->SetFont('Arial','B',8);
	$pdf->SetY(34+$intervmaes);
	$pdf->Cell(0.1);
	$pdf->Cell(50,5,''.$nit,0,0,'C'); //Cuadro Izquierda
	//*****************************************************************************************************************************
	$pdf->SetFont('Arial','B',14);
	$pdf->SetY(10+$intervmaes);
	$pdf->Cell(50.1);
	$pdf->Cell(149,29,'',0,1,'C'); 
	$pdf->SetY(8+$intervmaes);
	$pdf->Cell(50.1);
	$pdf->Cell(149,20,'LIQUIDACION DE NOMINA',0,0,'C'); 
//************************************
	$pdf->SetFont('Arial','I',10);
	$pdf->SetY(25+$intervmaes);
	$pdf->Cell(50.2);
	$pdf->multiCell(110.7,5,''.strtoupper($detalles),'T','L');
	$pdf->SetFont('Arial','B',10);
	$pdf->SetY(25+$intervmaes);
	$pdf->Cell(161.1);
	$pdf->Cell(37.8,13,'','TL',0,'L');
	$pdf->SetY(25+$intervmaes);
	$pdf->Cell(162);
	$pdf->Cell(35,5,"NUMERO : $rowg[0]",0,0,'L');
	$pdf->SetY(29+$intervmaes);
	$pdf->Cell(162);
	$pdf->Cell(35,5,"MES: $vmes",0,0,'L');
	$pdf->SetY(33+$intervmaes);
	$pdf->Cell(162);
	$pdf->Cell(35,5,"VIGENCIA: $rowg[2]",0,0,'L');
	$pdf->SetY(27+$intervmaes);
	$pdf->Cell(50.2);
	$pdf->MultiCell(105.7,4,'',0,'L');		
	$pdf->SetFont('times','B',10);
	$pdf->ln(12);
	
	$pdf->SetFont('Times','',10);
	$pdf->SetAutoPageBreak(true,20);
	$pdf->SetFont('Arial','B',12);
	
	$pdf->SetY(38+$intervmaes);   
	$pdf->cell(125);
	$pdf->cell(27,8,'TOTAL A PAGAR: ',0,0,'R');
	$pdf->RoundedRect(161, 39+$intervmaes ,48, 6, 1,'');
	$pdf->cell(45,8,'$'.number_format($rowg[3],2),0,0,'R',0);
	$pdf->ln(9);
		
	$pdf->SetFillColor(255,255,255);
	$pdf->cell(0.2);
	$pdf->SetFont('Arial','B',10);
	$pdf->cell(24,5,'Beneficiario: ',0,0,'L',1);
	$pdf->SetFont('Arial','',10);
	$pdf->cell(65,5,''.substr(ucwords(strtolower($nresult)),0,100),0,0,'L',1);
	$pdf->cell(0.2); 
	$pdf->SetFont('Arial','B',10);
	$pdf->cell(20,5,'C.C. o NIT: ',0,0,'L',1);
	$pdf->SetFont('Arial','',10);
	$pdf->cell(35,5,''.$rowg[16],0,0,'L',1);
	$pdf->SetFillColor(245,245,245);
	$pdf->cell(0.2);
	$pdf->SetFont('Arial','B',10);
	$pdf->cell(35,5,'Días Laborales: ',0,0,'L',0);
	$pdf->SetFont('Arial','',10);
	$pdf->cell(80,5,''.$rowg[4],0,1,'L',0);
	$pdf->cell(0.2); 
/*	$pdf->SetFont('Arial','B',10);
	$pdf->cell(35,5,'Salario Básico: ',0,0,'L',1);
	$pdf->SetFont('Arial','',10);
	$pdf->cell(49,5,'$'.number_format($rowg[10],2),0,1,'L',1);
	$pdf->cell(0.2); */
	$pdf->RoundedRect(10, 46+$intervmaes ,199 , 6, 1,'' );
	$pdf->ln(6);	
		
	$pdf->line(10,53+$intervmaes,209,53+$intervmaes);
	$pdf->RoundedRect(10,54+$intervmaes, 199, 5, 1,'' );
	$pdf->line(10,60+$intervmaes,209,60+$intervmaes);
	
	$pdf->SetFont('Arial','B',10);
	$pdf->SetY(54.5+$intervmaes);
	$pdf->Cell(11);
	$pdf->Cell(10,5,'DETALLES',0,1,'L'); 
	$pdf->SetY(54.5+$intervmaes);
	$pdf->Cell(117.1);
	$pdf->Cell(24,5,'PAGOS',0,1,'C');
	$pdf->SetY(54.5+$intervmaes);
	$pdf->Cell(170.1);
	$pdf->Cell(24,5,'DESCUENTOS',0,1,'C');
			
	//MULTICOLUMNAS CONCEPTOS
	$pdf->SetWidths(array(5,105,30,55));
	$pdf->SetAligns(array('L','L','R','R'));

	$pdf->SetFont('Times','',10);
	$pdf->SetFillColor(245,245,245);
	$pdf->Ln(1);
	$suming=0;
	$sumegr=0;
	if($filpri<=0){
		$pdf->Row(array('','Salario Básico','$'.number_format($rowg[10],2),'$'.number_format(0,2)),0);
		$pdf->Row(array('','Devengado','$'.number_format($rowg[5],2),'$'.number_format(0,2)),1);
		$pdf->Row(array('','Auxilio de Alimentación','$'.number_format($rowg[6],2),'$'.number_format(0,2)),2);
		$pdf->Row(array('','Auxilio de Transporte','$'.number_format($rowg[7],2),'$'.number_format(0,2)),3);
		$pdf->Row(array('','Horas Extras','$'.number_format($rowg[11],2),'$'.number_format(0,2)),4);
		$pdf->Row(array('','Salud','$'.number_format(0,2),'$'.number_format($rowg[12],2)),5);
		$pdf->Row(array('','Pensión','$'.number_format(0,2),'$'.number_format($rowg[13],2)),6);
		$pdf->Row(array('','Fondo de Solidaridad','$'.number_format(0,2),'$'.number_format($rowg[14],2)),7);
		$pdf->Row(array('','Retención en la Fuente','$'.number_format(0,2),'$'.number_format($rowg[15],2)),8);
		$suming=$rowg[5]+$rowg[6]+$rowg[7]+$rowg[11];
		$sumegr=$rowg[12]+$rowg[13]+$rowg[14]+$rowg[15];
		$sqlr="SELECT hp.descripcion,hp.ncta,hr.ncuotas,hr.valorcuota FROM humnominaretenemp hp, humretenempleados hr WHERE hp.id_nom='$rowg[0]' AND hp.cedulanit='$rowg[16]' AND hr.id=hp.id ORDER BY hr.id";
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
		$pdf->Ln(1);
		$pdf->line(10,$pdf->GetY(),209,$pdf->GetY());
	//	$pdf->line(10,108+$intervmaes+$interv,110,108+$intervmaes+$interv);
		$pdf->SetFont('Arial','I',8);
//		$pdf->SetY(109+$intervmaes+$interv);
//		$pdf->Cell(0.2);
//		$pdf->cell(100,5,'Elaborado por: '.$jnomina,0,0,'L',1);	
		$pdf->Row(array('','','$'.number_format($suming,2),'$'.number_format($sumegr,2)),1);
	}
	else{
		$sqld="SELECT * FROM humnomina_prima_det WHERE id_nom='$rowg[0]' AND tercero='$rowg[16]'";
		$rsd=mysql_query($sqld,$linkbd);
		$rowd=mysql_fetch_array($rsd);
		$pdf->Row(array('','Salario Básico','$'.number_format($rowg[10],2),'$'.number_format(0,2)),0);
		$pdf->Row(array('','Devengado','$'.number_format($rowg[5],2),'$'.number_format(0,2)),1);
		$pdf->Row(array('','Prima de Servicios','$'.number_format($rowd[6],2),'$'.number_format(0,2)),2);
		$pdf->Row(array('','Prima de Vacaciones','$'.number_format($rowd[7],2),'$'.number_format(0,2)),3);
		$suming=$rowd[6]+$rowd[7];		
		$pdf->Ln(1);
		$pdf->line(10,$pdf->GetY(),209,$pdf->GetY());
		$pdf->Row(array('','','$'.number_format($suming,2),'$'.number_format($sumegr,2)),4);
	}

/*	$pdf->SetY(61+$intervmaes);
	$pdf->Cell(5);
	$pdf->cell(100,5,'Salario Básico',0,0,'L',1); 
	$pdf->SetY(61+$intervmaes);
	$pdf->Cell(100.1);
	$pdf->cell(40,5,'$'.number_format($rowg[10],2),0,0,'R',1);
	$pdf->SetY(61+$intervmaes);
	$pdf->Cell(140.1);
	$pdf->cell(56,5,'$'.number_format(0,2),0,0,'R',1);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetY(65.5+$intervmaes);
	$pdf->Cell(5);
	$pdf->cell(100,5,'Devengado',0,0,'L',1); 
	$pdf->SetY(65.5+$intervmaes);
	$pdf->Cell(100.1);
	$pdf->cell(40,5,'$'.number_format($rowg[5],2),0,0,'R',1);
	$pdf->SetY(65.5+$intervmaes);
	$pdf->Cell(140.1);
	$pdf->cell(56,5,'$'.number_format(0,2),0,0,'R',1);
		$pdf->SetFillColor(245,245,245);
		$pdf->SetY(70+$intervmaes);
		$pdf->Cell(5);
		$pdf->cell(100,5,'Auxilio de alimentación',0,0,'L',1); 
		$pdf->SetY(70+$intervmaes);
		$pdf->Cell(100.1);
		$pdf->cell(40,5,'$'.number_format($rowg[6],2),0,0,'R',1);
		$pdf->SetY(70+$intervmaes);
		$pdf->Cell(140.1);
		$pdf->cell(56,5,'$'.number_format(0,2),0,0,'R',1);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetY(74.5+$intervmaes);
		$pdf->Cell(5);
		$pdf->cell(100,5,'Auxilio de Transporte',0,0,'L',1); 
		$pdf->SetY(74.5+$intervmaes);
		$pdf->Cell(100.1);
		$pdf->cell(40,5,'$'.number_format($rowg[7],2),0,0,'R',1);
		$pdf->SetY(74.5+$intervmaes);
		$pdf->Cell(140.1);
		$pdf->cell(56,5,'$'.number_format(0,2),0,0,'R',1);
		$pdf->SetFillColor(245,245,245);
		$pdf->SetY(79+$intervmaes);
		$pdf->Cell(5);
		$pdf->cell(100,5,'Horas Extras',0,0,'L',1); 
		$pdf->SetY(79+$intervmaes);
		$pdf->Cell(100.1);
		$pdf->cell(40,5,'$'.number_format($rowg[11],2),0,0,'R',1);
		$pdf->SetY(79+$intervmaes);
		$pdf->Cell(140.1);
		$pdf->cell(56,5,'$'.number_format(0,2),0,0,'R',1);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetY(83.5+$intervmaes);
		$pdf->Cell(5);
		$pdf->cell(100,5,'Salud',0,0,'L',1); 
		$pdf->SetY(83.5+$intervmaes);
		$pdf->Cell(100.1);
		$pdf->cell(40,5,'$'.number_format(0,2),0,0,'R',1);
		$pdf->SetY(83.5+$intervmaes);
		$pdf->Cell(140.1);
		$pdf->cell(56,5,'$'.number_format($rowg[12],2),0,0,'R',1);
		$pdf->SetFillColor(245,245,245);
		$pdf->SetY(88+$intervmaes);
		$pdf->Cell(5);
		$pdf->cell(100,5,'Pensión',0,0,'L',1); 
		$pdf->SetY(88+$intervmaes);
		$pdf->Cell(100.1);
		$pdf->cell(40,5,'$'.number_format(0,2),0,0,'R',1);
		$pdf->SetY(88+$intervmaes);
		$pdf->Cell(140.1);
		$pdf->cell(56,5,'$'.number_format($rowg[13],2),0,0,'R',1);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetY(92.5+$intervmaes);
		$pdf->Cell(5);
		$pdf->cell(100,5,'Fondo de solidaridad',0,0,'L',1); 
		$pdf->SetY(92.5+$intervmaes);
		$pdf->Cell(100.1);
		$pdf->cell(40,5,'$'.number_format(0,2),0,0,'R',1);
		$pdf->SetY(92.5+$intervmaes);
		$pdf->Cell(140.1);
		$pdf->cell(56,5,'$'.number_format($rowg[14],2),0,0,'R',1);
		$pdf->SetFillColor(245,245,245);
		$pdf->SetY(97+$intervmaes);
		$pdf->Cell(5);
		$pdf->cell(100,5,'Retención en la fuente',0,0,'L',1); 
		$pdf->SetY(97+$intervmaes);
		$pdf->Cell(100.1);
		$pdf->cell(40,5,'$'.number_format(0,2),0,0,'R',1);
		$pdf->SetY(97+$intervmaes);
		$pdf->Cell(140.1);
		$pdf->cell(56,5,'$'.number_format($rowg[15],2),0,0,'R',1);
		$sqlr="SELECT hp.descripcion,hp.ncta,hr.ncuotas,hr.valorcuota FROM humnominaretenemp hp, humretenempleados hr WHERE hp.id_nom='$rowg[0]' AND hp.cedulanit='$rowg[16]' AND hr.id=hp.id ORDER BY hr.id";
		$resp = mysql_query($sqlr,$linkbd);
		$cont=1;
		$interv=4.5;
		while ($row =mysql_fetch_row($resp)) 
		{
			if ($cont%2==0){$pdf->SetFillColor(245,245,245);}
			else{$pdf->SetFillColor(255,255,255);}
			$pdf->SetY(97+$intervmaes+$interv);
			$pdf->Cell(5);
			$pdf->cell(100,5,substr(ucwords(strtolower($row[0])),0,50).' '.$row[1].' de '.$row[2],0,0,'L',1); 
			$pdf->SetY(97+$intervmaes+$interv);
			$pdf->Cell(100.1);
			$pdf->cell(40,5,'$'.number_format(0,2),0,0,'R',1);
			$pdf->SetY(97+$intervmaes+$interv);
			$pdf->Cell(140.1);
			$pdf->cell(56,5,'$'.number_format($row[3],2),0,0,'R',1);
			$cont=$cont+1;
			$interv=$interv+4.5;
		}*/
		if($intervmaes!=0){$pdf->AddPage();}
	}
	$pdf->Output(); 
?>