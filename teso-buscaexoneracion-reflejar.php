<?php //V 1001 21/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	setlocale(LC_ALL,"es_ES");
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
		
	<title>:: SPID - Contabilidad</title>
			
			<link href="css/css2.css" rel="stylesheet" type="text/css" />
			<link href="css/css3.css" rel="stylesheet" type="text/css" />
			<link href="css/tabs.css" rel="stylesheet" type="text/css"/>
			<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
			<script type="text/javascript" src="css/programas.js"></script>
			<script type="text/javascript" src="css/calendario.js"></script>
			<script>
				function verUltimaPos(idpres, filas, filtro){
					var scrtop=$('#divdet').scrollTop();
					var altura=$('#divdet').height();
					var numpag=$('#nummul').val();
					var limreg=$('#numres').val();
					if((numpag<=0)||(numpag==""))
						numpag=0;
					if((limreg==0)||(limreg==""))
						limreg=10;
					numpag++;
					location.href="cont-exoneracion-reflejar.php?idpres="+idpres;
				}
				function verUltimaPos1(idpres, filas, filtro){
					var scrtop=$('#divdet').scrollTop();
					var altura=$('#divdet').height();
					var numpag=$('#nummul').val();
					var limreg=$('#numres').val();
					if((numpag<=0)||(numpag==""))
						numpag=0;
					if((limreg==0)||(limreg==""))
						limreg=10;
					numpag++;
					location.href="cont-exoneracion-reflejar.php?idpres="+idpres;
				}
			
				function eliminar(idr)
				{
					if (confirm("Esta Seguro de Reversar el comprobante "))
					{
						document.form2.oculto.value=2;
						document.form2.var1.value=idr;
						document.form2.submit();
					}
				}

				
				function crearexcel(){
					document.form2.action="teso-buscapredialexcel.php";
					document.form2.target="_BLANK";
					document.form2.submit();
					document.form2.action="";
					document.form2.target="";
					//refrescar();
				}
				function selpdf()
			{
				
				tipoex=document.form2.tabgroup1.value;
				switch(tipoex)
				{
					case "1":	document.form2.action="teso-pdfexoneraciones.php";break;
					
				}
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
					<a href="cont-exentos-reflejar.php" class="mgbt"><img src="imagenes/add.png" alt="Nuevo" border="0" title="Nuevo"/> </a> 
					<a href="#" class="mgbt"><img src="imagenes/guardad.png" alt="Guardar" title="Guardar"/> </a>
					<a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" alt="Buscar" title="Buscar" /></a> 
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana" title="Nueva Ventana"></a>
					<!--<a href="#"  class="mgbt"><img src="imagenes/print.png"  onClick="selpdf()" alt="pdf" title="Imprimir"></a>-->
					<!--<a href="#" onclick="crearexcel()" class="mgbt"><img src="imagenes/excel.png" title="Excel" title="Exportar Excel"></a>-->
					<a href="cont-reflejardocs.php"><img src="imagenes/iratras.png" alt="nueva ventana"></a>
				</td>
			</tr>	
		</table>
<tr><td colspan="3" class="tablaprin"> 
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
<form name="form2" method="post" action="" action="teso-buscaexoneraciones.php">
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
        	<td class="titulos" colspan="2">:. Buscar Predial Exonerado/Exento</td>
        	<td style="width:7%" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
			
      	</tr>
      	<tr >
        	<td style="width:3.5cm" class="saludo1">C&oacute;digo Catastral:</td>
        	<td style="width:70%" >
        		<input name="nombre" id="nombre" type="search" style="width:60%" value="<?php echo $_POST[nombre] ?>" >
				<input type="button" name="bboton" onClick="limbusquedas();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" />
        		<input name="oculto" id="oculto" type="hidden" value="<?php echo $_POST[oculto] ?>" >
        		<input type="hidden" name="var1" id="var1"  value="<?php echo $_POST[var1] ?>" />
        	</td>
        </tr>                       
    </table>   
<form name="form2" method="post" action="cont-buscapagonomina-reflejar.php">
	<?php if ($_POST[oculto]==""){$_POST[numres]=10;$_POST[numpos]=0;$_POST[nummul]=0;}?>
    <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
    <input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
    <input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
	<div class="subpantallap" style="height:68.5%; width:99.6%; overflow-x:hidden;">
   		<?php
		$oculto=$_POST['oculto'];
		$sqlr="select * from tesopredios tp, tesoexoneracion te where te.cedulacatastral=tp.cedulacatastral and tp.estado='S' order by id desc";
		$resp = mysql_query($sqlr,$linkbd);
		$ntr = mysql_num_rows($resp);
		$con=1;
		if($_POST[iddeshff]==1){$tff01=10;$tff02=11;}
		else {$tff01=9;$tff02=10;}
		echo "
		<table class='inicio' align='center'>
			<tr><td colspan='$tff01' class='titulos'>.: Resultados Busqueda:</td></tr>
			<tr><td colspan='$tff02'>Prediales Exoneraciones Encontrados: $ntr</td></tr>
			<tr>
				<td class='titulos2' style='width:6%'>Id Exento</td>
				<td class='titulos2' style='width:8%'>Fecha</td>
				<td class='titulos2' style='width:8%'>Resolucion</td>
				<td class='titulos2' style='width:15%'>Codigo Catastral</td>
				<td class='titulos2'>Propietario</td>
				<td class='titulos2'>Documento</td>
				<td class='titulos2' style='width:14%'>Tipo Predio</td>
				<td class='titulos2' style='width:4%'>Estado</td>
				<td class='titulos2' style='width:4%'>Anular</td>
				<td class='titulos2' style='width:4%'>Ver</td>
			</tr>";	
			// echo"<td class='titulos2' style='width:4%'>Ver</td></tr>";	
			$iter='zebra1';
			$iter2='zebra2';
			while ($row =mysql_fetch_row($resp)) 
			{
				if($row[13]=='S')
				{
					$imgsem="src='imagenes/sema_verdeON.jpg' title='Exonerado'";
					$coloracti="#0F0";
				}
				else
				{
					$imgsem="src='imagenes/sema_rojoON.jpg' title='Reversado'";
					$coloracti="#C00";
				}
				$sqlr1="SELECT sum(saldo) from pptocdp_det_r where consvigencia=$row[2] and vigencia=$row[1]";
				$resp1 = mysql_query($sqlr1,$linkbd);
				$row1 =mysql_fetch_row($resp1);
				$idcta="'$row[0]'";
				$idpres="'$row[17]'";
				$numfil="'$filas'";
				$filtro="'$_POST[nombre]'";
				echo " <tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" onDblClick=\"verUltimaPos1($idpres, $numfil, $filtro)\" style='text-transform:uppercase; $estilo' >
					<td>$row[17]</td>
					<td>$row[18]</td>
					<td style='text-align:right;'>$row[19]</td>
					<td style='text-align:right;'>$row[0]</td>
					<td>&nbsp;$row[6]</td>
					<td>$row[5]</td>
					<td style='text-align:center;'>$row[14]</td>
					<td style='text-align:center;'><img $imgsem style='width:20px'/></td>";
					if ($row[13]=='S'){
						echo "<td style='text-align:center;'><a href='#' onClick=eliminar($row[17])><img src='imagenes/anular.png' style='width:20px'></a></td>";
					}
					if ($row[13]!='S'){
						echo "<td></td>";
					}
					echo"<td style='text-align:center;'>
					<a onClick=\"verUltimaPos1($idpres, $numfil, $filtro)\" style='cursor:pointer;'>
						<img src='imagenes/lupa02.png' style='width:20px' title='Ver'>
					</a>
					</td>
				</tr>";
		
				$con+=1;
				$aux=$iter;
				$iter=$iter2;
				$iter2=$aux;
			}
			if($_POST[oculto]==2)
			{
				
				 $linkbd=conectar_bd();	
				 $sqlr="select * from tesoexentos where id=$_POST[var1]";
				 $resp = mysql_query($sqlr,$linkbd);
				 $row=mysql_fetch_row($resp);
				 //********Comprobante contable en 000000000000
				  $sqlr="update comprobante_cab set estado='0' where tipo_comp='33' and numerotipo=$row[0]";
				  mysql_query($sqlr,$linkbd);
				  //echo $sqlr;
				  $sqlr="update comprobante_det set estado='0' where tipo_comp='33' and numerotipo=$row[0]";
				  mysql_query($sqlr,$linkbd);
				  
				  $sqlr="update tesoexentos set estado='N' where id=$row[0]";
				  mysql_query($sqlr,$linkbd);

				  $sqlr="update tesoexentos_det set estado='N' where cedulacatastral=$row[3]";
				  mysql_query($sqlr,$linkbd);
					 
				  $sqlr="update tesoprediosavaluos set pago='N' where codigocatastral=$row[3]";
				  mysql_query($sqlr,$linkbd);
				  
			}
		echo"</table>";
		?> 
  	</div>	
</form> 
<br><br>
</td></tr>     
</table>
</body>
</html>