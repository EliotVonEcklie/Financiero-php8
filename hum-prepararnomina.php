<?php //V 1000 12/12/16 ?> 
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
							document.getElementById('ventanam').src="ventana-consulta2.php?titulos="+mensa+"&idresp="+pregunta;break;	
					}
				}
			}
			function despliegamodal2(_valor,_num,_funci)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else 
				{
					switch(_num)
					{
						case '1':	document.getElementById('ventana2').src="cargafuncionarios-ventana01.php?objeto=funcionarios01";break;
						case '2':	document.getElementById('ventana2').src="cargafuncionarios-ventana01.php?objeto="+_funci;break;
					}
				}
			}
			function fagregar()
			{
				if(document.getElementById('periodo').value!="-1")
				{
					var id=document.getElementById('variablepago').value;
					var combo = document.getElementById('variablepago');
					var actaa = document.getElementById('anauxalim').value;
					var actat = document.getElementById('anauxtrans').value;
					var nom = combo.options[combo.selectedIndex].text;
					if(id!=-1)
					{
						if(document.form2.tiponum.value=="")
						{
							document.form2.tiponum.value=id;
							document.form2.tiponom.value=nom;
							if(id=='01')
							{	
								if(actaa=='S')
								{
									document.form2.tiponum.value=document.form2.tiponum.value+"<->07";
									document.form2.tiponom.value=document.form2.tiponom.value+"<->"+combo.options[7].text;
								}
								if(actat=='S')
								{
									document.form2.tiponum.value=document.form2.tiponum.value+"<->08";
									document.form2.tiponom.value=document.form2.tiponom.value+"<->"+combo.options[8].text;
								}
							}
							document.form2.tpcheck.value=id;
							document.form2.submit();
						}
						else if(id!='01')
						{
							document.form2.tiponum.value=document.form2.tiponum.value+"<->"+id;
							document.form2.tiponom.value=document.form2.tiponom.value+"<->"+nom;
							document.form2.tpcheck.value=id;
							document.form2.submit();
						}
						else {despliegamodalm('visible','2','Los datos de personal de nomina deben ingresarse al inicio');}
						
						
					}
					else {despliegamodalm('visible','2','Seleccione un tipo de pago');}
				}
				else
				{despliegamodalm('visible','2','Se debe seleccionar un mes para trabajar');}
			}
			function fguardar()
			{
					if (document.form2.tipoacti.value=='S' ){despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
					else{despliegamodalm('visible','2','Faltan datos para poder guardar');}
			}
			function funcionmensaje()
			{
				var nid=document.form2.idcomp.value
				document.location.href = "hum-prepararnominaeditar.php?idpre="+nid;
			}
			
			function respuestaconsulta(estado,pregunta)
			{
				if(estado=="S")
				{
					switch(pregunta)
					{
						case "1":	document.form2.oculto.value="2";break;
						case "2":	break;
						case "3":	break;
					}
				}
				else
				{
					switch(pregunta)
					{
						case "1":	break;
						case "2":	document.getElementById('datodel01').value="";
									document.getElementById('datodel02').value="";
									document.getElementById('datodel03').value="";
									document.getElementById('datodel04').value="";break;
						case "3":	break;
					}
				}
				document.form2.submit();
			}
			function validadias(dlimite,ddigitado,pos)
			{
				var actaa = document.getElementById('anauxalim').value;
				var actat = document.getElementById('anauxtrans').value;
				valord=document.getElementsByName('diast[]').item(pos).value;
				devengado=document.getElementsByName('devengado[]').item(pos).value;
				if(valord > dlimite)
				{
					despliegamodalm('visible','2','Los dias trabajados no pueden ser mayor a '+ dlimite)
					document.getElementsByName('diast[]').item(pos).value=ddigitado;
				}
				else if((actaa =='S')||(actat=='S')){document.form2.submit();}
			}
			function feliminar(dato1,dato2,dato3,dato4,dato5)
			{
				document.getElementById('datodel01').value=dato1;
				document.getElementById('datodel02').value=dato2;
				document.getElementById('datodel03').value=dato3;
				document.getElementById('datodel04').value=dato4;
				despliegamodalm('visible','4','Esta Seguro Eliminar a '+dato5+' de la lista','2');
			}
			function cambiopes(pesta){document.form2.tpcheck.value=pesta;}
			function selprimas(idvalpri)
			{
				document.getElementsByName('valprima[]').item(idvalpri).select();
			}
			function validar(){document.form2.submit();}
			function cambiosema(nomvar,posvar)
			{
				var comvar=nomvar+'[]';
				var nomsem =document.getElementsByName(comvar).item(posvar);
				if(nomsem.value=='S'){nomsem.value='N';}
				else{nomsem.value='S';}
				document.form2.submit();
			}
			function valnumpre()
			{
				if(document.form2.idcomp.value < document.form2.idcomph.value)
				{
					document.form2.valnp.value=document.form2.idcomp.value;
					document.form2.submit();
				}
				else if(document.form2.idcomp.value != document.form2.idcomph.value)
				{
					despliegamodalm('visible','2','El numero de Preliquidacion esta fuera de rango');
					document.form2.idcomp.value = document.form2.idcomph.value;
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
          		<td colspan="3" class="cinta"><img src="imagenes/add.png" class="mgbt1"  title="Nuevo" onClick="location.href='hum-prepararnomina.php'"/><img src="imagenes/guarda.png" title="Guardar" onClick="fguardar()" class="mgbt"/><img src="imagenes/busca.png" title="Buscar" onClick="location.href='hum-prepararnominabuscar.php'" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="<?php echo paginasnuevas("hum");?>" class="mgbt"><img src='imagenes/iratras.png' title='Men&uacute; Nomina' class='mgbt' onClick="location.href='hum-menunomina.php'"/></td>
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
					$_POST[tiponum]=$_POST[tiponom]=$_POST[tpcheck]="";
					$_POST[tipoacti]="N";
					$_POST[funcionarios01]="";
					$_POST[idcomp]=selconsecutivo('hum_prenomina','codigo');
					$_POST[idcomph]=$_POST[idcomp];
					$_POST[fecha]=date('d/m/Y');
					$_POST[datodel01]=$_POST[datodel02]=$_POST[datodel03]=$_POST[datodel04]="";
					//carga parametros admfiscales
					$sqlr="SELECT transporte,alimentacion,balimentacion,btransporte,anauxalim,anauxtrans FROM admfiscales WHERE vigencia='$_POST[vigencia]'";
					$resp = mysql_query($sqlr,$linkbd);
					$row =mysql_fetch_row($resp);
					$_POST[transp]=$row[0];
					$_POST[alim]=$row[1];
					$_POST[balim]=$row[2];
					$_POST[btrans]=$row[3];
					$_POST[anauxalim]=$row[4];
					$_POST[anauxtrans]=$row[5];
					$_POST[valnp]=0;
				}
				$vtiponum=array();
				$vtiponum = explode('<->', $_POST[tiponum]);
				$vtiponom = explode('<->', $_POST[tiponom]);
				
				
				if($_POST[datodel01]!="")
				{
					switch($_POST[datodel01])
					{
						case 1:	if($_POST[datodel03]==1){$_POST[funcionarios01]="";}
								else
								{
									if($_POST[datodel04]==0){$idbusca=":".$_POST[datodel02].':<->';$_POST[funcionarios01]=str_replace($idbusca,"",$_POST[funcionarios01]);}
									else {$idbusca='<->:'.$_POST[datodel02].":";$_POST[funcionarios01]=str_replace($idbusca,"",$_POST[funcionarios01]);}
								}break;
						case 2:	if($_POST[datodel03]==1){$_POST[funcionarios02]="";}
								else
								{
									if($_POST[datodel04]==0){$idbusca=":".$_POST[datodel02].':<->';$_POST[funcionarios02]=str_replace($idbusca,"",$_POST[funcionarios02]);}
									else {$idbusca='<->:'.$_POST[datodel02].":";$_POST[funcionarios02]=str_replace($idbusca,"",$_POST[funcionarios02]);}
								}break;
					}
					$_POST[datodel01]=$_POST[datodel02]=$_POST[datodel03]=$_POST[datodel04]="";
				}
				if($_POST[valnp]!=0)
				{
					$sqlr="SELECT num_liq FROM hum_prenomina WHERE codigo='$_POST[idcomp]'";
					$resp = mysql_query($sqlr,$linkbd);
					$row =mysql_fetch_row($resp);echo $row[0];
					if ($row[0]==0)
					{
						echo"
							despliegamodalm('visible','2','El numero de Preliquidacion ya tiene nomina asignada');
							document.form2.idcomp.value = document.form2.idcomph.value;
							document.form2.valnp.value=0;";
					}
					$_POST[valnp]=0;
				}
			?>
			<!-- Variables parametros admfiscales --> 
			<input type="hidden" id="balim" name="balim"  value="<?php echo $_POST[balim];?>"/>
			<input type="hidden" id="alim" name="alim" value="<?php echo $_POST[alim];?>"/>
			<input type="hidden" id="btrans" name="btrans" value="<?php echo $_POST[btrans];?>"/>
			<input type="hidden" id="transp" name="transp"  value="<?php echo $_POST[transp];?>"/>
            <input type="hidden" id="anauxalim" name="anauxalim"  value="<?php echo $_POST[anauxalim];?>"/>
            <input type="hidden" id="anauxtrans" name="anauxtrans"  value="<?php echo $_POST[anauxtrans];?>"/>
			<input type="hidden" id="valnp" name="valnp"  value="<?php echo $_POST[valnp];?>"/>
    		<table class="inicio">
      			<tr>
        			<td class="titulos" colspan="10">.: Preparar Preliquidaci&oacute;n</td>
                    <td class="cerrar" style="width:7%" onClick="location.href='hum-principal.php'">Cerrar</td>
      			</tr>
                <tr>
                	<td class="saludo1" style="width:3cm;">No Preliquidaci&oacute;n:</td>
                    <td style="width:10%;"><input type="text" id="idcomp" name="idcomp" value="<?php echo $_POST[idcomp]?>" style="width:95%;" onChange="valnumpre();"/></td>
					<input type="hidden" id="idcomph" name="idcomph" value="<?php echo $_POST[idcomph]?>"/>
                   	<td class="saludo1" style="width:2cm;">Fecha:</td>
                    <td style="width:15%;"><input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" style="width:80%;">&nbsp;<img src="imagenes/calendario04.png" class="icobut" onClick="displayCalendarFor('fc_1198971545');" title="Calendario"/></td>
					<td class="saludo1" style="width:2cm;">Novedades:</td>
					<td>
                    	<select name="novepagos" id="novepagos" onChange="document.form2.submit();">
							<option value="-1">Seleccione ....</option>
							<?php
								$sqlr="SELECT codigo,mes,vigencia FROM hum_novedadespagos WHERE codpre=0 GROUP BY codigo";
								$resp = mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp)) 
								{
									$mesle=mesletras($row[1]);
									if($row[0]==$_POST[novepagos])
			 						{
				 						echo "<option value='$row[0]' SELECTED>$row[0] - $mesle $row[2]</option>";
										$_POST[periodo]=$row[1];
										$_POST[vigencia]=$row[2];
				 					}
									else {echo "<option value='$row[0]'>$row[0] - $mesle $row[2]</option>";}
			     				}   
							?>
						</select>
					</td>
	    		</tr>
    		</table>
            <input type="hidden" name="oculto" id="oculto" value="0"/>
			<input type="hidden" name="vigencia" id="vigencia" value="<?php echo $_POST[vigencia]?>"/>
			<input type="hidden" name="periodo" id="periodo" value="<?php echo $_POST[periodo];?>"/>
            <input type="hidden" name="tiponum" id="tiponum" value="<?php echo $_POST[tiponum];?>"/>
            <input type="hidden" name="tiponom" id="tiponom" value="<?php echo $_POST[tiponom];?>"/>
            <input type="hidden" name="tipoacti" id="tipoacti" value="<?php echo $_POST[tipoacti];?>"/>
            <input type="hidden" name="tpcheck" id="tpcheck" value="<?php echo $_POST[tpcheck];?>"/>
            <input type='hidden' name='datodel01' id="datodel01" value="<?php echo $_POST[datodel01];?>"/>
            <input type='hidden' name='datodel02' id="datodel02" value="<?php echo $_POST[datodel02];?>"/>
            <input type='hidden' name='datodel03' id="datodel03" value="<?php echo $_POST[datodel03];?>"/>
            <input type='hidden' name='datodel04' id="datodel04" value="<?php echo $_POST[datodel04];?>"/>
			<?php
				if($_POST[novepagos]!="-1")
				{
					$sqlr="SELECT tipo FROM hum_novedadespagos WHERE codigo='$_POST[novepagos]' GROUP BY tipo ORDER BY tipo";
					$resp = mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($resp)) 
					{
						$tiposc[]=$row[0];
						$vtiponum[]=$row[0];
					}
				}
			?>
		   
            <div class="tabscontra" style="height:60%; width:99.6%;"> 
            	<?php 
					for($xtipos=0;$xtipos<count($vtiponum);$xtipos++)
					{ 
						if ($vtiponum[$xtipos]=="01")
						{	
							$_POST[tipoacti]='S';
							if(($_POST[tpcheck]==$vtiponum[$xtipos])){$vcheck='checked';}
							else {$vcheck='';}
							$nomtitulo=buscavariblespagonomina($vtiponum[$xtipos]);
							$vtab="tab-$vtiponum[$xtipos]";
							$nomv="funcionarios".$vtiponum[$xtipos];
							echo"
							<input type='hidden' name='$nomv' id='$nomv' value='$_POST[$nomv]'/>
							<script>document.form2.tipoacti.value='S'</script>
							<div class='tab'>
								<input type='radio' id='$vtab' name='tabgroup1' value='1' $vcheck  onClick=\"cambiopes('$vtiponum[$xtipos]');\"/>
								<label for='$vtab'>$nomtitulo</label>
								<div class='content' style='overflow:hidden'>
									<table class='inicio' >
										<tr><td class='titulos' colspan='2'>.: SUELDO PERSONAL DE NOMINA</td></tr>
									</table>
									<div class='subpantalla1' style='height:90%; width:99.6%;overflow-x:hidden'>
										<table class='inicio' align='center'>
											<tr style='text-align:center;'>
												<td class='titulos2' style='width:3%'>ID</td>
												<td class='titulos2' style='width:6%'>DOCUMENTO</td>
												<td class='titulos2' >NOMBRE</td>
												<td class='titulos2'>CARGO</td>
												<td class='titulos2' style='width:18%'>CENTRO DE COSTO</td>
												<td class='titulos2' style='width:6%'>PERIDO</td>
												<td class='titulos2' style='width:7%'>SALARIO BASICO</td>
												<td class='titulos2' style='width:3%'>DIAS</td>
												<td class='titulos2' style='width:3%'>DIAS INC</td>
												<td class='titulos2' style='width:3%'>DIAS VAC</td>
												<td class='titulos2' style='width:7%'>DEVENGADO</td>
												<td class='titulos2' style='width:5%'>PAGO SALARIO</td>
												<td class='titulos2' style='width:5%'>PAGO SALUD</td>
												<td class='titulos2' style='width:5%'>PAGO PENSION</td>
												<td class='titulos2' style='width:5%'>PAGO ARL</td>
												<td class='titulos2' style='width:5%'>PAGO PARAFIS.</td>
												<td class='titulos2' style='width:5%'>RETIRO</td>
											</tr>";
							//if($_POST[funcionarios01]!="")
							{
								$iter='saludo1b';
								$iter2='saludo2b';
								$x=0;
								$sqlrf="SELECT idfun,documento,mes,vigencia,dias FROM hum_novedadespagos WHERE codigo='$_POST[novepagos]' AND tipo='$vtiponum[$xtipos]' ORDER BY id";
								$respf = mysql_query($sqlrf,$linkbd);
								while ($rowf =mysql_fetch_row($respf)) 
								{
									$sqlr="
									SELECT codfun, 
									GROUP_CONCAT(descripcion ORDER BY CONVERT(valor, SIGNED INTEGER) SEPARATOR '<->')
									FROM hum_funcionarios
									WHERE codfun='$rowf[0]' AND estado='S'
									GROUP BY codfun";
									$resp = mysql_query($sqlr,$linkbd);
									$row =mysql_fetch_row($resp);
									$datos = explode('<->', $row[1]);
									$sqlric="SELECT SUM(dias_inca) FROM hum_incapacidades_det WHERE doc_funcionario='$rowf[1]' AND mes='$rowf[2]' AND vigencia='$rowf[3]' AND estado='S'";
									$respic = mysql_query($sqlric,$linkbd);
									$rowic =mysql_fetch_row($respic);
									$diasinca=$rowic[0];
									if($diasinca==""){$diasinca=0;}
									$sqlrvc="SELECT SUM(dias_vaca) FROM hum_vacaciones_det WHERE doc_funcionario='$rowf[1]' AND mes='$rowf[2]' AND vigencia='$rowf[3]' AND estado='S'";
									$respvc = mysql_query($sqlrvc,$linkbd);
									$rowvc =mysql_fetch_row($respvc);
									$diasvaca=$rowvc[0];
									if($diasvaca==""){$diasvaca=0;}
									$diasnovedad=$diasinca+$diasvaca;
									$diasla=$rowf[4]-$diasnovedad;
									if($datos[23]==30){$verper="MENSUAL";}							
									else {$verper="QUINCENAL";}
									$diastr=$datos[23]-$diasnovedad;
									$sqlrtp="SELECT tipoemprse FROM hum_terceros_emprse WHERE numdocumento='$datos[17]' AND estado='S'";
									$resptp = mysql_query($sqlrtp,$linkbd);
									$rowtp =mysql_fetch_row($resptp);
									$pensionestipo=$rowtp[0];
									if($_POST[diast][$x]==''){$_POST[diast][$x]=$diasla;}
									if($_POST[devengado][$x]==''){$_POST[devengado][$x]=round(($datos[4]/30)*$_POST[diast][$x],0);}
									if ($_POST[psal01][$x]=="")
									{
										$_POST[psal01][$x]='S';
										$_POST[peps01][$x]=buscasipagaparafiscales('01','psalud');
										$_POST[ppen01][$x]=buscasipagaparafiscales('01','ppension');
										$_POST[parl01][$x]=buscasipagaparafiscales('01','parl');
										$_POST[ppar01][$x]=buscasipagaparafiscales('01','pparafiscal');
										$_POST[retiro01][$x]='N';
									}
									
									if($_POST[psal01][$x]=='S'){$imgsema="src='imagenes/sema_verdeON.jpg' title=' Si Pagar'";}
									else{$imgsema="src='imagenes/sema_rojoON.jpg' title='No Pagar'";}
									if($_POST[peps01][$x]=='S'){$imgsemb="src='imagenes/sema_verdeON.jpg' title=' Si Pagar'";}
									else{$imgsemb="src='imagenes/sema_rojoON.jpg' title='No Pagar'";}
									if($_POST[ppen01][$x]=='S'){$imgsemc="src='imagenes/sema_verdeON.jpg' title=' Si Pagar'";}
									else{$imgsemc="src='imagenes/sema_rojoON.jpg' title='No Pagar'";}
									if($_POST[parl01][$x]=='S'){$imgsemd="src='imagenes/sema_verdeON.jpg' title=' Si Pagar'";}
									else{$imgsemd="src='imagenes/sema_rojoON.jpg' title='No Pagar'";}
									if($_POST[ppar01][$x]=='S'){$imgseme="src='imagenes/sema_verdeON.jpg' title=' Si Pagar'";}
									else{$imgseme="src='imagenes/sema_rojoON.jpg' title='No Pagar'";}
									if($_POST[retiro01][$x]=='S'){$imgsemf="src='imagenes/sema_verdeON.jpg' title=' Paga días asignados'";}
									else{$imgsemf="src='imagenes/sema_rojoON.jpg' title='Paga los 30 días'";}
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
											<input type='hidden' name='psal01[]' value='".$_POST[psal01][$x]."'/>
											<input type='hidden' name='peps01[]' value='".$_POST[peps01][$x]."'/>
											<input type='hidden' name='ppen01[]' value='".$_POST[ppen01][$x]."'/>
											<input type='hidden' name='parl01[]' value='".$_POST[parl01][$x]."'/>
											<input type='hidden' name='ppar01[]' value='".$_POST[ppar01][$x]."'/>
											<input type='hidden' name='retiro01[]' value='".$_POST[retiro01][$x]."'/>
											<tr class='$iter' style='text-transform:uppercase'>
												<td class='icoop' style='text-align:right;'>$row[0]&nbsp;</td>
												<td class='icoop' style='text-align:right;'>".number_format($datos[5],0)."&nbsp;</td>
												<td class='icoop'>$datos[6]</td>
												<td class='icoop'>$datos[1]</td>
												<td class='icoop'>$datos[21] - $datos[22]</td>
												<td class='icoop'>$verper</td>
												<td class='icoop' style='text-align:right;'>$ ".number_format($datos[4],0)."&nbsp;</td>
												<td class='icoop' style='text-align:right;'><input type='text' name='diast[]' value='".$_POST[diast][$x]."' style='text-align:right; width:100%;font-size:9px;' class='inpnovisibles' readonly/></td>
												<td class='icoop' style='text-align:right;'>$diasinca&nbsp;</td>
												<td class='icoop' style='text-align:right;'>$diasvaca&nbsp;</td>
												<td class='icoop' style='text-align:right;'><input type='text' name='devengado[]' value='".$_POST[devengado][$x]."' style='text-align:right; width:100%;font-size:9px;' class='inpnovisibles' readonly/></td>
												<td style='text-align:center;'><img class='icoop' $imgsema onClick=\"cambiosema('psal01','$x');\"/></td>
												<td style='text-align:center;'><img class='icoop' $imgsemb onClick=\"cambiosema('peps01','$x');\"/></td>
												<td style='text-align:center;'><img class='icoop' $imgsemc onClick=\"cambiosema('ppen01','$x');\"/></td>
												<td style='text-align:center;'><img class='icoop' $imgsemd onClick=\"cambiosema('parl01','$x');\"/></td>
												<td style='text-align:center;'><img class='icoop' $imgseme onClick=\"cambiosema('ppar01','$x');\"/></td>
												<td style='text-align:center;'><img class='icoop' $imgsemf onClick=\"cambiosema('retiro01','$x');\"/></td>
											</tr>";
									$aux=$iter;
									$iter=$iter2;
									$iter2=$aux;
									$x++;
								}
							}	
									echo"
										</table>
									</div>
								</div>
							</div>
							";
						}
						if ($vtiponum[$xtipos]!="01" && $vtiponum[$xtipos]!="")
						{
							$_POST[tipoacti]='S';
							if($_POST[tpcheck]==$vtiponum[$xtipos]){$vcheck='checked';}
							else {$vcheck='';}
							$nomtitulo=buscavariblespagonomina($vtiponum[$xtipos]);
							$vtab="tab-$vtiponum[$xtipos]";
							switch(true)
   							{
								case ($vtiponum[$xtipos]=='07') && ($_POST[anauxalim]=='S') && ($_POST[funcionarios01]!=""):	
									$nomv='funcionarios01';break;
								case ($vtiponum[$xtipos]=='08') && ($_POST[anauxtrans]=='S') && ($_POST[funcionarios01]!=""):	
									$nomv='funcionarios01';break;
								default: $nomv="funcionarios".$vtiponum[$xtipos];
							}
							echo"
							<input type='hidden' name='$nomv' id='$nomv' value='$_POST[$nomv]'/>
							<script>document.form2.tipoacti.value='S'</script>
							<div class='tab'>
								<input type='radio' id='$vtab' name='tabgroup1' value='2' $vcheck  onClick=\"cambiopes('$vtiponum[$xtipos]');\"/>
								<label for='$vtab'>$nomtitulo</label>
								<div class='content' style='overflow:hidden'>
									<table class='inicio'>
										<tr><td class='titulos' colspan='2'>.: $nomtitulo</td></tr>
									</table>
									<div class='subpantalla1' style='height:90%; width:99.6%;overflow-x:hidden'>
										<table class='inicio' align='center'>
											<tr style='text-align:center;'>
												<td class='titulos2' style='width:3%'>ID</td>
												<td class='titulos2' style='width:6%'>DOCUMENTO</td>
												<td class='titulos2' >NOMBRE</td>
												<td class='titulos2'>CARGO</td>
												<td class='titulos2' style='width:18%'>CENTRO DE COSTO</td>
												<td class='titulos2' style='width:7%'>SALARIO BASICO</td>
												<td class='titulos2' style='width:5%'>HORAS O DIAS</td>
												<td class='titulos2' style='width:7%'>VALOR ASIGNADO</td>
												<td class='titulos2' style='width:5%'>PAGO </td>
												<td class='titulos2' style='width:5%'>PAGO SALUD</td>
												<td class='titulos2' style='width:5%'>PAGO PENSION</td>
												<td class='titulos2' style='width:5%'>PAGO ARL</td>
												<td class='titulos2' style='width:5%'>PAGO PARAFIS.</td>
											</tr>";
							//if($_POST[$nomv]!="")
							{
								$x=0;
								$iter='saludo1b';
								$iter2='saludo2b';
								$sqlrf="SELECT idfun,documento,mes,vigencia,dias,valorb,valord FROM hum_novedadespagos WHERE codigo='$_POST[novepagos]' AND tipo='$vtiponum[$xtipos]' ORDER BY id";
								$respf = mysql_query($sqlrf,$linkbd);
								while ($rowf =mysql_fetch_row($respf)) 
								{
									$sqlr="
									SELECT codfun, 
									GROUP_CONCAT(descripcion ORDER BY CONVERT(valor, SIGNED INTEGER) SEPARATOR '<->')
									FROM hum_funcionarios
									WHERE (item = 'NOMCARGO' OR item = 'DOCTERCERO' OR item = 'NOMTERCERO' OR item = 'NOMCC' OR item = 'VALESCALA' OR item = 'NUMCC') AND codfun='$rowf[0]' AND estado='S'
									GROUP BY codfun";
									$resp = mysql_query($sqlr,$linkbd);
									$row =mysql_fetch_row($resp);
									$datos = explode('<->', $row[1]);
									$_POST["hordias".$vtiponum[$xtipos]][$x]=$rowf[4];
									$_POST["valasig".$vtiponum[$xtipos]][$x]=$rowf[6];
									if(($vtiponum[$xtipos]=='07') && ($_POST[anauxalim]=='S'))//calcular auxilio de alimentación
									{
										if($_POST["hordias".$vtiponum[$xtipos]][$x]=='')
										{$_POST["hordias".$vtiponum[$xtipos]][$x]=$_POST[diast][$x];}
										if($_POST["valasig".$vtiponum[$xtipos]][$x]=="")
										{
											if($datos[1]<=$_POST[balim])
											{
												$sqlrest="SELECT COUNT(*) FROM hum_restricciones WHERE documento='$rowf[1]' AND tipo_rest='AXAL' AND estado='S'";
												$resprest = mysql_query($sqlrest,$linkbd);
												$rowrest =mysql_fetch_row($resprest);
												if($rowrest[0]==0 || $rowrest[0]=='')
												{
													$_POST["valasig".$vtiponum[$xtipos]][$x]=round(($_POST[alim]/30)*$_POST["hordias".$vtiponum[$xtipos]][$x],0);
												}
												else {$_POST["valasig".$vtiponum[$xtipos]][$x]=0;}
											}
										}
									}
									if(($vtiponum[$xtipos]=='08') && ($_POST[anauxtrans]=='S'))//calcular auxilio de transporte
									{
										if($_POST["hordias".$vtiponum[$xtipos]][$x]=='')
										{$_POST["hordias".$vtiponum[$xtipos]][$x]=$_POST[diast][$x];}
										if($_POST["valasig".$vtiponum[$xtipos]][$x]=="")
										{
											if($datos[1]<=$_POST[btrans])
											{
												$_POST["valasig".$vtiponum[$xtipos]][$x]=round(($_POST[transp]/30)*$_POST["hordias".$vtiponum[$xtipos]][$x],0);
											} 
											else{$auxtra=0;}
										}
									}
									if($_POST["valasig".$vtiponum[$xtipos]][$x]==""){$_POST["valasig".$vtiponum[$xtipos]][$x]=0;}
									if ($_POST['psal'.$vtiponum[$xtipos]][$x]=="")
									{
										$_POST['psal'.$vtiponum[$xtipos]][$x]="S";
										$_POST['peps'.$vtiponum[$xtipos]][$x]=buscasipagaparafiscales($vtiponum[$xtipos],'psalud');
										$_POST['ppen'.$vtiponum[$xtipos]][$x]=buscasipagaparafiscales($vtiponum[$xtipos],'ppension');
										$_POST['parl'.$vtiponum[$xtipos]][$x]=buscasipagaparafiscales($vtiponum[$xtipos],'parl');
										$_POST['ppar'.$vtiponum[$xtipos]][$x]=buscasipagaparafiscales($vtiponum[$xtipos],'pparafiscal');
									}
									if($_POST['psal'.$vtiponum[$xtipos]][$x]=='S'){$imgsema="src='imagenes/sema_verdeON.jpg' title=' Si Pagar'";}
									else{$imgsema="src='imagenes/sema_rojoON.jpg' title='No Pagar'";}
									if($_POST['peps'.$vtiponum[$xtipos]][$x]=='S'){$imgsemb="src='imagenes/sema_verdeON.jpg' title=' Si Pagar'";}
									else{$imgsemb="src='imagenes/sema_rojoON.jpg' title='No Pagar'";}
									if($_POST['ppen'.$vtiponum[$xtipos]][$x]=='S'){$imgsemc="src='imagenes/sema_verdeON.jpg' title=' Si Pagar'";}
									else{$imgsemc="src='imagenes/sema_rojoON.jpg' title='No Pagar'";}
									if($_POST['parl'.$vtiponum[$xtipos]][$x]=='S'){$imgsemd="src='imagenes/sema_verdeON.jpg' title=' Si Pagar'";}
									else{$imgsemd="src='imagenes/sema_rojoON.jpg' title='No Pagar'";}
									if($_POST['ppar'.$vtiponum[$xtipos]][$x]=='S'){$imgseme="src='imagenes/sema_verdeON.jpg' title=' Si Pagar'";}
									else{$imgseme="src='imagenes/sema_rojoON.jpg' title='No Pagar'";}
									
									echo "	<input type='hidden' name='codigofun".$vtiponum[$xtipos]."[]' value='$row[0]'/>
											<input type='hidden' name='documefun".$vtiponum[$xtipos]."[]' value='$datos[2]'/>
											<input type='hidden' name='nombrefun".$vtiponum[$xtipos]."[]' value='$datos[3]'/>
											<input type='hidden' name='cargofun".$vtiponum[$xtipos]."[]' value='$datos[0]'/>
											<input type='hidden' name='ccfun".$vtiponum[$xtipos]."[]' value='$datos[4]'/>
											<input type='hidden' name='salarifun".$vtiponum[$xtipos]."[]' value='$datos[1]'/>
											<input type='hidden' name='psal".$vtiponum[$xtipos]."[]' value='".$_POST['psal'.$vtiponum[$xtipos]][$x]."'/>
											<input type='hidden' name='peps".$vtiponum[$xtipos]."[]' value='".$_POST['peps'.$vtiponum[$xtipos]][$x]."'/>
											<input type='hidden' name='ppen".$vtiponum[$xtipos]."[]' value='".$_POST['ppen'.$vtiponum[$xtipos]][$x]."'/>
											<input type='hidden' name='parl".$vtiponum[$xtipos]."[]' value='".$_POST['parl'.$vtiponum[$xtipos]][$x]."'/>
											<input type='hidden' name='ppar".$vtiponum[$xtipos]."[]' value='".$_POST['ppar'.$vtiponum[$xtipos]][$x]."'/>
											<tr class='$iter' style='text-transform:uppercase'>
												<td>$row[0]</td>
												<td>$datos[2]</td>
												<td>$datos[3]</td>
												<td>$datos[0]</td>
												<td>$datos[5]</td>
												<td style='text-align:right;'>$ ".number_format($rowf[5],0)."</td>
												<td style='text-align:right;'><input type='text' name='hordias".$vtiponum[$xtipos]."[]' value='".$_POST["hordias".$vtiponum[$xtipos]][$x]."' style='text-align:right; width:100%' class='inpnovisibles' readonly/></td>
												<td style='text-align:right;'><input type='text' name='valasig".$vtiponum[$xtipos]."[]' value='".$_POST["valasig".$vtiponum[$xtipos]][$x]."' style='text-align:right; width:100%' class='inpnovisibles' readonly/></td>
												<td style='text-align:center;'><img class='icoop' $imgsema onClick=\"cambiosema('psal$vtiponum[$xtipos]','$x');\"/></td>
												<td style='text-align:center;'><img class='icoop' $imgsemb onClick=\"cambiosema('peps$vtiponum[$xtipos]','$x');\"/></td>
												<td style='text-align:center;'><img class='icoop' $imgsemc onClick=\"cambiosema('ppen$vtiponum[$xtipos]','$x');\"/></td>
												<td style='text-align:center;'><img class='icoop' $imgsemd onClick=\"cambiosema('parl$vtiponum[$xtipos]','$x');\"/></td>
												<td style='text-align:center;'><img class='icoop' $imgseme onClick=\"cambiosema('ppar$vtiponum[$xtipos]','$x');\"/></td>
											</tr>";
									$aux=$iter;
									$iter=$iter2;
									$iter2=$aux;
									$x++;
								}
							}	
							echo"
										</table>
									</div>
								</div>
							</div>
							";						
						}
					}
					//////////////////////////////////////////////////////////////////////////////////////////////////
					if ($_POST[oculto] =="2")
					{
						$errores="";
						$numerror=0;
						$consec=selconsecutivo('hum_prenomina','codigo');
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
						$fechap="$fecha[3]-$fecha[2]-$fecha[1]";
						$sqlrg="INSERT INTO hum_prenomina (codigo,fecha,mes,vigencia,num_liq,tipo_mov,user,estado) VALUES ('$consec','$fechap','$_POST[periodo]', '$_POST[vigencia]','0','201','".$_SESSION["nickusu"]."','S')";
						if (mysql_query($sqlrg,$linkbd))
						{
							for($xtipos=0;$xtipos<count($vtiponum);$xtipos++)
							{
								if ($vtiponum[$xtipos]=="01")
								{
									for ($x=0;$x<count($_POST[codigofun]);$x++)
									{
										$consdet=selconsecutivo('hum_prenomina_det','id_det');
										$sqlr="INSERT INTO hum_prenomina_det (id_det,codigo,mes,vigencia,codigofun,cargofun,salarifun,documefun, nombrefun,doceps,docarl,docafp,docfdc,ccfun,perliq,diast,diasi,diasv,devengado,fondopensionestipo,pcesantias,tipo_mov,user,estado,psal,peps,ppen, 	parl,ppar,retiro) VALUES ('$consdet','$consec','$_POST[periodo]','$_POST[vigencia]','".$_POST[codigofun][$x]."','".$_POST[cargofun][$x]."','".$_POST[salarifun][$x]."','".$_POST[documefun][$x]."','".$_POST[nombrefun][$x]."','".$_POST[doceps][$x]."','".$_POST[docarl][$x]."','".$_POST[docafp][$x]."','".$_POST[docfdc][$x]."','".$_POST[ccfun][$x]."','".$_POST[perliq][$x]."','".$_POST[diast][$x]."','".$_POST[diasi][$x]."','".$_POST[diasv][$x]."','".$_POST[devengado][$x]."','".$_POST[fondopensionestipo][$x]."','".$_POST[pcesantias][$x]."','201','".$_SESSION["nickusu"]."','S','".$_POST[psal01][$x]."','".$_POST[peps01][$x]."','".$_POST[ppen01][$x]."','".$_POST[parl01][$x]."','".$_POST[ppar01][$x]."','".$_POST[retiro01][$x]."')";	
										if (!mysql_query($sqlr,$linkbd))
										{
											$numerror++;
											if($errores!=""){$errores+="<->T1:$numerror";}
											else{$errores+="T1:$numerror";}
										}
									}
								}
								if ($vtiponum[$xtipos]!="01" && $vtiponum[$xtipos]!="")
								{
									switch(true)
									{
										case ($vtiponum[$xtipos]=='07') && ($_POST[anauxalim]=='S') && ($_POST[funcionarios01]!=""):	
											$nomv='funcionarios01';break;
										case ($vtiponum[$xtipos]=='08') && ($_POST[anauxtrans]=='S') && ($_POST[funcionarios01]!=""):	
											$nomv='funcionarios01';break;
										default: $nomv="funcionarios".$vtiponum[$xtipos];
									}
									$x=0;
									$sqlrf="SELECT idfun,documento,mes,vigencia,dias,valorb,valord FROM hum_novedadespagos WHERE codigo='$_POST[novepagos]' AND tipo='$vtiponum[$xtipos]' ORDER BY id";
									$respf = mysql_query($sqlrf,$linkbd);
									while ($rowf =mysql_fetch_row($respf)) 
									{
										$consdet=selconsecutivo('hum_otrospagos','id_det');
										$codigofunxx="codigofun".$vtiponum[$xtipos];
										$salarifunxx="salarifun".$vtiponum[$xtipos];
										$documefunxx="documefun".$vtiponum[$xtipos];
										$nombrefunxx="nombrefun".$vtiponum[$xtipos];
										$ccfunxx="ccfun".$vtiponum[$xtipos];
										$valxx="valasig".$vtiponum[$xtipos];
										$vahodi="hordias".$vtiponum[$xtipos];
										$sqlr="INSERT INTO hum_otrospagos (id_det,codpre,codpag,mes,vigencia,codigofun,salarifun,documefun,nombrefun, ccfun,valpago,horasdias,tipo_mov,user,estado,psal,peps,ppen,parl,ppar) VALUES ('$consdet','$consec', '$vtiponum[$xtipos]','$_POST[periodo]', '$_POST[vigencia]','".$_POST[$codigofunxx][$x]."','".$_POST[$salarifunxx][$x]."','".$_POST[$documefunxx][$x]."','".$_POST[$nombrefunxx][$x]."','".$_POST[$ccfunxx][$x]."','".$_POST[$valxx][$x]."','".$_POST[$vahodi][$x]."','201','".$_SESSION["nickusu"]."','S','".$_POST['psal'.$vtiponum[$xtipos]][$x]."','".$_POST['peps'.$vtiponum[$xtipos]][$x]."','".$_POST['ppen'.$vtiponum[$xtipos]][$x]."','".$_POST['parl'.$vtiponum[$xtipos]][$x]."','".$_POST['ppar'.$vtiponum[$xtipos]][$x]."')";	
										if (!mysql_query($sqlr,$linkbd))
										{
											$numerror++;
											if($errores!=""){$errores+="<->T2:$numerror";}
											else{$errores+="T2:$numerror";}
										}
										$x++;
									}
								}
								if($numerror==0) {echo "<script>despliegamodalm('visible','1','La Preliquidación Almacenada Exitosamente');</script>";}
								else {echo"<script>despliegamodalm('visible','2','La Preliquidación Almacenada con $numerror errores');</script>";}
							}
						}
						else {echo"<script>despliegamodalm('visible','2','Error al crear la Preliquidación');</script>";}
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