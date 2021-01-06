<?php  
ini_set('max_execution_time',3600);
require_once 'PHPExcel/Classes/PHPExcel.php';
require"comun.inc";
require"funciones.inc";
session_start();
$linkbd=conectar_bd();  
$objPHPExcel = new PHPExcel();

//----Propiedades----
$objPHPExcel->getProperties()
        ->setCreator("SPID")
        ->setLastModifiedBy("SPID")
        ->setTitle("Exportar Excel con PHP")
        ->setSubject("Documento de prueba")
        ->setDescription("Documento generado con PHPExcel")
        ->setKeywords("usuarios phpexcel")
        ->setCategory("reportes");

//----Cuerpo de Documento----
$objPHPExcel->getActiveSheet()->mergeCells('A1:L1');
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Formato - Plan Anual de Compras');

			
$objPHPExcel->getActiveSheet()
    ->getStyle('A1:L1')
    ->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()
    ->setARGB('22C6CB');
	
$objPHPExcel->getActiveSheet()
    ->getStyle('O1:P1')
    ->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()
    ->setARGB('22C6CB');
	
$objPHPExcel->getActiveSheet()
    ->getStyle('R1:S1')
    ->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()
    ->setARGB('22C6CB');
	
$borders = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
          'color' => array('argb' => 'FF000000'),
        )
      ),
    );
$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->applyFromArray($borders);
$objPHPExcel->getActiveSheet()->getStyle('A2:L2')->applyFromArray($borders);	
$objPHPExcel->getActiveSheet()->getStyle('O1:P1')->applyFromArray($borders);
$objPHPExcel->getActiveSheet()->getStyle('R1:S1')->applyFromArray($borders);

$objFont=$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont();
$objFont->setName('Courier New'); 
$objFont->setSize(15); 
$objFont->setBold(true); 
$objFont->setUnderline(PHPExcel_Style_Font::UNDERLINE_SINGLE);
$objFont->getColor()->setARGB( PHPExcel_Style_Color::COLOR_BLACK);

$objAlign=$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment(); 
$objAlign->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
$objAlign->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 

$objAlign=$objPHPExcel->getActiveSheet()->getStyle('O1')->getAlignment(); 
$objAlign->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
$objAlign->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 

$objAlign=$objPHPExcel->getActiveSheet()->getStyle('R1')->getAlignment(); 
$objAlign->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
$objAlign->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 


$objPHPExcel->getActiveSheet()->mergeCells('D2:E2');
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('D2', 'Duracion contrato (Dias/Meses)');	

$objPHPExcel->getActiveSheet()->mergeCells('O1:P1');
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('O1', 'Fuentes de Financiacion');	


$objPHPExcel->getActiveSheet()->mergeCells('R1:S1');
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('R1', 'Modalidad de Contratacion');



$objAlign=$objPHPExcel->getActiveSheet()->getStyle('O2:P2')->getAlignment(); 
$objAlign->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
$objAlign->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);


$objAlign=$objPHPExcel->getActiveSheet()->getStyle('R2:S2')->getAlignment(); 
$objAlign->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
$objAlign->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);


$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A2', 'Codigos UNSPSC')
			->setCellValue('B2', 'Descripcion')
            ->setCellValue('C2', 'Fecha estimada (DD/MM/YYYY)')
			->setCellValue('F2', 'Modalidad de seleccion')
			->setCellValue('G2', 'Fuente de recurso')
			->setCellValue('H2', 'Valor estimado')
			->setCellValue('I2', 'Valor vigencia actual')
			->setCellValue('J2', '¿Vigencias futuras?')
			->setCellValue('K2', 'Estado de solicitud vig. futuras')
			->setCellValue('L2', 'Contacto responsable');
					
$objFont=$objPHPExcel->getActiveSheet()->getStyle('A2:L2')->getFont();
$objFont->setName('Courier New'); 
$objFont->setSize(9); 
$objFont->setBold(true); 

$itera="";

