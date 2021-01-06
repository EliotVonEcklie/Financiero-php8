<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";
session_start();
$linkbd=conectar_bd();	
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
header("Cache-control: private"); // Arregla IE 6
date_default_timezone_set("America/Bogota");
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
$scroll=$_GET['scrtop'];
$totreg=$_GET['totreg'];
$idcta=$_GET['idcta'];
$altura=$_GET['altura'];
$filtro="'".$_GET['filtro']."'";
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID - Almacen</title>
		<script>
			//**************FUNCIONES*********
			function despliegamodal2(_valor,_pag)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else if(_pag=="1"){document.getElementById('ventana2').src="inve-tipocomp.php";}
				else {document.getElementById('ventana2').src="inve-tipocomp.php";}
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden")
				{
					document.getElementById('ventanam').src="";
					if(document.getElementById('valfocus').value=="2")
					{
						document.getElementById('valfocus').value='1';
						document.getElementById('documento').focus();
						document.getElementById('documento').select();
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
							document.getElementById('ventanam').src="inve-tipocomp.php";break;
					}
				}
			}
			function funcionmensaje(){}
			function respuestaconsulta(pregunta){
				switch(pregunta){
					case "1":
						document.form2.oculto.value="2";
						document.form2.submit();
						break;
				}
			}
//************* guardar ************
	function guardar(){
		var validacion00=document.getElementById('numero').value;
		var validacion01=document.getElementById('nombre').value;
		if((validacion00.trim()!='')&&(validacion01.trim()!='')){
			despliegamodalm('visible','4','Esta Seguro de Modificar la Informaci�n del Tipo de Movimiento','1');
		}
		else{
			despliegamodalm('visible','2','Faltan Datos para Completar el Registro');
		}
	}


//***************************************
function verep(idfac)
{
  document.form1.oculto.value=idfac;
  document.form1.submit();
  }
//************* genera reporte ************
//***************************************
function genrep(idfac)
{
  document.form2.oculto.value=idfac;
  document.form2.submit();
  }
//************* genera reporte ************
//***************************************

function clasifica(formulario)
{
//document.form2.action="presu-recursos.php";
document.form2.submit();
}

function agregardetalle()
{
if(document.form2.cuenta.value!=""  && document.form2.cc.value!="" )
 {
document.form2.agregadet.value=1;
document.form2.oculto.value=9;
document.form2.submit();
 }
 else {
 alert("Falta informacion para poder Agregar");
 }
}

function eliminar(variable)
{
if (confirm("Esta Seguro de Eliminar"))
  {
  
document.form2.oculto.value=9;
document.form2.elimina.value=variable;
//eli=document.getElementById(elimina);
vvend=document.getElementById('elimina');
//eli.value=elimina;
vvend.value=variable;
document.form2.submit();
}
}

function buscacta(e)
 {
if (document.form2.cuenta.value!="")
{
 document.form2.bc.value='1';
 document.form2.oculto.value=9;
 document.form2.submit();
 }
 }

function buscacc(e)
 {
if (document.form2.cc.value!="")
{
 document.form2.bcc.value='1';
 document.form2.submit();
 }
 }
function validar()
{
document.form2.oculto.value=9;
document.form2.submit();
}	
function rever()
{
document.form2.nomrev.value=document.form2.nombre.value;	

}
</script>
<script type="text/javascript" src="css/programas.js"></script>
<script type="text/javascript" src="css/calendario.js"></script>
<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script>
			function iratras(scrtop, numpag, limreg, filtro){
				var codmov=document.getElementById('codmov').value;
				var codtm=document.getElementById('codtm').value;
				var idcta=codtm+codmov;
				location.href="inve-buscatipomov.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
			}
		</script>
<?php titlepag();?>
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
    <tr><script>barra_imagenes("inve");</script><?php cuadro_titulos();?></tr>	 
    <tr><?php menu_desplegable("inve");?></tr>
    <tr>
  <td colspan="3" class="cinta"><a href="inve-tipomov.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" border="0" /></a><a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a><a href="inve-buscatipomov.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" border="0" /></a><a href="#" onClick="mypop=window.open('inve-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a><a href="#" onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td>
</tr>
</table>

<?php
//$vigencia=date(Y);
//$linkbd=conectar_bd();
	$_POST[codtm]=$_GET[tm];
	$_POST[codmov]=$_GET[codigo];
 ?>	
