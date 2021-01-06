<?php
require"comun.inc";
require"funciones.inc";
session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html" />
		<meta http-equiv="X-UA-Compatible" content="IE=9" />
		<title>:: SPID - Tesoreria</title>
		
			<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
			<script type="text/javascript" src="css/programas.js"></script>
			<script>
				function verUltimaPos(idcta, filas, filtro)
				{
					var scrtop=$('#divdet').scrollTop();
					var altura=$('#divdet').height();
					var numpag=$('#nummul').val();
					var limreg=$('#numres').val();
					if((numpag<=0)||(numpag==""))
						numpag=0;
					if((limreg==0)||(limreg==""))
						limreg=10;
					numpag++;	//location.href="teso-predialver.php?idpredial="+idcta+"&scrtop="+scrtop+"&totreg="+filas+"&altura="+altura+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
				}
				function eliminar(idr)
				{
					if (confirm("Esta Seguro de Eliminar"))
					{
						document.form2.oculto.value=2;
						document.form2.var1.value=idr;
						document.form2.submit();
					}
				}
				function pdf()
				{
				document.form2.action="pdfcobropredial_masivo.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
				}
				function pdf2()
				{
				document.form2.action="pdfcobropredial_masivo2.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
				}				
				function pdf3()
				{
				document.form2.action="pdfcobropredial_masivo3.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
				}
				function pdf4()
				{
					document.form2.action="pdfcobropredial_masivo4.php";
					document.form2.target="_BLANK";
					document.form2.submit(); 
					document.form2.action="";
					document.form2.target="";
				}
				function excell()
				{
					document.form2.action="teso-buscapredialexcel.php";
					//document.form2.excel.value=1;
					document.form2.target="_BLANK";
					document.form2.submit();
					refrescar(); 

				}
				function crearexcel()
				{
					document.form2.action="teso-buscapredialexcel.php";
					document.form2.target="_BLANK";
					document.form2.submit();
					refrescar();
				}

				function refrescar()
				{
					document.form2.excel.value="";
					document.form2.action="";
					document.form2.target="";
					//document.form2.submit();
				}
				function filtrarcatastral(codigo)
				{
					document.getElementById('nombre').value=codigo;
					limbusquedas();
				}
			</script>

			<script src="css/calendario.js"></script>
			<link href="css/css2.css" rel="stylesheet" type="text/css" />
			<link href="css/css3.css" rel="stylesheet" type="text/css" />
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
			<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("teso");?></tr>
			<tr>
				<td colspan="3" class="cinta">
					<a href="teso-reportecobropredial_masivo.php" class="mgbt"><img src="imagenes/add.png" alt="Nuevo" title="Nuevo"/></a> 
					<a href="#" class="mgbt"><img src="imagenes/guardad.png" alt="Guardar" title="Guardar"/> </a>
					<a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" alt="Buscar" title="Buscar" /></a> 
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana" title="Nueva ventana"></a> 
					<a href="#" onclick="excell()" class="mgbt"><img src="imagenes/excel.png" title="Excel"></a> 
					<a href="#" onClick="pdf()" class="mgbt"> <img src="imagenes/print.png"  alt="Buscar" title="Imprimir"/></a>
					<a href="#" onClick="pdf2()" class="mgbt"> <img src="imagenes/print111.png"  alt="Buscar2" title="Imprimir_v2"/></a>
					<a href="#" onClick="pdf3()" class="mgbt"> <img src="imagenes/print.png"  alt="Buscar2" title="Imprimir_v3"/></a>
					<a href="#" onClick="pdf4()" class="mgbt"> <img src="imagenes/print2.png"  alt="Buscar2" title="Cubarral"/></a>
					<a href="teso-gestioncobropredial.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
				</td>
			</tr>	
		</table>
		<tr><td colspan="5" class="tablaprin"> 
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
<form name="form2" method="post" action="">
    <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
	<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
	<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
	
	<table  class="inicio" align="center" >
    	<tr >
        	<td class="titulos" colspan="7">:. Buscar Liquidacion Predial</td>
        	<td style="width:7%" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      	</tr>
      	<tr >
			<td style="width:15%" class="saludo1"> Codigo Catastral:</td>
        	<td style="width:15%" >
        		<input name="nombre" id="nombre" type="search" style="width:90%" value="<?php echo $_POST[nombre] ?>" />
        		<input name="oculto" id="oculto" type="hidden" value="<?php echo $_POST[oculto] ?>" />
        		<input name="excel"  id="excel"  type="hidden" value="<?php echo $_POST[excel] ?>" />
        		<input name="var1" id="var1" type="hidden" value="<?php echo $_POST[var1] ?>" />
        	</td>
			<td style="width:15%" class="saludo1"> No. Resolucion:</td>
        	<td style="width:10%" >
        		<input name="numresolucion" id="numresolucion" type="search" style="width:70%" value="<?php echo $_POST[numresolucion] ?>" />
        	</td>
			<td style="width:15%" class="saludo1"> Busqueda No:</td>
        	<td style="width:10%" >
        		<input name="numbusqueda" id="numbusqueda" type="search" style="width:70%" value="<?php echo $_POST[numbusqueda] ?>" />
        	</td>
			<td><input type="button" name="bboton" onClick="limbusquedas();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" /></td>
        </tr>
		
    </table>    
	<div class="subpantallac5" style="height:68.5%; width:99.6%; overflow-x:hidden;" id="divdet">
    	<?php
    	if($_POST[oculto]==2){
	 		$linkbd=conectar_bd();	
			$sqlr="update tesocobroreporte set estado='N' where idtesoreporte=$_POST[var1]";
			$resp = mysql_query($sqlr,$linkbd);
			$row=mysql_fetch_row($resp);	 
		}
		$cmoff='imagenes/sema_rojoOFF.jpg';
		$cmrojo='imagenes/sema_rojoON.jpg';
		$cmamarillo='imagenes/sema_amarilloON.jpg';
		$cmverde='imagenes/sema_verdeON.jpg';
		$oculto=$_POST['oculto'];
		$excel=$_POST['excel'];
		$linkbd=conectar_bd();
		$crit1="";
		$crit2="";
		if ($_POST[nombre]!=""){
			$crit1="and codcatastral LIKE '%$_POST[nombre]%'";
		}

		if($_POST[numresolucion]!=""){
			$crit2="and numresolucion='$_POST[numresolucion]'";
		}
		if($_POST[numbusqueda]!=""){
			$crit3="and idconsulta='$_POST[numbusqueda]'";
		}
		
		//sacar el consecutivo 
		$sqlr="select *from tesocobroreporte where tesocobroreporte.idtesoreporte>-1 $crit1 $crit2 $crit3";
		$resp = mysql_query($sqlr,$linkbd);
		$ntr = mysql_num_rows($resp);

		$_POST[numtop]=$ntr;
		$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);

		$sqlr="select *from tesocobroreporte where tesocobroreporte.idtesoreporte>-1 $crit1 $crit2 $crit3 group by tesocobroreporte.numresolucion desc ";
        $resp = mysql_query($sqlr,$linkbd);

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
				<td colspan='6' class='titulos'>.: Resultados Busqueda:</td>
			</tr>
			<tr>
				<td colspan='6' class='saludo3'>Resoluciones Encontradas: $ntr</td>
			</tr>
			<tr>
				<td class='titulos2' width='10%'>No Resolucion</td>
				<td class='titulos2'>Codigo Catastral</td>
				<td class='titulos2'>Fecha</td>
				<td class='titulos2'>Total debe</td>
				<td class='titulos2' width='10%' align='center'>Estado</td>
				<td class='titulos2' width='5%'><center>Ver</td>
			</tr>";	
          	$iter='saludo1a';
            $iter2='saludo2';
			$filas=1;
			
 			while ($row =mysql_fetch_row($resp)){
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
				$sql1="SELECT pago FROM tesoprediosavaluos WHERE codigocatastral='$row[3]' and vigencia='$row[2]'";
				$r1=mysql_query($sql1,$linkbd);
				$row3=mysql_fetch_row($r1);
				if($row3[0]=="S")
				{
					$p2luzcem1=$cmverde;$p2luzcem2=$cmverde;$p2luzcem3=$cmverde;
				}
				else
				{
					$sql="SELECT proceso FROM tesocobroreporte_adj WHERE numresolucion='$row[16]'";
					$r=mysql_query($sql,$linkbd);
					$row2 =mysql_fetch_row($r);
					if($row2[0]=="resolucion")
					{
						$p2luzcem1=$cmverde;$p2luzcem2=$cmamarillo;$p2luzcem3=$cmrojo;
					}
					elseif ($row2[0]=="citacion")
					{
						$p2luzcem1=$cmverde;$p2luzcem2=$cmverde;$p2luzcem3=$cmamarillo;
					}
					elseif ($row2[0]=="mandamiento")
					{
						$p2luzcem1=$cmverde;$p2luzcem2=$cmverde;$p2luzcem3=$cmverde;
						echo "<td><input name='estado' value='S' type='hidden'></td>";
					}
					else
					{
						$p2luzcem1=$cmamarillo;$p2luzcem2=$cmrojo;$p2luzcem3=$cmrojo;
					}
				}
				
				$idcta="'".$row[0]."'";
				$sqlr1="select sum(valortotal) from tesocobroreporte where numresolucion='$row[16]'";
				$resp1 = mysql_query($sqlr1,$linkbd);
				$row1=mysql_fetch_row($resp1);
				$numfil="'".$filas."'";
				$filtro="'".$_POST[nombre]."'";
				echo"<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
			onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase; $estilo' >
					<td>$row[16]</td>
					<td>$row[3]</td>
					<td>$row[17]</td>
					<td>$ ".number_format($row1[0],2)."</td>
					<td align='center'><img src='$p2luzcem1' title='Persuasivo' width='16' height='16'><img src='$p2luzcem2' title='Coactivo' width='16' height='16'><img src='$p2luzcem3' title='Mandamiento de Pago' width='16' height='16'></td>
					<td><a href='teso-reportecobropredialver.php?resolucion=$row[16]'><center><img src='imagenes/buscarep.png'></center></a></td>
				</tr>";
				echo "<td ><input name='codcatastral[]' value='".$row[3]."' type='hidden' style='width:100%;' readonly></td>
						<td ><input name='codigo[]' value='".$row[16]."' type='hidden' style='width:100%;' readonly></td>";
                $con+=1;
                $con+=1;
                $aux=$iter;
                $iter=$iter2;
                $iter2=$aux;
				$filas++;
           	}
		if($_POST[excel]==1){
		?>
			<script>crearexcel();</script>
		<?php
		}
		
		?>
	</div>
</form> 
</td></tr>     
</table>
</body>
</html>