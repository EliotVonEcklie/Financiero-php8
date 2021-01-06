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
</script>
<script type="text/javascript" src="css/programas.js"></script>
<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
    <tr><script>barra_imagenes("inve");</script><?php cuadro_titulos();?></tr>	 
    <tr><?php menu_desplegable("inve");?></tr>
<tr>
  <td colspan="3" class="cinta"><a href="inve-fisico.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a><img src="imagenes/guardad.png" title="Guardar" class="mgbt"/><a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a><a href="#" onClick="mypop=window.open('inve-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a></td></tr>	
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
 		?>
 	<form name="form2" method="post" action="inve-fisicobuscar.php">
		<table  class="inicio" align="center" >
	    	<tr>
    	  		<td class="titulos" colspan="4">:: Buscar Inventario Físico</td>
	        	<td class="cerrar" ><a href="inve-principal.php">Cerrar</a></td>
		   	</tr>
	      	<tr >
    			<td class="saludo1a" style="width:10%">Codigo:</td>
        		<td style="width:10%">
                	<input name="documento" type="text" id="documento" value="<?php echo $_POST[documento];?>" size="2" maxlength="2">
               	</td>
				<td class="saludo1a">Nombre:</td>
        		<td>
                	<input name="nombre" type="text" id="nombre" value="<?php echo $_POST[nombre];?>" >
               	</td>             
       		</tr>                       
    	</table>    
	    <input name="oculto" type="hidden" value="1"> 
   		<input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
	    <input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
    	<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
		<input type="hidden" name="cambioestado" id="cambioestado" value="<?php echo $_POST[cambioestado];?>"/>
		<input type="hidden" name="nocambioestado" id="nocambioestado" value="<?php echo $_POST[nocambioestado];?>"/>
		<input type="hidden" name="idestado" id="idestado" value="<?php echo $_POST[idestado];?>"/>
        <div class="subpantalla"  style="height:69.5%; width:99.6%; overflow-x:hidden;">
      		<?php
			$linkbd=conectar_bd();
			$crit1=" ";
			$crit2=" ";
			if ($_POST[nombre]!="")
				$crit1=" and almfisico.nombre like '%".$_POST[tipomov]."%' ";
			if ($_POST[documento]!="")
				$crit2=" and almfisico.codigo like '%$_POST[documento]%' ";
			//sacar el consecutivo 
			//$sqlr="select *from pptosideforigen where".$crit1.$crit2." order by pptosideforigen.codigo";
			$sqlr="select *from almfisico where estado<>''".$crit1.$crit2." order by codigo";
			$resp = mysql_query($sqlr,$linkbd);
    	   	$_POST[numtop]=mysql_num_rows($resp);
			$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
			$sqlr="select *from almfisico where almfisico.estado<>''".$crit1.$crit2." order by almfisico.codigo LIMIT $_POST[numpos],$_POST[numres]";
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
					<td colspan='8' class='titulos'>.: Resultados Busqueda:</td>
				</tr>
				<tr>
					<td colspan='5'>Gestión de Inventario Físico Encontrados: $_POST[numtop]</td>
				</tr>
				<tr>
					<td width='5%' class='titulos2'>Codigo</td>
					<td class='titulos2' width='10%'>Fecha</td>
					<td class='titulos2' width='80%'>Nombre</td>
					<td class='titulos2' width='5%'>Editar</td>
				</tr>";	
				//echo "nr:".$nr;
				$iter='saludo1a';
				$iter2='saludo2';
				while($row =mysql_fetch_row($resp)){
 					echo "<tr class='$iter'>
						<td>".strtoupper($row[0])."</td>
						<td>".strtoupper($row[1])."</td>
						<td>".strtoupper($row[5])."</td>
						<td><a href='inve-fisicoedita.php?is=$row[0]'>
							<center><img src='imagenes/b_edit.png'></center></a>
						</td>
				</tr>";
 				$con+=1;
 				$aux=$iter;
 				$iter=$iter2;
	 			$iter2=$aux;
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
							if($numcontrol==$numx){
								echo"<a href='#' onClick='saltocol(\"$numx\")'; style='color:#24D915'> $numx </a>";
							}
							else{
								echo"<a href='#' onClick='saltocol(\"$numx\")'; style='color:#000000'> $numx </a>";
							}
						}
						echo "&nbsp;&nbsp;<a href='#'>$imagenforward</a>
						&nbsp;<a href='#'>$imagensforward</a>
					</td>
				</tr>
			</table>";
       	?>	
		</div>
        <input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>" />
 <br><br>
</td></tr>     
</table>
</form>
</body>
</html>