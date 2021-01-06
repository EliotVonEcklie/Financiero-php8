<?php  
	require_once 'PHPExcel/Classes/PHPExcel.php';
	require "comun.inc";
	require "funciones.inc";
	session_start();
	$linkbd=conectar_v7();  
	$objPHPExcel = new PHPExcel();
	//----Propiedades----
	$objPHPExcel->getProperties()
        ->setCreator("SPID")
        ->setLastModifiedBy("SPID")
        ->setTitle("Reporte Ejecucion Presupuestal Gastos")
        ->setSubject("Presupuesto")
        ->setDescription("Presupuesto")
        ->setKeywords("Presupuesto")
        ->setCategory("Presupuesto");
	//----Cuerpo de Documento----
	$objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Ejecucion presupuestal gastos');

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
		-> getStyle ("A2:H2")	
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
	
	$styleArray = array(
		"font"  => array(
		"bold" => false,
		"color" => array("rgb" => "FF0000"),
		"size"  => 12,
		"name" => "Verdana"
		));
	$objPHPExcel->getActiveSheet()->getStyle('A2:H2')->applyFromArray($borders);
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A2', 'MEDIO PAGO')
	->setCellValue('B2', 'UNIDAD')
	->setCellValue('C2', 'FUENTE')
	->setCellValue('D2', 'CODIGO')
	->setCellValue('E2', 'PROGRAMATICO')
	->setCellValue('F2', 'BIENES/SERVICIOS')
	->setCellValue('G2', 'NOMBRE')
	->setCellValue('H2', 'PRESUPUESTO INICIAL');
	
	$i=3;
	//echo count($_POST[codigo])."holaaa";
	$crit = '';
    if($_POST['unidadEjecutora'] != ''){
        $crit = "AND unidad = '$_POST[unidadEjecutora]'";
    }

    $crit1 = '';
    if($_POST['medioDePago'] != ''){
        $crit1 = "AND medioPago = '$_POST[medioDePago]'";
	}

	$critinv1 = '';
    if($_POST['medioDePago'] != ''){
        $critinv1 = "AND medio_pago = '$_POST[medioDePago]'";
	}

    for($xx=0; $xx<count($_POST[codigo]); $xx++)
    {
        $objPHPExcel->setActiveSheetIndex(0)
		->setCellValueExplicit ("D$i", $_POST[codigo][$xx], PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("G$i", $_POST[nombre][$xx], PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("H$i", $_POST[valor][$xx], PHPExcel_Cell_DataType :: TYPE_NUMERIC);
		if($_POST[tipo][$xx] == 'A'){
			$objPHPExcel->getActiveSheet()->getStyle("A$i:H$i")->getFont()->setBold(true);
		}else{
			$objPHPExcel->getActiveSheet()->getStyle("A$i:H$i");
		}

		$sqlr = "SELECT fuente, medioPago, subclase, unidad, valor FROM ccpetinicialigastosbienestransportables WHERE cuenta = '".$_POST[codigo][$xx]."' AND vigencia='$_POST[vigencia]' $crit $crit1";
		$result = mysqli_query($linkbd, $sqlr);
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_array($result)){
				$sqlr_fuente = "SELECT fuente_financiacion FROM ccpet_fuentes WHERE id_fuente = '$row[0]'";
				$result_fuente = mysqli_query($linkbd, $sqlr_fuente);
				$row_fuente = mysqli_fetch_array($result_fuente);

				$sqlr_bienes = "SELECT titulo FROM ccpetbienestransportables WHERE grupo = '$row[2]'";
				$result_bienes = mysqli_query($linkbd, $sqlr_bienes);
				$row_bienes = mysqli_fetch_array($result_bienes);

				$sqlr_unidad = "SELECT nombre FROM pptouniejecu WHERE id_cc = '$row[3]'";
				$result_unidad = mysqli_query($linkbd, $sqlr_unidad);
				$row_unidad = mysqli_fetch_array($result_unidad);
				$i++;
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueExplicit ("A$i", $row[1], PHPExcel_Cell_DataType :: TYPE_STRING)
				->setCellValueExplicit ("B$i", $row[3] .' - '. $row_unidad[0], PHPExcel_Cell_DataType :: TYPE_STRING)
				->setCellValueExplicit ("C$i", $row[0] .' - '. $row_fuente[0], PHPExcel_Cell_DataType :: TYPE_STRING)
				->setCellValueExplicit ("D$i", $_POST[codigo][$xx], PHPExcel_Cell_DataType :: TYPE_STRING)
				->setCellValueExplicit ("E$i", '', PHPExcel_Cell_DataType :: TYPE_STRING)
				->setCellValueExplicit ("F$i", $row[2], PHPExcel_Cell_DataType :: TYPE_STRING)
				->setCellValueExplicit ("G$i", $row_bienes[0], PHPExcel_Cell_DataType :: TYPE_STRING)
				->setCellValueExplicit ("H$i", $row[4], PHPExcel_Cell_DataType :: TYPE_NUMERIC);
				$objPHPExcel->getActiveSheet()->getStyle("A$i:H$i")->applyFromArray($styleArray);

				//$objPHPExcel-> getActiveSheet()->getStyle ("A$i:H$i")-> getStartColor ()-> setRGB ('A6E5F3');
			}

		}

		$sqlr = "SELECT fuente, medioPago, subclase, unidad, valor FROM ccpetinicialservicios WHERE cuenta = '".$_POST[codigo][$xx]."' AND vigencia='$_POST[vigencia]' $crit $crit1";
		$result = mysqli_query($linkbd, $sqlr);
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_array($result)){
				$sqlr_fuente = "SELECT fuente_financiacion FROM ccpet_fuentes WHERE id_fuente = '$row[0]'";
				$result_fuente = mysqli_query($linkbd, $sqlr_fuente);
				$row_fuente = mysqli_fetch_array($result_fuente);

				$sqlr_bienes = "SELECT titulo FROM ccpetservicios WHERE grupo = '$row[2]'";
				$result_bienes = mysqli_query($linkbd, $sqlr_bienes);
				$row_bienes = mysqli_fetch_array($result_bienes);

				$sqlr_unidad = "SELECT nombre FROM pptouniejecu WHERE id_cc = '$row[3]'";
				$result_unidad = mysqli_query($linkbd, $sqlr_unidad);
				$row_unidad = mysqli_fetch_array($result_unidad);
				$i++;
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueExplicit ("A$i", $row[1], PHPExcel_Cell_DataType :: TYPE_STRING)
				->setCellValueExplicit ("B$i", $row[3] .' - '. $row_unidad[0], PHPExcel_Cell_DataType :: TYPE_STRING)
				->setCellValueExplicit ("C$i", $row[0] .' - '. $row_fuente[0], PHPExcel_Cell_DataType :: TYPE_STRING)
				->setCellValueExplicit ("D$i", $_POST[codigo][$xx], PHPExcel_Cell_DataType :: TYPE_STRING)
				->setCellValueExplicit ("E$i", '', PHPExcel_Cell_DataType :: TYPE_STRING)
				->setCellValueExplicit ("F$i", $row[2], PHPExcel_Cell_DataType :: TYPE_STRING)
				->setCellValueExplicit ("G$i", $row_bienes[0], PHPExcel_Cell_DataType :: TYPE_STRING)
				->setCellValueExplicit ("H$i", $row[4], PHPExcel_Cell_DataType :: TYPE_NUMERIC);
				$objPHPExcel->getActiveSheet()->getStyle("A$i:H$i")->applyFromArray($styleArray);

				//$objPHPExcel-> getActiveSheet()->getStyle ("A$i:H$i")-> getStartColor ()-> setRGB ('A6E5F3');
			}
		}

		$sqlr = "SELECT fuente, medioPago, unidad, valor FROM ccpetinicialvalorgastos WHERE cuenta = '".$_POST[codigo][$xx]."' AND vigencia='$_POST[vigencia]' $crit $crit1";
		$result = mysqli_query($linkbd, $sqlr);
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_array($result)){
				$sqlr_fuente = "SELECT fuente_financiacion FROM ccpet_fuentes WHERE id_fuente = '$row[0]'";
				$result_fuente = mysqli_query($linkbd, $sqlr_fuente);
				$row_fuente = mysqli_fetch_array($result_fuente);

				$sqlr_unidad = "SELECT nombre FROM pptouniejecu WHERE id_cc = '$row[2]'";
				$result_unidad = mysqli_query($linkbd, $sqlr_unidad);
				$row_unidad = mysqli_fetch_array($result_unidad);
				$i++;
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueExplicit ("A$i", $row[1], PHPExcel_Cell_DataType :: TYPE_STRING)
				->setCellValueExplicit ("B$i", $row[2] .' - '. $row_unidad[0], PHPExcel_Cell_DataType :: TYPE_STRING)
				->setCellValueExplicit ("C$i", $row[0] .' - '. $row_fuente[0], PHPExcel_Cell_DataType :: TYPE_STRING)
				->setCellValueExplicit ("D$i", $_POST[codigo][$xx], PHPExcel_Cell_DataType :: TYPE_STRING)
				->setCellValueExplicit ("E$i", '', PHPExcel_Cell_DataType :: TYPE_STRING)
				->setCellValueExplicit ("F$i", '', PHPExcel_Cell_DataType :: TYPE_STRING)
				->setCellValueExplicit ("G$i", '', PHPExcel_Cell_DataType :: TYPE_STRING)
				->setCellValueExplicit ("H$i", $row[3], PHPExcel_Cell_DataType :: TYPE_NUMERIC);
				$objPHPExcel->getActiveSheet()->getStyle("A$i:H$i")->applyFromArray($styleArray);

				//$objPHPExcel-> getActiveSheet()->getStyle ("A$i:H$i")-> getStartColor ()-> setRGB ('A6E5F3');
			}
		}

		//$sqlr = "SELECT fuente, medioPago, unidad, valor FROM ccpetinicialvalorgastos WHERE cuenta = '".$_POST[codigo][$xx]."' AND vigencia='$_POST[vigencia]' $crit $crit1";

		$sqlr = "SELECT id_fuente, medio_pago, subproducto, codigocuin, valorcsf, valorssf, subclase FROM ccpproyectospresupuesto_presupuesto WHERE rubro = '".$_POST[codigo][$xx]."' AND codproyecto='".$_POST[idproyecto][$xx]."' $critinv1";//echo $sqlr."<br>";
		$result = mysqli_query($linkbd, $sqlr);
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_array($result)){
				$i++;
				if($row[1] == 'CSF'){
					$valor = $row[4];
				}else{
					$valor = $row[5];
				}
				$sqlr_fuente = "SELECT fuente_financiacion FROM ccpet_fuentes WHERE id_fuente = '$row[0]'";
				$result_fuente = mysqli_query($linkbd, $sqlr_fuente);
				$row_fuente = mysqli_fetch_array($result_fuente);

				$sqlr_unidad = "SELECT nombre FROM pptouniejecu WHERE id_cc = '".$_POST[unidad][$xx]."'";
				$result_unidad = mysqli_query($linkbd, $sqlr_unidad);
				$row_unidad = mysqli_fetch_array($result_unidad);

				$sqlr_cuin = "SELECT nombre FROM ccpet_cuin WHERE codigo_cuin = '$row[3]'";
				$result_cuin = mysqli_query($linkbd, $sqlr_cuin);
				$row_cuin = mysqli_fetch_array($result_cuin);
				$nombreCuinProducto = $row_cuin[0];
				$sqlr_bienes = "SELECT titulo FROM ccpetbienestransportables WHERE grupo = '$row[2]'";
				$result_bienes = mysqli_query($linkbd, $sqlr_bienes);
				$row_bienes = mysqli_fetch_array($result_bienes);
				$codigoProducto = $row[2];
				if($row_bienes[0] == ''){
					$sqlr_bienes = "SELECT titulo FROM ccpetservicios WHERE grupo = '$row[6]'";
					$result_bienes = mysqli_query($linkbd, $sqlr_bienes);
					$row_bienes = mysqli_fetch_array($result_bienes);
					$codigoProducto = $row[6];
				}

				if($nombreCuinProducto == ''){
					$nombreCuinProducto = $row_bienes[0];
				}

				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueExplicit ("A$i", $row[1], PHPExcel_Cell_DataType :: TYPE_STRING)
				->setCellValueExplicit ("B$i", $_POST[unidad][$xx] .' - '. $row_unidad[0], PHPExcel_Cell_DataType :: TYPE_STRING)
				->setCellValueExplicit ("C$i", $row[0] .' - '. $row_fuente[0], PHPExcel_Cell_DataType :: TYPE_STRING)
				->setCellValueExplicit ("D$i", $_POST[codigo][$xx], PHPExcel_Cell_DataType :: TYPE_STRING)
				->setCellValueExplicit ("E$i", $codigoProducto, PHPExcel_Cell_DataType :: TYPE_STRING)
				->setCellValueExplicit ("F$i", $row[3], PHPExcel_Cell_DataType :: TYPE_STRING)
				->setCellValueExplicit ("G$i", $nombreCuinProducto, PHPExcel_Cell_DataType :: TYPE_STRING)
				->setCellValueExplicit ("H$i", $valor, PHPExcel_Cell_DataType :: TYPE_NUMERIC);
				$objPHPExcel->getActiveSheet()->getStyle("A$i:H$i")->applyFromArray($styleArray);
			}
		}
		$i++;
    }
		
	//----Propiedades de la hoja 1
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth('15');
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth('15');
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth('50');
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->setTitle('EJECUCION');
	$objPHPExcel->setActiveSheetIndex(0);

//----Guardar documento----
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="REPORTE EJECUCION GASTOS.xls"');
header('Cache-Control: max-age=0');
 
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
$objWriter->save('php://output');
exit;

?>