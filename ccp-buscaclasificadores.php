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
				/* font: 115% sans-serif !important; */
    			font-weight: 700 !important;
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
					<a><img src="imagenes/add.png" title="Nuevo" onClick="location.href='ccp-generarclasificadores.php'" class="mgbt"/></a>
					<a class="mgbt"><img src="imagenes/guardad.png"/></a>
					<a><img src="imagenes/busca.png" title="Buscar"  onClick="location.href='ccp-buscaclasificadores.php'" class="mgbt"/></a>
					<a href="#" onClick="mypop=window.open('ccp-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<img src="imagenes/iratras.png" title="Atr&aacute;s" onClick="location.href='ccp-visualizarclasificadorpresupuestal.php'" class="mgbt"/>
				</td>
        	</tr>
		</table>
		<div class="subpantalla" style="height:80.5%; width:99.6%; overflow-x:hidden;">
			<div id="myapp" style="height:inherit;">
				<div class="row">
					<div class="col-12">
						<h4 style="padding-left:50px; padding-top:5px; padding-bottom:5px; background-color: #0FB0D4">Buscar clasificadores:</h4>
					</div>
				</div>
				<div class="row" style="margin: 1px 50px 0px">
					<div class="col-12">
						<div class="row" style="border-radius:4px; background-color: #E1E2E2; ">
							<div class="col-md-2" style="display: grid; align-content:center;">
								<label for="" style="margin-bottom: 0;">Buscar clasificador</label>
							</div>
							<div class="col-md-3" style="padding: 4px">
								<input v-on:keyup="searchMonitor" v-model="search.keyword" type="text" class="form-control" style="height: auto; border-radius:0;" placeholder="Nombre de clasificador">
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12" style="height: fit-content;">
						<div style="margin: 0px 50px 0">
							<table>
								<thead>
									<tr>
										<td class='titulos' width="40%"  style="padding-left: 10px; font: 160% sans-serif;">Nombre</td>
										<td class='titulos' width="20%" style="font: 160% sans-serif;">Estado</td>
										<td class='titulos' width="20%" style="font: 160% sans-serif;">Fecha creado</td>
										<td class='titulos' width="10%" style="font: 160% sans-serif; border-radius: 0px 5px 0px 0px;">Eliminar</td>
									</tr>
								</thead>
							</table>
						</div>
						<div style="margin: 0px 50px 20px; border-radius: 0 0 0 15px; height: 50%; overflow: scroll; overflow-x: hidden; background: white; ">
							<table class='inicio inicio--no-shadow'>
								<tbody v-if="show_resultados">
									<?php
										$co ='zebra1';
										$co2='zebra2';
									?>
									<!-- v-on:click="seleccionaCodigos(result)" -->
									<tr v-for="result in results" class='<?php echo $co; ?> text-rendering: optimizeLegibility; cursor: pointer important; style=\"cursor: hand\"' style="font: 130% sans-serif;">
										<td width="40%" style="padding-left: 10px;" v-on:click="showClasificador(result)" >{{ result[1] }}</td>
										<td width="20%"  v-on:click="showClasificador(result)" >{{ result[2] }}</td>
										<td width="20%" v-on:click="showClasificador(result)" >{{ result[3].split('-').reverse().join('/') }}</td>
										<td width="10%"> <button class="btn-delete" v-on:click="deleteClasificador(result[0])">Eliminar</button></td>
										
										<?php
										$aux=$co;
										$co=$co2;
										$co2=$aux;
										?>
									</tr>
								</tbody>
								<tbody v-else>
									<tr>
										<td width="20%"style="font: 120% sans-serif; padding-left:10px; text-align:center;" colspan="3">No hay clasificadores</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12" v-show="show_results_det">
						<div style="margin: 0px 50px 0">
							<table>
								<thead>
									<tr>
										<td class='titulos' width="30%"  style="padding-left: 10px; font: 160% sans-serif; border-radius: 5px 0px 0px 0px;">C&oacute;digo</td>
										<td class='titulos' width="40%"  style="font: 160% sans-serif;">Nombre</td>
										<td class='titulos' width="30%" style="font: 160% sans-serif; border-radius: 0px 5px 0px 0px;">Tipo</td>
									</tr>
								</thead>
							</table>
						</div>
						<div style="margin: 0px 50px 30px; border-radius: 0 0 0 15px; max-height: 450px; overflow: scroll; overflow-x: hidden; background: white; ">
							<table class='inicio inicio--no-shadow'>
								<tbody v-if="show_resultados">
									<?php
										$co ='zebra1';
										$co2='zebra2';
									?>
									<tr v-for="result in results_det" :class=" result[2] == 'A' ? 'background_active' : '' " class='<?php echo $co; ?> text-rendering: optimizeLegibility; cursor: pointer important; style=\"cursor: hand\"' style="font: 130% sans-serif;">
										<td width="30%" style="padding-left: 10px;">{{ result[0] }}</td>
										<td width="40%">{{ result[1] }}</td>
										<td width="30%">{{ result[2] }}</td>
										
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
				<span id="end_page"> </span>
			</div>	
		</div>
		
		<script src="https://cdn.jsdelivr.net/npm/vue"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"></script>
		<script src="vue/ccp-buscaclasificadores.js"></script>
	</body>
</html>