<?php
//**validacion signos cuentas ccontables chip
function cuenta_colocar_signo($cuenta)
{
 	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	 die("no se puede conectar");
	 if(!mysql_select_db($datin[0]))
	 die("no se puede seleccionar bd");
	 $sqlr="Select naturaleza from cuentasnicsp where cuenta='$cuenta'";
	 $res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res))
	{
		$inicial=substr($cuenta,0,1);	
		$nat=$r[0];
	 	//**** reglas de validaciones
	 	//cuentas 1 8 9
	 	if($inicial=='1' || $inicial=='5' || $inicial=='6' || $inicial=='7')	 
	 	{		
		 	if(0==strcmp($nat,"DEBITO")){$signo=1;}
	 		if(0==strcmp($nat,"CREDITO")){$signo=-1;}
	 	}
	 	//cuentas 2 3 4	 
	 	if($inicial=='2' || $inicial=='3' || $inicial=='4')	 
	 	{
	 	 	if(0==strcmp($nat,"DEBITO")){$signo=-1;}
	  		if(0==strcmp($nat,"CREDITO")){$signo=1;}
	 	}	 
	 	//cuentas  5 6 7
	 	if($inicial=='8' || $inicial=='9')	 
	 	{
	 	 	if(0==strcmp($nat,"DEBITO")){$signo=1;}
	  		if(0==strcmp($nat,"CREDITO")){$signo=-1;}
	 	}
	}
	return $signo;
}
function saldoTabla($numCuenta,$vigenciai,$vigenciaf){
	
$datin=datosiniciales();
	if(!($linkbd=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar func");
 	if(!mysql_select_db($datin[0]))
 	die("no se puede seleccionar bd");

 	$queryPresupuesto="SELECT saldos FROM pptocuentaspptoinicial WHERE cuenta='$numCuenta' AND (vigencia=$vigenciai OR vigenciaf=$vigenciaf)";

 	$result=mysql_query($queryPresupuesto,$linkbd);
 	$row = mysql_fetch_array($result);
 	return $row[0];

}
function generaSaldoCDPxcuenta($id_compro,$cuenta,$vigencia){
	$fechaf=$vigencia."-01-01";
 	$fechaf2=$vigencia."-12-31";
 	$datin=datosiniciales();
	if(!($linkbd=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar func");
 	if(!mysql_select_db($datin[0]))
 	die("no se puede seleccionar bd");

 	$query1="SELECT C.consvigencia,SUM(D.valor),(SELECT SUM(RD.valor) FROM pptorp R,pptorp_detalle RD where R.idcdp=$id_compro AND R.vigencia=$vigencia AND R.tipo_mov='201'  AND RD.consvigencia=R.consvigencia AND RD.tipo_mov='201' AND RD.cuenta='$cuenta' AND RD.vigencia=$vigencia AND R.fecha BETWEEN '$fechaf' AND '$fechaf2') FROM pptocdp C, pptocdp_detalle D WHERE C.consvigencia=$id_compro AND D.vigencia=$vigencia AND D.tipo_mov='201' AND D.consvigencia=C.consvigencia AND C.tipo_mov='201' AND C.vigencia=$vigencia AND NOT(D.estado='N') AND D.valor>0 AND D.cuenta='$cuenta' AND C.fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY C.consvigencia";
	$result=mysql_query($query1, $linkbd);			
	$row=mysql_fetch_array($result);

	$entact=$row[1];
	$entsig=$row[2];
 	$query2="SELECT SUM(RD.valor) FROM pptorp R,pptorp_detalle RD where R.idcdp=$id_compro AND R.vigencia=$vigencia AND (R.tipo_mov='401' OR R.tipo_mov='402')  AND RD.consvigencia=R.consvigencia AND (RD.tipo_mov='401' OR RD.tipo_mov='402') AND RD.vigencia=$vigencia AND RD.cuenta='$cuenta' AND R.fecha BETWEEN '$fechaf' AND '$fechaf2'";
	$result=mysql_query($query2,$linkbd);
	$valorReversado=mysql_fetch_array($result);

	$querySaldo="SELECT SUM(D.valor) FROM pptocdp C, pptocdp_detalle D WHERE C.consvigencia=$id_compro AND D.vigencia=$vigencia AND ( D.tipo_mov='401' OR D.tipo_mov='402') AND D.consvigencia=C.consvigencia AND (C.tipo_mov='401' OR C.tipo_mov='402') AND C.vigencia=$vigencia AND NOT(D.estado='N') AND D.cuenta='$cuenta' AND D.valor>0 AND C.fecha BETWEEN '$fechaf' AND '$fechaf2'";
	$result=mysql_query($querySaldo,$linkbd);
	$valorReversadoAct=mysql_fetch_array($result);

	$saldo=$entact-$entsig+$valorReversado[0]-$valorReversadoAct[0];
	return $saldo;
}

function generaSaldoCDP($id_compro,$vigencia){
	$fechaf=$vigencia."-01-01";
 	$fechaf2=$vigencia."-12-31";
	$datin=datosiniciales();
	if(!($linkbd=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar func");
 	if(!mysql_select_db($datin[0]))
 	die("no se puede seleccionar bd");


 	$query1="SELECT C.consvigencia,SUM(D.valor),(SELECT SUM(RD.valor) FROM pptorp R,pptorp_detalle RD where R.idcdp=$id_compro AND R.vigencia=$vigencia AND R.tipo_mov='201'  AND RD.consvigencia=R.consvigencia AND RD.tipo_mov='201' AND RD.vigencia=$vigencia AND R.fecha BETWEEN '$fechaf' AND '$fechaf2') FROM pptocdp C, pptocdp_detalle D WHERE C.consvigencia=$id_compro AND D.vigencia=$vigencia AND D.tipo_mov='201' AND D.consvigencia=C.consvigencia AND C.tipo_mov='201' AND C.vigencia=$vigencia AND NOT(D.estado='N') AND D.valor>0 AND C.fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY C.consvigencia";
	$result=mysql_query($query1, $linkbd);			
	$row=mysql_fetch_array($result);
	$entact=$row[1];
	$entsig=$row[2];
 	$query2="SELECT SUM(RD.valor) FROM pptorp R,pptorp_detalle RD where R.idcdp=$id_compro AND R.vigencia=$vigencia AND (R.tipo_mov='401' OR R.tipo_mov='402')  AND RD.consvigencia=R.consvigencia AND (RD.tipo_mov='401' OR RD.tipo_mov='402') AND RD.vigencia=$vigencia AND R.fecha BETWEEN '$fechaf' AND '$fechaf2'";
	$result=mysql_query($query2,$linkbd);
	$valorReversado=mysql_fetch_array($result);

	$querySaldo="SELECT SUM(D.valor) FROM pptocdp C, pptocdp_detalle D WHERE C.consvigencia=$id_compro AND D.vigencia=$vigencia AND ( D.tipo_mov='401' OR D.tipo_mov='402') AND D.consvigencia=C.consvigencia AND (C.tipo_mov='401' OR C.tipo_mov='402') AND C.vigencia=$vigencia AND NOT(D.estado='N') AND D.valor>0 AND C.fecha BETWEEN '$fechaf' AND '$fechaf2'";
	$result=mysql_query($querySaldo,$linkbd);
	$valorReversadoAct=mysql_fetch_array($result);

	$saldo=$entact-$entsig+$valorReversado[0]-$valorReversadoAct[0];
	return $saldo;
}
function generaSaldoCDP1($id_compro,$vigencia,$fecha,$cuenta='%')
{
	global $linkbd;
	$sqlr = "select fx_ppt_saldodisponibilidad('$id_compro','$vigencia','$cuenta','$fecha')";
	$result=mysql_query($sqlr, $linkbd);			
	$row=mysql_fetch_array($result);
	return $row[0];
}
function generaSaldoRP($id_compro,$vigencia){
	$fechaf=$vigencia."-01-01";
 	$fechaf2=$vigencia."-12-31";
	$datin=datosiniciales();
	if(!($linkbd=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar func");
 	if(!mysql_select_db($datin[0]))
 	die("no se puede seleccionar bd");

 	
 	$query1="SELECT R.consvigencia,SUM(RD.valor),(SELECT SUM(TD.valor) FROM tesoordenpago T,tesoordenpago_det TD WHERE T.id_rp=R.consvigencia AND T.vigencia=$vigencia AND T.tipo_mov='201' AND T.id_orden=TD.id_orden AND TD.tipo_mov='201' AND T.fecha BETWEEN '$fechaf' AND '$fechaf2'),(SELECT SUM(HNP.valor) FROM hum_nom_cdp_rp HNR,humnom_presupuestal HNP WHERE HNR.rp=R.consvigencia AND HNR.nomina=HNP.id_nom AND HNR.vigencia=$vigencia AND NOT(HNR.estado='N' OR HNR.estado='R')) FROM pptorp R,pptorp_detalle RD where R.consvigencia=$id_compro AND R.vigencia=$vigencia AND R.tipo_mov='201' AND RD.consvigencia=R.consvigencia AND NOT(R.estado='N') AND RD.tipo_mov='201' AND RD.vigencia=$vigencia AND RD.valor>0 AND R.fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY R.consvigencia";
	
	$result=mysql_query($query1, $linkbd);			
	$row=mysql_fetch_array($result);

	$entact=$row[1];
	$entsig=$row[2];
	$entsig1=$row[3];

    $query2="SELECT SUM(TD.valor) FROM tesoordenpago T,tesoordenpago_det TD WHERE T.id_rp=$id_compro AND T.vigencia=$vigencia AND (T.tipo_mov='401' OR T.tipo_mov='402') AND T.id_orden=TD.id_orden AND (TD.tipo_mov='401' OR TD.tipo_mov='402') AND T.fecha BETWEEN '$fechaf' AND '$fechaf2' ";
	$result=mysql_query($query2,$linkbd);
	$valorReversado=mysql_fetch_array($result);


	$querySaldo="SELECT SUM(RD.valor) FROM pptorp R,pptorp_detalle RD where  R.consvigencia=$id_compro AND R.vigencia=$vigencia AND (R.tipo_mov='401' OR R.tipo_mov='402') AND RD.consvigencia=R.consvigencia AND (RD.tipo_mov='401' OR RD.tipo_mov='402') AND RD.vigencia=$vigencia  AND NOT(R.estado='N') AND RD.valor>0 AND R.fecha BETWEEN '$fechaf' AND '$fechaf2'";
	$result=mysql_query($querySaldo,$linkbd);
	$valorReversado3=mysql_fetch_array($result);

	$saldo=$entact-($entsig+$entsig1)+$valorReversado[0]-$valorReversado3[0];
	return round($saldo,2);
							
}

function generaSaldoRPxcuenta($id_compro,$cuenta,$vigencia){
	$fechaf=$vigencia."-01-01";
 	$fechaf2=$vigencia."-12-31";
	$datin=datosiniciales();
	if(!($linkbd=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar func");
 	if(!mysql_select_db($datin[0]))
 	die("no se puede seleccionar bd");

 	
 	$query1="SELECT R.consvigencia,SUM(RD.valor),(SELECT SUM(TD.valor) FROM tesoordenpago T,tesoordenpago_det TD WHERE T.id_rp=R.consvigencia AND T.vigencia=$vigencia AND T.tipo_mov='201' AND T.id_orden=TD.id_orden AND TD.tipo_mov='201' AND TD.cuentap='$cuenta' AND  T.fecha BETWEEN '$fechaf' AND '$fechaf2'),(SELECT SUM(HNP.valor) FROM hum_nom_cdp_rp HNR,humnom_presupuestal HNP WHERE HNR.rp=R.consvigencia AND HNR.nomina=HNP.id_nom AND HNR.vigencia=$vigencia  AND NOT(HNR.estado='N' OR HNR.estado='R')) FROM pptorp R,pptorp_detalle RD where R.consvigencia=$id_compro AND R.vigencia=$vigencia AND R.tipo_mov='201' AND RD.consvigencia=R.consvigencia AND NOT(R.estado='N') AND RD.cuenta='$cuenta' AND RD.tipo_mov='201' AND RD.vigencia=$vigencia AND RD.valor>0 AND R.fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY R.consvigencia";
 	//echo $query1."<BR>";
	$result=mysql_query($query1, $linkbd);			
	$row=mysql_fetch_array($result);

	$entact=$row[1];
	$entsig=$row[2];
	$entsig1=$row[3];

    $query2="SELECT SUM(TD.valor) FROM tesoordenpago T,tesoordenpago_det TD WHERE T.id_rp=$id_compro AND T.vigencia=$vigencia AND (T.tipo_mov='401' OR T.tipo_mov='402') AND T.id_orden=TD.id_orden AND (TD.tipo_mov='401' OR TD.tipo_mov='402') AND TD.cuentap='$cuenta' AND T.fecha BETWEEN '$fechaf' AND '$fechaf2' ";
	$result=mysql_query($query2,$linkbd);
	$valorReversado=mysql_fetch_array($result);


	$querySaldo="SELECT SUM(RD.valor) FROM pptorp R,pptorp_detalle RD where  R.consvigencia=$id_compro AND R.vigencia=$vigencia AND (R.tipo_mov='401' OR R.tipo_mov='402') AND RD.consvigencia=R.consvigencia AND (RD.tipo_mov='401' OR RD.tipo_mov='402') AND RD.vigencia=$vigencia  AND NOT(R.estado='N') AND RD.cuenta='$cuenta' AND RD.valor>0 AND R.fecha BETWEEN '$fechaf' AND '$fechaf2'";
	$result=mysql_query($querySaldo,$linkbd);
	$valorReversado3=mysql_fetch_array($result);

	$saldo=$entact-($entsig+$entsig1)+$valorReversado[0]-$valorReversado3[0];
	return $saldo;
							
}


function generaSaldoCXP($id_compro,$vigencia){
	$fechaf=$vigencia."-01-01";
 	$fechaf2=$vigencia."-12-31";
 	$saldo=0.0;
	$datin=datosiniciales();
	if(!($linkbd=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar func");
 	if(!mysql_select_db($datin[0]))
 	die("no se puede seleccionar bd");

 	$query1="SELECT T.id_orden,SUM(TD.valor),T.estado FROM tesoordenpago T,tesoordenpago_det TD WHERE T.id_orden=$id_compro AND T.vigencia=$vigencia AND T.tipo_mov='201' AND T.id_orden=TD.id_orden AND TD.tipo_mov='201' AND NOT(T.estado='N') AND TD.valor>0 AND T.fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY T.id_orden";
 	$result=mysql_query($query1, $linkbd);	
 	//echo $query1;		
	$row=mysql_fetch_array($result);
	$entact=$row[1];
	$entsig=0.0;
	if($row[2]=='P'){
		$entsig=$row[1];
	}

 	$query2="SELECT 1 FROM tesoegresos TE,tesoordenpago_det TD where TE.id_orden=$id_compro AND TE.vigencia=$vigencia AND (TE.tipo_mov='401' OR TE.tipo_mov='402')  AND TE.id_orden=TD.id_orden AND TE.fecha BETWEEN '$fechaf' AND '$fechaf2'";	$result=mysql_result($query2, $linkbd);
	$numRegistros=mysql_num_rows($result);

	$querySaldo="SELECT SUM(TD.valor) FROM tesoordenpago T,tesoordenpago_det TD WHERE T.id_orden=$id_compro AND T.vigencia=$vigencia AND T.tipo_mov='401' AND TD.id_orden=T.id_orden AND TD.tipo_mov='401' AND NOT(T.estado='N') AND TD.valor>0 AND T.fecha BETWEEN '$fechaf' AND '$fechaf2'";
	$result=mysql_result($querySaldo, $linkbd);
	$valorReversado=mysql_fetch_array($result);

	if($numRegistros>0){
		$saldo=$entact-$entsig+$entsig-$valorReversado[0];
	}else{
		$saldo=$entact-$entsig-$valorReversado[0];
	}

	$queryTraslados="SELECT SUM(HNP.valor) FROM hum_nom_cdp_rp HNR,humnom_presupuestal HNP,tesoegresosnomina TEN WHERE TEN.id_orden=$id_compro AND HNR.nomina=HNP.id_nom AND HNR.vigencia=$vigencia  AND NOT(HNR.estado='N' OR TEN.estado='R') AND TEN.id_orden=HNP.id_nom AND TEN.vigencia=$vigencia AND NOT(TEN.estado='N' OR TEN.estado='R') AND HNP.valor>0 AND TEN.fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY TEN.id_orden";
	$result=mysql_result($queryTraslados, $linkbd);
	$valorReversado2=mysql_fetch_array($result);

	$querySaldo="SELECT 1 FROM tesoegresosnomina TE WHERE TE.id_orden=$id_compro AND TE.estado='R' AND TE.vigencia=$vigencia";
	$result=mysql_result($querySaldo, $linkbd);
	$numRegistros=mysql_num_rows($result);

	if($numRegistros>0){
		$saldo+=$valorReversado2[0];
	}else{
		$saldo+=0.0;
	}

	return $saldo;
}

function generaSaldo($numCuenta,$vigenciai,$vigenciaf)
{
	$ejecucionxcuenta=Array();
	$fechaf=$vigenciai."-01-01";
	$fechaf2=$vigenciaf."-12-31";
	$linkbd=conectar_v7();
	$queryPresupuesto="SELECT valor,vigencia FROM pptocuentaspptoinicial WHERE cuenta='$numCuenta' AND (vigencia=$vigenciai OR vigencia=$vigenciaf)";
	$result=mysqli_query($linkbd,$queryPresupuesto);
	while($row=mysqli_fetch_array($result)){@$presuDefinitivo+=$row[0];}
	$ejecucionxcuenta[0]=$presuDefinitivo;
	$querySalidaPresuDefi="SELECT SUM(D.valor) FROM pptocdp C, pptocdp_detalle D WHERE D.cuenta='$numCuenta' AND (D.vigencia=$vigenciai OR D.vigencia=$vigenciaf) AND D.vigencia=C.vigencia AND D.tipo_mov='201' AND D.consvigencia=C.consvigencia AND C.tipo_mov='201' AND (C.vigencia=$vigenciai OR C.vigencia=$vigenciaf)  AND C.fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY D.cuenta";
	$valCDP=0.0;
	$result=mysqli_query($linkbd,$querySalidaPresuDefi);
	if(mysqli_num_rows($result)!=0)
	{
		while($row=mysqli_fetch_array($result)){$valCDP=$row[0];}
	}
	$querySalidaPresuDefi="SELECT SUM(D.valor) FROM pptocdp C, pptocdp_detalle D WHERE D.cuenta='$numCuenta' AND (D.vigencia=$vigenciai OR D.vigencia=$vigenciaf) AND D.tipo_mov like'4%' AND D.consvigencia=C.consvigencia AND C.tipo_mov like'4%' AND (C.vigencia=$vigenciai OR C.vigencia=$vigenciaf)  AND C.fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY D.cuenta";
	$valCDPRevers=0.0;
	$result=mysqli_query($linkbd,$querySalidaPresuDefi);
	if(mysqli_num_rows($result)!=0)
	{
		while($row=mysqli_fetch_array($result)){$valCDPRevers=$row[0];}
	}
	$queryAdiciones="SELECT SUM(pad.valor),pad.id_adicion,pa.fecha FROM pptoadiciones pad,pptoacuerdos pa WHERE pad.cuenta='$numCuenta' AND (pad.vigencia=$vigenciai OR pad.vigencia=$vigenciaf) AND pa.id_acuerdo=pad.id_acuerdo AND pad.id_acuerdo>0 AND NOT(pa.estado='N') AND pa.fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY cuenta";
	$result=mysqli_query($linkbd,$queryAdiciones);
	$totentAdicion=0.0;
	$totsalAdicion=0.0;
	if(mysqli_num_rows($result)!=0)
	{
		while($row=mysqli_fetch_array($result))
		{
			$presuDefinitivo+=$row[0];
			$totentAdicion+=$row[0];
			$totsalAdicion+=0.0;
		}
	}
	$ejecucionxcuenta[1]=$totentAdicion;
	$queryReducciones="SELECT SUM(pr.valor),pr.id_reduccion,pa.fecha FROM pptoreducciones pr,pptoacuerdos pa WHERE pr.cuenta='$numCuenta' AND pr.vigencia=$vigenciai AND pr.id_acuerdo=pa.id_acuerdo AND pr.id_acuerdo>0 AND NOT(pa.estado='N') AND pa.fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY pr.cuenta";
	//echo $queryReducciones;
	$result=mysqli_query($linkbd,$queryReducciones);
	$totentReduccion=0.0;
	$totsalReduccion=0.0;
	if(mysqli_num_rows($result)!=0)
	{
		while($row=mysqli_fetch_array($result))
		{
			$presuDefinitivo-=$row[0];
			$totentReduccion-=$row[0];
			$totsalReduccion-=0.0;
		}
	}
	$ejecucionxcuenta[2]=$totentReduccion;
	$queryTraslados="SELECT pt.id_acuerdo,pt.tipo,pt.valor,pa.fecha FROM pptotraslados pt,pptoacuerdos pa WHERE pt.cuenta='$numCuenta' AND pt.vigencia=$vigenciai AND pt.id_acuerdo>0 AND  pt.id_acuerdo=pa.id_acuerdo AND NOT(pa.estado='N') AND pa.fecha BETWEEN '$fechaf' AND '$fechaf2'";
	$presuSalida=0.0;
	$totentTraslado=0.0;
	$totsalTraslado=0.0;
	$result=mysqli_query($linkbd,$queryTraslados);
	if(mysqli_num_rows($result)!=0)
	{
		while($row=mysqli_fetch_array($result))
		{
			if($row[1]=='R')
			{
				$presuSalida+=$row[2];
				$totsalTraslado+=$row[2];
				$presuDefinitivo-=$row[2];
			}
			else
			{
				$presuDefinitivo+=$row[2];
				$totentTraslado+=$row[2];
			}
		}
	}
	$ejecucionxcuenta[3]=$totentTraslado;
	$ejecucionxcuenta[4]=$totsalTraslado;
	$presuDefinitivoSalida=$valCDP+$presuSalida;
	$ejecucionxcuenta[5]=$presuDefinitivo;
	return ($presuDefinitivo-$valCDP+$valCDPRevers);
}

//***consulta saldo
function consultasaldo($cuenta,$vigenciai,$vigenciaf)
{
	$datin=datosiniciales();
	if(!($linkbd=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar func");
 	if(!mysql_select_db($datin[0]))
 	die("no se puede seleccionar bd");
 	$fechaf=$vigenciaf."-01-01";
 	$fechaf2=$vigenciaf."-12-31";
 	$sqlr3="SELECT DISTINCT
			pptocomprobante_det.cuenta,
			sum(pptocomprobante_det.valdebito)-sum(pptocomprobante_det.valcredito), 
			pptocomprobante_det.tipo_comp, 
			pptocomprobante_cab.numerotipo,
			pptocomprobante_cab.fecha
			FROM pptocomprobante_det, pptocomprobante_cab
			WHERE     pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
			AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
			AND pptocomprobante_cab.estado != 0
			AND pptocomprobante_det.estado != 0 
			AND (   pptocomprobante_det.valdebito > 0
			OR pptocomprobante_det.valcredito > 0)			   
			AND
			(pptocomprobante_cab.VIGENCIA=".$vigenciai." or pptocomprobante_cab.VIGENCIA=".$vigenciaf.")
			and(pptocomprobante_det.VIGENCIA=".$vigenciai." or pptocomprobante_det.VIGENCIA=".$vigenciaf.")
			and pptocomprobante_det.VIGENCIA=pptocomprobante_cab.VIGENCIA
		    AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2'
			AND pptocomprobante_det.tipo_comp = 1 
			AND pptocomprobante_cab.tipo_comp = 1 		  
			AND pptocomprobante_det.cuenta = '".$cuenta."' 		 
			ORDER BY pptocomprobante_cab.fecha,pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_det.cuenta";
	//echo "<br>".$sqlr3;
	$res=mysql_query($sqlr3,$linkbd);
	while($row =mysql_fetch_row($res)){
		$sqlrr="select sum(valdebito) from pptocomprobante_det where numerotipo=$row[4] and tipo_comp=$row[3] and cuenta=$row[0] and tipomovimiento=3 ";
		$resr=mysql_query($sqlrr,$linkbd);
		$rr=mysql_fetch_row($resr);
		$valorini+=($row[1]-($row[2]-$rr[0]));
	}	
	$sqlr3="SELECT DISTINCT
			pptocomprobante_det.cuenta,
			pptocomprobante_det.valdebito,
			pptocomprobante_det.valcredito, pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_cab.fecha
			FROM pptocomprobante_det, pptocomprobante_cab
			WHERE     pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
			AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
			AND pptocomprobante_cab.estado = 1
			AND (   pptocomprobante_det.valdebito > 0
			OR pptocomprobante_det.valcredito > 0)			   
			AND
			(pptocomprobante_cab.VIGENCIA=".$vigenciai." or pptocomprobante_cab.VIGENCIA=".$vigenciaf.")
			and(pptocomprobante_det.VIGENCIA=".$vigenciai." or pptocomprobante_det.VIGENCIA=".$vigenciaf.")
			and pptocomprobante_det.VIGENCIA=pptocomprobante_cab.VIGENCIA
		    AND pptocomprobante_cab.fecha BETWEEN '' AND '$fechaf2'
			AND pptocomprobante_det.tipo_comp = 2 
			AND pptocomprobante_cab.tipo_comp = 2 		  
			AND pptocomprobante_det.cuenta = '".$cuenta."' 		  
			ORDER BY pptocomprobante_cab.fecha,pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_det.cuenta";
 	//echo "<br>".$sqlr3;
	$res=mysql_query($sqlr3,$linkbd);
	while($row =mysql_fetch_row($res)){$valoradi+=$row[1];}
	$sqlr3="SELECT DISTINCT
			pptocomprobante_det.cuenta,
			pptocomprobante_det.valdebito,
			pptocomprobante_det.valcredito, pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_cab.fecha
			FROM pptocomprobante_det, pptocomprobante_cab
			WHERE     pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
			AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
			AND pptocomprobante_cab.estado = 1
			AND (   pptocomprobante_det.valdebito > 0
			OR pptocomprobante_det.valcredito > 0)			   
			AND
			(pptocomprobante_cab.VIGENCIA=".$vigenciai." or pptocomprobante_cab.VIGENCIA=".$vigenciaf.")
			and(pptocomprobante_det.VIGENCIA=".$vigenciai." or pptocomprobante_det.VIGENCIA=".$vigenciaf.")
			and pptocomprobante_det.VIGENCIA=pptocomprobante_cab.VIGENCIA		  
			AND pptocomprobante_cab.fecha BETWEEN '' AND '$fechaf2'
			AND pptocomprobante_det.tipo_comp = 3 
			AND pptocomprobante_cab.tipo_comp = 3 		  
			AND pptocomprobante_det.cuenta = '".$cuenta."' 		  
			ORDER BY pptocomprobante_cab.fecha,pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_det.cuenta";
	//echo "<br>".$sqlr3;
	$res=mysql_query($sqlr3,$linkbd);
	while($row =mysql_fetch_row($res)){$valorred+=$row[1];} 
	$sqlr3="SELECT DISTINCT
			pptocomprobante_det.cuenta,
			pptocomprobante_det.valdebito,
			pptocomprobante_det.valcredito, pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_cab.fecha
			FROM pptocomprobante_det, pptocomprobante_cab
			WHERE     pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
			AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
			AND pptocomprobante_cab.estado = 1
			AND (   pptocomprobante_det.valdebito > 0
			OR pptocomprobante_det.valcredito > 0)			   
			AND
			(pptocomprobante_cab.VIGENCIA=".$vigenciai." or pptocomprobante_cab.VIGENCIA=".$vigenciaf.")
			and(pptocomprobante_det.VIGENCIA=".$vigenciai." or pptocomprobante_det.VIGENCIA=".$vigenciaf.")
		  	and pptocomprobante_det.VIGENCIA=pptocomprobante_cab.VIGENCIA
			AND pptocomprobante_cab.fecha BETWEEN '' AND '$fechaf2'
			AND pptocomprobante_det.tipo_comp = 5 
			AND pptocomprobante_cab.tipo_comp = 5 		  
			AND pptocomprobante_det.cuenta = '".$cuenta."' 		  
			ORDER BY pptocomprobante_cab.fecha,pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_det.cuenta";
  	//echo "<br>".$sqlr3;
	$res=mysql_query($sqlr3,$linkbd);
	while($row =mysql_fetch_row($res)){$valorcred+=$row[1];$valorconcred+=$row[2];}    
	$sqlr3="SELECT DISTINCT
			pptocomprobante_det.cuenta,
			pptocomprobante_det.valdebito,
			pptocomprobante_det.valcredito, pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_cab.fecha
			FROM pptocomprobante_det, pptocomprobante_cab
			WHERE     pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
			AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
			AND pptocomprobante_cab.estado = 1
			AND (   pptocomprobante_det.valdebito > 0
			OR pptocomprobante_det.valcredito > 0)			   
			AND
			(pptocomprobante_cab.VIGENCIA=".$vigenciai." or pptocomprobante_cab.VIGENCIA=".$vigenciaf.")
			and(pptocomprobante_det.VIGENCIA=".$vigenciai." or pptocomprobante_det.VIGENCIA=".$vigenciaf.")
		  	and pptocomprobante_det.VIGENCIA=pptocomprobante_cab.VIGENCIA
		    AND pptocomprobante_cab.fecha BETWEEN '' AND '$fechaf2'
			AND pptocomprobante_det.tipo_comp = 6 
			AND pptocomprobante_cab.tipo_comp = 6 		  
			AND pptocomprobante_det.cuenta = '".$cuenta."' 		  
			ORDER BY pptocomprobante_cab.fecha,pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_det.cuenta";
	// echo "<br>".$sqlr3;
	$res=mysql_query($sqlr3,$linkbd);
	while($row =mysql_fetch_row($res)){$valorcdps+=($row[1]-$row[2]);}    
	$saldo=0;
	
	$saldo=$valorini+$valoradi-$valorred+$valorcred-$valorconcred+1;
	//echo "$saldo         ";
	// $saldo=$saldo-$valorcdps; 
	// echo "$valorini+$valoradi-$valorred+$valorcred-$valorconcred";
	//echo "<br>$saldo-$valorcdps";
	return $saldo;
}
function buscar_ruta($barrio)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
 	die("no se puede conectar");
 	if(!mysql_select_db($datin[0]))
 	die("no se puede seleccionar bd");
 	$sqlr="Select ruta from servrutas_barrios where id_barrio='$barrio'";
 	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
 	return $valor;
}
function buscar_barrio($barrio)
{
  	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="Select nombre from servbarrios where id='$barrio'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
 	return $valor;
}
function buscar_servicios($codigo)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
 	die("no se puede conectar");
 	if(!mysql_select_db($datin[0]))
 	die("no se puede seleccionar bd");
 	$sqlr="Select nombre from servservicios where codigo='$codigo'";
 	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
 	return $valor;	
}
function buscar_codcatservicios($idusuario)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
 	die("no se puede conectar");
 	if(!mysql_select_db($datin[0]))
 	die("no se puede seleccionar bd");
 	$sqlr="Select codcatastral from servclientes where codigo='$idusuario'";
 	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
 	return $valor;
}
function buscar_barriodirecc($idcliente)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
 	die("no se puede conectar");
 	if(!mysql_select_db($datin[0]))
 	die("no se puede seleccionar bd");
 	$sqlr="Select barrio,direccion from servclientes where codigo='$idcliente'";
 	$res=mysql_query($sqlr,$conexion);
 	$valor=array();
	while($r=mysql_fetch_row($res)){$valor[0]=$r[0];$valor[1]=$r[1];}
 	return $valor;
}
function buscar_usosuelo($estrato)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
 	die("no se puede conectar");
 	if(!mysql_select_db($datin[0]))
 	die("no se puede seleccionar bd");
 	$sqlr="Select uso from servestratos where id='$estrato'";
 	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$uso=$r[0];}
	$sqlr="select *from dominios where NOMBRE_DOMINIO='USO_SUELO' and valor_inicial='$uso' ";
	$res=mysql_query($sqlr,$conexion);	
	while($r=mysql_fetch_row($res)){$valor=$r[1];}
 	return $valor;	
}
function buscar_nomtercerosp($codigo)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
 	die("no se puede conectar");
 	if(!mysql_select_db($datin[0]))
 	die("no se puede seleccionar bd");
 	$sqlr="Select servclientes.nombretercero from servclientes where codigo='$codigo'";
 	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
 	return $valor;	
 }
function buscar_intereses($codigo)
{
  	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
 	die("no se puede conectar");
 	if(!mysql_select_db($datin[0]))
 	die("no se puede seleccionar bd");
 	$sqlr="Select servclientes.intereses from servclientes where codigo='$codigo'";
 	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
 	return $valor;	
 } 
 //Eliminar de una digitacion los caracteres ", ', ;
 function eliminar_comillas($texto)
 {
	 $norequeridos = array("\"", "'", ";");
	 $sincomillas=str_replace($norequeridos, "", $texto);
	 return $sincomillas;	
 }

?>