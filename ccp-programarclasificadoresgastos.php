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
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <script type="text/javascript" src="bootstrap/fontawesome.5.11.2/js/all.js"></script>
		
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
			.zebra1{
				cursor: pointer;
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
			.modal-body_1{
				padding-top: 15px;
				height: 50px;
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
					<a href="ccp-programarclasificadorpresupuestal.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
					<a href="#" onClick="mypop=window.open('ccp-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
				</td>
        	</tr>
		</table>
		<div class="subpantalla" style="height:80.5%; width:99.6%; overflow-x:hidden;">
			<div id="myapp">
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
								<tr v-for="nivel in nivel_2" v-on:click="siguienteNivel3(nivel)" v-bind:class="nivel[1] === padreNivel_3 ? 'background_active' : ''" class='<?php echo $co; ?>' style='height: 32.5px !important; text-rendering: optimizeLegibility; cursor: pointer important; style=\"cursor: hand\"' >
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
						<div class="row" style="margin: 4px; border-radius:4px; background-color: #E1E2E2; ">
							<div class="col-md-2" style="padding: 12px 0px 0px 30px; font: 140% sans-serif;">
								<label for="">Nivel 3</label>
							</div>
						</div>

						<table>
							<thead>
								<tr>
									<td width="10%" class='titulos' style="font: 160% sans-serif; border-radius: 5px 0px 0px;">C&oacute;digo</td>
									<td width="20%" class='titulos' style="font: 160% sans-serif;">Nombre</td>
									<td width="10%" class='titulos' style="font: 160% sans-serif;">Tipo</td>
									<td width="40%" class='titulos' style="font: 160% sans-serif;">Clasificadores</td>
									<td width="20%" class='titulos' style="font: 160% sans-serif; border-radius: 0px 5px 0px 0px; text-align: center;">Programar</td>
								</tr>
							</thead>
						</table>
					</div>
					<div style="margin: 0px 50px 20px; border-radius: 0 0 0 15px; height: 30%; overflow: scroll; overflow-x: hidden; background: white; ">
                        <div class="row">
							<table class='inicio inicio--no-shadow'>
								<tbody c>
									<?php
										$co ='zebra1'; 
										$co2='zebra2';
									?>
									<tr v-for="nivel in nivel_3" v-bind:class="nivel[1] === padreNivel_4 ? 'background_active' : ''" class='<?php echo $co; ?>' style='height: 40px !important; text-rendering: optimizeLegibility; cursor: pointer important; border-right-style: none; style=\"cursor: hand\"'>
										<td v-on:click="siguienteNivel4(nivel)" width="10%" style="font: 120% sans-serif; padding-left:30px">{{ nivel[1] }}</td>
										<td v-on:click="siguienteNivel4(nivel)" width="20%" style="font: 120% sans-serif; padding-left:10px">{{ nivel[2] }}</td>
										<td v-on:click="siguienteNivel4(nivel)" width="10%" style="font: 120% sans-serif; padding-left:10px">{{ nivel[6] }}</td>
										<td v-on:click="siguienteNivel4(nivel)" width="40%" style="font: 120% sans-serif; padding-left:10px;">{{ clasificadorPorNombres[nivel[1]] }} </td>
										<?php
										$aux=$co;
										$co=$co2;
										$co2=$aux;
										?>
										<td v-on:click="mostrarModal(nivel)" width="20%" class='zebra1' style='font: 120% sans-serif; text-align:center; background: #FFFFFF ; text-rendering: optimizeLegibility; cursor: pointer important; height: 40px !important; border-left-style: none; margin-left: -10px; style=\"cursor: hand\"'>
											<button type="button" class="btn btn-default">
												<i class="fas fa-plus-square"></i>
											</button>
										</td>
									</tr>
								</tbody>
							</table>
                        </div>
						
                        
					</div>
				</div>
				<div v-show="mostrarNivel_4">
					<div style="margin: 0px 50px 0 50px;">	
						<div class="row" style="margin: 4px; border-radius:4px; background-color: #E1E2E2; ">
							<div class="col-md-2" style="padding: 12px 0px 0px 30px; font: 140% sans-serif;">
								<label for="">Nivel 4</label>
							</div>
						</div>
						<table>
							<thead>
								<tr>
									<td width="10%" class='titulos' style="font: 160% sans-serif; border-radius: 5px 0px 0px;">C&oacute;digo</td>
									<td width="20%" class='titulos' style="font: 160% sans-serif;">Nombre</td>
									<td width="10%" class='titulos' style="font: 160% sans-serif;">Tipo</td>
									<td width="40%" class='titulos' style="font: 160% sans-serif;">Clasificadores</td>
									<td width="20%" class='titulos' style="font: 160% sans-serif; border-radius: 0px 5px 0px 0px; text-align: center;">Programar</td>
								</tr>
							</thead>
						</table>
					</div>
					<div style="margin: 0px 50px 20px; border-radius: 0 0 0 15px; height: 30%; overflow: scroll; overflow-x: hidden; background: white; ">
						<div class="row">
							<table class='inicio inicio--no-shadow'>
								<tbody>
									<?php
										$co ='zebra1';
										$co2='zebra2';
									?>
									<tr v-for="nivel in nivel_4" v-bind:class="nivel[1] === padreNivel_5 ? 'background_active' : ''" class='<?php echo $co; ?>' style='height: 40px !important; text-rendering: optimizeLegibility; cursor: pointer important; border-right-style: none; style=\"cursor: hand\"'>
										<td  v-on:click="siguienteNivel5(nivel)" width="10%" style="font: 120% sans-serif; padding-left:30px">{{ nivel[1] }}</td>
										<td  v-on:click="siguienteNivel5(nivel)" width="20%" style="font: 120% sans-serif; padding-left:10px">{{ nivel[2] }}</td>
										<td  v-on:click="siguienteNivel5(nivel)" width="10%" style="font: 120% sans-serif; padding-left:10px">{{ nivel[6] }}</td>
										<td  v-on:click="siguienteNivel5(nivel)" width="40%" style="font: 120% sans-serif; padding-left:10px;">{{ clasificadorPorNombres_4[nivel[1]] }} </td>
										<td v-on:click="mostrarModal(nivel)" width="20%" class='<?php echo $co; ?>' style='font: 120% sans-serif; text-align:center; background: #FFFFFF ; text-rendering: optimizeLegibility; cursor: pointer important; height: 40px !important; border-left-style: none; margin-left: -10px; style=\"cursor: hand\"'>
											<button type="button" class="btn btn-default">
												<i class="fas fa-plus-square"></i>
											</button>
										</td>

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
				</div>
				<div v-show="mostrarNivel_5">
					<div style="margin: 0px 50px 0 50px;">	
						<div class="row" style="margin: 4px; border-radius:4px; background-color: #E1E2E2; ">
							<div class="col-md-2" style="padding: 12px 0px 0px 30px; font: 140% sans-serif;">
								<label for="">Nivel 5</label>
							</div>
						</div>
						<table>
							<thead>
								<tr>
									<td width="10%" class='titulos' style="font: 160% sans-serif; border-radius: 5px 0px 0px;">C&oacute;digo</td>
									<td width="20%" class='titulos' style="font: 160% sans-serif;">Nombre</td>
									<td width="10%" class='titulos' style="font: 160% sans-serif;">Tipo</td>
									<td width="40%" class='titulos' style="font: 160% sans-serif;">Clasificadores</td>
									<td width="20%" class='titulos' style="font: 160% sans-serif; border-radius: 0px 5px 0px 0px; text-align: center;">Programar</td>
								</tr>
							</thead>
						</table>
					</div>
					<div style="margin: 0px 50px 20px; border-radius: 0 0 0 15px; height: 30%; overflow: scroll; overflow-x: hidden; background: white; ">
						<div class="row">
							<table class='inicio inicio--no-shadow'>
								<tbody>
									<?php
										$co ='zebra1';
										$co2='zebra2';
									?>
									<tr v-for="nivel in nivel_5"  v-bind:class="nivel[1] === padreNivel_6 ? 'background_active' : ''" class='<?php echo $co; ?>' style='height: 40px !important; text-rendering: optimizeLegibility; cursor: pointer important; border-right-style: none; style=\"cursor: hand\"'>
										<td v-on:click="siguienteNivel6(nivel)" width="10%" style="font: 120% sans-serif; padding-left:30px">{{ nivel[1] }}</td>
										<td v-on:click="siguienteNivel6(nivel)" width="20%" style="font: 120% sans-serif; padding-left:10px">{{ nivel[2] }}</td>
										<td v-on:click="siguienteNivel6(nivel)" width="10%" style="font: 120% sans-serif; padding-left:10px">{{ nivel[6] }}</td>
										<td v-on:click="siguienteNivel6(nivel)" width="40%" style="font: 120% sans-serif; padding-left:10px;">{{ clasificadorPorNombres_5[nivel[1]] }} </td>
										<td v-on:click="mostrarModal(nivel)" width="20%" style='font: 120% sans-serif; text-align:center; background: #FFFFFF;'>
											<button type="button" class="btn btn-default">
												<i class="fas fa-plus-square"></i>
											</button>
										</td>

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
				</div>
				<div v-show="mostrarNivel_6">
					<div style="margin: 0px 50px 0 50px;">	
						<div class="row" style="margin: 4px; border-radius:4px; background-color: #E1E2E2; ">
							<div class="col-md-2" style="padding: 12px 0px 0px 30px; font: 140% sans-serif;">
								<label for="">Nivel 6</label>
							</div>
						</div>
						<table>
							<thead>
								<tr>
									<td width="10%" class='titulos' style="font: 160% sans-serif; border-radius: 5px 0px 0px;">C&oacute;digo</td>
									<td width="20%" class='titulos' style="font: 160% sans-serif;">Nombre</td>
									<td width="10%" class='titulos' style="font: 160% sans-serif;">Tipo</td>
									<td width="40%" class='titulos' style="font: 160% sans-serif;">Clasificadores</td>
									<td width="20%" class='titulos' style="font: 160% sans-serif; border-radius: 0px 5px 0px 0px; text-align: center;">Programar</td>
								</tr>
							</thead>
						</table>
					</div>	
					<div style="margin: 0px 50px 20px; border-radius: 0 0 0 15px; height: 30%; overflow: scroll; overflow-x: hidden; background: white; ">
						<div class="row">
							<table class='inicio inicio--no-shadow'>
								<tbody>
									<?php
										$co ='zebra1';
										$co2='zebra2';
									?>
									<tr v-for="nivel in nivel_6" v-bind:class="nivel[1] === padreNivel_7 ? 'background_active' : ''" class='<?php echo $co; ?>' style='height: 40px !important; text-rendering: optimizeLegibility; cursor: pointer important; border-right-style: none; style=\"cursor: hand\"'>
											<td v-on:click="siguienteNivel7(nivel)" width="10%" style="font: 120% sans-serif; padding-left:30px">{{ nivel[1] }}</td>
											<td v-on:click="siguienteNivel7(nivel)" width="20%" style="font: 120% sans-serif; padding-left:10px">{{ nivel[2] }}</td>
											<td v-on:click="siguienteNivel7(nivel)" width="10%" style="font: 120% sans-serif; padding-left:10px">{{ nivel[6] }}</td>
											<td v-on:click="siguienteNivel7(nivel)" width="40%" style="font: 120% sans-serif; padding-left:10px;">{{ clasificadorPorNombres_6[nivel[1]] }} </td>
											<td v-on:click="mostrarModal(nivel)" width="20%" style='font: 120% sans-serif; text-align:center; background: #FFFFFF;'>
												<button type="button" class="btn btn-default">
													<i class="fas fa-plus-square"></i>
												</button>
											</td>
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
				</div>
				<div v-show="mostrarNivel_7">
					<div style="margin: 0px 50px 0 50px;">	
						<div class="row" style="margin: 4px; border-radius:4px; background-color: #E1E2E2; ">
							<div class="col-md-2" style="padding: 12px 0px 0px 30px; font: 140% sans-serif;">
								<label for="">Nivel 7</label>
							</div>
						</div>
						<table>
							<thead>
								<tr>
									<td width="10%" class='titulos' style="font: 160% sans-serif; border-radius: 5px 0px 0px;">C&oacute;digo</td>
									<td width="20%" class='titulos' style="font: 160% sans-serif;">Nombre</td>
									<td width="10%" class='titulos' style="font: 160% sans-serif;">Tipo</td>
									<td width="40%" class='titulos' style="font: 160% sans-serif;">Clasificadores</td>
									<td width="20%" class='titulos' style="font: 160% sans-serif; border-radius: 0px 5px 0px 0px; text-align: center;">Programar</td>
								</tr>
							</thead>
						</table>
					</div>	
					<div style="margin: 0px 50px 20px; border-radius: 0 0 0 15px; height: 30%; overflow: scroll; overflow-x: hidden; background: white; ">
						<div class="row">
							<table class='inicio inicio--no-shadow'>
								<tbody>
									<?php
										$co ='zebra1';
										$co2='zebra2';
									?>
									<tr v-for="nivel in nivel_7" v-bind:class="nivel[1] === padreNivel_8 ? 'background_active' : ''" class='<?php echo $co; ?> ' style='height: 40px !important; text-rendering: optimizeLegibility; cursor: pointer important; border-right-style: none; style=\"cursor: hand\"'>
										<td v-on:click="siguienteNivel8(nivel)" width="10%" style="font: 120% sans-serif; padding-left:30px">{{ nivel[1] }}</td>
										<td v-on:click="siguienteNivel8(nivel)" width="20%" style="font: 120% sans-serif; padding-left:10px">{{ nivel[2] }}</td>
										<td v-on:click="siguienteNivel8(nivel)" width="10%" style="font: 120% sans-serif; padding-left:10px">{{ nivel[6] }}</td>
										<td v-on:click="siguienteNivel8(nivel)" width="40%" style="font: 120% sans-serif; padding-left:10px;">{{ clasificadorPorNombres_7[nivel[1]] }} </td>
										<td v-on:click="mostrarModal(nivel)" width="20%" style='font: 120% sans-serif; text-align:center; background: #FFFFFF;'>
											<button type="button" class="btn btn-default">
												<i class="fas fa-plus-square"></i>
											</button>
										</td>

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
				</div>
				<div v-show="mostrarNivel_8">
					<div style="margin: 0px 50px 0 50px;">
						<div class="row" style="margin: 4px; border-radius:4px; background-color: #E1E2E2; ">
							<div class="col-md-2" style="padding: 12px 0px 0px 30px; font: 140% sans-serif;">
								<label for="">Nivel 8</label>
							</div>
						</div>	
						<table>
							<thead>
								<tr>
									<td width="10%" class='titulos' style="font: 160% sans-serif; border-radius: 5px 0px 0px;">C&oacute;digo</td>
									<td width="20%" class='titulos' style="font: 160% sans-serif;">Nombre</td>
									<td width="10%" class='titulos' style="font: 160% sans-serif;">Tipo</td>
									<td width="40%" class='titulos' style="font: 160% sans-serif;">Clasificadores</td>
									<td width="20%" class='titulos' style="font: 160% sans-serif; border-radius: 0px 5px 0px 0px; text-align: center;">Programar</td>
								</tr>
							</thead>
						</table>
					</div>		
					<div style="margin: 0px 50px 20px; border-radius: 0 0 0 15px; height: 30%; overflow: scroll; overflow-x: hidden; background: white; ">
						<div class="row">
							<table class='inicio inicio--no-shadow'>
								<tbody>
									<?php
										$co ='zebra1';
										$co2='zebra2';
									?>
									<tr v-for="nivel in nivel_8" v-bind:class="nivel[1] === padreNivel_9 ? 'background_active' : ''" class='<?php echo $co; ?> ' style='height: 40px !important; text-rendering: optimizeLegibility; cursor: pointer important; border-right-style: none; style=\"cursor: hand\"'>
										<td v-on:click="siguienteNivel9(nivel)" width="10%" style="font: 120% sans-serif; padding-left:30px">{{ nivel[1] }}</td>
										<td v-on:click="siguienteNivel9(nivel)" width="20%" style="font: 120% sans-serif; padding-left:10px">{{ nivel[2] }}</td>
										<td v-on:click="siguienteNivel9(nivel)" width="10%" style="font: 120% sans-serif; padding-left:10px">{{ nivel[6] }}</td>
										<td v-on:click="siguienteNivel9(nivel)" width="40%" style="font: 120% sans-serif; padding-left:10px;">{{ clasificadorPorNombres_8[nivel[1]] }} </td>
										<td v-on:click="mostrarModal(nivel)" width="20%" style='font: 120% sans-serif; text-align:center; background: #FFFFFF;'>
											<button type="button" class="btn btn-default">
												<i class="fas fa-plus-square"></i>
											</button>
										</td>

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
				</div>
				<div v-show="mostrarNivel_9">
					<div style="margin: 0px 50px 0 50px;">
						<div class="row" style="margin: 4px; border-radius:4px; background-color: #E1E2E2; ">
							<div class="col-md-2" style="padding: 12px 0px 0px 30px; font: 140% sans-serif;">
								<label for="">Nivel 9</label>
							</div>
						</div>	
						<table>
							<thead>
								<tr>
									<td width="10%" class='titulos' style="font: 160% sans-serif; border-radius: 5px 0px 0px;">C&oacute;digo</td>
									<td width="20%" class='titulos' style="font: 160% sans-serif;">Nombre</td>
									<td width="10%" class='titulos' style="font: 160% sans-serif;">Tipo</td>
									<td width="40%" class='titulos' style="font: 160% sans-serif;">Clasificadores</td>
									<td width="20%" class='titulos' style="font: 160% sans-serif; border-radius: 0px 5px 0px 0px; text-align: center;">Programar</td>
								</tr>
							</thead>
						</table>
					</div>	
					<div style="margin: 0px 50px 20px; border-radius: 0 0 0 15px; height: 30%; overflow: scroll; overflow-x: hidden; background: white; ">
						<div class="row">
							<table class='inicio inicio--no-shadow'>
								<tbody>
									<?php
										$co ='zebra1';
										$co2='zebra2';
									?>
									<tr v-for="nivel in nivel_9" v-on:click="siguienteNivel10(nivel)"  v-bind:class="nivel[1] === padreNivel_10 ? 'background_active' : ''" class='<?php echo $co; ?> '  style='height: 40px !important; text-rendering: optimizeLegibility; cursor: pointer important; border-right-style: none; style=\"cursor: hand\"'>
										<td v-on:click="siguienteNivel10(nivel)" width="10%" style="font: 120% sans-serif; padding-left:30px">{{ nivel[1] }}</td>
										<td v-on:click="siguienteNivel10(nivel)" width="20%" style="font: 120% sans-serif; padding-left:10px">{{ nivel[2] }}</td>
										<td v-on:click="siguienteNivel10(nivel)" width="10%" style="font: 120% sans-serif; padding-left:10px">{{ nivel[6] }}</td>
										<td v-on:click="siguienteNivel10(nivel)" width="40%" style="font: 120% sans-serif; padding-left:10px;">{{ clasificadorPorNombres_9[nivel[1]] }} </td>
										<td v-on:click="mostrarModal(nivel)" width="20%" style='font: 120% sans-serif; text-align:center; background: #FFFFFF;'>
											<button type="button" class="btn btn-default">
												<i class="fas fa-plus-square"></i>
											</button>
										</td>

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
				</div>		
				<div v-show="mostrarNivel_10">
					<div style="margin: 0px 50px 0 50px;">
						<div class="row" style="margin: 4px; border-radius:4px; background-color: #E1E2E2; ">
							<div class="col-md-2" style="padding: 12px 0px 0px 30px; font: 140% sans-serif;">
								<label for="">Nivel 10</label>
							</div>
						</div>	
						<table>
							<thead>
								<tr>
									<td width="10%" class='titulos' style="font: 160% sans-serif; border-radius: 5px 0px 0px;">C&oacute;digo</td>
									<td width="20%" class='titulos' style="font: 160% sans-serif;">Nombre</td>
									<td width="10%" class='titulos' style="font: 160% sans-serif;">Tipo</td>
									<td width="40%" class='titulos' style="font: 160% sans-serif;">Clasificadores</td>
									<td width="20%" class='titulos' style="font: 160% sans-serif; border-radius: 0px 5px 0px 0px; text-align: center;">Programar</td>
								</tr>
							</thead>
						</table>
					</div>	
					<div style="margin: 0px 50px 20px; border-radius: 0 0 0 15px; height: 30%; overflow: scroll; overflow-x: hidden; background: white; ">
						<div class="row">
							<table class='inicio inicio--no-shadow'>
								<tbody>
									<?php
										$co ='zebra1';
										$co2='zebra2';
									?>
									<tr v-for="nivel in nivel_10" class='<?php echo $co; ?> ' style='height: 40px !important; text-rendering: optimizeLegibility; cursor: pointer important; border-right-style: none; style=\"cursor: hand\"'>
										<td v-on:click="modalLastLevel(nivel)" width="10%" style="font: 120% sans-serif; padding-left:30px">{{ nivel[1] }}</td>
										<td v-on:click="modalLastLevel(nivel)" width="20%" style="font: 120% sans-serif; padding-left:10px">{{ nivel[2] }}</td>
										<td v-on:click="modalLastLevel(nivel)" width="10%" style="font: 120% sans-serif; padding-left:10px">{{ nivel[6] }}</td>
										<td v-on:click="modalLastLevel(nivel)" width="40%" style="font: 120% sans-serif; padding-left:10px;">{{ clasificadorPorNombres_10[nivel[1]] }} </td>
										<td v-on:click="mostrarModal(nivel)" width="20%" style='font: 120% sans-serif; text-align:center; background: #FFFFFF;'>
											<button type="button" class="btn btn-default">
												<i class="fas fa-plus-square"></i>
											</button> 
										</td>

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
				</div>	

                <div v-show="showModal">
					<transition name="modal">
						<div class="modal-mask">
							<div class="modal-wrapper">
								<div class="modal-dialog modal-lg" role="document">
									<div class="modal-content" scrollable>
									<div class="modal-header">
										<h5 class="modal-title">Bienes transportables</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true" @click="showModal = false">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<!-- Default unchecked -->
										<div v-for="clasificador in listClasi" class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" :value="clasificador[0]" v-model="checkedClasificadores" style="z-index: 2000;">
											<label class="custom-control-label" for="ingresos">{{ clasificador[1] }}</label>
										</div>	
										<!-- <span>Checked names: {{ checkedClasificadores | json }}</span> -->
										<h5 class="modal-title" style="text-align:center; padding-top:30px;padding-bottom:30px;">Se asginaran los clasificadores seleccionados a las siguientes cuentas</h5>
										<table class="table table-hover">
											<thead>
												<tr>
													<th>C&oacute;digo</th>
													<th>Nombre</th>
												</tr>
											</thead>
											<tbody>
												<tr  v-for="cuenta in cuentasSeleccionadas" style="font-weight: normal">
													<td>{{ cuenta[0] }}</td>
													<td>{{ cuenta[1] }}</td>
												</tr>
											</tbody>
										</table>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-primary" v-on:click="guardarClasificadores()">Guargar</button>
										<button type="button" class="btn btn-secondary" @click="showModal = false">Cerrar</button>
									</div>
									</div>
								</div>
							</div>
						</div>
					</transition>
				</div>

				<div v-show="showModal_respuesta">
					<transition name="modal">
						<div class="modal-mask">
							<div class="modal-wrapper">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title"></h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true" @click="showModal_respuesta = false">&times;</span>
										</button>
									</div>
									<div class="modal-body_1">
										<!-- Default unchecked -->
										<h3 style="font: 120% sans-serif; text-align:center">Se guardo exitosamente!!</h3>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" @click="showModal_respuesta = false">Cerrar</button>
									</div>
									</div>
								</div>
							</div>
						</div>
					</transition>
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
		<script src="vue/ccp-programarclasificadoresgastos.js"></script>
	</body>
</html>