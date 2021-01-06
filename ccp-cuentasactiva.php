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
		<title>:: SPID - Presupuesto</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
        <script type="text/javascript" src="css/programas.js"></script>
		<script>
			function verCuentaActiva(idcta, tipo, filas, filtro){
				var scrtop=$('#divdet').scrollTop();
				var altura=$('#divdet').height();
				var numpag=$('#nummul').val();
				var limreg=$('#numres').val();
				if((numpag<=0)||(numpag==""))
					numpag=0;
				if((limreg==0)||(limreg==""))
					limreg=10;
				numpag++;
				location.href="ccp-editarcuentasactiva.php?idcta="+idcta+"&tipo="+tipo+"&scrtop="+scrtop+"&totreg="+filas+"&altura="+altura+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
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
			$_POST[numero]=$_GET['filtro'];
		?>
    </head>
    <body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("ccpet");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("ccpet");?></tr>
        	<tr>
		       	<td colspan="3" class="cinta">
                	<a href="ccp-cuentasactivaadd.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
                    <a class="mgbt"><img src="imagenes/guardad.png"/></a>
                    <a onClick="document.form2.submit();" href="#"  class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
                    <a href="#" onClick="mypop=window.open('ccp-principal.php','','');mypop.focus();"class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a><img src="imagenes/iratras.png" title="Atr&aacute;s" onClick="location.href='ccp-menucuentas.php'" class="mgbt"/>
               	</td>
			</tr>
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
		<form  method="post" enctype="multipart/form-data" name="form2" action="ccp-cuentasactiva.php">
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres]; ?>"/>
       		<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos]; ?>"/>
         	<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul]; ?>"/>
         	<input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>"/>
  			<table class="inicio">
    			<tr>
      				<td height="25" colspan="4" class="titulos" >Buscar Cuentas Ingresos </td>
                    <td class="cerrar"><a href="ccp-principal.php"> Cerrar</a></td>
    			</tr>
				<tr>
		  			<td colspan="5" class="titulos2" >:&middot; Por Descripcion </td>
				</tr>
				<tr>
				 	<td width="12%" class="saludo1" >:&middot; Numero Cuenta:</td>
				  	<td  colspan="3">
                    	<input name="numero" type="text" size="30" value="<?php echo $_POST[numero];?>" >
			      		<input name="oculto" type="hidden" id="oculto" value="1" >
			      		<input type="submit" name="Submit" value="Buscar" >
			      	</td>
			 	</tr>
  			</table>
			<div class="subpantallap" style="height:63.5%; width:99.6%; " id="divdet">
				<?php
				$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
				$cond="";
				$cond2="";
				if ($_POST[numero]!=""){ 
					$cond="and (cuenta like'%".$_POST[numero]."%' or nombre like '%".strtoupper($_POST[numero])."%')"; 
				}
