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
		<title>:: Spid - Gestion Humana</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
        <script type="text/javascript" src="css/programas.js"></script>
		<script>
			function verUltimaPos(idcta, filas, filtro)
			{
				var scrtop=$('#divdet').scrollTop();
				var altura=$('#divdet').height();
				var numpag=$('#nummul').val();
				var limreg=$('#numres').val();
				if((numpag<=0)||(numpag==""))
					numpag=0;
				if((limreg==0)||(limreg==""))
					limreg=10;
				numpag++;
				location.href="hum-editaperiodos.php?idr="+idcta+"&scrtop="+scrtop+"&totreg="+filas+"&altura="+altura+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
			}
		</script>
		<?php titlepag();?>
		<?php
		$_POST[scrtop]=$_GET['scrtop'];
		if($_POST[scrtop]==""){$_POST[scrtop]=0;}
		$_POST[gidcta]=$_GET['idcta'];
		if(isset($_GET['filtro'])){$_POST[nombre]=$_GET['filtro'];}
		?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
    		<tr><script>barra_imagenes("hum");</script><?php cuadro_titulos();?></tr>	 
    		<tr><?php menu_desplegable("hum");?></tr>
  			<tr>
  				<td colspan="3" class="cinta"><a href="hum-periodos.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a><img src="imagenes/guardad.png" title="Guardar" /><a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a><a href="#" onClick="mypop=window.open('hum-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a></td>
        	</tr>	
		</table>
 		<form name="form2" method="post" action="hum-buscaperiodos.php">
        	<?php if($_POST[oculto]==""){$_POST[numpos]=0;$_POST[numres]=10;$_POST[nummul]=0;}?>
			<table  class="inicio" align="center" >
     			<tr>
        			<td class="titulos" colspan="6">:. Buscar Periodos </td>
        			<td width="139" class="cerrar" ><a href="hum-principal.php">Cerrar</a></td>
      			</tr>
      			<tr>
        			<td class="saludo1" style="width:7%">Codigo:</td>
        			<td style="width:10%"><input type="text" name="numero" id="numero" value="<?php echo $_POST[numero];?>" style="width:90%"/></td>
         			<td class="saludo1" style="width:7%">Nombre: </td>
    				<td ><input type="text" name="nombre" id="nombre" value="<?php echo $_POST[nombre];?>" style="width:40%"/></td>
        		</tr>                       
    		</table>    
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
            <input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
            <input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
    		<input type="hidden" name="oculto" id="oculto" value="1">
    		<div class="subpantallac5" style="height:68.5%; width:99.6%;overflow-x:hidden">
      			<?php
					$crit1=" ";
					$crit2=" ";
					if ($_POST[numero]!=""){$crit1="AND id_periodo LIKE '%$_POST[numero]%'";}
					if ($_POST[nombre]!=""){$crit2="AND nombre LIKE '%$_POST[nombre]%'";}
					$sqlr="SELECT * FROM humperiodos WHERE estado<>'' $crit1 $crit2";
					$resp = mysql_query($sqlr,$linkbd);
					$_POST[numtop]=mysql_num_rows($resp);
					$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
					$sqlr="SELECT * FROM humperiodos WHERE estado<>'' $crit1 $crit2 ORDER BY id_periodo LIMIT $_POST[numpos],$_POST[numres]";
					$resp = mysql_query($sqlr,$linkbd);
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
					<table class='inicio' align='center'>
						<tr>
							<td colspan='4' class='titulos'>.: Resultados Busqueda:</td>
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
						<tr><td colspan='5'>Variables Encontradas: $_POST[numtop]</td></tr>
						<tr>
							<td class='titulos2' style='width:6%'>Codigo</td>
							<td class='titulos2'>Nombre</td>
							<td class='titulos2' style='width:15%'>Días</td>
							<td class='titulos2' style='width:5%;text-align:center;'>Anular</td>
							<td class='titulos2' style='width:5%;text-align:center;'>Editar</td>
						</tr>";
					$iter='saludo1a';
					$iter2='saludo2';
					$filas=1;
	 				while ($row =mysql_fetch_row($resp)) 
 					{
						if($_POST[gidcta]!="")
						{
							if($_POST[gidcta]==$row[0]){$estilo='background-color:#FF9';}
							else{$estilo="";}
						}
						else{$estilo="";}	
						$idcta="'$row[0]'";
						$numfil="'$filas'";
						$filtro="'$_POST[nombre]'";
						echo "
						<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\" onDblClick=\"verUltimaPos($idcta, $numfil, $filtro)\" style='text-transform:uppercase; $estilo' >
							<td>$row[0]</td>
							<td>$row[1]</td>
							<td>$row[2]</td>
							<td style='text-align:center;'><a href='#'><img src='imagenes/anular.png'></a></td>";
							echo"<td style='text-align:center;'>
								<a onClick=\"verUltimaPos($idcta, $numfil, $filtro)\" style='cursor:pointer;'>
									<img src='imagenes/b_edit.png' style='width:18px' title='Editar'>
								</a>
							</td>
						</tr>";
	 					$con+=1;
	 					$aux=$iter;
	 					$iter=$iter2;
	 					$iter2=$aux;
						$filas++;
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
            <input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>" />
		</form> 
	</body>
</html>