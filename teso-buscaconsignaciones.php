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
		<title>:: SieS - Tesoreria</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
        <script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
		<script>
			function verUltimaPos(idcta, dc, filas, filtro){
				var scrtop=$('#divdet').scrollTop();
				var altura=$('#divdet').height();
				var numpag=$('#nummul').val();
				var limreg=$('#numres').val();
				if((numpag<=0)||(numpag==""))
					numpag=0;
				if((limreg==0)||(limreg==""))
					limreg=10;
				numpag++;
				location.href="teso-editaconsignaciones.php?idr="+idcta+"&dc="+dc+"&scrtop="+scrtop+"&totreg="+filas+"&altura="+altura+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
			}
		</script>
		<script>
			function eliminar(idr)
			{
				document.form2.var1.value=idr;
				despliegamodalm('visible','4','Esta Seguro de Eliminar la Consignacion '+idr,'1');
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventanam').src="";}
				else
				{
					switch(_tip)
					{
						case "1":
							document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
						case "2":
							document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
						case "3":
							document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
						case "4":
							document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
					}
				}
			}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":
						document.form2.oculto.value="2";
						document.form2.submit();
						break;
				}
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
			$_POST[numero]=$_GET['filtro'];
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
					<a href="teso-consignaciones.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a>
					<a class="mgbt"><img src="imagenes/guardad.png"/></a>
					<a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a>
					<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png"title="Nueva Ventana"></a></td>
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
 		<form name="form2" method="post" action="teso-buscaconsignaciones.php">
         	<input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
       		<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
         	<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
        	<input type="hidden" name="cambioestado" id="cambioestado" value="<?php echo $_POST[cambioestado];?>"/>
          	<input type="hidden" name="nocambioestado" id="nocambioestado" value="<?php echo $_POST[nocambioestado];?>"/>
            <?php
				if($_POST[oculto]=="")
				{
					$_POST[cambioestado]="";$_POST[nocambioestado]="";
				}
			?>
			<table  class="inicio" align="center" >
      			<tr>
        			<td class="titulos" colspan="6">:. Buscar Comprobante de Consignaci&oacute;n</td>
        			<td class="cerrar" style="width:7%;"><a href="teso-principal.php">&nbsp;Cerrar</a></td>
      			</tr>
      			<tr>
        			<td class="saludo1" style="width:3cm;">N° Comprobante:</td>
        			<td style="width:15%;"><input type="search" name="numero" id="numero" value="<?php echo $_POST[numero];?>" style="width:95%;"/></td>
         			<td class="saludo1" style="width:2.5cm;">Fecha Inicial: </td>
    				<td style="width:12%;">
					<input id="fc_1198971545" title="DD/MM/YYYY" name="fechaini" type="text" value="<?php echo $_POST[fechaini]?>" maxlength="10" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)">   
					<a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/calendario04.png" style="width:20px" align="absmiddle" border="0"></a></td>
  					<td class="saludo1" style="width:2.5cm;">Fecha Final: </td>
    				<td>
						<input id="fc_1198971546" title="DD/MM/YYYY" name="fechafin" type="text" value="<?php echo $_POST[fechafin]?>" maxlength="10" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)">   
					<a href="#" onClick="displayCalendarFor('fc_1198971546');"><img src="imagenes/calendario04.png" style="width:20px" align="absmiddle" border="0"></a>
                        <input type="button" name="bboton" onClick="limbusquedas();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" />
                    </td>
        		</tr>                       
    		</table> 
            <input type="hidden" name="oculto" id="oculto" value="1"/>
            <input type="hidden" name="var1" id="var1"  value="<?php echo $_POST[var1];?>"/>
            <div class="subpantallap" style="height:68.5%; width:99.6%; overflow-x:hidden;" id="divdet">
				<?php
										
                    if($_POST[oculto]==2)
                    {
						
                        $sqlr="select * from tesoconsignaciones_cab where id_consignacion=$_POST[var1]";
                     	$resp = mysql_query($sqlr,$linkbd);
                        $row=mysql_fetch_row($resp);
                        // //********Comprobante contable en 000000000000
                        $sqlr="update comprobante_cab set total_debito='0',total_credito='0',estado='0' where tipo_comp='8' and numerotipo='$row[0]'";
                        mysql_query($sqlr,$linkbd);
                        $sqlr="update comprobante_det set valdebito='0',valcredito='0' where id_comp='8 $row[0]'";
                     	mysql_query($sqlr,$linkbd);		
                        $sqlr="update tesoconsignaciones_cab set estado='N' where id_consignacion=$row[0]";
                        mysql_query($sqlr,$linkbd);
                    }
					$crit1=" ";
					$crit2=" ";
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaini],$fecha1);
					$fechaf=$fecha1[3]."-".$fecha1[2]."-".$fecha1[1];
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechafin],$fecha2);
					$fechaf2=$fecha2[3]."-".$fecha2[2]."-".$fecha2[1];
					if ($_POST[numero]!=""){$crit1="AND id_consignacion LIKE '%$_POST[numero]%'";}
					if ($_POST[fechaini]!="" and $_POST[fechafin]!="" )
					{$crit2="AND fecha BETWEEN '$fechaf' AND '$fechaf2'";}	
					$sqlr="SELECT * FROM tesoconsignaciones_cab WHERE estado<>'' $crit1 $crit2 ";
					$resp = mysql_query($sqlr,$linkbd);
					$_POST[numtop]=mysql_num_rows($resp);
					$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
					$cond2="";
					if ($_POST[numres]!="-1"){ 
						$cond2="LIMIT $_POST[numpos], $_POST[numres]"; 
					}
					
					$sqlr="SELECT * FROM tesoconsignaciones_cab WHERE estado<>'' $crit1 $crit2 ORDER BY id_consignacion desc $cond2";
					$resp = mysql_query($sqlr,$linkbd);
					$ntr = mysql_num_rows($resp);
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
						<tr><td colspan='7' class='saludo1'>Comprobante de Consignación Encontrados: $_POST[numtop]</td></tr>
						<tr>
							<td width='150' class='titulos2'>No Consignacion</td>
							<td class='titulos2'>Fecha</td>
							<td class='titulos2'>Concepto Consignación</td>
							<td class='titulos2'>Valor</td>
							<td class='titulos2' style='width:5%'>Estado</td>
							<td class='titulos2' style='width:5%'><center>Anular</td>
							<td class='titulos2' style='width:5%'>Editar</td>
						</tr>";	
					$iter='saludo1a';
					$iter2='saludo2';
					$filas=1;
 					while ($row =mysql_fetch_row($resp)) 
 					{
						$sqlr="select sum(valor) from tesoconsignaciones where id_consignacioncab=$row[0]";
						$resp2 = mysql_query($sqlr,$linkbd);
						$row2 =mysql_fetch_row($resp2);
						if ($row[4]=="S"){$imgsem="src='imagenes/sema_verdeON.jpg' title='Activo'";}
						else{$imgsem="src='imagenes/sema_rojoON.jpg' title='Inactivo'";}
						if($gidcta!=""){
							if($gidcta==$row[0]){
								$estilo='background-color:#FF9';
							}
							else{
								$estilo="";
							}
						}
						else{
							$estilo="";
						}	
						$idcta="'$row[0]'";
						$dc="'$row[1]'";
						$numfil="'$filas'";
						$filtro="'$_POST[numero]'";
						
						echo"<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
			onMouseOut=\"this.style.backgroundColor=anterior\" onDblClick=\"verUltimaPos($idcta, $dc, $numfil, $filtro)\" style='text-transform:uppercase; $estilo' >
							<td>$row[0]</td>
							<td>$row[2]</td>
							<td>$row[5]</td>
							<td>$row2[0]</td>
							<td style='text-align:center;'><img $imgsem style='width:18px'></td>";
							if ($row[4]=='S')
							echo "<td style='text-align:center;'><a href='#' onClick=eliminar($row[0])><img src='imagenes/anular.png'></a></td>";
							if ($row[4]=='N')
							echo "<td></td>";		 
							echo"<td style='text-align:center;'>
								<a onClick=\"verUltimaPos($idcta, $dc, $numfil, $filtro)\" style='cursor:pointer;'>
									<img src='imagenes/lupa02.png' style='width:20px' title='Ver'>
								</a>
							</td>
						</tr>";
					 	$con+=1;
						$filas++;
					 	$aux=$iter;
						$iter=$iter2;
					 	$iter2=$aux;	
 					}
 					if ($_POST[numtop]==0)
					{
						if($_POST[fechaini]>$_POST[fechafin]){$menerror="La fecha inicial no debe ser mayor a la fecha final";}
						else {$menerror="No hay coincidencias en la b&uacute;squeda";}
						echo "
						<table class='inicio'>
							<tr>
								<td class='saludo1' style='text-align:center;width:100%'><img src='imagenes\alert.png' style='width:25px'>$menerror<img src='imagenes\alert.png' style='width:25px'></td>
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