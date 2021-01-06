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
		<title>:: Spid - Presupuesto</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script>
			var anterior;
			function ponprefijo(pref,opc)
			{ 
				parent.document.form2.cuenta.value =pref  ;
				parent.document.form2.ncuenta.value =opc ;
				parent.document.form2.cuenta.focus();
				parent.document.form2.valorvl.value='';
				parent.document.form2.valorvl.focus();
				parent.despliegamodal2("hidden");
			} 
		</script> 
		<?php titlepag();?>
	</head>
	<body>
    	<form action="" method="post" enctype="multipart/form-data" name="form2">
			<?php 
				if($_POST[oculto]=="")
				{
					$_POST[numpos]=0;
					$_POST[numres]=10;
					$_POST[nummul]=0;
					$_POST[tipo]=$_GET[ti];
				}
				?>
  			<table class="inicio" style="width:99.4%;">
    			<tr>
      				<td height="25" colspan="3" class="titulos" >Buscar CUENTAS PRESUPUESTALES</td>
                    <td class="cerrar"><a onClick="parent.despliegamodal2('hidden');">&nbsp;Cerrar</a></td>
    			</tr>
				<tr><td colspan="4" class="titulos2" >:&middot; Por Descripcion </td></tr>
				<tr>
					<td class="saludo1" style='width:3cm;'>:&middot; Numero Cuenta:</td>
				  	<td  colspan="3">
                    	<input type="search" name="numero" id="numero" value="<?php echo $_POST[numero];?>" style='width:50%;'/>
				  		<input type="hidden" name="tipo" id="tipo" value="<?php echo $_POST[tipo]?>"/>
			      		
                        <input type="button" name="bboton" onClick="limbusquedas();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" />
			      	</td>
			    </tr>
  			</table>
            <input type="hidden" name="oculto" id="oculto" value="1"/>
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
    		<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
       		<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
			<div  class="subpantalla" style="height:80.5%; width:99.2%; overflow-x:hidden;">
				<?php
					$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
					$cond="and (cuenta like'%$_POST[numero]%' or nombre like '%$_POST[numero]%')";
					if($_POST[tipo]=='1'){$cond1="clasificacion='ingresos'";}
					else{$cond1="clasificacion<>'ingresos' ";}   
					$sqlr="Select distinct * from pptocuentas where $cond1 and (vigencia='$vigusu' or  vigenciaf='$vigusu') $cond";
					$resp = mysql_query($sqlr,$linkbd);	
					$_POST[numtop]=mysql_num_rows($resp);
					$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
					$cond2="";
					if ($_POST[numres]!="-1"){$cond2="LIMIT $_POST[numpos], $_POST[numres]";}
					$sqlr="Select distinct * from pptocuentas where $cond1 and (vigencia='$vigusu' or  vigenciaf='$vigusu') $cond order by cuenta $cond2";
					$resp = mysql_query($sqlr,$linkbd);	
					$co='saludo1a';
					$co2='saludo2';	
					$i=1;
					$numcontrol=$_POST[nummul]+1;
					if(($nuncilumnas==$numcontrol)||($_POST[numres]=="-1"))
					{
						$imagenforward="<img src='imagenes/forward02.png' style='width:17px'>";
						$imagensforward="<img src='imagenes/skip_forward02.png' style='width:16px' >";
					}
					else 
					{
						$imagenforward="<img src='imagenes/forward01.png' style='width:17px' title='Siguiente' onClick='numsiguiente()'>";
						$imagensforward="<img src='imagenes/skip_forward01.png' style='width:16px' title='Fin' onClick='saltocol(\"$nuncilumnas\")'>";
					}
					if(($_POST[numpos]==0)||($_POST[numres]=="-1"))
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
      						<td colspan='4' class='titulos'>Resultados Busqueda</td>
							<td class='submenu'>
									<select name='renumres' id='renumres' onChange='cambionum();' style='width:100%'>
										<option value='10'"; if ($_POST[renumres]=='10'){echo 'selected';} echo ">10</option>
										<option value='20'"; if ($_POST[renumres]=='20'){echo 'selected';} echo ">20</option>
										<option value='30'"; if ($_POST[renumres]=='30'){echo 'selected';} echo ">30</option>
										<option value='50'"; if ($_POST[renumres]=='50'){echo 'selected';} echo ">50</option>
										<option value='100'"; if ($_POST[renumres]=='100'){echo 'selected';} echo ">100</option>
										<option value='-1'"; if ($_POST[renumres]=='-1'){echo 'selected';} echo ">Todos</option>
									</select>
								</td>
      						</tr>
							<tr><td colspan='5'>Cuentas Encontradas: $_POST[numtop]</td></tr>
    						<tr>
      							<td class='titulos2' style='width:8%;'>Item</td>
      							<td class='titulos2' style='width:20%;'>Cuenta</td>
      							<td class='titulos2'>Descripcion</td>	  
      							<td class='titulos2' style='width:15%;'>Tipo</td>
      							<td class='titulos2' style='width:8%;'>Estado</td>	  	  
    						</tr>";
					while ($r =mysql_fetch_row($resp)) 
					{
						echo "
							<tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" "; if ($r[2]=='Auxiliar'){echo" onClick=\"javascript:ponprefijo('$r[0]','$r[1]')\"";} 
						echo">
								<td>$i</td>
								<td >$r[0]</td>
								<td>".ucwords(strtolower($r[1]))."</td>
								<td>$r[2]</td>
								<td>".ucwords(strtolower($r[3]))."</td></tr>";
       					$aux=$co;
        				$co=$co2;
        				$co2=$aux;
						$i=1+$i;
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
					$_POST[oculto]="";
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
				?>
			</div>
            <input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>"/>
		</form>
	</body>
</html> 
