<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=iso-8859-1");
	require 'comun.inc';
	require 'funciones.inc';
	require 'validaciones.inc';
	require 'conversor.php';
	session_start();
	$linkbd=conectar_v7();
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>SPID-Planeaci&oacute;n Estrat&eacute;gica</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css4.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css"/>
		<script src="vue/vue.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"> </script>
		<style>
			.modal-mask
			{
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
			.modal-wrapper 
			{
				display: table-cell;
				vertical-align: middle;
			}
			.modal-container
			{
				width: 60%;
				margin: 0px auto;
				padding: 20px 30px;
				text-align: left;
				background:linear-gradient(#99bbcc, #B6CEDA);
				border-radius: 2px;
				box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
				transition: all .3s ease;
			}
			.modal-container1
			{
				width: 50%;
				margin: 0px auto;
				padding: 20px 30px;
				text-align: left;
				background:linear-gradient(#99bbcc, #B6CEDA);
				border-radius: 10px;
				box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
				transition: all .3s ease;
			}
			.modal-container2
			{
				width: 80%;
				margin: 0px auto;
				padding: 20px 30px;
				text-align: left;
				background:linear-gradient(#99bbcc, #B6CEDA);
				border-radius: 2px;
				box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
				transition: all .3s ease;
			}
			.modal-container3
			{
				width: 90%;
				margin: 0px auto;
				padding: 20px 30px;
				text-align: left;
				background:linear-gradient(#99bbcc, #B6CEDA);
				border-radius: 2px;
				box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
				transition: all .3s ease;
			}
			footer
			{
				text-align: right;
			}
		</style>
		<?php titlepag();?>
	</head>
	<body>
		<div id="myapp">
			<table>
				<tr><script>barra_imagenes("ccpet");</script><?php cuadro_titulos();?></tr>
				<tr><?php menu_desplegable("ccpet");?></tr>
				<tr>
					<td colspan="3" class="cinta"><img src="imagenes/add.png" onClick="location.href='ccp-bancoproyctos.php'" class="mgbt" title="Nuevo" /><img src="imagenes/guarda.png" title="Guardar" v-on:click="preguntaguardar('1')" class="mgbt"/><img src="imagenes/busca.png" onClick="location.href='ccp-buscabancoproyectos.php'" class="mgbt" title="Buscar"/><img src="imagenes/nv.png" onClick="mypop=window.open('ccp-principal.php','',''); mypop.focus();" class="mgbt" title="Nueva Ventana"><a href="ccp-capturapresupuestoinicial.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
					</td>
				</tr>
			</table>
				<?php
					if(@ $_POST['oculto']=="")
					{
						$_POST['tabgroup1']=1;
					}
					switch($_POST['tabgroup1'])
					{
						case 1:
							$check1='checked';break;
						case 2:
							$check2='checked';break;
						case 3:
							$check3='checked';break;
						case 4:
							$check4='checked';break;
					}
				?>
			<div class="tabsmeci" style="height:74.5%; width:99.6%" >
				<div class="tab" >
					<input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
					<label for="tab-1">Proyecto</label>
					<div class="content" style="overflow:hidden;">
						<table class="inicio ancho">
							<tr>
								<td class="titulos" colspan="8" >Ingresar Proyecto</td>
								<td class="cerrar" style="width:7%" onClick="location.href='plan-principal.php'">Cerrar</td>
							</tr>
							<tr>
								<td class="tamano01" style="width:3cm">Unidad Ejecutora:</td>
								<td colspan="3">
									<input type="text" v-model="unidadejecutora" v-on:dblclick='toggleModalUnidadEje' style="width:100%;height:30px;" v-bind:class="unidadejecutoradobleclick"  autocomplete="off" readonly/>
									<input type="hidden" v-model="cunidadejecutora"/>
								</td>
							</tr>
							<tr>
								<td class="tamano01" style="width:3cm">C&oacute;digo:</td>
								<td style="width:20%"><input type="text" v-model="codigo" style="width:100%;height:30px;" ref="codigo"/></td>
								<td class="tamano01" style="width:7%">Vigencia:</td>
								<td style="width:7%">
									<select v-model="vigencia" style="width:100%">
										<option v-for="year in years" :value="year[0]">{{ year[0] }}</option>
									</select>
								</td>
								<td class="tamano01" style="width:3cm">Nombre:</td>
								<td style=""><input type="text" v-model="nombre" style="width:100%;height:30px;" ref="nombre"/></td>
							</tr>
							<tr>
								<td class="tamano01">Valor del proyecto:</td>
								<td><input type="number" v-model="valorproyecto" style="width:100%;height:30px;" readonly/></td>
								<td class="tamano01">Descripci&oacute;n:</td>
								<td colspan="3"><input type="text" v-model="descripcion" style="width:100%;height:30px;" ref="descripcion"/></td>
							</tr>
							<tr>
								<td class="tamano01">Sector:</td>
								<td colspan="3"><input type="text" v-model="sector" v-on:dblclick='toggleModal' style="width:100%;height:30px;" v-bind:class="sectordobleclick" autocomplete="off" readonly/><input type="hidden" v-model="csector"/></td>
								<td class="tamano01">Programa:</td>
								<td colspan="3"><input type="text"  v-model="programa" v-on:dblclick='toggleModal2' style="width:100%;height:30px;" v-bind:class="programadobleclick" readonly/><input type="hidden" v-model="cprograma"/></td>
							</tr>
							<tr>
								<td class="tamano01">Subprograma:</td>
								<td colspan="3"><input type="text"  v-model="subprograma" style="width:100%;height:30px;" readonly/><input type="hidden" v-model="csubprograma"/></td>
								<td class="tamano01">Indicador Producto:</td>
								<td colspan="3"><input type="text" v-model="indicadorpro" v-on:dblclick='toggleModal3' style="width:100%;height:30px;" v-bind:class=" indicadordobleclick" autocomplete="off" v-on:keyup="validaindicadorproducto(indicadorpro)"/><input type="hidden" v-model="cindicadorpro"/></td>
							</tr>
							<tr>
								<td class="tamano01">Producto:</td>
								<td colspan="4"><input type="text"  v-model="producto" style="width:100%;height:30px;"  autocomplete="off" readonly/><input type="hidden" v-model="cproducto"/></td>
								<td style=" height: 30px;"><em class="botonflecha" v-on:click="agregarproducto()">Agregar</em></td>
							</tr>
						</table>
						<div class='subpantalla' style='height:46.5%; width:99.5%; margin-top:0px; overflow-x:hidden'>
							<table class='inicio inicio--no-shadow'>
								<tbody>
									<tr v-for="(vcproducto, index) in selecproductosa" v-bind:class="index % 2 ? 'saludo1a' : 'saludo2'" style='text-rendering: optimizeLegibility; cursor: pointer !important; style=\"cursor: hand\"' >
										
										<td width="50%" style="font: 120% sans-serif; padding-left:10px">{{ vcproducto[1] }}</td>
										<td style="font: 120% sans-serif; padding-left:10px">{{ vcproducto[3] }}</td>
										<td  v-on:click="eliminaproducto(index)"><img src='imagenes/del.png'></td>

									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="tab">
					<input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?> >
					<label for="tab-2">Presupuesto</label>
					<div class="content" style="overflow:hidden;">
						<table class="inicio ancho">
							<tr>
								<td class="titulos" colspan="4">Ingresar Presupuesto</td>
								<td class="cerrar" style="width:7%" onClick="location.href='plan-principal.php'">Cerrar</td>
							</tr>
							<tr>
								<td class='tamano01'>Fuente:</td>
								
								<td><input type="text" v-model="fuentef" ref ="fuentef" v-on:dblclick='toggleModal10' style="width:100%;height:30px;" v-bind:class="fuentedobleclick" autocomplete="off" readonly/><input type="hidden" v-model="cfuentef"/></td>
								<td class='tamano01'>Medio de Pago:</td>
								<td>
									<select v-model="mediopago" style="width:100%" v-bind:class="parpadeomediopago" v-on:click="parpadeomediopago='';" >
										<option disabled value="">Seleccione un medio de pago</option>
										<option value='CSF'>Con Situaci&oacute;n de Fondos</option>
										<option value='SSF'>Si Situaci&oacute;n de Fondos</option>
									</select>
								</td>
							</tr>
							<tr>
								<td class='tamano01' style="width:3cm;">Rubro:</td>
								<td style="width:35%"><input type="text" v-model="nrubro" v-on:dblclick='toggleModal4' class="colordobleclik" style="width:100%;height:30px;" readonly/><input type="hidden" v-model="codrubro"/></td>
								<td class='tamano01' style="width:3cm;">Clasificador:</td>
								<td>
									<select v-show="(cclasificados.length > 0) ? true : false" v-model="clasificador" v-on:change="deplegar();deshacer('12');" style="width:100%">
										<option disabled value="">Seleccione un medio de pago</option>
										<option v-for="cclasifica in cclasificados" :value="cclasifica[0]">{{ cclasifica[0] }} - {{ cclasifica[1] }}</option>
									</select>
									<select v-show="(cclasificados.length == 0) ? true : false" style="width:100%">
										<option value="0" selected>Sin Clasificador</option>
									</select>
								</td>
							</tr>
						</table>
						<table class="inicio ancho" v-show="showopcion1">
							<tr>
								<td class='tamano01' style="width:3cm;">Id Entidad:</td>
								<td style="width:20%"><input type="text" v-model="identidad" v-on:dblclick='toggleModal11' style="width:100%;height:30px;" class="colordobleclik" autocomplete="off" readonly></td>
								<td class='tamano01' style="width:3cm;">Nit:</td>
								<td style="width:20%"><input type="text" v-model="nitentidad" style="width:100%;height:30px;" readonly></td>
								<td class='tamano01' style="width:3cm;">C&oacute;digo CUIN:</td>
								<td colspan="2"><input type="text" v-model="codigocuin" style="width:100%;height:30px;" readonly></td>
								<td style="width:7%"></td>
							</tr>
							<tr>
								<td class='tamano01' >Entidad:</td>
								<td colspan="3"><input type="text" v-model="nomentidad" style="width:100%;height:30px;" readonly/></td>
								<td class='tamano01' >Valor:</td>
								<td><input type="number" v-model="valorcuin" style="width:100%;height:30px;"/></td>
								<td style=" height: 30px;"><em class="botonflecha" v-on:click="agregarcuenta1()">Agregar</em></td>
							</tr>
						</table>
						<table class="inicio ancho" v-show="showopcion2">
							<tr>
								<td class='tamano01' style="width:3cm;">Valor:</td>
								<td width="26.2%"><input type="number" v-model="valorsinclasifi" style="width:100%;height:30px;"/></td>
								<td style=" height: 30px;"><em class="botonflecha" v-on:click="agregarcuenta2()">Agregar</em></td>
							</tr>
						</table>
						<table class="inicio ancho" v-show="showopcion2_3">
							<tr>
								<td class='tamano01' style="width:2.5cm;">Secci&oacute;n:</td>
								<td style="width:25%"><input type="text" v-model="seccion" v-on:dblclick='toggleModal5' v-bind:class="secciondobleclick" style="width:100%;height:30px;" readonly/><input type="hidden" v-model="cseccion"/></td>
								<td class='tamano01' style="width:2.8cm;">Divisi&oacute;n:</td>
								<td ><input type="text" v-model="division" v-on:dblclick='toggleModal6' v-bind:class="divisiondobleclick" style="width:100%;height:30px;" readonly/><input type="hidden" v-model="cdivision"/></td>
								<td class='tamano01' style="width:2.5cm;">Grupo:</td>
								<td ><input type="text" v-model="grupo" v-on:dblclick='toggleModal7' v-bind:class="grupodobleclick" style="width:100%;height:30px;" readonly/><input type="hidden" v-model="cgrupo"/></td>
								<td style="width:7%;"></td>
							</tr>
							<tr>
								<td class='tamano01'>Clase:</td>
								<td><input type="text" v-model="clase" v-on:dblclick='toggleModal8' v-bind:class="clasedobleclick" style="width:100%;height:30px;" readonly/><input type="hidden" v-model="cclase"/></td>
								<td  class='tamano01'>Subclase:</td>
								<td><input type="text" v-model="subclase" v-on:dblclick='toggleModal9' v-bind:class="subclasedobleclick"  style="width:100%;height:30px;" ref="subclase" v-on:keyup="validasubclase(subclase)"/><input type="hidden" v-model="csubclase"/></td>
								<td  class='tamano01' v-show="clasificador == 2 ? true : false">Producto:</td>
								<td v-show="clasificador == 2 ? true : false"><input type="text" v-model="subproducto" v-on:dblclick='toggleModal12' v-bind:class="subproductodobleclick" style="width:100%;height:30px;" ref="subproducto" v-on:keyup="validasubproducto(subproducto)"/><input type="hidden" v-model="csubproducto"/></td>
							</tr>
							<tr>
								<td class='tamano01' >Valor:</td>
								<td><input type="number" v-model="valorrubro" style="width:100%;height:30px;" ref="valorrubro" v-bind:class="parpadeovalorrubro" v-on:keydown="parpadeovalorrubro='';"/></td>
								<td style=" height: 30px;"><em class="botonflecha" v-on:click="agregarcuenta()">Agregar</em></td>
							</tr>
						</table>
						<div class="tabsmeci" style="width:99.8%" >
							<div class="tab" >
								<input type="radio" id="tab-1b" name="tabgroup2" v-model="tabgroup2" v-bind:value="tb1" >
								<label for="tab-1b">Sin Clasificador</label>
								<div class="content" style="overflow-x:hidden;" v-bind:style="{ height: tapheight1 }">
									<table class='inicio inicio--no-shadow'>
										<tbody>
											<tr class="titulos">
												<td>Fuente</td>
												<td>Medio Pago</td>
												<td>Rubro</td>
												<td>valor</td>
												<td></td>
											</tr>
											<tr v-for="(vsinclasificador, index) in selectcuetase" v-bind:class="index % 2 ? 'saludo1a' : 'saludo2'" style='text-rendering: optimizeLegibility; cursor: pointer !important; style=\"cursor: hand\"' >
												<td style="font: 120% sans-serif; padding-left:10px">{{ vsinclasificador[3] }}</td>
												<td style="font: 120% sans-serif; padding-left:10px; width:10%;">{{ vsinclasificador[4] }}</td>
												<td style="font: 120% sans-serif; padding-left:10px">{{ vsinclasificador[1] }}</td>
												<td style="font: 120% sans-serif; padding-left:10px; width:20%;">{{ vsinclasificador[2] }}</td>
												<td style="width:5%;" v-on:click="eliminacuenta2(index,vsinclasificador[2])"><img src='imagenes/del.png'></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<div class="tab">
								<input type="radio" id="tab-2b" name="tabgroup2" v-model="tabgroup2" v-bind:value="tb2" >
								<label for="tab-2b">Clasificador CUIN</label>
								<div class="content" style="overflow-x:hidden" v-bind:style="{ height: tapheight2 }">
									<table class='inicio inicio--no-shadow'>
										<tbody>
											<tr class="titulos">
												<td>Fuente</td>
												<td>Medio Pago</td>
												<td>Rubro</td>
												<td>Identidad</td>
												<td>Nit</td>
												<td>Entidad</td>
												<td>C&oacute;digo CUIN</td>
												<td>valor</td>
												<td></td>
											</tr>
											<tr v-for="(vcodigocuin, index) in selectcuetasc" v-bind:class="index % 2 ? 'saludo1a' : 'saludo2'" style='text-rendering: optimizeLegibility; cursor: pointer !important; style=\"cursor: hand\"' >
												<td style="font: 120% sans-serif; padding-left:10px">{{ vcodigocuin[5] }}</td>
												<td style="font: 120% sans-serif; padding-left:10px">{{ vcodigocuin[6] }}</td>
												<td style="font: 120% sans-serif; padding-left:10px">{{ vcodigocuin[7] }}</td>
												<td style="font: 120% sans-serif; padding-left:10px; width:15%;">{{ vcodigocuin[0] }}</td>
												<td style="font: 120% sans-serif; padding-left:10px">{{ vcodigocuin[1] }}</td>
												<td style="font: 120% sans-serif; padding-left:10px; width:35%;">{{ vcodigocuin[2] }}</td>
												<td style="font: 120% sans-serif; padding-left:10px; width:20%;">{{ vcodigocuin[3] }}</td>
												<td style="font: 120% sans-serif; padding-left:10px; width:20%;">{{ vcodigocuin[4] }}</td>
												<td style="width:5%;" v-on:click="eliminacuenta1(index,vcodigocuin[4])"><img src='imagenes/del.png'></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<div class="tab">
								<input type="radio" id="tab-3b" name="tabgroup2" v-model="tabgroup2" v-bind:value="tb3" >
								<label for="tab-3b">Clasificador B y S</label>
								<div class="content" style="overflow-x:hidden" v-bind:style="{ height: tapheight3 }">
									<table class='inicio inicio--no-shadow'>
										<tbody>
											<tr class="titulos">
												<td>Fuente</td>
												<td>Medio Pago</td>
												<td>Rubro</td>
												<td>Subclase</td>
												<td>producto</td>
												<td>valor</td>
												<td></td>
											</tr>
											<tr v-for="(vccuenta, index) in selectcuetasa" v-bind:class="index % 2 ? 'saludo1a' : 'saludo2'" style='text-rendering: optimizeLegibility; cursor: pointer !important; style=\"cursor: hand\"' >
												<td style="font: 120% sans-serif; padding-left:10px;">{{ vccuenta[4] }}</td>
												<td style="font: 120% sans-serif; padding-left:10px; width:10%;">{{ vccuenta[5] }}</td>
												<td style="font: 120% sans-serif; padding-left:10px">{{ vccuenta[1] }}</td>
												<td style="font: 120% sans-serif; padding-left:10px; width:30%;">{{ vccuenta[2] }}</td>
												<td style="font: 120% sans-serif; padding-left:10px;width:30%;">{{ vccuenta[6] }}</td>
												<td style="font: 120% sans-serif; padding-left:10px; ">{{ vccuenta[3] }}</td>
												<td style="width:5%;" v-on:click="eliminacuentas(index,vccuenta[3])"><img src='imagenes/del.png'></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div v-show="showMensaje">
					<transition name="modal">
						<div class="modal-mask">
							<div class="modal-wrapper">
								<div class="modal-container1">
									<table id='ventanamensaje1' class='inicio' style="border-radius: 10px;">
										<tr >
											<td class="titulosmensajes1" v-bind:style="{color:colortitulosmensaje,}" style=" text-shadow: 7px 4px 5px grey;font-style: italic;border-radius: 50px;">{{titulomensaje}}</td>
										</tr>
										<tr>
											<td class='.cuerpomensajes1' style="text-align:center;"><h3 style="font-size: 20px;font-family:Gotham, 'Helvetica Neue', Helvetica, Arial, 'sans-serif';font-style: italic;">{{ contenidomensaje }}</h3></td>
										</tr>
										<tr>
											<td class='.cuerpomensajes1' style="padding: 14px;text-align:center">
												<em name="continuar" id="continuar" class="botonflecha" @click="toggleMensaje()">Continuar</em>
											</td>
										</tr>
									</table>
								</div>
							</div>
						</div>
					</transition>
				</div>
				<div v-show="showMensajeSN">
					<transition name="modal">
						<div class="modal-mask">
							<div class="modal-wrapper">
								<div class="modal-container1">
									<table id='ventanamensaje1' class='inicio' style="border-radius: 10px;">
										<tr >
											<td class="titulosmensajes1" v-bind:style="{color:colortitulosmensaje,}" style=" text-shadow: 7px 4px 5px grey;font-style: italic;border-radius: 50px;">{{titulomensaje}}</td>
										</tr>
										<tr>
											<td class='.cuerpomensajes1' style="text-align:center;"><h3 style="font-size: 20px;font-family:Gotham, 'Helvetica Neue', Helvetica, Arial, 'sans-serif';font-style: italic;">{{ contenidomensaje }}</h3></td>
										</tr>
										<tr>
											<td class='.cuerpomensajes1' style="padding: 14px;text-align:center">
												<em name="continuar" id="continuar" class="botonflechaverde" @click="toggleMensajeSN('1','S')">Aceptar</em> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												<em name="continuar" id="continuar" class="botonflecharoja" @click="toggleMensajeSN('1','N')">Cancelar</em>
											</td>
										</tr>
									</table>
								</div>
							</div>
						</div>
					</transition>
				</div>
				<div v-show="showModalUnidadEj">
					<transition name="modal">
						<div class="modal-mask">
							<div class="modal-wrapper">
								<div class="modal-container">
									<table class="inicio ancho">
										<tr>
											<td class="titulos" colspan="2" >SELECCIONAR UNIDAD EJECUTORA</td>
											<td class="cerrar" style="width:7%" @click="showModalUnidadEj = false">Cerrar</td>
										</tr>
										<!-- <tr>
											<td class="tamano01" style="width:3cm">Unidad Ejecutora:</td>
											<td><input type="text" class="form-control" placeholder="Buscar por nombre de unidad ejecutora" v-on:keyup="searchMonitorUnidadEj" v-model="search.keyword" style="width:100%" /></td>
										</tr> -->
									</table>
									<table>
										<thead>
											<tr>
												<td class='titulos' style="font: 160% sans-serif; border-radius: 5px 0 0 0; width:20%;">C&oacute;digo</td>
												<td class='titulos' style="font: 160% sans-serif; width:60%;">Nombre</td>
												<td class='titulos' style="font: 160% sans-serif; border-radius: 0 5px 0 0;">Aplicaci&oacute;n</td>
											</tr>
										</thead>
									</table>
									<div style='margin: 0px 5px 5px; border-radius: 0 0 5px 5px; height: 200px; overflow: scroll; overflow-x: hidden; background: white;'>
										<table class='inicio inicio--no-shadow'>
											<tbody>
												<tr v-for="(unidadeejecutora,index) in unidadesejecutoras" v-on:click="cargaunidadejecutora(unidadeejecutora[0],unidadeejecutora[1])" v-bind:class="index % 2 ? 'saludo1a' : 'saludo2'" style='text-rendering: optimizeLegibility; cursor: pointer !important; style=\"cursor: hand\"'>
													<td style="font: 120% sans-serif; padding-left:10px; width:20%;">{{ unidadeejecutora[0] }}</td>
													<td style="font: 120% sans-serif; padding-left:10px; width:60%;">{{ unidadeejecutora[1] }}</td>
													<td style="font: 120% sans-serif; padding-left:10px">{{ unidadeejecutora[2] }}</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</transition>
				</div>
				<div v-show="showModal">
					<transition name="modal">
						<div class="modal-mask">
							<div class="modal-wrapper">
								<div class="modal-container">
									<table class="inicio ancho">
										<tr>
											<td class="titulos" colspan="2" >SELECCIONAR SECTOR</td>
											<td class="cerrar" style="width:7%" @click="showModal = false">Cerrar</td>
										</tr>
										<tr>
											<td class="tamano01" style="width:3cm">Sector:</td>
											<td><input type="text" class="form-control" placeholder="Buscar por nombre de sector" v-on:keyup="searchMonitor" v-model="search.keyword" style="width:100%" /></td>
										</tr>
									</table>
									<table>
										<thead>
											<tr>
												<td class='titulos' style="font: 160% sans-serif; border-radius: 5px 0 0 0; width:20%;">C&oacute;digo</td>
												<td class='titulos' style="font: 160% sans-serif; width:60%;">Nombre</td>
												<td class='titulos' style="font: 160% sans-serif; border-radius: 0 5px 0 0;">Aplicaci&oacute;n</td>
											</tr>
										</thead>
									</table>
									<div style='margin: 0px 5px 5px; border-radius: 0 0 5px 5px; height: 200px; overflow: scroll; overflow-x: hidden; background: white;'>
										<table class='inicio inicio--no-shadow'>
											<tbody>
												<tr v-for="(sector,index) in sectores" v-on:click="cargasector(sector[0],sector[1])" v-bind:class="index % 2 ? 'saludo1a' : 'saludo2'" style='text-rendering: optimizeLegibility; cursor: pointer !important; style=\"cursor: hand\"'>
													<td style="font: 120% sans-serif; padding-left:10px; width:20%;">{{ sector[0] }}</td>
													<td style="font: 120% sans-serif; padding-left:10px; width:60%;">{{ sector[1] }}</td>
													<td style="font: 120% sans-serif; padding-left:10px">{{ sector[2] }}</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</transition>
				</div>
				<div v-show="showModal2">
					<transition name="modal">
						<div class="modal-mask">
							<div class="modal-wrapper">
								<div class="modal-container2">
									<table class="inicio ancho">
										<tr>
											<td class="titulos" colspan="2" >SELECCIONAR PROGRAMA</td>
											<td class="cerrar" style="width:7%" @click="showModal2 = false">Cerrar</td>
										</tr>
										<tr>
											<td class="tamano01" style="width:3cm">Programa:</td>
											<td><input type="text" class="form-control" placeholder="Buscar por nombre del programa" v-on:keyup="searchMonitorPrograms" v-model="searchProgram.keywordProgram" style="width:100%" /></td>
										</tr>
									</table>
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
									<div style='margin: 0px 5px 5px; border-radius: 0 0 5px 5px; height: 200px; overflow: scroll; overflow-x: hidden; background: white;'>
										<table class='inicio inicio--no-shadow'>
											<tbody>
												<tr v-for="(programa,index) in programas_subprogramas" v-on:click="cargaprograma( programa[0],programa[1], programa[2], programa[3])" v-bind:class="index % 2 ? 'saludo1a' : 'saludo2'" style='text-rendering: optimizeLegibility; cursor: pointer !important; style=\"cursor: hand\"'>
													<td width="10%" style="font: 120% sans-serif; padding-left:10px">{{ programa[0] }}</td>
													<td width="30%" style="font: 120% sans-serif; padding-left:10px">{{ programa[1] }}</td>
													<td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ programa[2] }}</td>
													<td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ programa[3] }}</td>
													<td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ programa[4] }}</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</transition>
				</div>
				<div v-show="showModal3">
					<transition name="modal">
						<div class="modal-mask">
							<div class="modal-wrapper">
								<div class="modal-container3">
									<table class="inicio ancho">
										<tr>
											<td class="titulos" colspan="2" >SELECCIONAR PRODUCTOS</td>
											<td class="cerrar" style="width:7%" @click="showModal3 = false">Cerrar</td>
										</tr>
										<tr>
											<td class="tamano01" style="width:3cm">PRODUCTOS:</td>
											<td><input type="text" class="form-control" placeholder="Buscar por nombre de productos" v-on:keyup="searchMonitorProducts" v-model="searchProduct.keywordProduct" style="width:100%" /></td>
										</tr>
									</table>
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
									<div style='margin: 0px 5px 5px; border-radius: 0 0 5px 5px; height: 400px; overflow: scroll; overflow-x: hidden; background: white;'>
										<table class='inicio inicio--no-shadow'>
											<tbody>
												<tr v-for="(producto,index) in productos" v-on:click="cargaproducto(producto[0],producto[1],producto[4],producto[5])" v-bind:class="index % 2 ? 'saludo1a' : 'saludo2'" style='text-rendering: optimizeLegibility; cursor: pointer !important; style=\"cursor: hand\"'>
													<td width="10%" style="font: 120% sans-serif; padding-left:10px">{{ producto[0] }}</td>
													<td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ producto[1] }}</td>
													<td width="30%" style="font: 120% sans-serif; padding-left:10px">{{ producto[2] }}</td>
													<td width="10%" style="font: 120% sans-serif; padding-left:10px">{{ producto[3] }}</td>
													<td width="5%" style="font: 120% sans-serif; padding-left:10px">{{ producto[4] }}</td>
													<td width="10%" style="font: 120% sans-serif; padding-left:10px">{{ producto[5] }}</td>
													<td width="10%" style="font: 120% sans-serif; padding-left:10px">{{ producto[6] }}</td>
													<td width="5%" style="font: 120% sans-serif; padding-left:10px">{{ producto[7] }}</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</transition>
				</div>
				<div v-show="showModal4">
					<transition name="modal">
						<div class="modal-mask">
							<div class="modal-wrapper">
								<div class="modal-container">
									<table class="inicio ancho">
										<tr>
											<td class="titulos" colspan="2" >SELECCIONAR CUENTAS PRESUPUESTALES</td>
											<td class="cerrar" style="width:7%" @click="showModal4 = false">Cerrar</td>
										</tr>
										<tr>
											<td class="tamano01" style="width:3cm">Descripci&oacute;n:</td>
											<td><input type="text" class="form-control" placeholder="Buscar por descripcion cuenta" v-on:keyup="searchMonitorCuentasPresupuestales" v-model="searchCuentaPresupuestal.keywordCuentaPresupuestal" style="width:100%" /></td>
										</tr>
									</table>
									<table>
										<thead>
											<tr>

												<td class='titulos' style="width:30%; font: 160% sans-serif; ">C&oacute;digo</td>
												<td class='titulos' style="font: 160% sans-serif; ">Nombre</td>
												<td class='titulos' style="width:10%; font: 160% sans-serif; ">Tipo</td>

											</tr>
										</thead>
									</table>
									<div style='margin: 0px 5px 5px; border-radius: 0 0 5px 5px; height: 200px; overflow: scroll; overflow-x: hidden; background: white;'>
										<table class='inicio inicio--no-shadow'>
											<tbody>
												<tr v-for="(cuentapre,index) in cuentaspres" v-on:click="cargacuenta(cuentapre[0],cuentapre[1],cuentapre[2])"  v-bind:class="index % 2 ? 'saludo1a' : 'saludo2'" style='text-rendering: optimizeLegibility; cursor: pointer !important; style=\"cursor: hand\"'>
													<td style="font: 120% sans-serif; padding-left:10px; width: 30%;">{{ cuentapre[0] }}</td>
													<td style="font: 120% sans-serif; padding-left:10px">{{ cuentapre[1] }}</td>
													<td  style="width: 8%; font: 120% sans-serif; padding-left:10px">{{ cuentapre[2] }}</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</transition>
				</div>
				<div v-show="showModal5">
					<transition name="modal">
						<div class="modal-mask">
							<div class="modal-wrapper">
								<div class="modal-container">
									<table class="inicio ancho">
										<tr>
											<td class="titulos" colspan="2" >SELECCIONAR SECCION</td>
											<td class="cerrar" style="width:7%" @click="showModal5 = false">Cerrar</td>
										</tr>
										<tr>
											<td class="tamano01" style="width:3cm">NOMBRE:</td>
											<td><input type="text" class="form-control" placeholder="Buscar por nombre seccion" v-on:keyup="searchMonitorProducts" v-model="searchProduct.keywordProduct" style="width:100%" /></td>
										</tr>
									</table>
									<table>
										<thead>
											<tr>
												<td class='titulos' style="width:20%; font: 160% sans-serif; ">C&oacute;digo</td>
												<td class='titulos' style="font: 160% sans-serif; ">Nombre</td>
											</tr>
										</thead>
									</table>
									<div style='margin: 0px 5px 5px; border-radius: 0 0 5px 5px; height: 200px; overflow: scroll; overflow-x: hidden; background: white;'>
										<table class='inicio inicio--no-shadow'>
											<tbody>
												<tr v-for="(seccion,index) in secciones" v-on:click="cargaseccion(seccion[0],seccion[1])"  v-bind:class="index % 2 ? 'saludo1a' : 'saludo2'" style='text-rendering: optimizeLegibility; cursor: pointer !important; style=\"cursor: hand\"'>
													<td style="font: 120% sans-serif; padding-left:10px;width:20%;">{{ seccion[0] }}</td>
													<td style="font: 120% sans-serif; padding-left:10px">{{ seccion[1] }}</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</transition>
				</div>
				<div v-show="showModal6">
					<transition name="modal">
						<div class="modal-mask">
							<div class="modal-wrapper">
								<div class="modal-container">
									<table class="inicio ancho">
										<tr>
											<td class="titulos" colspan="2" >SELECCIONAR DIVISION</td>
											<td class="cerrar" style="width:7%" @click="showModal6 = false">Cerrar</td>
										</tr>
										<tr>
											<td class="tamano01" style="width:3cm">NOMBRE:</td>
											<td><input type="text" class="form-control" placeholder="Buscar por nombre de divisi�n" v-on:keyup="searchMonitorProducts" v-model="searchProduct.keywordProduct" style="width:100%" /></td>
										</tr>
									</table>
									<table>
										<thead>
											<tr>
												<td class='titulos' style="width:20%; font: 160% sans-serif; ">C&oacute;digo</td>
												<td class='titulos' style="font: 160% sans-serif; ">Nombre</td>
											</tr>
										</thead>
									</table>
									<div style='margin: 0px 5px 5px; border-radius: 0 0 5px 5px; height: 200px; overflow: scroll; overflow-x: hidden; background: white;'>
										<table class='inicio inicio--no-shadow'>
											<tbody>
												<tr v-for="(division,index) in divisiones" v-on:click="cargadivision(division[0],division[1])"  v-bind:class="index % 2 ? 'saludo1a' : 'saludo2'" style='text-rendering: optimizeLegibility; cursor: pointer !important; style=\"cursor: hand\"'>
													<td style="font: 120% sans-serif; padding-left:10px; width:20%;">{{ division[0] }}</td>
													<td style="font: 120% sans-serif; padding-left:10px">{{ division[1] }}</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</transition>
				</div>
				<div v-show="showModal7">
					<transition name="modal">
						<div class="modal-mask">
							<div class="modal-wrapper">
								<div class="modal-container">
									<table class="inicio ancho">
										<tr>
											<td class="titulos" colspan="2" >SELECCIONAR GRUPO</td>
											<td class="cerrar" style="width:7%" @click="showModal7 = false">Cerrar</td>
										</tr>
										<tr>
											<td class="tamano01" style="width:3cm">NOMBRE:</td>
											<td><input type="text" class="form-control" placeholder="Buscar por nombre del grupo" v-on:keyup="searchMonitorProducts" v-model="searchProduct.keywordProduct" style="width:100%" /></td>
										</tr>
									</table>
									<table>
										<thead>
											<tr>
												<td class='titulos' style="width:20%; font: 160% sans-serif; ">C&oacute;digo</td>
												<td class='titulos' style="font: 160% sans-serif; ">Nombre</td>
											</tr>
										</thead>
									</table>
									<div style='margin: 0px 5px 5px; border-radius: 0 0 5px 5px; height: 200px; overflow: scroll; overflow-x: hidden; background: white;'>
										<table class='inicio inicio--no-shadow'>
											<tbody>
												<tr v-for="(grupo,index) in grupos" v-on:click="cargagrupo(grupo[0],grupo[1])"  v-bind:class="index % 2 ? 'saludo1a' : 'saludo2'" style='text-rendering: optimizeLegibility; cursor: pointer !important; style=\"cursor: hand\"'>
													<td style="font: 120% sans-serif; padding-left:10px;width:20%;">{{ grupo[0] }}</td>
													<td style="font: 120% sans-serif; padding-left:10px">{{ grupo[1] }}</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</transition>
				</div>
				<div v-show="showModal8">
					<transition name="modal">
						<div class="modal-mask">
							<div class="modal-wrapper">
								<div class="modal-container">
									<table class="inicio ancho">
										<tr>
											<td class="titulos" colspan="2" >SELECCIONAR CLASE</td>
											<td class="cerrar" style="width:7%" @click="showModal8 = false">Cerrar</td>
										</tr>
										<tr>
											<td class="tamano01" style="width:3cm">NOMBRE:</td>
											<td><input type="text" class="form-control" placeholder="Buscar por nombre de la clase" v-on:keyup="searchMonitorProducts" v-model="searchProduct.keywordProduct" style="width:100%" /></td>
										</tr>
									</table>
									<table>
										<thead>
											<tr>
												<td class='titulos' style="width:20%; font: 160% sans-serif; ">C&oacute;digo</td>
												<td class='titulos' style="font: 160% sans-serif; ">Nombre</td>
											</tr>
										</thead>
									</table>
									<div style='margin: 0px 5px 5px; border-radius: 0 0 5px 5px; height: 200px; overflow: scroll; overflow-x: hidden; background: white;'>
										<table class='inicio inicio--no-shadow'>
											<tbody>
												<tr v-for="(clase,index) in clases" v-on:click="cargaclase(clase[0],clase[1])"  v-bind:class="index % 2 ? 'saludo1a' : 'saludo2'" style='text-rendering: optimizeLegibility; cursor: pointer !important; style=\"cursor: hand\"'>
													<td style="font: 120% sans-serif; padding-left:10px; width:20%;">{{ clase[0] }}</td>
													<td style="font: 120% sans-serif; padding-left:10px">{{ clase[1] }}</td>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</transition>
				</div>
				<div v-show="showModal9">
					<transition name="modal">
						<div class="modal-mask">
							<div class="modal-wrapper">
								<div class="modal-container">
									<table class="inicio ancho">
										<tr>
											<td class="titulos" colspan="2" >SELECCIONAR SUBCLASE</td>
											<td class="cerrar" style="width:7%" @click="showModal9 = false">Cerrar</td>
										</tr>
										<tr>
											<td class="tamano01" style="width:3cm">NOMBRE:</td>
											<td><input type="text" class="form-control" placeholder="Buscar por nombre de la subclase" v-on:keyup="buscarsubclases" v-model="searchsubclase.keywordsubclase" style="width:100%" /></td>
										</tr>
									</table>
									<table>
										<thead>
											<tr>
												<td class='titulos' style="font: 160% sans-serif; padding-left:10px; border-radius: 5px 0 0 0; width:20%;">C&oacute;digo</td>
												<td class='titulos' style="font: 160% sans-serif; ">Nombre</td>
												<td class='titulos' style="font: 160% sans-serif; width:15%;">CIIU Rev. 4 A.C. </td>
												<td class='titulos' style="font: 160% sans-serif; width:25%;">Sistema Armonizado 2012</td>
												<td class='titulos' style="font: 160% sans-serif; width:10%;">CPC 2 A.C.</td>
											</tr>
										</thead>
									</table>
									<div style='margin: 0px 5px 5px; border-radius: 0 0 5px 5px; height: 200px; overflow: scroll; overflow-x: hidden; background: white;'>
										<table class='inicio inicio--no-shadow'>
											<tbody>
												<tr v-for="(subclase,index) in subClases" v-bind:class="index % 2 ? 'saludo1a' : 'saludo2'" v-on:click="cargasubclase(subclase[0],subclase[1])"  style='text-rendering: optimizeLegibility; cursor: pointer !important; style=\"cursor: hand\"'>
													<td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ subclase[0] }}</td>
													<td width="30%" style="font: 120% sans-serif; padding-left:10px">{{ subclase[1] }}</td>
													<td width="15%" style="font: 120% sans-serif; padding-left:10px">{{ subclase[2] }}</td>
													<td width="25%" style="font: 120% sans-serif; padding-left:10px">{{ subclase[3] }}</td>
													<td width="10%" style="font: 120% sans-serif; padding-left:10px">{{ subclase[4] }}</td>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</transition>
				</div>
				<div v-show="showModal10">
					<transition name="modal">
						<div class="modal-mask">
							<div class="modal-wrapper">
								<div class="modal-container3">
									<table class="inicio ancho">
										<tr>
											<td class="titulos" colspan="2" >SELECCIONAR FUENTE</td>
											<td class="cerrar" style="width:7%" @click="showModal10 = false">Cerrar</td>
										</tr>
										<tr>
											<td class="tamano01" style="width:3cm">NOMBRE:</td>
											<td><input type="text" class="form-control" placeholder="Buscar por nombre de la Fuente" v-on:keyup="searchMonitorfuentes" v-model="searchfuentes.keyword" style="width:100%" /></td>
										</tr>
									</table>
									<table>
										<thead>
											<tr>
												<td class='titulos' style="font: 160% sans-serif; border-radius: 5px 0px 0px 0px; width:10%;">Id fuente</td>
												<td class='titulos' style="font: 160% sans-serif; width:10%;">Entidad financiadora</td>
												<td class='titulos' style="font: 160% sans-serif; border-radius: 0px 5px 0px 0px;">Fuente de financiaci&oacute;n</td>
											</tr>
										</thead>
									</table>
									<div style='margin: 0px 5px 5px; border-radius: 0 0 5px 5px; height: 200px; overflow: scroll; overflow-x: hidden; background: white;'>
										<table class='inicio inicio--no-shadow'>
											<tbody>
												<tr v-for="(result,index) in results" v-on:click="cargafuente(result[2],result[3])"  v-bind:class="index % 2 ? 'saludo1a' : 'saludo2'" style='text-rendering: optimizeLegibility; cursor: pointer !important; style=\"cursor: hand\"'>
													<td width="10%" style="font: 160% sans-serif;">{{ result[2] }}</td>
													<td width="30%" style="font: 160% sans-serif;">{{ result[1] }}</td>
													<td width="60%" style="font: 160% sans-serif;">{{ result[3] }}</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</transition>
				</div>
				<div v-show="showModal11">
					<transition name="modal">
						<div class="modal-mask">
							<div class="modal-wrapper">
								<div class="modal-container3">
									<table class="inicio ancho">
										<tr>
											<td class="titulos" colspan="2" >SELECCIONAR FUENTE</td>
											<td class="cerrar" style="width:7%" @click="showModal11 = false">Cerrar</td>
										</tr>
										<tr>
											<td class="tamano01" style="width:3cm">NOMBRE:</td>
											<td><input type="text" class="form-control" placeholder="Buscar por nombre de la Fuente" v-on:keyup="searchMonitorProducts" v-model="searchProduct.keywordProduct" style="width:100%" /></td>
										</tr>
									</table>
									<table>
										<thead>
											<tr>
												<td width="1%" class='titulos' style="font: 100% sans-serif; border-radius: 5px 0px 0px;">No</td>
												<td width="8%" class='titulos' style="font: 100% sans-serif;">Id entidad</td>
												<td width="8%" class='titulos' style="font: 100% sans-serif;">Nit</td>
												<td width="34%" class='titulos' style="font: 100% sans-serif;">Nombre</td>
												<td width="4%" class='titulos' style="font: 100% sans-serif;">Sector</td>
												<td width="5%" class='titulos' style="font: 100% sans-serif;">Subsector</td>
												<td width="4%" class='titulos' style="font: 100% sans-serif;">Tipo</td>
												<td width="5%" class='titulos' style="font: 100% sans-serif;">Supra regional</td>
												<td width="5%" class='titulos' style="font: 100% sans-serif;">Nivel territorial</td>
												<td width="5%" class='titulos' style="font: 100% sans-serif;">Depto</td>
												<td width="5%" class='titulos' style="font: 100% sans-serif;">Municipio</td>
												<td width="5%" class='titulos' style="font: 100% sans-serif;">Consecutivo</td>
												<td width="15%" class='titulos' style="font: 100% sans-serif; text-align:center; border-radius: 0px 5px 0px 0px;">C&oacute;digo CUIN</td>
											</tr>
										</thead>
									</table>
									<div style='margin: 0px 5px 5px; border-radius: 0 0 5px 5px; height: 200px; overflow: scroll; overflow-x: hidden; background: white;'>
										<table class='inicio inicio--no-shadow'>
											<tbody>
												<tr v-for="(clacuin,index) in codigoscuin" v-on:click="cargacodigocuin(clacuin[2],clacuin[3],clacuin[4],clacuin[13])" v-bind:class="index % 2 ? 'saludo1a' : 'saludo2'" style='text-rendering: optimizeLegibility; cursor: pointer !important; style=\"cursor: hand\"'>
													<td width="1%" style="font: 120% sans-serif;">{{ clacuin[1] }}</td>
													<td width="8%" style="font: 120% sans-serif;">{{ clacuin[2] }}</td>
													<td width="8%" style="font: 120% sans-serif;">{{ clacuin[3] }}</td>
													<td width="34%" style="font: 120% sans-serif;">{{ clacuin[4] }}</td>
													<td width="4%" style="font: 120% sans-serif;">{{ clacuin[5] }}</td>
													<td width="5%" style="font: 120% sans-serif;">{{ clacuin[6] }}</td>
													<td width="4%" style="font: 120% sans-serif;">{{ clacuin[7] }}</td>
													<td width="5%" style="font: 120% sans-serif;">{{ clacuin[8] }}</td>
													<td width="5%" style="font: 120% sans-serif;">{{ clacuin[9] }}</td>
													<td width="5%" style="font: 120% sans-serif;">{{ clacuin[10] }}</td>
													<td width="5%" style="font: 120% sans-serif;">{{ clacuin[11] }}</td>
													<td width="5%" style="font: 120% sans-serif;">{{ clacuin[12] }}</td>
													<td width="10%" style="font: 120% sans-serif;">{{ clacuin[13] }}</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</transition>
				</div>
				<div v-show="showModal12">
					<transition name="modal">
						<div class="modal-mask">
							<div class="modal-wrapper">
								<div class="modal-container2">
									<table class="inicio ancho">
										<tr>
											<td class="titulos" colspan="2" >SELECCIONAR PRODUCTO</td>
											<td class="cerrar" style="width:7%" @click="showModal12 = false">Cerrar</td>
										</tr>
										<tr>
											<td class="tamano01" style="width:3cm">Producto:</td>
											<td><input type="text" class="form-control" placeholder="Buscar por nombre del producto" v-on:keyup="buscarsubproductos" v-model="searchsubproductos.keywordsubproductos" style="width:100%" /></td>
										</tr>
									</table>
									<table>
										<thead>
											<tr>
												<td width="10%" class='titulos' style="font: 160% sans-serif; border-radius: 5px 0 0 0;">C&oacute;digo</td>
												<td width="30%" class='titulos' style="font: 160% sans-serif;">Nombre programa</td>
												<td width="20%" class='titulos' style="font: 160% sans-serif;">Ciiu</td>
												<td width="20%" class='titulos' style="font: 160% sans-serif;">Sistema Armonizado</td>
												<td width="20%" class='titulos' style="font: 160% sans-serif; border-radius: 0 5px 0 0;">CPC</td>
											</tr>
										</thead>
									</table>
									<div style='margin: 0px 5px 5px; border-radius: 0 0 5px 5px; height: 200px; overflow: scroll; overflow-x: hidden; background: white;'>
										<table class='inicio inicio--no-shadow'>
											<tbody>
												<tr v-for="(subprod,index) in subproductos" v-on:click="cargasubproducto(subprod[0],subprod[1])" v-bind:class="index % 2 ? 'saludo1a' : 'saludo2'" style='text-rendering: optimizeLegibility; cursor: pointer !important; style=\"cursor: hand\"'>
													<td width="10%" style="font: 120% sans-serif; padding-left:10px">{{ subprod[0] }}</td>
													<td width="30%" style="font: 120% sans-serif; padding-left:10px">{{ subprod[1] }}</td>
													<td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ subprod[2] }}</td>
													<td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ subprod[3] }}</td>
													<td width="20%" style="font: 120% sans-serif; padding-left:10px">{{ subprod[4] }}</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</transition>
				</div>
			</div>
			<input type="hidden" v-model="idproyecto"/>
		</div>
		<script src="Librerias/vue/vue.min.js"></script>
		<script src="Librerias/vue/axios.min.js"></script>
		<script src="vue/presupuesto_ccp/ccp-bancoproyectos.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
	</body>
</html>