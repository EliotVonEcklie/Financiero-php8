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
				color: white;
				background: #16a085;
			}
			.inicio--no-shadow{
				box-shadow: none;
			}
			.titulos2{
				background: none;
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
				
				<div style="margin: 20px 50px 0 50px; border-radius: 5px !important;">
					<div class="row" style="margin: 4px; border-radius:4px; background-color: #E1E2E2; ">
						<div class="col-md-2" style="padding: 12px 0px 0px 30px; font: 140% sans-serif;">
							<label for="">Sectores:</label>
						</div>
						
						<div class="col-md-6 col-md-offset-6" style="padding: 4px">
							<input type="text" class="form-control" placeholder="Buscar por nombre de sector" v-on:keyup="searchMonitor" v-model="search.keyword">
						</div>
					</div>
					<table>
						<thead>
							<tr>
								<td width="20%" class='titulos' style="font: 160% sans-serif; border-radius: 5px 0 0 0;">Codigo</td>
								<td width="60%" class='titulos' style="font: 160% sans-serif;">Nombre</td>
								<td width="20%" class='titulos' style="font: 160% sans-serif; border-radius: 0 5px 0 0;">Aplicaci&oacute;n</td>
							</tr>
						</thead>
					</table>
				</div>
				<div style='margin: 0px 50px 20px; border-radius: 0 0 5px 5px; height: 200px; overflow: scroll; overflow-x: hidden; background: white;'>
					<table class='inicio inicio--no-shadow'>
						<tbody>
								<?php
									$co ='zebra1';
									$co2='zebra2';
								?>
								<tr v-for="sector in sectores" v-on:click="programas(sector)" v-bind:class="sector[0] === sector_p ? 'background_active' : ''" class='<?php echo $co; ?>' style='text-rendering: optimizeLegibility; cursor: pointer !important; style=\"cursor: hand\"'>
									<td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ sector[0] }}</td>
									<td width="60%" style="font: 120% sans-serif; padding-left:10px">{{ sector[1] }}</td>
									<td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ sector[2] }}</td>

									<?php
									$aux=$co;
									$co=$co2;
									$co2=$aux;
									?>

								</tr>
						</tbody>
					</table>
				</div>
				<div v-show="mostrarProgramas">
					<div style="margin: 0px 50px 0 50px;">
						<div class="row" style="margin: 4px; border-radius:4px; background-color: #E1E2E2; ">
							<div class="col-md-2" style="padding: 12px 0px 0px 30px; font: 140% sans-serif;">
								<label for="">Programas:</label>
							</div>
							
							<div class="col-md-6 col-md-offset-6" style="padding: 4px">
								<input type="text" class="form-control" placeholder="Buscar por nombre de programa" v-on:keyup="searchMonitorPrograms" v-model="searchProgram.keywordProgram">
							</div>
						</div>
						<table>
							<thead>
								<tr>
									<td width="10%" class='titulos' style="font: 160% sans-serif; border-radius: 5px 0 0 0;">C&oacute;digo</td>
									<td width="30%" class='titulos' style="font: 160% sans-serif;">Nombre programa</td>
									<td width="20%" class='titulos' style="font: 160% sans-serif;">C&oacute;digo subprograma</td>
									<td width="20%" class='titulos' style="font: 160% sans-serif;">Nombre subprograma</td>
									<td width="20%" class='titulos' style="font: 160% sans-serif; border-radius: 0 5px 0 0;">Aplicaci&oacute;n</td>
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
								<tr v-for="programa in programas_subprogramas" v-on:click="buscarProductos(programa)" v-bind:class="programa[0] === programa_p ? 'background_active' : ''" class='<?php echo $co; ?>' style='text-rendering: optimizeLegibility; cursor: pointer !important; style=\"cursor: hand\"'>
									<td width="10%" style="font: 120% sans-serif; padding-left:10px">{{ programa[0] }}</td>
									<td width="30%" style="font: 120% sans-serif; padding-left:10px">{{ programa[1] }}</td>
									<td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ programa[2] }}</td>
									<td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ programa[3] }}</td>
									<td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ programa[4] }}</td>

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
				<div v-show="mostrarProductos">
					<div style="margin: 0px 50px 0 50px;">
						<div class="row" style="margin: 4px; border-radius:4px; background-color: #E1E2E2; ">
							<div class="col-md-2" style="padding: 12px 0px 0px 30px; font: 140% sans-serif;">
								<label for="">Productos:</label>
							</div>
							
							<div class="col-md-6 col-md-offset-6" style="padding: 4px">
								<input type="text" class="form-control" placeholder="Buscar por nombre de producto" v-on:keyup="searchMonitorProducts" v-model="searchProduct.keywordProduct">
							</div>
						</div>
						<table>
							<thead>
								<tr>
									<td width="10%" class='titulos' style="font: 160% sans-serif; padding-left:10px; border-radius: 5px 0 0 0;">C&oacute;digo</td>
									<td width="20%" class='titulos' style="font: 160% sans-serif; ">Producto</td>
									<td width="30%" class='titulos' style="font: 160% sans-serif; ">Descripci&oacute;n</td>
									<td width="10%" class='titulos' style="font: 160% sans-serif; ">Medio a traves</td>
									<td width="5%" class='titulos' style="font: 160% sans-serif; ">C&oacute;digo indicador</td>
									<td width="10%" class='titulos' style="font: 160% sans-serif;">Indicador producto</td>
									<td width="10%" class='titulos' style="font: 160% sans-serif;">Unidad medida</td>
									<td width="5%" class='titulos' style="font: 160% sans-serif; padding-right:10px; border-radius: 0 5px 0 0;">Indicador principal</td>
								</tr>
							</thead>
						</table>
					</div>
					<div style="margin: 0px 50px 20px; border-radius: 0 0 0 6px; height: 400px; overflow: scroll; overflow-x: hidden; background: white; ">
						<table class='inicio inicio--no-shadow'>
							<tbody>
								<?php
									$co ='zebra1';
									$co2='zebra2';
								?>
								<tr v-for="producto in productos" v-on:click="changeBackground(producto)"  v-bind:class="producto[0] === sombra ? 'background_active' : ''" class='<?php echo $co; ?>' style='text-rendering: optimizeLegibility; cursor: pointer !important; style=\"cursor: hand\"'>
									<td width="10%" style="font: 120% sans-serif; padding-left:10px">{{ producto[0] }}</td>
									<td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ producto[1] }}</td>
									<td width="30%" style="font: 120% sans-serif; padding-left:10px">{{ producto[2] }}</td>
									<td width="10%" style="font: 120% sans-serif; padding-left:10px">{{ producto[3] }}</td>
									<td width="5%" style="font: 120% sans-serif; padding-left:10px">{{ producto[4] }}</td>
									<td width="10%" style="font: 120% sans-serif; padding-left:10px">{{ producto[5] }}</td>
									<td width="10%" style="font: 120% sans-serif; padding-left:10px">{{ producto[6] }}</td>
									<td width="5%" style="font: 120% sans-serif; padding-left:10px">{{ producto[7] }}</td>

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
				<!-- end test -->
				<span id="end_page"> </span>
			</div>
		</div>
		
		<script src="https://cdn.jsdelivr.net/npm/vue"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"></script>
		<script src="vue/ccp-producto.js"></script>
	</body>
</html>