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
			despliegamodalm('visible','4','Esta Seguro de Guardar','1');
		}
		else{
			document.form2.nombre.focus();
			despliegamodalm('visible','2','Faltan Datos para Completar el Registro');
		}
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
  <td colspan="3" class="cinta"><a href="inve-unidadmedida.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"  border="0" /></a><a href="#" onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png"  title="Guardar" /></a><a href="inve-buscaunidadmedida.php" class="mgbt"><img src="imagenes/busca.png"  title="Buscar" /></a><a href="#" onClick="mypop=window.open('inve-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a></td>
</tr></table>		  
</td></tr>
<tr><td colspan="3" class="tablaprin" align="center"> 

<div id="bgventanamodalm" class="bgventanamodalm">
	<div id="ventanamodalm" class="ventanamodalm">
    	<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
        </IFRAME>
  	</div>
</div>
<form name="form2" method="post" action="inve-unidadmedida.php">
	<?php
	$sqlr="select MAX(RIGHT(valor_inicial,2)) from dominios where nombre_dominio='unidad_medida' order by valor_inicial Desc";
  	$res=mysql_query($sqlr,$linkbd);
	if(mysql_num_rows($res)!=0){
		$row=mysql_fetch_row($res);
		$_POST[codigo]=$row[0]+1;
	  	if(strlen($_POST[codigo])==1){
			$_POST[codigo]='0'.$_POST[codigo];
		}
	}
	else{
		$_POST[codigo]='01';
	}
	?>
	<table class="inicio" align="center" >
    	<tr >
        	<td class="titulos" colspan="8">.: Agregar Unidades de Medida</td>
           	<td class="cerrar" ><a href="inve-principal.php">Cerrar</a></td>
      	</tr>
      	<tr >
	  		<td class="saludo1">.: Codigo:</td>
        	<td>
            	<input id="codigo" name="codigo" type="text" value="<?php echo $_POST[codigo]?>" maxlength="2" size="2" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)">
        	</td>
        	<td class="saludo1">.: Unidad de Medida:</td>
        	<td>
            	<input id="nombre" name="nombre" type="text" value="<?php echo $_POST[nombre]?>" size="80" onKeyUp="return tabular(event,this)">
        	</td>
        	<td class="saludo1">.: Sigla:</td>
        	<td>
            	<input id="sigla" name="sigla" type="text" value="<?php echo $_POST[sigla]?>" size="10" onKeyUp="return tabular(event,this)" style="text-transform:uppercase;">
        	</td>
        	<td class="saludo1">.: Activo:</td>
        	<td>
            	<select name="estado" id="estado" >
          			<option value="S" selected>SI</option>
          			<option value="N">NO</option>
        		</select>   
                <input name="oculto" type="hidden" value="1">     
           	</td>
       </tr>  
	   <tr><td></td></tr>                  
    </table>
  	<?php
	$oculto=$_POST['oculto'];
	if($_POST[oculto]==2){
		$linkbd=conectar_bd();
		if($_POST[nombre]!=""){
			$nr="1";
			$sqlb="SELECT * FROM dominios WHERE (descripcion_valor='".($_POST[nombre])."' OR valor_final='".($_POST[sigla])."') AND nombre_dominio='unidad_medida'";
			$resb=mysql_query($sqlb,$linkbd);
			if(mysql_num_rows($resb)!=0){
				echo"<script>despliegamodalm('visible','2','El Nombre de la Unidad de Medida y/o Sigla YA Existen');</script>";
			}
			else{
				$sqlr="INSERT INTO dominios (valor_inicial, descripcion_valor, valor_final, tipo, nombre_dominio) VALUES ('".$_POST[codigo]."','".($_POST[nombre])."','".($_POST[sigla])."','".($_POST[estado])."', 'unidad_medida')";
				if(!mysql_query($sqlr,$linkbd)){
					echo"<script>despliegamodalm('visible','2','Error no se almaceno');</script>";
				}	
				else{
					echo"<script>despliegamodalm('visible','1','Se ha almacenado la Unidad de Medida con Exito');</script>";
				}
			}
 		}
	}
	?> 
    </td></tr>
<tr><td></td></tr>      
</table>
</form>
</body>
</html>