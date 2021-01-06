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
		<title>:: Spid - Calidad</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
<script>
//************* ver reporte ************
//***************************************
function verep(idfac)
{
  document.form1.oculto.value=idfac;
  document.form1.submit();
}
</script>
<script>
//************* genera reporte ************
//***************************************
function genrep(idfac)
{
  document.form2.oculto.value=idfac;
  document.form2.submit();
}
</script>
<script>
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
</script>
<script >
function clasifica(formulario)
{
//document.form2.action="presu-recursos.php";
document.form2.submit();
}
</script>

<?php titlepag();?>
</head>
<body>
	<table>
		<tr>
			<script>barra_imagenes("contra");</script>
			<?php cuadro_titulos();?>
		</tr>	 
		<tr>
			 <?php menu_desplegable("contra");?>
		</tr>
		<tr>
			<td colspan="3" class="cinta">
				<a href="contra-anexos.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" border="0" /></a>
				<a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a>
				<a href="contra-buscaanexos.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" border="0"/></a>
				<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
				<a href="#" onClick="mypop=window.open('contra-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva ventana"></a>
			</td>
		</tr>
	</table>
 	<form name="form2" method="post"> 
 	<?php
    	$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
   		$linkbd=conectar_bd(); 
 		if($_POST[oculto]=="")
		{
		$sqlr="Select * from contraanexos where id=$_GET[idproceso] ";
		$resp = mysql_query($sqlr,$linkbd);
	    while ($row =mysql_fetch_row($resp))
		{
		$_POST[codigo]=$row[0];
		$_POST[nombre]=$row[1];					
		$_POST[estado]=$row[2];		
		$_POST[tipo]=$row[4];				
		}
		}
 	?>
<table class="inicio" >
	<tr>
		<td class="titulos" colspan="4">Crear Anexos</td><td class="cerrar" ><a href="contra-principal.php">Cerrar</a></td></tr>
    <tr>
   		<td class="saludo1">Codigo:</td><td><input name="codigo" type="text" value="<?php echo $_POST[codigo]?>" size="3"></td><td class="saludo1">Nombre</td><td><input name="nombre" value="<?php echo $_POST[nombre]?>" size="50"><input type="hidden" name="oculto" value="1"></td></tr>
   <tr> 
    	<td class="saludo1">Tipo</td><td> <select name="tipo" id="tipo" onKeyUp="return tabular(event,this)"  >
            	<option  value="" >Seleccione....</option>
				<?php
								$sqlr="SELECT * FROM dominios where nombre_dominio='CONTRATACION_ANEXOS'";
								$res=mysql_query($sqlr,$linkbd);
								while ($rowEmp = mysql_fetch_row($res)) 
				    			{
									echo "<option value= ".$rowEmp[0];
									$i=$rowEmp[0];
					 				if($i==$_POST[tipo])
			 						{
						 				echo "  SELECTED";
						 			}
					  				echo ">".$rowEmp[0]." - ".$rowEmp[1]."</option>";	 	 
								}	
              			?> 
        	</select></td>
   		<td class="saludo1">Estado</td><td> <select name="estado" id="estado" onKeyUp="return tabular(event,this)" >
          <option value="S" <?php if($_POST[estado]=='S') echo "SELECTED"; ?>>Activo</option>
          <option value="N" <?php if($_POST[estado]=='N') echo "SELECTED"; ?>>Inactivo</option>
        </select></td>
    </tr>
   </table>
 <?php  
 //********guardar
 if($_POST[oculto]=="2")
	{
	$sqlr="update  contraanexos set nombre='$_POST[nombre]',estado ='$_POST[estado]', fase='$_POST[tipo]' where id=$_POST[codigo]  ";	
	if (!mysql_query($sqlr,$linkbd))
		{
		 echo "<script>alert('ERROR EN LA CREACION DEL ANEXO');document.form2.nombre.focus();</script>";
		 echo $sqlr;
		}
		  else
		  {
		   echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha Actualizado el ANEXO con Exito <img src='imagenes\confirm.png'></center></td></tr></table>";
		  }
	}
 ?>
 </form>       
 </td>       
 </tr>       
	</table>
</body>
</html>