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
		<script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
		<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
	<tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("presu");?></tr>
	<tr>
  		<td colspan="3" class="cinta"><a href="#" class="mgbt"><img src="imagenes/add2.png" title="Nuevo"/></a><a class="mgbt"><img src="imagenes/guardad.png"/></a><a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a><a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a> <a href="presu-reflejardocs.php"><img src="imagenes/iratras.png" alt="nueva ventana"></a>
        </td>
     </tr>	
  </table>
<form name="form2" method="post" action="presu-buscasinrecibocaja-reflejar.php">
	<?php if ($_POST[oculto]==""){$_POST[numres]=10;$_POST[numpos]=0;$_POST[nummul]=0;}?>
    <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
    <input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
    <input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
	<table  class="inicio" align="center" >
    	<tr >
        	<td class="titulos" colspan="6">:. Buscar Ingresos Propios</td>
        	<td width="70" class="cerrar" ><a href="presu-principal.php">Cerrar</a></td>
      	</tr>
      	<tr >
        	<td width="168" class="saludo1">Numero Liquidacion:</td>
        	<td width="154" ><input name="numero" type="text" value="" ></td>
         	<td width="144" class="saludo1">Concepto Liquidacion: </td>
    		<td width="498" >
                <input name="nombre" type="text" value="" size="80" >
                <input name="oculto" id="oculto" type="hidden" value="1">
                <input name="var1" type="hidden" value=<?php echo $_POST[var1];?>>
          	</td>
    	</tr>                       
   	</table>   
    <div class="subpantallap" style="height:68.5%; width:99.6%; overflow-x:hidden;">
		<?php
		$oculto=$_POST['oculto'];
		$linkbd=conectar_bd();
		$crit1=" ";
		$crit2=" ";
		if ($_POST[numero]!="")
			$crit1=" and tesosinreciboscaja.id_recibos like '%".$_POST[numero]."%' ";
		if ($_POST[nombre]!=""){
			//$crit2=" and tesorecaudos.concepto like '%".$_POST[nombre]."%'  ";}
		}
		$sqlr="select *from tesosinreciboscaja where tesosinreciboscaja.estado<>'' ".$crit1.$crit2." order by tesosinreciboscaja.id_recibos DESC";
		// echo "<div><div>sqlr:".$sqlr."</div></div>";
		$resp = mysql_query($sqlr,$linkbd);
		$ntr = mysql_num_rows($resp);
		$_POST[numtop]=$ntr;
		$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
		$cond2="";
		if($_POST[numres]!="-1"){
			$cond2="LIMIT $_POST[numpos],$_POST[numres]";
		}
		$sqlr="select *from tesosinreciboscaja where tesosinreciboscaja.estado<>'' ".$crit1.$crit2." order by tesosinreciboscaja.id_recibos DESC ".$cond2;
		$resp = mysql_query($sqlr,$linkbd);
		$con=1;
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
			<td colspan='9'>Recibos de Caja Encontrados: $ntr</td>
		</tr>
		<tr>
			<td width='150' class='titulos2'>No Recibo</td>
			<td class='titulos2'>Concepto</td>
			<td class='titulos2'>Fecha</td>
			<td class='titulos2'>Contribuyente</td>
			<td class='titulos2'>Valor</td>
			<td class='titulos2'>No Liquid.</td>
			<td class='titulos2'>Tipo</td>
			<td class='titulos2'>Estado</td>
			<td class='titulos2' width='5%'><center>Editar</td>
		</tr>";	
		$iter='saludo1a';
		$iter2='saludo2';
		$tipos=array('Predial','Industria y Comercio','Otros Recaudos');
	 	while ($row =mysql_fetch_row($resp)){
	 		$ntercero=buscatercero($row[15]);
			if($row[9]=='S'){
				$estadosemaforo="<img src='imagenes/sema_verdeON.jpg' style='width:19px; '  title='Activo'>";
			}else {
				$estadosemaforo="<img src='imagenes/sema_rojoON.jpg' style='width:19px; ' title='Inactivo'>";
			}
	 		echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor; this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase;cursor:pointer' onDblClick=\"window.open('presu-sinrecibocaja-reflejar.php?idrecibo=$row[0]&tiporeca=$row[10]','_self');\">

				<td>$row[0]</td>
				<td>$row[17]</td>
				<td>$row[2]</td>
				<td>$row[15] $ntercero</td>
				<td>".number_format($row[8],2)."</td>
				<td >$row[4]</td><td >".$tipos[$row[10]-1]."</td>
				<td style='text-align:center;'>$estadosemaforo</td>";
	 		echo "<td style='text-align:center;'>
				<a href='presu-sinrecibocaja-reflejar.php?idrecibo=$row[0]&tiporeca=$row[10]'><img src='imagenes/b_edit.png' style='width:18px' title='Editar'></a>
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