<?php //V 1000 12/12/16 ?> 
<?php 
	require"comun.inc";
	require"funciones.inc";
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		 <title>:: Meci - Calidad</title>
		 <?php require "head.php"; ?>
		<script>
        function ponprefijo(pref,opc,objeto,nobjeto,nfoco)
		{   
            parent.document.getElementById(''+objeto).value =pref ;
            parent.document.getElementById(''+nobjeto).value =opc ;
			if (nfoco!=''){parent.document.getElementById(''+nfoco).focus() ;}
			parent.despliegamodal2("hidden");
        } 
        </script> 
	</head>
	<body>
		<form name="form2" method="post">
			<?php
				if($_POST[oculto]==""){$_POST[numpos]=0;$_POST[numres]=10;$_POST[nummul]=0;}
          		$_POST[tobjeto]=$_GET[objeto];$_POST[tnobjeto]=$_GET[nobjeto];$_POST[tnfoco]=$_GET[nfoco];
         	 ?>
			<table  class="inicio ancho" style="width:99.4%;" >
      			<tr>
                	<td class="titulos" colspan="2" width='100%'>:: Buscar Funcionario</td>
                	<td class="boton02" onClick="parent.despliegamodal2('hidden');">Cerrar</td>
                </tr>
      			<tr>
                	<td class="saludo1" style="width:3.5cm;">Documento o Nombre:</td>
       				<td>
                    	<input type="text" name="nombre" id="nombre" value="<?php echo $_POST[nombre];?>" style="width:50%;"/>
                        <em class="botonflecha" name="bboton" onClick="limbusquedas();" >Buscar</em>
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
					{
					$crit1="AND 
					(
						IF (ltrim(rtrim(nombre2))<>'' AND nombre2 IS NOT NULL,
							IF (ltrim(rtrim(apellido2))<>'' AND apellido2 IS NOT NULL,
								concat_ws(' ', nombre1,nombre2,apellido1,apellido2,razonsocial,cedulanit) LIKE '%$_POST[nombre]%', 
								concat_ws(' ', nombre1,nombre2,apellido1,razonsocial,cedulanit) LIKE '%$_POST[nombre]%'),
							IF (ltrim(rtrim(apellido2))<>'' AND apellido2 IS NOT NULL,
								concat_ws(' ', nombre1,apellido1,apellido2,razonsocial,cedulanit) LIKE '%$_POST[nombre]%',
								concat_ws(' ', nombre1,apellido1,razonsocial,cedulanit) LIKE '%$_POST[nombre]%'))
					)";
					}
					//{$crit1="AND concat_ws(' ', nombre1, ltrim(rtrim(nombre2)), apellido1, ltrim(rtrim(apellido2)), razonsocial, cedulanit) LIKE '%$_POST[nombre]%'";}
					$sqlr="SELECT * FROM terceros where estado='S' AND empleado='1' $crit1";
					$resp = mysql_query($sqlr,$linkbd);
					$_POST[numtop]=mysql_num_rows($resp);
					$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
					$sqlr="SELECT * FROM terceros where estado='S' AND empleado='1' $crit1 ORDER BY apellido1,apellido2,nombre1,nombre2 LIMIT $_POST[numpos],$_POST[numres]";
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
								</select>
							</td>
						</tr>
						<tr><td colspan='7'>Terceros Encontrados: $_POST[numtop]</td></tr>
						<tr>
							<td class='titulos2' width='2%'>ITEM</td>
							<td class='titulos2' width='30%'>RAZON SOCIAL</td>
							<td class='titulos2' width='10%'>PRIMER APELLIDO</td>
							<td class='titulos2' width='10%'>SEGUNDO APELLIDO</td>
							<td class='titulos2' width='10%'>PRIMER NOMBRE</td>
							<td class='titulos2' width='10%'>SEGUNDO NOMBRE</td>
							<td class='titulos2' width='4%'>DOCUMENTO</td>
						</tr>";	
					$iter='saludo1a';
					$iter2='saludo2';
					while ($row =mysql_fetch_row($resp)) 
					{
						$con2=$con+ $_POST[numpos];
						if ($row[11]=='31'){$ntercero=$row[5];}
						else 
						{
							if(trim($row[4])!="")
							{
								if(trim($row[2])!=""){$ntercero="$row[3] $row[4] $row[1] $row[2]";}
								else {$ntercero="$row[3] $row[4] $row[1]";}
							}
							else
							{
								if(trim($row[2])!=""){$ntercero="$row[3] $row[1] $row[2]";}
								else {$ntercero="$row[3] $row[1]";}
							}
						}
						echo "
						<tr class='$iter' onClick=\"javascript:ponprefijo('$row[12]','$ntercero','$_POST[tobjeto]','$_POST[tnobjeto]', '$_POST[tnfoco]')\" onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
	onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase'>
							<td>$con2</td>
							<td>$row[5]</td>
							<td>$row[3]</td>
							<td>$row[4]</td>
							<td>$row[1]</td>
							<td>$row[2]</td>
							<td>$row[12]</td>
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