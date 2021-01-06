<?php //V 1000 12/12/16 ?> 
<?php
	require "comun.inc";
	require "funciones.inc";
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
function validar(){document.form2.submit();}
//************* genera reporte ************
function generarlibro()
{document.form2.oculto.value=2;document.form2.submit();}
function pdf()
{
	document.form2.action="pdflibrodiario.php";
	document.form2.target="_BLANK";
	document.form2.submit(); 
	document.form2.action="";
	document.form2.target="";
}
function buscacta(e){if (document.form2.cuenta.value!=""){document.form2.bc.value='1';document.form2.submit();}}

function excell()
{
	document.form2.action="cont-librodiarioexcel.php";
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
			<a href="cont-librodiario.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a>
			<a href="#" class="mgbt"><img src="imagenes/guardad.png"/></a>
			<a href="#" onClick="document.form2.submit()" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva ventana"></a>
			<a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" title="Imprimir"></a>
			<a href="#" target="_blank"  onClick="excell()" class="mgbt"><img src="imagenes/excel.png" title="Excel"></a>
			<a href="<?php echo "archivos/".$_SESSION[usuario]."movimientos-periodo.csv"; ?>" class="mgbt"><img src="imagenes/csv.png" title="csv"></a>
			<a href="cont-librosoficiales.php" class="mgbt" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
		</td>
	</tr>
</table>
 <form name="form2" method="post" action="cont-librodiario.php">
 <?php
 $vigusu=vigencia_usuarios($_SESSION[cedulausu]);
 $_POST[vigencia]=$vigusu;
 $linkbd=conectar_bd();
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
	 if($_POST[resumido]==1)
	 {
	$chk=" checked";	 
	 }
	 else
	 {
	$chk=" ";	 
	 }
 ?>
    <table  align="center" class="inicio" >
      	<tr>
        	<td class="titulos" colspan="10">.:Libro diario</td><td width="70" class="cerrar"><a href="cont-principal.php"> Cerrar</a></td>
      	</tr>
      	<tr>
			<td class="saludo1" >Mes:</td>
			<td>
				<select name="periodo1" id="periodo1" onChange=""  >
				  	<option value="-1">Seleccione ....</option>
					<?php
					$sqlr="Select * from meses where estado='S' ";
					$resp = mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($resp)) 
					{
						$i=$row[0];
						echo "<option value=$row[0] ";
						if($i==$_POST[periodo1])
			 			{
							echo "SELECTED";
							$diasmes=ultimoDia($vigusu,$row[0]);
							$_POST[periodonom1]=$row[1];
							$_POST[periodo2]=$_POST[periodo1];
							//$_POST[periodonom1]=$row[2];
				 		}
						echo " >".$row[1]."</option>";	  
			    	 }   
					?>
		  		</select>
				
				<input name="fecha" type="hidden" id="fc_1198971545" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">  
				<input id="periodonom1" name="periodonom1" type="hidden" value="<?php echo $_POST[periodonom1]?>" > 
          		<input name="fecha2" type="hidden" id="fc_1198971546" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha2]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">  <input id="periodo2" name="periodo2" type="hidden" value="<?php echo $_POST[periodo2]?>" >
         		<input id="periodonom2" name="periodonom2" type="hidden" value="<?php echo $_POST[periodonom2]?>" > <input id="vigencia" name="vigencia" type="hidden" value="<?php echo $_POST[vigencia]?>" >        
			</td>
			<td class="saludo1" >Año:</td>
			<td>
				<select name="anio" id="anio">
					<option value="-1">Seleccione...</option>
					<?php
					$sqlrAnio =  "SELECT anio FROM admbloqueoanio WHERE bloqueado='N' ORDER BY anio DESC";
					$respAnio = mysql_query($sqlrAnio,$linkbd);
					while ($rowAnio =mysql_fetch_row($respAnio)) 
					{
						$i=$rowAnio[0];
						echo "<option value=$rowAnio[0]";
						if($i==$_POST[anio])
						{
							echo "SELECTED";
							$_POST[anioV] = $i;
						}
						echo " >".$rowAnio[0]."</option>";
					}
					?>
				</select>
				<input type="hidden" name="anioV" id="anioV" value="<?php echo $_POST[anioV];?>">
			</td>
          	<td class="saludo1" >Ordenar:</td> 
        <td>
        <select name="orden" id="orden" onChange=""  >				
                  <?php
					 $sqlr="Select * from DOMINIOS where NOMBRE_DOMINIO='ORDENA_LIBROS' order by valor_inicial ";
		 		$resp = mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value=$row[0] ";
				if($i==$_POST[orden])
			 	{
				 echo "SELECTED";				
				 //$_POST[periodonom1]=$row[2];
				 }
				echo " >$row[0] - ".$row[1]."</option>";	  
			     }   
				 ?>
		  </select></td>
          <td class="saludo1">Resumido</td><td ><input id="resumido" type="checkbox" name="resumido" value="1" onClick="" <?php echo $chk;  ?>>  <input type="button" name="generar" value="Generar" onClick="generarlibro()">   <input name="oculto" type="hidden" value="1">   </td>
          </tr>                    
    </table>
       
	<div class="subpantallac5" style="height:65.5%; width:99.6%; overflow-x:hidden;">
  <?php
  //**** para sacar la consulta del balance se necesitan estos datos ********
  //**** nivel, mes inicial, mes final, cuenta inicial, cuenta final, cc inicial, cc final  
