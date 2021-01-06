<?php
//Elaborado por Sergio Murillo - Desarrollador
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
		<title>:: Spid - Tesoreria</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
   	 	<link href="css/css3.css" rel="stylesheet" type="text/css" />
		<script type='text/javascript' src='JQuery/jquery-2.1.4.min.js'></script>
   		<script type="text/javascript" src="css/programas.js"></script>
		<script>
			function verUltimaPos(idcta, filas, filtro)
			{
				location.href="teso-facturacionver.php?codigo="+idcta;
			}

			function archivocsv()
			{
				document.form2.action= "";  //Nombre archivo que genera CSV
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
		</script>
		<?php 
			titlepag();
			$scrtop=$_GET['scrtop'];
			if($scrtop=="") {$scrtop=0;}
			echo"<script>window.onload=function(){ $('#divdet').scrollTop(".$scrtop.")}</script>";
			$gidcta=$_GET['idcta'];
			if(isset($_GET['filtro'])){$_POST[nombre]=$_GET['filtro'];}
		?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("teso");?></tr>
			<tr>
  				<td colspan="3" class="cinta">
				<a onClick="location.href='teso-prefacturacion.php'" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a>
				<a class="mgbt1"><img src="imagenes/guardad.png" title="Guardar" /></a>
				<a onClick="document.form2.submit();" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
				<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
				<a class="mgbt" onClick="<?php echo paginasnuevas("teso");?>"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
				<a onClick="archivocsv();" class="mgbt"><img src="imagenes/csv.png" style="width:29px;height:25px;" title="csv"></a></td>
        	</tr>	
  		</table>
       </table>
        <?php
			if($_GET[numpag]!="")
			{
				$oculto=$_POST[oculto];
				if($oculto!=2)
				{
					$_POST[numres]=$_GET[limreg];
					$_POST[numpos]=$_GET[limreg]*($_GET[numpag]-1);
					$_POST[nummul]=$_GET[numpag]-1;
				}
			}
			else
			{
				if($_POST[nummul]=="")
				{
					$_POST[numres]=10;
					$_POST[numpos]=0;
					$_POST[nummul]=0;
				}
			}
		?>
 		<form name="form2" method="post" action="teso-buscaprefacturacion.php">
    		<input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
			<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
			<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
			<table  class="inicio" align="center" >
    			<tr >
        			<td class="titulos" colspan="4">:. Buscar Proceso Pre-facturacion</td>
        			<td class="cerrar" style="width:7%;"><a onClick="location.href='teso-principal.php'">&nbsp;Cerrar</a></td>
      			</tr>
      			<tr>
         			<td style="width:7%" class="saludo1"> N&uacute;mero Proceso: </td>
    				<td  style="width: 20%">
            			<input type="search" name="codigo" id="codigo"  value="<?php echo $_POST[codigo];?>" style="width:70%" >
                        <input type="button" name="bboton" onClick="limbusquedas();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" />
           			</td>
					<td class="saludo3" style="width: 7%">Zona: </td>
					<td style="width: 15%">
						<select id="zona" name="zona" style="width:70%">
							<option value="">Seleccione...</option>
						</select>
					</td>
     			</tr>                       
  			</table>    
            <input type="hidden" name="oculto" id="oculto"  value="1">
          	<input type="hidden" name="var1" value=<?php echo $_POST[var1];?>>
			<div class="subpantallac5" style="height:68.5%; width:99.6%; overflow-x:hidden;" id="divdet">
				<?php
                	$oculto=$_POST[oculto];
					
                	$crit1="";
					$crit2="";
					$tablacrit2="";
                	if ($_POST[codigo]!=""){
                		$crit1=" and TB1.codigo_factura like '%$_POST[codigo]%' ";
                	}
					if($_POST[zona]!=""){
						$crit2=" and TB2.zona like '%$_POST[zona]%' and TB1.codigo_factura = TB2.codigo_factura";
						$tablacrit2=",tesofacturacion_det TB2";
					}
					$sqlr="select * from tesoprefacturacion TB1 $tablacrit2 where TB1.estado<>'' $crit1 $crit2 group by codigo_factura order by TB1.codigo_factura DESC,tipomov DESC";
					$resp = mysql_query($sqlr,$linkbd);
					$ntr = mysql_num_rows($resp);
					$_POST[numtop]=$ntr;
					$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
					$cond2="";
					if ($_POST[numres]!="-1"){
						$cond2="LIMIT $_POST[numpos], $_POST[numres]";
					}
					
					$sqlr="select * from tesoprefacturacion TB1 $tablacrit2 where TB1.estado<>'' $crit1 $crit2 order by TB1.codigo_factura DESC $cond2";
					$resp = mysql_query($sqlr,$linkbd);
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
					$con=1;
					echo "
					<table class='inicio' align='center' >
						<tr>
							<td colspan='9' class='titulos'>.: Resultados Busqueda:</td>
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
						<tr>
							<td colspan='10'>Procesos Encontrados: $ntr</td>
						</tr>
						<tr style='text-align:center;'>
							<td class='titulos2' style='width:5%'>No. proceso</td>
							<td class='titulos2'>Concepto</td>
							<td class='titulos2'>Vigencia</td>
							<td class='titulos2' style='width:7%'>Fecha</td>
							<td class='titulos2'>Total Predial</td>
							<td class='titulos2'>Total Bomberil</td>
							<td class='titulos2'>Total Ambiental</td>
							<td class='titulos2'>Total Prefacturado</td>
							<td class='titulos2'>Estado</td>
							<td class='titulos2' width='4%'><center>Ver</td>
						</tr>";	
					$iter='saludo1a';
					$iter2='saludo2';
					$filas=1;
					while ($row =mysql_fetch_row($resp))
					{
						$concepto = "Proceso Prefacturacion $row[2] ";
						$idcta="'$row[0]'";
						$numfil="'$filas'";
						$filtro="'$_POST[codigo]'";
						echo"
						<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
					onMouseOut=\"this.style.backgroundColor=anterior\" onDblClick=\"verUltimaPos($idcta, $numfil, $filtro)\" style='text-transform:uppercase; $estilo' >
							<td style='text-align:center;'	>$row[0]</td>
							<td>$concepto</td>
							<td>$row[14] </td>
							<td>$row[1]</td>
							<td style='text-align:right'>$ ".number_format($row[3],2)."</td>
							<td style='text-align:right'>$ ".number_format($row[6],2)."</td>
							<td style='text-align:right'>$ ".number_format($row[8],2)."</td>
							<td style='text-align:right'>$ ".number_format($row[11],2)."</td>";
							if ($row[15]=='S'){echo "<td ><center><img src='imagenes/sema_verdeON.jpg' style='width:18px;'></center></td>";}
							if ($row[15]=='R'){echo "<td ><center><img src='imagenes/sema_rojoON.jpg' style='width:18px;'></center></td>";}
							echo"
							<td style='text-align:center;'>
								<a onClick=\"verUltimaPos($idcta, $numfil, $filtro)\" style='cursor:pointer;'>
									<img src='imagenes/lupa02.png' style='width:18px' title='Ver'>
								</a>
							</td>
						</tr>";
						$con+=1;
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
						$filas++;
					}
            		echo"</table>
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
								echo"&nbsp;&nbsp;<a href='#'>$imagenforward</a>
									&nbsp;<a href='#'>$imagensforward</a>
							</td>
						</tr>
					</table>";
				?>
			</div>
		</form> 
	</body>
</html>