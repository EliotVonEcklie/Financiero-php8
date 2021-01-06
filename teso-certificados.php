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
		<title>:: SPID - Tesoreria</title>
		<title>:: SPID - Tesoreria</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
        <script type="text/javascript" src="css/calendario.js"></script>
<script>
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
	if (confirm("Esta Seguro de Eliminar El Egreso No "+idr))
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
function buscatercero(e)
 {
if (document.form2.tercero.value!="")
{
 document.form2.bc.value='1';
 document.form2.submit();
 }
 }
function pdf()
{
document.form2.action="pdfcertificados.php";
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
	<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("teso");?></tr>
	<tr>
		<td colspan="3" class="cinta">
			<a href="#" class="mgbt"><img src="imagenes/add2.png"/></a>
			<a class="mgbt"><img src="imagenes/guardad.png" /></a>
			<a class="mgbt" onClick="document.form2.submit();" href="#"><img src="imagenes/busca.png" title="Buscar" /></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" class="mgbt" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
			<a href="#" class="mgbt" onClick="pdf()"><img src="imagenes/print.png" title="imprimir"></a>
			<a href="<?php echo "archivos/".$_SESSION[usuario]."-reporteegresos.csv"; ?>" target="_blank" class="mgbt"><img src="imagenes/csv.png" title="csv"></a>
		</td>
	</tr>	
</table>
 <form name="form2" method="post" action="teso-certificados.php">
 <?php
  $vigusu=vigencia_usuarios($_SESSION[cedulausu]);
  if($_POST[bc]=='1')
			 {
			  $nresul=buscatercero($_POST[tercero]);
			  if($nresul!='')
			   {
			  $_POST[ntercero]=$nresul;
  	
			  }
			 else
			 {
			  $_POST[ntercero]="";
			  }
			 }

 ?>
<table  class="inicio" align="center" >

      <tr >
        <td class="titulos" colspan="12">:. Certificados</td>
        <td  class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      </tr>
 <tr  >
 <td  class="saludo1">Tercero:          </td>
          <td valign="middle" ><input type="text" id="tercero" name="tercero" size="10" onKeyPress="javascript:return solonumeros(event)" 
		  onKeyUp="return tabular(event,this)" onBlur="buscatercero(event)" value="<?php echo $_POST[tercero]?>" onClick="document.getElementById('tercero').focus();document.getElementById('tercero').select();"><input type="hidden" value="0" name="bc"><a href="#" onClick="mypop=window.open('terceros-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>  </td><td ><input name="ntercero" type="text" id="ntercero" value="<?php echo $_POST[ntercero]?>" size="40" readonly></td>      
                  <td class="saludo1">Tipo Ret:</td><td>
        <select name="tiporet" id="tiporet"  >
   			<option value="" >Seleccione...</option>
			<option value="N" <?php if($_POST[tiporet]=='N') echo "SELECTED"?>>Nacional</option>
  			<option value="D" <?php if($_POST[tiporet]=='D') echo "SELECTED"?>>Departamental</option>
  			<option value="M" <?php if($_POST[tiporet]=='M') echo "SELECTED"?>>Municipal</option>            
			</select>        
        </td>
		
        <td  class="saludo1">Vigencia:</td>
        <td > 
             <select name="vigencias" id="vigencias" 	>
      <option value="">Sel..</option>
	  <?php	  
      for($x=$vigusu;$x>=$vigusu-5;$x--)
	   {
		 $i=$x;  
		 echo "<option  value=$x ";
		 if($i==$_POST[vigencias])
			 	{
				 echo " SELECTED";
				 }
		echo " >".$x."</option>";	    
		}
	  ?>
      </select>
	  </td>
	  	<td class="tamano03">
	  		<input type="checkbox" name="ica" id="ica" class="defaultcheckbox"  <?php if(!empty($_POST[ica])){echo "CHECKED"; }?>/> ICA
		</td>

      <td>
 <input type="button" name="generar" value="Generar" onClick="document.form2.submit()"> <input type="hidden" value="1" name="oculto"></td></tr>                 
    </table>   
        <?php 
			if($_POST[bc]=='1')
			 {
			  $nresul=buscatercero($_POST[tercero]);
			  if($nresul!='')
			   {
			  $_POST[ntercero]=$nresul;
  			  ?>
			  <script>
			  document.form2.fecha.focus();document.form2.fecha.select();</script>
			  <?php
			  }
			 else
			 {
			  $_POST[ntercero]="";
			  ?>
			  <script>alert("Tercero Incorrecta");document.form2.tercero.focus();</script>
			  <?php
			  }
			 }
			 ?>
 <div class="subpantallap" style="height:66.5%; width:99.6%; overflow-x:hidden;">
      <?php
$oculto=$_POST['oculto'];
if($_POST[oculto])
{
$linkbd=conectar_bd();
if($_POST[fecha1]!="" && $_POST[fecha2]!="")
{
$cond=" and tesoegresos.fecha between '$_POST[fecha1]' and '$_POST[fecha2]' ";
}
//sacar el consecutivo 
//$sqlr="select *from pptosideforigen where".$crit1.$crit2." order by pptosideforigen.codigo";
	//consulta incluyendo retenciones
//	$sqlr="select tesoegresos.id_egreso, tesoegresos.id_orden, tesoegresos.tercero, tesoegresos.fecha, tesoegresos.valortotal, tesoegresos.concepto, tesoretenciones.codigo, tesoretenciones.nombre, tesoordenpago_retenciones.valor from tesoegresos, tesoordenpago, tesoordenpago_retenciones, tesoretenciones  where tesoegresos.TERCERO='$_POST[tercero]' AND YEAR(tesoegresos.FECHA) = '$_POST[vigencias]' AND tesoegresos.ESTADO='S' and tesoordenpago.id_orden=tesoegresos.id_orden and tesoordenpago_retenciones.id_orden=tesoordenpago.id_orden and tesoordenpago_retenciones.id_retencion=tesoretenciones.id and tesoretenciones.destino='$_POST[tiporet]' ".$cond." order by tesoegresos.id_egreso DESC";

//consulta sin las retenciones
$crit = "";
if(!empty($_POST[ica]))
{
	$crit = " AND tesoretenciones.id = '16' ";
}
$query="SELECT conta_pago FROM tesoparametros";
$resultado=mysql_query($query,$linkbd);
$arreglo=mysql_fetch_row($resultado);
$opcion=$arreglo[0];
if($opcion=='1')
{
	$sqlr="select tesoordenpago.id_orden, tesoordenpago.id_orden, tesoordenpago.tercero, tesoordenpago.fecha, tesoordenpago.valorpagar, tesoordenpago.conceptorden, tesoretenciones.codigo, tesoretenciones.nombre, tesoordenpago_retenciones.valor from tesoordenpago, tesoordenpago_retenciones, tesoretenciones  where tesoordenpago.tercero='$_POST[tercero]' AND YEAR(tesoordenpago.FECHA) = '$_POST[vigencias]' AND (tesoordenpago.estado!='R' or tesoordenpago.estado!='N') and tesoordenpago_retenciones.id_orden=tesoordenpago.id_orden and tesoordenpago_retenciones.id_retencion=tesoretenciones.id and tesoretenciones.destino='$_POST[tiporet]'  ".$cond.$crit." order by tesoordenpago.id_orden DESC";
}
else
{
	$sqlr="select tesoegresos.id_egreso, tesoegresos.id_orden, tesoegresos.tercero, tesoegresos.fecha, tesoegresos.valortotal, tesoegresos.concepto, tesoretenciones.codigo, tesoretenciones.nombre, tesoordenpago_retenciones.valor from tesoegresos, tesoordenpago, tesoordenpago_retenciones, tesoretenciones  where tesoegresos.TERCERO='$_POST[tercero]' AND YEAR(tesoegresos.FECHA) = '$_POST[vigencias]' AND tesoegresos.ESTADO='S' and tesoordenpago.id_orden=tesoegresos.id_orden and tesoordenpago_retenciones.id_orden=tesoordenpago.id_orden and tesoordenpago_retenciones.id_retencion=tesoretenciones.id and tesoretenciones.destino='$_POST[tiporet]' ".$cond.$crit." order by tesoegresos.id_egreso DESC";
}

$resp = mysql_query($sqlr,$linkbd);
$ntr = mysql_num_rows($resp);
$con=1;
	 $namearch="archivos/".$_SESSION[usuario]."-reporteegresos.csv";
$Descriptor1 = fopen($namearch,"w+"); 
fputs($Descriptor1,"EGRESO;ORDEN PAGO;Doc Tercero;TERCERO;FECHA;VALOR_EGRESO;CONCEPTO;ESTADO\r\n");
echo "<table class='inicio' align='center' ><tr><td colspan='8' class='titulos'>.: Resultados Busqueda:</td></tr><tr><td colspan='8' class='saludo3'>Resultados Encontrados: $ntr</td></tr><tr><td  class='titulos2'>Egreso</td><td  class='titulos2'>Orden Pago</td><td class='titulos2'>Doc Tercero</td><td class='titulos2'>Tercero</td><td class='titulos2'>Fecha</td><td class='titulos2'>Valor Egreso</td><td class='titulos2' ><center>RETENCION</td><td class='titulos2'><center>VLR RETENCION</td></tr>";	
//echo "nr:".$nr;
$iter='saludo1a';
$iter2='saludo2';
	 $sumaegresos=0;
	 $sumaretenciones=0;	 
$retenciones[]=array();
 while ($row =mysql_fetch_row($resp)) 
 {
 //	$sqlret="select tesoretenciones.codigo, tesoretenciones.nombre, tesoordenpago_retenciones.valor from  tesoordenpago_retenciones, tesoretenciones  where tesoordenpago_retenciones.id_orden=tesoordenpago.id_orden and tesoordenpago_retenciones.id_retencion=tesoretenciones.id and tesoretenciones.destino='$_POST[tiporet]'  order by"; 
	 $ntr=buscatercero($row[2]);
	 echo "<tr class='$iter'><td >$row[0]</td><td >$row[1]</td><td >$row[2]</td><td >$ntr</td><td >$row[3]</td><td >".number_format($row[4],2)."</td><td >".strtoupper($row[6])." ".strtoupper($row[7])."</td><td >".strtoupper($row[8])."</td></tr>";
	$retenciones["$row[6]"][0]=$row[6];
	$retenciones["$row[6]"][1]=$row[7];
	$retenciones["$row[6]"][2]+=$row[8];
		$retenciones["$row[6]"][3]+=$row[4];
	 $con+=1;
	 $aux=$iter;
	 $iter=$iter2;
	 $iter2=$aux;
	 $sumaegresos+=$row[4];
	 $sumaretenciones+=$row[8];	 
  fputs($Descriptor1,$row[0].";".$row[2].";".$row[11].";".$ntr.";".$row[3].";".number_format($row[7],2,",","").";".strtoupper($row[8]).";".strtoupper($row[13])."\r\n");
  
 }
 echo "<tr class='$iter'><td class='saludo1' colspan='7'>TOTALES:</td><td class='saludo1'>".number_format($sumaretenciones,2,".",",")."</td></tr>";
 fclose($Descriptor1);
 echo"</table>";
  $tam=count($retenciones);
    foreach($retenciones as $k => $valores )
    {	 
	// echo "<br>".$retenciones[$k][0]." ".$retenciones[$k][1]." ".$retenciones[$k][2];	 
	 echo "<input type='hidden' name='codigo[]' value='".$retenciones[$k][0]."'>";
 	 echo "<input type='hidden' name='nombres[]' value='".$retenciones[$k][1]."'>";
	 echo "<input type='hidden' name='valores[]' value='".$retenciones[$k][2]."'>";
	 echo "<input type='hidden' name='valoresret[]' value='".$retenciones[$k][3]."'>";	 
  	}

}
?></div>
</form>
</td></tr>     
</table>
</body>
</html>