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
			function anular(acuerdo){
				document.getElementById('anula').value='1';
				document.getElementById('anulacompro').value=acuerdo;
				document.form2.submit();
			}
			function direcciona(acuerdo){
				window.location.href='teso-acuerdopredialver.php?idacuerdo='+acuerdo;
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
          		<td colspan="3" class="cinta"><a href="teso-acuerdopredial.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a class="mgbt"><img src="imagenes/guardad.png"/></a><a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a><a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>				
           </tr>	
		</table>
 		<form name="form2" method="post" action="teso-buscaacuerdopredial.php">
        	<?php if($_POST[oculto]==""){$_POST[escon1]="none";$_POST[escon2]="none";}?>
			<table  class="inicio">
      			<tr>
        			<td class="titulos" colspan="6" style='width:93%'>:. Buscar Acuerdos Liquidaci&oacute;n Predial</td>
        			<td width="139" class="cerrar" style='width:7%'><a href="teso-principal.php">Cerrar</a></td>
      			</tr>
      			<tr>
                	<td class="saludo1" style='width:8%'>Buscar Por:</td>
                	<td >
                        <select name="tbusqueda" id="tbusqueda" onChange="consul();">
                            <option value="" <?php if($_POST[tbusqueda]==""){echo "SELECTED";}?>>Seleccione ...</option>
                            <option value="1" <?php if($_POST[tbusqueda]=="1"){echo "SELECTED";}?>>N&deg; Acuerdo</option>
                            <option value="2" <?php if($_POST[tbusqueda]=="2"){echo "SELECTED";}?>>Fecha</option>
                            <option value="3" <?php if($_POST[tbusqueda]=="3"){echo "SELECTED";}?>>Autoriza</option>
                        </select>
                        <input type="text" name="consul1" id="consul1" style="display:<?php echo $_POST[escon1];?>; width:30%"> 
                        <input type="date" name="consul2" id="consul2" style="display:<?php echo $_POST[escon2];?>">
                        <input type="hidden" name="escon1" id="escon1" value="<?php echo $_POST[escon1];?>"> 
                        <input type="hidden" name="escon2" id="escon2" value="<?php echo $_POST[escon2];?>">                     
                        <input name="oculto" type="hidden" value="1">
						<input name="anula" id="anula" type="hidden" value="<?php echo $_POST[anula];?>">
						<input name="anulacompro" id="anulacompro" type="hidden" value="<?php echo $_POST[anulacompro];?>">
                	</td>
        		</tr>                       
    		</table>    
     		<div class="subpantallap" style="height:68.5%; width:99.6%;">
      		<?php
				  if($_POST[anula]=='1'){
					  if(!empty($_POST[anulacompro])){
						  $sql="UPDATE tesoacuerdopredial SET estado='N' WHERE idacuerdo='$_POST[anulacompro]' ";
						  mysql_query($sql,$linkbd);
					  }
					echo "<script>document.getElementById('anula').value='';document.getElementById('anulacompro').value='';</script>"; 
				  }
				//if($_POST[oculto])
				//{
					switch ($_POST[tbusqueda]) 
					{
						case "":
							$sqlr="SELECT * FROM tesoacuerdopredial ORDER BY idacuerdo DESC";
							break;
						case "1":
							$sqlr="SELECT * FROM tesoacuerdopredial WHERE idacuerdo LIKE '%$_POST[consul1]%' ORDER BY idacuerdo DESC";
							break;
						case "2":
							$sqlr="SELECT * FROM tesoacuerdopredial WHERE fecha_acuerdo='$_POST[consul2]' ORDER BY idacuerdo DESC";
							break;
						case "3":
							$sqlr="SELECT * FROM tesoacuerdopredial WHERE tercero LIKE '%$_POST[consul1]%' ORDER BY idacuerdo DESC";
					}
					$resp = mysql_query($sqlr,$linkbd);
					$ntr = mysql_num_rows($resp);
					$con=1;
					echo "
					<table class='inicio'>
						<tr><td colspan='12' class='titulos'>.: Resultados Busqueda:</td></tr>
						<tr><td colspan='12'>Acuerdos Encontradas: $ntr</td></tr>
						<tr>
							<td class='titulos2' style='width:3%'>Item</td>
							<td class='titulos2' style='width:3%'>Acuerdo</td>
							<td class='titulos2' style='width:7%'>Fecha de Acuerdo</td>
							<td class='titulos2' style='width:7%'>Fecha M&aacute;xima</td>
							<td class='titulos2' style='width:10%'>C&oacute;digo Catastral</td>
							<td class='titulos2' style='width:15%' colspan='2' >Propietario</td>
							<td class='titulos2' style='width:10%' >Cuotas</td>
							<td class='titulos2' style='width:6%'>Valor</td>
							<td class='titulos2' style='width:3%'>Estado</td>
							<td class='titulos2' style='width:3%'>Anular</td>
							<td class='titulos2' style='width:3%'>Ver</td>
						</tr>";	
					$iter='zebra1';
					$iter2='zebra2';
					
					while ($row =mysql_fetch_row($resp)) 
 					{
						$recibos=$row[14];
						$permiteAnular="1";
						if(!empty($recibos)){
							$arreglorec=explode(",",$recibos);
							for($i=0;$i<count($arreglorec);$i++){
								if(!empty($arreglorec[$i])){
									$sql="SELECT estado FROM tesoreciboscaja WHERE id_recibos='$arreglorec[$i]' ";
									$res=mysql_query($sql,$linkbd);
									$fila=mysql_fetch_row($res);
									if($fila[0]=='S'){
										$permiteAnular="0";
										break;
									}
								}
								
							}
						}
						
						
						switch ($row[8]) 
						{
							case "S":
								if($permiteAnular=="0"){
									$imgsem="src='imagenes/sema_verdeON.jpg' title='Con recibo de caja activo'";
									$imganu="<a href='#' ><img src='imagenes/anular.png' title='Con recibo de caja activo' style='width:20px'/></a>";
								}else{
									$imgsem="src='imagenes/sema_amarilloON.jpg' title='Activa'";
									$imganu="<a href='#' onClick='anular($row[0])' ><img src='imagenes/anular.png' title='Anular' style='width:20px'/></a>";
								}
								
								break;
							case "N":
								$imgsem="src='imagenes/sema_rojoON.jpg' title='Anulada'";
								$imganu="<a href='#'><img src='imagenes/anulard.png' title='Ya est&aacute; Anulada' style='width:20px'/></a>";
						}
	 					echo "
						<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase' onDblClick='direcciona($row[0])'>
					 		<td>$con</td>
					 		<td>$row[0]</td>
					 		<td>".date('d-m-Y',strtotime($row[5]))."</td>
							<td>".date('d-m-Y',strtotime($row[6]))."</td>
							<td>$row[1]</td>
							<td>$row[13]</td>
							<td>$row[13]</td>
							<td>$row[10] / $row[4]</td>
							<td style='text-align:right;'>$".number_format($row[7],2)."</td>
							<td style='text-align:center;width:4%'><img $imgsem style='width:18px'/></td>
							<td style='text-align:center;width:4%'>$imganu</td>
							<td style='text-align:center;width:4%'><a href='teso-acuerdopredialver.php?idacuerdo=$row[0]'><img src='imagenes/buscarep.png'></a></td>
							
						</tr>";
						$con+=1;
						$aux=$iter;
						$iter=$iter2;
					 	$iter2=$aux;
 					}
					
 					echo"</table>";
				//}
			?>
            </div>
		</form>
	</body>
</html>