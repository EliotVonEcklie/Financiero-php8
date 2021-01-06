<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";
session_start();
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
$linkbd=conectar_bd();
$scroll=$_GET['scrtop'];
$totreg=$_GET['totreg'];
$idcta=$_GET['idcta'];
$altura=$_GET['altura'];
$vigini=$_GET['vigini'];
$vigfin=$_GET['vigfin'];
$padret="'".$_GET['padret']."'";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"  />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>:: Spid - Planeacion Estrategica</title>
<script>

function validar()
{
	document.form2.submit();
}

function guardar()
{
	despliegamodalm('visible','4','Esta Seguro de Guardar','1');
}

function despliegamodalm(_valor,_tip,mensa,pregunta)
{
	document.getElementById("bgventanamodalm").style.visibility=_valor;
	if(_valor=="hidden")
	{
		document.getElementById('ventanam').src="";
		if (document.getElementById('valfocus').value!="0")
		{
			document.getElementById('valfocus').value='0';
			document.getElementById('consecutivo').focus();
			document.getElementById('consecutivo').select();
		}
	}
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

function funcionmensaje(){document.location.href = "";}
function respuestaconsulta(pregunta)
{
	switch(pregunta)
	{
		case "1":	document.form2.oculto.value="2";
					document.form2.submit();break;
	}
}

function calPor(i)
{
	var meta = document.getElementById('mmeta'+i).value;
	var indi = document.getElementById('mindi'+i).value;
	if(meta=="") meta=0;
	if(indi=="") indi=0;
	var porce = Math.round(indi*100/meta);
	document.getElementById('pindi'+i).value=porce;
}

 </script> 
		<script>
			function iratras(scrtop, numpag, limreg, vigini, vigfin, padre){
				var idcta=document.getElementById('codigo').value;
				location.href="plan-plandesarrollobusca.php?idcta="+idcta+"&vigini="+vigini+"&vigfin="+vigfin+"&padret="+padre+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg;
			}
		</script>

<?php titlepag();?>
    <link rel="stylesheet" href="treeview/jquery.treeview.css" />
    <link rel="stylesheet" href="treeview/red-treeview.css" />
	<link rel="stylesheet" href="css/screen.css" />
	<link href="css/css2.css" rel="stylesheet" type="text/css" />
    <link href="css/css3.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="css/programas.js"></script>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
        <?php
		$numpag=$_GET[numpag];
		$limreg=$_GET[limreg];
		$scrtop=26*$totreg;
		?>
<table>
	<tr><script>barra_imagenes("plan");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("plan");?></tr>
	<tr>
		<td colspan="3" class="cinta">
			<a href="plan-crearplandesarrollo.php" ><img src="imagenes/add.png"  alt="Nuevo" border="0" /></a> 
			<a href="#"  onClick="guardar()"><img src="imagenes/guarda.png"  alt="Guardar" /></a> 
			<a href="#" onClick="mypop=window.open('plan-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana"></a> 
			<a href="#" onClick="document.form2.submit()"><img src="imagenes/busca.png"  alt="Buscar" border="0" /></a> 
			<a href="#" onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $vigini; ?>, <?php echo $vigfin; ?>, <?php echo $padret; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
		</td>
	</tr>
</table>
<tr><td colspan="3" class="tablaprin"> 
<?php
$linkbd=conectar_bd();
$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
/*$sqlr="select *from dominios where nombre_dominio='VIGENCIA_PD' and tipo='S' order by VALOR_INICIAL";
$res=mysql_query($sqlr,$linkbd);
while ($row =mysql_fetch_row($res)) 
{*/
	$_POST[vigenciai]=$vigini;
	$_POST[vigenciaf]=$vigfin; 	
	$_POST[codigo]=$idcta;
//}

?>
<?php
if($_POST[oculto]==2){
	$tam=count($_POST[mmeta]);	
	for($i=0;$i<$tam;$i++){
		$sqlu="update planmetasindicadores set valorejecutado='".$_POST[mindi][$i]."' where id='".$_POST[valid][$i]."'";
		$resu=mysql_query($sqlu,$linkbd);
	}
}
?>
<div id="bgventanamodalm" class="bgventanamodalm">
    <div id="ventanamodalm" class="ventanamodalm">
        <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
        </IFRAME>
    </div>
</div>
<form name="form2" method="post">
	<input type="hidden" name="vigenciai" id="vigenciai" value="<?php echo $_POST[vigenciai]?>" > 
	<input type="hidden" name="vigenciaf" id="vigenciaf" value="<?php echo $_POST[vigenciaf]?>" > 
	<table  class="inicio" align="center" >
		<tr >
			<td class="titulos" colspan="1">:: Plan de Desarrollo           
				<input name="oculto" type="hidden" value="1">
				<input name="codigo" id="codigo" type="hidden" value="<?php echo $_POST[codigo]; ?>">
			</td>
			<td class="cerrar" ><a href="plan-principal.php">Cerrar</a></td>
		</tr>
	</table>
	<div class="subpantallap" style="height:73%; width:99.6%; overflow-x:hidden;" id="divdet">
		<?php
		$i=0;
		echo"<table class='inicio'>";
			for($x=$_POST[vigenciai]; $x<=$_POST[vigenciaf];$x++)
			{
				echo "<tr>
					<td class='titulos' colspan='5'>Vigencia $x<input type='hidden' name='vigenciasm[]' value='$x'></td>
				</tr>
				<tr>
					<td class='titulos2'>Codigo</td>
					<td class='titulos2'>Descripci&oacute;n</td>
					<td class='titulos2'>Valor Programado</td>
					<td class='titulos2'>Valor Ejecutado</td>
					<td class='titulos2'>Cumplimiento(%)</td>
				</tr>";
				$sqlp="SELECT presuplandesarrollo.codigo, presuplandesarrollo.nombre, planmetasindicadores.id, planmetasindicadores.valorprogramado, planmetasindicadores.valorejecutado FROM presuplandesarrollo INNER JOIN planmetasindicadores ON presuplandesarrollo.id=planmetasindicadores.codigo WHERE presuplandesarrollo.codigo='$_POST[codigo]' AND planmetasindicadores.vigencia='$x' AND planmetasindicadores.tipo='M'";
				$resp=mysql_query($sqlp,$linkbd);
				while($wp=mysql_fetch_array($resp)){
					$_POST[mindi][$i]=$wp[4];
					$_POST[pindi][$i]=ceil($wp[4]*100/$wp[3]);
					echo'<tr>
						<td>'.$wp[0].'</td>
						<td>'.$wp[1].'</td>
						<td align="center">'.number_format($wp[3],0,',','.').'</td>
						<td>
							<input type="text" id="mindi'.$i.'" name="mindi['.$i.']" style="text-align:center;" value="'.$_POST[mindi][$i].'" onkeyup="calPor('.$i.')" >
							<input type="hidden" id="mmeta'.$i.'" name="mmeta['.$i.']" value="'.$wp[3].'">
							<input type="hidden" id="valid'.$i.'" name="valid['.$i.']" value="'.$wp[2].'">
						</td>
						<td>
							<input type="text" id="pindi'.$i.'" name="pindi['.$i.']" style="text-align:center;" value="'.$_POST[pindi][$i].'" readonly="">
						</td>
					</tr>';
					$i++;
				}
			}
		echo"</table>";
		?>
	</div>
</form>     
</body>
</html>