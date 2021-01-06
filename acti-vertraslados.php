<?php
require"comun.inc";
require"funciones.inc";
require "conversor.php";
session_start();
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);

	$linkbd=conectar_bd();
	$scroll=$_GET['scrtop'];
	$totreg=$_GET['totreg'];
	$idcta=$_GET['idcta'];
	$altura=$_GET['altura'];
	$filtro="'".$_GET['filtro']."'";
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
function guardar()
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
function iratras(scrtop, numpag, limreg, filtro){
	var idrecaudo=document.getElementById('idr2').value;
	location.href="acti-buscatraslados.php?idcta="+idrecaudo;
}
</script>
<script>
function atrasc(scrtop, numpag, limreg, filtro, prev){
	var minimo=document.getElementById('minimo').value;
	var actual=document.getElementById('idr1').value;
	if(parseFloat(minimo)<parseFloat(actual)){
		document.getElementById('oculto').value='1';
		document.getElementById('idr2').value=prev;
		var idcta=document.getElementById('idr2').value;
		document.form2.action="acti-vertraslados.php?idr="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg;
	}document.form2.submit();
}
function adelante(scrtop, numpag, limreg, filtro, next){
	var maximo=document.getElementById('maximo').value;
	var actual=document.getElementById('idr1').value;
	if(parseFloat(maximo)>parseFloat(actual)){
		document.getElementById('oculto').value='1';
		document.getElementById('idr2').value=next;
		var idcta=document.getElementById('idr2').value;
		document.form2.action="acti-vertraslados.php?idr="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg;
	}document.form2.submit();
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
	<?php
		$numpag=$_GET[numpag];
		$limreg=$_GET[limreg];
		$scrtop=20*$totreg;
	?>
<table>
	<tr><script>barra_imagenes("acti");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("acti");?></tr>
	<tr  class="cinta">
		<td colspan="3"  class="cinta">
			<a href="acti-traslados.php" class="mgbt"><img src="imagenes/add.png" alt="Nuevo"  border="0" /></a>
			<a class="mgbt1"><img src="imagenes/guardad.png"  alt="Guardar" /></a>
			<a href="acti-buscatraslados.php" class="mgbt"> <img src="imagenes/busca.png"  alt="Buscar" border="0" /></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('acti-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana"></a>
			<a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png"  alt="Buscar" /></a>
			<a onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
			<input type="hidden" value="<?php echo $_POST[idr2]=$_GET[idr]?>" name="idr2" id="idr2">
		</td>
	</tr>		  
</table>
<tr><td colspan="3" class="tablaprin" align="center"> 
<?php
$vigencia=date(Y);
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
if ($_GET[idr]!=""){echo "<script>document.getElementById('codrec').value=$_GET[idr];</script>";}
$sqlr="select MIN(CONVERT(id_trasladocab, SIGNED INTEGER)), MAX(CONVERT(id_trasladocab, SIGNED INTEGER)) from actitraslados ORDER BY id_trasladocab";
$res=mysql_query($sqlr,$linkbd);
$r=mysql_fetch_row($res);
$_POST[minimo]=$r[0];
$_POST[maximo]=$r[1];
$sqlr2="select id_trasladocab from actitraslados where id_traslado=$_GET[idr]";
$res2=mysql_query($sqlr2,$linkbd);
$r2=mysql_fetch_row($res2);
$_POST[idr]=$r2[0];
$vigencia=$vigusu;
 ?>	
<?php
	  //*********** cuenta origen va al credito y la destinnno al debito
if(!$_POST[oculto])
{
	$linkbd=conectar_bd();	 
}
$sqlr2="select * from actitraslados, actitraslados_cab where actitraslados_cab.id_traslado_cab=actitraslados.id_trasladocab and actitraslados.id_traslado='$_POST[idr2]'";
$res2=mysql_query($sqlr2,$linkbd);
$row2=mysql_fetch_row($res2);


//NEXT
$sqln="select *from actitraslados WHERE id_trasladocab > $_POST[idr] and ((tipomov='102' and estado='S') or (tipomov='302' and estado='R')) ORDER BY id_trasladocab ASC LIMIT 1";
$resn=mysql_query($sqln,$linkbd);
$rowp=mysql_fetch_row($resn);
$next="'".$rowp[0]."'";
//PREV
$sqlp="select *from actitraslados WHERE id_trasladocab < $_POST[idr] and ((tipomov='102' and estado='S') or (tipomov='302' and estado='R')) ORDER BY id_trasladocab DESC LIMIT 1";
$resp=mysql_query($sqlp,$linkbd);
$rowp=mysql_fetch_row($resp);
$prev="'".$rowp[0]."'";

?>
 <div id="bgventanamodalm" class="bgventanamodalm">
        <div id="ventanamodalm" class="ventanamodalm">
            <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
            </IFRAME>
        </div>
</div>
 <form name="form2" method="post" action=""> 
	<table class="inicio" align="center" >
		<tr >
			<td class="titulos" colspan="6">.: Ver Traslados</td>
			<td class="cerrar" ><a href="acti-principal.php">  Cerrar</a></td>
		</tr>
		<tr>
			<td class="saludo1" >Numero Comp:</td>
			<td>
				<a href="#" onClick="atrasc(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $prev; ?>)">
				   	<img src="imagenes/back.png" title="anterior" align="absmiddle">
				</a> 
				<input id="idcomp" name="idcomp" type="text" size="5" value="<?php echo $row2[1] ?>" readonly />
				<a href="#" onClick="adelante(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $next; ?>)">
					<img src="imagenes/next.png" title="siguiente" align="absmiddle">
				</a>
				<input name="cuentatraslado" type="hidden" size="5" value="<?php echo $_POST[cuentatraslado]?>">
				<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo" id="maximo">
				<input type="hidden" value="<?php echo $_POST[minimo]?>" name="minimo" id="minimo">
				<input type="hidden" value="<?php echo $_POST[idr]?>" name="idr1" id="idr1">
				<input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">
			</td>
			<td class="saludo1">Fecha:</td>
			<td >
				<input id="fc_1198971545" title="DD/MM/YYYY" name="fecha" type="text" value="<?php echo $row2[17] ?>" maxlength="10" size="10" readonly>
				<input type="hidden" value="<?php echo $row2[18] ?>" name="vigencia" id="vigencia">
			</td>
			<td class="saludo1">Tipo Movimiento:</td>
			<?php
                if($row2[14]=="S")
				{
					echo "<td ><center><input name='estado' type='text' value='ACTIVO' size='5' style='width:98%; background-color:#0CD02A; color:white; text-align:center;' readonly ></center></td>";
				}
				else
				{
					echo "<td ><center><input name='estado' type='text' value='REVERSADO' size='5' style='width:98%; background-color:#FF0000; color:white; text-align:center;' readonly ></center></td>";
				}
			$_POST[tipotras]=$row2[22];
			?>
</tr>
	<tr>
	  <td  class="saludo1">Concepto Traslado General:</td>
	  <td colspan="3"><input id="conceptogral" name="conceptogral" type="text" value="<?php echo $row2[3] ?>" size="144" readonly></td>
	</tr>
	<tr>
	<td class="saludo1">Tipo Traslado</td>
	<td><input type='text' name='tipotras' id='tipotras' value="<?php if($_POST[tipotras]=='2'){echo "Externo";}else{echo "Interno";} ?>" size='30' readonly></td>
	<?php
	if($_POST[tipotras]==2)
	{
		?>
		<td class="saludo1">Tipo Traslado</td>
		<td>
		<input type="text" name="tipotrasext" id="tipotrasext" value="<?php echo $_POST[tipotrasext]?>" size="30" readonly>
		</td>
		<?php
	}
	$sql="select nombre from acticrearact_det where placa='$row2[2]'";
	$res=mysql_query($sql,$linkbd);
	$row=mysql_fetch_row($res);
	?>
	</tr>
	<tr>
        <td  class="saludo1">Numero Placa Activo:</td>
        <td><input id="numero" name="numero" type="text" value="<?php echo $row2[2] ?>" size="30" readonly></td>
		<td  class="saludo1">Descripcion Activo:</td>
		<td><input id="nactivo" name="nactivo" type="text" value="<?php echo $row[0] ?>" size="80" onKeyUp="return tabular(event,this)" readonly></td>
	</tr>
	<tr>
	<?php
		$sql="select nombre from centrocosto where id_cc='$row2[4]'";
		$res=mysql_query($sql,$linkbd);
		$row=mysql_fetch_row($res);
	?>
		<td class="saludo1">Centro Costo :</td>
		<td><input id="cc" name="cc" value="<?php echo $row[0]?>" type="text" size="30" readonly></td>
	<?php
		$sql="select nombrearea from planacareas where codarea='$row2[5]'";
		$res=mysql_query($sql,$linkbd);
		$row=mysql_fetch_row($res);
	?>
		<td class="saludo1">Dependencia de Origen:</td>
		<td><input id="area" name="area" value="<?php echo $row[0]?>" type="text" size="80" readonly></td>
	<?php
		$sql="select nombre from actiubicacion where id_cc='$row2[6]'";
		$res=mysql_query($sql,$linkbd);
		$row=mysql_fetch_row($res);
	?>
		<td class="saludo1">Ubicacion Origen :</td>
		<td><input id="ubicacion" name="ubicacion" value="<?php echo $row[0]?>" type="text" size="30" readonly>
		</td>
	</tr>
	<tr>
	<?php
		$sql="select nombre from acti_prototipo where id='$row2[7]'";
		$res=mysql_query($sql,$linkbd);
		$row=mysql_fetch_row($res);
	?>
		<td class="saludo1">Prototipo Origen :</td>
		<td><input id="prototipo" name="prototipo" value="<?php echo $row[0]?>" type="text" size="30" readonly></td>
	<?php
		$sql="select nombre from acti_disposicionactivos where id='$row2[8]'";
		$res=mysql_query($sql,$linkbd);
		$row=mysql_fetch_row($res);
	?>
		<td class="saludo1">Disposicion Del Activo  :</td>
		<td><input id="dispoactivo" name="dispoactivo" value="<?php echo $row[0]?>" type="text" size="80" readonly></td>
	</tr>
	<?php
	if($_POST[tipotras]==1)
	{
	?>
		<tr>
		<?php
			$sql="select nombre from centrocosto where id_cc='$row2[9]'";
			$res=mysql_query($sql,$linkbd);
			$row=mysql_fetch_row($res);
		?>
			<td class="saludo1">Centro Costo Destino:</td>
			<td><input id="cc2" name="cc2" value="<?php echo $row[0]?>" type="text" size="30" readonly></td>
		<?php
			$sql="select nombrearea from planacareas where codarea='$row2[10]'";
			$res=mysql_query($sql,$linkbd);
			$row=mysql_fetch_row($res);
		?>
			<td class="saludo1">Dependencia Destino :</td>
			<td><input id="area2" name="area2" value="<?php echo $row[0]?>" type="text" size="80" readonly>
				<input type="hidden" id="narea2" name="narea2" value="<?php echo $_POST[narea2]?>">
			</td>
		<?php
			$sql="select nombre from actiubicacion where id_cc='$row2[11]'";
			$res=mysql_query($sql,$linkbd);
			$row=mysql_fetch_row($res);
		?>
			<td class="saludo1">Ubicacion Destino :</td>
			<td><input id="ubicacion2" name="ubicacion2" value="<?php echo $row[0]?>" type="text" size="30" readonly>
				<input type="hidden" id="nubicacion2" name="nubicacion2" value="<?php echo $_POST[nubicacion2]?>">
			</td>
		</tr>
		<tr>
		<?php
			$sql="select nombre from acti_prototipo where id='$row2[12]'";
			$res=mysql_query($sql,$linkbd);
			$row=mysql_fetch_row($res);
		?>
			<td class="saludo1">Prototipo Destino :</td>
			<td><input id="prototipo2" name="prototipo2" value="<?php echo $row[0]?>" type="text" size="30" readonly></td>
		<?php
			$sql="select nombre from acti_disposicionactivos where id='$row2[13]'";
			$res=mysql_query($sql,$linkbd);
			$row=mysql_fetch_row($res);
		?>
			<td class="saludo1">Disposicion Del Activo Destino:</td>
			<td><input id="dispoactivo2" name="dispoactivo2" value="<?php echo $row[0]?>" type="text" size="80" readonly></td>
		</tr>
		<?php
	}
	?>
	<tr>	
		<td  class="saludo1">Concepto Traslado Activo:</td>
		<td colspan="3">
			<input id="concepto" name="concepto" type="text" value="<?php echo $row2[20]?>" size="144" readonly>
			<input type="hidden" value="1" id="oculto" name="oculto">
		</td>
	</tr> 	  
	</div>	
</form>
 </td></tr>  
</table>
</body>
</html>