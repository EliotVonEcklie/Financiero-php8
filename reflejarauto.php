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
	
	$tipocomp=1;
	$vigencia=2016;
	$docreceptor=6;
	
	$sqlr="select numerotipo, fecha from pptocomprobante_cab where tipo_comp='$tipocomp' and vigencia='$vigencia'";
	$res=mysql_query($sqlr,$linkbd);
	while($row=mysql_fetch_row($res)){
		echo "numerotipo: ".$row[0]."    Fecha: ".$row[1]."<br>";
		$sqlr1="select doc_receptor from pptocomprobante_det where numerotipo='$row[0]' and tipo_comp='$tipocomp' and vigencia='$vigencia'";
		$res1=mysql_query($sqlr1,$linkbd);
		while($row1=mysql_fetch_row($res1)){
			echo "doc_receptor: ".$row1[0]."<br>	";
			if($row1[0]==0){
				$sqlu="update pptocomprobante_det set fecha='$row[1]' where numerotipo='$row[0]' and tipo_comp='$tipocomp' and vigencia='$vigencia' and valcredito='0'";
				echo "$sqlu <br>";
				mysql_query($sqlu,$linkbd);
			}else{
				$sqlr2="select fecha from pptocomprobante_cab where numerotipo='$row1[0]' and  tipo_comp='$docreceptor' and vigencia='$vigencia'";
				$res2=mysql_query($sqlr2,$linkbd);
				$row2=mysql_fetch_row($res2);
				echo "$sqlr2 <br>";
				$sqlu1="update pptocomprobante_det set fecha='$row2[0]' where numerotipo='$row[0]' and tipo_comp='$tipocomp' and vigencia='$vigencia' and doc_receptor='$row1[0]'";
				mysql_query($sqlu1,$linkbd);
				echo "$sqlu1 <br>";
			}
		}
	}
?>