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
        <script type="text/javascript" src="css/programas.js"></script>
		<script>
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
				document.form2.action= "archivos/<?php echo $_SESSION[usuario];?>-reporteabonos.csv";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function crearexcel(){
				document.form2.action="teso-buscarecaudosexcel.php";
				document.form2.target="_BLANK";
				document.form2.submit();
				document.form2.action="";
				document.form2.target="";
			}
			function verUltimaPos(idcta){
				location.href="teso-editaabono.php?idabono="+idcta;
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("teso");?></tr>
			<tr>
  				<td colspan="3" class="cinta"><a onClick="location.href='teso-abonoacuerdopredial.php'" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>  <a class="mgbt1"><img src="imagenes/guardad.png"/></a>  <a onClick="document.form2.submit();" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>  <a class="mgbt" onClick="<?php echo paginasnuevas("teso");?>"><img src="imagenes/nv.png" title="Nueva Ventana"></a>  <a href="#" onclick="crearexcel()" class="mgbt"><img src="imagenes/excel.png" title="Excel"></a></</td>
         	</tr>
     	</table>	
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
 		<form name="form2" method="post" action="teso-buscaabonos.php">
        	<?php
        		if($_POST[oculto]=="")
				{
					$_POST[numres]=10;$_POST[numpos]=0;$_POST[nummul]=0;
				}
			?>
			<table  class="inicio" style="width:99.7%">
                <tr >
                    <td class="titulos" colspan="6">:. Buscar Abonos </td>
                    <td class="cerrar" style="width:7%;"><a onClick="location.href='teso-principal.php'">&nbsp;Cerrar</a></td>
                </tr>
                <tr>
                    <td class="saludo1" style="width:3.6cm;">Numero Abono:</td>
                    <td  style="width:10%;"><input type="search" name="numero" id="numero" value="<?php echo $_POST[numero];?>" style="width:100%;"/></td>
                    <td class="saludo1" style="width:3.6cm;">Concepto Abono:</td>
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
    		<div class="subpantallap" style="height:68%; width:99.6%; overflow-x:hidden;" id="divdet">
    			<?php	
					$crit1=" ";
					$crit2=" ";
					if ($_POST[numero]!=""){$crit1=" and tesoabono.id_abono like '%$_POST[numero]%' ";}
					if ($_POST[nombre]!=""){$crit2=" and tesoabono.concepto like '%$_POST[nombre]%'  ";}
					//sacar el consecutivo 
					//$sqlr="select *from pptosideforigen where".$crit1.$crit2." order by pptosideforigen.codigo";
					$sqlr="select *from tesoabono where tesoabono.id_abono>-1 and tipomovimiento='201' $crit1 $crit2 order by tesoabono.id_abono DESC";
					$resp1 = mysql_query($sqlr,$linkbd);
					$ntr = mysql_num_rows($resp1);
					$_POST[numtop]=mysql_num_rows($resp1);
					$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
					$cond2="";
					if ($_POST[numres]!="-1"){$cond2="LIMIT $_POST[numpos], $_POST[numres]"; }
					$sqlr="select *from tesoabono where tesoabono.id_abono>-1 and tipomovimiento='201' $crit1 $crit2 order by tesoabono.id_abono DESC $cond2";
					$resp = mysql_query($sqlr,$linkbd);
					$con=1;
					$numcontrol=$_POST[nummul]+1;
					$namearch="archivos/".$_SESSION[usuario]."-reporterecaudos.csv";
					$Descriptor1 = fopen($namearch,"w+"); 
					$lista = array ('ID_ABONO','CONCEPTO','FECHA','DOC TERCERO','TERCERO','VALOR','ESTADO');
					fputcsv($Descriptor1, $lista,";");
					while ($row1 =mysql_fetch_row($resp1)) 
 					{
						$ntercero=buscatercero($row1[3]);
						unset($lista);
						$lista = array ($row1[0],$row1[5],$row1[2],$row1[3],$ntercero,number_format($row1[4],2,",",""),$row1[6]);
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
						<tr><td colspan='2'>Abonos Encontrados: $_POST[numtop]</td></tr>
						<tr>
							<td class='titulos2' style='width:7%;'>Codigo</td>
							<td class='titulos2'>Nombre</td>
							<td class='titulos2' style='width:7%;'>Fecha</td>
							<td class='titulos2'  style='width:10%;'>Contribuyente</td>
							<td class='titulos2' style='width:12%;'>Valor</td>
							<td class='titulos2' style='width:5%;text-align:center;'>Estado</td>
							<td class='titulos2' style='width:5%;text-align:center;'>Ver</td>
						</tr>";	
					$iter='zebra1';
					$iter2='zebra2';
 					while ($row =mysql_fetch_row($resp)) 
 					{
						$ntercero=buscatercero($row[3]);
						echo "
						<tr class='$iter' onDblClick=\"verUltimaPos($row[0])\">
							<td >$row[0]</td>
							<td >$row[5]</td>
							<td >$row[2]</td>
							<td >$row[3]</td>
							<td style='text-align:right'>$ ".number_format($row[4],2,".",",")."</td>";
	  					if ($row[6]=='S')
	 					echo "<td style='text-align:center;'><img src='imagenes/confirm.png'></center></td>";
	 					if ($row[6]=='N')
						echo "<td style='text-align:center;'><img src='imagenes/del3.png'></td>";	
						if ($row[6]=='P')
						 echo "<td style='text-align:center;'><img src='imagenes/dinero3.png'></td>";
						 if ($row[6]=='R')
						 echo "<td style='text-align:center;'><img src='imagenes/reversado.png'></td<td ></td>";
	 					echo "<td style='text-align:center;'><a href='teso-editaabono.php?idabono=$row[0]'><img src='imagenes/lupa02.png'  style='width:19px;'></a></td></tr>";
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