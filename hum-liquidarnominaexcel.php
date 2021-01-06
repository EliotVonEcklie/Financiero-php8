<?php
	require_once 'PHPExcel/Classes/PHPExcel.php';
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$listatipopago=unserialize($_POST['lista_tipopago']);
	$listatcodigofuncionario=unserialize($_POST['lista_codigofuncionario']);
	$listaempleados=unserialize($_POST['lista_empleados']);
	$listadocumentos=unserialize($_POST['lista_documento']);
	$listasalariobasico=unserialize($_POST['lista_salariobasico']);	
	$listadevengados=unserialize($_POST['lista_devengados']);
	$listaauxalimentacion=unserialize($_POST['lista_auxalimentacion']);
	$listaauxtrasporte=unserialize($_POST['lista_auxtrasporte']);
	$listaotrospagos=unserialize($_POST['lista_otrospagos']);
	$listatotaldevengados=unserialize($_POST['lista_totaldevengados']);
	$listaibc=unserialize($_POST['lista_ibc']);
	$listabaseparafiscales=unserialize($_POST['lista_baseparafiscales']);
	$listabasearp=unserialize($_POST['lista_basearp']);
	$listaarp=unserialize($_POST['lista_arp']);
	$listasaludempleado=unserialize($_POST['lista_saludempleado']);
	$listasaludempleadog=unserialize($_POST['lista_saludempleadog']);
	$listasaludempresa=unserialize($_POST['lista_saludempresa']);
	$listasaludempresag=unserialize($_POST['lista_saludempresag']);
	$listasaludtotal=unserialize($_POST['lista_saludtotal']);
	$listasaludtotalg=unserialize($_POST['lista_saludtotalg']);
	$listapensionempleado=unserialize($_POST['lista_pensionempleado']);
	$listapensionempleadog=unserialize($_POST['lista_pensionempleadog']);
	$listapensionempresa=unserialize($_POST['lista_pensionempresa']);
	$listapensionempresag=unserialize($_POST['lista_pensionempresag']);
	$listapensiontotal=unserialize($_POST['lista_pensiontotal']);
	$listapensiontotalg=unserialize($_POST['lista_pensiontotalg']);
	$listafondosolidaridad=unserialize($_POST['lista_fondosolidaridad']);
	$listafondosolidaridadg=unserialize($_POST['lista_fondosolidaridadg']);
	$listaretenciones=unserialize($_POST['lista_retenciones']);
	$listaotrasdeducciones=unserialize($_POST['lista_otrasdeducciones']);
	$listatotaldeducciones=unserialize($_POST['lista_totaldeducciones']);
	$listanetoapagar=unserialize($_POST['lista_netoapagar']);
	$listaccf=unserialize($_POST['lista_ccf']);
	$listasena=unserialize($_POST['lista_sena']);
	$listaicbf=unserialize($_POST['lista_icbf']);
	$listainstecnicos=unserialize($_POST['lista_instecnicos']);
	$listaesap=unserialize($_POST['lista_esap']);
	$listadiasincapacidad=unserialize($_POST['lista_diasincapacidad']);
	$listadiaslaborados=unserialize($_POST['lista_diaslaborados']);
	$linkbd=conectar_bd();
	$objPHPExcel = new PHPExcel();
	//----Propiedades----
	$objPHPExcel->getProperties()
		->setCreator("SPID")
		->setLastModifiedBy("SPID")
		->setTitle("Liquidacion de Nomina")
		->setSubject("Nomina")
		->setDescription("Nomina")
		->setKeywords("Nomina")
		->setCategory("Gestion Humana");
	//----Cuerpo de Documento----
	$objPHPExcel->getActiveSheet()->mergeCells('A1:AD1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'NOMINA DETALLADA');
	$objFont=$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont();
	$objFont->setName('Courier New');
	$objFont->setSize(15);
	$objFont->setBold(true);
	$objFont->setUnderline(PHPExcel_Style_Font::UNDERLINE_SINGLE);
	$objFont->getColor()->setARGB( PHPExcel_Style_Color::COLOR_BLACK);
	$objAlign=$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment(); 
	$objAlign->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objAlign->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$objPHPExcel-> getActiveSheet ()
		-> getStyle ("A2:AD2")
		-> getFill ()
		-> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
		-> getStartColor ()
		-> setRGB ('A6E5F3');
	$objPHPExcel-> getActiveSheet ()
		-> getStyle ("A1")	
		-> getFill ()
		-> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
		-> getStartColor ()
		-> setRGB ('A6E5F3');
	$borders = array(
		'borders' => array(
			'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN,
				'color' => array('argb' => 'FF000000'),
			)
		),
	);
	$objPHPExcel->getActiveSheet()->getStyle('A2:AD2')->applyFromArray($borders);
	$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A2', 'TIPO PAGO')
			->setCellValue('B2', 'DOCUMENTO')
			->setCellValue('C2', 'EMPLEADO')
			->setCellValue('D2', 'SALARIO BASICO')
			->setCellValue('E2', 'DIAS')
			->setCellValue('F2', 'DEVENGADO')
			->setCellValue('G2', 'AUX ALIMENTACION')
			->setCellValue('H2', 'AUX TRANSPORTE')
			->setCellValue('I2', 'OTROS PAGOS')
			->setCellValue('J2', 'TOTAL DEVENGADO')
			->setCellValue('K2', 'IBC')
			->setCellValue('L2', 'BASE PARAFISCALES')
			->setCellValue('M2', 'BASE ARP')
			->setCellValue('N2', 'ARP')
			->setCellValue('O2', 'SALUD EMPLEADO')
			->setCellValue('P2', 'SALUD EMPRESA')
			->setCellValue('Q2', 'SALUD TOTAL')
			->setCellValue('R2', 'PENSION EMPLEADO')
			->setCellValue('S2', 'PENSION EMPRESA')
			->setCellValue('T2', 'PENSION TOTAL')
			->setCellValue('U2', 'FONDO SOLIDARIDAD')
			->setCellValue('V2', 'RETEFUENTE')
			->setCellValue('W2', 'OTRAS DEDUCCIONES')
			->setCellValue('X2', 'TOTAL DEDUCCIONES')
			->setCellValue('Y2', 'NETO A PAGAR')
			->setCellValue('Z2', 'CCF')
			->setCellValue('AA2', 'SENA')
			->setCellValue('AB2', 'ICBF')
			->setCellValue('AC2', 'INS. TECNICOS')
			->setCellValue('AD2', 'ESAP');
	$i=3;
	for($ii=0;$ii<count ($listaempleados);$ii++)
	{	
		$nomfuncionario=iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$listaempleados[$ii]);
		if($listatipopago[$ii]=='NN'){$tipopa='NETO TOTAL';}
		else
		{
			$sqlt="SELECT nombre FROM humvariables WHERE codigo='$listatipopago[$ii]'";
			$rest = mysql_query($sqlt,$linkbd);
			$rowt=mysql_fetch_row($rest);
			$tipopa=iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$rowt[0]);
		}
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValueExplicit ("A$i", $tipopa, PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("B$i", $listadocumentos[$ii], PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("C$i", $nomfuncionario, PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("D$i", $listasalariobasico[$ii], PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("E$i", $listadiaslaborados[$ii], PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("F$i", round ($listadevengados[$ii],0,PHP_ROUND_HALF_UP), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("G$i", round ($listaauxalimentacion[$ii],0,PHP_ROUND_HALF_UP), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("H$i", round ($listaauxtrasporte[$ii],0,PHP_ROUND_HALF_UP), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("I$i", round ($listaotrospagos[$ii],0,PHP_ROUND_HALF_UP), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("J$i", round ($listatotaldevengados[$ii],0,PHP_ROUND_HALF_UP), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("K$i", round ( $listaibc[$ii],0,PHP_ROUND_HALF_UP), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("L$i", round ($listabaseparafiscales[$ii],0,PHP_ROUND_HALF_UP), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("M$i", round ($listabasearp[$ii],0,PHP_ROUND_HALF_UP), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("N$i", round ($listaarp[$ii],0,PHP_ROUND_HALF_UP), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("O$i", round ($listasaludempleado[$ii],0,PHP_ROUND_HALF_UP), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("P$i", round ($listasaludempresa[$ii],0,PHP_ROUND_HALF_UP), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("Q$i", round ($listasaludtotal[$ii],0,PHP_ROUND_HALF_UP), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("R$i", round ($listapensionempleado[$ii],0,PHP_ROUND_HALF_UP), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("S$i", round ($listapensionempresa[$ii],0,PHP_ROUND_HALF_UP), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("T$i", round ($listapensiontotal[$ii],0,PHP_ROUND_HALF_UP), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("U$i", round ($listafondosolidaridad[$ii],0,PHP_ROUND_HALF_UP), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("V$i", round ($listaretenciones[$ii],0,PHP_ROUND_HALF_UP), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("W$i", round ($listaotrasdeducciones[$ii],0,PHP_ROUND_HALF_UP), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("X$i", round ($listatotaldeducciones[$ii],0,PHP_ROUND_HALF_UP), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("Y$i", round ($listanetoapagar[$ii],0,PHP_ROUND_HALF_UP), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("Z$i", round ($listaccf[$ii],0,PHP_ROUND_HALF_UP), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("AA$i", round ($listasena[$ii],0,PHP_ROUND_HALF_UP), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("AB$i", round ($listaicbf[$ii],0,PHP_ROUND_HALF_UP), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("AC$i", round ($listainstecnicos[$ii],0,PHP_ROUND_HALF_UP), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("AD$i",	round ($listaesap[$ii],0,PHP_ROUND_HALF_UP), PHPExcel_Cell_DataType :: TYPE_NUMERIC);
		$objPHPExcel->getActiveSheet()->getStyle("A$i:AD$i")->applyFromArray($borders);
		if($listatipopago[$ii]=='NN')
		{$objPHPExcel->getActiveSheet()->getStyle("A$i:AD$i")->getFill()->setFillType (PHPExcel_Style_Fill :: FILL_SOLID)->getStartColor()->setRGB('A1E103');}
		$i++;
	}
	//----Propiedades de la hoja 1
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->setTitle('Detallado');
	// hoja 2
	$objPHPExcel->createSheet(1);
	$objPHPExcel->setActiveSheetIndex(1);
	$objPHPExcel->getActiveSheet()->mergeCells('A1:AD1');
	$objPHPExcel->getActiveSheet()->setCellValue('A1', 'NOMINA TOTALES');
	$objFont=$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont();
	$objFont->setName('Courier New');
	$objFont->setSize(15);
	$objFont->setBold(true);
	$objFont->setUnderline(PHPExcel_Style_Font::UNDERLINE_SINGLE);
	$objFont->getColor()->setARGB( PHPExcel_Style_Color::COLOR_BLACK);
	$objAlign=$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment();
	$objAlign->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objAlign->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$objPHPExcel-> getActiveSheet ()
		-> getStyle ("A2:AD2")
		-> getFill ()
		-> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
		-> getStartColor ()
		-> setRGB ('A6E5F3');
	$objPHPExcel-> getActiveSheet ()
		-> getStyle ("A1")
		-> getFill ()
		-> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
		-> getStartColor ()
		-> setRGB ('A6E5F3');
	$borders = array(
		'borders' => array(
			'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN,
				'color' => array('argb' => 'FF000000'),
			)
		),
	);
	$objPHPExcel->getActiveSheet()->getStyle('A2:AD2')->applyFromArray($borders);
	$objPHPExcel->setActiveSheetIndex(1)
		->setCellValue('A2', iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",'N°'))
		->setCellValue('B2', 'Documento')
		->setCellValue('C2', 'EMPLEADO')
		->setCellValue('D2', 'SALARIO BASICO')
		->setCellValue('E2', 'DIAS')
		->setCellValue('F2', 'DEVENGADO')
		->setCellValue('G2', 'AUX ALIMENTACION')
		->setCellValue('H2', 'AUX TRANSPORTE')
		->setCellValue('I2', 'OTROS PAGOS')
		->setCellValue('J2', 'TOTAL DEVENGADO')
		->setCellValue('K2', 'IBC')
		->setCellValue('L2', 'BASE PARAFISCALES')
		->setCellValue('M2', 'BASE ARP')
		->setCellValue('N2', 'ARP')
		->setCellValue('O2', 'SALUD EMPLEADO')
		->setCellValue('P2', 'SALUD EMPRESA')
		->setCellValue('Q2', 'SALUD TOTAL')
		->setCellValue('R2', 'PENSION EMPLEADO')
		->setCellValue('S2', 'PENSION EMPRESA')
		->setCellValue('T2', 'PENSION TOTAL')
		->setCellValue('U2', 'FONDO SOLIDARIDAD')
		->setCellValue('V2', 'RETEFUENTE')
		->setCellValue('W2', 'OTRAS DEDUCCIONES')
		->setCellValue('X2', 'TOTAL DEDUCCIONES')
		->setCellValue('Y2', 'NETO A PAGAR')
		->setCellValue('Z2', 'CCF')
		->setCellValue('AA2', 'SENA')
		->setCellValue('AB2', 'ICBF')
		->setCellValue('AC2', 'INS. TECNICOS')
		->setCellValue('AD2', 'ESAP');
	$i=3;
	$x=0;
	$y=1;
	foreach ($listatcodigofuncionario as &$codfunci)
	{	
		$totaldias=$totaldeven=$totalauxalim=$totalauxtrans=$totalotrospag=$totalrdevenga=$totalsumibc=0;
		$totalibcpara=$totalibcarl=$totalsumarl=$totalsaludempl=$totalsaludempr=$totalsalud=$totalpensionempl=0;
		$totalpensionempr=$totalpension=$totalfondosol=$totalretefuente=$totalotrasdedu=$totaldeducciones=0; 
		$totalnetoapagar=$totalccf=$totalsena=$totalicbf=$totalinstecnicos=$totalesap=0;
		if (!in_array($listatcodigofuncionario[$x], $vecmarca))
		{
			$vecmarca[]=$listatcodigofuncionario[$x];
			for ($xy=0;$xy<count($listatcodigofuncionario);$xy++)
			{	
				if($listatcodigofuncionario[$x]==$listatcodigofuncionario[$xy]) 
				{
					$totaldias+=$listadiaslaborados[$xy];
					$totaldeven+=round ($listadevengados[$xy],0,PHP_ROUND_HALF_UP);
					$totalauxalim+=round ($listaauxalimentacion[$xy],0,PHP_ROUND_HALF_UP);
					$totalauxtrans+=round ($listaauxtrasporte[$xy],0,PHP_ROUND_HALF_UP);
					$totalotrospag+=round ($listaotrospagos[$xy],0,PHP_ROUND_HALF_UP);
					$totalrdevenga+=round ($listatotaldevengados[$xy],0,PHP_ROUND_HALF_UP);
					$totalsumibc+=round ($listaibc[$xy],0,PHP_ROUND_HALF_UP);
					$totalibcpara+=round ($listabaseparafiscales[$xy],0,PHP_ROUND_HALF_UP);
					$totalibcarl+=round ($listabasearp[$xy],0,PHP_ROUND_HALF_UP);
					$totalsumarl+=round ($listaarp[$xy],0,PHP_ROUND_HALF_UP);
					$totalsaludempl+=round ($listasaludempleado[$xy],0,PHP_ROUND_HALF_UP);
					$totalsaludempr+=round ($listasaludempresa[$xy],0,PHP_ROUND_HALF_UP);
					$totalsalud+=round ($listasaludtotal[$xy],0,PHP_ROUND_HALF_UP);
					$totalpensionempl+=round ($listapensionempleado[$xy],0,PHP_ROUND_HALF_UP);
					$totalpensionempr+=round ($listapensionempresa[$xy],0,PHP_ROUND_HALF_UP);
					$totalpension+=round ($listapensiontotal[$xy],0,PHP_ROUND_HALF_UP);
					$totalfondosol+=round ($listafondosolidaridad[$xy],0,PHP_ROUND_HALF_UP);
					$totalretefuente+=round ($listaretenciones[$xy],0,PHP_ROUND_HALF_UP);
					$totalotrasdedu+=round ($listaotrasdeducciones[$xy],0,PHP_ROUND_HALF_UP);
					$totaldeducciones+=round ($listatotaldeducciones[$xy],0,PHP_ROUND_HALF_UP);
					$totalnetoapagar+=round ($listanetoapagar[$xy],0,PHP_ROUND_HALF_UP);
					$totalccf+=round ($listaccf[$xy],0,PHP_ROUND_HALF_UP);
					$totalsena+=round ($listasena[$xy],0,PHP_ROUND_HALF_UP);
					$totalicbf+=round ($listaicbf[$xy],0,PHP_ROUND_HALF_UP);
					$totalinstecnicos+=round ($listainstecnicos[$xy],0,PHP_ROUND_HALF_UP);
					$totalesap+=round ($listaesap[$xy],0,PHP_ROUND_HALF_UP);
				}
			}
			$nomfuncionario=iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$listaempleados[$x]);
			$objPHPExcel->setActiveSheetIndex(1)
			->setCellValueExplicit ("A$i", $x+1, PHPExcel_Cell_DataType :: TYPE_NUMERIC)
			->setCellValueExplicit ("B$i", $listadocumentos[$x], PHPExcel_Cell_DataType :: TYPE_STRING)
			->setCellValueExplicit ("C$i", $nomfuncionario, PHPExcel_Cell_DataType :: TYPE_STRING)
			->setCellValueExplicit ("D$i", $listasalariobasico[$x], PHPExcel_Cell_DataType :: TYPE_NUMERIC)
			->setCellValueExplicit ("E$i", $totaldias, PHPExcel_Cell_DataType :: TYPE_NUMERIC)
			->setCellValueExplicit ("F$i", $totaldeven, PHPExcel_Cell_DataType :: TYPE_NUMERIC)
			->setCellValueExplicit ("G$i", $totalauxalim, PHPExcel_Cell_DataType :: TYPE_NUMERIC)
			->setCellValueExplicit ("H$i", $totalauxtrans, PHPExcel_Cell_DataType :: TYPE_NUMERIC)
			->setCellValueExplicit ("I$i", $totalotrospag, PHPExcel_Cell_DataType :: TYPE_NUMERIC)
			->setCellValueExplicit ("J$i", $totalrdevenga, PHPExcel_Cell_DataType :: TYPE_NUMERIC)
			->setCellValueExplicit ("K$i", $totalsumibc, PHPExcel_Cell_DataType :: TYPE_NUMERIC)
			->setCellValueExplicit ("L$i", $totalibcpara, PHPExcel_Cell_DataType :: TYPE_NUMERIC)
			->setCellValueExplicit ("M$i", $totalibcarl, PHPExcel_Cell_DataType :: TYPE_NUMERIC)
			->setCellValueExplicit ("N$i", $totalsumarl, PHPExcel_Cell_DataType :: TYPE_NUMERIC)
			->setCellValueExplicit ("O$i", $totalsaludempl, PHPExcel_Cell_DataType :: TYPE_NUMERIC)
			->setCellValueExplicit ("P$i", $totalsaludempr, PHPExcel_Cell_DataType :: TYPE_NUMERIC)
			->setCellValueExplicit ("Q$i", $totalsalud, PHPExcel_Cell_DataType :: TYPE_NUMERIC)
			->setCellValueExplicit ("R$i", round ($listapensionempleado[$ii],0,PHP_ROUND_HALF_UP), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
			->setCellValueExplicit ("S$i", round ($listapensionempresa[$ii],0,PHP_ROUND_HALF_UP), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
			->setCellValueExplicit ("T$i", round ($listapensiontotal[$ii],0,PHP_ROUND_HALF_UP), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
			->setCellValueExplicit ("U$i", round ($listafondosolidaridad[$ii],0,PHP_ROUND_HALF_UP), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
			->setCellValueExplicit ("V$i", 0, PHPExcel_Cell_DataType :: TYPE_NUMERIC)
			->setCellValueExplicit ("W$i", round ($listaotrasdeducciones[$ii],0,PHP_ROUND_HALF_UP), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
			->setCellValueExplicit ("X$i", round ($listatotaldeducciones[$ii],0,PHP_ROUND_HALF_UP), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
			->setCellValueExplicit ("Y$i", round ($listanetoapagar[$ii],0,PHP_ROUND_HALF_UP), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
			->setCellValueExplicit ("Z$i", round ($listaccf[$ii],0,PHP_ROUND_HALF_UP), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
			->setCellValueExplicit ("AA$i", round ($listasena[$ii],0,PHP_ROUND_HALF_UP), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
			->setCellValueExplicit ("AB$i", round ($listaicbf[$ii],0,PHP_ROUND_HALF_UP), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
			->setCellValueExplicit ("AC$i", round ($listainstecnicos[$ii],0,PHP_ROUND_HALF_UP), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
			->setCellValueExplicit ("AD$i",	round ($listaesap[$ii],0,PHP_ROUND_HALF_UP), PHPExcel_Cell_DataType :: TYPE_NUMERIC);
			$objPHPExcel->getActiveSheet()->getStyle("A$i:AD$i")->applyFromArray($borders);
			
			$i++;
		}
		$x++;
	}
	// hoja 3
	$objPHPExcel->createSheet(2);
	$objPHPExcel->setActiveSheetIndex(2);
	$objPHPExcel->getActiveSheet()->mergeCells('A1:E1');
	$objPHPExcel->getActiveSheet()->setCellValue('A1', 'APORTES PARAFISCALES');
	$objFont=$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont();
	$objFont->setName('Courier New'); 
	$objFont->setSize(15); 
	$objFont->setBold(true); 
	$objFont->setUnderline(PHPExcel_Style_Font::UNDERLINE_SINGLE);
	$objFont->getColor()->setARGB( PHPExcel_Style_Color::COLOR_BLACK);
	$objAlign=$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment(); 
	$objAlign->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
	$objAlign->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
	$objPHPExcel-> getActiveSheet ()
		-> getStyle ("A2:E2")	
        -> getFill ()
        -> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
        -> getStartColor ()
        -> setRGB ('A6E5F3');
	$objPHPExcel-> getActiveSheet ()
		-> getStyle ("A1")	
        -> getFill ()
        -> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
        -> getStartColor ()
        -> setRGB ('A6E5F3');
	$objPHPExcel->getActiveSheet()->getStyle('A2:E2')->applyFromArray($borders);
	$objPHPExcel->setActiveSheetIndex(2)
            ->setCellValue('A2', 'Cod.')
            ->setCellValue('B2', 'APORTES PARAFISCALES')
			->setCellValue('C2', 'PORCENTAJE')
            ->setCellValue('D2', 'VALOR')
			->setCellValue('E2', 'DESCRIPCION APORTE');
	$i=3;
	for($ii=0;$ii<count ($_POST[codpara]);$ii++)
	{
		if ($_POST[tipopara][$ii]=="A"){$tipoaporte="APORTES EMPRESA";}
		else{$tipoaporte="APORTE EMPLEADOS";}
		$objPHPExcel->setActiveSheetIndex(2)
		->setCellValueExplicit ("A$i", $_POST[codpara][$ii], PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("B$i", utf8_encode($_POST[codnpara][$ii]), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("C$i", $_POST[porpara][$ii], PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("D$i", round ($_POST[valpara][$ii],0,PHP_ROUND_HALF_UP), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("E$i", $tipoaporte, PHPExcel_Cell_DataType ::  TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getStyle("A$i:E$i")->applyFromArray($borders);
		$i++;
	}
	$objPHPExcel->setActiveSheetIndex(2)
	->setCellValueExplicit ("A$i", "--", PHPExcel_Cell_DataType :: TYPE_STRING)
	->setCellValueExplicit ("B$i", "SALUD ", PHPExcel_Cell_DataType :: TYPE_STRING)
	->setCellValueExplicit ("C$i", "4", PHPExcel_Cell_DataType :: TYPE_NUMERIC)
	->setCellValueExplicit ("D$i", round (array_sum($listasaludempleadog),0,PHP_ROUND_HALF_UP), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
	->setCellValueExplicit ("E$i", "APORTE EMPLEADOS", PHPExcel_Cell_DataType ::  TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getStyle("A$i:E$i")->applyFromArray($borders);
	$i++;
	$objPHPExcel->setActiveSheetIndex(2)
	->setCellValueExplicit ("A$i", "--", PHPExcel_Cell_DataType :: TYPE_STRING)
	->setCellValueExplicit ("B$i", "SALUD ", PHPExcel_Cell_DataType :: TYPE_STRING)
	->setCellValueExplicit ("C$i", "8.5", PHPExcel_Cell_DataType :: TYPE_NUMERIC)
	->setCellValueExplicit ("D$i", round (array_sum($listasaludempresag),0,PHP_ROUND_HALF_UP), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
	->setCellValueExplicit ("E$i", "APORTES EMPRESA", PHPExcel_Cell_DataType ::  TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getStyle("A$i:E$i")->applyFromArray($borders);
	$i++;
	$objPHPExcel->setActiveSheetIndex(2)
	->setCellValueExplicit ("A$i", "--", PHPExcel_Cell_DataType :: TYPE_STRING)
	->setCellValueExplicit ("B$i", "PENSION ", PHPExcel_Cell_DataType :: TYPE_STRING)
	->setCellValueExplicit ("C$i", "4", PHPExcel_Cell_DataType :: TYPE_NUMERIC)
	->setCellValueExplicit ("D$i", round (array_sum($listapensionempleadog),0,PHP_ROUND_HALF_UP), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
	->setCellValueExplicit ("E$i", "APORTE EMPLEADOS", PHPExcel_Cell_DataType ::  TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getStyle("A$i:E$i")->applyFromArray($borders);
	$i++;
	$objPHPExcel->setActiveSheetIndex(2)
	->setCellValueExplicit ("A$i", "--", PHPExcel_Cell_DataType :: TYPE_STRING)
	->setCellValueExplicit ("B$i", "PENSION ", PHPExcel_Cell_DataType :: TYPE_STRING)
	->setCellValueExplicit ("C$i", "12", PHPExcel_Cell_DataType :: TYPE_NUMERIC)
	->setCellValueExplicit ("D$i", round (array_sum($listapensionempresag),0,PHP_ROUND_HALF_UP), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
	->setCellValueExplicit ("E$i", "APORTES EMPRESA", PHPExcel_Cell_DataType ::  TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getStyle("A$i:E$i")->applyFromArray($borders);
	$i++;
	$objPHPExcel->setActiveSheetIndex(2)
	->setCellValueExplicit ("A$i", "--", PHPExcel_Cell_DataType :: TYPE_STRING)
	->setCellValueExplicit ("B$i", "fONDO SOLIRARIDAD ", PHPExcel_Cell_DataType :: TYPE_STRING)
	->setCellValueExplicit ("C$i", "--", PHPExcel_Cell_DataType :: TYPE_NUMERIC)
	->setCellValueExplicit ("D$i", round (array_sum($listafondosolidaridadg),0,PHP_ROUND_HALF_UP), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
	->setCellValueExplicit ("E$i", "APORTES EMPLEADOS", PHPExcel_Cell_DataType ::  TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getStyle("A$i:E$i")->applyFromArray($borders);
	$i++;
	
	//----Propiedades de la hoja 3
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->setTitle('Aportes');
	// hoja 4
	$objPHPExcel->createSheet(3);
	$objPHPExcel->setActiveSheetIndex(3);
	$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
	$objPHPExcel->getActiveSheet()->setCellValue('A1', 'APORTES PARAFISCALES');
	$objFont=$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont();
	$objFont->setName('Courier New'); 
	$objFont->setSize(15); 
	$objFont->setBold(true); 
	$objFont->setUnderline(PHPExcel_Style_Font::UNDERLINE_SINGLE);
	$objFont->getColor()->setARGB( PHPExcel_Style_Color::COLOR_BLACK);
	$objAlign=$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment(); 
	$objAlign->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
	$objAlign->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
	$objPHPExcel-> getActiveSheet ()
		-> getStyle ("A2:D2")	
        -> getFill ()
        -> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
        -> getStartColor ()
        -> setRGB ('A6E5F3');
	$objPHPExcel-> getActiveSheet ()
		-> getStyle ("A1")	
        -> getFill ()
        -> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
        -> getStartColor ()
        -> setRGB ('A6E5F3');
	$objPHPExcel->getActiveSheet()->getStyle('A2:D2')->applyFromArray($borders);
	$objPHPExcel->setActiveSheetIndex(3)
            ->setCellValue('A2', 'CUENTA')
            ->setCellValue('B2', 'NOMBRE CUENTA PRESUPUESTAL')
			->setCellValue('C2', 'VALOR')
            ->setCellValue('D2', 'SALDO');
	$i=3;
	for($ii=0;$ii<count ($_POST[rubrosp]);$ii++)
	{
		$objPHPExcel->setActiveSheetIndex(3)
		->setCellValueExplicit ("A$i", $_POST[rubrosp][$ii], PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("B$i", utf8_encode($_POST[nrubrosp][$ii]), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("C$i", $_POST[vrubrosp][$ii], PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("D$i", $_POST[vsaldo][$ii], PHPExcel_Cell_DataType :: TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getStyle("A$i:D$i")->applyFromArray($borders);
		$i++;
	}
	//----Propiedades de la hoja 4
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->setTitle('Presupuesto');
	
	
	$objPHPExcel->setActiveSheetIndex(0);

//----Guardar documento----
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Nomina.xls"');
header('Cache-Control: max-age=0');
 
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
$objWriter->save('php://output');
exit;

?>