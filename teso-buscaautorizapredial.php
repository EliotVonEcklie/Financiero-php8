<?php //V 1000 12/12/16 ?> 
<!--V 1.0 24/02/2015-->
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
		<script type="text/javascript" src="css/calendario.js"></script>
        <script>
			function consul()
			{
				document.getElementById('consul1').value="";
				document.getElementById('consul2').value="";
				switch (document.getElementById('tbusqueda').value) 
				{
					case "":
						document.getElementById('escon1').value="none";
						document.getElementById('escon2').value="none";
						break;
					case "2":
						
						document.getElementById('escon1').value="none";
						document.getElementById('escon2').value="inline";
						break;
					case "1":
					case "3":
						
						document.getElementById('escon1').value="inline";
						document.getElementById('escon2').value="none";
				}
				document.form2.submit();
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
          		<td colspan="3" class="cinta"><a href="teso-autorizapredial.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a class="mgbt"><img src="imagenes/guardad.png"/></a><a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a><a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>				
           </tr>	
		</table>
 		<form name="form2" method="post" action="teso-buscaautorizapredial.php">
        	<?php if($_POST[oculto]==""){$_POST[escon1]="none";$_POST[escon2]="none";}?>
			<table  class="inicio">
      			<tr>
        			<td class="titulos" colspan="6" style='width:93%'>:. Buscar Autorizaciones Liquidaci&oacute;n Predial</td>
        			<td width="139" class="cerrar" style='width:7%'><a href="teso-principal.php">Cerrar</a></td>
      			</tr>
      			<tr>
                	<td class="saludo1" style='width:8%'>Buscar Por:</td>
                	<td >
                        <select name="tbusqueda" id="tbusqueda" onChange="consul();">
                            <option value="" <?php if($_POST[tbusqueda]==""){echo "SELECTED";}?>>Seleccione ...</option>
                            <option value="1" <?php if($_POST[tbusqueda]=="1"){echo "SELECTED";}?>>N&deg; Autorizaci&oacute;</option>
                            <option value="2" <?php if($_POST[tbusqueda]=="2"){echo "SELECTED";}?>>Fecha</option>
                            <option value="3" <?php if($_POST[tbusqueda]=="3"){echo "SELECTED";}?>>Autoriza</option>
                        </select>
                        <input type="text" name="consul1" id="consul1" style="display:<?php echo $_POST[escon1];?>; width:30%"> 
                        <input type="date" name="consul2" id="consul2" style="display:<?php echo $_POST[escon2];?>">
                        <input type="hidden" name="escon1" id="escon1" value="<?php echo $_POST[escon1];?>"> 
                        <input type="hidden" name="escon2" id="escon2" value="<?php echo $_POST[escon2];?>">                     
                        <input name="oculto" type="hidden" value="1">
                	</td>
        		</tr>                       
    		</table>    
     		<div class="subpantallap" style="height:68.5%; width:99.6%;">
      		<?php
				//if($_POST[oculto])
				{
					switch ($_POST[tbusqueda]) 
					{
						case "":
							$sqlr="SELECT * FROM tesoautorizapredial ORDER BY id_auto DESC";
							break;
						case "1":
							$sqlr="SELECT * FROM tesoautorizapredial WHERE id_auto LIKE '%$_POST[consul1]%' ORDER BY id_auto DESC";
							break;
						case "2":
							$sqlr="SELECT * FROM tesoautorizapredial WHERE fecha_auto='$_POST[consul2]' ORDER BY id_auto DESC";
							break;
						case "3":
							$sqlr="SELECT * FROM tesoautorizapredial WHERE autoriza LIKE '%$_POST[consul1]%' ORDER BY id_auto DESC";
					}
					$resp = mysql_query($sqlr,$linkbd);
					$ntr = mysql_num_rows($resp);
					$con=1;
					echo "
					<table class='inicio'>
						<tr><td colspan='12' class='titulos'>.: Resultados Busqueda:</td></tr>
						<tr><td colspan='12'>Autorizaciones Encontradas: $ntr</td></tr>
						<tr>
							<td class='titulos2' style='width:3%'>Item</td>
							<td class='titulos2' style='width:3%'>N&deg;</td>
							<td class='titulos2' style='width:7%'>Fecha</td>
							<td class='titulos2' style='width:7%'>Fecha Proyecci&oacute;n</td>
							<td class='titulos2' style='width:15%'>C&oacute;digo Catastral</td>
							<td class='titulos2' >Descripci&oacute;n</td>
							<td class='titulos2' style='width:15%'>Autorizado por</td>
							<td class='titulos2' style='width:6%'>Valor</td>
							<td class='titulos2' style='width:6%'>A&ntilde;os</td>
							<td class='titulos2' style='width:3%'>Estado</td>
							<td class='titulos2' style='width:3%'>Anular</td>
							<td class='titulos2' style='width:3%'>Ver</td>
						</tr>";	
					$iter='zebra1';
					$iter2='zebra2';
					while ($row =mysql_fetch_row($resp)) 
 					{
						$anos="";
						$sqlra="SELECT vigencia FROM tesoautorizapredial_det WHERE id_auto='$row[0]' ORDER BY vigencia DESC";
						$respa = mysql_query($sqlra,$linkbd);
						while ($rowa =mysql_fetch_row($respa)){$anos=$anos.$rowa[0].", ";}
						switch ($row[10]) 
						{
							case "P":
								$imgsem="src='imagenes/sema_verdeON.jpg' title='Pagada'";
								$imganu="<a href='#'><img src='imagenes/anulard.png' title='No se puede Anular' style='width:20px'/></a>";
								break;
							case "S":
								$imgsem="src='imagenes/sema_amarilloON.jpg' title='Activa'";
								$imganu="<a href='#'><img src='imagenes/anular.png' title='Anular' style='width:20px'/></a>";
								break;
							case "N":
								$imgsem="src='imagenes/sema_rojoON.jpg' title='Anulada'";
								$imganu="<a href='#'><img src='imagenes/anulard.png' title='Ya est&aacute; Anulada' style='width:20px'/></a>";
						}
	 					echo "
						<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase'>
					 		<td>$con</td>
					 		<td>$row[0]</td>
					 		<td>".date('d-m-Y',strtotime($row[2]))."</td>
							<td>".date('d-m-Y',strtotime($row[3]))."</td>
							<td>$row[1]</td>
							<td>$row[5]</td>
							<td>$row[6]</td>
							<td style='text-align:right;'>$".number_format($row[4],2)."</td>
							<td>$anos</td>
							<td style='text-align:center;width:4%'><img $imgsem style='width:18px'/></td>
							<td style='text-align:center;width:4%'>$imganu</td>
							<td style='text-align:center;width:4%'><a href='teso-autorizapredialmirar.php?idauto=$row[0]'><img src='imagenes/buscarep.png'></a></td>
							
						</tr>";
						$con+=1;
						$aux=$iter;
						$iter=$iter2;
					 	$iter2=$aux;
 					}
 					echo"</table>";
				}
			?>
            </div>
		</form>
	</body>
</html>