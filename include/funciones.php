<?php

$host= $_SERVER["HTTP_HOST"];
$url= $_SERVER["REQUEST_URI"];
$url2 =$_SERVER["PHP_SELF"];

//include "comun.inc";
//****** BLOQUEOS USUARIO Y PERIODOS
function generaSuperavit($cuenta,$vigencia,$vigenciaf,$fechaf,$fechaf2){
	global $linkbd;
	$query="SELECT SUM(psd.valor) FROM pptosuperavit ps, pptosuperavit_detalle psd WHERE psd.cuenta='$cuenta' AND psd.vigencia=$vigencia AND NOT(ps.estado='N' OR psd.estado='R') AND ps.consvigencia=psd.consvigencia AND ps.fecha between '$fechaf' AND '$fechaf2' GROUP BY psd.cuenta";
	$result=mysql_query($query,$linkbd);
	$row=mysql_fetch_row($result);
	return $row[0];
}
function generaReporteIngresos($numCuenta,$vigencia,$fechaf,$fechaf2,$agregado = ''){
	$ejecucionxcuenta=Array();
	global $linkbd;
	$queryPresupuesto="SELECT valor,vigencia FROM pptocuentaspptoinicial WHERE cuenta='$numCuenta' AND vigencia=$vigencia";

	$result=mysql_query($queryPresupuesto, $linkbd);

				while($row=mysql_fetch_array($result)){

					$presuDefinitivo+=$row[0];
				 }

				$ejecucionxcuenta[0]=$presuDefinitivo;

			$queryAdiciones="SELECT SUM(pad.valor),pad.id_adicion,pa.fecha FROM pptoadiciones pad,pptoacuerdos pa WHERE pad.cuenta='$numCuenta' AND pad.vigencia=$vigencia AND pa.id_acuerdo=pad.id_acuerdo AND pad.id_acuerdo>0 AND NOT(pa.estado='N') AND pad.tipomovimiento<>'S' AND  pa.fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY cuenta";

			$result=mysql_query($queryAdiciones, $linkbd);
			$totentAdicion=0.0;
			$totsalAdicion=0.0;
				if(mysql_num_rows($result)!=0){
					while($row=mysql_fetch_array($result)){
					$presuDefinitivo+=$row[0];
					$totentAdicion+=$row[0];
					$totsalAdicion+=0.0;
				}
				}
	$ejecucionxcuenta[1]=$totentAdicion;



				$queryReducciones="SELECT SUM(pr.valor),pr.id_reduccion,pa.fecha FROM pptoreducciones pr,pptoacuerdos pa WHERE pr.cuenta='$numCuenta' AND pr.vigencia=$vigencia AND pr.id_acuerdo=pa.id_acuerdo AND pr.id_acuerdo>0 AND NOT(pa.estado='N') AND pa.fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY pr.cuenta";

				$result=mysql_query($queryReducciones, $linkbd);
				$totentReduccion=0.0;
				$totsalReduccion=0.0;
				if(mysql_num_rows($result)!=0){
					while($row=mysql_fetch_array($result)){
					$presuDefinitivo-=$row[0];
					$totentReduccion+=$row[0];
					$totsalReduccion+=0.0;
				}
			}
	$queryDispo="SELECT SUM(pad.valor),pad.id_adicion,pa.fecha FROM pptoadiciones pad,pptoacuerdos pa WHERE pad.cuenta='$numCuenta' AND pad.vigencia=$vigencia AND pa.id_acuerdo=pad.id_acuerdo AND pad.id_acuerdo>0 AND NOT(pa.estado='N') AND pad.tipomovimiento='S' AND  pa.fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY cuenta";

			$result=mysql_query($queryDispo, $linkbd);
			$totentDisponibilidad=0.0;
				if(mysql_num_rows($result)!=0){
					while($row=mysql_fetch_array($result)){
					$presuDefinitivo+=$row[0];
					$totentDisponibilidad+=$row[0];
				}
			}

	$supertavitdef=generaSuperavit($numCuenta,$vigencia,$vigencia,$fechaf,$fechaf2);
	$ejecucionxcuenta[2]=$totentReduccion;
	$presuDefinitivoSalida=$valCDP+$presuSalida;
	$ejecucionxcuenta[3]=$presuDefinitivo;
	$nuevafecha = strtotime ( '-1 day' , strtotime ( $fechaf ) ) ;
	$nuevafecha = date ( 'Y-m-j' , $nuevafecha );
	$ejecucionxcuenta[4]=generaRecaudo($numCuenta,$vigencia,$vigencia,$vigencia."-01-01",$nuevafecha);
	$ejecucionxcuenta[5]=generaRecaudo($numCuenta,$vigencia,$vigencia,$fechaf,$fechaf2);
	$ejecucionxcuenta[6]=$ejecucionxcuenta[4]+$ejecucionxcuenta[5];
	$ejecucionxcuenta[7]=$supertavitdef;
	$ejecucionxcuenta[8]=$totentDisponibilidad;
	if($agregado=="S")
	{
		$arreglo=generaReporteExternoIngreso($numCuenta,$vigencia,$fechaf,$fechaf2);
		$ejecucionxcuenta[0]+=$arreglo[0];  //INICIAL
		$ejecucionxcuenta[1]+=$arreglo[1];  //ADICION
		$ejecucionxcuenta[2]+=$arreglo[2];  //REDUCCION
	}

	return $ejecucionxcuenta;

	}

function generaRecaudo($cuenta,$vigencia,$vigenciaf,$fechaf,$fechaf2){
	global $linkbd;
	//////////////////////////////// YA!!
	$queryreccaja="SELECT SUM(prc.valor) FROM pptorecibocajappto prc,tesoreciboscaja trc WHERE prc.cuenta='$cuenta' AND prc.vigencia=$vigencia AND trc.id_recibos=prc.idrecibo AND NOT(trc.estado='N' OR trc.estado='R') AND NOT(prc.tipo='R' OR prc.tipo='P') AND trc.fecha between '$fechaf' AND '$fechaf2' GROUP BY prc.cuenta";
	$result=mysql_query($queryreccaja,$linkbd);
	$row=mysql_fetch_row($result);
	$totreccaja=$row[0];
	////////////////////////////////// YA!!
	$queryregalias="SELECT SUM(prd.valor) FROM pptoregalias_cab prc ,pptoregalias_det prd WHERE prc.codigo=prd.codigo AND prc.estado='S' AND prc.fecha between '$fechaf' AND '$fechaf2' AND prc.vigencia='$vigencia' AND prc.tipo_mov='101' AND prd.rubro='$cuenta' GROUP BY prd.rubro ";
	$result=mysql_query($queryregalias,$linkbd);
	$row=mysql_fetch_row($result);
	$totregalias=$row[0];
	////////////////////////////////// YA!!
	$querysinreccaja="SELECT SUM(psrc.valor) FROM pptosinrecibocajappto psrc,tesosinreciboscaja tsrc WHERE psrc.cuenta='$cuenta' AND psrc.vigencia=$vigencia AND tsrc.id_recibos=psrc.idrecibo AND NOT(tsrc.estado='N' OR tsrc.estado='R') AND tsrc.fecha between '$fechaf' AND '$fechaf2' GROUP BY psrc.cuenta";

	$result=mysql_query($querysinreccaja,$linkbd);
	$row=mysql_fetch_row($result);
	$totsinreccaja=$row[0];
	/////////////////////////////// YA!!
	$queryingssf="SELECT SUM(pissf.valor) FROM pptoingssf pissf,tesossfingreso_cab tissf WHERE pissf.cuenta='$cuenta' AND pissf.vigencia=$vigencia AND pissf.idrecibo=tissf.id_recaudo AND NOT(tissf.estado='N' OR tissf.estado='R') AND tissf.vigencia=$vigencia AND tissf.fecha between '$fechaf' AND '$fechaf2' GROUP BY pissf.cuenta";
	$result=mysql_query($queryingssf,$linkbd);
	$row=mysql_fetch_row($result);
	$totingssf=$row[0];
	/////////////////////// YA!!
	$querynotasban="SELECT SUM(pnb.valor) FROM pptonotasbanppto pnb,tesonotasbancarias_cab tnp WHERE pnb.cuenta='$cuenta' AND pnb.vigencia=$vigencia AND tnp.id_comp=pnb.idrecibo AND NOT(tnp.estado='R' OR tnp.estado='N')  AND tnp.vigencia=$vigencia AND tnp.fecha between '$fechaf' AND '$fechaf2' GROUP BY pnb.cuenta";
	$result=mysql_query($querynotasban,$linkbd);
	$row=mysql_fetch_row($result);
	$totnotasban=$row[0];
	/////////////////////// YA!!
	$queryrecatrans="SELECT SUM(pitp.valor) FROM pptoingtranppto pitp,tesorecaudotransferencia titp WHERE pitp.cuenta='$cuenta' AND pitp.vigencia=$vigencia AND pitp.idrecibo=titp.id_recaudo AND NOT(titp.estado='N' OR titp.estado='R') AND titp.fecha between '$fechaf' AND '$fechaf2' GROUP BY pitp.cuenta";
	$result=mysql_query($queryrecatrans,$linkbd);
	$row=mysql_fetch_row($result);
	$totrecatrans=$row[0];
	/////////////////////// YA!!
	$queryrecatrans="SELECT SUM(pitp.valor) FROM pptoingtranpptosgr pitp,tesorecaudotransferenciasgr titp WHERE pitp.cuenta='$cuenta' AND pitp.vigencia=$vigencia AND pitp.idrecibo=titp.id_recaudo AND NOT(titp.estado='N' OR titp.estado='R') AND titp.fecha between '$fechaf' AND '$fechaf2' GROUP BY pitp.cuenta";
	$result=mysql_query($queryrecatrans,$linkbd);
	$row=mysql_fetch_row($result);
	$totrecatransgr=$row[0];
	////////////////////// YA!!
	$queryretencionE="SELECT SUM(prc.valor) FROM pptoretencionpago prc,tesoegresos trc WHERE prc.cuenta='$cuenta' AND prc.vigencia=$vigencia AND trc.id_egreso=prc.idrecibo AND NOT(trc.estado='N') AND trc.fecha between '$fechaf' AND '$fechaf2' AND trc.tipo_mov='201' AND prc.tipo='egreso' AND NOT EXISTS (SELECT 1 FROM tesoegresos tra WHERE tra.id_egreso=trc.id_egreso  AND tra.tipo_mov='401') GROUP BY prc.cuenta";
	$result=mysql_query($queryretencionE,$linkbd);
	$row=mysql_fetch_row($result);
	$totretencionEgre=$row[0];
	///////////////////// YA!!
	$queryretencionO="SELECT SUM(prc.valor) FROM pptoretencionpago prc,tesoordenpago trc WHERE prc.cuenta='$cuenta' AND prc.vigencia=$vigencia AND trc.id_orden=prc.idrecibo AND NOT(trc.estado='N') AND trc.fecha between '$fechaf' AND '$fechaf2' AND trc.tipo_mov='201' AND prc.tipo='orden' AND NOT EXISTS (SELECT 1 FROM tesoordenpago tca WHERE tca.id_orden=trc.id_orden  AND tca.tipo_mov='401') GROUP BY prc.cuenta";
	$result=mysql_query($queryretencionO,$linkbd);
	$row=mysql_fetch_row($result);
	$totretencionOrden=$row[0];
	//////////////////// YA!!
	$querysuperavit="SELECT SUM(psd.valor) FROM pptosuperavit ps, pptosuperavit_detalle psd WHERE psd.cuenta='$cuenta' AND psd.vigencia=$vigencia AND NOT(ps.estado='N' OR psd.estado='R') AND ps.consvigencia=psd.consvigencia AND ps.fecha between '$fechaf' AND '$fechaf2' GROUP BY psd.cuenta";
	$result=mysql_query($querysuperavit,$linkbd);
	$row=mysql_fetch_row($result);
	$totsuperavit=$row[0];
	/////////////////////// YA!
	$querysuperavit="SELECT SUM(psd.valor) FROM pptoreservas ps, pptoreservas_det psd WHERE psd.cuenta='$cuenta' AND psd.vigencia=$vigencia AND NOT(ps.estado='N' OR psd.estado='R') AND ps.consvigencia=psd.consvigencia AND ps.fecha between '$fechaf' AND '$fechaf2' GROUP BY psd.cuenta";
	$result=mysql_query($querysuperavit,$linkbd);
	$row=mysql_fetch_row($result);
	$totreservas=$row[0];
	/////////////////////// YA!
	$querysuperavit="SELECT SUM(psd.valor) FROM pptoingresopresupuesto ps, pptoingresopresupuesto_det psd WHERE psd.cuenta='$cuenta' AND psd.vigencia=$vigencia AND NOT(ps.estado='N' OR psd.estado='R') AND ps.consvigencia=psd.consvigencia AND ps.fecha between '$fechaf' AND '$fechaf2' GROUP BY psd.cuenta";
	$result=mysql_query($querysuperavit,$linkbd);
	$row=mysql_fetch_row($result);
	$totingresopresupuesto=$row[0];
	//////////////////////// YA!
	$querysp="select sum(TB2.valor) from tesosinreciboscajasp TB1,pptosinrecibocajaspppto TB2 WHERE TB1.id_recibos=TB2.idrecibo AND TB1.estado='S' AND TB2.cuenta='$cuenta' AND TB2.vigencia=$vigencia AND TB1.vigencia=TB2.vigencia AND TB1.fecha between '$fechaf' AND '$fechaf2'  GROUP BY TB2.cuenta";
	//echo $querysp;
	$result=mysql_query($querysp,$linkbd);
	$row=mysql_fetch_row($result);
	$totsp=$row[0];
	//////////////////// YA!
	$queryrsp="SELECT SUM( servreciboscaja_det.valor ) FROM servreciboscaja_det, servreciboscaja WHERE servreciboscaja.estado =  'S' AND servreciboscaja.id_recibos = servreciboscaja_det.id_recibos AND servreciboscaja.vigencia =  $vigencia AND servreciboscaja_det.cuentapres =  '$cuenta' AND servreciboscaja.fecha BETWEEN  '$fechaf' AND  '$fechaf2' ";
	$result=mysql_query($queryrsp,$linkbd);
	$row=mysql_fetch_row($result);
	$totrsp=$row[0];

	$arreglo=generaReporteExternoIngreso($cuenta,$vigencia,$fechaf,$fechaf2);
	$valorRecaudadoEntidadExterna = $arreglo[3]; 

	$total=$totreccaja+$totsinreccaja+$totingssf+$totnotasban+$totrecatrans+$totrecatransg+$totretencionEgre+$totsuperavit+$totretencionOrden+$totsp+$totrsp+$totregalias+$totreservas + $totingresopresupuesto + $valorRecaudadoEntidadExterna;
	return $total;
	}
