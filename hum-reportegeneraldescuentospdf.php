<?php //V 1000 12/12/16 ?> 
<?php
	require_once("tcpdf/tcpdf_include.php");
	require('comun.inc');
	require('funciones.inc');
	session_start();
	class MYPDF extends TCPDF 
	{
		public function Header()
		{
			$linkbd=conectar_bd();
			$sqlr="SELECT nit, razonsocial FROM configbasica WHERE estado='S'";
			$resp=mysql_query($sqlr,$linkbd);
			while($row=mysql_fetch_row($resp)){$nit=$row[0];$rs=utf8_encode(strtoupper($row[1]));}
			$this->Image('imagenes/eng.jpg', 25, 10, 25, 25, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);// Logo
			$this->SetFont('helvetica','B',10);
			$this->SetY(10);
			$this->RoundedRect(10, 10, 278, 31, 1,'' );
			$this->Line(62, 10, 62, 41);
			$this->SetY(31);
			$this->Cell(52,5,''.$rs,0,0,'C',false,0,1,false,'T','B'); //Nombre Municipio
			$this->SetFont('helvetica','B',8);
			$this->SetY(35);
			$this->Cell(52,5,''.$nit,0,0,'C',false,0,1,false,'T','C'); //Nit
			$this->SetFont('helvetica','B',14);
			$this->SetY(10);
			$this->SetX(62);
			$this->Cell(226,15,'REPORTE GENERAL DE DESCUENTOS DE NOMINA',1,0,'C'); 
			$this->SetFont('helvetica','B',10);
			$this->Line(240, 25, 240, 41);
			$this->SetY(27);
			$this->SetX(242);
			$this->Cell(35,5,'VIGENCIA : '.vigencia_usuarios($_SESSION[cedulausu]),10,0,'L');
			$this->SetY(33);
			$this->SetX(242);
			$this->Cell(35,5,'FECHA: '.date("d/m/Y"),0,0,'L');
			$this->ln(10); 
			$this->SetFillColor(222,222,222);
			$this->SetFont('helvetica','B',10);
			$margeny=$this->GetY();	
			$this->SetY($margeny);
			$this->SetX(10);
			$this->Cell(12,9,'N°',1,0,'C',true,0,1,false,'T','C');
			$this->Cell(15,9,'Nomina',1,0,'C',true,0,1,false,'T','C');
			$this->Cell(30,9,'Mes',1,0,'C',true,0,1,false,'T','C');
			$this->Cell(16,9,'Vigencia',1,0,'C',true,0,1,false,'T','C');
			$this->Cell(30,9,'Documento',1,0,'C',true,0,1,false,'T','C');
			$this->Cell(70,9,'Funcionario',1,0,'C',true,0,1,false,'T','C');
			$this->Cell(70,9,'Descuento',1,0,'C',true,0,1,false,'T','C');
			$this->Cell(35,9,'Valor',1,0,'C',true,0,1,false,'T','C');
		}
		
		public function Footer() 
		{
			$linkbd=conectar_bd();
			$sqlr="SELECT direccion,telefono,web,email FROM configbasica WHERE estado='S'";
			$resp=mysql_query($sqlr,$linkbd);
			while($row=mysql_fetch_row($resp))
			{
				$direcc=utf8_encode(strtoupper($row[0]));
				$telefonos=$row[1];
				$dirweb=utf8_encode(strtoupper($row[2]));
				$coemail=utf8_encode(strtoupper($row[3]));
			}
			$this->SetY(-15);
			$this->SetFont('helvetica', 'I', 8);
			$this->RoundedRect(10, 195, 278,10, 1,'' );
			$this->Cell(0, 5, "Dirección: $direcc, Telefonos: $telefonos, Email:$dirweb, Pagina Web: $coemail",0, 1, 'C', 0, '', 0, false, 'T', 'M');
			$this->Cell(0, 5, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, 1, 'C', 0, '', 0, false, 'T', 'M');
		}
	}
	$pdf = new MYPDF('L','mm','Letter', true, 'iso-8859-1', false);// create new PDF document
	$pdf->SetDocInfoUnicode (true); 
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('G&CSAS');
	$pdf->SetTitle('Plan Anual de Adquisiciones');
	$pdf->SetSubject('Lista Adquisiciones');
	$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
	$pdf->SetMargins(10, 52, 10);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
	$pdf->SetAutoPageBreak(TRUE, 15);
	if (@file_exists(dirname(__FILE__).'/lang/spa.php')) 
	{
		require_once(dirname(__FILE__).'/lang/spa.php');
		$pdf->setLanguageArray($l);
	}
	$pdf->AddPage();// add a page
	$linkbd=conectar_bd();
	$listanomina=unserialize($_POST['lista_nominas']);
	$listames=unserialize($_POST['lista_meses']);
	$listavigencia=unserialize($_POST['lista_vigencias']);	
	$listadocumento=unserialize($_POST['lista_documentos']);
	$listafuncionario=unserialize($_POST['lista_funcionarios']);
	$listanomdescuento=unserialize($_POST['lista_nomdescuentos']);
	$listavaldescuento=unserialize($_POST['lista_valdescuentos']);
	for($ii=0;$ii<count ($listanomina);$ii++)
	{
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('helvetica','I',8);
		$pdf->Cell(12,6,($ii+1),1,0,'C',true,0,1,false,'T','C');
		$pdf->Cell(15,6,$listanomina[$ii],1,0,'C',true,0,1,false,'T','C');
		$pdf->Cell(30,6,$listames[$ii],1,0,'C',true,0,1,false,'T','C');
		$pdf->Cell(16,6,$listavigencia[$ii],1,0,'C',true,0,1,false,'T','C');
		$pdf->Cell(30,6,$listadocumento[$ii],1,0,'C',true,0,0,false,'T','C');
		$pdf->Cell(70,6,utf8_encode($listafuncionario[$ii]),1,0,'L',true,0,0,false,'T','C');
		$pdf->Cell(70,6,$listanomdescuento[$ii],1,0,'L',true,0,0,false,'T','C');
		$pdf->Cell(35,6,'$'.number_format($listavaldescuento[$ii],2),1,1,'R',true,1,0,false,'T','C');
	}
	$pdf->Cell(243,6,"TOTAL:",1,0,'R',true,0,0,false,'T','C');
	$pdf->Cell(35,6,'$'.number_format(array_sum($listavaldescuento),2),1,1,'R',true,1,0,false,'T','C');
	$pdf->Output('Reporte.pdf', 'I');//Close and output PDF document
	
?> 