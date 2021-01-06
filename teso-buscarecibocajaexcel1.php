<?php //V 1000 12/12/16 ?> 
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
	$objPHPExcel->getActiveSheet()->mergeCells('A1:B1');
	$objPHPExcel->setActiveSheetIndex(0)
            	->setCellValue('A1', 'Listado Facturas');
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
            ->setCellValue('A2', 'FACTURA')
            ->setCellValue('B2', 'CORTE')
          
	$linkbd=conectar_bd();
				$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
				$sqlr2="select *from tesoliquidapredial_det where tesoliquidapredial_det.idpredial=$_POST[idrecaudo] and estado ='S'  and 1=$_POST[tiporec]";
				$res2=mysql_query($sqlr2,$linkbd);
				$i=3;
				while ($row2 =mysql_fetch_row($res2))
				{
					$sqlr="select valor_inicial from dominios where nombre_dominio='COBRO_RECIBOS' AND descripcion_valor='$vigusu' and  tipo='S'";
					$res=mysql_query($sqlr,$linkbd);
					$row =mysql_fetch_row($res);
					$objPHPExcel->setActiveSheetIndex(0)
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,$row[0]);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,$row2[11]);
					$i++;
				}
	//----Propiedades de la hoja
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->setTitle('Listado Facturas');
	//----Guardar documento----
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="Listado Facturas.xls"');
	header('Cache-Control: max-age=0');
	$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
	$objWriter->save('php://output');
	exit;
?>