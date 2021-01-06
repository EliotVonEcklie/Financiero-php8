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
		<?php titlepag();?>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
        <script type="text/javascript" src="css/programas.js"></script>

        <script>
			function buscarp(padreo,nivelo,codigo,despro, filas)
			{
				var nivel=0;
				nivel=parseInt(nivelo)+1; 
				document.getElementById("padreo").value=codigo;
				document.getElementById("nivelo").value=nivel;
				document.getElementById("despro").value=despro;
				document.getElementById("filas").value=filas;
				document.form2.submit();
			}
			function buscart()
			{
				if (document.getElementById("padreo").value!="0")
				{
					var nivel=document.getElementById("nivelo").value;
					var scrtop=document.getElementById("filas").value*26;
					var idcta=document.getElementById("padreo").value;
					nivel=parseInt(nivel)-1; 
					
					document.getElementById("padreo").value=document.getElementById("padrea").value;
					document.getElementById("nivelo").value=nivel;
					document.getElementById("scrtop").value=scrtop;
					document.form2.action="contra-productosbuscar.php?idcta="+idcta;
					document.form2.submit();
				}
			}
			function buscarr()
			{
				document.getElementById("padreo").value="0";
				document.getElementById("nivelo").value="1";
				document.getElementById("despro").value="";
				document.form2.submit();
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventanam').src="";}
				else
				{
					switch(_tip)
					{
						case "1":	document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
						case "2":	document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
						case "3":	document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
						case "4":	document.getElementById('ventanam').src="ventana-consulta2.php?titulos="+mensa+"&idresp="+pregunta;break;	
						case "5":	document.getElementById('ventanam').src="contra-productosmodificar.php?codigo="+mensa+"&clase="+pregunta;
					}
				}
			}
			function funcionmensaje(){}
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
			function cambioswitch(id,valor)
			{
				document.getElementById('idestado').value=id;
				var menswitch1='Seguro de Desactivar '+document.form2.clprod.value;
				var menswitch2='Seguro de Activar '+document.form2.clprod.value;
				if(valor==1){despliegamodalm('visible','4',menswitch2,'1');}
				else{despliegamodalm('visible','4',menswitch1,'2');}
			}
		</script>
        <script>
			window.onload=function(){
				var scrtop=document.getElementById("scrtop").value;
				$('#divdet').scrollTop(scrtop)
			}
		</script>
		<?php titlepag();?>
        <?php
		if(isset($_GET['idcta']))
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
					<a href="contra-productosguardar.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" border="0" /></a>
					<a href="#" class="mgbt"><img src="imagenes/guardad.png"/></a>
					<a href="#" onClick="buscarr()" class="mgbt"><img src="imagenes/busca.png" title="Buscar" border="0" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('inve-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a>
					<a href="#" onClick="buscart()" class="mgbt"><img src="imagenes/iratras.png" title="Buscar" border="0" /></a>
				</td>
			</tr>
		</table>
	<div id="bgventanamodalm" class="bgventanamodalm">
		<div id="ventanamodalm" class="ventanamodalm">
        	<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
            </IFRAME>
       	</div>
   	</div>	
 	<form name="form2" method="post" action="contra-productosbuscar.php">
        <?php 
			if ($_POST[oculto]=="")
			{
				$_POST[padreo]="0";
				$_POST[nivelo]="1";
				$_POST[oculto]="1";
			}
			switch ($_POST[nivelo]) 
			{
				case "1":
					$_POST[clprod]="GRUPO";
					$_POST[clpro2]="";
					break;
				case "2":
					$_POST[clprod]="SEGMENTO";
					$_POST[clpro2]="GRUPO";
					break;
				case "3":
					$_POST[clprod]="FAMILIA";
					$_POST[clpro2]="SEGMENTO";
					break;
				case "4":
					$_POST[clprod]="CLASE";
					$_POST[clpro2]="FAMILIA";
					break;
				case "5":
					$_POST[clprod]="PRODUCTO";
					$_POST[clpro2]="CLASE";
					break;
			}
			if($_POST[oculto2]=="")
			{
				$_POST[oculto2]="0";
				$_POST[cambioestado]="";
				$_POST[nocambioestado]="";
			}
			//*****************************************************************
			if($_POST[cambioestado]!="")
			{
				if($_POST[cambioestado]=="1")
				{
					$sqlr="UPDATE productospaa SET estado='S' WHERE codigo='$_POST[idestado]'";
					mysql_fetch_row(mysql_query($sqlr,$linkbd)); 
				}
				else 
				{
					$sqlr="UPDATE productospaa SET estado='N' WHERE codigo='$_POST[idestado]'";
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
        		<td class="titulos" colspan="1">:: PRODUCTOS</td>
        		<td class="cerrar" style='width:7%'><a href="contra-principal.php">Cerrar</a></td>
      		</tr>
      		<tr>
      		</tr>
      	</table>
        <input type="hidden" name="filas" id="filas" value="<?php echo $_POST[filas];?>">
        <input type="hidden" name="scrtop" id="scrtop" value="<?php echo $_POST[scrtop];?>">
		<input type="hidden" name="oculto2" id="oculto2" value="<?php echo $_POST[oculto2];?>">
		<input type="hidden" name="cambioestado" id="cambioestado" value="<?php echo $_POST[cambioestado];?>">
		<input type="hidden" name="nocambioestado" id="nocambioestado" value="<?php echo $_POST[nocambioestado];?>">
	 	<input type="hidden" name="idestado" id="idestado" value="<?php echo $_POST[idestado];?>">
        <div id="divdet" class="subpantallac5" style="height:72%; width:99.6%; margin-top:0px; overflow-x:hidden">
        <table>
        	<?php
				$sqlr="SELECT * FROM productospaa WHERE padre='$_POST[padreo]' ORDER BY codigo";
				$sqlt="SELECT * FROM productospaa WHERE padre='$_POST[padreo]' ORDER BY codigo";
				$resp = mysql_query($sqlr,$linkbd);
				$rest = mysql_query($sqlt,$linkbd);
				$rowt =mysql_fetch_row($rest);
				$ntr = mysql_num_rows($resp);
				$sqlp="SELECT * FROM productospaa WHERE codigo='$rowt[3]'";
				$rowp=mysql_fetch_row(mysql_query($sqlp,$linkbd));
				$_POST[padrea]=$rowp[3];
				$iter='saludo1a';
				$iter2='saludo2';
				$con=1;
				if($rowp[1]!=""){$titulo=$_POST[clpro2]." \"$rowp[1]\"";}
				else{$titulo=$_POST[clprod];}
				echo "<table  class='inicio' align='center' >
      					<tr>
        					<td class='titulos' style=\"width:97%;\" colspan='7'>::BUSQUEDA POR $titulo</td>
      					</tr>
      					<tr>
							<td class='titulos2' style='width:6%;'>Item</td>
							<td class='titulos2' style='width:10%;'>C&oacute;digo</td>
							<td class='titulos2' >Descripci&oacute;n ".ucfirst(strtolower($_POST[clprod]))."</td>
							<td class='titulos2' colspan='2' style='width:5%;'>ESTADO</td>
							<td class='titulos2' style='width:5%; '>Modificar</td>										
      					</tr>";
				$filas=1;
				while ($row =mysql_fetch_row($resp)) 
				{
					if($_POST[nivelo]!="5")
						{$tbusqueda="onClick='buscarp(\"$row[3]\",\"$row[2]\",\"$row[0]\",\"$row[1]\",\"$filas\");'";}
					else{$tbusqueda="";}
					if($row[4]=='S'){$imgsem="src='imagenes/sema_verdeON.jpg' title='Activo'";$coloracti="#0F0";$_POST[lswitch1][$row[0]]=0;}
					else{$imgsem="src='imagenes/sema_rojoON.jpg' title='Inactivo'";$coloracti="#C00";$_POST[lswitch1][$row[0]]=1;}
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
					
					echo"
						<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\" style='$estilo'>
							<td $tbusqueda><a href='#'>$con</a></td>
							<td $tbusqueda><a href='#'>$row[0]</a></td>
							<td $tbusqueda><a href='#'>$row[1]</a></td>
							<td style='text-align:center;'><img $imgsem style='width:20px'/></td>
							<td><input type='range' name='lswitch1[]' value='".$_POST[lswitch1][$row[0]]."' min ='0' max='1' step ='1' style='background:$coloracti; width:60%' onChange='cambioswitch(\"$row[0]\",\"".$_POST[lswitch1][$row[0]]."\")' /></td>
							<td style='text-align:center;'><a href='#' onClick='despliegamodalm(\"visible\",\"5\",\"$row[0]\",\"".ucfirst(strtolower($_POST[clprod]))."\")'><img src='imagenes/b_edit.png' title='Modificar' style='width:18px'/></a></td>
						</tr>";	
					$con+=1;
					$aux=$iter;
	 				$iter=$iter2;
					$iter2=$aux;
					$filas++;
				}
      			echo"</table>";
				if($_POST[oculto]=="4")
				{
					$_POST[oculto]="1";
					echo"<script>despliegamodalm('visible','3','Se realizo con Exito la Modificación');</script>";
				}
			?>
        </table>
        </div>
        <input type="hidden" name="despro" id="despro" value="<?php echo $_POST[despro];?>">
        <input type="hidden" name="padreo" id="padreo" value="<?php echo $_POST[padreo];?>">
        <input type="hidden" name="padrea" id="padrea" value="<?php echo $_POST[padrea];?>">
        <input type="hidden" name="clprod" id="clprod" value="<?php echo $_POST[clprod];?>">
        <input type="hidden" name="clpro2" id="clpro2" value="<?php echo $_POST[clpro2];?>">
        <input type="hidden" name="nivelo" id="nivelo" value="<?php echo $_POST[nivelo];?>">
        <input type="hidden" name="oculto" id="oculto" value="<?php echo $_POST[oculto];?>">
	</form>
</body>
</html>