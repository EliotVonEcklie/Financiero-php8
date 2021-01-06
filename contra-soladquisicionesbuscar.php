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
		<title>:: Spid - Almacen</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="botones.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
		<script>
			function redireccion(paa){
				window.location.href='contra-soladquisicionesindexed.php?ind=2&codid='+paa; 
			}
			function pdf()
			{
				document.form2.action="contra-plancomprasbuscarpdf.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function cambioswitch(id,valor)
			{
				document.getElementById('idestado').value=id;
				if(valor==1){despliegamodalm('visible','4','Desea Activar esta Solicitud de Adquisiciones','1');}
				else{despliegamodalm('visible','4','Desea Desactivar esta Solicitud de Adquisiciones','2');}
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
		</script>
		<?php titlepag();?>
	</head>
	<body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
    	<table>
            <tr><script>barra_imagenes("inve");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("inve");?></tr>
            <tr>
                <td colspan="3" class="cinta">
					<a onClick="location.href='contra-soladquisicionesindex.php?ind=1'" class="mgbt"><img src="imagenes/add.png"  title="Nuevo"/></a>
					<a><img src="imagenes/guardad.png" class="mgbt1"/></a>
					<a onClick="document.form2.submit()" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a onClick="<?php echo paginasnuevas("inve");?>" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
				</td>
            </tr>
		</table>	
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
 		<form name="form2" method="post" action="contra-soladquisicionesbuscar.php">
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
						$sqlr="UPDATE contrasoladquisiciones SET estado='S' WHERE codsolicitud='$_POST[idestado]'";
						mysql_fetch_row(mysql_query($sqlr,$linkbd)); 
					}
					else 
					{
						$sqlr="UPDATE contrasoladquisiciones SET estado='N' WHERE codsolicitud='$_POST[idestado]'";
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
                    <td class="titulos" colspan="4" >:: Buscar Solicitud de Adquisiciones</td>
                    <td class="cerrar" style="width:7%;"><a onClick="location.href='contra-principal.php'">&nbsp;Cerrar</a></td>
                </tr>
                <tr>
                    <td class="saludo1" style="width:3%">Descripci&oacute;n:</td>
                    <td>
                    
                   		<input type="search" name="descripcion" id="descripcion" value="<?php echo $_POST[descripcion];?>" style="width:50%">
                        <input type="button" name="bboton" onClick="limbusquedas();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" />
                    </td>
                </tr>                       
            </table>
            <input type="hidden" name="oculto" id="oculto" value="1">
    		<input type="hidden" name="iddel" id="iddel" value="<?php echo $_POST[iddel]?>">
            <input type="hidden" name="cambioestado" id="cambioestado" value="<?php echo $_POST[cambioestado];?>">
            <input type="hidden" name="nocambioestado" id="nocambioestado" value="<?php echo $_POST[nocambioestado];?>">
            <input type="hidden" name="idestado" id="idestado" value="<?php echo $_POST[idestado];?>">
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
            <input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
            <input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
            <input type="hidden" name="vigenciactual" id="vigenciactual" value="<?php echo $_POST[vigenciactual];?>">
    		<div class="subpantallac5" style="height:68.5%;overflow-x:hidden;">
				<?php
					if($oculto=="3")
					{
						$sqlr ="DELETE FROM contraplancompras WHERE codplan='$_POST[iddel]'";
						mysql_query($sqlr,$linkbd);
						echo"<script> alert('Se Elimino la Adquisici\xf3n con exito');document.form2.oculto.value='';</script>";
					}
					$crit1=" ";
					if ($_POST[descripcion]!=""){$crit1="WHERE descripcion like '%$_POST[descripcion]%' ";}
					$sqlr="SELECT * FROM contrasoladquisiciones $crit1";
					$resp = mysql_query($sqlr,$linkbd);
					$_POST[numtop]=mysql_num_rows($resp);
					$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
					$cond2="";
					if ($_POST[numres]!="-1"){$cond2="LIMIT $_POST[numpos], $_POST[numres]";}
					$sqlr="SELECT * FROM contrasoladquisiciones $crit1 ORDER BY length(codsolicitud),codsolicitud DESC $cond2";
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
					<table class='inicio' align='center' width='100%'>
						<tr>
							<td colspan='14' class='titulos'>.: Resultados Busqueda:</td>
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
							<td colspan='14'>Total Adquisiciones: $_POST[numtop]</td>
						</tr>
						<tr>
							<td class='titulos2' style='width:4%;'>Codigo</td>
							<td class='titulos2' style='width:6%;'>Fecha</td>
							<td class='titulos2' >Objeto</td>
							<td class='titulos2' style='width:10%;'>Solicitante</td>
							<td class='titulos2' style='width:6%;'>Productos</td>
							<td class='titulos2' style='width:5%;'>Cuenta</td>
							<td class='titulos2' style='width:15%;'>Fuente</td>
							<td class='titulos2' style='width:7%;'>Valor</td>
							<td class='titulos2' style='width:7%;'>Total</td>
							<td class='titulos2' style='width:5%;'>CDP</td>
							<td class='titulos2' style='width:5%;'>liberado</td>
							<td class='titulos2' colspan='2' width='5%'>Estado</td>
							<td class='titulos2' style='width:5%;'>Editar</td>
						</tr>";
					$iter='zebra11';
					$iter2='zebra22';
					$k=0;
					while ($row =mysql_fetch_row($resp)) 
					{
						
						$sqlr2="SELECT * FROM contrasoladquisicionesgastos WHERE estado='S' AND codsolicitud='$row[0]' ORDER BY codsolicitud ASC";
						$resp2 = mysql_query($sqlr2,$linkbd);
						$ntr2 = mysql_num_rows($resp2);
						$row2 =mysql_fetch_row($resp2);
						$comcodigo=str_replace("-"," ",$row[4]);
						$sqlr3="SELECT nombre FROM presuplandesarrollo WHERE codigo='$row2[2]'";//meta
						$res3=mysql_query($sqlr3,$linkbd);
						$row3 =mysql_fetch_row($res3);
						$ind=substr($row2[3],0,1);//fuente
						if ($ind==2){$sqlr4="SELECT nombre FROM pptofutfuentefunc WHERE codigo='$row2[4]'";}
						else{$sqlr4="SELECT nombre FROM pptofutfuenteinv WHERE codigo='$row2[4]'";}
						$res4=mysql_query($sqlr4,$linkbd);
						$row4 =mysql_fetch_row($res4);
						$sqlr5="SELECT nombre FROM planproyectos WHERE consecutivo='$row2[7]'";//PROYECTO
						$row5 =mysql_fetch_row(mysql_query($sqlr5,$linkbd));
						//$dependencia=strtoupper(buscarareatrabajo($row[4]));//dependencia
						$solicitantes=explode("-",$row[3]);
						$solicitante="";
						foreach ($solicitantes as &$valor)
						{
							if($solicitante==""){$solicitante=buscatercero($valor);}
							else{$solicitante=$solicitante."</br>".buscatercero($valor);}
						}
						unset($valor);
						if($row[6]==""){$imgcdp="<a href='#'><img src='imagenes/sema_rojoON.jpg' title='No Solicitado' style='width:21px'></a>";}
						elseif($row[6]=="S" ) {$imgcdp="<a href='#'><img src='imagenes/sema_amarilloON.jpg' title='No Asignado' style='width:21px'></a>";}
						else{$imgcdp="<a href='#'><img src='imagenes/sema_verdeON.jpg' title='$row[6]' style='width:21px'></a>";}
						if($row[7]=="0"){$imglib="<a href='#'><img src='imagenes/del3.png' title='No Liberado' style='width:21px'></a>";}
						else {$imglib="<a href='#'><img src='imagenes/confirm3.png' title='Liberado' style='width:21px'></a>";}
						switch($row[8])
						{
							case 'S':	$tiest='Activo';
										$imgsem="src='imagenes/sema_verdeON.jpg' title='$tiest'";
										$coloracti="#0F0";
										$_POST[lswitch1][$row[0]]=0;
										$mosedita="<a href='contra-soladquisicionesindexed.php?ind=2&codid=$row[0]'><img src='imagenes/b_edit.png' style='width:18px' title='Editar'></a>";
										if($row[7]=="0"){$abilitado="";}
										else{$abilitado="disabled";}
										break;
							case 'A':	$tiest='Ligado a Solicitud';
										$imgsem="src='imagenes/sema_azulON.jpg' title='$tiest'";
										$coloracti="#4398FF";
										$_POST[lswitch1][$row[0]]=0;
										$mosedita="<img src='imagenes/candado.png' style='width:18px' title='No Editable'>"; 
										$abilitado="disabled";
										break;
							case 'N':	$tiest='Inactivo';
										$imgsem="src='imagenes/sema_rojoON.jpg' title='$tiest'";
										$coloracti="#C00";
										$_POST[lswitch1][$row[0]]=1;
										$mosedita="<img src='imagenes/candado.png' style='width:18px' title='No Editable'>"; 
										$abilitado="";
						}
						echo "
							<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor; this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase' onDblClick='redireccion($row[0])' >
								<td >$row[0]</td>
								<td >".date('d-m-Y',strtotime($row[1]))."</td>
								<td style='text-align:justify;'>$row[2]</td>
								<td >$solicitante</td>
								<td >$comcodigo</td>
								<td>$row2[3]</td>
								<td style='text-align:justify;'>$row4[0]</td>
								<td style='text-align:right;'>\$".number_format($row2[5],0,".",",")."</td>
								<td style=\"text-align:right;\">\$".number_format($row[5],0,".",",")."</td>
								<td style='text-align:center;' >$imgcdp</td>
								<td style='text-align:center;' >$imglib</td>
								<td style='text-align:center;'><img $imgsem style='width:20px'/></td>
								<td ><input type='range' name='lswitch1[]' value='".$_POST[lswitch1][$row[0]]."' min ='0' max='1' step ='1' style='background:$coloracti; width:60%' onChange='cambioswitch(\"$row[0]\",\"".$_POST[lswitch1][$row[0]]."\")' Title='$tiest' $abilitado /></td>
								<td style='text-align:center;'>$mosedita</td>
							</tr>";
							$con+=1;
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
							$_POST[adqfuente2][]=$row3[0];
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