<?php
if($_POST[oculto]==0){
	$linkbd=conectar_bd();
	if($_GET[tm]>2)
		$vartm=$_GET[tm]-2;
	else
		$vartm=$_GET[tm];
	$sqlr="select * from almtipomov where almtipomov.codigo='$_GET[codigo]' and tipom='$vartm'";
	//echo $sqlr;
	$res=mysql_query($sqlr,$linkbd); 
	while ($row=mysql_fetch_row($res)){
		$_POST[tipom]=$row[1];
		$_POST[nombre]=$row[2];
		$_POST[numero]=$row[0];
		$_POST[tmov]=$row[1];
		$_POST[nomrev]=$row[2];
		$_POST[numrev]=$row[0];
		$_POST[tipocomp]=$row[4];
		$_POST[requiereActo]=$row[5];
	}
	$sqlrTipoComp = "select nombre from tipo_comprobante where codigo = '$_POST[tipocomp]'";
	$resTipoComp=mysql_query($sqlrTipoComp,$linkbd); 
	$rowTipoComp=mysql_fetch_row($resTipoComp);
	$_POST[ntipocomp]=$rowTipoComp[0];
}
else{
	$linkbd=conectar_bd();
	$sqlr="select *from almtipomov where almtipomov.codigo='$_POST[numero]' and tipom='$_POST[tmov]'  ";
	//echo $sqlr;
	$res=mysql_query($sqlr,$linkbd); 
	while ($row=mysql_fetch_row($res)){
		$_POST[tipom]=$row[1];
		$_POST[numero]=$row[0];
		$_POST[numrev]=$row[0];
	}
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
        <td class="titulos" colspan="10">.: Editar Tipo Movimiento</td>
        <td width="61" class="cerrar" ><a href="inve-principal.php">Cerrar</a></td>
      </tr>
      <tr>
				<td class="saludo1" style="width:10%">Tipo Mov:</td>
				<td style="width:8%">
					<select name="tipom" style="width:90%" onChange="validar()">
		   			<option value="1" <?php if($_POST[tipom]=='1') echo "SELECTED"; ?>>1 - Entrada</option>
          	<option value="2" <?php if($_POST[tipom]=='2') echo "SELECTED"; ?>>2 - Salida</option>
					</select>
					<input type="hidden" value="" id="oculto" name="oculto"> <input type="hidden" value="<?php echo $_POST[tmov]?>" name="tmov"></td>
				<td  class="saludo1" style="width:10%">Codigo Tipo Mov.:</td>
				<td valign="middle" style="width:8%"><input type="text" id="codtipomov" name="codtipomov" style="width:90%"  value="<?php if($_POST[tipom]=="") echo 1; else echo $_POST[tipom]; ?>"  readonly=readonly><input type="hidden" id="codtm" name="codtm" value="<?php echo $_POST[codtm]?>" ><input type="hidden" id="codmov" name="codmov" value="<?php echo $_POST[codmov]?>" ></td>
				<td  class="saludo1" style="width:10%">Nombre:</td>
        <td valign="middle" style="width:40%">
					<input type="text" id="nombre" name="nombre" style="width:90%"
					onKeyUp="return tabular(event,this)" value="<?php echo $_POST[nombre]?>" onClick="document.getElementById('acuerdo').focus();document.getElementById('acuerdo').select();" onKeyDown="rever()" onChange="rever()">
				</td>
				<td class="saludo1" style="width:8%">Requiere Acto:</td>
				<td style="width:30%">
					<select name="requiereActo" id="requiereActo" onKeyUp="return tabular(event,this)" onChange="validar()" >
							<option value="1" <?php if($_POST[requiereActo]=='1') echo "SELECTED"; ?>>NO</option>
							<option value="2" <?php if($_POST[requiereActo]=='2') echo "SELECTED"; ?>>SI</option>
					</select>
				</td>
	    	</tr>
        <tr>	
					<td class="saludo1">Codigo:</td>
					<td valign="middle" style="width:10%">
						<input type="text" id="numero" name="numero" style="width:90%" onKeyPress="javascript:return solonumeros(event)" 
						onKeyUp="return tabular(event,this)" value="<?php echo $_POST[numero]?>" onClick="document.getElementById('numero').focus();document.getElementById('numero').select();" readonly>
					</td>	
        	<td  class="saludo1">Codigo Tipo Mov.:</td>
					<td valign="middle"><input type="text" id="codtipomov" name="codtipomov" style="width:90%" value="<?php if($_POST[tipom]=="")echo 3; else echo $_POST[tipom]+2; ?>"  readonly=readonly></td>
					<td class="saludo1">Codigo Reversi&oacute;n:</td>
					<td valign="middle" style="width:10%"><input type="text" id="numrev" name="numrev" value="<?php echo $_POST[numrev]?>" style="width:90%" readonly=readonly></td>
        </tr>
				<tr>
					<td class="saludo1">Tipo Comprobnte:</td>
					<td>
						<input type="text" id="tipocomp" name="tipocomp" style="width:70%" value="<?php echo $_POST[tipocomp] ?>">
						<img class='icobut' src='imagenes/find02.png'  title='Listado de Articulos' onClick="despliegamodal2('visible','1');"/>
					</td>
					<td valign="middle" colspan="2">
						<input type="text" id="ntipocomp" name="ntipocomp" style="width:100%" value="<?php echo $_POST[ntipocomp]?>" readonly=readonly> 
					</td>
					<td class="saludo1">Nombre Reversi&oacute;n:</td>
					<td valign="middle" ><input type="text" id="nomrev" name="nomrev" style="width:90%" value="<?php echo $_POST[nomrev]?>" readonly=readonly> </td>
					
				</tr>
    </table>
		<div id="bgventanamodal2">
			<div id="ventanamodal2">
					<IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
					</IFRAME>
			</div>
		</div>
</form>
	<?php 
	//********** GUARDAR EL COMPROBANTE ***********
	if($_POST[oculto]=='2'){
		//rutina de guardado cabecera
		$linkbd=conectar_bd();	
		$sqlr="update almtipomov set nombre='$_POST[nombre]', tipo_comp='$_POST[tipocomp]', requiereacto='$_POST[requiereActo]' where codigo='$_POST[numero]' and tipom='$_POST[tipom]'";
		if(!mysql_query($sqlr,$linkbd)){
			echo"<script>despliegamodalm('visible','2','Error no se almaceno');</script>";
		 }
		 else{
			$sqlr="update almtipomov set nombre='$_POST[nombre]' where codigo='$_POST[numero]' and tipom='".($_POST[tipom]+2)."'";
			//echo $sqlr;
			if(!mysql_query($sqlr,$linkbd)){
					echo"<script>despliegamodalm('visible','2','Error no se almaceno');</script>";
		 	}
			else{	 
		 		echo "<script>despliegamodalm('visible','3','Se ha modificado con Exito');</script>";
			}
		}
		//**** crear el detalle del concepto		
	}
	?>	
</td></tr>     
</table>
</body>
</html>