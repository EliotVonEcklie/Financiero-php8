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
			.loader-table{
				/* background-color: #dff9fb;
				opacity: .5; */
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
				<div class="row" style="margin: 20px 0 0 0; border-radius:4px; background-color: #E1E2E2; ">
					<div class="col-md-3" style="padding: 12px 0px 0px 30px; font: 140% sans-serif;">
						<label for="">Buscar por nombre o nit</label>
					</div>
					
					<div class="col-md-6" style="padding: 4px">
						<input type="text" class="form-control" style="height: auto; border-radius:0;" placeholder="Ej: Instituto de Casas Fiscales del Ejercito" v-on:keyup.enter="searchMonitor"  v-model="search.keyword">
					</div>
					<div class="col-md-2 col-sm-4 col-md-offset-1" style="padding: 4px">
						<button type="submit" class="btn btn-dark" value="Buscar" style="height: auto; border-radius:0;" v-on:click="searchMonitor">Buscar</button>
					</div>
				</div>
				<span id="start_page"> </span>
				<div>
					<div v-if="!show_table_search" class="loader-table">
						<div class="spinner"></div>
					</div>
					<div v-if="show_table_search">
						<div style="margin: 4px 0 0">
							<table>
								<thead>
									<tr>
										<td width="1%" class='titulos' style="font: 100% sans-serif; border-radius: 5px 0px 0px;">No</td>
										<td width="8%" class='titulos'  style="font: 100% sans-serif;">Id entidad</td>
										<td width="8%" class='titulos'  style="font: 100% sans-serif;">Nit</td>
										<td width="34%" class='titulos'  style="font: 100% sans-serif;">Nombre</td>
										<td width="4%" class='titulos'  style="font: 100% sans-serif;">Sector</td>
										<td width="5%" class='titulos'  style="font: 100% sans-serif;">Subsector</td>
										<td width="4%" class='titulos'  style="font: 100% sans-serif;">Tipo</td>
										<td width="5%" class='titulos'  style="font: 100% sans-serif;">Supra regional</td>
										<td width="5%" class='titulos'  style="font: 100% sans-serif;">Nivel territorial</td>
										<td width="5%" class='titulos'  style="font: 100% sans-serif;">Depto</td>
										<td width="5%" class='titulos'  style="font: 100% sans-serif;">Municipio</td>
										<td width="5%" class='titulos'  style="font: 100% sans-serif;">Consecutivo</td>
										<td width="15%" class='titulos'  style="font: 100% sans-serif; text-align:center; border-radius: 0px 5px 0px 0px;"><?php echo utf8_decode("Código CUIN") ?></td>
									</tr>
								</thead>
							</table>
						</div>
						<div style="margin: 0px 0 20px; border-radius: 0 0 0 15px; height: 75%; overflow: scroll; overflow-x: hidden; background: white; ">
							<table class='inicio inicio--no-shadow'>
								<tbody v-if="show_resultados">
									<?php
										$co ='zebra1';
										$co2='zebra2';
									?>
									<tr v-for="result in results" class='<?php echo $co; ?> text-rendering: optimizeLegibility; cursor: pointer important; style=\"cursor: hand\"' >
										<td width="1%" style="font: 120% sans-serif;">{{ result[1] }}</td>
										<td width="8%" style="font: 120% sans-serif;">{{ result[2] }}</td>
										<td width="8%" style="font: 120% sans-serif;">{{ result[3] }}</td>
										<td width="34%" style="font: 120% sans-serif;">{{ result[4] }}</td>
										<td width="4%" style="font: 120% sans-serif;">{{ result[5] }}</td>
										<td width="5%" style="font: 120% sans-serif;">{{ result[6] }}</td>
										<td width="4%" style="font: 120% sans-serif;">{{ result[7] }}</td>
										<td width="5%" style="font: 120% sans-serif;">{{ result[8] }}</td>
										<td width="5%" style="font: 120% sans-serif;">{{ result[9] }}</td>
										<td width="5%" style="font: 120% sans-serif;">{{ result[10] }}</td>
										<td width="5%" style="font: 120% sans-serif;">{{ result[11] }}</td>
										<td width="5%" style="font: 120% sans-serif;">{{ result[12] }}</td>
										<td width="10%" style="font: 120% sans-serif;">{{ result[13] }}</td>

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
		<script src="vue/ccp-cuin.js"></script>
	</body>
</html>