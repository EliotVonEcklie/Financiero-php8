<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";
session_start();
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>:: Spid - Tesoreria</title>

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
</script>
<script>
//************* genera reporte ************
//***************************************
function eliminar(idr)
{
	if (confirm("Esta Seguro de Eliminar el Recibo de Caja"))
  	{
  	document.form2.oculto.value=2;
  	document.form2.var1.value=idr;
	document.form2.submit();
  	}
}
</script>
<script>
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
</script>
<script>
function pdf()
{
document.form2.action="teso-pdfconsignaciones.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
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
	<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("teso");?></tr>
<tr>
  <td colspan="3" class="cinta">
  <a href="teso-recibocaja.php" class="mgbt"><img src="imagenes/add.png" alt="Nuevo" title="Nuevo"/></a>
  <a href="#" class="mgbt"><img src="imagenes/guardad.png" alt="Guardar" title="Guardar"/> 
  <a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" alt="Buscar" title="Buscar" /></a> 
  <a href="teso-liquidapredialexcel.php?tercero=<?php echo $_POST[tercero]?>&fecha1=<?php echo $_POST[fecha]?>&fecha2=<?php echo $_POST[fecha2]?>&conanulados=<?php echo $_POST[conanul]?>" target="_blank"><img src="imagenes/csv.png"  class="mgbt" alt="csv"></a>
  <a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana" title="Nueva Ventana"></a>
  <a href="teso-informestesoreria.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td></tr>	
  </table>
<tr><td colspan="3" class="tablaprin"> 
 <form name="form2" method="post" action="teso-reporteliquidacionpredial.php">
 <?php
	if($_POST[conanul]=='S')
	{
		$chkant=' checked ';
	}
 ?>
<table  class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="7">:. Buscar Liquidacion Predial</td>
        <td width="70" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      </tr>
      <tr >
         <td  class="saludo1">Fecha Inicial:</td>
        <td><input type="hidden" value="<?php echo $ $vigusu ?>" name="vigencias"><input id="fc_1198971545" title="DD/MM/YYYY" name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)"><a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/calendario04.png" style="width:20px" align="absmiddle" border="0"></a></td>
        <td class="saludo1">Fecha Final: </td>
        <td ><input id="fc_1198971546" title="DD/MM/YYYY" name="fecha2" type="text" value="<?php echo $_POST[fecha2]?>" maxlength="10" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)">   
					<a href="#" onClick="displayCalendarFor('fc_1198971546');"><img src="imagenes/calendario04.png" style="width:20px" align="absmiddle" border="0"></a> 
		</td>
		<td class="saludo1" style="width:20%">Generar reporte con recibos anulados</td>
		
		<td>
			<input type="checkbox" name="conanul" id="conanul" value='S' <?php echo $chkant; ?>>
		</td>
		<td>
			<input type="button" name="generar" value="Generar" onClick="document.form2.submit()">
          	<input name="oculto" type="hidden" value="1"><input name="var1" type="hidden" value=<?php echo $_POST[var1];?>></td>
		</td>
        </tr>                       
    </table>    </form> <div class="subpantallap">
   <?php
	
