<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	header("Content-Type: text/html;charset=utf-8");
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Gesti&oacute;n Humana</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="css/calendario.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
        <script>
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden") {document.getElementById('ventanam').src="";}
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
					}
				}
			}
			function despliegamodal2(_valor,_num)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else 
				{
					switch(_num)
					{
						case '1':	document.getElementById('ventana2').src="cargafuncionarios-ventana01.php?objeto=funcionarios01";break;
						case '2':	document.getElementById('ventana2').src="cargafuncionarios-ventana01.php?objeto=funcionarios02";break;
					}
				}
			}
			function fagregar()
			{
				if(document.getElementById('periodo').value!="-1")
				{
					id=document.getElementById('variablepago').value;
					switch(id)
					{
						case '01':	document.getElementById('tipo01').value="S";break;
						case '02':	document.getElementById('tipo02').value="S";break;
					}
					document.form2.submit();
				}
				else
				{despliegamodalm('visible','2','Se debe seleccionar un mes para trabajar');}
			}
			function fguardar()
			{
					if (document.form2.tipo01.value=='S' )
					{
						despliegamodalm('visible','4','Esta Seguro de Guardar','1');
					}
					else{despliegamodalm('visible','2','Faltan datos para completar la incapacidad');}
				
			}
			function funcionmensaje(){/*document.location.href = "";*/}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":
						document.form2.oculto.value="2";
						document.form2.submit();
						break;
				}
			}
			function validadias(dlimite,ddigitado,pos)
			{
				valord=document.getElementsByName('diast[]').item(pos).value;
				if(valord > dlimite)
				{
					despliegamodalm('visible','2','Los dias trabajados no pueden ser mayor a '+ dlimite)
					document.getElementsByName('diast[]').item(pos).value=ddigitado;
				}
				
			}
		</script>
		<?php titlepag();?>
    </head>
    <body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("hum");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("hum");?></tr>
        	<tr>
          		<td colspan="3" class="cinta"><img src="imagenes/add2.png" class="mgbt1"/><img src="imagenes/guarda.png" title="Guardar" onClick="fguardar()" class="mgbt"/><img src="imagenes/busca.png" title="Buscar" onClick="location.href='hum-prepararnominabuscar.php'" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="<?php echo paginasnuevas("hum");?>" class="mgbt"><img src='imagenes/iratras.png' title='Men&uacute; Nomina' class='mgbt' onClick="location.href='hum-menunomina.php'"/></td>
        	</tr>
        </table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
 		<form name="form2" method="post" action="">
        	<?php
				if ($_POST[oculto] =="")
				{
					$_POST[tipo01]=$_POST[tipo02]=$_POST[tipo03]=$_POST[tipo04]=$_POST[tipo05]=$_POST[tipo06]=$_POST[tipo07]=$_POST[tipo08]=$_POST[tipo09]=$_POST[tipo10]=$_POST[tipo11]=$_POST[tipo12]=$_POST[tipo13]=$_POST[tipo14]=$_POST[tipo15]="N";
					$_POST[funcionarios01]="";
					$_POST[vigencia]=vigencia_usuarios($_SESSION[cedulausu]);
					$_POST[idcomp]=selconsecutivo('hum_prenomina','codigo');
					$_POST[fecha]=date('d/m/Y');
				}
				$vtipo['01']=$_POST[tipo01];
				$vtipo['02']=$_POST[tipo02];
				$vtipo['03']=$_POST[tipo03];
				$vtipo['04']=$_POST[tipo04];
				$vtipo['05']=$_POST[tipo05];
				$vtipo['06']=$_POST[tipo06];
				$vtipo['07']=$_POST[tipo07];
				$vtipo['08']=$_POST[tipo08];
				$vtipo['09']=$_POST[tipo09];
				$vtipo['10']=$_POST[tipo10];
				$vtipo['11']=$_POST[tipo11];
				$vtipo['12']=$_POST[tipo12];
				$vtipo['13']=$_POST[tipo13];
				$vtipo['14']=$_POST[tipo14];
				$vtipo['15']=$_POST[tipo15];
			?>
    		<table class="inicio">
      			<tr>
        			<td class="titulos" colspan="8">.: Preparar Nomina</td>
                    <td class="cerrar" style="width:7%" onClick="location.href='hum-principal.php'">Cerrar</td>
      			</tr>
                <tr>
                	<td class="saludo1" style="width:3cm;">No Preliquidaci&oacute;n:</td>
                    <td style="width:10%;"><input type="text" id="idcomp" name="idcomp" value="<?php echo $_POST[idcomp]?>" style="width:95%;" readonly></td>
                   	<td class="saludo1" style="width:2.5cm;">Fecha:</td>
                    <td style="width:15%;"><input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" style="width:80%;">&nbsp;<img src="imagenes/calendario04.png" class="icobut" onClick="displayCalendarFor('fc_1198971545');" title="Calendario"/></td>
                    <td class="saludo1" style="width:2.5cm;">Vigencia:</td> 
                    <td style="width:10%;"><input name="vigencia" type="text" value="<?php echo $_POST[vigencia]?>" style="width:80%;" readonly></td>
                    <td class="saludo1" style="width:2.5cm;">Mes:</td>
          			<td>
                    	<select name="periodo" id="periodo" onChange="validar()">
				  			<option value="-1">Seleccione ....</option>
							<?php
					 			$sqlr="Select * from meses where estado='S' ";
		 						$resp = mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp)) 
								{
									if($row[0]==$_POST[periodo])
			 						{
				 						echo "<option value='$row[0]' SELECTED>$row[1]</option>";
				 						$_POST[periodonom]=$row[1];
				 						$_POST[periodonom]=$row[2];
				 					}
									else {echo "<option value='$row[0]'>$row[1]</option>";}
			     				}   
							?>
		  				</select>
                 	</td>
	    		</tr>
                <tr>
               		<td class="saludo1" >Tipo de Pago:</td>
                	<td colspan="3">
                    	<select name="variablepago" id="variablepago" onChange="validar()" style="width:100%; height:30px">
				  			<option value="-1">Seleccione ....</option>
							<?php
					 			$sqlr="SELECT codigo,nombre FROM humvariables WHERE estado='S'";
		 						$resp = mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp)) 
								{
									if($row[0]==$_POST[variablepago])
									{
										if($vtipo[$row[0]]=="N"){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
									}
									else 
									{
										if($vtipo[$row[0]]=="N"){echo "<option value='$row[0]' >$row[0] - $row[1]</option>";}
									}
			     				}   
							?>
		  				</select>
                       <td> <label class="boton02" onClick="fagregar()">&nbsp;&nbsp;Agregar&nbsp;&nbsp;</label></td>
                    </td>
                </tr>
    		</table>
            <input type="hidden" name="oculto" id="oculto" value="0"/>
            <input type="hidden" name="tipo01" id="tipo01" value="<?php echo $_POST[tipo01];?>"/>
            <input type="hidden" name="tipo02" id="tipo02" value="<?php echo $_POST[tipo02];?>"/>
            <input type="hidden" name="tipo03" id="tipo03" value="<?php echo $_POST[tipo03];?>"/>
            <input type="hidden" name="tipo04" id="tipo04" value="<?php echo $_POST[tipo04];?>"/>
            <input type="hidden" name="tipo05" id="tipo05" value="<?php echo $_POST[tipo05];?>"/>
            <input type="hidden" name="tipo06" id="tipo06" value="<?php echo $_POST[tipo06];?>"/>
            <input type="hidden" name="tipo07" id="tipo07" value="<?php echo $_POST[tipo07];?>"/>
            <input type="hidden" name="tipo08" id="tipo08" value="<?php echo $_POST[tipo08];?>"/>
            <input type="hidden" name="tipo09" id="tipo09" value="<?php echo $_POST[tipo09];?>"/>
            <input type="hidden" name="tipo10" id="tipo10" value="<?php echo $_POST[tipo10];?>"/>
            <input type="hidden" name="tipo11" id="tipo11" value="<?php echo $_POST[tipo11];?>"/>
            <input type="hidden" name="tipo12" id="tipo12" value="<?php echo $_POST[tipo12];?>"/>
            <input type="hidden" name="tipo13" id="tipo13" value="<?php echo $_POST[tipo13];?>"/>
            <input type="hidden" name="tipo14" id="tipo14" value="<?php echo $_POST[tipo14];?>"/>
            <input type="hidden" name="tipo15" id="tipo15" value="<?php echo $_POST[tipo15];?>"/>
            <input type='hidden' name='funcionarios01' id="funcionarios01" value="<?php echo $_POST[funcionarios01];?>"/>
            <input type='hidden' name='funcionarios02' id="funcionarios02" value="<?php echo $_POST[funcionarios02];?>"/>
            <div class="subpantalla" style="height:64.5%; width:99.6%;overflow-x:hidden" >
            	<?php
					if ($_POST[tipo01]=="S")
					{	
						echo"
						<table class='inicio'>
							<tr>
        						<td class='titulos' colspan='2'>.: SUELDO PERSONAL DE NOMINA</td>
								<td class='bagregar' style='width:5%' onClick=\"despliegamodal2('visible','1');\" title='Lista de Funcionarios'>Agregar</td>
      						</tr>
						</table>
						<div class='subpantalla1' style='height:45%; width:99.6%;overflow-x:hidden'>
							<table class='inicio' align='center'>
								<tr>
									<td class='titulos2' style='width:5%'>ID</td>
									<td class='titulos2' style='width:8%'>DOCUMENTO</td>
									<td class='titulos2' >NOMBRE</td>
									<td class='titulos2'>CARGO</td>
									<td class='titulos2' style='width:18%'>CENTRO DE COSTO</td>
									<td class='titulos2' style='width:7%'>PERIDO</td>
									<td class='titulos2' style='width:10%'>VALOR</td>
									<td class='titulos2' style='width:5%'>DIAS</td>
									<td class='titulos2' style='width:5%'>DIAS INC</td>
									<td class='titulos2' style='width:5%'>DIAS VAC</td>
									<td class='titulos2' style='width:5%;text-align:center;'>ELIMINAR</td>
								</tr>";
						if($_POST[funcionarios01]!="")
						{
							$codfun = explode('<->', $_POST[funcionarios01]);
							$iter='saludo1a';
							$iter2='saludo2';
							for($x=0;$x<count($codfun);$x++)
							{
								$sqlr="
								SELECT codfun, 
								GROUP_CONCAT(descripcion ORDER BY CONVERT(valor, SIGNED INTEGER) SEPARATOR '<->')
								FROM hum_funcionarios
								WHERE codfun='$codfun[$x]' AND estado='S'
								GROUP BY codfun";
								$resp = mysql_query($sqlr,$linkbd);
								$row =mysql_fetch_row($resp);
								$datos = explode('<->', $row[1]);
								$sqlric="SELECT SUM(dias_inca) FROM hum_incapacidades_det WHERE doc_funcionario='$datos[5]' AND mes='$_POST[periodo]' AND vigencia='$_POST[vigencia]'";
								$respic = mysql_query($sqlric,$linkbd);
								$rowic =mysql_fetch_row($respic);
								$diasinca=$rowic[0];
								if($diasinca==""){$diasinca=0;}
								$sqlrvc="SELECT SUM(dias_vaca) FROM hum_vacaciones_det WHERE doc_funcionario='$datos[5]' AND mes='$_POST[periodo]' AND vigencia='$_POST[vigencia]'";
								$respvc = mysql_query($sqlrvc,$linkbd);
								$rowvc =mysql_fetch_row($respvc);
								$diasvaca=$rowvc[0];
								if($diasvaca==""){$diasvaca=0;}
								$diasnovedad=$diasinca+$diasvaca;
								$diasla=30-$diasnovedad;
								if($datos[23]==30){$verper="MENSUAL";}							
								else {$verper="QUINCENAL";}
								$diastr=$datos[23]-$diasnovedad;
								$sqlrtp="SELECT tipoemprse FROM hum_terceros_emprse WHERE numdocumento='$datos[17]' AND estado='S'";
								$resptp = mysql_query($sqlrtp,$linkbd);
								$rowtp =mysql_fetch_row($resptp);
								$pensionestipo=$rowtp[0];
								if($_POST[diast][$x]=='')
								{$_POST[diast][$x]=$diasla;}
								echo "
								<input type='hidden' name='codigofun[]' value='$row[0]'/>
								<input type='hidden' name='cargofun[]' value='$datos[0]'/>
								<input type='hidden' name='salarifun[]' value='$datos[4]'/>
								<input type='hidden' name='documefun[]' value='$datos[5]'/>
								<input type='hidden' name='nombrefun[]' value='$datos[6]'/>
								<input type='hidden' name='doceps[]' value='$datos[13]'/>
								<input type='hidden' name='docarl[]' value='$datos[15]'/>
								<input type='hidden' name='docafp[]' value='$datos[17]'/>
								<input type='hidden' name='docfdc[]' value='$datos[19]'/>
								<input type='hidden' name='ccfun[]' value='$datos[21]'/>
								<input type='hidden' name='perliq[]' value='$datos[23]'/>
								<input type='hidden' name='diasi[]' value='$diasinca'/>
								<input type='hidden' name='diasv[]' value='$diasvaca'/>
								<input type='hidden' name='fondopensionestipo[]' value='$pensionestipo'/>
								<input type='hidden' name='pcesantias[]' value='$datos[24]'/>
								<tr class='$iter' style='text-transform:uppercase'>
									<td style='text-align:right;'>$row[0]&nbsp;</td>
									<td style='text-align:right;'>".number_format($datos[5],0)."&nbsp;</td>
									<td>$datos[6]</td>
									<td>$datos[1]</td>
									<td>$datos[21] - $datos[22]</td>
									<td>$verper</td>
									<td style='text-align:right;'>$ ".number_format($datos[4],0)."&nbsp;</td>
									<td style='text-align:right;'><input type='text' name='diast[]' value='".$_POST[diast][$x]."' style='text-align:right; width:100%' class='inpnovisibles' onChange=\"validadias($diasla,'".$_POST[diast][$x]."',$x)\";/></td>
									<td style='text-align:right;'>$diasinca&nbsp;</td>
									<td style='text-align:right;'>$diasvaca&nbsp;</td>
								</tr>";
								$aux=$iter;
								$iter=$iter2;
								$iter2=$aux;
							}
						}	
						echo"</table>
						</div>
						";
					}
					if ($_POST[tipo02]=="S")
					{
						echo"
						<table class='inicio'>
							<tr>
        						<td class='titulos' colspan='2'>.: PRIMA DE NAVIDAD</td>
								<td class='bagregar' style='width:5%' onClick=\"despliegamodal2('visible','2');\" title='Lista de Funcionarios'>Agregar</td>
      						</tr>
						</table>
						<div class='subpantalla1' style='height:45%; width:99.6%;overflow-x:hidden'>
							<table class='inicio' align='center'>
								<tr>
									<td class='titulos2' style='width:5%'>ID</td>
									<td class='titulos2' style='width:8%'>DOCUMENTO</td>
									<td class='titulos2' style='width:23%'>NOMBRE</td>
									<td class='titulos2'>CARGO</td>
									<td class='titulos2' style='width:18%'>CENTRO DE COSTO</td>
									<td class='titulos2' style='width:10%'>VALOR</td>
									<td class='titulos2' style='width:5%;text-align:center;'>ELIMINAR</td>
								</tr>";
						if($_POST[funcionarios02]!="")
						{
							$codfun = explode('<->', $_POST[funcionarios02]);
							$iter='saludo1a';
							$iter2='saludo2';
							for($x=0;$x<count($codfun);$x++)
							{
								$sqlr="
								SELECT codfun, 
								GROUP_CONCAT(descripcion ORDER BY CONVERT(valor, SIGNED INTEGER) SEPARATOR '<->')
								FROM hum_funcionarios
								WHERE (item = 'NOMCARGO' OR item = 'DOCTERCERO' OR item = 'NOMTERCERO' OR item = 'NOMCC' OR item = 'VALESCALA') AND codfun='$codfun[$x]' AND estado='S'
								GROUP BY codfun";
								$resp = mysql_query($sqlr,$linkbd);
								$row =mysql_fetch_row($resp);
								$datos = explode('<->', $row[1]);
								echo "
								<tr class='$iter' style='text-transform:uppercase'>
									<td>$row[0]</td>
									<td>$datos[2]</td>
									<td>$datos[3]</td>
									<td>$datos[0]</td>
									<td>$datos[4]</td>
									<td style='text-align:right;'>$ ".number_format($datos[1],0)."</td>
									<td></td>
								</tr>";
								$aux=$iter;
								$iter=$iter2;
								$iter2=$aux;
							}
						}	
						echo"</table>
						</div>
						";						
					}
					//////////////////////////////////////////////////////////////////////////////////////////////////
					if ($_POST[oculto] =="2")
					{
						if ($_POST[tipo01]=="S")
						{
							$consec=selconsecutivo('hum_prenomina','codigo');
							ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
							$fechap="$fecha[3]-$fecha[2]-$fecha[1]";
							$sqlr="INSERT INTO hum_prenomina (codigo,fecha,mes,vigencia,estado) VALUES ('$consec','$fechap','$_POST[periodo]', '$_POST[vigencia]','S')";
							
							if (mysql_query($sqlr,$linkbd))
							{
								for ($x=0;$x<count($_POST[codigofun]);$x++)
								{
									$consdet=selconsecutivo('hum_prenomina_det','id_det');
		  							$sqlr="INSERT INTO hum_prenomina_det (id_det,codigo,mes,vigencia,codigofun,cargofun,salarifun,documefun, nombrefun,doceps,docarl,docafp,docfdc,ccfun,perliq,diast,diasi,diasv,fondopensionestipo,pcesantias,estado) VALUES ('$consdet','$consec', '$_POST[periodo]','$_POST[vigencia]','".$_POST[codigofun][$x]."','".$_POST[cargofun][$x]."','".$_POST[salarifun][$x]."','".$_POST[documefun][$x]."','".$_POST[nombrefun][$x]."','".$_POST[doceps][$x]."','".$_POST[docarl][$x]."','".$_POST[docafp][$x]."','".$_POST[docfdc][$x]."','".$_POST[ccfun][$x]."','".$_POST[perliq][$x]."','".$_POST[diast][$x]."','".$_POST[diasi][$x]."','".$_POST[diasv][$x]."','".$_POST[fondopensionestipo][$x]."','".$_POST[pcesantias][$x]."','S')";							
		  							mysql_query($sqlr,$linkbd);
								}
								$sqlr="SELECT codigo,nombre FROM humvariables WHERE estado='S'";
		 						$resp = mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp)) 
								{
									$constip=selconsecutivo('hum_prenomina_tipos','idtipo');
									$sqlr1="INSERT INTO hum_prenomina_tipos (idtipo,num_nomi,tipo_prenom,estado_tipo,estado) VALUES ('$constip', '$consec','$row[0]','".$vtipo[$row[0]]."','S')";
									$resp1 = mysql_query($sqlr1,$linkbd);
									mysql_fetch_row($resp1);
								}
								echo "<script>despliegamodalm('visible','1','La Preliquidación Almacenada Exitosamente');</script>";
							}
							else {echo"<script>despliegamodalm('visible','2','Error al crear la Preliquidación');</script>";}
						}
					}
            	?>
            </div>
		</form>
        <div id="bgventanamodal2">
			<div id="ventanamodal2">
				<IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"></IFRAME>
        	</div>
		</div>
	</body>
</html>