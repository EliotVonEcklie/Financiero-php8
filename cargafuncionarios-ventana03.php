<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=iso-8859-1");
	require 'comun.inc';
	require 'funciones.inc';
	$linkbd=conectar_v7();
	date_default_timezone_set("America/Bogota");
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SieS</title>
		<link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
		<script>
			function fagregar(documento,idfun)
			{	
				if(document.getElementById('tcodfun').value!='' && document.getElementById('tcodfun').value != null)
				{
					tcodfun=document.getElementById('tcodfun').value;
					parent.document.getElementById(''+tcodfun).value=idfun;
				}
				tobjeto=document.getElementById('tobjeto').value;
				parent.document.getElementById(''+tobjeto).value =documento;
				parent.document.getElementById(''+tobjeto).select();
				parent.document.getElementById(''+tobjeto).blur();
				parent.despliegamodal2("hidden");
			}
		</script> 
		<?php titlepag();?>
	</head>
	<body>
		<form name="form2" method="post">
			<?php
				if(@$_POST['oculto']=="")
				{
					$_POST['tobjeto']=@$_GET['objeto'];
					$_POST['tcodfun']=@$_GET['vcodfun'];
				}
			?>
			<table class="inicio" style="width:99.5%">
				<tr>
					<td class="titulos" colspan="6">:: Buscar Funcionario</td>
					<td class="cerrar" style="width:7%;"><a onClick="parent.despliegamodal2('hidden');">&nbsp;Cerrar</a></td>
				</tr>
				<tr>
					<td class="saludo1" style='width:4cm;'>:: Documento o Nombre:</td>
					<td colspan="5"><input type="search" name="nombre" id="nombre" value="<?php echo @$_POST['nombre'];?>" style='width:100%;'/> </td>
				</tr> 
				<tr>
					<td class="saludo1">:: Centro de Costo:</td>
					<td style="width:30%;">
						<select name="cc" style="width:100%;">
							<option value='' <?php if(''==@$_POST['cc']) echo "SELECTED"?>>Todos</option>
							<?php
								$sqlr="SELECT * FROM centrocosto WHERE estado='S' ORDER BY ID_CC";
								$res=mysqli_query($linkbd,$sqlr);
								while ($row =mysqli_fetch_row($res))
								{
									if($row[0]==$_POST['cc']){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
									else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
								}
							?>
						</select>
					</td>
					<td class="saludo1">:: Salario Mayor A:</td>
					<td  style='width:20%;'><input type="search" name="salario" id="salario" value="<?php echo @$_POST['salario'];?>" style='width:100%;'/><td>
					<td> <input type="button" name="bboton" onClick="document.form2.submit();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" /></td>
				</tr>
			</table> 
			<input type="hidden" name="oculto" id="oculto" value="1"/>
			<input type="hidden" name="tobjeto" id="tobjeto" value="<?php echo @$_POST['tobjeto']?>"/>
			<input type="hidden" name="tcodfun" id="tcodfun" value="<?php echo @$_POST['tcodfun']?>"/>
			<div class="subpantalla" style="height:82%; width:99.2%; overflow-x:hidden;">
				<?php 
					if (@$_POST['nombre']!="")
					{$crit1="AND (SELECT T2.codfun FROM hum_funcionarios T2 WHERE T2.descripcion  LIKE  '%".$_POST['nombre']."%' AND T2.estado='S' AND T2.codfun=T1.codfun AND (T2.item='NOMTERCERO' OR T2.item='DOCTERCERO'))";}
					else {$crit1="";}
					if (@$_POST['salario']!=""){$crit2="AND (SELECT T2.codfun FROM hum_funcionarios T2 WHERE CONVERT(T2.descripcion, SIGNED INTEGER) >= '".$_POST['salario']."' AND T2.estado='S' AND T2.codfun=T1.codfun AND T2.item='VALESCALA')";}
					else{$crit2="";}
					if (@$_POST['cc']!=""){$crit3="AND (SELECT T2.codfun FROM hum_funcionarios T2 WHERE T2.descripcion  LIKE  '%".$_POST['cc']."%' AND T2.estado='S' AND T2.codfun=T1.codfun AND T2.item='NUMCC')";}
					else{$crit3="";}
					$sqlr="
					SELECT T1.codfun, 
					GROUP_CONCAT(T1.descripcion ORDER BY CONVERT(T1.valor, SIGNED INTEGER) SEPARATOR '<->')
					FROM hum_funcionarios T1
					WHERE (T1.item = 'VALESCALA' OR T1.item = 'DOCTERCERO' OR T1.item = 'NOMTERCERO' OR T1.item = 'ESTGEN' OR T1.item = 'NOMCC') AND T1.estado='S' $crit1 $crit2 $crit3 
					GROUP BY T1.codfun
					ORDER BY CONVERT(T1.codfun, SIGNED INTEGER)";
					$resp = mysqli_query($linkbd,$sqlr);
					$con=mysqli_num_rows($resp);
					echo "
					<table class='inicio' align='center' width='99%'>
						<tr><td colspan='6' class='titulos'>.: Resultados Busqueda:</td></tr>
						<tr><td colspan='7'>funcionarios Encontrados: </td></tr>
						<tr class='titulos2' >
							<td>No</td>
							<td width='2%'>ID</td>
							<td width='12%'>DOCUMENTO</td>
							<td >NOMBRE</td>
							<td width='15%'>SALARIO BASICO</td>
							<td width='25%'>CENTRO COSTO</td>
						</tr>";	
					$iter='saludo1a';
					$iter2='saludo2';
					$conta=1;
					while ($row =mysqli_fetch_row($resp)) 
					{
						$datos = explode('<->',$row[1]);
						if(@$datos[4]=="S")
						{
							echo "
							<tr class='$iter' onClick=\"javascript:fagregar('$datos[1]','$row[0]')\">
								<td>$conta</td>
								<td>$row[0]</td>
								<td style='text-align:right;'>".number_format($datos[1],0,'','.')."</td>
								<td>$datos[2]</td>
								<td style='text-align:right;'>$ ".number_format($datos[0],0,'','.')."</td>
								<td>$datos[3]</td>
							</tr>
							";
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
							$conta++;
						}
					}
					echo"</table>";
				?>
			</div>
		</form>
	</body>
</html>
