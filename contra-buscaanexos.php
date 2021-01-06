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
		<title>:: Spid - Contrataci&oacute;n</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
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
				location.href="contra-editaanexos.php?idproceso="+idcta+"&scrtop="+scrtop+"&totreg="+filas+"&altura="+altura+"&numpag="+numpag+"&limreg="+limreg;
			}
		</script>
		<script>
			function cambioswitch(id,valor)
			{
				document.getElementById('idestado').value=id;
				if(valor==1){despliegamodalm('visible','4','Desea Desactivar esta Normativa','1');}
				else{despliegamodalm('visible','4','Desea activar esta Normativa','2');}
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
			function funcionmensaje(){document.location.href = "contra-anexos.php";}
			function respuestaconsulta(estado,pregunta)
			{
				if(estado=="S")
				{
					switch(pregunta)
					{
						case "1":	document.form2.cambioestado.value="1";break;
						case "2":	document.form2.cambioestado.value="0";break;
					}
				}
				else
				{
					switch(pregunta)
					{
						case "1":	document.form2.nocambioestado.value="1";break;
						case "2":	document.form2.nocambioestado.value="0";break;
					}
				}
				document.form2.submit();
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
		?>
	</head>
	<body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
		<table>
            <tr><script>barra_imagenes("contra");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("contra");?></tr>
        	<tr>
  				<td colspan="3" class="cinta">
					<a href="contra-anexos.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
					<a class="mgbt"><img src="imagenes/guardad.png"/></a>
					<a href="#" onClick="document.form2.submit()" class="mgbt"><img src="imagenes/busca.png"  title="Buscar"/></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('contra-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
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
 		<form name="form2" method="post" action="contra-buscaanexos.php">
 		<?php
			if($_POST[oculto2]==""){$_POST[oculto2]="0";$_POST[cambioestado]="";$_POST[nocambioestado]="";}
			//*****************************************************************
			if($_POST[cambioestado]!="")
			{
				if($_POST[cambioestado]=="1")
				{
					$sqlr="UPDATE contraanexos SET estado='S' WHERE id='$_POST[idestado]'";
					mysql_fetch_row(mysql_query($sqlr,$linkbd)); 
				}
				else 
				{
					$sqlr="UPDATE contraanexos SET estado='N' WHERE id='$_POST[idestado]'";
					mysql_fetch_row(mysql_query($sqlr,$linkbd)); 
				}
				echo"<script>document.form2.cambioestado.value=''</script>";
			}
			//*****************************************************************
			if($_POST[nocambioestado]!="")
			{
				if($_POST[nocambioestado]=="1"){$_POST[lswitch1][$_POST[idestado]]=1;}
				else {$_POST[lswitch1][$_POST[idestado]]=0;}
				echo"<script>document.form2.nocambioestado.value=''</script>";
			}
		?>
			<table  class="inicio" align="center" >
				<tr>
                    <td class="titulos" colspan="4">:: Buscar Anexos </td>
                   <td class="cerrar" style="width:7%;"><a onClick="location.href='contra-principal.php'">&nbsp;Cerrar</a></td>
      			</tr>
      			<tr>
        			<td style='width:4cm' class="saludo1">C&oacute;digo o Nombre:</td>
                    <td>
                    	<input type="text" name="nombre" id="nombre" value="<?php echo $_POST[nombre];?>" style='width:50%'/>
                    	<input type="button" name="bboton" onClick="limbusquedas();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" />
                    </td>
       			</tr>                       
    		</table>
            <input type="hidden" name="oculto" id="oculto" value="1">
            <input type="hidden" name="oculto2" id="oculto2" value="<?php echo $_POST[oculto2];?>">
            <input type="hidden" name="cambioestado" id="cambioestado" value="<?php echo $_POST[cambioestado];?>">
            <input type="hidden" name="nocambioestado" id="nocambioestado" value="<?php echo $_POST[nocambioestado];?>">
            <input type="hidden" name="idestado" id="idestado" value="<?php echo $_POST[idestado];?>">
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
            <input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
            <input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
    		<div class="subpantallac5" style="height:68.5%; width:99.6%; overflow-x:hidden;" id="divdet">
     		<?php
				//if($_POST[oculto])
				{
					$crit1="";
					if ($_POST[nombre]!=""){$crit1="WHERE concat_ws(' ', id, nombre) LIKE '%$_POST[nombre]%'";}
					$sqlr="SELECT * FROM contraanexos $crit1 ";
					$resp = mysql_query($sqlr,$linkbd);
					$_POST[numtop]=mysql_num_rows($resp);
					$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);

					$cond2="";
					if ($_POST[numres]!="-1"){ 
						$cond2="LIMIT $_POST[numpos], $_POST[numres]"; 
					}
					$sqlr="SELECT * FROM contraanexos $crit1 ORDER BY id ".$cond2;
					$resp = mysql_query($sqlr,$linkbd);
					$con=1;
					$numcontrol=$_POST[nummul]+1;
					if($nuncilumnas==$numcontrol)
					{
						$imagenforward="<img src='imagenes/forward02.png' style='width:17px'>";
						$imagensforward="<img src='imagenes/skip_forward02.png' style='width:16px' >";
					}
					else 
					{
						$imagenforward="<img src='imagenes/forward01.png' style='width:17px' title='Siguiente' onClick='numsiguiente()'>";
						$imagensforward="<img src='imagenes/skip_forward01.png' style='width:16px' title='Fin' onClick='saltocol(\"$nuncilumnas\")'>";
					}
					if($_POST[numpos]==0)
					{
						$imagenback="<img src='imagenes/back02.png' style='width:17px'>";
						$imagensback="<img src='imagenes/skip_back02.png' style='width:16px'>";
					}
					else
					{
						$imagenback="<img src='imagenes/back01.png' style='width:17px' title='Anterior' onClick='numanterior();'>";
						$imagensback="<img src='imagenes/skip_back01.png' style='width:16px' title='Inicio' onClick='saltocol(\"1\")'>";
					}
					echo "
					<table class='inicio' align='center' width='80%'>
						<tr>
							<td colspan='5' class='titulos'>.: Resultados Busqueda:</td>
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
						<tr><td colspan='7'>Encontrados: $_POST[numtop]</td></tr>
						<tr>
							<td width='5%' class='titulos2'>Codigo</td>
							<td class='titulos2'>Nombre</td>
							<td class='titulos2'>Tipo</td>
							<td class='titulos2' colspan='2' width='5%'>ESTADO</td>
							<td class='titulos2' width='5%'>EDITAR</td>
						</tr>";	
					$iter='saludo1a';
					$iter2='saludo2';
					$filas=1;
					while ($row =mysql_fetch_row($resp)) 
 					{
						$con2=$con+ $_POST[numpos];
	 					$sqlr="SELECT * FROM dominios where nombre_dominio='CONTRATACION_ANEXOS' and valor_inicial='$row[4]'";
						$res=mysql_query($sqlr,$linkbd);
						$rowEmp = mysql_fetch_row($res);
						$tipo=$rowEmp[1];
						$abilitado="";
						if($row[2]=='S'){$imgsem="src='imagenes/sema_verdeON.jpg' title='Activo'";$coloracti="#0F0";$_POST[lswitch1][$row[0]]=0;}
						else{$imgsem="src='imagenes/sema_rojoON.jpg' title='Inactivo'";$coloracti="#C00";$_POST[lswitch1][$row[0]]=1;}
						if ($row[3]=="S"){$mosedita="<img src='imagenes/candado.png' style='width:18px' title='No Editable'>"; $abilitado="disabled";}
						else{$mosedita="<a href='contra-editaanexos.php?idproceso=$row[0]'><img src='imagenes/b_edit.png' style='width:18px' title='Editar'></a>";}
						if($gidcta!=""){
							if($gidcta==$row[0]){
								$estilo='background-color:yellow';
							}
							else{
								$estilo="";
							}
						}
						else{
							$estilo="";
						}	
						if ($row[3]!="S"){
							$idcta="'".$row[0]."'";
							$numfil="'".$filas."'";
							$dblclic="onDblClick=\"verUltimaPos($idcta, $numfil)\" ";
						}
						else{
							$dblclic="";
						}
						echo"<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
			onMouseOut=\"this.style.backgroundColor=anterior\" $dblclic style='text-transform:uppercase; $estilo' >
							<td>$row[0]</td>
							<td>$row[1]</td>
							<td>$tipo </td>
							<td style='text-align:center;'><img $imgsem style='width:20px'/></td>
							<td><input type='range' name='lswitch1[]' value='".$_POST[lswitch1][$row[0]]."' min ='0' max='1' step ='1' style='background:$coloracti; width:60%' onChange='cambioswitch(\"".$row[0]."\",\"".$_POST[lswitch1][$row[0]]."\")' $abilitado /></td>";
							if ($row[3]=="S"){
								echo"<td style='text-align:center;'>$mosedita</td>";
							}
							else{
								$idcta="'".$row[0]."'";
								$numfil="'".$filas."'";
								echo"<td style='text-align:center;'>
									<a onClick=\"verUltimaPos($idcta, $numfil)\" style='cursor:pointer;'>
										<img src='imagenes/b_edit.png' style='width:18px' title='Editar'>
									</a>
								</td>";
							}
						echo"</tr>";
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
				}
			?>
			</div>
            <input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>" />
		</form>
	</body>
</html>