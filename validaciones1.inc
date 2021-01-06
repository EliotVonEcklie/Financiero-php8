<?php
//**validacion signos cuentas ccontables chip
function cuenta_colocar_signo($cuenta)
{
 	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
		die("no se puede conectar");
		if(!mysql_select_db($datin[0]))
			die("no se puede seleccionar bd");
	$sqlr="Select naturaleza from cuentas where cuenta='$cuenta'";
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
	 	 	if(0==strcmp($nat,"DEBITO")){$signo=1;}
	  		if(0==strcmp($nat,"CREDITO")){$signo=-1;}
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
//***consulta saldo
function consultasaldo($cuenta,$vigenciai,$vigenciaf)
{
	$datin=datosiniciales();
	if(!($linkbd=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar func");
 	if(!mysql_select_db($datin[0]))
 	die("no se puede seleccionar bd");
 	$fechaf=$vigenciai."-01-01";
 	$fechaf2=$vigenciaf."-12-31";
 	
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
		    AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2'
          AND pptocomprobante_det.tipo_comp = 1 
          AND pptocomprobante_cab.tipo_comp = 1 		  
          AND pptocomprobante_det.cuenta = '".$cuenta."' 		 
   ORDER BY pptocomprobante_cab.fecha,pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_det.cuenta";
	//echo "<br>".$sqlr3;
	$res=mysql_query($sqlr3,$linkbd);

	while($row =mysql_fetch_row($res)){
		$valorini+=$row[1];$creditoinicial+=$row[2];
	}
	$sqlr3="SELECT DISTINCT
          pptocomprobante_det.cuenta,
          pptocomprobante_det.valdebito,
          pptocomprobante_det.valcredito, 
		  pptocomprobante_det.tipo_comp, 
		  pptocomprobante_cab.numerotipo,
		  pptocomprobante_cab.fecha
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
	   while($row =mysql_fetch_row($res)){
	   		$valoradi+=$row[1];
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
          AND pptocomprobante_det.tipo_comp = 3 
          AND pptocomprobante_cab.tipo_comp = 3 		  
          AND pptocomprobante_det.cuenta = '".$cuenta."' 		  
   		ORDER BY pptocomprobante_cab.fecha,pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_det.cuenta";
  		 //echo "<br>".$sqlr3;
		$res=mysql_query($sqlr3,$linkbd);
		while($row =mysql_fetch_row($res)){
			$valorred+=$row[1];
		} 
		$sqlr3="SELECT DISTINCT
			pptocomprobante_det.cuenta,
			pptocomprobante_det.valdebito,
			pptocomprobante_det.valcredito, pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_cab.fecha
 			FROM pptocomprobante_det, pptocomprobante_cab
    		WHERE pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
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
		while($row =mysql_fetch_row($res)){
			$valorcred+=$row[1];$valorconcred+=$row[2];
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
	          AND pptocomprobante_det.tipo_comp = 6 
	          AND pptocomprobante_cab.tipo_comp = 6 		  
	          AND pptocomprobante_det.cuenta = '".$cuenta."' 		  
	   		ORDER BY pptocomprobante_cab.fecha,pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_det.cuenta";
		 //echo "<br>".$sqlr3;
		$res=mysql_query($sqlr3,$linkbd);
		while($row =mysql_fetch_row($res)){
			$valorcdps+=$row[1]-$row[2];
		}    
		$saldo=0;
		$saldo=$valorini-$creditoinicial+$valoradi-$valorred+$valorcred-$valorconcred;
		//echo "<br>Saldo: $saldo ";
		//$saldo=$saldo-$valorcdps;
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