<?php
	require "comun.inc";
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
		<title>:: SieS</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
		<script> 
			function ponprefijo(var01,var02,var03,var04,var05)
			{
				parent.document.form2.banco.value =var01;
				parent.document.form2.nbanco.value =var02;
				parent.document.form2.ter.value =var03;
				parent.document.form2.cb.value =var04;
				parent.document.form2.tcta.value =var05;
				parent.despliegamodal2("hidden");
				parent.document.form2.submit();
			} 
		</script> 
		<?php titlepag();?>
	</head>
	<body >
	<form action="" method="post" name="form2">
		<?php 
			if($_POST[oculto]=="")
			{
				$_POST[numpos]=0;
				$_POST[numres]=10;
				$_POST[nummul]=0;
				$_POST[tipo]=$_GET[tipoc];
			}
		?>
		<table class="inicio" style="width:99.4%;">
			<tr >
				<td class="titulos" colspan="3">:. Buscar Cuentas Bancarias</td>
				<td style="width:7%"><label class="boton02" onClick="parent.despliegamodal2('hidden');">Cerrar</label></td>
			</tr>
			<tr>
        		<td style="width:4.5cm" class="tamano01">:. N&deg; Documento, Nombre o Razón Social:</td>
				<td><input type="search" name="nombre" id="nombre" style="width:100%" value="<?php echo $_POST[nombre];?>" class="tamano02"/></td>
				<td style="padding-bottom:5px"><em class="botonflecha" onClick="limbusquedas();">Buscar</em></td>
       		</tr>                       
    	</table> 
    	<input type="hidden" name="oculto" id="oculto" value="1">
        <input type="hidden" name="tipo" value="<?php echo $_POST[tipo]?>">
    	<input type="hidden" name="vigencia" value="<?php echo $_GET[vigencia]?>">
        <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
        <input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
        <input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
		<div class="subpantalla" style="height:85%; width:99%; overflow-x:hidden;">
			<?php
				$crit1="";
				if ($_POST[nombre]!=""){$crit1="AND concat_ws(' ', TB2.tercero, TB1.razonsocial) LIKE '%$_POST[nombre]%'";}
				if($_POST[tipo]=="C")
				{
					$sqlr="select TB1.razonsocial,TB3.nombre,TB2.cuenta,TB2.ncuentaban,TB2.tipo from terceros TB1,tesobancosctas TB2,cuentasnicsp TB3 where TB2.tercero=TB1.cedulanit and TB2.estado='S'  AND TB3.cuenta=TB2.cuenta AND TB2.tipo='Corriente' $crit1";
					$resp = mysql_query($sqlr,$linkbd);
					$_POST[numtop]=mysql_num_rows($resp);
					$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
					$sqlr="select TB1.razonsocial,TB3.nombre,TB2.cuenta,TB2.ncuentaban,TB2.tipo,TB1.cedulanit from terceros TB1,tesobancosctas TB2,cuentasnicsp TB3 where TB2.tercero=TB1.cedulanit and TB2.estado='S'  AND TB3.cuenta=TB2.cuenta AND TB2.tipo='Corriente' $crit1 ORDER BY TB3.cuenta,TB1.cedulanit LIMIT $_POST[numpos],$_POST[numres]";
				}
				else
				{
					$sqlr="select TB1.razonsocial,TB3.nombre,TB2.cuenta,TB2.ncuentaban,TB2.tipo from terceros TB1,tesobancosctas TB2,cuentasnicsp TB3 where TB2.tercero=TB1.cedulanit and TB2.estado='S'  AND TB3.cuenta=TB2.cuenta $crit1";
					$resp = mysql_query($sqlr,$linkbd);
					$_POST[numtop]=mysql_num_rows($resp);
					$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
					$sqlr="select TB1.razonsocial,TB3.nombre,TB2.cuenta,TB2.ncuentaban,TB2.tipo,TB1.cedulanit from terceros TB1,tesobancosctas TB2,cuentasnicsp TB3 where TB2.tercero=TB1.cedulanit and TB2.estado='S'  AND TB3.cuenta=TB2.cuenta $crit1 ORDER BY TB3.cuenta,TB1.cedulanit LIMIT $_POST[numpos],$_POST[numres]";
				}
				$resp = mysql_query($sqlr,$linkbd);
				$con=1;
				$numcontrol=$_POST[nummul]+1;
				if($nuncilumnas==$numcontrol)
				{
					$imagenforward="<img src='imagenes/forward02.png' style='width:17px'>";
					$imagensforward="<img src='imagenes/skip_forward02.png' style='width:16px' >";
				}
				else 
				{
					$imagenforward="<img src='imagenes/forward01.png' style='width:17px' title='Siguiente' onClick='numsiguiente()'>";
					$imagensforward="<img src='imagenes/skip_forward01.png' style='width:16px' title='Fin' onClick='saltocol(\"$nuncilumnas\")'>";
				}
				if($_POST[numpos]==0)
				{
					$imagenback="<img src='imagenes/back02.png' style='width:17px'>";
					$imagensback="<img src='imagenes/skip_back02.png' style='width:16px'>";
				}
				else
				{
					$imagenback="<img src='imagenes/back01.png' style='width:17px' title='Anterior' onClick='numanterior();'>";
					$imagensback="<img src='imagenes/skip_back01.png' style='width:16px' title='Inicio' onClick='saltocol(\"1\")'>";
				}
				echo "
				<table class='inicio' align='center' width='99%'>
				<tr>
					<td colspan='5' class='titulos'>.: Resultados Busqueda:</td>
					<td class='submenu'>
								<select name='renumres' id='renumres' onChange='cambionum();' style='width:100%'>
									<option value='10'"; if ($_POST[renumres]=='10'){echo 'selected';} echo ">10</option>
									<option value='20'"; if ($_POST[renumres]=='20'){echo 'selected';} echo ">20</option>
									<option value='30'"; if ($_POST[renumres]=='30'){echo 'selected';} echo ">30</option>
									<option value='50'"; if ($_POST[renumres]=='50'){echo 'selected';} echo ">50</option>
									<option value='100'"; if ($_POST[renumres]=='100'){echo 'selected';} echo ">100</option>
								</select>
							</td>
				</tr>
				<tr><td colspan='7'>Cuentas Bancarias Encontrados: $_POST[numtop]</td></tr>
				<tr>
					<td class='titulos2'>Item</td>
					<td class='titulos2'>Razón Social</td>
					<td class='titulos2'>Cuenta</td>
					<td class='titulos2'>Cuenta Contable</td>
					<td class='titulos2'>Cuenta Bancaria</td>
					<td class='titulos2'>Tipo Cuenta</td>
				</tr>";	
				$iter='saludo1a';
				$iter2='saludo2';
				while ($row =mysql_fetch_row($resp)) 
				{	
					$con2=$con+ $_POST[numpos];
					if($_POST[tipo]=="C")
					{
						$sqlrft="SELECT COUNT(*) FROM tesochequeras WHERE banco='$row[5]' AND cuentabancaria='$row[3]' AND estado='S'";
						$resft=mysql_query($sqlrft,$linkbd);
						$rowft =mysql_fetch_row($resft);
						if($rowft[0]<=0){$varcol=$iter;}
						else {$varcol='resaltar01';}
					}
					else{$varcol=$iter;}
					echo"<tr class='$varcol' style='text-transform:uppercase' onClick=\"javascript:ponprefijo('$row[2]','$row[1]','$row[5]', '$row[3]','$row[5]')\" >
					<td>$con2 $colval </td>
					 	<td>$row[0]</td>
					 	<td>$row[1]</td>
					 	<td>$row[2]</td>
					 	<td>$row[3]</td>
					 	<td>$row[4]</td>
					</tr>";
				 $con+=1;
				 $aux=$iter;
				 $iter=$iter2;
				 $iter2=$aux;
				}
				if ($_POST[numtop]==0)
					{
						echo "
						<table class='inicio'>
							<tr>
								<td class='saludo1' style='text-align:center;width:100%'><img src='imagenes\alert.png' style='width:25px'>No hay coincidencias en la b&uacute;squeda $tibusqueda<img src='imagenes\alert.png' style='width:25px'></td>
							</tr>
						</table>";
					}
 					echo"
						</table>
						<table class='inicio'>
							<tr>
								<td style='text-align:center;'>
									<a href='#'>$imagensback</a>&nbsp;
									<a href='#'>$imagenback</a>&nbsp;&nbsp;";
					if($nuncilumnas<=9){$numfin=$nuncilumnas;}
					else{$numfin=9;}
					for($xx = 1; $xx <= $numfin; $xx++)
					{
						if($numcontrol<=9){$numx=$xx;}
						else{$numx=$xx+($numcontrol-9);}
						if($numcontrol==$numx){echo"<a href='#' onClick='saltocol(\"$numx\")'; style='color:#24D915'> $numx </a>";}
						else {echo"<a href='#' onClick='saltocol(\"$numx\")'; style='color:#000000'> $numx </a>";}
					}
					echo "		&nbsp;&nbsp;<a href='#'>$imagenforward</a>
									&nbsp;<a href='#'>$imagensforward</a>
								</td>
							</tr>
						</table>";
?>
</div>
<input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>" />
</form>
</body>
</html>
