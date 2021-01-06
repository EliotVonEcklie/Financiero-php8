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
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
<title>:: Spid - Contrataci&oacute;n</title>
<?php titlepag();?>
 <link rel="stylesheet" href="treeview/jquery.treeview.css" />
    <link rel="stylesheet" href="treeview/red-treeview.css" />
	<link rel="stylesheet" href="css/screen.css" />
	<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
	<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="css/programas.js"></script>
	<script src="treeview/lib/jquery.js" type="text/javascript"></script>
	<script src="treeview/lib/jquery.cookie.js" type="text/javascript"></script>
	<script src="treeview/jquery.treeview.js" type="text/javascript"></script>
    <script type="text/javascript">
	$(document).ready(function(){
		$("#browser").treeview({
			toggle: function() {
				console.log("%s was toggled.", $(this).find(">span").text());
			}
		});
		
		$("#add").click(function() {
			var branches = $("<li><span class='folder'>New Sublist</span><ul>" + 
				"<li><span class='file'>Item1</span></li>" + 
				"<li><span class='file'>Item2</span></li></ul></li>").appendTo("#browser");
			$("#browser").treeview({
				add: branches
			});
		});
	});
	</script> 
    <script type="text/javascript">
		$(function() {
			$("#add").treeview({
				collapsed: true,
				animated: "fast",
				control:"#sidetreecontrol",
				prerendered: true,
				persist: "location"
			});
		})
		
	</script>

</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
    <tr><script>barra_imagenes("contra");</script><?php cuadro_titulos();?></tr>	 
    <tr><?php menu_desplegable("contra");?></tr>
	<tr>
		<td colspan="3" class="cinta">
			<a href="contra-productosguardar.php" class="mgbt"><img src="imagenes/add.png"  title="Nuevo" border="0" /></a>
			<a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  title="Guardar" /></a>
			<a href="#" onClick="document.form2.submit()" class="mgbt"><img src="imagenes/busca.png" title="Buscar" border="0" /></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('contra-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a>
		</td>
	</tr>
</table>	
<tr><td colspan="4" class="tablaprin"> 
 <form name="form2" method="post" action="contra-productosbuscar.php">
<table  class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="1">:: PRODUCTOS         <input name="oculto" type="hidden" value="1"></td>
        <td class="cerrar" ><a href="meci-principal.php">Cerrar</a></td>
      </tr>
      <tr><td colspan="2">
    <div class="subpantallac5" >
     
      <?php
$oculto=$_POST['oculto'];
if($_POST[oculto])
{
	?>
<div id="main">
<?php
$linkbd=conectar_bd();
$crit1=" ";
$crit2=" ";
if ($_POST[nombre]!="")
$crit1=" and (caldocumentos.nombre like '%".$_POST[nombre]."%') ";
if ($_POST[documento]!="")
$crit2=" and caldocumentos.id like '%$_POST[documento]%' ";
//sacar el consecutivo 
$crit3="and padre ='0'";
$sqlr1="Select * from productospaa  where tipo='1'  and estado='S' ".$crit3." order by tipo,codigo asc";
// echo "<div><div>sqlr:".$sqlr."</div></div>";
$resp1 = mysql_query($sqlr1,$linkbd);
$ntr = mysql_num_rows($resp1);
$con=1;
echo " <ul id='browser' class='filetree treeview-famfamfam'>";
$iter='saludo1';
$iter2='saludo2';
$minimaprioridad="5";
 while ($row1 =mysql_fetch_row($resp1)) 
 {
	
	// echo "	 	<tr class='$iter' >	 		<td>".strtoupper($row1[0])."</td>			<td colspan=\"5\">".utf8_decode(strtoupper($row1[1]))."</td>		</tr>";
	 echo "<li><span class='$clase'>$row1[0] $row1[1]</span>";
	 $padre=$row1[0];
	// buscaplan($padre,$row[5],$ultimaprioridad,$iter,$iter2);
	 $con+=1;
	 
	 buscaproductos_arbol($row1[0],$row1[2],$minimaprioridad,$iter,$iter2);
 }
 echo " </ul>";
 ?>
 </div>
 <?php
}
?>   
    </td></tr></table></div> </form></td></tr>
</table>
</body>
</html>