<?php //V 1000 12/12/16 ?> 
<?php
	require_once("tcpdf/tcpdf_include.php");
	require('comun.inc');
	session_start();
	class MYPDF extends TCPDF {}
	$pdf = new MYPDF('P','mm','Letter', true, 'iso-8859-1', false);// create new PDF document
	$pdf->SetDocInfoUnicode (true); 
	// set document information
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('G&CSAS');
	$pdf->SetTitle('Comprobante Radicación');
	$pdf->SetSubject('Radicación de Documentos');
	$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
	$pdf->SetAutoPageBreak(TRUE, 15);// set auto page breaks
	// set some language-dependent strings (optional)
	if (@file_exists(dirname(__FILE__).'/lang/spa.php')) 
	{
		require_once(dirname(__FILE__).'/lang/spa.php');
		$pdf->setLanguageArray($l);
	}
	// ---------------------------------------------------------
	$pdf->AddPage();// add a page
	$linkbd=conectar_bd();
	$sqlr="SELECT nit, razonsocial, direccion, telefono,web,email FROM configbasica WHERE estado='S'";
	$resp=mysql_query($sqlr,$linkbd);
	while($row=mysql_fetch_row($resp))
	{
		$nit=$row[0];
		$rs=utf8_encode(strtoupper($row[1]));
		$direcc=utf8_encode(strtoupper($row[2]));
		$telefonos=$row[3];
		$dirweb=utf8_encode(strtoupper($row[5]));
		$coemail=utf8_encode(strtoupper($row[4]));
	}
	$tiporadicado = explode('-', $_POST[tradicacion]);
	$sqlr="SELECT descripcion_valor FROM dominios WHERE nombre_dominio='TIPO_RADICACION_AC' AND valor_inicial ='$tiporadicado[0]'  ";
	$resp=mysql_query($sqlr,$linkbd);
	while($row=mysql_fetch_row($resp)){$tprd=utf8_encode($row[0]);}
	$tam=count($_POST[docres]);   
    for($x=0;$x<$tam;$x++){if($_POST[lecesc][$x] == "E"){$nomresponsable=$_POST[nomdes][$x];}}
	if ($_POST[trescrito] == 1){$marca1="checked";}
	else {$marca1="";}
	if ($_POST[trtelefono] == 1){$marca2="checked";}
	else {$marca2="";}
	if ($_POST[trcorreo] == 1){$marca3="checked";}
	else {$marca3="";}
	$styleline = array('width' => 0.3, 'cap' => 'butt', 'join' => 'miter', 'dash' => '10,5', 'phase' => 0, 'color' => array(0, 0, 0));
	//------------PRIMER COMPROVANTE------------------------	
	$pdf->Image('imagenes/eng.jpg', 25, 10, 25, 23.9, 'JPG', '', 'T', true, 300, '', false, false, 0, false, false, false);// Logo
	$pdf->SetFont('helvetica','B',8);
	$pdf->SetY(10);
	$pdf->RoundedRect(10, 10, 190, 31, 2.5,''); //Borde del encabezado
	$pdf->Cell(52,31,'','R',0,'L'); //Linea que separa el encabazado verticalmente
	$pdf->SetY(31);
	$pdf->Cell(52,5,''.$rs,0,0,'C',false,0,1,false,'T','B'); //Nombre Municipio
	$pdf->SetFont('helvetica','B',8);
	$pdf->SetY(35);
	$pdf->Cell(52,5,''.$nit,0,0,'C',false,0,1,false,'T','C'); //Nit
	$pdf->SetFont('helvetica','B',14);
	$pdf->SetY(10);
	$pdf->SetX(62);
	$pdf->Cell(138,17,'RADICACION DE DOCUMENTOS',0,0,'C'); 
	$pdf->SetFont('helvetica','I',10);
	$pdf->SetY(27);
	$pdf->SetX(62);
	$pdf->Cell(100,7,"Tipo de Radicación: $tprd",'T',0,'L',false,0,1); 
	$pdf->SetFont('helvetica','B',9);
	$pdf->SetY(27);
	$pdf->SetX(162);
	$pdf->Cell(37.8,14,'','TL',0,'L');
	$pdf->SetY(27);
	$pdf->SetX(162.5);
	$pdf->Cell(35,5,"N°: $_POST[nradicado]",0,0,'L');
	$pdf->SetY(31);
	$pdf->SetX(162.5);
	$pdf->Cell(35,5,"FECHA: $_POST[fecharad]",0,0,'L');
	$pdf->SetY(35);
	$pdf->SetX(162.5);
	$pdf->Cell(35,5,"HORA: ".date('h:i:s a',strtotime($_POST[horarad])),0,0,'L');
	// ---------------------------------------------------------
	$pdf->RoundedRect(10, 43, 190, 60, 2.5,'');
	$pdf->SetFont('helvetica', 'B', 9);
	$pdf->SetY(43);
	$pdf->Cell(17,7,"RADICO:",0,0,'L',false,0,0,false,'T','B'); 
	$pdf->SetFont('helvetica', 'B', 8);
	$pdf->SetX(31);
	$pdf->Cell(125,7,utf8_encode(strtoupper($_POST[ntercero])),'B',0,'L',false,0,1,false,'T','B'); 
	$pdf->SetFont('helvetica', 'B', 9);
	$pdf->SetX(157);
	$pdf->Cell(15,7,"N° DOC:",0,0,'L',false,0,0,false,'T','B');
	$pdf->SetFont('helvetica', 'B', 8);
	$pdf->SetX(172);
	$pdf->Cell(25,7,$_POST[tercero],'B',0,'L',false,0,1,false,'T','B'); 
	$pdf->SetFont('helvetica', 'B', 9);
	$pdf->SetY(50);
	$pdf->Cell(21,7,"DIRECCION:",0,0,'L',false,0,0,false,'T','B'); 
	$pdf->SetFont('helvetica', 'B', 8);
	$pdf->SetX(31);
	$pdf->Cell(166,7,utf8_encode(strtoupper($_POST[ndirecc])),'B',0,'L',false,0,1,false,'T','B'); 
	$pdf->SetFont('helvetica', 'B', 9);
	$pdf->SetY(57);
	$pdf->Cell(21,7,"EMAIL:",0,0,'L',false,0,0,false,'T','B');
	$pdf->SetFont('helvetica', 'B', 8);
	$pdf->SetX(31);
	$pdf->Cell(166,7,utf8_encode(strtoupper($_POST[ncorreoe])),'B',0,'L',false,0,1,false,'T','B'); 
	$pdf->SetFont('helvetica', 'B', 9);
	$pdf->SetY(64);
	$pdf->Cell(21,7,"TELEFONO:",0,0,'L',false,0,0,false,'T','B');
	$pdf->SetFont('helvetica', 'B', 8);
	$pdf->SetX(31);
	$pdf->Cell(72,7,utf8_encode(strtoupper($_POST[ntelefono])),'B',0,'L',false,0,1,false,'T','B');
	$pdf->SetFont('helvetica', 'B', 9);
	$pdf->SetX(103);
	$pdf->Cell(21,7,"CELULAR:",0,0,'L',false,0,0,false,'T','B');
	$pdf->SetFont('helvetica', 'B', 8);
	$pdf->SetX(124);
	$pdf->Cell(73,7,utf8_encode(strtoupper($_POST[ncelular])),'B',0,'L',false,0,1,false,'T','B');
	$pdf->SetFont('helvetica', 'B', 9);
	$pdf->SetY(71);
	$pdf->Cell(21,7,"RESPUESTA:",0,0,'L',false,0,0,false,'T','B');
	$pdf->SetFont('helvetica', 'B', 8);
	$html = <<<EOD
		<input type="checkbox" name="trescrito" value="1>" checked="$marca1"/>ESCRITA
		<input type="checkbox" name="trtelefono" value="1" checked="$marca2"/>TELEFONICA
		<input type="checkbox" name="trcorreo" value="1" checked="$marca3"/>CORREO ELECTRONICO 
