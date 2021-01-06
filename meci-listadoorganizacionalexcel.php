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
		->setTitle("Informe Listado Estructura Organizacional")
		->setSubject("Listado Estructura Organizacional")
		->setDescription("Listado Estructura Organizacional")
		->setKeywords("Listado Estructura Organizacional")
		->setCategory("Meci Calidad");
	//----Cuerpo de Documento----
    $objPHPExcel->getActiveSheet()->mergeCells('A1:F1');
    
    $linkbd=conectar_bd();
    $sqlr="select *from configbasica where estado='S'";
    $res=mysql_query($sqlr,$linkbd);
    while($row=mysql_fetch_row($res))
    {
        $nit=$row[0];
        $rs=$row[1];
    }
    $clase = $_POST[proceso];
    switch($_POST[proceso])
    {
        case "TODO": $clase="TODOS";break;
        case "VIS": $clase="VISIÓN";break;
        case "MIS": $clase="MISIÓN";break;
        case "PCL": $clase="POLITICA DE CALIDAD";break;
        case "OBJ": $clase="OBJETIVOS";break;
    }

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
		-> getStyle ("A2:F2")
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
	$objPHPExcel->getActiveSheet()->getStyle('A2:F2')->applyFromArray($borders);

    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A2', 'ITEM')
        ->setCellValue('B2', 'CLASE')
        ->setCellValue('C2', 'DESCRIPCIÓN')
        ->setCellValue('D2', 'VERSIÓN')
        ->setCellValue('E2', 'FECHA')
        ->setCellValue('F2', 'ESTADO');
    $i=3;
    $linkbd=conectar_bd();					
    $crit1=" ";
    if($_POST[proceso]!="TODO")
    {
        
        if ($_POST[proceso]!="TODO"){$crit1=" AND clase='$_POST[proceso]' ";}
        $sqlr="SELECT * FROM meciestructuraorg WHERE estado<>'' ".$crit1." ORDER BY id DESC";
        $resp = mysql_query($sqlr,$linkbd);
        $ntr = mysql_num_rows($resp);
        $con=1;
        while ($row =mysql_fetch_row($resp)) 
        {
            switch($row[1])
            {
                case "VIS": $clase="Visión";break;
                case "MIS": $clase="Misión";break;
                case "PCL": $clase="Politica de Calidad";break;
                case "OBJ": $clase="Objetivos";break;
            }
            if($row[5]=='S')
            {
                $imgsem="Activo";
                $desc = substr(ucwords(strtolower(str_replace("&lt;br/&gt;","\n",$row[4]))), 0, 80);

                $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValueExplicit ("A$i", $con, PHPExcel_Cell_DataType :: TYPE_NUMERIC)
                ->setCellValueExplicit ("B$i", $clase, PHPExcel_Cell_DataType :: TYPE_STRING)
                ->setCellValueExplicit ("C$i", iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$desc), PHPExcel_Cell_DataType :: TYPE_STRING)
                ->setCellValueExplicit ("D$i", $row[2], PHPExcel_Cell_DataType :: TYPE_STRING)
                ->setCellValueExplicit ("E$i", date("d-m-Y",strtotime($row[3])), PHPExcel_Cell_DataType :: TYPE_STRING)
                ->setCellValueExplicit ("F$i", $imgsem, PHPExcel_Cell_DataType :: TYPE_STRING);
                $objPHPExcel->getActiveSheet()->getStyle("A$i:F$i")->applyFromArray($borders);
                $i++;
                $con+=1;
            }
            else
            {
                $imgsem="Inactivo";
            }

        }       
    }else{

        $sqlr="SELECT * FROM meciestructuraorg WHERE estado<>'' ORDER BY clase DESC";
        $resp = mysql_query($sqlr,$linkbd);
        $ntr = mysql_num_rows($resp);
        $con=1;
        while ($row =mysql_fetch_row($resp)) 
        {
            switch($row[1])
            {
                case "VIS": $clase="Visión";break;
                case "MIS": $clase="Misión";break;
                case "PCL": $clase="Politica de Calidad";break;
                case "OBJ": $clase="Objetivos";break;
            }
            if($row[5]=='S')
            {
                $imgsem="Activo";
                $desc = substr(ucwords(strtolower(str_replace("&lt;br/&gt;","\n",$row[4]))), 0, 80);

                $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValueExplicit ("A$i", $con, PHPExcel_Cell_DataType :: TYPE_NUMERIC)
                ->setCellValueExplicit ("B$i", $clase, PHPExcel_Cell_DataType :: TYPE_STRING)
                ->setCellValueExplicit ("C$i", iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$desc), PHPExcel_Cell_DataType :: TYPE_STRING)
                ->setCellValueExplicit ("D$i", $row[2], PHPExcel_Cell_DataType :: TYPE_STRING)
                ->setCellValueExplicit ("E$i", date("d-m-Y",strtotime($row[3])), PHPExcel_Cell_DataType :: TYPE_STRING)
                ->setCellValueExplicit ("F$i", $imgsem, PHPExcel_Cell_DataType :: TYPE_STRING);
                $objPHPExcel->getActiveSheet()->getStyle("A$i:F$i")->applyFromArray($borders);
                $i++;
                $con+=1;
            }
            else
            {
                $imgsem="Inactivo";
            }

        }
    }
	
	//----Propiedades de la hoja 1
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true); 

	$objPHPExcel->getActiveSheet()->setTitle('ESTRUCTURA ORGANIZACIONAL');

	$objPHPExcel->setActiveSheetIndex(0);

//----Guardar documento----
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="informe_listado_organizacional.xls"');
header('Cache-Control: max-age=0');
 
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
$objWriter->save('php://output');
exit;

?>