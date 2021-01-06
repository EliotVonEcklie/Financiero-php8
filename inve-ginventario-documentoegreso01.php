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
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
       <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
		<script>
			function validar(){
				document.form2.submit();
			}
			function buscaref(){
					document.form2.oculto.value=2;document.form2.submit();
			}
			function ponprefijo(opc1,opc2,opc3,opc4,opc5,opc6){ 
				parent.document.getElementById('docum').value=opc1;	
				parent.document.getElementById('ndocum').value=opc2;
				parent.document.getElementById('valunitp').value=opc3;
				parent.document.getElementById('dcuentas').value=opc4;
				parent.document.getElementById('vigenciaorden').value=opc5;
				parent.document.getElementById('terceroegreso').value=opc6;
				parent.document.getElementById('ndocum').focus();
				parent.document.getElementById('ndocum').select();
				parent.despliegamodal2('hidden');
				parent.vartdoc(1);
			} 
		</script> 
		<?php titlepag();?>
	</head>
	<body>
		<form name="form2" method="post">
        	<?php
				if($_POST[oculto]=="")
				{
					$_POST[numpos]=0;
					$_POST[numres]=10;
					$_POST[nummul]=0;
				}
			?>
 			<table  class="inicio" style="width:99.4%;" >
      			<tr>
              		<td class="titulos" colspan="4">:: Buscar Documentos</td>
                    <td class="cerrar" style="width:10%;"><a onClick="parent.despliegamodal2('hidden');" href="#" >&nbsp;Cerrar</a></td>
                </tr>
     			<tr>
                	<td class="saludo1" style="width:2cm;">:: C&oacute;digo:</td>
                    <td style="width:20%;"><input type="text" name="codigo" id="codigo" value="<?php echo $_POST[codigo];?>" style="width:100%;"/></td>
        			<td class="saludo1" style="width:2cm;">:: Nombre:</td>
        			<td>
                    	<input type="text" name="nombre" id="nombre" value="<?php echo $_POST[nombre];?>" style="width:70%"/>&nbsp;
                        <input type="button" name="Submit" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" onClick="document.form2.submit();"/>
                    </td>
 				</tr>
 			</table>
            <input type="hidden" name="oculto" id="oculto" value="1"/>
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
       		<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
         	<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
            <div class="subpantallac" style="height:87%; width:99.1%; overflow-x:hidden;">
			<?php
					
 					$co='saludo1a';
 					$co2='saludo2';
					echo"
					<table class='inicio'>
						<tr>
							<td colspan='4' class='titulos'>.: Resultados Busqueda:</td>
							<td class='submenu' style='width:5%;'>
								<select name='renumres' id='renumres' onChange='cambionum();' style='width:100%'>
									<option value='10'"; if ($_POST[renumres]=='10'){echo 'selected';} echo ">10</option>
									<option value='20'"; if ($_POST[renumres]=='20'){echo 'selected';} echo ">20</option>
									<option value='30'"; if ($_POST[renumres]=='30'){echo 'selected';} echo ">30</option>
									<option value='50'"; if ($_POST[renumres]=='50'){echo 'selected';} echo ">50</option>
									<option value='100'"; if ($_POST[renumres]=='100'){echo 'selected';} echo ">100</option>
								</select>
							</td>
						</tr>
						<tr><td colspan='5'>Articulos Encontrados: $_POST[numtop]</td></tr>
						<tr>
							<td class='titulos2' style='width:10%'>Codigo</td>
							<td class='titulos2'>Vigencia</td>
							<td class='titulos2'>Descripci&oacute;n</td>
							<td class='titulos2' colspan='2' style='width:25%'>Fecha Registro</td>
						</tr>";
					$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
					$sq="SELECT TB1.cuenta FROM pptocuentas TB1,conceptoscontables_det TB2 WHERE YEAR(TB2.fechainicial)='$vigusu' and TB1.vigencia='$vigusu' AND TB1.codconcecausa=TB2.codigo AND TB2.tipo='AT'";
					$res=mysql_query($sq,$linkbd);
					while($ro=mysql_fetch_row($res))
					{
						$sql="SELECT id_orden FROM tesoordenpago_det WHERE cuentap='$ro[0]'";
						$re=mysql_query($sql,$linkbd);
						while($row1=mysql_fetch_row($re))
						{
							$crit1="";
							$crit2="";
							if ($_POST[codigo]!=""){$crit1="AND id_egreso LIKE '%$_POST[codigo]%'";}
							if ($_POST[nombre]!=""){$crit2="AND concepto LIKE '%$_POST[nombre]%'";
							}
							$sqlr="SELECT * FROM tesoegresos WHERE estado='S' AND id_orden='$row1[0]' $crit1 $crit2";
							$resp=mysql_query($sqlr,$linkbd);
							$_POST[numtop]=mysql_num_rows($resp);
							$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
							$sqlr="SELECT * FROM tesoegresos WHERE estado='S' AND id_orden='$row1[0]' $crit1 $crit2 ORDER BY vigencia DESC LIMIT $_POST[numpos],$_POST[numres]";
							$resp=mysql_query($sqlr,$linkbd);
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
							while($row=mysql_fetch_row($resp))
							{
								$sqlr1="SELECT *FROM almginventario WHERE codmov='$row[0]'";
								$result=mysql_query($sqlr1,$linkbd);
								$row2=mysql_num_rows($result);
								if($row2=='0')
								{
									echo"<tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
	onMouseOut=\"this.style.backgroundColor=anterior\" onClick=\"ponprefijo('$row[0]', '$row[8]','$row[7]','$ro[0]','$row[4]','$row[11]')\" style='text-transform:uppercase'>
									<td>$row[0]</td>
									<td>$row[4]</td>
									<td>$row[8]</td>
									<td colspan='2'>$row[3]</td>
									</tr>";
									$aux=$co;
									$co=$co2;
									$co2=$aux;
								}
							}
							
						}
					}
								
								
							echo"</table>
							<table class='inicio'>
								<tr>
									<td style='text-align:center;'>
										<a href='#'>$imagensback</a>&nbsp;
										<a href='#'>$imagenback</a>&nbsp;&nbsp;";
											if($nuncilumnas<=9){
												$numfin=$nuncilumnas;
											}
											else{
												$numfin=9;
											}
											for($xx = 1; $xx <= $numfin; $xx++){
												if($numcontrol<=9){$numx=$xx;}
												else{$numx=$xx+($numcontrol-9);}
												if($numcontrol==$numx){
													echo"<a href='#' onClick='saltocol(\"$numx\")'; style='color:#24D915'> $numx </a>";
												}
												else {
													echo"<a href='#' onClick='saltocol(\"$numx\")'; style='color:#000000'> $numx </a>";
												}
											}
											echo "&nbsp;&nbsp;<a href='#'>$imagenforward
										</a>
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
