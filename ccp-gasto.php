<?php
	require "comun.inc";
	require "funciones.inc";
	session_start();
	//$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
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
					<img src="imagenes/iratras.png" title="Atr&aacute;s" onClick="location.href='ccp-visualizarclasificadorpresupuestal.php'" class="mgbt"/>
				</td>
        	</tr>
		</table>
		<div class="subpantalla" style="height:80.5%; width:99.6%; overflow-x:hidden;">
			<div id="myapp">
				<div class="row" style="margin: 20px 50px 0px; border-radius: 5px !important; border-radius:4px; background-color: #E1E2E2; ">
					<div class="col-md-3" style="padding: 12px 0px 0px 30px; font: 140% sans-serif;">
						<label for="">Buscar cuenta de captura:</label>
					</div>
					
					<div class="col-md-6" style="padding: 4px">
						<input type="text" class="form-control" style="height: auto; border-radius:0;" placeholder="Ej: Paquetes de software" v-on:keyup.enter="searchMonitor"  v-model="search.keyword">
					</div>
					<div class="col-md-2 col-sm-4 col-md-offset-1" style="padding: 4px">
						<button type="submit" class="btn btn-dark" value="Buscar" style="height: auto; border-radius:0;" v-on:click="searchMonitor">Buscar</button>
					</div>
				</div>
				<span id="start_page"> </span>
				<div style="margin: 4px 50px 0 50px;">
					<table>
						<thead>
							<tr>
								<td class='titulos' style="font: 160% sans-serif; border-radius: 5px 0px 0px;">Codigo</td>
								<td class='titulos' style="font: 160% sans-serif;">Nombre</td>
								<td class='titulos' style="font: 160% sans-serif; border-radius: 0px 5px 0px 0px;">Tipo</td>
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
									<td class='titulos' style="font: 160% sans-serif; border-radius: 5px 0px 0px;">Codigo</td>
									<td class='titulos' style="font: 160% sans-serif;">Nombre</td>
									<td class='titulos' style="font: 160% sans-serif; border-radius: 0px 5px 0px 0px;">Tipo</td>
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
									<td class='titulos' style="font: 160% sans-serif; border-radius: 5px 0px 0px;">Codigo</td>
									<td class='titulos' style="font: 160% sans-serif;">Nombre</td>
									<td class='titulos' style="font: 160% sans-serif; border-radius: 0px 5px 0px 0px;">Tipo</td>
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
									<td class='titulos' style="font: 160% sans-serif; border-radius: 5px 0px 0px;">Codigo</td>
									<td class='titulos' style="font: 160% sans-serif;">Nombre</td>
									<td class='titulos' style="font: 160% sans-serif; border-radius: 0px 5px 0px 0px;">Tipo</td>
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
									<td class='titulos' style="font: 160% sans-serif; border-radius: 5px 0px 0px;">Codigo</td>
									<td class='titulos' style="font: 160% sans-serif;">Nombre</td>
									<td class='titulos' style="font: 160% sans-serif; border-radius: 0px 5px 0px 0px;">Tipo</td>
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
									<td class='titulos' style="font: 160% sans-serif; border-radius: 5px 0px 0px;">Codigo</td>
									<td class='titulos' style="font: 160% sans-serif;">Nombre</td>
									<td class='titulos' style="font: 160% sans-serif; border-radius: 0px 5px 0px 0px;">Tipo</td>
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
									<td class='titulos' style="font: 160% sans-serif; border-radius: 5px 0px 0px;">Codigo</td>
									<td class='titulos' style="font: 160% sans-serif;">Nombre</td>
									<td class='titulos' style="font: 160% sans-serif; border-radius: 0px 5px 0px 0px;">Tipo</td>
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
									<td class='titulos' style="font: 160% sans-serif; border-radius: 5px 0px 0px;">Codigo</td>
									<td class='titulos' style="font: 160% sans-serif;">Nombre</td>
									<td class='titulos' style="font: 160% sans-serif; border-radius: 0px 5px 0px 0px;">Tipo</td>
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
									<td class='titulos' style="font: 160% sans-serif; border-radius: 5px 0px 0px;">Codigo</td>
									<td class='titulos' style="font: 160% sans-serif;">Nombre</td>
									<td class='titulos' style="font: 160% sans-serif; border-radius: 0px 5px 0px 0px;">Tipo</td>
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
								<tr v-for="nivel in nivel_10" v-on:click="modalLastLevel(nivel)" class='<?php echo $co; ?>  text-rendering: optimizeLegibility; cursor: pointer important; style=\"cursor: hand\"'>
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
				<div v-show="showModal_n3">
					<transition name="modal">
						<div class="modal-mask">
							<div class="modal-wrapper">
								<div class="modal-dialog modal-lg" role="document">
									<div class="modal-content" scrollable>
									<div class="modal-header">
										<h5 class="modal-title">Cuenta de captura</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true" @click="showModal_n3 = false">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<h6><strong>Nivel 2</strong></h6> <p>{{ this.padreNivel_3}} - {{this.nombreNivel_2}}</p>
										<h6><strong>Nivel 3</strong></h6> <p>{{ this.padreNivel_4}} - {{this.nombreNivel_3}}</p>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" @click="showModal_n3 = false">Cerrar</button>
									</div>
									</div>
								</div>
							</div>
						</div>
					</transition>
				</div>
				<div v-show="showModal_n4">
					<transition name="modal">
						<div class="modal-mask">
							<div class="modal-wrapper">
								<div class="modal-dialog modal-lg" role="document">
									<div class="modal-content" scrollable>
									<div class="modal-header">
										<h5 class="modal-title">Cuenta de captura</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true" @click="showModal_n4 = false">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<h6><strong>Nivel 2</strong></h6> <p>{{ this.padreNivel_3}} - {{this.nombreNivel_2}}</p>
										<h6><strong>Nivel 3</strong></h6> <p>{{ this.padreNivel_4}} - {{this.nombreNivel_3}}</p>
										<h6><strong>Nivel 4</strong></h6> <p>{{ this.padreNivel_5}} - {{this.nombreNivel_4}}</p>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" @click="showModal_n4 = false">Cerrar</button>
									</div>
									</div>
								</div>
							</div>
						</div>
					</transition>
				</div>
				<div v-show="showModal_n5">
					<transition name="modal">
						<div class="modal-mask">
							<div class="modal-wrapper">
								<div class="modal-dialog modal-lg" role="document">
									<div class="modal-content" scrollable>
									<div class="modal-header">
										<h5 class="modal-title">Cuenta de captura</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true" @click="showModal_n5 = false">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<h6><strong>Nivel 2</strong></h6> <p>{{ this.padreNivel_3}} - {{this.nombreNivel_2}}</p>
										<h6><strong>Nivel 3</strong></h6> <p>{{ this.padreNivel_4}} - {{this.nombreNivel_3}}</p>
										<h6><strong>Nivel 4</strong></h6> <p>{{ this.padreNivel_5}} - {{this.nombreNivel_4}}</p>
										<h6><strong>Nivel 5</strong></h6> <p>{{ this.padreNivel_6}} - {{this.nombreNivel_5}}</p>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" @click="showModal_n5 = false">Cerrar</button>
									</div>
									</div>
								</div>
							</div>
						</div>
					</transition>
				</div>
				<div v-show="showModal_n6">
					<transition name="modal">
						<div class="modal-mask">
							<div class="modal-wrapper">
								<div class="modal-dialog modal-lg" role="document">
									<div class="modal-content" scrollable>
									<div class="modal-header">
										<h5 class="modal-title">Cuenta de captura</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true" @click="showModal_n6 = false">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<h6><strong>Nivel 2</strong></h6> <p>{{ this.padreNivel_3}} - {{this.nombreNivel_2}}</p>
										<h6><strong>Nivel 3</strong></h6> <p>{{ this.padreNivel_4}} - {{this.nombreNivel_3}}</p>
										<h6><strong>Nivel 4</strong></h6> <p>{{ this.padreNivel_5}} - {{this.nombreNivel_4}}</p>
										<h6><strong>Nivel 5</strong></h6> <p>{{ this.padreNivel_6}} - {{this.nombreNivel_5}}</p>
										<h6><strong>Nivel 6</strong></h6> <p>{{ this.padreNivel_7}} - {{this.nombreNivel_6}}</p>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" @click="showModal_n6 = false">Cerrar</button>
									</div>
									</div>
								</div>
							</div>
						</div>
					</transition>
				</div>
				<div v-show="showModal_n7">
					<transition name="modal">
						<div class="modal-mask">
							<div class="modal-wrapper">
								<div class="modal-dialog modal-lg" role="document">
									<div class="modal-content" scrollable>
									<div class="modal-header">
										<h5 class="modal-title">Cuenta de captura</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true" @click="showModal_n7 = false">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<h6><strong>Nivel 2</strong></h6> <p>{{ this.padreNivel_3}} - {{this.nombreNivel_2}}</p>
										<h6><strong>Nivel 3</strong></h6> <p>{{ this.padreNivel_4}} - {{this.nombreNivel_3}}</p>
										<h6><strong>Nivel 4</strong></h6> <p>{{ this.padreNivel_5}} - {{this.nombreNivel_4}}</p>
										<h6><strong>Nivel 5</strong></h6> <p>{{ this.padreNivel_6}} - {{this.nombreNivel_5}}</p>
										<h6><strong>Nivel 6</strong></h6> <p>{{ this.padreNivel_7}} - {{this.nombreNivel_6}}</p>
										<h6><strong>Nivel 7</strong></h6> <p>{{ this.padreNivel_8}} - {{this.nombreNivel_7}}</p>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" @click="showModal_n7 = false">Cerrar</button>
									</div>
									</div>
								</div>
							</div>
						</div>
					</transition>
				</div>
				<div v-show="showModal_n8">
					<transition name="modal">
						<div class="modal-mask">
							<div class="modal-wrapper">
								<div class="modal-dialog modal-lg" role="document">
									<div class="modal-content" scrollable>
									<div class="modal-header">
										<h5 class="modal-title">Cuenta de captura</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true" @click="showModal_n8 = false">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<h6><strong>Nivel 2</strong></h6> <p>{{ this.padreNivel_3}} - {{this.nombreNivel_2}}</p>
										<h6><strong>Nivel 3</strong></h6> <p>{{ this.padreNivel_4}} - {{this.nombreNivel_3}}</p>
										<h6><strong>Nivel 4</strong></h6> <p>{{ this.padreNivel_5}} - {{this.nombreNivel_4}}</p>
										<h6><strong>Nivel 5</strong></h6> <p>{{ this.padreNivel_6}} - {{this.nombreNivel_5}}</p>
										<h6><strong>Nivel 6</strong></h6> <p>{{ this.padreNivel_7}} - {{this.nombreNivel_6}}</p>
										<h6><strong>Nivel 7</strong></h6> <p>{{ this.padreNivel_8}} - {{this.nombreNivel_7}}</p>
										<h6><strong>Nivel 8</strong></h6> <p>{{ this.padreNivel_9}} - {{this.nombreNivel_8}}</p>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" @click="showModal_n8 = false">Cerrar</button>
									</div>
									</div>
								</div>
							</div>
						</div>
					</transition>
				</div>
				<div v-show="showModal_n9">
					<transition name="modal">
						<div class="modal-mask">
							<div class="modal-wrapper">
								<div class="modal-dialog modal-lg" role="document">
									<div class="modal-content" scrollable>
									<div class="modal-header">
										<h5 class="modal-title">Cuenta de captura</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true" @click="showModal_n9 = false">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<h6><strong>Nivel 2</strong></h6> <p>{{ this.padreNivel_3}} - {{this.nombreNivel_2}}</p>
										<h6><strong>Nivel 3</strong></h6> <p>{{ this.padreNivel_4}} - {{this.nombreNivel_3}}</p>
										<h6><strong>Nivel 4</strong></h6> <p>{{ this.padreNivel_5}} - {{this.nombreNivel_4}}</p>
										<h6><strong>Nivel 5</strong></h6> <p>{{ this.padreNivel_6}} - {{this.nombreNivel_5}}</p>
										<h6><strong>Nivel 6</strong></h6> <p>{{ this.padreNivel_7}} - {{this.nombreNivel_6}}</p>
										<h6><strong>Nivel 7</strong></h6> <p>{{ this.padreNivel_8}} - {{this.nombreNivel_7}}</p>
										<h6><strong>Nivel 8</strong></h6> <p>{{ this.padreNivel_9}} - {{this.nombreNivel_8}}</p>
										<h6><strong>Nivel 9</strong></h6> <p>{{ this.padreNivel_10}} - {{this.nombreNivel_9}}</p>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" @click="showModal_n9 = false">Cerrar</button>
									</div>
									</div>
								</div>
							</div>
						</div>
					</transition>
				</div>
				<div v-show="showModal_n10">
					<transition name="modal">
						<div class="modal-mask">
							<div class="modal-wrapper">
								<div class="modal-dialog modal-lg" role="document">
									<div class="modal-content" scrollable>
									<div class="modal-header">
										<h5 class="modal-title">Cuenta de captura</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true" @click="showModal_n10 = false">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<h6><strong>Nivel 2</strong></h6> <p>{{ this.padreNivel_3}} - {{this.nombreNivel_2}}</p>
										<h6><strong>Nivel 3</strong></h6> <p>{{ this.padreNivel_4}} - {{this.nombreNivel_3}}</p>
										<h6><strong>Nivel 4</strong></h6> <p>{{ this.padreNivel_5}} - {{this.nombreNivel_4}}</p>
										<h6><strong>Nivel 5</strong></h6> <p>{{ this.padreNivel_6}} - {{this.nombreNivel_5}}</p>
										<h6><strong>Nivel 6</strong></h6> <p>{{ this.padreNivel_7}} - {{this.nombreNivel_6}}</p>
										<h6><strong>Nivel 7</strong></h6> <p>{{ this.padreNivel_8}} - {{this.nombreNivel_7}}</p>
										<h6><strong>Nivel 8</strong></h6> <p>{{ this.padreNivel_9}} - {{this.nombreNivel_8}}</p>
										<h6><strong>Nivel 9</strong></h6> <p>{{ this.padreNivel_10}} - {{this.nombreNivel_9}}</p>
										<h6><strong>Nivel 10</strong></h6> <p>{{ this.codigoNivel_10}} - {{this.nombreNivel_10}}</p>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" @click="showModal_n10 = false">Cerrar</button>
									</div>
									</div>
								</div>
							</div>
						</div>
					</transition>
				</div>
				<span id="end_page"> </span>
			</div>
		</div>
		<script src="https://cdn.jsdelivr.net/npm/vue"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"></script>
		<script src="vue/ccpet.js"></script>
	</body>
</html>