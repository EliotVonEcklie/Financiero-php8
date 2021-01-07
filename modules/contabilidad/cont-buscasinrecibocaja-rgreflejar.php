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
		<title>:: Spid - Contabilidad</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
		<script>
			function validar(){document.form2.submit();}
			function guardar()
			{
				if (document.form2.fecha.value!='')
			  	{
					if (confirm("Esta Seguro de Guardar"))
					{
						document.form2.oculto.value=2;
						document.form2.submit();
					}
			 	}
			  	else
				{
			  		alert('Faltan datos para completar el registro');
					document.form2.fecha.focus();
					document.form2.fecha.select();
			  	}
			}		
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("cont");?></tr>
			<tr>
  				<td colspan="3" class="cinta">
					<a class="mgbt"><img src="imagenes/add2.png"/></a>
					<a class="mgbt"><img src="imagenes/guardad.png"/></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a>
					<a href="#" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a href="cont-reflejardocs.php" class="mgbt"><img src="imagenes/iratras.png" title="Retornar"></a>
				</td>
        	</tr>	
  		</table>
 		<form name="form2" method="post" action="cont-buscasinrecibocaja.rgreflegar.php">
        	<?php if ($_POST[oculto]==""){$_POST[numres]=10;$_POST[numpos]=0;$_POST[nummul]=0;}?>
			<table class="inicio">
                <tr>
                    <td class="titulos" colspan="6">:. Buscar Ingresos Propios</td>
                    <td class="cerrar" style="width:7%;"><a href="cont-principal.php">&nbsp;Cerrar</a></td>
                </tr>
                
                <tr>
                	<td  class="saludo1" style="width:3.5cm;">Numero Recibo:</td>
                    <td>
                 		<input type="search" name="nombre" id="nombre" value="<?php echo $_POST[nombre];?>" style="width:20%;"/>
              			<input type="button" name="bboton" onClick="limbusquedas();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" />
                    </td>
                </tr>                       
    		</table>
            <input type="hidden" name="oculto" id="oculto" value="1"/>
           	<input type="hidden" name="var1" value=<?php echo $_POST[var1];?>/>   
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
       		<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
         	<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
    		<div class="subpantallap" style="height:68.5%; width:99.6%; overflow-x:hidden;">
				<?php
                    if($_POST[oculto]==2)
                    {
                        $sqlr="select * from tesosinreciboscaja where id_recibos=$_POST[var1]";
                        $resp = mysql_query($sqlr,$linkbd);
                        $row=mysql_fetch_row($resp);
                        //********Comprobante contable en 000000000000
                        $sqlr="update comprobante_cab set total_debito=0,total_credito=0,estado='0' where tipo_comp='25' and numerotipo=$row[0]";
                        mysql_query($sqlr,$linkbd);
                        $sqlr="update comprobante_det set valdebito=0,valcredito=0 where id_comp='25 $row[0]'";
                        mysql_query($sqlr,$linkbd);
                        //********PREDIAL O RECAUDO SE ACTIVA COLOCAR 'S'
                        if($row[10]=='3')
                        {
                            $sqlr="update tesosinrecaudos set estado='S' where id_recaudo=$row[4]";
                            mysql_query($sqlr,$linkbd);
                        } 
                        //******** RECIBO DE CAJA ANULAR 'N'	 
                        $sqlr="update tesosinreciboscaja set estado='N' where id_recibos=$row[0]";
                        mysql_query($sqlr,$linkbd);
                        $sqlr="select * from pptosinrecibocajappto where idrecibo=$row[0]";
                        $resp=mysql_query($sqlr,$linkbd);
                        while($r=mysql_fetch_row($resp))
                        {
                            $sqlr="update pptocuentaspptoinicial set ingresos=ingresos-$r[3] where cuenta='$r[1]'";
                            mysql_query($sqlr,$linkbd);
                        }				
                        $sqlr="delete from pptosinrecibocajappto where idrecibo=$row[0]";
                        $resp=mysql_query($sqlr,$linkbd); 
                    }
                    $crit1=" ";
                    $crit2=" ";
                    if ($_POST[nombre]!=""){$crit1=" and tid_recibos like '%$_POST[nombre]%' ";}
                    $sqlr="select * from tesosinreciboscaja where estado<>'' $crit1";
                    $resp = mysql_query($sqlr,$linkbd);
					$_POST[numtop]=mysql_num_rows($resp);
					$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
					$sqlr="select * from tesosinreciboscaja where estado<>'' $crit1 order by id_recibos DESC LIMIT $_POST[numpos],$_POST[numres]";
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
							<td colspan='8' class='titulos'>.: Resultados Busqueda:</td>
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
                        <tr><td colspan='9'>Recibos de Caja Encontrados: $_POST[numtop]</td></tr>
                        <tr>
                            <td width='150' class='titulos2'>No Recibo</td>
                            <td class='titulos2'>Concepto</td>
                            <td class='titulos2'>Fecha</td>
                            <td class='titulos2'>Contribuyente</td>
                            <td class='titulos2'>Valor</td>
                            <td class='titulos2'>No Liquid.</td>
                            <td class='titulos2'>Tipo</td>
                            <td class='titulos2'>ESTADO</td>
                            <td class='titulos2' width='5%'><center>Editar</td>
                        </tr>";	
                    $iter='saludo1a';
                    $iter2='saludo2';
                    $tipos=array('Predial','Industria y Comercio','Otros Recaudos');
                    while ($row =mysql_fetch_row($resp)) 
                    {
                        $ntercero=buscatercero($row[15]);
						if($row[9]=='S')
						{
							$estadosemaforo="<img src='imagenes/sema_verdeON.jpg' style='width:19px; '  title='Activo'>";
						}else {
							$estadosemaforo="<img src='imagenes/sema_rojoON.jpg' style='width:19px; ' title='Inactivo'>";
						}
                        echo "
                        <tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor; this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase;cursor:pointer' onDblClick=\"window.open('cont-sinrecibocaja-refleja.php?idrecibo=$row[0]','_self');\">
                            <td>$row[0]</td>
                            <td>$row[17]</td>
                            <td>$row[2]</td>
                            <td>$row[15] $ntercero</td>
                            <td>".number_format($row[8],2)."</td>
                            <td >$row[4]</td><td >".$tipos[$row[10]-1]."</td>
                            <td style='text-align:center;'>$estadosemaforo</td>
                            <td style='text-align:center;'><a href='cont-sinrecibocaja-refleja.php?idrecibo=$row[0]'><img src='imagenes/b_edit.png' style='width:18px' title='Editar'></a></td>
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