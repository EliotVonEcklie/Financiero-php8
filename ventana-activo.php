<!--V 1.0 24/02/2015-->
<?php
	require "comun.inc";
	require"funciones.inc";
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
		<title>:: SieS</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
		<script> 
			function ponprefijo(var01,var02,objeto01,objeto02,tipo)
			{
				if (tipo=='activos') {
					if(objeto01!=''){parent.document.getElementById(''+objeto01).value =var01;}//activos
	            	if(objeto02!=''){parent.document.getElementById(''+objeto02).value =var02;}//nactivos
					parent.despliegamodal2("hidden");
					parent.document.form2.submit();
				}else if (tipo=='depreciacion') {
					if(objeto01!=''){parent.document.getElementById(''+objeto01).value =var01;}//depreciacion
	            	if(objeto02!=''){parent.document.getElementById(''+objeto02).value =var02;}//ndepreciacion
					parent.despliegamodal2("hidden");
					parent.document.form2.submit();
				}else if (tipo=='deterioro') {
					if(objeto01!=''){parent.document.getElementById(''+objeto01).value =var01;}//deterioro
	            	if(objeto02!=''){parent.document.getElementById(''+objeto02).value =var02;}//ndeterioro
					parent.despliegamodal2("hidden");
					parent.document.form2.submit();
				}
				
			} 
		</script> 
		<?php titlepag();?>
	</head>
	<body >
  	<form action="" method="post" name="form2">
    	<?php 
			if($_POST[oculto]=="")
			{
				$_POST[numpos]=0;
				$_POST[numres]=10;
				$_POST[nummul]=0;
				$_POST[tobjeto01]=$_GET[obj01];
				$_POST[tobjeto02]=$_GET[obj02];
			}
		?>
		<table  class="inicio" style="width:99.4%;">
  			<tr >
    			<td class="titulos" colspan="2">:. Buscar Cuentas Bancarias</td>
				<td style="width:7%" class="cerrar" ><a onClick="parent.despliegamodal2('hidden');" style="cursor:pointer;">Cerrar</a></td>
			</tr>
      		<tr >
        		<td style="width:4.5cm" class="saludo1">:. Nombre:
                	<input name="nombre" id="nombre" type="search" style="width:60%" value="<?php echo $_POST[nombre]; ?>">
                	<input type="button" name="bboton" onClick="limbusquedas();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" />
              	</td>
       		</tr>                       
    	</table> 
    	<input type="hidden" name="oculto" id="oculto" value="1">
    	<input type="hidden" name="vigencia" value="<?php echo $_GET[vigencia]?>">
        <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
        <input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
        <input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
        <input type="hidden" name="tobjeto01" id="tobjeto01" value="<?php echo $_POST[tobjeto01]?>"/>
        <input type="hidden" name="tobjeto02" id="tobjeto02" value="<?php echo $_POST[tobjeto02]?>"/>
		<div class="subpantalla" style="height:86%; width:99%; overflow-x:hidden;">
			<?php
				$crit1="";
				if ($_POST[nombre]!=""){
					$crit1="AND concat_ws(' ', nombre) LIKE '%$_POST[nombre]%'";
				}
				
				if ($_GET[tipo]=='activos') {

					$sqlr="SELECT * from acti_activos_cab where estado='S' $crit1";
					$resp = mysql_query($sqlr,$linkbd);
					$_POST[numtop]=mysql_num_rows($resp);
					$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
					$sqlr="SELECT * from acti_activos_cab where estado='S' $crit1";
					$resp = mysql_query($sqlr,$linkbd);

				}else if ($_GET[tipo]=='depreciacion') {


					$sqlr="SELECT * from acti_depreciacionactivos_cab where estado='S' $crit1";
					$resp = mysql_query($sqlr,$linkbd);
					$_POST[numtop]=mysql_num_rows($resp);
					$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
					$sqlr="SELECT * from acti_depreciacionactivos_cab where estado='S' $crit1";
					$resp = mysql_query($sqlr,$linkbd);

				}else if ($_GET[tipo]=='deterioro') {
					

					$sqlr="SELECT * from acti_deterioro_cab where estado='S' $crit1";
					$resp = mysql_query($sqlr,$linkbd);
					$_POST[numtop]=mysql_num_rows($resp);
					$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
					$sqlr="SELECT * from acti_deterioro_cab where estado='S' $crit1";
					$resp = mysql_query($sqlr,$linkbd);

				}

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
				<table class='inicio' align='center' width='99%'>
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
				<tr><td colspan='3'>Cuentas Bancarias Encontrados: $_POST[numtop]</td></tr>
				<tr>
					<td class='titulos2'>Item</td>
					<td class='titulos2' style='width:85%'>Nombre.</td>
				</tr>";	
				$iter='saludo1a';
				$iter2='saludo2';
				while ($row =mysql_fetch_row($resp)) 
				{	
					echo"<tr class='$iter' style='text-transform:uppercase' onClick=\"javascript:ponprefijo('$row[0]','$row[1]','$_POST[tobjeto01]','$_POST[tobjeto02]','$_GET[tipo]')\" onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" >
					
					 	<td>$row[0]</td>
					 	<td colspan='2'>$row[1]</td>
					</tr>";
				 $con+=1;
				 $aux=$iter;
				 $iter=$iter2;
				 $iter2=$aux;
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