$oculto=$_POST['oculto'];
if($_POST[oculto])
{
	
	function consultar_ingresos($cod,$v=1){
		if ($v==1) {
			$sqlr = "SELECT T2.codigo,T2.nombre FROM tesoreciboscaja_det T1 INNER JOIN tesoingresos T2 ON T1.ingreso=T2.codigo WHERE T1.id_recibos='$cod'";
		}else{
			$sqlr = "SELECT T2.codigo,T2.nombre FROM tesosinreciboscaja_det T1 INNER JOIN tesoingresos T2 ON T1.ingreso=T2.codigo WHERE T1.id_recibos='$cod'";
		}
		$data = view($sqlr);
		foreach ($data as $key => $row) {
			$nomb_ingresos[] = $row[nombre];
			$cod_ingresos[] = $row[codigo];
		}
		$nomb_ingresos = array_unique($nomb_ingresos);
		$cod_ingresos = array_unique($cod_ingresos);
		$codigos = '';
		$nombres = '';
		foreach ($nomb_ingresos as $key => $val) {
			if($key==0){
				$nombres .= $val;
			}else{
				$nombres .= ' - '.$val;
			}
		}
		$datos[nombre] = $nombres;
		foreach ($cod_ingresos as $key => $val) {
			if($key==0){
				$codigos .= $val;
			}else{
				$codigos .= ' - '.$val;
			}
		}
		$datos[codigo] = $codigos;
		return $datos;
	}
$linkbd=conectar_bd();
$crit1=" ";
$crit2=" ";
$fechaf=$_POST[fecha];
$fechaf2=$_POST[fecha2];
ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha1);
$fechaf=$fecha1[3]."-".$fecha1[2]."-".$fecha1[1];
ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha2);
$fechaf2=$fecha2[3]."-".$fecha2[2]."-".$fecha2[1];
if ($_POST[numero]!="")
$crit1=" and tesoreciboscaja.id_recibos like '%".$_POST[numero]."%' ";
if ($_POST[nombre]!="")
{//$crit2=" and tesorecaudos.concepto like '%".$_POST[nombre]."%'  ";}
}
	$sqlr="select *from tesoliquidapredial,tesoliquidapredial_det where tesoliquidapredial.estado<>'' and tesoliquidapredial.fecha BETWEEN '$fechaf' AND '$fechaf2' and tesoliquidapredial.idpredial=tesoliquidapredial_det.idpredial order by tesoliquidapredial.idpredial ASC";
	// echo "<div><div>sqlr:".$sqlr."</div></div>";
	$resp = mysql_query($sqlr,$linkbd);
	$ntr = mysql_num_rows($resp);
	$con=1;
	$namearch="archivos/".$_SESSION[usuario]."-reporteingresos.csv";
	$Descriptor1 = fopen($namearch,"w+"); 
	fputs($Descriptor1,"No LIQUIDACION;VIGENCIA;COD CATASTRAL;TERCERO;FECHA;AVALUO;TASA;PREDIAL;INT PREDIAL;BOMBERIL;INT BOMBERIL;MEDIO AMBIENTE;INT MEDIO AMBIENTE;DESCUENTOS;TOTAL;ID RECIBOS CAJA;FECHA RECIBOS CAJA\r\n");
	echo "<table class='inicio' align='center' >
		<tr>
			<td colspan='17' class='titulos'>.: Resultados Busqueda:</td>
		</tr>
		<tr>
			<td colspan='4'>Recibos de Liquidacion Encontrados: $ntr</td>
		</tr>
		<tr>
			<td class='titulos2'>No liquidacion</td>
			<td class='titulos2' style='width:5%;'>Vigencia</td>
			<td class='titulos2' style='width:10S%;'>Codigo catastral</td>
			<td class='titulos2' style='width:25%;'>Tercero</td>
			<td class='titulos2'>Fecha</td>
			<td class='titulos2'>Avaluo</td>
			<td class='titulos2'>Tasa</td>
			<td class='titulos2'>Pedrial</td>
			<td class='titulos2'>Interes Predial</td>
			<td class='titulos2'>Bomberil</td>
			<td class='titulos2'>Interes Bomberil</td>
			<td class='titulos2'>Medio Ambiente</td>
			<td class='titulos2'>Interes M. Amb.</td>
			<td class='titulos2'>Descuentos</td>
			<td class='titulos2'>Total</td>
			<td class='titulos2'>Recibo Caja</td>
			<td class='titulos2'>Fecha Recibo Caja</td>
		</tr>";	
//echo "nr:".$nr;
$iter='saludo1';
$iter2='saludo2';
 while ($row =mysql_fetch_assoc($resp)) 
 {
	$tercero=buscatercero($row['tercero']);
	$sqlrCaja = "SELECT id_recibos, fecha FROM tesoreciboscaja WHERE id_recaudo=".$row['idpredial']." AND tipo=1";
	$resCaja = mysql_query($sqlrCaja,$linkbd);
	$rowCaja = mysql_fetch_row($resCaja);
    echo "<tr >
    		<td class='$iter'>".$row['idpredial']."</td>
    		<td class='$iter'>".$row['vigliquidada']."</td>
    		<td class='$iter'>".$row['codigocatastral']."</td>
    		<td class='$iter'>".$row['tercero']." - ".$tercero."</td>
    		<td class='$iter'>".$row['fecha']."</td>
    		<td class='$iter'>".$row['avaluo']."</td>
    		<td class='$iter'>".$row['tasav']."</td>
    		<td class='$iter'>".$row['predial']."</td>
    		<td class='$iter'>".$row['intpredial']."</td>
    		<td class='$iter'>".$row['bomberil']."</td>
			<td class='$iter'>".$row['intbomb']."</td>
			<td class='$iter'>".$row['medioambiente']."</td>
			<td class='$iter'>".$row['intmedioambiente']."</td>
			<td class='$iter'>".$row['descuentos']."</td>
			<td class='$iter'>$ ".number_format($row['totaliquidavig'],2)."</td>
			<td class='$iter'>".$rowCaja[0]."</td>
			<td class='$iter'>".$rowCaja[1]."</td>
    	</tr>";	
	$con+=1;
	$aux=$iter;
	$iter=$iter2;
	$iter2=$aux;
	fputs($Descriptor1,$row['idpredial'].";".$row['vigliquidada'].";".$row['codigocatastral'].";".$row['tercero']." - ".$tercero.";".$row['fecha'].";".$row['avaluo'].";".$row['tasav'].";".$row['predial'].";".$row['intpredial'].";".$row['bomberil'].";".$row['intbomb'].";".$row['medioambiente'].";".$row['intmedioambiente'].";".$row['descuentos'].";".$row['totaliquidavig'].";".$rowCaja[0].";".$rowCaja[1]."\r\n");	
 }
 echo"</table>";
}
?></div>
</td></tr>     
</table>
</body>
</html>