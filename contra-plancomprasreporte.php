<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Contrataci&oacute;n</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="botones.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
		<script>
			function pdf()
			{
				document.form2.action="contra-plancomprasbuscarpdf.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function excell()
			{
				document.form2.action="contra-plancomprasexcel.php";
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
        	<tr><script>barra_imagenes("contra");</script><?php cuadro_titulos();?></tr>	 
        	<tr><?php menu_desplegable("contra");?></tr>
        	<tr>
       			<td colspan="3" class="cinta">
					<a href="contra-plancompras.php" class="mgbt"><img src="imagenes/add.png"  title="Nuevo" border="0" /></a>
					<a><img src="imagenes/guardad.png" class="mgbt"/></a>
					<a href="#" onClick="document.form2.submit()" class="mgbt"><img src="imagenes/busca.png" title="Buscar" border="0" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('inve-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" title="Imprimir" /></a>
					<a href="#" onClick="excell()" class="mgbt"><img src="imagenes/excel.png"  title="excel"></a>
				</td>
			</tr>
		</table>	
 		<form name="form2" method="post" action="contra-plancomprasreporte.php">
        	<?php if($_POST[oculto]==""){$_POST[numpos]=0;$_POST[numres]=10;$_POST[nummul]=0;}?>
            <input name="oculto" id="oculto" type="hidden" value="1">
            <input name="iddel" id="iddel" type="hidden" value="<?php echo $_POST[iddel]?>">
			<table  class="inicio" align="center" >
                <tr>
                    <td class="titulos" colspan="6">:: Buscar Plan de Compras</td>
                    <td class="cerrar" style="width:7%"><a href="inve-principal.php">&nbsp;Cerrar</a></td>
                </tr>
      			<tr>
            		<td class="saludo1" style="width:8%">Vigencia:</td>
            		<td style="width:10%"><input type="text" name="vigencia" id="vigencia" value="<?php echo $_POST[vigencia];?>" maxlength="4" style="width:100%" onKeyUp="return tabular(event,this)"  onKeyPress="javascript:return solonumeros(event)"/> </td>
            		<td class="saludo1" style="width:8%">Codigo:</td>
            		<td style="width:10%"><input type="text" name="codigosu" id="codigosu" value="<?php echo $_POST[codigosu];?>" maxlength="8" style="width:100%" onKeyUp="return tabular(event,this)"  onKeyPress="javascript:return solonumeros(event)"/> </td>
            		<td class="saludo1" style="width:3%">Descripci&oacute;n:</td>
            		<td><input type="text" name="descripcion" id="descripcion" value="<?php echo $_POST[descripcion];?>" style="width:65%"/></td>
       			</tr>                       
			</table>
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
            <input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
            <input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
    		<div class="subpantallac5" style=" height:67%;overflow-x:hidden;">
				<?php
					$oculto=$_POST['oculto'];
					if($oculto=="3")
					{
						$sqlr ="DELETE FROM contraplancompras WHERE codplan='".$_POST[iddel]."'";
						mysql_query($sqlr,$linkbd);
						?> <script> alert("Se Elimino la Adquisici\xf3n con exito");document.form2.oculto.value="";</script><?php
					}
					//if($_POST[oculto])
					{
						$crit1=" ";
						$crit2=" ";
						$crit3=" ";
						$_POST[detallefill]="";
						if ($_POST[vigencia]!="")
						{$crit1="AND (vigencia LIKE '%$_POST[vigencia]%')"; $_POST[detallefill]=" Vigencia ($_POST[vigencia]), ";}
						if ($_POST[codigosu]!="")
						{$crit2="AND codigosunspsc LIKE '%$_POST[codigosu]%'";$_POST[detallefill]=$_POST[detallefill]." Codigo UNSPSC ($_POST[codigosu]), ";}
						if ($_POST[descripcion]!="")
						{$crit3="AND descripcion LIKE '%$_POST[descripcion]%' ";$_POST[detallefill]=$_POST[detallefill]." Descripcion ($_POST[descripcion])";}
						$sqlr="SELECT * FROM contraplancompras WHERE estado='S' $crit1 $crit2 $crit3";
						$resp = mysql_query($sqlr,$linkbd);
						$_POST[numtop]=mysql_num_rows($resp);
						$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
						$sqlr="SELECT * FROM contraplancompras WHERE estado='S' $crit1 $crit2 $crit3  ORDER BY vigencia ASC, codplan ASC LIMIT $_POST[numpos],$_POST[numres]";
						$resp = mysql_query($sqlr,$linkbd);
						$_POST[nresultados]=$_POST[numtop];
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
						<table class='inicio' align='center' width='75%'>
							<tr>
								<td colspan='8' class='titulos'>.: Resultados Busqueda:</td>
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
							<tr>
								<td colspan='9'>Total Adquisiciones: $_POST[numtop]</td>
							</tr>
							<tr>
								<td class='titulos2' style=\"width:5%;\">Vigencia</td>
								<td class='titulos2' style=\"width:6%;\">Codigo UNSPSC</td>
								<td class='titulos2' style=\"width:30%;\">Descripcion</td>
								<td class='titulos2' style=\"width:7%;\">Fecha Estimada</td>
								<td class='titulos2' style=\"width:6%;\">Duracion Estimada</td>
								<td class='titulos2' style=\"width:12%;\">Modalidad Seleccion</td>
								<td class='titulos2' style=\"width:20%;\">Fuente</td>
								<td class='titulos2' style=\"width:10%;\">Vlr Estimado</td>
								<td class='titulos2' style=\"width:10%;\">Vlr Estimado Vig Actual</td>
							</tr>";
						$iter='saludo1a';
						$iter2='saludo2';
						while ($row =mysql_fetch_row($resp)) 
						{
							$con2=$con+ $_POST[numpos];
							$comcodigo=str_replace("-","</br>",$row[4]);
							$sqlr2="SELECT descripcion_valor FROM dominios  WHERE nombre_dominio='MODALIDAD_SELECCION' AND (valor_final IS NULL or valor_final ='') AND valor_inicial='".$row[8]."'";
							$row2 =mysql_fetch_row(mysql_query($sqlr2,$linkbd));
							$sqlr3="SELECT nombre FROM pptosidefrecursos WHERE codigo='$row[9]'";
							$row3 =mysql_fetch_row(mysql_query($sqlr3,$linkbd));
							echo "
								<tr class='$iter'>
									<td>$row[1]</td>
									<td>". $comcodigo."</td>
									<td>".strtoupper($row[5])."</td>
									<td>$row[6]</td>
									<td>$row[7]</td>
									<td>$row2[0]</td>
									<td>$row3[0]</td>
									<td>$".number_format($row[10],2)."</td>
									<td>$".number_format($row[11],2)."</td>
									<input name='adqdescripcion[]' value='".$row[5]."' type='hidden' >
									<input name='adqprodtodos[]' value='".str_replace("-"," ",$row[4])."' type='hidden' >
									<input name='adqprodtodos2[]' value='".$row[4]."' type='hidden' >
									<input name='adqfecha2[]' value='".$row[6]."' type='hidden' >
									<input name='adqduracion[]' value='".$row[7]."' type='hidden' >
									<input name='adqmodalidad2[]' value='".$row2[0]."' type='hidden' >
									<input name='adqfuente2[]' value='".$row3[0]."' type='hidden' >
									<input name='adqvlrestimado[]' value='".$row[10]."' type='hidden' >
									<input name='adqvlrvig[]' value='".$row[11]."' type='hidden' >
									<input name='vigencias[]' value='".$row[1]."' type='hidden' >
								</tr>";
							$con+=1;
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
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
						echo"			&nbsp;&nbsp;<a href='#'>$imagenforward</a>
										&nbsp;<a href='#'>$imagensforward</a>
									</td>
								</tr>
							</table>";
					}
				?>
			</div>
            <input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>" />
    		<input type="hidden" id="detallefill" name="detallefill" value="<?php echo $_POST[detallefill];?>">
    		<input type="hidden" id="nresultados" name="nresultados" value="<?php echo $_POST[nresultados];?>">
    	</form>
	</body>
</html>

