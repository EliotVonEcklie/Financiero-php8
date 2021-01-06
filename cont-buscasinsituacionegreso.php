<?php //V 1000 12/12/16 ?> 
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
		<title>:: SPID - Contabilidad</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
        <script type="text/javascript" src="css/programas.js"></script>
        <script type="text/javascript" src="css/calendario.js"></script>
<script>
	function verUltimaPos(idcta, filas, filtro){
		var scrtop=$('#divdet').scrollTop();
		var altura=$('#divdet').height();
		var numpag=$('#nummul').val();
		var limreg=$('#numres').val();
		if((numpag<=0)||(numpag==""))
			numpag=0;
		if((limreg==0)||(limreg==""))
			limreg=10;
			numpag++;
		location.href="cont-sinsituacionegreso-reflejar.php?idrecaudo="+idcta+"&scrtop="+scrtop+"&totreg="+filas+"&altura="+altura+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
	}
//************* ver reporte ************
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
function buscacta(e)
 {
if (document.form2.cuenta.value!="")
{
 document.form2.bc.value='1';
 document.form2.submit();
 }
 }
function validar()
{
document.form2.submit();
}
function buscater(e)
 {
if (document.form2.tercero.value!="")
{
 document.form2.bt.value='1';
 document.form2.submit();
 }
 }