$objPHPExcel->getActiveSheet()->getStyle('R1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('S1')->getAlignment()->setWrapText(true);
//**** Cabeza de celda
$objPHPExcel->getActiveSheet()->getStyle('R2')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('S2')->getAlignment()->setWrapText(true);
//**Subtitulos de celda
$objPHPExcel->getActiveSheet()->setCellValue('R2', 'Codigo');
$objPHPExcel->getActiveSheet()->setCellValue('S2', 'Abreviatura - Nombre');

 $sqlr="Select * from dominios  where nombre_dominio='ESTADO_VIGENCIASF'   order by valor_inicial asc";
 $resp = mysql_query($sqlr,$linkbd);
 while ($row =mysql_fetch_row($resp)) 
 {
	$itera.=($row[2].",");
 }
								 
$sql="Select * from dominios  where nombre_dominio='MODALIDAD_SELECCION' and (valor_final IS NULL or valor_final ='') AND (tipo='S' OR tipo='1') AND descripcion_dominio IS NOT NULL order by valor_inicial asc";
$res=mysql_query($sql,$linkbd);
$itera1="";
while($row = mysql_fetch_array($res)){
	$itera1.=($row[5].",");
}
$arregloMod=Array(substr($itera1,0,strlen($itera1)-1));


$sql="Select * from dominios  where nombre_dominio='MODALIDAD_SELECCION' and (valor_final IS NULL or valor_final ='') AND (tipo='S' OR tipo='1') AND descripcion_dominio IS NOT NULL order by valor_inicial asc";
$res=mysql_query($sql,$linkbd);
$numtotmod=mysql_num_rows($res);
$numtotmod=$numtotmod+2;

$i=2;
while($row = mysql_fetch_array($res)){
	$objPHPExcel->getActiveSheet()->setCellValue('R'.($i+1), $row[0]);
	$objPHPExcel->getActiveSheet()->setCellValue('S'.($i+1), $row[5]."-".$row[2]);
	$objPHPExcel->getActiveSheet()->getStyle('R'.$i.':S'.$i)->applyFromArray($borders);
	$objPHPExcel->getActiveSheet()->getStyle('R'.$i)->getAlignment()->setWrapText(true);
	$objPHPExcel->getActiveSheet()->getStyle('S'.$i)->getAlignment()->setWrapText(true);
	$i++;
}
$objPHPExcel->getActiveSheet()->getStyle('R'.$i.':S'.$i)->applyFromArray($borders);
$arregloVig=Array(substr($itera,0,strlen($itera)-1));
$arregloOpc=Array("SI,NO");
$sql="Select codigo,nombre from pptofutfuentefunc UNION Select * from pptofutfuenteinv order by CAST(codigo AS SIGNED INTEGER) asc";
$rest=mysql_query($sql,$linkbd);
$numtot=mysql_num_rows($rest);
$numtot=$numtot+3;
$i=2;
$objPHPExcel->getActiveSheet()->setCellValue('O2', 'Codigo');
$objPHPExcel->getActiveSheet()->setCellValue('P2', 'Nombre');
$objPHPExcel->getActiveSheet()
    ->getProtection()->setSheet(true);
while($row = mysql_fetch_array($rest)){
	$objPHPExcel->getActiveSheet()->setCellValue('O'.($i+1), $row[0]);
	$objPHPExcel->getActiveSheet()->setCellValue('P'.($i+1), $row[0]."-".$row[1]);
	$objPHPExcel->getActiveSheet()->getStyle('O'.$i.':P'.$i)->applyFromArray($borders);
	$objPHPExcel->getActiveSheet()->getStyle('A'.($i+1).':L'.($i+1))->applyFromArray($borders);
	$objPHPExcel->getActiveSheet()->getStyle('A'.($i+1).':L'.($i+1))
    ->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
	$objPHPExcel->getActiveSheet()->getStyle('O'.$i)->getAlignment()->setWrapText(true);
	$objPHPExcel->getActiveSheet()->getStyle('P'.$i)->getAlignment()->setWrapText(true);
	$objPHPExcel->getActiveSheet()->getStyle('A'.($i+1).':L'.($i+1))->getAlignment()->setWrapText(true);
	//------data validation Fuentes
	$objValidation = $objPHPExcel->getActiveSheet()->getCell('G'.($i+1))->getDataValidation();

	$objValidation->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );

	$objValidation->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );

	$objValidation->setAllowBlank(false);

	$objValidation->setShowInputMessage(true);

	$objValidation->setShowErrorMessage(true);

	$objValidation->setShowDropDown(true);

	$objValidation->setErrorTitle('Input error');

	$objValidation->setError('El valor no esta en la lista');

	$objValidation->setPromptTitle('Presiona la lista');

	$objValidation->setPrompt('Por favor, seleccionar un valor de la lista');

	$objValidation->setFormula1("'Plan de compras'!J$3:J$$numtot");
	
	//------data validation Vigencias fut
	$objValidationVig = $objPHPExcel->getActiveSheet()->getCell('K'.($i+1))->getDataValidation();

	$objValidationVig->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );

	$objValidationVig->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );

	$objValidationVig->setAllowBlank(false);

	$objValidationVig->setShowInputMessage(true);

	$objValidationVig->setShowErrorMessage(true);

	$objValidationVig->setShowDropDown(true);

	$objValidationVig->setErrorTitle('Input error');

	$objValidationVig->setError('El valor no esta en la lista');

	$objValidationVig->setPromptTitle('Presiona la lista');

	$objValidationVig->setPrompt('Por favor, seleccionar un valor de la lista');

	$objValidationVig->setFormula1('"'.implode('","', $arregloVig).'"');
	//------data validation Vigencias fut opciones
	$objValidationVig1 = $objPHPExcel->getActiveSheet()->getCell('J'.($i+1))->getDataValidation();

	$objValidationVig1->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );

	$objValidationVig1->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );

	$objValidationVig1->setAllowBlank(false);

	$objValidationVig1->setShowInputMessage(true);

	$objValidationVig1->setShowErrorMessage(true);

	$objValidationVig1->setShowDropDown(true);

	$objValidationVig1->setErrorTitle('Input error');

	$objValidationVig1->setError('El valor no esta en la lista');

	$objValidationVig1->setPromptTitle('Presiona la lista');

	$objValidationVig1->setPrompt('Por favor, seleccionar un valor de la lista');

	$objValidationVig1->setFormula1('"'.implode('","', $arregloOpc).'"');
	//------data validation Modalidad
		$objValidation = $objPHPExcel->getActiveSheet()->getCell('F'.($i+1))->getDataValidation();

	$objValidation->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );

	$objValidation->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );

	$objValidation->setAllowBlank(false);

	$objValidation->setShowInputMessage(true);

	$objValidation->setShowErrorMessage(true);

	$objValidation->setShowDropDown(true);

	$objValidation->setErrorTitle('Input error');

	$objValidation->setError('El valor no esta en la lista');

	$objValidation->setPromptTitle('Presiona la lista');

	$objValidation->setPrompt('Por favor, seleccionar un valor de la lista');

	$objValidation->setFormula1("'Plan de compras'!N$3:N$$numtotmod");
	//--Formato tipo texto de fecha
	$objPHPExcel->getActiveSheet()
    ->getStyle('C'.$i)
    ->getNumberFormat()
    ->setFormatCode(
        PHPExcel_Style_NumberFormat::FORMAT_TEXT
    );
	$i++;
}
$objPHPExcel->getActiveSheet()->getStyle('O'.$i.':P'.$i)->applyFromArray($borders);



//----Propiedades de la hoja
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(32);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(17);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(17);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(24);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(24);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(22); 
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(28); 
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(22);   
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(12); 
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(60); 
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(12); 
$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(60); 
$objPHPExcel->getActiveSheet()->setTitle('Plan de compras');
$objPHPExcel->setActiveSheetIndex(0);

//----Guardar documento----
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="plan-compras-import.xls"');
header('Cache-Control: max-age=0');
 
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
$objWriter->save('php://output');
exit;

?>