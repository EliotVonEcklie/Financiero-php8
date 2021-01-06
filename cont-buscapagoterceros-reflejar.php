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
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script src="css/programas.js"></script>
        <script src="css/calendario.js"></script>
        
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
	if (confirm("Esta Seguro de Eliminar el Pago a Terceros "+idr))
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
</script>

<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
	<tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("cont");?></tr>
	<tr>
		<td colspan="3" class="cinta">
			<a href="#" class="mgbt"><img src="imagenes/add2.png" title="Nuevo" /></a>
			<a class="mgbt"><img src="imagenes/guardad.png"/></a>
			<a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" class="mgbt" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
			<a href="cont-reflejardocs.php"><img src="imagenes/iratras.png" alt="nueva ventana"></a>
		</td>
	</tr>	
</table>
<form name="form2" method="post" action="cont-buscapagoterceros-reflejar.php">
		<?php if ($_POST[oculto]==""){$_POST[numres]=10;$_POST[numpos]=0;$_POST[nummul]=0;}?>
        <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
        <input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
        <input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
	<table  class="inicio" align="center" >
    	<tr >
        	<td class="titulos" colspan="6">:. Buscar Pago Terceros</td>
        	<td style="width:7%" class="cerrar" ><a href="cont-principal.php"> Cerrar</a></td>
      	</tr>
      	<tr >
        	<td width="168" class="saludo1">No Pago:</td>
        	<td width="154" >
            	<input name="numero" type="text" value="" >
        	</td>
         	<td width="144" class="saludo1">Concepto Pago: </td>
    		<td width="498" >
            	<input name="nombre" type="text" value="" size="80" >
          		<input id="oculto" name="oculto" type="hidden" value="1">
                <input name="var1" type="hidden" value=<?php echo $_POST[var1];?>>
           	</td>
        </tr>                       
    </table>    
    <div class="subpantallap" style="height:68.5%; width:99.6%; overflow-x:hidden;">
    	<?php
		$oculto=$_POST['oculto'];
		$oculto=$_POST['oculto'];
		$linkbd=conectar_bd();
		$crit1=" ";
		$crit2=" ";
		if ($_POST[numero]!="")
			$crit1=" and tesopagoterceros.id_pago like '%".$_POST[numero]."%' ";
		if ($_POST[nombre]!="")
			$crit2=" and tesopagoterceros.concepto like '%".$_POST[nombre]."%'  ";
		//sacar el consecutivo 
		$sqlr="select *from tesopagoterceros where tesopagoterceros.id_pago>-1 ".$crit1.$crit2." order by tesopagoterceros.id_pago DESC";
		$resp = mysql_query($sqlr,$linkbd);
		$ntr = mysql_num_rows($resp);
		$_POST[numtop]=$ntr;
		$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
		$cond2="";
		if($_POST[numres]!="-1"){
			$cond2="LIMIT $_POST[numpos],$_POST[numres]";
		}
		$sqlr="select *from tesopagoterceros where tesopagoterceros.id_pago>-1 ".$crit1.$crit2." order by tesopagoterceros.id_pago DESC ".$cond2;
		$resp = mysql_query($sqlr,$linkbd);
		$numcontrol=$_POST[nummul]+1;
		if(($nuncilumnas==$numcontrol)||($_POST[numres]=='1')){
			$imagenforward="<img src='imagenes/forward02.png' style='width:17px'>";
			$imagensforward="<img src='imagenes/skip_forward02.png' style='width:16px' >";
		}
		else{
			$imagenforward="<img src='imagenes/forward01.png' style='width:17px' title='Siguiente' onClick='numsiguiente()'>";
			$imagensforward="<img src='imagenes/skip_forward01.png' style='width:16px' title='Fin' onClick='saltocol(\"$nuncilumnas\")'>";
		}
		if(($_POST[numpos]==0)||($_POST[numres]=='1')){
			$imagenback="<img src='imagenes/back02.png' style='width:17px'>";
			$imagensback="<img src='imagenes/skip_back02.png' style='width:16px'>";
		}
		else{
			$imagenback="<img src='imagenes/back01.png' style='width:17px' title='Anterior' onClick='numanterior();'>";
			$imagensback="<img src='imagenes/skip_back01.png' style='width:16px' title='Inicio' onClick='saltocol(\"1\")'>";
		}

		$con=1;
		echo "<table class='inicio' align='center' >
			<tr>
				<td colspan='8' class='titulos'>.: Resultados Busqueda:</td>
			</tr>
			<tr>
				<td colspan='2'>Recaudos Encontrados: $ntr</td>
			</tr>
			<tr>
				<td  class='titulos2'>Codigo</td>
				<td class='titulos2'>Concepto</td>
				<td class='titulos2'>Fecha</td>
				<td class='titulos2'>Contribuyente</td>
				<td class='titulos2'>Valor</td>
				<td class='titulos2'>Estado</td>
				<td class='titulos2' width='5%'><center>Anular</td>
				<td class='titulos2' width='5%'><center>Ver</td>
			</tr>";	
			$iter='saludo1a';
			$iter2='saludo2';
			while ($row =mysql_fetch_row($resp)){
	 			$nter=buscatercero($row[1]);
	 			if($row[9]=='S')
		 			$estado='ACTIVO'; 	 				  
		 		if($row[9]=='N')
		 			$estado='ANULADO'; 	
		 		echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor; this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase;cursor:pointer' onDblClick=\"window.open('cont-pagoterceros-reflejar.php?idr=$row[0]','_self');\">
					<td>$row[0]</td>
					<td>$row[7]</td>
					<td>$row[10]</td>
					<td>$nter</td>
					<td>".number_format($row[5],2)."</td>
					<td>$estado</td>";
	 	 			if($row[9]=='S')
		 				echo "<td style='text-align:center;'>
							<a href='#'  onClick=eliminar($row[0])><img src='imagenes/anular.png'>
						</a>
					</td>";		 
	 	 			if($row[9]=='N')
		 			echo "<td></td>";	 
	 				echo "<td style='text-align:center;'>
						<a href='cont-pagoterceros-reflejar.php?idr=$row[0]'><img src='imagenes/buscarep.png'></a>
					</td>
				</tr>";
			 	$con+=1;
			 	$aux=$iter;
			 	$iter=$iter2;
			 	$iter2=$aux;
 			}
 		echo"</table>
			<table class='inicio'>
				<tr>
					<td style='text-align:center;'>
						<a href='#'>$imagensback</a>&nbsp;
						<a href='#'>$imagenback</a>&nbsp;&nbsp;";
						if($nuncilumnas<=9){$numfin=$nuncilumnas;}
						else{$numfin=9;}
						for($xx = 1; $xx <= $numfin; $xx++){
							if($numcontrol<=9){$numx=$xx;}
							else{$numx=$xx+($numcontrol-9);}
							if($numcontrol==$numx){echo"<a href='#' onClick='saltocol(\"$numx\")'; style='color:#24D915'> $numx </a>";}
							else {echo"<a href='#' onClick='saltocol(\"$numx\")'; style='color:#000000'> $numx </a>";}
						}
						echo "&nbsp;&nbsp;<a href='#'>$imagenforward</a>
							&nbsp;<a href='#'>$imagensforward</a>
					</td>
				</tr>
			</table>";
			?>
		</div>
	</form> 
</body>
</html>