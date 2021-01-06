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
		<div class="subpantalla" style="height:78%; width:99.6%; overflow:hidden;">
			<div id="myapp">
				<div class="row">
					<div class="col-12">
						<h4 style="padding-left:50px; padding-top:5px; padding-bottom:5px; background-color: #0FB0D4">Crear clasificadores:</h4>
					</div>
				</div>
				<div class="row" style="height:115%;">
					<div class="col-8" >
						<div style="margin: 20px 50px 0">
							<table>
								<thead>
									<tr>
										<td class='titulos' width="30%"  style="font: 160% sans-serif; border-radius: 5px 0px 0px 0px;">C&oacute;digo</td>
										<td class='titulos' width="60%"  style="font: 160% sans-serif;">Nombre</td>
										<td class='titulos' width="10%" style="font: 160% sans-serif; border-radius: 0px 5px 0px 0px;">Tipo</td>
									</tr>
								</thead>
							</table>
						</div>
						<div style="margin: 0px 50px 20px; border-radius: 0 0 0 5px; height: 70%; overflow: scroll; overflow-x: hidden; background: white; ">
							<table class='inicio inicio--no-shadow'>
								<tbody v-if="show_resultados">
									<?php
										$co ='zebra1';
										$co2='zebra2';
									?>
									<tr v-for="result in results" v-on:click="seleccionaCodigos(result)" :style="estaEnArray(result) == true ? myStyle : ''"  class='<?php echo $co; ?> text-rendering: optimizeLegibility; cursor: pointer important; style=\"cursor: hand\"' >
										<td width="30%" style="font: 160% sans-serif;">{{ result[1] }}</td>
										<td width="60%" style="font: 160% sans-serif;">{{ result[2] }}</td>
										<td width="10%" style="font: 160% sans-serif;">{{ result[6] }}</td>
										
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
					<div class="col-4">
						<div class="row" style="margin:20px 50px 0 0; border-radius:4px 0 0; background-color: #E1E2E2; ">
							<div class="col" style="padding: 12px 0px 0px 30px; font: 140% sans-serif;">
								<label for="">Crear clasificador</label>
							</div>
						</div>
						<div class="row" style="margin:0 50px 0 0; border-radius: 0 0 4px; background-color: #E1E2E2;">
							<div class="col-md-8" style="padding: 4px">
								<input v-on:keyup.enter="addClasificador" v-model="name_clasificador" type="text" class="form-control" style="height: auto; border-radius:0;" placeholder="Nombre de clasificador">
							</div>
							<div class="col-md-4" style="padding: 4px">
								<button v-on:click="addClasificador" type="submit" class="col btn btn-dark" value="Buscar"  style="height: auto; border-radius:0;">Guardar</button>
							</div>
						</div>
						<div v-show="success_registro_clasi" class="row" style="margin:20px 50px 0 0;">
							<div class="col-md-12 alert alert-success">
								Clasificador registrado.
							</div>
						</div>
						<div v-show="error_selecciona_clasi" class="row" style="margin:20px 50px 0 0;">
							<div class="col-md-12 alert alert-danger">
								No hay clasificador seleccionado en la tabla.
							</div>
						</div>
						<div v-show="error_name_cla_empty" class="row" style="margin:20px 50px 0 0;">
							<div class="col-md-12 alert alert-danger">
								Ingrese un nombre para el clasificador.
							</div>
						</div>
					</div>
				</div>
			</div>	
		</div>
		
		
		<script src="https://cdn.jsdelivr.net/npm/vue"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"></script>
		<script src="vue/ccp-generarclasificadores.js"></script>
	</body>
</html>