function generaReporteExterno($cuenta,$vigencia,$f1,$f2){
global $linkbd;
$ejecucionxcuenta=Array();
$sql="SELECT * FROM entidadesgastos,pptocuentashomologacion WHERE entidadesgastos.vigencia='$vigencia' AND pptocuentashomologacion.cuentacentral='$cuenta' AND pptocuentashomologacion.cuentaexterna=entidadesgastos.cuenta  AND pptocuentashomologacion.vigencia='$vigencia' AND entidadesgastos.trimestre=(SELECT MAX(ent.trimestre) FROM  entidadesgastos ent WHERE ent.vigencia='$vigencia' ) AND entidadesgastos.fecha between '$f1' AND '$f2' AND pptocuentashomologacion.unidad=entidadesgastos.unidad";
$res=mysql_query($sql,$linkbd);
while ($row = mysql_fetch_row($res)){
	$ejecucionxcuenta[0]=$row[2];  //Inicial
	$ejecucionxcuenta[1]=$row[3];  //Adicion
	$ejecucionxcuenta[2]=$row[4];  //Reduccion
	$ejecucionxcuenta[3]=$row[5];  //Creditos
	$ejecucionxcuenta[4]=$row[6];  //Contracredito
	$ejecucionxcuenta[5]=$row[7];  //Definitivo
	$ejecucionxcuenta[6]=$row[8];  //cdp
	$ejecucionxcuenta[7]=$row[9];  //rp
	$ejecucionxcuenta[8]=$row[10];  //cxp
	$ejecucionxcuenta[9]=$row[11];  //compromiso en ejec.
	$ejecucionxcuenta[10]=$row[12];  //egreso
	$ejecucionxcuenta[11]=$row[14];  //saldo
	$ejecucionxcuenta[12]=$row[15];  //unidad
	$ejecucionxcuenta[13]=$row[16];  //vigencia
	$ejecucionxcuenta[14]=$row[17];  //trimestre
}
return $ejecucionxcuenta;
}
function generaReporteExternoIngreso($cuenta,$vigencia,$f1,$f2)
{
	global $linkbd;
	$ejecucionxcuenta=Array();
	$sqlr = "SELECT * FROM entidadesing WHERE  vigencia='$vigencia' AND cuenta='$cuenta' AND trimestre=(SELECT MAX(ent.trimestre) FROM  entidadesgastos ent WHERE ent.vigencia='$vigencia' ) AND fecha between '$f1' AND '$f2'";
	
	$res=mysql_query($sqlr,$linkbd);
	while ($row = mysql_fetch_row($res)){
		$ejecucionxcuenta[0]=$row[1];  //Inicial
		$ejecucionxcuenta[1]=$row[2];  //Adicion
		$ejecucionxcuenta[2]=$row[4];  //Reduccion
		$ejecucionxcuenta[3]=$row[7];  //Reduccion
	}
	return $ejecucionxcuenta;
}
function generaReporteGastos($numCuenta,$vigencia,$fechaf,$fechaf2,$regalias,$vigenciari,$vigenciarf,$agregado){
	global $linkbd;
	$ejecucionxcuenta=Array();
	global $linkbd;
	$queryPresupuesto="SELECT valor,vigencia FROM pptocuentaspptoinicial WHERE cuenta='$numCuenta' AND vigencia=$vigencia";
	$result=mysql_query($queryPresupuesto, $linkbd);

		while($row=mysql_fetch_array($result)){

			$presuDefinitivo+=$row[0];
		 }

		$ejecucionxcuenta[0]=$presuDefinitivo;
		if($regalias=='S'){
			$fecha1=split("-",$fechaf);
			$fecha2=split("-",$fechaf2);
			$fechar1=$vigenciari."-".$fecha1[1]."-".$fecha1[2];
			$fechar2=$vigenciari."-".$fecha2[1]."-".$fecha2[2];
			$fechar3=$vigenciarf."-".$fecha1[1]."-".$fecha1[2];
			$fechar4=$vigenciarf."-".$fecha2[1]."-".$fecha2[2];
			$querySalidaPresuDefi="SELECT SUM(D.valor) FROM pptocdp C, pptocdp_detalle D WHERE D.cuenta='$numCuenta' AND (D.vigencia=$vigenciari OR D.vigencia=$vigenciarf) AND D.tipo_mov='201' AND D.consvigencia=C.consvigencia AND C.tipo_mov='201' AND (C.vigencia=$vigenciari OR C.vigencia=$vigenciarf) AND NOT(D.estado='N' OR D.estado='R') GROUP BY D.cuenta";
		}else{
			$querySalidaPresuDefi="SELECT SUM(D.valor) FROM pptocdp C, pptocdp_detalle D WHERE D.cuenta='$numCuenta' AND D.vigencia=$vigencia AND D.tipo_mov='201' AND D.consvigencia=C.consvigencia AND C.tipo_mov='201' AND C.vigencia=$vigencia AND NOT(D.estado='N' OR D.estado='R') AND C.fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY D.cuenta";
		}

		$valCDP=0.0;
		$result=mysql_query($querySalidaPresuDefi, $linkbd);
		if(mysql_num_rows($result)!=0){
			while($row=mysql_fetch_array($result)){
		$valCDP=$row[0];
			}
		}
	if($regalias=='S'){
		$fecha1=split("-",$fechaf);
			$fecha2=split("-",$fechaf2);
			$fechar1=$vigenciari."-".$fecha1[1]."-".$fecha1[2];
			$fechar2=$vigenciari."-".$fecha2[1]."-".$fecha2[2];
			$fechar3=$vigenciarf."-".$fecha1[1]."-".$fecha1[2];
			$fechar4=$vigenciarf."-".$fecha2[1]."-".$fecha2[2];

		$queryAdiciones="SELECT SUM(pad.valor),pad.id_adicion,pa.fecha FROM pptoadiciones pad,pptoacuerdos pa WHERE pad.cuenta='$numCuenta' AND (pad.vigencia=$vigenciari OR pad.vigencia=$vigenciarf) AND pa.id_acuerdo=pad.id_acuerdo AND pad.id_acuerdo>0 AND NOT(pa.estado='N') AND  pad.fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY cuenta";
	}else{
		$queryAdiciones="SELECT SUM(pad.valor),pad.id_adicion,pa.fecha FROM pptoadiciones pad,pptoacuerdos pa WHERE pad.cuenta='$numCuenta' AND pad.vigencia=$vigencia AND pa.id_acuerdo=pad.id_acuerdo AND pad.id_acuerdo>0 AND NOT(pa.estado='N') AND  pa.fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY cuenta";
	}


	$result=mysql_query($queryAdiciones, $linkbd);
	$totentAdicion=0.0;
	$totsalAdicion=0.0;
		if(mysql_num_rows($result)!=0){
			while($row=mysql_fetch_array($result)){
			$presuDefinitivo+=$row[0];
			$totentAdicion+=$row[0];
			$totsalAdicion+=0.0;
		}
		}
		$ejecucionxcuenta[1]=$totentAdicion;
		if($regalias=='S'){
			$fecha1=split("-",$fechaf);
			$fecha2=split("-",$fechaf2);
			$fechar1=$vigenciari."-".$fecha1[1]."-".$fecha1[2];
			$fechar2=$vigenciari."-".$fecha2[1]."-".$fecha2[2];
			$fechar3=$vigenciarf."-".$fecha1[1]."-".$fecha1[2];
			$fechar4=$vigenciarf."-".$fecha2[1]."-".$fecha2[2];
			$queryReducciones="SELECT SUM(pr.valor),pr.id_reduccion,pa.fecha FROM pptoreducciones pr,pptoacuerdos pa WHERE pr.cuenta='$numCuenta' AND (pr.vigencia=$vigenciari OR pr.vigencia=$vigenciarf) AND pr.id_acuerdo=pa.id_acuerdo AND pr.id_acuerdo>0 AND NOT(pa.estado='N') GROUP BY pr.cuenta";

		}else{
			$queryReducciones="SELECT SUM(pr.valor),pr.id_reduccion,pa.fecha FROM pptoreducciones pr,pptoacuerdos pa WHERE pr.cuenta='$numCuenta' AND pr.vigencia=$vigencia AND pr.id_acuerdo=pa.id_acuerdo AND pr.id_acuerdo>0 AND NOT(pa.estado='N') AND pa.fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY pr.cuenta";

		}


		$result=mysql_query($queryReducciones, $linkbd);
		$totentReduccion=0.0;
		$totsalReduccion=0.0;
		if(mysql_num_rows($result)!=0){
			while($row=mysql_fetch_array($result)){
			$presuDefinitivo-=$row[0];
			$totentReduccion+=$row[0];
			$totsalReduccion+=0.0;
		}
		}

$ejecucionxcuenta[2]=$totentReduccion;
		if($regalias=='S'){
			$fecha1=split("-",$fechaf);
			$fecha2=split("-",$fechaf2);
			$fechar1=$vigenciari."-".$fecha1[1]."-".$fecha1[2];
			$fechar2=$vigenciari."-".$fecha2[1]."-".$fecha2[2];
			$fechar3=$vigenciarf."-".$fecha1[1]."-".$fecha1[2];
			$fechar4=$vigenciarf."-".$fecha2[1]."-".$fecha2[2];
			$queryTraslados="SELECT pt.id_acuerdo,pt.tipo,SUM(pt.valor),pa.fecha FROM pptotraslados pt,pptoacuerdos pa WHERE pt.cuenta='$numCuenta' AND (pt.vigencia=$vigenciari OR pt.vigencia=$vigenciarf) AND pt.id_acuerdo>0 AND  pt.id_acuerdo=pa.id_acuerdo AND NOT(pa.estado='N')  GROUP BY pt.id_acuerdo,pt.tipo";
		}else{
			$queryTraslados="SELECT pt.id_acuerdo,pt.tipo,SUM(pt.valor),pa.fecha FROM pptotraslados pt,pptoacuerdos pa WHERE pt.cuenta='$numCuenta' AND pt.vigencia=$vigencia AND pt.id_acuerdo>0 AND  pt.id_acuerdo=pa.id_acuerdo AND NOT(pa.estado='N') AND pa.fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY pt.id_acuerdo,pt.tipo";
		}



		$presuSalida=0.0;
		$totentTraslado=0.0;
		$totsalTraslado=0.0;
		$result=mysql_query($queryTraslados, $linkbd);
		if(mysql_num_rows($result)!=0){
			while($row=mysql_fetch_array($result)){

			if($row[1]=='R'){
			$presuSalida+=$row[2];
			$totsalTraslado+=$row[2];
			$presuDefinitivo-=$row[2];
			}
			else{

			$presuDefinitivo+=$row[2];
			$totentTraslado+=$row[2];
			}
		echo "</tr>";
		}
	}
	$ejecucionxcuenta[3]=$totentTraslado;
	$ejecucionxcuenta[4]=$totsalTraslado;

	$presuDefinitivoSalida=round($valCDP,2)+round($presuSalida,2);
	$ejecucionxcuenta[5]=round($presuDefinitivo,2);

	$totalCDPEnt=0;
	$totalCDPSal=0;
	$pos=0;
	$pos1=0;
	if($regalias=='S'){
		$fecha1=split("-",$fechaf);
		$fecha2=split("-",$fechaf2);
		$fechar1=$vigenciari."-".$fecha1[1]."-".$fecha1[2];
		$fechar2=$vigenciari."-".$fecha2[1]."-".$fecha2[2];
		$fechar3=$vigenciarf."-".$fecha1[1]."-".$fecha1[2];
		$fechar4=$vigenciarf."-".$fecha2[1]."-".$fecha2[2];
		$queryTraslados="SELECT D.consvigencia,SUM(D.valor),D.tipo_mov FROM  pptocdp DC, pptocdp_detalle D WHERE D.cuenta='$numCuenta' AND (D.vigencia=$vigenciari OR D.vigencia=$vigenciarf)  AND NOT(D.estado='N') AND D.valor>0 AND DC.fecha BETWEEN '$fechaf' AND '$fechaf2' AND DC.consvigencia=D.consvigencia AND DC.vigencia = D.vigencia GROUP BY D.consvigencia,D.tipo_mov";
		
		$queryTraslados="SELECT C.consvigencia,C.fecha,C.objeto,C.tipo_mov,SUM(D.valor),D.tipo_mov FROM pptocdp C, pptocdp_detalle D WHERE D.cuenta='$numCuenta' AND (D.vigencia=$vigenciari OR D.vigencia=$vigenciarf) AND D.consvigencia=C.consvigencia AND C.vigencia = D.vigencia AND (C.vigencia=$vigenciari OR C.vigencia=$vigenciarf) AND NOT(D.estado='N') AND D.valor>0 AND D.tipo_mov=C.tipo_mov AND D.tipo_mov='201' AND C.fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY C.consvigencia,C.tipo_mov UNION SELECT C.consvigencia,C.fecha,C.objeto,C.tipo_mov,SUM(D.valor),D.tipo_mov FROM pptocdp C, pptocdp_detalle D WHERE D.cuenta='$numCuenta' AND C.fecha BETWEEN '$fechaf' AND '$fechaf2' AND C.vigencia = D.vigencia AND (D.vigencia=$vigenciari OR D.vigencia=$vigenciarf) AND D.consvigencia=C.consvigencia AND (C.vigencia=$vigenciari OR C.vigencia=$vigenciarf) AND NOT(D.estado='N') AND D.valor>0 AND D.tipo_mov=C.tipo_mov AND (D.tipo_mov='401' OR D.tipo_mov='402') AND EXISTS(SELECT 1 FROM pptocdp DAUX WHERE DAUX.consvigencia=D.consvigencia AND DAUX.tipo_mov='201') GROUP BY C.consvigencia,C.tipo_mov";
		//echo $queryTraslados."<br><BR>";
		$pos=4;
		$pos1=5;
	}else{
		$queryTraslados="SELECT C.consvigencia,C.fecha,C.objeto,C.tipo_mov,SUM(D.valor),D.tipo_mov FROM pptocdp C, pptocdp_detalle D WHERE D.cuenta='$numCuenta' AND D.vigencia=$vigencia AND D.consvigencia=C.consvigencia AND C.vigencia=$vigencia AND NOT(D.estado='N') AND D.valor>0 AND D.tipo_mov=C.tipo_mov AND D.tipo_mov='201' AND C.fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY C.consvigencia,C.tipo_mov UNION SELECT C.consvigencia,C.fecha,C.objeto,C.tipo_mov,SUM(D.valor),D.tipo_mov FROM pptocdp C, pptocdp_detalle D WHERE D.cuenta='$numCuenta' AND D.vigencia=$vigencia AND D.consvigencia=C.consvigencia AND C.vigencia=$vigencia AND NOT(D.estado='N') AND D.valor>0 AND D.tipo_mov=C.tipo_mov AND (D.tipo_mov='401' OR D.tipo_mov='402') AND EXISTS(SELECT 1 FROM pptocdp DAUX WHERE DAUX.consvigencia=D.consvigencia AND DAUX.tipo_mov='201' AND DAUX.fecha BETWEEN '$fechaf' AND '$fechaf2') GROUP BY C.consvigencia,C.tipo_mov";
		$pos=4;
		$pos1=5;
	}
	//echo $queryTraslados."<br>";
		$result=mysql_query($queryTraslados, $linkbd);
				if(mysql_num_rows($result)!=0){
					while($row=mysql_fetch_array($result)){
					if($row[$pos1]=='201'){
						$totalCDPEnt+=round($row[$pos],2);
					}else if(($row[$pos1]=='401') || ($row[$pos1]=='402')){
						$totalCDPEnt-=round($row[$pos],2);
					}

				}
				}
		$ejecucionxcuenta[6]=$totalCDPEnt;

				$totalRPEnt=0;
				$totalRPSal=0;
				$arregloRP=Array();
				$pos=0;
				$pos1=0;
				if($regalias=='S'){
					$fecha1=split("-",$fechaf);
					$fecha2=split("-",$fechaf2);
					$fechar1=$vigenciari."-".$fecha1[1]."-".$fecha1[2];
					$fechar2=$vigenciari."-".$fecha2[1]."-".$fecha2[2];
					$fechar3=$vigenciarf."-".$fecha1[1]."-".$fecha1[2];
					$fechar4=$vigenciarf."-".$fecha2[1]."-".$fecha2[2];
					$queryTraslados="SELECT RD.consvigencia,RD.tipo_mov,SUM(RD.valor) FROM pptorp_detalle RD where RD.cuenta='$numCuenta' AND (RD.vigencia=$vigenciari OR RD.vigencia=$vigenciarf)  AND NOT(RD.estado='N') AND RD.valor>0  GROUP BY RD.consvigencia,RD.tipo_mov";

					$queryTraslados="SELECT R.consvigencia,R.fecha,R.tipo_mov,SUM(RD.valor),RD.tipo_mov FROM pptorp R,pptorp_detalle RD where  (R.vigencia=$vigenciari OR R.vigencia=$vigenciarf) AND RD.cuenta='$numCuenta' AND RD.consvigencia=R.consvigencia AND (RD.vigencia=$vigenciari OR RD.vigencia=$vigenciarf)  AND R.vigencia = RD.vigencia AND NOT(R.estado='N') AND R.tipo_mov=RD.tipo_mov AND R.tipo_mov='201' AND RD.valor>0 AND R.fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY R.consvigencia,R.tipo_mov UNION SELECT R.consvigencia,R.fecha,R.tipo_mov,SUM(RD.valor),RD.tipo_mov FROM pptorp R,pptorp_detalle RD where  (R.vigencia=$vigenciari OR R.vigencia=$vigenciarf) AND RD.cuenta='$numCuenta' AND RD.consvigencia=R.consvigencia AND (RD.vigencia=$vigenciari OR RD.vigencia=$vigenciarf)  AND NOT(R.estado='N') AND R.tipo_mov=RD.tipo_mov AND R.vigencia = RD.vigencia AND (R.tipo_mov='401' OR R.tipo_mov='402') AND RD.valor>0 AND EXISTS(SELECT 1 FROM pptorp RAUX WHERE RAUX.consvigencia=R.consvigencia AND RAUX.tipo_mov='201' AND RAUX.fecha BETWEEN '$fechaf' AND '$fechaf2')  GROUP BY R.consvigencia,R.tipo_mov";
					$pos=3;
					$pos1=4;
				}else{
					$queryTraslados="SELECT R.consvigencia,R.fecha,R.tipo_mov,SUM(RD.valor),RD.tipo_mov FROM pptorp R,pptorp_detalle RD where  R.vigencia=$vigencia AND RD.cuenta='$numCuenta' AND RD.consvigencia=R.consvigencia AND RD.vigencia=$vigencia  AND NOT(R.estado='N') AND R.tipo_mov=RD.tipo_mov AND R.tipo_mov='201' AND RD.valor>0 AND R.fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY R.consvigencia,R.tipo_mov UNION SELECT R.consvigencia,R.fecha,R.tipo_mov,SUM(RD.valor),RD.tipo_mov FROM pptorp R,pptorp_detalle RD where  R.vigencia=$vigencia AND RD.cuenta='$numCuenta' AND RD.consvigencia=R.consvigencia AND RD.vigencia=$vigencia  AND NOT(R.estado='N') AND R.tipo_mov=RD.tipo_mov AND (R.tipo_mov='401' OR R.tipo_mov='402') AND RD.valor>0 AND EXISTS(SELECT 1 FROM pptorp RAUX WHERE RAUX.consvigencia=R.consvigencia AND RAUX.tipo_mov='201' AND RAUX.fecha BETWEEN '$fechaf' AND '$fechaf2')  GROUP BY R.consvigencia,R.tipo_mov";
					$pos=3;
					$pos1=4;
				}

				$result=mysql_query($queryTraslados, $linkbd);
				if(mysql_num_rows($result)!=0){

					while($row=mysql_fetch_array($result)){
						if( $row[$pos1]=='201'){
						$totalRPEnt+=$row[$pos];
						$arregloRP[]=$row[0];
					}else if(( $row[$pos1]=='401') || ($row[$pos1]=='402')){
						$totalRPEnt-=$row[$pos];
					}



				}
				}
	$ejecucionxcuenta[7]=$totalRPEnt;

				$totalCxPEnt=0.0;
				$totalCxPSal=0.0;
				if($regalias=='S'){
					$fecha1=split("-",$fechaf);
					$fecha2=split("-",$fechaf2);
					$fechar1=$vigenciari."-".$fecha1[1]."-".$fecha1[2];
					$fechar2=$vigenciari."-".$fecha2[1]."-".$fecha2[2];
					$fechar3=$vigenciarf."-".$fecha1[1]."-".$fecha1[2];
					$fechar4=$vigenciarf."-".$fecha1[1]."-".$fecha1[2];
					$queryTraslados="SELECT T.id_orden,T.fecha,T.tipo_mov,TD.valor,T.estado,TD.tipo_mov FROM tesoordenpago T,tesoordenpago_det TD WHERE (T.vigencia=$vigenciari OR T.vigencia=$vigenciarf)  AND T.id_orden=TD.id_orden AND NOT(T.estado='N') AND TD.valor>0 AND TD.cuentap='$numCuenta' AND T.tipo_mov=TD.tipo_mov ";

					$queryTraslados="SELECT T.id_orden,T.fecha,T.tipo_mov,TD.valor,T.estado,TD.tipo_mov FROM tesoordenpago T,tesoordenpago_det TD WHERE (T.vigencia=$vigenciari OR T.vigencia=$vigenciarf)  AND T.id_orden=TD.id_orden AND NOT(T.estado='N') AND TD.valor>0 AND TD.cuentap='$numCuenta' AND T.tipo_mov=TD.tipo_mov AND T.tipo_mov='201' AND T.fecha BETWEEN '$fechaf' AND '$fechaf2' UNION SELECT T.id_orden,T.fecha,T.tipo_mov,TD.valor,T.estado,TD.tipo_mov FROM tesoordenpago T,tesoordenpago_det TD WHERE (T.vigencia=$vigenciari OR T.vigencia=$vigenciarf)  AND T.id_orden=TD.id_orden AND NOT(T.estado='N') AND TD.valor>0 AND TD.cuentap='$numCuenta' AND T.tipo_mov=TD.tipo_mov AND (T.tipo_mov='401' OR T.tipo_mov='402') AND EXISTS(SELECT 1 FROM tesoordenpago TAUX WHERE TAUX.id_orden=T.id_orden AND TAUX.tipo_mov='201' AND TAUX.fecha BETWEEN '$fechaf' AND '$fechaf2') ";

				}else{
					$queryTraslados="SELECT T.id_orden,T.fecha,T.tipo_mov,TD.valor,T.estado,TD.tipo_mov FROM tesoordenpago T,tesoordenpago_det TD WHERE T.vigencia=$vigencia  AND T.id_orden=TD.id_orden AND NOT(T.estado='N') AND TD.valor>0 AND TD.cuentap='$numCuenta' AND T.tipo_mov=TD.tipo_mov AND T.tipo_mov='201' AND T.fecha BETWEEN '$fechaf' AND '$fechaf2' UNION SELECT T.id_orden,T.fecha,T.tipo_mov,TD.valor,T.estado,TD.tipo_mov FROM tesoordenpago T,tesoordenpago_det TD WHERE T.vigencia=$vigencia  AND T.id_orden=TD.id_orden AND NOT(T.estado='N') AND TD.valor>0 AND TD.cuentap='$numCuenta' AND T.tipo_mov=TD.tipo_mov AND (T.tipo_mov='401' OR T.tipo_mov='402') AND EXISTS(SELECT 1 FROM tesoordenpago TAUX WHERE TAUX.id_orden=T.id_orden AND TAUX.tipo_mov='201' AND TAUX.fecha BETWEEN '$fechaf' AND '$fechaf2') ";
				}

				$result=mysql_query($queryTraslados, $linkbd);
				if(mysql_num_rows($result)!=0){
					$salida=0.0;
					while($row=mysql_fetch_array($result)){

					if($row[5]=='201'){
						$totalCxPEnt+=$row[3];
					}else if($row[5]=='401'){
						$totalCxPEnt-=$row[3];
					}



				}
				}
		$totalEgresoEnt=0.0;

		$queryssf="SELECT E.id_orden,SUM(ED.valor) FROM  tesossfegreso_cab E, tesossfegreso_det ED WHERE E.id_orden=ED.id_egreso AND E.vigencia=$vigencia AND E.fecha BETWEEN '$fechaf' AND '$fechaf2' AND ED.cuentap='$numCuenta' AND E.estado='S' GROUP BY E.id_orden";

			$result=mysql_query($queryssf, $linkbd);
				if(mysql_num_rows($result)!=0){
					$salida=0.0;
					while($row=mysql_fetch_array($result)){


						$totalCxPEnt+=$row[1];
						$totalEgresoEnt+=$row[1];



				}
				}
		$queryEgresoCAjaMenor = "SELECT EC.id, SUM(ECD.valor) FROM tesoegresocajamenor EC, tesoegresocajamenor_det ECD WHERE EC.id = ECD.id_egreso AND EC.vigencia=$vigencia AND EC.fecha BETWEEN '$fechaf' AND '$fechaf2' AND ECD.cuentap='$numCuenta' 	AND EC.estado='S' GROUP BY EC.id";
		$result=mysql_query($queryEgresoCAjaMenor, $linkbd);
		if(mysql_num_rows($result)!=0)
		{
			$salida=0.0;
			while($row=mysql_fetch_array($result))
			{
				$totalCxPEnt+=$row[1];
				$totalEgresoEnt+=$row[1];
			}
		}

		for ($i=0; $i <sizeof($arregloRP); $i++) {
				$queryTraslados="SELECT HN.id_nom,HN.periodo,SUM(HNP.valor),HN.fecha FROM hum_nom_cdp_rp HNR,humnom_presupuestal HNP,humnomina HN WHERE HNR.rp=$arregloRP[$i] AND HNR.nomina=HNP.id_nom AND HNP.cuenta='$numCuenta' AND HNR.vigencia=$vigencia AND  NOT(HNR.estado='N' OR HNR.estado='R') AND HNP.valor>0 AND HN.id_nom=HNR.nomina AND HN.fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY HNP.id_nom";
				//echo $queryTraslados."<br>";
				$result=mysql_query($queryTraslados, $linkbd);
			if(mysql_num_rows($result)==0)
				echo "";
			else{
				while($row=mysql_fetch_array($result)){
					$queryegreso="SELECT SUM(TEND.valordevengado) FROM tesoegresosnomina TEN,tesoegresosnomina_det TEND WHERE  TEN.id_orden=".$row[0]." AND TEN.vigencia=$vigencia AND NOT(TEN.estado='N' OR TEN.estado='R')  AND TEN.fecha BETWEEN '$fechaf' AND '$fechaf2' AND TEN.id_egreso=TEND.id_egreso AND NOT(TEND.tipo='SE' OR TEND.tipo='PE' OR TEND.tipo='DS' OR TEND.tipo='RE') AND TEND.cuentap='$numCuenta' ";
					//echo $queryegreso."<br>";
					$resultegre=mysql_query($queryegreso, $linkbd);

					$rowegre=mysql_fetch_array($resultegre);

				$totalCxPEnt+=$row[2];
				$totalEgresoEnt+=$rowegre[0];
				//echo $totalCxPEnt."<br>";
				}
			}

		}

		for ($i=0; $i <sizeof($arregloRP); $i++) {
			$queryTraslados="SELECT TEN.id_orden,TEN.concepto,TEN.id_egreso,TEN.fecha,SUM(TEND.valordevengado) FROM hum_nom_cdp_rp HNR,tesoegresosnomina TEN,tesoegresosnomina_det TEND WHERE HNR.rp=$arregloRP[$i]  AND HNR.vigencia=$vigencia  AND NOT(HNR.estado='N' OR HNR.estado='R') AND TEN.id_orden=HNR.nomina AND  TEN.vigencia=$vigencia AND NOT(TEN.estado='N' OR TEN.estado='R') AND TEN.fecha BETWEEN '$fechaf' AND '$fechaf2' AND TEN.id_egreso=TEND.id_egreso AND TEND.cuentap='$numCuenta' AND NOT(TEND.tipo='SE' OR TEND.tipo='PE' OR TEND.tipo='DS' OR TEND.tipo='RE') GROUP BY TEN.id_egreso";

			$result=mysql_query($queryTraslados, $linkbd);
		if(mysql_num_rows($result)==0)
			echo "";
		else{
			while($row=mysql_fetch_array($result)){
			$arregloEgresosNom[]=@Array("id" => "$row[2]",
				"concepto" => "Egreso de nomina",
				"valor" => "$row[4]",
				"fecha" => "$row[3]");


			}
		}

	}

	$ejecucionxcuenta[8]=$totalCxPEnt;


				$totalEgresoSal=0.0;
				if($regalias=='S'){
					$fecha1=split("-",$fechaf);
					$fecha2=split("-",$fechaf2);
					$fechar1=$vigenciari."-".$fecha1[1]."-".$fecha1[2];
					$fechar2=$vigenciari."-".$fecha2[1]."-".$fecha2[2];
					$fechar3=$vigenciarf."-".$fecha1[1]."-".$fecha1[2];
					$fechar4=$vigenciarf."-".$fecha2[1]."-".$fecha2[2];
					$queryTraslados="SELECT TE.id_egreso,TE.fecha,TE.tipo_mov,TD.valor FROM tesoegresos TE,tesoordenpago_det TD where (TE.vigencia=$vigenciari OR TE.vigencia=$vigenciarf) AND TD.cuentap='$numCuenta' AND TE.id_orden=TD.id_orden AND  NOT(TE.estado='N') AND TD.valor >0 ";
					
					$queryTraslados="SELECT TE.id_egreso,TE.fecha,TE.tipo_mov,TD.valor FROM tesoegresos TE,tesoordenpago_det TD, tesoordenpago TIA where (TIA.vigencia=$vigenciari OR TIA.vigencia=$vigenciarf) AND TIA.id_orden=TD.id_orden AND TD.cuentap='$numCuenta' AND TE.id_orden=TD.id_orden AND  NOT(TE.estado='N') AND TD.valor >0 AND TE.tipo_mov='201' AND TE.fecha BETWEEN '$fechaf' AND '$fechaf2' UNION SELECT TE.id_egreso,TE.fecha,TE.tipo_mov,TD.valor FROM tesoegresos TE,tesoordenpago_det TD,tesoordenpago TIO where (TIO.vigencia=$vigenciari OR TIO.vigencia=$vigenciarf) AND TIO.id_orden=TD.id_orden AND TD.cuentap='$numCuenta' AND TE.id_orden=TD.id_orden AND  NOT(TE.estado='N') AND TD.valor >0 AND TE.tipo_mov='401'  AND EXISTS(SELECT 1 FROM tesoegresos TEAUX WHERE TEAUX.id_egreso=TE.id_egreso AND TEAUX.tipo_mov='201' AND TEAUX.fecha BETWEEN '$fechaf' AND '$fechaf2')";

				}else{
					$queryTraslados="SELECT TE.id_egreso,TE.fecha,TE.tipo_mov,TD.valor FROM tesoegresos TE,tesoordenpago_det TD, tesoordenpago TIA where TIA.vigencia=$vigencia AND TIA.id_orden=TD.id_orden AND TD.cuentap='$numCuenta' AND TE.id_orden=TD.id_orden AND  NOT(TE.estado='N') AND TD.valor >0 AND TE.tipo_mov='201' AND TE.fecha BETWEEN '$fechaf' AND '$fechaf2' UNION SELECT TE.id_egreso,TE.fecha,TE.tipo_mov,TD.valor FROM tesoegresos TE,tesoordenpago_det TD,tesoordenpago TIO where TIO.vigencia=$vigencia AND TIO.id_orden=TD.id_orden AND TD.cuentap='$numCuenta' AND TE.id_orden=TD.id_orden AND  NOT(TE.estado='N') AND TD.valor >0 AND TE.tipo_mov='401'  AND EXISTS(SELECT 1 FROM tesoegresos TEAUX WHERE TEAUX.id_egreso=TE.id_egreso AND TEAUX.tipo_mov='201' AND TEAUX.fecha BETWEEN '$fechaf' AND '$fechaf2')";
				}

				$result=mysql_query($queryTraslados, $linkbd);
				if(mysql_num_rows($result)!=0){
					while($row=mysql_fetch_array($result)){
					if($row[2]=='201'){
						$totalEgresoEnt+=$row[3];
					}else if($row[2]=='401'){
						$totalEgresoEnt-=$row[3];
					}



				}
				}

				for($i=0;$i<sizeof($arregloEgresosNom);$i++){
					$valor=$arregloEgresosNom[$i]['valor'];
					//$totalEgresoEnt+=$valor;
				}
	$ejecucionxcuenta[9]=$totalEgresoEnt;
	$ejecucionxcuenta[10]=$presuDefinitivo-$totalCDPEnt;
	$ejecucionxcuenta[11]=$numCuenta;
	$sql="SELECT 1 FROM pptocuentashomologacion WHERE cuentacentral='$numCuenta' ";
	$res=mysql_query($sql,$linkbd);
	$num = mysql_num_rows($res);

	if($agregado=="S" && $num>0){
		$arreglo=generaReporteExterno($numCuenta,$vigencia,$fechaf,$fechaf2);
		$ejecucionxcuenta[0]=$arreglo[0];  //INICIAL
		$ejecucionxcuenta[1]=$arreglo[1];  //ADICION
		$ejecucionxcuenta[2]=$arreglo[2];  //REDUCCION
		$ejecucionxcuenta[3]=$arreglo[3];  //CREDITO
		$ejecucionxcuenta[4]=$arreglo[4];  //CONTRACREDITO
		$ejecucionxcuenta[5]=$arreglo[5];  //DEFINITIVO
		$ejecucionxcuenta[6]=$arreglo[6];  //CDP
		$ejecucionxcuenta[7]=$arreglo[7];  //RP
		$ejecucionxcuenta[8]=$arreglo[8];  //CXP
		$ejecucionxcuenta[9]=$arreglo[10];  //EGRESO
		$ejecucionxcuenta[10]=$arreglo[11]; //SALDO

	}

	return $ejecucionxcuenta;

}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function generaReporteSinPagos($codcatastral,$vigusu1)
{
	global $linkbd,$Descriptor1;
	$_POST[var1]=0;
	$_POST[var2]=0;
	$sqlr="select valor_inicial,valor_final, tipo from dominios where nombre_dominio='BASE_PREDIAL' ";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)){$_POST[basepredial]=$row[0];}
	$sqlr="select valor_inicial,valor_final, tipo from dominios where nombre_dominio='BASE_PREDIALAMB' ";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)){$_POST[basepredialamb]=$row[0];}
	$sqlr="select valor_inicial,valor_final, tipo from dominios where nombre_dominio='NORMA_PREDIAL' ";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)){
		$_POST[aplicapredial]=$row[0];}
	$sqlr="select valor_inicial,valor_final, tipo from dominios where nombre_dominio='DESC_INTERESES' ";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res))
	{
		$_POST[vigmaxdescint]=$row[0];
		$_POST[porcdescint]=$row[1];
		$_POST[aplicadescint]=$row[2];
	}
	$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
	$fec=date("d/m/Y");
	$_POST[fecha]=$fec;
	$_POST[fechaav]=$_POST[fecha];
	$_POST[vigencia]=$vigusu;
	$sqlr="select *from tesotasainteres where vigencia=".$vigusu;

	$res=mysql_query($sqlr,$linkbd);
	$r=mysql_fetch_row($res);
	$tasam=array();
	$tasam[0]=$r[14];
	$tasam[1]=$r[15];
	$tasam[2]=$r[16];
	$tasam[3]=$r[17];
	$tasamoratoria[0]=0;

	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);

	if($fecha[2]<=3){$tasamoratoria[0]=$tasam[0];}
	else
	{
		if($fecha[2]<=6){$tasamoratoria[0]=$tasam[1];}
		else
		{
			if($fecha[2]<=9){$tasamoratoria[0]=$tasam[2];}
			else {$tasamoratoria[0]=$tasam[3];}
		}
	}
	$_POST[tasamora]=$tasamoratoria[0];
	if($_POST[tasamora]==0)
	{echo"<script>despliegamodalm('visible','2','LA TASA DE INTERES DE MORA ES CERO (0) POR FAVOR ACTUALIZAR EL VALOR');</script>";}
	$_POST[tasa]=0;
	$_POST[predial]=0;
	$_POST[descuento]=0;
	$condes=0;
	//***** BUSCAR FECHAS DE INCENTIVOS
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaactual=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	$sqlr="select *from tesodescuentoincentivo where vigencia='$vigusu' and ingreso='01' and estado='S'";
	$res=mysql_query($sqlr,$linkbd);
	while($r=mysql_fetch_row($res))
	{
		if($r[7]<=$fechaactual && $fechaactual <= $r[8])
		{
			$_POST[descuento]=$r[2];
			$condes=1;
		}
		elseif($fechaactual>$r[9] && $fechaactual <= $r[10])
		{
			$_POST[descuento]=$r[3];
			$condes=1;
		}
		elseif($fechaactual>$r[11] && $fechaactual <= $r[12])
		{
			$_POST[descuento]=$r[4];
			$condes=1;
		}
		elseif($fechaactual>$r[19] && $fechaactual <= $r[20])
		{
			$_POST[descuento]=$r[16];
			$condes=1;
		}
		elseif($fechaactual>$r[21] && $fechaactual <= $r[22])
		{
			$_POST[descuento]=$r[17];
			$condes=1;
		}
		elseif($fechaactual>$r[23] && $fechaactual <= $r[24] )
		{
			$_POST[descuento]=$r[18];
			$condes=1;
		}
		else
		{
			if($r[24]!="0000-00-00"){$ulfedes=explode("-",$r[24]);}
			elseif($r[22]!="0000-00-00"){$ulfedes=explode("-",$r[22]);}
			elseif($r[20]!="0000-00-00"){$ulfedes=explode("-",$r[20]);}
			elseif($r[12]!="0000-00-00"){$ulfedes=explode("-",$r[12]);}
			elseif($r[10]!="0000-00-00"){$ulfedes=explode("-",$r[10]);}
			else {$ulfedes=explode("-",$r[8]);}
		}
	}
	//**FINALIZA
	$sqlr="select * from tesotasainteres where vigencia='$vigusu'";
	$res=mysql_query($sqlr,$linkbd);
	$r=mysql_fetch_row($res);
	$tasam=array();
	$tasam[0]=$r[14];
	$tasam[1]=$r[15];
	$tasam[2]=$r[16];
	$tasam[3]=$r[17];
	$tasamoratoria[0]=0;
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaav],$fecha);
	//$fechaactual=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	//echo $fecha[2];
	if($fecha[2]<=3){$tasamoratoria[0]=$tasam[0];}
	else
	{
		if($fecha[2]<=6){$tasamoratoria[0]=$tasam[1];}
		else
		{
			if($fecha[2]<=9){$tasamoratoria[0]=$tasam[2];}
			else {$tasamoratoria[0]=$tasam[3];}
		}
	}
	$_POST[tasamora]=$tasamoratoria[0];
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaav],$fecha);
	$fechaactual=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	$condes=0;
	$sqlr="select *from tesodescuentoincentivo where vigencia='$vigusu' and ingreso='01' and estado='S'";
	$res=mysql_query($sqlr,$linkbd);
	while($r=mysql_fetch_row($res))
	{
		if($r[7]<=$fechaactual && $fechaactual <= $r[8] )
		{
			$_POST[descuento]=$r[2];
			$condes=1;
		}
		elseif($fechaactual>$r[9] && $fechaactual <= $r[10] )
		{
			$_POST[descuento]=$r[3];
			$condes=1;
		}
		elseif($fechaactual>$r[11] && $fechaactual <= $r[12] )
		{
			$_POST[descuento]=$r[4];
			$condes=1;
		}
		elseif($fechaactual>$r[19] && $fechaactual <= $r[20]  )
		{
			$_POST[descuento]=$r[16];
			$condes=1;
		}
		elseif($fechaactual>$r[21] && $fechaactual <= $r[22] )
		{
			$_POST[descuento]=$r[17];
			$condes=1;
		}
		elseif($fechaactual>$r[23] && $fechaactual <= $r[24] )
		{
			$_POST[descuento]=$r[18];
			$condes=1;
		}
		else
		{
			if($r[24]!="0000-00-00"){$ulfedes=explode("-",$r[24]);}
			elseif($r[22]!="0000-00-00"){$ulfedes=explode("-",$r[22]);}
			elseif($r[20]!="0000-00-00"){$ulfedes=explode("-",$r[20]);}
			elseif($r[12]!="0000-00-00"){$ulfedes=explode("-",$r[12]);}
			elseif($r[10]!="0000-00-00"){$ulfedes=explode("-",$r[10]);}
			else {$ulfedes=explode("-",$r[8]);}
		}
	}
	if($codcatastral!='')
	{

		$sqlr="SELECT ord,tot FROM tesoprediosavaluos WHERE codigocatastral='$codcatastral' AND vigencia='$vigusu1'";
		//echo $sqlr;
		$rowot=mysql_fetch_row(mysql_query($sqlr,$linkbd));
		$ord=$rowot[0];
		$tot=$rowot[1];

	$sqlr="select * from tesopredios where cedulacatastral='$codcatastral' and ord='$ord'  and tot='$tot' ";
	$res=mysql_query($sqlr,$linkbd);
	while($row=mysql_fetch_row($res))
	{
		$_POST[catastral]=$row[0];
		$_POST[ntercero]=$row[6];
		$_POST[tercero]=$row[5];
		$_POST[direccion]=$row[7];
		$_POST[ha]=$row[8];
		$_POST[mt2]=$row[9];
		$_POST[areac]=$row[10];
		$_POST[avaluo]=number_format($row[11],2);
		$_POST[avaluo2]=number_format($row[11],2);
		$_POST[vavaluo]=$row[11];
		$_POST[tipop]=$row[15];
		$_POST[rangos]=$row[16];
		$tipopp=$row[15];

		// $_POST[dcuentas][]=$_POST[estrato];
		$_POST[dtcuentas][]=$row[1];
		$_POST[dvalores][]=$row[5];
		$_POST[buscav]="";
		$sqlr2="select tasa from tesoprediosavaluos where vigencia='$vigusu' AND codigocatastral='$row[0]' ";
		$res2=mysql_query($sqlr2,$linkbd);
		while($row2=mysql_fetch_row($res2))
		{
			$_POST[tasa]=$row2[0];
			$_POST[predial]=($row2[0]/1000)*$_POST[vavaluo];
			$_POST[predial]=number_format($_POST[predial],2);
		}
	 }
	}
	///******* aparicion campos

		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
		$fechaactual=$fecha[3]."-".$fecha[2]."-".$fecha[1];
		$tasaintdiaria=($_POST[tasamora]/100);
		$valoringreso[0]=0;
		$valoringreso[1]=0;
		$intereses[1]=0;
		$intereses[0]=0;
		$valoringresos=0;
		$cuentavigencias=0;
		$tdescuentos=0;
		$baseant=0;
		$npredialant=0;
		$banderapre=0;
		$co="zebra1";
		$co2="zebra2";
		$sqlrxx="
		SELECT DISTINCT TB1.vigencia,TB1.codigocatastral,TB1.avaluo,TB1.pago,TB1.estado,TB1.tipopredio,TB1.estratos,TB1.areacon
		FROM tesoprediosavaluos TB1
		WHERE TB1.codigocatastral = '$codcatastral'
		AND TB1.estado = 'S'
		AND TB1.pago = 'N'
		ORDER BY TB1.vigencia ASC";
		//echo $sqlrxx;
		$resxx=mysql_query($sqlrxx,$linkbd);
		$cuentavigencias= mysql_num_rows($resxx);
		$sqlr="
		SELECT DISTINCT TB1.vigencia,TB1.codigocatastral,TB1.avaluo,TB1.pago,TB1.estado,TB1.tipopredio,TB1.estratos,TB1.areacon
		FROM tesoprediosavaluos TB1
		WHERE TB1.codigocatastral = '$codcatastral'
		AND TB1.estado = 'S'
		AND (TB1.pago = 'N' OR TB1.pago = 'P' OR TB1.pago = 'S')
		ORDER BY TB1.vigencia ASC ";
		//echo $sqlr;
		$res=mysql_query($sqlr,$linkbd);
		$cv=0;
		$xpm=0;
		$sq="select interespredial from tesoparametros ";
		$result=mysql_query($sq,$linkbd);
		$rw=mysql_fetch_row($result);
		$interespredial=$rw[0];
		while($r=mysql_fetch_row($res))
		{
			$banderapre++;
			$otros=0;
			$sqlr2="select IF(tasa='-1',0,tasa) from tesoprediosavaluos where vigencia='$r[0]' and codigocatastral='$r[1]' " ;
			//echo $sqlr2."<br>";
			$res2=mysql_query($sqlr2,$linkbd);
			$row2=mysql_fetch_row($res2);
			$base=$r[2];

			//$valorperiodo=$base*($row2[0]/1000)-$base*($row2[0]/1000)*($_POST[deduccion]/100);
			$valorperiodo=$base*($row2[0]/1000);
			$tasav=$row2[0];
			//$predial=round($base*($row2[0]/1000)-$base*($row2[0]/1000)*($_POST[deduccion]/100),2);
			$predial=round($base*($row2[0]/1000),2);
			//echo "$base $row2[0] <br>";
			//**validacion normatividad predial ****
			if($_POST[aplicapredial]=='S')
			{
				$sqlrp="select distinct * from tesoprediosavaluos where tesoprediosavaluos.codigocatastral='$r[1]' and vigencia=".($r[0]-1)." ";
				$respr=mysql_query($sqlrp,$linkbd);
				$rowpr=mysql_fetch_row($respr);
				$baseant=0;
				$estant=$rowpr[3];
				$baseant=$rowpr[2]+0;
				$predialant=$baseant*($rowpr[10]/1000);
				//echo "$baseant - $rowpr[10] <br>";
				$areaanterior=$rowpr[9];
				if($estant=='S')
				{
					$sqlrav="select distinct tesoliquidapredial_det.predial,tesoliquidapredial_det.avaluo from tesoliquidapredial_det,tesoliquidapredial where tesoliquidapredial_det.idpredial=tesoliquidapredial.idpredial and tesoliquidapredial.codigocatastral='$_POST[codcat]' and tesoliquidapredial.estado='P' AND tesoliquidapredial_det.vigliquidada='".($r[0]-1)."'";
					$resav=mysql_query($sqlrav,$linkbd);
					while($rowav=mysql_fetch_row($resav))
					{
						if($predialant<($rowav[0]*2))
						{
							$baseant=$rowav[1]+0;
							$predialant=$rowav[0]+0;
						}
					}
				}
				else
				{
					$baseant=$rowpr[2]+0;
					$predialant=$baseant*($rowpr[10]/1000);
				}
				if ($baseant<=0)
				{
					//echo "<br>bas ".$baseant;
				}
				else
				{
					if(($predialant>($npredialant*2)) && ($npredialant>0))
					{
						//echo "<br> PA:".$npredialant;
						$predialant=$npredialant;
					}
					//echo "if($predial>($predialant*2) && $r[7]==$areaanterior) <br>";
					if($predial>($predialant*2) && $r[7]==$areaanterior)
					{
						//echo "<br>PPP ".$predialant." ".$predial;
						$predial=$predialant*2;

					}
				}
				$npredialant=$predial;
			}

			//echo "NP:".$npredialant;
			//*******
			$valoringresos=0;
			//echo "vp:".$valorperiodo.' - Pr:'.$predial;
			$sidescuentos=0;
			//****buscar en el concepto del ingreso *******
			$intereses=array();
			$valoringreso=array();
			//Inicializando intereses a cero
			$intereses[0] = 0;
			$intereses[1] = 0;

			$in=0;
			if($cuentavigencias>1)
			{
				if($vigusu==$r[0] && ($_POST[descuento]>0 or $condes==1) )
				{
					$pdescuento=$_POST[descuento]/100;
					$tdescuentos+=round(($predial)*$pdescuento,0);
				}
				elseif ($interespredial=='inicioanio')//Si se cuentan los dias desde el principio del a�o
				{
					$fechaini=mktime(0,0,0,1,1,$r[0]);
					$fechafin=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
					$difecha=$fechafin-$fechaini;
					$vigenciacobro=$fecha[3];
					$diasd=$difecha/(24*60*60);
					$diasd=floor($diasd);
					$totalintereses=0;
				}
				else //Si se cuentan los dias desde el principio del a�o
				{
					$sqlrfd="SELECT * FROM tesodescuentoincentivo WHERE vigencia='$r[0]' AND estado='S'";
					$resfd=mysql_query($sqlrfd,$linkbd);
					$rowfd=mysql_fetch_row($resfd);
					if($rowfd[24]!="0000-00-00"){$ulfedes01=$rowfd[24];}
					elseif($rowfd[22]!="0000-00-00"){$ulfedes01=$rowfd[22];}
					elseif($rowfd[20]!="0000-00-00"){$ulfedes01=$rowfd[20];}
					elseif($rowfd[12]!="0000-00-00"){$ulfedes01=$rowfd[12];}
					elseif($rowfd[10]!="0000-00-00"){$ulfedes01=$rowfd[10];}
					else {$ulfedes01=$rowfd[8];}
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", date('d/m/Y',strtotime($ulfedes01)),$fechafd);
					$fechainiciocobro=$fecha[2];
					$vigenciacobro=$fecha[3];
					$diascobro=$fecha[1];
					$fechaini=mktime(0,0,0,$fechafd[2],$fechafd[1],$fechafd[3]);
					$fechafin=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
					$difecha=$fechafin-$fechaini;
					if($difecha<'0')
					{
						$ulfedes01=$rowfd[7];
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", date('d/m/Y',strtotime($ulfedes01)),$fechafd);
						$fechainiciocobro=$fecha[2];
						$vigenciacobro=$fecha[3];
						$diascobro=$fecha[1];
						$fechaini=mktime(0,0,0,$fechafd[2],$fechafd[1],$fechafd[3]);
						$fechafin=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
						$difecha=$fechafin-$fechaini;
					}
					$diasd=$difecha/(24*60*60);
					$diasd=floor($diasd);
					$totalintereses=0;
				}
			}
			else //********* si solo debe la actual vigencia
			{
				$diasd=0;
				$totalintereses=0;
				$tdescuentos=0;
				$sidescuentos=1;
				if($vigusu==$r[0] && ($_POST[descuento]>0 or $condes==1))
				{
					$pdescuento=$_POST[descuento]/100;
					$tdescuentos+=round(($predial)*$pdescuento,0);
				}
				elseif ($interespredial=='inicioanio')//Si se cuentan los dias desde el principio del a�o
				{
					$fechaini=mktime(0,0,0,1,1,$r[0]);
					$fechafin=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
					$difecha=$fechafin-$fechaini;
					$diasd=$difecha/(24*60*60);
					$diasd=floor($diasd);
					$totalintereses=0;
				}
				else //Si se cuentan los dias desde el principio del a�o
				{
					$sqlrfd="SELECT * FROM tesodescuentoincentivo WHERE vigencia='$r[0]' AND estado='S'";
					$resfd=mysql_query($sqlrfd,$linkbd);
					$rowfd=mysql_fetch_row($resfd);
					if($rowfd[24]!="0000-00-00"){$ulfedes01=$rowfd[24];}
					elseif($rowfd[22]!="0000-00-00"){$ulfedes01=$rowfd[22];}
					elseif($rowfd[20]!="0000-00-00"){$ulfedes01=$rowfd[20];}
					elseif($rowfd[12]!="0000-00-00"){$ulfedes01=$rowfd[12];}
					elseif($rowfd[10]!="0000-00-00"){$ulfedes01=$rowfd[10];}
					else {$ulfedes01=$rowfd[8];}
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", date('d/m/Y',strtotime($ulfedes01)),$fechafd);
					$fechainiciocobro=$fecha[2];
					$vigenciacobro=$fecha[3];
					$diascobro=$fecha[1];
					$fechaini=mktime(0,0,0,$fechafd[2],$fechafd[1],$fechafd[3]);
					$fechafin=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
					$difecha=$fechafin-$fechaini;
					if($difecha<'0')
					{
						$ulfedes01=$rowfd[7];
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", date('d/m/Y',strtotime($ulfedes01)),$fechafd);
						$fechainiciocobro=$fecha[2];
						$vigenciacobro=$fecha[3];
						$diascobro=$fecha[1];
						$fechaini=mktime(0,0,0,$fechafd[2],$fechafd[1],$fechafd[3]);
						$fechafin=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
						$difecha=$fechafin-$fechaini;
					}
					$diasd=$difecha/(24*60*60);
					$diasd=floor($diasd);
					$totalintereses=0;

				}
			}
			$y1=12;
			$diascobro1=0;
			if($vigenciacobro==$r[0])
			{
				$y1=$fechainiciocobro;
				$diascobro1=$diascobro;
			}
			$sqlr2="select *from tesoingresos_det where codigo='01' and modulo='4' and  estado='S' and vigencia=$vigusu";
			//echo $sqlr2."hola";
			$res3=mysql_query($sqlr2,$linkbd);
			while($r3=mysql_fetch_row($res3))
			{

				if($r3[5]>0 && $r3[5]<100)
				{
					if($r3[2]=='03')
					{

						if( $_POST[basepredial]==1)
						{

							//$valoringreso[0]=round($base*($r3[5]/1000),0)-($base*($r3[5]/1000)*($_POST[deduccion]/100));
							$valoringreso[0]=round($base*($r3[5]/1000),0);
							//$valoringresos+=round($base*($r3[5]/1000),0)-($base*($r3[5]/1000)*($_POST[deduccion]/100));
							$valoringresos+=round($base*($r3[5]/1000),0);
						}
						if( $_POST[basepredial]==2)
						{
							$valoringreso[0]=round($predial*($r3[5]/100),0);
							$valoringresos+=round($predial*($r3[5]/100),0);
						}


						$totdiastri = 0;
						//Antes del 2017 se cobran intereses trimestrales
						$vig=$vigenciacobro-$r[0];
						$vigcal=$r[0];
						for($j=0;$j<=$vig;$j++)
						{
							//Se consultan los interes de la vigencia por mes
							$sqlintereses = "SELECT inmopri,inmoseg,inmoter,inmocua,inmoquin,inmosex,inmosep,inmooct,inmonov,inmodec,inmoonc,inmodoc from tesotasainteres WHERE vigencia = '".$vigcal."'";
							$resinteres = mysql_query($sqlintereses, $linkbd);
							$rowinteres = mysql_fetch_row($resinteres);
							$x1=3;
							for($i = 1; $i <= $y1 ; $i++)
							{
								if($interespredial!='inicioanio')
								{
									$sqlrfd="SELECT * FROM tesodescuentoincentivo WHERE vigencia='$r[0]' AND estado='S'";
									$resfd=mysql_query($sqlrfd,$linkbd);
									$rowfd=mysql_fetch_row($resfd);
									if($rowfd[24]!="0000-00-00"){$ulfedes01=$rowfd[24];}
									elseif($rowfd[22]!="0000-00-00"){$ulfedes01=$rowfd[22];}
									elseif($rowfd[20]!="0000-00-00"){$ulfedes01=$rowfd[20];}
									elseif($rowfd[12]!="0000-00-00"){$ulfedes01=$rowfd[12];}
									elseif($rowfd[10]!="0000-00-00"){$ulfedes01=$rowfd[10];}
									else {$ulfedes01=$rowfd[8];}
									ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", date('d/m/Y',strtotime($ulfedes01)),$fechafd);
									$fechainiciocobro=$fecha[2];
									$vigenciacobro=$fecha[3];
									$diascobro=$fecha[1];
									$fechaini=mktime(0,0,0,$fechafd[2],$fechafd[1],$fechafd[3]);
									$fechafin=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
									$difecha=$fechafin-$fechaini;
									if($difecha<'0')
									{
										$rowinteres[$i-1]=0;
									}
								}
								if($interespredial!='inicioanio')
								{
									$sqlrfd="SELECT * FROM tesodescuentoincentivo WHERE vigencia='$r[0]' AND estado='S'";
									$resfd=mysql_query($sqlrfd,$linkbd);
									$rowfd=mysql_fetch_assoc($resfd);
									if($rowfd['fechafin4']!="0000-00-00"){$ulfedes01=$rowfd['fechafin4'];}
									elseif($rowfd['fechafin5']!="0000-00-00"){$ulfedes01=$rowfd['fechafin5'];}
									elseif($rowfd['fechafin6']!="0000-00-00"){$ulfedes01=$rowfd['fechafin6'];}
									elseif($rowfd['fechafin3']!="0000-00-00"){$ulfedes01=$rowfd['fechafin3'];}
									elseif($rowfd['fechafin2']!="0000-00-00"){$ulfedes01=$rowfd['fechafin2'];}
									else {$ulfedes01=$rowfd['fechafin1'];}
									$mesesIntereses = explode('-',$ulfedes01);
									if($i <= $mesesIntereses[1])
										continue;
								}
								$numdias = cal_days_in_month(CAL_GREGORIAN, $i, $vigcal);
								$totdiastri += $numdias;
								//echo $fecha[3]."<br>";
								if($i==$fechainiciocobro && $vigcal==$fechafd[3] )
									$numdias=$diascobro1;
								if($vigcal>'2006' && $vigcal<'2017')
								{
									if($i % 3 == 0){
										$intereses[0]+=round(($valoringreso[0]*$totdiastri*($rowinteres[$i-$x1]/100))/365,0);
										$totdiastri = 0;
										$x1+=2;
									}

								}
								elseif($vigcal=='2017')
								{
									if($i <= 7)
									{
										if($i % 3 == 0){
											$intereses[0]+=round(($valoringreso[0]*$totdiastri*($rowinteres[$i-$x1]/100))/365,0);
											$totdiastri = 0;
											$x1+=2;
										}
									}
									else{
										$totdiastri = $numdias;
										$intereses[0]+=round(($valoringreso[0]*$totdiastri*($rowinteres[$i-1]/100))/365,0);
									}
								}
								else{
										$totdiastri = $numdias;
										$intereses[0]+=round(($valoringreso[0]*$totdiastri*($rowinteres[$i-1]/100))/365,0);
								}

							}
							$vigcal+=1;
						}
					$totalintereses+=$intereses[0];
				}
				if($r3[2]=='02')
				{
					if( $_POST[basepredialamb]==1)
					{

						$valoringreso[1]=round($base*($r3[5]/1000),0)-($base*($r3[5]/1000)*($_POST[deduccion]/100));
						$valoringresos+=round($base*($r3[5]/1000),0)-($base*($r3[5]/1000)*($_POST[deduccion]/100));
					}
					if( $_POST[basepredialamb]==2)
					{
						$valoringreso[1]=round($predial*($r3[5]/100),0);
						$valoringresos+=round($predial*($r3[5]/100),0);
					}
					$totdiastri = 0;
					//Antes del 2017 se cobran intereses trimestrales
					$vig=$vigenciacobro-$r[0];
					$vigcal=$r[0];
						for($j=0;$j<=$vig;$j++)
						{
							$sqlintereses = "SELECT inmopri,inmoseg,inmoter,inmocua,inmoquin,inmosex,inmosep,inmooct,inmonov,inmodec,inmoonc,inmodoc from tesotasainteres WHERE vigencia = '".$vigcal."'";
							$resinteres = mysql_query($sqlintereses, $linkbd);
							$rowinteres = mysql_fetch_row($resinteres);
							$x1=3;
							for($i = 1; $i <= $y1 ; $i++)
							{
								if($interespredial!='inicioanio')
								{
									$sqlrfd="SELECT * FROM tesodescuentoincentivo WHERE vigencia='$r[0]' AND estado='S'";
									$resfd=mysql_query($sqlrfd,$linkbd);
									$rowfd=mysql_fetch_row($resfd);
									if($rowfd[24]!="0000-00-00"){$ulfedes01=$rowfd[24];}
									elseif($rowfd[22]!="0000-00-00"){$ulfedes01=$rowfd[22];}
									elseif($rowfd[20]!="0000-00-00"){$ulfedes01=$rowfd[20];}
									elseif($rowfd[12]!="0000-00-00"){$ulfedes01=$rowfd[12];}
									elseif($rowfd[10]!="0000-00-00"){$ulfedes01=$rowfd[10];}
									else {$ulfedes01=$rowfd[8];}
									ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", date('d/m/Y',strtotime($ulfedes01)),$fechafd);
									$fechainiciocobro=$fecha[2];
									$vigenciacobro=$fecha[3];
									$diascobro=$fecha[1];
									$fechaini=mktime(0,0,0,$fechafd[2],$fechafd[1],$fechafd[3]);
									$fechafin=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
									$difecha=$fechafin-$fechaini;
									if($difecha<'0')
									{
										$rowinteres[$i-1]=0;
									}
								}
								$numdias = cal_days_in_month(CAL_GREGORIAN, $i, $vigcal);
								$totdiastri += $numdias;
								if($i==$fechainiciocobro && $vigcal==$fechafd[3])
									$numdias=$diascobro1;
								if($vigcal<'2017')
								{
									if($i % 3 == 0){
										$intereses[1]+=round(($valoringreso[1]*$totdiastri*($rowinteres[$i-$x1]/100))/365,0);
										$totdiastri = 0;
										$x1+=2;
									}
								}
								elseif($vigcal=='2017')
								{
									if($i <= 7)
									{
										if($i % 3 == 0){
											$intereses[1]+=round(($valoringreso[1]*$totdiastri*($rowinteres[$i-$x1]/100))/365,0);
											$totdiastri = 0;
											$x1+=2;
										}
									}
									else{
										$totdiastri = $numdias;
										$intereses[1]+=round(($valoringreso[1]*$totdiastri*($rowinteres[$i-1]/100))/365,0);
									}
								}
								else{
										$totdiastri = $numdias;
										$intereses[1]+=round(($valoringreso[1]*$totdiastri*($rowinteres[$i-1]/100))/365,0);
								}
							}
							$vigcal+=1;
						}
					$totalintereses+=$intereses[1];
					}

				}

			}

			$otros+=$valoringresos;
			$ipredial = 0;
			$totdiastri = 0;
			//Antes del 2017 se cobran intereses trimestrales
			$vig=$vigenciacobro-$r[0];
			$vigcal=$r[0];
			for($j=0;$j<=$vig;$j++)
			{

				$sqlintereses = "SELECT inmopri,inmoseg,inmoter,inmocua,inmoquin,inmosex,inmosep,inmooct,inmonov,inmodec,inmoonc,inmodoc from tesotasainteres WHERE vigencia = '".$vigcal."'";
				$resinteres = mysql_query($sqlintereses, $linkbd);
				$rowinteres = mysql_fetch_row($resinteres);
				$x1=3;
				for($i = 1; $i <= $y1 ; $i++)
				{
					if($interespredial!='inicioanio')
					{
						$sqlrfd="SELECT * FROM tesodescuentoincentivo WHERE vigencia='$r[0]' AND estado='S'";
						$resfd=mysql_query($sqlrfd,$linkbd);
						$rowfd=mysql_fetch_row($resfd);
						if($rowfd[24]!="0000-00-00"){$ulfedes01=$rowfd[24];}
						elseif($rowfd[22]!="0000-00-00"){$ulfedes01=$rowfd[22];}
						elseif($rowfd[20]!="0000-00-00"){$ulfedes01=$rowfd[20];}
						elseif($rowfd[12]!="0000-00-00"){$ulfedes01=$rowfd[12];}
						elseif($rowfd[10]!="0000-00-00"){$ulfedes01=$rowfd[10];}
						else {$ulfedes01=$rowfd[8];}
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", date('d/m/Y',strtotime($ulfedes01)),$fechafd);
						$fechainiciocobro=$fecha[2];
						$vigenciacobro=$fecha[3];
						$diascobro=$fecha[1];
						$fechaini=mktime(0,0,0,$fechafd[2],$fechafd[1],$fechafd[3]);
						$fechafin=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
						$difecha=$fechafin-$fechaini;
						if($difecha<'0')
						{
							$rowinteres[$i-1]=0;
						}
					}
					$numdias = cal_days_in_month(CAL_GREGORIAN, $i, $vigcal);
					$totdiastri += $numdias;
					if($i==$fechainiciocobro && $vigcal==$fechafd[3])
						$numdias=$diascobro1;
					if($vigcal<'2017')
					{
						if($i % 3 == 0){
							$ipredial+=round(($predial*$totdiastri*($rowinteres[$i-$x1]/100))/365,0);
							$totdiastri = 0;
							$x1+=2;
						}
					}
					elseif($vigcal=='2017')
					{
						if($i <= 7)
						{
							if($i % 3 == 0){
								$iipredial+=round(($predial*$totdiastri*($rowinteres[$i-$x1]/100))/365,0);
								$totdiastri = 0;
								$x1+=2;
							}
						}
						else{
							$totdiastri = $numdias;
							$ipredial+=round(($predial*$totdiastri*($rowinteres[$i-1]/100))/365,0);

						}
					}
					else{
							$totdiastri = $numdias;
							$ipredial+=round(($predial*$totdiastri*($rowinteres[$i-1]/100))/365,0);
					}

				}
				$vigcal+=1;
			}
			$chk='';
			$ch=esta_en_array($_POST[dselvigencias], $r[0]);
			if($ch==1){$chk=" checked";}
			$descipred=0;
			if($r[0]<=$_POST[vigmaxdescint] && $_POST[aplicadescint]=='S')
			{
				$descipred=$ipredial*($_POST[porcdescint]/100)+$intereses[0]*($_POST[porcdescint]/100)+$intereses[1]*($_POST[porcdescint]/100);
			}
			$totalpredial=round($predial+$otros+$totalintereses-$descipred+$ipredial,0);
			//echo "hola".$predial;
			$totalpagar=round($totalpredial- round($tdescuentos,0),0);

			$sqlrat="SELECT TB1.idpredial FROM tesoliquidapredial_det TB1, tesoliquidapredial TB2 WHERE TB1.idpredial=TB2.idpredial AND TB2.codigocatastral='$r[1]' AND TB1.vigliquidada='$r[0]' AND TB2.estado='S'";
			$resat=mysql_fetch_row(mysql_query($sqlrat,$linkbd));
			if($resat[0]!="")
			{
				$varcol='resaltar01';
				$clihis="onDblClick='hisliquidacion(\"$resat[0]\");'";
				$titvig="title='Periodo con Liquidaci�n vigente N� $resat[0]'";
				$_POST[var1]=$resat[0];
			}
			else
			{
				$sqlrat2="SELECT TB1.id_auto FROM tesoautorizapredial_det TB1, tesoautorizapredial TB2 WHERE TB1.id_auto=TB2.id_auto AND TB2.codcatastral='$r[1]' AND TB1.vigencia='$r[0]' AND TB2.estado='S'";
				$resat2=mysql_fetch_row(mysql_query($sqlrat2,$linkbd));
				if($resat2[0]!="")
				{
					$varcol='resaltar01';
					$clihis="onDblClick='hisautorizacion(\"$resat2[0]\");'";
					$titvig="title='Periodo con Autorizaci�n de Liquidaci�n vigente N� $resat2[0]'";
					$_POST[var2]=$resat2[0];
				}
				else{$varcol=$co;$clihis=""; $titvig="";}
			}
			//echo $intereses[1]."<br>";
			if($r[3]=="N")
			{
				$tipopredio=$_POST[tipop];
				$arreglofinal[]=Array("catastro" => $r[1],
									   "tercero" => $_POST[tercero],
									   "ntercero" => $_POST[ntercero],
									   "predial" => $predial,
									   "ipredial" =>$ipredial,
									   "descipred" => $descipred,
									   "bomberil" => $valoringreso[0],
									   "ibomberil" => $intereses[0],
									   "ambiental" => $valoringreso[1],
									   "iambiental" => $intereses[1],
									   "descuentos" => $tdescuentos,
									   "total" => $totalpagar,
									   "tipopredio" => $tipopredio,
									   "vigencia" => $r[0]);

			}
		}
	//***terminacion campos
	return $arreglofinal;
	}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function bloqueos($usuario,$fechadoc)
 {
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="Select count(*) From dominios dom  where dom.nombre_dominio = 'PERMISO_MODIFICA_DOC'  and dom.valor_final <= '$fechadoc'  AND dom.valor_inicial =  '$usuario' ";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
	return $valor;
}
function vigencia_usuarios($usuario)
 {
	$conexion = conectar_v7();
	$sqlr="Select dom.tipo From dominios dom  where dom.nombre_dominio = 'PERMISO_MODIFICA_DOC'  AND dom.valor_inicial =  '$usuario'";
	$res=mysqli_query($conexion,$sqlr);
	while($r=mysqli_fetch_row($res)){$valor=$r[0];}
	return @$valor;
}
//****** cuentas contables ***
function buscacuentacont($cuenta)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select * from cuentas where cuenta='$cuenta' ";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];$valor2=$r[1];$co+=1;}
	if ($co>0){$nombre=$valor2;}
	else {$nombre="";}
	//echo $sqlr;
	return $nombre;
}
function buscacuenta($cuenta)
{
	$co=0;
	$conexion=conectar_v7();
	$sqlr="select * from cuentas where cuenta='$cuenta' and tipo='Auxiliar'";
	$res=mysqli_query($conexion,$sqlr);
	while($r=mysqli_fetch_row($res)){$valor=$r[0];$valor2=$r[1];$co+=1;}
	if ($co>0){$nombre=$valor2;}
	else {$nombre="";}
	if($nombre=='')
	{
		$sqlr="select * from cuentasnicsp where cuenta='$cuenta' and tipo='Auxiliar'";
		$res=mysqli_query($conexion,$sqlr);
		while($r=mysqli_fetch_row($res)){$valor=$r[0];$valor2=$r[1];$co+=1;}
		if ($co>0){$nombre=$valor2;}
		else {$nombre="";}
	}
	return $nombre;
}

