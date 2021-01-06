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
			.background_active_color{
				background: #16a085;
			}
            .background_active_clasificador{
                font-family: calibri !important;
				font-weight: bold !important;
				font-size:14px !important;
            }
			.background_active{
				/* font: 115% sans-serif !important; */
    			/*font-weight: 700 !important;*/
				/*font-family: "Constantia", serif !important;*/
				font-family: calibri !important;
				font-weight: bold !important;
				font-size:20px !important;
			}
			.background_active_1{
				/* font: 115% sans-serif !important; */
    			/*font-weight: 700 !important;*/
				/*font-family: "Constantia", serif !important;*/
				font-family: helvética !important;
				font-size:20px !important;
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
				max-height: 250px;
				overflow-y: scroll;
			}
			.modal-intermetio{
				margin: 0 15px;
				font-family: helvética !important;
				font-size: 26px !important;
				padding: 10px 0;
			}
			.modal-intermedio-agregar{
				text-align:right;
				padding: 4px;
				margin-top: 6px;
				margin-right: 20px
			}
			.modal-body_1{
				padding-top: 15px;
				height: 40px;
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
					<a><img src="imagenes/add.png" title="Nuevo" onClick="location.href='#'" class="mgbt"/></a>
					<a class="mgbt"><img src="imagenes/guardad.png"/></a>
					<a><img src="imagenes/busca.png" title="Buscar"  onClick="location.href='#'" class="mgbt"/></a>
					<a href="#" onClick="mypop=window.open('ccp-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<img src="imagenes/iratras.png" title="Atr&aacute;s" onClick="location.href='ccp-capturapresupuestoinicial.php'" class="mgbt"/>
				</td>
        	</tr>
		</table>
		<div class="subpantalla" style="height:520px; width:99.6%; overflow:hidden;">
			<div id="myapp" style="height:inherit;">
                <div class="row">
					<div class="col-12">
						<h5 style="padding-left:30px; padding-top:5px; padding-bottom:5px; background-color: #0FB0D4">Agregar presupuesto de ingresos:</h5>
					</div>
				</div>
				<div class="row" style="margin: 10px 10px 0px">
					<div class="col-12">
						<div class="row" style="border-radius:2px; background-color: #E1E2E2; ">
							<div class="col-md-2" style="display: grid; align-content:center;">
								<label for="" style="margin-bottom: 0; font-weight: bold">Unidad ejecutora: </label>
							</div>
							<div class="col-md-3" style="padding: 4px">
                                <select v-model="selected" v-on:change="buscarIngresos" class="form-control select">
                                    <option v-for="unidad in unidadesejecutoras" v-bind:value="unidad[0]">
                                        {{ unidad[1] }}
                                    </option>
                                </select>
							</div>
                            <div class="col-md-2" style="display: grid; align-content:center;">
								<label for="" style="margin-bottom: 0; font-weight: bold">Medio de pago: </label>
							</div>
							<div class="col-md-3" style="padding: 4px">

                                <select v-model="selectMedioPago" v-on:change="buscarIngresos" class="form-control select">
                                    <option v-for="option in optionsMediosPagos" v-bind:value="option.value">
                                        {{ option.text }}
                                    </option>
                                </select>
							</div>
                            <div class="col-md-1" style="display: grid; align-content:center;">
								<label for="" style="margin-bottom: 0; font-weight: bold">Vigencia: </label>
							</div>
                            <div class="col-md-1" style="display: grid; align-content:center;">
                                <input type="text" class="form-control" v-on:keyup="buscarIngresos" v-model="vigencia">
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12" v-show="mostrar_resultados_ingresos">
						<div style="margin: 5px 10px 0">
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
						<div style="margin: 0px 10px 10px; border-radius: 0 0 0 5px; max-height: 390px; overflow: scroll; overflow-x: hidden; background: white; ">
							<table class='inicio inicio--no-shadow' style='margin: 10px; border-radius: 4px;'>
								<tbody v-if="mostrar_resultados_ingresos">
									<?php
										$co ='zebra1';
										$co2='zebra2';
									?>
									<tr v-for="ingreso in ingresos" :class=" ingreso[2] == 'A' ? 'background_active' : 'background_active_1' " class='<?php echo $co; ?>' style="font: 130% sans-serif;">
										<td width="10%" style="padding-left: 10px; ">{{ ingreso[0] }}</td>
										<td width="30%" >{{ ingreso[1] }}</td>
										<td width="10%" >{{ ingreso[2] }}</td>
										<td width="20%" >  </td>
										<td width="30%" v-if="ingreso[2] == 'C' " v-on:dblclick="agregarPresupuesto(ingreso[0])" style='text-rendering: optimizeLegibility; cursor: pointer !important; text-align:center; background-color: FBE71B;  style=\"cursor: hand\"'>
											
											{{ valorIngresoCuenta[ingreso[0]] }}

											<td width="30%" v-else style='text-rendering: optimizeLegibility; text-align:center; '> {{ valorIngresoCuenta[ingreso[0]] }} </td>
										
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
				
				<div v-show="showModal">
					<transition name="modal">
						<div class="modal-mask">
							<div class="modal-wrapper">
								<div class="modal-dialog modal-lg" style = "max-width: 1200px !important;" role="document">
									<div class="modal-content" style = "width: 1200px !important;" scrollable>
										<div class="modal-header">
											<h5 class="modal-title">Clasificador CUIN</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true" @click="showModal = false">&times;</span>
											</button>
										</div>
										<div class="modal-body">
											<!-- Default unchecked -->
											
											<!-- <span>Checked names: {{ checkedClasificadores | json }}</span> -->
											<div class="row" style="margin: 2px 0 0 0; border-radius:4px; background-color: #E1E2E2; ">
												<div class="col-md-4" style="padding: 12px 0px 0px 30px; font: 120% sans-serif;">
													<label for="">Buscar por nombre o nit</label>
												</div>
											
												<div class="col-md-6" style="padding: 4px">
													<input type="text" class="form-control" style="height: auto; border-radius:4px;" placeholder="Ej: Instituto de Casas Fiscales del Ejercito" v-on:keyup.enter="searchMonitorCuin"  v-model="searchCuin.keywordCuin">
												</div>
												<div class="col-md-2 col-sm-4 col-md-offset-1" style="padding: 4px">
													<button type="submit" class="btn btn-dark" value="Buscar" style="height: auto; border-radius:4px;" v-on:click="searchMonitorCuin">Buscar</button>
												</div>
											</div>
											<div v-if="!show_table_search" class="loader-table">
												<div class="spinner"></div>
											</div>
											<table v-if="show_table_search" class="table table-hover">
												<thead>
													<tr>
														<th>C&oacute;digo</th>
														<th>Nit</th>
														<th>Nombre</th>
														<th>C&oacute;didgo CUIN</th>
													</tr>
												</thead>
												<tbody>
													<tr v-for="cuin in resultsCuin" v-on:click="seleccionarCuin(cuin)" v-bind:class="cuin[2] === cuin_p ? 'background_active_color' : ''" style='font-weight: normal; text-rendering: optimizeLegibility; cursor: pointer !important; style=\"cursor: hand\"'>
														<td>{{ cuin[2] }}</td>
														<td>{{ cuin[3] }}</td>
														<td>{{ cuin[4] }}</td>
														<td>{{ cuin[13] }}</td>
													</tr>
												</tbody>
											</table>
										</div>
										<div class="modal-intermedio-agregar">
											<div class="row" style="margin-left: 15px;">
												<form class="form-inline">
													<div class="form-group">
														<label for="valorCuin">Valor:</label>
														<input type="number" v-model="valorCuin" class="form-control mx-sm-3">

														<button type="button" class="btn btn-primary" v-on:click="agregaCuin">Agregar CUIN</button>
														
													</div>
												</form>

												<form class="form-inline" style='padding-left:10px'>
													<div class="form-group">
															<label for="valorTotal">Valor Total:</label>
															<input type="number" v-model="valorTotal" class="form-control mx-sm-3" readonly>
													</div>
												</form>
												
											</div>
												
										</div>
										<div class="modal-intermetio">
											<div class="row">
												<div class="col-12" style="text-align:center; background: #E1E2E2;">
													<h5 class="modal-title">Cuentas CUIN seleccionadas</h5>
												</div>
											</div>
										</div>
										<div class="modal-body" style='height:140px; paddind: 0px'>
											<table v-if="show_table_search" class="table table-hover" >
												<thead>
													<tr>
														<th>C&oacute;digo</th>
														<th>Nit</th>
														<th>Nombre</th>
														<th>CUIN</th>
														<th>Valor</th>
														<th>Eliminar</th>
													</tr>
												</thead>
												<tbody>
													<tr v-for="cuenta in cuentasCuinAgr" style="font-weight: normal">
														<td>{{ cuenta[2] }}</td>
														<td>{{ cuenta[3] }}</td>
														<td>{{ cuenta[4] }}</td>
														<td>{{ cuenta[13] }}</td>
														<td>{{ cuenta[15] }}</td>
														<td>
															<button type="button" class="btn btn-danger" v-on:click="eliminarCuin(cuenta)">Eliminar</button>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-primary" v-on:click="guardarCuin">Guardar y continuar</button>
											<button type="button" class="btn btn-secondary" @click="showModal = false">Cerrar</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</transition>
				</div>


				<div v-show="showModal_bienes_transportables">
					<transition name="modal">
						<div class="modal-mask">
							<div class="modal-wrapper">
								<div class="modal-dialog modal-lg" style = "max-width: 1200px !important;" role="document">
									<div class="modal-content"  style = "width: 1200px !important;" scrollable>
										<div class="modal-header">
                                            <div class="row">
                                                <div class="col-10">
                                                    <h5 class="modal-title">Clasificador Bienes transportables Sec. 0-4</h5>
                                                </div>
                                                <div class="col-2">
                                                    <button type="button" class="btn btn-secondary" v-on:click="buscarFuente()">Volver</button>
                                                </div>  
                                            </div>
											
                                            
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true" @click="showModal_bienes_transportables = false">&times;</span>
											</button>
										</div>
                                        <div class="modal-body">
                                            <div v-show="mostrarDivision">
                                                <div style="margin: 2px 0 0 0;">
                                                    <div class="row" style="margin: 4px; border-radius:4px; background-color: #E1E2E2; ">
                                                        <div class="col-md-2" style="padding: 12px 0px 0px 30px; font: 140% sans-serif;">
                                                            <label for="">Divisi&oacute;n:</label>
                                                        </div>
                                                        
                                                        <div class="col-md-6 col-md-offset-6" style="padding: 4px">
                                                            <input type="text" class="form-control" placeholder="Buscar por nombre o c&oacute;digo de divisi&oacute;n" v-on:keyup="searchMonitorDivision" v-model="searchDivision.keywordDivision">
                                                        </div>
                                                    </div>
                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <td width="20%" class='titulos' style="font: 120% sans-serif; border-radius: 5px 0 0 0;">C&oacute;digo</td>
                                                                <td width="80%" class='titulos' style="font: 120% sans-serif;">Nombre</td>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                                <div style="margin: 2px 0 0 0; border-radius: 0 0 0 6px; height: 200px; overflow: scroll; overflow-x: hidden; background: white; ">
                                                    <table class='inicio inicio--no-shadow'>
                                                        <tbody>
                                                            <?php
                                                                $co ='zebra1';
                                                                $co2='zebra2';
                                                            ?>
                                                            <tr v-for="division in divisiones" v-on:click="buscarGrupo(division)" v-bind:class="division[0] === division_p ? 'background_active_color' : ''" class='<?php echo $co; ?>' style='text-rendering: optimizeLegibility; cursor: pointer !important; style=\"cursor: hand\"'>
                                                                <td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ division[0] }}</td>
                                                                <td width="80%" style="font: 120% sans-serif; padding-left:10px">{{ division[1] }}</td>

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
                                            <div v-show="mostrarGrupo">
                                                <div style="margin: 2px 0 0 0;">
                                                    <div class="row" style="margin: 4px; border-radius:4px; background-color: #E1E2E2; ">
                                                        <div class="col-md-2" style="padding: 12px 0px 0px 30px; font: 140% sans-serif;">
                                                            <label for="">Grupos:</label>
                                                        </div>
                                                        
                                                        <div class="col-md-6 col-md-offset-6" style="padding: 4px">
                                                            <input type="text" class="form-control" placeholder="Buscar por nombre o c&oacute;digo de grupo" v-on:keyup="searchMonitorGrupos" v-model="searchGrupo.keywordGrupo">
                                                        </div>
                                                    </div>
                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <td width="20%" class='titulos' style="font: 120% sans-serif; padding-left:10px; border-radius: 5px 0 0 0;">C&oacute;digo</td>
                                                                <td width="80%" class='titulos' style="font: 120% sans-serif; ">Nombre</td>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                                <div style="margin: 2px 0 0 0; border-radius: 0 0 0 6px; height: 200px; overflow: scroll; overflow-x: hidden; background: white; ">
                                                    <table class='inicio inicio--no-shadow'>
                                                        <tbody>
                                                            <?php
                                                                $co ='zebra1';
                                                                $co2='zebra2';
                                                            ?>
                                                            <tr v-for="grupo in grupos" v-on:click="buscarClase(grupo)"  v-bind:class="grupo[0] === grupo_p ? 'background_active_color' : ''" class='<?php echo $co; ?>' style='text-rendering: optimizeLegibility; cursor: pointer !important; style=\"cursor: hand\"'>
                                                                <td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ grupo[0] }}</td>
                                                                <td width="80%" style="font: 120% sans-serif; padding-left:10px">{{ grupo[1] }}</td>

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
                                            <div v-show="mostrarClase">
                                                <div style="margin: 2px 0 0 0;">
                                                    <div class="row" style="margin: 4px; border-radius:4px; background-color: #E1E2E2; ">
                                                        <div class="col-md-2" style="padding: 12px 0px 0px 30px; font: 140% sans-serif;">
                                                            <label for="">Clases:</label>
                                                        </div>
                                                        
                                                        <div class="col-md-6 col-md-offset-6" style="padding: 4px">
                                                            <input type="text" class="form-control" placeholder="Buscar por nombre o c&oacute;digo de clase" v-on:keyup="searchMonitorClases" v-model="searchClase.keywordClase">
                                                        </div>
                                                    </div>
                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <td width="20%" class='titulos' style="font: 120% sans-serif; padding-left:10px; border-radius: 5px 0 0 0;">C&oacute;digo</td>
                                                                <td width="80%" class='titulos' style="font: 120% sans-serif; ">Nombre</td>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                                <div style="margin: 2px 0 0 0; border-radius: 0 0 0 6px; height: 200px; overflow: scroll; overflow-x: hidden; background: white; ">
                                                    <table class='inicio inicio--no-shadow'>
                                                        <tbody>
                                                            <?php
                                                                $co ='zebra1';
                                                                $co2='zebra2';
                                                            ?>
                                                            <tr v-for="clase in clases" v-on:click="buscarSubclase(clase)"  v-bind:class="clase[0] === clase_p ? 'background_active_color' : ''" class='<?php echo $co; ?>' style='text-rendering: optimizeLegibility; cursor: pointer !important; style=\"cursor: hand\"'>
                                                                <td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ clase[0] }}</td>
                                                                <td width="80%" style="font: 120% sans-serif; padding-left:10px">{{ clase[1] }}</td>

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
                                            <div v-show="mostrarSubClase">
                                                <div style="margin: 2px 0 0 0;">
                                                    <div class="row" style="margin: 4px; border-radius:4px; background-color: #E1E2E2; ">
                                                        <div class="col-md-2" style="padding: 12px 0px 0px 30px; font: 140% sans-serif;">
                                                            <label for="">Subclase:</label>
                                                        </div>
                                                        
                                                        <div class="col-md-6 col-md-offset-6" style="padding: 4px">
                                                            <input type="text" class="form-control" placeholder="Buscar por nombre o c&oacute;digo de subclase" v-on:keyup="searchMonitorSubClases" v-model="searchSubClase.keywordSubClase">
                                                        </div>
                                                    </div>
                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <td width="20%" class='titulos' style="font: 120% sans-serif; padding-left:10px; border-radius: 5px 0 0 0;">C&oacute;digo</td>
                                                                <td width="30%" class='titulos' style="font: 120% sans-serif; ">Nombre</td>
                                                                <td width="15%" class='titulos' style="font: 120% sans-serif; ">CIIU Rev. 4 A.C. </td>
                                                                <td width="25%" class='titulos' style="font: 120% sans-serif; ">Sistema Armonizado 2012</td>
                                                                <td width="10%" class='titulos' style="font: 120% sans-serif; ">CPC 2 A.C.</td>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                                <div style="margin: 2px 0 0 0; border-radius: 0 0 0 6px; height: 200px; overflow: scroll; overflow-x: hidden; background: white; ">
                                                    <table class='inicio inicio--no-shadow'>
                                                        <tbody>
                                                            <?php
                                                                $co ='zebra1';
                                                                $co2='zebra2';
                                                            ?>
                                                            <tr v-for="subclase in subClases" v-on:click="seleccionarSublaseProducto(subclase)"  v-bind:class="subclase[0] === subClase_p ? 'background_active_color' : ''" class='<?php echo $co; ?>' style='text-rendering: optimizeLegibility; cursor: pointer !important; style=\"cursor: hand\"'>
                                                                <td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ subclase[0] }}</td>
                                                                <td width="30%" style="font: 120% sans-serif; padding-left:10px">{{ subclase[1] }}</td>
                                                                <td width="15%" style="font: 120% sans-serif; padding-left:10px">{{ subclase[2] }}</td>
                                                                <td width="25%" style="font: 120% sans-serif; padding-left:10px">{{ subclase[3] }}</td>
                                                                <td width="10%" style="font: 120% sans-serif; padding-left:10px">{{ subclase[4] }}</td>

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
											<div v-show="mostrarSubClaseProducto">
                                                <div style="margin: 2px 0 0 0;">
                                                    <div class="row" style="margin: 4px; border-radius:4px; background-color: #E1E2E2; ">
                                                        <div class="col-md-2" style="padding: 12px 0px 0px 30px; font: 140% sans-serif;">
                                                            <label for="">Producto:</label>
                                                        </div>
                                                    </div>
                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <td width="20%" class='titulos' style="font: 120% sans-serif; padding-left:10px; border-radius: 5px 0 0 0;">Subclase</td>
                                                                <td width="60%" class='titulos' style="font: 120% sans-serif; ">Titulo</td>
                                                                <td width="20%" class='titulos' style="font: 120% sans-serif; ">Ud </td>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                                <div style="margin: 2px 0 0 0; border-radius: 0 0 0 6px; height: 100px; overflow: scroll; overflow-x: hidden; background: white; ">
                                                    <table class='inicio inicio--no-shadow'>
                                                        <tbody>
                                                            <tr v-for="subclase in subClases_captura" v-on:click="seleccionarBienes(subclase)"  v-bind:class="subclase[0] === subClase_p ? 'background_active_color' : ''" style='text-rendering: optimizeLegibility; cursor: pointer !important; style=\"cursor: hand\"'>
                                                                <td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ subclase[0] }}</td>
                                                                <td width="60%" style="font: 120% sans-serif; padding-left:10px">{{ subclase[1] }}</td>
                                                                <td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ subclase[2] }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <span id="end_page"> </span>
                                        </div>
										
										<div class="modal-intermedio-agregar">
											<div class="row" style="margin-left: 15px;">
												<form class="form-inline">
													<div class="form-group">
														<label for="valorBienesTranspotables">Valor:</label>
														<input type="number" v-model="valorBienesTranspotables" class="form-control mx-sm-3">

														<button type="button" class="btn btn-primary" v-on:click="agregaBienesTranspotables">Agregar</button>
														
													</div>
												</form>

												<form class="form-inline" style='padding-left:10px'>
													<div class="form-group">
															<label for="valorTotalBienes">Valor Total:</label>
															<input type="number" v-model="valorTotalBienes" class="form-control mx-sm-3" readonly>
													</div>
												</form>
											</div>
										</div>
										<div class="modal-body" style='height:140px; paddind: 0px'>
											<table v-if="show_table_search" class="table table-hover" >
												<thead>
													<tr>
														<th>C&oacute;digo</th>
														<th>Nombre</th>
														<th>Ud</th>
														<th>Valor</th>
														<th>Eliminar</th>
													</tr>
												</thead>
												<tbody>
													<tr v-for="cuenta in cuentasSubClaseAgr" style="font-weight: normal">
														<td>{{ cuenta[0] }}</td>
														<td>{{ cuenta[1] }}</td>
														<td>{{ cuenta[2] }}</td>
														<td>{{ cuenta[3] }}</td>
														<td>
															<button type="button" class="btn btn-danger" v-on:click="eliminarBienes(cuenta)">Eliminar</button>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-primary" v-on:click="guardarBienes">Guardar y continuar</button>
											<button type="button" class="btn btn-secondary" @click="showModal_bienes_transportables = false">Cerrar</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</transition>
				</div>

				<div v-show="showModal_servicios">
					<transition name="modal">
						<div class="modal-mask">
							<div class="modal-wrapper">
								<div class="modal-dialog modal-lg" style = "max-width: 1200px !important;" role="document">
									<div class="modal-content"  style = "width: 1200px !important;" scrollable>
										<div class="modal-header">
                                            <div class="row">
                                                <div class="col-10">
                                                    <h5 class="modal-title">Clasificador Servicios Sec. 5-9</h5>
                                                </div>
                                                <div class="col-2">
                                                    <button type="button" class="btn btn-secondary" v-on:click="buscarFuente()">Volver</button>
                                                </div>  
                                            </div>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true" @click="showModal_servicios = false">&times;</span>
											</button>
										</div>
                                        <div class="modal-body">
                                            <div v-show="mostrarDivisionServicios">
                                                <div style="margin: 2px 0 0 0;">
                                                    <div class="row" style="margin: 4px; border-radius:4px; background-color: #E1E2E2; ">
                                                        <div class="col-md-2" style="padding: 12px 0px 0px 30px; font: 140% sans-serif;">
                                                            <label for="">Divisi&oacute;n:</label>
                                                        </div>
                                                        
                                                        <div class="col-md-6 col-md-offset-6" style="padding: 4px">
                                                            <input type="text" class="form-control" placeholder="Buscar por nombre o c&oacute;digo de divisi&oacute;n" v-on:keyup="searchMonitorDivision" v-model="searchDivision.keywordDivision">
                                                        </div>
                                                    </div>
                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <td width="20%" class='titulos' style="font: 120% sans-serif; border-radius: 5px 0 0 0;">C&oacute;digo</td>
                                                                <td width="80%" class='titulos' style="font: 120% sans-serif;">Nombre</td>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                                <div style="margin: 2px 0 0 0; border-radius: 0 0 0 6px; height: 200px; overflow: scroll; overflow-x: hidden; background: white; ">
                                                    <table class='inicio inicio--no-shadow'>
                                                        <tbody>
                                                            <?php
                                                                $co ='zebra1';
                                                                $co2='zebra2';
                                                            ?>
                                                            <tr v-for="division in divisionesServicios" v-on:click="buscarGrupoServicios(division)" v-bind:class="division[0] === divisionServicios_p ? 'background_active_color' : ''" class='<?php echo $co; ?>' style='text-rendering: optimizeLegibility; cursor: pointer !important; style=\"cursor: hand\"'>
                                                                <td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ division[0] }}</td>
                                                                <td width="80%" style="font: 120% sans-serif; padding-left:10px">{{ division[1] }}</td>

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
                                            <div v-show="mostrarGrupoServicios">
                                                <div style="margin: 2px 0 0 0;">
                                                    <div class="row" style="margin: 4px; border-radius:4px; background-color: #E1E2E2; ">
                                                        <div class="col-md-2" style="padding: 12px 0px 0px 30px; font: 140% sans-serif;">
                                                            <label for="">Grupos:</label>
                                                        </div>
                                                        
                                                        <div class="col-md-6 col-md-offset-6" style="padding: 4px">
                                                            <input type="text" class="form-control" placeholder="Buscar por nombre o c&oacute;digo de grupo" v-on:keyup="searchMonitorGrupos" v-model="searchGrupoServicios.keywordGrupoServicios">
                                                        </div>
                                                    </div>
                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <td width="20%" class='titulos' style="font: 120% sans-serif; padding-left:10px; border-radius: 5px 0 0 0;">C&oacute;digo</td>
                                                                <td width="80%" class='titulos' style="font: 120% sans-serif; ">Nombre</td>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                                <div style="margin: 2px 0 0 0; border-radius: 0 0 0 6px; height: 200px; overflow: scroll; overflow-x: hidden; background: white; ">
                                                    <table class='inicio inicio--no-shadow'>
                                                        <tbody>
                                                            <?php
                                                                $co ='zebra1';
                                                                $co2='zebra2';
                                                            ?>
                                                            <tr v-for="grupo in gruposServicios" v-on:click="buscarClaseServicios(grupo)"  v-bind:class="grupo[0] === grupoServicios_p ? 'background_active_color' : ''" class='<?php echo $co; ?>' style='text-rendering: optimizeLegibility; cursor: pointer !important; style=\"cursor: hand\"'>
                                                                <td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ grupo[0] }}</td>
                                                                <td width="80%" style="font: 120% sans-serif; padding-left:10px">{{ grupo[1] }}</td>

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
                                            <div v-show="mostrarClaseServicios">
                                                <div style="margin: 2px 0 0 0;">
                                                    <div class="row" style="margin: 4px; border-radius:4px; background-color: #E1E2E2; ">
                                                        <div class="col-md-2" style="padding: 12px 0px 0px 30px; font: 140% sans-serif;">
                                                            <label for="">Clases:</label>
                                                        </div>
                                                        
                                                        <div class="col-md-6 col-md-offset-6" style="padding: 4px">
                                                            <input type="text" class="form-control" placeholder="Buscar por nombre o c&oacute;digo de clase" v-on:keyup="searchMonitorClases" v-model="searchClaseServicios.keywordClaseServicios">
                                                        </div>
                                                    </div>
                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <td width="20%" class='titulos' style="font: 120% sans-serif; padding-left:10px; border-radius: 5px 0 0 0;">C&oacute;digo</td>
                                                                <td width="80%" class='titulos' style="font: 120% sans-serif; ">Nombre</td>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                                <div style="margin: 2px 0 0 0; border-radius: 0 0 0 6px; height: 200px; overflow: scroll; overflow-x: hidden; background: white; ">
                                                    <table class='inicio inicio--no-shadow'>
                                                        <tbody>
                                                            <?php
                                                                $co ='zebra1';
                                                                $co2='zebra2';
                                                            ?>
                                                            <tr v-for="clase in clasesServicios" v-on:click="buscarSubclaseServicios(clase)"  v-bind:class="clase[0] === claseServicios_p ? 'background_active_color' : ''" class='<?php echo $co; ?>' style='text-rendering: optimizeLegibility; cursor: pointer !important; style=\"cursor: hand\"'>
                                                                <td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ clase[0] }}</td>
                                                                <td width="80%" style="font: 120% sans-serif; padding-left:10px">{{ clase[1] }}</td>

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
                                            <div v-show="mostrarSubClaseServicios">
                                                <div style="margin: 2px 0 0 0;">
                                                    <div class="row" style="margin: 4px; border-radius:4px; background-color: #E1E2E2; ">
                                                        <div class="col-md-2" style="padding: 12px 0px 0px 30px; font: 140% sans-serif;">
                                                            <label for="">Subclase:</label>
                                                        </div>
                                                        
                                                        <div class="col-md-6 col-md-offset-6" style="padding: 4px">
                                                            <input type="text" class="form-control" placeholder="Buscar por nombre o c&oacute;digo de subclase" v-on:keyup="searchMonitorSubClases" v-model="searchSubClase.keywordSubClase">
                                                        </div>
                                                    </div>
                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <td width="20%" class='titulos' style="font: 120% sans-serif; padding-left:10px; border-radius: 5px 0 0 0;">C&oacute;digo</td>
                                                                <td width="30%" class='titulos' style="font: 120% sans-serif; ">Nombre</td>
                                                                <td width="15%" class='titulos' style="font: 120% sans-serif; ">CIIU Rev. 4 A.C. </td>
                                                                <td width="25%" class='titulos' style="font: 120% sans-serif; ">Sistema Armonizado 2012</td>
                                                                <td width="10%" class='titulos' style="font: 120% sans-serif; ">CPC 2 A.C.</td>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                                <div style="margin: 2px 0 0 0; border-radius: 0 0 0 6px; height: 200px; overflow: scroll; overflow-x: hidden; background: white; ">
                                                    <table class='inicio inicio--no-shadow'>
                                                        <tbody>
                                                            <?php
                                                                $co ='zebra1';
                                                                $co2='zebra2';
                                                            ?>
                                                            <tr v-for="subclase in subClasesServicios" v-on:click="seleccionarServicios(subclase)"  v-bind:class="subclase[0] === subClaseServicios_p ? 'background_active_color' : ''" class='<?php echo $co; ?>' style='text-rendering: optimizeLegibility; cursor: pointer !important; style=\"cursor: hand\"'>
                                                                <td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ subclase[0] }}</td>
                                                                <td width="30%" style="font: 120% sans-serif; padding-left:10px">{{ subclase[1] }}</td>
                                                                <td width="15%" style="font: 120% sans-serif; padding-left:10px">{{ subclase[2] }}</td>
                                                                <td width="25%" style="font: 120% sans-serif; padding-left:10px">{{ subclase[3] }}</td>
                                                                <td width="10%" style="font: 120% sans-serif; padding-left:10px">{{ subclase[4] }}</td>

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
                                            <span id="end_page_servicios"> </span>
                                        </div>
										
										<div class="modal-intermedio-agregar">
											<div class="row" style="margin-left: 15px;">
												<form class="form-inline">
													<div class="form-group">
														<label for="valorServicios">Valor:</label>
														<input type="number" v-model="valorServicios" class="form-control mx-sm-3">

														<button type="button" class="btn btn-primary" v-on:click="agregaServicios">Agregar</button>
														
													</div>
												</form>

												<form class="form-inline" style='padding-left:10px'>
													<div class="form-group">
															<label for="valorTotalServicios">Valor Total:</label>
															<input type="number" v-model="valorTotalServicios" class="form-control mx-sm-3" readonly>
													</div>
												</form>
											</div>
										</div>
										<div class="modal-body" style='height:140px; paddind: 0px'>
											<table v-if="show_table_search" class="table table-hover" >
												<thead>
													<tr>
														<th>C&oacute;digo</th>
														<th>Nombre</th>
														<th>Valor</th>
														<th>Eliminar</th>
													</tr>
												</thead>
												<tbody>
													<tr v-for="cuenta in cuentasSubClaseServiciosAgr" style="font-weight: normal">
														<td>{{ cuenta[0] }}</td>
														<td>{{ cuenta[1] }}</td>
														<td>{{ cuenta[4] }}</td>
														<td>
															<button type="button" class="btn btn-danger" v-on:click="eliminarServicios(cuenta)">Eliminar</button>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-primary" v-on:click="guardarServicios">Guardar y continuar</button>
											<button type="button" class="btn btn-secondary" @click="showModal_servicios = false">Cerrar</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</transition>
				</div>
                <div v-show="showModal_fuentes">
					<transition name="modal">
						<div class="modal-mask">
							<div class="modal-wrapper">
								<div class="modal-dialog modal-lg" style = "max-width: 1200px !important;" role="document">
									<div class="modal-content"  style = "width: 1200px !important;" scrollable>
										<div class="modal-header">
											<h5 class="modal-title">Fuentes</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true" @click="showModal_fuentes = false">&times;</span>
											</button>
										</div>
                                        <div class="modal-body">
                                            <div style="margin: 2px 0 0 0;">
                                                <div class="row" style="margin: 4px; border-radius:4px; background-color: #E1E2E2; ">
                                                    <div class="col-md-2" style="padding: 12px 0px 0px 30px; font: 140% sans-serif;">
                                                        <label for="">Fuente:</label>
                                                    </div>
                                                    
                                                    <div class="col-md-6 col-md-offset-6" style="padding: 4px">
                                                        <input type="text" class="form-control" placeholder="Buscar por nombre o c&oacute;digo de la fuente" v-on:keyup="searchMonitorFuente" v-model="searchFuente.keywordFuente">
                                                    </div>
                                                </div>
                                                <table>
                                                    <thead>
                                                        <tr>
                                                            <td width="20%" class='titulos' style="font: 120% sans-serif; padding-left:10px; border-radius: 5px 0 0 0;">C&oacute;digo</td>
                                                            <td width="40%" class='titulos' style="font: 120% sans-serif; ">Nombre</td>
                                                            <td width="20%" class='titulos' style="font: 120% sans-serif; ">CSF</td>
                                                            <td width="20%" class='titulos' style="font: 120% sans-serif; ">SSF</td>

                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                            <div style="margin: 2px 0 0 0; border-radius: 0 0 0 6px; height: 200px; overflow: scroll; overflow-x: hidden; background: white; ">
                                                <table class='inicio inicio--no-shadow'>
                                                    <tbody>
                                                        <?php
                                                            $co ='zebra1';
                                                            $co2='zebra2';
                                                        ?>
                                                        <tr v-for="fuente in fuentes" v-on:click="seleccionarFuente(fuente)"  v-on:dblclick= "continuar" v-bind:class="fuente[0] === fuente_p ? 'background_active_color' : ''" class='<?php echo $co; ?>' style='text-rendering: optimizeLegibility; cursor: pointer !important; style=\"cursor: hand\"'>
                                                            <td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ fuente[0] }}</td>
                                                            <td width="40%" style="font: 120% sans-serif; padding-left:10px">{{ fuente[3] }}</td>
                                                            <td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ valorGastoCSF[fuente[0]] }}</td>
                                                            <td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ valorGastoSSF[fuente[0]] }}</td>
                                                            
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
										<div class="modal-footer">
											<button type="button" class="btn btn-primary" v-on:click="continuar">Continuar</button>
											<button type="button" class="btn btn-secondary" @click="showModal_fuentes = false">Cerrar</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</transition>
				</div>
				<div v-show="showModal_Solo_Presupuesto">
					<transition name="modal">
						<div class="modal-mask">
							<div class="modal-wrapper">
								<div class="modal-dialog modal-lg" role="document">
									<div class="modal-content"  style = "width: 700px !important;" scrollable>
										<div class="modal-header">
                                            <div class="row">
                                                <div class="col-10">
                                                    <h5 class="modal-title">Fuentes</h5>
                                                </div>
                                                <div class="col-2">
                                                    <button type="button" class="btn btn-secondary" v-on:click="buscarFuente()">Volver</button>
                                                </div>  
                                            </div>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true" @click="showModal_Solo_Presupuesto = false">&times;</span>
											</button>
										</div>
                                        <div class="modal-body">
                                            <div class="modal-intermedio-agregar">
                                                <div class="row" style="margin-left: 15px;">
                                                    <form class="form-inline">
                                                        <div class="form-group">
                                                            <label for="valorSolo">Valor:</label>
                                                            <input type="number" v-model="valorSolo" v-on:keydown.enter.prevent="guardarValorSolo" class="form-control mx-sm-3">
                                                            
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
										<div class="modal-footer">
											<button type="button" class="btn btn-primary" v-on:click="guardarValorSolo">Guardar y Continuar</button>
											<button type="button" class="btn btn-secondary" @click="showModal_Solo_Presupuesto = false">Cerrar</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</transition>
				</div>
                <div v-show="showModal_clasificador">
					<transition name="modal">
						<div class="modal-mask">
							<div class="modal-wrapper">
								<div class="modal-dialog modal-lg" style = "max-width: 1200px !important;" role="document">
									<div class="modal-content" style = "width: 1200px !important;" scrollable>
										<div class="modal-header">
											<h5 class="modal-title">Clasificador </h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true" @click="showModal_clasificador = false">&times;</span>
											</button>
										</div>
										<div class="modal-body">
											
											<div v-if="!show_table_search" class="loader-table">
												<div class="spinner"></div>
											</div>
											<table v-if="show_table_search" class="table table-hover">
												<thead>
													<tr>
														<th>C&oacute;digo</th>
														<th>Nombre</th>
														<th>tipo</th>
													</tr>
												</thead>
												<tbody>
													<tr v-for="clasificador in resultsClasificador" v-on:click="seleccionarClasificador(clasificador)" :class=" clasificador[2] == 'A' ? 'background_active_clasificador' : '' " v-bind:class="clasificador[0] === clasificador_p ? 'background_active_color' : ''" style='font-weight: normal; text-rendering: optimizeLegibility; cursor: pointer !important; style=\"cursor: hand\"'>
														<td>{{ clasificador[0] }}</td>
														<td>{{ clasificador[1] }}</td>
														<td>{{ clasificador[2] }}</td>
													</tr>
												</tbody>
											</table>
										</div>
										<div class="modal-intermedio-agregar">
											<div class="row" style="margin-left: 15px;">
												<form class="form-inline">
													<div class="form-group">
														<label for="valorClasificador">Valor:</label>
														<input type="number" v-model="valorClasificador" class="form-control mx-sm-3">

														<button type="button" class="btn btn-primary" v-on:click="agregaClasificador">Agregar cuenta</button>
														
													</div>
												</form>

												<form class="form-inline" style='padding-left:10px'>
													<div class="form-group">
															<label for="valorTotalClasificador">Valor Total:</label>
															<input type="number" v-model="valorTotalClasificador" class="form-control mx-sm-3" readonly>
													</div>
												</form>
												
											</div>
												
										</div>
										<div class="modal-intermetio">
											<div class="row">
												<div class="col-12" style="text-align:center; background: #E1E2E2;">
													<h5 class="modal-title">Cuentas seleccionadas</h5>
												</div>
											</div>
										</div>
										<div class="modal-body" style='height:140px; paddind: 0px'>
											<table v-if="show_table_search" class="table table-hover" >
												<thead>
													<tr>
														<th>C&oacute;digo</th>
														<th>Nombre</th>
														<th>Valor</th>
														<th>Eliminar</th>
													</tr>
												</thead>
												<tbody>
													<tr v-for="cuenta in cuentasClasificadorAgr" style="font-weight: normal">
														<td>{{ cuenta[0] }}</td>
														<td>{{ cuenta[1] }}</td>
														<td>{{ cuenta[3] }}</td>
														<td>
															<button type="button" class="btn btn-danger" v-on:click="eliminarClasificador(cuenta)">Eliminar</button>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-primary" v-on:click="guardarClasificador">Guardar y continuar</button>
											<button type="button" class="btn btn-secondary" @click="showModal_clasificador = false">Cerrar</button>
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
		<script src="vue/ccp-crearpresupuestoingresos.js"></script>
	</body>
</html>