<?php
require"comun.inc";
require"funciones.inc";
require "conversor.php";
session_start();
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>:: SPID- Activos Fijos</title>

<script>
//************* ver reporte ************
//***************************************
function verep(idfac)
{
  document.form1.oculto.value=idfac;
  document.form1.submit();
  }
</script>
<script>
//************* genera reporte ************
//***************************************
function genrep(idfac)
{
  document.form2.oculto.value=idfac;
  document.form2.submit();
  }
</script>
<script>
function buscacta(e)
 {
if (document.form2.cuenta.value!="")
{
 document.form2.bc.value='1';
 document.form2.submit();
 }
 }
</script>
<script language="JavaScript1.2">
function validar()
{
document.form2.submit();
}
function validar2()
{
document.form2.oculto.value=9;
document.form2.submit();
}
</script>
<script>
function buscater(e)
 {
if (document.form2.tercero.value!="")
{
 document.form2.bt.value='1';
 document.form2.submit();
 }
 }
</script>
<script>
//************* genera reporte ************
//***************************************
function guardar($ti)
		{
			if($ti=='102')
			{	
				document.form2.agregadet.value=1;
				var validacion01=document.getElementById('numero').value;
				var validacion02=document.getElementById('conceptogral').value;
				var validacion03=document.getElementById('concepto').value;
				var validacion04=document.getElementById('cc2').value;
				var validacion05=document.getElementById('area2').value;
				var validacion06=document.getElementById('ubicacion2').value;
				if (validacion01.trim()!='' && validacion02.trim()!='' && validacion03.trim()!='' && validacion04.trim()!='' && validacion05.trim()!='' && validacion06.trim()!='')
				{
					despliegamodalm('visible','4','Esta Seguro de Guardar','1');
				}
				else
				{
					despliegamodalm('visible','2','Faltan datos para completar el registro');
					document.form2.numero.focus();
					document.form2.numero.select();
				}
			}
			else
			{
				var validacion1=document.getElementById('traslid').value;
				var validacion2=document.getElementById('descripcion').value;
				if(validacion1.trim()!='' && validacion2.trim()!='')
				{
					despliegamodalm('visible','4','Esta Seguro de Guardar','1');
				}
				else
				{
					despliegamodalm('visible','2','Faltan datos para completar el registro');
					document.form2.numero.focus();
					document.form2.numero.select();
				}
			}

		}
		
		function despliegamodalm(_valor,_tip,mensa,pregunta,variable)
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
					case "5":
					document.getElementById('ventanam').src="ventana-elimina1.php?titulos="+mensa+"&idresp="+pregunta+"&variable="+variable;break;	
				}
			}
		}
		function respuestaconsulta(pregunta)
		{
			switch(pregunta)
			{
				case "1":	document.getElementById('oculto').value="2";
							document.form2.submit();break;
				case "2":
					document.form2.elimina.value=variable;
					//eli=document.getElementById(elimina);
					vvend=document.getElementById('elimina');
					//eli.value=elimina;
					vvend.value=variable;
					document.form2.submit();
					break;
			}
		}
		function funcionmensaje(){document.location.href = "acti-traslados.php";}
		
