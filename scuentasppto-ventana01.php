<?php //V 1000 12/12/16 ?> 
<?php
	require "comun.inc";
	require "funciones.inc";
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
		<title>:: SieS - Presupuesto</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
		<script>
			var anterior;
			function ponprefijo(pref,opc)
			{ 
				
				parent.document.form2.cuentap.value =pref;
				parent.document.form2.ncuentap.value =opc ;
				//parent.document.form2.concecont.focus();
				
				parent.despliegamodal2("hidden");
			} 
		</script> 
		<?php titlepag();?>
	</head>
	<body>
  		<form method="post" name="form2">
        	<?php
	 			if($_POST[oculto]==""){$_POST[numpos]=0;$_POST[numres]=10;$_POST[nummul]=0;if(!$_POST[tipo]){$_POST[tipo]=$_GET[ti];}}
				$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
			?>
  			<table class="inicio">
    			<tr>
      				<td height="25" colspan="3" class="titulos" >Buscar CUENTAS PRESUPUESTALES</td>
          			<td class="cerrar"><a onClick="parent.despliegamodal2('hidden');" href="#" >&nbsp;Cerrar</a></td>
    			</tr>
				<tr><td colspan="4" class="titulos2" >:&middot; Por Descripcion </td></tr>
				<tr>
					<td class="saludo1" style="width:15%;" >:&middot; Numero Cuenta:</td>
				  	<td  colspan="3"><input type="text" name="numero" id="numero" value="<?php echo $_POST[numero];?>"/>
				  		<input name="oculto" type="hidden" id="tipo" value="<?php echo $_POST[tipo]?>" >
			      		<input name="oculto" type="hidden" id="oculto" value="1" >
			      		<input type="submit" name="Submit" value="Buscar" >
			      	</td>
			    </tr>
    			<tr><td colspan="4" align="center">&nbsp;</td></tr>
  			</table>
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
    		<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
       		<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
            <div class="subpantalla" style="height:77.5%; width:99.6%; overflow-x:hidden;">
				<?php
					
					if ($_POST[numero]!=""){$cond="AND (cuenta LIKE '%$_POST[numero]%' OR nombre LIKE '%_POST[numero])%')";}
					else{$cond="";}
  					if($_POST[tipo]=='1')
					{$sqlr="SELECT DISTINCT * FROM pptocuentas WHERE clasificacion='ingresos' $cond AND vigencia='$vigusu' ";}
 					else {$sqlr="SELECT DISTINCT * FROM pptocuentas WHERE clasificacion!='ingresos' $cond AND vigencia='$vigusu'";}
					$resp = mysql_query($sqlr,$linkbd);	
					$_POST[numtop]=mysql_num_rows($resp);
					$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
					if($_POST[tipo]=='1')
					{$sqlr="SELECT DISTINCT * FROM pptocuentas WHERE clasificacion='ingresos' $cond AND vigencia='$vigusu' ORDER BY cuenta LIMIT $_POST[numpos],$_POST[numres]";}
 					else {$sqlr="SELECT DISTINCT * FROM pptocuentas WHERE clasificacion!='ingresos' $cond AND vigencia='$vigusu' ORDER BY cuenta LIMIT $_POST[numpos],$_POST[numres]";}
					$resp = mysql_query($sqlr,$linkbd);					
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
					echo "
					<table class='inicio'>
    					<tr>
      						<td height='25' colspan='4' class='titulos' >Resultados Busqueda </td>
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
						<tr><td colspan='5'>Cuentas Encontradas: $_POST[numtop]</td></tr>
    					<tr>
      						<td width='32' class='titulos2' >Item</td>
      						<td width='76' class='titulos2' >Cuenta </td>
							<td width='140' class='titulos2' >Descripcion</td>	  
							<td width='140' class='titulos2' >Tipo</td>
							<td width='140' class='titulos2' >Estado</td>	  	  
    					</tr>";
						
					while ($r =mysql_fetch_row($resp)) 
	    			{
						$con2=$i+ $_POST[numpos];
    					echo"<tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" ";
						if ($r[2]=='Auxiliar'){echo "onClick=\"javascript:ponprefijo('$r[0]','$r[1]')\"";} 
						echo">
						<td>$con2</td>
    	 				<td>$r[0]</td>
     					<td>".ucwords(strtolower($r[1]))."</td>
      	 				<td>$r[2]</td>
     	 				<td>".ucwords(strtolower($r[3]))."</td></tr>";
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
					echo"			&nbsp;&nbsp;<a href='#'>$imagenforward</a>
									&nbsp;<a href='#'>$imagensforward</a>
								</td>
							</tr>
						</table>";		
					$_POST[oculto]="";
				?>
			</div>
            <input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>"/>
		</form>
	</body>
</html>
 