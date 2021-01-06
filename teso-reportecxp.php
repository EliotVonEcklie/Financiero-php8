<?php //V 1000 12/12/16 ?> 
<!--V 1.0 24/02/2015-->
<?php
	require "comun.inc";
	require "funciones.inc";
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
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
        <script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
		<script>

			function crearexcel()
			{
				document.form2.action="teso-buscaegresoexcel.php";
				document.form2.target="_BLANK";
				document.form2.submit();
				//refrescar();
			}
            function actualizar()
            {
                document.form2.submit();
            }
		</script>
		<?php titlepag();?>
        <?php
				
			$fech1=split("/",$_POST[fecha]);
			$fech2=split("/",$_POST[fecha2]);
			$f1=$fech1[2]."-".$fech1[1]."-".$fech1[0];
			$f2=$fech2[2]."-".$fech2[1]."-".$fech2[0];
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
				<a href="teso-reportecxp.php" accesskey="n" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
				<a class="mgbt"><img src="imagenes/guardad.png"/></a>
				<a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a>
				<a href="#" onClick="<?php echo paginasnuevas("teso");?>" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a> 
				<a href="#" onclick="crearexcel()" class="mgbt"><img src="imagenes/excel.png" title="Excell"></a></td>
        	</tr>	
        </table>
        <?php
		
			if($_POST[nummul]=="")
			{
				$_POST[numres]=10;
				$_POST[numpos]=0;
				$_POST[nummul]=0;
			}
			
			if($_POST[oculto]==""){$_POST[iddeshff]=0;}
		?>
 		<form name="form2" method="post" action="teso-reportecxp.php">
         	<input name="excel"  id="excel"  type="hidden" value="<?php echo $_POST[excel] ?>" >
			<table  class="inicio" align="center" >
      			<tr>
        			<td class="titulos" colspan="8">:. Buscar Liquidaciones CxP</td>
        			<td class="cerrar" style='width:7%'><a href="teso-principal.php">&nbsp;Cerrar</a></td>
              	</tr>
              	<tr>
              		<td class="saludo1" style="width:3.1cm;">Fecha Inicial:</td>
       				<td style="width:12%;"><input name="fecha"  type="text" value="<?php echo $_POST[fecha]?>" maxlength="10"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" style="width:80%;" title="DD/MM/YYYY"/>&nbsp;<a href="#" onClick="displayCalendarFor('fc_1198971545');" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;"/></a></td>
       				<td class="saludo1" style="width:3.1cm;">Fecha Final:</td>
       				<td style="width:12%;"><input name="fecha2" type="text" value="<?php echo $_POST[fecha2]?>" maxlength="10"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971546" onKeyDown="mascara(this,'/',patron,true)" style="width:80%;" title="DD/MM/YYYY"/>&nbsp;<a href="#" onClick="displayCalendarFor('fc_1198971546');" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;"/></a></td>
                 	<td style="width:4.5cm" class="saludo1">N&uacute;mero o Detalle Orden: </td>
    				<td >
                		<input type="search" name="nombre" id="nombre" value="<?php echo $_POST[nombre];?>" style="width:50%" >
	          			
               		</td>
                    <td class="saludo1"> Estado</td>
                    <td>
                        <select name="est" id="est">
                            <option value="-1">...</option>
                            <option value="S">ACTIVO</option>
                            <option value="P">PAGO</option>
                            <option value="R">REVERSADO</option>
                            <option value="N">ANULADO</option>
                        </select>
                        <input type="button" name="bboton" onClick="actualizar();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" />
                        <input name="estado" id="estado" type="hidden" value="<?php echo $_POST[est]; ?>">
                    </td>
       			</tr>                        
    		</table> 
            <input name="oculto" id="oculto" type="hidden" value="1">
            <input name="var1" type="hidden" value=<?php echo $_POST[var1];?>>  
    		<script>
    			document.form2.nombre.focus();
	    		document.form2.nombre.select();
    		</script>
    		<input type="hidden" name="fecham1"  id="fecham1" value="<?php echo $_POST[fecham1]; ?>"/>
    		<input type="hidden" name="fecham2" id="fecham2" value="<?php echo $_POST[fecham2]; ?>"/>
     		<div class="tabsmeci" style="height:64.5%; width:99.6%; overflow: scroll;">
      				<?php
					$_POST[fecham1]=$f1;
					$_POST[fecham2]=$f2;
					//$_POST[fecha]=$f1;
					//$_POST[fecha2]=$f2;
					//****** 	
					$linkbd=conectar_bd();
					$crit1="";
					$crit3="";

					if ($_POST[nombre]!="")
						$crit1="and concat_ws(' ', id_orden, conceptorden) LIKE '%$_POST[nombre]%'";
					if ($_POST[estado]!='' && $_POST[estado]!='-1')
						$crit3="and estado='$_POST[estado]'";
					//sacar el consecutivo 
					if($_POST[nombre]!="" || $_POST[fecha]!="" || $_POST[fecha2]!="")
					{
						$sqlr="select * from tesoordenpago where tesoordenpago.id_orden>-1 $crit1 $crit3 and tipo_mov='201' order by tesoordenpago.id_orden DESC"; 
						if(isset($_POST[fecha]) && isset($_POST[fecha2])){
							if(!empty($_POST[fecha]) && !empty($_POST[fecha2])){
								$sqlr="select * from tesoordenpago where tesoordenpago.id_orden>-1 $crit1 $crit3 and fecha between '$f1' AND '$f2' and tipo_mov='201' order by tesoordenpago.id_orden DESC"; 
							}
						}
						
						$resp = mysql_query($sqlr,$linkbd);
						$ntr = mysql_num_rows($resp);
						$_POST[numtop]=$ntr;
						$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
						$cond2="";
						if ($_POST[numres]!="-1"){
							$cond2="LIMIT $_POST[numpos], $_POST[numres]"; 
						}
						$sqlr="select * from tesoordenpago where tesoordenpago.id_orden>-1 $crit1 $crit3 and tipo_mov='201' order by tesoordenpago.id_orden desc $cond2";
						if(isset($_POST[fecha]) && isset($_POST[fecha2])){
							if(!empty($_POST[fecha]) && !empty($_POST[fecha2])){
								$sqlr="select * from tesoordenpago where tesoordenpago.id_orden>-1 $crit1 $crit3 and fecha between '$f1' AND '$f2' and tipo_mov='201' order by tesoordenpago.id_orden DESC"; 
							}
						}

					}	
					
					$resp = mysql_query($sqlr,$linkbd);
					$con=1;
					$numcontrol=$_POST[nummul]+1;
					if(($nuncilumnas==$numcontrol)||($_POST[numres]=="-1")){
						$imagenforward="<img src='imagenes/forward02.png' style='width:17px'>";
						$imagensforward="<img src='imagenes/skip_forward02.png' style='width:16px' >";
					}
					else{
						$imagenforward="<img src='imagenes/forward01.png' style='width:17px' title='Siguiente' onClick='numsiguiente()'>";
						$imagensforward="<img src='imagenes/skip_forward01.png' style='width:16px' title='Fin' onClick='saltocol(\"$nuncilumnas\")'>";
					}
					if(($_POST[numpos]==0)||($_POST[numres]=="-1")){
						$imagenback="<img src='imagenes/back02.png' style='width:17px'>";
						$imagensback="<img src='imagenes/skip_back02.png' style='width:16px'>";
					}
					else{
						$imagenback="<img src='imagenes/back01.png' style='width:17px' title='Anterior' onClick='numanterior();'>";
						$imagensback="<img src='imagenes/skip_back01.png' style='width:16px' title='Inicio' onClick='saltocol(\"1\")'>";
					}
					
					$con=1;
					echo "<table class='inicio' align='center'>
						<tr>
							<td colspan='7' class='titulos'>.: Resultados Busqueda:</td>
							
							</td>
						</tr>
						<tr>
							<td colspan='9'>Liquidaciones Encontrados: $ntr</td>
						</tr>
						<tr>
							<td class='titulos2' style='width:3%'>Item</td>
							<td class='titulos2' style='width:5%'>Vigencia</td>
							<td class='titulos2' style='width:3%'>N RP</td>
							<td class='titulos2' >Detalle</td>
							<td class='titulos2' >Valor</td>
							<td class='titulos2' style='width:6.5%'>Fecha</td>
							<td class='titulos2' style='width:5%'>Estado</td>
						</tr>";	
						$iter='saludo1a';
						$iter2='saludo2';
						$filas=1;
						while ($row =mysql_fetch_row($resp)){
							$detalle=$row[2];
							$ntr=buscatercero($row[11]);
							switch ($row[13]){
								case "S":
									$imagen="src='imagenes/confirm.png' title='Activo'";
									$camcelda="<td style='text-align:center;'><a href='#' onClick=eliminar($row[0])><img src='imagenes/anular.png' title='Anular'></a></td>";
									break;
								case "P":
									$imagen="src='imagenes/dinero3.png' title='Pago'";
									$camcelda="<td style='text-align:center;'><img src='imagenes/candado.png' title='bloqueado' style='width:18px'/></td>";
									break;
								case "N":
									$imagen="src='imagenes/cross.png' title='Anulado'";
									$camcelda="<td style='text-align:center;'><img src='imagenes/candado.png' title='bloqueado' style='width:18px'/></td>";
								case "R":
									$imagen="src='imagenes/reversado.png' title='Reversado'";
									$camcelda="<td style='text-align:center;'><img src='imagenes/candado.png' title='bloqueado' style='width:18px'/></td>";
							}
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
							$numfil="'$filas'";
							$filtro="'$_POST[nombre]'";
							echo"<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
				onMouseOut=\"this.style.backgroundColor=anterior\"  style='text-transform:uppercase; $estilo' >
								<td>$row[0]</td>
								<td>$row[3]</td>
								<td>$row[4]</td>
								<td>$row[7]</td>
								<td style='text-align:right;'>$ ".number_format($row[10],$_SESSION["ndecimales"],$_SESSION["spdecimal"],$_SESSION["spmillares"])."&nbsp;&nbsp;</td>
								<td>".date('d-m-Y',strtotime($row[2]))."</td>
								<td style='text-align:center;'><img $imagen style='width:18px'></td>
								</tr>";
							$con+=1;
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
							$filas++;
						}
                        echo"</table>";
				?>
			</div>
		</form>
	</body>
</html>