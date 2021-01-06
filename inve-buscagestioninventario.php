<?php //V 1000 12/12/16 ?>
<?php
  require"comun.inc";
  require"funciones.inc";
  session_start();
  $linkbd=conectar_bd();  
  cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
  header("Cache-control: private"); // Arregla IE 6
  date_default_timezone_set("America/Bogota");
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
  <head>
    <meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
    <meta http-equiv="X-UA-Compatible" content="IE=9"/>
<title>:: Spid - Almacen</title>
<script>
//************* FUNCIONES ************
	function cambioswitch(id,valor){
		document.getElementById('idestado').value=id;
		if(valor==1){
			despliegamodalm('visible','4','Desea activar este Tipo de Movimiento','1');
		}
		else{
			despliegamodalm('visible','4','Desea Desactivar este Tipo de Movimiento','2');
		}
	}
	function despliegamodalm(_valor,_tip,mensa,pregunta){
		document.getElementById("bgventanamodalm").style.visibility=_valor;
		if(_valor=="hidden"){
			document.getElementById('ventanam').src="";
		}
		else{
			switch(_tip){
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
	function respuestaconsulta(estado,pregunta){
		if(estado=="S"){
			switch(pregunta){
				case "1":	document.form2.cambioestado.value="1";break;
				case "2":	document.form2.cambioestado.value="0";break;
			}
		}
		else{
			switch(pregunta){
				case "1":	document.form2.nocambioestado.value="1";break;
				case "2":	document.form2.nocambioestado.value="0";break;
			}
		}
		document.form2.submit();
	}

//************* ver reporte ************
//***************************************
function verep(idfac)
{
  document.form1.oculto.value=idfac;
  document.form1.submit();
  }

//************* genera reporte ************
//***************************************
function genrep(idfac)
{
  document.form2.oculto.value=idfac;
  document.form2.submit();
  }

//************* genera reporte ************
//***************************************
function guardar()
{
if (document.form2.documento.value!='')
  {
	if (confirm("Esta Seguro de Guardar"))
  	{
  	document.form2.oculto.value=2;
  	document.form2.submit();
  	}
  }
  else{
  alert('Faltan datos para completar el registro');
  }
 }

function validar(formulario)
{
document.form2.action="inve-buscagestioninventario.php";
document.form2.submit();
}

function cleanForm()
{
document.form2.nombre1.value="";
document.form2.nombre2.value="";
document.form2.apellido1.value="";
document.form2.apellido2.value="";
document.form2.documento.value="";
document.form2.codver.value="";
document.form2.telefono.value="";
document.form2.direccion.value="";
document.form2.email.value="";
document.form2.web.value="";
document.form2.celular.value="";
document.form2.razonsocial.value="";
}
function redirecciona(cod,mov,ent){
	window.location.href = "inve-editagestioninventario.php?is="+cod+"&mov="+mov+"&ent="+ent;
}
</script>
<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
<script type='text/javascript' src='JQuery/jquery-2.1.4.min.js'></script>
<script type="text/javascript" src="css/calendario.js"></script>
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
    <tr><script>barra_imagenes("inve");</script><?php cuadro_titulos();?></tr>	 
    <tr><?php menu_desplegable("inve");?></tr>
<tr>
  <td colspan="3" class="cinta"><a href="inve-gestioninventarioentrada.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a><img src="imagenes/guardad.png" title="Guardar" class="mgbt"/><a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a><a href="#" onClick="mypop=window.open('inve-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a></td></tr>	
</table><tr><td colspan="3" class="tablaprin"> 

	<div id="bgventanamodalm" class="bgventanamodalm">
    	<div id="ventanamodalm" class="ventanamodalm">
        	<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
            </IFRAME>
       	</div>
   	</div>
		<?php
		if($_POST[oculto]==""){
			$_POST[cambioestado]="";
			$_POST[nocambioestado]="";
		}
		if(($_POST[oculto]=="")||($_POST[oculto]=="1")){
			$_POST[numpos]=0;
			$_POST[numres]=10;
			$_POST[nummul]=0;
		}
		//*****************************************************************
		if($_POST[cambioestado]!=""){
			if($_POST[cambioestado]=="1"){
         		$sqlr="UPDATE almdestinocompra SET estado='S' WHERE codigo='$_POST[idestado]'";
	            mysql_fetch_row(mysql_query($sqlr,$linkbd)); 
			}
			else{
            	$sqlr="UPDATE almdestinocompra SET estado='N' WHERE codigo='$_POST[idestado]'";
	            mysql_fetch_row(mysql_query($sqlr,$linkbd)); 
			}
			echo"<script>document.form2.cambioestado.value=''</script>";
		}
		//*****************************************************************
		if($_POST[nocambioestado]!=""){
			if($_POST[nocambioestado]=="1"){
				$_POST[lswitch1][$_POST[idestado]]=1;
			}
			else{
				$_POST[lswitch1][$_POST[idestado]]=0;
			}
			echo"<script>document.form2.nocambioestado.value=''</script>";
		}
 		?>
 	<form name="form2" method="post" action="inve-buscagestioninventario.php">
		<table  class="inicio" align="center" >
	    	<tr>
    	  		<td class="titulos" colspan="11">:: Buscar Gestion de Inventario</td>
	        	<td class="cerrar" style="width:7%"><a href="inve-principal.php">Cerrar</a></td>
		   	</tr>
				<tr>
					<td class="saludo1a" style="width:8%;">Fecha Inicial:</td>
					<td style="width:9%;"><input name="fecha1"  type="text" value="<?php echo $_POST[fecha1]?>" maxlength="10"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" style="width:75%;" title="DD/MM/YYYY"/>&nbsp;<a href="#" onClick="displayCalendarFor('fc_1198971545');" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;"/></a></td>
					<td class="saludo1a" style="width:8%;">Fecha Final:</td>
					<td style="width:9%;"><input name="fecha2" type="text" value="<?php echo $_POST[fecha2]?>" maxlength="10"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971546" onKeyDown="mascara(this,'/',patron,true)" style="width:75%;" title="DD/MM/YYYY"/>&nbsp;<a href="#" onClick="displayCalendarFor('fc_1198971546');" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;"/></a></td>
				
    			<td class="saludo1a" style="width:5%">Codigo:</td>
        		<td style="width:5%">
                	<input name="documento" type="text" id="documento" value="<?php echo $_POST[documento];?>">
               	</td>
				<td class="saludo1a" style="width:12%">Tipo de Movimiento:</td>
        		<td style="width:10%">
	          		<select name="tipomov" id="tipomov" onChange="validar()" style="width:90%">
						<option value="">Seleccione ....</option>
        	  			<option value="1" <?php if($_POST[tipomov]=='1') echo "SELECTED"; ?>>1 - Entrada</option>
          				<option value="2" <?php if($_POST[tipomov]=='2') echo "SELECTED"; ?>>2 - Salida</option>
          				<option value="3" <?php if($_POST[tipomov]=='3') echo "SELECTED"; ?>>3 - Reversi&oacute;n de Entrada</option>
          				<option value="4" <?php if($_POST[tipomov]=='4') echo "SELECTED"; ?>>4 - Reversi&oacute;n de Salida</option>
      	 			</select>
               	</td>  
               	<td class='saludo1a' style="width:8%">Tipo Entrada</td>
                <td style="width:25%">
                    <select name='tipoentrada' id='tipoentrada' onChange='validar()' style="width:66%">
                        <option value=''>Seleccione ....</option>
                        <?php
		                 	$sqlr="SELECT * FROM almtipomov WHERE tipom='$_POST[tipomov]' ORDER BY tipom, codigo";
		                 	$resp = mysql_query($sqlr,$linkbd);
		               		while($row =mysql_fetch_row($resp)) 
							{
		                    	if($row[0]==$_POST[tipoentrada])
								{
									$_POST[tipoentrada]=$row[0];
									$_POST[ntipoentrada]=$row[2];
		               				echo "<option value='$row[0]' SELECTED>$row[1]$row[0] - $row[2]</option>";
		                      	}
		                     	else {echo "<option value='$row[0]'>$row[1]$row[0] - $row[2]</option>"; }
		                  	}   
                        ?>
                    </select>
                    <input type="submit" name="Submit" value="Buscar" style="height:25px"/>
                </td>         
       		</tr>                       
    	</table>    
   		<input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
	    <input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
    	<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
		<input type="hidden" name="cambioestado" id="cambioestado" value="<?php echo $_POST[cambioestado];?>"/>
		<input type="hidden" name="nocambioestado" id="nocambioestado" value="<?php echo $_POST[nocambioestado];?>"/>
		<input type="hidden" name="idestado" id="idestado" value="<?php echo $_POST[idestado];?>"/>
        <div class="subpantalla"  style="height:69.5%; width:99.6%; overflow-x:hidden;">
      		<?php
			$linkbd=conectar_bd();
			$fech1=split("/",$_POST[fecha1]);
			$fech2=split("/",$_POST[fecha2]);
			$f1=$fech1[2]."-".$fech1[1]."-".$fech1[0];
			$f2=$fech2[2]."-".$fech2[1]."-".$fech2[0];
			$crit1=" ";
			$crit2=" ";
			if ($_POST[tipomov]!="")
				$crit1=" and almginventario.tipomov like '%".$_POST[tipomov]."%' ";
			if ($_POST[documento]!="")
				$crit2=" and almginventario.consec like '%$_POST[documento]%' ";
			if ($_POST[tipoentrada]!="")
				$crit3=" and almginventario.tiporeg like '%$_POST[tipoentrada]%' ";
			if ($_POST[fecha1]!="" && $_POST[fecha2]!=""){$crit4=" and fecha BETWEEN '$f1' AND '$f2' ";}
			else{$crit4=" ";}
			//sacar el consecutivo 
			//$sqlr="select *from pptosideforigen where".$crit1.$crit2." order by pptosideforigen.codigo";
			if($_POST[oculto]!='0')
			{
				$sqlr="select *from almginventario where almginventario.estado<>''".$crit1.$crit2.$crit3.$crit4." order by almginventario.codigo";
				$resp = mysql_query($sqlr,$linkbd);
						 $_POST[numtop]=mysql_num_rows($resp);
				$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
				$sqlr="select *from almginventario where almginventario.estado<>''".$crit1.$crit2.$crit3.$crit4." order by almginventario.codigo desc";
				$resp = mysql_query($sqlr,$linkbd);
						$con=1;
				$numcontrol=$_POST[nummul]+1;
				if($nuncilumnas==$numcontrol){
					$imagenforward="<img src='imagenes/forward02.png' style='width:17px'>";
					$imagensforward="<img src='imagenes/skip_forward02.png' style='width:16px' >";
				}
				else{
					$imagenforward="<img src='imagenes/forward01.png' style='width:17px' title='Siguiente' onClick='numsiguiente()'>";
					$imagensforward="<img src='imagenes/skip_forward01.png' style='width:16px' title='Fin' onClick='saltocol(\"$nuncilumnas\")'>";
				}
				if($_POST[numpos]==0){
					$imagenback="<img src='imagenes/back02.png' style='width:17px'>";
					$imagensback="<img src='imagenes/skip_back02.png' style='width:16px'>";
				}
				else{
					$imagenback="<img src='imagenes/back01.png' style='width:17px' title='Anterior' onClick='numanterior();'>";
					$imagensback="<img src='imagenes/skip_back01.png' style='width:16px' title='Inicio' onClick='saltocol(\"1\")'>";
				}
				echo "<table class='inicio' align='center' width='80%'>
					<tr>
						<td colspan='5' class='titulos'>.: Resultados Busqueda:</td>
					</tr>
					<tr>
						<td colspan='5'>Destino de Compra Encontrados: $_POST[numtop]</td>
					</tr>
					<tr>
						<td width='5%' class='titulos2'>Codigo</td>
						<td class='titulos2' width='10%'>Fecha</td>
						<td class='titulos2' width='20%'>Tipo de Movimiento</td>
						<td class='titulos2' width='60%'>Nombre</td>
						<td class='titulos2' width='5%'>Editar</td>
					</tr>";	
					//echo "nr:".$nr;
					$iter='saludo1a';
					$iter2='saludo2';
					while($row =mysql_fetch_row($resp)){
						 echo "<tr class='$iter' onDblClick='redirecciona($row[9],$row[2],\"$row[3]\")'>
							<td>".$row[9]."</td>
							<td>".$row[1]."</td>
							<td>";
							if($row[2]>2) $tpmov='REVERSION';
							else $tpmov='';
							 $sqlm="Select * from almtipomov where codigo='$row[3]' and tipom='$row[2]'";
							 $respm = mysql_query($sqlm,$linkbd);
							$rowm =mysql_fetch_row($respm);
							$tpmov.=' '.$rowm[2];
							echo $tpmov."</td>
							<td>".strtoupper($row[8])."</td>
							<td><a href='inve-editagestioninventario.php?is=$row[9]&mov=$row[2]&ent=$row[3]'>
								<center><img src='imagenes/b_edit.png'></center></a>
							</td>
					</tr>";
					 $con+=1;
					 $aux=$iter;
					 $iter=$iter2;
					 $iter2=$aux;
					}
					?>
					<input name="oculto" type="hidden" value="1"> 
					<?php
			
			

				echo"</table>
					<table class='inicio'>
						<tr>
							<td style='text-align:center;'>
								<a href='#'>$imagensback</a>&nbsp;
								<a href='#'>$imagenback</a>&nbsp;&nbsp;";
									if($nuncilumnas<=9){
										$numfin=$nuncilumnas;
									}
									else{
										$numfin=9;
									}
									for($xx = 1; $xx <= $numfin; $xx++){
										if($numcontrol<=9){$numx=$xx;}
										else{$numx=$xx+($numcontrol-9);}
										if($numcontrol==$numx){
											echo"<a href='#' onClick='saltocol(\"$numx\")'; style='color:#24D915'> $numx </a>";
										}
										else {
											echo"<a href='#' onClick='saltocol(\"$numx\")'; style='color:#000000'> $numx </a>";
										}
									}
									echo "&nbsp;&nbsp;<a href='#'>$imagenforward
								</a>
								&nbsp;<a href='#'>$imagensforward</a>
							</td>
						</tr>
					</table>";
				}
				else
				{
					echo "<table class='inicio'><tr><td class='saludo1a'><center> Seleccione uno o varios filtros y oprima buscar, para visualizar los registros almacenados.  <img src='imagenes\confirm.png'> </center></tr></table>";
				}
       	?>	
		</div>
        <input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>" />
 <br><br>
</td></tr>     
</table>
</form>
</body>
</html>