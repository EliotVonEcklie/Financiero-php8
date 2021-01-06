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
		<title>:: Spid - Contabilidad</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/calendario.js"></script>
        <script type="text/javascript" src="css/programas.js"></script>
<script>
//************* ver reporte ************
function verep(idfac){document.form1.oculto.value=idfac;document.form1.submit();}
//************* genera reporte ************
function genrep(idfac){document.form2.oculto.value=idfac;document.form2.submit();}

function pdf()
{
	document.form2.action="pdfauxiliarcuentacon.php";
	document.form2.target="_BLANK";
	document.form2.submit(); 
	document.form2.action="";
	document.form2.target="";
}

function buscacta(e){if (document.form2.cuenta.value!=""){document.form2.bc.value='1';document.form2.submit();}}

function excell()
{
	document.form2.action="cont-auxiliarmovimientosexcel.php";
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
   	<tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("cont");?></tr>
	<tr class="cinta">
		<td colspan="3" class="cinta">
			<a href="cont-expcompman.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a>
			<a href="#" class="mgbt"><img src="imagenes/guardad.png"/></a>
			<a href="#" onClick="document.form2.submit()" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva ventana"></a>
			<a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" title="Imprimir"></a>
			<a href="<?php echo "archivos/".$_SESSION[usuario]."compmanuales.csv"; ?>" class="mgbt"><img src="imagenes/csv.png" title="csv"></a>
		</td>
	</tr>
</table> 
 <form name="form2" method="post" action="cont-expcompman.php">
 <?php
 if($_POST[bc]=='1')
			 {
			  $nresul=buscacuenta($_POST[cuenta]);
			  if($nresul!='')
			   {
			  $_POST[ncuenta]=$nresul;
  	
			  }
			 else
			 {
			  $_POST[ncuenta]="";
			  }
			 }
 ?>
    <table  align="center" class="inicio" >
      <tr >
        <td class="titulos" colspan="10" style='width:93%'>.: Exportar Comprobantes Manuales</td><td style='width:7%' class="cerrar"><a href="cont-principal.php"> Cerrar</a></td>
      </tr>
      <tr  >
        <td width="89" class="saludo1">Fecha Inicial:</td>
        <td width="108"><input name="oculto" type="hidden" value="1"><input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>        </td>
        <td width="78" class="saludo1">Fecha Final: </td>
        <td width="163"><input name="fecha2" type="text" id="fc_1198971546" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha2]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         <a href="#" onClick="displayCalendarFor('fc_1198971546');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>      <input type="button" name="generar" value="Generar" onClick="document.form2.submit()">  </td></tr>                    
    </table>
       
	<div class="subpantallac5" style="height:66.7%; width:99.6%; overflow-x:hidden;">
  <?php
  //**** para sacar la consulta del balance se necesitan estos datos ********
  //**** nivel, mes inicial, mes final, cuenta inicial, cuenta final, cc inicial, cc final  
