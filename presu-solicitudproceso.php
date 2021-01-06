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
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
		<script> 
			function ponprefijo(codsolicitud)
            { 
                parent.document.form2.idliq.value=codsolicitud;
                parent.validar();
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
					$_POST[numpos]=0;$_POST[numres]=10;$_POST[nummul]=0;
                }
            ?>
  			<table class="inicio" style="width:99.4%;">
    			<tr>
                	<td height="25" colspan="3" class="titulos" >Buscar Solicitud Proceso: </td>
                    <td class="cerrar" style="width:10%;"><a onClick="parent.despliegamodal2('hidden');" href="#" >&nbsp;Cerrar</a></td>
                </tr>
				<tr>
					<td class="saludo1" style="width:3cm;">:&middot; Descripci&oacute;n o Numero Solicitud:</td>
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
					{$cond=" AND concat_ws(' ',cuenta ,nombre) like '%$_POST[numero]%'";$cond2=" concat_ws(' ',cuenta ,nombre) like '%$_POST[numero]%' AND";}
					switch($_POST[tipo])
					{
						case '':	$sqlr1="SELECT DISTINCT * FROM pptocuentas WHERE vigencia='$vigusu' OR VIGENCIAF='$vigusu'";
									$sqlr2="SELECT DISTINCT * FROM pptocuentas WHERE vigencia='$vigusu' OR VIGENCIAF='$vigusu' ORDER BY cuenta LIMIT $_POST[numpos], $_POST[numres]";
									break;
						case '1':	$sqlr1="SELECT DISTINCT * FROM pptocuentas WHERE (left(cuenta,1)='1' OR left(cuenta,2)='R1') $cond AND (vigencia='$vigusu' OR vigenciaf='$vigusu')";
									$sqlr2="SELECT DISTINCT * FROM pptocuentas WHERE (left(cuenta,1)='1' OR left(cuenta,2)='R1') $cond AND (vigencia='$vigusu' OR vigenciaf='$vigusu') ORDER BY cuenta LIMIT $_POST[numpos], $_POST[numres]";
									break;
						case '2':	$sqlr1="SELECT DISTINCT * FROM pptocuentas WHERE $cond2 (vigencia='$vigusu' OR vigenciaf='$vigusu')";
									$sqlr2="SELECT DISTINCT * FROM pptocuentas WHERE  $cond2 (vigencia='$vigusu' OR vigenciaf='$vigusu') ORDER BY cuenta LIMIT $_POST[numpos], $_POST[numres]";
									break;
					}
					//echo $sqlr2;
                    $sqlr1="SELECT * FROM contrasoladquisiciones TB1,contrasolicitudcdpppto TB2 WHERE TB1.estado='S' AND TB2.ndoc='0' AND TB2.proceso=TB1.codsolicitud AND TB2.vigencia='$vigusu'";
					$resp = mysql_query($sqlr1,$linkbd);
					$_POST[numtop]=mysql_num_rows($resp);
                    $nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
					$sqlr2="SELECT * FROM contrasoladquisiciones TB1,contrasolicitudcdpppto TB2 WHERE TB1.estado='S' AND TB2.ndoc='0' AND TB2.proceso=TB1.codsolicitud AND TB2.vigencia='$vigusu' LIMIT $_POST[numpos], $_POST[numres]";
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
      						<td height='25' colspan='3' class='titulos'>Resultados Busqueda </td>
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
					</table>
					<table class='inicio'>
						<tr><td colspan='4'>Terceros Encontrados: $_POST[numtop]</td></tr>
    					<tr>
							<td class='titulos2' style='width:15%'>Cod. Solicitud </td>
							<td class='titulos2' >Descripci&oacute;n</td>	  
							<td class='titulos2' style='width:10%'>Fecha</td>
							<td class='titulos2' >Estado</td>	
							<td></td>  	  
    					</tr>";
					while ($r =mysql_fetch_row($resp)) 
	    			{
						$sq="SELECT * FROM contrasolicitudcdpppto TB1,contrasolicitudcdp TB2 WHERE TB1.estado='S' AND TB1.proceso='$r[0]' AND TB1.vigencia='$vigusu' AND TB1.ndoc='0' AND TB1.tipodoc='CDP' AND TB1.proceso=TB2.proceso AND TB2.liberado='1' AND TB2.estado='S'";
                        $rs = mysql_query($sq,$linkbd);
                        $r1=mysql_fetch_row($rs);
                        $redir='';
                        if($r1[0]!="")
                        {
                            $fondo="background-color: green";
                            $mensa="Orden de compra con solicitud de CDP. ";
                            $redir="ponprefijo('$r[0]')";
                        }
                        else
                        {
                            $fondo="background-color: red";
                            $mensa="Tiene una orden de compra sin solicitud de CDP.";
                        }
						$con2=$i+ $_POST[numpos];
						echo"<tr class='$co' onClick=\"javascript:$redir\" style='text-transform:uppercase' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\">
    	 					<td>$r[0]</td>
     	 					<td>$r[2]</td>
      	 					<td>$r[1]</td>
     	 					<td style='$fondo'>$mensa</td>
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