function buscagasto_valoriva($gasto)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
//***
$co=0;
$sqlr="select porcentaje from tesogastos_det where codigo='$gasto'";
//echo $sqlr;
$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res))
	{
	 $valor=$r[0];
	}
return $valor;
}

function buscarpcxpactiva($rp,$vigencia)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select count(id_orden) from tesoordenpago where tesoordenpago.id_rp=$rp and vigencia='$vigencia' and estado<>'N'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];$co+=1;}
	return $valor;
}
//**** busca tercero
function buscatercero($cuenta)
{
	$co=0;
	$linkbd=conectar_v7();
	$linkbd -> set_charset("utf8");
	$sqlr="select * from terceros where cedulanit='$cuenta' and estado='S'";
	$res=mysqli_query($linkbd,$sqlr);
	while($r=mysqli_fetch_row($res))
	{
		if ($r[16]=='1'){$ntercero=$r[5];}
		else {$ntercero="$r[3] $r[4] $r[1] $r[2]";}
		$valor=$r[12];
		$valor2=$ntercero;
		$co+=1;
	}
	if ($co>0){$nombre=$valor2;}
	else {$nombre="";}
	return $nombre;
}
//**********************
function codifica($cadena,$cadena2)
{
 	$tam=strlen($cadena);
 	$tam2=strlen($cadena2);
	$con=0;
	$nuevacadena='';
 	for ($x=0;$x<$tam;$x++)
  	{
		$asci=  abs(((ord(substr($cadena,$x,1))+ord(substr($cadena2,$con,1)))));
		$asci=abs($asci-255);
   		$nuevacadena.=chr($asci);
    	if($con<($tam2-1)){$con+=1;}
  	 	else{$con=0;}
  	}
 	return $nuevacadena;
}
function decodifica($cadena,$cadena2)
{
 	$tam=strlen($cadena);
 	$tam2=strlen($cadena2);
	$con=0;
	$nuevacadena='';
 	for ($x=0;$x<$tam;$x++)
  	{
		$asci=abs(ord(substr($cadena,$x,1))-255);
		$asci=abs($asci-ord(substr($cadena2,$con,1)));
   		$nuevacadena.=chr($asci);
      	if($con<$tam2-1){$con+=1;}
   		else{$con=0;}
  	}
 	return $nuevacadena;
}
function software()
{
	$conexion=conectar_v7();
	$sqlr="select * from admcon where  id=1 ";
	$res=mysqli_query($conexion,$sqlr);
	$fec=date("d/m/Y");
	while ($row =mysqli_fetch_row($res)){$f1=$row[1];$f2=$row[2];$cadena2=$row[3];$estado=$row[4];}
	if($estado=='N')
	{
		die("<br><br><br><div style='background-color:#0555aa;color:fff';><h4><img src='imagenes/gyc.png'  align='middle' >&nbsp;&nbsp;<img src='imagenes/pagar.png' widht='100' height='100' align='middle'  >&nbsp;&nbsp; &iexcl;&iexcl;&iexcl; EL SISTEMA ESTA DESACTIVADO !!!. COMUNIQUESE CON LA EMPRESA DISTRIBUIDORA DEL SOFTWARE  &nbsp;&nbsp; <img src='imagenes/alert.png' align='middle'  ></h4></div>");
	}
	if($estado=='A')
	{
		$decfin=decodifica($f2,$cadena2);
		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fec,$fecha);
		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $decfin,$fecha2);
		$fechafin=mktime(0,0,0,$fecha2[2],$fecha2[1],$fecha2[3]);
		$fechactual=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
		if(($fechafin-$fechactual)<0)
		{
			die("<br><br><br><div style='background-color:#0555aa;color:fff';><h4><img src='imagenes/gyc.png'  align='middle' >&nbsp;&nbsp;<img src='imagenes/pagar.png' widht='100' height='100' align='middle'  >&nbsp;&nbsp; &iexcl;&iexcl;&iexcl; EL SISTEMA ESTA DESACTIVADO !!!. COMUNIQUESE CON LA EMPRESA DISTRIBUIDORA DEL SOFTWARE  &nbsp;&nbsp; <img src='imagenes/alert.png' align='middle'></h4></div>");
			$sqlr='UPDATE admcon SET estado="N", WHERE id=1 ';
			mysql_query($sqlr,$conexion);
		}
		$resultado=codifica($cadena,$cadena2);
	}
}
//**** busca centro costo
function buscacentro($cuenta)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select * from centrocosto where id_cc='$cuenta' and estado='S'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$ncc=$r[1];$valor=$r[0];$valor2=$ncc;$co+=1;}
	if ($co>0){$nombre=$valor2;}
	else {$nombre="";}
	return $nombre;
}
function buscaNombreCuenta($cuenta,$vigencia)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$criterio=" and (vigencia=$vigencia or vigenciaf=$vigencia)";
	$sqlr="select * from pptocuentas where cuenta='$cuenta'  ".$criterio;
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res))
	{
		$valor=$r[0];
		$valor2=$r[1];
		$co+=1;
	}
	$nombre=$valor2;
	return $nombre;
}
//***** busca cuentas presupuestales
function buscacuentapres($cuenta,$tipo)
{
	$co=0;
	$conexion=conectar_v7();
	$vigusu=vigencia_usuarios($_SESSION['cedulausu']);
	$criterio=" and (vigencia=$vigusu or vigenciaf=$vigusu)";
	$sqlr="select * from pptocuentas where cuenta='$cuenta'  ".$criterio;
	$res=mysqli_query($conexion,$sqlr);
	while($r=mysqli_fetch_row($res))
	{
		$valor=$r[0];
		$valor2=$r[1];
		$co+=1;
	}
	$nombre=@$valor2;
	return $nombre;
}
function buscacuentaprescxp($cuenta,$vigencia)//***** busca cuentas presupuestales
{
	$co=0;
	$conexion=conectar_v7();
	$criterio=" and (vigencia=$vigencia or vigenciaf=$vigencia)";
	$sqlr="select * from pptocuentas where cuenta='$cuenta'  ".$criterio;
	$res=mysqli_query($conexion,$sqlr);
	while($r=mysqli_fetch_row($res))
	{
		$valor=$r[0];
		$valor2=$r[1];
		$co+=1;
	}
	$nombre=@$valor2;
	return $nombre;
}
function existecuenta($cuenta)// busca si existe una cuenta
{
	$co=0;
	$conexion=conectar_v7();
	$sqlr="select * from cuentas where cuenta='$cuenta'";
	$res=mysqli_query($conexion,$sqlr);
	while($r=mysqli_fetch_row($res)){$valor=$r[0];$valor2=$r[1];$co+=1;}
	if ($co>0){$nombre=@$valor2;}
	else {$nombre="";}
	return $nombre;
}
function existecuentanicsp($cuenta)// busca si existe una cuenta nicsp
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select * from cuentasnicsp where cuenta='$cuenta'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];$valor2=$r[1];$co+=1;}
	if ($co>0){$nombre=$valor2;}
	else {$nombre="";}
	return $nombre;
}
// busca si existe una cuenta de ingreso
function existecuentain($cuenta)
{
	$conexion = conectar_v7();
	$vigusu=vigencia_usuarios($_SESSION['cedulausu']);
	$co=0;
	$sqlr="select * from pptocuentas where cuenta='$cuenta' and (vigencia='".$vigusu."' or  vigenciaf='".$vigusu."')";
	$res=mysqli_query($conexion,$sqlr);
	while($r=mysqli_fetch_row($res)){$valor=$r[0];$valor2=$r[1];$co+=1;}
	if ($co>0){$nombre=$valor2;}
	else{$nombre="";}
	return $nombre;
}
function existecuentain2($cuenta,$vigusu)
{
	$co=0;
	$conexion = conectar_v7();
	$sqlr="select * from pptocuentas where cuenta='$cuenta' and (vigencia='".$vigusu."' or  vigenciaf='".$vigusu."')";
	$res=mysqli_query($conexion,$sqlr);
	while($r=mysqli_fetch_row($res)){$valor=$r[0];$valor2=$r[1];$co+=1;}
	if ($co>0){$nombre=$valor2;}
	else{$nombre="";}
	return $nombre;
}
// busca si la cuenta es auxiliar o no
function mayaux($cuenta)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
	$sqlr="select * from pptocuentas where cuenta='$cuenta'and vigencia=".$vigusu;
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];$valor2=$r[2];$co+=1;}
	if ($co>0){$tipo=$valor2;}
	else {$tipo="";}
	return $tipo;
}
//**** busca registro
function buscaregistro($cuenta,$vigencia)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select * from pptorp where consvigencia='$cuenta' and vigencia='$vigencia'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[1];$valor2=$r[2];$co+=1;}
	if ($co>0){$nombre=$valor2;}
	else {$nombre="";}
	return $nombre;
}
//*****busca ingreso tesoreria
function buscaingreso($cuenta)
{
	$linkbd=conectar_v7();
	$co=0;
	$sqlr="SELECT * FROM tesoingresos WHERE codigo='$cuenta'";
	$res=mysqli_query($linkbd,$sqlr);
	while($r=mysqli_fetch_row($res)){$valor=$r[0];$valor2=$r[1];$co+=1;}
	if ($co>0){$nombre=$valor2;}
	else {$nombre="";}
	return $nombre;
}
//***
//*****busca ingreso tesoreria
function buscaEntidadAdministradora($id)
{
	$linkbd=conectar_v7();
	$co=0;
	$sqlr="SELECT * FROM tesomediodepago WHERE id='$id'";
	$res=mysqli_query($linkbd,$sqlr);
	while($r=mysqli_fetch_row($res)){$valor=$r[0];$valor2=$r[1];$co+=1;}
	if ($co>0){$nombre=$valor2;}
	else {$nombre="";}
	return $nombre;
}
function buscaingresoconpes($cuenta)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select * from presuingresoconpes where codigo='$cuenta' and estado='S'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];$valor2=$r[1];$co+=1;}
	if ($co>0){$nombre=$valor2;}
	else {$nombre="";}
	return $nombre;
}
//**** ingresos ssf
function buscaingresossf($cuenta)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select * from tesoingresossf_cab where codigo='$cuenta' and estado='S'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];$valor2=$r[1];$co+=1;}
	if ($co>0){$nombre=$valor2;}
	else {$nombre=""; }
	return $nombre;
}
//***** anula todos los documentos de predial y liq recaudos de fechas anteriores que no se hallan pagado
function anularprediales($fecha)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
 	die("no se puede conectar");
  	if(!mysql_select_db($datin[0]))
  	die("no se puede seleccionar bd");
	$sqlr="Select *  From dominios dom where dom.nombre_dominio = 'FECHA_LIMITE_MODIFICA_DOC'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$fecha2=$r[0];}
	$fechafin=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
	$difecha=$fechafin-$fechaini;
	$diasd=$difecha/(24*60*60);
	$diasd=floor($diasd);
	//**** predial
  	$sqlr="update tesoliquidapredial set estado='N' where fecha between '$fecha2' and '$fecha'  and estado='S'";
 	mysql_query($sqlr,$conexion);
	//**** recibos de caja
  	/*$sqlr="select * from tesorecaudos where fecha between '$fecha2' and '$fecha'  and estado='S'";
 	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res))
	{
  		$sqlr="update tesorecaudos set estado='N' where id_recaudo=$r[0] and fecha between '$fecha2' and '$fecha'  and estado='S'";
 		mysql_query($sqlr,$conexion);
  		$sqlr="update comprobante_cab set estado=0 where tipo_comp=2 and numerotipo=$r[0]";
  		mysql_query($sqlr,$conexion);
  		$sqlr="update comprobante_det set debito=0,credito=0 where tipo_comp=2 and numerotipo=$r[0]";
  		mysql_query($sqlr,$conexion);
	}*/
	//echo "CONSULTA".$sqlr;
 }
