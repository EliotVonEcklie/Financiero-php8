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
		<title>:: SieS - Presupuesto</title>
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
			.titulos2{
				background: none;
			}
			.head-results{
				display: grid;
				justify-items: center;
				align-items: center;
				height: 40px;
				margin-bottom: 10px; 
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
					<a href="#" onClick="mypop=window.open('ccp-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
				</td>
        	</tr>
		</table>
		<div class="subpantalla" style="height:80.5%; width:99.6%; overflow-x:hidden;">
			<div id="myapp">
				<div class="row" style="margin: 20px 50px 0 50px;">
					<label for="" style="margin-bottom: 0;">Buscar cuenta de captura</label>
				</div>
				<div class="row" style="margin: 0 50px;">
					<input type="text" class="col-md-3 form-control" style="height: auto; border-radius:0;" placeholder="Ej: Superavit fiscal" v-on:keyup.enter="searchMonitor"  v-model="search.keyword">
					<button type="submit" class="col-md-1  btn btn-dark" value="Buscar" style="height: auto; border-radius:0;" v-on:click="searchMonitor">Buscar</button>
					<div v-if="!show_resultados" class="col-md-2 alert alert-danger sin_resultados">Sin resultados</div>
					
				</div>
				<span id="start_page"> </span>
				<div style="margin: 20px 50px 0 50px;">
					<table>
						<thead>
							<tr>
								<td class='titulos' style="font: 160% sans-serif;">Codigo</td>
								<td class='titulos' style="font: 160% sans-serif;">Nombre</td>
								<td class='titulos' style="font: 160% sans-serif;">Tipo</td>
							</tr>
						</thead>
					</table>
				</div>
				<div style="margin: 0px 50px 20px; border-radius: 0 0 0 15px; height: 25%; overflow: scroll; overflow-x: hidden; background: white; ">
					<table class='inicio inicio--no-shadow'>
						<tbody>
								<?php
									$co ='zebra1';
									$co2='zebra2';
								?>
								<tr v-for="nivel in nivel_2" v-on:click="siguienteNivel3(nivel)" v-bind:class="nivel[1] === padreNivel_3 ? 'background_active' : ''" class='<?php echo $co; ?> text-rendering: optimizeLegibility; cursor: pointer important; style=\"cursor: hand\"' >
									<td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ nivel[1] }}</td>
									<td width="60%" style="font: 120% sans-serif; padding-left:10px">{{ nivel[2] }}</td>
									<td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ nivel[6] }}</td>

									<?php
									$aux=$co;
									$co=$co2;
									$co2=$aux;
									?>

								</tr>
							
						</tbody>
					</table>
				</div>
				<div v-show="mostrarNivel_3">
					<div style="margin: 0px 50px 0 50px;">
						<table>
							<thead>
								<tr >
									<td class='titulos2' style="font-size: 15px !important; font: 150% sans-serif;" colspan='3'>Nivel 3</td>
								</tr>
								<tr>
									<td class='titulos' style="font: 160% sans-serif;">Codigo</td>
									<td class='titulos' style="font: 160% sans-serif;">Nombre</td>
									<td class='titulos' style="font: 160% sans-serif;">Tipo</td>
								</tr>
							</thead>
						</table>
					</div>
					<div style="margin: 0px 50px 20px; border-radius: 0 0 0 15px; height: 25%; overflow: scroll; overflow-x: hidden; background: white; ">
						<table class='inicio inicio--no-shadow'>
							<tbody>
								<?php
									$co ='zebra1';
									$co2='zebra2';
								?>
								<tr v-for="nivel in nivel_3" v-on:click="siguienteNivel4(nivel)" v-bind:class="nivel[1] === padreNivel_4 ? 'background_active' : ''" class='<?php echo $co; ?>  text-rendering: optimizeLegibility; cursor: pointer important; style=\"cursor: hand\"'>
									<td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ nivel[1] }}</td>
									<td width="60%" style="font: 120% sans-serif; padding-left:10px">{{ nivel[2] }}</td>
									<td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ nivel[6] }}</td>

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
				<div v-show="mostrarNivel_4">
					<div style="margin: 0px 50px 0 50px;">	
						<table>
							<thead>
								<tr >
									<td class='titulos2' style="font-size: 15px !important; font: 150% sans-serif;" colspan='3'>Nivel 4</td>
								</tr>
								<tr>
									<td class='titulos' style="font: 160% sans-serif;">Codigo</td>
									<td class='titulos' style="font: 160% sans-serif;">Nombre</td>
									<td class='titulos' style="font: 160% sans-serif;">Tipo</td>
								</tr>
							</thead>
						</table>
					</div>
					<div style="margin: 0px 50px 20px; border-radius: 0 0 0 15px; height: 25%; overflow: scroll; overflow-x: hidden; background: white; ">
						<table class='inicio inicio--no-shadow'>
							<tbody>
								<?php
									$co ='zebra1';
									$co2='zebra2';
								?>
								<tr v-for="nivel in nivel_4" v-on:click="siguienteNivel5(nivel)" v-bind:class="nivel[1] === padreNivel_5 ? 'background_active' : ''" class='<?php echo $co; ?>  text-rendering: optimizeLegibility; cursor: pointer important; style=\"cursor: hand\"'>
									<td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ nivel[1] }}</td>
									<td width="60%" style="font: 120% sans-serif; padding-left:10px">{{ nivel[2] }}</td>
									<td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ nivel[6] }}</td>


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
				<div v-show="mostrarNivel_5">
					<div style="margin: 0px 50px 0 50px;">	
						<table>
							<thead>
								<tr>
									<td class='titulos2' style="font-size: 15px !important; font: 150% sans-serif;" colspan='3'>Nivel 5</td>
								</tr>
								<tr>
									<td class='titulos' style="font: 160% sans-serif;">Codigo</td>
									<td class='titulos' style="font: 160% sans-serif;">Nombre</td>
									<td class='titulos' style="font: 160% sans-serif;">Tipo</td>
								</tr>
							</thead>
						</table>
					</div>
					<div style="margin: 0px 50px 20px; border-radius: 0 0 0 15px; height: 25%; overflow: scroll; overflow-x: hidden; background: white; ">
						<table class='inicio inicio--no-shadow'>
							<tbody>
								<?php
									$co ='zebra1';
									$co2='zebra2';
								?>
								<tr v-for="nivel in nivel_5" v-on:click="siguienteNivel6(nivel)" v-bind:class="nivel[1] === padreNivel_6 ? 'background_active' : ''" class='<?php echo $co; ?>  text-rendering: optimizeLegibility; cursor: pointer important; style=\"cursor: hand\"'>
									<td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ nivel[1] }}</td>
									<td width="60%" style="font: 120% sans-serif; padding-left:10px">{{ nivel[2] }}</td>
									<td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ nivel[6] }}</td>


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
				<div v-show="mostrarNivel_6">
					<div style="margin: 0px 50px 0 50px;">	
						<table>
							<thead>
								<tr>
									<td class='titulos2' style="font-size: 15px !important; font: 150% sans-serif;" colspan='3'>Nivel 6</td>
								</tr>
								<tr>
									<td class='titulos' style="font: 160% sans-serif;">Codigo</td>
									<td class='titulos' style="font: 160% sans-serif;">Nombre</td>
									<td class='titulos' style="font: 160% sans-serif;">Tipo</td>
								</tr>
							</thead>
						</table>
					</div>	
					<div style="margin: 0px 50px 20px; border-radius: 0 0 0 15px; height: 25%; overflow: scroll; overflow-x: hidden; background: white; ">
						<table class='inicio inicio--no-shadow'>
							<tbody>
								<?php
									$co ='zebra1';
									$co2='zebra2';
								?>
								<tr v-for="nivel in nivel_6" v-on:click="siguienteNivel7(nivel)" v-bind:class="nivel[1] === padreNivel_7 ? 'background_active' : ''" class='<?php echo $co; ?>  text-rendering: optimizeLegibility; cursor: pointer important; style=\"cursor: hand\"'>
									<td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ nivel[1] }}</td>
									<td width="60%" style="font: 120% sans-serif; padding-left:10px">{{ nivel[2] }}</td>
									<td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ nivel[6] }}</td>


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
				<div v-show="mostrarNivel_7">
					<div style="margin: 0px 50px 0 50px;">	
						<table>
							<thead>
								<tr>
									<td class='titulos2' style="font-size: 15px !important; font: 150% sans-serif;" colspan='3'>Nivel 7</td>
								</tr>
								<tr>
									<td class='titulos' style="font: 160% sans-serif;">Codigo</td>
									<td class='titulos' style="font: 160% sans-serif;">Nombre</td>
									<td class='titulos' style="font: 160% sans-serif;">Tipo</td>
								</tr>
							</thead>
						</table>
					</div>	
					<div style="margin: 0px 50px 20px; border-radius: 0 0 0 15px; height: 25%; overflow: scroll; overflow-x: hidden; background: white; ">	
						<table class='inicio inicio--no-shadow'>
							<tbody>
								<?php
									$co ='zebra1';
									$co2='zebra2';
								?>
								<tr v-for="nivel in nivel_7" v-on:click="siguienteNivel8(nivel)" v-bind:class="nivel[1] === padreNivel_8 ? 'background_active' : ''" class='<?php echo $co; ?>  text-rendering: optimizeLegibility; cursor: pointer important; style=\"cursor: hand\"'>
									<td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ nivel[1] }}</td>
									<td width="60%" style="font: 120% sans-serif; padding-left:10px">{{ nivel[2] }}</td>
									<td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ nivel[6] }}</td>


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
				<div v-show="mostrarNivel_8">
					<div style="margin: 0px 50px 0 50px;">	
						<table>
							<thead>
								<tr>
									<td class='titulos2' style="font-size: 15px !important; font: 150% sans-serif;" colspan='3'>Nivel 8</td>
								</tr>
								<tr>
									<td class='titulos' style="font: 160% sans-serif;">Codigo</td>
									<td class='titulos' style="font: 160% sans-serif;">Nombre</td>
									<td class='titulos' style="font: 160% sans-serif;">Tipo</td>
								</tr>
							</thead>
						</table>
					</div>		
					<div style="margin: 0px 50px 20px; border-radius: 0 0 0 15px; height: 25%; overflow: scroll; overflow-x: hidden; background: white; ">		
						<table class='inicio inicio--no-shadow'>
							<tbody>
								<?php
									$co ='zebra1';
									$co2='zebra2';
								?>
								<tr v-for="nivel in nivel_8" v-on:click="siguienteNivel9(nivel)" v-bind:class="nivel[1] === padreNivel_9 ? 'background_active' : ''" class='<?php echo $co; ?>  text-rendering: optimizeLegibility; cursor: pointer important; style=\"cursor: hand\"'>
									<td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ nivel[1] }}</td>
									<td width="60%" style="font: 120% sans-serif; padding-left:10px">{{ nivel[2] }}</td>
									<td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ nivel[6] }}</td>


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
				<div v-show="mostrarNivel_9">
					<div style="margin: 0px 50px 0 50px;">	
						<table>
							<thead>
								<tr>
									<td class='titulos2' style="font-size: 15px !important; font: 150% sans-serif;" colspan='3'>Nivel 9</td>
								</tr>
								<tr>
									<td class='titulos' style="font: 160% sans-serif;">Codigo</td>
									<td class='titulos' style="font: 160% sans-serif;">Nombre</td>
									<td class='titulos' style="font: 160% sans-serif;">Tipo</td>
								</tr>
							</thead>
						</table>
					</div>	
					<div style="margin: 0px 50px 20px; border-radius: 0 0 0 15px; height: 25%; overflow: scroll; overflow-x: hidden; background: white; ">
						<table class='inicio inicio--no-shadow'>
							<tbody>
								<?php
									$co ='zebra1';
									$co2='zebra2';
								?>
								<tr v-for="nivel in nivel_9" v-on:click="siguienteNivel10(nivel)"  v-bind:class="nivel[1] === padreNivel_10 ? 'background_active' : ''" class='<?php echo $co; ?>  text-rendering: optimizeLegibility; cursor: pointer important; style=\"cursor: hand\"'>
									<td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ nivel[1] }}</td>
									<td width="60%" style="font: 120% sans-serif; padding-left:10px">{{ nivel[2] }}</td>
									<td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ nivel[6] }}</td>


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
				
				<div v-show="mostrarNivel_10">
					<div style="margin: 0px 50px 0 50px;">	
						<table>
							<thead>
								<tr>
									<td class='titulos2' style="font-size: 15px !important; font: 150% sans-serif;" colspan='3'>Nivel 10</td>
								</tr>
								<tr>
									<td class='titulos' style="font: 160% sans-serif;">Codigo</td>
									<td class='titulos' style="font: 160% sans-serif;">Nombre</td>
									<td class='titulos' style="font: 160% sans-serif;">Tipo</td>
								</tr>
							</thead>
						</table>
					</div>	
					<div style="margin: 0px 50px 20px; border-radius: 0 0 0 15px; height: 25%; overflow: scroll; overflow-x: hidden; background: white; ">
						<table class='inicio inicio--no-shadow'>
							<tbody>
								<?php
									$co ='zebra1';
									$co2='zebra2';
								?>
								<tr v-for="nivel in nivel_10" class='<?php echo $co; ?>  text-rendering: optimizeLegibility; cursor: pointer important; style=\"cursor: hand\"'>
									<td width="20%"style="font: 120% sans-serif; padding-left:10px">{{ nivel[1] }}</td>
									<td width="60%"style="font: 120% sans-serif; padding-left:10px">{{ nivel[2] }}</td>
									<td width="20%"style="font: 120% sans-serif; padding-left:10px">{{ nivel[6] }}</td>


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
				
				

				<div v-show="show_table_search" id="show_table_search">
					<div style="margin: 0px 50px 0 50px;">	
						<hr>
						<div class="head-results">
							<p>Resultados</p>
						</div>
						<table>
							<thead>
								<tr>
									<td class='titulos_search' style="font: 160% sans-serif;">Codigo</td>
									<td class='titulos_search' style="font: 160% sans-serif;">Nombre</td>
									<td class='titulos_search' style="font: 160% sans-serif;">Tipo</td>
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
								<tr v-for="nivel in result_search" v-on:click="show_levels(nivel)" class='<?php echo $co; ?>  text-rendering: optimizeLegibility; cursor: pointer important; style=\"cursor: hand\"'>
									<td width="20%"style="font: 120% sans-serif; padding-left:10px">{{ nivel[1] }}</td>
									<td width="60%"style="font: 120% sans-serif; padding-left:10px">{{ nivel[2] }}</td>
									<td width="20%"style="font: 120% sans-serif; padding-left:10px">{{ nivel[6] }}</td>
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
				<!-- end test -->
				<span id="end_page"> </span>
			</div>
		</div>
		
		<script src="https://cdn.jsdelivr.net/npm/vue"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"></script>
		<script src="vue/ingreso-ccpet.js"></script>
	</body>
</html>