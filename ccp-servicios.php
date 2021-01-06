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
		<title>:: Ideal - Presupuesto</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="bootstrap/css/estilos.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
		
		<?php titlepag();?>

		<style>
			.background_active{
				background: #16a085;
			}
			.background_active_1{
				background: #28F67C;
			}
			.inicio--no-shadow{
				box-shadow: none;
			}
			.titulos2{
				background: none;
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
				max-height: 450px;
				overflow-y: scroll;
			}
			.head-results{
				display: grid;
				justify-items: center;
				align-items: center;
				height: 40px;
				margin-bottom: 10px; 
				border-radius: 5px;
				/* border-radius: 5px; */
				background: #3a3a3a;
			}
			.head-results p{
				color: white;
				font-size: 17px;
				margin-bottom: 0;
				text-transform: uppercase;
				font-weight: 500;
			}
			.titulos_search{
				background: #3a3a3a;
				color: white;
			}
			.sin_resultados{
				display: grid;
				justify-content: center;
				align-items: center;
				height: auto;
				border-radius: 0px;
				margin: 0px 0px 0px 15px;
				padding: 0;
			}
		</style>
    </head>
    <body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("ccpet");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("ccpet");?></tr>
        	<tr>
          		<td colspan="3" class="cinta">
					<a class="mgbt"><img src="imagenes/add2.png"/></a>
					<a class="mgbt"><img src="imagenes/guardad.png"/></a>
					<a class="mgbt"><img src="imagenes/buscad.png"/></a>
                    <a href="ccp-visualizarclasificadorpresupuestal.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
					<a href="#" onClick="mypop=window.open('ccp-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
				</td>
        	</tr>
		</table>
		<div class="subpantalla" style="height:80.5%; width:99.6%; overflow-x:hidden;">
			<div id="myapp">
				<span id="start_page"> </span>
				<div class="row">
					<div class="col-12">
						<h4 style="padding-left:50px; padding-top:5px; padding-bottom:5px; background-color: #0FB0D4">Servicios:</h4>
					</div>
				</div>
				<div class="row" style="margin: 20px 50px 0px; border-radius: 5px !important; border-radius:4px; background-color: #E1E2E2; ">
					<div class="col-md-3" style="padding: 12px 0px 0px 30px; font: 140% sans-serif;">
						<label for="">Buscar subclase:</label>
					</div>
					
					<div class="col-md-6" style="padding: 4px">
						<input type="text" class="form-control" style="height: auto; border-radius:2px;" placeholder="Ej: Edificios" v-on:keyup.enter="buscarGeneral"  v-model="searchGeneral.keywordGeneral">
					</div>
					<div class="col-md-2 col-sm-4 col-md-offset-1" style="padding: 4px">
						<button type="submit" class="btn btn-dark" value="Buscar" style="height: auto; border-radius:5px;" v-on:click="buscarGeneral">Buscar</button>
					</div>
				</div>
				
				<div v-show="mostrarSeccion">
					<div style="margin: 20px 50px 0 50px; border-radius: 5px !important;">
						<div class="row" style="margin: 4px; border-radius:4px; background-color: #E1E2E2; ">
							<div class="col-md-2" style="padding: 12px 0px 0px 30px; font: 140% sans-serif;">
								<label for="">Secci&oacute;n:</label>
							</div>
							
							<div class="col-md-6 col-md-offset-6" style="padding: 4px">
								<input type="text" class="form-control" placeholder="Buscar por nombre o c&oacute;digo de secci&oacute;n" v-on:keyup="searchMonitor" v-model="search.keyword">
							</div>
						</div>
						<table>
							<thead>
								<tr>
									<td width="20%" class='titulos' style="font: 160% sans-serif; border-radius: 5px 0 0 0;">C&oacute;digo</td>
									<td width="80%" class='titulos' style="font: 160% sans-serif;">Nombre</td>
								</tr>
							</thead>
						</table>
					</div>
				
					<div style='margin: 0px 50px 20px; border-radius: 0 0 5px 5px; height: 136px; overflow: scroll; overflow-x: hidden; background: white;'>
						<table class='inicio inicio--no-shadow'>
							<tbody>
									<?php
										$co ='zebra1';
										$co2='zebra2';
									?>
									<tr v-for="seccion in secciones" v-on:click="division(seccion)" v-bind:class="seccion[0] === seccion_p ? 'background_active' : ''" class='<?php echo $co; ?>' style='text-rendering: optimizeLegibility; cursor: pointer !important; style=\"cursor: hand\"'>
										<td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ seccion[0] }}</td>
										<td width="80%" style="font: 120% sans-serif; padding-left:10px">{{ seccion[1] }}</td>
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
				<div v-show="mostrarDivision">
					<div style="margin: 0px 50px 0 50px;">
						<div class="row" style="margin: 4px; border-radius:4px; background-color: #E1E2E2; ">
							<div class="col-md-2" style="padding: 12px 0px 0px 30px; font: 140% sans-serif;">
								<label for="">Divisi&oacute;n:</label>
							</div>
							
							<div class="col-md-6 col-md-offset-6" style="padding: 4px">
								<input type="text" class="form-control" placeholder="Buscar por nombre o c&oacute;digo de divisi&oacute;n" v-on:keyup="searchMonitorDivision" v-model="searchDivision.keywordDivision">
							</div>
						</div>
						<table>
							<thead>
								<tr>
									<td width="20%" class='titulos' style="font: 160% sans-serif; border-radius: 5px 0 0 0;">C&oacute;digo</td>
									<td width="80%" class='titulos' style="font: 160% sans-serif;">Nombre</td>
								</tr>
							</thead>
						</table>
					</div>
					<div style="margin: 0px 50px 20px; border-radius: 0 0 0 6px; height: 200px; overflow: scroll; overflow-x: hidden; background: white; ">
						<table class='inicio inicio--no-shadow'>
							<tbody>
								<?php
									$co ='zebra1';
									$co2='zebra2';
								?>
								<tr v-for="division in divisiones" v-on:click="buscarGrupo(division)" v-bind:class="division[0] === division_p ? 'background_active' : ''" class='<?php echo $co; ?>' style='text-rendering: optimizeLegibility; cursor: pointer !important; style=\"cursor: hand\"'>
									<td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ division[0] }}</td>
									<td width="80%" style="font: 120% sans-serif; padding-left:10px">{{ division[1] }}</td>

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
				<div v-show="mostrarGrupo">
					<div style="margin: 0px 50px 0 50px;">
						<div class="row" style="margin: 4px; border-radius:4px; background-color: #E1E2E2; ">
							<div class="col-md-2" style="padding: 12px 0px 0px 30px; font: 140% sans-serif;">
								<label for="">Grupos:</label>
							</div>
							
							<div class="col-md-6 col-md-offset-6" style="padding: 4px">
								<input type="text" class="form-control" placeholder="Buscar por nombre o c&oacute;digo de grupo" v-on:keyup="searchMonitorGrupos" v-model="searchGrupo.keywordGrupo">
							</div>
						</div>
						<table>
							<thead>
								<tr>
									<td width="20%" class='titulos' style="font: 160% sans-serif; padding-left:10px; border-radius: 5px 0 0 0;">C&oacute;digo</td>
									<td width="80%" class='titulos' style="font: 160% sans-serif; ">Nombre</td>
								</tr>
							</thead>
						</table>
					</div>
					<div style="margin: 0px 50px 20px; border-radius: 0 0 0 6px; height: 200px; overflow: scroll; overflow-x: hidden; background: white; ">
						<table class='inicio inicio--no-shadow'>
							<tbody>
								<?php
									$co ='zebra1';
									$co2='zebra2';
								?>
								<tr v-for="grupo in grupos" v-on:click="buscarClase(grupo)"  v-bind:class="grupo[0] === grupo_p ? 'background_active' : ''" class='<?php echo $co; ?>' style='text-rendering: optimizeLegibility; cursor: pointer !important; style=\"cursor: hand\"'>
									<td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ grupo[0] }}</td>
									<td width="80%" style="font: 120% sans-serif; padding-left:10px">{{ grupo[1] }}</td>

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
                <div v-show="mostrarClase">
					<div style="margin: 0px 50px 0 50px;">
						<div class="row" style="margin: 4px; border-radius:4px; background-color: #E1E2E2; ">
							<div class="col-md-2" style="padding: 12px 0px 0px 30px; font: 140% sans-serif;">
								<label for="">Clases:</label>
							</div>
							
							<div class="col-md-6 col-md-offset-6" style="padding: 4px">
								<input type="text" class="form-control" placeholder="Buscar por nombre o c&oacute;digo de clase" v-on:keyup="searchMonitorClases" v-model="searchClase.keywordClase">
							</div>
						</div>
						<table>
							<thead>
								<tr>
									<td width="20%" class='titulos' style="font: 160% sans-serif; padding-left:10px; border-radius: 5px 0 0 0;">C&oacute;digo</td>
									<td width="80%" class='titulos' style="font: 160% sans-serif; ">Nombre</td>
								</tr>
							</thead>
						</table>
					</div>
					<div style="margin: 0px 50px 20px; border-radius: 0 0 0 6px; height: 200px; overflow: scroll; overflow-x: hidden; background: white; ">
						<table class='inicio inicio--no-shadow'>
							<tbody>
								<?php
									$co ='zebra1';
									$co2='zebra2';
								?>
								<tr v-for="clase in clases" v-on:click="buscarSubclase(clase)"  v-bind:class="clase[0] === clase_p ? 'background_active' : ''" class='<?php echo $co; ?>' style='text-rendering: optimizeLegibility; cursor: pointer !important; style=\"cursor: hand\"'>
									<td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ clase[0] }}</td>
									<td width="80%" style="font: 120% sans-serif; padding-left:10px">{{ clase[1] }}</td>

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
                <div v-show="mostrarSubClase">
					<div style="margin: 0px 50px 0 50px;">
						<div class="row" style="margin: 4px; border-radius:4px; background-color: #E1E2E2; ">
							<div class="col-md-2" style="padding: 12px 0px 0px 30px; font: 140% sans-serif;">
								<label for="">Subclase:</label>
							</div>
							
							<div class="col-md-6 col-md-offset-6" style="padding: 4px">
								<input type="text" class="form-control" placeholder="Buscar por nombre o c&oacute;digo de subclase" v-on:keyup="searchMonitorSubClases" v-model="searchSubClase.keywordSubClase">
							</div>
						</div>
						<table>
							<thead>
								<tr>
									<td width="20%" class='titulos' style="font: 160% sans-serif; padding-left:10px; border-radius: 5px 0 0 0;">C&oacute;digo</td>
									<td width="40%" class='titulos' style="font: 160% sans-serif; ">Nombre</td>
									<td width="20%" class='titulos' style="font: 160% sans-serif; ">CIIU Rev. 4 A.C. </td>
									<td width="20%" class='titulos' style="font: 160% sans-serif; ">CPC 2 A.C.</td>
								</tr>
							</thead>
						</table>
					</div>
					<div style="margin: 0px 50px 20px; border-radius: 0 0 0 6px; height: 200px; overflow: scroll; overflow-x: hidden; background: white; ">
						<table class='inicio inicio--no-shadow'>
							<tbody>
								<?php
									$co ='zebra1';
									$co2='zebra2';
								?>
								<tr v-for="subclase in subClases" v-on:click="toggleModal(subclase)" :style="subclase[0] === subClase_p ? myStyle : ''" v-bind:class="subclase[0].length === 7 ? 'background_active_1' : ''" class='<?php echo $co; ?>' style='text-rendering: optimizeLegibility; cursor: pointer !important; style=\"cursor: hand\"'>
									<td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ subclase[0] }}</td>
									<td width="40%" style="font: 120% sans-serif; padding-left:10px">{{ subclase[1] }}</td>
									<td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ subclase[2] }}</td>
									<td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ subclase[3] }}</td>

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
				<div v-show="showModal">
					<transition name="modal">
						<div class="modal-mask">
							<div class="modal-wrapper">
								<div class="modal-dialog" role="document">
									<div class="modal-content" scrollable>
									<div class="modal-header">
										<h5 class="modal-title">Bienes transportables</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true" @click="showModal = false">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<h6><strong>Secci&oacute;n:</strong></h6> <p>{{ seccion_p }} - {{ seccion_p_nombre }}</p>
										<h6><strong>Divisi&oacute;n:</strong></h6> <p>{{ division_p }} - {{ division_p_nombre }}</p>
										<h6><strong>Grupo:</strong></h6> <p>{{ grupo_p }} - {{ grupo_p_nombre }}</p>
										<h6><strong>Clase:</strong></h6> <p>{{ clase_p }} - {{ clase_p_nombre }}</p>
										<h6><strong>Subclase:</strong></h6> <p>{{ subClase_p }} - {{ subClase_p_nombre }}</p>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" @click="showModal = false">Close</button>
									</div>
									</div>
								</div>
							</div>
						</div>
					</transition>
				</div>

				<div v-show="show_table_search" id="show_table_search">
					<div style="margin: 0px 50px 0 50px;">	
						<hr>
						<div class="head-results">
							<p>Resultados</p>
						</div>
						<table>
							<thead>
								<tr>
									<td width="20%" class='titulos_search' style="font: 160% sans-serif; padding-left:10px; border-radius: 5px 0 0 0;">C&oacute;digo</td>
									<td width="40%" class='titulos_search' style="font: 160% sans-serif; ">Nombre</td>
									<td width="20%" class='titulos_search' style="font: 160% sans-serif; ">CIIU Rev. 4 A.C. </td>
									<td width="20%" class='titulos_search' style="font: 160% sans-serif; ">CPC 2 A.C.</td>
								</tr>
							</thead>
						</table> 
					</div>	
					<div style="margin: 0px 50px 20px; border-radius: 0 0 0 15px; height:auto; overflow: scroll; overflow-x: hidden; background: white; ">
						<table class='inicio inicio--no-shadow'>
							<tbody v-if="show_resultados">
								<?php
									$co ='zebra1';
									$co2='zebra2';
								?>
								<tr v-for="nivel in result_search" v-on:click="show_levels(nivel)" class='<?php echo $co; ?>' style='text-rendering: optimizeLegibility; cursor: pointer !important; style=\"cursor: hand\"'>
									<td width="20%"style="font: 120% sans-serif; padding-left:10px">{{ nivel[0] }}</td>
									<td width="40%"style="font: 120% sans-serif; padding-left:10px">{{ nivel[1] }}</td>
									<td width="20%"style="font: 120% sans-serif; padding-left:10px">{{ nivel[2] }}</td>
									<td width="20%"style="font: 120% sans-serif; padding-left:10px">{{ nivel[3] }}</td>
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
  				<!-- <button @click="showModal = true">Click</button> -->
				
				<!-- end test -->
				<span id="end_page"> </span>
			</div>
		</div>
		
		<script src="https://cdn.jsdelivr.net/npm/vue"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"></script>
		<script src="vue/ccp-servicios.js"></script>
	</body>
</html>