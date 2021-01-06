<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";
require"validaciones.inc";
require "conversor.php";
session_start();
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<title>:: SPID - Tesoreria</title>

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
//************* genera reporte ************
//***************************************
function guardar()
{

if (document.form2.vigencia.value!='' && document.form2.fecha.value!='' && document.form2.solicita.value!='')
  {
	if (confirm("Esta Seguro de Guardar"))
  	{
  	document.form2.oculto.value=2;
  	document.form2.submit();
	document.form2.action="pdfcdp.php";
  	}
  }
  else{
  alert('Faltan datos para completar el registro');
  	document.form2.fecha.focus();
  	document.form2.fecha.select();
  }
}
</script>
<script >
function validar(formulario)
{
document.form2.action="presu-cdp.php";
document.form2.submit();
}
</script>
<script >
function validar2(formulario)
{
document.form2.chacuerdo.value=2;
document.form2.action="presu-cdp.php";
document.form2.submit();
}
</script>

<script >
function validarcdp()
{
valorp=document.getElementById("valor").value;
nums=quitarpuntos(valorp);			
if(nums<0 || nums> parseFloat(document.form2.saldo.value))
{
		alert('Valor Superior al Disponible '+document.form2.saldo.value);
document.form2.cuenta.select();
document.form2.cuenta.focus();
}
}
</script>
<script>
function buscacta(e)
 {
if (document.form2.cuenta.value!="")
{
 document.form2.bc.value=2;
 document.form2.submit();
 }
 }
