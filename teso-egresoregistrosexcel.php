<?php
require_once 'PHPExcel/Classes/PHPExcel.php';
require "comun.inc";
require "funciones.inc";
require "validaciones.inc";
ini_set('max_execution_time',36000);
session_start();
$linkbd=conectar_v7();
$objPHPExcel = new PHPExcel();

//----Propiedades----
$objPHPExcel->getProperties()
        ->setCreator("IDEAL10")
        ->setLastModifiedBy("IDEAL10")
        ->setTitle("Exportar Excel con PHP")
        ->setSubject("Documento")
        ->setDescription("Documento generado con PHPExcel")
        ->setKeywords("usuarios phpexcel")
        ->setCategory("reportes");

//----Cuerpo del Documento----
$objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'REGISTRO RPS-CDPS');

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
		-> getStyle ("A1")
        -> getFill ()
        -> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
        -> getStartColor ()
        -> setRGB ('A6E5F3');
	$objPHPExcel-> getActiveSheet ()
		-> getStyle ("A2:G2")
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
	$objPHPExcel->getActiveSheet()->getStyle('A2:G2')->applyFromArray($borders);
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A2', 'ITEM')
	->setCellValue('B2', 'VIGENCIA')
	->setCellValue('C2', 'N° RP')
	->setCellValue('D2', 'DETALLE')
	->setCellValue('E2', 'VALOR')
	->setCellValue('F2', 'SALDO')
	->setCellValue('G2', 'TERCERO');

	//----Información del Documento----
	$sqlr = "SELECT pptorp.vigencia,pptorp.consvigencia,pptocdp.objeto,pptorp.estado,pptocdp.consvigencia,pptorp.valor,pptorp.saldo, pptorp.tercero
		FROM pptorp, pptocdp
		WHERE pptorp.idcdp=pptocdp.consvigencia AND pptocdp.tipo_mov='201' AND pptorp.tipo_mov='201'
		AND pptorp.vigencia=$_POST[vigencia] and  pptocdp.vigencia=$_POST[vigencia]
		ORDER BY pptorp.consvigencia ASC";
	$resp = mysqli_query($linkbd, $sqlr);
	$i = 3;
	while ($row = mysqli_fetch_row($resp)){
		$saldoRP=generaSaldoRP($row[1],$_POST['vigencia']);
		if($saldoRP!=0){
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValueExplicit("A$i", $i-2, PHPExcel_Cell_DataType :: TYPE_NUMERIC)
			->setCellValueExplicit("B$i", $row[0], PHPExcel_Cell_DataType :: TYPE_NUMERIC)
			->setCellValueExplicit("C$i", $row[1], PHPExcel_Cell_DataType :: TYPE_NUMERIC)
			->setCellValueExplicit("D$i", iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT", $row[2]), PHPExcel_Cell_DataType :: TYPE_STRING)
			->setCellValueExplicit("E$i", $row[5], PHPExcel_Cell_DataType :: TYPE_NUMERIC)
			->setCellValueExplicit("F$i", $row[6], PHPExcel_Cell_DataType :: TYPE_NUMERIC)
			->setCellValueExplicit("G$i", $row[7], PHPExcel_Cell_DataType :: TYPE_NUMERIC);
			$objPHPExcel->getActiveSheet()->getStyle("A$i:G$i")->applyFromArray($borders);
			$i++;
		}
	}

	//----Propiedades de la hoja----
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->setTitle('REGISTROS');
	$objPHPExcel->setActiveSheetIndex(0);

	//----Guardar documento----
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="Reportes-RP-CDP.xls"');
	header('Cache-Control: max-age=0');

	$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
	$objWriter->save('php://output');
	exit;
?>
