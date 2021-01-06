<?php //V 1000 12/12/16 ?> 
<?php
	error_reporting(0);
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
			function validar(){document.form2.submit();}
			function buscaref(){document.form2.oculto.value=2;document.form2.submit();}
			function Cargapre(_val1,_val2)
			{
				document.getElementById('ncodigo').value=_val1;
				document.getElementById('nproductos').value=_val2;
				ponprefijo();
			}
			function ponprefijo()
			{ 
				parent.document.form2.cuenta.value = document.getElementById('ncodigo').value ;	
				parent.document.form2.ncuenta.value =document.getElementById('nproductos').value;
				parent.despliegamodal2("hidden"); 
			} 
			function mensaje(){
				parent.despliegamodalm('visible','2','Solo puede seleccionar productos');
			}
		</script> 
		<?php titlepag();?>
	</head>
	<body>
		<form name="form2" method="post">
            <input type="hidden" name="ncodigo" id="ncodigo" value="<?php echo $_POST[ncodigo]?>"> 
            <input type="hidden" name="nproductos" id="nproductos"  value="<?php echo $_POST[nproductos]?>"> 
        	<?php if($_POST[oculto]==""){$_POST[numpos]=0;$_POST[numres]=10;$_POST[nummul]=0;$_POST[ntipos]="";$_POST[npadre];}?>
 			<table class="inicio" style="width:99.4%;">
 				<tr>
                	<td colspan="2" class="titulos">Productos Plan de Compras</td>
                    <td class="cerrar" style="width:10%;"><a onClick="parent.despliegamodal2('hidden');" href="#" >&nbsp;Cerrar</a></td>
                </tr>
				<tr>
                	<td class="saludo1"><?php $dominio='UNSPSC' ; $clasificacion=buscadominiov2($dominio,'1'); echo strtoupper($clasificacion);?></td>
                    <td>
						<select name="grupo" onChange="validar()" style="width:85%">
                            <option value=''>Seleccione ...</option>
                            <?php
                                $sqlr="Select * from productospaa  where tipo='1'  and estado='S' order by tipo,codigo asc";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    if($row[0]==$_POST[grupo])
									{echo "
										<option value=$row[0] SELECTED>$row[0] - $row[1]</option>
										<script>
											document.getElementById('ncodigo').value='$row[0]';
											document.getElementById('nproductos').value='$row[1]';
										</script>";
									$_POST[ntipos]="2";
									$_POST[npadre]="$row[0]";
									}
									else{echo "<option value=$row[0]>$row[0] - $row[1]</option>";}
                                }			
		 					?>
						</select>
					</td>
     			</tr>
				<tr>
                	<td class="saludo1"><?php $dominio='UNSPSC' ; $clasificacion=buscadominiov2($dominio,'2'); echo strtoupper($clasificacion);?></td>
                    <td>
                        <select name="segmento" onChange="validar()" style="width:85%">
                            <option value=''>Seleccione ...</option>
                            <?php
                                $sqlr="Select * from productospaa  where tipo='2' and padre='$_POST[grupo]' and estado='S' order by tipo,codigo asc";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    if($row[0]==$_POST[segmento])
									{
										echo "
											<option value=$row[0] SELECTED>$row[0] - $row[1]</option>
											<script>
												document.getElementById('ncodigo').value='$row[0]';
												document.getElementById('nproductos').value='$row[1]';
											</script>";
										$_POST[ntipos]="3";
										$_POST[npadre]="$row[0]";
									}
                                    else{echo "<option value=$row[0]>$row[0] - $row[1]</option>";}
                                }			
                            ?>
                        </select>
                    </td>
      		 	</tr>
				<tr>
                	<td class="saludo1"><?php $dominio='UNSPSC' ; $clasificacion=buscadominiov2($dominio,'3'); echo strtoupper($clasificacion);?></td>
                	<td>
						<select name="familia" onChange="validar()" style="width:85%">
							<option value=''>Seleccione ...</option>
							<?php
								$sqlr="Select * from productospaa  where tipo='3' and padre='$_POST[segmento]' and estado='S' order by tipo,codigo asc";
								$resp = mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp)) 
								{
									if($row[0]==$_POST[familia])
									{
										echo "
											<option value=$row[0] SELECTED>$row[0] - $row[1]</option>
											<script>
												document.getElementById('ncodigo').value='$row[0]';
												document.getElementById('nproductos').value='$row[1]';
											</script>";
										$_POST[ntipos]="4";
										$_POST[npadre]="$row[0]";
									}
									else{echo "<option value=$row[0]>$row[0] - $row[1]</option>";}
			     				}			
		  					?>
						</select>
					</td>
       	 		</tr>
				<tr>
                	<td class="saludo1"><?php $dominio='UNSPSC' ; $clasificacion=buscadominiov2($dominio,'4'); echo strtoupper($clasificacion);?></td>
                    <td>
						<select name="clases" onChange="validar()" style="width:85%">
							<option value=''>Seleccione ...</option>
 							<?php
		   						$sqlr="Select * from productospaa  where tipo='4' and padre='$_POST[familia]' and estado='S' order by tipo,codigo asc";
		 						$resp = mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp)) 
								{
									if($row[0]==$_POST[clases])
									{
										echo "
											<option value=$row[0] SELECTED>$row[0] - $row[1]</option>
											<script>
												document.getElementById('ncodigo').value='$row[0]';
												document.getElementById('nproductos').value='$row[1]';
											</script>";
										$_POST[ntipos]="5";
										$_POST[npadre]="$row[0]";
									}
									else{echo "<option value=$row[0]>$row[0] - $row[1]</option>";}
			     				}			
		  					?>
						</select>
					</td>
          		</tr>
				<tr>
                	<td class="saludo1"><?php $dominio='UNSPSC' ; $clasificacion=buscadominiov2($dominio,'5'); echo strtoupper($clasificacion);?></td>
                    <td>
						<select  name="productos" onChange="validar()" style="width:85%">
							<option value=''>Seleccione ...</option>
 							<?php
		   						$sqlr="Select * from productospaa  where tipo='5' and padre='$_POST[clases]' and estado='S' order by tipo,codigo asc";
		 						$resp = mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp)) 
								{
									if($row[0]==$_POST[productos])
			 						{
				 						echo "
											<option value=$row[0] SELECTED>$row[0] - $row[1]</option>
											<script>
												document.getElementById('ncodigo').value='$row[0]';
												document.getElementById('nproductos').value='$row[1]';
											</script>";
				 					}
									else
									{echo "<option value=$row[0]>$row[0] - $row[1]</option>";}
			    				}			
		  					?>
						</select>
                        
                        <input type="button" value="Agregar" onClick="javascript:ponprefijo()">
					</td>
       			</tr>
 			</table>
 			<table  class="inicio" style="width:99.4%;" >
      			<tr><td class="titulos" colspan="4">:: Busqueda por Referencia</td></tr>
     			<tr>
        			<td class="saludo1" style="width:2.5cm;">:: Referencia:</td>
        			<td>
                    	<input type="text" name="nombre" id="nombre" value="<?php echo $_POST[nombre];?>" style="width:60%;"/>
                        <input type="button" name="Submit" value="Buscar" onClick="buscaref()" >
                    </td>
 				</tr>
 			</table>
            <input type="hidden" name="ntipos" id="ntipos" value="<?php echo $_POST[ntipos]?>">
            <input type="hidden" name="npadre" id="npadre" value="<?php echo $_POST[npadre]?>">
            <input type="hidden" name="oculto" id="oculto" value="1"/>
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
            <input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
            <input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
            <div class="subpantallac" style="height:56.4%; width:99.1%; overflow-x:hidden;">
			<?php
 				//if ($_POST[oculto]=='2')
				{
 					$co='saludo1a';
 					$co2='saludo2';
					if ($_POST[ntipos]!=""){$crit1="AND tipo='$_POST[ntipos]'";}
					if ($_POST[nombre]!=""){$crit2="AND concat_ws(' ', nombre, codigo) LIKE '%$_POST[nombre]%'";}
					if ($_POST[npadre]!=""){$crit3="AND padre='$_POST[npadre]'";}

 					$sqlr="SELECT * FROM productospaa  WHERE estado='S' $crit1 $crit2 $crit3";
 					$resp=mysql_query($sqlr,$linkbd);
					$_POST[numtop]=mysql_num_rows($resp);
					$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
					$sqlr="SELECT * FROM productospaa  WHERE estado='S' $crit1 $crit2 $crit3 ORDER BY codigo,nombre,tipo ASC LIMIT $_POST[numpos],$_POST[numres]";
 					$resp=mysql_query($sqlr,$linkbd);
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
					echo"
 					<table class='inicio'>
						<tr>
							<td colspan='2' class='titulos'>.: Resultados Busqueda:</td>
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
						<tr><td colspan='3'>Terceros Encontrados: $_POST[numtop]</td></tr>
 						<tr>
							<td class='titulos' style='width:10%'>Codigo</td>
							<td class='titulos'>Nombre</td>
							<td class='titulos' style='width:10%'>Tipo</td>
						</tr>";
					while($r=mysql_fetch_row($resp))
  					{
	  					$tipo=buscadominiov2("UNSPSC",$r[2]);
						$eleccion="";
						if($tipo!="PRODUCTO"){
							$eleccion =" onClick=\"mensaje()\" ";
						}else{
							$eleccion=" onClick=\"Cargapre('$r[0]','$r[1]')\" ";
						}
						echo"
						<tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\"  $eleccion style='text-transform:uppercase'>
							<td>$r[0]</td>
							<td>$r[1]</td>
							<td>$tipo</td>
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
					echo"			&nbsp;&nbsp;<a href='#'>$imagenforward</a>
									&nbsp;<a href='#'>$imagensforward</a>
								</td>
							</tr>
						</table>";
 				}
 			?>
 			</div>
            <input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>" />
 		</form>
	</body>
</html>
