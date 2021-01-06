<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
    require_once 'PHPExcel/Classes/PHPExcel.php';
    require "comun.inc";
	require "funciones.inc";
    ini_set('max_execution_time',36000);
    $nombreTitulo = "Auxiliar de registros";
	$objPHPExcel = new PHPExcel();
	//----Propiedades----
	$objPHPExcel->getProperties()
		->setCreator("IDEAL")
		->setLastModifiedBy("IDEAL")
		->setTitle("$nombreTitulo")
		->setSubject("Presupuesto")
		->setDescription("Presupuesto")
		->setKeywords("Presupuesto")
        ->setCategory("Libros");
    
    $conexion = conectar_v7();
    $sqlr="select *from configbasica where estado='S'";
    $res=mysqli_query($conexion,$sqlr);
    while($row=mysqli_fetch_row($res))
    {
        $nit=$row[0];
        $rs=$row[1];
    }
    //PARTE VARIABLES PERSONALIZADAS PHP
    $abecedario=array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
    $letra = intval($_POST[cantColum1])-1;
    // FIN VARIABLES PERSONALIZADAS
	//----Cuerpo de Documento----
	

	$objPHPExcel->getActiveSheet()->mergeCells("A1:$abecedario[$letra]1");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $rs." - ".$nit);

    $objPHPExcel->getActiveSheet()->mergeCells("A2:$abecedario[$letra]2");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'AUXILIAR DE COMPROMISOS - Periodo: '.$_POST[fechai].' - '.$_POST[fechaf]);
    

	$objFont=$objPHPExcel->getActiveSheet()->getStyle('A1:A2')->getFont();
	$objFont->setName('Courier New');
	$objFont->setSize(15);
	$objFont->setBold(true);
	$objFont->setUnderline(PHPExcel_Style_Font::UNDERLINE_SINGLE);
	$objFont->getColor()->setARGB( PHPExcel_Style_Color::COLOR_BLACK);
	$objAlign=$objPHPExcel->getActiveSheet()->getStyle('A1:A2')->getAlignment(); 
	$objAlign->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objAlign->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$objPHPExcel-> getActiveSheet ()
		-> getStyle ("A3:$abecedario[$letra]3")
		-> getFill ()
		-> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
		-> getStartColor ()
		-> setRGB ('A6E5F3');
	$objPHPExcel-> getActiveSheet ()
		-> getStyle ("A1:A2")	
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
    $objPHPExcel->getActiveSheet()->getStyle("A3:$abecedario[$letra]3")->applyFromArray($borders);
    
    for($x=0; $x<=$letra;$x++)
    {
        $nombre = "titulo_".$x;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("$abecedario[$x]3", $_POST[$nombre][0]);
    }
    $i=4;
	for($ii=0;$ii<count($_POST['registro_0']);$ii++)
	{
        for($x=0; $x<=$letra;$x++)
        {
            $nombre_registro = "registro_".$x;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("$abecedario[$x]$i",iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[$nombre_registro][$ii]) , PHPExcel_Cell_DataType :: TYPE_STRING);
            $objPHPExcel->getActiveSheet()->getStyle("A$i:$abecedario[$x]$i")->applyFromArray($borders);
        }
		$i++;
	}
    //----Propiedades de la hoja 1
    for($x=0; $x<=$letra;$x++)
    {
        if($abecedario[$x] == 'G')
        {
            $objPHPExcel->getActiveSheet()->getColumnDimension("$abecedario[$x]")->setWidth('80');
        }
        else
        {
            $objPHPExcel->getActiveSheet()->getColumnDimension("$abecedario[$x]")->setAutoSize(true);
        }
    }
	$objPHPExcel->getActiveSheet()->setTitle('IDEAL');
	$objPHPExcel->setActiveSheetIndex(0);

//----Guardar documento----
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Auxiliar_compromisos".xlsx"');
header('Cache-Control: max-age=0');
 
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save('php://output');
exit;

?>