//*********
function buscaciiu($cuenta)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select *from codigosciiu where codigosciiu.nombre<>='$cuenta' and estado='S'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];$valor2=$r[1];$co+=1;}
	if ($co>0){$nombre=$valor2;}
	else {$nombre="";}
	return $nombre;
}

function buscacodigociiu($codigo)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select nombre from codigosciiu where codigo='$codigo'";
	$res=mysql_query($sqlr,$conexion);
	$r=mysql_fetch_row($res);
	return $r[0];
}

function buscaretencion($cuenta)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select * from tesoretenciones where id='$cuenta' and estado='S'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];$valor2=$r[2]; $co+=1;}
	if ($co>0){$nombre=$valor2;}
	else {$nombre="";}
	return $nombre;
}
function buscaretencioncod($cuenta)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select * from tesoretenciones where id='$cuenta' and estado='S'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];$valor2=$r[1];$co+=1;}
	if ($co>0){$nombre=$valor2;}
	else {$nombre="";}
	return $nombre;
}
function buscaretencioniva($cuenta)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select * from tesoretenciones where id='$cuenta' and estado='S'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0]; $valor2=$r[7];$co+=1;}
	if ($co>0){$nombre=$valor2;}
	else {$nombre="";}
	return $nombre;
}
//**** busca tercero
function buscaregimen($cuenta)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select * from terceros where cedulanit='$cuenta' and estado='S'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[12];$valor2=$r[17];$co+=1;}
	if ($co>0){$nombre=$valor2;}
	else {$nombre="";}
	return $nombre;
}
function buscaconcepto($cuenta, $modulo)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select * from conceptoscontables where codigo='$cuenta' and modulo='$modulo'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];$valor2=$r[1];$co+=1;}
	if ($co>0){$nombre=$valor2;}
	else {$nombre=""; }
	return $nombre;
}
function buscaconcepto2($cuenta, $modulo, $tipo)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="SELECT nombre FROM conceptoscontables WHERE codigo='$cuenta' AND modulo='$modulo' AND tipo='$tipo'";
	$res=mysql_query($sqlr,$conexion);
	$row=mysql_fetch_row($res);
	return $row[0];
}
function buscaccnomina($tercero)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="
	SELECT GROUP_CONCAT(T1.descripcion ORDER BY CONVERT(T1.codrad, SIGNED INTEGER) SEPARATOR '<->')
	FROM hum_funcionarios T1
	WHERE (T1.item = 'NUMCC') AND T1.estado='S' AND (SELECT T2.codfun FROM hum_funcionarios T2 WHERE T2.descripcion  LIKE  '$tercero' AND T2.estado='S' AND T2.codfun=T1.codfun AND T2.item='DOCTERCERO')
	GROUP BY T1.codfun
	ORDER BY CONVERT(T1.codfun, SIGNED INTEGER)";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
	return $valor;
}
function buscaparafiscal($codigo,$cc,$sector)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	if($sector=='PB'){$sector="publico";}
	if($sector=='PR'){$sector="privado";}
	$sqlr="SELECT * FROM humparafiscales_det WHERE codigo='$codigo' AND cc='$cc' AND sector LIKE '%$sector%' AND estado='S'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[6];}
	return $valor;
}
function buscasectorpension($nomina,$tipo,$cc,$empresa)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="SELECT sector FROM humnomina_saludpension WHERE id_nom='$nomina' AND tipo='$tipo' AND tercero='$empresa'";
	$res=mysql_query($sqlr,$conexion);
	$r=mysql_fetch_row($res);
	$valor=$r[0];
	return $valor;
}
function buscaparafiscal2($codigo,$cc,$sector,$vigencia)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3]))) die("no se puede conectar");
	if(!mysql_select_db($datin[0])) die("no se puede seleccionar bd");
	$co=0;
	if($sector=='PB'){$sector="publico";}
	if($sector=='PR'){$sector="privado";}
	$sqlr="SELECT * FROM humparafiscales_det WHERE codigo='$codigo' AND cc='$cc' AND sector LIKE '%$sector%' AND estado='S' AND vigencia='$vigencia'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[6];}
	return $valor;
}
function buscanominaparafiscal_estado($nomina,$codigo,$tercero,$cc,$sector)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	/*if($sector=='PB')
	$sector="publico";
	if($sector=='PR')
	$sector="privado";*/
	$sqlr="select estado from humnomina_saludpension where id_nom=$nomina and tipo='$codigo' and tercero='$tercero' and cc='$cc' and sector like '%$sector%' ";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
	return $valor;
}

function buscavariablepago($codigo,$cc)
{
	$linkbd=conectar_v7();
	$co=0;
	$sqlr="select * from  humvariables_det where codigo='$codigo' and cc='$cc'  and estado='S'";
	$res=mysqli_query($linkbd,$sqlr);
	while($r=mysqli_fetch_row($res)){$valor=$r[7];}
	return $valor;
}
function buscabanco($cuenta)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select * from  tesobancosctas where cuenta='$cuenta' and estado='S'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[1];}
	return $valor;
}
function buscabancocn($cuentab,$nit)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select * from  tesobancosctas where ncuentaban='$cuentab' and tercero='$nit' and estado='S'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
	return $valor;
}
function buscabancocn2($cuentab,$nit)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select * from  tesobancosctas where cuenta='$cuentab' and tercero='$nit' and estado='S'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[2];}
	return $valor;
}
function buscagastoban($ngasto)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select * from  tesogastosbancarios where codigo='$ngasto' and estado='S'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[1];}
	return $valor;
}
function validarcuentas($cuenta)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
    $sqlrchip="select count(*) from cuentas where cuenta='$cuenta'";
	$reschip=mysql_query($sqlrchip,$conexion);
	$rowchip=mysql_fetch_row($reschip);
	return $rowchip[0];
}
function buscadominio($dominio,$valorinicial)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select * from dominios where  NOMBRE_DOMINIO='$dominio' and VALOR_INICIAL='$valorinicial'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$ncc=$r[2];$valor=$r[0];$valor2=$ncc;$co+=1;}
	if ($co>0){$nombre=$valor2;}
	else {$nombre="";}
	return $nombre;
}
function buscadominiov2($dominio,$tipo)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select * from dominios where  NOMBRE_DOMINIO='$dominio' and tipo='$tipo'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$ncc=$r[1];$valor=$r[0];$valor2=$ncc;$co+=1;}
	if ($co>0){$nombre=$valor2;}
	else {$nombre="";}
	return $nombre;
}
function buscaclase($tipo)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select * from acti_clase where id='$tipo'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$ncc=$r[1];$valor=$r[0];$valor2=$ncc;$co+=1;}
	if ($co>0){$nombre=$valor2;}
	else {$nombre="";}
	return $nombre;
}
function buscaperfil($idrol)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select nom_rol from  roles where id_rol='$idrol' ";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
	return $valor;
}
//****BUSCA CONCILIACION ***
function buscaconciliacion($idconc,$numerocom,$fechaini,$fechafin,$cuenta)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
//	$valor=0;
	$sqlr="select COUNT(*) from  CONCILIACION where id_comp='$idconc $numerocom' and cuenta='$cuenta' and periodo2 not between '$fechaini' and '$fechafin' ";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];	}
	return $valor;
}
function buscaconciliacion_fecha($idconc,$numerocom,$fechaini,$fechafin,$cuenta)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select periodo2 from  CONCILIACION where id_comp='$idconc $numerocom' and cuenta='$cuenta' and periodo2 not between '$fechaini' and '$fechafin'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
	return $valor;
}
//***ultimo dia de un mes
function ultimodia($anho,$mes){
   if (((fmod($anho,4)==0) and (fmod($anho,100)!=0)) or (fmod($anho,400)==0)) {$dias_febrero = 29; }
   else {$dias_febrero = 28;}
   switch($mes)
   {
       case 1: return 31; break;
       case 2: return $dias_febrero; break;
       case 3:  return 31; break;
       case 4: return 30; break;
       case 5: return 31; break;
       case 6:  return 30; break;
       case 7:  return 31; break;
       case 8:  return 31; break;
       case 9:  return 30; break;
       case '01': return 31; break;
       case '02': return $dias_febrero; break;
       case '03' :  return 31; break;
       case '04' :  return 30; break;
       case '05' : return 31; break;
       case '06' :  return 30; break;
       case '07' : return 31; break;
       case '08':  return 31; break;
       case '09':  return 30; break;
       case 10: return 31; break;
       case 11: return 30; break;
       case 12: return 31; break;
   }
}
function buscacomprobante($tipocomp)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
    $sqlrchip="select nombre from tipo_comprobante where codigo='$tipocomp'";
	$reschip=mysql_query($sqlrchip,$conexion);
	$rowchip=mysql_fetch_row($reschip);
	return $rowchip[0];
}
function digitosnivelesctas($nivel)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
    $sqlrchip="select posiciones from nivelesctas where id_nivel=$nivel";
	$reschip=mysql_query($sqlrchip,$conexion);
	$rowchip=mysql_fetch_row($reschip);
	return $rowchip[0];
}
function pptovalor($cuentap,$mes,$vigencia)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	//******RECAUDOS - RECIBOS DE CAJA
	$sqlr="select pptorecibocajappto.valor, pptorecibocajappto.idrecibo from pptorecibocajappto, tesoreciboscaja where pptorecibocajappto.cuenta='$cuentap' AND tesoreciboscaja.id_recibos=pptorecibocajappto.idrecibo and pptorecibocajappto.vigencia='".$vigencia."' and MONTH(tesoreciboscaja.fecha)='$mes' and tesoreciboscaja.estado<>'N' ORDER BY pptorecibocajappto.idrecibo";
	echo "<br>re:".$sqlr;
 	$res=mysql_query($sqlr,$conexion);
 	$valor=0;
 	while ($row =mysql_fetch_row($res)){$valor+=$row[0];}
	//RETENCIONES
	$sqlr="select pptoretencionpago.valor,pptoretencionpago.idrecibo from pptoretencionpago, tesoegresos where pptoretencionpago.cuenta='$_POST[cuenta]' AND tesoegresos.id_egreso=pptoretencionpago.idrecibo and pptoretencionpago.vigencia='".$vigencia."' and MONTH(tesoegresos.fecha)='$mes' and tesoegresos.estado<>'N' ORDER BY pptoretencionpago.idrecibo";
	echo "v:$valor<br>ret:".$sqlr;
 	$res=mysql_query($sqlr,$conexion);
 	while ($row =mysql_fetch_row($res)){$valor+=$row[0];}
 	//****INGRESOS TRANSFERENCIAS
 	$sqlr="select pptoingtranppto.valor,pptoingtranppto.idrecibo from pptoingtranppto, tesorecaudotransferencia where pptoingtranppto.cuenta='$_POST[cuenta]' AND tesorecaudotransferencia.id_recaudo=pptoingtranppto.idrecibo and pptoingtranppto.vigencia='".$vigencia."' and MONTH(tesorecaudotransferencia.fecha) ='$mes' and tesorecaudotransferencia.estado<>'N'   ORDER BY pptoingtranppto.idrecibo";
 	echo "v:$valor<br>ing:".$sqlr;
  	$res=mysql_query($sqlr,$conexion);
  	while ($row =mysql_fetch_row($res)){$valor+=$row[0];}
  	return $valor;
}
 //*****BUSCA PRODUCTOS COMPRAS
 function buscaproducto($codigo)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select nombre from  productospaa where codigo='$codigo' ";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
	return $valor;
}
 function buscaproductotipo($codigo)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select tipo from  productospaa where codigo='$codigo' ";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
	return $valor;
}
function buscacodssf($rubro,$vigencia)
 {
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="select codigo from  tesoingresossf_det where cuentapresgas='$rubro' and vigencia=$vigencia";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
	return $valor;
 }
