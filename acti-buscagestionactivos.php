<?php //V 1001 17/12/2016 ?>
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
			function verUltimaPos(idcta, filas){
				var scrtop=$('#divdet').scrollTop();
				var altura=$('#divdet').height();
				var numpag=$('#nummul').val();
				var limreg=$('#numres').val();
				if((numpag<=0)||(numpag==""))
					numpag=0;
				if((limreg==0)||(limreg==""))
					limreg=10;
				numpag++;
				location.href="acti-editargestionactivos.php?scrtop="+scrtop+"&totreg="+filas+"&altura="+altura+"&numpag="+numpag+"&limreg="+limreg+"&clase="+idcta+"&chk=1";
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
			function iratras(){document.location.href="acti-gestiondelosactivos.php";}
		</script>
		<?php 
			titlepag();
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
  				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='acti-gestionactivos.php'" class="mgbt"/><img src="imagenes/guardad.png" class="mgbt1"/><img src="imagenes/busca.png" title="Buscar" onClick="document.form2.submit();" class="mgbt"/><img src="imagenes/agenda1.png" title="Agenda" onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"/><img src="imagenes/nv.png" title="nueva ventana"  onClick="mypop=window.open('acti-principal.php','','');mypop.focus();" class="mgbt"/><img src="imagenes/iratras.png" title="Atrás" onclick="iratras()" class="mgbt"/>
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
 		<form name="form2" method="post" action="acti-buscagestionactivos.php">
     		<input type="hidden" name="oculto" id="oculto" value="1"/>
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
    		<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
       		<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
    		<div class="subpantallac5" style="height:68.5%; width:99.6%; overflow-x:hidden;" id="divdet">
			<?php 
				$crit1=" ";
				$crit2=" ";
				$sqlr="SELECT T1.codigo FROM acticrearact_det T1 INNER JOIN acticrearact T2 ON T1.codigo = T2.codigo AND T2.tipo_mov='101'";
				$resp = mysql_query($sqlr,$linkbd);		
				$_POST[numtop]=mysql_num_rows($resp);
				$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
				if ($_POST[numres]!="-1"){$cond2="LIMIT $_POST[numpos], $_POST[numres]";}
				else{$cond2="";}
				$sqlr="SELECT T2.codigo,T2.fechareg,T2.origen,T2.documento,T1.placa,T1.nombre,T1.valor,T2.estado FROM acticrearact_det T1 INNER JOIN acticrearact T2 ON T1.codigo = T2.codigo AND T2.tipo_mov='101' ORDER BY T2.codigo DESC $cond2";
				$resp = mysql_query($sqlr,$linkbd);
				$numcontrol=$_POST[nummul]+1;
				$con=1;
				echo "
				<table class='inicio' align='center' width='100%'>
					<tr>
						<td colspan='11' class='titulos'>.: Resultados Busqueda:</td>
						<td colspan='12' class='submenu'>
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
						<td colspan='12'>Encontrados: $_POST[numtop]</td>
					</tr>
					<tr>
						<td class='titulos2' style=\"width:5%\">Orden</td>
						<td class='titulos2' style='width:8%'>Fecha</td>
						<td class='titulos2'>Origen</td>
						<td class='titulos2' style=\"width:5%\">Documento</td>
						<td class='titulos2'>Placa</td>
						<td class='titulos2'>Nombre</td>
						<td class='titulos2'>Clase</td>
						<td class='titulos2'>Grupo</td>
						<td class='titulos2'>Tipo</td>
						<td class='titulos2' style='width:12%'>Valor</td>
						<td class='titulos2' style='width:4%'>Estado</td>	
						<td class='titulos2' style='width:4%'>Editar</td>							
					</tr>";
				$iter='saludo1a';
				$iter2='saludo2';
				$filas=1;
				while ($row =mysql_fetch_row($resp)) 
				{
					$estilo2="";
					if ($_GET[idcta]==$row[0]) {
						$estilo2="background-color: yellow;";
					}
					$idcta="'$row[0]'";
					$numfil="'$filas'";
					$fecha01=date('d-m-Y',strtotime($row[1]));
					$sqlb="Select nombre from acti_tipomov where estado='S' and codigo='$row[2]' and tipom=1 ";
					$resb=mysql_query($sqlb,$linkbd);
					$worg =mysql_fetch_row($resb);
					$origen="$row[2] $worg[0]";
					$clase=substr($row[4],0,1);
					$nivel1=substr($row[4],1,2);
					$nivel2=substr($row[4],3,3);
					$sqlclase = "SELECT nombre FROM actipo where codigo='$clase' ";
					$resclase = mysql_query($sqlclase,$linkbd);
					$rwclase = mysql_fetch_row($resclase);
					$sqlgrupo = "SELECT nombre FROM actipo where codigo='$nivel1' and niveluno='$clase' ";
					$resgrupo = mysql_query($sqlgrupo,$linkbd);
					$rwgrupo = mysql_fetch_row($resgrupo);
					$sqltipo = "SELECT nombre FROM actipo where codigo='$nivel2' and niveluno='$nivel1' AND niveldos='$clase' ";
					$restipo = mysql_query($sqltipo,$linkbd);
					$rwtipo = mysql_fetch_row($restipo);
					$valor=number_format($row[6],2,',','.');
					echo"
					<tr class='$iter' onDblClick=\"verUltimaPos($idcta, $numfil)\" style='text-transform:uppercase; $estilo2' >
						<td>$row[0]</td>
						<td>$fecha01</td>
						<td>$origen</td>
						<td>$row[3]</td>
						<td>$row[4]</td>
						<td>$row[5]</td>
						<td>$rwclase[0]</td>
						<td>$rwgrupo[0]</td>
						<td>$rwtipo[0]</td>
						<td style='text-align:right;'>$valor</td>";
							switch ($row[7]) 
							{
								case "S":	echo "<td ><center><img src='imagenes/confirm.png'></center></td>";break;
								case "R":	echo "<td ><center><img src='imagenes/reversado.png' style='width:18px'></center></td>";break;
							}		
							echo"<td style='text-align:center;'>
								<a onClick=\"verUltimaPos($idcta, $numfil)\" style='cursor:pointer;'>
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
				
				if($nuncilumnas<=9){$numfin=$nuncilumnas;} 
				else{$numfin=9;}
				for($xx = 1; $xx <= $numfin; $xx++)
				{
					if($numcontrol<=9){$numx=$xx;} 
					else{$numx=$xx+($numcontrol-9);}
					if($numcontrol==$numx){echo"<a href='#' onClick='saltocol(\"$numx\")'; style='color:#24D915'> $numx </a>";} 
					else {echo"<a href='#' onClick='saltocol(\"$numx\")'; style='color:#000000'> $numx </a>";}
				}
				echo"			&nbsp;&nbsp;<a href='#'>$imagenforward</a>
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