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
		<title>:: Spid - Presupuesto</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
        <script type="text/javascript" src="css/cssrefresh.js"></script>
		<script>
			function validar(){document.form2.submit();}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("presu");?></tr>
			<tr>
  				<td colspan="3" class="cinta">
					<a class="mgbt"><img src="imagenes/add2.png"/></a>
					<a class="mgbt"><img src="imagenes/guardad.png" /></a>
					<a onClick="document.form2.submit();" href="#"  class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a href="<?php echo "archivos/".$_SESSION[usuario]."-reporterecibos.csv"; ?>" target="_blank" class="mgbt"><img src="imagenes/csv.png" title="csv" style="width:26px;"></a>
					<a href="presu-reflejardocs.php" class="mgbt"><img src="imagenes/iratras.png" title="Retornar"/></a>
				</td>
        	</tr>	
  		</table>
 		<form name="form2" method="post" action="presu-buscarecibocaja-reflejar.php">
        	<?php if ($_POST[oculto]==""){$_POST[numres]=10;$_POST[numpos]=0;$_POST[nummul]=0;}?>
			<table  class="inicio" align="center" >
      			<tr>
       				<td class="titulos" colspan="6">:. Buscar Recibos de Caja</td>
        			<td class="cerrar" style="width:7%;"><a href="cont-principal.php">&nbsp;Cerrar</a></td>
      			</tr>
      			<tr>
        			<td  class="saludo1" style="width:3.5cm;">Numero Liquidaci&oacute;n:</td>
        			<td>
                 		<input type="search" name="nombre" id="nombre" value="<?php echo $_POST[nombre];?>" style="width:20%;"/>
              			<input type="button" name="bboton" onClick="limbusquedas();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" />
                    </td>
        		</tr>                       
    		</table>    
            <input type="hidden" name="oculto" id="oculto" value="1"/>
            <input type="hidden" name="var1"  value=<?php echo $_POST[var1];?>>
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
       		<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
         	<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
    		<div class="subpantallap" style="height:68.5%; width:99.6%; overflow-x:hidden;">
   				<?php
					if($_POST[oculto]==2)
					{
	 					$sqlr="select * from tesoreciboscaja where id_recibos=$_POST[var1]";
	 					$resp = mysql_query($sqlr,$linkbd);
	 					$row=mysql_fetch_row($resp);
	 					//********Comprobante contable en 000000000000
	 					$sqlr="update comprobante_cab set total_debito=0,total_credito=0,estado='0' where tipo_comp='5' and numerotipo=$row[0]";
	  					mysql_query($sqlr,$linkbd);
	  					$sqlr="update comprobante_det set valdebito=0,valcredito=0 where id_comp='5 $row[0]'";
	  					mysql_query($sqlr,$linkbd);
	  					$sqlr="update pptocomprobante_cab set estado='0' where tipo_comp='16' and numerotipo=$row[0]";
	  					mysql_query($sqlr,$linkbd);
	 					//********PREDIAL O RECAUDO SE ACTIVA COLOCAR 'S'
						switch($row[10])
						{
							case '1':	$sqlr="update tesoliquidapredial set estado='N' where id_predial=$row[4]";
										mysql_query($sqlr,$linkbd);
										$sqlr="select *from tesoliquidapredial where id_predial=$row[4] ";
										$respr = mysql_query($sqlr,$linkbd);
										$rowr=mysql_fetch_row($respr);
										$sqlr="select *from tesoliquidapredial_det where id_predial=$row[4] ";	   
										$resprd = mysql_query($sqlr,$linkbd);
										while($rowrd=mysql_fetch_row($resprd))
										{
											$sqlr="update tesoprediosavaluos set estado='S' where codigocatastral='$rowr[1]' and ord='$rowr[19]' and tot='$rowr[20]' and vigencia=$rowrd[1] ";
											mysql_query($sqlr,$linkbd);
										}
										break;
							case '2':	$sqlr="update tesoindustria set estado='S' where id_industria=$row[4]";
	  									mysql_query($sqlr,$linkbd);break;
							case '3': 	$sqlr="update tesorecaudos set estado='S' where id_recaudo=$row[4]";
	  									mysql_query($sqlr,$linkbd);break;
						}
	 					//******** RECIBO DE CAJA ANULAR 'N'	 
	  					$sqlr="update tesoreciboscaja set estado='N' where id_recibos=$row[0]";
	  					mysql_query($sqlr,$linkbd);
	  					$sqlr="select * from pptorecibocajappto where idrecibo=$row[0]";
  	 					$resp=mysql_query($sqlr,$linkbd);
	  					while($r=mysql_fetch_row($resp))
	   					{
							$sqlr="update pptocuentaspptoinicial set ingresos=ingresos-$r[3] where cuenta='$r[1]'";
							mysql_query($sqlr,$linkbd);
	  					 }	
	   					$sqlr="delete from pptorecibocajappto where idrecibo=$row[0]";
  	  					$resp=mysql_query($sqlr,$linkbd); 
					}
					//if($_POST[oculto])
					{
						$crit1="";
						if ($_POST[nombre]!=""){$crit1=" AND tc.id_recibos LIKE '%$_POST[nombre]%'";}
						//$crit1="CASE tipo  WHEN '1' THEN select tesoliquidapredial.tercero from tesoliquidapredial,tesoreciboscaja where idpredial=tesoreciboscaja.id_recaudo";
						$sqlr="SELECT * FROM tesoreciboscaja tc WHERE tc.estado<>'' $crit1";
						$resp = mysql_query($sqlr,$linkbd);
						$_POST[numtop]=mysql_num_rows($resp);
						$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
						$cond2;
						if($_POST[numres]!="-1")
							$cond2="LIMIT $_POST[numpos],$_POST[numres]";
						$sqlr="SELECT * FROM tesoreciboscaja tc WHERE tc.estado<>'' $crit1 ORDER BY tc.id_recibos DESC ".$cond2;
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
						<tr><td colspan='10'>Recibos de Caja Encontrados: $_POST[numtop]</td></tr>
						<tr>
							<td width='150' class='titulos2'>No Recibo</td>
							<td class='titulos2'>Concepto</td>
							<td class='titulos2'>Fecha</td>
							<td class='titulos2'>Doc. Contribuyente</td>
							<td class='titulos2'>Contribuyente</td>
							<td class='titulos2'>Valor</td>
							<td class='titulos2'>No Liquid.</td>
							<td class='titulos2'>Tipo</td>
							<td class='titulos2'>Estado</td>
							<td class='titulos2' width='5%'><center>Ver</td>
						</tr>";	
						$iter='zebra1';
						$iter2='zebra2';
						$tipos=array('Predial','Industria y Comercio','Otros Recaudos');
						$namearch="archivos/".$_SESSION[usuario]."-reporterecibos.csv";
						$Descriptor1 = fopen($namearch,"w+"); 
						fputs($Descriptor1,"RECIBO;CONCEPTO;FECHA;Doc Tercero;TERCERO;VALOR;NO LIQUIDACION;TIPO;ESTADO\r\n");
						while ($row =mysql_fetch_row($resp)) 
 						{
							switch($row[10])
							{
								case 1:	$sqlrt="select tercero from tesoliquidapredial where idpredial='$row[4]'";
										break;
								case 2:	$sqlrt="select tercero from tesoindustria where id_industria='$row[4]'";
										break;
								case 3:	$sqlrt="select tercero from tesorecaudos where tesorecaudos.id_recaudo='$row[4]'";
										break;
							}
	 						$rest=mysql_query($sqlrt,$linkbd);
	 						$rowt =mysql_fetch_row($rest);	 	
	 						$ntercero=buscatercero($rowt[0]);
	 						fputs($Descriptor1,"$row[0];;$row[2];$rowt[0];$ntercero;$row[8];$row[4];".$tipos[$row[10]-1].";$row[9]\r\n");
	 						echo "
							<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor; this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase;cursor:pointer' onDblClick=\"window.open('presu-recibocaja-reflejar.php?idrecibo=$row[0]','_self');\">
								<td>$row[0]</td>
								<td>$row[17]</td>
								<td>$row[2]</td>
								<td>$rowt[0]</td>
								<td>$ntercero</td>
								<td>".number_format($row[8],2)."</td>
								<td>$row[4]</td>
								<td>".$tipos[$row[10]-1]."</td>";
	  						if ($row[9]=='S')
	 	 					echo "<td style='text-align:center;'><img src='imagenes/confirm.png'></td>";
	  						if ($row[9]=='N')
	  						echo "<td style='text-align:center;'><img src='imagenes/del3.png'></td>";
	 						echo "<td style='text-align:center;'><a href='presu-recibocaja-reflejar.php?idrecibo=$row[0]'><img src='imagenes/lupa02.png'/></a></td>
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
					}
				?>
			</div>
            <input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>" />
		</form> 
	</body>
</html>