function buscacodssfnom($codigo)
 {
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="select nombre from  tesoingresossf_cab where codigo='$codigo'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
	return $valor;
 }
//***activos ****
function diferenciamesesfechas($fechainicial,$fechafinal)
{
	
	preg_match("/([0-9]{4})\-([0-9]{2})\-([0-9]{2})/", $fechainicial,$fecha);
	$fechai=mktime(0,0,0,$fecha[2],$fecha[3],$fecha[1]);
	$yeari=$fecha[1];
	$mesesi=$fecha[2];
	preg_match("/([0-9]{4})\-([0-9]{2})\-([0-9]{2})/", $fechafinal,$fecha);
	$fechaf=mktime(0,0,0,$fecha[2],$fecha[3],$fecha[1]);
	$yearf=$fecha[1];
	$mesesf=$fecha[2];
	$dif=$fechaf-$fechai;
	$meses=floor($dif/(30*24*60*60));
	$meses=($yearf-$yeari)*12+($mesesf-$mesesi);
 	return $meses;
}
function dias_transcurridos($fecha_i,$fecha_f)
{
	$dias	= (strtotime($fecha_i)-strtotime($fecha_f))/86400;
	$dias 	= abs($dias); $dias = floor($dias);
	return $dias;
}
function sumamesesfecha($fechainicial,$meses)
 {
	$fechaf=date("Y-m-d",strtotime("$fechainicial+$meses months"));
	return $fechaf;
 }
 function diferenciamesesfechas_f2($fechainicial,$fechafinal)
 {
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fechainicial,$fecha);
	$fechai=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
	$yeari=$fecha[1];
	$mesesi=$fecha[2];
  	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fechafinal,$fecha);
	$fechaf=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
	$yearf=$fecha[1];
	$mesesf=$fecha[2];
	$dif=$fechaf-$fechai;
	$meses=floor($dif/(30*24*60*60));
	$meses=($yearf-$yeari)*12+($mesesf-$mesesi);
	return $dif;
 }
 function diferenciamesesfechas_f3($fechainicial,$fechafinal)
 {
	ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fechainicial,$fecha);
	$fechai=mktime(0,0,0,$fecha[2],$fecha[3],$fecha[1]);
	$yeari=$fecha[1];
	$mesesi=$fecha[2];
  	ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fechafinal,$fecha);
	$fechaf=mktime(0,0,0,$fecha[2],$fecha[3],$fecha[1]);
	$yearf=$fecha[1];
	$mesesf=$fecha[2];
	$dif=$fechaf-$fechai;
	$meses=floor($dif/(30*24*60*60));
	$meses=($yearf-$yeari)*12+($mesesf-$mesesi);
	return $dif;
 }
//******BUSCAR FUENTES DE RECURSOS PRESUPUESTALES
function buscafuenteppto($rubro,$vigencia)
{
	$conexion = conectar_v7();
	$ind=substr($rubro,0,1);
	$sqlr="SELECT clasificacion FROM pptocuentas WHERE cuenta='$rubro' AND (vigencia='$vigencia' OR vigenciaf='$vigencia')";
	$res=mysqli_query($conexion,$sqlr);
	$row=mysqli_fetch_row($res);
	$ind=$row[0];
	//****clasificacion
	$criterio="AND (T1.vigencia='$vigencia' OR T1.vigenciaf='$vigencia')";
	if ($ind=='funcionamiento')
	{
		$sqlr="SELECT DISTINCT T1.futfuentefunc,T2.nombre FROM pptocuentas AS T1,pptofutfuentefunc AS T2 WHERE T1.cuenta='$rubro' AND T1.futfuentefunc=T2.codigo $criterio";
	}
	if ($ind=='deuda' || $ind=='inversion' || $ind=='reservas-gastos')
	{
		$sqlr="SELECT DISTINCT T1.futfuenteinv,T2.nombre FROM pptocuentas AS T1,pptofutfuenteinv AS T2 WHERE T1.cuenta='$rubro' AND T2.codigo=T1.futfuenteinv $criterio";
	}
	$res=mysqli_query($conexion,$sqlr);
	$row=mysqli_fetch_row($res);
	$recurso="";
	if($row[1]!='' || $row[1]!=0)
	{
		$recurso=$row[0].'_'.$row[1];
	}
	if($ind=='sgr-gastos')
	{
		$sql="SELECT pf.nombre FROM pptocuentas_fuen_regalias AS pr,pptofutfuentesgr AS pf WHERE pr.cuenta='$rubro' AND (pr.vigenciai='$vigencia' OR pr.vigenciaf='$vigencia' ) AND pf.codigo=pr.fuente ";
		$res=mysqli_query($conexion,$sql);
		$row=mysqli_fetch_row($res);
		$recurso=$row[0];
	}
	return $recurso;
}//****** funcion de busqueda de sector empleado pension

function buscasector($cedulausu,$prenom)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="SELECT fondopensionestipo FROM hum_prenomina_det WHERE documefun='$cedulausu' AND codigo=$prenom";
	$res=mysql_query($sqlr,$conexion);
	$row=mysql_fetch_row($res);
	$sector=$row[0];
	return $sector;
}

//***** NOMINA BUSCAR VARIABLE
function buscapptovarnom($codigo,$tipo,$vigencia)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	if($tipo=='N')
	{
		$sqlr="SELECT DISTINCT T1.concepto FROM humvariables_det T1,humvariables T2 WHERE T1.codigo='$codigo' AND T1.codigo=T2.codigo AND T2.estado='S' AND T1.vigencia='$vigencia'";
	}
	if($tipo=='F' || $tipo=='SR' || $tipo=='SE' || $tipo=='PR' || $tipo=='PE')
	{
		$sqlr="SELECT DISTINCT T1.concepto FROM humparafiscales_det T1 ,humparafiscales T2 WHERE T1.codigo='$codigo' AND T1.codigo=T2.codigo AND T1.estado='S' AND T1.vigencia='$vigencia'";
	}
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
	return $valor;
}
//****
function buscapptovarnom_ppto($codigo,$tipo,$cc,$vigencia)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	if($tipo=='N' || $tipo=='D' || $tipo=='SE' || $tipo=='PE')
	{
		$sqlr="select distinct humvariables_det.cuentapres from humvariables_det,humvariables where humvariables_det.codigo='$codigo' and humvariables_det.codigo=humvariables.codigo and humvariables.estado='S' and humvariables_det.cc='$cc' AND humvariables_det.vigencia=$vigencia";
	}
	if($tipo=='F' || $tipo=='SR'  || $tipo=='PR' )
	{
		$sqlr="select distinct humparafiscales_det.cuentapres from humparafiscales_det,humparafiscales where humparafiscales_det.codigo='$codigo' and humparafiscales_det.codigo=humparafiscales.codigo and humparafiscales_det.cc='$cc' and humparafiscales.estado='S' AND humparafiscales_det.vigencia=$vigencia";
	}
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
	if($valor=="")
	{
	//echo $sqlr;
	}
	//echo $sqlr;
	return $valor;
}
//************** CODIGOS PARAMETROS DE NOMINA
function buscaparanom($parametro)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select ".$parametro." from humparametrosliquida ";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
	return $valor;
}
//**** busca responsable
function buscaresponsable($cuenta)
{
	$linkbd=conectar_v7();
	$co=0;
	$sqlr="SELECT t.*, pt.* FROM terceros t, planestructura_terceros pt WHERE pt.estado='S' AND pt.cedulanit = t.cedulanit AND pt.cedulanit='".$cuenta."'";
	$res=mysqli_query($linkbd,$sqlr);
	while($r=mysqli_fetch_row($res))
	{
		if ($r[16]=='1'){$ntercero=$r[5];}
		else {$ntercero=$r[3].' '.$r[4].' '.$r[1].' '.$r[2];}
		$valor=$r[12];
		$valor2=$ntercero;
		$co+=1;
	}
	if ($co>0){$nombre=$valor2;}
	else {$nombre="";}
	return $nombre;
}
//**** busca terceros2
function buscatercero2($cuenta)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select * from terceros where cedulanit='$cuenta' and estado='S'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res))
	{
	  	if ($r[16]=='1'){$ntercero=$r[5];}
   		else {$ntercero=$r[3].' '.$r[4].' '.$r[1].' '.$r[2];}
		$valor=$r[12];
		$valor2=$ntercero;
		$terdireccion=$r[6];
		$tertelefono=$r[7];
		$tercelular=$r[8];
		$teremail=$r[9];
		$co+=1;
	}
	if ($co>0){$nombre=$valor2;}
	else {$nombre="";}
	$pruebav[0]=iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$nombre);
	$pruebav[1]=trim($terdireccion);
	$pruebav[2]=trim($tertelefono);
	$pruebav[3]=trim($tercelular);
	$pruebav[4]=trim($teremail);//str_replace(' ', '', $cadena);
	return $pruebav;
}
function buscatercero_cta($tercero)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select * from terceros_cuentasban where cedulanit='$tercero' ";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$nombre=$r[1];}
	return $nombre;
}
// INICIO CARGA MENU DESPLEGABLE
function menu_desplegable($modulo)
{
	$conexion = conectar_v7();
	$datin=datosiniciales();
	$sqlr="SELECT valor_inicial FROM dominios WHERE nombre_dominio='FECHA_BACKUP' ";
	$rowbk=mysqli_fetch_row(mysqli_query($conexion,$sqlr));
	if($rowbk[0]!=NULL){$fechabackup=$rowbk[0];}
	else {$fechabackup='Sin Fecha';}
	@$nombre_archivo = @$_SERVER['REQUEST_URI'];
	if ( strpos(@$nombre_archivo, '/') !== FALSE )
	{@$nombre_archivo = array_pop(explode('/', @$nombre_archivo));}
	echo '<td colspan="3"> <div class="divmenu">';
	switch ($modulo)
	{
		case "plan":
		{
			echo ('
				<ul class="navmenu">
					<li><a onClick="location.href=\'principal.php\'" style="cursor:pointer;">Inicio</a>
					</li>
					<li><a style="cursor:pointer;">Archivos Maestros</a>');
						$estilos=ajustar_menu(@$_SESSION['linksetpl'][1],'pl',1);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linksetpl'][1]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Procesos</a>');
						$estilos=ajustar_menu(@$_SESSION['linksetpl'][2],'pl',2);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linksetpl'][2]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Herramientas</a>');
						$estilos=ajustar_menu(@$_SESSION['linksetpl'][3],'pl',3);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linksetpl'][3]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Informes</a>');
						$estilos=ajustar_menu(@$_SESSION['linksetpl'][4],'pl',4);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linksetpl'][4]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a onClick="mypop=window.open(\'../spid.php?pagina=ayuda.php\',\'\',\'\');mypop.focus();" style="cursor:pointer;">Ayuda</a></li><li style="text-align:right; float:right"><a>'.vigencia_usuarios(@$_SESSION['cedulausu']).'</a></li>');
					if($_SESSION["perfil"]=="Superman"){echo('<li><a onClick="alert(\''."Pagina: $nombre_archivo\\nBase: $datin[0]\\nFecha: $fechabackup".'\')" style="cursor:pointer;">Link</a></li>');}
					echo('<li style="vertical-align:bottom; line-height: 20px;  float:right" ><a>Ir a:<input name="atajos" type="search" style="height:20px" size="11" placeholder="Digite atajo..." onkeypress="if(validateEnter(event) == true) {abriratajo(this.value)}"></a></li>
					</ul>');
		}break;
		case "adm":
		{
			echo ('
				<ul class="navmenu">
					<li><a onClick="location.href=\'principal.php\'" style="cursor:pointer;">Inicio</a></li>
					<li><a style="cursor:pointer;">Sistema</a>');
						$estilos=ajustar_menu(@$_SESSION['linksetad'][0],'ad',0);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linksetad'][0]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Parametros</a>');
						$estilos=ajustar_menu(@$_SESSION['linksetad'][1],'ad',1);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linksetad'][1]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Herramientas</a>');
						$estilos=ajustar_menu(@$_SESSION['linksetad'][2],'ad',2);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linksetad'][2]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Informes</a>');
						$estilos=ajustar_menu(@$_SESSION['linksetad'][3],'ad',3);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linksetad'][3]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a onClick="mypop=window.open(\'../spid.php?pagina=ayuda.php\',\'\',\'\');mypop.focus();" style="cursor:pointer;">Ayuda</a></li><li style="text-align:right; float:right"><a>'.vigencia_usuarios(@$_SESSION['cedulausu']).'</a></li>');
					if($_SESSION["perfil"]=="Superman"){echo('<li><a onClick="alert(\''."Pagina: $nombre_archivo\\nBase: $datin[0]\\nFecha: $fechabackup".'\')" style="cursor:pointer;">Link</a></li>');}
					echo('<li style="vertical-align:bottom; line-height: 20px; float:right" ><a>Ir a:<input name="atajos" type="search" size="11" style="height:20px" placeholder="Digite atajo..." onkeypress="if(validateEnter(event) == true) {abriratajo(this.value)}"></a></li></ul>');
		}break;
		case "acti":
		{
			echo ('
				<ul class="navmenu">
					<li><a onClick="location.href=\'principal.php\'" style="cursor:pointer;">Inicio</a></li>
					<li><a style="cursor:pointer;">Archivos Maestros</a>');
						$estilos=ajustar_menu(@$_SESSION['linksetac'][1],'ac',1);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linksetac'][1]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Procesos</a>');
						$estilos=ajustar_menu(@$_SESSION['linksetac'][2],'ac',2);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linksetac'][2]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Herramientas</a>');
						$estilos=ajustar_menu(@$_SESSION['linksetac'][3],'ac',3);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linksetac'][3]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Informes</a>');
						$estilos=ajustar_menu(@$_SESSION['linksetac'][4],'ac',4);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linksetac'][4]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a onClick="mypop=window.open(\'../spid.php?pagina=ayuda.php\',\'\',\'\');mypop.focus();" style="cursor:pointer;">Ayuda</a></li><li style="text-align:right; float:right"><a>'.vigencia_usuarios(@$_SESSION['cedulausu']).'</a></li>');
					if($_SESSION["perfil"]=="Superman"){echo('<li><a onClick="alert(\''."Pagina: $nombre_archivo\\nBase: $datin[0]\\nFecha: $fechabackup".'\')" style="cursor:pointer;">Link</a></li>');}
					echo('<li style="vertical-align:bottom; line-height: 20px; float:right" ><a>Ir a:<input name="atajos" type="search" size="11" style="height:20px" placeholder="Digite atajo..." onkeypress="if(validateEnter(event) == true) {abriratajo(this.value)}"></a></li>
					</ul>');
		}break;
		case "cont":
		{
			echo ('
				<ul class="navmenu">
					<li><a onClick="location.href=\'principal.php\'" style="cursor:pointer;">Inicio</a></li>
					<li><a style="cursor:pointer;">Archivos Maestros</a>');
						$estilos=ajustar_menu(@$_SESSION['linksetco'][1],'co',1);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linksetco'][1]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Procesos</a>');
						$estilos=ajustar_menu(@$_SESSION['linksetco'][2],'co',2);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linksetco'][2]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Herramientas</a>');
						$estilos=ajustar_menu(@$_SESSION['linksetco'][3],'co',3);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linksetco'][3]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Informes</a>');
						$estilos=ajustar_menu(@$_SESSION['linksetco'][4],'co',4);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linksetco'][4]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li>
						<a href="ayuda.php" target="_blank">Ayuda</a>
					</li>
					<li style="text-align:right; float:right">
						<a>'.vigencia_usuarios(@$_SESSION['cedulausu']).'</a>
					</li>');
					if($_SESSION["perfil"]=="Superman"){echo('<li><a onClick="alert(\''."Pagina: $nombre_archivo\\nBase: $datin[0]\\nFecha: $fechabackup".'\')" style="cursor:pointer;">Link</a></li>');}
					echo('<li style="text-align:right; float:right">
						<img src="imagenes/chat2.png" style="width:30px; height:25px; cursor:pointer;" alt="Chat" title="Chat" onclick="verChat()">
					</li>
					<li style="vertical-align:bottom; line-height: 20px; float:right" >
						<a>Ir a:<input name="atajos" type="search" size="11" style="height:20px" placeholder="Digite atajo..." onkeypress="if(validateEnter(event) == true) {abriratajo(this.value)}"></a>
					</li>
				</ul>');

		}break;
		case "teso":
		{
			echo('
				<ul class="navmenu">
					<li><a onClick="location.href=\'principal.php\'" style="cursor:pointer;" accesskey="i">Inicio</a></li>
					<li><a style="cursor:pointer;">Archivos Maestros</a>');
						$estilos=ajustar_menu(@$_SESSION['linksette'][1],'te',1);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linksette'][1]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Recaudo</a>');
						$estilos=ajustar_menu(@$_SESSION['linksette'][2],'te',2);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linksette'][2]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Pago</a>');
						$estilos=ajustar_menu(@$_SESSION['linksette'][3],'te',3);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linksette'][3]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Traslados</a>');
						$estilos=ajustar_menu(@$_SESSION['linksette'][4],'te',4);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linksette'][4]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Herramientas</a>');
						$estilos=ajustar_menu(@$_SESSION['linksette'][5],'te',5);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linksette'][5]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Informes</a>');
						$estilos=ajustar_menu(@$_SESSION['linksette'][6],'te',6);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linksette'][6]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a onClick="mypop=window.open(\'../spid.php?pagina=ayuda.php\',\'\',\'\');mypop.focus();" style="cursor:pointer;">Ayuda</a></li><li style="text-align:right; float:right"><a>'.vigencia_usuarios(@$_SESSION['cedulausu']).'</a></li>');
					if(@$_SESSION["perfil"]=="Superman"){echo('<li><a onClick="alert(\''."Pagina: $nombre_archivo\\nBase: $datin[0]\\nFecha: $fechabackup".'\')" style="cursor:pointer;">Link</a></li>');}
					echo('<li style="vertical-align:bottom; line-height: 20px; float:right" ><a>Ir a:<input name="atajos" type="search" size="11" style="height:20px" placeholder="Digite atajo..." onkeypress="if(validateEnter(event) == true) {abriratajo(this.value)}"></a></li></ul>');
		}break;
		case "contra":
		{
			echo ('
				<ul class="navmenu">
					<li><a onClick="location.href=\'principal.php\'" style="cursor:pointer;">Inicio</a></li>
					<li><a style="cursor:pointer;">Archivos Maestros</a>');
						$estilos=ajustar_menu(@$_SESSION['linksetct'][1],'ct',1);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linksetct'][1]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Procesos</a>');
						$estilos=ajustar_menu(@$_SESSION['linksetct'][2],'ct',2);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linksetct'][2]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Herramientas</a>');
						$estilos=ajustar_menu(@$_SESSION['linksetct'][3],'ct',3);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linksetct'][3]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Informes</a>');
						$estilos=ajustar_menu(@$_SESSION['linksetct'][4],'ct',4);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linksetct'][4]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a onClick="mypop=window.open(\'../spid.php?pagina=ayuda.php\',\'\',\'\');mypop.focus();" style="cursor:pointer;">Ayuda</a></li><li style="text-align:right; float:right"><a>'.vigencia_usuarios(@$_SESSION['cedulausu']).'</a></li>');
					if(@$_SESSION["perfil"]=="Superman"){echo('<li><a onClick="alert(\''."Pagina: $nombre_archivo\\nBase: $datin[0]\\nFecha: $fechabackup".'\')" style="cursor:pointer;">Link</a></li>');}
					echo('<li style="vertical-align:bottom; line-height: 20px; float:right" ><a>Ir a:<input name="atajos" type="search" size="11" style="height:20px" placeholder="Digite atajo..." onkeypress="if(validateEnter(event) == true) {abriratajo(this.value)}"></a></li></ul>');
		}break;
		case "presu":
		{
			echo ('
				<ul class="navmenu">
					<li><a onClick="location.href=\'principal.php\'" style="cursor:pointer;">Inicio</a></li>
					<li><a style="cursor:pointer;">Archivos Maestros</a>');
						$estilos=ajustar_menu(@$_SESSION['linksetpr'][1],'pr',1);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linksetpr'][1]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Proceso Ingreso </a>');
						$estilos=ajustar_menu(@$_SESSION['linksetpr'][2],'pr',2);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linksetpr'][2]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Proceso Gastos </a>');
						$estilos=ajustar_menu(@$_SESSION['linksetpr'][3],'pr',3);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linksetpr'][3]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Reportes</a>');
						$estilos=ajustar_menu(@$_SESSION['linksetpr'][4],'pr',4);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linksetpr'][4]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Herramientas</a>');
						$estilos=ajustar_menu(@$_SESSION['linksetpr'][5],'pr',5);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linksetpr'][5]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a onClick="mypop=window.open(\'../spid.php?pagina=ayuda.php\',\'\',\'\');mypop.focus();" style="cursor:pointer;">Ayuda</a></li><li style="text-align:right; float:right"><a>'.vigencia_usuarios(@$_SESSION['cedulausu']).'</a></li>');
					if($_SESSION["perfil"]=="Superman"){echo('<li><a onClick="alert(\''."Pagina: $nombre_archivo\\nBase: $datin[0]\\nFecha: $fechabackup".'\')" style="cursor:pointer;">Link</a></li>');}
					echo('<li style="vertical-align:bottom; line-height: 20px; float:right" ><a>Ir a:<input name="atajos" type="search" size="11" style="height:20px" placeholder="Digite atajo..." onkeypress="if(validateEnter(event) == true) {abriratajo(this.value)}"></a></li></ul>');
		}break;
		case "serv":
		{
			echo ('
				<ul class="navmenu">
					<li><a onClick="location.href=\'principal.php\'" style="cursor:pointer;">Inicio</a></li>
					<li><a style="cursor:pointer;">Archivos Maestros</a>');
						$estilos=ajustar_menu(@$_SESSION['linksetser'][1],'ser',1);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linksetser'][1]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Procesos</a>');
						$estilos=ajustar_menu(@$_SESSION['linksetser'][2],'ser',2);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linksetser'][2]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Herramientas</a>');
						$estilos=ajustar_menu(@$_SESSION['linksetser'][3],'ser',3);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linksetser'][3]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Informes</a>');
						$estilos=ajustar_menu(@$_SESSION['linksetser'][4],'ser',4);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linksetser'][4]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a onClick="mypop=window.open(\'../spid.php?pagina=ayuda.php\',\'\',\'\');mypop.focus();" style="cursor:pointer;">Ayuda</a></li> <li style="text-align:right; float:right"><a>'.vigencia_usuarios(@$_SESSION['cedulausu']).'</a></li>');
					if(@$_SESSION["perfil"]=="Superman"){echo('<li><a onClick="alert(\''."Pagina: $nombre_archivo\\nBase: $datin[0]\\nFecha: $fechabackup".'\')" style="cursor:pointer;">Link</a></li>');}
					echo('<li style="vertical-align:bottom; line-height: 20px; float:right" ><a>Ir a:<input name="atajos" type="search" size="11" style="height:20px" placeholder="Digite atajo..." onkeypress="if(validateEnter(event) == true) {abriratajo(this.value)}"></a></li></ul>');
		}break;
		case "hum":
		{
			echo ('
				<ul class="navmenu">
					<li><a onClick="location.href=\'principal.php\'" style="cursor:pointer;"">Inicio</a></li>
					<li><a style="cursor:pointer;">Archivos Maestros</a>');
						$estilos=ajustar_menu(@$_SESSION['linksethu'][1],'hu',1);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linksethu'][1]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Procesos</a>');
						$estilos=ajustar_menu(@$_SESSION['linksethu'][2],'hu',2);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linksethu'][2]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Herramientas</a>');
						$estilos=ajustar_menu(@$_SESSION['linksethu'][3],'hu',3);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linksethu'][3]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Informes</a>');
						$estilos=ajustar_menu(@$_SESSION['linksethu'][4],'hu',4);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linksethu'][4]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a onClick="mypop=window.open(\'../spid.php?pagina=ayuda.php\',\'\',\'\');mypop.focus();" style="cursor:pointer;">Ayuda</a></li>
					<li style="text-align:right; float:right"><a>'.vigencia_usuarios(@$_SESSION['cedulausu']).'</a></li>');
					if(@$_SESSION["perfil"]=="Superman"){echo('<li><a onClick="alert(\''."Pagina: $nombre_archivo\\nBase: $datin[0]\\nFecha: $fechabackup".'\')" style="cursor:pointer;">Link</a></li>');}
					echo('<li style="vertical-align:bottom; line-height: 20px; float:right" ><a>Ir a:<input name="atajos" type="search" size="11" style="height:20px" placeholder="Digite atajo..." onkeypress="if(validateEnter(event) == true) {abriratajo(this.value)}"></a></li></ul>');
		}break;
		case "meci":
		{
			echo ('
				<ul class="navmenu">
					<li><a onClick="location.href=\'principal.php\'" style="cursor:pointer;">Inicio</a></li>
					<li><a style="cursor:pointer;">Archivos Maestros</a>');
						$estilos=ajustar_menu(@$_SESSION['linkset'][1],'',1);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linkset'][1]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Procesos</a>');
						$estilos=ajustar_menu(@$_SESSION['linkset'][2],'',2);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linkset'][2]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Herramientas</a>');
						$estilos=ajustar_menu(@$_SESSION['linkset'][3],'',3);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linkset'][3]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Informes</a>');
						$estilos=ajustar_menu(@$_SESSION['linkset'][4],'',4);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linkset'][4]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a onClick="mypop=window.open(\'../spid.php?pagina=ayuda.php\',\'\',\'\');mypop.focus();" style="cursor:pointer;">Ayuda</a></li><li style="text-align:right; float:right"><a>'.vigencia_usuarios(@$_SESSION['cedulausu']).'</a></li>');
					if(@$_SESSION["perfil"]=="Superman"){echo('<li><a onClick="alert(\''."Pagina: $nombre_archivo\\nBase: $datin[0]\\nFecha: $fechabackup".'\')" style="cursor:pointer;">Link</a></li>');}
					echo('<li style="vertical-align:bottom; line-height: 20px; float:right" ><a>Ir a:<input name="atajos" type="search" size="11" style="height:20px" placeholder="Digite atajo..." onkeypress="if(validateEnter(event) == true) {abriratajo(this.value)}"></a></li></ul>');
		}break;
		case "inve":
		{
			echo ('
					<ul class="navmenu">
					<li><a onClick="location.href=\'principal.php\'" style="cursor:pointer;">Inicio</a></li>
					<li><a style="cursor:pointer;">Archivos Maestros</a>');
						$estilos=ajustar_menu(@$_SESSION['linksetin'][1],'in',1);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linksetin'][1]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Procesos</a>');
						$estilos=ajustar_menu(@$_SESSION['linksetin'][2],'in',2);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linksetin'][2]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Herramientas</a>');
						$estilos=ajustar_menu(@$_SESSION['linksetin'][3],'in',3);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linksetin'][3]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Informes</a>');
						$estilos=ajustar_menu(@$_SESSION['linksetin'][4],'in',4);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linksetin'][4]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a onClick="mypop=window.open(\'../spid.php?pagina=ayuda.php\',\'\',\'\');mypop.focus();" style="cursor:pointer;">Ayuda</a></li><li style="text-align:right; float:right"><a>'.vigencia_usuarios(@$_SESSION['cedulausu']).'</a></li>');
					if(@$_SESSION["perfil"]=="Superman"){echo('<li><a onClick="alert(\''."Pagina: $nombre_archivo\\nBase: $datin[0]\\nFecha: $fechabackup".'\')" style="cursor:pointer;">Link</a></li>');}
					echo('<li style="vertical-align:bottom; line-height: 20px; float:right" ><a>Ir a:<input name="atajos" type="search" size="11" style="height:20px" placeholder="Digite atajo..." onkeypress="if(validateEnter(event) == true) {abriratajo(this.value)}"></a></li></ul>');
		}break;
		case "ccpet":
		{
			echo ('
				<ul class="navmenu">
					<li><a onClick="location.href=\'principal.php\'" style="cursor:pointer;">Inicio</a></li>
					<li><a style="cursor:pointer;">Archivos Maestros</a>');
						$estilos=ajustar_menu(@$_SESSION['linksetccp'][1],'cc',1);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linksetccp'][1]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Proceso Ingreso </a>');
						$estilos=ajustar_menu(@$_SESSION['linksetccp'][2],'cc',2);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linksetccp'][2]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Proceso Gastos </a>');
						$estilos=ajustar_menu(@$_SESSION['linksetccp'][3],'cc',3);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linksetccp'][3]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Reportes</a>');
						$estilos=ajustar_menu(@$_SESSION['linksetccp'][4],'cc',4);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linksetccp'][4]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Herramientas</a>');
						$estilos=ajustar_menu(@$_SESSION['linksetccp'][5],'cc',5);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',@$_SESSION['linksetccp'][5]);
						echo('<ul class="subsmenu" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a onClick="mypop=window.open(\'../spid.php?pagina=ayuda.php\',\'\',\'\');mypop.focus();" style="cursor:pointer;">Ayuda</a></li><li style="text-align:right; float:right"><a>'.vigencia_usuarios(@$_SESSION['cedulausu']).'</a></li>');
					if($_SESSION["perfil"]=="Superman"){echo('<li><a onClick="alert(\''."Pagina: $nombre_archivo\\nBase: $datin[0]\\nFecha: $fechabackup".'\')" style="cursor:pointer;">Link</a></li>');}
					echo('<li style="vertical-align:bottom; line-height: 20px; float:right" ><a>Ir a:<input name="atajos" type="search" size="11" style="height:20px" placeholder="Digite atajo..." onkeypress="if(validateEnter(event) == true) {abriratajo(this.value)}"></a></li></ul>');
		}break;
		case "ayuda":
		{
			echo ('
					<ul class="navmenu">
						<li><a onClick="location.href=\'principal.php\'" style="cursor:pointer;">Inicio</a></li>
						<li><a onClick="location.href=\' \'" style="cursor:pointer;">Manuales</a></li>
						<li><a onClick="location.href=\' \'" style="cursor:pointer;">Procesos</a></li>
						<li style="text-align:right; float:right"><a>'.vigencia_usuarios(@$_SESSION['cedulausu']).'</a></li>');
					if(@$_SESSION["perfil"]=="Superman"){echo('<li><a onClick="alert(\''."Pagina: $nombre_archivo\\nBase: $datin[0]\\nFecha: $fechabackup".'\')" style="cursor:pointer;">Link</a></li>');}
					echo('<li style="vertical-align:bottom; line-height: 20px; float:right" ><a>Ir a:<input name="atajos" type="search" size="11" style="height:20px" placeholder="Digite atajo..." onkeypress="if(validateEnter(event) == true) {abriratajo(this.value)}"></a></li>
					</ul>
				');
		}break;
	}
	echo "</div></td>";
}
//FIN CARGA MENU DESPLEGABLE
//INICIO CARGA CUADRO DE TITULOS
function cuadro_titulos()
{
	$hora=time();
	$conexion = conectar_v7();
	$sqlr="SELECT razonsocial FROM configbasica";
	$row =mysqli_fetch_row(mysqli_query($conexion,$sqlr));
	$ttentidad=$row[0];
	$sqlr="SELECT * FROM interfaz01 ";
	$resp = mysqli_query($conexion,$sqlr);
	$ntr = mysqli_num_rows($resp);
	$row =mysqli_fetch_row($resp);
	if($ntr==0)
	{
		$ttlema="Ingresar Lema de la Entidad";
		$ttcolor1="#000000";
		$ttcolor2="#ffffff";
		$sqlr1="SELECT descripcion_valor FROM dominios WHERE nombre_dominio='TIPOS_DE_LETRA' AND valor_inicial='1'";
		$row1 =mysqli_fetch_row(mysqli_query($conexion,$sqlr1));
		$ttletra1= $row1[0];
		$ttflle01="normal";
		$ttle01="100%";
		$ttcolorl1="#000000";
		$sqlr1="SELECT descripcion_valor FROM dominios WHERE nombre_dominio='TIPOS_DE_LETRA' AND valor_inicial='1'";
		$row1 =mysqli_fetch_row(mysqli_query($conexion,$sqlr1));
		$ttletra2= $row1[0];
		$ttflle02="normal";
		$ttle02="100%";
		$ttcolorl2="#000000";
	}
	else
	{
		$ttlema=$row[0];
		$ttcolor1=$row[1];
		$ttcolor2=$row[2];
		$sqlr1="SELECT descripcion_valor FROM dominios WHERE nombre_dominio='TIPOS_DE_LETRA' AND valor_inicial='$row[3]'";
		$row1 =mysqli_fetch_row(mysqli_query($conexion,$sqlr1));
		$ttletra1= $row1[0];
		$ttflle01=$row[4];
		$ttle01="$row[5]%";
		$ttcolorl1=$row[6];
		$sqlr1="SELECT descripcion_valor FROM dominios WHERE nombre_dominio='TIPOS_DE_LETRA' AND valor_inicial='$row[7]'";
		$row1 =mysqli_fetch_row(mysqli_query($conexion,$sqlr1));
		$ttletra2= $row1[0];
		$ttflle02=$row[8];
		$ttle02="$row[9]%";
		$ttcolorl2=$row[10];
	}
	echo"
	<td style='height:50px; width:36%;margin-right:0px;padding-right:0px'>
		<img src='imagenes/escudo.jpg'  style='width:14%;height:131%;float:left;margin-top:1px;'/>
		<table style='width:85%;height:100%; background: -webkit-linear-gradient($ttcolor1,$ttcolor2);float:left; border-top-right-radius:4px; border-bottom-right-radius:4px;'>
			<tr>
				<td style='font-family:$ttletra1;font-style:$ttflle01;text-align:center;font-size:$ttle01;color:$ttcolorl1;'>$ttentidad</td>
			</tr>
			<tr>
				<td style='font-family:$ttletra2;font-style:$ttflle02;text-align:center;font-size:$ttle02;color:$ttcolorl2;'>$ttlema</td>
			</tr>
		</table>
	</td>";
	echo('
	<td style="margin-left:0px;padding-left:0px ">
		<table class="inicio" style="width:100%;margin-left:0px;padding-left:0px">
			<tr>
				<td class="saludot"  style="width:1.5cm;" >Usuario: </td>
				<td>'.substr(ucwords((strtolower(@$_SESSION['usuario']))),0,14).'</td>
				<td class="saludot" style="width:1.5cm;">Perfil: </td>
				<td>'.substr(ucwords((strtolower(@$_SESSION["perfil"]))),0,14).'</td>
				<td rowspan="2"><img class="marco01" id="imagencmS" src="'.@$_SESSION["fotousuario"].'" style="height:57px; width:50px;" /></td>
			</tr>
			<tr>
				<td class="saludot" style="width:1.5cm;">Fecha ingreso:</td>
				<td>'.' '.$fec=date("d-m-Y").'</td>
				<td class="saludot" style="width:1.5cm;">Hora Ingreso: </td>
				<td>'.' '.date ( "h:i:s" , $hora ).'</td>
			</tr>
		</table>
	</td>');
}
//FIN CARGA CUADRO DE TITULOS
//****BUSQUEDA RECURSIVA
function buscaplan($padre,$prioridad,$minimaprioridad,$color,$color2)
{
	$tipo=array();
	$tipo[0]="folder";
	$tipo[1]="file";
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	//echo "<tr class=$color><td>$padre</td><td>$row[1]</td><td ><a href='plan-editaplandesarrollo.php?idproceso=$row[0]'><center><img src='imagenes/buscarep.png'></center></a></td></tr>";
	$sqlr="Select distinct *from presuplandesarrollo where padre like '$padre'";
	$resp2 = mysql_query($sqlr,$conexion);
	//echo "<br>$sqlr";
	while ($row=mysql_fetch_row($resp2))
    {
		/*$sqlr="Select distinct *from presuplandesarrollo where codigo=$padre";
		$resp3 = mysql_query($sqlr,$conexion);
		$fila=mysql_fetch_row($resp3);
		*/
		if($minimaprioridad==$row[5]){$clase="file";$vinculo="plan-indicadores.php";}
		else{$clase="folder";$vinculo="plan-indicadores.php";}
		$aux=$color;
		$color=$color2;
		$color2=$aux;
		echo "<ul><li><span class='$clase'>$row[0] $row[1]<a href='$vinculo?idproceso=$row[0]&tipo=$row[5]'><img src='imagenes/ver.png' ></a></span>";
		$aux=$color;
		$color=$color2;
		$color2=$aux;
		if($row){buscaplan($row[0],$row[5],$minimaprioridad,$color,$color2);echo "</li></ul>";}
    }
}
function buscaplanedit($padre,$prioridad,$minimaprioridad,$color,$color2)
 {
	$tipo=array();
	$tipo[0]="folder";
	$tipo[1]="file";
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	//echo "<tr class=$color><td>$padre</td><td>$row[1]</td><td ><a href='plan-editaplandesarrollo.php?idproceso=$row[0]'><center><img src='imagenes/buscarep.png'></center></a></td></tr>";
	$sqlr="Select distinct *from presuplandesarrollo where padre like '$padre'";
	$resp2 = mysql_query($sqlr,$conexion);
	//echo "<br>$sqlr";
	while ($row=mysql_fetch_row($resp2))
    {
		/*$sqlr="Select distinct *from presuplandesarrollo where codigo=$padre";
		$resp3 = mysql_query($sqlr,$conexion);
		$fila=mysql_fetch_row($resp3);
		*/
		if($minimaprioridad==$row[5]){$clase="file";$vinculo="plan-editaplandesarrollo.php";}
		else{$clase="folder";	$vinculo="plan-editaplandesarrollo.php";}
		$aux=$color;
		$color=$color2;
		$color2=$aux;
		echo "<ul><li><span class='$clase'>$row[0] $row[1]<a href='$vinculo?idproceso=$row[0]&tipo=$row[5]'><img src='imagenes/ver.png' ></a></span>";
		$aux=$color;
		$color=$color2;
		$color2=$aux;
		if($row){buscaplanedit($row[0],$row[5],$minimaprioridad,$color,$color2);echo "</li></ul>";}
    }
}
//***
function buscavariable_pd($codigo,$vigenciai,$vigenciaf)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="Select distinct *from presuplandesarrollo where codigo like '$codigo' and vigencia=$vigenciai and vigenciaf=$vigenciaf";
	$resp2 = mysql_query($sqlr,$conexion);
	$variable=array();
	while ($row=mysql_fetch_row($resp2))
    {
		$variable[0]=$row[0];
		$variable[1]=$row[1];
		$variable[2]=$row[5];
		$variable[3]=$row[2];
	}
	return $variable;
}
function tipos_pd($tipo)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="select *from dominios where nombre_dominio='PLAN_DESARROLLO' and VALOR_INICIAL=$tipo order by VALOR_INICIAL";
	$resp2 = mysql_query($sqlr,$conexion);
	while ($row=mysql_fetch_row($resp2)){$variable=$row[1];}
	return $variable;
}
//***
function buscaestrato_servicios($codigo)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select * from servestratos where id='$codigo'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor2=$r[0]." - ".$r[2]." - ".$r[1];$co+=1;}
	if ($co>0){$nombre=$valor2;}
	else {$nombre="";}
	return $nombre;
}
function buscaclienteserv($documento)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="select terceros_servicios.cedulanit from terceros, terceros_servicios where terceros.cedulanit=terceros_servicios.cedulanit and terceros_servicios.consecutivo='$documento'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$nombre=$r[0];}
	return $nombre;
}
function buscaclienteserv2($codigo)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="select terceros_servicios.consecutivo from terceros, terceros_servicios where terceros.cedulanit=terceros_servicios.cedulanit and terceros_servicios.cedulanit='$codigo'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$nombre=$r[0];}
	echo $sqlr;
	return $nombre;
}

