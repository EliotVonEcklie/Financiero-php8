<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";
session_start();
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<title>:: Spid - Planeacion Estrategica</title>
<script>
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
if (document.form2.codigo.value!='' && document.form2.nombre.value!='')
  {
	if (confirm("Esta Seguro de Guardar"))
  	{
  	document.form2.oculto.value=2;
  	document.form2.submit();
  	}
  }
  else{
  alert('Faltan datos para completar el registro');
  	document.form2.nombre.focus();
  	document.form2.nombre.select();
  }
 }

function agregardetalle()
{
if(document.form2.nombredet.value!="" )
{ 
				document.form2.agregadet.value=1;
	//			document.form2.chacuerdo.value=2;
				document.form2.submit();
 }
 else {
 alert("Falta informacion para poder Agregar");
 }
}

function eliminar(variable)
{
if (confirm("Esta Seguro de Eliminar"))
  {
document.form2.elimina.value=variable;
//eli=document.getElementById(elimina);
document.getElementById('elimina').value=variable;
//eli.value=elimina;
//vvend.value=variable;
document.form2.submit();
}
}
</script>
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<link href="css/css3.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="css/programas.js"></script>
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
    <tr><script>barra_imagenes("plan");</script><?php cuadro_titulos();?></tr>	 
    <tr><?php menu_desplegable("plan");?></tr>
        <tr>
  <td colspan="3" class="cinta"><a href="#" ><img src="imagenes/add.png"  alt="Nuevo" border="0" /></a> <a href="#"  onClick="guardar()"><img src="imagenes/guarda.png"  alt="Guardar" /></a> <a href="plan-plandesarrollo.php"><img src="imagenes/busca.png"  alt="Buscar" border="0" /></a> <a href="#" onClick="mypop=window.open('plan-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana"></a></td>