</script>
<script>
function agregardetalle()
{
if(document.form2.cuenta.value!="" &&  document.form2.fuente.value!="" && parseFloat(document.form2.valor.value) >=0 )
{ 
				document.form2.agregadet.value=1;
	//			document.form2.chacuerdo.value=2;
				document.form2.submit();
 }
 else {
 alert("Falta informacion para poder Agregar");
 }
}
</script>
<script>
function eliminar(variable)
{
if (confirm("Esta Seguro de Eliminar"))
  {
  document.form2.chacuerdo.value=2;
document.form2.elimina.value=variable;
//eli=document.getElementById(elimina);
document.getElementById('elimina').value=variable;
//eli.value=elimina;
//vvend.value=variable;
document.form2.submit();
}
}
</script>
<script>
function pdf()
{
document.form2.action="pdfcdispre.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}
</script>
<script>
function finaliza()
 {
  if (confirm("Confirme Guardando el Documento, al completar el Proceso"))
  {
	  document.form2.fin.value=1;
	  document.form2.fin.checked=true; 
  } 
  else
  	  document.form2.fin.value=0;
  document.form2.fin.checked=false; 
 }
</script>

<script>
function capturaTecla(e){ 
var tcl = (document.all)?e.keyCode:e.which;
if (tcl==115){
alert(tcl);
return tabular(e,elemento);
}
}
</script>
<script src="css/programas.js"></script>
<script src="css/calendario.js"></script>
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<link href="css/css3.css" rel="stylesheet" type="text/css" />
<?php titlepag();?>
</head>
<body >
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
	<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("teso");?></tr>
<tr>
  <td colspan="3" class="cinta">
	  <a href="teso-reservas.php" class="mgbt" ><img src="imagenes/add.png"  alt="Nuevo" border="0" title="Nuevo"/></a> 
	  <a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  alt="Guardar" title="Guardar"/></a> 
	  <a href="teso-buscareservas.php" class="mgbt"><img src="imagenes/busca.png"  alt="Buscar" border="0" title="Buscar"/></a> 
	  <a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana" class="mgbt" title="Nueva ventana"></a> 
	  <a href="#" <?php if($_POST[oculto]==2) { ?> onClick="pdf()" <?php } ?> class="mgbt"><img src="imagenes/print.png" alt="Imprimir" title="Imprimir"></a>
	  <a href="teso-buscareservas.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
  </td>
</tr></table>
<tr><td colspan="3" class="tablaprin"> 
<?php
//$vigencia=date(Y);
$linkbd=conectar_bd();
$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
$_POST[vigencia]=vigencia_usuarios($_SESSION[cedulausu]); 
$vigencia=$vigusu;
 ?>	
<?php
	if(!$_POST[oculto])
	{
		$link=conectar_bd();
		$sqlr="select * from pptoreservas where vigencia=$_POST[vigencia] and consvigencia=$_GET[id]";
		$res=mysql_query($sqlr,$link);
		//echo $sqlr;
		$r=mysql_fetch_row($res);
		$_POST[numero]=$r[1];
		$_POST[fecha]=$r[2];
		$_POST[objeto]=$r[5];
	}

?>
	<form name="form2" method="post" action="">
		<table class="inicio" align="center" width="80%" >
			<tr >
				<td style="width:95%;" class="titulos" colspan="6">.: Reservas </td>
				<td style="width:5%;" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
			</tr>
			<tr  >
				<td class="saludo1" style="width:5%;">Vigencia:</td>
				<td style="width:5%;">
					<input  style="width:100%;" type="text" name="vigencia" value="<?php echo $_POST[vigencia] ?>" readonly>
				</td>
				<td  class="saludo1" style="width:5%;">Numero:</td>
				<td style="width:8%;">
					<input style="width:100%;" name="numero" type="text" id="numero" value="<?php echo $_POST[numero] ?>"  readonly></td>
				<td class="saludo1" style="width:5%;">Fecha:        </td>
				<td>
					<input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY"  value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" readonly> 
				</td>
			</tr>
			<tr>
				<td class="saludo1">Objeto:</td>
				<td style="width:100%;" colspan="6">
					<input name="objeto" type="text" id="objeto" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[objeto]?>" style="width:60%">
				</td>
			</tr>
		</table>
		<table class="inicio" width="99%">
			<tr>
				<td class="titulos" colspan="5">Detalle Reservas</td>
			</tr>
			<tr>
				<td class="titulos2">Cuenta</td>
				<td class="titulos2">Nombre Cuenta</td>
				<td class="titulos2">Valor</td>
			</tr>
			
			<?php 
				$sqlr="select * from pptoreservas_det where consvigencia=$_POST[numero] and vigencia=$_POST[vigencia]";
				$res=mysql_query($sqlr,$linkbd);
				while($row=mysql_fetch_row($res)){
					$tipo=substr($row[2],0,1);			 
					$nresul=buscacuentapres($row[2],$tipo);
					$iter='zebra1';
					$iter2='zebra2';
					echo "
						<tr class='$iter'>
							<td>$row[2]</td>
							<td>$nresul</td>
							<td>$row[3]</td>
						</tr>";
					$aux=$iter;
					$iter=$iter2;
					$iter2=$aux;
				}
			?>
		</table>
    </form>
  <?php
  //***************PARTE PARA INSERTAR Y ACTUALIZAR LA INFORMACION
$oculto=$_POST['oculto'];
if($_POST[oculto]=='2')
{
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	$bloq=bloqueos($_SESSION[cedulausu],$fechaf);
	if($bloq>=1)
	{
		$linkbd=conectar_bd();
		$sqlr="select count(*) from pptocdp where vigencia='$_POST[vigencia]' and consvigencia=$_POST[numero]";
		$res=mysql_query($sqlr,$linkbd);
		//echo $sqlr;
		while($r=mysql_fetch_row($res))
		{
			$numerorecaudos=$r[0];
		}
		if($numerorecaudos==0)
		{
			$nr="1";	 	
			//************** modificacion del presupuesto **************
			$sqlr="insert into pptocomprobante_cab(numerotipo,tipo_comp,fecha,concepto,vigencia,total_debito,total_credito,diferencia,estado) values($_POST[numero],24,'$fechaf','$_POST[objeto]',$_POST[vigencia],'$_POST[cuentagas2]',0,0,'1')";
			
			$sqlr="insert into pptoreservas (vigencia,consvigencia,fecha,valor,estado,solicita,objeto) values($_POST[vigencia],$_POST[numero],'$fechaf	',$_POST[cuentagas2],'S','$_POST[solicita]','$_POST[objeto]')";
			if (!mysql_query($sqlr,$linkbd))
			{
				echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b> <img src='imagenes\alert.png'> </b></font></p>";
//	 			$e =mysql_error($respquery);
				echo "Ocurrió el siguiente problema:<br>";
				//echo htmlentities($e['message']);
				echo "<pre>";
				///echo htmlentities($e['sqltext']);
				// printf("\n%".($e['offset']+1)."s", "^");
				echo "</pre></center></td></tr></table>";
			}
			else
			{
				echo "<table class='inicio'><tr><td class='saludo1'>Se ha almacenado el CDP con Exito <img src='imagenes\confirm.png'></center></td></tr></table>";
			}
			for ($x=0;$x<count($_POST[dcuentas]);$x++)
			{
				$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values('".$_POST[dcuentas][$x]."','','Reservas','".$_POST[dgastos][$x]."',0,'1','$_POST[vigencia]',25,$_POST[numero],1,'','','$fechaf')";
				mysql_query($sqlr,$linkbd); 			  
				$sqlr="insert into pptoreservas_det (vigencia,consvigencia,cuenta,fuente,valor,estado,saldo,saldo_liberado) values('$_POST[vigencia]','$_POST[numero]','".$_POST[dcuentas][$x]."','".$_POST[dcfuentes][$x]."',".$_POST[dgastos][$x].",'S',".$_POST[dgastos][$x].",0)";
				$res=mysql_query($sqlr,$linkbd);
			}
		}
		else
		{
			echo "<table class='inicio'><tr><td class='saludo1'><center>Ya Existe un CDP con este Numero <img src='imagenes/alert.png'></center></td></tr></table>";
		}
	}
	else
	{
		echo "<div class='inicio'><img src='imagenes\alert.png'> No Tiene los Permisos para Modificar este Documento</div>";	
	}
}//*** if de control de guardado
?> 
</td></tr>     
</table>
</body>
</html>