function buscaclienteserv3($codigo)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="select t.razonsocial,t.apellido1,t.apellido2,t.nombre1,t.nombre2 from terceros t, servclientes sc where sc.terceroactual=t.cedulanit and sc.codigo='$codigo'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res))
	{
		if($r[0]==""){$nombre[0]=$r[1].' '.$r[2].' '.$r[3].' '.$r[4];}
		else{$nombre[0]=$r[0];}
	}
	$sqlr2="select codigo from servmedidores where cliente=".$codigo;
	$resp2=mysql_query($sqlr2,$linkbd);
	$row2=mysql_fetch_row($resp2);
	if($row2[0]==""){$nombre[1]="MEDIDOR NO ASIGNADO";}
	else{$nombre[1]=$row2[0];}
	return $nombre;
}
function buscasubsidio_valor($servicio,$estrato,$tipoliquida, $valormed)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	if($tipoliquida==1)
	$sqlr="select servsubsidios_det.valor from servsubsidios,servsubsidios_det where servsubsidios.codigo=servsubsidios_det.codigo and 	servsubsidios.codservicio='$servicio' and servsubsidios_det.estrato='$estrato' and  servsubsidios_det.estado='S'";
	if($tipoliquida==2)
	$sqlr="select servsubsidios_det.valor from servsubsidios,servsubsidios_det where servsubsidios.codigo=servsubsidios_det.codigo and servsubsidios.codservicio='$servicio' and servsubsidios_det.estrato='$estrato' and '$valormed' between servsubsidios_det.rango2 and servsubsidios_det.rango2 and  servsubsidios_det.estado='S' ";
	$res=mysql_query($sqlr,$conexion);
	$valor=0;
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
	return $valor;
}
function buscadescuento_valor($servicio,$estrato,$tipoliquida, $valormed)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	if($tipoliquida==1)
		$sqlr="select servdescuentos_det.valor from servdescuentos,servdescuentos_det where servdescuentos.codigo=servdescuentos_det.codigo and servdescuentos.codservicio='$servicio' and servdescuentos_det.estrato='$estrato' and  servdescuentos_det.estado='S'";
	if($tipoliquida==2)
		$sqlr="select servdescuentos_det.valor from servdescuentos,servdescuentos_det where servsubsidios.codigo=servdescuentos_det.codigo and servdescuentos.codservicio='$servicio' and servdescuentos_det.estrato='$estrato' and '$valormed' between servdescuentos_det.rango2 and servdescuentos_det.rango2 and  servdescuentos_det.estado='S' ";
	$res=mysql_query($sqlr,$conexion);
	$valor=0;
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
	return $valor;
}
function buscatarifa_valor($servicio,$estrato,$tipoliquida, $valormed)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	if($tipoliquida==1)
		$sqlr="select servtarifas_det.valor, servtarifas_det.valorcf from servtarifas,servtarifas_det where servtarifas.codigo=servtarifas_det.codigo and servtarifas.codservicio='$servicio' and servtarifas_det.estrato='$estrato' and  servtarifas_det.estado='S'";
	if($tipoliquida==2)
		$sqlr="select servtarifas_det.valor, servtarifas_det.valorcf from servtarifas,servtarifas_det where servtarifas.codigo=servtarifas_det.codigo and servtarifas.codservicio='$servicio' and servtarifas_det.estrato='$estrato' and '$valormed' between servtarifas_det.rango2 and servtarifas_det.rango2 and  servtarifas_det.estado='S' ";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor[0]=$r[0];$valor[1]=$r[1];}
	return $valor;
}
function buscacontribucion_valor($servicio,$estrato,$tipoliquida,$valormed)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	if($tipoliquida==1)
		$sqlr="select servcontribuciones_det.valor from servcontribuciones,servcontribuciones_det where servcontribuciones.codigo=servcontribuciones_det.codigo and servcontribuciones.codservicio='$servicio' and servcontribuciones_det.estrato='$estrato' and  servcontribuciones_det.estado='S'";
	if($tipoliquida==2)
		$sqlr="select servcontribuciones_det.valor from servcontribuciones,servcontribuciones_det where servcontribuciones.codigoservcontribuciones_det.codigo and servcontribuciones.codservicio='$servicio' and servcontribuciones_det.estrato='$estrato' and '$valormed' between servcontribuciones_det.rango2 and servcontribuciones_det.rango2 and  servcontribuciones_det.estado='S' ";
	$res=mysql_query($sqlr,$conexion);
	$valor=0;
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
	return $valor;
}
function mostrarservicios($cliente)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="select servicio from  terceros_servicios where  terceros_servicios.estado='S' and terceros_servicios.consecutivo='$cliente' ";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor.=" ".$r[0];}
	return $valor;
}
function buscaservicio_liquida($servicio)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="select tipo_liqui from  servservicios where  servservicios.codigo='$servicio' ";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
	return $valor;
}
function buscaservicio_cc($servicio)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="select cc from  servservicios where  servservicios.codigo='$servicio' ";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
	return $valor;
}
function buscamedicion($servicio,$medidor,$cliente)
{

}
function buscasaldoanterior($servicio,$cliente)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$valor=0;
	$c=0;
	//$sqlr="select codigo from  servliquidaciones, servliquidaciones_det where  servliquidaciones.estado='S' and servliquidaciones.codusuario='$cliente' and servliquidaciones.id_liquidacion=servliquidaciones_det.id_liquidacion and servliquidaciones_det.servicio='$servicio'";
	$sqlr="SELECT * FROM (SELECT sn.id_liquidacion, sn.codusuario,det.servicio, det.valorliquidacion,sn.estado
					FROM servliquidaciones sn, servliquidaciones_det  det, servfacturas fac
						WHERE sn.id_liquidacion = det.id_liquidacion
						AND sn.codusuario = '$cliente' and det.servicio='$servicio'
						and  sn.factura=fac.id_factura
						ORDER BY sn.id_liquidacion DESC)SUB	";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res))
	{
		if($r[4]=='S'){$valor=$r[0];}
		else{$c+=1;exit;}
	}
	if($valor==0 && $c==0)
	{
		$sqlr="SELECT saldo FROM terceros_servicios where consecutivo='".$cliente."' AND ESTADO='S' and servicio='$servicio' order by servicio";
		//echo "<br>sw: ".$sqlr;
		$resp=mysql_query($sqlr,$conexion);
		while($rowEmp =mysql_fetch_row($resp)){$valor=	$rowEmp[0];}
		//echo "suma: ".$valor;
	}
	return $valor;
}
function buscarmedidor($cliente)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="select codigo from  servmedidores where  servmedidores.estado='S' and servmedidores.cliente='$cliente' ";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
	return $valor;
}
function buscarmedidor_servicios($cliente)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="select servicio from  servmedidores_servicios where  servmedidores_servicios.estado='S' and servmedidores_servicios.codigo='$cliente' ";
	$res=mysql_query($sqlr,$conexion);
	$valor=' ';
	while($r=mysql_fetch_row($res))
	{$valor.=$r[0]." ";}
	return $valor;
}
function buscaconcepto_sp($servicio,$tipo)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	switch ($tipo)
	{
		case 'TR':  //tarifas
			$sqlr="select concecont from servtarifas where codservicio='$servicio' and estado='S' ";break;
		case 'SB':  //subsidios
			$sqlr="select concecont from servsubsidios where codservicio='$servicio' and estado='S' ";break;
		case 'CT':  //contribucion
			$sqlr="select concecont from servcontribuciones where codservicio='$servicio' and estado='S' ";break;
		case 'DS': //descuentos
			$sqlr="select concecont from servdescuentos where codservicio='$servicio' and estado='S' ";break;
	}
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
	return $valor;
}
//conceptos contables en general
function concepto_cuentas($concepto,$tipo,$modulo,$centrocosto,$fecha)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sq="select fechainicial from conceptoscontables_det where codigo='$concepto' and modulo='$modulo' and cc='$centrocosto' and tipo='$tipo' and fechainicial<'$fecha' and cuenta!='' order by fechainicial asc";
	$re=mysql_query($sq,$conexion);
	while($ro=mysql_fetch_assoc($re))
	{
		$_POST[fechacausa]=$ro["fechainicial"];
	}
	$sqlr="Select distinct conceptoscontables_det.cuenta, conceptoscontables_det.tipocuenta,conceptoscontables_det.debito,conceptoscontables_det.credito from conceptoscontables, conceptoscontables_det where conceptoscontables.tipo='$tipo' and conceptoscontables_det.tipo='$tipo' and conceptoscontables.codigo=conceptoscontables_det.codigo and conceptoscontables.codigo='$concepto' and conceptoscontables_det.codigo='$concepto' and conceptoscontables_det.modulo=$modulo and conceptoscontables_det.cc like '%$centrocosto%' and conceptoscontables_det.fechainicial='".$_POST[fechacausa]."'";
	$res=mysql_query($sqlr,$conexion);
	//echo "<br>".$sqlr;
	$valor[]=array();
	$con=0;
	while($r=mysql_fetch_row($res))
	{
	$valor[$con][0]=$r[0]; //cuenta
	$valor[$con][1]=$r[1]; //tipo cuenta
	$valor[$con][2]=$r[2]; //debito
	$valor[$con][3]=$r[3]; //credito
	$con+=1;
	}
	return $valor;
}
//****fin servicios publicos
function buscarareatrabajo($idarea)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="select nombrearea from  planacareas where   planacareas.codarea='$idarea' ";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
	return $valor;
}

