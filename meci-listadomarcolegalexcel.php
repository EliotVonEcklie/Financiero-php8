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
		->setTitle("Informe Listado Marco Legal")
		->setSubject("Listado Marco Legal")
		->setDescription("Listado Marco Legal")
		->setKeywords("Listado Marco Legal")
		->setCategory("Meci Calidad");
	//----Cuerpo de Documento----
    $objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
    
    $linkbd=conectar_bd();
    $sqlr="select *from configbasica where estado='S'";
    $res=mysql_query($sqlr,$linkbd);
    while($row=mysql_fetch_row($res))
    {
        $nit=$row[0];
        $rs=$row[1];
    }
    
    $clase="MARCO LEGAL";

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1',$clase);
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
		-> getStyle ("A2:G2")
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
	$objPHPExcel->getActiveSheet()->getStyle('A2:G2')->applyFromArray($borders);
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A2', 'ITEM')
        ->setCellValue('B2', 'CLASE')
        ->setCellValue('C2', 'CATEGORÍA')
        ->setCellValue('D2', 'DESCRIPCIÓN')
        ->setCellValue('E2', 'FECHA')
        ->setCellValue('F2', 'DOCUMENTOS')
        ->setCellValue('G2', 'ESTADO');

    $i=3;
    $linkbd=conectar_bd();					
    $crit1=" ";
    $crit2=" ";

    if ($_POST[normativa]!=""){$crit1=" AND idnormativa='$_POST[normativa]' ";}
    if ($_POST[catenormativa]!=""){$crit2=" AND idcatenormativa='$_POST[catenormativa]'";}
    $sqlr="SELECT * FROM meciestructuraorg_marcolegal WHERE estado<>'' ".$crit1.$crit2." ORDER BY id DESC";
    $resp = mysql_query($sqlr,$linkbd);
    $con=1;
    while ($row =mysql_fetch_row($resp)) 
    {
        $sqlrdoc="SELECT nombre FROM mecivariables WHERE id='$row[2]'";
        $rowdoc =mysql_fetch_row(mysql_query($sqlrdoc,$linkbd));
        $sqlrcate="SELECT nombre FROM mecivariables WHERE id='$row[7]'";
        $rowcate =mysql_fetch_row(mysql_query($sqlrcate,$linkbd));

        switch($row[6])
        {
            case "S": 
                $imgsem="Vigente";
                
                $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValueExplicit ("A$i", $con, PHPExcel_Cell_DataType :: TYPE_NUMERIC)
                ->setCellValueExplicit ("B$i", iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$rowdoc[0]), PHPExcel_Cell_DataType :: TYPE_STRING)
                ->setCellValueExplicit ("C$i", iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$rowcate[0]), PHPExcel_Cell_DataType :: TYPE_STRING)
                ->setCellValueExplicit ("D$i", iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$row[4]), PHPExcel_Cell_DataType :: TYPE_STRING)
                ->setCellValueExplicit ("E$i", date("d-m-Y",strtotime($row[3])), PHPExcel_Cell_DataType :: TYPE_STRING)
                ->setCellValueExplicit ("F$i", $row[5], PHPExcel_Cell_DataType :: TYPE_STRING)
                ->setCellValueExplicit ("G$i", $imgsem, PHPExcel_Cell_DataType :: TYPE_STRING);
                $objPHPExcel->getActiveSheet()->getStyle("A$i:G$i")->applyFromArray($borders);
                $i++;
                $con+=1;
                break;
            case "N": 
                $imgsem="No Vigente";
                break;
            case "M": $clase="Objetivos";break;
            case "F": $clase="Marco Legal";break;
        }
    }
	
	//----Propiedades de la hoja 1
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true); 


	$objPHPExcel->getActiveSheet()->setTitle('ESTRUCTURA ORGANIZACIONAL MARCO LEGAL');

	$objPHPExcel->setActiveSheetIndex(0);

//----Guardar documento----
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="informe_listado.xls"');
header('Cache-Control: max-age=0');
 
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
$objWriter->save('php://output');
exit;

?>