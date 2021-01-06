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
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
		<script> 
			function ponprefijo(cuentasel,pref,opc)
			{ 
				var digitotipo=document.getElementById('tipo2').value;			
				parent.document.form2.codrubro.value=cuentasel;
				parent.buscarubro();
				parent.despliegamodal2('hidden');
			} 
		</script> 
		<?php titlepag();?>
	</head>
	<body >
    	<form action="" method="post" enctype="multipart/form-data" name="form2">
			<?php
                if($_POST[oculto]=="")
                {
                    $_POST[tipo]=$_GET[ti];$_POST[tipo2]=$_GET[ti2];
					$_POST[numpos]=0;$_POST[numres]=10;$_POST[nummul]=0;
                }
            ?>
  			<table class="inicio" style="width:99.4%;">
    			<tr>
                	<td height="25" colspan="3" class="titulos" >Buscar CUENTAS PRESUPUESTALES</td>
                    <td class="cerrar" style="width:10%;"><a onClick="parent.despliegamodal2('hidden');" href="#" >&nbsp;Cerrar</a></td>
                </tr>
				<tr>
					<td class="saludo1" style="width:3cm;">:&middot; Descripci&oacute;n o Numero Cuenta:</td>
				  	<td>
                    	<input type="text" name="numero" id="numero" value="<?php echo $_POST[numero];?>" style="width:70%"/>&nbsp;
			     		<input type="submit" name="Submit" value="Buscar" />
			      	</td>
			    </tr>
  			</table>
  			<input type="hidden" name="tipo"  id="tipo" value="<?php echo $_POST[tipo];?>" >
        	<input type="hidden" name="tipo2"  id="tipo2" value="<?php echo $_POST[tipo2]?>" >
			<input name="oculto" type="hidden" id="oculto" value="1" >
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
       		<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
         	<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
            <div class="subpantallac" style="height:86%; width:99.1%; overflow-x:hidden;">
				<?php
					$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
					if($_POST[numero]!="")
					{$cond=" AND concat_ws(' ',cuenta ,nombre) like '%$_POST[numero]%'";}
					switch($_POST[tipo])
					{
						case '':	$sqlr1="SELECT DISTINCT * FROM pptocuentas WHERE vigencia='$vigusu' OR VIGENCIAF='$vigusu'";
									$sqlr2="SELECT DISTINCT * FROM pptocuentas WHERE vigencia='$vigusu' OR VIGENCIAF='$vigusu' ORDER BY cuenta LIMIT $_POST[numpos], $_POST[numres]";
									break;
						case '1':	$sqlr1="SELECT DISTINCT * FROM pptocuentas WHERE (left(cuenta,1)='1' OR left(cuenta,2)='R1' ) $cond AND (vigencia='$vigusu' OR vigenciaf='$vigusu')";
									$sqlr2="SELECT DISTINCT * FROM pptocuentas WHERE (clasificacion!='ingresos' or clasificacion!='Ingresos') $cond AND (vigencia='$vigusu' OR vigenciaf='$vigusu') ORDER BY cuenta LIMIT $_POST[numpos], $_POST[numres]";
									break;
						case '2':	$sqlr1="SELECT DISTINCT * FROM pptocuentas WHERE (left(cuenta,1)>=2 OR (left(cuenta,1)='R' AND substring(cuenta,2,1)>=2)) $cond AND (vigencia='$vigusu' OR vigenciaf='$vigusu')";
								$sqlr2="SELECT DISTINCT * FROM pptocuentas WHERE (clasificacion!='ingresos' or clasificacion!='Ingresos')$cond AND (vigencia='$vigusu' OR vigenciaf='$vigusu') ORDER BY cuenta LIMIT $_POST[numpos], $_POST[numres]";
									break;
					}
					//ECHO $sqlr2;
					$resp = mysql_query($sqlr1,$linkbd);
					$_POST[numtop]=mysql_num_rows($resp);
					$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);	
					$resp = mysql_query($sqlr2,$linkbd);		
					$co='saludo1a';
	 				$co2='saludo2';	
	 				$i=1;
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
      						<td height='25' colspan='4' class='titulos'>Resultados Busqueda </td>
							<td class='submenu' style='width:2cm;'>
								<select name='renumres' id='renumres' onChange='cambionum();' style='width:100%'>
									<option value='10'"; if ($_POST[renumres]=='10'){echo 'selected';} echo ">10</option>
									<option value='20'"; if ($_POST[renumres]=='20'){echo 'selected';} echo ">20</option>
									<option value='30'"; if ($_POST[renumres]=='30'){echo 'selected';} echo ">30</option>
									<option value='50'"; if ($_POST[renumres]=='50'){echo 'selected';} echo ">50</option>
									<option value='100'"; if ($_POST[renumres]=='100'){echo 'selected';} echo ">100</option>
								</select>
							</td>
      					</tr>
						<tr><td colspan='5'>Terceros Encontrados: $_POST[numtop]</td></tr>
    					<tr>
							<td class='titulos2' style='width:5%'>Item</td>
							<td class='titulos2' style='width:15%'>Cuenta </td>
							<td class='titulos2' >Descripci&oacute;n</td>	  
							<td class='titulos2' style='width:10%'>Tipo</td>
							<td class='titulos2' style='width:5%'>Estado</td>	  	  
    					</tr>";
					while ($r =mysql_fetch_row($resp)) 
	    			{
						$con2=$i+ $_POST[numpos];
						if ($r[2]=='Auxiliar')
						{
    						echo"
							<tr class='$co' style='text-transform:uppercase' onClick=\"javascript:ponprefijo('$r[0]','$r[29]','$r[1]')\">";
						}
						else
						{	
							echo"
							<tr class='$co' style='text-transform:uppercase'>";
						}
						echo"
							<td>$con2</td>
    	 					<td>$r[0]</td>
     	 					<td>$r[1]</td>
      	 					<td>$r[2]</td>
     	 					<td>$r[3]</td>
						</tr>";
         				$aux=$co;
						$co=$co2;
						$co2=$aux;
						$i=1+$i;
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
