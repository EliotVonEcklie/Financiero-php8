<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	require "conversor.php";
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
		<title>:: Spid - Presupuesto</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script src="css/calendario.js"></script>
		<script src="css/programas.js"></script>
		<script>
			function eliminar(idr)
			{
				if (confirm("Esta Seguro de Eliminar el Sub-Menu "+idr))
				{
				document.form2.oculto.value=2;
				document.form2.var1.value=idr;
				document.form2.var2.value=idr;
				document.form2.submit();
				}
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
		  	{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
			  	if(_valor=="hidden"){document.getElementById('ventanam').src="";}
			  	else
			  	{
					switch(_tip)
					{
						case "2":
							document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
						case "5":
							var idcdp=document.form2.var2.value;
							document.getElementById('ventanam').src="ventana-comentarios.php?infor="+mensa+"&tabl=pptoanulaciones&tipo=CDP&idr="+idcdp;break;
					}
					
				}
		  }
</script>
		<?php titlepag();?>
    </head>
    <body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("adm");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("adm");?></tr>
        	<tr>
          		<td colspan="3" class="cinta">
				<a href="#" class="mgbt"><img src="imagenes/add2.png" title="Nuevo"/></a>
				<a class="mgbt"><img src="imagenes/guardad.png" /></a>
				<a href="adm-listasubmenus.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a>
				<a href="#" onClick="mypop=window.open('adm-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
			</tr>
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
 		<form name="form2" method="post" action="adm-listasubmenus.php">
        	<input name="var2" id="var2" type="hidden" value=<?php echo $_POST[var2];?>>
       	<?php
			$oculto=$_POST['oculto'];
			$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
			if($_POST[oculto]==2)
			{	
				$sqlr="delete * from opciones where id_opcion=''";	
				$resp = mysql_query($sqlr,$linkbd);
				$cont=0;
				
				
			}
?>
<table width="60%" align="center"  class="inicio" >
      <tr >
        <td class="titulos" colspan="4">:: Lista Sub-menus Sistema SPID<input type="hidden" value="1" name="oculto2">
        </td>
        <td width="9%" class="cerrar" ><a href="presu-principal.php">Cerrar</a></td>
             <input name="oculto" type="hidden" value="1"><input name="var1" id="var1" type="hidden" value=<?php echo $_POST[var1];?>>
    </tr>
    <tr></tr>
    <tr></tr>
    <tr>
    	<td class="saludo1" style="width:5%">N&uacute;mero:</td>
        <td >
            <input name="numero" type="search" id="numero" value="<?php echo $_POST[numero] ?>" style='width:10%;'/>
            
        </td>
    </tr>
    
</table>
<div class="subpantalla" style="height:66.5%; width:99.6%; overflow-x:hidden;">
 <?php
if ($_POST[numero]!="")
$crit2=" and pptocdp.consvigencia like '%$_POST[numero]%' ";
$linkbd=conectar_bd();
 	$sqlr="select *from opciones order by id_opcion desc";
// echo "<div><div>sqlr:".$sqlr."</div></div>";
$resp = mysql_query($sqlr,$linkbd);
$ntr = mysql_num_rows($resp);
$con=1;
echo "<table class='inicio' align='center' width='80%'>
	<tr>
		<td colspan='8' class='titulos'>.: Resultados Busqueda:</td>
	</tr>
	<tr>
		<td colspan='5'>Sub-Menus Encontrados: $ntr</td>
	</tr>
	<tr>
		<td width='5%' class='titulos2'>id</td>
		<td class='titulos2'>Nombre</td>
		<td class='titulos2'>Ruta</td>
		<td class='titulos2'>Modulo</td>
		<td class='titulos2'>Nivel</td>
		<td class='titulos2' width='10%'>Orden</td>
		<td class='titulos2' width='5%'>Eliminar</td></tr>";	
//echo "nr:".$nr;
$iter='zebra1';
$iter2='zebra2';
 while ($row =mysql_fetch_row($resp)) 
 {
	 echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\">
	 	<td >$row[0]</td>
		<td >$row[1]</td>
		<td >$row[2]</td>
		<td >$row[6]</td>
		<td >$row[3]</td>
		<td >$row[5]</td>
		<td ><a href='#' onClick=eliminar($row[0])><center><img src='imagenes/anular.png'></center></a></td></tr>";
	 $con+=1;
	 $aux=$iter;
	 $iter=$iter2;
	 $iter2=$aux;
 }
 echo"</table>";
 ?>
 </div>
</form>
</body>
</html>