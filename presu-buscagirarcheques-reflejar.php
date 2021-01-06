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
		<title>:: SPID - Presupuesto</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript"src="css/programas.js"></script>
		<script type="text/javascript"src="css/calendario.js"></script>
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
	<tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("presu");?></tr>
<tr>
  <td colspan="3" class="cinta"><a href="#" class="mgbt"><img src="imagenes/add2.png" title="Nuevo"/></a><a class="mgbt"><img src="imagenes/guardad.png"/></a><a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a><a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a> <a href="presu-reflejardocs.php"><img src="imagenes/iratras.png" alt="nueva ventana"></a></td></tr>	
</table>
<tr><td colspan="3" class="tablaprin"> 
	<form name="form2" method="post" action="presu-buscagirarcheques-reflejar.php">
		<?php if ($_POST[oculto]==""){$_POST[numres]=10;$_POST[numpos]=0;$_POST[nummul]=0;}?>
        <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
        <input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
        <input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
		<table  class="inicio" align="center" >
      		<tr >
        		<td class="titulos" colspan="4">:. Buscar Pagos</td>
        		<td style="width:7%" class="cerrar" ><a href="presu-principal.php">Cerrar</a></td>
      		</tr>
      		<tr >
        		<td width="162" class="saludo1">Numero Pago:</td>
        		<td >
                	<input name="numero" type="text" value="" >
        		</td>
         		<td width="131" class="saludo1">Detalle Pago: </td>
    			<td >
                	<input name="nombre" type="text" value="" size="80" >
	  	          	<input name="oculto" id="oculto" type="hidden" value="1">
                    <input name="var1" type="hidden" value=<?php echo $_POST[var1];?>>
              	</td>
                <td></td>
        	</tr>                       
    	</table>    
     	<div class="subpantallap" style="height:68.5%; width:99.6%; overflow-x:hidden;">
      	<?php
		$oculto=$_POST['oculto'];
		if($_POST[oculto]==2){
	 		$linkbd=conectar_bd();	
		 	$sqlr="select * from tesoegresos where id_egreso=$_POST[var1]";
			$resp = mysql_query($sqlr,$linkbd);
			$row=mysql_fetch_row($resp);
			$op=$row[2];
			$vpa=$row[7];
	 		//********Comprobante contable en 000000000000
	  		$sqlr="update comprobante_cab set total_debito=0,total_credito=0,estado='0' where tipo_comp='6' and numerotipo=$row[0]";
	  		mysql_query($sqlr,$linkbd);
	  		$sqlr="update comprobante_det set valdebito=0,valcredito=0 where id_comp='6 $row[0]'";
	  		mysql_query($sqlr,$linkbd);
	 		//********RETENCIONES
 	 		$sqlr="delete from pptoretencionpago where idrecibo=$row[0] and vigencia='".$_SESSION[vigencia]."'";
	 		mysql_query($sqlr,$linkbd);
   	 		$sqlr="delete from pptorecibopagoppto where idrecibo=$row[0] and vigencia='".$_SESSION[vigencia]."'";
	 		mysql_query($sqlr,$linkbd);
	   		$sqlr="update tesoordenpago  set estado='S' where id_orden=$op";
	  		mysql_query($sqlr,$linkbd);	 
	   		$sqlr="update tesoegresos set estado='N' where id_egreso=$_POST[var1]";
	  		mysql_query($sqlr,$linkbd);	 
		}   

		$linkbd=conectar_bd();
		$crit1=" ";
		$crit2=" ";
		if ($_POST[numero]!="")
		$crit1=" and tesoegresos.id_egreso like '%".$_POST[numero]."%' ";
		if ($_POST[nombre]!="")
		$crit2=" and tesoegresos.concepto like '%".$_POST[nombre]."%'  ";

		//sacar el consecutivo 
		$sqlr="select *from tesoegresos where tesoegresos.id_egreso>-1 ".$crit1.$crit2." order by tesoegresos.id_egreso DESC";
		$resp = mysql_query($sqlr,$linkbd);
		$ntr = mysql_num_rows($resp);
		$_POST[numtop]=$ntr;
		$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
		$cond2="";
		if($_POST[numres]!="-1"){
			$cond2="LIMIT $_POST[numpos],$_POST[numres]";
		}
		$sqlr="select *from tesoegresos where tesoegresos.id_egreso>-1 ".$crit1.$crit2." order by tesoegresos.id_egreso DESC ".$cond2;
		$resp = mysql_query($sqlr,$linkbd);
		$numcontrol=$_POST[nummul]+1;
		if($nuncilumnas==$numcontrol){
			$imagenforward="<img src='imagenes/forward02.png' style='width:17px'>";
			$imagensforward="<img src='imagenes/skip_forward02.png' style='width:16px' >";
		}
		else{
			$imagenforward="<img src='imagenes/forward01.png' style='width:17px' title='Siguiente' onClick='numsiguiente()'>";
			$imagensforward="<img src='imagenes/skip_forward01.png' style='width:16px' title='Fin' onClick='saltocol(\"$nuncilumnas\")'>";
		}
		if($_POST[numpos]==0){
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
				<td class='submenu'>
					<select name='renumres' id='renumres' onChange='cambionum();' style='width:100%'>
						<option value='10'"; if ($_POST[renumres]=='10'){echo 'selected';} echo ">10</option>
						<option value='20'"; if ($_POST[renumres]=='20'){echo 'selected';} echo ">20</option>
						<option value='30'"; if ($_POST[renumres]=='30'){echo 'selected';} echo ">30</option>
						<option value='50'"; if ($_POST[renumres]=='50'){echo 'selected';} echo ">50</option>
						<option value='100'"; if ($_POST[renumres]=='100'){echo 'selected';} echo ">100</option>
						<option value='-1'"; if ($_POST[renumres]=='-1'){echo 'selected';} echo ">Todos</option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan='9'>Pagos Encontrados: $ntr</td>
			</tr>
			<tr>
				<td  class='titulos2'>Egreso</td>
				<td  class='titulos2'>Orden Pago</td>
				<td class='titulos2'>Nombre</td>
				<td class='titulos2'>Fecha</td>
				<td class='titulos2'>Valor</td>
				<td class='titulos2'>Concepto</td>
				<td class='titulos2' width='5%'><center>Estado</td>
				<td class='titulos2' width='5%'><center>Anular</td>
				<td class='titulos2' width='5%'><center>Editar</td>
			</tr>";	
			$iter='saludo1a';
			$iter2='saludo2';
 			while ($row =mysql_fetch_row($resp)){
	 			$ntr=buscatercero($row[11]);
		 		echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor; this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase;cursor:pointer' onDblClick=\"window.open('presu-girarcheques-reflejar.php?idegre=$row[0]','_self');\">
					<td >$row[0]</td>
					<td>$row[2]</td>
					<td >$ntr</td>
					<td>$row[3]</td>
					<td >".number_format($row[7],2)."</td>
					<td>".strtoupper($row[8])."</td>
					<td>".strtoupper($row[13])."</td>";
	 	 			if($row[13]=='S')
	 					echo "<td style='text-align:center;'>
							<a href='#' onClick=eliminar($row[0])><img src='imagenes/anular.png'></a>
						</td>";
	 				if ($row[13]=='P' || $row[13]=='N')
	 					echo "<td></td>";	 
	 				echo "<td style='text-align:center;'>
						<a href='presu-girarcheques-reflejar.php?idegre=$row[0]'>
							<img src='imagenes/b_edit.png' style='width:18px' title='Editar'>
						</a>
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