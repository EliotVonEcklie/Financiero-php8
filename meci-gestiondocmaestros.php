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
    <title>:: Spid - Meci Calidad</title>
    <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="css/programas.js"></script>
	<script>
		function excell()
		{
			var tinfo=document.form1.tinforme.value;
			//var lista=document.form2.tdocumento.value;
			if (tinfo==0) {
				
			}else {
				document.form1.action="meci-gestiondocmaestrosexcel.php";
				document.form1.target="_BLANK";
				document.form1.submit();
				document.form1.action="";
				document.form1.target="";
			}
		}
		function pdf()
		{
			var tinfo=document.form1.tinforme.value;
			//var lista=document.form2.tdocumento.value;
			if (tinfo==0) {
				
			}else {
				document.form1.action="pdfmeci-gestiondocm.php";
				document.form1.target="_BLANK";
				document.form1.submit();
				document.form1.action="";
				document.form1.target="";
			}
		}
	</script>
	<script>
		function cargarinforme()
		{
			var tinfo=document.form1.tinforme.value;
			switch(tinfo)
			{
				case "1":
					var winat="derogados";
					var pagaux="meci-gestionmaestrospro.php";
					document.getElementById('botbuscar').innerHTML='<img src="imagenes/busca.png" title="Buscar" onclick="parent.derogados.funbuscar();">';
					///document.getElementById('botpdf').innerHTML='<img src="imagenes/print.png" title="pdf" onclick="parent.derogados.pdf();">';
					break;
				case "2":
					var winat="enmejora";
					var pagaux="meci-gestionmaestrosdoc.php";
					document.getElementById('botbuscar').innerHTML='<img src="imagenes/busca.png" title="Buscar" onclick="parent.enmejora.funbuscar();">';
					break;
				default:
					document.form1.submit();
			}
			if(tinfo!="0")
			{
				document.getElementById('todastablas').innerHTML='<IFRAME src="'+pagaux+'" name="'+winat+'" scrolling="no" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana1" frameSpacing=0 style="width:100%; height:65%;"></IFRAME>';
			}
		}
		
    </script>

    <?php titlepag();?>
</head>
<body>
    <table>
		<tr>
			<script>barra_imagenes("meci");</script>
			<?php cuadro_titulos();?>
		</tr>	 
        <tr>
         	<?php menu_desplegable("meci");?>
        </tr>
       	<tr>
			<td colspan="3" class="cinta">
				<a href="#" class="mgbt"><img src="imagenes/add2.png"/></a>
        		<a href="#" class="mgbt"><img src="imagenes/guardad.png"/></a> 
          		<a href="#" id="botbuscar" class="mgbt"><img src="imagenes/buscad.png"/></a> 				
            	<a href="#" onClick="mypop=window.open('meci-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
				<img src="imagenes/print.png" title="Imprimir" onClick="pdf()" class="mgbt"/>
               	<img src="imagenes/excel.png" title="Excel" onClick='excell()' class="mgbt"/>		   
          	</td>
		</tr>
	</table>	
 	<form name="form1" method="post" action="#">
    <table  class="inicio" align="center">
    	<tr>
        	<td class="titulos" colspan="3" style="width:90%">:: Listado Maestro de Documentos </td>
        	<td width="10%" class="cerrar" ><a href="meci-principal.php">Cerrar</a></td>
     	</tr>
      	<tr>
        	<td style="width:5%" class="saludo1">Seleccionar Informe:</td>
        	<td >
            	<select id="tinforme" name="tinforme" class="elementosmensaje" style="width:30%"  onKeyUp="return tabular(event,this)"  onChange="cargarinforme();" >
					<option onChange="" value="0" <?php if($_POST[tinforme]=="0"){echo " SELECTED";}?>   >Seleccione....</option>
                    <option onChange="" value="1" <?php if($_POST[tinforme]=="1"){echo " SELECTED";}?>  >Listado por Procesos</option>
                    <option onChange="" value="2"<?php if($_POST[tinforme]=="2"){echo " SELECTED";}?>   >Listado por Documentos</option>
           		</select> 
            </td>
       </tr>                       
    </table>
    <input name="menubotones" id="menubotones" type="hidden" value="<?php echo $_POST[menubotones]?>">
	<span id="todastablas" ></span> 
	<input name="listado" id="listado" type="hidden" value="<?php echo $_POST[listado]?>">
    </form>

</body>
</html>