<?php //V 1000 12/12/16 ?> 
<?php 
require"comun.inc";
	require"funciones.inc";
	require "conversor.php";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");

$saldo=consultasaldo(203020101,2016,2016);


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
	// echo "<br>".$sqlr3;
	$res=mysql_query($sqlr3,$linkbd);
	while($row =mysql_fetch_row($res)){
		$sqlrr="select sum(valdebito) from pptocomprobante_det where numerotipo=$row[4] and tipo_comp=$row[3] and cuenta=$row[0] and tipomovimiento=3 ";
		$resr=mysql_query($sqlrr,$linkbd);
		$rr=mysql_fetch_row($resr);
		$valorini+=($row[1]-($row[2]-$rr[0]));
		echo "PI: ".$row[1]."<br>";
		echo "PIC: ".$row[2]."<br>";
		echo "R: ".$rr[0]."<br>";
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
	   while($row =mysql_fetch_row($res)){
		   $valoradi+=$row[1];
		   echo "AD: ".$row[1]."<br>";
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
		echo "RED: ".$row[1]."<br>";
		} 
	$sqlr3="SELECT 
			pptocomprobante_det.cuenta,
			sum(pptocomprobante_det.valdebito),
			sum(pptocomprobante_det.valcredito), 
			pptocomprobante_det.tipo_comp, 
			pptocomprobante_cab.numerotipo,
			pptocomprobante_cab.fecha,
			pptocomprobante_det.tipomovimiento
			FROM pptocomprobante_det, pptocomprobante_cab
			WHERE     pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
			AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
			AND pptocomprobante_cab.estado = 1
			AND pptocomprobante_det.estado = 1
			AND (   pptocomprobante_det.valdebito > 0
			OR pptocomprobante_det.valcredito > 0)			   
			AND
			(pptocomprobante_cab.VIGENCIA=".$vigenciai." or pptocomprobante_cab.VIGENCIA=".$vigenciaf.")
			and(pptocomprobante_det.VIGENCIA=".$vigenciai." or pptocomprobante_det.VIGENCIA=".$vigenciaif.")
			and pptocomprobante_cab.VIGENCIA=pptocomprobante_det.VIGENCIA
			AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2'
			AND pptocomprobante_det.tipo_comp = 5 
			AND pptocomprobante_cab.tipo_comp = 5 		  
			AND pptocomprobante_det.cuenta LIKE '".$cuenta."' 
			GROUP BY pptocomprobante_det.numerotipo
			ORDER BY pptocomprobante_cab.fecha,pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_det.cuenta";
  	echo "<br>".$sqlr3;
	$res=mysql_query($sqlr3,$linkbd);
	while($row =mysql_fetch_row($res)){
		$valorcred+=$row[1];
		$valorconcred+=$row[2];
		echo "CRED: ".$row[1]."<br>";
		echo "CONTRA: ".$row[2]."<br>";
	
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
	// echo "<br>".$sqlr3;
	$res=mysql_query($sqlr3,$linkbd);
	while($row =mysql_fetch_row($res)){$valorcdps+=$row[1]-$row[2];}    
	$saldo=0;
	echo $valorconcred;
	$saldo=$valorini+$valoradi-$valorred+$valorcred-$valorconcred;
	//echo "$saldo         ";
	// $saldo=$saldo-$valorcdps; 
	// echo "$valorini+$valoradi-$valorred+$valorcred-$valorconcred";
	//echo "<br>$saldo-$valorcdps";
	return $saldo;
}
?>