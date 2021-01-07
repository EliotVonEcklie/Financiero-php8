<?php 
ini_set('max_execution_time',3600);
require"comun.inc"; 
	$cont = 0;
	while($cont<count($_POST[dexcelc])) 
	{	
		$cuenta = substr($_POST[dexcelc][$cont],0,6);
		$dcuentas[$cuenta][0] = $cuenta;
		$dcuentas[$cuenta][1] += $_POST[dexcel1][$cont];
		$dcuentas[$cuenta][2] += $_POST[dexcel2][$cont];
		$dcuentas[$cuenta][3] += $_POST[dexcel3][$cont];
		$dcuentas[$cuenta][4] += $_POST[dexcel4][$cont];
		$dcuentas[$cuenta][5] += $_POST[dexcel5][$cont];
		$dcuentas[$cuenta][6] += $_POST[dexcel6][$cont];
		$dcuentas[$cuenta][7] += $_POST[dexcel7][$cont];
		$dcuentas[$cuenta][8] += $_POST[dexcel8][$cont];
		$cont++;
	}
	asort($dcuentas);
	$link=conectar_bd();
	$namearch="archivos/".$_SESSION[usuario]."chip-homologacion.csv";
	$Descriptor1 = fopen($namearch,"w+"); 
	$sql="Select nit from configbasica where estado='S'";
	$res=mysql_query($sql,$link);
	$row=mysql_fetch_row($res);
	$tercero=$row[0];
	fputs($Descriptor1,"S;".$tercero.";10112;2017;CGN2015_001_SI_CONVERGENCIA\r\n");
	foreach ($dcuentas as $key => $val){
		$ncuentas=substr($val[0],0,1).".".substr($val[0],1,1).".".substr($val[0],2,2).".".substr($val[0],4,2); 
		if(substr($val[0],0,1)>1 && substr($val[0],0,1)<5)
	    {
			fputs($Descriptor1,"D;".$ncuentas.";".round($val[1])*(-1).";". round($val[2]).";". round($val[3]).";".round($val[7]).";".round($val[8]).";".round($val[4]).";".round($val[5]).";".round($val[6])*(-1).";\r\n");
		} 
		else
		{
			fputs($Descriptor1,"D;".$ncuentas.";".round($val[1]).";". round($val[2]).";". round($val[3]).";".round($val[7]).";".round($val[8]).";".round($val[4]).";".round($val[5]).";".round($val[6]).";\r\n");
		}
		//fputs($Descriptor1,"D;".$ncuentas.";".round($val[1]).";". round($val[2]).";". round($val[3]).";".round($val[4]).";".round($val[5]).";".round($val[6]).";\r\n");
	}
	fclose($namearch);

	header("Location: ".$namearch);
	/*require_once '/PHPExcel/Classes/PHPExcel.php';// Incluir la libreria PHPExcel
	include '/PHPExcel/Classes/PHPExcel/IOFactory.php';// PHPExcel_IOFactory
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();

	$objPHPExcel = new PHPExcel();// Crea un nuevo objeto PHPExcel
	$objPHPExcel->getProperties()->setCreator("G&C Tecnoinversiones SAS")
	   ->setLastModifiedBy("HAFR")
	   ->setTitle("Reporte Homologacion de Cuentas")
	   ->setSubject("Homologacion")
	   ->setDescription("Reporte Homologacion de Cuentas")
	   ->setKeywords("Activos")
	   ->setCategory("Homologacion");
	$objPHPExcel->setActiveSheetIndex(0)
		->mergeCells('A1:H1')
		->mergeCells('A2:H2')
  		->setCellValue('A1', 'HOMOLOGACION DE CUENTAS')
     	->setCellValue('A2', 'INFORMACION GENERAL');
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
		-> getStyle ('A3:H3')
		-> getAlignment ()
		-> applyFromArray (array ( 'horizontal'  =>  PHPExcel_Style_Alignment :: VERTICAL_JUSTIFY ,) ); 
	$objPHPExcel-> getActiveSheet ()
		-> getStyle ("A2")
        -> getFill ()
        -> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
        -> getStartColor ()
        -> setRGB ('A6E5F3');
	$objPHPExcel-> getActiveSheet ()
		-> getStyle ("A3:H3")
        -> getFill ()
        -> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
        -> getStartColor ()
        -> setRGB ('22C6CB');
	$borders = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
          'color' => array('argb' => 'FF000000'),
        )
      ),
    );
	$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->applyFromArray($borders);
	$objPHPExcel->getActiveSheet()->getStyle('A2:H2')->applyFromArray($borders);
	$objPHPExcel->getActiveSheet()->getStyle('A3:H3')->applyFromArray($borders);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('A')->setWidth(11); 
	$objPHPExcel-> getActiveSheet ()	
		-> getStyle ('A:B')
		-> getAlignment ()
		-> applyFromArray (array ( 'horizontal'  =>  PHPExcel_Style_Alignment :: VERTICAL_JUSTIFY ,) ); 
	$objPHPExcel-> getActiveSheet()->getColumnDimension('B')->setWidth(55);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('C')->setWidth(19);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('D')->setWidth(19);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('E')->setWidth(19);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('F')->setWidth(19);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('G')->setWidth(19);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('H')->setWidth(60);
	$objWorksheet = $objPHPExcel->getActiveSheet();
	$objWorksheet->fromArray(array(utf8_encode('Cuenta'),utf8_encode('Nombre'),utf8_encode('Saldo Final'),utf8_encode('Debito 100 y 101'),utf8_encode('Credito 100 y 101'),utf8_encode('Saldo Final'),utf8_encode('Cuenta NICSP'),utf8_encode('Nombre Cuenta NICSP')),NULL,'A3');


	$vigencia=date(Y);
	$fec=date("d/m/Y");
	$_POST[fecha]=$fec; 	
	$_POST[vigencia]=$vigencia;
	$_POST[vigdep]=$vigencia;		 	  			 
	$_POST[valor]=0;	

	$fechadep=$_POST[vigdep].'-'.$_POST[periodo].'-01';

	$tama=count($row);
	$i = 4;
	$con=0;
	$co="zebra1";
	$co2='zebra2';


	while($con<count($_POST[dcuentas])) 
	{	
		$objWorksheet->fromArray(array($_POST[dcuentas][$con],$_POST[dncuentas][$con],number_format($_POST[dexcel1][$con],2,',','.'),number_format($_POST[dexcel2][$con],2,',','.'),number_format($_POST[dexcel3][$con],2,',','.'),number_format($_POST[dexcel4][$con],2,',','.'),$_POST[cuentanicsp][$con],$_POST[nomcuentanicsp][$con]),NULL,'A'.$i);
		$objPHPExcel->getActiveSheet()->getStyle("A$i:H$i")->applyFromArray($borders);
		$objPHPExcel->getActiveSheet()->getStyle("C$i:G$i")->getNumberFormat()
		->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
		
		$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
		$objPHPExcel->getActiveSheet()->getStyle('H')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY,));
		$objPHPExcel-> getActiveSheet()-> getStyle ("A3:H3")-> getFont ()-> setBold ( true );
		
		$i++;
		$con++;
	}

	$objPHPExcel->getActiveSheet()->setTitle('Listado 1');// Renombrar Hoja
	$objPHPExcel->setActiveSheetIndex(0);// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
	// --------Cerrar--------
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Homologacion de Cuentas.xlsx"');
	header('Cache-Control: max-age=0');
	header ('Expires: Mon, 15 Dic 2015 09:31:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
	exit;*/
?>