<?php
	require "comun.inc";
	require "funciones.inc";
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
			function funcionmensaje(){document.location.href = "acti-depreciaractivos.php";}
			function respuestaconsulta(pregunta, variable)
			{
				switch(pregunta)
				{
					case "1":
						document.form2.oculto.value=2;
						document.form2.listar.value=2;
						document.form2.submit();						
						break;
				}
			}
			function validar(){document.form2.submit();}
			function iratras(){document.location.href="acti-gestiondelosactivos.php";}
			function atrasc()
			{
				var idcodigo = parseFloat(document.form2.codigo.value);
				var nmin = idcodigo - 1;
				if(nmin>=parseFloat(document.form2.valmin.value)){document.location.href="acti-depreciaractivosvisualizar.php?iddepre="+nmin;}
				else {despliegamodalm('visible','2','No hay listados de activos de depreciaci�n con c�digo menor a '+idcodigo);}
			}
			function adelante()
			{
				var idcodigo = parseFloat(document.form2.codigo.value);
				var nmax = idcodigo + 1;
				if(nmax<=parseFloat(document.form2.valmax.value)){document.location.href="acti-depreciaractivosvisualizar.php?iddepre="+nmax;}
				else {despliegamodalm('visible','2','No hay listados de activos de depreciaci�n con c�digo mayor a '+idcodigo);}
			}
			function cambiocodigo()
			{
				var idcodigo = parseFloat(document.form2.codigo.value);
				var nmax = parseFloat(document.form2.valmax.value);
				if(idcodigo<=nmax){document.location.href="acti-depreciaractivosvisualizar.php?iddepre="+idcodigo;}
				else 
				{
					despliegamodalm('visible','2','No existe un listados de activos de depreciaci�n con c�digo '+idcodigo);
					document.form2.codigo.value=document.form2.codaux.value;
				}
			}
			function excell()
			{
				document.form2.action="acti-depreciaractivosexcel.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
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
				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='acti-depreciaractivos.php'" class="mgbt"/><img src="imagenes/guardad.png"  title="Guardar" class="mgbt1"/><img src="imagenes/busca.png"  title="Buscar" class="mgbt"/><img src="imagenes/agenda1.png" title="Agenda" onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana"  onClick="mypop=window.open('acti-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/print.png" title="Imprimir" onClick="pdf()" class="mgbt"/><img src="imagenes/excel.png" title="Excel" onClick='excell()' class="mgbt"/><img src="imagenes/iratras.png" title="Atr�s" onclick="iratras()" class="mgbt">
				</td>
			</tr>
		</table>
		<?php
			$linkbd=conectar_bd();
			if(!$_POST[oculto])
			{
				$sqlr="SELECT MAX(id_dep),MIN(id_dep) FROM actidepactivo_cab";
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
				$_POST[valmax]=$row[0];
				$_POST[valmin]=$row[1];
				if($_GET[iddepre]!=""){$_POST[codigo]=$_POST[codaux]=$_GET[iddepre];}
				else{$_POST[codigo]=$_POST[codaux]=$_POST[valmax];}
				$sqlr="SELECT mes,vigencia,fecha,tipo_mov FROM actidepactivo_cab WHERE id_dep='$_POST[codigo]'";
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
				$_POST[fecha]=date('d-m-Y',strtotime($row[2]));
				$_POST[periodo]=$row[0];
				$_POST[vigencia]=$row[1];
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
					<td class="saludo1" style="width:2.5cm">Documento:</td>
					<td style="width:12%"><img src="imagenes/back.png" title="Anterior" onClick="atrasc()" class="icobut"/>&nbsp;<input type="text" name="codigo" size="5" id="codigo" value="<?php echo $_POST[codigo]; ?>" onKeyUp="return tabular(event,this)" onChange="cambiocodigo();"/>&nbsp;<img src="imagenes/next.png" title="Siguiente" onClick="adelante()" class="icobut"/></td>
					<td class="saludo1" style="width:2.5cm">Fecha:</td>
					<td style="width:8%"><input type="text" name="fecha" id="fecha" style="width:80%" value="<?php echo $_POST[fecha]; ?>" readonly/></td>
                    <td class="saludo1" style="width:2.5cm">Vigencia:</td>
					<td style="width:8%"><input type="text" name="vigencia" id="vigencia" style="width:80%" value="<?php echo $_POST[vigencia]; ?>" readonly/></td>
					<td class="saludo1" style="width:2.5cm">Mes:</td>
					<td>
						<select name="periodo" id="periodo">
							<?php
								$sqlr="SELECT * FROM meses WHERE estado='S' ";
								$resp = mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp)) 
								{
									if($row[0]==$_POST[periodo]){echo "<option value='$row[0]' SELECTED>$row[1]</option>";}
								}   
							?>
						</select> 
					</td>
				</tr> 
				<input type="hidden" name="oculto" id="oculto" value="1"/>
				<input type="hidden" name="valmin" id="valmin" value="<?php echo $_POST[valmin];?>"/>
				<input type="hidden" name="valmax" id="valmax" value="<?php echo $_POST[valmax];?>"/>
				<input type="hidden" name="codaux" id="codaux" value="<?php echo $_POST[codaux];?>"/>
			</table>    
			<div class="subpantalla" style="height:66.5%; width:99.6%; overflow-x:hidden;">
            	<?php
					$sqlr="SELECT placa,fechact,nombre,clase,grupo,tipo,valor,valord,valorad,valdep FROM actidepactivo_det WHERE id_dep='$_POST[codigo]' ORDER BY placa";
					$resp=mysql_query($sqlr,$linkbd);
					$row =mysql_fetch_row($resp);
					echo"
					<table class='inicio' id='tabact'>
						<tr><td class='titulos' colspan='11'>Listado de Activos - Depreciar</td></tr>
						<tr>
							<th class='titulos2' style='width:3%'>No</th>
							<th class='titulos2' style='width:10%'>Placa</th>
							<th class='titulos2' style='width:7%'>Fecha Activacion</th>
							<th class='titulos2'>Nombre</th>
							<th class='titulos2' style='width:10%'>Clase</th>
							<th class='titulos2' style='width:10%'>Grupo</th>
							<th class='titulos2' style='width:10%'>Tipo</th>
							<th class='titulos2' style='width:10%'>Valor</th>
							<th class='titulos2' style='width:10%'>Valor Depreciado</th>
							<th class='titulos2' style='width:10%'>Valor por Depreciar</th>
							<th class='titulos2' style='width:10%'>Valor Depreciacion Mensual</th>
						</tr> ";
					$iter='zebra1';
					$iter2='zebra2';
					$cont=1;
					$sumatotdep=$sumvalxdep=$sumvalordep=$sumvaloract=0;
					while ($row =mysql_fetch_row($resp)) 
					{
						echo"
						<tr class='$iter'>
							<td>$cont</td>
							<td>$row[0]</td>
							<td>$row[1]</td>
							<td>$row[2]</td>
							<td>$row[3]</td>
							<td>$row[4]</td>
							<td>$row[5]</td>
							<td style='text-align:right;'>".number_format($row[6],2,',','.')."</td>
							<td style='text-align:right;'>".number_format($row[7],2,',','.')."</td>
							<td style='text-align:right;'>".number_format($row[8],2,',','.')."</td>
							<td style='text-align:right;'>".number_format($row[9],2,',','.')."</td>
						</tr>";
						$sumvaloract+=$row[6];
						$sumvalordep+=$row[7];
						$sumvalxdep+=$row[8];
						$sumatotdep+=$row[9];
						$cont+=1;
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
					}
					echo "
						<tr class='$iter'>
							<td colspan='7' style='text-align:right;'>Totales:</td>
							<td style='text-align:right;'>".number_format($sumvaloract,2,',','.')."</td>
							<td style='text-align:right;'>".number_format($sumvalordep,2,',','.')."</td>
							<td style='text-align:right;'>".number_format($sumvalxdep,2,',','.')."</td>
							<td style='text-align:right;'>".number_format($sumatotdep,2,',','.')."</td>
						</tr>
					</table>";
				?>
			</div>
		</form>
	</body>
</html>