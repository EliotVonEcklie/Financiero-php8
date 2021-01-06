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
		<title>:: Spid - Tesoreria</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
        <script type="text/javascript" src="css/programas.js"></script>
		<script>
			function verUltimaPos(idcta, filas, filtro){
				var scrtop=$('#divdet').scrollTop();
				var altura=$('#divdet').height();
				var numpag=$('#nummul').val();
				var limreg=$('#numres').val();
				if((numpag<=0)||(numpag==""))
					numpag=0;
				if((limreg==0)||(limreg==""))
					limreg=10;
				numpag++;
				location.href="teso-verexogena1001.php?idexo="+idcta+"&scrtop="+scrtop+"&totreg="+filas+"&altura="+altura+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
			}
			function eliminar(idr)
			{
				if (confirm("Esta Seguro de Eliminar el Recibo de Caja"))
				{
				document.form2.oculto.value=2;
				document.form2.var1.value=idr;
				document.form2.submit();
				}
			}
			function archivocsv()
			{
				document.form2.action= "archivos/<?php echo $_SESSION[usuario];?>-reporterecaudos.csv";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
		</script>
		<?php titlepag();?>
		<?php
		$scrtop=$_GET['scrtop'];
		if($scrtop=="") $scrtop=0;
		echo"<script>
			window.onload=function(){
				$('#divdet').scrollTop(".$scrtop.")
			}
		</script>";
		$gidcta=$_GET['idcta'];
		if(isset($_GET['filtro']))
			$_POST[nombre]=$_GET['filtro'];
		?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("cont");?></tr>
			<tr>
  				<td colspan="3" class="cinta">
					<a onClick="location.href='teso-exogena1001.php'" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
					<a class="mgbt1"><img src="imagenes/guardad.png"/></a>
					<a onClick="document.form2.submit();" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a class="mgbt" onClick="<?php echo paginasnuevas("cont");?>"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a class="mgbt" onClick="archivocsv();"><img src="imagenes/csv.png" style="width:29px;height:25px;" title="csv"></a>
					<a onClick="location.href='teso-exogena1001.php'" class="mgbt"><img src="imagenes/iratras.png" title="Retornar"></a>
				</td>
         	</tr>
     	</table>	
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
		<?php
		if($_GET[numpag]!=""){
			$oculto=$_POST[oculto];
			if($oculto!=2){
				$_POST[numres]=$_GET[limreg];
				$_POST[numpos]=$_GET[limreg]*($_GET[numpag]-1);
				$_POST[nummul]=$_GET[numpag]-1;
			}
		}
		else{
			if($_POST[nummul]==""){
				$_POST[numres]=10;
				$_POST[numpos]=0;
				$_POST[nummul]=0;
			}
		}
		?>
 		<form name="form2" method="post" action="teso-buscaexogena1001.php">
        	<?php
        		if($_POST[oculto]=="")
				{
					$_POST[numres]=10;$_POST[numpos]=0;$_POST[nummul]=0;
				}
			?>
			<table  class="inicio" style="width:99.7%">
                <tr >
                    <td class="titulos" colspan="6">:. Buscar Exogenas 1001 </td>
                    <td class="cerrar" style="width:7%;"><a onClick="location.href='teso-principal.php'">&nbsp;Cerrar</a></td>
                </tr>
                <tr>
                    <td class="saludo1" style="width:3.6cm;">Numero Id:</td>
                    <td  style="width:10%;"><input type="search" name="numero" id="numero" value="<?php echo $_POST[numero];?>" style="width:100%;"/></td>
                    <td class="saludo1" style="width:3.6cm;">Concepto Exogena:</td>
                    <td>
                    	<input type="search" name="nombre" id="nombre"  value="<?php echo $_POST[nombre];?>" style="width:60%;"/>
                    	<input type="button" name="bboton" onClick="limbusquedas();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" />
                    </td>
                </tr>                       
            </table> 
        	<input type="hidden" name="oculto" id="oculto"  value="1"/>
        	<input type="hidden" name="var1" value="<?php echo $_POST[var1];?>"/>  
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
    		<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
       		<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
         	<input type="hidden" name="oculto2" id="oculto2" value="<?php echo $_POST[oculto2];?>">
    		<div class="subpantallap" style="height:68%; width:99.6%; overflow-x:hidden;" id="divdet">
    			<?php	
					
					$crit1=" ";
					$crit2=" ";
					if ($_POST[numero]!=""){$crit1=" and exogena_cab.id_exo like '%$_POST[numero]%' ";}
					if ($_POST[nombre]!=""){$crit2=" and exogena_cab.descripcion like '%$_POST[nombre]%'  ";}
					//sacar el consecutivo 
					//$sqlr="select *from pptosideforigen where".$crit1.$crit2." order by pptosideforigen.codigo";
					$sqlr="select *from exogena_cab where exogena_cab.id_exo>-1 $crit1 $crit2 order by exogena_cab.id_exo DESC";
					$resp1 = mysql_query($sqlr,$linkbd);
					$ntr = mysql_num_rows($resp1);
					$_POST[numtop]=mysql_num_rows($resp1);
					$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
					$cond2="";
					if ($_POST[numres]!="-1"){$cond2="LIMIT $_POST[numpos], $_POST[numres]"; }
					$sqlr="select *from exogena_cab where exogena_cab.id_exo>-1 $crit1 $crit2 order by exogena_cab.id_exo DESC $cond2";
					$resp = mysql_query($sqlr,$linkbd);
					$con=1;
					$numcontrol=$_POST[nummul]+1;
					$namearch="archivos/".$_SESSION[usuario]."-reporterecaudos.csv";
					$Descriptor1 = fopen($namearch,"w+"); 
					$lista = array ('ID_RECAUDO','CONCEPTO','FECHA','DOC TERCERO','TERCERO','VALOR','ESTADO');
					fputcsv($Descriptor1, $lista,";");
					while ($row1 =mysql_fetch_row($resp1)) 
 					{
						$ntercero=buscatercero($row1[4]);
						unset($lista);
						$lista = array ($row1[0],$row1[6],$row1[2],$row1[4],$ntercero,number_format($row1[5],2,",",""),$row1[7]);
						fputcsv($Descriptor1, $lista,";");
					}
					fclose($Descriptor1);
					if(($nuncilumnas==$numcontrol)||($_POST[numres]=="-1"))
					{
						$imagenforward="<img src='imagenes/forward02.png' style='width:17px;cursor:default;'>";
						$imagensforward="<img src='imagenes/skip_forward02.png' style='width:16px;cursor:default;' >";
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
					$con=1;
					echo "
					<table class='inicio' align='center' >
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
						<tr><td colspan='2'>Recaudos Encontrados: $_POST[numtop]</td></tr>
						<tr>
							<td class='titulos2' style='width:7%;'>Codigo</td>
							<td class='titulos2'>Descripcion</td>
							<td class='titulos2' style='width:7%;'>Vigencia</td>
							<td class='titulos2'  style='width:10%;'>Fecha</td>
							<td class='titulos2' style='width:5%;text-align:center;'>Estado</td>
							<td class='titulos2' style='width:5%;text-align:center;'>Anular</td>
							<td class='titulos2' style='width:5%;text-align:center;'>Ver</td>
						</tr>";	
					$iter='zebra1';
					$iter2='zebra2';
					$filas=1;
 					while ($row =mysql_fetch_row($resp)) 
 					{
						$ntercero=buscatercero($row[4]);
						if($gidcta!="")
						{
							if($gidcta==$row[0]){
								$estilo='background-color:yellow';
							}
							else{
								$estilo="";
							}
						}
						else{
							$estilo="";
						}	
						$idcta="'".$row[0]."'";
						$numfil="'".$filas."'";
						$filtro="'".$_POST[nombre]."'";
						echo "
						<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" onDblClick=\"verUltimaPos($idcta, $numfil, $filtro)\" style='text-transform:uppercase; $estilo' >
							<td >$row[0]</td>
							<td >$row[3]</td>
							<td >$row[2]</td>
							<td >$row[1]</td>";
	  					if ($row[4]=='S')
	 					echo "<td style='text-align:center;'><img src='imagenes/confirm.png'></center></td><td ><a href='#' onClick=eliminar($row[0])><center><img src='imagenes/anular.png'></a></td>";
	 					if ($row[4]=='N')
						echo "<td style='text-align:center;'><img src='imagenes/del3.png'></td><td ></td>";	
						if ($row[4]=='P')
	 					echo "<td style='text-align:center;'><img src='imagenes/dinero3.png'></td><td ></td>";
								$idcta="'".$row[0]."'";
								$numfil="'".$filas."'";
								echo"<td style='text-align:center;'>
									<a onClick=\"verUltimaPos($idcta, $numfil, $filtro)\" style='cursor:pointer;'>
										<img src='imagenes/lupa02.png'  style='width:19px;'>
									</a>
								</td>
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
					echo"			&nbsp;&nbsp;<a>$imagenforward</a>
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