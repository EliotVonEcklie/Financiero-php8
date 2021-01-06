<?php //V 1000 12/12/16 ?> 
<?php 
	require_once '/PHPExcel/Classes/PHPExcel.php';// Incluir la libreria PHPExcel
	include '/PHPExcel/Classes/PHPExcel/IOFactory.php';// PHPExcel_IOFactory
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	$objPHPExcel = new PHPExcel();// Crea un nuevo objeto PHPExcel
	$objPHPExcel->getProperties()->setCreator("G&C Tecnoinversiones SAS")
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
	$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	$sumacdp=0;
	$sumareca=0;	
	$sumaop=0;	
	$sumap=0;			
	$sumai=0;
	$sumapi=0;				
	$sumapad=0;	
	$sumapred=0;	
	$sumapcr=0;	
	$sumapccr=0;
	$linkbd=conectar_bd();
	$sqlr="select *from configbasica where estado='S'";
	//echo $sqlr;
	$res=mysql_query($sqlr,$linkbd);
	while($row=mysql_fetch_row($res))
	 {
	  $nit=$row[0];
	  $rs=$row[1];
	 }
	
		->setLastModifiedBy("HAFR")
		->setTitle("Ejecicion de Ingresos")
		->setSubject("Ingresos")
		->setDescription("Lista Semestral de Ingresos")
		->setKeywords("Ejecucion de Ingresos")
		->setCategory("Presupuesto");
		
	$objPHPExcel->setActiveSheetIndex(0)
		->mergeCells('A1:H1')
		->mergeCells('A2:H2')
  		->setCellValue('A1', '$rs - $nit')
     	->setCellValue('A2', 'Ejecucion Presupuestal de INGRESOS - Periodo: $_POST[fecha] - $_POST[fecha2]');
		
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
	$objPHPExcel-> getActiveSheet()->getColumnDimension('A')->setWidth(12); 
	$objPHPExcel-> getActiveSheet()->getColumnDimension('B')->setWidth(55);
	$objPHPExcel-> getActiveSheet ()	
		-> getStyle ('B:C')
		-> getAlignment ()
		-> applyFromArray (array ( 'horizontal'  =>  PHPExcel_Style_Alignment :: VERTICAL_JUSTIFY ,) ); 
	$objPHPExcel-> getActiveSheet()->getColumnDimension('C')->setWidth(15);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('D')->setWidth(12);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('E')->setWidth(11);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('F')->setWidth(25);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('G')->setWidth(28);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('H')->setWidth(21);
	$objWorksheet = $objPHPExcel->getActiveSheet();
	$objWorksheet->fromArray(array(utf8_encode('RUBRO'),utf8_encode('CONCEPTO'),utf8_encode('PRESUPUESTO INICIAL'),utf8_encode('ADICIONES'),utf8_encode('REDUCCIONES'),utf8_encode('PRESUPUESTO DEFINITIVO'),'INGRESOS','(%)'),NULL,'A3');
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		