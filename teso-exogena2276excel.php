<?php
	ini_set('max_execution_time', 3600);
	require_once '/PHPExcel/Classes/PHPExcel.php';//Incluir la libreria PHPExcel 
	include '/PHPExcel/Classes/PHPExcel/IOFactory.php';// PHPExcel_IOFactory
	require "comun.inc";
	require "funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	$objPHPExcel = new PHPExcel();// Crea un nuevo objeto PHPExcel
	$objReader = PHPExcel_IOFactory::createReader('Excel2007');// Leemos un archivo Excel 2007
	$objPHPExcel = $objReader->load("formatos/Formato 2276.xlsx");
	$borders = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
          'color' => array('argb' => 'FF000000'),
        )
      ),
    );
	// Agregar Informacion
	$sqlr="select distinct concepto,tercero,sum(valor),id_cxp from exogena_det_2276 where id_exo='$_POST[idexo]' AND tipo!='SE' AND tipo!='PE' group by concepto,tercero order by concepto,tercero";
	$res=mysql_query($sqlr,$linkbd);
	$xy=4;
	while ($row = mysql_fetch_row($res))
	{
		$_POST[nomina][]=$row[3];
		if($row[0] == '101')
		{
			$_POST[pagoSalarios][]=$row[2];
			$_POST[eclesiasticos][]=0;
			$_POST[honorario][]=0;
			$_POST[pagoPorServicio][]=0;
			$_POST[pagoPorComisiones][]=0;
			$_POST[pagoPorPrestasionesSociales][]=0;
			$_POST[pagoPorViaticos][]=0;
			$_POST[pagoPorRepresentacion][]=0;
			$_POST[pagoPorCompensaciones][]=0;
			$_POST[otrosPagos][]=0;
			$_POST[bonosElectronicos][]=0;
			$_POST[interesesCesantias][]=0;
			$_POST[pensionesJubilacion][]=0;
			$_POST[aportesSalud][]=0;
			$_POST[aportesPensiones][]=0;
			$_POST[aportesPensionesVoluntarios][]=0;
			$_POST[cuentasAFC][]=0;
			$_POST[retencionesFuenteRentas][]=0;
			$_POST[terceros1][] = $row[1];
		}
		else if($row[0] == '102')
		{
			$_POST[pagoSalarios][]=0;
			$_POST[eclesiasticos][]=$row[2];
			$_POST[honorario][]=0;
			$_POST[pagoPorServicio][]=0;
			$_POST[pagoPorComisiones][]=0;
			$_POST[pagoPorPrestasionesSociales][]=0;
			$_POST[pagoPorViaticos][]=0;
			$_POST[pagoPorRepresentacion][]=0;
			$_POST[pagoPorCompensaciones][]=0;
			$_POST[otrosPagos][]=0;
			$_POST[bonosElectronicos][]=0;
			$_POST[interesesCesantias][]=0;
			$_POST[pensionesJubilacion][]=0;
			$_POST[aportesSalud][]=0;
			$_POST[aportesPensiones][]=0;
			$_POST[aportesPensionesVoluntarios][]=0;
			$_POST[cuentasAFC][]=0;
			$_POST[retencionesFuenteRentas][]=0;
			$_POST[terceros1][] = $row[1];
		}
		else if($row[0] == '103')
		{
			$_POST[pagoSalarios][]=0;
			$_POST[eclesiasticos][]=0;
			$_POST[honorario][]=$row[2];
			$_POST[pagoPorServicio][]=0;
			$_POST[pagoPorComisiones][]=0;
			$_POST[pagoPorPrestasionesSociales][]=0;
			$_POST[pagoPorViaticos][]=0;
			$_POST[pagoPorRepresentacion][]=0;
			$_POST[pagoPorCompensaciones][]=0;
			$_POST[otrosPagos][]=0;
			$_POST[bonosElectronicos][]=0;
			$_POST[interesesCesantias][]=0;
			$_POST[pensionesJubilacion][]=0;
			$_POST[aportesSalud][]=0;
			$_POST[aportesPensiones][]=0;
			$_POST[aportesPensionesVoluntarios][]=0;
			$_POST[cuentasAFC][]=0;
			$_POST[retencionesFuenteRentas][]=0;
			$_POST[terceros1][] = $row[1];
		}
		else if($row[0] == '104')
		{
			$_POST[pagoSalarios][]=0;
			$_POST[eclesiasticos][]=0;
			$_POST[honorario][]=0;
			$_POST[pagoPorServicio][]=$row[2];
			$_POST[pagoPorComisiones][]=0;
			$_POST[pagoPorPrestasionesSociales][]=0;
			$_POST[pagoPorViaticos][]=0;
			$_POST[pagoPorRepresentacion][]=0;
			$_POST[pagoPorCompensaciones][]=0;
			$_POST[otrosPagos][]=0;
			$_POST[bonosElectronicos][]=0;
			$_POST[interesesCesantias][]=0;
			$_POST[pensionesJubilacion][]=0;
			$_POST[aportesSalud][]=0;
			$_POST[aportesPensiones][]=0;
			$_POST[aportesPensionesVoluntarios][]=0;
			$_POST[cuentasAFC][]=0;
			$_POST[retencionesFuenteRentas][]=0;
			$_POST[terceros1][] = $row[1];
		}
		else if($row[0] == '105')
		{
			$_POST[pagoSalarios][]=0;
			$_POST[eclesiasticos][]=0;
			$_POST[honorario][]=0;
			$_POST[pagoPorServicio][]=0;
			$_POST[pagoPorComisiones][]=$row[2];
			$_POST[pagoPorPrestasionesSociales][]=0;
			$_POST[pagoPorViaticos][]=0;
			$_POST[pagoPorRepresentacion][]=0;
			$_POST[pagoPorCompensaciones][]=0;
			$_POST[otrosPagos][]=0;
			$_POST[bonosElectronicos][]=0;
			$_POST[interesesCesantias][]=0;
			$_POST[pensionesJubilacion][]=0;
			$_POST[aportesSalud][]=0;
			$_POST[aportesPensiones][]=0;
			$_POST[aportesPensionesVoluntarios][]=0;
			$_POST[cuentasAFC][]=0;
			$_POST[retencionesFuenteRentas][]=0;
			$_POST[terceros1][] = $row[1];
		}
		else if($row[0] == '106')
		{
			$_POST[pagoSalarios][]=0;
			$_POST[eclesiasticos][]=0;
			$_POST[honorario][]=0;
			$_POST[pagoPorServicio][]=0;
			$_POST[pagoPorComisiones][]=0;
			$_POST[pagoPorPrestasionesSociales][]=$row[2];
			$_POST[pagoPorViaticos][]=0;
			$_POST[pagoPorRepresentacion][]=0;
			$_POST[pagoPorCompensaciones][]=0;
			$_POST[otrosPagos][]=0;
			$_POST[bonosElectronicos][]=0;
			$_POST[interesesCesantias][]=0;
			$_POST[pensionesJubilacion][]=0;
			$_POST[aportesSalud][]=0;
			$_POST[aportesPensiones][]=0;
			$_POST[aportesPensionesVoluntarios][]=0;
			$_POST[cuentasAFC][]=0;
			$_POST[retencionesFuenteRentas][]=0;
			$_POST[terceros1][] = $row[1];
		}
		else if($row[0] == '107')
		{
			$_POST[pagoSalarios][]=0;
			$_POST[eclesiasticos][]=0;
			$_POST[honorario][]=0;
			$_POST[pagoPorServicio][]=0;
			$_POST[pagoPorComisiones][]=0;
			$_POST[pagoPorPrestasionesSociales][]=0;
			$_POST[pagoPorViaticos][]=$row[2];
			$_POST[pagoPorRepresentacion][]=0;
			$_POST[pagoPorCompensaciones][]=0;
			$_POST[otrosPagos][]=0;
			$_POST[bonosElectronicos][]=0;
			$_POST[interesesCesantias][]=0;
			$_POST[pensionesJubilacion][]=0;
			$_POST[aportesSalud][]=0;
			$_POST[aportesPensiones][]=0;
			$_POST[aportesPensionesVoluntarios][]=0;
			$_POST[cuentasAFC][]=0;
			$_POST[retencionesFuenteRentas][]=0;
			$_POST[terceros1][] = $row[1];
		}
		else if($row[0] == '108')
		{
			$_POST[pagoSalarios][]=0;
			$_POST[eclesiasticos][]=0;
			$_POST[honorario][]=0;
			$_POST[pagoPorServicio][]=0;
			$_POST[pagoPorComisiones][]=0;
			$_POST[pagoPorPrestasionesSociales][]=0;
			$_POST[pagoPorViaticos][]=0;
			$_POST[pagoPorRepresentacion][]=$row[2];
			$_POST[pagoPorCompensaciones][]=0;
			$_POST[otrosPagos][]=0;
			$_POST[bonosElectronicos][]=0;
			$_POST[interesesCesantias][]=0;
			$_POST[pensionesJubilacion][]=0;
			$_POST[aportesSalud][]=0;
			$_POST[aportesPensiones][]=0;
			$_POST[aportesPensionesVoluntarios][]=0;
			$_POST[cuentasAFC][]=0;
			$_POST[retencionesFuenteRentas][]=0;
			$_POST[terceros1][] = $row[1];
		}
		else if($row[0] == '109')
		{
			$_POST[pagoSalarios][]=0;
			$_POST[eclesiasticos][]=0;
			$_POST[honorario][]=0;
			$_POST[pagoPorServicio][]=0;
			$_POST[pagoPorComisiones][]=0;
			$_POST[pagoPorPrestasionesSociales][]=0;
			$_POST[pagoPorViaticos][]=0;
			$_POST[pagoPorRepresentacion][]=0;
			$_POST[pagoPorCompensaciones][]=$row[2];
			$_POST[otrosPagos][]=0;
			$_POST[bonosElectronicos][]=0;
			$_POST[interesesCesantias][]=0;
			$_POST[pensionesJubilacion][]=0;
			$_POST[aportesSalud][]=0;
			$_POST[aportesPensiones][]=0;
			$_POST[aportesPensionesVoluntarios][]=0;
			$_POST[cuentasAFC][]=0;
			$_POST[retencionesFuenteRentas][]=0;
			$_POST[terceros1][] = $row[1];
		}
		else if($row[0] == '110')
		{
			$_POST[pagoSalarios][]=0;
			$_POST[eclesiasticos][]=0;
			$_POST[honorario][]=0;
			$_POST[pagoPorServicio][]=0;
			$_POST[pagoPorComisiones][]=0;
			$_POST[pagoPorPrestasionesSociales][]=0;
			$_POST[pagoPorViaticos][]=0;
			$_POST[pagoPorRepresentacion][]=0;
			$_POST[pagoPorCompensaciones][]=0;
			$_POST[otrosPagos][]=$row[2];
			$_POST[bonosElectronicos][]=0;
			$_POST[interesesCesantias][]=0;
			$_POST[pensionesJubilacion][]=0;
			$_POST[aportesSalud][]=0;
			$_POST[aportesPensiones][]=0;
			$_POST[aportesPensionesVoluntarios][]=0;
			$_POST[cuentasAFC][]=0;
			$_POST[retencionesFuenteRentas][]=0;
			$_POST[terceros1][] = $row[1];
		}
		else if($row[0] == '111')
		{
			$_POST[pagoSalarios][]=0;
			$_POST[eclesiasticos][]=0;
			$_POST[honorario][]=0;
			$_POST[pagoPorServicio][]=0;
			$_POST[pagoPorComisiones][]=0;
			$_POST[pagoPorPrestasionesSociales][]=0;
			$_POST[pagoPorViaticos][]=0;
			$_POST[pagoPorRepresentacion][]=0;
			$_POST[pagoPorCompensaciones][]=0;
			$_POST[otrosPagos][]=0;
			$_POST[bonosElectronicos][]=$row[2];
			$_POST[interesesCesantias][]=0;
			$_POST[pensionesJubilacion][]=0;
			$_POST[aportesSalud][]=0;
			$_POST[aportesPensiones][]=0;
			$_POST[aportesPensionesVoluntarios][]=0;
			$_POST[cuentasAFC][]=0;
			$_POST[retencionesFuenteRentas][]=0;
			$_POST[terceros1][] = $row[1];
		}
		else if($row[0] == '112')
		{
			$_POST[pagoSalarios][]=0;
			$_POST[eclesiasticos][]=0;
			$_POST[honorario][]=0;
			$_POST[pagoPorServicio][]=0;
			$_POST[pagoPorComisiones][]=0;
			$_POST[pagoPorPrestasionesSociales][]=0;
			$_POST[pagoPorViaticos][]=0;
			$_POST[pagoPorRepresentacion][]=0;
			$_POST[pagoPorCompensaciones][]=0;
			$_POST[otrosPagos][]=0;
			$_POST[bonosElectronicos][]=0;
			$_POST[interesesCesantias][]=$row[2];
			$_POST[pensionesJubilacion][]=0;
			$_POST[aportesSalud][]=0;
			$_POST[aportesPensiones][]=0;
			$_POST[aportesPensionesVoluntarios][]=0;
			$_POST[cuentasAFC][]=0;
			$_POST[retencionesFuenteRentas][]=0;
			$_POST[terceros1][] = $row[1];
		}
		else if($row[0] == '113')
		{
			$_POST[pagoSalarios][]=0;
			$_POST[eclesiasticos][]=0;
			$_POST[honorario][]=0;
			$_POST[pagoPorServicio][]=0;
			$_POST[pagoPorComisiones][]=0;
			$_POST[pagoPorPrestasionesSociales][]=0;
			$_POST[pagoPorViaticos][]=0;
			$_POST[pagoPorRepresentacion][]=0;
			$_POST[pagoPorCompensaciones][]=0;
			$_POST[otrosPagos][]=0;
			$_POST[bonosElectronicos][]=0;
			$_POST[interesesCesantias][]=0;
			$_POST[pensionesJubilacion][]=$row[2];
			$_POST[aportesSalud][]=0;
			$_POST[aportesPensiones][]=0;
			$_POST[aportesPensionesVoluntarios][]=0;
			$_POST[cuentasAFC][]=0;
			$_POST[retencionesFuenteRentas][]=0;
			$_POST[terceros1][] = $row[1];
		}
		else if($row[0] == '114')
		{
			$_POST[pagoSalarios][]=0;
			$_POST[eclesiasticos][]=0;
			$_POST[honorario][]=0;
			$_POST[pagoPorServicio][]=0;
			$_POST[pagoPorComisiones][]=0;
			$_POST[pagoPorPrestasionesSociales][]=0;
			$_POST[pagoPorViaticos][]=0;
			$_POST[pagoPorRepresentacion][]=0;
			$_POST[pagoPorCompensaciones][]=0;
			$_POST[otrosPagos][]=0;
			$_POST[bonosElectronicos][]=0;
			$_POST[interesesCesantias][]=0;
			$_POST[pensionesJubilacion][]=0;
			$_POST[aportesSalud][]=$row[2];
			$_POST[aportesPensiones][]=0;
			$_POST[aportesPensionesVoluntarios][]=0;
			$_POST[cuentasAFC][]=0;
			$_POST[retencionesFuenteRentas][]=0;
			$_POST[terceros1][] = $row[1];
		}
		else if($row[0] == '115')
		{
			$_POST[pagoSalarios][]=0;
			$_POST[eclesiasticos][]=0;
			$_POST[honorario][]=0;
			$_POST[pagoPorServicio][]=0;
			$_POST[pagoPorComisiones][]=0;
			$_POST[pagoPorPrestasionesSociales][]=0;
			$_POST[pagoPorViaticos][]=0;
			$_POST[pagoPorRepresentacion][]=0;
			$_POST[pagoPorCompensaciones][]=0;
			$_POST[otrosPagos][]=0;
			$_POST[bonosElectronicos][]=0;
			$_POST[interesesCesantias][]=0;
			$_POST[pensionesJubilacion][]=0;
			$_POST[aportesSalud][]=0;
			$_POST[aportesPensiones][]=$row[2];
			$_POST[aportesPensionesVoluntarios][]=0;
			$_POST[cuentasAFC][]=0;
			$_POST[retencionesFuenteRentas][]=0;
			$_POST[terceros1][] = $row[1];
		}
		else if($row[0] == '116')
		{
			$_POST[pagoSalarios][]=0;
			$_POST[eclesiasticos][]=0;
			$_POST[honorario][]=0;
			$_POST[pagoPorServicio][]=0;
			$_POST[pagoPorComisiones][]=0;
			$_POST[pagoPorPrestasionesSociales][]=0;
			$_POST[pagoPorViaticos][]=0;
			$_POST[pagoPorRepresentacion][]=0;
			$_POST[pagoPorCompensaciones][]=0;
			$_POST[otrosPagos][]=0;
			$_POST[bonosElectronicos][]=0;
			$_POST[interesesCesantias][]=0;
			$_POST[pensionesJubilacion][]=0;
			$_POST[aportesSalud][]=0;
			$_POST[aportesPensiones][]=0;
			$_POST[aportesPensionesVoluntarios][]=$row[2];
			$_POST[cuentasAFC][]=0;
			$_POST[retencionesFuenteRentas][]=0;
			$_POST[terceros1][] = $row[1];
		}
		else if($row[0] == '117')
		{
			$_POST[pagoSalarios][]=0;
			$_POST[eclesiasticos][]=0;
			$_POST[honorario][]=0;
			$_POST[pagoPorServicio][]=0;
			$_POST[pagoPorComisiones][]=0;
			$_POST[pagoPorPrestasionesSociales][]=0;
			$_POST[pagoPorViaticos][]=0;
			$_POST[pagoPorRepresentacion][]=0;
			$_POST[pagoPorCompensaciones][]=0;
			$_POST[otrosPagos][]=0;
			$_POST[bonosElectronicos][]=0;
			$_POST[interesesCesantias][]=0;
			$_POST[pensionesJubilacion][]=0;
			$_POST[aportesSalud][]=0;
			$_POST[aportesPensiones][]=0;
			$_POST[aportesPensionesVoluntarios][]=0;
			$_POST[cuentasAFC][]=$row[2];
			$_POST[retencionesFuenteRentas][]=0;
			$_POST[terceros1][] = $row[1];
		}
		else if($row[0] == '118')
		{
			$_POST[pagoSalarios][]=0;
			$_POST[eclesiasticos][]=0;
			$_POST[honorario][]=0;
			$_POST[pagoPorServicio][]=0;
			$_POST[pagoPorComisiones][]=0;
			$_POST[pagoPorPrestasionesSociales][]=0;
			$_POST[pagoPorViaticos][]=0;
			$_POST[pagoPorRepresentacion][]=0;
			$_POST[pagoPorCompensaciones][]=0;
			$_POST[otrosPagos][]=0;
			$_POST[bonosElectronicos][]=0;
			$_POST[interesesCesantias][]=0;
			$_POST[pensionesJubilacion][]=0;
			$_POST[aportesSalud][]=0;
			$_POST[aportesPensiones][]=0;
			$_POST[aportesPensionesVoluntarios][]=0;
			$_POST[cuentasAFC][]=0;
			$_POST[retencionesFuenteRentas][]=$row[2];
			$_POST[terceros1][] = $row[1];
		}
		
	}
	$sqlr="SELECT distinct ED.concepto,ED.tercero,sum(ED.valor),ED.id_cxp,sum(ED.retefte) FROM exogena_det AS ED, exogena_cab AS E WHERE E.vigencia = '$_POST[vigencias]' AND E.id_exo=ED.id_exo AND E.estado='S' group by ED.concepto,ED.tercero order by ED.tercero"; 
	$res=mysql_query($sqlr,$linkbd);
	$xy=4;
	while ($row = mysql_fetch_row($res))
	{
		$_POST[nomina][]=$row[3];
		if($row[0] == '101')
		{
			$_POST[pagoSalarios][]=$row[2];
			$_POST[eclesiasticos][]=0;
			$_POST[honorario][]=0;
			$_POST[pagoPorServicio][]=0;
			$_POST[pagoPorComisiones][]=0;
			$_POST[pagoPorPrestasionesSociales][]=0;
			$_POST[pagoPorViaticos][]=0;
			$_POST[pagoPorRepresentacion][]=0;
			$_POST[pagoPorCompensaciones][]=0;
			$_POST[otrosPagos][]=0;
			$_POST[bonosElectronicos][]=0;
			$_POST[interesesCesantias][]=0;
			$_POST[pensionesJubilacion][]=0;
			$_POST[aportesSalud][]=0;
			$_POST[aportesPensiones][]=0;
			$_POST[aportesPensionesVoluntarios][]=0;
			$_POST[cuentasAFC][]=0;
			$_POST[retencionesFuenteRentas][]=$row[4];
			$_POST[terceros1][] = $row[1];
		}
		else if($row[0] == '102')
		{
			$_POST[pagoSalarios][]=0;
			$_POST[eclesiasticos][]=$row[2];
			$_POST[honorario][]=0;
			$_POST[pagoPorServicio][]=0;
			$_POST[pagoPorComisiones][]=0;
			$_POST[pagoPorPrestasionesSociales][]=0;
			$_POST[pagoPorViaticos][]=0;
			$_POST[pagoPorRepresentacion][]=0;
			$_POST[pagoPorCompensaciones][]=0;
			$_POST[otrosPagos][]=0;
			$_POST[bonosElectronicos][]=0;
			$_POST[interesesCesantias][]=0;
			$_POST[pensionesJubilacion][]=0;
			$_POST[aportesSalud][]=0;
			$_POST[aportesPensiones][]=0;
			$_POST[aportesPensionesVoluntarios][]=0;
			$_POST[cuentasAFC][]=0;
			$_POST[retencionesFuenteRentas][]=$row[4];
			$_POST[terceros1][] = $row[1];
		}
		else if($row[0] == '103')
		{
			$_POST[pagoSalarios][]=0;
			$_POST[eclesiasticos][]=0;
			$_POST[honorario][]=$row[2];
			$_POST[pagoPorServicio][]=0;
			$_POST[pagoPorComisiones][]=0;
			$_POST[pagoPorPrestasionesSociales][]=0;
			$_POST[pagoPorViaticos][]=0;
			$_POST[pagoPorRepresentacion][]=0;
			$_POST[pagoPorCompensaciones][]=0;
			$_POST[otrosPagos][]=0;
			$_POST[bonosElectronicos][]=0;
			$_POST[interesesCesantias][]=0;
			$_POST[pensionesJubilacion][]=0;
			$_POST[aportesSalud][]=0;
			$_POST[aportesPensiones][]=0;
			$_POST[aportesPensionesVoluntarios][]=0;
			$_POST[cuentasAFC][]=0;
			$_POST[retencionesFuenteRentas][]=$row[4];
			$_POST[terceros1][] = $row[1];
		}
		else if($row[0] == '104')
		{
			$_POST[pagoSalarios][]=0;
			$_POST[eclesiasticos][]=0;
			$_POST[honorario][]=0;
			$_POST[pagoPorServicio][]=$row[2];
			$_POST[pagoPorComisiones][]=0;
			$_POST[pagoPorPrestasionesSociales][]=0;
			$_POST[pagoPorViaticos][]=0;
			$_POST[pagoPorRepresentacion][]=0;
			$_POST[pagoPorCompensaciones][]=0;
			$_POST[otrosPagos][]=0;
			$_POST[bonosElectronicos][]=0;
			$_POST[interesesCesantias][]=0;
			$_POST[pensionesJubilacion][]=0;
			$_POST[aportesSalud][]=0;
			$_POST[aportesPensiones][]=0;
			$_POST[aportesPensionesVoluntarios][]=0;
			$_POST[cuentasAFC][]=0;
			$_POST[retencionesFuenteRentas][]=$row[4];
			$_POST[terceros1][] = $row[1];
		}
		else if($row[0] == '105')
		{
			$_POST[pagoSalarios][]=0;
			$_POST[eclesiasticos][]=0;
			$_POST[honorario][]=0;
			$_POST[pagoPorServicio][]=0;
			$_POST[pagoPorComisiones][]=$row[2];
			$_POST[pagoPorPrestasionesSociales][]=0;
			$_POST[pagoPorViaticos][]=0;
			$_POST[pagoPorRepresentacion][]=0;
			$_POST[pagoPorCompensaciones][]=0;
			$_POST[otrosPagos][]=0;
			$_POST[bonosElectronicos][]=0;
			$_POST[interesesCesantias][]=0;
			$_POST[pensionesJubilacion][]=0;
			$_POST[aportesSalud][]=0;
			$_POST[aportesPensiones][]=0;
			$_POST[aportesPensionesVoluntarios][]=0;
			$_POST[cuentasAFC][]=0;
			$_POST[retencionesFuenteRentas][]=$row[4];
			$_POST[terceros1][] = $row[1];
		}
		else if($row[0] == '106')
		{
			$_POST[pagoSalarios][]=0;
			$_POST[eclesiasticos][]=0;
			$_POST[honorario][]=0;
			$_POST[pagoPorServicio][]=0;
			$_POST[pagoPorComisiones][]=0;
			$_POST[pagoPorPrestasionesSociales][]=$row[2];
			$_POST[pagoPorViaticos][]=0;
			$_POST[pagoPorRepresentacion][]=0;
			$_POST[pagoPorCompensaciones][]=0;
			$_POST[otrosPagos][]=0;
			$_POST[bonosElectronicos][]=0;
			$_POST[interesesCesantias][]=0;
			$_POST[pensionesJubilacion][]=0;
			$_POST[aportesSalud][]=0;
			$_POST[aportesPensiones][]=0;
			$_POST[aportesPensionesVoluntarios][]=0;
			$_POST[cuentasAFC][]=0;
			$_POST[retencionesFuenteRentas][]=$row[4];
			$_POST[terceros1][] = $row[1];
		}
		else if($row[0] == '107')
		{
			$_POST[pagoSalarios][]=0;
			$_POST[eclesiasticos][]=0;
			$_POST[honorario][]=0;
			$_POST[pagoPorServicio][]=0;
			$_POST[pagoPorComisiones][]=0;
			$_POST[pagoPorPrestasionesSociales][]=0;
			$_POST[pagoPorViaticos][]=$row[2];
			$_POST[pagoPorRepresentacion][]=0;
			$_POST[pagoPorCompensaciones][]=0;
			$_POST[otrosPagos][]=0;
			$_POST[bonosElectronicos][]=0;
			$_POST[interesesCesantias][]=0;
			$_POST[pensionesJubilacion][]=0;
			$_POST[aportesSalud][]=0;
			$_POST[aportesPensiones][]=0;
			$_POST[aportesPensionesVoluntarios][]=0;
			$_POST[cuentasAFC][]=0;
			$_POST[retencionesFuenteRentas][]=$row[4];
			$_POST[terceros1][] = $row[1];
		}
		else if($row[0] == '108')
		{
			$_POST[pagoSalarios][]=0;
			$_POST[eclesiasticos][]=0;
			$_POST[honorario][]=0;
			$_POST[pagoPorServicio][]=0;
			$_POST[pagoPorComisiones][]=0;
			$_POST[pagoPorPrestasionesSociales][]=0;
			$_POST[pagoPorViaticos][]=0;
			$_POST[pagoPorRepresentacion][]=$row[2];
			$_POST[pagoPorCompensaciones][]=0;
			$_POST[otrosPagos][]=0;
			$_POST[bonosElectronicos][]=0;
			$_POST[interesesCesantias][]=0;
			$_POST[pensionesJubilacion][]=0;
			$_POST[aportesSalud][]=0;
			$_POST[aportesPensiones][]=0;
			$_POST[aportesPensionesVoluntarios][]=0;
			$_POST[cuentasAFC][]=0;
			$_POST[retencionesFuenteRentas][]=$row[4];
			$_POST[terceros1][] = $row[1];
		}
		else if($row[0] == '109')
		{
			$_POST[pagoSalarios][]=0;
			$_POST[eclesiasticos][]=0;
			$_POST[honorario][]=0;
			$_POST[pagoPorServicio][]=0;
			$_POST[pagoPorComisiones][]=0;
			$_POST[pagoPorPrestasionesSociales][]=0;
			$_POST[pagoPorViaticos][]=0;
			$_POST[pagoPorRepresentacion][]=0;
			$_POST[pagoPorCompensaciones][]=$row[2];
			$_POST[otrosPagos][]=0;
			$_POST[bonosElectronicos][]=0;
			$_POST[interesesCesantias][]=0;
			$_POST[pensionesJubilacion][]=0;
			$_POST[aportesSalud][]=0;
			$_POST[aportesPensiones][]=0;
			$_POST[aportesPensionesVoluntarios][]=0;
			$_POST[cuentasAFC][]=0;
			$_POST[retencionesFuenteRentas][]=$row[4];
			$_POST[terceros1][] = $row[1];
		}
		else if($row[0] == '110')
		{
			$_POST[pagoSalarios][]=0;
			$_POST[eclesiasticos][]=0;
			$_POST[honorario][]=0;
			$_POST[pagoPorServicio][]=0;
			$_POST[pagoPorComisiones][]=0;
			$_POST[pagoPorPrestasionesSociales][]=0;
			$_POST[pagoPorViaticos][]=0;
			$_POST[pagoPorRepresentacion][]=0;
			$_POST[pagoPorCompensaciones][]=0;
			$_POST[otrosPagos][]=$row[2];
			$_POST[bonosElectronicos][]=0;
			$_POST[interesesCesantias][]=0;
			$_POST[pensionesJubilacion][]=0;
			$_POST[aportesSalud][]=0;
			$_POST[aportesPensiones][]=0;
			$_POST[aportesPensionesVoluntarios][]=0;
			$_POST[cuentasAFC][]=0;
			$_POST[retencionesFuenteRentas][]=$row[4];
			$_POST[terceros1][] = $row[1];
		}
		else if($row[0] == '111')
		{
			$_POST[pagoSalarios][]=0;
			$_POST[eclesiasticos][]=0;
			$_POST[honorario][]=0;
			$_POST[pagoPorServicio][]=0;
			$_POST[pagoPorComisiones][]=0;
			$_POST[pagoPorPrestasionesSociales][]=0;
			$_POST[pagoPorViaticos][]=0;
			$_POST[pagoPorRepresentacion][]=0;
			$_POST[pagoPorCompensaciones][]=0;
			$_POST[otrosPagos][]=0;
			$_POST[bonosElectronicos][]=$row[2];
			$_POST[interesesCesantias][]=0;
			$_POST[pensionesJubilacion][]=0;
			$_POST[aportesSalud][]=0;
			$_POST[aportesPensiones][]=0;
			$_POST[aportesPensionesVoluntarios][]=0;
			$_POST[cuentasAFC][]=0;
			$_POST[retencionesFuenteRentas][]=$row[4];
			$_POST[terceros1][] = $row[1];
		}
		else if($row[0] == '112')
		{
			$_POST[pagoSalarios][]=0;
			$_POST[eclesiasticos][]=0;
			$_POST[honorario][]=0;
			$_POST[pagoPorServicio][]=0;
			$_POST[pagoPorComisiones][]=0;
			$_POST[pagoPorPrestasionesSociales][]=0;
			$_POST[pagoPorViaticos][]=0;
			$_POST[pagoPorRepresentacion][]=0;
			$_POST[pagoPorCompensaciones][]=0;
			$_POST[otrosPagos][]=0;
			$_POST[bonosElectronicos][]=0;
			$_POST[interesesCesantias][]=$row[2];
			$_POST[pensionesJubilacion][]=0;
			$_POST[aportesSalud][]=0;
			$_POST[aportesPensiones][]=0;
			$_POST[aportesPensionesVoluntarios][]=0;
			$_POST[cuentasAFC][]=0;
			$_POST[retencionesFuenteRentas][]=$row[4];
			$_POST[terceros1][] = $row[1];
		}
		else if($row[0] == '113')
		{
			$_POST[pagoSalarios][]=0;
			$_POST[eclesiasticos][]=0;
			$_POST[honorario][]=0;
			$_POST[pagoPorServicio][]=0;
			$_POST[pagoPorComisiones][]=0;
			$_POST[pagoPorPrestasionesSociales][]=0;
			$_POST[pagoPorViaticos][]=0;
			$_POST[pagoPorRepresentacion][]=0;
			$_POST[pagoPorCompensaciones][]=0;
			$_POST[otrosPagos][]=0;
			$_POST[bonosElectronicos][]=0;
			$_POST[interesesCesantias][]=0;
			$_POST[pensionesJubilacion][]=$row[2];
			$_POST[aportesSalud][]=0;
			$_POST[aportesPensiones][]=0;
			$_POST[aportesPensionesVoluntarios][]=0;
			$_POST[cuentasAFC][]=0;
			$_POST[retencionesFuenteRentas][]=$row[4];
			$_POST[terceros1][] = $row[1];
		}
		else if($row[0] == '114')
		{
			$_POST[pagoSalarios][]=0;
			$_POST[eclesiasticos][]=0;
			$_POST[honorario][]=0;
			$_POST[pagoPorServicio][]=0;
			$_POST[pagoPorComisiones][]=0;
			$_POST[pagoPorPrestasionesSociales][]=0;
			$_POST[pagoPorViaticos][]=0;
			$_POST[pagoPorRepresentacion][]=0;
			$_POST[pagoPorCompensaciones][]=0;
			$_POST[otrosPagos][]=0;
			$_POST[bonosElectronicos][]=0;
			$_POST[interesesCesantias][]=0;
			$_POST[pensionesJubilacion][]=0;
			$_POST[aportesSalud][]=$row[2];
			$_POST[aportesPensiones][]=0;
			$_POST[aportesPensionesVoluntarios][]=0;
			$_POST[cuentasAFC][]=0;
			$_POST[retencionesFuenteRentas][]=$row[4];
			$_POST[terceros1][] = $row[1];
		}
		else if($row[0] == '115')
		{
			$_POST[pagoSalarios][]=0;
			$_POST[eclesiasticos][]=0;
			$_POST[honorario][]=0;
			$_POST[pagoPorServicio][]=0;
			$_POST[pagoPorComisiones][]=0;
			$_POST[pagoPorPrestasionesSociales][]=0;
			$_POST[pagoPorViaticos][]=0;
			$_POST[pagoPorRepresentacion][]=0;
			$_POST[pagoPorCompensaciones][]=0;
			$_POST[otrosPagos][]=0;
			$_POST[bonosElectronicos][]=0;
			$_POST[interesesCesantias][]=0;
			$_POST[pensionesJubilacion][]=0;
			$_POST[aportesSalud][]=0;
			$_POST[aportesPensiones][]=$row[2];
			$_POST[aportesPensionesVoluntarios][]=0;
			$_POST[cuentasAFC][]=0;
			$_POST[retencionesFuenteRentas][]=$row[4];
			$_POST[terceros1][] = $row[1];
		}
		else if($row[0] == '116')
		{
			$_POST[pagoSalarios][]=0;
			$_POST[eclesiasticos][]=0;
			$_POST[honorario][]=0;
			$_POST[pagoPorServicio][]=0;
			$_POST[pagoPorComisiones][]=0;
			$_POST[pagoPorPrestasionesSociales][]=0;
			$_POST[pagoPorViaticos][]=0;
			$_POST[pagoPorRepresentacion][]=0;
			$_POST[pagoPorCompensaciones][]=0;
			$_POST[otrosPagos][]=0;
			$_POST[bonosElectronicos][]=0;
			$_POST[interesesCesantias][]=0;
			$_POST[pensionesJubilacion][]=0;
			$_POST[aportesSalud][]=0;
			$_POST[aportesPensiones][]=0;
			$_POST[aportesPensionesVoluntarios][]=$row[2];
			$_POST[cuentasAFC][]=0;
			$_POST[retencionesFuenteRentas][]=$row[4];
			$_POST[terceros1][] = $row[1];
		}
		else if($row[0] == '117')
		{
			$_POST[pagoSalarios][]=0;
			$_POST[eclesiasticos][]=0;
			$_POST[honorario][]=0;
			$_POST[pagoPorServicio][]=0;
			$_POST[pagoPorComisiones][]=0;
			$_POST[pagoPorPrestasionesSociales][]=0;
			$_POST[pagoPorViaticos][]=0;
			$_POST[pagoPorRepresentacion][]=0;
			$_POST[pagoPorCompensaciones][]=0;
			$_POST[otrosPagos][]=0;
			$_POST[bonosElectronicos][]=0;
			$_POST[interesesCesantias][]=0;
			$_POST[pensionesJubilacion][]=0;
			$_POST[aportesSalud][]=0;
			$_POST[aportesPensiones][]=0;
			$_POST[aportesPensionesVoluntarios][]=0;
			$_POST[cuentasAFC][]=$row[2];
			$_POST[retencionesFuenteRentas][]=$row[4];
			$_POST[terceros1][] = $row[1];
		}
		else if($row[0] == '118')
		{
			$_POST[pagoSalarios][]=0;
			$_POST[eclesiasticos][]=0;
			$_POST[honorario][]=0;
			$_POST[pagoPorServicio][]=0;
			$_POST[pagoPorComisiones][]=0;
			$_POST[pagoPorPrestasionesSociales][]=0;
			$_POST[pagoPorViaticos][]=0;
			$_POST[pagoPorRepresentacion][]=0;
			$_POST[pagoPorCompensaciones][]=0;
			$_POST[otrosPagos][]=0;
			$_POST[bonosElectronicos][]=0;
			$_POST[interesesCesantias][]=0;
			$_POST[pensionesJubilacion][]=0;
			$_POST[aportesSalud][]=0;
			$_POST[aportesPensiones][]=0;
			$_POST[aportesPensionesVoluntarios][]=0;
			$_POST[cuentasAFC][]=0;
			$_POST[retencionesFuenteRentas][]=$row[4];
			$_POST[terceros1][] = $row[1];
		}
		
	}
	$max = MAX($_POST[nomina]);
	$min = MIN($_POST[nomina]);
	$sqlr="create  temporary table exogena2276 (id int(11),tercero varchar(20),pagoSalarios double,eclesiasticos double,honorario double,pagoPorServicio double,pagoPorComisiones double,pagoPorPrestasionesSociales double,pagoPorViaticos double,pagoPorRepresentacion double,pagoPorCompensaciones double,otrosPagos double,bonosElectronicos double,interesesCesantias double,pensionesJubilacion double,aportesSalud double,aportesPensiones double,aportesPensionesVoluntarios double,cuentasAFC double,retencionesFuenteRentas double,nomina int(11))";
	mysql_query($sqlr,$linkbd);
    for($x = 0 ; $x < count($_POST[pagoSalarios]) ; $x++)
    {

		//$sqlr="insert into exogena2276 (id,tercero,salarios,viaticos,cesantias,prestaciones,otrospagos,nomina) values($x,'".$_POST[terceros1][$x]."','".$_POST[salarios][$x]."','".$_POST[viaticos][$x]."','".$_POST[cesantias][$x]."','".$_POST[prestaciones][$x]."','".$_POST[otrosPagos][$x]."','".$_POST[nomina][$x]."')";
		$sqlr="insert into exogena2276 (id,tercero,pagoSalarios,eclesiasticos,honorario,pagoPorServicio,pagoPorComisiones,pagoPorPrestasionesSociales,pagoPorViaticos,pagoPorRepresentacion,pagoPorCompensaciones,otrosPagos,bonosElectronicos,interesesCesantias,pensionesJubilacion,aportesSalud,aportesPensiones,aportesPensionesVoluntarios,cuentasAFC,retencionesFuenteRentas,nomina) values($x,'".$_POST[terceros1][$x]."','".$_POST[pagoSalarios][$x]."','".$_POST[eclesiasticos][$x]."','".$_POST[honorario][$x]."','".$_POST[pagoPorServicio][$x]."','".$_POST[pagoPorComisiones][$x]."','".$_POST[pagoPorPrestasionesSociales][$x]."','".$_POST[pagoPorViaticos][$x]."','".$_POST[pagoPorRepresentacion][$x]."','".$_POST[pagoPorCompensaciones][$x]."','".$_POST[otrosPagos][$x]."','".$_POST[bonosElectronicos][$x]."','".$_POST[interesesCesantias][$x]."','".$_POST[pensionesJubilacion][$x]."','".$_POST[aportesSalud][$x]."','".$_POST[aportesPensiones][$x]."','".$_POST[aportesPensionesVoluntarios][$x]."','".$_POST[cuentasAFC][$x]."','".$_POST[retencionesFuenteRentas][$x]."','".$_POST[nomina][$x]."')";
		//echo "hola".$_POST[terceros1][$x];
		mysql_query($sqlr,$linkbd);
	}
	$sqlrExogena = "select tercero,sum(pagoSalarios),sum(eclesiasticos),sum(honorario),sum(pagoPorServicio),sum(pagoPorComisiones),sum(pagoPorPrestasionesSociales),sum(pagoPorViaticos),sum(pagoPorRepresentacion),sum(pagoPorCompensaciones),sum(otrosPagos),sum(bonosElectronicos),sum(interesesCesantias),sum(pensionesJubilacion),sum(aportesSalud),sum(aportesPensiones),sum(aportesPensionesVoluntarios),sum(cuentasAFC),sum(retencionesFuenteRentas),nomina from exogena2276 group by tercero order by tercero";
	$resExogena=mysql_query($sqlrExogena,$linkbd);
	//echo "hola".$sqlrExogena;
	while($row=mysql_fetch_row($resExogena))
  	{
		$sqlrNomina = "select tipo,valor from humnomina_saludpension where id_nom>='$min' and id_nom<=$max and empleado='$row[0]'";
		//echo $sqlrNomina."<br>";
		$restNomina = mysql_query($sqlrNomina,$linkbd);
		$salud = 0;
		$pension = 0;
		while($rowtNomina = mysql_fetch_row($restNomina))
		{
			if($rowtNomina[0]=='SE')
			{
				$salud = $salud + $rowtNomina[1];
			}
			if ($rowtNomina[0]=='PE')
			{
				$pension = $pension + $rowtNomina[1];
			}
		}
		$row[14] = $row[14] + $salud;
		$row[15] = $row[15] + $pension;
		$sqlrt="select * from terceros where cedulanit='$row[0]'";
		//echo $sqlrt." - ".$_POST[terceros1][$x];
		$rest=mysql_query($sqlrt,$linkbd);
		$rowt=mysql_fetch_row($rest);
		$filbor="A".$xy.":AB".$xy;
		$objPHPExcel-> getActiveSheet ()
				-> getStyle ($filbor)
		-> getFont ()
		-> setBold ( false ) 
				-> setName ('Arial') 
				-> setSize ( 10 ) 
		-> getColor ()
		-> setRGB ('000000');
		$objPHPExcel->getActiveSheet()->getStyle($filbor)->applyFromArray($borders);
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValueExplicit ("A".$xy, utf8_encode($rowt[11]), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("B".$xy, utf8_encode($rowt[12]), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("C".$xy, utf8_encode($rowt[3]), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("D".$xy, utf8_encode($rowt[4]), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("E".$xy, utf8_encode($rowt[1]), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("F".$xy, utf8_encode($rowt[2]), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("G".$xy, utf8_encode($rowt[6]), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("H".$xy, utf8_encode($rowt[14]), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("I".$xy, utf8_encode($rowt[15]), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("J".$xy, "169", PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("K".$xy, utf8_encode(round($row[1])), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("L".$xy, utf8_encode(round($row[2])), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("M".$xy, utf8_encode(round($row[3])), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("N".$xy, utf8_encode(round($row[4])), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("O".$xy, utf8_encode(round($row[5])), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("P".$xy, utf8_encode(round($row[6])), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("Q".$xy, utf8_encode(round($row[7])), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("R".$xy, utf8_encode(round($row[8])), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("S".$xy, utf8_encode(round($row[9])), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("T".$xy, utf8_encode(round($row[10])), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("U".$xy, utf8_encode(round($row[11])), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("V".$xy, utf8_encode(round($row[12])), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("W".$xy, utf8_encode(round($row[13])), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("X".$xy, utf8_encode(round($row[14])), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("Y".$xy, utf8_encode(round($row[15])), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("Z".$xy, utf8_encode(round($row[16])), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("AA".$xy, utf8_encode(round($row[17])), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("AB".$xy, utf8_encode(round($row[18])), PHPExcel_Cell_DataType :: TYPE_NUMERIC);
		$xy++;
	}
	
	// Renombrar Hoja
	//$objPHPExcel->getActiveSheet()->setTitle('Listado Asistencia');
	// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
	$objPHPExcel->setActiveSheetIndex(0);
	// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="fmt2276_'.$_POST[vigencias].'.xlsx"');
	header('Cache-Control: max-age=0');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
	exit;
?>