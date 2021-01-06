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
		function cargarinforme()
		{
			var tinfo=document.form1.tinforme.value;
			switch(tinfo)
			{
				case "1":
					var winat="derogados";
					var pagaux="meci-docderogados1.php";
					document.getElementById('botbuscar').innerHTML='<img src="imagenes/busca.png" title="Buscar" onclick="parent.derogados.funbuscar();cargabotones(\'1\');">';
					break;
				case "2":
					var winat="enmejora";
					var pagaux="meci-docenmejora1.php";
					document.getElementById('botbuscar').innerHTML='<img src="imagenes/busca.png" title="Buscar" onclick="parent.enmejora.funbuscar();cargabotones(\'2\');">';
					break;
				case "3":
					var winat="mejoraspub";
					var pagaux="meci-docmejoraspub.php";
					document.getElementById('botbuscar').innerHTML='<img src="imagenes/busca.png" title="Buscar" onclick="parent.mejoraspub.funbuscar();cargabotones(\'3\');">';
					break;
				default:
					document.form1.submit();
			}
			if(tinfo!="0")
			{
				document.getElementById('todastablas').innerHTML='<IFRAME src="'+pagaux+'" name="'+winat+'" scrolling="no" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana1" frameSpacing=0 style="width:100%; height:65%;"></IFRAME>';
			}
		}
		function cargabotones(tinf)
		{
			document.getElementById('botcsv').innerHTML='<img src="imagenes/csv.png" title="csv">';
			switch (tinf)
			{
				case "1":
					document.getElementById('botcsv').href="informacion/temp/documentos_derogados.csv";
					break;
				case "2":
					document.getElementById('botcsv').href="informacion/temp/documentos_en_mejora.csv";
					break;
				case "3":
					document.getElementById('botcsv').href="informacion/temp/mejoras_publicadas.csv";
					break;
			}
		}
    </script>
    <?php titlepag();?>
</head>
<body>
    <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
    <span id="todastablas2"></span>
    <table>
		<tr><script>barra_imagenes("meci");</script><?php cuadro_titulos();?></tr>	 
		<tr><?php menu_desplegable("meci");?></tr>
       	<tr>
			<td colspan="3" class="cinta">
				<a href="#" class="mgbt"><img src="imagenes/add2.png"/></a>
        		<a href="#" class="mgbt"><img src="imagenes/guardad.png"/></a> 
          		<a href="#" id="botbuscar" class="mgbt"><img src="imagenes/buscad.png"/></a> 
            	<a href="#" onClick="mypop=window.open('meci-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
               <a id="botcsv" href="#" class="mgbt"><img src="imagenes/csvb.png"></a>
          	</td>
		</tr>
	</table>	
 	<form name="form1" method="post" action="#">
    <table  class="inicio" align="center">
    	<tr>
        	<td class="titulos" colspan="2" style="width:90%">:: Informes Gesti&oacute;n Documental </td>
        	<td width="10%" class="cerrar" ><a href="meci-principal.php">Cerrar</a></td>
     	</tr>
      	<tr>
        	<td style="width:5%" class="saludo1">Seleccionar Informe:</td>
        	<td >
            	<select id="tinforme" name="tinforme" class="elementosmensaje" style="width:30%"  onKeyUp="return tabular(event,this)"  onChange="cargarinforme();" >
					<option onChange="" value="0" <?php if($_POST[tinforme]=="0"){echo " SELECTED";}?>   >Seleccione....</option>
                    <option onChange="" value="1" <?php if($_POST[tinforme]=="1"){echo " SELECTED";}?>  >Documentos Derogados</option>
                    <option onChange="" value="2"<?php if($_POST[tinforme]=="2"){echo " SELECTED";}?>   >Documentos En Mejora</option>
                    <option onChange="" value="3"<?php if($_POST[tinforme]=="3"){echo " SELECTED";}?>   >Mejoras Publicadas</option>
           		</select> 
            </td>

       </tr>                       
    </table>
    <input name="menubotones" id="menubotones" type="hidden" value="<?php echo $_POST[menubotones]?>">
    <span id="todastablas" ></span> 
    </form>

</body>
</html>