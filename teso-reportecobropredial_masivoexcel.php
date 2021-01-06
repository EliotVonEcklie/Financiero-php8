<?php  
//V 1000 12/12/2016
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
	$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
	$objPHPExcel->setActiveSheetIndex(0)
            	->setCellValue('A1', 'ESTADO DE CUENTA PREDIOS');
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
            ->setCellValue('A2', 'CODIGO CATASTRAL')
            ->setCellValue('B2', 'NOMBRE PROPIETARIO')
            ->setCellValue('C2', 'VIGENCIA')
			->setCellValue('D2', 'VALOR');
        
	$linkbd=conectar_bd();
	
	
	$varconta= count($_POST[dvigencias]);
	$ejem=2;
	$xx=1;
	$i=3;
	while ($xx < $varconta)
		{
			$sqlr="select distinct nombrepropietario from tesopredios where tesopredios.cedulacatastral=".$_POST[dcodcatas][$xx]." and tesopredios.estado='S'";
			$resp=mysql_query($sqlr,$linkbd);
			$rp=mysql_fetch_row($resp);
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValueExplicit ("A".$i, str_pad($_POST[dcodcatas][$xx],10,"0", STR_PAD_LEFT), PHPExcel_Cell_DataType :: TYPE_STRING);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,$rp[0]);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,$_POST[dvigencias][$xx]);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$i,$_POST[davaluos][$xx]);
			
			$i++;
			$xx++;
		}
		//----Propiedades de la hoja
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setTitle('Listado Facturas');
		//----Guardar documento----
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Listado Facturas.xls"');
		header('Cache-Control: max-age=0');
		$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
		$objWriter->save('php://output');
		exit;
?>