$oculto=$_POST['oculto'];
if($_POST[oculto])
{
$linkbd=conectar_bd();
	$sumad=0;
	$sumac=0;	
ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	$fechafa2=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
	$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
	$fechafa=$_SESSION[vigencia]."-01-01";
	$fechafa2=date('Y-m-d',$fechafa2-((24*60*60)));
	$inicial=0;
	$saldant=0;
	$compinicial=0;
	 $namearch="archivos/".$_SESSION[usuario]."compmanuales.csv";
$Descriptor1 = fopen($namearch,"w+"); 

fputs($Descriptor1,"FORMATO;ID_COMP;CUENTA;TERCERO;CC;DETALLE;CHEQUE;DEBITO;CREDITO;ESTADO;VIGENCIA\r\n");

fputs($Descriptor1,"FECHA;TIPO_COMP;N COMP;CUENTA;NOM CUENTA;CC;TERCERO;NOM TERCERO;DETALLE;DEBITO;CREDITO\r\n");
  echo "<table class='inicio' ><tr><td colspan='10' class='titulos'>Auxiliar Movimientos<input type='hidden' name='saldoinicial' value='$compinicial'></td></tr>";
  echo "<tr><td class='titulos2' style='width:7%'>Fecha</td><td class='titulos2'>Tipo Comp</td><td class='titulos2'>No Comp</td><td class='titulos2'>Cuenta</td><td class='titulos2'>Nom Cuenta</td><td class='titulos2'>CC</td><td class='titulos2'>Tercero</td><td class='titulos2'>Detalle</td><td class='titulos2'>Debito</td><td class='titulos2'>Credito</td></tr>";
$sqlr="select distinct * from comprobante_cab where   comprobante_cab.fecha between '$fechaf' and '$fechaf2' and comprobante_cab.estado='1'  order by comprobante_cab.fecha, comprobante_cab.tipo_comp, comprobante_cab.numerotipo";
//echo $sqlr;
$cuentainicial='';
$res=mysql_query($sqlr,$linkbd);
$iter='zebra1';
$iter2='zebra2';
	while($row=mysql_fetch_row($res))
 	{
		echo "<tr ><td class='titulop'>$row[3]</td><td colspan='1' class='titulop'>$row2[1]</td><td colspan='1' class='titulop'>$row[1]</td></tr>";	  
		fputs($Descriptor1,"FORMATO;N_COMP;TIPO_COMP;FECHA;CONCEPTO;TOTAL;TOT_DEBITO;TOT_CREDITO;DIFERENCIA;ESTADO\r\n");
		fputs($Descriptor1,"C;$row[1];$row[2];$row[3];$row[4];$row[5];$row[6];$row[7];$row[8];$row[9]\r\n");
		$sqlr="select distinct *from comprobante_det where id_comp='".$row[2]." ".$row[1]."'";
		$res2=mysql_query($sqlr,$linkbd);
		while($row2=mysql_fetch_row($res2))
		{
			$nt=buscatercero($row2[3]);
			$nc=buscacuentacont($row2[2]);
			fputs($Descriptor1,$row[3].";".$row2[1].";".$row[1].";".$row[12].";".$row[12].";".$row[14].";".$row[13].";".$nt.";".$row[15].";".$row[17].";".$row[18]."\r\n");
		  	echo "<tr class='$iter' style='text-transform:uppercase' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\" >
			<td><input type='hidden' name='fechas[]' value='$row[3]'>$row[3]</td>
			<td><input type='hidden' name='tipocomps[]' value='$row2[1]'>$row2[1]</td>
			<td><input type='hidden' name='ncomps[]' value='$row[1]'>$row[1]</td>
			<td><input type='hidden' name='cuentas[]' value='$row2[2]'>$row2[2]</td>
			<td><input type='hidden' name='ncuentas[]' value='$nc'>$nc</td>
			<td><input type='hidden' name='ccs[]' value='$row2[4]'>$row2[4]</td>
			<td><input type='hidden' name='terceros[]' value='$row2[3]'><input type='hidden' name='nterceros[]' value='$nt'>$nt</td>
			<td><input type='hidden' name='detalles[]' value='$row2[5]'>$row2[5]</td>
			<td style='text-align:right;'><input type='hidden' name='debitos[]' value='$row2[7]'>".number_format($row2[7],2)."</td>
			<td style='text-align:right;'><input type='hidden' name='creditos[]' value='$row2[8]'>".number_format($row2[8],2)."</td></tr>";
	 		$sumad+=$row2[7];
			$sumac+=$row2[8];
			$saldant=$ns;
			$aux=$iter;
			$iter=$iter2;
			$iter2=$aux;
		}
 	}
 	 $ns=$compinicial+$sumad-$sumac;
	 fclose($Descriptor1);
 echo "<tr style='text-align:right;'><td colspan='7'></td><td>Totales:</td><td class='saludo1'><input type='hidden' name='sumadebitos' value='$sumad'>$".number_format($sumad,2)."</td><td class='saludo1'><input type='hidden' name='sumacreditos' value='$sumac'>$".number_format($sumac,2)."</td></tr>";
}
?> 
</div></form></td></tr>
<tr><td></td></tr>      
</table>

</body>
</html>