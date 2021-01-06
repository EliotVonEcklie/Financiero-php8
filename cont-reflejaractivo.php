<?php
	require"comun.inc";
	require"funciones.inc";
	require "conversor.php";
	require "validaciones.inc";
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
		<title>:: SPID - Contabilidad</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/calendario.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type="text/javascript" src="css/programas.js"></script>
		<script>
			function procesos($tip)
			{	
				document.form2.oculto.value=3;	
  				document.form2.submit();
				/*switch ($tip) 
				{
					case 1:	despliegamodalm('visible','4','Generar preliquidación de este periodo','1');
							break;
				}*/
 			}
			 function despliegamodalm(_valor,_tip,mensa,pregunta,variable)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden")
				{
					document.getElementById('ventanam').src="";
					if(document.getElementById('valfocus').value=="2")
					{
						document.getElementById('valfocus').value='1';
						document.getElementById('codigo').focus();
						document.getElementById('codigo').select();
					}
				}
				else
				{
					switch(_tip)
					{
						case "1":
							document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
						case "2":
							document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
						case "3":
							document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
						case "4":
							document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
						case "5":
							document.getElementById('ventanam').src="ventana-elimina1.php?titulos="+mensa+"&idresp="+pregunta+"&variable="+variable;break;	
					}
				}
			}
			function despliegamodal2(_valor,v)
				{
						document.getElementById("bgventanamodal2").style.visibility=_valor;
						if(_valor=="hidden"){
							document.getElementById('ventana2').src="";
							document.form2.submit();
						}
						else {
							if(v==1){
								document.getElementById('ventana2').src="cuentas-ventana1.php?fecha=01/01/2018";
							}
							else if(v==2)
							{
								document.getElementById('ventana2').src="tercerosgral-ventana01.php?objeto=tercero&nobjeto=ntercero&nfoco=solicita";
							}
							else if(v==3)
							{
								document.getElementById('ventana2').src="cuentas-ventana3.php?fecha="+document.form2.fecha1.value;
							}
							else if(v==4)
							{
								document.getElementById('ventana2').src="cuentas-ventana4.php?fecha="+document.form2.fecha1.value;
							}
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
			<tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("cont");?></tr>
			<tr>
  				<td colspan="3" class="cinta"><img src="imagenes/add2.png" class="mgbt1"/><img src="imagenes/guardad.png" class="mgbt1"/><img src="imagenes/busca.png" title="Buscar" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"/><img src="imagenes/iratras.png" title="Menu Gesti&oacute;n Predial" class="mgbt" onClick="location.href='cont-reflejardocs.php'"/></td>
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
                    <td class="titulos" colspan="13">Correr Activos</td>
                    <td class="cerrar" style='width:7%'><a onClick="location.href='cont-principal.php'">&nbsp;Cerrar</a></td>
                </tr>
                <tr>
					<td class="salud1" style='width:8%'>Cuenta Credito:</td>
					<td style='width:8%'>
						<input name="cuentact" id="cuentact" type="text"  value="<?php echo $_POST[cuentact]?>" onKeyUp="return tabular(event,this) " style="width:60%;" onBlur="validar2()">
						<input name="cuentact_" type="hidden" value="<?php echo $_POST[cuentact_]?>">&nbsp;<img src="imagenes/find02.png" style="width:20px;" onClick="despliegamodal2('visible',1);" title="Buscar cuenta" class="icobut" />
						
					</td>
					<td><input type="text" name="ncuentact" style="width:100%;" value="<?php echo $_POST[ncuentact]?>" readonly></td>
					<td class="saludo1">Tercero:</td>
					<td>
						<input type="text" name="tercero" id="tercero" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>" onClick="document.getElementById('tercero').focus();document.getElementById('tercero').select();" style="width:60%">&nbsp;<a onClick="despliegamodal2('visible',2);" title="Listado Terceros"><img src="imagenes/find02.png" style="width:20px;cursor:pointer;"/></a> 
						<input type="hidden" value="0" name="bt">
					</td>
				
					<td >
						<input type="text" name="ntercero" id="ntercero" value="<?php echo $_POST[ntercero]?>" style="width:100%" readonly >
					</td>
				</tr>
				<tr>
                	<td class="saludo1" style="width:2cm;">No Activo Ini:</td>
                    <td style="width:5%"><input type="text" name="facini" id="facini" value="<?php echo $_POST[facini];?>"/></td>
                    <td class="saludo1" style="width:2cm;">No Activo Fin:</td>
                    <td style="width:5%"><input type="text" name="facfin" id="facfin" value="<?php echo $_POST[facfin];?>"/></td>
					<td  class="saludo1" style="width:1cm;">Fecha:</td>
                    <td >
                        <input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY"  value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)" maxlength="10">&nbsp;<img src="imagenes/calendario04.png" style="width:15px; cursor:pointer;" title="Calendario"  onClick="displayCalendarFor('fc_1198971545');" class="icobut"/>	  
                   </td>
                    <td><input type="button" name="buscapredios"  value=" Contabilizar " onClick="procesos(1)"/></td>
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
            <div class="subpantalla" style="height:30.5%; width:99.6%; overflow-x:hidden;">
      		<?php
				if($_POST[oculto]==3)
	   			{	
					$_POST[oculto]=2;
					$nuevo="";
					$actual="";
					$result=0;
					ini_set('max_execution_time', 7200);
					$sqlrn="SELECT * FROM acticrearact WHERE codigo BETWEEN $_POST[facini] AND $_POST[facfin] ORDER BY codigo";
					$respn=mysql_query($sqlrn,$linkbd);
					preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/",$_POST['fecha'],$fecha);
					$fechaf="$fecha[3]-$fecha[2]-$fecha[1]";
					$vigencia = $fecha[3];
					$totalcli=mysql_affected_rows ($linkbd);
					while ($rown=mysql_fetch_row($respn)) 
					{
						$c+=1;
						$porcentaje = $c * 100 / $totalcli; 
						echo"<script>progres='".round($porcentaje)."';callprogress(progres);</script>"; 
						flush();
						ob_flush();
						usleep(5);//microsegundos
						
						$fecha=$rown[1];
						$sqlr="SELECT * FROM acticrearact_det WHERE codigo='$rown[0]' ORDER BY codigo";
						$resp=mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_assoc($resp)) 
						{	
							//***datos	
							$sqlrCon = "SELECT numerotipo FROM comprobante_det WHERE numacti='".$row['placa']."' AND tipo_comp='70'";
							$resCon = mysql_query($sqlrCon,$linkbd);
							$rowCon=mysql_fetch_assoc($resCon);
							if($rowCon['numerotipo']!='')
							{
								$result+=1;
							}
							else
							{
								$valor='';
								$tarifa=array();
								$actual=$rown[0];
								$centrocosto=$row["cc"];
								if($nuevo!=$actual )
								{
									$sqlrdl ="DELETE FROM comprobante_cab WHERE tipo_comp='70' AND numerotipo='$rown[0]'";
									mysql_query($sqlrdl,$linkbd);
									$sqlrdl ="DELETE FROM comprobante_det WHERE tipo_comp='70' AND numerotipo='$rown[0]'";
									mysql_query($sqlrdl,$linkbd);			
									$sqlrt="INSERT INTO comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito, total_credito,diferencia,estado) VALUES ('$rown[0]','70','$fechaf','".$row['nombre']."',0,0,0,0,'1') ON DUPLICATE KEY UPDATE numerotipo='$rown[0]',tipo_comp='70'";
									mysql_query($sqlrt,$linkbd);
									$nuevo=$actual;		
								}
								$valor=$row['valor']+$row['valorcorrec'];
								
								$placar=SUBSTR($row['placa'],0,6);
								$sqlr1="SELECT cuenta_activo FROM acti_activos_det WHERE tipo='$placar' and disposicion_activos='".$row['dispoact']."'";
								$res1=mysql_query($sqlr1,$linkbd);
								$row1=mysql_fetch_row($res1);	
								if($row1[0]!='')
								{
									$sqlrj="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito, estado, vigencia,tipo_comp,numerotipo,numacti) values ('70 $rown[0]','$row1[0]','$_POST[tercero]','$centrocosto' , '".$row['placa']."','','".$valor."', '0','1' ,'$vigencia','70','$rown[0]','".$row['placa']."')";
									mysql_query($sqlrj,$linkbd);			
									$sqlrj="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito, estado, vigencia,tipo_comp,numerotipo,numacti) values ('70 $rown[0]','$_POST[cuentact]','$_POST[tercero]','$centrocosto' , '".$row['placa']."','','0', '".$valor."','1' ,'$vigencia','70','$rown[0]','".$row['placa']."')";
									mysql_query($sqlrj,$linkbd);
								}
								else 
								{
									echo "<div class='saludo1'>No Parametrizada: ".$row['placa']." - ".$row['nombre']."</div>"; 
								}
							}
						}
					}
					if($result>0)
					{
						echo "<script>despliegamodalm('visible','2','Hay activos que ya estan contabilizados, no se incluiran en esta contabilizacion.');</script>";
					}
				}
			?>
			</div>
			<div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                    </IFRAME>
                </div>
       	 	</div>
		</form>
	</body>
</html>