function agregardetalle()
{
if(document.form2.numero.value!="" &&  document.form2.valor.value>0 &&  document.form2.banco.value!=""  )
{ 
				document.form2.agregadet.value=1;
	//			document.form2.chacuerdo.value=2;
				document.form2.submit();
 }
 else {
 alert("Falta informacion para poder Agregar");
 }
}
//************* genera reporte ************
//***************************************
function eliminar(idr)
{
	if (confirm("Esta Seguro de Eliminar el Recaudo Transferencia "+idr))
  	{
  	document.form2.oculto.value=2;
  	document.form2.var1.value=idr;
	document.form2.submit();
  	}
}
//************* genera reporte ************
//***************************************
function guardar()
{

if (document.form2.fecha.value!='')
  {
	if (confirm("Esta Seguro de Guardar"))
  	{
  	document.form2.oculto.value=2;
  	document.form2.submit();
  	}
  }
  else{
  alert('Faltan datos para completar el registro');
  	document.form2.fecha.focus();
  	document.form2.fecha.select();
  }
}
function pdf()
{
document.form2.action="teso-pdfconsignaciones.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}
function redireccion(ruta){
	window.location.href="cont-sinsituacionegreso-reflejar.php?idrecaudo="+ruta;
}
</script>

<?php titlepag();?>
	<?php
	$scrtop=$_GET['scrtop'];
	if($scrtop=="") $scrtop=0;
	echo"<script>
		window.onload=function(){
			$('#divdet').scrollTop(".$scrtop.")
		}
	</script>";
	$gidcta=$_GET['idcta'];
	if(isset($_GET['filtro']))
		$_POST[nombre]=$_GET['filtro'];
	?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
	<tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("cont");?></tr>
	<tr>
		<td colspan="3" class="cinta">
			<a href="#" class="mgbt"><img src="imagenes/add.png" alt="Nuevo" title="Nuevo"/></a>
			<a class="mgbt"><img src="imagenes/guardad.png"/></a>
			<a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
			<a href="cont-reflejardocs.php" class="mgbt"><img src="imagenes/iratras.png" alt="nueva ventana" title="Atras"></a>
		</td>
	</tr>
</table>
	<?php
	if($_GET[numpag]!=""){
		$oculto=$_POST[oculto];
		if($oculto!=2){
			$_POST[numres]=$_GET[limreg];
			$_POST[numpos]=$_GET[limreg]*($_GET[numpag]-1);
			$_POST[nummul]=$_GET[numpag]-1;
		}
	}
	else{
		if($_POST[nummul]==""){
			$_POST[numres]=10;
			$_POST[numpos]=0;
			$_POST[nummul]=0;
		}
	}
	?>
<form name="form2" method="post" action="cont-buscasinsituacionegreso.php">
<table  class="inicio" align="center" >
	<input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
	<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
	<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
	<input type="hidden" name="oculto2" id="oculto2" value="<?php echo $_POST[oculto2];?>">
	<tr >
		<td class="titulos" colspan="6">:. Buscar Egresos Sin Situacion de Fondos - SSF</td>
		<td width="70" class="cerrar" ><a href="cont-principal.php"> Cerrar</a></td>
	</tr>
	<tr >
		<td width="168" class="saludo1">Numero Egreso:</td>
		<td width="154" ><input name="numero" type="text" value="" >
		</td>
		<td width="144" class="saludo1">Concepto: </td>
		<td width="498" ><input name="nombre" type="text" value="" size="80" ></td>
		<input name="oculto" type="hidden" value="1">
		<input name="var1" type="hidden" value=<?php echo $_POST[var1];?>>
	</tr>                       
    </table>   
    <div class="subpantallap" style="height:69%; width:99.6%; margin-top:0px; overflow-x:hidden" id="divdet">
     
      <?php
	 
$oculto=$_POST['oculto'];
$linkbd=conectar_bd();
$crit1=" ";
$crit2=" ";
if ($_POST[numero]!="")
$crit1=" and tesossfegreso_cab.id_orden  like '%".$_POST[numero]."%' ";
if ($_POST[nombre]!="")
$crit2=" and tesossfegreso_cab.concepto like '%".$_POST[nombre]."%'  ";
//sacar el consecutivo 
//$sqlr="select *from pptosideforigen where".$crit1.$crit2." order by pptosideforigen.codigo";
	$sqlr="select *from tesossfegreso_cab where  tesossfegreso_cab.id_orden>-1 ".$crit1.$crit2." order by tesossfegreso_cab.id_orden";
	

	// echo "<div><div>sqlr:".$sqlr."</div></div>";
	$resp = mysql_query($sqlr,$linkbd);
	$ntr = mysql_num_rows($resp);
	$con=1;
	echo "<table class='inicio'><tr><td colspan='9' class='titulos'>.: Resultados Busqueda:</td></tr><tr><td class='saludo3' colspan='9'>Recaudos Encontrados: $ntr</td></tr><tr><td class='titulos2'>Codigo</td><td class='titulos2'>Fecha</td><td class='titulos2'>Tercero</td><td class='titulos2'>Descripcion</td><td class='titulos2'>Valor</td><td class='titulos2'>Vigencia</td><td class='titulos2'>Estado</td><td class='titulos2' width='5%'><center>Ver</td></tr>";	
	//echo "nr:".$nr;
	$iter='saludo1a';
	$iter2='saludo2';
	$filas=1;
	while ($row =mysql_fetch_row($resp)) 
	{
	switch($row[13]){
		 case "S":
			$estado="Activo";
			break;
		case "N":
			$estado="Anulado";
			break;
		case "R":
			$estado="Reversado";
			break;
	}
	if($gidcta!="")
	{
		if($gidcta==$row[0]){
			$estilo='background-color:yellow';
		}
		else{
			$estilo="";
		}
	}
	else{
		$estilo="";
	}	
	$idcta="'".$row[0]."'";
	$numfil="'".$filas."'";
	$filtro="'".$_POST[nombre]."'";
	$nter=buscatercero($row[6]);
	if($row[8]=='S'){$imgsem="src='imagenes/sema_verdeON.jpg' title='Activo'";} 	 				  
	if($row[8]=='N'){$imgsem="src='imagenes/sema_rojoON.jpg' title='Anulado'";} 	
	 echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" onDblClick=\"verUltimaPos($idcta, $numfil, $filtro)\" style='text-transform:uppercase; $estilo' >
		<td>$row[0]</td>
		<td>$row[2]</td>
		<td>$row[6] - $nter</td>
		<td>$row[7]</td>
		<td>".number_format($row[10],2,",",".")."</td>
		<td >$row[3]</td>
		<td style='text-align:center;'>
		<img $imgsem style='width:18px'/>$estado</td>";
		$idcta="'".$row[0]."'";
		$numfil="'".$filas."'";
		echo"<td style='text-align:center;'>
			<a onClick=\"verUltimaPos($idcta, $numfil, $filtro)\" style='cursor:pointer;' >
				<img src='imagenes/lupa02.png' style='width:18px'>
			</a>
		</td>
	</tr>";
	 $con+=1;
	 $aux=$iter;
	 $iter=$iter2;
	 $iter2=$aux;
	 $filas++;
 }
 echo"</table>";

?></div>
 </form> 
</body>
</html>