</script>
<script>
function pdf()
{
document.form2.action="acti-pdftraslados.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}
		function iratras(){
			location.href="acti-gestiondelosactivos.php";
		}
		
		function adelante(scrtop, numpag, limreg, filtro, next){
			var maximo=document.getElementById('maximo').value;
			var actual=document.getElementById('numero').value;
			if(parseFloat(maximo)>parseFloat(actual)){
				document.getElementById('oculto').value='1';
				document.getElementById('numero').value=next;
				var idcta=document.getElementById('numero').value;
				document.form2.action="teso-editaingresos.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
				document.form2.submit();
			}
		}
		
			
		function atrasc(scrtop, numpag, limreg, filtro, prev){
			var minimo=document.getElementById('minimo').value;
			var actual=document.getElementById('numero').value;
			if(parseFloat(minimo)<parseFloat(actual)){
				document.getElementById('oculto').value='1';
				document.getElementById('numero').value=prev;
				var idcta=document.getElementById('numero').value;
				document.form2.action="teso-editaingresos.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
				document.form2.submit();
			}
		}
</script>
<script>
function despliegamodal2(_valor,v)
{
	if(v!='')
	{
		document.getElementById("bgventanamodal2").style.visibility=_valor;
		if(_valor=="hidden"){
			document.getElementById('ventana2').src="";
			document.form2.submit();
		}
		else {
			if(v=='01'){
				document.getElementById('ventana2').src="activentana-compra-activos.php";
			}
			else if(v=='02')
			{
				document.getElementById('ventana2').src="activentana-construccion.php";
			}
			else if(v=='03')
			{
				document.getElementById('ventana2').src="activentana-montaje.php";
			}
			else if(v=='04')
			{
				document.getElementById('ventana2').src="activentana-donacion.php";
			}
			else if(v=='05')
			{
				document.getElementById('ventana2').src="activentana-donacion.php";
			}
			else if(v=='07')
			{
				document.getElementById('ventana2').src="activentana-otros.php";
			}
			else if(v=='4')
			{
				document.getElementById('ventana2').src="reservar-activo.php";
			}
		}
	}
	else{
		despliegamodalm('visible','2','Seleccione el Origen del Activo');
	}
}
</script>

<script src="css/programas.js"></script>
<script src="css/calendario.js"></script>
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<link href="css/css3.css" rel="stylesheet" type="text/css" />
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
	<tr><script>barra_imagenes("acti");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("acti");?></tr>
	<tr  class="cinta">
		<td colspan="3"  class="cinta">
			<a href="acti-traslados.php" class="mgbt"><img src="imagenes/add.png" alt="Nuevo"  border="0" /></a>
			<a href="#"  onClick="guardar(<?php echo $_POST[tipomov]; ?>)" class="mgbt"><img src="imagenes/guarda.png"  alt="Guardar" /></a>
			<a href="acti-buscatraslados.php" class="mgbt"> <img src="imagenes/busca.png"  alt="Buscar" border="0" /></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('acti-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana"></a>
			<a onclick="iratras()" class="mgbt"><img src="imagenes/iratras.png" title="AtrÃ¡s"></a>
		</td>
	</tr>		  
</table>
<tr><td colspan="3" class="tablaprin" align="center"> 
<?php
$vigencia=date(Y);
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
$vigencia=$vigusu;
 ?>	
<?php
	  //*********** cuenta origen va al credito y la destino al debito
if($_POST[oculto]==9 || !$_POST[oculto])
{
	$_POST[tipotras]=1;
	$linkbd=conectar_bd();
	$fec=date("d/m/Y");
	$_POST[fecha]=$fec; 		 		  			 
	$sqlr="select max(id_traslado_cab) from actitraslados_cab ";
	$res=mysql_query($sqlr,$linkbd);
	$consec=0;
	while($r=mysql_fetch_row($res))
	{
		$consec=$r[0];	  
	}
	$consec+=1;
	$_POST[idcomp]=$consec;
	$_POST[tipomov]='102';
}
?>
 <div id="bgventanamodalm" class="bgventanamodalm">
        <div id="ventanamodalm" class="ventanamodalm">
            <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
            </IFRAME>
        </div>
</div>
 <form name="form2" method="post" action=""> 
		<table class="inicio">
			<tr>
				<td class="titulos" style="width:100%;">.: Tipo de Movimiento 
					<select id="tipomovimiento" name="tipomovimiento" onChange="validar2()" style="width:20%;" >
						<?php
						$link=conectar_bd();
						$sqlr="Select * from acti_tipomov where estado='S' AND (tipom='1' OR tipom='3') AND codigo='02'";
						// echo $sqlr;
						$resp = mysql_query($sqlr,$link);
						while ($row =mysql_fetch_row($resp)) 
						{
							echo "<option value=$row[1] ";
							$i=$row[1];
							if($i==$_POST[tipomovimiento])
							{
								echo "SELECTED";
								$_POST[tipomov]=$row[1].''.$row[0];
							}
							echo ">".$row[1].''.$row[0].' - '.$row[2]."</option>";
						}
						?>
					</select>
					<input type="hidden" id="tipomov" name="tipomov" value="<?php echo $_POST[tipomov]?>" size="50" readonly>
					<input type="hidden" value="0" name="agregadet"><input type="hidden" value="1" id="oculto" name="oculto">
				</td>
				<td style="width:80%;">
				</td>
			</tr>
		</table>
	<?php if($_POST[tipomov]=='102'){?>
	<table class="inicio" align="center" >
		<tr >
			<td class="titulos" colspan="6">.: Agregar Traslados</td>
			<td class="cerrar" ><a href="acti-principal.php">  Cerrar</a></td>
		</tr>
		<tr>
			<td class="saludo1" style="width:10%">Numero Comp:</td>
			<td> 
				<input name="idcomp" type="text" size="5" value="<?php echo $_POST[idcomp]?>">
				<input name="cuentatraslado" type="hidden" size="5" value="<?php echo $_POST[cuentatraslado]?>">
			</td>
			<td class="saludo1" style="width:10%" >Fecha:</td>
			<td ><input id="fc_1198971545" title="DD/MM/YYYY" name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)">   <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>     </td>  
		</tr>
	<tr>
	  <td  class="saludo1">Concepto Traslado General:</td>
	  <td colspan="3"><input id="conceptogral" name="conceptogral" type="text" value="<?php echo $_POST[conceptogral]?>" size="150" onKeyUp="return tabular(event,this)">
	</tr>
	<tr>
	<td class="saludo1">Tipo Traslado</td>
	<td>
	<select name="tipotras" id="tipotras" onKeyUp="return tabular(event,this)" onChange="validar()" style="width:90%" >
         <option value="1" <?php if($_POST[tipotras]=='1') echo "SELECTED"; ?>>Interno</option>
         <option value="2" <?php if($_POST[tipotras]=='2') echo "SELECTED"; ?>>Externo</option>
  	</select>
	</td>
	<?php
	 if($_POST[tipotras]==2)
	   {
	?>
	<td class="saludo1">Tipo Traslado</td>
	<td>
	<select name="tipotrasext" id="tipotrasext" onKeyUp="return tabular(event,this)" onChange="validar()" >
         <option value="1" <?php if($_POST[tipotrasext]=='1') echo "SELECTED"; ?>>Entrada</option>
         <option value="2" <?php if($_POST[tipotrasext]=='2') echo "SELECTED"; ?>>Salida</option>
  	</select>
	</td>
	<?php
		}
	?>
	</tr>
	<tr>
        <td  class="saludo1">Numero Placa Activo:
        </td>
        <td><input id="numero" name="numero" type="text" value="<?php echo $_POST[numero]?>" style="width:90%" onKeyUp="return tabular(event,this)"><a href="#" onClick="mypop=window.open('activos-ventana.php?vigencia=<?php echo $vigusu?>&objeto=numero&nobjeto=nactivo&objeto2=ccaux&objeto3=areaaux&objeto4=ubicacionaux&objeto5=proaux&objeto6=disaux ','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();">  <img src="imagenes/buscarep.png" align="absmiddle" border="0"></a></td>
		<td  class="saludo1">Descripcion Activo:
        </td><td><input id="nactivo" name="nactivo" type="text" value="<?php echo $_POST[nactivo]?>" size="82" onKeyUp="return tabular(event,this)" readonly>        </td></tr>
	
	  <tr>
	  <td class="saludo1">Centro Costo :</td>
	  <td>
	<select id='cc' name="cc"  onChange="validar()" onKeyUp="return tabular(event,this)" style="width:90%">
	<?php
	$linkbd=conectar_bd();
	$sqlr="select *from centrocosto where estado='S'";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
				    {
					if($row[0]==$_POST[ccaux])
			 			{
						 echo "<option value=$row[0] SELECTED>".$row[0]." - ".$row[1]."</option>";
						} 	 
					}	 	
	?>
   </select>
	<input type="hidden" id="ccaux" name="ccaux" value="<?php echo $_POST[ccaux]?>">
	</td>
	<td class="saludo1">Dependencia de Origen :</td>
	<td><select id="area" name="area" style="width:96%" onChange="validar()">
		<?php
		   $link=conectar_bd();
  		   $sqlr="Select * from  planacareas where planacareas.estado='S'";
			// echo $sqlr;
		 			$resp = mysql_query($sqlr,$link);
				    while ($row =mysql_fetch_row($resp)) 
				    { 
					 if($row[0]==$_POST[areaaux])
			 			{
						 echo "<option value=$row[0] SELECTED>".$row[0].' - '.$row[1]."</option>";
						 $_POST[narea]=$row[1];
						}
					}
		?>
    </select>
	<input type="hidden" id="narea" name="narea" value="<?php echo $_POST[narea]?>" size="50" readonly>
	<input type="hidden" id="areaaux" name="areaaux" value="<?php echo $_POST[areaaux]?>">
    </td>
	<td class="saludo1">Ubicacion Origen :</td>
	<td>
    <select id="ubicacion" name="ubicacion" style="width:94%">
		 <?php
		   $link=conectar_bd();
  		   $sqlr="Select * from actiubicacion where estado='S'";
			// echo $sqlr;
		 			$resp = mysql_query($sqlr,$link);
				    while ($row =mysql_fetch_row($resp)) 
				    {
					if($row[0]==$_POST[ubicacionaux])
			 			{
						 echo "<option value='$row[0]' SELECTED>".$row[0].' - '.$row[1]."</option>";
						 $_POST[nubicacion]=$row[1];
						}
					}
		  ?>
	</select>
	<input type="hidden" id="nubicacion" name="nubicacion" value="<?php echo $_POST[nubicacion]?>" >
	<input type="hidden" id="ubicacionaux" name="ubicacionaux" value="<?php echo $_POST[ubicacionaux]?>">
    </td>
	</tr>
	<tr>
		<td class="saludo1">Prototipo:</td>
		<td>
			<select id="prototipo" name="prototipo" onChange="document.form2.submit()" style="width:90%">
				<?php
				$link=conectar_bd();
				$sqlr="SELECT * from acti_prototipo where estado='S'";
				$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
				{	
					if($row[0]==$_POST[proaux])
					{
						echo "<option value='$row[0]' SELECTED>".$row[0].' - '.$row[1]."</option>";
						$_POST[npro]=$row[1];
					}
				}
				?>
			</select>
			<input type="hidden" id="npro" name="npro" value="<?php echo $_POST[npro]?>" size="50" readonly>
			<input type="hidden" id="proaux" name="proaux" value="<?php echo $_POST[proaux]?>">
		</td>
		<td class="saludo1">Disposici&oacute;n de los Activos:</td>
		<td>
			<select id="dispactivos" name="dispactivos" onKeyUp="return tabular(event,this)" style="width: 96%;">
				<?php
				$sqlr="SELECT * from acti_disposicionactivos where estado='S'";
				$res=mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($res)){
					if($row[0]==$_POST[disaux])
					{
						echo "<option value='$row[0]' SELECTED>".$row[0].' - '.$row[1]."</option>";
						$_POST[ndis]=$row[1];
					}
				}	 	
				?>
			</select>
			<input type="hidden" id="ndis" name="ndis" value="<?php echo $_POST[ndis]?>" size="50" readonly>
			<input type="hidden" id="disaux" name="disaux" value="<?php echo $_POST[disaux]?>">
		</td>
	</tr>
	<?php
		if($_POST[tipotras]==1)
		{
	?>
	<tr>
		<td class="saludo1">Centro Costo Destino:</td>
		<td>
		<select id="cc2" name="cc2" onChange="validar()" style="width:90%" onKeyUp="return tabular(event,this)">
		<option value="">...</option>
		<?php
		$linkbd=conectar_bd();
		$sqlr="select *from centrocosto where estado='S'";
		$res=mysql_query($sqlr,$linkbd);
		while ($row =mysql_fetch_row($res)) 
		{
			echo "<option value=$row[0] ";
			$i=$row[0];
			if($i==$_POST[cc2])
			{
				echo "SELECTED";
			}
			echo ">".$row[0]." - ".$row[1]."</option>";	 	 
		}	 	
	?>
   </select>
	</td>
	<td class="saludo1">Dependencia Destino :</td>
	<td><select id="area2" name="area2" style="width:96%">
    <option value="">...</option>
		 <?php
			$link=conectar_bd();
			$sqlr="Select * from  planacareas where planacareas.estado='S'";
			// echo $sqlr;
			$resp = mysql_query($sqlr,$link);
			while ($row =mysql_fetch_row($resp)) 
			{
				echo "<option value=$row[0] ";
				$i=$row[0];
				if($i==$_POST[area2])
				{
					echo "SELECTED";
					$_POST[narea2]=$row[1];
				}
				echo ">".$row[0].' - '.$row[1]."</option>";	  
			}
		  ?>
    </select><input type="hidden" id="narea2" name="narea2" value="<?php echo $_POST[narea2]?>" size="50" readonly>
    </td>
	<td class="saludo1">Ubicacion Destino :</td>
	<td>
		<select id="ubicacion2" name="ubicacion2" style="width:94%">
		<option value="">...</option>
			<?php
			$link=conectar_bd();
			$sqlr="Select * from actiubicacion where estado='S'";
			// echo $sqlr;
		 			$resp = mysql_query($sqlr,$link);
				    while ($row =mysql_fetch_row($resp)) 
				    {
					echo "<option value=$row[0] ";
					$i=$row[0];
					if($i==$_POST[ubicacion2])
			 			{
						 echo "SELECTED";
						 $_POST[nubicacion2]=$row[1];
						}
					  echo ">".$row[0].' - '.$row[1]."</option>";	  
					}
  
		  ?>
    </select><input type="hidden" id="nubicacion2" name="nubicacion2" value="<?php echo $_POST[nubicacion2]?>" size="50" readonly>
	</td>
	</tr>
	<tr>
		<td class="saludo1">Prototipo:</td>
		<td>
			<select id="prototipo2" name="prototipo2" onChange="document.form2.submit()" style="width:90%">
				<option value="">...</option>
				<?php
				$link=conectar_bd();
				$sqlr="SELECT * from acti_prototipo where estado='S'";
				$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
				{
					echo "<option value=$row[0] ";
					$i=$row[0];
					if($i==$_POST[prototipo2])
					{
						echo "SELECTED";
					}
					echo ">".$row[0].' - '.$row[1]."</option>";	  
				}
				?>
			</select><input type="hidden" id="npro2" name="npro2" value="<?php echo $_POST[npro2]?>" size="50" readonly>
		</td>
		<td class="saludo1">Disposici&oacute;n de los Activos:</td>
		<td>
			<select id="dispactivos2" name="dispactivos2" onKeyUp="return tabular(event,this)" style="width: 96%;">
				<option value="">...</option>
				<?php
				$sqlr="SELECT * from acti_disposicionactivos where estado='S'";
				$res=mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($res)){
					echo "<option value=$row[0] ";
					$i=$row[0];
					if($i==$_POST[dispactivos2]){
						echo "SELECTED";
					}
					echo ">".$row[0]." - ".$row[1]."</option>";	 	 
				}	 	
				?>
			</select><input type="hidden" id="ndis2" name="ndis2" value="<?php echo $_POST[ndis2]?>" size="50" readonly>
		</td>
	</tr>
	  <?php
	  }
	  ?>
	  <tr>	
	  <td  class="saludo1">Concepto Traslado Activo:</td>
	  <td colspan="3"><input id="concepto" name="concepto" type="text" value="<?php echo $_POST[concepto]?>" size="150" onKeyUp="return tabular(event,this)"></td>
	</tr> 	  
	</div>
	</table>
	  <?php
	}if($_POST[tipomov]=='302'){?>
	<table class="inicio">
		<tr>
			<td class="titulos" colspan="6">.: Documento a Reversar</td>
		</tr>
		<tr>
			<td class="saludo1" style="width:10%;">Numero de traslado:</td>
			<td style="width:10%;">
				<input id="traslid" name="traslid" type="text" value="<?php echo $_POST[traslid]?>" size="20" onKeyUp="return tabular(event,this)">
				<a href="#" onClick="mypop=window.open('traslados-ventana.php?vigencia=<?php echo $vigusu?>&objeto=traslid','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=1000px,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
			</td>
			<td class="saludo1" style="width:10%;">Fecha:</td>
			<td style="width:10%;">
				<input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" style="width:80%;" title="DD/MM/YYYY"/>&nbsp;<a href="#" onClick="displayCalendarFor('fc_1198971545');" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;"/></a>
			</td>
			<td class="saludo1" style="width:10%;">Descripcion</td>
			<td style="width:60%;" colspan="3">
				<input type="text" name="descripcion" id="descripcion" value="<?php echo $_POST[descripcion]?>" style="width:100%;">
			</td>
		</tr>	
		<?php
		if(($_POST[oculto]!="2")&&($_POST[oculto]!="7")){
		}
		?>
		<table class="inicio">
		<tr>
			<td class="titulos" colspan="11">Detalles</td>
		</tr>
		<tr>
			<td class="titulos2" style="width:2%">Id</td>
			<td class="titulos2" style="width:5%">Activo</td>
			<td class="titulos2" style="width:8%">Centro Costos Origen</td>
			<td class="titulos2" style="width:10%">Area Origen</td>
			<td class="titulos2" style="width:10%">Ubicacion Origen</td>
			<td class="titulos2" style="width:10%">Centro Costos Destino</td>
			<td class="titulos2" style="width:10%">Area Destino</td>
			<td class="titulos2" style="width:10%">Ubicacion Destino</td>
			<td class="titulos2" style="width:5%">Fecha</td>
			<td class="titulos2" style="width:10%">Concepto de Traslado</td>
			<td class="titulos2" style="width:2%"><img src="imagenes/del.png" ><input type='hidden' name='elimina' id='elimina'></td>
		</tr>
		
	<?php
		if($_POST[traslid]!=""){
			$iter='zebra1';
			$iter2='zebra2';
			$gtotal=0;
			$linkbd=conectar_bd();
			$sqlr4="select * from actitraslados, actitraslados_cab where actitraslados_cab.id_traslado_cab=actitraslados.id_trasladocab and actitraslados.id_trasladocab='$_POST[traslid]'";
			$res4=mysql_query($sqlr4,$linkbd);
			while ($row4 =mysql_fetch_row($res4)) 
			{
			echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" >
				<td style='width:2%'><input id='ids[]' name='ids[]' value='".$row4[1]."' type='text' style='width:100%' readonly></td>
				<td style='width:5%'><input name='actv[]' id='actv[]' value='".$row4[2]."' type='text' style='width:100%' readonly></td>";
					$sql="select nombre from centrocosto where id_cc='$row4[4]'";
					$res=mysql_query($sql,$linkbd);
					$row=mysql_fetch_row($res);
				echo "<td style='width:8%'><input name='cc[]' id='cc[]' value='".$row[0]."' type='text' style='width:100%' readonly></td>";
					$sql="select nombrearea from planacareas where codarea='$row4[5]'";
					$res=mysql_query($sql,$linkbd);
					$row=mysql_fetch_row($res);
				echo "<td style='width:10%'><input name='area[]' id='area[]' value='".$row[0]."' type='text' style='width:100%' readonly></td>";
					$sql="select nombre from actiubicacion where id_cc='$row4[6]'";
					$res=mysql_query($sql,$linkbd);
					$row=mysql_fetch_row($res);
				echo "<td style='width:10%'><input name='ubicacion[]' id='ubicacion[]' value='".$row[0]."' type='text' style='width:100%' readonly></td>";
					$sql="select nombre from centrocosto where id_cc='$row4[9]'";
					$res=mysql_query($sql,$linkbd);
					$row=mysql_fetch_row($res);
				echo "<td style='width:10%'><input name='cc2[]' id='cc2[]' value='".$row[0]."' type='text' style='width:100%' readonly></td>";
					$sql="select nombrearea from planacareas where codarea='$row4[10]'";
					$res=mysql_query($sql,$linkbd);
					$row=mysql_fetch_row($res);
				echo "<td style='width:10%'><input name='area2[]' id='area2[]' value='".$row[0]."' type='text' style='width:100%' readonly></td>";
					$sql="select nombre from actiubicacion where id_cc='$row4[11]'";
					$res=mysql_query($sql,$linkbd);
					$row=mysql_fetch_row($res);
				echo "<td style='width:10%'><input name='ubicacion2[]' id='ubicacion2[]' value='".$row[0]."' type='text' style='width:100%'  readonly></td>
				<td style='width:5%'><input name='fecha[]' id='fecha[]' value='".$row4[13]."' type='text' style='width:100%' readonly></td>
				<td style='width:10%'><input name='concepto[]' id='concepto[]' value='".$row4[3]."' type='text' style='width:100%' readonly></td>
				<td style='text-align:center;'><a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td></tr>";
				$aux=$iter;
				$iter=$iter2;
				$iter2=$aux;
		?>
				<input type="hidden" id="numero" name="numero" value="<?php echo $_POST[numero]?>" >
				<input type="hidden" id="concepto" name="concepto" value="<?php echo $_POST[concepto]?>" >
				<input type="hidden" id="conceptogral" name="conceptogral" value="<?php echo $_POST[conceptogral]?>" >
				<input type="hidden" id="cc" name="cc" value="<?php echo $_POST[cc]?>" >
				<input type="hidden" id="area" name="area" value="<?php echo $_POST[area]?>" >
				<input type="hidden" id="ubicacion" name="ubicacion" value="<?php echo $_POST[ubicacion]?>" >
				<input type="hidden" id="prototipo" name="prototipo" value="<?php echo $_POST[prototipo]?>" >
				<input type="hidden" id="disposicion" name="disposicion" value="<?php echo $_POST[disposicion]?>" >
				<input type="hidden" id="cc2" name="cc2" value="<?php echo $_POST[cc2]?>" >
				<input type="hidden" id="area2" name="area2" value="<?php echo $_POST[area2]?>" >
				<input type="hidden" id="ubicacion2" name="ubicacion2" value="<?php echo $_POST[ubicacion2]?>" >
				<input type="hidden" id="prototipo2" name="prototipo2" value="<?php echo $_POST[prototipo2]?>" >
				<input type="hidden" id="disposicion2" name="disposicion2" value="<?php echo $_POST[disposicion2]?>" >
				<input type="hidden" id="fecha" name="fecha" value="<?php echo $_POST[fecha]?>" >
				
		<?php		
				$_POST[numero]=$row4[2];
				$_POST[concepto]=$row4[3];
				$_POST[conceptogral]=$_POST[descripcion];
				$_POST[cc]=$row4[4];
				$_POST[area]=$row4[5];
				$_POST[ubicacion]=$row4[6];
				$_POST[prototipo]=$row4[7];
				$_POST[dispactivos]=$row4[8];
				$_POST[cc2]=$row4[9];
				$_POST[area2]=$row4[10];
				$_POST[ubicacion2]=$row4[11];
				$_POST[prototipo2]=$row4[12];
				$_POST[dispactivos2]=$row4[13];
				$_POST[fecha]=$row4[17];
			}
		}
			?>
		</table>
	</div>
</form>
	<?php }
