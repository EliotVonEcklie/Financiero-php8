<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	header("Content-Type: text/html;charset=iso-8859-1");
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-type" content="text/html; charset=iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Tesoreria</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
		<script>
			function procesos($tip)
			{	
				switch ($tip) 
				{
					case 1:	despliegamodalm('visible','4','Generar preliquidación de este periodo','1');
							break;
				}
 			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventanam').src="";}
				else
				{
					switch(_tip)
					{
						case "1":	document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
						case "2":	document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
						case "3":	document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
						case "4":	document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
					}
				}
			}
			function funcionmensaje(){}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.form2.oculto.value=3;	
  								document.form2.submit();break;
				}
			}
			function callprogress(vValor)
			{
 				document.getElementById("getprogress").innerHTML = vValor;
 				document.getElementById("getProgressBarFill").innerHTML = '<div class="ProgressBarFill" style="width: '+vValor+'%;"></div>';				
				document.getElementById("titulog1").style.display='block';
   				document.getElementById("progreso").style.display='block';
     			document.getElementById("getProgressBarFill").style.display='block';
				if (vValor==100){document.getElementById("titulog2").style.display='block';}
			} 
		</script>
		<?php titlepag(); ?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("teso");?></tr>
			<tr>
  				<td colspan="3" class="cinta"><img src="imagenes/add2.png" class="mgbt1"/><img src="imagenes/guardad.png" class="mgbt1"/><img src="imagenes/busca.png" title="Buscar" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"/><img src="imagenes/iratras.png" title="Menu Gesti&oacute;n Predial" class="mgbt" onClick="location.href='teso-gestionpredial.php'"/></td>
			</tr>		  
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
        <form name="form2" method="post" action="">
			<table class="inicio">
                <tr>
                    <td class="titulos" colspan="13">correr huevonaditas</td>
                    <td class="cerrar" style='width:7%'><a onClick="location.href='teso-principal.php'">&nbsp;Cerrar</a></td>
                </tr>
                <tr>
                    <td class="saludo1" style="width:4cm;">correr codigo:</td>
                    <td><input type="button" name="buscapredios"  value=" Generar " onClick="procesos(1)"/></td>
                    <td>
						<div id='titulog1' style='display:none; float:left'></div>
						<div id='progreso' class='ProgressBar' style='display:none; float:left'>
							<div class='ProgressBarText'><span id='getprogress'></span>&nbsp;% </div>
							<div id='getProgressBarFill'></div>
						</div>
					</td>
                </tr>
			</table>
            <input type="hidden" name="oculto" id="oculto" value="<?php echo $_POST[oculto];?>"/>
            <div class="subpantalla" style="height:68.5%; width:99.6%; overflow-x:hidden;">
      		<?php
				
				if($_POST[oculto]==3)
	   			{
					$_POST[oculto]=2;
					$sqlr="SELECT diasplazo FROM servparametros";
					$row =mysql_fetch_row(mysql_query($sqlr,$linkbd));
					$diaplazo=$row[0];
					$facrevi="0";
					$c=0;
					$vigenciaactual=2017;
					$vigenciaanterior=$vigenciaactual-1;
					$sqlr="
					SELECT DISTINCT TB1.codigocatastral,TB1.avaluo,TB1.pago,TB1.estado,TB2.tipopredio,TB2.estratos,TB1.vigencia
					FROM tesoprediosavaluos TB1, tesopredios TB2
					WHERE TB1.estado = 'S'
					AND TB1.pago = 'N'
					AND TB1.codigocatastral = TB2.cedulacatastral
					ORDER BY TB1.vigencia ASC ";
					$respn=mysql_query($sqlr,$linkbd);
					$totalcli=mysql_affected_rows ($linkbd);
					while ($row =mysql_fetch_row($respn)) 
					{	
						$c+=1;
						$porcentaje = $c * 100 / $totalcli; 
						echo"<script>progres='".round($porcentaje)."';callprogress(progres);</script>"; 
						flush();
						ob_flush();
						usleep(5);//microsegundos
						//ACTUALIZAR FACTURA
						//$sqlrin="SELECT pago FROM tesoprediosavaluos WHERE codigocatastral='$row[0]' AND vigencia='$row[6]'";
						//$resin=mysql_query($sqlrin,$linkbd);
						//$rowin=mysql_fetch_row($resin);
						//if ($rowin[0]=='S')
						{
							$base=$row[1];
							$sqlrtr="SELECT tasa FROM tesotarifaspredial WHERE vigencia='$row[6]' AND tipo='$row[4]' AND estratos='$row[5]'";
			 				$restr=mysql_query($sqlrtr,$linkbd);
	 						$rowtr=mysql_fetch_row($restr);
							$tasapre=$rowtr[0];
							$predial=round($base*($rowtr[0]/1000)-$base*($rowtr[0]/1000)*($_POST[deduccion]/100),2);

						echo "$row[0]- $row[6] - $predial</br>";
						}
	  				}
				}
			?>
			</div>
		</form>
	</body>
</html>