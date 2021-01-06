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
		<td colspan="3" class="cinta"><a href="cont-auxiliarmovimientos.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a>
			<a class="mgbt"><img src="imagenes/guardad.png"/></a>
			<a href="#" onClick="document.form2.submit()" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
			<a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" title="Imprimir"></a>
			<a href="#" target="_blank"  onClick="excell()" class="mgbt"><img src="imagenes/excel.png" title="Excel"></a>
			<a href="<?php echo "archivos/".$_SESSION[usuario]."movimientos-periodo.csv"; ?>" class="mgbt"><img src="imagenes/csv.png"  title="csv"></a>
			<a href="cont-auxiliarescontabilidad.php" class="mgbt"><img src="imagenes/iratras.png" title="Retornar"></a>
		</td>
  </tr>
</table>
<form name="form2" method="post" action="cont-auxiliarmovimientos.php">
 <?php
 $linkbd=conectar_bd();
 $vigusu=vigencia_usuarios($_SESSION[cedulausu]);
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
        <td class="titulos" colspan="6">.: Auxilar Movimientos</td><td width="70" class="cerrar"><a href="cont-principal.php"> Cerrar</a></td>
      </tr>
      <tr  >
        <td  class="saludo1">Fecha Inicial:</td>
        <td><input name="oculto" type="hidden" value="1"><input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">&nbsp;<a href="#" onClick="displayCalendarFor('fc_1198971545');" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;"></a></td>
        <td class="saludo1">Fecha Final: </td>
        <td><input name="fecha2" type="text" id="fc_1198971546" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha2]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">&nbsp;<a href="#" onClick="displayCalendarFor('fc_1198971546');" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;"></a></td><td class="saludo1">Tipo Comprobantes</td><td   >
        <select name="tipocomprobante" onKeyUp='return tabular(event,this)' >
		  <option value="">Todos</option>	  
		   <?php		  
  		   $sqlr="SELECT * from tipo_comprobante  where estado='S' order by nombre";
			// echo $sqlr;
		 		$resp = mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[3];
				echo "<option value=$row[3] ";
				if($i==$_POST[tipocomprobante])
			 	{
				 $_POST[ntipocomp]=$row[1];
				 echo "SELECTED";
				 }
				echo " >".$row[1]."</option>";	  
			     }			
		  ?>
		  </select>  <input type="button" name="generar" value="Generar" onClick="document.form2.submit()"> </td></tr>                    
    </table>
       
	<div class="subpantallac5" style="height:66.5%; width:99.6%; overflow-x:hidden;">
  <?php
  //**** para sacar la consulta del balance se necesitan estos datos ********
  //**** nivel, mes inicial, mes final, cuenta inicial, cuenta final, cc inicial, cc final  
	$oculto=$_POST['oculto'];
	if($_POST[oculto])
	{
		$sumad=0;
		$sumac=0;	
		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
		$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
		$fechafa2=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
		$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
		$fechafa=$vigusu."-01-01";
		$fechafa2=date('Y-m-d',$fechafa2-((24*60*60)));
		$inicial=0;
		$saldant=0;
		$compinicial=0;
		$criterio1='';
		if($_POST[tipocomprobante]!=''){$criterio1=" and comprobante_cab.tipo_comp=".$_POST[tipocomprobante]."";}
	 	$namearch="archivos/".$_SESSION[usuario]."movimientos-periodo.csv";
		$Descriptor1 = fopen($namearch,"w+"); 
		fputs($Descriptor1,"FECHA;TIPO_COMP;N COMP;CUENTA;NOM CUENTA;CC;TERCERO;NOM TERCERO;DETALLE;DEBITO;CREDITO\r\n");
  		echo "<table class='inicio' >
		<tr><td colspan='10' class='titulos'>Auxiliar Movimientos<input type='hidden' name='saldoinicial' value='$compinicial'></td></tr>
		<tr>
			<td class='titulos2'>Fecha</td>
			<td class='titulos2'>Tipo Comp</td>
			<td class='titulos2'>No Comp</td>
			<td class='titulos2'>Cuenta</td>
			<td class='titulos2'>Nom Cuenta</td>
			<td class='titulos2'>CC</td>
			<td class='titulos2'>Tercero</td>
			<td class='titulos2'>Detalle</td>
			<td class='titulos2'>Debito</td>
			<td class='titulos2'>Credito</td>
		</tr>";
		$sqlr="SELECT distinct * from comprobante_cab,comprobante_det where comprobante_cab.fecha between '$fechaf' and '$fechaf2' and comprobante_det.tipo_comp=comprobante_cab.tipo_comp AND comprobante_det.numerotipo=comprobante_cab.numerotipo  and comprobante_cab.estado='1' ".$criterio1." order by comprobante_cab.fecha, comprobante_cab.tipo_comp, comprobante_cab.numerotipo,comprobante_det.id_det";
		//echo $sqlr;
		$cuentainicial='';
		$res=mysql_query($sqlr,$linkbd);
		$iter='saludo1a';
		$iter2='saludo2';
		while($row=mysql_fetch_row($res))
 		{
	 		$sqlr="SELECT *from tipo_comprobante where codigo=$row[2]";
	 		$res2=mysql_query($sqlr);
	 		$row2=mysql_fetch_row($res2);
	 		$nt=buscatercero($row[13]);
	  		$nc=buscacuenta($row[12]);
	 		$ns=$saldant+$row[17]-$row[18];
	  		if($row[0]!=$cuentainicial)
	  		{		
	   		echo "<tr class='titulop2' ><td>$row[3]</td><td colspan='1'>$row2[1]</td><td colspan='8'>$row[1]</td></tr>";	  
	   		$cuentainicial=$row[0];
	  		}
	  		fputs($Descriptor1,$row[3].";".$row2[1].";".$row[1].";".$row[12].";".$row[12].";".$row[14].";".$row[13].";".$nt.";".$row[15].";".$row[17].";".$row[18]."\r\n");
  			echo "<tr class='$iter' style='font-size:10px;'  onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\">
			<td><input type='hidden' name='fechas[]' value='$row[3]'>$row[3]</td>
			<td><input type='hidden' name='tipocomps[]' value='$row2[1]'>$row2[1]</td>
			<td><input type='hidden' name='ncomps[]' value='$row[1]'>$row[1]</td>
			<td><input type='hidden' name='cuentas[]' value='$row[12]'>$row[12]</td>
			<td><input type='hidden' name='ncuentas[]' value='$nc'>$nc</td>
			<td><input type='hidden' name='ccs[]' value='$row[14]'>$row[14]</td>
			<td><input type='hidden' name='terceros[]' value='$row[13]'><input type='hidden' name='nterceros[]' value='$nt'>$nt</td>
			<td><input type='hidden' name='detalles[]' value='$row[15]'>$row[15]</td>
			<td style='text-align:right;'><input type='hidden' name='debitos[]' value='$row[17]'>".number_format(round($row[17],2),2)."</td>
			<td style='text-align:right;'><input type='hidden' name='creditos[]' value='$row[18]'>".number_format(round($row[18],2),2)."</td></tr>";
			$sumad+=$row[17];
			$sumac+=$row[18];
			$saldant=$ns;
			$aux=$iter;
			$iter=$iter2;
			$iter2=$aux;
 }
 	 $ns=$compinicial+$sumad-$sumac;
	 fclose($Descriptor1);
 echo "<tr><td colspan='7'></td><td>Totales:</td><td class='saludo1'><input type='hidden' name='sumadebitos' value='$sumad'>$".number_format($sumad,2)."</td><td class='saludo1'><input type='hidden' name='sumacreditos' value='$sumac'>$".number_format($sumac,2)."</td></tr></table>";
}
?> 
</div></form>  


</body>
</html>