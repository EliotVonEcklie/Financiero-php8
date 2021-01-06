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
	
	$sqlcdp="select numerotipo,estado from pptocomprobante_cab where tipo_comp='6' and vigencia='2016'";
	// echo $sqlcdp;
	$rescdp=mysql_query($sqlcdp,$linkbd);
	while($rowcdp=mysql_fetch_row($rescdp)){
		$sqlr="select tipo_mov from pptocdp_cab_r where consvigencia='".$rowcdp[0]."'";
		$resdes=mysql_query($sqlr);
		$rowdes=mysql_fetch_row($resdes);
		if($rowdes[0]!=''){
			$tipomov=$rowdes[0];
		}else{
			$tipomov='01';
		}
		$fpfecha=split("/",$_POST[fecha]);
		$fechaf=$fpfecha[2]."-".$fpfecha[1]."-".$fpfecha[0];	
		$sqlc="select * from pptocomprobante_det where numerotipo='".$rowcdp[0]."' and vigencia='2016'";
		$resc=mysql_query($sqlc,$linkbd);
		while($rowc=mysql_fetch_row($resc))
		{			
			$dgastos=$rowc[4];
			echo $dgastos."-".$rowcdp[0]."-".$rowcdp[1]."-".$rowc[0]."-".$rowc[1]."-".$rowc[3]."<br>";	
			$sqlr="delete from  pptocomprobante_det where numerotipo='".$rowcdp[0]."' and tipo_comp=6 and valcredito=0 and cuenta=";
			mysql_query($sqlr,$linkbd);
			$sqlr="delete from pptocomprobante_det where numerotipo='2016' and tipo_comp=1 and valdebito=0 and cuenta='".$rowc[1]."' and doc_receptor='".$rowcdp[0]."' and tipomovimiento=1";
			echo $sqlr."<br>";
			mysql_query($sqlr,$linkbd);
			
			$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo,tipomovimiento,uniejecutora,doc_receptor) values('".$rowc[1]."','','".$rowc[3]."',".$dgastos.",0,'".$rowcdp[1]."','2016',6,'".$rowcdp[0]."',1,'','')";
			echo $sqlr."<br>";
			mysql_query($sqlr,$linkbd); 
			$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo,tipomovimiento,uniejecutora,doc_receptor) values('".$rowc[1]."','','".$rowc[3]."',0,'".$dgastos."','".$rowcdp[1]."','2016',1,'2016',1,'','".$rowcdp[0]."')";
			echo $sqlr."<br>";
			mysql_query($sqlr,$linkbd); 
		}
	}
	
?>