</tr></table>
 <tr> 
 <td colspan="3"> 
 <form name="form2" method="post"> 
 <?php
    $vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
   $linkbd=conectar_bd(); 
   $sqlr="select *from dominios where nombre_dominio='VIGENCIA_PD' and tipo='S' order by VALOR_INICIAL";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
	{
		$_POST[vigenciai]=$row[0];
		$_POST[vigenciaf]=$row[1]; 	
	}
 		if($_POST[oculto]=="")
		{
		$_POST[meta]=$_GET[idproceso];	
		$vanterior=buscavariable_pd($_POST[meta],$_POST[vigenciai],$_POST[vigenciaf]);
		$_POST[nmeta]=$vanterior[1];			
		$_POST[anterior]=$vanterior[3];
		$vanterior=buscavariable_pd($_POST[anterior],$_POST[vigenciai],$_POST[vigenciaf]);
		$_POST[nombre]=$vanterior[1];	
		$_POST[ctipo]=$_GET[tipo];		
		$_POST[tipo]=tipos_pd($_POST[ctipo]);				
		} 
 ?>
   <table class="inicio" >
   <tr>
     <td class="titulos" colspan="4">Datos Plan de Desarrollo</td><td class="cerrar" ><a href="plan-principal.php">Cerrar</a></td></tr>
     <tr><td class="saludo1">Codigo:</td><td ><input type="text" name="meta" value="<?php echo $_POST[meta]?>" size="30" readonly></td>
     <td class="saludo1">Descripcion:</td><td ><input type="text" name="nmeta" value="<?php echo $_POST[nmeta]?>" size="100" readonly></td>
     </tr>
     
   <tr><td class="saludo1">Tipo:</td><td><input name="ctipo" type="hidden" value="<?php echo $_POST[ctipo]?>" ><input name="tipo" type="text" value="<?php echo $_POST[tipo]?>" size="15" readonly></td><td class="saludo1">Nivel Anterior</td><td><input name="anterior" value="<?php echo $_POST[anterior]?>" size="20" readonly><input name="nombre" value="<?php echo $_POST[nombre]?>" size="80" readonly><input type="hidden" name="oculto" value="1"><input type="hidden" name="vigenciai" value="<?php echo $_POST[vigenciai]?>"><input type="hidden" name="vigenciaf" value="<?php echo $_POST[vigenciaf]?>"></td></tr>
   <tr>
   <td class="saludo1">Estado</td><td> <select name="estado" id="estado" onKeyUp="return tabular(event,this)" >
          <option value="S" <?php if($_POST[estado]=='S') echo "SELECTED"; ?>>Activo</option>
          <option value="N" <?php if($_POST[estado]=='N') echo "SELECTED"; ?>>Inactivo</option>
        </select></td>
   </tr>
   </table>   
 <table class="inicio">
    
    <?php
	if ($_POST[tipo]==6)
	{
		echo "<tr >";
    for($x=$_POST[vigenciai]; $x<=$_POST[vigenciaf];$x++)
	{
				//****cargar indicadores o metas
		echo "<td class='titulos'>Tipo</td><td class='titulos' colspan=2>Valor Programado $x<input type='hidden' name='vigenciasm[]' value='$x'></td>";		
	}
	echo "</tr> ";
	?>
   <tr class="saludo1">
    <?php
	$c=0;
    for($x=$_POST[vigenciai]; $x<=$_POST[vigenciaf];$x++)
	{
		$sqlr="select *from planmetasindicadores where codigo='$_POST[meta]' and vigencia=$x";
		$res=mysql_query($sqlr,$linkbd);
		while ($rv =mysql_fetch_row($res)) 
		{	
	echo "<td><input type='hidden' name='tipoind[]' value='".$rv[]."'></td><td><input type='number' name='vmetas[]' value='".$rv[3]."' onKeyPress='solonumeros(event)' min=0 placeholder='Valor Programado' readonly></td><td><input type='number' name='vmetaseje[]' value='".$_POST[vmetaseje][$c]."' onKeyPress='solonumeros(event)' min=0 placeholder='Valor Ejecutado'></td>";	
	$c+=1;
		}
	}	
		?>
	</tr>   
    <?php
	}

	if ($_POST[tipo]==5)
	{
	echo "<tr>";
	for($x=$_POST[vigenciai]; $x<=$_POST[vigenciaf];$x++)
	{
				//****cargar indicadores o metas
		echo "<td class='titulos' colspan=2>Valor Programado $x<input type='hidden' name='vigenciasm[]' value='$x'></td>";		
	}
	echo "</tr>";
	?>
	<tr class="saludo1">
    <?php
	$c=0;
    for($x=$_POST[vigenciai]; $x<=$_POST[vigenciaf];$x++)
	{
		$sqlr="select *from planmetasindicadores where codigo='$_POST[meta]' and vigencia=$x";
		$res=mysql_query($sqlr,$linkbd);
		while ($rv =mysql_fetch_row($res)) 
		{	
		$sqlr="select distinct * from  pptocdp,pptocdp_detalle,presucdpplandesarrollo where presucdpplandesarrollo.codigo_meta='$_POST[meta]' and presucdpplandesarrollo.id_cdp =pptocdp_detalle.consvigencia and presucdpplandesarrollo.vigencia=$x and pptocdp_detalle.vigencia=$x and pptocdp_detalle.consvigencia=pptocdp.consvigencia and pptocdp.vigencia=$x";		
		echo "<br>".$sqlr;
	echo "<td><input type='number' name='vmetas[]' value='".$rv[3]."' onKeyPress='solonumeros(event)' min=0 placeholder='Valor Programado' readonly></td><td><input type='number' name='vmetaseje[]' value='".$_POST[vmetaseje][$c]."' onKeyPress='solonumeros(event)' min=0 placeholder='Valor Ejecutado'></td>";	
	$c+=1;
		}
	}	
		?>
	</tr>   
	<?php
    }
	?>
          
  </table>  
    
 <?php  
 //********guardar
 if($_POST[oculto]=="2")
	{
	$sqlr="insert into calvaraccion (nombre,estado) values ('$_POST[nombre]','$_POST[estado]') ";	
	if (!mysql_query($sqlr,$linkbd))
		{
		 echo "<script>alert('ERROR EN LA CREACION DEL INDICADOR');document.form2.nombre.focus();</script>";
		 echo $sqlr;
		}
		  else
		  {
			$nid=mysql_insert_id($linkbd);
		   echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado la Variable del Plan de Accion con Exito <img src='imagenes\confirm.png'></center></td></tr></table>";
		   for ($x=0;$x<count($_POST[dnvars]);$x++)
		 	{
			 $sqlr="insert into calvaraccion_det (id_varaccion, nombre,id_det, adjunto,estado) values ($nid, '".$_POST[dnvars][$x]."','".$_POST[dids][$x]."','".$_POST[dadjs][$x]."','S') ";	
			 mysql_query($sqlr,$linkbd);
			}
		  }
	}
 ?>
 </form>       
 </td>       
 </tr>       
	</table>
</body>
</html>