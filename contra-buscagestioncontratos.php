<?php //V 1000 12/12/16 ?> 
<?php
	error_reporting(0);
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
		<title>:: Spid - Contratacion</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script>
        	function cambioswitch(id,valor)
			{
				document.getElementById('idestado').value=id;
				if(valor==1){despliegamodalm('visible','4','Desea Activar este Proceso de Contrato','1');}
				else{despliegamodalm('visible','4','Desea Desactivar este Proceso de Contrato','2');}
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
			function pasar(proceso){
				window.location.href='contra-editagestioncontratos.php?idproceso='+proceso;
			}
        </script>
	<?php titlepag();?>
	</head>
	<body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("contra");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("contra");?></tr>
            <tr>
  				<td colspan="3" class="cinta">
					<a onClick="location.href='contra-gestioncontratos.php'" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
					<a class="mgbt1"><img src="imagenes/guardad.png"/></a>
					<a onClick="document.form2.submit()" class="mgbt"><img src="imagenes/busca.png" title="Buscar" border="0" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a onClick="<?php echo paginasnuevas("contra");?>" class="mgbt"><img src="imagenes/nv.png" title="Nueva ventana"></a>
					<a id="impre" class="mgbt"><img src="imagenes/print_off.png" title="Imprimir" style="width:30px;"/></a>
				</td>
        	</tr>
     	</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>	
 		<form name="form2" method="post" action="contra-buscagestioncontratos.php">
        	<?php
        		if($_POST[oculto]=="")
				{
					$_POST[numpos]=0;$_POST[numres]=10;$_POST[nummul]=0;
					$_POST[cambioestado]="";$_POST[nocambioestado]="";
				}
				if($_POST[cambioestado]!="")
				{
					if($_POST[cambioestado]=="1")
					{
						$sqlr="UPDATE contraprocesos SET estado='S' WHERE codsolicitud='$_POST[idestado]'";
						mysql_fetch_row(mysql_query($sqlr,$linkbd)); 
					}
					else 
					{
						$sqlr="UPDATE contraprocesos SET estado='N' WHERE codsolicitud='$_POST[idestado]'";
						mysql_fetch_row(mysql_query($sqlr,$linkbd)); 
					}
					echo"<script>document.form2.cambioestado.value=''</script>";
					$_POST[cambioestado]='';
				}
				//*****************************************************************
				if($_POST[nocambioestado]!="")
				{
					if($_POST[nocambioestado]=="1"){$_POST[lswitch1][$_POST[idestado]]=1;}
					else {$_POST[lswitch1][$_POST[idestado]]=0;}
					echo"<script>document.form2.nocambioestado.value=''</script>";
					$_POST[nocambioestado]='';
				}
			?>
            <table  class="inicio" align="center" >
                <tr>
                    <td class="titulos" colspan="4">:: Buscar Procesos de Contratacion </td>
                    <td class="cerrar" style="width:7%;"><a onClick="location.href='contra-principal.php'">&nbsp;Cerrar</a></td>
                </tr>
                <tr>
                    <td class="saludo1" style="width:4cm;">N&deg; Proceso o de Contrato:</td>
                    <td style="width:15%;"><input type="search" name="numerodc" id="numerodc" value="<?php echo $_POST[numerodc];?>" style="width:95%;"></td>
                    <td class="saludo1" style="width:2cm;">Descripci&oacute;n:</td>
                    <td>
                    	<input type="search" name="ndescrip" id="ndescrip" value="<?php echo $_POST[ndescrip];?>" style="width:50%">&nbsp;
                        <input type="button" name="bboton" onClick="limbusquedas();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" />
                    </td>
                </tr>                       
            </table>
            <input type="hidden" name="oculto" id="oculto" value="1">
            <input type="hidden" name="cambioestado" id="cambioestado" value="<?php echo $_POST[cambioestado];?>">
            <input type="hidden" name="nocambioestado" id="nocambioestado" value="<?php echo $_POST[nocambioestado];?>">
            <input type="hidden" name="idestado" id="idestado" value="<?php echo $_POST[idestado];?>">
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
            <input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
            <input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
    		<div class="subpantallac5" style="height:68.5%;overflow-x:hidden;">
    		<?php 
				$crit1="";
				$crit2="";
				$tibusqueda="";
				if ($_POST[numerodc]!=""){$crit1="WHERE concat_ws(' ', idproceso,contrato) LIKE '%$_POST[numerodc]%'";}
				if ($_POST[ndescrip]!="")
				{
					if ($crit1==""){$crit2=" WHERE objeto LIKE '%$_POST[ndescrip]%'";}
					else{$crit2=" AND objeto LIKE '%$_POST[ndescrip]%'";}
				}
				$sqlr="SELECT * FROM contraprocesos $crit1 $crit2";
				$resp = mysql_query($sqlr,$linkbd);
				$_POST[numtop]=mysql_num_rows($resp);
				$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
				$cond2="";
				if ($_POST[numres]!="-1"){$cond2="LIMIT $_POST[numpos], $_POST[numres]";}
				$sqlr="SELECT * FROM contraprocesos $crit1 $crit2 ORDER BY idproceso ASC $cond2";
				$resp = mysql_query($sqlr,$linkbd);
				$con=1;
				$numcontrol=$_POST[nummul]+1;
				if(($nuncilumnas==$numcontrol)||($_POST[numres]=="-1"))
				{
					$imagenforward="<img src='imagenes/forward02.png' style='width:17px;cursor:default;'/>";
					$imagensforward="<img src='imagenes/skip_forward02.png' style='width:16px;cursor:default;'/>";
				}
				else 
				{
					$imagenforward="<img src='imagenes/forward01.png' style='width:17px;cursor:pointer;' title='Siguiente' onClick='numsiguiente()'/>";
					$imagensforward="<img src='imagenes/skip_forward01.png' style='width:16px;cursor:pointer;' title='Fin' onClick='saltocol(\"$nuncilumnas\")'/>";
				}
				if(($_POST[numpos]==0)||($_POST[numres]=="-1"))
				{
					$imagenback="<img src='imagenes/back02.png' style='width:17px;cursor:default;'/>";
					$imagensback="<img src='imagenes/skip_back02.png' style='width:16px;cursor:default;'/>";
				}
				else
				{
					$imagenback="<img src='imagenes/back01.png' style='width:17px;cursor:pointer;' title='Anterior' onClick='numanterior();'/>";
					$imagensback="<img src='imagenes/skip_back01.png' style='width:16px;cursor:pointer;' title='Inicio' onClick='saltocol(\"1\")'/>";
				}
				echo "
				<table class='inicio' align='center' width='80%'>
					<tr>
						<td colspan='13' class='titulos'>.: Resultados Busqueda:</td>
						<td class='submenu' colspan='2' style='width:7%'>
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
					<tr class='saludo3'>
						<td colspan='14'>Encontrados: $_POST[numtop]</td>
					</tr>
					<tr>
						<td class='titulos2' style='width:4%' rowspan='2'>Proceso</td>
						<td class='titulos2' style='width:6%' rowspan='2'>Fecha</td>
						<td class='titulos2' style='width:4%' rowspan='2'>Vigencia</td>
						<td class='titulos2' style='width:41%' rowspan='2'>Objeto</td>
						<td class='titulos2' style='width:8%' rowspan='2'>Modalidad</td>
						<td class='titulos2' style='width:8%' rowspan='2'>Procedimiento</td>
						<td class='titulos2' style='width:8%' rowspan='2'>Tipo Contrato</td>
						<td class='titulos2' style='width:5%' rowspan='2'>No Contrato</td>
						<td class='titulos2' style='width:10%; text-align:center;' colspan='4'>Fase Actual</td>
						<td class='titulos2' style='width:5%' rowspan='2' colspan='2'>Estado</td>
						<td class='titulos2' style='width:3%' rowspan='2'>EDITAR</td>
					</tr>
					<tr>
						<td class='titulos2' title='Datos Precontractuales'>DP</td>
						<td class='titulos2' title='Anexos Precontractuales'>AP</td>
						<td class='titulos2' title='Datos Contrataci&oacute;n'>DC</td>
						<td class='titulos2' title='Anexos Contrataci&oacute;n'>AC</td>
					</tr>";	
				$iter='saludo1a';
				$iter2='saludo2';
				while ($row =mysql_fetch_row($resp)) 
				{	
					switch($row[11])
					{
						case 'S':	$tiest='Activo';
									$imgsem="src='imagenes/sema_verdeON.jpg' title='$tiest'";
									$coloracti="#0F0";
									$_POST[lswitch1][$row[0]]=0;
									$abilitado="";
									break;
						case 'A':	$tiest='Ligado a Solicitud';
									$imgsem="src='imagenes/sema_azulON.jpg' title='$tiest'";
									$coloracti="#4398FF";
									$_POST[lswitch1][$row[0]]=0;
									$abilitado="disabled";
									break;
						case 'N':	$tiest='Inactivo';
									$imgsem="src='imagenes/sema_rojoON.jpg' title='$tiest'";
									$coloracti="#C00";
									$_POST[lswitch1][$row[0]]=1;
									$abilitado="";
					}
					$modalidad= buscar_dominio('MODALIDAD_SELECCION',$row[4],'','S','DESCRIPCION_VALOR');
					$smodalidad= buscar_dominio('MODALIDAD_SELECCION',$row[5],$row[4],'S','DESCRIPCION_VALOR');
					$sqlrcl="SELECT nombre FROM contraclasecontratos where id='$row[6]'";
					$rowcl =mysql_fetch_row(mysql_query($sqlrcl,$linkbd));
					$sqlrsf="SELECT * FROM contraestadosemf where idcontrato='$row[0]'";
					$rowsf =mysql_fetch_row(mysql_query($sqlrsf,$linkbd));
					$cmrojo="src='imagenes/sema_rojoON.jpg'";
					$cmamarillo="src='imagenes/sema_amarilloON.jpg' title='Informaci&oacute;n Incompleta'";
					$cmverde="src='imagenes/sema_verdeON.jpg' title='Informaci&oacute;n Completa'";
					$cmamarilloa="src='imagenes/sema_amarilloON.jpg' title='Anexos Incompletos'";
					$cmverdea="src='imagenes/sema_verdeON.jpg' title='Anexos Completos'";
					for($xy=1;$xy<=4;$xy++)
					{
						if (($xy==1 )||($xy==3))
						{
							switch($rowsf[$xy])
							{
								case "0":
									$csemf[$xy]=$cmrojo;
									break;
								case "1":
								case "2":
									$csemf[$xy]=$cmamarillo;
									break;
								case "3":
									$csemf[$xy]=$cmverde;
									break;
							}
						}
						else
						{
							switch($rowsf[$xy])
							{
								case "0":
									$csemf[$xy]=$cmrojo;
									break;
								case "1":
									$csemf[$xy]=$cmamarilloa;
									break;
								case "2":
									$csemf[$xy]=$cmverdea;
									break;
							}
						}
					}
					echo "
						<tr class='$iter' onDblClick='pasar($row[0])'>	
							<td>$row[0]</td>
							<td>".date("d-m-Y",strtotime($row[1]))."</td>
							<td>$row[2]</td>
							<td>$row[3]</td>
							<td>$modalidad</td>
							<td>$smodalidad</td>
							<td>".ucwords(strtolower($rowcl[0]))."</td>
							<td>$row[8]</td>
							<td style='text-align:center;'><img $csemf[1] style='width:20px'/></td>
							<td style='text-align:center;'><img $csemf[2] style='width:20px'/></td>
							<td style='text-align:center;'><img $csemf[3] style='width:20px'/></td>
							<td style='text-align:center;'><img $csemf[4] style='width:20px'/></td>
							<td style='text-align:center;'><img $imgsem style='width:20px'/></td>
							<td ><input type='range' name='lswitch1[]' value='".$_POST[lswitch1][$row[0]]."' min ='0' max='1' step ='1' style='background:$coloracti; width:60%' onChange='alert();cambioswitch(\"$row[0]\",\"".$_POST[lswitch1][$row[0]]."\")' Title='$tiest' $abilitado /></td>
							<td><a href='contra-editagestioncontratos.php?idproceso=$row[0]'><center><img src='imagenes/b_edit.png'></center></a></td>
						</tr>";
					 $con+=1;
					 $aux=$iter;
					 $iter=$iter2;
					 $iter2=$aux;
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
									<a>$imagensback</a>&nbsp;
									<a>$imagenback</a>&nbsp;&nbsp;";
					if($nuncilumnas<=9){$numfin=$nuncilumnas;}
					else{$numfin=9;}
					for($xx = 1; $xx <= $numfin; $xx++)
					{
						if($numcontrol<=9){$numx=$xx;}
						else{$numx=$xx+($numcontrol-9);}
						if($numcontrol==$numx){echo"<a  onClick='saltocol(\"$numx\")'; style='color:#24D915;cursor:pointer;'> $numx </a>";}
						else {echo"<a onClick='saltocol(\"$numx\")'; style='color:#000000;cursor:pointer;'> $numx </a>";}
					}
					echo"			&nbsp;&nbsp;<a>$imagenforward</a>
									&nbsp;<a>$imagensforward</a>
								</td>
							</tr>
						</table>";
				?>
        	</div>
       		<input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>" />
		</form>
	</body>
</html>