/*				echo'<script>alert('.$_POST[numres].');</script>';*/
				if ($_POST[numres]!="-1"){ 
					$cond2="LIMIT $_POST[numpos], $_POST[numres]"; 
				}
				$sqlr="Select distinct pptocuentas.*, dominios.tipo from pptocuentas, dominios where dominios.descripcion_valor=pptocuentas.clasificacion AND dominios.nombre_dominio='CLASIFICACION_RUBROS' AND (dominios.tipo='I') and (vigencia='".$vigusu."' or  vigenciaf='".$vigusu."') $cond";
				$resp = mysql_query($sqlr,$linkbd);			
				$_POST[numtop]=mysql_num_rows($resp);
				$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
				$sqlr="SELECT DISTINCT pptocuentas.*, dominios.tipo FROM pptocuentas, dominios WHERE dominios.descripcion_valor=pptocuentas.clasificacion AND dominios.nombre_dominio='CLASIFICACION_RUBROS' AND (dominios.tipo='I') AND (vigencia='".$vigusu."' or  vigenciaf='".$vigusu."') $cond ORDER BY cuenta ASC ".$cond2;
				$resp = mysql_query($sqlr,$linkbd);			
				$co='saludo1a';
				$co2='saludo2';	
				$numcontrol=$_POST[nummul]+1;
				$i=($_POST[nummul]*$_POST[numres])+1;
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
				echo'<table class="inicio">
    				<tr>
      					<td height="25" colspan="7" class="titulos" style="width:95%" >Resultados Busqueda </td>
						<td class="submenu">
							<select name="renumres" id="renumres" onChange="cambionum();" style="width:100%">
								<option value="10"'; if ($_POST[renumres]=='10'){echo 'selected';} echo '>10</option>
								<option value="20"'; if ($_POST[renumres]=='20'){echo 'selected';} echo '>20</option>
								<option value="30"'; if ($_POST[renumres]=='30'){echo 'selected';} echo '>30</option>
								<option value="50"'; if ($_POST[renumres]=='50'){echo 'selected';} echo '>50</option>
								<option value="100"'; if ($_POST[renumres]=='100'){echo 'selected';} echo '>100</option>
								<option value="-1"'; if ($_POST[renumres]=='-1'){echo 'selected';} echo '>Todos</option>
							</select>
						</td>
      				</tr>
    				<tr>
      					<td width="32" class="titulos2"  >Item</td>
      					<td width="76" class="titulos2" >Cuenta </td>
      					<td width="140" class="titulos2" >Descripcion</td>
      					<td width="140" class="titulos2" >Tipo</td>          
      					<td class="titulos2" >Regal&iacute;as</td>
      					<td class="titulos2" >Unidad</td>		
      					<td class="titulos2" >Vigencia</td>	
      					<td width="5" class="titulos2" >Editar</td>	  	  
    				</tr>';
					$filas=1;
					while ($r =mysql_fetch_row($resp)){
						$negrilla="style='font-weight:bold'";
						$tipo=$r[2];
						if($gidcta!=""){
							if($gidcta==$r[0]){
								$estilo='background-color:yellow';
							}
							else{
								$estilo="";
							}
						}
						else{
							$estilo="";
						}	
						$idcta="'".$r[0]."'";
						$tipo="'".$tipo."'";
						$numfil="'".$filas."'";
						$filtro="'".$_POST[numero]."'";
						echo"<tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
			onMouseOut=\"this.style.backgroundColor=anterior\" onDblClick=\"verCuentaActiva($idcta, $tipo, $numfil, $filtro)\" style='text-transform:uppercase; $estilo' >";
							if ($r[2]=='Auxiliar'){
								$negrilla=" "; 
							} 
						?>
						<td><?php echo $i?></td>
				    	<?php 
						echo "<td $negrilla>".$r[0]."</td>";
				     	echo "<td $negrilla>".ucwords(strtolower($r[1]))."</td>";
						echo "<td $negrilla>".ucwords(strtolower($r[2]))."</td>";
						echo "<td align='center' $negrilla>".$r[37]."</td>";
						echo "<td align='center' $negrilla>".$r[39]."</td>";
						if($r[37]=='S')
							echo "<td $negrilla>".$r[38]."</td>";
						else
							echo "<td $negrilla>".$r[25]."</td>";
						
						echo "<td style='text-align:center;'>
								<a onClick=\"verCuentaActiva($idcta, $tipo, $numfil, $filtro)\" style='cursor:pointer;'>
								<img src='imagenes/b_edit.png' style='width:18px' title='Editar'></a>
							</td>
						</tr>";
         				$aux=$co;
			         	$co=$co2;
			         	$co2=$aux;
					 	$i=1+$i;
						$filas++;
		   			}
					$_POST[oculto]="";
					?>
				</table>
				<?php
				echo"<table class='inicio'>
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
							echo "&nbsp;&nbsp;<a href='#'>$imagenforward</a>
								&nbsp;<a href='#'>$imagensforward</a>
						</td>
					</tr>
				</table>";
				?>
		</div>
	</form>
</body>
</html>