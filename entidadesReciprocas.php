
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
		<?php require "head.php";?>
		<title>:: Contabilidad</title>
		<script>
		function ponprefijo(pref,opc,objeto,nobjeto)
		{ 
			parent.document.getElementById(''+objeto).value =pref ;
			parent.document.getElementById(''+nobjeto).value =opc ;
			parent.despliegamodal2("hidden");
		} 
		</script> 
		<?php titlepag();?>
	</head>
	<body>
		<form name="form2" method="post">
			<?php
				if($_POST[oculto]==""){$_POST[numpos]=0;$_POST[numres]=10;$_POST[nummul]=0;}
		  		$_POST[tobjeto]=$_GET[objeto];$_POST[tnobjeto]=$_GET[nobjeto];$_POST[tnfoco]=$_GET[nfoco];
		 	 ?>
			<table  class="inicio ancho" style="width:99.4%;" >
	  			<tr>
					<td class="titulos" colspan="4" width="100%">:: Entidades Reciprocas</td>
					<td class="boton02" onClick="parent.despliegamodal2('hidden');" >Cerrar</td>
				</tr>
	  			<tr>
					<td class="saludo1" style="width:4cm;">Id entidadad, NIT o Nombre:</td>
	   				<td >
						<input type="text" name="nombre" id="nombre" value="<?php echo $_POST[nombre];?>" style="width:60%;"/>
						<em name="bboton" class="botonflecha" onClick="limbusquedas();" >Buscar</em>
					</td>
	   			</tr>                       
			</table> 
			<input type="hidden" name="oculto" id="oculto" value="1"/>
			<input type="hidden" name="tobjeto" id="tobjeto" value="<?php echo $_POST[tobjeto]?>"/>
			<input type="hidden" name="tnobjeto" id="tnobjeto" value="<?php echo $_POST[tnobjeto]?>"/>
			<input type="hidden" name="tnfoco" id="tnfoco" value="<?php echo $_POST[tnfoco]?>"/>
			<input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
			<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
			<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
			<div class="subpantalla" style="height:83.5%; width:99%; overflow-x:hidden;">
				<?php
					$crit1=" ";
					$crit2=" ";
					if ($_POST[nombre]!="")
					{$crit1=" AND concat_ws(' ', id_entidad,nit,nombre) LIKE '%$_POST[nombre]%'";}
					$sqlr="SELECT * FROM codigoscun where id_entidad!='' $crit1";
					$resp = mysql_query($sqlr,$linkbd);
					$_POST[numtop]=mysql_num_rows($resp);
					$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
					$cond2="";
					if ($_POST[numres]!="-1"){$cond2="LIMIT $_POST[numpos], $_POST[numres]";}
					$sqlr="SELECT * FROM codigoscun where id_entidad!='' $crit1 ORDER BY id_entidad $cond2";
					$resp = mysql_query($sqlr,$linkbd);
					$con=1;
					$numcontrol=$_POST[nummul]+1;
					if(($nuncilumnas==$numcontrol)||($_POST[numres]=="-1"))
					{
						$imagenforward="<img src='imagenes/forward02.png' style='width:17px;cursor:default;'>";
						$imagensforward="<img src='imagenes/skip_forward02.png' style='width:16px;cursor:default;'>";
					}
					else 
					{
						$imagenforward="<img src='imagenes/forward01.png' style='width:17px;cursor:pointer;' title='Siguiente' onClick='numsiguiente()'>";
						$imagensforward="<img src='imagenes/skip_forward01.png' style='width:16px;cursor:pointer;' title='Fin' onClick='saltocol(\"$nuncilumnas\")'>";
					}
					if(($_POST[numpos]==0)||($_POST[numres]=="-1"))
					{
						$imagenback="<img src='imagenes/back02.png' style='width:17px;cursor:default;'>";
						$imagensback="<img src='imagenes/skip_back02.png' style='width:16px;cursor:default;'>";
					}
					else
					{
						$imagenback="<img src='imagenes/back01.png' style='width:17px;cursor:pointer;' title='Anterior' onClick='numanterior();'>";
						$imagensback="<img src='imagenes/skip_back01.png' style='width:16px;cursor:pointer;' title='Inicio' onClick='saltocol(\"1\")'>";
					}
					echo "
					<table class='inicio' align='center' width='99%'>
						<tr>
							<td colspan='6' class='titulos'>.: Resultados Busqueda:</td>
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
						<tr><td colspan='7'>Terceros Encontrados: $_POST[numtop]</td></tr>
						<tr>
							<td class='titulos2' width='2%'>ID ENTIDAD</td>
							<td class='titulos2' width='10%'>NIT</td>
							<td class='titulos2' width='1%'>CV</td>
							<td class='titulos2' width='30%'>NOMBRE</td>
							<td class='titulos2' width='10%'>DEPARTAMENTO</td>
							<td class='titulos2' width='10%'>MUNICIPIO</td>
							<td class='titulos2' width='4%'>CONSECUTIVO</td>
						</tr>";	
					$iter='saludo1a';
					$iter2='saludo2';
					while ($row =mysql_fetch_assoc($resp)) 
					{
						$con2=$con+ $_POST[numpos];
						$ntercero=iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$row['nombre']);
						echo "
						<tr class='$iter' onClick=\"javascript:ponprefijo('$row[id_entidad]','$row[nombre]','$_POST[tobjeto]','$_POST[tnobjeto]')\">
							<td>".strtoupper(iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$row['id_entidad']))."</td>
							<td>".strtoupper(iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$row['nit']))."</td>
							<td>".strtoupper(iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$row['cv']))."</td>
							<td>".strtoupper(iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$row['nombre']))."</td>
							<td>".strtoupper(iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$row['depto']))."</td>
							<td>".strtoupper(iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$row['municipio']))."</td>
							<td>".strtoupper(iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$row['consecutivo']))."</td>
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
									<a>$imagensback</a>&nbsp;
									<a>$imagenback</a>&nbsp;&nbsp;";
					if($nuncilumnas<=9){$numfin=$nuncilumnas;}
					else{$numfin=9;}
					for($xx = 1; $xx <= $numfin; $xx++)
					{
						if($numcontrol<=9){$numx=$xx;}
						else{$numx=$xx+($numcontrol-9);}
						if($numcontrol==$numx){echo"<a onClick='saltocol(\"$numx\")'; style='color:#24D915;cursor:pointer;'> $numx </a>";}
						else {echo"<a onClick='saltocol(\"$numx\")'; style='color:#000000;cursor:pointer;'> $numx </a>";}
					}
					echo "		&nbsp;&nbsp;<a>$imagenforward</a>
									&nbsp;<a>$imagensforward</a>
								</td>
							</tr>
						</table>";
				?>
			</div>
			<input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>" />
		</form>
	</body>
</html>
