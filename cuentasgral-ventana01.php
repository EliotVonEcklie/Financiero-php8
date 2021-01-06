<?php //V 1000 12/12/16 ?> 
<!--V 1.0 24/02/2015-->
<?php
	require "comun.inc";
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
        <title>:: SPID</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script>
			function ponprefijo(pref,opc,objeto,nobjeto)
			{  
				parent.document.getElementById(''+objeto).value =pref;
				if (document.getElementById('tnobjeto').value!="000")
				{parent.document.getElementById(''+nobjeto).value =opc;}
				parent.despliegamodal2("hidden");
			} 
		</script> 
		<?php titlepag();?>
	</head>
	<body>
  		<form action="" method="post" name="form2">
  			<?php 
				if($_POST[oculto]=="")
				{
					$_POST[tobjeto]=$_GET[objeto];
					$_POST[tnobjeto]=$_GET[nobjeto];
					$_POST[numpos]=0;
					$_POST[numres]=10;
					$_POST[nummul]=0;
				}
			?>
			<table  class="inicio">
      			<tr>
      				<td class="titulos" colspan="3" >Buscar CUENTAS</td>
                    <td class="cerrar"><a onClick="parent.despliegamodal2('hidden');" href="#" >&nbsp;Cerrar</a></td>
    			</tr>
				<tr><td class="titulos2" colspan="4">:&middot; Por Descripcion </td></tr>
				<tr>
					<td class="saludo1" style='width:4cm;'>::N&deg; Cuenta o Descripci&oacute;n:</td>
        			<td>
                    	<input type="search" name="nombre" id="nombre" value="<?php echo $_POST[nombre];?>" style='width:50%;'/>
                        <input type="button" name="bboton" onClick="limbusquedas();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" />
                    </td>
				</tr>      
    		</table>
    		<input type="hidden" name="oculto" id="oculto" value="1" >
            <input type="hidden" name="tobjeto" id="tobjeto" value="<?php echo $_POST[tobjeto]?>">
            <input type="hidden" name="tnobjeto" id="tnobjeto" value="<?php echo $_POST[tnobjeto]?>">
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
    		<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
       		<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
    		<div class="subpantalla" style="height:78.5%; width:99.6%; overflow-x:hidden;">
      		<?php
				$cond="";
				if ($_POST[nombre]!=""){$cond="WHERE concat_ws(' ', tabla.cuenta, tabla.nombre) LIKE '%$_POST[nombre]%'";$cond1="WHERE concat_ws(' ', cuenta, nombre) LIKE '%$_POST[nombre]%'"; }
				$sqlr="SELECT * FROM (SELECT cn1.cuenta FROM cuentasnicsp AS cn1 INNER JOIN cuentasnicsp AS cn2 ON cn2.tipo='Auxiliar'  AND cn2.cuenta LIKE CONCAT( cn1.cuenta,  '%' ) WHERE cn1.tipo='Mayor' GROUP BY cn1.cuenta UNION SELECT cuenta FROM cuentasnicsp WHERE tipo='Auxiliar') AS tabla  $cond";
				$resp = mysql_query($sqlr,$linkbd);
				$_POST[numtop]=mysql_num_rows($resp);
				$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
				$cond2="";
				if ($_POST[numres]!="-1"){$cond2="LIMIT $_POST[numpos], $_POST[numres]";}
				$sqlr="SELECT * FROM (SELECT cn1.cuenta,cn1.nombre,cn1.naturaleza,cn1.centrocosto,cn1.tercero,cn1.tipo,cn1.estado FROM cuentasnicsp AS cn1 INNER JOIN cuentasnicsp AS cn2 ON cn2.tipo='Auxiliar'  AND cn2.cuenta LIKE CONCAT( cn1.cuenta,  '%' ) WHERE cn1.tipo='Mayor' GROUP BY cn1.cuenta UNION SELECT cuenta,nombre,naturaleza,centrocosto,tercero,tipo,estado FROM cuentasnicsp WHERE tipo='Auxiliar') AS tabla $cond ORDER BY 1 $cond2";
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
					<tr><td colspan='8'>Cuentas Encontradas: $_POST[numtop]</td></tr>
					<tr>
						<td style='width:4%'  class='titulos2' >Item</td>
						<td style='width:12%'class='titulos2' >Cuenta </td>
						<td class='titulos2' >Descripcion</td>
						<td style='width:14%'class='titulos2' >Tipo</td>
						<td style='width:6%' class='titulos2' >Estado</td>	
					</tr>";
					while ($r =mysql_fetch_row($resp)) 
					{	
						$con2=$i+ $_POST[numpos];	
						echo"<tr class='$co' style='text-transform:uppercase' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" ";
						if ($r[5]=='Auxiliar'){echo "onClick=\"javascript:ponprefijo('$r[0]','$r[1]','$_POST[tobjeto]','$_POST[tnobjeto]')\"";} 
						echo ">
						<td>$con2</td>
						<td>$r[0]</td>
						<td>$r[1]</td>
						<td>$r[5]</td>
						<td style='text-align:center;'>$r[6]</td></tr>";
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