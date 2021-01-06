<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=iso-8859-1");
	require 'comun.inc';
	require 'funciones.inc';
	require 'validaciones.inc';
	require 'conversor.php';
	session_start();
	$linkbd=conectar_v7();
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>SPID-Planeaci&oacute;n Estrat&eacute;gica</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css4.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css"/>
		<script src="vue/vue.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"> </script>
		<style>
			.modal-mask
			{
				position: fixed;
				z-index: 9998;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
				background-color: rgba(0, 0, 0, .5);
				display: table;
				transition: opacity .3s ease;
			}
			.modal-wrapper 
			{
				display: table-cell;
				vertical-align: middle;
			}
			.modal-container
			{
				width: 60%;
				margin: 0px auto;
				padding: 20px 30px;
				text-align: left;
				background:linear-gradient(#99bbcc, #B6CEDA);
				border-radius: 2px;
				box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
				transition: all .3s ease;
			}
			.modal-container1
			{
				width: 50%;
				margin: 0px auto;
				padding: 20px 30px;
				text-align: left;
				background:linear-gradient(#99bbcc, #B6CEDA);
				border-radius: 10px;
				box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
				transition: all .3s ease;
			}
			.modal-container2
			{
				width: 80%;
				margin: 0px auto;
				padding: 20px 30px;
				text-align: left;
				background:linear-gradient(#99bbcc, #B6CEDA);
				border-radius: 2px;
				box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
				transition: all .3s ease;
			}
			.modal-container3
			{
				width: 90%;
				margin: 0px auto;
				padding: 20px 30px;
				text-align: left;
				background:linear-gradient(#99bbcc, #B6CEDA);
				border-radius: 2px;
				box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
				transition: all .3s ease;
			}
			footer
			{
				text-align: right;
			}
		</style>
		<?php titlepag();?>
	</head>
	<body>
		<div id="myapp">
			<!--<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>-->
			<span id="todastablas2"></span>
			<div id="bgventanamodalm" class="bgventanamodalm">
				<div id="ventanamodalm" class="ventanamodalm">
					<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;">
					</IFRAME>
				</div>
			</div>
			<table>
				<tr><script>barra_imagenes("ccpet");</script><?php cuadro_titulos();?></tr>
				<tr><?php menu_desplegable("ccpet");?></tr>
				<tr>
					<td colspan="3" class="cinta"><img src="imagenes/add.png" onClick="location.href='ccp-bancoproyctos.php'" class="mgbt" title="Nuevo" /><img src="imagenes/guardad.png" title="Guardar" class="mgbt1"/><img src="imagenes/busca.png" onClick="location.href='ccp-buscabancoproyectos.php'" class="mgbt" title="Buscar"/><img src="imagenes/nv.png" onClick="mypop=window.open('ccp-principal.php','',''); mypop.focus();" class="mgbt" title="Nueva Ventana"></td>
				</tr>
			</table>
			<div>
				<table class="inicio ancho">
					<tr>
						<td class="titulos" colspan="2" >SELECCIONAR PROYECTO</td>
						<td class="cerrar" style="width:7%" @click="showModal = false">Cerrar</td>
					</tr>
					<tr>
						<td class="tamano01" style="width:3cm">Proyecto:</td>
						<td><input type="text" class="form-control" placeholder="Buscar por nombre de Proyecto" v-on:keyup="searchProyecto" v-model="search.keyword" style="width:100%" /></td>
					</tr>
				</table>
				<table>
					<thead>
						<tr>
							<td class='titulos' style="font: 160% sans-serif; border-radius: 5px 0 0 0; width:5%;">id</td>
							<td class='titulos' style="font: 160% sans-serif; width:20%;">C&oacute;digo</td>
							<td class='titulos' style="font: 160% sans-serif; width:20%;">Und. Ejecutora</td>
							<td class='titulos' style="font: 160% sans-serif; width:5%;">Vigencia</td>
							<td class='titulos' style="font: 160% sans-serif; width:30%;">Nombre</td>
							<td class='titulos' style="font: 160% sans-serif;">Descripci&oacute;n</td>
							<td class='titulos' style="font: 160% sans-serif; border-radius: 0 5px 0 0;">Aprobado</td>
							<td class='titulos' style="font: 160% sans-serif; border-radius: 0 5px 0 0;"></td>
						</tr>
					</thead>
				</table>
				<div class="subpantallac5" style='margin: 0px 5px 5px; border-radius: 0 0 5px 5px; height:60%; width: 99.4%;  overflow-x: hidden;'>
					<table class='inicio'>
						<tbody>
							<tr v-for="(proyecto,index) in proyectos" v-on:DblClick="editarsector(proyecto[0])" v-bind:class="index % 2 ? 'saludo1a' : 'saludo2'" style='text-rendering: optimizeLegibility; cursor: pointer !important; style=\"cursor: hand\"'>
								<td style="font: 120% sans-serif; padding-left:10px; width:5%;">{{ proyecto[0] }}</td>
								<td style="font: 120% sans-serif; padding-left:10px; width:20%;">{{ proyecto[2] }}</td>
								<td style="font: 120% sans-serif; padding-left:10px; width:20%;">{{ proyecto[1] }}</td>
								<td style="font: 120% sans-serif; padding-left:10px; width:5%;">{{ proyecto[3] }}</td>
								<td style="font: 120% sans-serif; padding-left:10px; width:30%;">{{ proyecto[4] }}</td>
								<td style="font: 120% sans-serif; padding-left:10px;">{{ proyecto[5] }}</td>
								<td style="font: 120% sans-serif; padding-left:10px">{{ proyecto[7] }}</td>
								<td style="width:5%;" v-on:click="preguntardel(proyecto[0],proyecto[2],proyecto[7]);"><img src='imagenes/del.png'></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<input type="hidden"  v-model="numerodel" >
			<div v-show="showMensajeSN">
				<transition name="modal">
					<div class="modal-mask">
						<div class="modal-wrapper">
							<div class="modal-container1">
								<table id='ventanamensaje1' class='inicio' style="border-radius: 10px;">
									<tr >
										<td class="titulosmensajes1" v-bind:style="{color:colortitulosmensaje,}" style=" text-shadow: 7px 4px 5px grey;font-style: italic;border-radius: 50px;">{{titulomensaje}}</td>
									</tr>
									<tr>
										<td class='.cuerpomensajes1' style="text-align:center;"><h3 style="font-size: 20px;font-family:Gotham, 'Helvetica Neue', Helvetica, Arial, 'sans-serif';font-style: italic;">{{ contenidomensaje }}</h3></td>
									</tr>
									<tr>
										<td class='.cuerpomensajes1' style="padding: 14px;text-align:center">
											<em name="continuar" id="continuar" class="botonflechaverde" @click="toggleMensajeSN('1','S')">Aceptar</em> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<em name="continuar" id="continuar" class="botonflecharoja" @click="toggleMensajeSN('1','N')">Cancelar</em>
										</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</transition>
			</div>
		</div>
		<script src="Librerias/vue/vue.min.js"></script>
		<script src="Librerias/vue/axios.min.js"></script>
		<script src="vue/presupuesto_ccp/ccp-buscabancoproyectos.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
	</body>
</html>