//**** buscar datos de cualquier dominio
function buscar_dominio($dominio,$valini,$valfin,$tipo,$varsalida)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	if($valini==NULL){$cond1=" and (valor_inicial is NULL or valor_inicial='')";}
	else{$cond1=" and  valor_inicial = '$valini'";}
	if($valfin==NULL){$cond2=" and (valor_final is NULL or valor_final='')";}
	else{$cond2=" and  valor_final = '$valfin'";}
	if($tipo==NULL){$cond3=" and (tipo is NULL or tipo='')";}
	else{$cond3=" and  tipo like '%$tipo%'";}
	$sqlr="select $varsalida from  dominios where nombre_dominio='$dominio' $cond1 $cond2 $cond3 ";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
	return $valor;
}
function buscar_empleado($documento,$campo='')
{
	$linkbd=conectar_v7();
	$linkbd -> set_charset("utf8");
	if($campo == NULL || $campo>1)
	$campo=0;
	$crit2=" and t.cedulanit like '%$documento%' ";
	$sqlr='SELECT concat(t.nombre1," ",t.nombre2," ",t.apellido1," ",t.apellido2), pl.nombrecargo, pt.* FROM terceros t, planestructura_terceros pt, planaccargos pl WHERE pt.estado="S" AND pt.cedulanit = t.cedulanit AND pl.codcargo = pt.codcargo'.$crit1.$crit2.' order by t.apellido1, t.apellido2, t.nombre1, t.nombre2';
	$res=mysqli_query($linkbd,$sqlr);
	while($r=mysqli_fetch_row($res)){$valor=$r[$campo];}
	return $valor;
}
//***** genera semaforo
function  semaforo($estadofase)
{
	switch ($estadofase)
	{
		case 1:
			echo "<img src='imagenes/sema_rojoON.jpg' width='16px' height='16px'><img src='imagenes/sema_amarilloOFF.jpg' width='16px' height='16px'><img src='imagenes/sema_verdeOFF.jpg' width='16px' height='16px'>";break;
		case 2:
			echo "<img src='imagenes/sema_rojoOFF.jpg' width='16px' height='16px'><img src='imagenes/sema_amarilloON.jpg' width='16px' height='16px'><img src='imagenes/sema_verdeOFF.jpg' width='16px' height='16px'>";break;
		case 3:
			echo "<img src='imagenes/sema_rojoOFF.jpg' width='16px' height='16px'><img src='imagenes/sema_amarilloOFF.jpg' width='16px' height='16px'><img src='imagenes/sema_verdeON.jpg' width='16px' height='16px'>";break;
	}
}
//****************
function busca_cdpcontrato($cdp,$vigencia,$tipodoc)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$valor=array();
	$sqlr="select proceso from contrasolicitudcdpppto where vigencia='$vigencia' and tipodoc='$tipodoc' and ndoc=$cdp";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$proceso=$r[0];}
	//echo $sqlr;

	$sqlr="select contrato from contraprocesos where idproceso=$proceso";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$contrato=$r[0];}

	//echo $sqlr;
	$sqlr="select numcontrato,contratista from contracontrato where vigencia='$vigencia'  and numcontrato=$contrato";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res))
	{
	$valor[0]=$r[0];
	$valor[1]=$r[1];
	}
	//echo $sqlr;
	return $valor;
}
//**Inicio copiar carpeta con todo el contenido
function full_copy( $source, $target )
{
	if ( is_dir( $source ) )
	{
		@mkdir( $target );
		$d = dir( $source );
		while ( FALSE !== ( $entry = $d->read() ) )
		{
			if ( $entry == '.' || $entry == '..' ) { continue;}
			$Entry = $source . '/' . $entry;
			if ( is_dir( $Entry ) ){full_copy( $Entry, $target . '/' . $entry ); continue;}
			copy( $Entry, $target . '/' . $entry );
		}
		$d->close();
	}
	else {copy( $source, $target );}
}
//**Inicio comprimir carpeta**
function comprimir($ruta, $zip_salida, $handle = false, $recursivo = false)
{
	if(!$handle)
	{
		$handle = new ZipArchive;
		if ($handle->open($zip_salida, ZipArchive::CREATE) === false){}
	}
	if(is_dir($ruta))
	{
		$ruta = dirname($ruta.'/arch.ext');
		$handle->addEmptyDir($ruta);
		foreach(glob($ruta.'/*') as $url){comprimir($url, $zip_salida, $handle, true);}
	}
	else{$handle->addFile($ruta);}
	if(!$recursivo){$handle->close();}
}
//**Descomprimir carpeta
function descomprimir($ruta)
{
	$zip = new ZipArchive;
	if ($zip->open($ruta.".zip") === TRUE)
	{
		$zip->extractTo(getcwd()."/");
		$zip->close();
	}
}
//**mirar icono del archivo
function traeico($archivo)
{
	$ext=explode(".",$archivo);
	switch (strtoupper(@$ext[1]))
	{
		case "":
			$icono='<img style="width:17px; height:17px" src="imagenes/tipodoc/sinarch.png" title="Sin Archivo">';
			break;
		case "DOC":
			$icono='<img style="width:20px" src="imagenes/tipodoc/doc1.png" title="(.doc)">';
			break;
		case "DOCX":
			$icono='<img style="width:20px" src="imagenes/tipodoc/doc1.png" title="(.docx)">';
			break;
		case "PDF":
			$icono='<img style="width:20px" src="imagenes/tipodoc/pdf2.png" title="(.pdf)">';
			break;
		case "JPG":
			$icono='<img style="width:20px" src="imagenes/tipodoc/imagen_jpg.png" title="(.jpg)">';
			break;
		case "BPM":
			$icono='<img style="width:20px" src="imagenes/tipodoc/imagen_bmp.png" title="(.bpm)">';
			break;
		case "GIF":
			$icono='<img style="width:20px" src="imagenes/tipodoc/imagen_gif.png" title="(.gif)">';
			break;
		case "PNG":
			$icono='<img style="width:20px" src="imagenes/tipodoc/imagen_png.png" title="(.png)">';
			break;
		case "TXT":
			$icono='<img style="width:20px" src="imagenes/tipodoc/imagen_txt.png" title="(.txt)">';
			break;
		default:
			$icono='<img style="width:20px" src="imagenes/tipodoc/unknown.png" title="Desconocido">';

	}
	return $icono;
}
function buscaingreso_valor($cuenta)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$valor=0;
	$sqlr="select precio from tesoingresos_precios where ingreso='$cuenta' and estado='S'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
	return $valor;
}

// funcion para saber si el codigo de ingreso es gravado con iva o no
function buscaingreso_gravado($iva)
{
    $datin=datosiniciales();
    if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
        die("no se puede conectar");
    if(!mysql_select_db($datin[0]))
        die("no se puede seleccionar bd");
    $gravado = '';
    $sqlr="select gravado from tesoingresos where codigo='$iva' and estado='S'";
    $res=mysql_query($sqlr,$conexion);
    while($r=mysql_fetch_row($res)){$gravado=$r[0];}
    return $gravado;
}

function buscaproductos($padre,$prioridad,$minimaprioridad,$color,$color2)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="Select distinct *from productospaa where padre like '$padre'";
	$resp2 = mysql_query($sqlr,$conexion);
	while ($row=mysql_fetch_row($resp2))
    {
		switch($row[2])
		{
			case "2":
				echo "<tr class='$color2'><td width='10%' colspan=\"2\" style=\"text-align:right\">$row[0]</td><td colspan=\"4\">$row[1]</td></tr>";
				break;
			case "3":
				echo "<tr class='$color2'><td width='15%' colspan=\"3\" style=\"text-align:right\">$row[0]</td><td colspan=\"3\">$row[1]</td></tr>";
				break;
			case "4":
				echo "<tr class='$color2'><td width='20%' colspan=\"4\" style=\"text-align:right\">$row[0]</td><td colspan=\"2\">$row[1]</td></tr>";
				break;
			default:
				echo "<tr class='$color2'><td width='25%' colspan=\"5\" style=\"text-align:right\">$row[0]</td><td>$row[1]</td></tr>";
		}
		$aux=$color;
		$color=$color2;
	 	$color2=$aux;
		if($row){buscaproductos($row[0],$row[3],$minimaprioridad,$color,$color2);}
	}
}
function buscaproductos_arbol($padre,$prioridad,$minimaprioridad,$color,$color2)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="Select distinct *from productospaa where padre like '$padre'";
	$resp2 = mysql_query($sqlr,$conexion);
	while ($row=mysql_fetch_row($resp2))
    {
		if($minimaprioridad==$row[3]){$clase="file";$vinculo="plan-indicadores.php";}
		else{$clase="folder";$vinculo="plan-indicadores.php";}
		$aux=$color;
		$color=$color2;
		$color2=$aux;
	 	echo "<ul><li><span class='$clase'>$row[0] $row[1]<a href='$vinculo?idproceso=$row[0]&tipo=$row[3]'><img src='imagenes/ver.png' ></a></span>";
		$aux=$color;
		$color=$color2;
		$color2=$aux;
		if($row)
		{
			//echo "<br>$row[11]";
			buscaproductos_arbol($row[0],$row[3],$minimaprioridad,$color,$color2);
			echo "</li></ul>";
		}
  	}
}
//*****BUSCA PRODUCTOS COMPRAS
function buscadquisicion($codigo)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="select codigosunspsc, descripcion, codplan from contraplancompras where codplan='$codigo' ";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){
		$valor[0]=$r[0];
		$valor[1]=$r[1];
		$valor[2]=$r[2];
	}
	return $valor;
}
//*****BUSCA PRODUCTOS SOLICIUD ADOQUISICIONAL
function buscasoladquisicion($codigo)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="select codproductos, objeto, codsolicitud, numproductos, valortotal, valunitariop from contrasoladquisiciones where codsolicitud='$codigo' and estado='S' and activo='1'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){
		$valor[0]=$r[0];
		$valor[1]=$r[1];
		$valor[2]=$r[2];
		$valor[3]=$r[3];
		$valor[4]=$r[4];
		$valor[5]=$r[5];
	}
	return $valor;
}
//*****BUSCA PRODUCTOS SOLICIUD RESERVA
function buscasolreserva($codigo){
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="SELECT almreservas.codigo, almreservas.solicitante, almreservas.detalle FROM almreservas WHERE almreservas.codigo='$codigo' AND (almreservas.estado='S' OR almreservas.estado='PND')";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){
		$valor[0]=$r[0];
		$valor[1]=$r[1];
		$valor[2]=$r[2];
	}
	return $valor;
}
//*****BUSCA PRODUCTOS SOLICIUD RESERVA
function buscasolreserva_temp($codigo){
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="SELECT almreservas.codigo, almreservas.solicitante, almreservas.detalle FROM almreservas WHERE almreservas.codigo='$codigo' ";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){
		$valor[0]=$r[0];
		$valor[1]=$r[1];
		$valor[2]=$r[2];
	}
	return $valor;
}
//*****BUSCA REVERSION
function buscainveitem($codigo, $movimiento, $tipoentra){
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$tipomov=$movimiento-2;
	$sqlr="SELECT codigo, nombre FROM almginventario WHERE codigo='$codigo' AND tipomov='$tipomov' AND tiporeg='$tipoentra'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){
		$valor[0]=$r[0];
		$valor[1]=$r[1];
	}
	return $valor;
}
//**** busca tercero con dependencia
function buscatercerod($cuenta)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="SELECT t.*, pl.*, pt.* FROM terceros t, planestructura_terceros pt, planaccargos pl WHERE pt.estado='S' AND t.cedulanit='$cuenta' AND pt.cedulanit = t.cedulanit AND pl.codcargo = pt.codcargo";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res))
	{
		if ($r[11]=='31'){$ntercero=$r[5];}
	   	else {$ntercero=$r[3].' '.$r[4].' '.$r[1].' '.$r[2];}
	   	$dependencia=strtoupper(buscarareatrabajo($r[25]));
		$coddependencia=$r[25];
	 	$co+=1;
	}
	if ($co>0)
	 {
	  $nombre[0]=$ntercero;
	  $nombre[1]=$dependencia;
	  $nombre[2]=$coddependencia;
	 }
	else {$nombre[0]=""; }
	return $nombre;
}
//*********
function buscaingreso_recaudo($recibo, $ingreso)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="select ingreso, valor from tesoreciboscaja_det where id_recibos=$recibo and ingreso='$ingreso'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor[0]=$r[0];$valor[1]=$r[1];}
	return $valor;
}
function buscaing_cobrorecibo($vigencia)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="select valor_inicial,valor_final from dominios where nombre_dominio='COBRO_RECIBOS' AND descripcion_valor='$vigencia' and  tipo='S'";
	$res=mysql_query($sqlr,$conexion);
	while ($row =mysql_fetch_row($res)){$valor[0]=$row[0];$valor[1]=$row[1];}
	return $valor;
}
function buscacomprobanteppto($tipocomp)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
    $sqlrchip="select nombre from pptotipo_comprobante where codigo='$tipocomp'";
	$reschip=mysql_query($sqlrchip,$conexion);
	$rowchip=mysql_fetch_row($reschip);
	return $rowchip[0];
}
//*****BUSCA PROYECTOS
function buscaproyectos($codigo,$vigencia="")
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="SELECT nombre, consecutivo, archivo, valor, descripcion FROM planproyectos WHERE codigo='$codigo'  ";
	$r=mysql_fetch_row(mysql_query($sqlr,$conexion));
	//$res=mysql_query($sqlr,$conexion);
	//while($r=mysql_fetch_row($res))
	{$valor[0]=$r[0];$valor[1]=$r[1];$valor[2]=$r[2];$valor[3]=$r[3];$valor[4]=$r[4];}
	//$valor=strtoupper($r[0]);
	return $valor;
}

//*****BUSCA EL PADRE PLANDEDESARROLLO
function buscapadreplan($codigo)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="select padre from presuplandesarrollo where codigo='".$codigo."' ";
	$row =mysql_fetch_row(mysql_query($sqlr,$conexion));
	$sqlr2="select codigo, nombre from presuplandesarrollo where codigo='".$row[0]."' ";
	$row2 =mysql_fetch_row(mysql_query($sqlr2,$conexion));
	{$valor[0]=$row2[0];$valor[1]=$row2[1];}
	return $valor;
}
//****busca pago terceros - ingreso - retencion
function buscapagotercero_detalle($codpago,$mes,$vigencia)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="SELECT tesopagoterceros_det.valor,tesopagoterceros.fecha FROM tesopagoterceros, tesopagoterceros_det
	WHERE
	tesopagoterceros_det.id_pago=tesopagoterceros.id_pago
	and tesopagoterceros_det.movimiento='$codpago'
	and MONTH(tesopagoterceros.fecha)='$mes'
	and YEAR(tesopagoterceros.fecha)='$vigencia' and tesopagoterceros.estado='S'";
	//echo "ssss   ".$sqlr;
	$r=mysql_fetch_row(mysql_query($sqlr,$conexion));
	//$res=mysql_query($sqlr,$conexion);
	//while($r=mysql_fetch_row($res))
	{$valor[0]=$r[0];$valor[1]=$r[1];}
	//$valor=strtoupper($r[0]);
	return $valor;
}
function cargarcodigopag($cod,$nivel)
{//header ("location: http://servidor/financiero/principal.php");
	if ($cod!="")
	{
		$datin=datosiniciales();
		if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
		die("no se puede conectar");
		if(!mysql_select_db($datin[0]))
		die("no se puede seleccionar bd");
		$cod=strtoupper($cod);
		$sqlr="SELECT id_opcion,ruta_opcion FROM opciones WHERE comando='".$cod."'";
		$r=mysql_fetch_row(mysql_query($sqlr,$conexion));
		$opsi=$r[0];
		if ($opsi!="")
		{
			$sqln="SELECT id_opcion FROM rol_priv WHERE id_rol='".$nivel."' AND id_opcion='".$opsi."'";
			$niv=mysql_fetch_row(mysql_query($sqln,$conexion));
			$supnivel=$niv[0];
			if($supnivel!="")
			{
				cargainfomenus(strtoupper(substr($cod,0,2)),$nivel);
				$pagina=$r[1];
				if($pagina!=""){$pagina="location: http://servidor/financiero/".$pagina;header ($pagina);}
				else{echo '<script >alert(" C\xf3digo de P\xe1gina Incorrecto");</script>';}
			}
			else
			{echo '<script >alert("No tiene los privilegios para abrir esta p\xe1gina");</script>';}
		}
		else{echo '<script >alert(" C\xf3digo de P\xe1gina Incorrecto");</script>';}
	}
}
function cargainfomenus($cod,$nivel)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	switch ($cod)
	{
		case "PE":
			$marcalink="linksetpl";
			$opcion="9";
			break;
		case "AD":
			$marcalink="linksetad";
			$opcion="0";
			break;
		case "AF":
			$marcalink="linksetac";
			$opcion="6";
			break;
		case "CO":
			$marcalink="linksetco";
			$opcion="1";
			break;
		case "TE":
			$marcalink="linksette";
			$opcion="4";
			break;
		case "CT":
			$marcalink="linksetct";
			$opcion="8";
			break;
		case "PR":
			$marcalink="linksetpr";
			$opcion="3";
			break;
		case "SP":
			$marcalink="linksetser";
			$opcion="10";
			break;
		case "GH":
			$marcalink="linksethu";
			$opcion="2";
			break;
		case "ME":
			$marcalink="linkset";
			$opcion="7";
			break;
		case "AL":
			$marcalink="linksetin";
			$opcion="5";
			break;
		case "CC":
			$marcalink="linksetccp";
			$opcion="11";
			break;
	}
	$_SESSION[$marcalink]=array();
	$sqlrw="Select DISTINCT (opciones.nom_opcion),opciones.ruta_opcion, opciones.niv_opcion,opciones.comando  from rol_priv, opciones where rol_priv.id_rol=$nivel and opciones.id_opcion=rol_priv.id_opcion and opciones.modulo='$opcion' group by (opciones.nom_opcion), opciones.ruta_opcion, opciones.niv_opcion,opciones.comando  order by opciones.orden";
	$resw=mysql_query($sqlrw,$conexion);
	while($roww=mysql_fetch_row($resw))
    {
	 	$_SESSION[$marcalink][$roww[2]].='<li> <a href="'.$roww[1].'">'.$roww[0].' <span style="float:right">'.$roww[3].'</span></a></li>';
	}
}
//******FUNCIONES PPTO *******
function buscacdp_detalle($numero,$vigencia)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="select objeto from pptocdp where vigencia=$vigencia and consvigencia=$numero";
	$res=mysql_query($sqlr,$conexion);
	while($row=mysql_fetch_row($res)){$valor=$row[0];}
 return $valor;
}
function buscacdp_rp($numero,$vigencia)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="select idcdp from pptorp where vigencia=$vigencia and consvigencia=$numero";
	$res=mysql_query($sqlr,$conexion);
	while($row=mysql_fetch_row($res)){$valor=$row[0];}
 	return $valor;
}
function buscaescalas($numero)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="SELECT * FROM humnivelsalarial WHERE id_nivel='$numero'";
	$res=mysql_query($sqlr,$conexion);
	while($row=mysql_fetch_row($res))
	{$valor[0]=$row[1];$valor[1]=$row[2];}
	return $valor;
}
function mesletras($mes)
{
	switch ($mes)
	{
		case "1":	$mesl="Enero";break;
		case "2":	$mesl="Febrero";break;
		case "3":	$mesl="Marzo";break;
		case "4":	$mesl="Abril";break;
		case "5":	$mesl="Mayo";break;
		case "6":	$mesl="Junio";break;
		case "7":	$mesl="Julio";break;
		case "8":	$mesl="Agosto";break;
		case "9":	$mesl="Septiembre";break;
		case "10":	$mesl="Octubre";break;
		case "11":	$mesl="Noviembre";break;
		case "12":	$mesl="Diciembre";
	}
	 return $mesl;
}
function buscararticulos($codigo)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="SELECT nombre FROM almarticulos WHERE estado='S' AND concat_ws('', grupoinven, codigo)='$codigo'";
	$row=mysql_fetch_row(mysql_query($sqlr,$conexion));
	return $row[0];
}
function selconsecutivo($base,$campo)
{
	$conexion=conectar_v7();
	$sqlr="SELECT MAX(CONVERT($campo, SIGNED INTEGER)) FROM $base";
	$resp = mysqli_query($conexion,$sqlr);
	while ($row =mysqli_fetch_row($resp)){$mx=$row[0];}
	$mx=$mx+1;
	return $mx;
}
function selconsecutivo1($base,$campo,$campo1)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="SELECT MAX(CONVERT($campo, SIGNED INTEGER)) FROM $base WHERE tipo_mov=$campo1";
    $resp = mysql_query($sqlr,$conexion);
    while ($row =mysql_fetch_row($resp)){$mx=$row[0];}
	$mx=$mx+1;
	return $mx;
}
function selconsecutivodomi($campo,$domi)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="SELECT MAX(CONVERT($campo, SIGNED INTEGER)) FROM dominios WHERE nombre_dominio='$domi'";
	$resp = mysql_query($sqlr,$conexion);
	while ($row =mysql_fetch_row($resp)){$mx=$row[0];}
	$mx=$mx+1;
	return $mx;
}
function selconsecutivohres($campo)
{
	$linkbd=conectar_v7();
	$sqlr="SELECT MAX(CONVERT(idhistory, SIGNED INTEGER)) FROM planacresponsables WHERE codradicacion='$campo'";
	$resp = mysqli_query($linkbd,$sqlr);
	while ($row =mysqli_fetch_row($resp)){$mx=$row[0];}
	$mx=$mx+1;
	return $mx;
}
function busquedageneralSN($ntabla,$ncampo,$datocp)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="SELECT * FROM $ntabla WHERE $ncampo='$datocp'";
	$res=mysql_query($sqlr,$conexion);
	while($row=mysql_fetch_row($res))
	{
		if($row[0]!=''){$valor='SI';}
		else {$valor='NO';}
	}
	return $valor;
}
function kill_Spid($carpeta)
{/*
	$carpeta2="../financiero/".$carpeta;
	foreach(glob($carpeta2 . "/*") as $archivos_carpeta)
	{
		if (is_dir($archivos_carpeta)){kill_SiiP($archivos_carpeta);}
		else{unlink($archivos_carpeta);}
	}
	rmdir($carpeta2);*/
}
function mortal_strike()
{
	//$fechakill = new DateTime('2015-12-31 10:34:09');
	//$fechahoy = new DateTime('now');
	//if($fechakill < $fechahoy){kill_SiiP();}
}
function validar_li($datos){
	$cont = count(explode('style',@$datos[1]));
	$res = ($cont<4) ? true : false ;
	return array($res, count($datos));
}
function ajustar_menu($menu,$nomb = '',$id = 1)
{
	$ancho=$estilo=0;
	$arrmenu=explode('<li>',$menu);
	$valid = validar_li(explode('<li',$menu));
	if ($valid[0])
	{
		$filas=count($arrmenu);
		$cols=ceil($filas/11);
		if($cols<=1)
		{
			$ancho='240px';
			$estilo='style="margin-left:-30px;
			padding-left:0px;"';
		}
		else
		{
			$valor=$cols*275;
			$ancho=$valor.'px';
			$top = 406;
			$estilo='style="margin-left:-40px;
			border-left:#ccc 1px solid;
			padding-left:10px;
			padding-right:50px;"';
			$style='style="float: right;
			width: 0%;
			margin-left: -40px;
			margin-top: -333px;
			border-left:#ccc 1px solid;
			padding-right: 287px;"';
			$j = 0;
			for ($i=0; $i < $filas; $i++)
			{
				if (($i>10)&&($j<1)) {$j++;}
				$menus[$j][] = $arrmenu[$i];
			}
			$menus[0] = implode('<li>', $menus[0]);
			$menus[0] = str_replace('<li>','<li '.$estilo.'>',$menus[0]);

			foreach ($menus[1] as $key => $val)
			{
				$top = $top-37;
				$temp = str_replace('333',$top,$style);
				$menus[1][$key] = ' '.$temp.'>'.$val;
				unset($temp);
			}
			$menus[1] = implode('<li', $menus[1]);
			$_SESSION['linkset'.$nomb][$id] = $menus[0].'<li'.$menus[1];
			$estilo = '';
		}
	}
	else
	{
		$cols=ceil($valid[1]/11);
		if($cols<=1){
			$ancho='240px';
			$estilo='style="margin-left:-30px;
			padding-left:0px;"';
		}
		else
		{
			$valor=$cols*275;
			$ancho=$valor.'px';
		}
	}
	return array($ancho, $estilo);
}
function paginasnuevas($modulo)
{
	switch ($modulo)
	{
		case "cont":	$pagina="mypop=window.open('../spid.php?pagina=cont-principal.php','','');mypop.focus();";break;
		case "meci":	$pagina="mypop=window.open('../spid.php?pagina=meci-principal.php','','');mypop.focus();";break;
		case "teso":	$pagina="mypop=window.open('../spid.php?pagina=teso-principal.php','','');mypop.focus();";break;
		case "hum":		$pagina="mypop=window.open('../spid.php?pagina=hum-principal.php','','');mypop.focus();";break;
		case "plan":	$pagina="mypop=window.open('../spid.php?pagina=plan-principal.php','','');mypop.focus();";break;
		case "inve":	$pagina="mypop=window.open('../spid.php?pagina=inve-principal.php','','');mypop.focus();";break;
		case "adm":		$pagina="mypop=window.open('../spid.php?pagina=adm-principal.php','','');mypop.focus();";break;
		case "presu":	$pagina="mypop=window.open('../spid.php?pagina=presu-principal.php','','');mypop.focus();";break;
		case "contra":	$pagina="mypop=window.open('../spid.php?pagina=contra-principal.php','','');mypop.focus();";break;
		case "serv":	$pagina="mypop=window.open('../spid.php?pagina=serv-principal.php','','');mypop.focus();";break;
		case "ccpet":	$pagina="mypop=window.open('../spid.php?pagina=ccp-principal.php','','');mypop.focus();";break;
	}
	return $pagina;
}
function busca_recaudos($recibo,$tipo)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
 $liquidacion=array();
 switch ($tipo)
	{
		case 16:
	 	$sqlrw="select id_recaudo,tipo from tesoreciboscaja where id_recibos=$recibo";
		$resw=mysql_query($sqlrw,$conexion);
		 //echo "<br>".$sqlr;
		 while($roww=mysql_fetch_row($resw))
		 {

		   $liquidacion[0]=$roww[0];
		   if($roww[1]==1)
		   $tipo='Predial';
		   if($roww[1]==2)
		   $tipo='Industria y Comercio';
		   if($roww[1]==3)
		   $tipo='Otros Recaudos';
   		   $liquidacion[1]=$tipo;
		 }
		break;
		case 17:
		$sqlrw="select id_orden from tesoordenpago_retenciones where id_orden=$recibo";
		$resw=mysql_query($sqlrw,$conexion);
		 while($roww=mysql_fetch_row($resw))
		 {
		   $liquidacion[0]=$roww[0];
   		   $liquidacion[1]=$roww[1];
		 }
		break;
		case 18:
		$sqlrw="select id_recaudo,tipo from tesosinreciboscaja where id_recibos=$recibo";
		$resw=mysql_query($sqlrw,$conexion);
		 while($roww=mysql_fetch_row($resw))
		 {
		   $liquidacion[0]=$roww[0];
   		   $liquidacion[1]=$roww[1];
		 }
		break;
		case 19:
	 	$sqlrw="select idcomp from tesorecaudotransferencia where id_recaudo=$recibo";
		$resw=mysql_query($sqlrw,$conexion);
		 while($roww=mysql_fetch_row($resw))
		 {
		   $liquidacion[0]=$roww[0];
   		   $liquidacion[1]=$roww[1];
		 }
		break;
		case 21:
	 	$sqlrw="select id_recaudo from  tesossfingreso_cab where id_recaudo=$recibo";
		$resw=mysql_query($sqlrw,$conexion);
		 while($roww=mysql_fetch_row($resw))
		 {
		   $liquidacion[0]=$roww[0];
   		   $liquidacion[1]=$roww[1];
		 }
		break;
		case 22:
		   $liquidacion[0]="";
   		   $liquidacion[1]="";
		break;
	}

 return $liquidacion;
}
function convertirdecimal($numero,$div)
{
	$numeros = explode($div, $numero);
	$pesos=convertir((int)$numeros[0]);
	$centa=convertir((int)$numeros[1]);
	if($numeros[1]!=0 && $numeros[1]!="00"){$total="$pesos PESOS CON $centa CENTAVOS M/CTE";}
	else{$total="$pesos PESOS M/CTE";}
	return $total;
}
function verificavigencia()
{
	if (vigencia_usuarios($_SESSION[cedulausu])=="")
	{echo"<script>despliegamodalm('visible','2','No tiene activo un a�o para la vigencia, favor agregarlo');</script>";}
}
function delnominaxx($idnom)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr ="DELETE FROM humnomina WHERE id_nom='$idnom'";//1
	mysql_query($sqlr,$conexion);
	$sqlr ="DELETE FROM hum_nom_cdp_rp WHERE nomina='$idnom'";//2
	mysql_query($sqlr,$conexion);
	$sqlr ="DELETE FROM humcomprobante_cab WHERE numerotipo='$idnom'";//3
	mysql_query($sqlr,$conexion);
	$sqlr ="DELETE FROM humnomina_det WHERE id_nom='$idnom'";//4
	mysql_query($sqlr,$conexion);
	$sqlr ="DELETE FROM humcomprobante_det WHERE numerotipo='$idnom'";//5
	mysql_query($sqlr,$conexion);
	$sqlr ="DELETE FROM humnomina_saludpension WHERE id_nom='$idnom'";//6
	mysql_query($sqlr,$conexion);
	$sqlr ="DELETE FROM humnominaretenemp WHERE id_nom='$idnom'";//7
	mysql_query($sqlr,$conexion);
	$sqlr ="DELETE FROM humnomina_parafiscales WHERE id_nom='$idnom'";//7
	mysql_query($sqlr,$conexion);
	$sqlr ="DELETE FROM humnom_presupuestal WHERE id_nom='$idnom'";//8
	mysql_query($sqlr,$conexion);

	//$sqlr="UPDATE humretenempleados SET SNCUOTAS=SNCUOTAS-1 where estado='S' and empleado='".$_POST[ccemp][$x]."' and sncuotas>0";
	//$sqlr="UPDATE humretenempleados SET estado='P' where estado='S' and empleado='".$_POST[ccemp][$x]."'  and sncuotas<=0";

}
 function intercalar_caracteres( $cadena1, $cadena2, $posicion )
{
	$cadena2 = str_split( $cadena2 );
	$nueva = '';
	$l=1; $k=0;
	for( $n=0; $n < strlen( $cadena1 ); $n++ )
	{
    	if( $l % $posicion == 0 )
		{
        	$l=0;
        	$letra = $cadena2[ $k ];
       	 	$k++;
    	}
    	$l++;
    	$nueva .=  $cadena1[ $n ] . $letra ;
    	$letra = '';
	}
	return $nueva;
}
function quitarcomas($quitarcom)
{
	return str_replace(',','',$quitarcom);



}
function cambiar_fecha($fecha){
	$fecha=str_replace('/','-',$fecha);
	$arrfec=explode('-',$fecha);
	$nfecha=$arrfec[2].'-'.$arrfec[1].'-'.$arrfec[0];
	return $nfecha;
}
function buscaporcentajeparafiscal($codigo, $tipo)
{
	$linkbd=conectar_v7();
	$sqlr="SELECT porcentaje FROM humparafiscales WHERE tipo='$tipo' AND estado='S' AND codigo='$codigo'";
	$resp = mysqli_query($linkbd,$sqlr);
	$row =mysqli_fetch_row($resp);
	return $row[0];
}
function buscaconcontalbles($codigo,$concepto,$vigencia)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="SELECT COUNT( * ) AS concepto FROM tesoingresos_det WHERE codigo='$codigo' AND vigencia='$vigencia' AND concepto='$concepto'";
    $resp = mysql_query($sqlr,$conexion);
   	$row =mysql_fetch_row($resp);
	return $row[0];
}
function estadotipoprenimina($prenomina,$codigo)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="SELECT estado_tipo FROM hum_prenomina_tipos WHERE num_nomi='$prenomina' AND tipo_prenom='$codigo'";
	$resp = mysql_query($sqlr,$conexion);
	$row =mysql_fetch_row($resp);
	return $row[0];
}
function array_null($valor) {return !empty($valor);}

