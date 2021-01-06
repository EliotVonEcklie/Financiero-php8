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
					ini_set('max_execution_time', 7200);
					$_POST[oculto]=2;
					$sqlr="SELECT id_nom,cedulanit,netopagar,devendias,estado,auxalim,auxtran,prima_navi,salud,saludemp,pension,pensionemp, fondosolid,cajacf,icbf,sena,instecnicos,esap,arp,otrasdeduc FROM humnomina_det ORDER BY id_nom ASC ";
					$resp=mysql_query($sqlr,$linkbd);
					$totalcli=mysql_affected_rows ($linkbd);
					while ($row =mysql_fetch_row($resp)) 
					{	
						$c+=1;
						$porcentaje = $c * 100 / $totalcli; 
						echo"<script>progres='".round($porcentaje)."';callprogress(progres);</script>"; 
						flush();
						ob_flush();
						usleep(5);//microsegundos
						//datos generales
						$numcc=buscaccnomina("$row[1]");
						$sqlrf="SELECT mes,vigencia FROM  humnomina WHERE id_nom='$row[0]'";
						$respf=mysql_query($sqlrf,$linkbd);
						$rowf=mysql_fetch_row($respf);
						$fechar = new DateTime("$rowf[1]-$rowf[0]-01");
						$fechar->modify('last day of this month');
						$fechat=$fechar->format('Y-m-d');
						$perpagoi="$rowf[1]-$rowf[0]-01";
						$perpagof=$fechat;
		 				$sqlrpf="SELECT cajas,icbf,sena,iti,esap,indiceinca FROM admfiscales WHERE estado='S' AND vigencia='$rowf[1]'";
		  				$resppf = mysql_query($sqlrpf,$linkbd);			
						while($rowpf=mysql_fetch_row($resppf))
		 				{
					 		$cajascom=$rowpf[0];	
							$icbf=$rowpf[1];	
							$sena=$rowpf[2];	
							$iti=$rowpf[3];	
							$esap=$rowpf[4];
							$arp=$rowpf[5];						 					 					 					 
						}
						//salarios
						if($row[3]>0)
						{
							$idlist=selconsecutivo('hum_salarios_nom','id_list');
							$cupres=buscavariablepago('01',$numcc);
							$sqlr1="INSERT INTO hum_salarios_nom (id_list,id_nom,empleado,tercero,cc,cuentap,valorneto,valordevengado,fecha, periodopagoi,periodopagof,tipo_item,estado,tipo_mov) VALUES ('$idlist','$row[0]','$row[1]','','$numcc','$cupres','$row[3]','$row[2]','','$perpagoi', '$perpagof','SL','$row[4]','201')";
							$resp1=mysql_query($sqlr1,$linkbd);
							$row1=mysql_fetch_row($resp1);
						}
						//aux Alimentación
						if($row[5]>0)
						{
							$idlist=selconsecutivo('hum_salarios_nom','id_list');
							$cupres=buscavariablepago('07',$numcc);
							$sqlry2="INSERT INTO hum_salarios_nom (id_list,id_nom,empleado,tercero,cc,cuentap,valorneto,valordevengado,fecha, periodopagoi,periodopagof,tipo_item,estado,tipo_mov) VALUES ('$idlist','$row[0]','$row[1]','','$numcc','$cupres','$row[5]','$row[5]','','$perpagoi', '$perpagof','AA','$row[4]','201')";
							$respy2=mysql_query($sqlry2,$linkbd);
							$rowy2=mysql_fetch_row($respy2);
						}
						//aux Alimentación
						if($row[6]>0)
						{
							$idlist=selconsecutivo('hum_salarios_nom','id_list');
							$cupres=buscavariablepago('08',$numcc);
							$sqlry2="INSERT INTO hum_salarios_nom (id_list,id_nom,empleado,tercero,cc,cuentap,valorneto,valordevengado,fecha, periodopagoi,periodopagof,tipo_item,estado,tipo_mov) VALUES ('$idlist','$row[0]','$row[1]','','$numcc','$cupres','$row[6]','$row[6]','','$perpagoi', '$perpagof','AT','$row[4]','201')";
							$respy2=mysql_query($sqlry2,$linkbd);
							$rowy2=mysql_fetch_row($respy2);
						}
						//Prima Navidad
						if($row[7]>0)
						{
							$idlist=selconsecutivo('hum_salarios_nom','id_list');
							$cupres=buscavariablepago('02',$numcc);
							$sqlry2="INSERT INTO hum_salarios_nom (id_list,id_nom,empleado,tercero,cc,cuentap,valorneto,valordevengado,fecha, periodopagoi,periodopagof,tipo_item,estado,tipo_mov) VALUES ('$idlist','$row[0]','$row[1]','','$numcc','$cupres','$row[7]','$row[7]','','$perpagoi', '$perpagof','PN','$row[4]','201')";
							$respy2=mysql_query($sqlry2,$linkbd);
							$rowy2=mysql_fetch_row($respy2);
						}
						//salud empleado
						if($row[8]>0)
						{
							$idlist=selconsecutivo('hum_salarios_nom','id_list');
							$cupres=buscavariablepago('01',$numcc);
							$eps=buscadatofuncionario($row[1],'NUMEPS');
							$sqlry2="INSERT INTO hum_salarios_nom (id_list,id_nom,empleado,tercero,cc,cuentap,valorneto,valordevengado,fecha, periodopagoi,periodopagof,tipo_item,estado,tipo_mov) VALUES ('$idlist','$row[0]','$row[1]','$eps','$numcc','$cupres','$row[8]','$row[8]','', '$perpagoi','$perpagof','SE','$row[4]','201')";
							$respy2=mysql_query($sqlry2,$linkbd);
							$rowy2=mysql_fetch_row($respy2);
						}
						//salud empresa
						if($row[9]>0)
						{
							$idlist=selconsecutivo('hum_salarios_nom','id_list');
							$eps=buscadatofuncionario($row[1],'NUMEPS');
							$cupres=buscaparafiscal2('07',$numcc,'N/A',$rowf[1]);
							$sqlry2="INSERT INTO hum_salarios_nom (id_list,id_nom,empleado,tercero,cc,cuentap,valorneto,valordevengado,fecha, periodopagoi,periodopagof,tipo_item,estado,tipo_mov) VALUES ('$idlist','$row[0]','$row[1]','$eps','$numcc','$cupres','$row[9]','$row[9]','', '$perpagoi','$perpagof','SR','$row[4]','201')";
							$respy2=mysql_query($sqlry2,$linkbd);
							$rowy2=mysql_fetch_row($respy2);
						}
						//pension empleado
						if($row[10]>0)
						{
							$idlist=selconsecutivo('hum_salarios_nom','id_list');
							$afp=buscadatofuncionario($row[1],'NUMAFP');
							$cupres=buscavariablepago('01',$numcc);
							$sqlry2="INSERT INTO hum_salarios_nom (id_list,id_nom,empleado,tercero,cc,cuentap,valorneto,valordevengado,fecha, periodopagoi,periodopagof,tipo_item,estado,tipo_mov) VALUES ('$idlist','$row[0]','$row[1]','$afp','$numcc','$cupres','$row[10]','$row[10]','', '$perpagoi','$perpagof','PE','$row[4]','201')";
							$respy2=mysql_query($sqlry2,$linkbd);
							$rowy2=mysql_fetch_row($respy2);
						}
						//pension empresa
						if($row[11]>0)
						{
							$idlist=selconsecutivo('hum_salarios_nom','id_list');
							$afp=buscadatofuncionario($row[1],'NUMAFP');
							$sector=buscasectoremp($afp,'1');
							$cupres=buscaparafiscal2('09',$numcc,$sector,$rowf[1]);
							$sqlry2="INSERT INTO hum_salarios_nom (id_list,id_nom,empleado,tercero,cc,cuentap,valorneto,valordevengado,fecha, periodopagoi,periodopagof,tipo_item,estado,tipo_mov) VALUES ('$idlist','$row[0]','$row[1]','$afp','$numcc','$cupres','$row[11]','$row[11]','', '$perpagoi','$perpagof','PR','$row[4]','201')";
							$respy2=mysql_query($sqlry2,$linkbd);
							$rowy2=mysql_fetch_row($respy2);
						}
						//fondo solidaridad
						if($row[12]>0)
						{
							$idlist=selconsecutivo('hum_salarios_nom','id_list');
							$afp=buscadatofuncionario($row[1],'NUMAFP');
							$cupres=buscavariablepago('01',$numcc);
							$sqlry2="INSERT INTO hum_salarios_nom (id_list,id_nom,empleado,tercero,cc,cuentap,valorneto,valordevengado,fecha, periodopagoi,periodopagof,tipo_item,estado,tipo_mov) VALUES ('$idlist','$row[0]','$row[1]','$afp','$numcc','$cupres','$row[12]','$row[12]','', '$perpagoi','$perpagof','FS','$row[4]','201')";
							$respy2=mysql_query($sqlry2,$linkbd);
							$rowy2=mysql_fetch_row($respy2);
						}
						//cofrem
						if($row[13]>0)
						{
							$idlist=selconsecutivo('hum_salarios_nom','id_list');
							$cupres=buscaparafiscal2('01',$numcc,'N/A',$rowf[1]);
							
							$sqlry2="INSERT INTO hum_salarios_nom (id_list,id_nom,empleado,tercero,cc,cuentap,valorneto,valordevengado,fecha, periodopagoi,periodopagof,tipo_item,estado,tipo_mov) VALUES ('$idlist','$row[0]','$row[1]','$cajascom','$numcc','$cupres','$row[13]','$row[13]','', '$perpagoi','$perpagof','P1','$row[4]','201')";
							$respy2=mysql_query($sqlry2,$linkbd);
							$rowy2=mysql_fetch_row($respy2);
						}
						//ICBF
						if($row[14]>0)
						{
							$idlist=selconsecutivo('hum_salarios_nom','id_list');
							$cupres=buscaparafiscal2('02',$numcc,'N/A',$rowf[1]);
							$sqlry2="INSERT INTO hum_salarios_nom (id_list,id_nom,empleado,tercero,cc,cuentap,valorneto,valordevengado,fecha, periodopagoi,periodopagof,tipo_item,estado,tipo_mov) VALUES ('$idlist','$row[0]','$row[1]','$icbf','$numcc','$cupres','$row[14]','$row[14]','', '$perpagoi','$perpagof','P2','$row[4]','201')";
							$respy2=mysql_query($sqlry2,$linkbd);
							$rowy2=mysql_fetch_row($respy2);
						}
						//sena
						if($row[15]>0)
						{
							$idlist=selconsecutivo('hum_salarios_nom','id_list');
							$cupres=buscaparafiscal2('03',$numcc,'N/A',$rowf[1]);
							$sqlry2="INSERT INTO hum_salarios_nom (id_list,id_nom,empleado,tercero,cc,cuentap,valorneto,valordevengado,fecha, periodopagoi,periodopagof,tipo_item,estado,tipo_mov) VALUES ('$idlist','$row[0]','$row[1]','$sena','$numcc','$cupres','$row[15]','$row[15]','', '$perpagoi','$perpagof','P3','$row[4]','201')";
							$respy2=mysql_query($sqlry2,$linkbd);
							$rowy2=mysql_fetch_row($respy2);
						}
						//institutos tec
						if($row[16]>0)
						{
							$idlist=selconsecutivo('hum_salarios_nom','id_list');
							$cupres=buscaparafiscal2('04',$numcc,'N/A',$rowf[1]);
							$sqlry2="INSERT INTO hum_salarios_nom (id_list,id_nom,empleado,tercero,cc,cuentap,valorneto,valordevengado,fecha, periodopagoi,periodopagof,tipo_item,estado,tipo_mov) VALUES ('$idlist','$row[0]','$row[1]','$iti','$numcc','$cupres','$row[16]','$row[16]','', '$perpagoi','$perpagof','P4','$row[4]','201')";
							$respy2=mysql_query($sqlry2,$linkbd);
							$rowy2=mysql_fetch_row($respy2);
						}
						//esap
						if($row[17]>0)
						{
							$idlist=selconsecutivo('hum_salarios_nom','id_list');
							$cupres=buscaparafiscal2('05',$numcc,'N/A',$rowf[1]);
							$sqlry2="INSERT INTO hum_salarios_nom (id_list,id_nom,empleado,tercero,cc,cuentap,valorneto,valordevengado,fecha, periodopagoi,periodopagof,tipo_item,estado,tipo_mov) VALUES ('$idlist','$row[0]','$row[1]','$esap','$numcc','$cupres','$row[17]','$row[17]','', '$perpagoi','$perpagof','P5','$row[4]','201')";
							$respy2=mysql_query($sqlry2,$linkbd);
							$rowy2=mysql_fetch_row($respy2);
						}
						//arp
						if($row[18]>0)
						{
							$idlist=selconsecutivo('hum_salarios_nom','id_list');
							$cupres=buscaparafiscal2('06',$numcc,'N/A',$rowf[1]);
							$sqlry2="INSERT INTO hum_salarios_nom (id_list,id_nom,empleado,tercero,cc,cuentap,valorneto,valordevengado,fecha, periodopagoi,periodopagof,tipo_item,estado,tipo_mov) VALUES ('$idlist','$row[0]','$row[1]','$arp','$numcc','$cupres','$row[18]','$row[18]','', '$perpagoi','$perpagof','P6','$row[4]','201')";
							$respy2=mysql_query($sqlry2,$linkbd);
							$rowy2=mysql_fetch_row($respy2);
						}
						//Descuentos
						if($row[19]>0)
						{
							$sqlrd="SELECT valor,estado,id FROM humnominaretenemp WHERE id_nom='$row[0]' AND cedulanit='$row[1]'";
							$respd=mysql_query($sqlrd,$linkbd);
							while ($rowd =mysql_fetch_row($respd)) 
							{	
								$idlist=selconsecutivo('hum_salarios_nom','id_list');
								$cupres=buscavariablepago('01',$numcc);
								$sqlrd2="
								SELECT DISTINCT T3.beneficiario
								FROM humnominaretenemp T1,humretenempleados T2,humvariablesretenciones T3
								WHERE T1.id='$rowd[2]' AND T1.id=T2.id AND T2.id_retencion=T3.codigo";
								$respd2=mysql_query($sqlrd2,$linkbd);
								$rowd2 =mysql_fetch_row($respd2);
								$sqlry2="INSERT INTO hum_salarios_nom (id_list,id_nom,empleado,tercero,cc,cuentap,valorneto,valordevengado,fecha, periodopagoi,periodopagof,tipo_item,estado,tipo_mov) VALUES ('$idlist','$row[0]','$row[1]','$rowd2[0]','$numcc','$cupres','$rowd[0]','$rowd[0]','', '$perpagoi','$perpagof','DS','$rowd[1]','201')";
								$respy2=mysql_query($sqlry2,$linkbd);
								$rowy2=mysql_fetch_row($respy2);
							}
						}
	  				}
				}
			?>
			</div>
		</form>
	</body>
</html>