$oculto=$_POST['oculto'];
if($_POST[oculto]==2)
{
$linkbd=conectar_bd();
$uldia=ultimodia($_POST[anio],$_POST[periodo1]);
	$fechaf=$_POST[anio]."-".$_POST[periodo1]."-01";	
	$fechaf2=$_POST[anio]."-".$_POST[periodo1]."-".$uldia;		
switch ($_POST[orden])
 {
  case 1: //fecha	
  if($_POST[resumido]==1)
	 {
		$criterio=" comprobante_cab.id_comp,comprobante_cab.numerotipo,comprobante_cab.tipo_comp, comprobante_cab.fecha, comprobante_cab.concepto, comprobante_cab.estado, comprobante_det.cuenta, comprobante_det.tercero, comprobante_det.centrocosto, comprobante_det.detalle, comprobante_det.vigencia,comprobante_det.numerotipo, comprobante_det.tipo_comp, sum(comprobante_det.valdebito), sum(comprobante_det.valcredito) "; 
		$criterio2=" group by comprobante_cab.numerotipo,comprobante_cab.tipo_comp order by comprobante_cab.fecha, comprobante_cab.tipo_comp, comprobante_cab.numerotipo,comprobante_det.id_det";
	 }
	 else
	  {
		$criterio=" comprobante_cab.id_comp,comprobante_cab.numerotipo,comprobante_cab.tipo_comp, comprobante_cab.fecha, comprobante_det.detalle, comprobante_cab.estado, comprobante_det.cuenta, comprobante_det.tercero, comprobante_det.centrocosto, comprobante_det.detalle, comprobante_det.vigencia, comprobante_det.numerotipo, comprobante_det.tipo_comp, comprobante_det.valdebito, comprobante_det.valcredito";   
		$criterio2="  order by comprobante_cab.fecha, comprobante_cab.tipo_comp, comprobante_cab.numerotipo,comprobante_det.id_det ";
	  }    
  	$sqlr="select  ".$criterio." from comprobante_cab,comprobante_det where   comprobante_cab.fecha between '$fechaf' and '$fechaf2' and comprobante_cab.estado = 1 AND comprobante_det.tipo_comp <> 7 AND comprobante_det.tipo_comp <> 102 AND comprobante_det.tipo_comp <> 100 AND comprobante_det.tipo_comp <> 101 AND comprobante_det.tipo_comp <> 103 AND comprobante_det.tipo_comp<>104 and comprobante_det.tipo_comp=comprobante_cab.tipo_comp AND comprobante_DET.numerotipo=comprobante_cab.numerotipo  ".$criterio2;
	$iter='zebra1';
    $iter2='zebra2';
	$sumad=0;
	$sumac=0;	
	$inicial=0;
	$saldant=0;
	$compinicial=0;
	$compdif='';
	$namearch="archivos/".$_SESSION[usuario]."movimientos-periodo.csv";
$Descriptor1 = fopen($namearch,"w+"); 
fputs($Descriptor1,"FECHA;TIPO_COMP;N COMP;CUENTA;NOM CUENTA;CC;TERCERO;NOM TERCERO;DETALLE;DEBITO;CREDITO\r\n");
  echo "<table class='inicio' ><tr><td colspan='9' class='titulos'>Auxiliar Movimientos<input type='hidden' name='saldoinicial' value='$compinicial'></td></tr>";
  echo "<tr><td class='titulos2'>Tipo Comp</td><td class='titulos2'>No Comp</td><td class='titulos2'>Cuenta</td><td class='titulos2'>Nom Cuenta</td><td class='titulos2'>CC</td><td class='titulos2'>Tercero</td><td class='titulos2'>Detalle</td><td class='titulos2'>Debito</td><td class='titulos2'>Credito</td></tr>";
$cuentainicial='';
//echo $sqlr;
$res=mysql_query($sqlr,$linkbd);
	while($row=mysql_fetch_row($res))
 	{
	 	if($row[1]!=$compdif)
	  	{	
			$aux=$iter;
		 	$iter=$iter2;
		 	$iter2=$aux;
		 	$compdif=$row[1];
	  	}
		$tipocom=buscacomprobante($row[2]);
	 	$nt=buscatercero($row[7]);
	  	$nc=buscacuenta($row[6]);
	 	$ns=$saldant+$row[17]-$row[18];
	  	if($row[3]!=$cuentainicial)
	  	{	
	  		if($cuentainicial!='')
			echo "
			<tr >
				<td class='saludo3' colspan='7'></td>
				<td class='saludo3'>$sumad</td>
				<td class='saludo3'>$sumac</td>
			</tr>
			<tr >
				<td class='ejemplo' colspan='9'><input type='hidden' name='tipocomps[]' value='$row[3]'>$row[3]<input type='hidden' name='ncomps[]' value=''><input type='hidden' name='cuentas[]' value=''><input type='hidden' name='ncuentas[]' value=''><input type='hidden' name='ccs[]' value=''><input type='hidden' name='terceros[]' value=''><input type='hidden' name='nterceros[]' value=''><input type='hidden' name='detalles[]' value=''><input type='hidden' name='debitos[]' value=''><input type='hidden' name='creditos[]' value=''></td>
			</tr>";	  
			$cuentainicial=$row[3];
	  	}
	  	fputs($Descriptor1,$row[3].";".$tipocom.";".$row[1].";".$row[12].";".$row[12].";".$row[14].";".$row[13].";".$nt.";".$row[15].";".$row[17].";".$row[18]."\r\n");
  		echo "
  		<tr class='$iter' style='text-transform:uppercase' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\">
			<td><input type='hidden' name='tipocomps[]' value='$tipocom'>$tipocom</td>
			<td><input type='hidden' name='ncomps[]' value='$row[1]'>$row[1]</td>
			<td><input type='hidden' name='cuentas[]' value='$row[6]'>$row[6]</td>
			<td><input type='hidden' name='ncuentas[]' value='$nc'>$nc</td>
			<td><input type='hidden' name='ccs[]' value='$row[8]'>$row[8]</td>
			<td><input type='hidden' name='terceros[]' value='$row[7]'><input type='hidden' name='nterceros[]' value='$nt'>$nt</td>
			<td><input type='hidden' name='detalles[]' value='$row[4]'>$row[4]</td>
			<td style='text-align:right;'><input type='hidden' name='debitos[]' value='$row[13]'>".number_format($row[13],2)."</td>
			<td style='text-align:right;'><input type='hidden' name='creditos[]' value='$row[14]'>".number_format($row[14],2)."</td>
		</tr>";
		$sumad+=$row[13];
		$sumac+=$row[14];
		$saldant=$ns;
		$aux=$iter;
		 $iter=$iter2;
		 $iter2=$aux;
 	}
 $ns=$compinicial+$sumad-$sumac;
	 fclose($Descriptor1);
 echo "<tr><td colspan='6'></td><td>Totales:</td><td class='saludo1'><input type='hidden' name='sumadebitos' value='$sumad'>$".number_format($sumad,2)."</td><td class='saludo1'><input type='hidden' name='sumacreditos' value='$sumac'>$".number_format($sumac,2)."</td></tr>";	
	
  	break;	 
  case 2: //comprobantes
  if($_POST[resumido]==1)
	 {
		$criterio=" comprobante_cab.id_comp,comprobante_cab.numerotipo,comprobante_cab.tipo_comp, comprobante_cab.fecha, comprobante_cab.concepto, comprobante_cab.estado, comprobante_det.cuenta, comprobante_det.tercero, comprobante_det.centrocosto, comprobante_det.detalle, comprobante_det.vigencia,comprobante_det.numerotipo, comprobante_det.tipo_comp, sum(comprobante_det.valdebito), sum(comprobante_det.valcredito) "; 
		$criterio2=" group by comprobante_cab.numerotipo,comprobante_cab.tipo_comp order by comprobante_cab.tipo_comp, comprobante_cab.numerotipo, comprobante_cab.fecha, comprobante_det.id_det";
	 }
	 else
	  {
		$criterio=" comprobante_cab.id_comp,comprobante_cab.numerotipo,comprobante_cab.tipo_comp, comprobante_cab.fecha, comprobante_det.detalle, comprobante_cab.estado, comprobante_det.cuenta, comprobante_det.tercero, comprobante_det.centrocosto, comprobante_det.detalle, comprobante_det.vigencia, comprobante_det.numerotipo, comprobante_det.tipo_comp, comprobante_det.valdebito, comprobante_det.valcredito";   
		$criterio2="  order by comprobante_cab.tipo_comp, comprobante_cab.numerotipo, comprobante_cab.fecha, comprobante_det.id_det ";
	  }    
  	$sqlr="select ".$criterio." from comprobante_cab,comprobante_det where   comprobante_cab.fecha between '$fechaf' and '$fechaf2' and comprobante_det.tipo_comp=comprobante_cab.tipo_comp AND comprobante_DET.numerotipo=comprobante_cab.numerotipo  ".$criterio2;
	$iter='zebra1';
$iter2='zebra2';
	$sumad=0;
	$sumac=0;	
	$inicial=0;
	$saldant=0;
	$compinicial=0;
	$compdif='';
	$namearch="archivos/".$_SESSION[usuario]."movimientos-periodo.csv";
$Descriptor1 = fopen($namearch,"w+"); 
fputs($Descriptor1,"FECHA;TIPO_COMP;N COMP;CUENTA;NOM CUENTA;CC;TERCERO;NOM TERCERO;DETALLE;DEBITO;CREDITO\r\n");
  echo "<table class='inicio' ><tr><td colspan='9' class='titulos'>Auxiliar Movimientos<input type='hidden' name='saldoinicial' value='$compinicial'></td></tr>";
  echo "<tr><td class='titulos2'>FECHA</td><td class='titulos2'>No Comp</td><td class='titulos2'>Cuenta</td><td class='titulos2'>Nom Cuenta</td><td class='titulos2'>CC</td><td class='titulos2'>Tercero</td><td class='titulos2'>Detalle</td><td class='titulos2'>Debito</td><td class='titulos2'>Credito</td></tr>";
$cuentainicial='';
//echo $sqlr;
$res=mysql_query($sqlr,$linkbd);
while($row=mysql_fetch_row($res))
 {
	 	if($row[1]!=$compdif)
	  {	
	$aux=$iter;
	 $iter=$iter2;
	 $iter2=$aux;
	 $compdif=$row[1];
	  }
	$tipocom=buscacomprobante($row[2]);
	 $nt=buscatercero($row[7]);
	  $nc=buscacuenta($row[6]);
	 $ns=$saldant+$row[17]-$row[18];
	  if($row[2]!=$cuentainicial)
	  {		
	   echo "<tr ><td class='ejemplo' colspan='9'>$tipocom</td></tr>";	  
	   $cuentainicial=$row[2];
	  }
	  fputs($Descriptor1,$row[3].";".$row2[1].";".$row[1].";".$row[12].";".$row[12].";".$row[14].";".$row[13].";".$nt.";".$row[15].";".$row[17].";".$row[18]."\r\n");
  echo "<tr class='$iter' style='text-transform:uppercase' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\">
  <td><input type='hidden' name='fecha[]' value='$row[3]'>$row[3]</td>
  <td><input type='hidden' name='ncomps[]' value='$row[1]'>$row[1]</td>
  <td><input type='hidden' name='cuentas[]' value='$row[6]'>$row[6]</td>
  <td><input type='hidden' name='ncuentas[]' value='$nc'>$nc</td>
  <td><input type='hidden' name='ccs[]' value='$row[8]'>$row[8]</td>
  <td><input type='hidden' name='terceros[]' value='$row[7]'><input type='hidden' name='nterceros[]' value='$nt'>$nt</td>
  <td><input type='hidden' name='detalles[]' value='$row[4]'>$row[4]</td>
  <td style='text-align:right;'><input type='hidden' name='debitos[]' value='$row[13]'>".number_format($row[13],2)."</td>
  <td style='text-align:right;'><input type='hidden' name='creditos[]' value='$row[14]'>".number_format($row[14],2)."</td></tr>";
 	$sumad+=$row[17];
	$sumac+=$row[18];
	$saldant=$ns;
	$aux=$iter;
	$iter=$iter2;
	$iter2=$aux;
 }
 $ns=$compinicial+$sumad-$sumac;
	 fclose($Descriptor1);
 echo "<tr><td colspan='6'></td><td>Totales:</td><td class='saludo1'><input type='hidden' name='sumadebitos' value='$sumad'>$".number_format($sumad,2)."</td><td class='saludo1'><input type='hidden' name='sumacreditos' value='$sumac'>$".number_format($sumac,2)."</td></tr>";	

  	break;	 
  case 3: //cuenta
  if($_POST[resumido]==1)
	 {
		$criterio=" comprobante_cab.id_comp,comprobante_cab.numerotipo,comprobante_cab.tipo_comp, comprobante_cab.fecha, comprobante_cab.concepto, comprobante_cab.estado, comprobante_det.cuenta, comprobante_det.tercero, comprobante_det.centrocosto, comprobante_det.detalle, comprobante_det.vigencia,comprobante_det.numerotipo, comprobante_det.tipo_comp, sum(comprobante_det.valdebito), sum(comprobante_det.valcredito) "; 
		$criterio2="group by comprobante_det.cuenta order by  comprobante_det.cuenta, comprobante_cab.tipo_comp, comprobante_cab.numerotipo, comprobante_cab.fecha, comprobante_det.id_det";
	 }
	 else
	  {
		$criterio=" comprobante_cab.id_comp,comprobante_cab.numerotipo,comprobante_cab.tipo_comp, comprobante_cab.fecha, comprobante_det.detalle, comprobante_cab.estado, comprobante_det.cuenta, comprobante_det.tercero, comprobante_det.centrocosto, comprobante_det.detalle, comprobante_det.vigencia, comprobante_det.numerotipo, comprobante_det.tipo_comp, comprobante_det.valdebito, comprobante_det.valcredito";   
		$criterio2=" group by comprobante_det.cuenta, comprobante_cab.numerotipo,comprobante_cab.tipo_comp order by comprobante_det.cuenta, comprobante_cab.tipo_comp, comprobante_cab.numerotipo, comprobante_cab.fecha, comprobante_det.id_det ";
	  }    
  	$sqlr="select  ".$criterio." from comprobante_cab,comprobante_det where   comprobante_cab.fecha between '$fechaf' and '$fechaf2' and comprobante_det.tipo_comp=comprobante_cab.tipo_comp AND comprobante_DET.numerotipo=comprobante_cab.numerotipo ".$criterio2;
	$iter='zebra1';
$iter2='zebra2';
	$sumad=0;
	$sumac=0;	
	$inicial=0;
	$saldant=0;
	$compinicial=0;
	$compdif='';
	$namearch="archivos/".$_SESSION[usuario]."movimientos-periodo.csv";
$Descriptor1 = fopen($namearch,"w+"); 
fputs($Descriptor1,"FECHA;TIPO_COMP;N COMP;CUENTA;NOM CUENTA;CC;TERCERO;NOM TERCERO;DETALLE;DEBITO;CREDITO\r\n");
  echo "<table class='inicio' ><tr><td colspan='9' class='titulos'>Auxiliar Movimientos<input type='hidden' name='saldoinicial' value='$compinicial'></td></tr>";
  echo "<tr><td class='titulos2'>FECHA</td><td class='titulos2'>No Comp</td><td class='titulos2'>Cuenta</td><td class='titulos2'>Nom Cuenta</td><td class='titulos2'>CC</td><td class='titulos2'>Tercero</td><td class='titulos2'>Detalle</td><td class='titulos2'>Debito</td><td class='titulos2'>Credito</td></tr>";
$cuentainicial='';
//echo $sqlr;
$res=mysql_query($sqlr,$linkbd);
while($row=mysql_fetch_row($res))
 {
	 	if($row[1]!=$compdif)
	  {	
	$aux=$iter;
	 $iter=$iter2;
	 $iter2=$aux;
	 $compdif=$row[1];
	  }
	$tipocom=buscacomprobante($row[2]);
	 $nt=buscatercero($row[7]);
	  $nc=buscacuenta($row[6]);
	 $ns=$saldant+$row[17]-$row[18];
	  if($row[6]!=$cuentainicial)
	  {		
	   echo "<tr ><td class='ejemplo' colspan='9'>$row[6] $nc </td></tr>";	  
	   $cuentainicial=$row[6];
	   $compdif=$row[1];
	  }
	  fputs($Descriptor1,$row[3].";".$row2[1].";".$row[1].";".$row[12].";".$row[12].";".$row[14].";".$row[13].";".$nt.";".$row[15].";".$row[17].";".$row[18]."\r\n");
  echo "
  <tr class='$iter' style='text-transform:uppercase' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\" >
  <td><input type='hidden' name='fecha[]' value='$row[3]'>$row[3]</td>
  <td><input type='hidden' name='ncomps[]' value='$row[1]'>$row[1]</td>
  <td><input type='hidden' name='cuentas[]' value='$tipocom'>$tipocom</td>
  <td><input type='hidden' name='ncuentas[]' value='$nc'>$nc</td>
  <td><input type='hidden' name='ccs[]' value='$row[8]'>$row[8]</td>
  <td><input type='hidden' name='terceros[]' value='$row[7]'><input type='hidden' name='nterceros[]' value='$nt'>$nt</td>
  <td><input type='hidden' name='detalles[]' value='$row[4]'>$row[4]</td>
  <td style='text-align:right;'><input type='hidden' name='debitos[]' value='$row[13]'>".number_format($row[13],2)."</td>
  <td style='text-align:right;'><input type='hidden' name='creditos[]' value='$row[14]'>".number_format($row[14],2)."</td></tr>";
 	$sumad+=$row[17];
	$sumac+=$row[18];
	$saldant=$ns;
 }
 $ns=$compinicial+$sumad-$sumac;
	 fclose($Descriptor1);
 echo "<tr><td colspan='6'></td><td>Totales:</td><td class='saludo1'><input type='hidden' name='sumadebitos' value='$sumad'>$".number_format($sumad,2)."</td><td class='saludo1'><input type='hidden' name='sumacreditos' value='$sumac'>$".number_format($sumac,2)."</td></tr>";    
  	break;	 
 }
}
?> 
</div></form></td></tr>
<tr><td></td></tr>      
</table>

</body>
</html>