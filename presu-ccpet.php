<?php
	require "comun.inc";
	require"funciones.inc";
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
		<title>:: SieS - Presupuesto</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="bootstrap/css/estilos.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
		
		<?php titlepag();?>

		<script>
			function scroll()
			{
				document.getElementById('container').scrollTop=document.getElementById('container').scrollHeight;
				//alert(document.getElementById('container').scrollHeight);
			}
		</script>
    </head>
    <body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("presu");?></tr>
        	<tr>
          		<td colspan="3" class="cinta">
					<a class="mgbt"><img src="imagenes/add2.png"/></a>
					<a class="mgbt"><img src="imagenes/guardad.png"/></a>
					<a class="mgbt"><img src="imagenes/buscad.png"/></a>
					<a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
				</td>
        	</tr>
		</table>
		<div id="myapp">
			<div class="subpantalla" id="container" style="height:80.5%; width:99.6%; overflow-y:scroll;">
			
				<div class="row">
					<div class="col-md-4 col-md-offset-8">
						<input type="text" class="form-control" placeholder="Buscar primer nombre - apellido" v-on:keyup="searchMonitor" v-model="search.keyword">
					</div>
				</div>
				<div style="height:20.5%; overflow-x:hidden; " >
					<table class='inicio'>
						<tr>
							<td class='titulos' style="font: 160% sans-serif; width:30%;">Codigo</td>
							<td class='titulos' style="font: 160% sans-serif; width:60%;">Nombre</td>
							<td class='titulos' style="font: 160% sans-serif; width:10%;">Tipo</td>
						</tr>
						<?php
							$co ='zebra1';
							$co2='zebra2';
						?>
						<tr v-for="nivel in nivel_2" v-on:click="siguienteNivel3(nivel);" class='<?php echo $co; ?> ' style='text-rendering: optimizeLegibility; cursor: pointer !important; style=\"cursor: hand\"'>
							<td style="font: 120% sans-serif; padding-left:10px">{{ nivel[1] }}</td>
							<td style="font: 120% sans-serif; padding-left:10px">{{ nivel[2] }}</td>
							<td style="font: 120% sans-serif; padding-left:10px">{{ nivel[6] }}</td>

							<?php
							$aux=$co;
							$co=$co2;
							$co2=$aux;
							?>

						</tr>
					</table>
				</div>
				<div v-show="mostrarNivel_3" style="height:30%; overflow-x:hidden; ">
					<table class='inicio'>
						<tr >
							<td class='titulos2' style="font-size: 15px !important; font: 150% sans-serif;" colspan='3'>Nivel 3</td>
						</tr>
						<tr>
							<td class='titulos' style="font: 160% sans-serif; width:30%;">Codigo</td>
							<td class='titulos' style="font: 160% sans-serif; width:60%;">Nombre</td>
							<td class='titulos' style="font: 160% sans-serif; width:10%;">Tipo</td>
						</tr>
						<?php
							$co ='zebra1';
							$co2='zebra2';
						?>
						<tr v-for="nivel in nivel_3" v-on:click="siguienteNivel4(nivel)" class='<?php echo $co; ?> ' style='text-rendering: optimizeLegibility; cursor: pointer !important; style=\"cursor: hand\"'>
							<td style="font: 120% sans-serif; padding-left:10px">{{ nivel[1] }}</td>
							<td style="font: 120% sans-serif; padding-left:10px">{{ nivel[2] }}</td>
							<td style="font: 120% sans-serif; padding-left:10px">{{ nivel[6] }}</td>

							<?php
							$aux=$co;
							$co=$co2;
							$co2=$aux;
							?>
						</tr>
					</table>
				</div>
				
				<div v-show="mostrarNivel_4" style="height:30.5%; overflow-x:hidden; ">
					<table class='inicio'>
						<tr >
							<td class='titulos2' style="font-size: 15px !important; font: 150% sans-serif;" colspan='3'>Nivel 4</td>
						</tr>
						<tr>
							<td class='titulos' style="font: 160% sans-serif; width:30%;">Codigo</td>
							<td class='titulos' style="font: 160% sans-serif; width:60%;">Nombre</td>
							<td class='titulos' style="font: 160% sans-serif; width:10%;">Tipo</td>
						</tr>
						<?php
							$co ='zebra1';
							$co2='zebra2';
						?>
						<tr v-for="nivel in nivel_4" v-on:click="siguienteNivel5(nivel)" class='<?php echo $co; ?>' style='text-rendering: optimizeLegibility; cursor: pointer !important; style=\"cursor: hand\"'>
							<td style="font: 120% sans-serif; padding-left:10px">{{ nivel[1] }}</td>
							<td style="font: 120% sans-serif; padding-left:10px">{{ nivel[2] }}</td>
							<td style="font: 120% sans-serif; padding-left:10px">{{ nivel[6] }}</td>

							<?php
							$aux=$co;
							$co=$co2;
							$co2=$aux;
							?>
						</tr>
					</table>
				</div>
				<div v-show="mostrarNivel_5" style="height:30.5%; overflow-x:hidden; ">
					<table class='inicio'>
						<tr>
							<td class='titulos2' style="font-size: 15px !important; font: 150% sans-serif;" colspan='3'>Nivel 5</td>
						</tr>
						<tr>
							<td class='titulos' style="font: 160% sans-serif; width:30%;">Codigo</td>
							<td class='titulos' style="font: 160% sans-serif; width:60%;">Nombre</td>
							<td class='titulos' style="font: 160% sans-serif; width:10%;">Tipo</td>
						</tr>
						<?php
							$co ='zebra1';
							$co2='zebra2';
						?>
						<tr v-for="nivel in nivel_5" v-on:click="siguienteNivel6(nivel)" class='<?php echo $co; ?> ' style='text-rendering: optimizeLegibility; cursor: pointer !important; style=\"cursor: hand\"'>
							<td style="font: 120% sans-serif; padding-left:10px">{{ nivel[1] }}</td>
							<td style="font: 120% sans-serif; padding-left:10px">{{ nivel[2] }}</td>
							<td style="font: 120% sans-serif; padding-left:10px">{{ nivel[6] }}</td>

							<?php
							$aux=$co;
							$co=$co2;
							$co2=$aux;
							?>
						</tr>
					</table>
				</div>
				<div v-show="mostrarNivel_6" style="height:30.5%; overflow-x:hidden; ">
					<table class='inicio'>
						<tr>
							<td class='titulos2' style="font-size: 15px !important; font: 150% sans-serif;" colspan='3'>Nivel 6</td>
						</tr>
						<tr>
							<td class='titulos' style="font: 160% sans-serif; width:30%;">Codigo</td>
							<td class='titulos' style="font: 160% sans-serif; width:60%;">Nombre</td>
							<td class='titulos' style="font: 160% sans-serif; width:10%;">Tipo</td>
						</tr>
						<?php
							$co ='zebra1';
							$co2='zebra2';
						?>
						<tr v-for="nivel in nivel_6" v-on:click="siguienteNivel7(nivel)" class='<?php echo $co; ?>' style='text-rendering: optimizeLegibility; cursor: pointer !important; style=\"cursor: hand\"'>
							<td style="font: 120% sans-serif; padding-left:10px">{{ nivel[1] }}</td>
							<td style="font: 120% sans-serif; padding-left:10px">{{ nivel[2] }}</td>
							<td style="font: 120% sans-serif; padding-left:10px">{{ nivel[6] }}</td>

							<?php
							$aux=$co;
							$co=$co2;
							$co2=$aux;
							?>
						</tr>
					</table>
				</div>
				<div v-show="mostrarNivel_7" style="height:30.5%; overflow-x:hidden; ">
					<table class='inicio'>
						<tr>
							<td class='titulos2' style="font-size: 15px !important; font: 150% sans-serif;" colspan='3'>Nivel 7</td>
						</tr>
						<tr>
							<td class='titulos' style="font: 160% sans-serif; width:30%;">Codigo</td>
							<td class='titulos' style="font: 160% sans-serif; width:60%;">Nombre</td>
							<td class='titulos' style="font: 160% sans-serif; width:10%;">Tipo</td>
						</tr>
						<?php
							$co ='zebra1';
							$co2='zebra2';
						?>
						<tr v-for="nivel in nivel_7" v-on:click="siguienteNivel8(nivel)" class='<?php echo $co; ?>' style='text-rendering: optimizeLegibility; cursor: pointer !important; style=\"cursor: hand\"'>
							<td style="font: 120% sans-serif; padding-left:10px">{{ nivel[1] }}</td>
							<td style="font: 120% sans-serif; padding-left:10px">{{ nivel[2] }}</td>
							<td style="font: 120% sans-serif; padding-left:10px">{{ nivel[6] }}</td>

							<?php
							$aux=$co;
							$co=$co2;
							$co2=$aux;
							?>
						</tr>
					</table>
				</div>
				<div v-show="mostrarNivel_8" style="height:30.5%; overflow-x:hidden; ">
					<table class='inicio'>
						<tr>
							<td class='titulos2' style="font-size: 15px !important; font: 150% sans-serif;" colspan='3'>Nivel 8</td>
						</tr>
						<tr>
							<td class='titulos' style="font: 160% sans-serif; width:30%;">Codigo</td>
							<td class='titulos' style="font: 160% sans-serif; width:60%;">Nombre</td>
							<td class='titulos' style="font: 160% sans-serif; width:10%;">Tipo</td>
						</tr>
						<?php
							$co ='zebra1';
							$co2='zebra2';
						?>
						<tr v-for="nivel in nivel_8" v-on:click="siguienteNivel9(nivel)" class='<?php echo $co; ?>' style='text-rendering: optimizeLegibility; cursor: pointer !important; style=\"cursor: hand\"'>
							<td style="font: 120% sans-serif; padding-left:10px">{{ nivel[1] }}</td>
							<td style="font: 120% sans-serif; padding-left:10px">{{ nivel[2] }}</td>
							<td style="font: 120% sans-serif; padding-left:10px">{{ nivel[6] }}</td>

							<?php
							$aux=$co;
							$co=$co2;
							$co2=$aux;
							?>
						</tr>
					</table>
				</div>
				<div v-show="mostrarNivel_9" style="height:30.5%; overflow-x:hidden; ">
					<table class='inicio'>
						<tr>
							<td class='titulos2' style="font-size: 15px !important; font: 150% sans-serif;" colspan='3'>Nivel 9</td>
						</tr>
						<tr>
							<td class='titulos' style="font: 160% sans-serif; width:30%;">Codigo</td>
							<td class='titulos' style="font: 160% sans-serif; width:60%;">Nombre</td>
							<td class='titulos' style="font: 160% sans-serif; width:10%;">Tipo</td>
						</tr>
						<?php
							$co ='zebra1';
							$co2='zebra2';
						?>
						<tr v-for="nivel in nivel_9" v-on:click="siguienteNivel10(nivel)" class='<?php echo $co; ?>' style='text-rendering: optimizeLegibility; cursor: pointer !important; style=\"cursor: hand\"'>
							<td style="font: 120% sans-serif; padding-left:10px">{{ nivel[1] }}</td>
							<td style="font: 120% sans-serif; padding-left:10px">{{ nivel[2] }}</td>
							<td style="font: 120% sans-serif; padding-left:10px">{{ nivel[6] }}</td>

							<?php
							$aux=$co;
							$co=$co2;
							$co2=$aux;
							?>
						</tr>
					</table>
				</div>
				<div v-show="mostrarNivel_10" style="height:30.5%; overflow-x:hidden; ">
					<table class='inicio'>
						<tr>
							<td class='titulos2' style="font-size: 15px !important; font: 150% sans-serif;" colspan='3'>Nivel 10</td>
						</tr>
						<tr>
							<td class='titulos' style="font: 160% sans-serif; width:30%;">Codigo</td>
							<td class='titulos' style="font: 160% sans-serif; width:60%;">Nombre</td>
							<td class='titulos' style="font: 160% sans-serif; width:10%;">Tipo</td>
						</tr>
						<?php
							$co ='zebra1';
							$co2='zebra2';
						?>
						<tr v-for="nivel in nivel_10" class='<?php echo $co; ?>' style='text-rendering: optimizeLegibility; cursor: pointer !important; style=\"cursor: hand\"'>
							<td style="font: 120% sans-serif; padding-left:10px">{{ nivel[1] }}</td>
							<td style="font: 120% sans-serif; padding-left:10px">{{ nivel[2] }}</td>
							<td style="font: 120% sans-serif; padding-left:10px">{{ nivel[6] }}</td>

							<?php
							$aux=$co;
							$co=$co2;
							$co2=$aux;
							?>
						</tr>
					</table>
				</div>
			</div>
			<?php echo "<script> scroll(); </script>";  ?>
		</div>
		<script src="https://cdn.jsdelivr.net/npm/vue"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"></script>
		<script src="vue/ccpet.js"></script>
	</body>
</html>