if($_POST[oculto]=='2')
{
	$sqlr="select * from  acticrearact_det where placa=$_POST[numero]  ";
	$res=mysql_query($sqlr,$linkbd);
	$r=mysql_fetch_row($res);
	$sqlr="select nit from  configbasica limit 1";
	$da=mysql_query($sqlr,$linkbd);
	$nt=mysql_fetch_row($da);
	$sqlr="select cuenta_activo from  acti_activos_det where centro_costos='".$_POST[cc]."' and tipo='".substr($_POST[numero],0,6)."' limit 1";
	$en=mysql_query($sqlr,$linkbd);
	$ce=mysql_fetch_row($en);
	$sqlr="select cuenta_activo from  acti_activos_det where centro_costos='".$_POST[cc2]."' and tipo='".substr($_POST[numero],0,6)."' limit 1";
	$sa=mysql_query($sqlr,$linkbd);
	$cs=mysql_fetch_row($sa);
	if($cs!=''){
		if($_POST[tipomov]=="102"){
			$linkbd=conectar_bd();
			$sqlr="select count(*) from actitraslados_cab where id_traslado_cab=$_POST[idcomp]  ";
			$res=mysql_query($sqlr,$linkbd);
			//echo "t:".$_POST[tipotras];
			while($r=mysql_fetch_row($res))
			{
				$numerorecaudos=$r[0];
			}
			if($numerorecaudos==0)
			{ 	
				ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
				$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
				//************CREACION DEL COMPROBANTE CONTABLE ************************6246
				//***busca el consecutivo del comprobante contable
				$consec=0;
				$consec=$_POST[idcomp];
				$sqlr="insert into actitraslados_cab (id_traslado_cab,fecha,vigencia,estado,concepto,tipomov,tipotras) values('$_POST[idcomp]','$fechaf','".$vigusu."','S','$_POST[conceptogral]','$_POST[tipomov]','$_POST[tipotras]')";	
				mysql_query($sqlr,$linkbd);
				$sqlrd="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito, estado,vigencia,tipo_comp,numerotipo,numacti) VALUES ('75 ".$_POST[idcomp]."','".$ce[0]."','".$nt[0]."','".$_POST[cc]."','".$_POST[concepto]."','','".$r[12]."','0','1','".$vigusu."','75','".$_POST[idcomp]."','".$_POST[numero]."')";
				mysql_query($sqlrd);
				$sqlrd="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito, estado,vigencia,tipo_comp,numerotipo,numacti) VALUES ('75 ".$_POST[idcomp]."','".$ce[0]."','".$nt[0]."','".$_POST[cc]."','".$_POST[concepto]."','','0','".$r[12]."','1','".$vigusu."','75','".$_POST[idcomp]."','".$_POST[numero]."')";
				mysql_query($sqlrd);			
				$sqlrd="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito, estado,vigencia,tipo_comp,numerotipo,numacti) VALUES ('75 ".$_POST[idcomp]."','".$cs[0]."','".$nt[0]."','".$_POST[cc2]."','".$_POST[concepto]."','','".$r[12]."','0','1','".$vigusu."','75','".$_POST[idcomp]."','".$_POST[numero]."')";
				mysql_query($sqlrd);
				$sqlrd="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito, estado,vigencia,tipo_comp,numerotipo,numacti) VALUES ('75 ".$_POST[idcomp]."','".$cs[0]."','".$nt[0]."','".$_POST[cc2]."','".$_POST[concepto]."','','0','".$r[12]."','1','".$vigusu."','75','".$_POST[idcomp]."','".$_POST[numero]."')";
				mysql_query($sqlrd);
				$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ('".$_POST[idcomp]."','75','$fc_1198971545','".strtoupper($_POST[conceptogral])."','0','0','0','0','1')";
				mysql_query($sqlr,$linkbd);
				echo "<input type='hidden' name='ncomp' value='$idcomp'>";
				if($_POST[tipotras]=='1')
				{
					$sqlr="insert into actitraslados (id_trasladocab,activo,concepto,cco,area1,ubicacion1,prototipo,dispoactivo,ccd,area2,ubicacion2,prototipo2,dispoactivo2,estado,tipomov) values($_POST[idcomp],'".$_POST[numero]."','".$_POST[concepto]."','".$_POST[cc]."','".$_POST[area]."','".$_POST[ubicacion]."','".$_POST[prototipo]."','".$_POST[dispactivos]."','".$_POST[cc2]."','".$_POST[area2]."','".$_POST[ubicacion2]."','".$_POST[prototipo2]."','".$_POST[dispactivos2]."','S','".$_POST[tipomov]."')";
					if (!mysql_query($sqlr,$linkbd))
					{
						echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
						//$e =mysql_error($respquery);
						echo "Ocurrió el siguiente problema:<br>";
						//echo htmlentities($e['message']);
						echo "<pre>";
						//echo htmlentities($e['sqltext']);
						//printf("\n%".($e['offset']+1)."s", "^");
						echo "</pre></center></td></tr></table>";
					}
					else
					{
						echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado los Traslados con Exito <img src='imagenes/confirm.png'></center></td></tr></table>";
					}
					$sqlr="update acticrearact_det SET cc='".$_POST[cc2]."', area='".$_POST[area2]."', ubicacion='".$_POST[ubicacion2]."', prototipo='".$_POST[prototipo2]."', dispoact='".$_POST[dispactivos2]."' where placa=".$_POST[numero];
					if (!mysql_query($sqlr,$linkbd))
					{
						echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
						//$e =mysql_error($respquery);
						echo "Ocurrió el siguiente problema:<br>";
						//echo htmlentities($e['message']);
						echo "<pre>";
						//echo htmlentities($e['sqltext']);
						//printf("\n%".($e['offset']+1)."s", "^");
						echo "</pre></center></td></tr></table>";
					}
					else
					{
						echo "<script>despliegamodalm('visible','1','Se ha almacenado con Exito');</script>";
					}
				}
					
				if($_POST[tipotras]=='2')
				{
					for($x=0;$x<count($_POST[dbancos]);$x++)
					{
						if($_POST[tipotrasext]=='1')
						{
							$debito=$_POST[dvalores][$x];
							$credito=0;	 
						}
						if($_POST[tipotrasext]=='2')
						{
							$debito=0;
							$credito=$_POST[dvalores][$x];	 	 
						}	
					}	
				}
			}
			else
			{
				echo "<table class='inicio'><tr><td class='saludo1'><center>Ya existe un traslado con este consecutivo <img src='imagenes/alert.png'></center></td></tr></table>";
			}
		}
	
		if($_POST[tipomov]=="302"){
			$linkbd=conectar_bd();
			$sqlr="select count(*) from actitraslados_cab where id_traslado_cab=$_POST[idcomp]";
			$res=mysql_query($sqlr,$linkbd);
			//echo "t:".$_POST[tipotras];
			while($r=mysql_fetch_row($res))
			{
				$numerorecaudos=$r[0];
			}
			if($numerorecaudos==0)
			{ 	
				ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
				$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
				//************CREACION DEL COMPROBANTE CONTABLE ************************6246
				//***busca el consecutivo del comprobante contable
				$consec=0;
				$linkbd=conectar_bd();
				$sqlr="update actitraslados_cab SET estado='R' where id_traslado_cab='$_POST[traslid]'";	
				mysql_query($sqlr,$linkbd);
				$sqlr="insert into actitraslados_cab (id_traslado_cab,fecha,vigencia,estado,concepto,tipomov,tipotras) values('$_POST[traslid]','$_POST[fecha]','".$vigusu."','R','$_POST[conceptogral]','$_POST[tipomov]','$_POST[tipotras]')";	
				mysql_query($sqlr,$linkbd);
				$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($_POST[traslid],75,'$fc_1198971545','".strtoupper($_POST[conceptogral])."',0,'0','0',0,'1')";
				mysql_query($sqlr,$linkbd);
				$sqlrd="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito, estado,vigencia,tipo_comp,numerotipo,numacti) VALUES ('75 $_POST[traslid]','".$ce[0]."','".$nt[0]."','".$_POST[cc]."','".$_POST[concepto]."','',".$r[valor].",0,'1','".$_POST[vigencia]."',75,$_POST[traslid],".$_POST[numero].")";
				mysql_query($sqlrd);
				$sqlrd="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito, estado,vigencia,tipo_comp,numerotipo,numacti) VALUES ('75 $_POST[traslid]','".$ce[0]."','".$nt[0]."','".$_POST[cc]."','".$_POST[concepto]."','',0,".$r[valor].",'1','".$_POST[vigencia]."',75,$_POST[traslid],".$_POST[numero].")";
				mysql_query($sqlrd);			
				$sqlrd="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito, estado,vigencia,tipo_comp,numerotipo,numacti) VALUES ('75 $_POST[traslid]','".$cs[0]."','".$nt[0]."','".$_POST[cc2]."','".$_POST[concepto]."','',".$r[valor].",0,'1','".$_POST[vigencia]."',75,$_POST[traslid],".$_POST[numero].")";
				mysql_query($sqlrd);
				$sqlrd="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito, estado,vigencia,tipo_comp,numerotipo,numacti) VALUES ('75 $_POST[traslid]','".$cs[0]."','".$nt[0]."','".$_POST[cc2]."','".$_POST[concepto]."','',0,".$r[valor].",'1','".$_POST[vigencia]."',75,$_POST[traslid],".$_POST[numero].")";
				mysql_query($sqlrd);
				echo "<input type='hidden' name='ncomp' value='$_POST[traslid]'>";
				$sqlr="update actitraslados SET estado='R' where id_trasladocab=".$_POST[traslid];
				if (!mysql_query($sqlr,$linkbd))
				{
					echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
					//	 $e =mysql_error($respquery);
					echo "Ocurrió el siguiente problema:<br>";
					//echo htmlentities($e['message']);
					echo "<pre>";
					//echo htmlentities($e['sqltext']);
					// printf("\n%".($e['offset']+1)."s", "^");
					echo "</pre></center></td></tr></table>";
				}
				else
				{
					echo "<script>despliegamodalm('visible','1','Se ha almacenado con Exito');</script>";
				}
				$sqlr="insert into actitraslados (id_trasladocab,activo,concepto,cco,area1,ubicacion1,prototipo,dispoactivo,ccd,area2,ubicacion2,prototipo2,dispoactivo2,estado,tipomov) values('".$_POST[traslid]."','".$_POST[numero]."','".$_POST[concepto]."','".$_POST[cc]."','".$_POST[area]."','".$_POST[ubicacion]."','".$_POST[prototipo]."','".$_POST[dispactivos]."','".$_POST[cc2]."','".$_POST[area2]."','".$_POST[ubicacion2]."','".$_POST[prototipo2]."','".$_POST[dispactivos2]."','S','".$_POST[tipomov]."')";
				if (!mysql_query($sqlr,$linkbd))
				{
					echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
					//	 $e =mysql_error($respquery);
					echo "Ocurrió el siguiente problema:<br>";
					//echo htmlentities($e['message']);
					echo "<pre>";
					//echo htmlentities($e['sqltext']);
					// printf("\n%".($e['offset']+1)."s", "^");
					echo "</pre></center></td></tr></table>";
				}
				else
				{
					echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado los Traslados con Exito <img src='imagenes/confirm.png'></center></td></tr></table>";
				}
				$sqlr="update acticrearact_det SET cc='".$_POST[cc]."', area='".$_POST[area]."', ubicacion='".$_POST[ubicacion]."', prototipo='".$_POST[prototipo]."', dispoact='".$_POST[dispactivos]."' where placa=".$_POST[numero];
				if (!mysql_query($sqlr,$linkbd))
				{
					echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
					//$e =mysql_error($respquery);
					echo "Ocurrió el siguiente problema:<br>";
					//echo htmlentities($e['message']);
					echo "<pre>";
					//echo htmlentities($e['sqltext']);
					//printf("\n%".($e['offset']+1)."s", "^");
					echo "</pre></center></td></tr></table>";
				}
				else
				{
					echo "<script>despliegamodalm('visible','1','Se ha almacenado con Exito');</script>";
				}
			}	
			else
			{
				echo "<table class='inicio'><tr><td class='saludo1'><center>Ya existe un traslado con este consecutivo <img src='imagenes/alert.png'></center></td></tr></table>";
			}
		}
	}
	else
	{
		echo "<table class='inicio'><tr><td class='saludo1'><center>No puede realizar este traslado, el Centro de Costos Destino o la Disposicion del Activo no se encuentran parametrizados <img src='imagenes/alert.png'></center></td></tr></table>";
	}
}
?>	
</form>
</td></tr>
	<div id="bgventanamodal2">
            <div id="ventanamodal2">
                <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                </IFRAME>
            </div>
   	 	</div>
</body>
</html>