<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
        <title>:: SPID - Tesoreria</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
        <script type="text/javascript" src="css/programas.js"></script>
		<script>
			function verUltimaPos(idcta, filas, filtro){
				var scrtop=$('#divdet').scrollTop();
				var altura=$('#divdet').height();
				var numpag=$('#nummul').val();
				var limreg=$('#numres').val();
				if((numpag<=0)||(numpag==""))
					numpag=0;
				if((limreg==0)||(limreg==""))
					limreg=10;
				numpag++;
				location.href="teso-editasinsituacion.php?idrecaudo="+idcta+"&scrtop="+scrtop+"&totreg="+filas+"&altura="+altura+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
			}
		</script>
		<script src="css/calendario.js"></script>
		<script>
        function eliminar(idr){
            if (confirm("Esta Seguro de Eliminar el Recaudo Transferencia "+idr)){
                document.form2.oculto.value=2;
                document.form2.var1.value=idr;
                document.form2.submit();
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
  <a href="teso-sinsituacion.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
  <a class="mgbt"><img src="imagenes/guardad.png"/></a>
  <a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a>
  <a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td></tr>	
</table>
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
<form name="form2" method="post" action="teso-buscasinsituacion.php">
	<table  class="inicio" align="center" >
	   	<input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
    	<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
      	<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
    	<tr >
        	<td class="titulos" colspan="2">:. Buscar Ingresos Sin Situacion de Fondos - SSF</td>
        	<td style="width:7%" class="cerrar" ><a href="teso-principal.php"> Cerrar</a></td>
      	</tr>
      	<tr >
         	<td style="width:3.5cm" class="saludo1">Numero Ingreso o Concepto: </td>
    		<td style="width:70%" >
            	<input name="nombre" type="text" value="" style="width:50%" >
          		<input name="oculto" id="oculto" type="hidden" value="1">
                <input name="var1" type="hidden" value=<?php echo $_POST[var1];?>>
           	</td>
     	</tr>                       
  	</table>    
   	<div class="subpantallap" style="height:68.5%; width:99.6%; overflow-x:hidden;" id="divdet">
		 <?php
        $oculto=$_POST['oculto'];
        if($_POST[oculto]==2){
	 		$linkbd=conectar_bd();	
	 		$sqlr="select * from tesossfingreso_cab where id_recaudo=$_POST[var1]";
	 		$resp = mysql_query($sqlr,$linkbd);
	 		$row=mysql_fetch_row($resp);
	 		//********Comprobante contable en 000000000000
	  		$sqlr="update comprobante_cab set total_debito=0,total_credito=0,estado='0' where numerotipo=$row[0] AND tipo_comp=20";
		  	mysql_query($sqlr,$linkbd);
		  	$sqlr="update comprobante_det set valdebito=0,valcredito=0 where id_comp='20 $row[0]'";
		  	mysql_query($sqlr,$linkbd);
			$sqlr="update pptocomprobante_cab set estado='0' where tipo_comp='21' and numerotipo=$row[0]";
			mysql_query($sqlr,$linkbd);
	
	 //******** RECIBO DE CAJA ANULAR 'N'	 
	  		$sqlr="update tesossfingreso_cab set estado='N' where id_recaudo=$row[0]";
		  	mysql_query($sqlr,$linkbd);
		  	$sqlr="select * from pptoingssf where idrecibo=$row[0]";
		  	$resp=mysql_query($sqlr,$linkbd);
		  	while($r=mysql_fetch_row($resp)){
				$sqlr="update pptocuentaspptoinicial set ingresos=ingresos-$r[3] where cuenta='$r[1]'";
				mysql_query($sqlr,$linkbd);
		   	}	
		   	$sqlr="delete from pptoingssf where idrecibo=$row[0]";
		  	$resp=mysql_query($sqlr,$linkbd); 
		}
   		?>
      	<?php
		$oculto=$_POST['oculto'];
		$linkbd=conectar_bd();
		$crit1="";
		if ($_POST[nombre]!="")
			$crit1="and concat_ws(' ', id_recaudo, concepto) LIKE '%$_POST[nombre]%'";
		//sacar el consecutivo 
		$sqlr="select *from tesossfingreso_cab where tesossfingreso_cab.id_RECAUDO>-1 ".$crit1." order by tesossfingreso_cab.id_RECAUDO";
		$resp = mysql_query($sqlr,$linkbd);
		$ntr = mysql_num_rows($resp);
		$_POST[numtop]=$ntr;
		$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);

		$cond2="";
		if ($_POST[numres]!="-1"){ 
			$cond2="LIMIT $_POST[numpos], $_POST[numres]"; 
		}
		$sqlr="select *from tesossfingreso_cab where tesossfingreso_cab.id_RECAUDO>-1 ".$crit1." order by tesossfingreso_cab.id_RECAUDO desc $cond2";
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
				<td colspan='8' class='titulos'>.: Resultados Busqueda:</td>
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
				<td class='saludo3' colspan='9'>Recaudos Encontrados: $ntr</td>
			</tr>
			<tr>
				<td class='titulos2'>Codigo</td>
				<td class='titulos2'>Fecha</td>
				<td class='titulos2'>Tercero</td>
				<td class='titulos2'>Descripcion</td>
				<td class='titulos2'>Valor</td>
				<td class='titulos2'>Vigencia</td>
				<td class='titulos2'>Estado</td>
				<td class='titulos2' width='5%'><center>Anular</td>
				<td class='titulos2' width='5%'><center>Ver</td>
			</tr>";	
            $iter='saludo1a';
            $iter2='saludo2';
			$filas=1;
 			while ($row =mysql_fetch_row($resp)){
			 	$nter=buscatercero($row[5]);
				if($row[8]=='S'){$imgsem="src='imagenes/sema_verdeON.jpg' title='Activo'";} 	 				  
				if($row[8]=='N'){$imgsem="src='imagenes/sema_rojoON.jpg' title='Anulado'";} 	
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
				$idcta="'".$row[0]."'";
				$numfil="'".$filas."'";
				$filtro="'".$_POST[nombre]."'";
				echo"<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
			onMouseOut=\"this.style.backgroundColor=anterior\" onDblClick=\"verUltimaPos($idcta, $numfil, $filtro)\" style='text-transform:uppercase; $estilo' >
					<td>$row[0]</td>
					<td>$row[2]</td>
					<td>$row[5] - $nter</td>
					<td>$row[4] </td>
					<td>".number_format($row[7],2,",",".")."</td>
					<td >$row[3]</td>
					<td style='text-align:center;'><img $imgsem style='width:18px'/></td>";
	 	 			if($row[8]=='S')
						echo "<td style='text-align:center;'>
							<a href='#' onClick=eliminar($row[0])><img src='imagenes/anular.png'></a>
						</td>";		 
	 	 			if($row[8]=='N')
		 				echo "<td></td>";	 
					echo"<td style='text-align:center;'>
						<a onClick=\"verUltimaPos($idcta, $numfil, $filtro)\" style='cursor:pointer;'>
							<img src='imagenes/lupa02.png' style='width:18px' title='Editar'>
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
						for($xx = 1; $xx <= $numfin; $xx++){
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
</form> 
</body>
</html>