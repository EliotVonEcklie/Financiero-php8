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
		<link href="css/tabs.css" rel="stylesheet" type="text/css"/>
		<script type='text/javascript' src='JQuery/jquery-2.1.4.min.js'></script>
   		<script type="text/javascript" src="css/programas.js"></script>
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
				location.href="teso-recibocajabancover.php?idrecibo="+idcta+"&scrtop="+scrtop+"&totreg="+filas+"&altura="+altura+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
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
				document.form2.action= "archivos/<?php echo $_SESSION[usuario];?>-reporterecibos.csv";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function iratras()
			{
				window.location = 'teso-modificabancos.php';
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
					<a class="mgbt1"><img src="imagenes/add.png" title="Nuevo" /></a>
					<a class="mgbt1"><img src="imagenes/guardad.png" title="Guardar" /></a>
					<a onClick="document.form2.submit();" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a class="mgbt" onClick="<?php echo paginasnuevas("teso");?>"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a onClick="archivocsv();" class="mgbt"><img src="imagenes/csv.png" style="width:29px;height:25px;" title="csv"></a>
					<a href="#" onClick="iratras()" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
				</td>
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
 		<form name="form2" method="post" action="teso-buscarecibocajabanco.php">
		<?php  
			if ($_POST[oculto]==""){$_POST[tabgroup1]=1;}
			 switch($_POST[tabgroup1])
                {
                    case 1:	$check1='checked';break;
                    case 2:	$check2='checked';break;
                    case 3:	$check3='checked';break;
                }
		?>
    		<input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
			<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
			<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
			<table  class="inicio" align="center" >
    			<tr >
        			<td class="titulos" colspan="2">:. Buscar Recibos de Caja</td>
        			<td class="cerrar" style="width:7%;"><a onClick="location.href='teso-principal.php'">&nbsp;Cerrar</a></td>
      			</tr>
      			<tr>
         			<td style="width:3.5cm" class="saludo1"> N&uacute;mero Recibo: </td>
    				<td  >
            			<input type="search" name="nombre" id="nombre"  value="<?php echo $_POST[nombre];?>" style="width:40%" >
                        <input type="button" name="bboton" onClick="limbusquedas();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" />
           			</td>
     			</tr>                       
  			</table>    
            <input type="hidden" name="oculto" id="oculto"  value="1">
          	<input type="hidden" name="var1" value=<?php echo $_POST[var1];?>>
			<div class="tabsmeci"  style="height:68.5%; width:99.6%; overflow-x:hidden;" id="divdet">
			<div class="tab">
                    <input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
                    <label for="tab-1">Recibos General</label>
           	<div class="content" style="overflow-x:hidden;" id="divdet">
			<?php
					$oculto=$_POST['oculto'];
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
                        if($row[10]=='1')
                        {
                            $sqlr="update tesoliquidapredial set estado='N' where id_predial=$row[4]";
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
                        }
                        if($row[10]=='2')
                        {
                            $sqlr="update tesoindustria set estado='S' where id_industria=$row[4]";
                            mysql_query($sqlr,$linkbd);		 
                        }
                        if($row[10]=='3')
                        {
                            $sqlr="update tesorecaudos set estado='S' where id_recaudo=$row[4]";
                            mysql_query($sqlr,$linkbd);
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
                	$oculto=$_POST['oculto'];
                	$crit1="";
                	if ($_POST[nombre]!=""){
                		$crit1=" and TB1.id_recibos like '%$_POST[nombre]%' ";
                	}
					$sqlr="select * from tesoreciboscaja TB1 where TB1.estado<>'' $crit1 order by TB1.id_recibos DESC";
					$resp = mysql_query($sqlr,$linkbd);
					$ntr = mysql_num_rows($resp);
					$_POST[numtop]=$ntr;
					$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
					$cond2="";
					if ($_POST[numres]!="-1"){
						$cond2="LIMIT $_POST[numpos], $_POST[numres]";
					}

					$sqlr="select * from tesoreciboscaja TB1 where TB1.estado<>'' $crit1 order by TB1.id_recibos DESC $cond2";
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
							<td colspan='10'>Recibos de Caja Encontrados: $ntr</td>
						</tr>
						<tr style='text-align:center;'>
							<td class='titulos2' style='width:5%'>No Recibo</td>
							<td class='titulos2'>Concepto</td>
							<td class='titulos2' style='width:7%'>Fecha</td>
							<td class='titulos2'>Doc. Contribuyente</td>
							<td class='titulos2'>Contribuyente</td>
							<td class='titulos2' style='width:10%'>Valor</td>
							<td class='titulos2'>No Liquid.</td>
							<td class='titulos2' style='width:10%'>Tipo</td>
							<td class='titulos2'>Estado</td>
							<td class='titulos2' width='4%'><center>Ver</td>
						</tr>";	
					$iter='saludo1a';
					$iter2='saludo2';
					$filas=1;
					$tipos=array('Predial','Industria y Comercio','Otros Recaudos');
					$namearch="archivos/".$_SESSION[usuario]."-reporterecibos.csv";
					$Descriptor1 = fopen($namearch,"w+"); 
					fputs($Descriptor1,"RECIBO;CONCEPTO;FECHA;Doc Tercero;TERCERO;VALOR;NO LIQUIDACION;TIPO;ESTADO\r\n");
					while ($row =mysql_fetch_row($resp))
					{
						if($row[10]==1){$sqlrt="select tercero from tesoliquidapredial where tesoliquidapredial.idpredial=$row[4]";}
						if($row[10]==2){$sqlrt="select tercero from tesoindustria where $row[4]=tesoindustria.id_industria";}
						if($row[10]==3){$sqlrt="select tercero from tesorecaudos where tesorecaudos.id_recaudo=$row[4]";}
						$rest=mysql_query($sqlrt,$linkbd);
						$rowt=mysql_fetch_row($rest);	 	
						$ntercero=buscatercero($rowt[0]);
						fputs($Descriptor1,"$row[0];;$row[2];$rowt[0];$ntercero;$row[8];$row[4];".$tipos[$row[10]-1].";$row[9]\r\n");
						if($gidcta!="")
						{
							if($gidcta==$row[0]){$estilo='background-color:yellow';}
							else{$estilo="";}
						}
						else{$estilo="";}	
						$idcta="'$row[0]'";
						$numfil="'$filas'";
						$filtro="'$_POST[nombre]'";
						echo"
						<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
					onMouseOut=\"this.style.backgroundColor=anterior\" onDblClick=\"verUltimaPos($idcta, $numfil, $filtro)\" style='text-transform:uppercase; $estilo' >
							<td style='text-align:center;'	>$row[0]</td>
							<td>$row[11]</td>
							<td>$row[2]</td>
							<td>$rowt[0]</td>
							<td>$ntercero</td>
							<td style='text-align:right'>$ ".number_format($row[8],2)."</td>
							<td style='text-align:center'>$row[4]</td>
							<td>&nbsp;".$tipos[$row[10]-1]."</td>";
							if ($row[9]=='S'){echo "<td ><center><img src='imagenes/sema_verdeON.jpg' style='width:18px;'></center></td>";}
							if ($row[9]=='N'){echo "<td ><center><img src='imagenes/sema_rojoON.jpg' style='width:18px;'></center></td>";}
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
			</div>
				<div class="tab">
                    <input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?> >
                    <label for="tab-2">Recibos Modificados</label>
					<div class="content" style="overflow-x:hidden;" id="divdet">
					<?php
					$oculto=$_POST['oculto'];
                    if($_POST[oculto]==2)
                    {
						$sqlr="select * from tesoreciboscaja,tesoreciboscaja_banco where tesoreciboscaja.id_recibos=$_POST[var1] AND tesoreciboscaja.id_recibos=tesoreciboscaja_banco.id_recibos";
                        $resp = mysql_query($sqlr,$linkbd);
                        $row=mysql_fetch_row($resp);
                        //********Comprobante contable en 000000000000
                        if($row[10]=='1')
                        {

                            $sqlr="select *from tesoliquidapredial where id_predial=$row[4] ";
                            $respr = mysql_query($sqlr,$linkbd);
                            $rowr=mysql_fetch_row($respr);
               
                        }
                        if($row[10]=='2')
                        {
                            $sqlr="update tesoindustria set estado='S' where id_industria=$row[4]";
                            mysql_query($sqlr,$linkbd);		 
                        }
                        if($row[10]=='3')
                        {
                            $sqlr="update tesorecaudos set estado='S' where id_recaudo=$row[4]";
                            mysql_query($sqlr,$linkbd);
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
                	$oculto=$_POST['oculto'];
                	$crit1="";
                	if ($_POST[nombre]!=""){
                		$crit1=" and TB1.id_recibos like '%$_POST[nombre]%' ";
                	}
					$sqlr="select * from tesoreciboscaja TB1,tesoreciboscaja_banco TB2 where TB1.estado<>'' AND TB1.id_recibos=TB2.id_recibos $crit1 order by TB1.id_recibos DESC";
					$resp = mysql_query($sqlr,$linkbd);
					$ntr = mysql_num_rows($resp);
					$_POST[numtop]=$ntr;
					$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
					$cond2="";
					if ($_POST[numres]!="-1"){
						$cond2="LIMIT $_POST[numpos], $_POST[numres]";
					}

					$sqlr="select * from tesoreciboscaja TB1,tesoreciboscaja_banco TB2 where TB1.estado<>'' AND TB1.id_recibos=TB2.id_recibos $crit1 order by TB1.id_recibos DESC $cond2";
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
							<td colspan='10'>Recibos de Caja Encontrados: $ntr</td>
						</tr>
						<tr style='text-align:center;'>
							<td class='titulos2' style='width:5%'>No Recibo</td>
							<td class='titulos2'>Concepto</td>
							<td class='titulos2' style='width:7%'>Fecha</td>
							<td class='titulos2'>Banco Ant. </td>
							<td class='titulos2'>Banco Act. </td>
							<td class='titulos2' style='width:10%'>Valor</td>
							<td class='titulos2'>No Liquid.</td>
							<td class='titulos2' style='width:10%'>Tipo</td>
							<td class='titulos2'>Estado</td>
							<td class='titulos2' width='4%'><center>Ver</td>
						</tr>";	
					$iter='saludo1a';
					$iter2='saludo2';
					$filas=1;
					$tipos=array('Predial','Industria y Comercio','Otros Recaudos');
					$namearch="archivos/".$_SESSION[usuario]."-reporterecibos.csv";
					$Descriptor1 = fopen($namearch,"w+"); 
					fputs($Descriptor1,"RECIBO;CONCEPTO;FECHA;Doc Tercero;TERCERO;VALOR;NO LIQUIDACION;TIPO;ESTADO\r\n");
					while ($row =mysql_fetch_row($resp))
					{
						if($row[10]==1){$sqlrt="select tercero from tesoliquidapredial where tesoliquidapredial.idpredial=$row[4]";}
						if($row[10]==2){$sqlrt="select tercero from tesoindustria where $row[4]=tesoindustria.id_industria";}
						if($row[10]==3){$sqlrt="select tercero from tesorecaudos where tesorecaudos.id_recaudo=$row[4]";}
						$rest=mysql_query($sqlrt,$linkbd);
						$rowt=mysql_fetch_row($rest);	 	
						$ntercero=buscatercero($rowt[0]);
						fputs($Descriptor1,"$row[0];;$row[2];$rowt[0];$ntercero;$row[8];$row[4];".$tipos[$row[10]-1].";$row[9]\r\n");
						if($gidcta!="")
						{
							if($gidcta==$row[0]){$estilo='background-color:yellow';}
							else{$estilo="";}
						}
						else{$estilo="";}	
						$idcta="'$row[0]'";
						$numfil="'$filas'";
						$filtro="'$_POST[nombre]'";
						echo"
						<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
					onMouseOut=\"this.style.backgroundColor=anterior\" onDblClick=\"verUltimaPos($idcta, $numfil, $filtro)\" style='text-transform:uppercase; $estilo' >
							<td style='text-align:center;'	>$row[0]</td>
							<td>$row[11]</td>
							<td>$row[2]</td>
							<td>$row[16]</td>
							<td>$row[17]</td>
							<td style='text-align:right'>$ ".number_format($row[8],2)."</td>
							<td style='text-align:center'>$row[4]</td>
							<td>&nbsp;".$tipos[$row[10]-1]."</td>";
							if ($row[9]=='S'){echo "<td ><center><img src='imagenes/sema_verdeON.jpg' style='width:18px;'></center></td>";}
							if ($row[9]=='N'){echo "<td ><center><img src='imagenes/sema_rojoON.jpg' style='width:18px;'></center></td>";}
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
				</div>
			</div>
		</form> 
	</body>
</html>