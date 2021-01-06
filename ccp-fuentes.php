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
				border-radius: 5px; 
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
					<img src="imagenes/iratras.png" title="Atr&aacute;s" onClick="location.href='ccp-visualizarclasificadorpresupuestal.php'" class="mgbt"/>
				</td>
        	</tr>
		</table>
		<div class="subpantalla" style="height:80.5%; width:99.6%; overflow-x:hidden;">
			<div id="myapp">
				<div class="row" style="margin: 20px 50px 0 50px; border-radius:4px; background-color: #E1E2E2; ">
					<div class="col-md-3" style="padding: 12px 0px 0px 30px; font: 140% sans-serif;">
						<label for="">Buscar por entidad o fuente</label>
					</div>
					
					<div class="col-md-6" style="padding: 4px">
						<input type="text" class="form-control" style="height: auto; border-radius:0;" placeholder="Ej: Proposito General Libre Destinacion" v-on:keyup.enter="searchMonitor"  v-model="search.keyword">
					</div>
					<div class="col-md-2 col-sm-4 col-md-offset-1" style="padding: 4px">
						<button type="submit" class="btn btn-dark" value="Buscar" style="height: auto; border-radius:0;" v-on:click="searchMonitor">Buscar</button>
					</div>
				</div>
				<span id="start_page"> </span>
				<div>
					
					<div>
						<div style="margin: 4px 50px 0">
							<table>
								<thead>
									<tr>
										<td class='titulos' width="10%"  style="font: 160% sans-serif;  border-radius: 5px 0px 0px 0px;">Id fuente</td>
										<td class='titulos' width="30%"  style="font: 160% sans-serif;">Entidad financiadora</td>
										<td class='titulos' width="60%" style="font: 160% sans-serif; border-radius: 0px 5px 0px 0px;">Fuente de financiaci&oacute;n</td>
									</tr>
								</thead>
							</table>
						</div>
						<div style="margin: 0px 50px 20px; border-radius: 0 0 0 15px; height: 75%; overflow: scroll; overflow-x: hidden; background: white; ">
							<table class='inicio inicio--no-shadow'>
								<tbody v-if="show_resultados">
									<?php
										$co ='zebra1';
										$co2='zebra2';
									?>
									<tr v-for="result in results" class='<?php echo $co; ?> text-rendering: optimizeLegibility; cursor: pointer important; style=\"cursor: hand\"' >
										<td width="10%" style="font: 160% sans-serif;">{{ result[2] }}</td>
										<td width="30%" style="font: 160% sans-serif;">{{ result[1] }}</td>
										<td width="60%" style="font: 160% sans-serif;">{{ result[3] }}</td>

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
		<script src="vue/ccp-fuentes.js"></script>
	</body>
</html>