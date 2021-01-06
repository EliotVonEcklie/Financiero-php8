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
	$scroll=$_GET['scrtop'];
	$totreg=$_GET['totreg'];
	$idcta=$_GET['idcta'];
	$altura=$_GET['altura'];
	$filtro="'".$_GET['filtro']."'";
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
<title>:: SPID - Almacen</title>
<script>
	//**************FUNCIONES*********
	function despliegamodalm(_valor,_tip,mensa,pregunta){
		document.getElementById("bgventanamodalm").style.visibility=_valor;
		if(_valor=="hidden"){
			document.getElementById('ventanam').src="";
			if(document.getElementById('valfocus').value=="2"){
				document.getElementById('valfocus').value='1';
				document.getElementById('documento').focus();
				document.getElementById('documento').select();
			}
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
					document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
			}
		}
	}
	function funcionmensaje(){}
	function respuestaconsulta(pregunta){
		switch(pregunta){
			case "1":
				document.form2.oculto.value="2";
				document.form2.submit();
				break;
		}
	}
//************* guardar ************
	function guardar(){
		var validacion00=document.getElementById('sigla').value;
		var validacion01=document.getElementById('nombre').value;
		if((validacion00.trim()!='')&&(validacion01.trim()!='')){
			despliegamodalm('visible','4','Esta Seguro de Modificar la Información de la Unidad de Medida','1');
			document.getElementById('oculto').value='2';
		}
		else{
		document.form2.numero.focus();
			despliegamodalm('visible','2','Faltan Datos para Completar el Registro');
		}
	}

