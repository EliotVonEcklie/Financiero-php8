<?php
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
$objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Formato - Plan de Cuentas');

$objPHPExcel->getActiveSheet()
    ->getStyle('A1:G1')
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

$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->applyFromArray($borders);
$objPHPExcel->getActiveSheet()->getStyle('A2:G2')->applyFromArray($borders);

$objFont=$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont();
$objFont->setName('Courier New');
$objFont->setSize(15);
$objFont->setBold(true);
$objFont->setUnderline(PHPExcel_Style_Font::UNDERLINE_SINGLE);
$objFont->getColor()->setARGB( PHPExcel_Style_Color::COLOR_BLACK);

$objAlign=$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment();
$objAlign->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objAlign->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', 'Cuenta')
            ->setCellValue('B2', 'Nombre de la cuenta')
            ->setCellValue('C2', 'Tipo')
			->setCellValue('D2', 'Clasificacion')
			->setCellValue('E2', 'Regalias (S/N)')
			->setCellValue('F2', 'Causacion Contable (S/N)')
			->setCellValue('G2', 'Fuente');

//----Datos para validación----
$arrayType=Array("Mayor,Auxiliar");
$arrayClassification=Array("ingresos,funcionamiento,inversion,deuda");
$arrayRoyalties=Array("S,N");
$arrayCausation=Array("S,N");
$row=2;

//----Asignación de validación----
for ($i=0; $i < 600; $i++) {
	$objValidationType = $objPHPExcel->getActiveSheet()->getCell('C'.($row+1))->getDataValidation();
	$objValidationType->setType( PHPExcel_Cell_DataValidation::TYPE_LIST);
	$objValidationType->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
	$objValidationType->setAllowBlank(false);
	$objValidationType->setShowInputMessage(true);
	$objValidationType->setShowErrorMessage(true);
	$objValidationType->setShowDropDown(true);
	$objValidationType->setErrorTitle('Input error');
	$objValidationType->setError('El valor no esta en la lista');
	$objValidationType->setPromptTitle('Presiona la lista');
	$objValidationType->setPrompt('Por favor, seleccionar un valor de la lista');
	$objValidationType->setFormula1('"'.implode('","',$arrayType).'"');

	$objValidationClasi = $objPHPExcel->getActiveSheet()->getCell('D'.($row+1))->getDataValidation();
	$objValidationClasi->setType( PHPExcel_Cell_DataValidation::TYPE_LIST);
	$objValidationClasi->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
	$objValidationClasi->setAllowBlank(false);
	$objValidationClasi->setShowInputMessage(true);
	$objValidationClasi->setShowErrorMessage(true);
	$objValidationClasi->setShowDropDown(true);
	$objValidationClasi->setErrorTitle('Input error');
	$objValidationClasi->setError('El valor no esta en la lista');
	$objValidationClasi->setPromptTitle('Presiona la lista');
	$objValidationClasi->setPrompt('Por favor, seleccionar un valor de la lista');
	$objValidationClasi->setFormula1('"'.implode('","',$arrayClassification).'"');

	$objValidationRoyalties = $objPHPExcel->getActiveSheet()->getCell('E'.($row+1))->getDataValidation();
	$objValidationRoyalties->setType( PHPExcel_Cell_DataValidation::TYPE_LIST);
	$objValidationRoyalties->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
	$objValidationRoyalties->setAllowBlank(false);
	$objValidationRoyalties->setShowInputMessage(true);
	$objValidationRoyalties->setShowErrorMessage(true);
	$objValidationRoyalties->setShowDropDown(true);
	$objValidationRoyalties->setErrorTitle('Input error');
	$objValidationRoyalties->setError('El valor no esta en la lista');
	$objValidationRoyalties->setPromptTitle('Presiona la lista');
	$objValidationRoyalties->setPrompt('Por favor, seleccionar un valor de la lista');
	$objValidationRoyalties->setFormula1('"'.implode('","',$arrayRoyalties).'"');

	$objValidationCausation = $objPHPExcel->getActiveSheet()->getCell('F'.($row+1))->getDataValidation();
	$objValidationCausation->setType( PHPExcel_Cell_DataValidation::TYPE_LIST);
	$objValidationCausation->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
	$objValidationCausation->setAllowBlank(false);
	$objValidationCausation->setShowInputMessage(true);
	$objValidationCausation->setShowErrorMessage(true);
	$objValidationCausation->setShowDropDown(true);
	$objValidationCausation->setErrorTitle('Input error');
	$objValidationCausation->setError('El valor no esta en la lista');
	$objValidationCausation->setPromptTitle('Presiona la lista');
	$objValidationCausation->setPrompt('Por favor, seleccionar un valor de la lista');
	$objValidationCausation->setFormula1('"'.implode('","',$arrayCausation).'"');

	$row++;
}

//----Propiedades de la hoja
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setTitle('Adicion-Reduccion');
$objPHPExcel->setActiveSheetIndex(0);

//----Guardar documento----
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Presu-pptocuentas-import.xls"');
header('Cache-Control: max-age=0');

$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
$objWriter->save('php://output');
exit;

?>