function array_zero($valor) {if($valor!=0){return $valor;}}
function buscadatofuncionario($tercero,$item)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3]))) die("no se puede conectar");
	if(!mysql_select_db($datin[0])) die("no se puede seleccionar bd");
	$sqlr="
	SELECT GROUP_CONCAT(T1.descripcion ORDER BY CONVERT(T1.codrad, SIGNED INTEGER) SEPARATOR '<->')
	FROM hum_funcionarios T1
	WHERE (T1.item = '$item') AND T1.estado='S' AND (SELECT T2.codfun FROM hum_funcionarios T2 WHERE T2.descripcion  LIKE  '$tercero' AND T2.estado='S' AND T2.codfun=T1.codfun AND T2.item='DOCTERCERO')
	GROUP BY T1.codfun
	ORDER BY CONVERT(T1.codfun, SIGNED INTEGER)";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
	return $valor;
}
function buscasectoremp($empresa,$tipo)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="SELECT tipoemprse FROM hum_terceros_emprse WHERE numdocumento='$empresa' AND estado='S'";
	$res=mysql_query($sqlr,$conexion);
	$r=mysql_fetch_row($res);
	if($tipo=='1'){$valor=$r[0];}
	else
	{
		if($r[0]=='PB'){$valor="publico";}
		elseif($r[0]=='PR'){$valor="privado";}
		else {$valor="error";}
	}
	return $valor;
}
//conceptos contables en general Nuevo con fecha
function concepto_cuentasn($concepto,$tipo,$modulo,$centrocosto,$fecha)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))die("no se puede conectar");
	if(!mysql_select_db($datin[0]))die("no se puede seleccionar bd");
	$sqlr="SELECT DISTINCT cuenta,tipocuenta,debito,credito FROM conceptoscontables_det T2 WHERE tipo='$tipo' AND codigo='$concepto' AND modulo=$modulo AND cc='$centrocosto' AND debito='S' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE fechainicial <= '$fecha' AND modulo='$modulo' AND tipo='$tipo' AND CC='$centrocosto' AND codigo='$concepto' AND debito='S')";

	$res=mysql_query($sqlr,$conexion);
	$valor[]=array();
	$con=0;
	while($r=mysql_fetch_row($res))
	{
		$valor[$con][0]=$r[0]; //cuenta
		$valor[$con][1]=$r[1]; //tipo cuenta
		$valor[$con][2]=$r[2]; //debito
		$valor[$con][3]=$r[3]; //credito
		$con+=1;
	}
	$sqlr="SELECT DISTINCT cuenta,tipocuenta,debito,credito FROM conceptoscontables_det T2 WHERE tipo='$tipo' AND codigo='$concepto' AND modulo=$modulo AND cc='$centrocosto' AND credito='S' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE fechainicial <= '$fecha' AND modulo='$modulo' AND tipo='$tipo' AND CC='$centrocosto' AND codigo='$concepto' AND credito='S')";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res))
	{
		$valor[$con][0]=$r[0]; //cuenta
		$valor[$con][1]=$r[1]; //tipo cuenta
		$valor[$con][2]=$r[2]; //debito
		$valor[$con][3]=$r[3]; //credito
		$con+=1;
	}
	return $valor;
}
function buscavariablepagon($codigo,$cc,$vigencia)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))die("no se puede conectar");
	if(!mysql_select_db($datin[0]))die("no se puede seleccionar bd");
	$co=0;
	$sqlr="SELECT cuentapres FROM  humvariables_det WHERE codigo='$codigo' AND cc='$cc' AND vigencia='$vigencia' AND estado='S'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
	return $valor;
}
function totalinventario($codpro,$bodega='',$cc='')
{
	global $linkbd;
	if($bodega!=""){$crit2="AND T2.bodega='$bodega' ";}
	else{$crit2="";}
	if($cc!=""){$crit1="AND T2.cc='$cc' ";}
	else{$crit1="";}
	//ENTRADAS
	$sumentradas=$sumsalidas=$sumreserva=0;
	$sqls="SELECT T2.cantidad_entrada,T2.unidad FROM almginventario T1 INNER JOIN almginventario_det T2 ON CONCAT(T1.consec,T1.tipomov) = CONCAT(T2.codigo,T2.tipomov) WHERE T1.estado='S' and T2.codart='$codpro' AND T1.tipomov='1' $crit1 $crit2";
	$res=mysql_query($sqls,$linkbd);
	while ($row =mysql_fetch_row($res))
    {
	    $factor=almconsulta_factorarticulo($codpro,$row[1]);
		$canti=$row[0]/$factor;
		$sumentradas+=$canti;
	}
	//SALIDAS
	$sqls="SELECT T2.cantidad_salida,T2.unidad FROM almginventario T1 INNER JOIN almginventario_det T2 ON CONCAT(T1.consec,T1.tipomov) = CONCAT(T2.codigo,T2.tipomov) WHERE T1.estado='S' and T2.codart='$codpro' AND T2.tipomov='2' $crit1 $crit2";
	$res=mysql_query($sqls,$linkbd);
	while ($row =mysql_fetch_row($res))
    {
	    $factor=almconsulta_factorarticulo($codpro,$row[1]);
		$canti=$row[0]/$factor;
		$sumsalidas+=$canti;
	}
	//RESERVAS
	$sqls="SELECT T1.cantidad,T1.unidad FROM almreservas_det T1 INNER JOIN almreservas T2 ON T1.codreserva=T2.codigo WHERE T2.estado='S' AND T1.articulo='$codpro' $crit1";
	$res=mysql_query($sqls,$linkbd);
	while($row=mysql_fetch_row($res))
	{
		 $factor=almconsulta_factorarticulo($codpro,$row[1]);
		 $canti=$row[0]/$factor;
		 $sumreserva+=$canti;
	}
	$total=$sumentradas-$sumsalidas;
	return $total;
}
function totalinventarioConRutina($articulo,$bodega='%',$cc='%')
{
	global $linkbd;
	$sqlr = "select fx_alm_cantbodegadisponible('$articulo','$bodega','$cc')";
	$result=mysql_query($sqlr, $linkbd);			
	$row=mysql_fetch_array($result);
	return $row[0];
}
function totalinventario1($codpro,$bodega='',$cc='')
{
	global $linkbd;
	if($bodega!=""){$crit2="AND T2.bodega='$bodega' ";}
	else{$crit2="";}
	if($cc!=""){$crit1="AND T2.cc='$cc' ";}
	else{$crit1="";}
	//ENTRADAS
	$sumentradas=$sumsalidas=$sumreserva=0;
	$sqls="SELECT T2.cantidad_entrada,T2.unidad FROM almginventario T1 INNER JOIN almginventario_det T2 ON CONCAT(T1.consec,T1.tipomov,T1.tiporeg) = CONCAT(T2.codigo,T2.tipomov,T2.tiporeg) WHERE T1.estado='S' and T2.codart='$codpro' AND T1.tipomov='1' $crit1 $crit2";
	$res=mysql_query($sqls,$linkbd);
	while ($row =mysql_fetch_row($res))
    {
	    $factor=almconsulta_factorarticulo($codpro,$row[1]);
		$canti=$row[0]/$factor;
		$sumentradas+=$canti;
	}
	//SALIDAS
	$sqls="SELECT T2.cantidad_salida,T2.unidad FROM almginventario T1 INNER JOIN almginventario_det T2 ON CONCAT(T1.consec,T1.tipomov) = CONCAT(T2.codigo,T2.tipomov) WHERE T1.estado='S' and T2.codart='$codpro' AND T2.tipomov='2' $crit1 $crit2";
	$res=mysql_query($sqls,$linkbd);

	while ($row =mysql_fetch_row($res))
    {
	    $factor=almconsulta_factorarticulo($codpro,$row[1]);
		$canti=$row[0]/$factor;
		$sumsalidas+=$canti;
	}
	//RESERVAS
	$sqls="SELECT T1.cantidad,T1.unidad FROM almreservas_det T1 INNER JOIN almreservas T2 ON T1.codreserva=T2.codigo WHERE T2.estado='S' AND T1.articulo='$codpro' ";
	$res=mysql_query($sqls,$linkbd);

	while($row=mysql_fetch_row($res))
	{
		 $factor=almconsulta_factorarticulo($codpro,$row[1]);
		 $canti=$row[0]/$factor;
		 $sumreserva+=$canti;
	}
	$total=$sumentradas-$sumsalidas-$sumreserva;
	return $total;
}
function totalinventario2($codpro)
{
	global $linkbd;
	$sqlkar="SELECT DISTINCT T2.cantarticulo,T2.valcredito,T1.tipomov,T1.tiporeg,T4.fecha,T1.codigo,T1.unidad,T1.valorunit FROM almginventario T4,almginventario_det T1 INNER JOIN comprobante_det T2 ON T1.codigo=T2.numerotipo AND T1.codart=T2.numacti INNER JOIN almtipomov T3 ON T3.tipo_comp=T2.tipo_comp AND CONCAT(T1.tipomov,T1.tiporeg)=CONCAT(T3.tipom,T3.codigo) WHERE T1.codart='$codpro' AND T2.valcredito<>0 AND CONCAT(T1.tipomov,T1.tiporeg,T1.codigo)=CONCAT(T4.tipomov,T4.tiporeg,T4.consec) ORDER BY T4.fecha,T1.codigo";
	$res=mysql_query($sqlkar,$linkbd);
	while ($row =mysql_fetch_row($res))
    {
	    $factor=almconsulta_factorarticulo($codpro,$row[6]);
		$canti=$row[0]/$factor;
		if($row[2]==1)
			$sumentradas+=$canti;
		elseif($row[2]==2)
			$sumentradas-=$canti;
	}
	return $sumentradas;
}

//funcion para inventario a determinada fecha
function totalinventariofecha($codpro,$fecha)
{
	$linkbd=conectar_v7();
	$sqlkar="SELECT DISTINCT T2.cantarticulo,T2.valcredito,T1.tipomov,T1.tiporeg,T4.fecha,T1.codigo,T1.unidad,T1.valorunit FROM almginventario T4,almginventario_det T1 INNER JOIN comprobante_det T2 ON T1.codigo=T2.numerotipo AND T1.codart=T2.numacti INNER JOIN almtipomov T3 ON T3.tipo_comp=T2.tipo_comp AND CONCAT(T1.tipomov,T1.tiporeg)=CONCAT(T3.tipom,T3.codigo) WHERE T1.codart='$codpro' AND T4.fecha<'$fecha' AND T2.valcredito<>0 AND CONCAT(T1.tipomov,T1.tiporeg,T1.codigo)=CONCAT(T4.tipomov,T4.tiporeg,T4.consec) ORDER BY T4.fecha,T1.codigo";
	$res=mysqli_query($linkbd,$sqlkar);
	while ($row =mysqli_fetch_row($res))
    {
	    $factor=almconsulta_factorarticulo($codpro,$row[6]);
		$canti=$row[0]/$factor;
		if($row[2]==1){$sumentradas+=$canti;}
		elseif($row[2]==2){$sumentradas-=$canti;}
	}
	return $sumentradas;
}
//***** FUNCIONES BY GECO


function consultar_origen()
{
	$linkbd=conectar_v7();
	$sqlr="SELECT * from actiorigenes where estado='S'";
	$resp = mysqli_query($linkbd,$sqlr);
    while ($row =mysqli_fetch_row($resp))
    {
	    $vector_origen[$row[0]] = $row[1];
	}
	return $vector_origen;
}
function almconculta_um_principal($articulo)
{
	$linkbd=conectar_v7();
	$sqlr="SELECT unidad FROM almarticulos_det WHERE articulo='$articulo' AND principal='1'";
	$resp = mysqli_query($linkbd,$sqlr);
	$row =mysqli_fetch_row($resp);
	return $row[0];
}
function almconsulta_factorarticulo($articulo,$unidad)
{
	$linkbd=conectar_v7();
	$sqlr="SELECT factor FROM almarticulos_det WHERE articulo='$articulo' AND unidad='$unidad'";
	$resp = mysqli_query($linkbd,$sqlr);
	$row =mysqli_fetch_row($resp);
	return $row[0];
}
function parse_number($number, $dec_point=null) {
    if (empty($dec_point)) {
        $locale = localeconv();
        $dec_point = $locale['decimal_point'];
    }
    return floatval(str_replace($dec_point, '.', preg_replace('/[^\d'.preg_quote($dec_point).']/', '', $number)));
}
function generaLogs($usuario,$modulo,$tipo,$accion,$origen)
{
    $hora=str_pad(date("H:i:s"),10," ");
    $usuario=strtoupper(str_pad($usuario,15," "));
    $accion=strtoupper(str_pad($accion,50," "));
    $cadena="$hora<->$modulo<->$tipo<->$usuario<->$accion<->$origen";
    $pre="log";
	$directory = "logs";
    $date=date("ymd");
    $fileName=str_replace (' ','',"$pre$usuario$date");
	if(!file_exists($directory)) mkdir($directory, 0700);

    $f = fopen("$directory/$fileName.TXT","a");
    fputs($f,$cadena."\r\n") or die("no se pudo crear o insertar el fichero");
    fclose($f);
}
function getUserIpAddr()
{
    if(!empty($_SERVER['HTTP_CLIENT_IP']))//IP de un servicio compartido
	{$ip = $_SERVER['HTTP_CLIENT_IP']; }
	elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))//IP pass from proxy
	{ $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];}
	else {$ip = $_SERVER['REMOTE_ADDR']; }
    return $ip;
}
function buscasipagaparafiscales($codigo,$tipo)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="SELECT $tipo FROM humvariables WHERE codigo='$codigo'";
	$res=mysql_query($sqlr,$conexion);
	$r=mysql_fetch_row($res);
	return $r[0];
}
function obtenerNombreZona($codigo,$tipo){
			global $linkbd;
			$sql="SELECT nombre,nom_rango FROM teso_clasificapredios WHERE codigo=$codigo LIMIT 0,1";
			$res=mysql_query($sql,$linkbd);
			$row = mysql_fetch_row($res);
			if($tipo==0){
				return $row[0];
			}else{
				return $row[1];
			}
	}
function nombrefuncionario($codigo)
	{
		global $linkbd;
		$sql="SELECT descripcion FROM hum_funcionarios WHERE codfun='$codigo' AND item='NOMTERCERO' AND estado='S'";
		$res=mysql_query($sql,$linkbd);
		$row = mysql_fetch_row($res);
		return $row[0];
	}
	function ccfuncionario($codigo,$tipo)
	{
		global $linkbd;
		switch ($tipo)
		{
			case 1:	$sql="SELECT descripcion FROM hum_funcionarios WHERE codfun='$codigo' AND item='NUMCC' AND estado='S'";
					$res=mysql_query($sql,$linkbd);
					$row = mysql_fetch_row($res);
					$ccfun = $row[0];break;
			case 2:	$sql="SELECT GROUP_CONCAT(T1.descripcion ORDER BY CONVERT(T1.codrad, SIGNED INTEGER) SEPARATOR '<->') FROM hum_funcionarios T1 WHERE (T1.item = 'NUMCC') AND T1.estado='S' AND (SELECT T2.codfun FROM hum_funcionarios T2 WHERE T2.descripcion='$codigo' AND T2.estado='S' AND T2.codfun=T1.codfun AND T2.item='DOCTERCERO') GROUP BY T1.codfun ORDER BY CONVERT(T1.codfun, SIGNED INTEGER)";
					$res=mysql_query($sql,$linkbd);
					$row = mysql_fetch_row($res);
					$ccfun = $row[0];
		}
		return $ccfun;
	}
	function ccdescuentoconid($codigo)
	{
		global $linkbd;
		$sql="SELECT empleado FROM humretenempleados WHERE id='$codigo'";
		$res=mysql_query($sql,$linkbd);
		$row = mysql_fetch_row($res);
		return ccfuncionario($row[0],'2');
	}
	function buscavariblespagonomina($codigo)
	{
		$linkbd=conectar_v7();
		$sql="SELECT nombre FROM humvariables WHERE codigo='$codigo'";
		$res=mysqli_query($linkbd,$sql);
		$row = mysqli_fetch_row($res);
		return $row[0];
	}
	function cargofuncionario($codigo)
	{
		$linkbd=conectar_v7();
		$sql="SELECT GROUP_CONCAT(T1.descripcion ORDER BY CONVERT(T1.codrad, SIGNED INTEGER) SEPARATOR '<->') FROM hum_funcionarios T1 WHERE (T1.item = 'NOMCARGO') AND T1.estado='S' AND (SELECT T2.codfun FROM hum_funcionarios T2 WHERE T2.codfun='$codigo' AND T2.estado='S' AND T2.codfun=T1.codfun AND T2.item='NOMCARGO') GROUP BY T1.codfun ORDER BY CONVERT(T1.codfun, SIGNED INTEGER)";
		$res=mysqli_query($linkbd,$sql);
		$row = mysqli_fetch_row($res);
		return iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$row[0]);
	}
	function cargofuncionarioid($codigo)
	{
		global $linkbd;
		$sql="SELECT nombrecargo FROM planaccargos WHERE codcargo='$codigo' ";
		$res=mysql_query($sql,$linkbd);
		$row = mysql_fetch_row($res);
		return iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$row[0]);
	}
	function nombrecentrocosto($codigo)
	{
		global $linkbd;
		$sql="SELECT nombre FROM centrocosto WHERE id_cc='$codigo'";
		$res=mysql_query($sql,$linkbd);
		$row = mysql_fetch_row($res);
		return iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$row[0]);
	}
	function calculavalordevengado($codigo)
	{
		global $linkbd;
		$sql="SELECT valordevengado FROM tesoegresosnomina_det WHERE id_egreso='$codigo' and (tipo='01' or tipo='N')";
		$res=mysql_query($sql,$linkbd);
		$row = mysql_fetch_row($res);
		if($row[0] < 1687297)
			$row[0]=$row[0]+60170;
		return $row[0];
	}

	function buscaTipoDeRetencion($retencion)
	{
		$sqlrTipoDeRrte = "SELECT tipo FROM tesoretenciones WHERE id='$retencion'";
		$rowTipoDeRete = view($sqlrTipoDeRrte);
		return $rowTipoDeRete[0]["tipo"];
	}

	function buscarCXPEnEgreso($cxp, $fechai, $fechaf)
	{
		global $linkbd;
		$sqlrBuscaEgreso = "SELECT * FROM tesoegresos WHERE id_orden='$cxp' AND fecha BETWEEN '$fechai' AND '$fechaf' AND estado='S'";
		$rowBuscaEgreso = view($sqlrBuscaEgreso);
		if($rowBuscaEgreso == NULL)
		{
			return 0;
		}
		else
		{
			return 1;
		}
	}

	function buscarCodigoCatastralAbono($acuerdo)
	{
		$sqlrCodCatastral = "SELECT codcatastral FROM tesoacuerdopredial WHERE idacuerdo=$acuerdo";
		$rowCodCatastrak = view($sqlrCodCatastral);
		return $rowCodCatastrak[0]["codcatastral"];
	}

	function buscaClasificacion($rubro, $vigencia)
	{
		$sqlrClasificacion = "SELECT clasificacion FROM pptocuentas WHERE cuenta='$rubro' AND vigencia='$vigencia'";
		$rowClasificacion = view($sqlrClasificacion);
		return $rowClasificacion[0]["clasificacion"];
	}
	function buscarfirmaspdf($tipo,$fecha,$tercero,$documento)
	{
		$x=0;
		$linkbd=conectar_v7();
		$sqlr="SELECT funcionario,nomcargo FROM firmaspdf_det WHERE idfirmas='$tipo,' AND estado ='S' AND fecha < '$fecha' ORDER BY orden";
		$res=mysqli_query($linkbd,$sqlr);
		while($row=mysqli_fetch_row($res))
		{
			if ($row[0]=='BENEFICIARIO')
			{
				
				$firmas[0][]=strtoupper($tercero).' CC/NIT '.$documento;
				$firmas[1][]=$row[1];
			}
			else
			{
				$firmas[0][]=$row[0];
				$firmas[1][]=$row[1];
			}
		}
		return $firmas;
	}
	class zipplan
	{
		public static function zipcrear($ruta,$nombre,$archivos,$tipo)
		{
			$rutadestino="informacion/documentosradicados/$tipo/$nombre";
			$rutadestinozip="informacion/documentosradicados/$tipo/$nombre.zip";
			mkdir($rutadestino, 0777);
			$yconta=count($archivos);
			for($y=0;$y<$yconta;$y++)
			{
				$nomarch=$ruta.$archivos[$y];
				$nuevoarch=$rutadestino.'/'.$archivos[$y];
				copy($nomarch, $nuevoarch);
			}
			$zip = new ZipArchive();
			$zip->open($rutadestinozip, ZipArchive::CREATE);
			for($y=0;$y<$yconta;$y++)
			{
				$nuevoarch=$rutadestino.'/'.$archivos[$y];
				$zip->addFile($nuevoarch);
			}
			$zip->close();
		}
		public static function zipcrear2($ruta,$nombre,$archivos,$tipo)
		{
			$rutadestino="informacion/documentosradicados/responsables/$tipo/$nombre";
			$rutadestinozip="informacion/documentosradicados/responsables/$tipo/$nombre.zip";
			mkdir($rutadestino, 0777);
			$yconta=count($archivos);
			for($y=0;$y<$yconta;$y++)
			{
				$nomarch=$ruta.$archivos[$y];
				$nuevoarch=$rutadestino.'/'.$archivos[$y];
				copy($nomarch, $nuevoarch);
			}
			$zip = new ZipArchive();
			$zip->open($rutadestinozip, ZipArchive::CREATE);
			for($y=0;$y<$yconta;$y++)
			{
				$nuevoarch=$rutadestino.'/'.$archivos[$y];
				$zip->addFile($nuevoarch);
			}
			$zip->close();
		}
		public static function zipdesc($nombre,$tipo)
		{
			$nomarchivo="C:/xampp/htdocs/financiero";
			$zip = new ZipArchive();
			$zip->open('', ZipArchive::CREATE);
			$zip->extractTo($_SERVER['DOCUMENT_ROOT']);
			$zip->close();
		}
	}
?>
