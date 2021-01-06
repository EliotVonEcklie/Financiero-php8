<?php //V 1000 12/12/16 ?> 
<!--V 1.0 24/02/2015-->
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Activos Fijos</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
		<script type='text/javascript' src='JQuery/jquery-2.1.4.min.js'></script>
        <script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
		<script>
			function guardar()
			{
				var validacion01=document.getElementById('periodo').value;
				if((validacion01.trim()!='')){despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
				else {despliegamodalm('visible','2','Seleccione un MES para realizar la Depreciaci�n');}
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
			function funcionmensaje()
			{
				var idcodigo = parseFloat(document.form2.codigo.value);
				document.location.href = "acti-depreciaractivosvisualizar.php?iddepre="+idcodigo;
			}
			function respuestaconsulta(pregunta, variable)
			{
				switch(pregunta)
				{
					case "1":
						document.form2.oculto.value=2;
						document.form2.listar.value=3;
						document.form2.submit();						
						break;
				}
			}
			function validar(){document.form2.submit();}
			function buscaract()
			{
				document.form2.listar.value=2;
				document.form2.oculto.value=1;
				document.form2.submit();
			}
			function calcularact()
			{
				if($('#tabact >tbody >tr').length > 3)
				{
					document.form2.listar.value=3;
					document.form2.oculto.value=1;
					document.form2.submit();
				}
				else{
					despliegamodalm('visible','2','No Hay Activos para Calcular la Depreciaci�n');
				}
			}
			function iratras(){location.href="acti-gestiondelosactivos.php";}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("acti");</script><?php cuadro_titulos();?></tr>
			<tr><?php menu_desplegable("acti");?></tr>
			<tr>
				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='acti-depreciaractivos.php'" class="mgbt"/><img src="imagenes/guarda.png"  title="Guardar" onClick="guardar()" class="mgbt"/><img src="imagenes/busca.png"  title="Buscar" onClick="location.href='acti-depreciaractivosvisualizar.php'" class="mgbt"/><img src="imagenes/agenda1.png" title="Agenda" onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana"  onClick="mypop=window.open('acti-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/iratras.png" title="Atr�s" onclick="iratras()" class="mgbt">
				</td>
			</tr>
		</table>
		<?php
		$vigencia=vigencia_usuarios($_SESSION[cedulausu]);
		$linkbd=conectar_bd();
		$vs=" ";
		if(!$_POST[oculto])
		{
			$fec=date("d/m/Y");
			$_POST[fecha]=$fec; 	
			$_POST[vigencia]=$vigencia;
			$_POST[vigdep]=$vigencia;		 	  			 
			$_POST[valor]=0;	
			$vs=" style=visibility:visible";	
			$_POST[codigo]=selconsecutivo('actidepactivo_cab','id_dep');
		} 				  
		?>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
		<form name="form2" method="post" action=""> 
			<table class="inicio" align="center"  >
				<tr >
					<td class="titulos" colspan="10">.: Gestion de Activos - Depreciar</td>
					<td class="cerrar" style="width:7%" onClick="location.href='acti-principal.php'">Cerrar</td>
				</tr>
				<tr>
					<td class="saludo1" style="width:4%">Documento:</td>
					<td valign="middle" style="width:1%">
						<input name="codigo" type="text" id="codigo" value="<?php echo $_POST[codigo]; ?>" onKeyUp="return tabular(event,this)" readonly />         
					</td>
					<td class="saludo1" style="width:6%">Fecha:</td>
					<td valign="middle" style="width:8%">
						<input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" style="width:80%" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)" >         
						<a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>        <input type="hidden" name="chacuerdo" value="1">		  
					</td>        
					<td class="saludo1" style="width:3%">Clase:</td>
					<td style="width:10%">
						<select id="clasificacion" name="clasificacion" onChange="document.form2.submit()" style="width:100%">
							<option value="">...</option>
							<?php
							$link=conectar_bd();
							$sqlr="SELECT * from actipo where niveluno='0' and estado='S'";
							$resp = mysql_query($sqlr,$link);
							while ($row =mysql_fetch_row($resp)) 
							{
								echo "<option value=$row[0] ";
								$i=$row[0];
								if($i==$_POST[clasificacion])
								{
									echo "SELECTED";
								}
								echo ">".$row[0].' - '.strtoupper($row[1])."</option>";	  
							}
							?>
						</select>
					</td>    
					<td class="saludo1" style="width:3%">Grupo:</td>
					<td style="width:10%">
						<select id="grupo" name="grupo" onChange="document.form2.submit()" style="width:100%">
							<option value="">...</option>
							<?php
							$link=conectar_bd();
							$sqlr="SELECT * from actipo where niveluno='$_POST[clasificacion]' and estado='S'";
							$resp = mysql_query($sqlr,$link);
							while ($row=mysql_fetch_row($resp)) 
							{
								echo "<option value=$row[0] ";
								$i=$row[0];
								if($i==$_POST[grupo])
								{
									echo "SELECTED";
								}
								echo ">".$row[0].' - '.strtoupper($row[1])."</option>";	  
							}
							?>
						</select>
					</td>
					<td class="saludo1" style="width:3%">Tipo:</td>
					<td style="width:10%" colspan="2">
						<select id="tipo" name="tipo" onChange="document.form2.submit()" style="width:100%">
							<option value="">...</option>
							<?php
							$link=conectar_bd();
							$sqlr="SELECT * from actipo where niveluno='$_POST[grupo]' and niveldos='$_POST[clasificacion]' and estado='S'";
							$resp = mysql_query($sqlr,$link);
							while ($row =mysql_fetch_row($resp)) 
							{
								echo "<option value=$row[0] ";
								$i=$row[0];
								if($i==$_POST[tipo])
								{
									echo "SELECTED";
									$_POST[nombre] = $row[1];
								}
								echo ">".$row[0].' - '.strtoupper($row[1])."</option>";	  
							}
							?>
						</select>
						<input type="hidden" name="nombre" id="nombre" value="<?php echo $_POST[nombre]?>" onKeyUp="return tabular(event,this)"/>
					</td> 
				</tr>   
				<tr>
					<td class="saludo1">Mes:</td>
					<td>
						<select name="periodo" id="periodo" onChange="validar()"  >
							<option value="-1">Seleccione ....</option>
							<?php
							$sqlr="Select * from meses where estado='S' ";
							$resp = mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($resp)) 
							{
								$i=$row[0];
								echo "<option value=$row[0] ";
								if($i==$_POST[periodo])
								{
									echo "SELECTED";
								}
								echo " >".$row[1]."</option>";	  
							}   
							?>
						</select> 
					</td>
					<?php 
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
					$_POST[vigdep]=$fecha[3];
					?>
					<td></td>
					<td>
						<input name="vigdep" type="hidden" id="vigdep" style="width:80%" value="<?php echo $_POST[vigdep]?>">
						<input name="oculto" type="hidden" value="1">
						<input name="listar" type="hidden" value="1">
					</td>
					<td></td>
					<td>
						<input type="button" name="buscar" style="width:80%" value="Buscar" onClick="buscaract()">
					</td>
					<td></td>
					<td>
						<input type="button" name="buscar" style="width:80%" value="Calcular" onClick="calcularact()">
					</td>
					
				</tr>       
			</table>    
			<div class="subpantalla" style="height:63.5%; width:99.6%; overflow-x:hidden;">
				<table class="inicio" id="tabact">
					<tr><td class="titulos" colspan="11">Listado de Activos - Depreciar</td></tr>
					<tr>
						<td class="titulos2">No</td>
						<td class="titulos2">Placa</td>
						<td class="titulos2">Fecha Activacion</td>
						<td class="titulos2">Nombre</td>
						<td class="titulos2">Clase</td>
						<td class="titulos2">Grupo</td>
						<td class="titulos2">Tipo</td>
						<td class="titulos2">Valor</td>
						<td class="titulos2">Valor Depreciado</td>
						<td class="titulos2">Valor por Depreciar</td>
						<td class="titulos2">Valor Depreciacion Mensual</td>
					</tr>   
					<?php
					if($_POST[listar]=='2')
					{
						if($_POST[clasificacion]!='')
						{
							$criterio="AND clasificacion='$_POST[clasificacion]'";
						}
						if($_POST[grupo]!='')
						{
							$criterio1="AND grupo='$_POST[grupo]'";
						}
						if($_POST[tipo]!='')
						{
							$criterio3="AND tipo='$_POST[tipo]'";
						}
						$linkbd=conectar_bd();
						if($_POST[periodo]<10)
						$_POST[periodo]="0".$_POST[periodo];
						$fechadep=$_POST[vigdep].'-'.$_POST[periodo].'-01';
					//	$criterio2=" and fechaultdep<$fechadep"; 
						$sqlr="SELECT * FROM acticrearact_det WHERE estado='S' AND mesesdepacum <= nummesesdep AND fechact <= '$fechadep' $criterio $criterio1 $criterio3 ORDER BY placa";
						$resp = mysql_query($sqlr,$linkbd);
						$con=1;
						$co="zebra1";
						$co2='zebra2';
						$cuentas[]=array();
						$sumatotdep=0;
						while ($row =mysql_fetch_row($resp)) 
						{
							$cuentas[$row[27]][0]=$row[27];
							$cuentas[$row[27]][1]+=$row[21];	
							$cuentas[$row[27]][2]=$row[14];
							$cuentas[$row[27]][3]=$row[1];		 
							$sqlr="SELECT * FROM acti_tipo_cab WHERE id='$row[27]' AND estado='S'";
							//echo $sqlr;
							$resp2 = mysql_query($sqlr,$linkbd);
							$row2 =mysql_fetch_row($resp2);	
							$agesdep=$row2[3]*12;					
							//arreglo
							$clase=substr($row[1],0,1);
							$nivel1=substr($row[1],1,2);
							$nivel2=substr($row[1],3,3);

							$sqlclase = "SELECT nombre FROM actipo where codigo='$clase' ";
							$resclase = mysql_query($sqlclase,$linkbd);
							$rwclase = mysql_fetch_row($resclase);

							$sqlgrupo = "SELECT nombre FROM actipo where codigo='$nivel1' and niveluno='$clase' ";
							$resgrupo = mysql_query($sqlgrupo,$linkbd);
							$rwgrupo = mysql_fetch_row($resgrupo);

							$sqltipo = "SELECT nombre FROM actipo where codigo='$nivel2' and niveluno='$nivel1' AND niveldos='$clase' ";
							$restipo = mysql_query($sqltipo,$linkbd);
							$rwtipo = mysql_fetch_row($restipo);

							$sq="SELECT valdebito FROM comprobante_det WHERE valdebito!='0' AND numacti='$row[1]' and tipo_comp='100'";
							$rs=mysql_query($sq,$linkbd);
							$rw=mysql_fetch_row($rs);
							//echo $sq."<br>";
							$_POST[dplaca][$x]=$row[1];
							$_POST[dfecact][$x]=$row[8];
							$_POST[dnombre][$x]=$row[2];
							$_POST[dtipo][$x]=$row[27];
							$_POST[dntipo][$x]=$row2[1];
							$_POST[dvalact][$x]=$row[15];
							$_POST[dvaldep][$x]=$rw[0];		 
							$_POST[dvalx][$x]=$row[20];
							$_POST[dvalmen][$x]=$row[21];	 
							$_POST[dages][$x]=$agesdep;		 		 
							$_POST[dmesdep][$x]=$row[17];		 		 
							$_POST[dfecdep][$x]=$row[25];		 		 
							echo "
							<input type='hidden' name='dplaca[]' value='".$_POST[dplaca][$x]."'/>
							<input type='hidden' name='dfecact[]' value='".$_POST[dfecact][$x]."'/>
							<input type='hidden' name='dnombre[]' value='".$_POST[dnombre][$x]."'/>
							<input type='hidden' name='dvalact[]' value='".$_POST[dvalact][$x]."'/>
							<input type='hidden' name='dvaldep[]' value='".$_POST[dvaldep][$x]."'/>
							<input type='hidden' name='dvalx[]' value='".$_POST[dvalx][$x]."'/>
							<input type='hidden' name='dvalmen[]' value='".$_POST[dvalmen][$x]."'/>
							<tr class='$co'>
								<td style='width:3%'>$con</td>
								<td style='width:10%'>".$_POST[dplaca][$x]."</td>
								<td style='width:7%'>".cambiar_fecha($_POST[dfecact][$x])."</td>
								<td style='width:15%'>".$_POST[dnombre][$x]."</td>
								<td style='width:10%'>$rwclase[0]</td>
								<td style='width:10%'>$rwgrupo[0]</td>
								<td style='width:10%'>$rwtipo[0]</td>
								<td style='width:10%;text-align:right;'>".number_format($_POST[dvalact][$x],2,',','.')."</td>
								<td style='width:10%;text-align:right;'>".number_format($_POST[dvaldep][$x],2,',','.')."</td>
								<td style='width:10%;text-align:right;'>".number_format($_POST[dvalx][$x],2,',','.')."</td>
								<td style='width:10%;text-align:right;'>".number_format($_POST[dvalmen][$x],2,',','.')."</td>
							</tr>";					
							$con+=1;
							$aux=$co;
							$co=$co2;
							$co2=$aux;
							$sumatotdep+=$row[21];
						}		
						echo "
						<tr class='$co'>
							<td colspan='6'  style='text-align:right;'>Totales</td>
							<td></td><td></td><td></td>
							<td style='text-align:right;'>".number_format($sumatotdep,2)."</td>
						</tr>";	
					}
					//CALCULAR Depreciacion
					elseif($_POST[listar]=='3')
					{
						
						if($_POST[clasificacion]!='')
						{
							$criterio=" and clasificacion='$_POST[clasificacion]'";
						}
						if($_POST[grupo]!='')
						{
							$criterio1=" and grupo='$_POST[grupo]'";
						}
						if($_POST[tipo]!='')
						{
							$criterio3=" and tipo='$_POST[tipo]'";
						}
						$linkbd=conectar_bd();
						$fechadep=$_POST[vigdep].'-'.$_POST[periodo].'-01';
						$criterio2=" and fechaultdep<$fechadep"; 
						$sqlr="SELECT * FROM acticrearact_det WHERE estado='S' AND mesesdepacum <= nummesesdep AND fechact <= '$fechadep' $criterio $criterio1 $criterio3 ORDER BY placa";
						$resp = mysql_query($sqlr,$linkbd);
						$con=1;
						$co="zebra1";
						$co2='zebra2';
						$cuentas[]=array();
						$sumatotdep=$sumvalxdep=$sumvalordep=$sumvaloract=0;
						if(strlen($_POST[periodo])<=1)
							$pe='0'.$_POST[periodo];
						else
							$pe=$_POST[periodo];
						$fechacorte=$_POST[vigdep].'-'.$pe.'-30';
						$valmes=0;
						$exis=0;
						while ($row =mysql_fetch_row($resp)) 
						{
								 
							$sqlr="SELECT * FROM acti_prototipo WHERE id='$row[27]' AND estado='S'";
							//echo $sqlr;
							$resp2 = mysql_query($sqlr,$linkbd);
							$row2 =mysql_fetch_row($resp2);	
							$agesdep=$row2[3]*12;		
							
							$sqldep = "SELECT * FROM actidepactivo_det WHERE placa='$row[1]' and vigencia='$_POST[vigdep]' and mes='$_POST[periodo]' and estado='S'";
							$resdep = mysql_query($sqldep,$linkbd);
							$rowdep = mysql_fetch_row($resdep);
							if($rowdep[0]=='')
							{
								$terrenos=substr($row[1],0,3);
								$sqldep = "SELECT mes FROM actidepactivo_det WHERE placa='$row[1]' and vigencia='$_POST[vigdep]' and placa not like '$terrenos%' and estado='S' order by mes desc";
								$resdep = mysql_query($sqldep,$linkbd);
								$rowdep = mysql_fetch_row($resdep);	
								//echo $sqldep."hola";
								if($rowdep[0]!='')
								{
									if(strlen($rowdep[0])<=1)
									$ultmes='0'.$rowdep[0];
									else
										$ultmes=$rowdep[0];
									$fechaultimomes=$_POST[vigdep].'-'.$ultmes.'-30';
									//depreciacion
									$fechareg=$row[8];		
									$meses=diferenciamesesfechas($fechaultimomes,$fechacorte);
								}
								
								if($meses>1 && $pe=='01')
								{
									$meses=1;
								}
								if($meses<2)
								{
									$valordep=0;
									$valdepmen=$row[21];
									/*if($meses<$agesdep)
									{
										if (0>diferenciamesesfechas_f3($fechareg,$fechacorte)){$mesesdep=0;$fechadep="";$valordep=0;}
										else
										{ 
											$mesesdep=$meses;
											$fechadep=sumamesesfecha($row[8],$mesesdep);	
											$valordep=$mesesdep*$valdepmen;
										}
									}
									else
									{
										$mesesdep=$agesdep;  
										$fechadep=sumamesesfecha($row[8],$mesesdep);
										$valordep=$mesesdep*$valdepmen;
									}*/
									/*$sql="SELECT valdepdic FROM acti_deprecia_inicial_det WHERE placa='$row[1]'";
									$rs=mysql_query($sql,$linkbd);
									$rw=mysql_fetch_row($rs);*/
									$sq="SELECT valdebito FROM comprobante_det WHERE valdebito!='0' AND numacti='$row[1]' and tipo_comp='100'";
									$rs=mysql_query($sq,$linkbd);
									$rw=mysql_fetch_row($rs);

									$valordep=$rw[0];
									$valoract=$row[15];
									$codplaca=substr($row[1],0,1);
									$nivel1=substr($row[1],1,2);
									$nivel2=substr($row[1],3,3);
									if($row[26]=='1')
									{
										$sqlr1="SELECT * FROM actipo WHERE codigo='$nivel2' AND niveluno='$nivel1' AND niveldos='$codplaca'";
										$res1=mysql_query($sqlr1,$linkbd);
										$row1=mysql_fetch_assoc($res1);
										$mesesdeptot=$row1["deprecia"];
									}
									else
									{
										$mesesdeptot=$row[16];
									}	
									$clase=substr($row[1],0,1);
									$nivel1=substr($row[1],1,2);
									$nivel2=substr($row[1],3,3);

									$sqlclase = "SELECT nombre FROM actipo where codigo='$clase' ";
									$resclase = mysql_query($sqlclase,$linkbd);
									$rwclase = mysql_fetch_row($resclase);

									$sqlgrupo = "SELECT nombre FROM actipo where codigo='$nivel1' and niveluno='$clase' ";
									$resgrupo = mysql_query($sqlgrupo,$linkbd);
									$rwgrupo = mysql_fetch_row($resgrupo);

									$sqltipo = "SELECT nombre FROM actipo where codigo='$nivel2' and niveluno='$nivel1' AND niveldos='$clase' ";
									$restipo = mysql_query($sqltipo,$linkbd);
									$rwtipo = mysql_fetch_row($restipo);

									$valdepmen=round($valoract/$mesesdeptot,2);
									$valxdep=round($valoract-$valordep,2);
									//arreglo
									$cuentas[$row[1]][0]=$row[1];
									$cuentas[$row[27]][1]+=$row[21];	
									$cuentas[$row[27]][2]=$row[14];
									$cuentas[$row[27]][3]=$row[1];	
									if($valxdep<$valdepmen)
									{
										$valdepmen=0;
									}
									$_POST[dplaca][$x]=$row[1];
									$_POST[dfecact][$x]=$row[8];
									$_POST[dnombre][$x]=$row[2];
									$_POST[dtipo][$x]=$row[27];
									$_POST[dntipo][$x]=$row2[1];
									$_POST[dvalact][$x]=$valoract;
									$_POST[dvaldep][$x]=$valordep;		 
									$_POST[dvalx][$x]=$valxdep;
									$_POST[dvalmen][$x]=$valdepmen;	 
									$_POST[dages][$x]=$agesdep;		 		 
									$_POST[dmesdep][$x]=$mesesdep;		 		 
									$_POST[dfecdep][$x]=$fechadep;	
									$_POST[dclase][$x]=$rwclase[0];
									$_POST[dgrupo][$x]=$rwgrupo[0];
									$_POST[dtipop][$x]=$rwtipo[0];
										 		 
									echo "
									<input type='hidden' name='dplaca[]' value='".$_POST[dplaca][$x]."'/>
									<input type='hidden' name='dfecact[]' value='".$_POST[dfecact][$x]."' >
									<input type='hidden' name='dnombre[]' value='".$_POST[dnombre][$x]."'/>
									<input type='hidden' name='dclase[]' value='".$_POST[dclase][$x]."'/>
									<input type='hidden' name='dgrupo[]' value='".$_POST[dgrupo][$x]."'/>
									<input type='hidden' name='dtipop[]' value='".$_POST[dtipop][$x]."'/>
									<input type='hidden' name='dvalact[]' value='".$_POST[dvalact][$x]."'/>
									<input type='hidden' name='dvaldep[]' value='".$_POST[dvaldep][$x]."'/>
									<input type='hidden' name='dvalx[]' value='".$_POST[dvalx][$x]."'/>
									<input type='hidden' name='dvalmen[]' value='".$_POST[dvalmen][$x]."'/>
									<tr class='$co'>
										<td style='width:3%'>$con</td>
										<td style='width:10%'>".$_POST[dplaca][$x]."</td>
										<td style='width:7%'>".cambiar_fecha($_POST[dfecact][$x])."</td>
										<td style='width:15%'>".$_POST[dnombre][$x]."</td>
										<td style='width:10%'>".$_POST[dclase][$x]."</td>
										<td style='width:10%'>".$_POST[dgrupo][$x]."</td>
										<td style='width:10%'>".$_POST[dtipop][$x]."</td>
										<td style='width:10%;text-align:right;'>".number_format($_POST[dvalact][$x],2,',','.')."</td>
										<td style='width:7%;text-align:right;'>".number_format($_POST[dvaldep][$x],2,',','.')."</td>
										<td style='width:10%;text-align:right;'>".number_format($_POST[dvalx][$x],2,',','.')."</td>
										<td style='width:10%;text-align:right;'>".number_format($_POST[dvalmen][$x],2,',','.')."</td>
									</tr>
									<input name='dcc[]' value='".$row[14]."' type='hidden'>";				
									$con+=1;
									$aux=$co;
									$co=$co2;
									$co2=$aux;
									$sumvaloract+=$valoract;
									$sumvalordep+=$valordep;
									$sumvalxdep+=$valxdep;
									$sumatotdep+=$valdepmen;
									
								}
								else
								{
									$valmes=1;
								}
							}
							else
							{
								$exis=1;
							}
							
						}		
						echo "
						<tr class='$co'>
							<td colspan='7'  style='text-align:right;'>Totales:</td>
							<td style='text-align:right;'>".number_format($sumvaloract,2,',','.')."</td>
							<td style='text-align:right;'>".number_format($sumvalordep,2,',','.')."</td>
							<td style='text-align:right;'>".number_format($sumvalxdep,2,',','.')."</td>
							<td style='text-align:right;'>".number_format($sumatotdep,2,',','.')."</td>
						</tr>";
						if($valmes==1){
							echo "<script>despliegamodalm('visible','2','Hay Activos con mas de Un (1) mes Sin Depreciacion');</script>";
						}
						elseif($exis==1)
						{
							echo "<script>despliegamodalm('visible','1','Los activos ya se depreciaron en este mes');</script>";
						}
					}
					?>
				</table>
			</div>
		</form>
		<?php 
		//********** GUARDAR EL COMPROBANTE ***********
		if($_POST[oculto]=='2')	
		{
		//rutina de guardado cabecera
			$linkbd=conectar_bd();
			ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
			$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
			$bloq=bloqueos($_SESSION[cedulausu],$fechaf);	
			if($bloq>=1)
			{		
				$sqlr="select MAX(numerotipo) from comprobante_cab WHERE tipo_comp=78 ";
				$srl="SELECT nit FROM configbasica";
				$rs=mysql_query($srl,$linkbd);
				$ro=mysql_fetch_row($rs);
				$tercero=substr($ro[0],0,9);
				$res=mysql_query($sqlr);
				$row=mysql_fetch_row($res);
				$_POST[codigo]=$consec=selconsecutivo('actidepactivo_cab','id_dep');
				$lastday = mktime (0,0,0,$_POST[periodo],1,$_POST[vigdep]);
				$ultdiadep=$_POST[vigdep]."-".$_POST[periodo]."-01";
				$sq="insert into actidepactivo_cab (id_dep,mes,vigencia,fecha,estado,tipo_mov) values ($consec,$_POST[periodo],$_POST[vigdep],'$fechaf','S',201)";
				mysql_query($sq,$linkbd);
				$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($consec,78,'$fechaf','DEPRECIACION ACTIVOS MES ".strtoupper(strftime("%B",$lastday))."',0,0,0,0,'1')";
				mysql_query($sqlr,$linkbd);
				$idcomp=mysql_insert_id();
				$total=0;
				for($x=0;$x<count($_POST[dplaca]);$x++)
				{
					$tipo=substr($_POST[dplaca][$x],0,6);
					$sqlr="SELECT * FROM acti_depreciacionactivos_det WHERE tipo='$tipo'";
					$res=mysql_query($sqlr,$linkbd);
					$row=mysql_fetch_assoc($res);
					if($row["cuenta_debito"]!='')
					{
						$sql="update acticrearact_det set fechact='$ultdiadep' where placa = '".$_POST[dplaca][$x]."'";
						mysql_query($sql,$linkbd);
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito, estado, vigencia,tipo_comp,numerotipo,numacti) values ('78 $consec','".$row['cuenta_debito']."','$tercero','".$_POST[dcc][$x]."' , '".$_POST[dplaca][$x].$_POST[dnombre][$x]."','','".$_POST[dvalmen][$x]."','0','1','$_POST[vigdep]','78','$consec','".$_POST[dplaca][$x]."')";
						mysql_query($sqlr,$linkbd);
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito, estado, vigencia,tipo_comp,numerotipo,numacti) values ('78 $consec','".$row['cuenta_credito']."','$tercero','".$_POST[dcc][$x]."' , '".$_POST[dplaca][$x]."-".$_POST[dnombre][$x]."','','0','".$_POST[dvalmen][$x]."','1','$_POST[vigdep]','78','$consec','".$_POST[dplaca][$x]."')";
						mysql_query($sqlr,$linkbd);
					}
					$sq="insert into actidepactivo_det (id_dep,vigencia,mes,placa,fechact,nombre,clase,grupo,tipo,valor,valord,valorad,valdep, estado,tipo_mov) values ('$consec','$_POST[vigdep]','$_POST[periodo]','".$_POST[dplaca][$x]."','".$_POST[dfecact][$x]."','".$_POST[dnombre][$x]."','".$_POST[dclase][$x]."','".$_POST[dgrupo][$x]."','".$_POST[dtipop][$x]."','".$_POST[dvalact][$x]."','".$_POST[dvaldep][$x]."','".$_POST[dvalx][$x]."','".$_POST[dvalmen][$x]."','S',201)";
					if(!mysql_query($sq,$linkbd))
					{
						$cuentanp[]=$_POST[dplaca][$x];
					}
					
				}
				if(count($cuentanp)<1)
				{
					echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado con Exito <img src='imagenes\confirm.png'></center></td></tr></table>";
					echo "<script>funcionmensaje();</script>";
				}
				
				//$total=array_sum($k[1]); 	  
				//
				//echo "t:".$total;
				// $sqlr="insert into actidepactivo_cab (`id_dep`, `age`, `mes`, `fecha`, `valordep`, `estado`) values ($consec,'$_POST[vigdep]','$_POST[periodo]','$_POST[fecha]',,)";			
				/*$_POST[valor]=str_replace(".","",$_POST[valor]);
				ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
				$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
				ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechact],$fecha);
				$fechafact=$fecha[3]."-".$fecha[2]."-".$fecha[1];
				$nmesesdep=$_POST[agedep]/12;
				$vmendep=$_POST[valor]/$nmesesdep;
				$sqlr="insert into actidepactivo (`placa`, age, `mes`,  `fecha`, `valordep`, `estado`) values ('$_POST[consecutivo]','$_POST[placa]', '$_POST[nombre]', '$_POST[referencia]','$_POST[modelo]','$_POST[serial]', '$_POST[unimed]','$fechaf', '$fechafact','$_POST[clasificacion]','$_POST[origen]','$_POST[area]','$_POST[ubicacion]','$_POST[grupo]','$_POST[cc]',$_POST[valor],$nmesesdep,0,$nmesesdep,$_POST[valor],$_POST[valor],$vmendep,'S')";
				echo $sqlr;
				if(!mysql_query($sqlr,$linkbd))
				 {
				  echo "<table class='inicio'><tr><td class='saludo1'><center>No Se ha Almacenado el Nuevo Activo, <img src='imagenes\alert.png'> Error:".mysql_error()."</center></td></tr></table>";
				 }
				 else
				 {
				  echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha Almacenado con Exito el Nuevo Activo <img src='imagenes\confirm.png'></center></td></tr></table>";
				 
				 }*/
			}
		}
		?>	
	</body>
</html>