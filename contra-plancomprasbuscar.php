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
		<title>:: Spid - Almacen</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
		<script>
			function redireccion(compro){
				var vigencia=document.getElementById("vigenciactual").value;
				window.location.href='contra-plancompraseditar.php?codid='+compro+'&vigen='+vigencia;
			}
			function pdf()
			{
				document.form2.action="contra-plancompraslistapdf.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function excell()
			{
				document.form2.action="contra-plancompraslistaexcel.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function cambioswitch(id,valor)
			{
				document.getElementById('idestado').value=id;
				if(valor==1){despliegamodalm('visible','4','Desea Activar este Plan de Adquisiciones','1');}
				else{despliegamodalm('visible','4','Desea Desactivar este Plan de Adquisiciones','2');}
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
					<a onClick="location.href='contra-plancompras.php'" class="mgbt"><img src="imagenes/add.png"  title="Nuevo"/></a>
					<a ><img src="imagenes/guardad.png" class="mgbt1"/></a>
					<a onClick="document.form2.submit()" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a onClick="<?php echo paginasnuevas("inve");?>" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a onClick="pdf()" class="mgbt"><img src="imagenes/print.png" title="Imprimir" /></a>
					<a onClick="excell()" class="mgbt"><img src="imagenes/excel.png" title="Excel"></a>
				</td>
			</tr>
		</table>	
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
 		<form name="form2" method="post" action="contra-plancomprasbuscar.php">
        	<?php 
				if($_POST[oculto]=="")
				{
					$_POST[numpos]=0;$_POST[numres]=10;$_POST[nummul]=0;
					$_POST[cambioestado]="";$_POST[nocambioestado]="";
					$_POST[vigenciactual]=vigencia_usuarios($_SESSION[cedulausu]);
				}
				if($_POST[cambioestado]!="")
				{
					if($_POST[cambioestado]=="1")
					{
						$sqlr="UPDATE contraplancompras SET estado='S' WHERE codplan='$_POST[idestado]'";
						mysql_fetch_row(mysql_query($sqlr,$linkbd)); 
					}
					else 
					{
						$sqlr="UPDATE contraplancompras SET estado='N' WHERE codplan='$_POST[idestado]'";
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
                    <td class="titulos" colspan="4">:: Buscar Plan de Compras</td>
                    <td class="cerrar" style="width:7%;"><a onClick="location.href='contra-principal.php'">&nbsp;Cerrar</a></td>
                </tr>
      			<tr>
                    <td class="saludo1" style="width:2.5cm">Descripci&oacute;n:</td>
                    <td>
                    	<input type="search" name="descripcion" id="descripcion" value="<?php echo $_POST[descripcion];?>" style="width:55%">&nbsp;
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
					$crit1=" ";
					$crit2=" ";
					if ($_POST[descripcion]!=""){$crit2="AND descripcion LIKE '%$_POST[descripcion]%' ";}
					$sqlr="SELECT * FROM contraplancompras WHERE vigencia='$_POST[vigenciactual]' $crit1 $crit2";
					$resp = mysql_query($sqlr,$linkbd);
					$_POST[numtop]=mysql_num_rows($resp);
					$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
					$cond2="";
					if ($_POST[numres]!="-1"){$cond2="LIMIT $_POST[numpos], $_POST[numres]";}
					$sqlr="SELECT * FROM contraplancompras WHERE vigencia='$_POST[vigenciactual]' $crit1 $crit2 ORDER BY codplan DESC   $cond2";
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
					<table class='inicio' align='center' width='75%'>
						<tr>
							<td colspan='11' class='titulos'>.: Resultados Busqueda:</td>
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
							<td colspan='12'>Total Adquisiciones: $_POST[numtop]</td>
						</tr>
						<tr>
							<td class='titulos2' style='width:5%;'>Item</td>
							<td class='titulos2' style='width:6%;'>Codigo UNSPSC</td>
							<td class='titulos2' >Descripci&oacute;n</td>
							<td class='titulos2' style='width:7%;'>Fecha Estimada Inicial</td>
							<td class='titulos2' style='width:5%;'>Duracion Estimada</td>
							<td class='titulos2' style='width:12%;'>Modalidad Seleccion</td>
							<td class='titulos2' style='width:15%;'>Fuente</td>
							<td class='titulos2' style='width:10%;'>Vlr Estimado</td>
							<td class='titulos2' style='width:10%;'>Vlr Estimado Vig Actual</td>
							<td class='titulos2' colspan='2' style='width:5%;'>ESTADO</td>
							<td class='titulos2' style='width:5%;'>Editar</td>
						</tr>";
					$iter='saludo1a';
					$iter2='saludo2';
					$k=0;
					while ($row =mysql_fetch_row($resp)) 
					{
						switch($row[14])
						{
							case 'S':	$tiest='Activo';
										$imgsem="src='imagenes/sema_verdeON.jpg' title='$tiest'";
										$coloracti="#0F0";
										$_POST[lswitch1][$row[0]]=0;
										$mosedita="<a href='contra-plancompraseditar.php?codid=$row[0]&vigen=$row[1]'><img src='imagenes/b_edit.png' style='width:18px' title='Editar'></a>";
										$abilitado="";
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
						$con2=$con+ $_POST[numpos];
						$comcodigo=str_replace("-","</br>",$row[4]);
						$sqlr2="SELECT descripcion_valor FROM dominios  WHERE nombre_dominio='MODALIDAD_SELECCION' AND (valor_final IS NULL or valor_final ='') AND valor_inicial='$row[8]'";
						$row2 =mysql_fetch_row(mysql_query($sqlr2,$linkbd));
						$sqlr3="SELECT nombre FROM (SELECT codigo,nombre FROM pptofutfuentefunc UNION SELECT codigo,nombre FROM pptofutfuentefunc) AS tabla WHERE codigo='$row[9]'";
						$row3 =mysql_fetch_row(mysql_query($sqlr3,$linkbd));
						$duramostrar="";
						$duraciones=explode('/', $row[7]);
						if($duraciones[0]>1 ){$duramostrar ="$duraciones[0] Dias ";}
						elseif($duraciones[0]==1){$duramostrar ="$duraciones[0] Dia ";}
						if($duraciones[0]>1 && $duraciones[1]>1){$duramostrar ="$duramostrar y ";}
						if($duraciones[1]>1 ){$duramostrar = "$duraciones[1] Meses";}
						elseif($duraciones[1]==1){$duramostrar ="$duraciones[1] Mes";}
						echo "
						<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase' onDblClick='redireccion($row[0])'>
							<td>$row[0]</td>
							<td>$comcodigo</td>
							<td>$row[5]</td>
							<td style='text-align:center;'>".date('d-m-Y',strtotime($row[6]))."</td>
							<td style='text-align:center;'>$duramostrar</td>
							<td>$row2[0]</td>
							<td>$row3[0]</td>
							<td style='text-align:right;'>$".number_format($row[10],2)."</td>
							<td style='text-align:right;'>$".number_format($row[11],2)."</td>
							<td style='text-align:center;'><img $imgsem style='width:20px'/></td>
							<td><input type='range' name='lswitch1[]' value='".$_POST[lswitch1][$row[0]]."' min ='0' max='1' step ='1' style='background:$coloracti; width:60%' onChange='cambioswitch(\"".$row[0]."\",\"".$_POST[lswitch1][$row[0]]."\")' Title='$tiest' $abilitado /></td>
							<td style='text-align:center;'>$mosedita</td>
						</tr>";
					$con+=1;
					$aux=$iter;
					$iter=$iter2;
					$iter2=$aux;
       				$sqlr2="SELECT descripcion_valor FROM dominios  WHERE nombre_dominio='MODALIDAD_SELECCION' AND (valor_final IS NULL or valor_final ='') AND valor_inicial='$row[8]'";
					$row2 =mysql_fetch_row(mysql_query($sqlr2,$linkbd));
					$_POST[adqmodalidad2][]=$row2[0];
					$sqlr3="SELECT nombre FROM (SELECT codigo,nombre FROM pptofutfuentefunc UNION SELECT codigo,nombre FROM pptofutfuentefunc) AS tabla WHERE codigo='$row[9]'";
					$row3 =mysql_fetch_row(mysql_query($sqlr3,$linkbd));
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
        <input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>"/>
        <input type='hidden' name='adqprodtodos[]' value='".$_POST[adqprodtodos][$k]."'/>
        <input type='hidden' name='adqindice[]' value='".$_POST[adqindice][$k]."'/>
        <input type='hidden' name='adqdescripcion[]' value='".$_POST[adqdescripcion][$k]."'/>
        <input type='hidden' name='adqfecha2[]' value='".$_POST[adqfecha2][$k]."'/>
        <input type='hidden' name='adqduracion[]' value='".$_POST[adqduracion][$k]."'/>
        <input type='hidden' name='adqmodalidad[]' value='".$_POST[adqmodalidad][$k]."'/>
        <input type='hidden' name='adqfuente[]' value='".$_POST[adqfuente][$k]."'/>
        <input type='hidden' name='adqvlrestimado[]' value='".$_POST[adqvlrestimado][$k]."'/>
        <input type='hidden' name='adqvlrvig[]' value='".$_POST[adqvlrvig][$k]."'/>
        <input type='hidden' name='adqfecha[]' value='".$_POST[adqfecha][$k]."'/>
        <input type='hidden' name='adqprodtodosg[]' value='".$_POST[adqprodtodosg][$k]."'/>
        <input type='hidden' name='adqrequierevig[]' value='".$_POST[adqrequierevig][$k]."'/>
        <input type='hidden' name='adqestadovigfut[]' value='".$_POST[adqestadovigfut][$k]."'/>
        <input type='hidden' name='codigoadqisicion[]' value='".$_POST[codigoadqisicion][$k]."'/>
        <input type='hidden' name='adqmodalidad2[]' value='".$_POST[adqmodalidad2][$k]."'/>
        <input type='hidden' name='adqfuente2[]' value='".$_POST[adqfuente2][$k]."'/>
    </form>
</body>
</html>

