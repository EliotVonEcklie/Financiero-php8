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
    <meta http-equiv="X-UA-Compatible" content="IE=9" />
    <title>::SPID-Planeaci&oacute;n Estrat&eacute;gica</title>
    <link href="css/css2.css" rel="stylesheet" type="text/css" />
    <link href="css/css3.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="css/programas.js"></script>
    <script>
    	function cargarinforme()
		{
			var tinfo=document.form1.tinforme.value;
			switch(tinfo)
			{
				case "1":
					var winat="activos";
					var pagaux="plan-agendabuscactivos.php";
					document.getElementById('botbuscar').innerHTML='<img src="imagenes/busca.png" title="Buscar" onclick="parent.activos.funbuscar();">';
					break;
				case "2":
					var winat="vencidos";
					var pagaux="plan-agendabuscavencidos.php";
					document.getElementById('botbuscar').innerHTML='<img src="imagenes/busca.png" title="Buscar" onclick="parent.vencidos.funbuscar();">';
					break;
				case "3":
					var winat="cumplidos";
					var pagaux="plan-agendabuscacumplidos.php";
					document.getElementById('botbuscar').innerHTML='<img src="imagenes/busca.png" title="Buscar" onclick="parent.cumplidos.funbuscar();">';
					break;
				default:
					document.form2.submit();
			}
			if(tinfo!="0")
			{
				document.getElementById('todastablas').innerHTML='<IFRAME src="'+pagaux+'" name="'+winat+'" scrolling="no" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana1" frameSpacing=0 style="width:100%; height:66%;"></IFRAME>';
			}
		}
		function cargarpagina(pagina)
		{
			document.location.href=pagina;
		}
		function despliegamodal2(_valor)
		{
			document.getElementById("bgventanamodal2").style.visibility=_valor;
			if (_valor=="hidden"){document.getElementById('ContenidoMirar').innerHTML=""}
		}
		function actulizar(idfecha,idlinea)
		{
			despliegamodal2("hidden");
			var winat="actualizar";
			var pagaux='calendario1/mensajes-actualizar.php?fecha='+idfecha+'&'+'horaini='+idlinea;
			document.getElementById('ContenidoMirar').innerHTML='<div id="bgventanamodal2"><div id="ventanamodal2"><IFRAME  src="'+pagaux+'" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"></IFRAME></div></div>';
			despliegamodal2('visible');
		}
    </script>
    <?php titlepag();?>
</head>
<body>
	<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
	<span id="todastablas2"></span>
	<span id="ContenidoMirar"></span>
	<table>
		<tr><script>barra_imagenes("plan");</script><?php cuadro_titulos();?></tr>	 
		<tr><?php menu_desplegable("plan");?></tr>
        <tr>
  			<td colspan="3" class="cinta">
            	<a href="plan-agenda.php" class="mgbt"><img src="imagenes/add.png"  alt="Nuevo" border="0" /></a> 
            	<a href="#" class="mgbt"><img src="imagenes/guardad.png" alt="Guardar" /></a> 
                <a href="#" id="botbuscar" class="mgbt"><img src="imagenes/buscad.png"/></a> 
                <a href="#" class="mgbt" onClick="mypop=window.open('plan-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana"></a>
   			</td>
		</tr>
	</table>	
	<form name="form1" method="post" action="plan-actareasbusca.php" >
	<table  class="inicio" align="center" >
		<tr>
        	<td class="titulos" colspan="2">:: Buscar Eventos Programados para: <?php $nresul=buscaresponsable($_SESSION[cedulausu]);echo $nresul;?> </td>
        	<td width="14%" class="cerrar" ><a href="plan-principal.php">Cerrar</a></td>
      	</tr>
        <tr>
        	<td width="11%" class="saludo1" >Seleccionar Estado :</td>
        	<td>
            	<select id="tinforme" name="tinforme" class="elementosmensaje" style="width:30%"  onKeyUp="return tabular(event,this)"  onChange="cargarinforme();" >
					<option onChange="" value="0" <?php if($_POST[tinforme]=="0"){echo " SELECTED";}?>   >Seleccione....</option>
                    <option onChange="" value="1" <?php if($_POST[tinforme]=="1"){echo " SELECTED";}?>  >Eventos Vigentes</option>
                    <option onChange="" value="2"<?php if($_POST[tinforme]=="2"){echo " SELECTED";}?>   >Eventos Vencidos</option>
                    <option onChange="" value="3"<?php if($_POST[tinforme]=="3"){echo " SELECTED";}?>   >Eventos Cumplidos</option>
           		</select> 
            </td>
       </tr>  
    </table>
    <span id="todastablas"></span> 
    </form>
</body>
</html>