EOD;
	$pdf->SetY(74);
	$pdf->SetX(32);
	$pdf->writeHTML($html, true, 0, true, 0);
	$pdf->Line(31, 78, 157, 78);
	$pdf->SetFont('helvetica', 'B', 9);
	$pdf->SetY(71);
	$pdf->SetX(157);
	$pdf->Cell(15,7,"FOLIOS:",0,0,'L',false,0,0,false,'T','B');
	$pdf->SetFont('helvetica', 'B', 8);
	$pdf->SetX(172);
	$pdf->Cell(25,7,$_POST[contarch],'B',0,'L',false,0,1,false,'T','B'); 
	$pdf->SetFont('helvetica', 'B', 9);
	$pdf->SetY(78);
	$pdf->Cell(28,7,"DESCRIPCION:",0,0,'L',false,0,0,false,'T','B');
	$pdf->SetFont('helvetica', 'B', 8);
	$pdf->SetY(81.5);
	$pdf->SetX(38);
	$pdf->Multicell(160,20,utf8_encode(strtoupper($_POST[raddescri])),0,'L',false,1,'','',true,0,false,true,0,'T',false);
	$pdf->SetFont('helvetica', 'BI', 8);
	$pdf->SetY(105);
	$txt = <<<EOD
Dirección: $direcc, Telefonos: $telefonos
Email:$dirweb, Pagina Web: $coemail
EOD;
	$pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);
	//------------SEGUNDO COMPROVANTE------------------------	
	$pdf->Image('imagenes/eng.jpg', 25, 130, 25, 23.9, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);// Logo
	$pdf->SetFont('helvetica','B',8);
	$pdf->SetY(130);
	$pdf->RoundedRect(10, 130, 190, 31, 2.5,''); //Borde del encabezado
	$pdf->Cell(52,31,'','R',0,'L'); //Linea que separa el encabazado verticalmente
	$pdf->SetY(151);
	$pdf->Cell(52,5,''.$rs,0,0,'C',false,0,1,false,'T','B'); //Nombre Municipio
	$pdf->SetFont('helvetica','B',8);
	$pdf->SetY(155);
	$pdf->Cell(52,5,''.$nit,0,0,'C',false,0,1,false,'T','C'); //Nit
	$pdf->SetFont('helvetica','B',14);
	$pdf->SetY(130);
	$pdf->SetX(62);
	$pdf->Cell(138,17,'RADICACION DE DOCUMENTOS',0,0,'C'); 
	$pdf->SetFont('helvetica','I',10);
	$pdf->SetY(147);
	$pdf->SetX(62);
	$pdf->Cell(100,7,"Tipo de Radicación: $tprd",'T',0,'L',false,0,1); 
	$pdf->SetFont('helvetica','B',9);
	$pdf->SetY(147);
	$pdf->SetX(162);
	$pdf->Cell(37.8,14,'','TL',0,'L');
	$pdf->SetY(147);
	$pdf->SetX(162.5);
	$pdf->Cell(35,5,"N°: $_POST[nradicado]",0,0,'L');
	$pdf->SetY(151);
	$pdf->SetX(162.5);
	$pdf->Cell(35,5,"FECHA: $_POST[fecharad]",0,0,'L');
	$pdf->SetY(155);
	$pdf->SetX(162.5);
	$pdf->Cell(35,5,"HORA: ".date('h:i:s a',strtotime($_POST[horarad])),0,0,'L');
	// ---------------------------------------------------------
	$pdf->RoundedRect(10, 163, 190, 67, 2.5,'');
	$pdf->SetFont('helvetica', 'B', 9);
	$pdf->SetY(163);
	$pdf->Cell(17,7,"RADICO:",0,0,'L',false,0,0,false,'T','B'); 
	$pdf->SetFont('helvetica', 'B', 8);
	$pdf->SetX(31);
	$pdf->Cell(125,7,utf8_encode(strtoupper($_POST[ntercero])),'B',0,'L',false,0,1,false,'T','B'); 
	$pdf->SetFont('helvetica', 'B', 9);
	$pdf->SetX(157);
	$pdf->Cell(15,7,"N° DOC:",0,0,'L',false,0,0,false,'T','B');
	$pdf->SetFont('helvetica', 'B', 8);
	$pdf->SetX(172);
	$pdf->Cell(25,7,$_POST[tercero],'B',0,'L',false,0,1,false,'T','B'); 
	$pdf->SetFont('helvetica', 'B', 9);
	$pdf->SetY(170);
	$pdf->Cell(21,7,"DIRECCION:",0,0,'L',false,0,0,false,'T','B'); 
	$pdf->SetFont('helvetica', 'B', 8);
	$pdf->SetX(31);
	$pdf->Cell(166,7,utf8_encode(strtoupper($_POST[ndirecc])),'B',0,'L',false,0,1,false,'T','B'); 
	$pdf->SetFont('helvetica', 'B', 9);
	$pdf->SetY(177);
	$pdf->Cell(21,7,"EMAIL:",0,0,'L',false,0,0,false,'T','B');
	$pdf->SetFont('helvetica', 'B', 8);
	$pdf->SetX(31);
	$pdf->Cell(166,7,utf8_encode(strtoupper($_POST[ncorreoe])),'B',0,'L',false,0,1,false,'T','B'); 
	$pdf->SetFont('helvetica', 'B', 9);
	$pdf->SetY(184);
	$pdf->Cell(21,7,"TELEFONO:",0,0,'L',false,0,0,false,'T','B');
	$pdf->SetFont('helvetica', 'B', 8);
	$pdf->SetX(31);
	$pdf->Cell(72,7,utf8_encode(strtoupper($_POST[ntelefono])),'B',0,'L',false,0,1,false,'T','B');
	$pdf->SetFont('helvetica', 'B', 9);
	$pdf->SetX(103);
	$pdf->Cell(21,7,"CELULAR:",0,0,'L',false,0,0,false,'T','B');
	$pdf->SetFont('helvetica', 'B', 8);
	$pdf->SetX(124);
	$pdf->Cell(73,7,utf8_encode(strtoupper($_POST[ncelular])),'B',0,'L',false,0,1,false,'T','B');
	$pdf->SetFont('helvetica', 'B', 9);
	$pdf->SetY(191);
	$pdf->Cell(21,7,"RESPUESTA:",0,0,'L',false,0,0,false,'T','B');
	$pdf->SetFont('helvetica', 'B', 8);
	$pdf->SetY(194);
	$pdf->SetX(32);
	$pdf->writeHTML($html, true, 0, true, 0);
	$pdf->Line(31, 198, 157, 198);
	$pdf->SetFont('helvetica', 'B', 9);
	$pdf->SetY(191);
	$pdf->SetX(157);
	$pdf->Cell(15,7,"FOLIOS:",0,0,'L',false,0,0,false,'T','B');
	$pdf->SetFont('helvetica', 'B', 8);
	$pdf->SetX(172);
	$pdf->Cell(25,7,$_POST[contarch],'B',0,'L',false,0,1,false,'T','B'); 
	$pdf->SetFont('helvetica', 'B', 9);
	$pdf->SetY(198);
	$pdf->Cell(28,7,"RESPONSABLE:",0,0,'L',false,0,0,false,'T','B');
	$pdf->SetFont('helvetica', 'B', 8);
	$pdf->SetX(38);
	$pdf->Cell(159,7,utf8_encode(strtoupper($nomresponsable)),'B',0,'L',false,0,1,false,'T','B'); 
	$pdf->SetFont('helvetica', 'B', 9);
	$pdf->SetY(205);
	$pdf->Cell(28,7,"DESCRIPCION:",0,0,'L',false,0,0,false,'T','B');
	$pdf->SetFont('helvetica', 'B', 8);
	$pdf->SetY(208.5);
	$pdf->SetX(38);
	$pdf->Multicell(160,20,utf8_encode(strtoupper($_POST[raddescri])),0,'L',false,1,'','',true,0,false,true,0,'T',false);
	$pdf->SetFont('helvetica', 'BI', 8);
	$pdf->SetY(232);
	$pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);
	$pdf->Line(0, 120, 210, 120,$styleline);
	// ---------------------------------------------------------
	$pdf->Output('Radicacion.pdf', 'I');//Close and output PDF document
?>