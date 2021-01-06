<?php //V 1000 12/12/16 ?> 
<?php 
	require_once '/PHPExcel/Classes/PHPExcel.php';// Incluir la libreria PHPExcel
	include '/PHPExcel/Classes/PHPExcel/IOFactory.php';// PHPExcel_IOFactory
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	if($_POST[tinforme]==''){$titulo1="Listado General";}
	elseif($_POST[tinforme]=='1'){$titulo1="Listado Tareas Internas";}
	else{$titulo1="Listado Tareas Externas";}
	switch($_POST[testado])
	{ 
		case '':	$titulo2="Todos Los Estados";break;
		case 'LN':	$titulo2="Solo Lectura Sin Ver";break;
		case 'LS':	$titulo2="Solo Lectura Vistos";break;
		case 'AN':	$titulo2="Para Constestar";break;
		case 'AC':	$titulo2="Contestadas";break;
		case 'AR':	$titulo2="Redirigidas";break;
		case 'AV':	$titulo2="Vencidas";break;
		case 'CN':	$titulo2="Consultas Sin Contestas";break;
		case 'CS':	$titulo2="Consultas Sin Contestas";break;
	}
	if ($_POST[fechaini]!="" && $_POST[fechafin]!=""){$titulo3="Fecha Inicial: $_POST[fechaini] - Fecha Final: $_POST[fechafin]";}
	else{$titulo3="Sin Rango Definido";}
	$objPHPExcel = new PHPExcel();// Crea un nuevo objeto PHPExcel
	$objPHPExcel->getProperties()->setCreator("G&C Tecnoinversiones SAS")
	   ->setLastModifiedBy("HAFR")
	   ->setTitle("Lista Tareas Asignadas")
	   ->setSubject("Planeacion Extrategica")
	   ->setDescription("Planeacion Extrategica")
	   ->setKeywords("Planeacion Extrategica")
	   ->setCategory("Planeacion Extrategica");
	$objPHPExcel->setActiveSheetIndex(0)
		->mergeCells('A1:I1')
		->mergeCells('A2:I2')
		->mergeCells('A3:A4')
		->mergeCells('B3:B4')
		->mergeCells('C3:C4')
		->mergeCells('D3:D4')
		->mergeCells('E3:E4')
		->mergeCells('F3:F4')
		->mergeCells('G3:H3')
		->mergeCells('I3:I4')
  		->setCellValue('A1', 'LISTA DE TAREAS ASIGNADAS')
     	->setCellValue('A2', "$titulo1 - $titulo2 - $titulo3");
	$objPHPExcel-> getActiveSheet ()
        -> getStyle ("A1")
        -> getFill ()
        -> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
        -> getStartColor ()
        -> setRGB ('C8C8C8');
	$objPHPExcel-> getActiveSheet ()
        -> getStyle ("A1:A2")
		-> getFont ()
		-> setBold ( true ) 
      	-> setName ( 'Verdana' ) 
      	-> setSize ( 10 ) 
		-> getColor ()
		-> setRGB ('000000');
	$objPHPExcel-> getActiveSheet ()	
		-> getStyle ('A1:A2')
		-> getAlignment ()
		-> applyFromArray (array ( 'horizontal'  =>  PHPExcel_Style_Alignment :: HORIZONTAL_CENTER ,) ); 
	$objPHPExcel-> getActiveSheet ()	
		-> getStyle ('A3:I3')
		-> getAlignment ()
		-> applyFromArray (array ( 'horizontal'  =>  PHPExcel_Style_Alignment :: HORIZONTAL_CENTER ,) )
		-> applyFromArray (array ( 'vertical'  =>  PHPExcel_Style_Alignment :: VERTICAL_JUSTIFY ,) );  
	$objPHPExcel-> getActiveSheet ()
		-> getStyle ("A2")
        -> getFill ()
        -> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
        -> getStartColor ()
        -> setRGB ('A6E5F3');
	$objPHPExcel-> getActiveSheet ()
		-> getStyle ("A3:I3")
        -> getFill ()
        -> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
        -> getStartColor ()
        -> setRGB ('2335FF');
	$objPHPExcel-> getActiveSheet ()
		-> getStyle ("G4:H4")
        -> getFill ()
        -> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
        -> getStartColor ()
        -> setRGB ('2335FF');
	$borders = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
          'color' => array('argb' => 'FF000000'),
        )
      ),
    );
	$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->applyFromArray($borders);
	$objPHPExcel->getActiveSheet()->getStyle('A2:I2')->applyFromArray($borders);
	$objPHPExcel->getActiveSheet()->getStyle('A3:A4')->applyFromArray($borders);
	$objPHPExcel->getActiveSheet()->getStyle('B3:B4')->applyFromArray($borders);
	$objPHPExcel->getActiveSheet()->getStyle('C3:C4')->applyFromArray($borders);
	$objPHPExcel->getActiveSheet()->getStyle('D3:D4')->applyFromArray($borders);
	$objPHPExcel->getActiveSheet()->getStyle('E3:E4')->applyFromArray($borders);
	$objPHPExcel->getActiveSheet()->getStyle('F3:F4')->applyFromArray($borders);
	$objPHPExcel->getActiveSheet()->getStyle('G3:H3')->applyFromArray($borders);
	$objPHPExcel->getActiveSheet()->getStyle('G4:H4')->applyFromArray($borders);
	$objPHPExcel->getActiveSheet()->getStyle('I3:I4')->applyFromArray($borders);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('A')->setWidth(12); 
	$objPHPExcel-> getActiveSheet()->getColumnDimension('B')->setWidth(14);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('C')->setWidth(14);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('D')->setWidth(14);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('E')->setWidth(40);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('F')->setWidth(45);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('G')->setWidth(14);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('H')->setWidth(14);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('i')->setWidth(15);
	$objWorksheet = $objPHPExcel->getActiveSheet();
	$objWorksheet->fromArray(array(utf8_encode('Radicación'),"Fecha \nRadicado","Fecha \nVencimiento",'Fecha Respuesta','Asignada Por',utf8_encode('Descripción'),'Estado','','Concluida'),NULL,'A3');
	$objWorksheet->fromArray(array("Usuario","Tarea"),NULL,'G4');
	$cont=5;
	if ($_POST[fechaini]!="" && $_POST[fechafin]!="")
	{$crit4=" AND TB1.fechasig BETWEEN CAST('$_POST[fechaini]' AS DATE) AND CAST('$_POST[fechafin]' AS DATE)";}
	switch($_POST[tinforme])
	{
		case "":	$crit1="";break;
		case "1":	$crit1=" AND TB1.tipot='1'";break;
		case "0":	$crit1=" AND TB1.tipot='0'";break;
	}
	switch($_POST[testado])
	{
		case "":	$crit2="";break;
		case "LN":	$crit2=" AND TB1.estado='LN'";break;
		case "LS":	$crit2=" AND TB1.estado='LS'";break;
		case "AN":	$crit2=" AND TB1.estado='AN'";break;
		case "AC":	$crit2=" AND TB1.estado='AC'";break;
		case "AR":	$crit2=" AND TB1.estado='AR'";break;
		case "CN":	$crit2=" AND TB1.estado='CN'";break;
		case "CC":	$crit2=" AND TB1.estado='CC'";break;
		case "AV":	$crit2=" AND (TB2.fechalimite <> '0000-00-00' AND (TB1.estado='AN' AND (TB2.fechalimite <= CURDATE())) OR ((TB1.estado='AC') AND (TB2.fechalimite <= TB1.fechares)))";
	}
	if($_POST[nradicacion]!=""){$crit3=" AND TB2.codigobarras LIKE '%$_POST[nradicacion]%'";}
	else{$crit3="";}
	$sqlr="SELECT TB1.*,TB2.numeror,TB2.fechalimite,TB2.descripcionr,TB2.codigobarras,TB2.estado,TB2.estado2 FROM planacresponsables TB1, planacradicacion TB2 WHERE TB1.codradicacion=TB2.numeror AND TB1.usuariocon='$_SESSION[cedulausu]' $crit1 $crit2 $crit3 $crit4 ORDER BY TB1.codigo DESC";
	$res=mysql_query($sqlr,$linkbd);
	while ($row = mysql_fetch_row($res)) 
	{
		$nresul=buscaresponsable($row[4]);
		switch($row[19])
		{
			
			case "AC":	if($row[16]!="0000-00-00")
						{
							$imgcon="Concluida";
							$fecha01=explode('-',date('d-m-Y',strtotime($row[3])));
							$fecha01g=gregoriantojd($fecha01[1],$fecha01[0],$fecha01[2]);
							$fecha02=explode('-',date('d-m-Y',strtotime($row[16])));
							$fecha02g=gregoriantojd($fecha02[1],$fecha02[0],$fecha02[2]);
							if($fecha02g<=$fecha01g){$imgtar="Vencida";}
							else {$imgtar="Contestada";}
							$feclim=date('d-m-Y',strtotime($row[16]));
						}
						else
						{
							$imgcon="Concluida";
							$feclim="Sin Limite";
							$imgtar="Contestada";
						}
						break;
			case "AN":	if($row[16]!="0000-00-00")
						{
							$imgcon="Activa";
							$fecha01=explode('-',date("d-m-Y"));
							$fecha01g=gregoriantojd($fecha01[1],$fecha01[0],$fecha01[2]);
							$fecha02=explode('-',date('d-m-Y',strtotime($row[16])));
							$fecha02g=gregoriantojd($fecha02[1],$fecha02[0],$fecha02[2]);
							if($fecha02g<=$fecha01g)
							{$imgtar="Vencida";}
							else {$imgtar="Pendiente";}
							$feclim=date('d-m-Y',strtotime($row[16]));
						}
						else
						{
							$imgcon="Activa";
							$feclim="Sin Limite";
							$imgtar="Pendiente";
						}
						break;
			case "LS":	$imgcon="Concluida";
						$feclim="Sin Limite";
						$imgtar="Revisada";
						break;
			case "LN":	$imgcon="Activa";
						$feclim="Sin Limite";
						$imgtar="Sin Revisadar";
						break;
		}
		switch($row[6])
		{
			case "LN":	$imgtip="Informativa";
						$icopreoce="Mirar";
						$estadosol="Sin Revisar";
						break;
			case "LS":	$imgtip="Informativa";
						$icopreoce="Mirar";
						$estadosol="Revisada";
						break;
			case "AN":	$imgtip="Tarea";
						$estadosol="Sin Contestar";
						$icopreoce="Contestar";
						break;
			case "AC":	$imgtip="Tarea";
						$estadosol="Contestada";
						$icopreoce="Mirar";
						break;
			case "AR":	$imgtip="Redirigida";
						$estadosol="Contestada";
						$icopreoce="Contestar";
						break;
			case "CN":	$imgtip="Consuta";
						$estadosol="Sin Contestar";
						$icopreoce="Editar";
						break;
			case "CS":	$imgtip="Consuta";
						$estadosol="Contestada";
						$icopreoce="Mirar";
						break;
		}
		if($row[20]==3)
		{
			$imgtar="Anulado";
			$icopreoce="Mirar";
		}
		if($row[3]=="0000-00-00"){$fecres="00-00-0000";}
		else {$fecres=date('d-m-Y',strtotime($row[3]));}
		$filbor="A".$cont.":I".$cont;
		$objPHPExcel-> getActiveSheet ()
        -> getStyle ($filbor)
		-> getFont ()
		-> setBold ( false ) 
      	-> setName ('Arial') 
      	-> setSize ( 10 ) 
		-> getColor ()
		-> setRGB ('000000');
		$objPHPExcel->getActiveSheet()->getStyle($filbor)->applyFromArray($borders);
		$objPHPExcel->getActiveSheet ()->getStyle("F".$cont)->getAlignment()->setWrapText(true);
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValueExplicit ("A".$cont, utf8_encode($row[18]), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("B".$cont, date('d-m-Y',strtotime($row[2])), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("C".$cont, "$feclim", PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("D".$cont, "$fecres", PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("E".$cont, utf8_encode($nresul), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("F".$cont, utf8_encode($row[17]), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("G".$cont, utf8_encode($estadosol), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("H".$cont, utf8_encode($imgtar), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("I".$cont, utf8_encode($imgcon), PHPExcel_Cell_DataType :: TYPE_STRING);
		$objPHPExcel-> getActiveSheet ()	
		-> getStyle ($filbor)
		-> getAlignment ()
		-> applyFromArray (array ( 'vertical'  =>  PHPExcel_Style_Alignment :: VERTICAL_TOP ,) );  
		$cont=$cont+1;					
	}
	$objPHPExcel->getActiveSheet()->setTitle('Listado 1');// Renombrar Hoja
	$objPHPExcel->setActiveSheetIndex(0);// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
	// --------Cerrar--------
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Listado Tareas Asignadas.xlsx"');
	header('Cache-Control: max-age=0');
	header ('Expires: Mon, 15 Dic 2015 09:31:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
	exit;
?>
