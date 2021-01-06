<?php
require"comun.inc";
require"funciones.inc";
session_start();
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
	$scroll=$_GET['scrtop'];
	$totreg=$_GET['totreg'];
	$idcta=$_GET['idcta'];
	$altura=$_GET['altura'];
	$buscta=$_GET['buscta'];
	$ruta="'".$_GET['ruta']."'";
	//$vigfin="'".$_GET['vigfin']."'";
	$padret="'".$_GET['padre']."'";
	$vigini=$_GET['vigini'];
	$vigfin=$_GET['vigfin'];
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<title>:: Spid - Planeacion Estrategica</title>
<script>
	function guardar()
	{
		var validacion01=document.getElementById('nmeta').value;
		if (validacion01.trim()!='')
		{
			despliegamodalm('visible','4','Esta Seguro de Guardar','1');
		}
		else {despliegamodalm('visible','2','Faltan datos para completar el registro');}
	}


			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden")
				{
					document.getElementById('ventanam').src="";
					if (document.getElementById('valfocus').value!="0")
					{
						document.getElementById('valfocus').value='0';
						document.getElementById('consecutivo').focus();
						document.getElementById('consecutivo').select();
					}
				}
				else
				{
					switch(_tip)
					{
						case "1":	document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
						case "2":	document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
						case "3":	document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
						case "4":	document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
					}
				}
			}
			function funcionmensaje(){document.location.href = "";}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.form2.oculto.value="2";
								document.form2.submit();break;
				}
			}

</script>
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<link href="css/css3.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="css/programas.js"></script>
		<script>
			function iratras(scrtop, numpag, limreg, vigini, vigfin, padre, ruta){
				var idcta=document.getElementById('meta').value;
				location.href="plan-buscaplandesarrollo.php?idcta="+idcta+"&vigini="+vigini+"&vigfin="+vigfin+"&padret="+padre+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&ruta="+ruta;
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
	<tr><script>barra_imagenes("plan");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("plan");?></tr>
        <tr>
  <td colspan="3" class="cinta">
	<a href="#" class="mgbt"><img src="imagenes/add.png"  alt="Nuevo" border="0" /></a> 
	<a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  alt="Guardar" /></a> 
	<a href="plan-buscaplandesarrollo.php" class="mgbt"><img src="imagenes/busca.png"  alt="Buscar" border="0" /></a> 
	<a href="#" onClick="mypop=window.open('plan-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana"></a>
	<a href="#" onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $vigini; ?>, <?php echo $vigfin; ?>, <?php echo $padret; ?>, <?php echo $ruta; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
	</td>
</tr>
</table>
         <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>

<form name="form2" method="post"> 
<?php
$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
$linkbd=conectar_bd(); 
$_POST[vigenciai]=$vigini;
$_POST[vigenciaf]=$vigfin; 	

if($_POST[oculto]=="")
{
	$_POST[meta]=$_GET[idproceso];	
	$vanterior=buscavariable_pd($_POST[meta],$_POST[vigenciai],$_POST[vigenciaf]);
	$_POST[nmeta]=$vanterior[1];			
	$_POST[anterior]=$vanterior[3];
	$vanterior=buscavariable_pd($_POST[anterior],$_POST[vigenciai],$_POST[vigenciaf]);
	$_POST[nombre]=$vanterior[1];	
	$_POST[tipo]=$_GET[tipo];		
	$_POST[ctipo]=tipos_pd($_POST[tipo]);				
} 
$medi=array();
if(count($_POST[mmetas])>0){
	for($i=0;$i<count($_POST[mmetas]);$i++){
		$medi[$i]=$_POST[mmetas][$i];
	}
}		
$cuanti=array();
if(count($_POST[vmetas])>0){
	for($i=0;$i<count($_POST[vmetas]);$i++){
		$cuanti[$i]=$_POST[vmetas][$i];
	}
}		
?>
   <table class="inicio" >
   <tr>
     <td class="titulos" colspan="4">Datos Plan de Desarrollo</td><td class="cerrar" ><a href="plan-principal.php">Cerrar</a></td></tr>
     <tr><td class="saludo1">Codigo:</td><td ><input type="text" name="meta" id="meta" value="<?php echo $_POST[meta]?>" size="30" readonly></td>
     <td class="saludo1">Descripcion:</td><td ><input type="text" name="nmeta" id="nmeta" value="<?php echo $_POST[nmeta]?>" size="100" ></td>
     </tr>
     
   <tr><td class="saludo1">Tipo:</td><td><input name="tipo" type="hidden" value="<?php echo $_POST[tipo]?>" ><input name="ctipo" type="text" value="<?php echo $_POST[ctipo]?>" size="15" readonly></td><td class="saludo1">Nivel Anterior</td><td><input name="anterior" value="<?php echo $_POST[anterior]?>" size="20" readonly><input name="nombre" value="<?php echo $_POST[nombre]?>" size="80" readonly><input type="hidden" name="oculto" value="1"></td></tr>
   <tr>
   <td class="saludo1">Estado</td><td> <select name="estado" id="estado" onKeyUp="return tabular(event,this)" >
          <option value="S" <?php if($_POST[estado]=='S') echo "SELECTED"; ?>>Activo</option>
          <option value="N" <?php if($_POST[estado]=='N') echo "SELECTED"; ?>>Inactivo</option>
        </select>
		</td>
        <td class="saludo1" style='width:10%'>Vigencia:</td>
        <td > 
						<input type="text" name="vigenciai" id="vigenciai" value="<?php echo $_POST[vigenciai]?>" style='width:10%' readonly> - 
						<input type="text" name="vigenciaf" id="vigenciaf" value="<?php echo $_POST[vigenciaf]?>" style='width:10%' readonly> 
                    </td>
   </tr>
   </table>   
    <?php  
 //********guardar
 if($_POST[oculto]=="2")
	{
		$sqlr="update presuplandesarrollo set nombre='$_POST[nmeta]' where id='$buscta'";	
		mysql_query($sqlr,$linkbd);
		//metas
		if (!mysql_query($sqlr,$linkbd))
		{
			echo "<div class='inicio'><img src='imagenes\alert.png'>No se pudo actualizar </div>";	
		}
		else
		{
			echo "<div class='inicio'><img src='imagenes\confirm.png'>Se actualizo con exito </div>";	
		}
	}
 ?>
 </form>       
 </td>       
 </tr>       
	</table>
</body>
</html>