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
		<title>:: SPID - Tesoreria</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
        <script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
		<script>
			function verUltimaPos(idcta, filas, filtro)
			{
				var scrtop=$('#divdet').scrollTop();
				var altura=$('#divdet').height();
				var numpag=$('#nummul').val();
				var limreg=$('#numres').val();
				if((numpag<=0)||(numpag=="")){numpag=0;}
				if((limreg==0)||(limreg=="")){limreg=10;}
				numpag++;
				location.href="teso-pagonominaver.php?idegre="+idcta+"&scrtop="+scrtop+"&totreg="+filas+"&altura="+altura+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
			}
			function eliminar(idr)
			{
				if (confirm("Esta Seguro de Anular El Egreso No "+idr))
				{
					document.form2.oculto.value=2;
					document.form2.var1.value=idr;
					document.form2.submit();
				}
			}
			function pdf()
			{
				document.form2.action="teso-pdfconsignaciones.php";
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
			echo"<script> window.onload=function(){ $('#divdet').scrollTop(".$scrtop.") }</script>";
			$gidcta=$_GET['idcta'];
			if(isset($_GET['filtro']))
			$_POST[nombre]=$_GET['filtro'];
		?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("teso");?></tr>
			<tr>
				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='teso-pagonomina.php'" class="mgbt"/><img src="imagenes/guardad.png" class="mgbt1"/><img src="imagenes/busca.png" title="Buscar" onClick="document.form2.submit();" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana"  onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"></td>
  			</tr>	
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
 		<form name="form2" method="post" action="teso-buscapagonomina.php">
     		<input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
       		<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
         	<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
			<table  class="inicio" align="center" >
                <tr >
                    <td class="titulos" colspan="3" >:. Buscar Pagos Nomina</td>
                    <td class="cerrar" style="width:7%" onClick="location.href='teso-principal.php'">Cerrar</td>
                </tr>
                <tr>
                    <td class="saludo1" style="width:4cm;">N&uacute;mero o Detalle Pago:</td>
                    <td style="width:15%;"><input type="search" name="nombre" id="nombre"  value="<?php echo $_POST[nombre];?>" style="width:98%;"/></td>
                    <td><input type="button" name="bboton" onClick="limbusquedas();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" /></td>
                    <input type="hidden" name="oculto" id="oculto"  value="1">
                    <input type="hidden" name="var1"  value=<?php echo $_POST[var1];?>>
                </tr>                       
            </table>   
     		<div class="subpantallap" style="height:68.5%; width:99.6%; overflow-x:hidden;" id="divdet">
      		<?php
				$oculto=$_POST['oculto'];
				if($_POST[oculto]==2)
				{
					$sqlr="select * from tesoegresos where id_egreso=$_POST[var1]";
					$resp = mysql_query($sqlr,$linkbd);
					$row=mysql_fetch_row($resp);
					$op=$row[2];
					$vpa=$row[7];
					//********Comprobante contable en 000000000000
					$sqlr="update comprobante_cab set total_debito=0,total_credito=0,estado='0' where tipo_comp='17' and numerotipo='$row[0]'";
					mysql_query($sqlr,$linkbd);
					$sqlr="update comprobante_det set valdebito=0,valcredito=0 where id_comp='17 $row[0]'";
					mysql_query($sqlr,$linkbd);
					$sqlr="update pptocomprobante_cab set estado='0' where tipo_comp='10' and numerotipo='$row[0]'";
					mysql_query($sqlr,$linkbd);
					$sqlr="update tesoordenpago  set estado='S' where id_orden='$op'";
					mysql_query($sqlr,$linkbd);	 
					$sqlr="update tesoegresosnomina set estado='N' where id_egreso='$_POST[var1]'";
					mysql_query($sqlr,$linkbd);	 
					$sqlr="update tesoegresos set estado='N' where id_egreso='$_POST[var1]'";
					mysql_query($sqlr,$linkbd);	 
					$sqlr="select * from tesoegresosnomina_det where id_egreso='$_POST[var1]'";
					$res=mysql_query($sqlr,$linkbd);	 
					while($row=mysql_fetch_row($res))
					{
						if($row[3]=='N')
						{
							$sqlru="update humnomina_det set estado='S' where id_nom=$_POST[var1] and cedulanit=$row[4]";
							mysql_query($sqlru,$linkbd);
						}
						else if($row[3]=='SE' || $row[3]=='PR' || $row[3]=='PE' || $row[3]=='SR')
						{
							$sqlru="update humnomina_saludpension set estado='S' where id_nom=$_POST[var1] and tercero=$row[4]";
							mysql_query($sqlru,$linkbd);
						}
						else if($row[3]=='F')
						{
							$sqlru="update humnomina_parafiscales set estado='S' where id_nom=$_POST[var1] and valor=$row[8]";
							mysql_query($sqlru,$linkbd);
						}
					}
				}   
				$crit1="";
				if ($_POST[nombre]!="")
				$crit1="and concat_ws(' ', tesoegresosnomina.id_egreso, tesoegresosnomina.concepto) LIKE '%$_POST[nombre]%'";
				$sqlr="select *from tesoegresosnomina where tesoegresosnomina.id_egreso>-1 $crit1 order by tesoegresosnomina.id_egreso DESC";
				$resp = mysql_query($sqlr,$linkbd);
				$ntr = mysql_num_rows($resp);
				$_POST[numtop]=$ntr;
				$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
				$cond2="";
				if ($_POST[numres]!="-1"){ $cond2="LIMIT $_POST[numpos], $_POST[numres]";}
				$sqlr="select *from tesoegresosnomina where tesoegresosnomina.id_egreso>-1 $crit1 order by tesoegresosnomina.id_egreso DESC $cond2";
				$resp = mysql_query($sqlr,$linkbd);
				$con=1;
				$numcontrol=$_POST[nummul]+1;
				if(($nuncilumnas==$numcontrol)||($_POST[numres]=="-1"))
				{
					$imagenforward="<img src='imagenes/forward02.png' class='icomen2n'/>";
					$imagensforward="<img src='imagenes/skip_forward02.png' class='icomen1n'/>";
				}
				else
				{
					$imagenforward="<img src='imagenes/forward01.png' class='icomen2' title='Siguiente' onClick='numsiguiente()'>";
					$imagensforward="<img src='imagenes/skip_forward01.png' class='icomen1' title='Fin' onClick='saltocol(\"$nuncilumnas\")'/>";
				}
				if(($_POST[numpos]==0)||($_POST[numres]=="-1"))
				{
					$imagenback="<img src='imagenes/back02.png' class='icomen2n'>";
					$imagensback="<img src='imagenes/skip_back02.png' class='icomen1n'/>";
				}
				else
				{
					$imagenback="<img src='imagenes/back01.png' class='icomen2' title='Anterior' onClick='numanterior();'>";
					$imagensback="<img src='imagenes/skip_back01.png' class='icomen1' title='Inicio' onClick='saltocol(\"1\")'/>";
				}
				$con=1;
				echo "
				<table class='inicio' align='center' >
					<tr>
						<td colspan='10' class='titulos'>.: Resultados Busqueda:</td>
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
						<td colspan='11'>Pagos Encontrados: $ntr</td>
					</tr>
					<tr>
						<td  class='titulos2'>Egreso</td>
						<td  class='titulos2'>Nomina</td>
						<td class='titulos2'>Nombre</td>
						<td class='titulos2'>Fecha</td>
						<td class='titulos2'>Banco</td>
						<td class='titulos2'>Cuenta</td>
						<td class='titulos2'>Valor</td>
						<td class='titulos2'>Concepto</td>
						<td class='titulos2' width='5%'><center>Estado</td>
						<td class='titulos2' width='5%'><center>Anular</td>
						<td class='titulos2' width='5%'><center>Ver</td>
					</tr>";	
				$iter='zebra1';
				$iter2='zebra2';
				$filas=1;
				while ($row =mysql_fetch_row($resp)) 
 				{
	 				$ntr=buscatercero($row[11]);
	 				$banco=buscatercero(buscabanco($row[9]));
					if($gidcta!="")
					{
						if($gidcta==$row[0]){$estilo='background-color:#FF9';}
						else{$estilo="";}
					}
					else{$estilo="";}	
					$idcta="'$row[0]'";
					$numfil="'$filas'";
					$filtro="'$_POST[nombre]'";
					if($row[13]=='S')
					{
						$imgsem="src='imagenes/sema_verdeON.jpg' title='Activo'";$coloracti="#0F0";$_POST[lswitch1][$row[0]]=0;
						$iconanu="<img src='imagenes/anular.png' onClick=\"eliminar($row[0])\" class='icoop' title='Anular'/>";
					}
					else {$imgsem="src='imagenes/sema_rojoON.jpg' title='Inactivo'";$coloracti="#C00";$_POST[lswitch1][$row[0]]=1;}
					echo"
					<tr class='$iter' onDblClick=\"verUltimaPos($idcta, $numfil, $filtro)\" style='text-transform:uppercase; $estilo' >
						<td>$row[0]</td>
						<td>$row[2]</td>
						<td>$row[11] - $ntr</td>
						<td>$row[3]</td>
						<td>$banco</td>
						<td>$row[12]</td>
						<td>".number_format($row[7],2)."</td>
						<td>".strtoupper($row[8])."</td>
						<td style='text-align:center;'><img $imgsem style='width:20px'/></td>
						<td style='text-align:center;'>$iconanu</td>
						<td style='text-align:center;'><img src='imagenes/lupa02.png' class='icoop' title='Ver' onClick=\"verUltimaPos($idcta, $numfil, $filtro)\"/></td>
					</tr>";
	 				$con+=1;
	 				$filas++;
	 				$aux=$iter;
	 				$iter=$iter2;
	 				$iter2=$aux;	
 				}
    			echo"
				</table>
				<table class='inicio'>
					<tr style='height:20px'>
						<td style='text-align:center;'>
							$imagensback&nbsp;$imagenback&nbsp;&nbsp;";
				if($nuncilumnas<=9){$numfin=$nuncilumnas;}
				else{$numfin=9;}
				for($xx = 1; $xx <= $numfin; $xx++)
				{
					if($numcontrol<=9){$numx=$xx;}
					else{$numx=$xx+($numcontrol-9);}
					if($numcontrol==$numx){echo"<label onClick='saltocol(\"$numx\")'; style='color:#24D915' class='icomen3'> $numx </label>";}
					else {echo"<label onClick='saltocol(\"$numx\")'; style='color:#000000' class='icomen3'> $numx </label>";}
				}
					echo "		&nbsp;&nbsp;$imagenforward&nbsp;$imagensforward
							</td>
						</tr>
					</table>";

			?>
            </div>
		</form> 
	</body>
</html>