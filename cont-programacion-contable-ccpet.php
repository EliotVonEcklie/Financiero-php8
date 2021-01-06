<?php
	require "comun.inc";
	require "funciones.inc"; 
	session_start();
	cargarcodigopag(@$_GET['codpag'], @$_SESSION['nivel']);
	header("Cache-control: private"); // Arregla IE 6 
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es"> 
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Ideal - Contabilidad</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
        <script type="text/javascript" src="css/funciones.js"></script>
		<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="bootstrap/css/estilos.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <script type="text/javascript" src="bootstrap/fontawesome.5.11.2/js/all.js"></script>
		
		<?php titlepag();?> 

		<style>
			.background_active_color{
				background: #16a085;
			}
			.background_active{
				font: 115% sans-serif !important; */
    			font-weight: 700 !important;*/
				font-family: "Constantia", serif !important;*/
				font-family: calibri !important;
				font-weight: bold !important;
				font-size:20px !important;
			}
			.background_active_1{
				font: 115% sans-serif !important; */
    			font-weight: 700 !important;*/
				font-family: "Constantia", serif !important;*/
				font-family: helvética !important;
				font-size:20px !important;
			}
			.inicio--no-shadow{
				box-shadow: none;
			}
			.btn-delete{
				background: red; 	
				color: white;
				border-radius: 5px;
				border: none;
				font-size: 13px;
			}
			.btn-delete:hover, .btn-delete:focus{
				background: white; 	
				color: red;
			}
			.modal-mask {
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

			.modal-wrapper {
			display: table-cell;
			vertical-align: middle;
			}
			.modal-body{
				max-height: 296px;
				overflow-y: scroll;
			}
			.modal-intermetio{
				margin: 0 15px;
				font-family: helvética !important;
				font-size: 26px !important;
				padding: 10px 0;
			}
			.modal-intermedio-agregar{
				text-align:right;
				padding: 4px;
				margin-top: 6px;
				margin-right: 20px
			}
			.modal-body_1{
				padding-top: 15px;
				height: 40px;
			}

			.loader-table{
				 background-color: #dff9fb;
				opacity: .5; 
				display: flex;
				align-items: center;
				justify-content: center;
				height: 75%;
			}
			.spinner{
				border: 4px solid rgba(0, 0, 0, 0.2);
				border-left-color: #39C;
				border-radius: 50%;
				width: 50px;
				height: 50px;
				animation: spin .9s linear infinite;
			}
			@keyframes spin {
				to { transform: rotate(360deg); }
			}
		</style>
    </head>
    <body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
		<div id="myapp">
			<table>
				<tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
				<tr><?php menu_desplegable("cont");?></tr>
				<tr>
					<td colspan="3" class="cinta">
						<a><img src="imagenes/add.png" title="Nuevo" onClick="location.href='#'" class="mgbt"/></a>
						<a><img src="imagenes/guarda.png" title="Guardar" v-on:Click="guardarTotal()" class="mgbt"/></a>
						<a><img src="imagenes/busca.png" title="Buscar"  onClick="location.href='#'" class="mgbt"/></a>
						<a href="#" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
						<img src="imagenes/iratras.png" title="Atr&aacute;s" onClick="location.href='cont-programacioncontable.php'" class="mgbt"/>
					</td>
				</tr>
			</table>
			<div class="subpantalla" style="height:520px; width:99.6%; overflow:hidden;">
				<div style="height:inherit;">
					<div class="row">
						<div class="col-12">
							<h5 style="padding-left:30px; padding-top:5px; padding-bottom:5px; background-color: #0FB0D4">Programaci&oacute;n contable CCPET</h5>
						</div>
					</div>
					
					<div class="row">
						<div class="col-12" v-show="mostrar_resultados_gastos">
							<div style="margin: 5px 10px 0">
								<table>
									<thead>
										<tr>
											<td class='titulos' width="20%"  style="padding-left: 10px; font: 160% sans-serif; border-radius: 5px 0px 0px 0px;">C&oacute;digo</td>
											<td class='titulos' width="33%"  style="font: 160% sans-serif;">Nombre</td>
											<td class='titulos' width="29%" style="font: 160% sans-serif; ">Tipo</td>
											
											<td class='titulos' width="18%" style="font: 160% sans-serif; border-radius: 0px 5px 0px 0px;">Valor</td>
										</tr>
									</thead>
								</table>
							</div>
							<div style="margin: 0px 10px 10px; border-radius: 0 0 0 5px; max-height: 390px; overflow: scroll; overflow-x: hidden; background: white; ">
								<table class='inicio inicio--no-shadow' style='margin: 10px; border-radius: 4px;'>
									<tbody v-if="mostrar_resultados_gastos">
										<?php
											$co ='zebra1';
											$co2='zebra2';
										?>
										<tr v-for="gasto in gastos" :class=" gasto[2] == 'A' ? 'background_active' : 'background_active_1' " class='<?php echo $co; ?>' style="font: 130% sans-serif;">
											<td width="10%" style="padding-left: 10px; ">{{ gasto[0] }}</td>
											<td width="32%" >{{ gasto[1] }}</td>
											<td width="10%" >{{ gasto[2] }}</td>
											<td width="30%" v-if="gasto[2] == 'C' " v-on:dblclick="agregarPresupuesto(gasto[0])" style='text-rendering: optimizeLegibility; cursor: pointer !important; text-align:center;  style=\"cursor: hand\"'>
												<input type="number" id="fname" min="00" v-model="valorIngresoCuenta[gasto[0]]" v-on:blur="guardarTotal" style="text-align:center;background-color:FBE71B;border: none !important;"></td>
											<td width="30%" v-else style='text-rendering: optimizeLegibility; text-align:center; '></td>
											<td width="30%" v-else style='text-rendering: optimizeLegibility; text-align:center; '></td>
											
											<?php
											$aux=$co;
											$co=$co2;
											$co2=$aux;
											?>
										</tr>
										
										
									</tbody>
									<tbody v-else>
										<tr>
											<td width="20%"style="font: 120% sans-serif; padding-left:10px; text-align:center;" colspan="3">Sin resultados</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					
					
					<div v-show="showModal_fuentes">
						<transition name="modal">
							<div class="modal-mask">
								<div class="modal-wrapper">
									<div class="modal-dialog modal-lg" style = "max-width: 1200px !important;" role="document">
										<div class="modal-content"  style = "width: 1200px !important;" scrollable>
											<div class="modal-header">
												<h5 class="modal-title">Programaciones Contables</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true" @click="cerrarModalCuenta()">&times;</span>
												</button>
											</div>
											<div class="modal-body">
												<div style="margin: 2px 0 0 0;">
													<div class="row" style="margin: 4px; border-radius:4px; background-color: #E1E2E2; ">
														<div class="col-md-2" style="padding: 12px 0px 0px 30px; font: 140% sans-serif;">
															<label for="">Programaci&oacute;n contable:</label>
														</div>
														
														<div class="col-md-6 col-md-offset-6" style="padding: 28px">
															<input type="text" class="form-control" placeholder="Buscar por nombre de cuenta." v-on:keyup="searchMonitorFuente" v-model="searchFuente.keywordFuente">
														</div>
													</div>
													<table>
														<thead>
															<tr>
																<td width="20%" class='titulos' style="text-align:left; font: 120% sans-serif; padding-left:10px; border-radius: 5px 0 0 0;">C&oacute;digo</td>
																<td width="80%" class='titulos' style="text-align:left; font: 120% sans-serif; ">Cuenta</td>
														
															</tr>
														</thead>
													</table>
												</div>
												<div style="margin: 2px 0 0 0; border-radius: 0 0 0 6px; height: 200px; overflow: scroll; overflow-x: hidden; background: white; ">
													<table class='inicio inicio--no-shadow'>
														<tbody>
															<?php
																$co ='zebra1';
																$co2='zebra2';
															?>
															<tr v-for="codigo in codigosDet" v-on:click="seleccionarCuenta(codigo[0], codigo[2])"  v-bind:class="codigo[0] === codigo_p ? 'background_active_color' : ''"  v-on:dblclick= "guardar" class='<?php echo $co; ?>' style='text-rendering: optimizeLegibility; cursor: pointer !important; style=\"cursor: hand\"'>
																<td id= width="22%" style="text-align:left; font: 120% sans-serif; padding-left:10px">{{ codigo[0] }}</td>
																<td width="78%" style="text-align: left; font: 120% sans-serif; padding-left:10px"> {{ codigo[1] }}<td>															
																<?php
																$aux=$co;
																$co=$co2;
																$co2=$aux;
																?>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-primary" v-on:click="guardar">Guardar</button>
												<button type="button" class="btn btn-secondary" @click="cerrarModalCuenta()">Cerrar</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</transition>
					</div>
				</div>	
			</div>
		</div>
		<script src="https://cdn.jsdelivr.net/npm/vue"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"></script>
		<script src="vue/cont-programacion-contable-ccpet.js"></script>
	</body>
</html>