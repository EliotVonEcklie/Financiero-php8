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
			function ponprefijo(codigo,nombre)
			{ 
				parent.document.form2.codproyecto.value = codigo ;	
				parent.document.form2.nproyecto.value =nombre;
				parent.document.form2.buscameta.value='1'
				parent.despliegamodal2("hidden");	
				parent.document.form2.submit();
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
                	<td colspan="2" class="titulos">Metas</td>
                    <td class="cerrar" style="width:10%;"><a onClick="parent.despliegamodal2('hidden');" href="#" >&nbsp;Cerrar</a></td>
                </tr>
				<?php
				
				$sqln="SELECT nombre, orden, codigo FROM plannivelespd WHERE estado='S' ORDER BY orden";
                $resn=mysql_query($sqln,$linkbd);
				$n=0; $j=0;
					  while($wres=mysql_fetch_array($resn))
						{
							if (strcmp($wres[0],'INDICADORES')!=0)
								{
									if($wres[1]==1){$buspad='';}
									elseif($_POST[arrpad][($j-1)]!=""){$buspad=$_POST[arrpad][($j-1)];}
									else {$buspad='';}
									echo "<tr>";
									echo "<td class='saludo1' style='width:20%'>".strtoupper($wres[0])."</td>";
									echo "<td  style='width:80%'>
                                                <select name='niveles[$j]' id='niveles[$j]'  onChange='document.form2.submit();' onKeyUp='return tabular(event,this)' style='width:85%;'>
                                                    <option value=''>Seleccione....</option>";
                                        $sqlr="SELECT * FROM presuplandesarrollo WHERE padre='$buspad'  ORDER BY codigo";
                                        $res=mysql_query($sqlr,$linkbd);
                                        while ($row =mysql_fetch_row($res)) 
                                        {
                                            if($row[0]==$_POST[niveles][$j])
                                            {
                                                $_POST[arrpad][$j]=$row[0];
                                                $_POST[nmeta]=$row[0];
                                                $_POST[meta]=$row[1];
                                                $_POST[codmeta]=$wres[2];
                                                echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";
                                                
                                            }
                                            else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}	 
                                        }	
                                        echo"	</select>
                                                <input type='hidden' name='arrpad[$j]' value='".$_POST[arrpad][$j]."' >
                                                <input type='hidden' name='meta' value='".$_POST[meta]."' >
                                                <input type='hidden' name='codmeta' value='".$_POST[codmeta]."' >
                                                <input type='hidden' name='codmetas[]' value='".$_POST[codmeta]."' />
                                                 <input type='hidden' name='nmetas[]' value='".$_POST[meta]."' />
                                                <input type='hidden' name='nmeta' value='".$_POST[nmeta]."' >

                                            </td>";
											echo "<tr>";
											$j++;
								}
						}			
				?>
	

 			</table>
 			<table  class="inicio" style="width:99.4%;" >
      			<tr><td class="titulos" colspan="4">:: Busqueda por BPIM</td></tr>
     			<tr>
        			<td class="saludo1" style="width:2.5cm;">:: Nombre del Proyecto:</td>
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
					if($_POST[nombre]!=""){$crit2="AND planproyectos.nombre LIKE '%$_POST[nombre]%' "; }
					if ($_POST[nmeta]!=""){$tabla=",planproyectos_det"; $crit1="AND planproyectos_det.valor='$_POST[nmeta]' AND planproyectos_det.codigo=planproyectos.codigo";}

 					$sqlr="SELECT * FROM planproyectos$tabla  WHERE planproyectos.estado='S'  $crit1 $crit2 GROUP BY planproyectos.codigo";
 					$resp=mysql_query($sqlr,$linkbd);
					$_POST[numtop]=mysql_num_rows($resp);
					$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
					$sqlr="SELECT * FROM planproyectos$tabla  WHERE planproyectos.estado='S'  $crit1 GROUP BY planproyectos.codigo ORDER BY planproyectos.codigo ASC  LIMIT $_POST[numpos],$_POST[numres]";
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
						<tr><td colspan='3'>Proyectos Encontrados: $_POST[numtop]</td></tr>
 						<tr>
							<td class='titulos' style='width:10%'>Codigo</td>
							<td class='titulos'>Nombre</td>
							<td class='titulos' style='width:10%'>Vigencia</td>
						</tr>";
					while($r=mysql_fetch_row($resp))
  					{
						echo"
						<tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\" onClick=\"ponprefijo('$r[1]','$r[3]')\" style='text-transform:uppercase'>
							<td>$r[1]</td>
							<td>$r[3]</td>
							<td>$r[2]</td>
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
