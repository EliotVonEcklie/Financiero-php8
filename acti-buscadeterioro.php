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
		<title>:: Spid - Control de Activos</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
        <script type="text/javascript" src="css/programas.js"></script>
		<script>
			function verUltimaPos(idcta, filas, grupo){
				var scrtop=$('#divdet').scrollTop();
				var altura=$('#divdet').height();
				var numpag=$('#nummul').val();
				var limreg=$('#numres').val();
				if((numpag<=0)||(numpag==""))
					numpag=0;
				if((limreg==0)||(limreg==""))
					limreg=10;
				numpag++;
				location.href="acti-editadeterioro.php?idproceso="+grupo+"&scrtop="+scrtop+"&totreg="+filas+"&altura="+altura+"&numpag="+numpag+"&limreg="+limreg+"&clase="+idcta;
			}
		</script>
		<script>
			function cambioswitch(id1,id2,valor)
			{
				document.getElementById('idestado1').value=id1;
				document.getElementById('idestado2').value=id2;
				if(valor==1){
					despliegamodalm('visible','4','Desea activar este Activo','1');
				}else{
					despliegamodalm('visible','4','Desea Desactivar este Activo','2');
				}
			}
            function eliminar_inf(codigo)
            {
				document.getElementById('iddel').value=codigo;
				//despliegamodalm('visible','4','Esta Seguro de Eliminar la Modalidad de Contratación','1');
            }
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventanam').src="";}
				else
				{
					switch(_tip)
					{
						case "1":
							document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
						case "2":
							document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
						case "3":
							document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
						case "4":
							document.getElementById('ventanam').src="ventana-consulta2.php?titulos="+mensa+"&idresp="+pregunta;break;	
					}
				}
			}
			function funcionmensaje(){document.location.href = "acti-creaciondeterioro.php";}
			
		</script>

		<script type="text/javascript">
			function iratras(){
				location.href="acti-concecontables.php";
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
			$_POST[modalidad]=$_GET['filtro'];
		?>
	</head>
	<body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
		<table>
    		<tr><script>barra_imagenes("acti");</script><?php cuadro_titulos();?></tr>	 
    		<tr><?php menu_desplegable("acti");?></tr>
			<tr>
  				<td colspan="3" class="cinta">
	  				<a href="acti-creaciondeterioro.php" class="mgbt"><img src="imagenes/add.png"  title="Nuevo" border="0" /></a>
	  				<a class="mgbt"><img src="imagenes/guardad.png"/></a>
	  				<a href="#" onClick="document.form2.submit();" class="mgbt"><img src="imagenes/busca.png"  title="Buscar" border="0" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
	  				<a href="#" onClick="mypop=window.open('acti-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a>
	  				<a onclick="iratras()" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
  				</td>
			</tr>
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>	
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
 		<form name="form2" method="post" action="acti-buscadeterioro.php">
        	
     		<input type="hidden" name="oculto" id="oculto" value="1"/>
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
    		<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
       		<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
            <input type="hidden" name="idestado1" id="idestado1" value="<?php echo $_POST[idestado1];?>">
            <input type="hidden" name="idestado2" id="idestado2" value="<?php echo $_POST[idestado2];?>">
        	<input type="hidden" name="ocudel" id="ocudel" value="<?php echo $_POST[ocudel]?>">
        	<input type="hidden" name="iddel" id="iddel" value="<?php echo $_POST[iddel]?>">
    		<div class="subpantallac5" style="height:68.5%; width:99.6%; overflow-x:hidden;" id="divdet">
			<?php 
				
				$oculto=$_POST['oculto'];
				//if($_POST[oculto])
				{
					$crit1=" ";
					$crit2=" ";

					$sqlr="SELECT * FROM acti_deterioro_cab WHERE estado='S'";
					$resp = mysql_query($sqlr,$linkbd);		
					$_POST[numtop]=mysql_num_rows($resp);
					$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);

					$cond2="";
					if ($_POST[numres]!="-1"){ 
						$cond2="LIMIT $_POST[numpos], $_POST[numres]"; 
					}
					$sqlr="SELECT * FROM acti_deterioro_cab WHERE estado='S' ORDER BY id";
					$resp = mysql_query($sqlr,$linkbd);
					$numcontrol=$_POST[nummul]+1;
					
					$con=1;
					echo "
					<table class='inicio' align='center' width='100%'>
						<tr>
							<td colspan='2' class='titulos'>.: Resultados Busqueda:</td>
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
							<td colspan='3'>Encontrados: $_POST[numtop]</td>
						</tr>
						<tr>
							<td class='titulos2' style=\"width:5%\">Item</td>
							<td class='titulos2' style=\"width:80%\">Nombre</td>
							<td class='titulos2' style=\"width:5%\">Editar</td>							
						</tr>";
					$iter='saludo1a';
					$iter2='saludo2';
					$filas=1;
					while ($row =mysql_fetch_row($resp)) 
					{
						
						$idcta="'".$row[0]."'";
						$numfil="'".$filas."'";
						$filtro="'".$_POST[modalidad]."'";

						$estilo2="";
						if ($_GET[idcta]==$row[0]) {
							$estilo2="background-color: yellow;";
						}

						echo"<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
								onMouseOut=\"this.style.backgroundColor=anterior\" onDblClick=\"verUltimaPos($idcta, $numfil, $row[0])\" style='text-transform:uppercase; $estilo2 $estilo' >
								<td>$row[0]</td>
								<td>$row[1]</td>
								";		
								$idcta="'".$row[0]."'";
								$numfil="'".$filas."'";
								echo"<td style='text-align:center;'>
									<a onClick=\"verUltimaPos($idcta, $numfil, $row[0])\" style='cursor:pointer;'>
										<img src='imagenes/b_edit.png' style='width:18px' title='Editar'>
									</a>
								</td>
							</tr>";
						
						$con+=1;
						$aux=$iter;
						$iter=$iter2;
				 		$iter2=$aux;
						$filas++;
					}
					if ($_POST[numtop]==0)
					{
						echo "
						<table class='inicio'>
							<tr>
								<td class='saludo1' style='text-align:center;width:100%'><img src='imagenes\alert.png' style='width:25px'>No hay coincidencias en la b&uacute;squeda<img src='imagenes\alert.png' style='width:25px'></td>
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
					
					if($nuncilumnas<=9){
						$numfin=$nuncilumnas;
					} else{
						$numfin=9;
					}

					for($xx = 1; $xx <= $numfin; $xx++)
					{
						if($numcontrol<=9){
							$numx=$xx;
						} else{
							$numx=$xx+($numcontrol-9);
						}
						
						if($numcontrol==$numx){
							echo"<a href='#' onClick='saltocol(\"$numx\")'; style='color:#24D915'> $numx </a>";
						} else {
							echo"<a href='#' onClick='saltocol(\"$numx\")'; style='color:#000000'> $numx </a>";
						}
					}
					echo"			&nbsp;&nbsp;<a href='#'>$imagenforward</a>
									&nbsp;<a href='#'>$imagensforward</a>
								</td>
							</tr>
						</table>";
				}
			?>
			</div>
            <input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>" />
		</form>
	</body>
</html>