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
		<title>:: SieS - Presupuesto</title>
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
				location.href="presu-editaterceros.php?idter="+idcta+"&scrtop="+scrtop+"&totreg="+filas+"&altura="+altura+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
			}
		</script>
		<script>
		function crearexcel(){
			document.form2.action="presu-buscaterceros-excel.php";
			document.form2.target="_BLANK";
			document.form2.submit();
			document.form2.action="";
			document.form2.target="";
		}
		</script>

		<?php 
			titlepag();
			$scrtop=$_GET['scrtop'];
			if($scrtop=="") {$scrtop=0;}
			echo"<script> window.onload=function(){ $('#divdet').scrollTop($scrtop)}</script>";
			$gidcta=$_GET['idcta'];
			if(isset($_GET['filtro'])){$_POST[nombre]=$_GET['filtro'];}
		?>
    </head>
    <body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("presu");?></tr>
        	<tr>
          		<td colspan="3" class="cinta">
					<a onClick="location.href='presu-terceros.php'" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
					<a class="mgbt"><img src="imagenes/guardad.png"/></a>
					<a onClick="document.form2.submit();" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a>
					<a onClick="<?php echo paginasnuevas("presu");?>" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					 <a href="#" onclick="crearexcel()" class="mgbt"><img src="imagenes/excel.png" title="Excel"></a>
					</td>
					
			</tr>
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
 		<form name="form2" method="post" action="presu-buscaterceros.php">
			<table  class="inicio" align="center" >
                <tr >
                    <td class="titulos" colspan="4">:: Buscar Tercero</td>
                    <td class="cerrar" style="width:7%;"><a onClick="location.href='presu-principal.php'">&nbsp;Cerrar</a></td>
                </tr>
                <tr >
                    <td style="width:4cm;" class="saludo1">:: Documento o Nombre:</td>
                    <td>
                        <input type="search" name="nombre" id="nombre" value="<?php echo $_POST[nombre];?>" style='width:50%;'/>
                        <input type="button" name="bboton" onClick="limbusquedas();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" />
                    </td>
                </tr>                       
			</table>    
    		<input type="hidden" name="oculto" id="oculto" value="1"/>
     		<input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres]; ?>"/>
       		<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos]; ?>"/>
         	<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul]; ?>"/>
			<div class="subpantalla" style="height:68.5%; width:99.6%; overflow-x:hidden;" id="divdet">
      		<?php
				$oculto=$_POST['oculto'];
				$linkbd=conectar_bd();
				$crit1=" ";
				if ($_POST[nombre]!="")
				{$crit1="WHERE concat_ws(' ', nombre1,nombre2,apellido1,apellido2,razonsocial,cedulanit) LIKE '%$_POST[nombre]%'";}
				//sacar el consecutivo 
				$sqlr="SELECT * FROM terceros  $crit1";
				$resp = mysql_query($sqlr,$linkbd);
				$ntr = mysql_num_rows($resp);
				
				
				
				$_POST[numtop]=$ntr;
				$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
				$cond2="";
				if ($_POST[numres]!="-1"){$cond2="LIMIT $_POST[numpos], $_POST[numres]"; }
				$sqlr="SELECT * FROM terceros $crit1 ORDER BY apellido1,apellido2,nombre1,nombre2,razonsocial $cond2";
				$resp = mysql_query($sqlr,$linkbd);			
				$co='saludo1a';
				$co2='saludo2';	
				$numcontrol=$_POST[nummul]+1;
				$i=($_POST[nummul]*$_POST[numres])+1;
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
				echo'
				<table class="inicio">
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
						<td colspan="8">Recursos Encontrados: '.$ntr.'</td>
					</tr>
					<tr>
						<td width="2%" class="titulos2">Item</td>
						<td width="30%" class="titulos2">RAZON SOCIAL</td>
						<td width="10%" class="titulos2">PRIMER APELLIDO</td>
						<td width="10%" class="titulos2">SEGUNDO APELLIDO</td>
						<td width="10%" class="titulos2">PRIMER NOMBRE</td>
						<td width="10%" class="titulos2">SEGUNDO NOMBRE</td>
						<td width="4%" class="titulos2">DOCUMENTO</td>
						<td width="3%" class="titulos2">Editar</td>          
					</tr>';
		
				$con=1;
				$iter='saludo1a';
				$iter2='saludo2';
				$filas=1;
				while ($row =mysql_fetch_row($resp))
				{
					$con2=$con+ $_POST[numpos];
					if($gidcta!="")
					{
						if($gidcta==$row[0]){$estilo='background-color:yellow';}
						else{$estilo="";}
					}
					else{$estilo="";}	
					$idcta="'".$row[0]."'";
					$numfil="'".$filas."'";
					$filtro="'".$_POST[nombre]."'";
					echo"
					<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
			onMouseOut=\"this.style.backgroundColor=anterior\" onDblClick=\"verUltimaPos($idcta, $numfil, $filtro)\" style='text-transform:uppercase; $estilo'>
			 			<td>$con2</td>
						<td>$row[5]</td>
						<td>$row[3]</td>
						<td>$row[4]</td>
						<td>$row[1]</td>
						<td>$row[2]</td>
						<td>$row[12]</td>";
					$idcta="'".$row[0]."'";
					$numfil="'".$filas."'";
					echo"
						<td style='text-align:center;'>
							<a onClick=\"verUltimaPos($idcta, $numfil, $filtro)\" style='cursor:pointer;'><img src='imagenes/b_edit.png' style='width:18px' title='Editar'></a>
						</td>
					</tr>";
	 				$con+=1;
					$aux=$iter;
					$iter=$iter2;
					$iter2=$aux;
					$filas++;
					?>
					 <input type="hidden" name="item[]" id="item[]" value="<?php echo $con2;?>"/>
					  <input type="hidden" name="ra[]" id="ra[]" value="<?php echo $row[5];?>"/>
					<input type="hidden" name="nom[]" id="nom[]" value="<?php echo $row[3];?>"/>
					<input type="hidden" name="ap[]" id="ap[]" value="<?php echo $row[4];?>"/>
					<input type="hidden" name="nom1[]" id="nom1[]" value="<?php echo $row[1];?>"/>
					<input type="hidden" name="ap1[]" id="ap1[]" value="<?php echo $row[2];?>"/>
						<input type="hidden" name="doc[]" id="doc[]" value="<?php echo $row[12];?>"/>
					<?php
					
					
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
<input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>"/>
</form>

</body>
</html>