//***************************************
</script>
<script type="text/javascript" src="css/programas.js"></script>
<script type="text/javascript" src="css/calendario.js"></script>
<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script>
			function adelante(scrtop, numpag, limreg, filtro, next){
				var maximo=document.getElementById('maximo').value;
				var actual=document.getElementById('codigo').value;
				if(parseFloat(maximo)>parseFloat(actual)){
					document.getElementById('oculto').value='1';
					document.getElementById('codigo').value=next;
					var idcta=document.getElementById('codigo').value;
					document.form2.action="inve-editaunidadmedida.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
		
			function atrasc(scrtop, numpag, limreg, filtro, prev){
				var minimo=document.getElementById('minimo').value;
				var actual=document.getElementById('codigo').value;
				if(parseFloat(minimo)<parseFloat(actual)){
					document.getElementById('oculto').value='1';
					document.getElementById('codigo').value=prev;
					var idcta=document.getElementById('codigo').value;
					document.form2.action="inve-editaunidadmedida.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
		
			function iratras(scrtop, numpag, limreg, filtro){
				var idcta=document.getElementById('codigo').value;
				location.href="inve-buscaunidadmedida.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
			}
		</script>
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
        <?php
		$numpag=$_GET[numpag];
		$limreg=$_GET[limreg];
		$scrtop=26*$totreg;
		?>
<table>
    <tr><script>barra_imagenes("inve");</script><?php cuadro_titulos();?></tr>	 
    <tr><?php menu_desplegable("inve");?></tr>
    <tr>
  <td colspan="3" class="cinta"><a href="inve-unidadmedida.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" border="0" /></a><a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a><a href="inve-buscaunidadmedida.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" border="0" /></a><a href="#" onClick="mypop=window.open('inve-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a><a href="#" onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td>
</tr>
</table>

<?php
//$vigencia=date(Y);
//$linkbd=conectar_bd();
?>	
<?php
			if ($_GET[codigo]!=""){echo "<script>document.getElementById('codrec').value=$_GET[codigo];</script>";}
			$sqlr="select MIN(CONVERT(valor_inicial, SIGNED INTEGER)), MAX(CONVERT(valor_inicial, SIGNED INTEGER)) from dominios where nombre_dominio='unidad_medida' ORDER BY CONVERT(valor_inicial, SIGNED INTEGER)";
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
			$_POST[minimo]=$r[0];
			$_POST[maximo]=$r[1];
			if($_POST[oculto]==""){
				if ($_POST[codrec]!="" || $_GET[codigo]!=""){
					if($_POST[codrec]!=""){
						$sqlr="select *from dominios where nombre_dominio='unidad_medida' and valor_inicial='$_POST[codrec]'";
					}
					else{
						$sqlr="select *from dominios where nombre_dominio='unidad_medida' and valor_inicial ='$_GET[codigo]'";
					}
				}
				else{
					$sqlr="select * from  dominios where nombre_dominio='unidad_medida' ORDER BY CONVERT(valor_inicial, SIGNED INTEGER) DESC";
				}
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
			   	$_POST[codigo]=$row[0];
			}

if(($_POST[oculto]!=2)){
	$linkbd=conectar_bd();
	$sqlr="select * from dominios where dominios.valor_inicial='$_POST[codigo]' and nombre_dominio='unidad_medida'";
	//echo $sqlr;
	$res=mysql_query($sqlr,$linkbd); 
	while ($row=mysql_fetch_row($res)){
		$_POST[codigo]=$row[0];
		$_POST[nombre]=$row[2];
		$_POST[sigla]=$row[1];
	}
}
			//NEXT
			$sqln="select *from dominios WHERE nombre_dominio='unidad_medida' and valor_inicial > '$_POST[codigo]' ORDER BY valor_inicial ASC LIMIT 1";
			$resn=mysql_query($sqln,$linkbd);
			$row=mysql_fetch_row($resn);
			$next="'".$row[0]."'";
			//PREV
			$sqlp="select *from dominios WHERE nombre_dominio='unidad_medida' and valor_inicial < '$_POST[codigo]' ORDER BY valor_inicial DESC LIMIT 1";
			$resp=mysql_query($sqlp,$linkbd);
			$row=mysql_fetch_row($resp);
			$prev="'".$row[0]."'";

?>
<div id="bgventanamodalm" class="bgventanamodalm">
	<div id="ventanamodalm" class="ventanamodalm">
    	<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
        </IFRAME>
   	</div>
</div>
<form name="form2" method="post" action=""> 
  	<table class="inicio" align="center"  >
    	<tr >
        	<td class="titulos" colspan="8">.: Editar Unidad de Medida</td>
        	<td width="61" class="cerrar" ><a href="inve-principal.php">Cerrar</a></td>
      	</tr>
      	<tr>
	  		<td class="saludo1">.: Codigo:</td>
        	<td style="width:10%">
	        	    	<a href="#" onClick="atrasc(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $prev; ?>)"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> 
            	<input name="codigo" id="codigo" type="text" value="<?php echo $_POST[codigo]?>" maxlength="2" style="width:30%" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)">
	    	            <a href="#" onClick="adelante(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $next; ?>)"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
						<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo" id="maximo">
						<input type="hidden" value="<?php echo $_POST[minimo]?>" name="minimo" id="minimo">
						<input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">
        	</td>
        	<td class="saludo1">.: Unidad de Medida:</td>
        	<td>
            	<input id="nombre" name="nombre" type="text" value="<?php echo $_POST[nombre]?>" size="80" onKeyUp="return tabular(event,this)">
        	</td>
        	<td class="saludo1">.: Sigla:</td>
        	<td>
            	<input id="sigla" name="sigla" type="text" value="<?php echo $_POST[sigla]?>" size="10" onKeyUp="return tabular(event,this)" style="text-transform:uppercase;">
            	<input type="hidden" value="" name="oculto" id="oculto">
        	</td>
    	</tr>
    </table>
</form>
	<?php 
	//********** GUARDAR EL COMPROBANTE ***********
	if($_POST[oculto]=='2'){
		//rutina de guardado cabecera
		$linkbd=conectar_bd();	
		$sqlr="update dominios set descripcion_valor='".$_POST[nombre]."', valor_final='".$_POST[sigla]."' where valor_inicial='$_POST[codigo]' and nombre_dominio='unidad_medida'";
   	   	if(!mysql_query($sqlr,$linkbd)){
			echo"<script>despliegamodalm('visible','2','Error no se almaceno');</script>";
		}	
        else{
			echo"<script>despliegamodalm('visible','3','Se ha actualizado la Unidad de Medida con Exito');</script>";
		}
		//**** crear el detalle del concepto		
	}
	?>	
</td></tr>     
</table>
</body>
</html>