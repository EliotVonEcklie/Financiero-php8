<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
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
		<title>:: Spid - Activos Fijos</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script>
        	function guardar()
			{
				
				var validacion01=document.getElementById('nombre').value;
				if(validacion01.trim()!=''){despliegamodalm('visible','4','Esta Seguro de Modificar','1');}
				else {despliegamodalm('visible','2','Falta informacion para modificar el Centro Costo');}
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
							document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
					}
				}
			}
			function funcionmensaje(){}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":
						document.getElementById('oculto').value='2';
						document.form2.submit();
						break;
				}
			}
        </script>
		<script>
			function adelante(scrtop, numpag, limreg, filtro, next){
				var maximo=document.getElementById('maximo').value;
				var actual=document.getElementById('idcomp').value;
				if(parseFloat(maximo)>parseFloat(actual)){
					document.getElementById('oculto').value='1';
					document.getElementById('idcomp').value=next;
					document.getElementById('codigo').value=next;
					var idcta=document.getElementById('idcomp').value;
					document.form2.action="acti-editarubicacion.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
		
			function atrasc(scrtop, numpag, limreg, filtro, prev){
				var minimo=document.getElementById('minimo').value;
				var actual=document.getElementById('idcomp').value;
				if(parseFloat(minimo)<parseFloat(actual)){
					document.getElementById('oculto').value='1';
					document.getElementById('idcomp').value=prev;
					document.getElementById('codigo').value=prev;
					var idcta=document.getElementById('idcomp').value;
					document.form2.action="acti-editarubicacion.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
		
			function iratras(scrtop, numpag, limreg, filtro){
				var idcta=document.getElementById('idcomp').value;
				location.href="acti-buscaubicacion.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
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
	<tr><script>barra_imagenes("acti");</script><?php cuadro_titulos();?></tr>
	<tr><?php menu_desplegable("acti");?></tr>
	<tr>
		<td colspan="3" class="cinta">
			<a href="acti-ubicacion.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a>
			<a href="#" onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a>
			<a href="acti-buscaubicacion.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('acti-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"/></a>
			<a href="#" class="mgbt" onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)"><img src="imagenes/iratras.png" title="Atr&aacute;s" /></a>
		</td>
	</tr>
</table>
<?php
			if ($_GET[idtipocom]!=""){echo "<script>document.getElementById('codrec').value=$_GET[idtipocom];</script>";}
			$sqlr="select MIN(CONVERT(id_cc, SIGNED INTEGER)), MAX(CONVERT(id_cc, SIGNED INTEGER)) from actiubicacion ORDER BY CONVERT(id_cc, SIGNED INTEGER)";
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
			$_POST[minimo]=$r[0];
			$_POST[maximo]=$r[1];
			if($_POST[oculto]==""){
				if ($_POST[codrec]!="" || $_GET[idtipocom]!=""){
					if($_POST[codrec]!=""){
						$sqlr="select *from actiubicacion where id_cc='$_POST[codrec]'";
					}
					else{
						$sqlr="select *from actiubicacion where id_cc='$_GET[idtipocom]'";
					}
				}
				else{
					$sqlr="select * from  actiubicacion ORDER BY CONVERT(id_cc, SIGNED INTEGER) DESC";
				}
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
			   	$_POST[codigo]=$row[0];
			   	$_POST[idcomp]=$row[0];
			}

if($_POST[oculto]!=2)
{
$linkbd=conectar_bd();
$sqlr="Select *from actiubicacion where id_cc=$_POST[idcomp]";
$res=mysql_query($sqlr,$linkbd);
//echo $sqlr;
while($row=mysql_fetch_row($res))
  {
   $_POST[idcomp]=$row[0];
   $_POST[nombre]=$row[1];
   $_POST[estado]=$row[2];
   $_POST[codigo]=$row[0];
  }
}

			//NEXT
			$sqln="select *from actiubicacion WHERE id_cc > '$_POST[idcomp]' ORDER BY id_cc ASC LIMIT 1";
			$resn=mysql_query($sqln,$linkbd);
			$row=mysql_fetch_row($resn);
			$next="'".$row[0]."'";
			//PREV
			$sqlp="select *from actiubicacion WHERE id_cc < '$_POST[idcomp]' ORDER BY id_cc DESC LIMIT 1";
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
    <table class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="6">.: Editar Ubicacion</td><td class="cerrar"><a href="acti-principal.php">Cerrar</a></td>
      </tr>
      <tr  >
	    <td class="saludo1">Codigo:
        </td>
        <td style="width:10%">
	        	    	<a href="#" onClick="atrasc(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $prev; ?>)"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> 
        	<input name="codigo" id="codigo" type="text" value="<?php echo $_POST[codigo]?>" style="width:50%"  maxlength="2" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)">
	    	            <a href="#" onClick="adelante(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $next; ?>)"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
						<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo" id="maximo">
						<input type="hidden" value="<?php echo $_POST[minimo]?>" name="minimo" id="minimo">
						<input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">
        </td>
        <td class="saludo1">Nombre:
        </td>
        <td><input name="nombre" id="nombre" type="text" value="<?php echo $_POST[nombre]?>" size="80"  onKeyUp="return tabular(event,this)">
        </td>
        <td class="saludo1">Activo:
        </td>
        <td><select name="estado" id="estado">
          <option value="S" <?php if($_POST[estado]=='S') echo "selected" ?>>SI</option>
          <option value="N" <?php if($_POST[estado]=='N') echo "selected" ?>>NO</option>
        </select>   <input name="oculto" id="oculto" type="hidden" value="1">  <input name="idcomp" id="idcomp" type="hidden" value="<?php echo $_POST[idcomp]?>" >   </td>
       </tr>  
	   <tr><td></td></tr>                  
    </table>
    </form>
  <?php
$oculto=$_POST['oculto'];
if($_POST[oculto]==2)
{
$linkbd=conectar_bd();
if ($_POST[nombre]!="")
 {
 $nr="1";
 $sqlr="update actiubicacion set nombre='".$_POST[nombre]."',estado='$_POST[estado]',id_cc='$_POST[codigo]' where id_cc='$_POST[idcomp]'";
 //echo "sqlr:".$sqlr;
  if (!mysql_query($sqlr,$linkbd))
	{
	 echo "<table><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
//	 $e =mysql_error($respquery);
	 echo "Ocurrió el siguiente problema:<br>";
  	 //echo htmlentities($e['message']);
  	 echo "<pre>";
     ///echo htmlentities($e['sqltext']);
    // printf("\n%".($e['offset']+1)."s", "^");
     echo "</pre></center></td></tr></table>";
	}
  else
  {
  echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha actualizado con Exito <img src='imagenes\confirm.png' ></center></td></tr></table>";
  }
 }
else
 {
  echo "<table><tr><td class='saludo1'><center>Falta informacion para Crear la Ubicacion <img src='imagenes\alert.png' ></center></td></tr></table>";
 }
}
?> 
</body>
</html>