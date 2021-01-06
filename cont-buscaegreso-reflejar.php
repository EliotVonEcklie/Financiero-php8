<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Contabilidad</title>
        <script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
<script>
	function validar(){
		document.form2.submit();
	}
	function pdf(){
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
				<a href="#" class="mgbt"><img src="imagenes/add2.png" title="Nuevo"/></a>
				<a class="mgbt"><img src="imagenes/guardad.png"/></a>
				<a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a>
				<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
				<a href="#" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
			</td>
		</tr>	
    </table>
<form name="form2" method="post" action="cont-buscaegreso-reflejar.php">
	<?php if ($_POST[oculto]==""){$_POST[numres]=10;$_POST[numpos]=0;$_POST[nummul]=0;}?>
    <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
    <input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
    <input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
	<table  class="inicio" align="center" >
    	<tr >
        	<td class="titulos" colspan="4">:. Buscar Liquidaciones CxP</td>
        	<td style="width:7%" class="cerrar" ><a href="cont-principal.php">Cerrar</a></td>
      	</tr>
      	<tr>
        	<td width="162" class="saludo1">N&uacute;mero Orden:</td>
        	<td>
            	<input name="numero" type="text" value="" >
        	</td>
         	<td width="131" class="saludo1">Detalle Orden: </td>
    		<td>
            	<input name="nombre" type="text" value="" size="80" >
	          	<input name="oculto" id="oculto" type="hidden" value="1">
                <input name="var1" type="hidden" value=<?php echo $_POST[var1];?>>
           	</td>
      	</tr>                       
  	</table>   
    <script>
    	document.form2.numero.focus();
	    document.form2.numero.select();
    </script>
   	<div class="subpantallap" style="height:68.5%; width:99.6%; overflow-x:hidden;">
    	<?php
	  	$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
		$_POST[vigencia]=$vigusu;
		$oculto=$_POST['oculto'];
		//****** 	
		$linkbd=conectar_bd();
		$crit1=" ";
		$crit2=" ";
		if ($_POST[numero]!="")
			$crit1=" and tesoordenpago.id_orden like '%".$_POST[numero]."%' ";
		if ($_POST[nombre]!="")
			$crit2=" and tesoordenpago.conceptorden like '%".$_POST[nombre]."%'  ";
		//sacar el consecutivo 
		$sqlr="select *from tesoordenpago where tesoordenpago.id_orden>-1 ".$crit1.$crit2." order by tesoordenpago.id_orden DESC";
		$resp = mysql_query($sqlr,$linkbd);
		$ntr = mysql_num_rows($resp);
		$_POST[numtop]=$ntr;
		$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
		$cond2="";
		if($_POST[numres]!="-1"){
			$cond2="LIMIT $_POST[numpos],$_POST[numres]";
		}
		$sqlr="select *from tesoordenpago where tesoordenpago.id_orden>-1 ".$crit1.$crit2." order by tesoordenpago.id_orden DESC ".$cond2;
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
		echo "<table class='inicio' align='center' width='99%'>
			<tr>
				<td colspan='7' class='titulos'>.: Resultados Busqueda:</td>
				<td class='submenu' colspan='2'>
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
				<td colspan='8'>Liquidaciones Encontrados: $ntr</td>
			</tr>
			<tr>
				<td class='titulos2' style='width:3%;'>Item</td>
				<td class='titulos2' >Vigencia</td>
				<td class='titulos2' style='width:3%;'>N RP</td>
				<td class='titulos2' >Detalle</td>
				<td class='titulos2' >Valor</td>
				<td class='titulos2' style='width:6%;'>Fecha</td>
				<td class='titulos2' width='4%'>Estado</td>
				<td class='titulos2'>Anular</td>
				<td class='titulos2' style='width:2%;'>Ver</td>
			</tr>";	
			$iter='saludo1a';
			$iter2='saludo2';
 			while($row =mysql_fetch_row($resp)){
 				$detalle=$row[2];
 				$ntr=buscatercero($row[11]);
 	 			if($row[13]=='S')
					$imagen="src='imagenes/confirm.png' title='Activo'";
				if($row[13]=='P')
					$imagen="src='imagenes/dinero3.png' title='Pago'";
				if ($row[13]=='N')
					$imagen="src='imagenes/cross.png' title='Anulado'";
		 		echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor; this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase;cursor:pointer' onDblClick=\"window.open('cont-egreso-reflejar.php?idr=$row[0]','_self');\">
					<td>$row[0]</td>
					<td>".strtoupper($row[3])."</td>
					<td>".strtoupper($row[4])."</td>
					<td>".strtoupper($row[7])."</td>
					<td>".number_format($row[10],2)."</td>
					<td>".$row[2]."</td>
					<td style='text-align:center;'><img $imagen style='width:16px'></td>";
	 	 			if ($row[13]=='S')
						echo "<td style='text-align:center;'>
							<a href='#' onClick=eliminar($row[0])><img src='imagenes/anular.png'></a>
						</td>";
	 				if ($row[13]=='P' || $row[13]=='N')
	 					echo "<td></td>";
	 				echo "<td style='text-align:center;'>
						<a href='cont-egreso-reflejar.php?idr=$row[0]'><img src='imagenes/buscarep.png'></a>
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