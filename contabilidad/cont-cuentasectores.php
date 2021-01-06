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
		<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="bootstrap/css/estilos.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
		
		<?php titlepag();?>

		<style>
			.background_active{
				color: white;
				background: gray;
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
			.zebra1{
				cursor: pointer;
			}
			.msm-error{
				font-size: 13px;
				margin-bottom: 0;
			}
			.frame_cuentasector{
				background: #E1E2E2;
				padding: 10px;
				border-radius: 10px;
			}
			.btn-primary{
				background: #39C;
			}
		</style>
    </head>
    <body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("cont");?></tr>
        	<tr>
          		<td colspan="3" class="cinta">
					<a class="mgbt"><img src="imagenes/add2.png"/></a>
					<a class="mgbt"><img src="imagenes/guardad.png"/></a>
					<a class="mgbt"><img src="imagenes/buscad.png"/></a>
					<a href="#" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<img src="imagenes/iratras.png" title="Atr&aacute;s" onClick="location.href='cont-menupresupuesto.php'" class="mgbt"/>
				</td>
        	</tr>
		</table>
		<div class="subpantalla" style="height:80.5%; width:99.6%; padding: 20px 50px 0; overflow-x:hidden;">
			<div id="myapp" class="frame_cuentasector">
				<div class="row">
					<div class="col">
						<div class="row" style="margin: 0 0 0 0; border-radius:4px; background-color: #fff; ">
							<div class="col-md-3" style="padding: 12px 0px 0px 30px; font: 140% sans-serif;">
								<label for="">Sectores</label>
							</div>
							<div class="col-md-6" style="padding: 4px">
								<input type="text" class="form-control" style="height: auto; border-radius:0;" placeholder="Ej: Ciencia, tecnolog&iacute;a e innovaci&oacute;n" v-on:keyup="searchMonitor"  v-model="search.keyword">
							</div>
						</div>
						<div style="margin: 4px 0 0">
							<table>
								<thead>
									<tr>
										<td width="1%" class='titulos' style="font: 120% sans-serif; border-radius: 5px 0px 0px;">C&oacute;digo</td>
										<td width="8%" class='titulos'  style="font: 120% sans-serif;">Nombre</td>
									</tr>
								</thead>
							</table>
						</div>
						<div style="margin: 0px 0 20px; border-radius: 0 0 0 15px; height: 200px; overflow: scroll; overflow-x: hidden; background: white; ">
							<table class='inicio inicio--no-shadow'>
								<tbody v-if="show_resultados_sectores">
									<?php
										$co ='zebra1';
										$co2='zebra2';
									?> 
									<tr v-for="result in results_sectores" v-on:click="chosenCuentaSector(result, 'sector')" v-bind:class="result[1] === app.codigo_sector  ? 'background_active' : ''" class='<?php echo $co; ?>  text-rendering: optimizeLegibility; cursor: pointer important; style=\"cursor: hand\"' >
										<td width="1%" style="font: 120% sans-serif;">{{ result[1] }}</td>
										<td width="8%" style="font: 120% sans-serif;">{{ result[2] }}</td>
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
								<tbody v-if="show_sectores_parametri">
									<tr>
										<td width="20%"style="font: 120% sans-serif; padding-left:10px; text-align:center;" colspan="3">Todos los sectores parametrizados</td>
									</tr>
								</tbody>
							</table>
						</div> 
					</div>
					
					<div class="col">
						<div class="row" style="margin: 0 0 0 0; border-radius:4px; background-color: #fff; ">
							<div class="col-md-3" style="padding: 12px 0px 0px 30px; font: 140% sans-serif;">
								<label for="">Cuentas</label>
							</div>
						</div>
						<div style="margin: 4px 0 0">
							<table>
								<thead>
									<tr>
										<td width="1%" class='titulos' style="font: 120% sans-serif; border-radius: 5px 0px 0px;">Cuenta</td>
										<td width="8%" class='titulos'  style="font: 120% sans-serif;">Nombre</td>
									</tr>
								</thead>
							</table>
						</div>
						<div style="margin: 0px 0 20px; border-radius: 0 0 0 15px; height: 200px; overflow: scroll; overflow-x: hidden; background: white; ">
							<table class='inicio inicio--no-shadow'>
								<tbody v-if="show_resultados_cuenta">
									<?php
										$co ='zebra1';
										$co2='zebra2';
									?>
									<tr v-for="result in results_cuentas"  v-on:click="chosenCuentaSector(result, 'cuenta')" v-bind:class="result[0] === app.codigo_cuenta  ? 'background_active' : ''" class='<?php echo $co; ?> text-rendering: optimizeLegibility; cursor: pointer important; style=\"cursor: hand\"' >
										<td width="1%" style="font: 120% sans-serif;">{{ result[0] }}</td>
										<td width="8%" style="font: 120% sans-serif;">{{ result[1] }}</td>
										<?php
										$aux=$co;
										$co=$co2;
										$co2=$aux;
										?>
									</tr>
								</tbody>
								<tbody v-if="show_selecciona_sector">
									<tr>
										<td width="20%"style="font: 120% sans-serif; padding-left:10px; text-align:center;" colspan="3"><- Selecciona un Sector</td>
									</tr>
								</tbody>
								<tbody v-if="show_sectores_parametri">
									<tr>
										<td width="20%"style="font: 120% sans-serif; padding-left:10px; text-align:center;" colspan="3">Todos los sectores parametrizados</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="col-2" style="display: grid;">
						<div style="align-self: center;">
							<button type="submit" class="col btn btn-primary" v-on:click="addCuentaSector" value="Buscar" style="border-radius:5px;">Agregar</button>
							<div  v-if="seleccione_sector" class="alert alert-danger">
								<p class="msm-error">Seleccione un sector</p>
							</div>
							<div  v-if="seleccione_cuenta" class="alert alert-danger">
								<p class="msm-error">Seleccione una cuenta</p>
							</div>
							<div  v-if="sector_paramatri" class="alert alert-danger">
								<p class="msm-error">Este sector ya esta parametrizado, recargue la pagina!</p>
							</div>
						</div>
					</div>
				</div>
				<table>
					<thead>
						<tr>
							<td width="10%" class='titulos' style="font: 120% sans-serif; border-radius: 5px 0px 0px;">Id sector</td>
							<td width="35%" class='titulos' style="font: 120% sans-serif;">Nombre sector</td>
							<td width="10%" class='titulos'  style="font: 120% sans-serif;">Id cuenta</td>
							<td width="35%" class='titulos'  style="font: 120% sans-serif;">Cuenta</td>
							<td width="10%" class='titulos'  style="font: 120% sans-serif; border-radius: 0px 5px 0px;">Eliminar</td>
						</tr>
					</thead>
				</table>
				<div style="margin: 0px 0 20px; border-radius: 0 0 0 15px; height: 75%; overflow: scroll; overflow-x: hidden; background: white; ">
					<table class='inicio inicio--no-shadow'>
						<tbody v-if="show_resultados_cuentasectores">
							<?php
								$co ='zebra1';
								$co2='zebra2';
							?>
							<tr v-for="result in results_cuentasectores" class='<?php echo $co; ?> text-rendering: optimizeLegibility; cursor: pointer important; style=\"cursor: hand\"' >
								<td width="10%" style="font: 120% sans-serif;">{{ result[1] }}</td>
								<td width="35%" style="font: 120% sans-serif;">{{ result[2] }}</td>
								<td width="10%" style="font: 120% sans-serif;">{{ result[3] }}</td>
								<td width="35%" style="font: 120% sans-serif;">{{ result[4] }}</td>
								<td width="10%" style="font: 120% sans-serif;"><button class="btn-delete" v-on:click="deleteCuentaSector(result[0])">Eliminar</button></td>
								<?php
								$aux=$co;
								$co=$co2;
								$co2=$aux;
								?>
							</tr>
						</tbody>
						<tbody v-else>
							<tr>
								<td width="20%"style="font: 120% sans-serif; padding-left:10px; text-align:center;" colspan="3">No hay sectores parametrizados</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		
		<script src="https://cdn.jsdelivr.net/npm/vue"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"></script>
		<script src="vue/ccp-cuentasectores.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
	</body>
</html>