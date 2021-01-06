<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	$linkbd=conectar_bd();
	session_start();
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
?>

<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
        <title>::Spid - Meci Calidad</title>
        <link rel="shortcut icon" href="favicon.ico"/>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type='text/javascript' src='funcioneshf.js'></script>
        <script type='text/javascript' src='css/programas.js'></script>
        <script>
			function cambiarwin(winat)
			{
				if (document.getElementById('winactiva').value != winat)
				{
					var pagaux;
					switch(winat)
					{	
						case "paginic":
							pagaux="adm-asignacioncargosbuscar.php";
							winat="winbuscar";
							break;
						case "winbuscar":
							pagaux="adm-asignacioncargosbuscar.php";
							document.getElementById('winactiva').value="winbuscar";
							document.getElementById('bot2').innerHTML=("<img src='imagenes/guardad.png' />");
							break;	
						case "winguardar":
							pagaux="adm-asignacioncargosguardar.php";
							document.getElementById('bot2').innerHTML=("<img src='imagenes/guarda.png' onClick='guardar_inf();'/>");
							document.getElementById('winactiva').value="winguardar";
							break;
					}
					document.getElementById('todastablas').innerHTML='<IFRAME src="'+pagaux+'" name="'+winat+'" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana1" frameSpacing=0 scrolling="no" style="width:100%; height:500px;"></IFRAME>';
				}
				if(winat=="winbuscar")
				{parent.winbuscar.document.formbuscar.oculto.value="1";parent.winbuscar.document.formbuscar.submit();}
				if(winat=="winguardar")
				{parent.winguardar.document.formguardar.oculto2.value="1";parent.winguardar.document.formguardar.submit();}
			}
			
			function guardar_inf()
			{
				if (confirm("¿Seguro de Guardar este Cargo?"))
				{parent.winguardar.document.formguardar.oculto.value="1";parent.winguardar.document.formguardar.submit();}
			}
			
			function modificar_inf(idmod)
			{	
				document.getElementById('todastablas').innerHTML='<IFRAME src="adm-asignacioncargosmodificar.php?dependcia='+idmod+'" name="winmodificar" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana1" frameSpacing=0 scrolling="no" style=" width:100%; height:500px;"></IFRAME>';
				document.getElementById('winactiva').value="winmodificar";
				document.getElementById('bot2').innerHTML=("<img src='imagenes/guarda.png' onClick='guardar_modificar();'/>");
			}
			
			function guardar_modificar()
			{
				if (confirm("¿Seguro de Modificar esta Cargo?"))
				{parent.winmodificar.document.formmodificar.oculto.value="1";parent.winmodificar.document.formmodificar.submit();}
			}
			
			function cerrargeneral()
			{window.location='adm-principal.php';}
			
			function eliminar_inf(iddel)
			{
				if (confirm("¿Seguro de Eliminar esta Cargo?"))
				{
					/*parent.winbuscar.document.formbuscar.ocudel.value="2";
					parent.winbuscar.document.formbuscar.iddel.value=iddel;
					parent.winbuscar.document.formbuscar.submit();*/
				}
			}
		</script>
    </head>
	<body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
    	<div id="bgventanamodal">
        	<div id="ventanamodal">
            	<a href="javascript:if(document.getElementById('winactiva').value=='winguardar'){parent.winguardar.despliegamodal('hidden')}else {parent.winmodificar.despliegamodal('hidden');} " style="position: absolute; left: 810px; top: 5px; z-index: 100;"><img src="imagenes/exit.png" title="cerrar" width=22 height=22>Cerrar</a>
                <IFRAME src="adm-asignacioncargosterceros.php" name="buster" marginWidth=0 marginHeight=0  frameBorder=0 id="ventana1" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                </IFRAME>
            </div>
        </div>
		<table>
        	<tr><script>barra_imagenes("meci");</script><?php cuadro_titulos();?></tr>
        	<tr><?php menu_desplegable("meci");?></tr>
    		<tr><script>var pagini = '<?php echo $_GET[pagini];?>';barra_imgbotones("inicio2");</script></tr>
		</table>
        <form name="formulario" method="post" action="">
        	<span id="todastablas"></span> 
         <input type="hidden" name="winactiva" id="winactiva" value="<?php echo $_POST[winactiva]?>"> 
        <script>
		
			try {
				var zz=document.getElementById('winactiva').value;
				if(zz==""){document.getElementById('winactiva').value="winbuscar";cambiarwin("paginic");}
				}
			catch(e){}
		</script>
        </form>
    </body>
</html>