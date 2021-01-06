<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=iso-8859-1");
	require 'comun.inc';
	require 'funciones.inc';
	session_start();
	$linkbd=conectar_v7();
	date_default_timezone_set("America/Bogota");
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
		<script>
			function validar(){document.form2.submit();}
			function buscaref(){document.form2.oculto.value=2;document.form2.submit();}
			function ponprefijo(opc1,opc2,opc3,opc4)
			{
				parent.document.getElementById('nnomina').value=opc1;
				if(parent.document.getElementById('vigencias')){parent.document.getElementById('vigencias').value=opc2;}
				if(parent.document.getElementById('periodo')){parent.document.getElementById('periodo').value=opc3;}
				if(parent.document.getElementById('mes')){parent.document.getElementById('mes').value=opc4;}
				if(parent.document.getElementById('tercero'))
				{
					parent.document.getElementById('tercero').focus();
					parent.document.getElementById('tercero').select();
				}
				parent.validar();
				parent.document.form2.submit();
				parent.despliegamodal2('hidden');
			} 
		</script> 
		<?php titlepag();?>
	</head>
	<body>
		<form name="form2" method="post">
			<?php
				if(@$_POST['oculto']=="")
				{
					$_POST['numpos']=0;
					$_POST['numres']=10;
					$_POST['nummul']=0;
				}
			?>
			<table class="inicio" style="width:99.4%;" >
				<tr>
					<td class="titulos" colspan="4">:: Buscar N&oacute;minas</td>
					<td class="cerrar" style="width:10%;"><a onClick="parent.despliegamodal2('hidden');" href="#" >&nbsp;Cerrar</a></td>
				</tr>
				<tr>
					<td class="saludo1" style="width:2cm;">:: No. N&oacute;mina:</td>
					<td style="width:20%;"><input type="text" name="codigo" id="codigo" value="<?php echo @$_POST['codigo'];?>" style="width:100%;"/></td>
					<td class="saludo1" style="width:2cm;">:: Vigencia:</td>
					<td>
						<input type="text" name="nombre" id="nombre" value="<?php echo @$_POST['nombre'];?>" style="width:70%"/>&nbsp;
						<input type="button" name="Submit" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" onClick="document.form2.submit();"/>
					</td>
				</tr>
			</table>
			<input type="hidden" name="oculto" id="oculto" value="1"/>
			<input type="hidden" name="numres" id="numres" value="<?php echo @$_POST['numres'];?>"/>
			<input type="hidden" name="numpos" id="numpos" value="<?php echo @$_POST['numpos'];?>"/>
			<input type="hidden" name="nummul" id="nummul" value="<?php echo @$_POST['nummul'];?>"/>
			<div class="subpantallac" style="height:87%; width:99.1%; overflow-x:hidden;">
				<?php
					$co='saludo1a';
					$co2='saludo2';
					$crit1="";
					$crit2="";
					if (@$_POST['codigo']!=""){$crit1="AND id_nom LIKE '%".$_POST['codigo']."%'";}
					if (@$_POST['nombre']!=""){$crit2="AND vigencia LIKE '%".$_POST['nombre']."%'";}
 					$sqlr="SELECT * FROM humnomina WHERE estado='P' $crit1 $crit2";
 					$resp=mysqli_query($linkbd,$sqlr);
					$_POST['numtop']=mysqli_num_rows($resp);
					$nuncilumnas=ceil($_POST['numtop']/$_POST['numres']);
					$sqlr="SELECT * FROM humnomina WHERE estado='P' $crit1 $crit2 ORDER BY id_nom DESC, vigencia DESC LIMIT ".$_POST['numpos'].",".$_POST['numres'];
 					$resp=mysqli_query($linkbd,$sqlr);
					$numcontrol=$_POST['nummul']+1;
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
					if(@$_POST['numpos']==0)
					{
						$imagenback="<img src='imagenes/back02.png' style='width:17px'>";
						$imagensback="<img src='imagenes/skip_back02.png' style='width:16px'>";
					}
					else{
						$imagenback="<img src='imagenes/back01.png' style='width:17px' title='Anterior' onClick='numanterior();'>";
						$imagensback="<img src='imagenes/skip_back01.png' style='width:16px' title='Inicio' onClick='saltocol(\"1\")'>";
					}
					echo"
 					<table class='inicio'>
						<tr>
							<td colspan='4' class='titulos'>.: Resultados Busqueda:</td>
							<td class='submenu' style='width:5%;'>
								<select name='renumres' id='renumres' onChange='cambionum();' style='width:100%'>
									<option value='10'"; if (@$_POST['renumres']=='10'){echo 'selected';} echo ">10</option>
									<option value='20'"; if (@$_POST['renumres']=='20'){echo 'selected';} echo ">20</option>
									<option value='30'"; if (@$_POST['renumres']=='30'){echo 'selected';} echo ">30</option>
									<option value='50'"; if (@$_POST['renumres']=='50'){echo 'selected';} echo ">50</option>
									<option value='100'"; if (@$_POST['renumres']=='100'){echo 'selected';} echo ">100</option>
								</select>
							</td>
						</tr>
						<tr><td colspan='5'>Articulos Encontrados: ".@$_POST['numtop']."</td></tr>
 						<tr>
							<td class='titulos2' style='width:10%'>No. N&oacute;mina</td>
							<td class='titulos2'>Vigencia</td>
							<td class='titulos2'>Mes</td>
							<td class='titulos2' colspan='2' style='width:25%'>Fecha</td>
						</tr>";
					while($row=mysqli_fetch_row($resp))
					{
						$mes=mesletras($row[3]);
						echo"
						<tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\" onClick=\"ponprefijo('$row[0]','$row[7]','$mes','$row[3]')\" style='text-transform:uppercase'>
							<td>$row[0]</td>
							<td>$row[7]</td>
							<td>$mes</td>
							<td colspan='2'>$row[1]</td>
						</tr>";
						$aux=$co;
						$co=$co2;
						$co2=$aux;
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
			<input type="hidden" name="numtop" id="numtop" value="<?php echo @$_POST['numtop'];?>" />
		</form>
	</body>
</html>