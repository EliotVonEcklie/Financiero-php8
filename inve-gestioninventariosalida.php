<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<?php require "head.php"; ?>
		<title>:: SPID - Almacen</title>
		<script>
			//************* FUNCIONES ************
			function despliegamodal2(_valor,_pag)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else
				{
					switch(_pag)
					{
						case "1":	document.getElementById('ventana2').src="inve-ginventario-documento.php";break;
						case "2":	document.getElementById('ventana2').src="inve-ginventario-reserva.php";break;
						case "3":	document.getElementById('ventana2').src="inve-ginventario-devolucion.php";break;
						case "4":	document.getElementById('ventana2').src="inve-ginventario-reversion.php?tipomov="+document.getElementById('tipomov').value+"&tipoentra="+document.getElementById('tipoentra').value;break;
						case "5":	document.getElementById('ventana2').src="inve-ginventario-articulos.php?bodega="+document.getElementById('salbod').value;break;
						case "6":	document.getElementById('ventana2').src="inve-ginventario-traslados.php?bodega="+document.getElementById('recbod').value;break;
						case "7":	document.getElementById('ventana2').src="inve-ginventario-artdonaciones.php";break;
						case "8":	document.getElementById('ventana2').src="inve-ginventario-articulosaux.php?bodega="+document.getElementById('bodega').value;break;
						case "9":	document.getElementById('ventana2').src="inve-ventana-ajustesalida.php";break;
						case "10":	document.getElementById('ventana2').src="inve-ventana-articulos.php";break;
						case "11":	document.getElementById('ventana2').src="inve-ventana-reserva.php";break;
					}
				}
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta, variable)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden"){
					document.getElementById('ventanam').src="";
					switch(document.getElementById('valfocus').value)
					{
						case "1":	document.getElementById('docum').focus();
									document.getElementById('docum').select();
									break;
					}
					document.getElementById('valfocus').value='0';
				}
				else{
					switch(_tip)
					{
						case "1":	document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
						case "2":	document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
						case "3":	document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
						case "4":	document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
						case "5":	document.getElementById('ventanam').src="ventana-elimina1.php?titulos="+mensa+"&idresp="+pregunta+"&variable="+variable;break;	
					}
				}
			}
			function visualizar(){
				document.form2.action='inve-buscagestioninventario.php';
				document.form2.target='_SELF';
				document.form2.submit(); 
				document.form2.action='';
				document.form2.target='';
			}
			function respuestaconsulta(pregunta, variable)
			{
				switch(pregunta){
					case "1":	
						document.getElementById('oculto').value="2";
						document.form2.submit();
						break;
					case "2":
						document.form2.elimina.value=variable;
						document.form2.sw.value=document.getElementById('tipomov').value ;
						document.form2.submit();
						break;
				}
			}
			function funcionmensaje(){document.location.href="inve-editagestioninventario.php?is="+document.form2.numero.value+"&mov="+document.getElementById('tipomov').value+"&ent="+document.form2.tipoentra.value;}
			function guiabuscar(_opc)
			{
				if(_opc==1)
				{
					if(document.getElementById('docum').value!=""){
						document.getElementById('busqueda').value='1';
					}
					else{
						document.getElementById('busqueda').value='';
					}
				}
				if(_opc==2)
				{
					if(document.getElementById('docum').value!=""){
						document.getElementById('busqueda').value='2';
					}
					else{
						document.getElementById('busqueda').value='';
					}
				}
				if(_opc==3)
				{
					if(document.getElementById('docum').value!=""){
						document.getElementById('busqueda').value='3';
					}
					else{
						document.getElementById('busqueda').value='';
					}
				}
				if(_opc==4)
				{
					if(document.getElementById('docum').value!=""){
						document.getElementById('busqueda').value='4';
					}
					else{
						document.getElementById('busqueda').value='';
					}
				}
				if(_opc==6)
				{
					if(document.getElementById('docum').value!=""){
						document.getElementById('busqueda').value='6';
					}
					else{
						document.getElementById('busqueda').value='';
					}
				}
				document.form2.submit();
			}
			function buscarDocum(codoc, nomdoc, coduns, numcan, vtotal, valunit)
			{
				document.getElementById('docum').value=codoc;
				document.getElementById('ndocum').value=nomdoc;
				document.getElementById('codiun').value=coduns;
				document.getElementById('numcan').value=numcan;
				document.getElementById('vtotal').value=vtotal;
				document.getElementById('valunitp').value=valunit;
				vartdoc(1);
			}
			function buscarReserva(opc1,opc2,opc3)
			{
				document.getElementById('docum').value=opc1;	
				document.getElementById('ndocum').value=opc2+' - '+opc3;
				vartdoc(2);
			}
			function buscarDevolucion(codoc, nomdoc, coduns, numcan, vtotal, valunit)
			{
				document.getElementById('docum').value=codoc;
				document.getElementById('ndocum').value=nomdoc;
				document.getElementById('codiun').value=coduns;
				document.getElementById('numcan').value=numcan;
				document.getElementById('vtotal').value=vtotal;
				document.getElementById('valunitp').value=valunit;
				vartdoc(3);
			}
			function buscarReversion(codrev, nombre)
			{
				document.getElementById('docum').value=codrev;
				document.getElementById('ndocum').value=nombre;
				vartdoc(4);
			}
			function validar(){document.form2.submit();}
			function validar2(pos){
				document.getElementById('cont['+pos+']').value = 1;
				document.form2.submit();
			}
			function validarAux(pos){
				var factor = document.getElementById("factor[" + pos + ']').value;
				//alert(factor);
				document.getElementById('vmed['+pos+']').value=document.getElementById('saler['+pos+']').value/factor;
				document.getElementById('saler['+pos+']').value=document.getElementById('vmed['+pos+']').value*factor;
			}

			function cambioCheck(pos,e){
				var check = document.getElementById("reservasal[" + pos + "]");
				//alert("Checked: " + check.checked);
				if(e.checked){
					check.checked = true;	
				}else{
					check.checked = false;
				}
				//alert(e.checked); 
			}

			function reiniciar() {
			    var x = document.getElementsByClassName("cont");
			    var i;
			    for (i = 0; i < x.length; i++) {
			        x[i].value = 0;
			    }
			}
			function vartdoc(opc)
			{
				switch(opc)
				{
					case 1:
						document.form2.verart.value=1;
						document.form2.sw.value=document.getElementById('tipomov').value ;
						document.form2.submit();
					break;
					case 2:
						document.form2.verart.value=2;
						document.form2.sw.value=document.getElementById('tipomov').value ;
						document.form2.submit();
					break;
					case 3:
						document.form2.verart.value=3;
						document.form2.sw.value=document.getElementById('tipomov').value ;
						document.form2.submit();
					break;
					case 4:
						document.form2.verart.value=4;
						document.form2.sw.value=document.getElementById('tipomov').value ;
						document.form2.submit();
					break;
					case 5:
						document.form2.verart.value=5;
						document.form2.sw.value=document.getElementById('tipomov').value ;
						document.form2.submit();
					break;
				}
			}
			//*************** DETALLE ENTRADA COMPRA  ************************
			function agregardetalle(pos)
			{
				var validacion01=document.getElementById('tipomov').value;
				var validacion02=document.getElementById('tipoentra').value;
				var validacion03=document.getElementById('codinar['+pos+']').value;
				var validacion04=document.getElementById('docum').value;
				var validacion05=document.getElementById('ingresa['+pos+']').value;
				var validacion06=document.getElementById('bodega['+pos+']').value;
				if(validacion01!='-1' && validacion02!='-1' && validacion03!='-1' && validacion04.trim()!='' && validacion05.trim()!='' && validacion06!='-1')
				{
					document.form2.unsart.value=document.getElementById('coduns['+pos+']').value;
					document.form2.codart.value=document.getElementById('codinar['+pos+']').value;
					document.form2.cantart.value=document.getElementById('ingresa['+pos+']').value;
					document.form2.numart.value=document.getElementById('cantidad['+pos+']').value;
					document.form2.uniart.value=document.getElementById('valunit['+pos+']').value;
					document.form2.umedida.value=document.getElementById('unimed['+pos+']').value;
					document.form2.codbod.value=document.getElementById('bodega['+pos+']').value;
					document.form2.agregadet.value=1;
					//document.form2.busqueda.value=1;
					document.form2.submit();
				}
				else {despliegamodalm('visible','2','Faltan datos para completar el registro');}
			}
			function eliminar(variable){despliegamodalm('visible','5','Esta Seguro de Eliminar','2',variable);}
			//*************** DETALLE ENTRADA DONACIONES ************************
			function agregardetdonacion()
			{
				var validacion01=document.getElementById('tipomov').value;
				var validacion02=document.getElementById('tipoentra').value;
				var validacion03=document.getElementById('bodega').value;
				var validacion04=document.getElementById('numdona').value;
				if(validacion01!='-1' && validacion02!='-1' && validacion03!='-1' && validacion04.trim()!='')
				{
					document.form2.codart.value=document.getElementById('articulo').value;
					document.form2.cantart.value=document.getElementById('numdona').value;
					document.form2.numart.value=document.getElementById('numdona').value;
					document.form2.nomart.value=document.getElementById('narticulo').value;
					document.form2.umedida.value=document.getElementById('unimed').value;
					document.form2.codbod.value=document.getElementById('bodega').value;
					document.form2.nombod.value=document.form2.bodega.options[document.form2.bodega.selectedIndex].text;
					document.form2.agregadet.value=1;
					document.form2.submit();
				}
				else {despliegamodalm('visible','2','Faltan datos para completar el registro');}
			}
			//*************** DETALLE ENTRADA TRASLADOS ************************
			function agregarenttraslado(pos)
			{
				var validacion01=document.getElementById('tipomov').value;
				var validacion02=document.getElementById('tipoentra').value;
				var validacion03=document.getElementById('recbod').value;
				var validacion04=document.getElementById('docum').value;
				if(validacion01!='-1' && validacion02!='-1' && validacion03!='-1' && validacion04.trim()!='')
				{
					document.form2.unsart.value=document.getElementById('coduns['+pos+']').value;
					document.form2.codart.value=document.getElementById('codinar['+pos+']').value;
					document.form2.cantart.value=document.getElementById('cantidad['+pos+']').value;
					document.form2.numart.value=document.getElementById('cantidad['+pos+']').value;
					document.form2.nomart.value=document.getElementById('narticulo['+pos+']').value;
					document.form2.umedida.value=document.getElementById('unimed['+pos+']').value;
					document.form2.codbod.value=document.getElementById('recbod').value;
					document.form2.nombod.value=document.form2.recbod.options[document.form2.recbod.selectedIndex].text;
					document.form2.codbod2.value=document.getElementById('bodega2['+pos+']').value;
					document.form2.agregadet.value=1;
					//document.form2.busqueda.value=1;
					document.form2.submit();
				}
				else {despliegamodalm('visible','2','Faltan datos para completar el registro');}
			}
			//*************** DETALLE ENTRADA AJUSTES ************************
			function agregardetentajuste()
			{
				var validacion01=document.getElementById('tipomov').value;
				var validacion02=document.getElementById('tipoentra').value;
				var validacion03=document.getElementById('bodega').value;
				var validacion04=document.getElementById('numdona').value;
				if(validacion01!='-1' && validacion02!='-1' && validacion03!='-1' && validacion04.trim()!='')
				{
					document.form2.codart.value=document.getElementById('articulo').value;
					document.form2.cantart.value=document.getElementById('numdona').value;
					document.form2.numart.value=document.getElementById('numdona').value;
					document.form2.nomart.value=document.getElementById('narticulo').value;
					document.form2.umedida.value=document.getElementById('unimed').value;
					document.form2.codbod.value=document.getElementById('bodega').value;
					document.form2.nombod.value=document.form2.bodega.options[document.form2.bodega.selectedIndex].text;
					document.form2.agregadet.value=1;
					document.form2.submit();
				}
				else {despliegamodalm('visible','2','Faltan datos para completar el registro');}
			}
			//*************** DETALLE SALIDA RESERVA ************************
			function agregardetreserva()
			{
				var cantidad= document.getElementById("cantidadArticulosTotal").value;
				var noCompleto = false;
				var existeSalidaCero = false;
				for(var i = 0; i < cantidad; i++){
					var validacion04=document.getElementById('saler['+i+']').value;
					var validacion05=document.getElementById('bodega['+i+']').value;
					var validacion06=parseInt(document.getElementById('saler['+i+']').value);
					var check = document.getElementById("reservasal[" + i + "]");
					if( !(validacion04.trim()!='' && validacion05!='-1' && check.checked)){
						noCompleto = true;
					}
					if(validacion06 == 0 && check.checked){
						existeSalidaCero = true;
					}
				}
				var validacion01=document.getElementById('tipomov').value;
				var validacion02=document.getElementById('tipoentra').value;
				var validacion03=document.getElementById('docum').value;
				if(validacion01!='-1' && validacion02!='-1' && validacion03.trim()!='' && !noCompleto)
				{
					if(!existeSalidaCero){
						document.form2.agregadet.value=1;
						document.form2.submit();
					}else {despliegamodalm('visible','2','La cantidad de productos en salida deben ser mayor a cero');}
				}
				else {despliegamodalm('visible','2','Faltan datos para completar el registro');}
			}
			
			function agregardettraslado(opc)//*************** DETALLE SALIDA TRASLADOS ************************
			{
				if(opc == "1"){
					var validacion01=document.getElementById('tipomov').value;
					var validacion02=document.getElementById('tipoentra').value;
					var validacion03=document.getElementById('articulo').value;
					var validacion04=document.getElementById('narticulo').value;
					var validacion05=document.getElementById('bodega').value;
					var validacion06=document.getElementById('umedida').value;
					var validacion07=document.getElementById('bodeganu').value;
					var validacion08 = document.getElementById('cantbodtras').value;
					var validacion09 = document.getElementById('valunit').value;
					
					if(validacion01!='-1' && validacion02!='-1' && validacion03.trim()!='' && validacion04.trim()!='' && validacion05.trim()!='' && validacion06.trim()!='' && validacion07!='-1' && validacion08!='' && validacion09!=''){
						if(parseFloat(validacion09)>0){
							var cantidadactual = parseInt(document.getElementById('cantbodact').value);
							var cantidadtrasladar = parseInt(document.getElementById('cantbodtras').value);
							if(cantidadactual>=cantidadtrasladar){
								var bodegaact = document.getElementById('bodega').value;
								var bodegatras = document.getElementById('bodeganu').value;
								if(bodegaact!=bodegatras){
									document.form2.codart.value=document.getElementById('articulo').value;
									document.form2.cantart.value=document.getElementById('cantbodtras').value;
									document.form2.numart.value=document.getElementById('cantbodact').value;
									document.form2.nomart.value=document.getElementById('narticulo').value;
									document.form2.umedida.value=document.getElementById('umedida').value;
									document.form2.codbod.value=document.getElementById('bodega').value;
									document.form2.nombod.value=document.getElementById('nbodega').value;
									document.form2.codbod2.value=document.getElementById('bodeganu').value;
									document.form2.nombod2.value=document.getElementById('nbodeganu').value;
									document.form2.agregadet.value=1;
									document.form2.submit();
								}else{
									despliegamodalm('visible','2','La bodega destino no puede ser igual a la bodega origen');
								}
								
							}else{
								despliegamodalm('visible','2','La cantidad a trasladar no puede exceder la cantidad en inventario');
							}
						}else{
							despliegamodalm('visible','2','El valor unitario no puede ser cero');
						}
					}
					else {despliegamodalm('visible','2','Faltan datos para completar el registro');}
				}else{
					
					var validacion01=document.getElementById('tipomov').value;
					var validacion02=document.getElementById('tipoentra').value;
					var validacion03=document.getElementById('articulo').value;
					var validacion04=document.getElementById('narticulo').value;
					var validacion05=document.getElementById('centrocosto').value;
					var validacion06=document.getElementById('umedida').value;
					var validacion07=document.getElementById('centrocostonu').value;
					var validacion08 = document.getElementById('cantcctras').value;
					var validacion09 = document.getElementById('valunitcc').value;
					
					if(validacion01!='-1' && validacion02!='-1' && validacion03.trim()!='' && validacion04.trim()!='' && validacion05.trim()!='' && validacion06.trim()!='' && validacion07!='-1' && validacion08!='' && validacion09!=''){
						if(parseFloat(validacion09)>0){
							var cantidadactual = parseInt(document.getElementById('cantccact').value);
							var cantidadtrasladar = parseInt(document.getElementById('cantcctras').value);
							if(cantidadactual>=cantidadtrasladar){
								var ccact = document.getElementById('centrocosto').value;
								var cctras = document.getElementById('centrocostonu').value;
								if(ccact!=cctras){
									var saldo = parseInt(document.getElementById('saldocc').value);
									if(saldo>=0){
										document.form2.agregadet2.value=1;
										document.form2.submit();
									}else{
										despliegamodalm('visible','2','No puede exceder el total de este producto en inventario');
									}
									
								}else{
									despliegamodalm('visible','2','El centro de costo destino no puede ser igual al de origen');
								}
								
							}else{
								despliegamodalm('visible','2','La cantidad a trasladar no puede exceder la cantidad en inventario');
							}
						}else{
							despliegamodalm('visible','2','El valor unitario no puede ser cero');
						}
						
						
					}
					else {despliegamodalm('visible','2','Faltan datos para completar el registro');}
					
				}

				
			}
			//*************** DETALLE SALIDA DIRECTA
			function agregararticulo(){
				var articulo = document.getElementById("codigoarticulo").value;
				var cantidadSalida = parseInt(document.getElementById("cbodegasalida").value);
				var bodega = document.getElementById("bodega").value;
				var um = document.getElementById("unidadmedidaart").value;
				var cantidadBodega = parseInt(document.getElementById("cbodega").value);
				var cc = document.getElementById("cc").value;
				var cuentacont = document.getElementById("cuenta").value;
				if(articulo && cantidadSalida > 0 && bodega!="-1" && um!="-1" && cc!="" && cuentacont!=""){
					if(cantidadBodega>=cantidadSalida){
						document.form2.agregadet.value=1;
						document.form2.codbod.value=bodega;
						document.form2.submit();
					}else{
						despliegamodalm('visible','2','La cantidad de articulos que salen no puede ser mayor que la cantidad en existencia');
					}
					
				}else{
					despliegamodalm('visible','2','Faltan datos para completar el registro');
				}
			}
			//*************** DETALLE SALIDA DEVOLUCION ************************
			function agregardetdevolucion(pos)
			{
				var validacion01=document.getElementById('tipomov').value;
				var validacion02=document.getElementById('tipoentra').value;
				var validacion03=document.getElementById('docum').value;
				var validacion04=document.getElementById('saler['+pos+']').value;
				if(validacion01!='-1' && validacion02!='-1' && validacion03.trim()!='' && validacion04.trim()!='')
				{
					document.form2.unsart.value=document.getElementById('codunsr['+pos+']').value;
					document.form2.codart.value=document.getElementById('codartr['+pos+']').value;
					document.form2.cantart.value=document.getElementById('saler['+pos+']').value;
					document.form2.numart.value=document.getElementById('cantidadr['+pos+']').value;
					document.form2.nomart.value=document.getElementById('nomartr['+pos+']').value;
					document.form2.umedida.value=document.getElementById('unimed['+pos+']').value;
					document.form2.codbod.value=document.getElementById('codbodega['+pos+']').value;
					document.form2.nombod.value=document.getElementById('nombodega['+pos+']').value;
					document.form2.agregadet.value=1;
					//document.form2.busqueda.value=1;
					document.form2.submit();
				}
				else {despliegamodalm('visible','2','Faltan datos para completar el registro');}
			}
			//*************** DETALLE REVERSION ************************
			function agregardetreversion(pos)
			{
				var validacion01=document.getElementById('tipomov').value;
				var validacion02=document.getElementById('tipoentra').value;
				var validacion03=document.getElementById('docum').value;
				if(validacion01!='-1' && validacion02!='-1' && validacion03.trim()!='')
				{
					document.form2.unsart.value=document.getElementById('codunsr['+pos+']').value;
					document.form2.codart.value=document.getElementById('codartr['+pos+']').value;
					document.form2.cantart.value=document.getElementById('cantidadr['+pos+']').value;
					document.form2.numart.value=document.getElementById('cantidadr['+pos+']').value;
					document.form2.nomart.value=document.getElementById('nomartr['+pos+']').value;
					document.form2.umedida.value=document.getElementById('unimed['+pos+']').value;
					document.form2.codbod.value=document.getElementById('codbodega['+pos+']').value;
					document.form2.nombod.value=document.getElementById('nombodega['+pos+']').value;
					document.form2.coddetalle.value=document.getElementById('coddet['+pos+']').value;
					document.form2.agregadet.value=1;
					//document.form2.busqueda.value=1;
					document.form2.submit();
				}
				else {despliegamodalm('visible','2','Faltan datos para completar el registro');}
			}

			//*************** DETALLE SALIDA DETERIORO O BAJA ************************
			function agregardetbaja()
			{
				var validacion01=document.getElementById('tipomov').value;
				var validacion02=document.getElementById('tipoentra').value;
				var validacion03=document.getElementById('salbod').value;
				var validacion04=document.getElementById('traslado').value;
				if(validacion01!='-1' && validacion02!='-1' && validacion03!='-1' && validacion04.trim()!='')
				{
					document.form2.codart.value=document.getElementById('articulo').value;
					document.form2.cantart.value=document.getElementById('traslado').value;
					document.form2.numart.value=document.getElementById('dispo').value;
					document.form2.nomart.value=document.getElementById('narticulo').value;
					document.form2.umedida.value=document.getElementById('unimed').value;
					document.form2.codbod.value=document.getElementById('salbod').value;
					document.form2.nombod.value=document.form2.salbod.options[document.form2.salbod.selectedIndex].text;
					document.form2.agregadet.value=1;
					//document.form2.busqueda.value=1;
					document.form2.submit();
				}
				else {despliegamodalm('visible','2','Faltan datos para completar el registro');}
			}
			function validar_bodega()
			{
				document.form2.nombod.value=document.form2.salbod.options[document.form2.salbod.selectedIndex].text;
				document.form2.articulo.value='';
				document.form2.narticulo.value='';
				document.form2.dispo.value='';
				document.form2.traslado.value='';
				document.form2.submit();
			}
			function eliminares(variable){despliegamodalm('visible','5','Esta Seguro de Eliminar','2',variable);}
			//************* guardar ************
			function guardar()
			{
				var validacion01=document.getElementById('tipomov').value;
				var validacion02=document.getElementById('tipoentra').value;
				var validacion04=document.getElementById('nombre').value;
				var id='';
				if(document.getElementById("codunsd")){
					id= document.getElementById('codunsd').value;
				}
				console.log(id);
				//if(validacion01!='-1' && validacion02!='-1' && validacion03.trim()!='' && validacion04.trim()!='')
				if(validacion01!='-1' && validacion02!='-1' && validacion04.trim()!='' )
				{despliegamodalm('visible','4','Esta Seguro de Guardar','1','0');}
				else
				{
					document.form2.numero.focus();
					document.form2.numero.select();
					despliegamodalm('visible','2','Faltan Datos para Completar el Registro');
				}
			}
			//***************************************
			function pdf()
			{
				document.form2.action="pdfinventcompra.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function verep(idfac){document.form1.oculto.value=idfac;document.form1.submit();}
			function swtch()
			{
				//alert("Balance Descuadrado");
				document.form2.sw.value=document.getElementById('tipomov').value ;
				document.form2.submit();
			}
			function agregardetajuste(pos){
				
				document.getElementById("posAjuste").value = pos;
				var validacion01=document.getElementById('tipomov').value;
				var validacion02=document.getElementById('tipoentra').value;
				
				var validacion03=document.getElementsByName('bodega[]');
				var validacion04=document.getElementsByName('numarti[]');
				var validacion06=document.getElementsByName('unimed[]');
				var validacion07=document.getElementsByName('articulo[]');
				var validacion08=document.getElementsByName('narticulo[]');
				var validacion09=document.getElementsByName('valorunitario[]');
				var validacion10=document.getElementById('valor').value;
				var validacion11=document.getElementsByName('saldo[]');
				
				if(validacion01!='-1' && validacion02!='-1' && validacion03.item(pos).value!='-1' && validacion04.item(pos).value.trim()!='' && validacion06.item(pos).value!='' && validacion07.item(pos).value!='' && validacion08.item(pos).value!='' && validacion09.item(pos).value!='' && validacion10!='')
				{
					
					document.form2.codart.value=validacion07.item(pos).value;
					document.form2.cantart.value=validacion04.item(pos).value;
					document.form2.numart.value=validacion04.item(pos).value;
					document.form2.nomart.value=validacion08.item(pos).value;
					document.form2.umedida.value=validacion06.item(pos).value;
					document.form2.codbod.value=validacion03.item(pos).value;
					if(parseInt(validacion04.item(pos).value.trim())<= 0){
						despliegamodalm('visible','2','La cantidad de productos no puede ser menor o igual a cero');
					}else{
						if(parseFloat(validacion09.item(pos).value)<=0){
							despliegamodalm('visible','2','El valor unitario no puede ser menor o igual a cero');
						}else{
							var arreglototal = document.getElementsByName("valortotal1[]");
							var total = 0;
							for(var i=0;i < arreglototal.length; i++){
								total+=parseFloat(arreglototal.item(i).value);
							}
							total+= parseFloat(validacion09.item(pos).value)*parseInt(validacion04.item(pos).value.trim());
							
							if(parseFloat(validacion10)< total){
								despliegamodalm('visible','2','El valor total no puede ser menor o igual al autorizado');
							}else{
								var numarti = parseInt(validacion04.item(pos).value.trim());
								var saldo = parseInt(validacion11.item(pos).value.trim());
								if(numarti<=saldo){
									document.getElementsByName('saldo[]').item(pos).value = saldo - numarti;
									document.getElementsByName('numarti[]').item(pos).value=0;
									document.form2.agregadet.value=1;
									document.form2.submit();
								}else{
									despliegamodalm('visible','2','La cantidad de articulos no puede superar el autorizado');
								}
								
							}
						}
					}
					
				}
				else {despliegamodalm('visible','2','Faltan datos para completar el registro');}
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
    		<tr><script>barra_imagenes("inve");</script><?php cuadro_titulos();?></tr>	 
    		<tr><?php menu_desplegable("inve");?></tr>
   			<tr>
  				<td colspan="3" class="cinta">
					<a class="tooltip bottom mgbt" onClick="location.href='inve-gestioninventariosalida.php'"><img src="imagenes/add.png"/><span class="tiptext">Nuevo</span></a>
					<a class="tooltip bottom mgbt" onClick="guardar()"><img src="imagenes/guarda.png"/><span class="tiptext">Guardar</span></a>
					<a class="tooltip bottom mgbt" onClick="visualizar()"><img src="imagenes/busca.png"/><span class="tiptext">Buscar</span></a>
					<a class="tooltip bottom mgbt" onClick="mypop=window.open('inve-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" /><span class="tiptext">Nueva ventana</span></a>
					<a class="tooltip bottom mgbt" onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()"><img src="imagenes/agenda1.png"/><span class="tiptext">Agenda</span></a>
					<a class="tooltip bottom mgbt" onClick="mypop=window.open('<?php echo $url2; ?>','','');mypop.focus();"><img src="imagenes/duplicar_pantalla.png"><span class="tiptext">Duplicar pestaña</span></a>
					<?php
						if($_POST[numero]!="")
							echo'<a onClick="pdf()" class="tooltip bottom mgbt"><img src="imagenes/print.png"/><span class="tiptext">Imprimir</span></a>';
					?>
					<a class="tooltip bottom mgbt" onClick="location.href='inve-menuinventario.php'"><img src="imagenes/iratras.png" /><span class="tiptext">Atrás</span></a>
				</td>
			</tr>
      	</table>
		<?php
			$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
			$nomuser=$_SESSION[usuario];
			$vigencia=$vigusu;
		?>	
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>		  
		<form name="form2" method="post" action=""> 
			<input type="hidden"  name="limpiar"  id="limpiar" value="<?php echo $_POST[limpiar]?>"/>
            <input type="hidden" value="<?php echo $_POST[oculto]?>" name="oculto"  id="oculto">	
            <input type="hidden" name="valfocus" id="valfocus" value="0"/>
            <input type='hidden' name='unsart' id='unsart' value="<?php echo $_POST[unsart]?>" > 
            <input type='hidden' name='cantart' id='cantart' value="<?php echo $_POST[cantart]?>" > 
            <input type='hidden' name='uniart' id='uniart' value="<?php echo $_POST[uniart]?>" > 
            <input type='hidden' name='umedida' id='umedida' value="<?php echo $_POST[umedida]?>" > 
            <input type='hidden' name='umd' id='umd' value="<?php echo $_POST[umd]?>" >
            <input type='hidden' name='coddetalle' id='coddetalle' value="<?php echo $_POST[coddetalle]?>"/> 
            <input type='hidden' name='numart' id='numart' value="<?php echo $_POST[numart]?>" > 
            <input type='hidden' name='nomart' id='nomart' value="<?php echo $_POST[nomart]?>" > 
            <input type='hidden' name='codbod' id='codbod' value="<?php echo $_POST[codbod]?>" > 
            <input type='hidden' name='codbod2' id='codbod2' value="<?php echo $_POST[codbod2]?>" > 
            <input type='hidden' name='codart' id='codart' value="<?php echo $_POST[codart]?>" > 
            <input type='hidden' name='grupo' id='grupo' value="<?php echo $_POST[grupo]?>" > 
            <input type='hidden' name='hddent' id='hddent' value="<?php echo $_POST[hddent]?>" > 
   			<?php
   				if (!isset($_POST[oculto])) {
   					$_POST[fecha]=date('d/m/Y');
   					$_POST[tipomov]='2';
   				}
				if($_POST[tipomov]!=-1&&$_POST[tipoentra]!=-1&&$_POST[tipomov]!=""&&$_POST[tipoentra]!="")
				{
					$sql="SELECT consec FROM almginventario WHERE tipomov='$_POST[tipomov]' AND tiporeg='$_POST[tipoentra]' ORDER BY consec DESC";
					$res=mysql_query($sql);
					if(mysql_num_rows($res)!=0){$winv=mysql_fetch_array($res);$codinv=$winv[0]+1;}
					else{$codinv=1;}
					$_POST[numero]=$codinv;
				}
			?>
			<table class="inicio ancho" align="center" >
    			<tr >
        			<td class="titulos" colspan="8" width="100%">.: Gesti&oacute;n de Inventarios </td>
	        		<td class="boton02" onclick="location.href='inve-principal.php'">Cerrar</td>
    			</tr>
      			<tr>
					<td class="saludo1" width="5%" style="font-weight: bold">Consecutivo:</td>
          			<td valign="middle"  width="4%">
                        <input type='hidden' name='nombod' id='nombod' value="<?php echo $_POST[nombod]?>" > 
                        <input type='hidden' value='<?php echo $_POST[agregadet] ?>' id='agregadet' name='agregadet'>
                        <input type="hidden" value="<?php echo $_POST[verart]?>" name="verart" id="verart">	
                        <input type="hidden" name="busqueda" id="busqueda" value="<?php echo $_POST[busqueda]?>"> 
            			<input type="text" id="numero" name="numero"  style="width:100%; text-align:center" value="<?php echo $_POST[numero] ?>" readonly>
         			</td>
          			<td class="saludo1" style="width:7%;font-weight: bold"  >Fecha Registro:</td>
          			<td style="width:9%"><input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)" maxlength="10" style="width: 70%">&nbsp;<img src="imagenes/calendario04.png" style="width:20px; cursor:pointer;" title="Calendario"  onClick="displayCalendarFor('fc_1198971545');" class="icobut"/><input type="hidden" name="chacuerdo" value="1"></td>
		 			<td class="saludo1" width="6%" style="font-weight: bold">Descripci&oacute;n:</td>
          			<td valign="middle"  width="40%"><input type="text" id="nombre" name="nombre" style="width:100%;" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[nombre]?>"/></td>
	   				<td class="saludo1" width="10%" style="font-weight: bold">Tipo de Movimiento: </td>
          			<td colspan="1"  valign="middle"  width="8%">
                        <select name="tipomov" id="tipomov" onChange="validar()"  style="width:100%;" >
                            <option value="-1">Seleccione ....</option>
                            <option value="2" <?php if($_POST[tipomov]=='2') echo "SELECTED"; ?>>1 - Salida</option>
                            <option value="4" <?php if($_POST[tipomov]=='4') echo "SELECTED"; ?>>2 - Reversi&oacute;n de Salida</option>
                        </select>
            			<input type="hidden" name="sw"  id="sw" value="<?php echo $_POST[tipomov] ?>" />
       				</td>
	   				<td width="7%"></td>
       			</tr>
  			</table>	
			<!--INICIO TIPO MOV 2 SALIDA-->
			<?php 
			ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
			$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
			
			if($_POST[tipomov]==2 || $_POST[tipomov]=="" || $_POST[tipomov]==-1)
			{
				echo"
					<table class='inicio ancho'>
						<tr><td colspan='12' class='titulos2'>Gesti&oacute;n Inventario - Salida</td></tr>
						<tr>
							<td class='saludo1' style='width:8%;'>Tipo Salida</td>
							<td style='width:5%;'>
    	   						<select name='tipoentra' id='tipoentra' onChange='validar()'>
									<option value='-1'>Seleccione ....</option>";
						
				$sqlr="Select * from almtipomov where tipom='$_POST[tipomov]' AND estado='S' ORDER BY tipom, codigo";
				$resp = mysql_query($sqlr,$linkbd);
				while($row =mysql_fetch_row($resp)) 
				{
					if($row[0]==$_POST[tipoentra])
					{
						echo "<option value='$row[0]' SELECTED >$row[1]$row[0] - $row[2]</option>";
						$_POST[tipoentra]=$row[0];
					}
					else{echo "<option value='$row[0]'>$row[1]$row[0] - $row[2]</option>";}
			     }   
				echo"	
		  						</select>
								<input type='hidden' name='ntipoentra' id='ntipoentra' value='$_POST[ntipoentra]'/> 
        					</td>";
			
				switch($_POST[tipoentra])
				{
					case -1: 
						echo"<td style='width:6%;'></td><td style='width:12%;'></td><td style='width:50%;'></td></tr>";
					break;
					case "": 
						echo"<td style='width:6%;'></td><td style='width:12%;'></td><td style='width:50%;'></td></tr>";
					break;
					case 0://SALIDA POR DEVOLUCIONES
					{
						echo"
							<td class='saludo1' style='width:6%;'>Documento</td>
							<td style='width:12%;'>
								<input type='hidden' id='codiun' name='codiun' value='$_POST[codiun]'/>
								<input type='hidden' id='numcan' name='numcan'  value='$_POST[numcan]'/>
								<input type='hidden' id='valunitp' name='valunitp' value='$_POST[valunitp]'/>
								<input type='hidden' id='vtotal' name='vtotal' value='$_POST[vtotal]'/>
								<input type='text' id='docum' name='docum' value='$_POST[docum]' onKeyPress='javascript:return solonumeros(event)' onKeyUp='return tabular(event,this)' onBlur=\"guiabuscar('3');\" style='width:80%'/>&nbsp;<img src='imagenes/find02.png' onClick=\"despliegamodal2('visible','3');\" class='icobut'/>
							</td>
							<td style='width:50%;'><input type='text' name='ndocum' id='ndocum' value='$_POST[ndocum]' style='width:100%; text-transform:uppercase' readonly/></td>
						</tr>
					</table>
					<div class='subpantalla'  style='height:62%; width:99.8%; overflow-x:hidden;'>
						<div class='subpantallac' style='height:47%; overflow-x:hidden;'>";
						//BUSQUEDA
						if($_POST[busqueda]!="")
						{
							if($_POST[busqueda]=="3")
							{
								$nresul=buscasoladquisicion($_POST[docum]);
								if(count($nresul)>0)
								{
									echo"
									<script>
										document.form2.busqueda.value=0;
										buscarDevolucion('$nresul[2]','$nresul[1]','$nresul[0]','$nresul[3]','$nresul[4]','$nresul[5]');
									</script>";
								}
								else
								{
									echo"
									<script>
										document.getElementById('valfocus').value='1';
										despliegamodalm('visible','2','Código del Documento Incorrecto');
									</script>";
								}
							}
						}	//FIN BUSQUEDA	
						if ($_POST[verart]==3)
						{
							$pos=0;
							$sqlg="SELECT * FROM almginventario WHERE CONCAT(tipomov,tiporeg)='$_POST[hddent]' AND consec='$_POST[docum]'";
							$gres=mysql_query($sqlg,$linkbd);
							if(mysql_num_rows($gres)!=0)
							{
								$grow=mysql_fetch_array($gres);
								$pos=0;
								echo "
							<table class='inicio'>";
								$sqlr="SELECT almginventario_det.unspsc, almginventario_det.codart, almarticulos.nombre, almginventario_det.cantidad, almginventario_det.unidad, almginventario_det.bodega, almbodegas.nombre FROM (almginventario_det INNER JOIN almarticulos ON almginventario_det.codart=CONCAT(almarticulos.grupoinven,almarticulos.codigo)) INNER JOIN almbodegas ON almginventario_det.bodega=almbodegas.id_cc WHERE almginventario_det.codigo='$grow[9]' AND almginventario_det.tipomov='$grow[2]' ORDER BY almginventario_det.codart, almginventario_det.bodega";
										$res=mysql_query($sqlr,$linkbd);
										while($wres=mysql_fetch_array($res)){
											echo"<tr>
												<td class='saludo1' style='width:5%'>UNSPSC:</td> 
												<td style='width:7%'>
													<input type='text' id='codunsr[".$pos."]' name='codunsr[".$pos."]' onKeyUp='return tabular(event,this)' value='$wres[0]' readonly=readonly style='width:100%;' >
												</td>
												<td class='saludo1' style='width:5%'>Codigo:</td>
												<td colspan='1' style='width:7%'>
													<input type='text' id='codartr[".$pos."]' name='codartr[".$pos."]' onKeyUp='return tabular(event,this)' value='$wres[1]' readonly=readonly style='width:100%;' >
												</td>
												<td class='saludo1' style='width:10%'>Nombre Articulo:</td>
												<td colspan='1' width='18%'>
													<input type='text' id='nomartr[".$pos."]' name='nomartr[".$pos."]' onKeyUp='return tabular(event,this)' value='$wres[2]' readonly=readonly style='width:100%;' >
												</td>
												<td class='saludo1' style='width:4%'>Cantidad </td>
												<td style='width:4%'>
													<input name='cantidadr[".$pos."]' id='cantidadr[".$pos."]' type='text' value='".number_format($wres[3],0,',','.')."' onKeyPress='javascript:return solonumeros(event)' onKeyUp='return tabular(event,this)' style='text-align:center; width:100%;' readonly >
												</td>
												<td class='saludo1' style='width:2%'>U.M:</td>
												<td colspan='1' width='5%'>
													<select name='unimed[".$pos."]' id='unimed[".$pos."]'>";
														$sqlu="SELECT unidad FROM almarticulos_det WHERE articulo='$wres[1]'";
														$resu=mysql_query($sqlu,$linkbd);
														while($wuni=mysql_fetch_array($resu)){
															echo"<option value='".$wuni[0]."'>".$wuni[0]."</option>";
														}
												echo"</select>
												</td>
												<td class='saludo1' style='width:4%'>Bodega:</td>
												<td colspan='1' style='width:15%'>
													<input type='text' id='nombodega[".$pos."]' name='nombodega[".$pos."]' onKeyUp='return tabular(event,this)' value='$wres[6]' readonly=readonly style='width:100%;' >
													<input type='hidden' id='codbodega[".$pos."]' name='codbodega[".$pos."]' value='$wres[5]' >
												</td>
												<td class='saludo1' style='width:5%'>Devoluci&oacute;n: </td>
												<td style='width:4%'>  
													<input name='saler[".$pos."]' id='saler[".$pos."]' type='text' value='' onKeyPress='javascript:return solonumeros(event)' onKeyUp='return tabular(event,this)' style='text-align:right; width:100%' > 
												</td> 
												<td class='saludo1' style='width:5%'>
													<input name='regdev' id='regdev' type='button' value='Confirmar' style='width:100%; height:22px' onClick='agregardetdevolucion(".$pos.")' > 
												</td>
											</tr>";
										$pos =$pos+1;
										}
										echo "</table>";
									}
						}
						echo"		
						</div>
						<div class='subpantallac' style='height:50%; overflow-x:hidden;'>
							<table class='inicio'>
								<tr><td class='titulos' colspan='7'>Detalle Gesti&oacute;n Inventario - Salida</td></tr>
								<tr class='titulos2'>
									<td>Codigo UNSPSC</td>
									<td>Codigo Articulo</td>
									<td>Nombre Articulo</td>
									<td>Cantidad Entrada</td>
									<td>U.M</td>
									<td>Bodega</td>
									<td>Cantidad Devoluci&oacute;n</td>
									<td class='titulos2'><img src='imagenes/del.png' >
										<input type='hidden' name='elimina' id='elimina'>
										<input type='hidden' name='contad' id='contad' value='$_POST[contad]'/>
									</td>
								</tr>";
								if($_POST[elimina]!='')
								{ 
									$posi=$_POST[elimina];
									unset($_POST[codunsd][$posi]);
									unset($_POST[codinard][$posi]);
									unset($_POST[nomartd][$posi]);
									unset($_POST[devolved][$posi]);
									unset($_POST[cantidadd][$posi]);
									unset($_POST[unidadd][$posi]);
									unset($_POST[codbodd][$posi]);
									unset($_POST[bodegad][$posi]);
									$_POST[codunsd]= array_values($_POST[codunsd]); 
									$_POST[codinard]= array_values($_POST[codinard]); 
									$_POST[nomartd]= array_values($_POST[nomartd]); 		 		 
									$_POST[devolved]= array_values($_POST[devolved]); 
									$_POST[cantidadd]= array_values($_POST[cantidadd]); 
									$_POST[unidadd]= array_values($_POST[unidadd]); 
									$_POST[codbodd]= array_values($_POST[codbodd]); 
									$_POST[bodegad]= array_values($_POST[bodegad]); 
									echo"<script>
										document.getElementById('contad').value=".count($_POST[codinard]).";
									</script>";
								}
								if($_POST[agregadet]=='1')
								{	
									$cantmp=str_replace('.','',$_POST[cantart]);
									$numart=0; $posicion=-1;
									//DEFINIR DISPONIBILIDAD DEL TOTAL DE PRODUCTOS
									$sqla="SELECT almarticulos.existencia, almarticulos_det.factor FROM almarticulos INNER JOIN almarticulos_det ON CONCAT(almarticulos.grupoinven,almarticulos.codigo)=almarticulos_det.articulo WHERE almarticulos_det.articulo='$_POST[codart]' AND almarticulos_det.unidad='$_POST[umedida]'";
									$resa=mysql_query($sqla,$linkbd);
									$rowa=mysql_fetch_array($resa);
									$numcon=$cantmp*$rowa[1];
									if($numcon>$rowa[0]){$supero=1;}
									else {$supero=0;}
					
									if($supero<1)
									{
										$numart=0; $posicion=-1; $numbod=0;
										//DEFINIR DISPONIBILIDAD DEL TOTAL DE PRODUCTOS POR BODEGA
										$cantmp=str_replace('.','',$_POST[cantart]);
										$sqla="SELECT almarticulos_exis.existencia, almarticulos_det.factor FROM almarticulos_exis INNER JOIN almarticulos_det ON almarticulos_exis.articulo=almarticulos_det.articulo WHERE almarticulos_det.articulo='$_POST[codart]' AND almarticulos_det.unidad='$_POST[umedida]' AND almarticulos_exis.bodega='$_POST[codbod]'";
										$resa=mysql_query($sqla,$linkbd);
										$rowa=mysql_fetch_array($resa);
										$totbod=$rowa[0];
										$numbod=$cantmp*$rowa[1];
										for ($x=0;$x < count($_POST[codinard]);$x++)
										{
											if(($_POST[codart]==$_POST[codinard][$x])&&($_POST[codbod]==$_POST[codbodd][$x]))
											{
												$sqla="SELECT factor FROM almarticulos_det WHERE articulo='$_POST[codart]' AND unidad='$_POST[umedida]'";
												$resa=mysql_query($sqla,$linkbd);
												$rowa=mysql_fetch_array($resa);
												$numbod+=$_POST[cantidadd][$x]*$rowa[0];
											}
										}
										if($numbod>$totbod){$supbod=1;}
										else {$supbod=0;}
										//FIN DISPONIBILIDAD
										if($supbod<1)
										{
											//VALIDA1: QUE NO PASE DE LA CANTIDAD DE ENTRADA
											for ($x=0;$x < count($_POST[codinard]);$x++)
											{
												if($_POST[codart]==$_POST[codinard][$x])
												{
													$posicion=$x;
													$numart+=$_POST[cantidadd][$x];
												}
											}
											$numart+=$_POST[cantart];
											//FIN VALIDA1
											if($numart<=$_POST[numart]){
												if($posicion<=-1){
													$_POST[codunsd][]=$_POST[unsart];
													$_POST[codinard][]=$_POST[codart];
													$_POST[nomartd][]=$_POST[nomart];
													$_POST[devolved][]=$_POST[numart];
													$_POST[cantidadd][]=$_POST[cantart];
													$_POST[unidadd][]=$_POST[umedida];
													$_POST[codbodd][]=$_POST[codbod];
													$_POST[bodegadd][]=$_POST[nombod];
												}	
												else{
													$_POST[cantidadd][$posicion]=$numart;
												}
											}
											else{
												echo"<script>
													despliegamodalm('visible','2','La Cantidad de Articulos a Devolver Supera la Cantidad Disponible');
												</script>";
											}
										}
										else
										{
											echo"<script>
												despliegamodalm('visible','2','La Cantidad de Articulos a Devolver Supera la Existencia en Bodega');
											</script>";
										}
									}
									else
									{
										echo"<script>
											despliegamodalm('visible','2','La Cantidad de Articulos a Devolver Supera la Existencia Total');
										</script>";
									}
									echo"<script>
										document.getElementById('agregadet').value='0';
										document.getElementById('contad').value=".count($_POST[codinard]).";
									</script>";
								}
								$iter='saludo1';
								$iter2='saludo2';
								for ($x=0;$x< count($_POST[codinard]);$x++)
								{
									echo "
										<input type='hidden' name='codunsd[]' value='".$_POST[codunsd][$x]."'/>
										<input type='hidden' name='codinard[]' value='".$_POST[codinard][$x]."'/>
										<input type='hidden' name='nomartd[]' value='".$_POST[nomartd][$x]."'/>
										<input type='hidden' name='devolved[]' value='".$_POST[devolved][$x]."'/>
										<input type='hidden' name='unidadd[]' value='".$_POST[unidadd][$x]."'/>
										<input type='hidden' name='bodegad[]' value='".$_POST[bodegad][$x]."'/>
										<input type='hidden' name='codbodd[]' value='".$_POST[codbodd][$x]."'/>
										<input type='hidden' name='cantidadd[]' value='".$_POST[cantidadd][$x]."'/>
									<tr class='$iter'>
										<td style='width:10%'>".$_POST[codunsd][$x]."</td> 
										<td  style='width:10%'>".$_POST[codinard][$x]."</td> 
										<td  style='width:40%'>".$_POST[nomartd][$x]."</td>
										<td style='width:5%'>".$_POST[devolved][$x]."</td>
										<td style='width:5%'>".$_POST[unidadd][$x]."</td>
										<td style='width:20%'>".$_POST[bodegad][$x]."</td>
										<td style='width:5%'>".$_POST[cantidadd][$x]."</td>
										<td style='width:5%'><img src='imagenes/del.png' onclick='eliminares($x)' class='icobut'></td>
									</tr>";
									$aux=$iter;
									$iter=$iter2;
									$iter2=$aux;
								 }	 
								 echo"
										</table>
									</div>
								</div>";
					}break;
					case 1://SALIDA POR RESERVA
					{
						echo"
								<td class='saludo1' style='width:6%;'>No Reserva</td>
								<td style='width:10%;'>
									<input type='text' name='docum' id='docum' value='$_POST[docum]' onKeyPress='javascript:return solonumeros(event)' onKeyUp='return tabular(event,this)' onBlur=\"guiabuscar('2');reiniciar();\" style='width:60%'/>&nbsp;
									<img src='imagenes/find02.png' onClick=\"despliegamodal2('visible','2');reiniciar();\" class='icobut' title='Lista de Reservas'/>
								</td>
								<td width='50%'>
									<input type='text' name='ndocum' id='ndocum' value='$_POST[ndocum]' style='width:70%; text-transform:uppercase' readonly/>
									<em type='button' class='botonflecha' onClick='agregardetreserva()' style='float:rigth;'>Agregar Productos</em>
								</td>
							</tr>
						</table>
						<div class='subpantalla' style='height:62%; width:99.8%; overflow-x:hidden;'>
							<div class='subpantallac' style='height:47%; overflow-x:hidden;'>";
								//BUSQUEDA
								if($_POST[busqueda]!=""){
									if($_POST[busqueda]=="2"){
										$nresul=buscasolreserva_temp($_POST[docum]);
										if(count($nresul)>0){
											echo "<script>
												document.form2.busqueda.value=0;
												buscarReserva('".$nresul[0]."', '".$nresul[1]."', '".$nresul[2]."');
											</script>";
										}
										else{
											echo "<script>
												document.getElementById('valfocus').value='1';
												despliegamodalm('visible','2','Codigo del Documento Incorrecto');
											</script>";
										}
									}
								}		
								//FIN BUSQUEDA
								if ($_POST[verart]==2){
									$pos=0;
									echo "<table class='inicio'>";
									$sqlr ="SELECT almreservas_det. * , almarticulos_det.factor FROM almreservas_det, almarticulos_det
									WHERE almreservas_det.codreserva =  '$_POST[docum]' AND almreservas_det.articulo = almarticulos_det.articulo AND almreservas_det.cantidad > 0";
									//echo $sqlr;
									$res=view($sqlr);
									echo "<input type='hidden' name='cantidadArticulosTotal' id='cantidadArticulosTotal' value='".count($res)."' />";
									foreach ($res as $key => $wres) {
										//DATOS DEL ARTICULO
										
										$crit1="WHERE concat_ws(' ', art.nombre, concat_ws('', art.grupoinven, art.codigo)) LIKE '%$wres[articulo]'";
										$sqlr="SELECT art.codunspsc,art.nombre,invent.bodega FROM almarticulos art INNER JOIN almginventario_det invent ON invent.codart=concat_ws('', art.grupoinven, art.codigo) INNER JOIN almginventario inv ON invent.codigo=inv.consec $crit1 ORDER BY inv.fecha ASC";
										
										$wart=view($sqlr);
										if ($_POST[cont][$key]==0){
											$_POST[umed][$key] = $wres[unidad];
											$_POST[bodega][$key] = $wart[0][bodega];
										}
										$_POST[factor][$key] = $wres[factor];
										//CANTIDAD DE LA RESERVA SI HAY 'RETIROS DE RESERVAS' PARCIALES
										$sqlparcial = "SELECT T2.codart,T2.cantidad_salida,T2.unidad FROM almginventario T1 INNER JOIN almginventario_det T2 ON T1.consec=T2.codigo WHERE T1.tipomov='$_POST[tipomov]' AND T1.tiporeg='$_POST[tipoentra]' AND T1.codmov='$_POST[docum]' AND T2.codart='$wres[articulo]' AND T2.tipomov='$_POST[tipomov]'";
										
										$dat = view($sqlparcial);
										
										$cantparcial = 0;
										foreach ($dat as $key1 => $val) {
											$f = almconsulta_factorarticulo($val[codart],$val[unidad]);
											
											$cantparcial += ($val[cantidad_salida]/$f); //SE CONVIERTE A UNIDAD PRINCIPAL PARA SUMAR
										}
										$f = almconsulta_factorarticulo($wres[articulo],$wres[unidad]);
										$cantparcial = $cantparcial*$f; //SE CONVIERTE A UNIDAD DEL ARTICULO
										$cantreserva = $wres[cantidad]-$cantparcial;
										//FIN 
										
										if(isset($_POST[reservasal][$key])){
											$checked = "checked";
										}

										echo"<tr>
											<td class='saludo1' style='width:5%'>UNSPSC:</td> 
											<td style='width:5%'>
												<input type='text' id='codunsr[".$key."]' name='codunsr[".$key."]' onKeyUp='return tabular(event,this)' value='".$wart[0][codunspsc]."' readonly=readonly style='width:100%;' >
											</td>
											<td class='saludo1' style='width:5%'>Codigo:</td>
											<td colspan='1' style='width:10%'>
												<input type='text' id='codartr[".$key."]' name='codartr[".$key."]' onKeyUp='return tabular(event,this)' value='$wres[articulo]' readonly=readonly style='width:100%;' >
											</td>
											<td class='saludo1' style='width:5%'>Articulo:</td>
											<td colspan='1' width='18%'>
												<input type='text' id='nomartr[".$key."]' name='nomartr[".$key."]' onKeyUp='return tabular(event,this)' value='".$wart[0][nombre]."' readonly=readonly style='width:100%;' >
											</td>
											<td class='saludo1' style='width:2%'>U.M:</td>
											<td colspan='1' width='7%'>
												<input type='text' id='unimed[".$key."]' name='unimed[".$key."]' onKeyUp='return tabular(event,this)' value='$wres[unidad]' readonly=readonly style='width:100%;' >
											</td>
											<td class='saludo1' style='width:5%'>Cantidad </td>
											<td style='width:5%'>
												<input name='cantidadr[".$key."]' id='cantidadr[".$key."]' type='text' value='".$cantreserva."' onKeyPress='javascript:return solonumeros(event)' onKeyUp='return tabular(event,this)'  style='text-align:center; width:100%;' readonly >
											</td>
											<td class='saludo1' style='width:5%'>Salen: </td>
											<td style='width:5%'>  
												<input type='hidden' name='cont[".$key."]' id='cont[".$key."]' class='cont' value='".($_POST[cont][$key]+1)."'/>
												<input type='hidden' name='vmed[".$key."]' id='vmed[".$key."]' value='".$_POST[vmed][$key]."'/>
												<input type='hidden' name='factor[".$key."]' id='factor[".$key."]' value ='".$_POST[factor][$key]."'/> 
												<input name='saler[".$key."]' id='saler[".$key."]' type='text' value='".$_POST[saler][$key]."' onKeyPress='javascript:return solonumerossinpuntos(event)' onblur='validarAux($key)' onKeyUp='return tabular(event,this)' style='text-align:right; width:100%' > 
											</td> 
											<td class='saludo1' style='width:2%;'>U.M:</td>
											<td style='width:8%;'> 
												<select id='umed[".$key."]'  name='umed[".$key."]'  onChange='validar()' style='width:100%'>";
												$sqlm="SELECT * FROM almarticulos_det WHERE articulo='$wres[articulo]' ORDER BY principal DESC, id_det ASC";
												$resm=view($sqlm);
												foreach ($resm as $rowm) {
													if($rowm[unidad]==$_POST[umed][$key])
													{
														$_POST[factor]=$rowm[factor];

														if ($_POST[cont][$key] == 1) {
															echo"
															<script>
															document.getElementById('vmed[$key]').value=document.getElementById('saler[$key]').value/$_POST[factor];
															</script>";
														}
														echo "<script>
														document.getElementById('saler[$key]').value=document.getElementById('vmed[$key]').value*$_POST[factor];
														</script>
														<option value='$rowm[unidad]' style='text-transform:uppercase' SELECTED>$rowm[unidad]</option>";										
													}
													else {echo "<option value='$rowm[unidad]' style='text-transform:uppercase'>$rowm[unidad]</option>";}
												}
						     				echo"</select>
											</td> 
											<td class='saludo1' style='width:5%'>Bodega:</td>
											<td colspan='1'>
												<input type='hidden' name='nombodega[".$key."]' id='nombodega[".$key."]' value='".$_POST[nombodega][$key]."'/>

												<select id='bodega[".$key."]' name='bodega[".$key."]' onchange='javascript:form2.nombod.value=this.options[this.selectedIndex].text;'> 
													<option value='-1'>Seleccione ....</option>";
													$sqlr="SELECT * FROM almbodegas WHERE estado='S' ORDER BY id_cc";
													$resp = view($sqlr);
													foreach ($resp as $k => $row) {
														$i=$row[id_cc];
														if($i==$_POST[bodega][$key]){
															$_POST[nombodega][$key] = $row[id_cc]." - ".$row[nombre];
															echo"<script>
																document.form2.nombod.value='".$row[id_cc]." - ".$row[nombre]."';
																</script>
																
															<option value='".$row[id_cc]."' SELECTED>".$row[id_cc]." - ".$row[nombre]."</option>"; 
															
														}
														else{
															echo"<option value='".$row[id_cc]."'>".$row[id_cc]." - ".$row[nombre]."</option>"; 
														}
													}  
												echo "</select>
											</td>
											<td class='saludo1' style='width:5%'>
												<input type='checkbox' name='reservasal[$key]' id='reservasal[$key]' onChange='cambioCheck($key,this)' $checked/>
											</td>
										</tr>";
										$checked = "";
									}
									echo "</table>";
								}		
								?>
							</div>
							<div class="subpantallac" style="height:50%; overflow-x:hidden;">
							<table class="inicio">
								<tr>
									<td class="titulos" colspan="9">Detalle Gesti&oacute;n Inventario - Salida</td>
								</tr>
								<tr>
									<td class="titulos2">Codigo UNSPSC</td>
									<td class="titulos2">Codigo Articulo</td>
									<td class="titulos2">Nombre Articulo</td>
									<td class="titulos2">Cantidad Reservada</td>
									<td class="titulos2">U.M</td>
									<td class="titulos2">Cantidad Entregada</td>
									<td class="titulos2">U.M</td>
									<td class="titulos2">Bodega</td>
									<td class="titulos2"><img src="imagenes/del.png" >
										<input type='hidden' name='elimina' id='elimina'>
										<input name='contad' id='contad' value='<?php $_POST[contad] ?>' type='hidden' style='width:100%' readonly>
									</td>
								</tr>
								<?php			 
								if($_POST[elimina]!=''){ 
									$posi=$_POST[elimina];
									unset($_POST[codunsd][$posi]);
									unset($_POST[codinard][$posi]);
									unset($_POST[nomartd][$posi]);
									unset($_POST[reservad][$posi]);
									unset($_POST[unidadd][$posi]);
									unset($_POST[cantidadd][$posi]);
									unset($_POST[undadd][$posi]);
									unset($_POST[codbodd][$posi]);
									unset($_POST[bodegad][$posi]);
									$_POST[codunsd]= array_values($_POST[codunsd]); 
									$_POST[codinard]= array_values($_POST[codinard]); 
									$_POST[nomartd]= array_values($_POST[nomartd]); 		 		 
									$_POST[reservad]= array_values($_POST[reservad]); 
									$_POST[unidadd]= array_values($_POST[unidadd]); 
									$_POST[cantidadd]= array_values($_POST[cantidadd]); 
									$_POST[undadd] = array_values($_POST[undadd]); 
									$_POST[codbodd]= array_values($_POST[codbodd]); 
									$_POST[bodegad]= array_values($_POST[bodegad]); 
									echo"<script>
										document.getElementById('contad').value=".count($_POST[codinard]).";
									</script>";
								}
								
								if($_POST[agregadet]=='1'){
									$cantidadProductos = $_POST[cantidadArticulosTotal];
									for($i = 0; $i < $cantidadProductos; $i++){
										if(isset($_POST[reservasal][$i])){
											//DEFINIR DISPONIBILIDAD DEL TOTAL DE PRODUCTOS
											$cantmp = str_replace('.','',$_POST[cantidadr][$i]);
											$disponible = totalinventario2($_POST[codartr][$i]);
											$fact = almconsulta_factorarticulo($_POST[codartr][$i],$_POST[umed][$i]);
											$numcon = $cantmp/$fact;
							
											if($numcon>$disponible)
												$supero=1;
											else
												$supero=0;
											
											if($supero<1){
												
												$numart=0; $posicion=-1; $numbod=0;
												//DEFINIR DISPONIBILIDAD DEL TOTAL DE PRODUCTOS POR BODEGA
												$disponible = totalinventario2($_POST[codartr][$i]);
												$totbod=$disponible;
												$numbod=$cantmp/$fact;

												if($numbod>$totbod)
													$supbod=1;
												else
													$supbod=0;
													
												//FIN DISPONIBILIDAD
												if($supbod<1){
													//VALIDA1: QUE NO SUPERE LAS CANTIDAD REGISTRADAS EN LA ENTRADA
													for ($x=0;$x < count($_POST[codinard]);$x++){
														if($_POST[codart]==$_POST[codinard][$x]){
															$f = almconsulta_factorarticulo($_POST[codartr][$i],$_POST[undadd][$x]);
															$numart+=($_POST[cantidadd][$x]/$f);
														}
													}
													$numart+=($_POST[saler][$i]/$fact);

													//VALIDA2: QUE SUME CANTIDADES AL SACAR EL MISMO ARTICULO
													for ($x=0;$x < count($_POST[codinard]);$x++){
														if(($_POST[codartr][$i]==$_POST[codinard][$x])&&($_POST[bodega][$i]==$_POST[codbodd][$x])){
															$posicion=$x;
															$totalart=$_POST[cantidadd][$x];
														}
													}
													//CONVERTIR A UNIDAD PRINCIPAL 
													$f = almconsulta_factorarticulo($_POST[codartr][$i],$_POST[unimed][$i]);
													//FIN CONVERTIR A UNIDAD PRINCIPAL 
													$totalart+=($_POST[saler][$i]/$fact)*$f;
													//FIN VALIDA2
													
													if($numart<=($_POST[cantidadr][$i]/$f)){
														if($posicion<=-1){
															$_POST[codunsd][]=$_POST[codunsr][$i];
															$_POST[codinard][]=$_POST[codartr][$i];
															$_POST[nomartd][]=$_POST[nomartr][$i];
															$_POST[reservad][]=$_POST[cantidadr][$i];
															$_POST[unidadd][]=$_POST[unimed][$i];
															$_POST[cantidadd][]=($_POST[saler][$i]/$fact)*$f;
															$_POST[undadd][]=$_POST[unimed][$i];
															$_POST[codbodd][]=$_POST[bodega][$i];
															$_POST[bodegad][]=$_POST[nombodega][$i];
														}	
														else{
															$_POST[cantidadd][$posicion]=$totalart;
														}
													}
													else{
														echo"<script>
															despliegamodalm('visible','2','La Cantidad de Articulos a Entregar Supera la Cantidad descrita en la Reserva');
														</script>";
													}
													echo"<script>
														document.getElementById('agregadet').value='0';
														document.getElementById('contad').value=".count($_POST[codinard]).";
													</script>";
												}
												else{
													echo"<script>
														despliegamodalm('visible','2','La Cantidad de Articulos a Reservar supera la Existencia en Bodega');
													</script>";
												}
												
											} //aQUI
											else{
												echo"<script>
													despliegamodalm('visible','2','La Cantidad de Articulos a Reservar supera a la Existencia Total');
												</script>";
											}
											
										} //AQUI TERMINA IF
									}	
								}
								
								$iter='saludo1';
								$iter2='saludo2';
								for ($x=0;$x< count($_POST[codinard]);$x++){
									echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
					onMouseOut=\"this.style.backgroundColor=anterior\">
										<td style='width:10%'>
											<input class='inpnovisibles' name='codunsd[]' value='".$_POST[codunsd][$x]."' type='text' style='width:100%' readonly>
										";
										echo"</td> 
										<td  style='width:10%'>
											<input class='inpnovisibles' name='codinard[]' value='".$_POST[codinard][$x]."' type='text'  style='width:100%' readonly>
										</td> 
										<td  style='width:35%'>
											<input class='inpnovisibles' name='nomartd[]' value='".$_POST[nomartd][$x]."' type='text' style='width:100%' readonly>
										</td>
										<td style='width:5%'>
											<input class='inpnovisibles' name='reservad[]' value='".$_POST[reservad][$x]."' type='text'  style='width:100%' readonly>
										</td>
										<td style='width:5%'>
											<input class='inpnovisibles' name='unidadd[]' value='".$_POST[unidadd][$x]."' type='text'  style='width:100%' readonly>
										</td>
										<td style='width:7%'>
											<input class='inpnovisibles' value='".round($_POST[cantidadd][$x], 2)."' type='text' style='width:100%; text-align:right;' readonly>
											<input name='cantidadd[]' value='".$_POST[cantidadd][$x]."' type='hidden'>
										</td>
										<td style='width:5%'>
											<input class='inpnovisibles' name='undadd[]' value='".$_POST[undadd][$x]."' type='text'  style='width:100%' readonly>
										</td>
										<td style='width:23%'>
											<input class='inpnovisibles' name='bodegad[]' value='".$_POST[bodegad][$x]."' type='text' style='width:100%; text-align:right;' readonly>
											<input name='codbodd[]' value='".$_POST[codbodd][$x]."' type='hidden'>
										</td>
										<td style='width:5%'>
											<a href='#' onclick='eliminares($x)'><img src='imagenes/del.png'></a>
										</td>
									</tr>";
									$aux=$iter;
									$iter=$iter2;
									$iter2=$aux;
								 }
								 ?>
							</table>
						</div>
					</div>
					<?php 
					}break;
					case 2://SALIDA POR DEVOLUCIONES
					{
?> 
	    	<td class="saludo1" width="6%" style="font-weight: bold">Documento</td>
	       	<td style="width:12%;">
               	<input id="codiun" name="codiun" type="hidden" value="<?php echo $_POST[codiun]?>">
               	<input id="numcan" name="numcan" type="hidden" value="<?php echo $_POST[numcan]?>">
               	<input id="valunitp" name="valunitp" type="hidden" value="<?php echo $_POST[valunitp]?>">
               	<input id="vtotal" name="vtotal" type="hidden" value="<?php echo $_POST[vtotal]?>">
               	<input type="text" name="docum" id="docum" value="<?php echo $_POST[docum]?>" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="guiabuscar('3');" style="width:80%"/>&nbsp;<a onClick="despliegamodal2('visible','3');"><img src="imagenes/buscarep.png"/></a>
            </td>
            <td width="50%">
            	<input type="text" name="ndocum" id="ndocum" value="<?php echo $_POST[ndocum]?>" style="width:100%;text-transform:uppercase" readonly/>
          	</td>
		</tr>
	</table>
   	<div class="subpantalla"  style="height:62%; width:99.8%; overflow-x:hidden;">
    	<div class="subpantallac" style="height:47%; overflow-x:hidden;">
  			<?php
			//BUSQUEDA
			if($_POST[busqueda]!=""){
				if($_POST[busqueda]=="3"){
					$nresul=buscasoladquisicion($_POST[docum]);
					if(count($nresul)>0){
						echo "<script>
						document.form2.busqueda.value=0;
							buscarDevolucion('".$nresul[2]."', '".$nresul[1]."', '".$nresul[0]."', '".$nresul[3]."', '".$nresul[4]."', '".$nresul[5]."');
						</script>";
					}
					else{
						echo "<script>
							document.getElementById('valfocus').value='1';
							despliegamodalm('visible','2','CÃ³digo del Documento Incorrecto');
						</script>";
					}
				}
			}		
			//FIN BUSQUEDA
			if ($_POST[verart]==3){
				$pos=0;
				$sqlg="SELECT * FROM almginventario WHERE CONCAT(tipomov,tiporeg)='$_POST[hddent]' AND consec='$_POST[docum]'";
				$gres=mysql_query($sqlg,$linkbd);
				if(mysql_num_rows($gres)!=0){
					$grow=mysql_fetch_array($gres);
					$pos=0;
					echo "<table class='inicio'>";
					$sqlr="SELECT almginventario_det.unspsc, almginventario_det.codart, almarticulos.nombre, almginventario_det.cantidad, almginventario_det.unidad, almginventario_det.bodega, almbodegas.nombre FROM (almginventario_det INNER JOIN almarticulos ON almginventario_det.codart=CONCAT(almarticulos.grupoinven,almarticulos.codigo)) INNER JOIN almbodegas ON almginventario_det.bodega=almbodegas.id_cc WHERE almginventario_det.codigo='$grow[9]' AND almginventario_det.tipomov='$grow[2]' ORDER BY almginventario_det.codart, almginventario_det.bodega";
					$res=mysql_query($sqlr,$linkbd);
					while($wres=mysql_fetch_array($res)){
						echo"<tr>
							<td class='saludo1' style='width:5%'>UNSPSC:</td> 
							<td style='width:7%'>
								<input type='text' id='codunsr[".$pos."]' name='codunsr[".$pos."]' onKeyUp='return tabular(event,this)' value='$wres[0]' readonly=readonly style='width:100%;' >
							</td>
							<td class='saludo1' style='width:5%'>Codigo:</td>
							<td colspan='1' style='width:7%'>
								<input type='text' id='codartr[".$pos."]' name='codartr[".$pos."]' onKeyUp='return tabular(event,this)' value='$wres[1]' readonly=readonly style='width:100%;' >
							</td>
							<td class='saludo1' style='width:10%'>Nombre Articulo:</td>
							<td colspan='1' width='18%'>
								<input type='text' id='nomartr[".$pos."]' name='nomartr[".$pos."]' onKeyUp='return tabular(event,this)' value='$wres[2]' readonly=readonly style='width:100%;' >
							</td>
							<td class='saludo1' style='width:4%'>Cantidad </td>
       						<td style='width:4%'>
								<input name='cantidadr[".$pos."]' id='cantidadr[".$pos."]' type='text' value='".number_format($wres[3],0,',','.')."' onKeyPress='javascript:return solonumeros(event)' onKeyUp='return tabular(event,this)' style='text-align:center; width:100%;' readonly >
							</td>
							<td class='saludo1' style='width:2%'>U.M:</td>
							<td colspan='1' width='5%'>
								<select name='unimed[".$pos."]' id='unimed[".$pos."]'>";
									$sqlu="SELECT unidad FROM almarticulos_det WHERE articulo='$wres[1]'";
									$resu=mysql_query($sqlu,$linkbd);
									while($wuni=mysql_fetch_array($resu)){
										echo"<option value='".$wuni[0]."'>".$wuni[0]."</option>";
									}
							echo"</select>
							</td>
							<td class='saludo1' style='width:4%'>Bodega:</td>
							<td colspan='1' style='width:15%'>
								<input type='text' id='nombodega[".$pos."]' name='nombodega[".$pos."]' onKeyUp='return tabular(event,this)' value='$wres[6]' readonly=readonly style='width:100%;' >
								<input type='hidden' id='codbodega[".$pos."]' name='codbodega[".$pos."]' value='$wres[5]' >
							</td>
		  					<td class='saludo1' style='width:5%'>Devoluci&oacute;n: </td>
	  						<td style='width:4%'>  
								<input name='saler[".$pos."]' id='saler[".$pos."]' type='text' value='' onKeyPress='javascript:return solonumeros(event)' onKeyUp='return tabular(event,this)' style='text-align:right; width:100%' > 
							</td> 
	  						<td class='saludo1' style='width:5%'>
								<input name='regdev' id='regdev' type='button' value='Confirmar' style='width:100%; height:22px' onClick='agregardetdevolucion(".$pos.")' > 
							</td>
					 	</tr>";
					$pos =$pos+1;
					}
					echo "</table>";
				}
			}
   			?>
    	</div>
    	<div class="subpantallac" style="height:50%; overflow-x:hidden;">
		<table class="inicio">
			<tr>
    			<td class="titulos" colspan="7">Detalle Gesti&oacute;n Inventario - Salida</td>
       		</tr>
			<tr>
    	    	<td class="titulos2">Codigo UNSPSC</td>
        		<td class="titulos2">Codigo Articulo</td>
            	<td class="titulos2">Nombre Articulo</td>
	            <td class="titulos2">Cantidad Entrada</td>
    	        <td class="titulos2">U.M</td>
    	        <td class="titulos2">Bodega</td>
    	        <td class="titulos2">Cantidad Devoluci&oacute;n</td>
            	<td class="titulos2"><img src="imagenes/del.png" >
            		<input type='hidden' name='elimina' id='elimina'>
	<input name='contad' id='contad' value='<?php $_POST[contad] ?>' type='hidden' style='width:100%' readonly>
	            </td>
    	  	</tr>
			<?php			 
			if($_POST[elimina]!=''){ 
				$posi=$_POST[elimina];
			 	unset($_POST[codunsd][$posi]);
		 		unset($_POST[codinard][$posi]);
			 	unset($_POST[nomartd][$posi]);
 			 	unset($_POST[devolved][$posi]);
			 	unset($_POST[cantidadd][$posi]);
			 	unset($_POST[unidadd][$posi]);
			 	unset($_POST[codbodd][$posi]);
			 	unset($_POST[bodegad][$posi]);
			 	$_POST[codunsd]= array_values($_POST[codunsd]); 
			 	$_POST[codinard]= array_values($_POST[codinard]); 
			 	$_POST[nomartd]= array_values($_POST[nomartd]); 		 		 
		 		$_POST[devolved]= array_values($_POST[devolved]); 
			  	$_POST[cantidadd]= array_values($_POST[cantidadd]); 
			  	$_POST[unidadd]= array_values($_POST[unidadd]); 
			  	$_POST[codbodd]= array_values($_POST[codbodd]); 
			  	$_POST[bodegad]= array_values($_POST[bodegad]); 
				echo"<script>
					document.getElementById('contad').value=".count($_POST[codinard]).";
				</script>";
			}

			if($_POST[agregadet]=='1'){
				$cantmp=str_replace('.','',$_POST[cantart]);
				$numart=0; $posicion=-1;
				//DEFINIR DISPONIBILIDAD DEL TOTAL DE PRODUCTOS
				$sqla="SELECT almarticulos.existencia, almarticulos_det.factor FROM almarticulos INNER JOIN almarticulos_det ON CONCAT(almarticulos.grupoinven,almarticulos.codigo)=almarticulos_det.articulo WHERE almarticulos_det.articulo='$_POST[codart]' AND almarticulos_det.unidad='$_POST[umedida]'";
				$resa=mysql_query($sqla,$linkbd);
				$rowa=mysql_fetch_array($resa);
				$numcon=$cantmp*$rowa[1];
				if($numcon>$rowa[0])
					$supero=1;
				else
					$supero=0;

				if($supero<1){
					$numart=0; $posicion=-1; $numbod=0;
					//DEFINIR DISPONIBILIDAD DEL TOTAL DE PRODUCTOS POR BODEGA
					$cantmp=str_replace('.','',$_POST[cantart]);
					$sqla="SELECT almarticulos_exis.existencia, almarticulos_det.factor FROM almarticulos_exis INNER JOIN almarticulos_det ON almarticulos_exis.articulo=almarticulos_det.articulo WHERE almarticulos_det.articulo='$_POST[codart]' AND almarticulos_det.unidad='$_POST[umedida]' AND almarticulos_exis.bodega='$_POST[codbod]'";
					$resa=mysql_query($sqla,$linkbd);
					$rowa=mysql_fetch_array($resa);
					$totbod=$rowa[0];
					$numbod=$cantmp*$rowa[1];
					for ($x=0;$x < count($_POST[codinard]);$x++){
						if(($_POST[codart]==$_POST[codinard][$x])&&($_POST[codbod]==$_POST[codbodd][$x])){
							$sqla="SELECT factor FROM almarticulos_det WHERE articulo='$_POST[codart]' AND unidad='$_POST[umedida]'";
							$resa=mysql_query($sqla,$linkbd);
							$rowa=mysql_fetch_array($resa);
							$numbod+=$_POST[cantidadd][$x]*$rowa[0];
						}
					}

					if($numbod>$totbod)
						$supbod=1;
					else
						$supbod=0;
					//FIN DISPONIBILIDAD
					if($supbod<1){
						//VALIDA1: QUE NO PASE DE LA CANTIDAD DE ENTRADA
						for ($x=0;$x < count($_POST[codinard]);$x++){
							if($_POST[codart]==$_POST[codinard][$x]){
								$posicion=$x;
								$numart+=$_POST[cantidadd][$x];
							}
						}
						$numart+=$_POST[cantart];
						//FIN VALIDA1
						if($numart<=$_POST[numart]){
							if($posicion<=-1){
							 	$_POST[codunsd][]=$_POST[unsart];
		 						$_POST[codinard][]=$_POST[codart];
							 	$_POST[nomartd][]=$_POST[nomart];
						  		$_POST[devolved][]=$_POST[numart];
							 	$_POST[cantidadd][]=$_POST[cantart];
							 	$_POST[unidadd][]=$_POST[umedida];
							 	$_POST[codbodd][]=$_POST[codbod];
							 	$_POST[bodegadd][]=$_POST[nombod];
							}	
							else{
								$_POST[cantidadd][$posicion]=$numart;
							}
						}
						else{
							echo"<script>
								despliegamodalm('visible','2','La Cantidad de Articulos a Devolver Supera la Cantidad Disponible');
							</script>";
						}
					}
					else{
						echo"<script>
							despliegamodalm('visible','2','La Cantidad de Articulos a Devolver Supera la Existencia en Bodega');
						</script>";
					}
				}
				else{
					echo"<script>
						despliegamodalm('visible','2','La Cantidad de Articulos a Devolver Supera la Existencia Total');
					</script>";
				}
				echo"<script>
					document.getElementById('agregadet').value='0';
					document.getElementById('contad').value=".count($_POST[codinard]).";
				</script>";
			}
			$iter='saludo1';
	        $iter2='saludo2';
			for ($x=0;$x< count($_POST[codinard]);$x++){
	 			echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\">
					<td style='width:10%'>
						<input class='inpnovisibles' name='codunsd[]' value='".$_POST[codunsd][$x]."' type='text' style='width:100%' readonly>
					";
					echo"</td> 
					<td  style='width:10%'>
						<input class='inpnovisibles' name='codinard[]' value='".$_POST[codinard][$x]."' type='text'  style='width:100%' readonly>
					</td> 
					<td  style='width:40%'>
						<input class='inpnovisibles' name='nomartd[]' value='".$_POST[nomartd][$x]."' type='text' style='width:100%' readonly>
					</td>
					<td style='width:5%'>
						<input class='inpnovisibles' name='devolved[]' value='".$_POST[devolved][$x]."' type='text'  style='width:100%' readonly>
					</td>
					<td style='width:5%'>
						<input class='inpnovisibles' name='unidadd[]' value='".$_POST[unidadd][$x]."' type='text' style='width:100%; text-align:right;' readonly>
					</td>
					<td style='width:20%'>
						<input class='inpnovisibles' name='bodegad[]' value='".$_POST[bodegad][$x]."' type='text' style='width:100%; text-align:right;' readonly>
						<input name='codbodd[]' value='".$_POST[codbodd][$x]."' type='hidden'>
					</td>
					<td style='width:5%'>
						<input class='inpnovisibles' name='cantidadd[]' value='".$_POST[cantidadd][$x]."' type='text' style='width:100%; text-align:right;' readonly>
					</td>
					<td style='width:5%'>
						<a href='#' onclick='eliminares($x)'><img src='imagenes/del.png'></a>
					</td>
				</tr>";
				$aux=$iter;
				$iter=$iter2;
				$iter2=$aux;
			 }	 
			 ?>
		</table>
	</div>
</div>
<?php 
}break;
					case 3://SALIDA POR TRASLADOS
					{
						$_POST[saldobod] = 0;
						$_POST[saldocc] = 0;
						if(!isset($_POST[valunit])){
							$_POST[valunit] = 0;
						}
						if(!isset($_POST[valunitcc])){
							$_POST[valunitcc] = 0;
						}
						
						$_POST[docum] = $_POST[numero];
						if($_POST[articulo]!=''){
							$grupo = substr($_POST[articulo],0,4);
							$codigo = substr($_POST[articulo],4);
							$sql = "SELECT nombre FROM almarticulos WHERE grupoinven='$grupo' AND codigo='$codigo' AND estado='S'";
							$res = mysql_query($sql,$linkbd);
							$row = mysql_fetch_row($res);
							$_POST[narticulo] = $row[0];
							
							$sql = "SELECT unidad FROM almarticulos_det WHERE articulo='$_POST[articulo]' ";
							$res = mysql_query($sql,$linkbd);
							$row = mysql_fetch_row($res);
							$_POST[umedida] = $row[0];
							
							if($_POST[bodega]!="-1"){
								$_POST[cantbodact] = totalinventario2($_POST[articulo]);
								$_POST[saldobod] = $_POST[cantbodact];
							}
							if($_POST[centrocosto]!="-1"){
								$_POST[cantccact] = totalinventario2($_POST[articulo]);
								$_POST[saldocc] = $_POST[cantccact];
							}
						}
						
						
					?> 
    		<td class="saludo1" width="6%" style="font-weight: bold">Articulo</td>
				<input type='hidden' name='ntipoentra' id='ntipoentra' value="<?php echo $_POST[ntipoentra]?>" > 
               	<input id="codiun" name="codiun" type="hidden" value="<?php echo $_POST[codiun]?>">
               	<input id="numcan" name="numcan" type="hidden" value="<?php echo $_POST[numcan]?>">
               	<input id="valunitp" name="valunitp" type="hidden" value="<?php echo $_POST[valunitp]?>">
               	<input id="vtotal" name="vtotal" type="hidden" value="<?php echo $_POST[vtotal]?>">
				<input id="docum" name="docum" type="hidden" value="<?php echo $_POST[docum]?>" >
           	<td style="width:10%;">
               	<input type="text" name="articulo" id="articulo" value="<?php echo $_POST[articulo]?>" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="guiabuscar('1');" style="width:74%"/>&nbsp;<img class="icobut" src="imagenes/find02.png"  title="Lista de Articulos" onClick="despliegamodal2('visible','10');"/></a>
            </td>
            <td width="15%">
               	<input type="text" name="narticulo" id="narticulo" value="<?php echo $_POST[narticulo]?>" style="width:100%;text-transform:uppercase" readonly/>
            </td>
			<td class="saludo1" width="6%" style="font-weight: bold">Centro costo</td>
			<td width="17%">

               	<select name="centrocosto" id="centrocosto"  onKeyUp="return tabular(event,this)" style="width:100%;" onChange="validar();">
					<option value="-1">Seleccione ...</option>
					<?php
						$sqlr="select *from centrocosto where estado='S' order by id_cc";
						$res=mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_row($res)) 
						{
							if("$row[0]"==$_POST[centrocosto]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";$_POST[ncentrocosto] = $row[1]; }
							else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
						}
					?>	
				</select>
            </td>
			<td class="saludo1" width="6%" style="font-weight: bold">Bodega</td>
			<td width="15%">
               	<input type="hidden" name="nbodega" id="nbodega" value="<?php echo $_POST[nbodega]; ?> " /> 
				<select name="bodega" id="bodega" onChange="validar();" style="width:100%"> 
					<option value="-1">Seleccione ....</option>
					<?php
						$sqlr="Select * from almbodegas where estado='S' ORDER BY id_cc";
						$resp = mysql_query($sqlr,$linkbd);
						while($row =mysql_fetch_row($resp)) 
						{
							if($row[0]==$_POST[bodega])
							{
								echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";
								$_POST[bodega]=$row[0];
								$_POST[nbodega]=$row[1];
								$_POST[nbodegaact] = $row[1];
							}
						   else	{ echo "<option value='$row[0]'>$row[0] - $row[1]</option>";} 
						} 
					?>
				</select>
            </td>
			<td class="saludo1" width="6%" style="font-weight: bold">U.M</td>
			<td width="5%">
               	<input type="text" name="umedida" id="umedida" value="<?php echo $_POST[umedida]?>" style="width:95%;text-transform:uppercase" readonly/>
            </td>
    	</tr>
	</table>
    <div class="subpantalla"  style="height:62%; width:99.8%; overflow:hidden;display:flex">

   	<div class="subpantallac" style="height:100%;width:50%; overflow-x:hidden">
	<table class="inicio">
		<tr>
    		<td class="titulos" colspan="8">Traslado entre bodegas</td>
       	</tr>
		<tr>
			<td class="saludo1" style="font-weight: bold; width: 13%">Bodega</td>
			<td style="width:35%" colspan="3"><input type="text" name="nbodegaact" id="nbodegaact" value="<?php echo $_POST[nbodegaact]; ?>" style="width:99%" readonly/></td>
			<td class="saludo1" style="font-weight: bold; width: 17%">Bodega nueva</td>
			<td colspan="3">
				<input type="hidden" id="nbodeganu" name="nbodeganu" value="<?php echo $_POST[nbodeganu]; ?>" />
				<select name="bodeganu" id="bodeganu" onChange="validar();" style="width:100%"> 
					<option value="-1">Seleccione ....</option>
					<?php
						$sqlr="Select * from almbodegas where estado='S' ORDER BY id_cc";
						$resp = mysql_query($sqlr,$linkbd);
						while($row =mysql_fetch_row($resp)) 
						{
							if($row[0]==$_POST[bodeganu])
							{
								echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";
								$_POST[bodeganu]=$row[0];
								$_POST[nbodeganu] = $row[1];
							}
						   else	{ echo "<option value='$row[0]'>$row[0] - $row[1]</option>";} 
						} 
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td class="saludo1" style="font-weight: bold; width: 13%">Valor unitario</td>
			<td style="width:13%"><input type="text" name="valunit" id="valunit" value="<?php echo $_POST[valunit]?>" style="width:95%"/></td>
			<td class="saludo1" style="font-weight: bold; width: 15%">Cantidad actual</td>
			<td><input type="text" name="cantbodact" id="cantbodact" value="<?php echo $_POST[cantbodact]?>" style="width:95%" readonly/></td>
			<td class="saludo1" style="font-weight: bold; width: 17%">Cantidad a trasladar</td>
			<td style="width:8%"><input type="text" name="cantbodtras" id="cantbodtras" value="<?php echo $_POST[cantbodtras]?>" style="width:95%" /> </td>
			<td class="saludo1" style="font-weight: bold; width: 10%">Saldo</td>
			<td><input type="text" name="saldobod" id="saldobod" value="<?php echo $_POST[saldobod]?>" style="width:40%; margin-right:10%" readonly/><input name="regbodtraslado" id="regbodtraslado" type="button" value="Agregar" style="width:50%; height:22px" onClick="agregardettraslado('1')" > </td>
		</tr>
	</table>
	
	<table class="inicio">
		<tr>
        	<td class="titulos2" style="width: 13%">Codigo Articulo</td>
            <td class="titulos2" style="width: 17%">Nombre Articulo</td>
			<td class="titulos2" style="width: 15%">Valor Unitario</td>
            <td class="titulos2" style="width: 17%">Bodega Actual</td>
			<td class="titulos2" style="width: 17%">Bodega a Trasladar</td>
			<td class="titulos2" style="width: 10%">Cantidad a Trasladar</td>
            <td class="titulos2" style="width: 5%"><img src="imagenes/del.png" >
            <input type='hidden' name='elimina' id='elimina'>
			<input name='contad' id='contad' value='<?php $_POST[contad] ?>' type='hidden' style='width:100%' readonly>
            </td>
      	</tr>
		<?php			 
		if($_POST[elimina]!=''){ 
			$posi=$_POST[elimina];
		 	unset($_POST[codunsd][$posi]);
		 	unset($_POST[codinard][$posi]);
		 	unset($_POST[nomartd][$posi]);
 		 	unset($_POST[cantidadd][$posi]);
		 	unset($_POST[unidadd][$posi]);
		 	unset($_POST[codbodd][$posi]);
		 	unset($_POST[bodegad][$posi]);
		 	unset($_POST[codbodd2][$posi]);
			unset($_POST[bodegad2][$posi]);
			unset($_POST[valore][$posi]);
			unset($_POST[valortotal1][$posi]);
			unset($_POST[dccbod][$posi]);
			
		 	$_POST[codunsd]= array_values($_POST[codunsd]); 
		 	$_POST[codinard]= array_values($_POST[codinard]); 
		 	$_POST[nomartd]= array_values($_POST[nomartd]); 		 		 
		 	$_POST[cantidadd]= array_values($_POST[cantidadd]); 
		 	$_POST[unidadd]= array_values($_POST[unidadd]); 		 		 
		 	$_POST[codbodd]= array_values($_POST[codbodd]); 		 		 
		 	$_POST[bodegad]= array_values($_POST[bodegad]); 		 		 
		  	$_POST[codbodd2]= array_values($_POST[codbodd2]); 
			$_POST[bodegad2]= array_values($_POST[bodegad2]);
			$_POST[valore]= array_values($_POST[valore]);
			$_POST[valortotal1]= array_values($_POST[valortotal1]);
			$_POST[dccbod]= array_values($_POST[dccbod]);
			
			echo"<script>
				document.getElementById('contad').value=".count($_POST[codinard]).";
			</script>";
		}

		if($_POST[agregadet]=='1'){
			$cantmp=str_replace('.','',$_POST[cantart]);
			$numart=0; $posicion=-1;


			//VALIDA2: QUE SUME CANTIDADES AL SACAR EL MISMO ARTICULO
			for ($x=0;$x < count($_POST[codinard]);$x++){
				if(($_POST[codart]==$_POST[codinard][$x]) && ($_POST[codbod2]==$_POST[codbodd2][$x])){
					$posicion=$x;
				}
			}
			
			//FIN VALIDA2
			if($posicion<=-1){
				$_POST[codunsd][]=$_POST[unsart];
				$_POST[codinard][]=$_POST[codart];
				$_POST[nomartd][]=$_POST[nomart];
				$_POST[cantidadd][]=$_POST[cantart];
				$_POST[unidadd][]=$_POST[umedida];
				$_POST[codbodd][]=$_POST[codbod];
				$_POST[bodegad][]=$_POST[nbodega];
				$_POST[codbodd2][]=$_POST[codbod2];
				$_POST[bodegad2][]=$_POST[nbodeganu];
				$_POST[valore][]=$_POST[valunit];
				$_POST[valortotal1][]=$_POST[valunit]*$_POST[cantart];
				$_POST[dccbod][]=$_POST[centrocosto];
			}	

			echo"<script>
				document.getElementById('agregadet').value='0';
				document.getElementById('contad').value=".count($_POST[codinard]).";
			</script>";
		}
		$iter='saludo1a';
        $iter2='saludo2';
		$total = 0;
		$saldobod = 0;
		for ($x=0;$x< count($_POST[codinard]);$x++){
			
			if($_POST[codart] == $_POST[codinard][$x] && $_POST[codbod] == $_POST[codbodd][$x]){
				$saldobod +=($_POST[cantidadd][$x]);
			}
			
	 		echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\">
				<td style='width:13%'>
					<input name='codunsd[]' value='".$_POST[codunsd][$x]."' type='hidden'/>
					<input name='unidadd[]' value='".$_POST[unidadd][$x]."' type='hidden'/>
					<input name='valortotal1[]' value='".$_POST[valortotal1][$x]."' type='hidden'/>
					<input name='dccbod[]' value='".$_POST[dccbod][$x]."' type='hidden'/>
					<input class='inpnovisibles' name='codinard[]' value='".$_POST[codinard][$x]."' type='text' style='width:100%' readonly>
					";
				echo"</td> 
				<td  style='width:17%'>
					<input class='inpnovisibles' name='nomartd[]' value='".$_POST[nomartd][$x]."' type='text'  style='width:100%' readonly>
				</td> 
				<td  style='width:15%'>
					<input class='inpnovisibles' name='valore[]' value='".$_POST[valore][$x]."' type='text'  style='width:100%' readonly>
				</td> 
				<td  style='width:17%'>
					<input class='inpnovisibles' name='bodegad[]' value='".$_POST[bodegad][$x]."' type='text' style='width:100%' readonly>
					<input name='codbodd[]' value='".$_POST[codbodd][$x]."' type='hidden'/>
				</td>
				<td style='width:17%'>
					<input class='inpnovisibles' name='bodegad2[]' value='".$_POST[bodegad2][$x]."' type='text'  style='width:100%' readonly>
					<input name='codbodd2[]' value='".$_POST[codbodd2][$x]."' type='hidden'/>
				</td>
					<td  style='width:10%'>
					<input class='inpnovisibles' name='cantidadd[]' value='".$_POST[cantidadd][$x]."' type='text' style='width:100%' readonly>
				</td>
				<td style='width:5%'>
					<a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a>
				</td>
			</tr>";
			$aux=$iter;
			$iter=$iter2;
			$iter2=$aux;
			$total+=($_POST[cantidadd][$x]);
		 }
			$_POST[saldobod] = $_POST[saldobod] - $saldobod;
			echo "<script> document.getElementById('saldobod').value = parseInt(document.getElementById('saldobod').value)-$saldobod;</script>";
			echo "<tr class='saludo2'><td colspan='5'></td><td>".$total."</td><td></td>";
		 ?>
	</table>
</div>

<div class="subpantallac" style="height:100%;width:50%; overflow-x:hidden;">
	<table class="inicio">
		<tr>
    		<td class="titulos" colspan="8">Traslado entre centros de costo</td>
       	</tr>
		<tr>
			<td class="saludo1" style="font-weight: bold; width: 13%">Centro costo</td>
			<td style="width:35%"colspan="3"><input type="text" name="ncentrocosto" id="ncentrocosto" value="<?php echo $_POST[ncentrocosto]?>" style="width:99%" readonly/></td>
			<td class="saludo1" style="font-weight: bold; width: 17%" >Centro costo nuevo</td>
			<td colspan="3">
				<input type="hidden" name="ncentrocostonu" id="ncentrocostonu" value="<?php echo $_POST[ncentrocostonu]; ?>" />
				<select name="centrocostonu" id="centrocostonu"  onKeyUp="return tabular(event,this)" style="width:100%;" onChange="validar();">
					<option value="-1">Seleccione ...</option>
					<?php
						$sqlr="select *from centrocosto where estado='S' order by id_cc";
						$res=mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_row($res)) 
						{
							if("$row[0]"==$_POST[centrocostonu]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>"; $_POST[ncentrocostonu] = $row[1]; }
							else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
						}
					?>	
				</select>
			</td>
		</tr>
		<tr>
			<td class="saludo1" style="font-weight: bold; width: 13%">Valor unitario</td>
			<td style="width:13%"><input type="text" name="valunitcc" id="valunitcc" value="<?php echo $_POST[valunitcc]?>" style="width:95%"/></td>
			<td class="saludo1" style="font-weight: bold; width: 15%">Cantidad actual</td>
			<td><input type="text" name="cantccact" id="cantccact" value="<?php echo $_POST[cantccact]?>" style="width:95%" readonly/></td>
			<td class="saludo1" style="font-weight: bold; width: 17%">Cantidad a trasladar</td>
			<td style="width:8%"><input type="text" name="cantcctras" id="cantcctras" value="<?php echo $_POST[cantcctras]?>" style="width:95%" /></td>
			<td class="saludo1" style="font-weight: bold; width: 10%">Saldo</td>
			<td><input type="text" name="saldocc" id="saldocc" value="<?php echo $_POST[saldocc]?>" style="width:40%; margin-right:10%" readonly/><input name="regcctraslado" id="regcctraslado" type="button" value="Agregar" style="width:50%; height:22px" onClick="agregardettraslado('2')" > </td>
		</tr>
	</table>
	<table class="inicio">
		<tr>
        	<td class="titulos2" style="width: 13%">Codigo Articulo</td>
            <td class="titulos2" style="width: 17%">Nombre Articulo</td>
			<td class="titulos2" style="width: 15%">Valor Unitario</td>
            <td class="titulos2" style="width: 17%">C.C Actual</td>
			<td class="titulos2" style="width: 17%">C.C a Trasladar</td>
			<td class="titulos2" style="width: 10%">Cantidad a Trasladar</td>
            <td class="titulos2" style="width: 5%"><img src="imagenes/del.png" >
            <input type='hidden' name='eliminacc' id='eliminacc'>
			<input name='contadcc' id='contadcc' value='<?php $_POST[contadcc] ?>' type='hidden' style='width:100%' readonly>
            </td>
      	</tr>
		<?php			 
	 if($_POST[eliminacc]!=''){ 
			$posi=$_POST[eliminacc];
		 	unset($_POST[codunsd2][$posi]);
		 	unset($_POST[codinard2][$posi]);
		 	unset($_POST[nomartd2][$posi]);
 		 	unset($_POST[cantidadd2][$posi]);
		 	unset($_POST[unidadd2][$posi]);
		 	unset($_POST[codcc][$posi]);
		 	unset($_POST[ccd][$posi]);
		 	unset($_POST[codcc2][$posi]);
			unset($_POST[ccd2][$posi]);
			unset($_POST[valore2][$posi]);
			unset($_POST[valortotal2][$posi]);
			unset($_POST[codboddcc][$posi]);
			unset($_POST[cuentacon][$posi]);
			unset($_POST[cuentacre][$posi]);
			
		 	$_POST[codunsd2]= array_values($_POST[codunsd2]); 
		 	$_POST[codinard2]= array_values($_POST[codinard2]); 
		 	$_POST[nomartd2]= array_values($_POST[nomartd2]); 		 		 
		 	$_POST[cantidadd2]= array_values($_POST[cantidadd2]); 
		 	$_POST[unidadd2]= array_values($_POST[unidadd2]); 		 		 
		 	$_POST[codcc]= array_values($_POST[codcc]); 		 		 
		 	$_POST[ccd]= array_values($_POST[ccd]); 		 		 
		  	$_POST[codcc2]= array_values($_POST[codcc2]); 
			$_POST[ccd2]= array_values($_POST[ccd2]);
			$_POST[valore2]= array_values($_POST[valore2]);
			$_POST[valortotal2]= array_values($_POST[valortotal2]);
			$_POST[codboddcc]= array_values($_POST[codboddcc]);
			$_POST[cuentacon]= array_values($_POST[cuentacon]);
			$_POST[cuentacre]= array_values($_POST[cuentacre]);
			
			echo"<script>
				document.getElementById('contadcc').value=".count($_POST[codinard2]).";
			</script>";
		}

		if($_POST[agregadet2]=='1'){
			$cantmp=str_replace('.','',$_POST[cantcctras]);
			$numart=0; $posicion=-1;


			//VALIDA2: QUE SUME CANTIDADES AL SACAR EL MISMO ARTICULO
			for ($x=0;$x < count($_POST[codinard2]);$x++){
				if(($_POST[articulo]==$_POST[codinard2][$x]) && ($_POST[centrocostonu]==$_POST[codcc2][$x])){
					$posicion=$x;
				}
			}
			
			//FIN VALIDA2
			if($posicion<=-1){
				$codgrupo= substr($_POST[articulo], 0, 4);
				$sqlrpat="SELECT cuentapatrimonio FROM almparametros";
				//echo $sqlrpat;
				$respat = mysql_query($sqlrpat,$linkbd);
				$cuentapat=mysql_fetch_row($respat);
				
				$sqlrcumdon="SELECT T2.cuenta FROM almgrupoinv T1, conceptoscontables_det T2 WHERE  T1.codigo='$codgrupo' AND T1.concepent=T2.codigo AND T2.cc = '$_POST[centrocosto]' AND T2.modulo='5' AND T2.debito='S' AND T2.estado='S' AND T2.fechainicial=(SELECT MAX(T3.fechainicial) FROM conceptoscontables_det T3 WHERE  T3.codigo=T2.codigo AND T3.cc = '$_POST[centrocosto]' AND T3.modulo='5' AND T3.debito='S' AND T3.estado='S' AND T3.fechainicial<='$fechaf')";
				//echo $sqlrcumdon;
				$rescumdon = mysql_query($sqlrcumdon,$linkbd);
				$cuentart = mysql_fetch_row($rescumdon);
				
				$_POST[codunsd2][]=$_POST[unsart];
				$_POST[codinard2][]=$_POST[articulo];
				$_POST[nomartd2][]=$_POST[narticulo];
				$_POST[cantidadd2][]=$_POST[cantcctras];
				$_POST[unidadd2][]=$_POST[umedida];
				$_POST[codcc][]=$_POST[centrocosto];
				$_POST[ccd][]=$_POST[ncentrocosto];
				$_POST[codcc2][]=$_POST[centrocostonu];
				$_POST[ccd2][]=$_POST[ncentrocostonu];
				$_POST[valore2][]=$_POST[valunitcc];
				$_POST[valortotal2][]=$_POST[valunitcc]*$_POST[cantcctras];
				$_POST[codboddcc][]=$_POST[bodega];
				$_POST[cuentacon][]=$cuentart[0];
				$_POST[cuentacre][]=$cuentapat[0];
			}	

			echo"<script>
				document.getElementById('agregadet2').value='0';
				document.getElementById('contadcc').value=".count($_POST[codinard2]).";
			</script>";
		}
		$iter='saludo1a';
        $iter2='saludo2';
		$total2 = 0;
		$saldocc = 0;
		for ($x=0;$x< count($_POST[codinard2]);$x++){
			if($_POST[articulo] == $_POST[codinard2][$x] && $_POST[centrocosto] == $_POST[codcc][$x]){
				$saldocc +=($_POST[cantidadd2][$x]);
			}
			
	 		echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\">
				<td style='width:13%'>
					<input name='codunsd2[]' value='".$_POST[codunsd2][$x]."' type='hidden'/>
					<input name='unidadd2[]' value='".$_POST[unidadd2][$x]."' type='hidden'/>
					<input name='valortotal2[]' value='".$_POST[valortotal2][$x]."' type='hidden'/>
					<input name='codboddcc[]' value='".$_POST[codboddcc][$x]."' type='hidden'/>
					<input name='cuentacon[]' value='".$_POST[cuentacon][$x]."' type='hidden'/>
					<input name='cuentacre[]' value='".$_POST[cuentacre][$x]."' type='hidden'/>
					<input class='inpnovisibles' name='codinard2[]' value='".$_POST[codinard2][$x]."' type='text' style='width:100%' readonly>
					";
				echo"</td> 
				<td  style='width:17%'>
					<input class='inpnovisibles' name='nomartd2[]' value='".$_POST[nomartd2][$x]."' type='text'  style='width:100%' readonly>
				</td> 
				<td  style='width:15%'>
					<input class='inpnovisibles' name='valore2[]' value='".$_POST[valore2][$x]."' type='text'  style='width:100%' readonly>
				</td> 
				<td  style='width:17%'>
					<input class='inpnovisibles' name='ccd[]' value='".$_POST[ccd][$x]."' type='text' style='width:100%' readonly>
					<input name='codcc[]' value='".$_POST[codcc][$x]."' type='hidden'/>
				</td>
				<td style='width:17%'>
					<input class='inpnovisibles' name='ccd2[]' value='".$_POST[ccd2][$x]."' type='text'  style='width:100%' readonly>
					<input name='codcc2[]' value='".$_POST[codcc2][$x]."' type='hidden'/>
				</td>
					<td  style='width:10%'>
					<input class='inpnovisibles' name='cantidadd2[]' value='".$_POST[cantidadd2][$x]."' type='text' style='width:100%' readonly>
				</td>
				<td style='width:5%'>
					<a href='#' onclick='eliminarcc($x)'><img src='imagenes/del.png'></a>
				</td>
			</tr>";
			$aux=$iter;
			$iter=$iter2;
			$iter2=$aux;
			$total2+=($_POST[cantidadd2][$x]);
			$totalcc+=($_POST[valortotal2][$x]);
		 }
			$_POST[saldocc] = $_POST[saldocc] - $saldocc;
			echo "<script> document.getElementById('saldocc').value = parseInt(document.getElementById('saldocc').value)-$saldocc;</script>";
			echo "<tr class='saludo2'><td colspan='5'></td><td>".$total2."</td><td></td>";
		 ?>
	</table>
</div>

</div>
				<?php
					}break;
					case 4://SALIDA POR DETERIORO O BAJA
					{
					?> 
								<td class="saludo1" width="34%" style="font-weight: bold">Bodega
									<input id="codiun" name="codiun" type="hidden" value="<?php echo $_POST[codiun]?>">
									<input id="numcan" name="numcan" type="hidden" value="<?php echo $_POST[numcan]?>">
									<input id="valunitp" name="valunitp" type="hidden" value="<?php echo $_POST[valunitp]?>">
									<input id="vtotal" name="vtotal" type="hidden" value="<?php echo $_POST[vtotal]?>">
									<input id="docum" name="docum" type="hidden" value="SALIDA POR DETERIORO O BAJA">
									<select name="salbod" id="salbod" onChange="validar()">
										<option value="-1">Seleccione ....</option>
										<?php
										$sqlr="Select * from almbodegas where estado='S' ORDER BY id_cc";
										$resp = mysql_query($sqlr,$linkbd);
										while($row =mysql_fetch_row($resp)) {
											$i=$row[0];
											echo "<option value=$row[0] ";
											if($i==$_POST[salbod]){
												echo "SELECTED";
												$_POST[salbod]=$row[0];
											}
											echo " >".$row[0]." - ".$row[1]."</option>";	  
										}   
										?>
									</select>
								</td>
							</tr>
						</table>
						<div class="subpantalla"  style="height:62%; width:99.8%; overflow-x:hidden;">
							<div class="subpantallac" style="height:9%; overflow:hidden;">
								<table class="inicio">
									<tr>
										<td class="saludo1" width="8%" style="font-weight: bold">.: Art&iacute;culos</td>
										<td style="width:12%;">
											<input type="text" name="articulo" id="articulo" value="<?php echo $_POST[articulo]?>" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="guiabuscar('1');" style="width:80%"/>&nbsp;
											<?php
											if($_POST[salbod]!="-1"){
												$visible="'visible'";
												$numpag="'5'";
												echo'<a onClick="despliegamodal2('.$visible.','.$numpag.');"><img src="imagenes/buscarep.png"/></a>';
											}
											?>
										</td>
										<td style="width:20%;">
											<input type="text" name="narticulo" id="narticulo" value="<?php echo $_POST[narticulo]?>" style="width:100%;text-transform:uppercase" readonly/>
										</td>
										<td class="saludo1" width="10%" style="font-weight: bold">.: Disponibles</td>
										<td style="width:8%;">
											<input type="text" name="dispo" id="dispo" value="<?php echo $_POST[dispo]?>" style="width:80%; text-align:right;" readonly/>
										</td>
										<td class="saludo1" width="10%" style="font-weight: bold">.: Dar de Baja</td>
										<td style="width:8%;">
											<input type="text" name="traslado" id="traslado" value="<?php echo $_POST[traslado]?>" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" style="width:80%; text-align:right;" />
										</td>
										<td class="saludo1" width="5%" style="font-weight: bold">.: U.M</td>
										<td width="25%">
											<select id='unimed' name='unimed' > 
												<?php
												$c=0;
												$sqlr="SELECT unidad FROM almarticulos_det WHERE articulo='$_POST[articulo]' ORDER BY principal DESC, unidad ASC";
												$resp = mysql_query($sqlr,$linkbd);
												while ($row =mysql_fetch_row($resp)){
													$i=$row[0];
													if($i==$_POST[unimed]){
														$_POST[unimed]=$row[0];
														echo"<option value='".$row[0]."' SELECTED>".$row[0]."</option>"; 
													}
													else{
														echo"<option value='".$row[0]."'>".$row[0]."</option>"; 
													}
												}   
												?>
											</select>
										</td>
										<td class="saludo1" width="10%">
											<input name='regbaja' id='regbaja' type='button' value='Confirmar' style='width:100%; height:22px' onClick='agregardetbaja()' > 
										</td>
									</tr>
								</table>
							</div>
							<div class="subpantallac" style="height:86%; overflow-x:hidden;">
							<table class="inicio">
								<tr>
									<td class="titulos" colspan="7">Detalle Gesti&oacute;n Inventario - Traslados</td>
								</tr>
								<tr>
									<td class="titulos2">Codigo UNSPSC</td>
									<td class="titulos2">Codigo Articulo</td>
									<td class="titulos2">Nombre Articulo</td>
									<td class="titulos2">Bodega</td>
									<td class="titulos2">Cantidad</td>
									<td class="titulos2">U.M</td>
									<td class="titulos2"><img src="imagenes/del.png" >
										<input type='hidden' name='elimina' id='elimina'>
						<input name='contad' id='contad' value='<?php $_POST[contad] ?>' type='hidden' style='width:100%' readonly>
									</td>
								</tr>
								<?php			 
								if($_POST[elimina]!=''){ 
									$posi=$_POST[elimina];
									unset($_POST[codunsd][$posi]);
									unset($_POST[codinard][$posi]);
									unset($_POST[nomartd][$posi]);
									unset($_POST[bajad][$posi]);
									unset($_POST[cantidadd][$posi]);
									unset($_POST[unidadd][$posi]);
									unset($_POST[codbodd][$posi]);
									unset($_POST[bodegad][$posi]);
									$_POST[codunsd]= array_values($_POST[codunsd]); 
									$_POST[codinard]= array_values($_POST[codinard]); 
									$_POST[nomartd]= array_values($_POST[nomartd]); 		 		 
									$_POST[bajad]= array_values($_POST[bajad]); 
									$_POST[cantidadd]= array_values($_POST[cantidadd]); 
									$_POST[unidadd]= array_values($_POST[unidadd]); 
									$_POST[codbodd]= array_values($_POST[codbodd]); 
									$_POST[bodegad]= array_values($_POST[bodegad]); 
									echo"<script>
										document.getElementById('contad').value=".count($_POST[codinard]).";
									</script>";
								}
					
								if($_POST[agregadet]=='1'){
									$cantmp=str_replace('.','',$_POST[cantart]);
									$numart=0; $posicion=-1;
									//DEFINIR DISPONIBILIDAD DEL TOTAL DE PRODUCTOS POR BODEGA
									$cantmp=str_replace('.','',$_POST[cantart]);
									$sqla="SELECT almarticulos_exis.existencia, almarticulos_det.factor FROM almarticulos_exis INNER JOIN almarticulos_det ON almarticulos_exis.articulo=almarticulos_det.articulo WHERE almarticulos_det.articulo='$_POST[codart]' AND almarticulos_det.unidad='$_POST[umedida]' AND almarticulos_exis.bodega='$_POST[codbod]'";
									$resa=mysql_query($sqla,$linkbd);
									$rowa=mysql_fetch_array($resa);
									$numbod=$cantmp*$rowa[1];
									for ($x=0;$x < count($_POST[codinard]);$x++){
										if(($_POST[codart]==$_POST[codinard][$x])&&($_POST[codbod]==$_POST[codbodd][$x])){
											$sqla="SELECT factor FROM almarticulos_det WHERE articulo='$_POST[codart]' AND unidad='$_POST[umedida]'";
											$resa=mysql_query($sqla,$linkbd);
											$rowa=mysql_fetch_array($resa);
											$numbod+=$_POST[cantidadd][$x]*$rowa[0];
										}
									}
					
									//VALIDA1: SUMA ARTICULOS
									for ($x=0;$x < count($_POST[codinard]);$x++){
										if($_POST[codart]==$_POST[codinard][$x]){
											$posicion=$x;
											$numart+=$_POST[cantidadd][$x];
										}
									}
									$numart+=$_POST[cantart];
									//FIN VALIDA1
									
									if($numbod<=$_POST[numart]){
										if($posicion<=-1){
											$_POST[codunsd][]=$_POST[unsart];
											$_POST[codinard][]=$_POST[codart];
											$_POST[nomartd][]=$_POST[nomart];
											$_POST[bajad][]=$_POST[numart];
											$_POST[cantidadd][]=$_POST[cantart];
											$_POST[unidadd][]=$_POST[umedida];
											$_POST[codbodd][]=$_POST[codbod];
											$_POST[bodegad][]=$_POST[nombod];
										}	
										else{
											$_POST[cantidadd][$posicion]=$numart;
										}
									}
									else{
										echo"<script>
											despliegamodalm('visible','2','La Cantidad de Articulos a Traslada Supera la Existencia Disponible en Bodega');
										</script>";
									}
									echo"<script>
										document.getElementById('agregadet').value='0';
										document.getElementById('contad').value=".count($_POST[codinard]).";
									</script>";
								}
								$iter='saludo1';
								$iter2='saludo2';
								for ($x=0;$x< count($_POST[codinard]);$x++){
									echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
					onMouseOut=\"this.style.backgroundColor=anterior\">
										<td style='width:10%'>
											<input class='inpnovisibles' name='codunsd[]' value='".$_POST[codunsd][$x]."' type='text' style='width:100%' readonly>
										";
										echo"</td> 
										<td  style='width:10%'>
											<input class='inpnovisibles' name='codinard[]' value='".$_POST[codinard][$x]."' type='text'  style='width:100%' readonly>
										</td> 
										<td  style='width:40%'>
											<input class='inpnovisibles' name='nomartd[]' value='".$_POST[nomartd][$x]."' type='text' style='width:100%' readonly>
										</td>
										<td style='width:20%'>
											<input class='inpnovisibles' name='bodegad[]' value='".$_POST[bodegad][$x]."' type='text' style='width:100%;' readonly>
											<input name='codbodd[]' value='".$_POST[codbodd][$x]."' type='hidden'>
											<input name='bajad[]' value='".$_POST[bajad][$x]."' type='hidden'>
										</td>
										<td style='width:5%'>
											<input class='inpnovisibles' name='cantidadd[]' value='".$_POST[cantidadd][$x]."' type='text' style='width:100%; text-align:right;' readonly>
										</td>
										<td style='width:5%'>
											<input class='inpnovisibles' name='unidadd[]' value='".$_POST[unidadd][$x]."' type='text' style='width:100%; text-align:right;' readonly>
										</td>
										<td style='width:5%'>
											<a href='#' onclick='eliminares($x)'><img src='imagenes/del.png'></a>
										</td>
									</tr>";
									$aux=$iter;
									$iter=$iter2;
									$iter2=$aux;
								 }	 
								 ?>
							</table>
						</div>
					</div>
					<?php 
					}break;
					case 5://SALIDA POR AJUSTE
					{
					?> 
					
					<?php
					
						echo" 
				<td class='saludo1' style='width:6%;'>Documento</td>
				<input type='hidden' id='ntipoentra' name='ntipoentra' value='$_POST[ntipoentra]'/> 
				<input type='hidden' id='codiun' name='codiun'  value='$_POST[codiun]'/>
				<input type='hidden' id='valunitp' name='valunitp' value='$_POST[valunitp]'/>
				<input type='hidden' id='ccselect' name='ccselect' value='$_POST[ccselect]'/>
				<input type='hidden' id='controlaAjuste' name='controlaAjuste' value='$_POST[controlaAjuste]' />
				<td style='width:12%;'>
					<input type='text' name='docum' id='docum' value='$_POST[docum]' onKeyPress='javascript:return solonumeros(event)' onKeyUp='return tabular(event,this)' onBlur=\"guiabuscar('4');\" style='width:80%'/>&nbsp;<img class='icobut' src='imagenes/find02.png'  title='Lista de actos por ajuste' onClick=\"despliegamodal2('visible','9');\"/></td>
				<td colspan='3' style='width:20%'><input type='text' name='ndocum' id='ndocum' value='$_POST[ndocum]' style='width:92.5%;text-transform:uppercase' readonly/></td>
			</tr>
			<tr>
				<td class='saludo1' >Saldo Autorizado</td>
				<td>
				<input type='hidden' name='valorh' id='valorh' value='$_POST[valorh]'/>
				<input type='text' name='valor' id='valor' value='$_POST[valor]' style='width:100%' readonly/>
				</td>
				<td class='saludo1' style='width:6%;'>Tercero</td>
				<td>
					<input type='text' name='tercero' id='tercero' value='$_POST[tercero]' onKeyPress='javascript:return solonumeros(event)' onKeyUp='return tabular(event,this)' onBlur=\"guiabuscar1('1');\" style='width:100%'/ readonly></td>
				<td style='width:20%'><input type='text' name='ntercero' id='ntercero' value='$_POST[ntercero]' style='width:99%;text-transform:uppercase' readonly/></td>
				<td class='saludo1' style='width:10%;'>Concepto Contable</td>
				<td><select style='width:84%' id='cuenta' name='cuenta'><option value='-1'>Seleccione el concepto...</option>";
				$sqlm="SELECT * FROM conceptoscontables WHERE almacen='S' and tipo='C' and modulo='3' ORDER BY codigo";
				$resm=mysql_query($sqlm,$linkbd);
				while($rowm=mysql_fetch_array($resm))
				{
					if("$rowm[0]"==$_POST[cuenta])
					{
						
						echo "<option value='$rowm[0]' style='text-transform:uppercase' SELECTED>$rowm[0] - $rowm[1]</option>";										
					}
					else {
						echo "<option value='$rowm[0]' style='text-transform:uppercase'>$rowm[0] - $rowm[1]</option>";
					}
				}
			echo "</select></td>";
			
			echo"
					
			</tr>
		</table>";?>
		<div class="subpantallac" style="height:18.5%; overflow:hidden;">
			<table class="inicio">
				<tr>
					<td class="titulos2" colspan="15">Art&iacute;culos</td>
				</tr>
				<?php

					if($_POST[controlaAjuste]==''){
						unset($_POST[articulo]);
						unset($_POST[narticulo]);
						unset($_POST[unimed]);
						unset($_POST[numarti]);
						unset($_POST[saldo]);
						unset($_POST[valorunitario]);
						
						$_POST[articulo]= array_values($_POST[articulo]); 
						$_POST[narticulo]= array_values($_POST[narticulo]); 
						$_POST[unimed]= array_values($_POST[unimed]);
						$_POST[numarti]= array_values($_POST[numarti]); 
						$_POST[saldo]= array_values($_POST[saldo]);
						$_POST[valorunitario]= array_values($_POST[valorunitario]); 
					
						$sql = "SELECT codigo,descripcion,unumedida,cantidad,valor,saldo FROM almactoajustesalarticu WHERE idacto='$_POST[docum]' AND estado='S' ";
						$res = mysql_query($sql,$linkbd);
						while($row = mysql_fetch_row($res)){
							$_POST[articulo][]=$row[0];
							$_POST[narticulo][]=$row[1];
							$_POST[unimed][]=$row[2];
							$_POST[numarti][]=$row[5];
							$_POST[saldo][]=$row[5];
							$_POST[valorunitario][]=$row[4];
						}
					}
					
					$readonly = "";
					for($x=0; $x<count($_POST[articulo]);$x++ ){
						
						echo "<tr>
					<td class='saludo1' style='width:5%;'>.: Art&iacute;culo</td>
					<td style='width:5%;'>
						<input type='text' name='articulo[]' value='".$_POST[articulo][$x]."' onKeyPress='javascript:return solonumeros(event)' onKeyUp='return tabular(event,this)' onBlur='guiabuscar1(1);' style='width:95%' readonly/></td>
					<td style='width:12%;'>
						<input type='text' name='narticulo[]' value='".$_POST[narticulo][$x]."' style='width:100%;text-transform:uppercase' readonly/>
					</td>
					<td class='saludo1' style='width:5%;'>.: Saldo</td>
					<td style='width:3%;'><input type='text' name='saldo[]' value='".$_POST[saldo][$x]."' style='width:100%; text-align:right;' onKeyPress='javascript:return solonumeros(event)' readonly/> </td>
					<td class='saludo1' style='width:5%;'>.: Cantidad</td>
					<td style='width:3%;'><input type='text' name='numarti[]' value='".$_POST[numarti][$x]."' style='width:100%; text-align:right;' onKeyPress='javascript:return solonumeros(event)'/> </td>
					<td class='saludo1' style='width:7%;'>.: Valor Unitario</td>
					<td style='width:5%;'><input type='text' name='valorunitario[]' value='".$_POST[valorunitario][$x]."' style='width:100%; text-align:right;' onKeyPress='javascript:return solonumeros(event)' readonly/></td>
					<td class='saludo1' width='5%' style='font-weight: bold'>.: Bodega</td>
					<td style='width:12%;'>
					<input type='hidden' name='nbodega[]' value='".$_POST[nbodega][$x]."' /> 
					<select name='bodega[]' onChange='document.form2.controlaAjuste.value=0; validar();' style='width:100%'> 
						<option value='-1'>Seleccione ....</option>";
				?>	
					<?php
						$sqlr="Select * from almbodegas where estado='S' ORDER BY id_cc";
						$resp = mysql_query($sqlr,$linkbd);
						while($row =mysql_fetch_row($resp)) 
						{
							if($row[0]==$_POST[bodega][$x])
							{
								echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";
								$_POST[bodega]=$row[0];
								$_POST[nbodega]=$row[1];
							}
						   else	{ echo "<option value='$row[0]'>$row[0] - $row[1]</option>";} 
						} 
					?>
					<?php  
			echo"
					</select>
					</td>

					<td class='saludo1' width='7%' style='font-weight: bold'>.: Centro Costo</td>
					<td width='13%'>
						<select name='centrocosto[]' onKeyUp='return tabular(event,this)' style='width:100%;' onChange='validar();'>
						<option value=''>Seleccione ...</option>";
								$sqlr="select *from centrocosto where estado='S' order by id_cc	";
								$res=mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($res)) 
								{
									if("$row[0]"==$_POST[centrocosto][$x]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
									else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
								}

								 	
				echo "
					</select>
					</td>
					<td class='saludo1' width='4%' style='font-weight: bold'>.: U.M</td>
					<td width='13%'>
						<input type='text' name='unimed[]' value='".$_POST[unimed][$x]."' style='width: 43%;' readonly/>
						<input name='regajus' id='regajus' type='button' value='Agregar' style='width:40%; height:22px' onClick='agregardetajuste($x)' > 
						<input type='hidden' name='posAjuste' id='posAjuste' value='$_POST[posAjuste]'/>
					</td>
				</tr>";
				
					}

				?>
				

			</table>
		</div>
	<div class="subpantallac" style="height:82%; overflow-x:hidden;">
		<table class="inicio">
			<tr>
				<td class="titulos" colspan="10">Detalle Gesti&oacute;n Inventario - Entrada por Ajuste</td>
			</tr>
			<tr class="titulos2">
				<td>C&oacute;digo Articulo</td>
				<td>Nombre Articulo</td>
				<td>Bodega</td>
				<td>Cantidad</td>
				<td>Valor Unitario</td>
				<td>Valor Total</td>
				<td>Concepto</td>
				<td>U.M</td>
				<td>C.C</td>
				<td><img src="imagenes/del.png"></td>
			</tr>
			<input type='hidden' name='elimina' id='elimina'/>
			<input type='hidden' name='contad' id='contad' value='<?php $_POST[contad] ?>'/>
			<?php			 
			if($_POST[elimina]!='')
			{ 
				$posi=$_POST[elimina];
				unset($_POST[codunsd][$posi]);
				unset($_POST[codinard][$posi]);
				unset($_POST[nomartd][$posi]);
				unset($_POST[cantidadd][$posi]);
				unset($_POST[unidadd][$posi]);
				unset($_POST[codbodd][$posi]);
				unset($_POST[bodegad][$posi]);
				unset($_POST[valortotal1][$posi]);
				unset($_POST[dcuentas][$posi]);
				unset($_POST[dcc][$posi]);
				unset($_POST[cuentacon][$posi]);
				
				$_POST[codunsd]= array_values($_POST[codunsd]); 
				$_POST[codinard]= array_values($_POST[codinard]); 
				$_POST[nomartd]= array_values($_POST[nomartd]);
				$_POST[cantidadd]= array_values($_POST[cantidadd]); 
				$_POST[unidadd]= array_values($_POST[unidadd]); 
				$_POST[codbodd]= array_values($_POST[codbodd]); 
				$_POST[bodegad]= array_values($_POST[bodegad]); 
				$_POST[valortotal1]= array_values($_POST[valortotal1]);
				$_POST[dcuentas]= array_values($_POST[dcuentas]);
				$_POST[dcc] = array_values($_POST[dcc]);
				$_POST[cuentacon] = array_values($_POST[cuentacon]);
				
				echo"<script> document.getElementById('contad').value=".count($_POST[codinard])."; </script>";
			}
			$valorto=0;
			if($_POST[agregadet]=='1')
			{
				
				$pos = $_POST[posAjuste];
				$saldoinvcc=totalinventario2($_POST[codart]);
				if($_POST[cantart] > $saldoinvcc){
					echo "<script>document.getElementsByName('saldo[]').item(".$pos.").value =  document.getElementsByName('saldo[]').item(".$pos.").value + ".$_POST[cantart]."; </script>";
					echo "<script>despliegamodalm('visible','2','El saldo del acto no coincide con el saldo del inventario para el centro de costo "+ $_POST[centrocosto][$pos] +"');</script>";
				}else{
					$sql = "";
					$cantmp=str_replace('.','',$_POST[cantart]);
					$numart=0; $posicion=-1;
					
					//VALIDA1: SUMA ARTICULOS
					for ($x=0;$x < count($_POST[codinard]);$x++)
					{
						if(($_POST[codart]==$_POST[codinard][$x])&&($_POST[centrocosto][$x]==$_POST[dcc][$x])&&($_POST[codbod]==$_POST[codbodd][$x]))
						{
							$posicion=$x;
							$numart+=$_POST[cantidadd][$x];
						}
					}
					$numart+=$_POST[cantart];
					
					//FIN VALIDA1
					$valorto=$_POST[valorunitario][$pos]*$numart;
					
					
					$codgrupo= substr($_POST[codart], 0, 4);
					
					$codarticulo= substr($_POST[codart], -5);
					
					$sqlrcumdon="SELECT T2.cuenta FROM almgrupoinv T1, conceptoscontables_det T2 WHERE  T1.codigo='$codgrupo' AND T1.concepent=T2.codigo AND T2.cc = '".$_POST[centrocosto][$pos]."' AND T2.modulo='5' AND T2.debito='S' AND T2.estado='S' AND T2.fechainicial=(SELECT MAX(T3.fechainicial) FROM conceptoscontables_det T3 WHERE  T3.codigo=T2.codigo AND T3.cc = '".$_POST[centrocosto][$pos]."' AND T3.modulo='5' AND T3.debito='S' AND T3.estado='S' AND T3.fechainicial<='$fechaf')";
					//echo $sqlrcumdon;
					$rescumdon = mysql_query($sqlrcumdon,$linkbd);
					$cuentadeb = mysql_fetch_row($rescumdon);

					$sql="SELECT codunspsc from almarticulos WHERE estado='S' AND codigo='$codarticulo' ";
					$res = mysql_query($sql,$linkbd);
					$row_articulo = mysql_fetch_row($res);
					
					if($posicion<=-1)
					{
						$_POST[codunsd][]=$row_articulo[0];
						$_POST[codinard][]=$_POST[codart];
						$_POST[nomartd][]=$_POST[nomart];
						$_POST[cantidadd][]=$_POST[cantart];
						$_POST[valore][]=$_POST[valorunitario][$pos];
						$_POST[unidadd][]=$_POST[umedida];
						$_POST[codbodd][]=$_POST[codbod];
						$_POST[bodegad][]=$_POST[nbodega];
						$_POST[valortotal1][]=$valorto;
						$_POST[dcuentas][]=$_POST[cuenta];
						$_POST[dcc][] = $_POST[centrocosto][$pos];
						$_POST[cuentacon][] = $cuentadeb[0];
					}	
					else{
						$_POST[cantidadd][$posicion]=$numart;
						$_POST[valortotal1][$posicion]=$valorto;
					}
					echo"<script>
						document.getElementById('posAjuste').value='';
						document.getElementById('agregadet').value='0';
						document.getElementById('contad').value=".count($_POST[codinard]).";
					</script>";
				}
				
				

			}
			$iter='saludo1a';
			$iter2='saludo2';
			for ($x=0;$x< count($_POST[codinard]);$x++)
			{
				echo "
				<tr class='$iter'>
					<input type='hidden' name='codunsd[]' value='".$_POST[codunsd][$x]."'/>
					<input type='hidden' name='codinard[]' value='".$_POST[codinard][$x]."'/>
					<input type='hidden' name='nomartd[]' value='".$_POST[nomartd][$x]."'/>
					<input type='hidden' name='bodegad[]' value='".$_POST[bodegad][$x]."'/>
					<input type='hidden' name='codbodd[]' value='".$_POST[codbodd][$x]."'/>
					<input type='hidden' name='cantidadd[]' value='".$_POST[cantidadd][$x]."'/>
					<input type='hidden' name='unidadd[]' value='".$_POST[unidadd][$x]."'/>
					<input type='hidden' name='valortotal1[]' value='".$_POST[valortotal1][$x]."'/>
					<input type='hidden' name='dcuentas[]' value='".$_POST[dcuentas][$x]."'/>
					<input type='hidden' name='valore[]' value='".$_POST[valore][$x]."'/>
					<input type='hidden' name='dcc[]' value='".$_POST[dcc][$x]."'/>
					<input type='hidden' name='cuentacon[]' value='".$_POST[cuentacon][$x]."'/>
					<td style='width:10%'>".$_POST[codinard][$x]."</td> 
					<td style=''>".$_POST[nomartd][$x]."</td>
					<td style='width:20%'>".$_POST[bodegad][$x]."</td>
					<td style='width:5%;text-align:right;'>".$_POST[cantidadd][$x]."</td>
					<td style='width:8%;text-align:right;'>$ ".number_format($_POST[valore][$x],0,',','.')."</td>
					<td style='width:10%;text-align:right;'>$ ".number_format($_POST[valortotal1][$x],0,',','.')."</td>
					<td style='width:5%;text-align:right;'>".$_POST[dcuentas][$x]."</td>
					<td style='width:6%;text-align:right;'>".$_POST[unidadd][$x]."</td>
					<td style='width:6%;text-align:right;'>".$_POST[dcc][$x]."</td>
					<td style='width:5%'><img src='imagenes/del.png' class='icobut' onclick='eliminares($x)'></td>
				</tr>";
				$aux=$iter;
				$iter=$iter2;
				$iter2=$aux;
			 }	 
			 $sumvalortotal=array_sum($_POST[valortotal1]);
			 echo"
				<tr>
					<td colspan='5'></td>
					<td style='text-align:right;'>$".number_format($sumvalortotal,0,',','.')."</td>
					<td colspan='2'></td>
				</tr>";
			 ?>
		</table>
	</div>
					
					<?php 
					}break;
					case 6://SALIDA DIRECTA
					{
						
						if($_POST[busqueda]!="")
						{
							if($_POST[busqueda]=="6")
							{
								if($_POST[bodega]=='')
								{
									$_POST[bodega]=$_POST[bodegaParaBuscar];
								}
								$disponible=totalinventarioConRutina($_POST[docum],$_POST[bodega]);
								
								if($disponible>0)
								{
									$sqlr="SELECT * FROM almarticulos WHERE estado='S' AND concat_ws('', grupoinven, codigo) LIKE '%$_POST[docum]%' ORDER BY length(grupoinven),grupoinven ASC, length(codigo),codigo ASC";
									$resp=mysql_query($sqlr,$linkbd);
									$row=mysql_fetch_row($resp);
									$unprinart=almconculta_um_principal($_POST[docum]);

									$_POST[codigoarticulo] = $_POST[docum];
									$_POST[ndocum] = $row[1];
									$_POST[narticulo] = $row[1];
									$_POST[codigounspsc] = $row[2];
									$_POST[cbodega] = $disponible;
									$_POST[unidadmedidaart] = $unprinart;
									$_POST[disableBodega] = 'disabled';
									echo"
									<script>
										document.getElementById('busqueda').value='';
									</script>";
								}
								else
								{
									echo"
									<script>
										despliegamodalm('visible','2','Código del Documento Incorrecto o no tiene disponibilidades en bodega');
									</script>";
								}
							}
						}
						?>
						<td class="saludo1" style="width:6%;">.: Bodega:</td>
						<td style="width:15%">
							
							<input type="hidden" name="disableBodega" id="disableBodega" value="<?php echo $_POST[disableBodega]; ?>"/>
							<select name="bodega" id="bodega" style="width:100%" <?php echo $_POST[disableBodega]; ?>>
								<?php
								$sqlr="Select * from almbodegas where estado='S' ORDER BY id_cc";
								$resp = mysql_query($sqlr,$linkbd);
								while($row =mysql_fetch_row($resp)) {
									$i=$row[0];
									echo "<option value=$row[0] ";
									if($i==$_POST[bodega]){
										$_POST[nombodega] = $row[0]." - ".$row[1];
										echo "SELECTED";
										$_POST[bodega]=$row[0];
									}
									echo " >".$row[0]." - ".$row[1]."</option>";	  
								}   
								?>
							</select>
							<input type="hidden" name="nombodega" id="nombodega" value="<?php echo $_POST[nombodega]; ?>"/>
							<input type="hidden" name="bodegaParaBuscar" id="bodegaParaBuscar" value="<?php echo $_POST[bodega]; ?>"/>
						</td>
						<?php
						echo"
								<td class='saludo1' style='width:6%;'>Articulo:</td>
								<td style='width:15%;'>
									<input type='text' name='docum' id='docum' value='$_POST[docum]' onKeyPress='javascript:return solonumeros(event)' onKeyUp='return tabular(event,this)' onBlur=\"guiabuscar('6');reiniciar();\" style='width:80%'/>&nbsp;
									<img src='imagenes/find02.png' onClick=\"despliegamodal2('visible','8');reiniciar();\" class='icobut' title='Lista de Reservas'/>
								</td>
								<td width='50%'>
									<input type='text' name='ndocum' id='ndocum' value='$_POST[ndocum]' style='width:100%; text-transform:uppercase' readonly/>
									
								</td>
							</tr>
						</table>
						<div class='subpantalla' style='height:62%; width:99.8%; overflow-x:hidden;'>
							<div class='subpantallac' style='height:18%; overflow:hidden;'>";
								//BUSQUEDA
						
							if(!isset($_POST[cbodegasalida])){
								$_POST[cbodegasalida] = 0;
							}
							?>
							<table class="inicio ancho" align="center" >
							<tr>
								<td class="saludo1" style="width:3.6cm;">.: C&oacute;digo Articulo:</td>
								<td style="width:9%;"><input type="text" name="codigoarticulo" id="codigoarticulo" value="<?php echo $_POST[codigoarticulo]?>" style="width:100%;" readonly/></td>
								<input type="hidden" name="codigounspsc" id="codigounspsc" value="<?php echo $_POST[codigounspsc]?>" style="width:100%;" readonly/>
								<td class="saludo1" style="width:4cm;">.: Nombre Articulo:</td>
								<td colspan="3"><input type="text" name="narticulo" id="narticulo" value="<?php echo $_POST[narticulo]?>" style="width:100%;text-transform:uppercase" readonly/></td>
								
								<td class="saludo1" style="width:3.2cm;">.: Centro de Costo:</td>
								<td style="width:10%;">
									<select name="cc" id="cc"  style="width:100%;text-align:right;">
										<?php
										$sql="SELECT id_cc,nombre FROM centrocosto WHERE estado='S' AND entidad='S' ORDER BY id_cc";
										$result=mysql_query($sql,$linkbd);
										while($row = mysql_fetch_row($result)){
											echo "<option value='$row[0]'>$row[1]</option>";
										}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="saludo1">.: Cantidad Bodega:</td>
								<td ><input type="text" name="cbodega" id="cbodega" value="<?php echo $_POST[cbodega];?>" style="width:100%;" readonly/></td>
								<td class="saludo1">.: Unidad de Medida:</td>
								<td>
									<input type="text" name="unidadmedidaart" id="unidadmedidaart" value="<?php echo $_POST[unidadmedidaart];?>" style="width:100%;" readonly/>
								</td>
								<td class="saludo1">.: Cantidad Salida:</td>
								<td ><input type="text" name="cbodegasalida" id="cbodegasalida" value="<?php echo $_POST[cbodegasalida];?>" onKeyPress="javascript:return solonumerossinpuntos(event)" style="width:100%;"/></td>

								<td class="saludo1" style="width:3.6cm;">.: Conceptos Contables:</td>
								<td ><select id="cuenta" name="cuenta" style="width:100%">
									<option value="">Seleccione...</option>
									<?php
									$sqlm="SELECT * FROM conceptoscontables WHERE almacen='S' AND modulo=3 ORDER BY codigo";
									$resm=mysql_query($sqlm,$linkbd);
									while($rowm=mysql_fetch_array($resm))
									{
										if("$rowm[0]"==$_POST[cuenta])
										{
											$_POST[ncuenta]=$rowm[1];
											echo "<option value='$rowm[0]' style='text-transform:uppercase' SELECTED>$rowm[0] - $rowm[1]</option>";										
										}
										else {
											echo "<option value='$rowm[0]' style='text-transform:uppercase'>$rowm[0] - $rowm[1]</option>";
										}
									}
									?>
								</select>
								<input type="hidden" name="ncuenta" id="ncuenta" value="<?php echo $_POST[ncuenta]?>" >
								</td>
								<td colspan="2"><center><em class='botonflecha' onClick="agregararticulo();" style='float:rigth;'>Agregar articulo</em></center></td>
							</tr>

						</table>
							</div>
							<div class="subpantallac" style="height:65%; overflow-x:hidden;">
							<table class="inicio">
								<tr>
									<td class="titulos" colspan="13">Detalle Gesti&oacute;n Inventario - Salida</td>
								</tr>
								<tr class="centrartext">
									<td class="titulos2">Codigo Articulo</td>
									<td class="titulos2">Nombre Articulo</td>
									<td class="titulos2">Cantidad en Bodega</td>
									<td class="titulos2">Cantidad Entregada</td>
									<td class="titulos2">Cod. Cuenta</td>
									<td class="titulos2">Cuenta</td>
									<td class="titulos2">c.c</td>
									<td class="titulos2">U.M</td>
									<td class="titulos2">Bodega</td>
									<td class="titulos2">Valor Unitario</td>
									<td class="titulos2">Valor Total</td>
									<td class="titulos2"><img src="imagenes/del.png" >
										<input type="hidden" name="elimina" id="elimina">
										<input name="contad" id="contad" value="<?php $_POST[contad] ?>" type="hidden" style="width:100%" readonly>
									</td>
								</tr>
								<?php			 
								if($_POST[elimina]!=''){ 
									$posi=$_POST[elimina];
									unset($_POST[codunsd][$posi]);
									unset($_POST[codinard][$posi]);
									unset($_POST[nomartd][$posi]);
									unset($_POST[reservad][$posi]);
									//unset($_POST[unidadd][$posi]);
									unset($_POST[cantidadd][$posi]);
									unset($_POST[undadd][$posi]);
									unset($_POST[codbodd][$posi]);
									unset($_POST[bodegad][$posi]);
								    unset($_POST[agcuen][$posi]);
						   	        unset($_POST[agncue][$posi]);
									unset($_POST[ccd][$posi]);
									
									$_POST[codunsd]= array_values($_POST[codunsd]); 
									$_POST[codinard]= array_values($_POST[codinard]); 
									$_POST[nomartd]= array_values($_POST[nomartd]); 		 		 
									$_POST[reservad]= array_values($_POST[reservad]); 
									//$_POST[unidadd]= array_values($_POST[unidadd]); 
									$_POST[cantidadd]= array_values($_POST[cantidadd]); 
									$_POST[undadd] = array_values($_POST[undadd]); 
									$_POST[codbodd]= array_values($_POST[codbodd]); 
									$_POST[bodegad]= array_values($_POST[bodegad]); 
									$_POST[agcuen]= array_values($_POST[agcuen]); 
									$_POST[agncue]= array_values($_POST[agncue]);
									$_POST[ccd]= array_values($_POST[ccd]);
									
									echo"<script>
										document.getElementById('contad').value=".count($_POST[codinard]).";
									</script>";
								}
								
								if($_POST[agregadet]=='1'){
									//DEFINIR DISPONIBILIDAD DEL TOTAL DE PRODUCTOS
									$cantmp = str_replace('.','',$_POST[cbodegasalida]);
									$disponible = totalinventario1($_POST[codigoarticulo]);
									$fact = almconsulta_factorarticulo($_POST[codigoarticulo],$_POST[unidadmedidaart]);
									$numcon = $cantmp/$fact;
									if($numcon>$disponible)
										$supero=1;
									else
										$supero=0;
									
									if($supero<1){
										
										$numart=0; $posicion=-1; $numbod=0;
										//DEFINIR DISPONIBILIDAD DEL TOTAL DE PRODUCTOS POR BODEGA
										$disponible = totalinventario1($_POST[codigoarticulo]);
										$totbod=$disponible;
										$numbod=$cantmp/$fact;

										if($numbod>$totbod)
											$supbod=1;
										else
											$supbod=0;
											
										//FIN DISPONIBILIDAD
										if($supbod<1){
											//VALIDA1: QUE NO SUPERE LAS CANTIDAD REGISTRADAS EN LA ENTRADA
											for ($x=0;$x < count($_POST[codinard]);$x++){
												if($_POST[codart]==$_POST[codinard][$x]){
													$f = almconsulta_factorarticulo($_POST[codigoarticulo],$_POST[undadd][$x]);
													$numart+=($_POST[cantidadd][$x]/$f);
												}
											}
											$numart+=($_POST[cbodegasalida]/$fact);

											//VALIDA2: QUE SUME CANTIDADES AL SACAR EL MISMO ARTICULO
											for ($x=0;$x < count($_POST[codinard]);$x++){
												if(($_POST[codigoarticulo]==$_POST[codinard][$x])&&($_POST[bodega]==$_POST[codbodd][$x])){
													$posicion=$x;
													$totalart=$_POST[cantidadd][$x];
												}
											}
											//CONVERTIR A UNIDAD PRINCIPAL 
											$f = almconsulta_factorarticulo($_POST[codigoarticulo],$_POST[unidadmedidaart]);
											//FIN CONVERTIR A UNIDAD PRINCIPAL 
											$totalart+=($_POST[cbodegasalida]/$fact)*$f;
											//FIN VALIDA2
											
											if($numart<=($_POST[cbodega]/$f)){
												if($posicion<=-1){
													$_POST[codunsd][]=$_POST[codigounspsc];
													$_POST[codinard][]=$_POST[codigoarticulo];
													$_POST[nomartd][]=$_POST[narticulo];
													$_POST[reservad][]=$_POST[cbodega];
													//$_POST[unidadd][]=$_POST[unidadmedidaart];
													$_POST[cantidadd][]=($_POST[cbodegasalida]/$fact)*$f;
													$_POST[undadd][]=$_POST[unidadmedidaart];
													$_POST[codbodd][]=$_POST[bodega];
													$_POST[bodegad][]=$_POST[nombodega];
													$_POST[agcuen][]=$_POST[cuenta];
													$_POST[agncue][]=$_POST[ncuenta]; 
													$_POST[ccd][]=$_POST[cc];
												}	
												else{
													$_POST[cantidadd][$posicion]=$totalart;
												}
											}
											else{
												echo"<script>
													despliegamodalm('visible','2','La Cantidad de Articulos a Entregar Supera la Cantidad descrita en la Reserva');
												</script>";
											}
											echo"<script>
												document.getElementById('agregadet').value='0';
												document.getElementById('contad').value=".count($_POST[codinard]).";
												document.getElementById('cbodegasalida').value='0';
												document.getElementById('cuenta').value='';
												document.getElementById('docum').value='';
												document.getElementById('ndocum').value='';
												document.getElementById('cbodega').value='';
												document.getElementById('codigounspsc').value='';
												document.getElementById('narticulo').value='';
												document.getElementById('unidadmedidaart').value='';
												document.getElementById('codigoarticulo').value='';
												document.getElementById('bodega').disabled='';
												document.getElementById('disableBodega').value='';
											</script>";
										}
										else{
											echo"<script>
												despliegamodalm('visible','2','La Cantidad de Articulos a Reservar supera la Existencia en Bodega');
											</script>";
										}
										
									} //aQUI
									else{
										echo"<script>
											despliegamodalm('visible','2','La Cantidad de Articulos a Reservar supera a la Existencia Total');
										</script>";
									}

								}
								
								$iter='saludo1';
								$iter2='saludo2';
								$valtotf=0;
								$totalcab=0;
								for ($x=0;$x< count($_POST[codinard]);$x++){
									$valtotf=str_replace('.','',$_POST[cantidadd][$x]);
									$totalcab+=$valtotf;
									//CACULAR VALOR DE SALIDA KARDEX PROMEDIO PONDERADO
									if($valtotf>0){
										$sqlpp = "SELECT T2.valorunit,T2.cantidad_entrada,T2.cantidad_salida,T2.unidad FROM almginventario T1 INNER JOIN almginventario_det T2 ON CONCAT(T1.consec,T1.tipomov)=CONCAT(T2.codigo,T2.tipomov) WHERE T2.codart='".$_POST[codinard][$x]."'";
										//echo $sqlpp;
										$data = view($sqlpp);
										$valtotal = 0;
										$canttotal = 0;
										foreach ($data as $key => $val) {
											$f1 = almconsulta_factorarticulo($_POST[codinard][$x],$val[unidad]);
											$rec = 1/$f1;
											$rec_val = $val[valorunit];
											$f2 = almconsulta_factorarticulo($_POST[codinard][$x],$_POST[undadd][$x]);
											$res = 1/$f2;
											$res_val = ($rec_val*$res)/$rec;
											$cantidad_entrada = ($val[cantidad_entrada]*$rec)/$res;
											$cantidad_salida = ($val[cantidad_salida]*$rec)/$res;
											$valtotal += ($res_val*$cantidad_entrada)-($res_val*$cantidad_salida);
											$canttotal += $cantidad_entrada-$cantidad_salida;
										}
										$valor_unit = $valtotal/$canttotal;
									}else{
										$valor_unit = 0;
									}
									$valtotall = $valtotf*$valor_unit;
									echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
					onMouseOut=\"this.style.backgroundColor=anterior\">
										";
										echo"
										<td  style='width:10%'>
											<input class='inpnovisibles' name='codinard[]' value='".$_POST[codinard][$x]."' type='text'  style='width:100%' readonly>
											<input class='inpnovisibles' name='codunsd[]' id='codunsd' value='".$_POST[codunsd][$x]."' type='hidden' style='width:100%' readonly>
										</td> 
										<td  style='width:25%'>
											<input class='inpnovisibles' name='nomartd[]' value='".$_POST[nomartd][$x]."' type='text' style='width:100%' readonly>
										</td>
										<td style='width:5%'>
											<input class='inpnovisibles centrartext' name='reservad[]' value='".$_POST[reservad][$x]."' type='text'  style='width:100%' readonly>
										</td>
										<td style='width:5%'>
											<input class='inpnovisibles centrartext' value='".round($_POST[cantidadd][$x], 2)."' type='text' style='width:100%; text-align:right;' readonly>
											<input name='cantidadd[]' value='".$_POST[cantidadd][$x]."' type='hidden'>
										</td>
										<td style='width:5%'>
											<input class='inpnovisibles centrartext' name='agcuen[]' value='".$_POST[agcuen][$x]."' type='text'  style='width:100%' readonly>
										</td>
										<td style='width:10%'>
											<input class='inpnovisibles' name='agncue[]' value='".$_POST[agncue][$x]."' type='text'  style='width:100%' readonly>
										</td>
										<td style='width:5%'>
											<input class='inpnovisibles centrartext' name='ccd[]' value='".$_POST[ccd][$x]."' type='text'  style='width:100%' readonly>
										</td>
										<td style='width:5%'>
											<input class='inpnovisibles centrartext' name='undadd[]' value='".$_POST[undadd][$x]."' type='text'  style='width:100%' readonly>
										</td>
										<td style='width:12%'>
											<input class='inpnovisibles' name='bodegad[]' value='".$_POST[bodegad][$x]."' type='text' style='width:100%;' readonly>
											<input name='codbodd[]' value='".$_POST[codbodd][$x]."' type='hidden'>
										</td>
										<td style='width:10%'>
											<input class='inpnovisibles' name='' value='$".number_format($valor_unit,2,',','.')."' type='text'  style='width:100%; text-align:right' readonly>
										</td>
										<td style='width:10%'>
											<input class='inpnovisibles' name='' value='$".number_format($valtotall,2,',','.')."' type='text'  style='width:100%; text-align:right' readonly>
										</td>
										<td style='width:5%'>
											<a href='#' onclick='eliminares($x)'><img src='imagenes/del.png'></a>
										</td>
									</tr>";
									$aux=$iter;
									$iter=$iter2;
									$iter2=$aux;
								 }	 
								 ?>
							</table>
						</div>
					</div>
					<?php 
					}break;
				}
}
//FIN TIPO MOV 2
?> 

<!--REVERSIONES -->
<?php 
if($_POST[tipomov]>2)
{
?> 
	<table class="inicio">
		<tr>
    		<td colspan="5" class="titulos2">Gesti&oacute;n Inventario - Reversiones</td>
       	</tr>
		<tr>
			<td class="saludo1" width="8%">Tipo Reversi&oacute;n</td>
	    	<td valign="middle" width="10%">
    	   		<select name="tipoentra" id="tipoentra" onChange="validar()" >
					<option value="-1">Seleccione ....</option>
						<?php
					 	$sqlr="Select * from almtipomov where tipom='$_POST[tipomov]' ORDER BY tipom, codigo";
						$resp = mysql_query($sqlr,$linkbd);
						while($row =mysql_fetch_row($resp)) {
							$i=$row[0];
							echo "<option value=$row[0] ";
							if($i==$_POST[tipoentra]){
				 				echo "SELECTED";
				 				$_POST[tipoentra]=$row[0];
			 				}
							echo " >".$row[1].$row[0]." - ".$row[2]."</option>";	  
			     		}   
						?>
		  		</select>
        	</td>
			<?php
			switch($_POST[tipoentra]){
				case 1:
				?>
						<td class="saludo1" width="6%" style="font-weight: bold">Documento</td>
						<td style="width:12%;">
							<input type="text" name="docum" id="docum" value="<?php echo $_POST[docum]?>" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="guiabuscar('4');" style="width:80%"/>&nbsp;<img class="icobut" src="imagenes/find02.png" title="Lista de Documentos" onclick="despliegamodal2('visible','11');resetear();">
						</td>
						<td width="50%">
							<input type="text" name="ndocum" id="ndocum" value="<?php echo $_POST[ndocum]?>" style="width:100%;text-transform:uppercase" readonly/>
						</td>
					</tr>
				</table>
				<div class="subpantalla"  style="height:70%; width:99.8%; overflow:hidden;">

					<div class="subpantallac" style="height:60%; overflow-x:hidden;">
					
					<table class="inicio">
						<tr>
							<td class="titulos" colspan="8">Detalle Gesti&oacute;n Inventario - Reversi&oacute;n de Movimientos</td>
						</tr>
						<tr>
							<td class="titulos2">Codigo UNSPSC</td>
							<td class="titulos2">Codigo Articulo</td>
							<td class="titulos2">Nombre Articulo</td>
							<td class="titulos2">Cantidad Registrada</td>
							<td class="titulos2">Cantidad Reversi&oacute;n</td>
							<td class="titulos2">U.M</td>
							<td class="titulos2">Bodega</td>
							<input type='hidden' name='elimina' id='elimina'>
							<input type='hidden' name='reset' id='reset'>
							<input name='contad' id='contad' value='<?php $_POST[contad] ?>' type='hidden' >
						</tr>
						<?php	
						if(!empty($_POST[docum])){
							$sql="SELECT unspsc,codart,cantidad_salida,valorunit,valortotal,unidad,bodega,id_det FROM almginventario_det WHERE tipomov='2' AND tiporeg='01' AND codigo=$_POST[docum]";
							//echo $sql;
							$res=mysql_query($sql,$linkbd);
							while($row = mysql_fetch_row($res)){
								//Se obtiene el nombre del articulo
								$grupo = substr($row[1],0,4);
								$codigo = substr($row[1],4);
								$sqlnom = "SELECT nombre FROM almarticulos WHERE grupoinven='$grupo' AND codigo='$codigo' AND estado='S'";
								$resnom = mysql_query($sqlnom,$linkbd);
								$rownom = mysql_fetch_row($resnom);
								//Se obtiene el nombre de la bodega
								$sqlbod="Select nombre from almbodegas where estado='S' AND id_cc=$row[6] ORDER BY id_cc";
								$resbod = mysql_query($sqlbod,$linkbd);
								$rowbod = mysql_fetch_row($resbod);
							
								$_POST[codunsd][]=$row[0];
								$_POST[codinard][]=$row[1];
								$_POST[nomartd][]=$rownom[0];
								$_POST[revertid][]=$row[2];
								$_POST[cantidadd][]=$row[2];
								$_POST[unidadd][]=$row[5];
								$_POST[codbodd][]=$row[6];
								$_POST[bodegad][]=$row[6]." - ".$rowbod[0];
								$_POST[dcoddetalle][]=$row[7];
							}
							
											
							$iter='saludo1';
							$iter2='saludo2';
							for ($x=0;$x< count($_POST[codinard]);$x++)
							{
								echo "<tr class='$iter' >
									<td style='width:10%'>
										<input class='inpnovisibles' name='codunsd[]' value='".$_POST[codunsd][$x]."' type='text' style='width:100%' readonly>
									";
									echo"</td> 
									<td  style='width:10%'>
										<input class='inpnovisibles' name='codinard[]' value='".$_POST[codinard][$x]."' type='text'  style='width:100%' readonly>
									</td> 
									<td  style='width:35%'>
										<input class='inpnovisibles' name='nomartd[]' value='".$_POST[nomartd][$x]."' type='text' style='width:100%' readonly>
									</td>
									<td style='width:5%'>
										<input class='inpnovisibles' name='revertid[]' value='".$_POST[revertid][$x]."' type='text'  style='width:100%' readonly>
									</td>
									<td style='width:5%'>
										<input class='inpnovisibles' name='cantidadd[]' value='".$_POST[cantidadd][$x]."' type='text' style='width:100%; text-align:right;' readonly>
									</td>
									<td style='width:5%'>
										<input class='inpnovisibles' name='unidadd[]' value='".$_POST[unidadd][$x]."' type='text' style='width:100%; text-align:right;' readonly>
									</td>
									<td style='width:25%'>
										<input class='inpnovisibles' name='bodegad[]' value='".$_POST[bodegad][$x]."' type='text' style='width:100%;' readonly>
										<input name='codbodd[]' value='".$_POST[codbodd][$x]."' type='hidden'>
										<input name='dcoddetalle[]' value='".$_POST[dcoddetalle][$x]."' type='hidden'>
									</td>
								</tr>";
								$aux=$iter;
								$iter=$iter2;
								$iter2=$aux;
							 }
						}
							 
						 ?>
					</table>
				</div>
			</div>
				<?php
				break;
				
				case 2:
				?>
				<td class="saludo1" width="6%" style="font-weight: bold">Documento</td>
					<td style="width:12%;">
						<input type="text" name="docum" id="docum" value="<?php echo $_POST[docum]?>" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="guiabuscar('4');" style="width:80%"/>&nbsp;<img class="icobut" src="imagenes/find02.png" title="Lista de Documentos" onclick="despliegamodal2('visible','4');resetear();">
					</td>
					<td width="50%">
						<input type="text" name="ndocum" id="ndocum" value="<?php echo $_POST[ndocum]?>" style="width:100%;text-transform:uppercase" readonly/>
					</td>
				</tr>
			</table>
				<?php
				break;
				
				case 3:
				?>
				<td class="saludo1" width="6%" style="font-weight: bold">Documento</td>
					<td style="width:12%;">
						<input type="text" name="docum" id="docum" value="<?php echo $_POST[docum]?>" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="guiabuscar('4');" style="width:80%"/>&nbsp;<img class="icobut" src="imagenes/find02.png" title="Lista de Documentos" onclick="despliegamodal2('visible','4');resetear();">
					</td>
					<td width="50%">
						<input type="text" name="ndocum" id="ndocum" value="<?php echo $_POST[ndocum]?>" style="width:100%;text-transform:uppercase" readonly/>
					</td>
				</tr>
			</table>
			<div class="subpantalla"  style="height:62%; width:99.8%; overflow:hidden;display:flex">

			<div class="subpantallac" style="height:100%;width:50%; overflow-x:hidden">
			<table class="inicio">
				<tr>
					<td class="titulos" colspan="8">Traslado entre bodegas</td>
				</tr>
				<tr>
					<td class="saludo1" style="font-weight: bold; width: 13%">Bodega</td>
					<td style="width:35%" colspan="3"><input type="text" name="nbodegaact" id="nbodegaact" value="<?php echo $_POST[nbodegaact]; ?>" style="width:99%" readonly/></td>
					<td class="saludo1" style="font-weight: bold; width: 17%">Bodega nueva</td>
					<td colspan="3">
						<input type="hidden" id="nbodeganu" name="nbodeganu" value="<?php echo $_POST[nbodeganu]; ?>" />
						<select name="bodeganu" id="bodeganu" onChange="validar();" style="width:100%"> 
							<option value="-1">Seleccione ....</option>
							<?php
								$sqlr="Select * from almbodegas where estado='S' ORDER BY id_cc";
								$resp = mysql_query($sqlr,$linkbd);
								while($row =mysql_fetch_row($resp)) 
								{
									if($row[0]==$_POST[bodeganu])
									{
										echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";
										$_POST[bodeganu]=$row[0];
										$_POST[nbodeganu] = $row[1];
									}
								   else	{ echo "<option value='$row[0]'>$row[0] - $row[1]</option>";} 
								} 
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td class="saludo1" style="font-weight: bold; width: 13%">Valor unitario</td>
					<td style="width:13%"><input type="text" name="valunit" id="valunit" value="<?php echo $_POST[valunit]?>" style="width:95%"/></td>
					<td class="saludo1" style="font-weight: bold; width: 15%">Cantidad actual</td>
					<td><input type="text" name="cantbodact" id="cantbodact" value="<?php echo $_POST[cantbodact]?>" style="width:95%" readonly/></td>
					<td class="saludo1" style="font-weight: bold; width: 17%">Cantidad a trasladar</td>
					<td style="width:8%"><input type="text" name="cantbodtras" id="cantbodtras" value="<?php echo $_POST[cantbodtras]?>" style="width:95%" /> </td>
					<td class="saludo1" style="font-weight: bold; width: 10%">Saldo</td>
					<td><input type="text" name="saldobod" id="saldobod" value="<?php echo $_POST[saldobod]?>" style="width:40%; margin-right:10%" readonly/><input name="regbodtraslado" id="regbodtraslado" type="button" value="Agregar" style="width:50%; height:22px" onClick="agregardettraslado('1')" > </td>
				</tr>
			</table>
			
			<table class="inicio">
				<tr>
					<td class="titulos" colspan="6">Reversion de Traslado entre bodegas</td>
				</tr>
				<tr>
					<td class="titulos2" style="width: 13%">Codigo Articulo</td>
					<td class="titulos2" style="width: 17%">Nombre Articulo</td>
					<td class="titulos2" style="width: 15%">Valor Unitario</td>
					<td class="titulos2" style="width: 17%">Bodega Actual</td>
					<td class="titulos2" style="width: 17%">Bodega a Trasladar</td>
					<td class="titulos2" style="width: 10%">Cantidad a Reversar</td>
					<input type='hidden' name='elimina' id='elimina'>
					<input name='contad' id='contad' value='<?php $_POST[contad] ?>' type='hidden' />
				</tr>
				<?php			 
					
					if(empty($_POST[docum])){
						$sql = "SELECT * FROM almginventario_det WHERE codigo=$_POST[docum] AND tipomov='2' AND tiporeg='03' ";
						$_POST[codunsd][]=$_POST[unsart];
						$_POST[codinard][]=$_POST[codart];
						$_POST[nomartd][]=$_POST[nomart];
						$_POST[cantidadd][]=$_POST[cantart];
						$_POST[unidadd][]=$_POST[umedida];
						$_POST[codbodd][]=$_POST[codbod];
						$_POST[bodegad][]=$_POST[nbodega];
						$_POST[codbodd2][]=$_POST[codbod2];
						$_POST[bodegad2][]=$_POST[nbodeganu];
						$_POST[valore][]=$_POST[valunit];
						$_POST[valortotal1][]=$_POST[valunit]*$_POST[cantart];
						$_POST[dccbod][]=$_POST[centrocosto];
					}
					

					$iter='saludo1a';
					$iter2='saludo2';
					$total = 0;
					$saldobod = 0;
					for ($x=0;$x< count($_POST[codinard]);$x++){
						
						if($_POST[codart] == $_POST[codinard][$x] && $_POST[codbod] == $_POST[codbodd][$x]){
							$saldobod +=($_POST[cantidadd][$x]);
						}
						
						echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
			onMouseOut=\"this.style.backgroundColor=anterior\">
							<td style='width:13%'>
								<input name='codunsd[]' value='".$_POST[codunsd][$x]."' type='hidden'/>
								<input name='unidadd[]' value='".$_POST[unidadd][$x]."' type='hidden'/>
								<input name='valortotal1[]' value='".$_POST[valortotal1][$x]."' type='hidden'/>
								<input name='dccbod[]' value='".$_POST[dccbod][$x]."' type='hidden'/>
								<input class='inpnovisibles' name='codinard[]' value='".$_POST[codinard][$x]."' type='text' style='width:100%' readonly>
								";
							echo"</td> 
							<td  style='width:17%'>
								<input class='inpnovisibles' name='nomartd[]' value='".$_POST[nomartd][$x]."' type='text'  style='width:100%' readonly>
							</td> 
							<td  style='width:15%'>
								<input class='inpnovisibles' name='valore[]' value='".$_POST[valore][$x]."' type='text'  style='width:100%' readonly>
							</td> 
							<td  style='width:17%'>
								<input class='inpnovisibles' name='bodegad[]' value='".$_POST[bodegad][$x]."' type='text' style='width:100%' readonly>
								<input name='codbodd[]' value='".$_POST[codbodd][$x]."' type='hidden'/>
							</td>
							<td style='width:17%'>
								<input class='inpnovisibles' name='bodegad2[]' value='".$_POST[bodegad2][$x]."' type='text'  style='width:100%' readonly>
								<input name='codbodd2[]' value='".$_POST[codbodd2][$x]."' type='hidden'/>
							</td>
								<td  style='width:10%'>
								<input class='inpnovisibles' name='cantidadd[]' value='".$_POST[cantidadd][$x]."' type='text' style='width:100%' readonly>
							</td>
						</tr>";
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
						$total+=($_POST[cantidadd][$x]);
					 }
					$_POST[saldobod] = $_POST[saldobod] - $saldobod;
					echo "<script> document.getElementById('saldobod').value = parseInt(document.getElementById('saldobod').value)-$saldobod;</script>";
					echo "<tr class='saludo2'><td colspan='5'></td><td>".$total."</td>";
				 ?>
			</table>
		</div>

		<div class="subpantallac" style="height:100%;width:50%; overflow-x:hidden;">
			<table class="inicio">
				<tr>
					<td class="titulos" colspan="8">Traslado entre centros de costo</td>
				</tr>
				<tr>
					<td class="saludo1" style="font-weight: bold; width: 13%">Centro costo</td>
					<td style="width:35%"colspan="3"><input type="text" name="ncentrocosto" id="ncentrocosto" value="<?php echo $_POST[ncentrocosto]?>" style="width:99%" readonly/></td>
					<td class="saludo1" style="font-weight: bold; width: 17%" >Centro costo nuevo</td>
					<td colspan="3">
						<input type="hidden" name="ncentrocostonu" id="ncentrocostonu" value="<?php echo $_POST[ncentrocostonu]; ?>" />
						<select name="centrocostonu" id="centrocostonu"  onKeyUp="return tabular(event,this)" style="width:100%;" onChange="validar();">
							<option value="-1">Seleccione ...</option>
							<?php
								$sqlr="select *from centrocosto where estado='S' order by id_cc";
								$res=mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($res)) 
								{
									if("$row[0]"==$_POST[centrocostonu]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>"; $_POST[ncentrocostonu] = $row[1]; }
									else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
								}
							?>	
						</select>
					</td>
				</tr>
				<tr>
					<td class="saludo1" style="font-weight: bold; width: 13%">Valor unitario</td>
					<td style="width:13%"><input type="text" name="valunitcc" id="valunitcc" value="<?php echo $_POST[valunitcc]?>" style="width:95%"/></td>
					<td class="saludo1" style="font-weight: bold; width: 15%">Cantidad actual</td>
					<td><input type="text" name="cantccact" id="cantccact" value="<?php echo $_POST[cantccact]?>" style="width:95%" readonly/></td>
					<td class="saludo1" style="font-weight: bold; width: 17%">Cantidad a trasladar</td>
					<td style="width:8%"><input type="text" name="cantcctras" id="cantcctras" value="<?php echo $_POST[cantcctras]?>" style="width:95%" /></td>
					<td class="saludo1" style="font-weight: bold; width: 10%">Saldo</td>
					<td><input type="text" name="saldocc" id="saldocc" value="<?php echo $_POST[saldocc]?>" style="width:40%; margin-right:10%" readonly/><input name="regcctraslado" id="regcctraslado" type="button" value="Agregar" style="width:50%; height:22px" onClick="agregardettraslado('2')" > </td>
				</tr>
			</table>
			<table class="inicio">
				<tr>
					<td class="titulos2" style="width: 13%">Codigo Articulo</td>
					<td class="titulos2" style="width: 17%">Nombre Articulo</td>
					<td class="titulos2" style="width: 15%">Valor Unitario</td>
					<td class="titulos2" style="width: 17%">C.C Actual</td>
					<td class="titulos2" style="width: 17%">C.C a Trasladar</td>
					<td class="titulos2" style="width: 10%">Cantidad a Trasladar</td>
					<td class="titulos2" style="width: 5%"><img src="imagenes/del.png" >
					<input type='hidden' name='eliminacc' id='eliminacc'>
					<input name='contadcc' id='contadcc' value='<?php $_POST[contadcc] ?>' type='hidden' style='width:100%' readonly>
					</td>
				</tr>
				<?php			 
			 if($_POST[eliminacc]!=''){ 
					$posi=$_POST[eliminacc];
					unset($_POST[codunsd2][$posi]);
					unset($_POST[codinard2][$posi]);
					unset($_POST[nomartd2][$posi]);
					unset($_POST[cantidadd2][$posi]);
					unset($_POST[unidadd2][$posi]);
					unset($_POST[codcc][$posi]);
					unset($_POST[ccd][$posi]);
					unset($_POST[codcc2][$posi]);
					unset($_POST[ccd2][$posi]);
					unset($_POST[valore2][$posi]);
					unset($_POST[valortotal2][$posi]);
					unset($_POST[codboddcc][$posi]);
					unset($_POST[cuentacon][$posi]);
					unset($_POST[cuentacre][$posi]);
					
					$_POST[codunsd2]= array_values($_POST[codunsd2]); 
					$_POST[codinard2]= array_values($_POST[codinard2]); 
					$_POST[nomartd2]= array_values($_POST[nomartd2]); 		 		 
					$_POST[cantidadd2]= array_values($_POST[cantidadd2]); 
					$_POST[unidadd2]= array_values($_POST[unidadd2]); 		 		 
					$_POST[codcc]= array_values($_POST[codcc]); 		 		 
					$_POST[ccd]= array_values($_POST[ccd]); 		 		 
					$_POST[codcc2]= array_values($_POST[codcc2]); 
					$_POST[ccd2]= array_values($_POST[ccd2]);
					$_POST[valore2]= array_values($_POST[valore2]);
					$_POST[valortotal2]= array_values($_POST[valortotal2]);
					$_POST[codboddcc]= array_values($_POST[codboddcc]);
					$_POST[cuentacon]= array_values($_POST[cuentacon]);
					$_POST[cuentacre]= array_values($_POST[cuentacre]);
					
					echo"<script>
						document.getElementById('contadcc').value=".count($_POST[codinard2]).";
					</script>";
				}

				if($_POST[agregadet2]=='1'){
					$cantmp=str_replace('.','',$_POST[cantcctras]);
					$numart=0; $posicion=-1;


					//VALIDA2: QUE SUME CANTIDADES AL SACAR EL MISMO ARTICULO
					for ($x=0;$x < count($_POST[codinard2]);$x++){
						if(($_POST[articulo]==$_POST[codinard2][$x]) && ($_POST[centrocostonu]==$_POST[codcc2][$x])){
							$posicion=$x;
						}
					}
					
					//FIN VALIDA2
					if($posicion<=-1){
						$codgrupo= substr($_POST[articulo], 0, 4);
						$sqlrpat="SELECT cuentapatrimonio FROM almparametros";
						//echo $sqlrpat;
						$respat = mysql_query($sqlrpat,$linkbd);
						$cuentapat=mysql_fetch_row($respat);
						
						$sqlrcumdon="SELECT T2.cuenta FROM almgrupoinv T1, conceptoscontables_det T2 WHERE  T1.codigo='$codgrupo' AND T1.concepent=T2.codigo AND T2.cc = '$_POST[centrocosto]' AND T2.modulo='5' AND T2.debito='S' AND T2.estado='S' AND T2.fechainicial=(SELECT MAX(T3.fechainicial) FROM conceptoscontables_det T3 WHERE  T3.codigo=T2.codigo AND T3.cc = '$_POST[centrocosto]' AND T3.modulo='5' AND T3.debito='S' AND T3.estado='S' AND T3.fechainicial<='$fechaf')";
						//echo $sqlrcumdon;
						$rescumdon = mysql_query($sqlrcumdon,$linkbd);
						$cuentart = mysql_fetch_row($rescumdon);
						
						$_POST[codunsd2][]=$_POST[unsart];
						$_POST[codinard2][]=$_POST[articulo];
						$_POST[nomartd2][]=$_POST[narticulo];
						$_POST[cantidadd2][]=$_POST[cantcctras];
						$_POST[unidadd2][]=$_POST[umedida];
						$_POST[codcc][]=$_POST[centrocosto];
						$_POST[ccd][]=$_POST[ncentrocosto];
						$_POST[codcc2][]=$_POST[centrocostonu];
						$_POST[ccd2][]=$_POST[ncentrocostonu];
						$_POST[valore2][]=$_POST[valunitcc];
						$_POST[valortotal2][]=$_POST[valunitcc]*$_POST[cantcctras];
						$_POST[codboddcc][]=$_POST[bodega];
						$_POST[cuentacon][]=$cuentart[0];
						$_POST[cuentacre][]=$cuentapat[0];
					}	

					echo"<script>
						document.getElementById('agregadet2').value='0';
						document.getElementById('contadcc').value=".count($_POST[codinard2]).";
					</script>";
				}
				$iter='saludo1a';
				$iter2='saludo2';
				$total2 = 0;
				$saldocc = 0;
				for ($x=0;$x< count($_POST[codinard2]);$x++){
					if($_POST[articulo] == $_POST[codinard2][$x] && $_POST[centrocosto] == $_POST[codcc][$x]){
						$saldocc +=($_POST[cantidadd2][$x]);
					}
					
					echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
		onMouseOut=\"this.style.backgroundColor=anterior\">
						<td style='width:13%'>
							<input name='codunsd2[]' value='".$_POST[codunsd2][$x]."' type='hidden'/>
							<input name='unidadd2[]' value='".$_POST[unidadd2][$x]."' type='hidden'/>
							<input name='valortotal2[]' value='".$_POST[valortotal2][$x]."' type='hidden'/>
							<input name='codboddcc[]' value='".$_POST[codboddcc][$x]."' type='hidden'/>
							<input name='cuentacon[]' value='".$_POST[cuentacon][$x]."' type='hidden'/>
							<input name='cuentacre[]' value='".$_POST[cuentacre][$x]."' type='hidden'/>
							<input class='inpnovisibles' name='codinard2[]' value='".$_POST[codinard2][$x]."' type='text' style='width:100%' readonly>
							";
						echo"</td> 
						<td  style='width:17%'>
							<input class='inpnovisibles' name='nomartd2[]' value='".$_POST[nomartd2][$x]."' type='text'  style='width:100%' readonly>
						</td> 
						<td  style='width:15%'>
							<input class='inpnovisibles' name='valore2[]' value='".$_POST[valore2][$x]."' type='text'  style='width:100%' readonly>
						</td> 
						<td  style='width:17%'>
							<input class='inpnovisibles' name='ccd[]' value='".$_POST[ccd][$x]."' type='text' style='width:100%' readonly>
							<input name='codcc[]' value='".$_POST[codcc][$x]."' type='hidden'/>
						</td>
						<td style='width:17%'>
							<input class='inpnovisibles' name='ccd2[]' value='".$_POST[ccd2][$x]."' type='text'  style='width:100%' readonly>
							<input name='codcc2[]' value='".$_POST[codcc2][$x]."' type='hidden'/>
						</td>
							<td  style='width:10%'>
							<input class='inpnovisibles' name='cantidadd2[]' value='".$_POST[cantidadd2][$x]."' type='text' style='width:100%' readonly>
						</td>
						<td style='width:5%'>
							<a href='#' onclick='eliminarcc($x)'><img src='imagenes/del.png'></a>
						</td>
					</tr>";
					$aux=$iter;
					$iter=$iter2;
					$iter2=$aux;
					$total2+=($_POST[cantidadd2][$x]);
					$totalcc+=($_POST[valortotal2][$x]);
				 }
					$_POST[saldocc] = $_POST[saldocc] - $saldocc;
					echo "<script> document.getElementById('saldocc').value = parseInt(document.getElementById('saldocc').value)-$saldocc;</script>";
					echo "<tr class='saludo2'><td colspan='5'></td><td>".$total2."</td><td></td>";
				 ?>
			</table>
		</div>

		</div>

				<?php
				break;
				
				case 4:
				?>
				<td class="saludo1" width="6%" style="font-weight: bold">Documento</td>
					<td style="width:12%;">
						<input type="text" name="docum" id="docum" value="<?php echo $_POST[docum]?>" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="guiabuscar('4');" style="width:80%"/>&nbsp;<img class="icobut" src="imagenes/find02.png" title="Lista de Documentos" onclick="despliegamodal2('visible','4');resetear();">
					</td>
					<td width="50%">
						<input type="text" name="ndocum" id="ndocum" value="<?php echo $_POST[ndocum]?>" style="width:100%;text-transform:uppercase" readonly/>
					</td>
				</tr>
			</table>
				<?php
				break;
				
				case 5:
				?>
				<td class="saludo1" width="6%" style="font-weight: bold">Documento</td>
					<td style="width:12%;">
						<input type="text" name="docum" id="docum" value="<?php echo $_POST[docum]?>" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="guiabuscar('4');" style="width:80%"/>&nbsp;<img class="icobut" src="imagenes/find02.png" title="Lista de Documentos" onclick="despliegamodal2('visible','4');resetear();">
					</td>
					<td width="50%">
						<input type="text" name="ndocum" id="ndocum" value="<?php echo $_POST[ndocum]?>" style="width:100%;text-transform:uppercase" readonly/>
					</td>
				</tr>
			</table>
				<?php
				break;
				
				case 6:
				?>
				<td class="saludo1" width="6%" style="font-weight: bold">Documento</td>
					<td style="width:12%;">
						<input type="text" name="docum" id="docum" value="<?php echo $_POST[docum]?>" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="guiabuscar('4');" style="width:80%"/>&nbsp;<img class="icobut" src="imagenes/find02.png" title="Lista de Documentos" onclick="despliegamodal2('visible','4');resetear();">
					</td>
					<td width="50%">
						<input type="text" name="ndocum" id="ndocum" value="<?php echo $_POST[ndocum]?>" style="width:100%;text-transform:uppercase" readonly/>
					</td>
				</tr>
			</table>
				<?php
				break;
				
				default:
				?>
				<td></td>
				</tr>
			</table>
				<?php
				break;
			}
			?>	

<?php 
}
//FIN REVERSIONES
?> 

	<div id="bgventanamodal2">
    	<div id="ventanamodal2">
        	<IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
            </IFRAME>
		</div>
	</div>
	<?php 
	//********** GUARDAR EL COMPROBANTE ***********
	if($_POST[oculto]=='2'){
		echo'<script>document.form2.oculto.value=0</script>';
		$linkbd=conectar_bd();
		$nfecha = cambiar_fecha($_POST[fecha]);
		$sq="select max(bodega2) from almginventario ";
		$rs=mysql_query($sq,$linkbd);
		$rw = mysql_fetch_row($rs);
		$numacta=$rw[0]+1;
		$sqlrTipoComp = "SELECT tipo_comp FROM almtipomov WHERE tipom='$_POST[tipomov]' AND codigo='$_POST[tipoentra]'";
		$resTipoComp = mysql_query($sqlrTipoComp,$linkbd);
		$rowTipoComp = mysql_fetch_row($resTipoComp);
		if($rowTipoComp[0]!='' && $rowTipoComp[0]!=0)
		{
			//rutina de guardado cabecera
			$sqlr="insert into almginventario (consec, fecha, tipomov, tiporeg, codmov, valortotal, usuario, estado, nombre, bodega1, bodega2,vigenciadoc) values ('$_POST[numero]', '$nfecha','$_POST[tipomov]','$_POST[tipoentra]','$_POST[docum]','0', '".$_SESSION[cedulausu]."', 'S', '$_POST[nombre]', '$_POST[codbod]', '$numacta', '$vigusu')";
			if(!view($sqlr,'confirm')){
				echo"<script>despliegamodalm('visible','2','Error no se almaceno');</script>";
			}else{
		
				if($_POST[tipomov]==2){
					$tercero = view("SELECT nit FROM configbasica LIMIT 1");
					$tercero = explode('-', $tercero[0][nit]);
					switch($_POST[tipoentra]){
						//**** crear el detalle del concepto para salida reservas
						case 1: 
							$valtotf=0;
							$totalcab=0;
							for($x=0;$x<count($_POST[codinard]);$x++){
								$valtotf=str_replace('.','',$_POST[cantidadd][$x]);
								$totalcab+=$valtotf;
								//CACULAR VALOR DE SALIDA KARDEX PROMEDIO PONDERADO
								if($valtotf>0){
									$sqlpp = "SELECT T2.valorunit,T2.cantidad_entrada,T2.cantidad_salida,T2.unidad FROM almginventario T1 INNER JOIN almginventario_det T2 ON CONCAT(T1.consec,T1.tipomov)=CONCAT(T2.codigo,T2.tipomov) WHERE T2.codart='".$_POST[codinard][$x]."'";
									//echo $sqlpp;
									$data = view($sqlpp);
									$valtotal = 0;
									$canttotal = 0;
									foreach ($data as $key => $val) {
										$f1 = almconsulta_factorarticulo($_POST[codinard][$x],$val[unidad]);
										$rec = 1/$f1;
										$rec_val = $val[valorunit];
										$f2 = almconsulta_factorarticulo($_POST[codinard][$x],$_POST[undadd][$x]);
										$res = 1/$f2;
										$res_val = ($rec_val*$res)/$rec;
										$cantidad_entrada = ($val[cantidad_entrada]*$rec)/$res;
										$cantidad_salida = ($val[cantidad_salida]*$rec)/$res;
										$valtotal += ($res_val*$cantidad_entrada)-($res_val*$cantidad_salida);
										$canttotal += $cantidad_entrada-$cantidad_salida;
									}
									$valor_unit = $valtotal/$canttotal;
								}else{
									$valor_unit = 0;
								}
								$valtotall = $valtotf*$valor_unit;
								
								//COMPROBANTE DEBITO
								$sql="SELECT T3.fechainicial,T3.cuenta,T3.cc FROM almreservas_det T1 INNER JOIN conceptoscontables T2 ON T1.cuenta = T2.codigo INNER JOIN conceptoscontables_det T3 ON T3.codigo = T2.codigo WHERE T2.almacen='S' AND T3.tipo='C' AND T3.cuenta<>'' AND T3.modulo='3' AND T1.cc=T3.cc AND T1.codreserva='".$_POST[docum]."' AND T1.articulo = '".$_POST[codinard][$x]."' AND T3.fechainicial<'".$nfecha."' ORDER BY T3.fechainicial DESC LIMIT 1";
								$row = view($sql);
								$sql="INSERT INTO comprobante_det(id_comp,cuenta,tercero,centrocosto,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo,numacti,cantarticulo) VALUES ('$rowTipoComp[0] $_POST[numero]','".$row[0][cuenta]."','".$tercero[0]."','".$row[0][cc]."','$_POST[nombre]',$valtotall,0,1,'$vigusu','$rowTipoComp[0]','$_POST[numero]','".$_POST[codinard][$x]."','".$_POST[cantidadd][$x]."')";
								view($sql);
								
								//COMPROBANTE CREDITO
								$ginv = substr($_POST[codinard][$x], 0, 4);
								$sql="SELECT T2.fechainicial,T2.cuenta,T2.cc FROM almgrupoinv T1 INNER JOIN conceptoscontables_det T2 ON T2.codigo = T1.concepent INNER JOIN almreservas_det T3 ON T3.cc = T2.cc WHERE T2.modulo='5' AND T2.tipo='AE' AND T2.cuenta<>'' AND T1.codigo='".$ginv."' AND T3.codreserva='".$_POST[docum]."' AND T2.fechainicial<'".$nfecha."' ORDER BY T2.fechainicial DESC LIMIT 1";
								$row = view($sql);
								$sql="INSERT INTO comprobante_det(id_comp,cuenta,tercero,centrocosto,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo,numacti,cantarticulo) VALUES ('$rowTipoComp[0] $_POST[numero]','".$row[0][cuenta]."','".$tercero[0]."','".$row[0][cc]."','$_POST[nombre]',0,$valtotall,1,'$vigusu','$rowTipoComp[0]','$_POST[numero]','".$_POST[codinard][$x]."','".$_POST[cantidadd][$x]."')";
								view($sql);

								//DETALLES INVENTARIO
								$sqlr="INSERT INTO almginventario_det (codigo,unspsc,codart,solicitud,cantidad_salida,valorunit,valortotal,unidad,tipomov,tiporeg, bodega,codcuentacre,cc) VALUES ('$_POST[numero]', '".$_POST[codunsd][$x]."','".$_POST[codinard][$x]."','$_POST[docum]','".$_POST[cantidadd][$x]."','".$valor_unit."','".$valtotall."','".$_POST[undadd][$x]."', '$_POST[tipomov]','$_POST[tipoentra]','".$_POST[codbodd][$x]."','".$row[0][cuenta]."','".$row[0][cc]."')";
								view($sqlr);

								//RESERVA ENTREGADA
								if ($_POST[reservad][$x]==$_POST[cantidadd][$x]) {
									//ACTUALIZAR ESTADO DEL DETALLE DE LA RESERVA
									$sql="UPDATE almreservas_det SET estado='ENT' WHERE codreserva='$_POST[docum]' AND articulo='".$_POST[codinard][$x]."' AND unidad='".$_POST[unidadd][$x]."'";
									view($sql);
									//BUSCAR DETALLES DE RESERVA NO ENTREGADOS
									$sql="SELECT estado FROM almreservas_det WHERE codreserva='$_POST[docum]'";
									$data = view($sql);
									$bandera = true;
									foreach ($data  as $key => $val) {
										if ($val[estado]!='ENT') {
											$bandera = false;
										}
									}
									//ACTUALIZAR ESTADO DE LA RESERVA
									if ($bandera) {
										$sql="UPDATE almreservas SET estado='ENT' WHERE codigo='$_POST[docum]'";
										view($sql);
									}
								}
							}
							//CABECERA COMPROBANTE
							$totalcab = $totalcab*$valor_unit;
							$sql="INSERT INTO comprobante_cab(numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) VALUES ('$_POST[numero]','$rowTipoComp[0]',$nfecha,'$_POST[nombre]',0,$totalcab,$totalcab,1)";
							view($sql);
						break;
						case 3: //***SALIDA POR TRASLADOS
						for($x=0;$x<$_POST[contad];$x++)
						{
							//Salida de bodega
							$sqlr="INSERT INTO almginventario_det (codigo,unspsc,codart,solicitud,cantidad_salida,valorunit,valortotal,unidad,tipomov,tiporeg, bodega,codcuentacre,cc) VALUES ('$codinv', '".$_POST[codunsd][$x]."','".$_POST[codinard][$x]."','$_POST[docum]','".$_POST[cantidadd][$x]."','".$_POST[valore][$x]."','".$_POST[valortotal1][$x]."','".$_POST[unidadd][$x]."', '$_POST[tipomov]','$_POST[tipoentra]','".$_POST[codbodd][$x]."','".$_POST[tipcredit][$x]."','".$_POST[dccbod][$x]."')";
							$res=mysql_query($sqlr,$linkbd) or die($varinventario1=1);
							//Entrada a bodega
							$sqlr="INSERT INTO almginventario_det (codigo,unspsc,codart,solicitud,cantidad_entrada,valorunit,valortotal,unidad,tipomov,tiporeg, bodega,codcuentacre,cc) VALUES ('$codinv', '".$_POST[codunsd][$x]."','".$_POST[codinard][$x]."','$_POST[docum]','".$_POST[cantidadd][$x]."','".$_POST[valore][$x]."','".$_POST[valortotal1][$x]."','".$_POST[unidadd][$x]."', '$_POST[tipomov]','$_POST[tipoentra]','".$_POST[codbodd2][$x]."','".$_POST[tipcredit][$x]."','".$_POST[dccbod][$x]."')";
							$res=mysql_query($sqlr,$linkbd) or die($varinventario2=1);
						}
						
						for($x=0;$x<$_POST[contadcc];$x++)
						{
							//Salida de CC
							$sqlr="INSERT INTO almginventario_det (codigo,unspsc,codart,solicitud,cantidad_salida,valorunit,valortotal,unidad,tipomov,tiporeg, bodega,codcuentacre,cc) VALUES ('$codinv', '".$_POST[codunsd2][$x]."','".$_POST[codinard2][$x]."','$_POST[docum]','".$_POST[cantidadd2][$x]."','".$_POST[valore2][$x]."','".$_POST[valortotal2][$x]."','".$_POST[unidadd2][$x]."', '$_POST[tipomov]','$_POST[tipoentra]','".$_POST[codboddcc][$x]."','".$_POST[tipcredit][$x]."','".$_POST[codcc][$x]."')";
							$res=mysql_query($sqlr,$linkbd) or die($varinventario3=1);
							//Entrada de CC
							$sqlr="INSERT INTO almginventario_det (codigo,unspsc,codart,solicitud,cantidad_entrada,valorunit,valortotal,unidad,tipomov,tiporeg, bodega,codcuentacre,cc) VALUES ('$codinv', '".$_POST[codunsd2][$x]."','".$_POST[codinard2][$x]."','$_POST[docum]','".$_POST[cantidadd2][$x]."','".$_POST[valore2][$x]."','".$_POST[valortotal2][$x]."','".$_POST[unidadd2][$x]."', '$_POST[tipomov]','$_POST[tipoentra]','".$_POST[codboddcc][$x]."','".$_POST[tipcredit][$x]."','".$_POST[codcc2][$x]."')";
							$res=mysql_query($sqlr,$linkbd) or die($varinventario4=1);
							//CONCEPTO CONTABLE TRASLADOS
							if($_POST[cuentacon][$x]!=""){
								$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado, vigencia,tipo_comp,numerotipo,numacti,cantarticulo) VALUES ('$rowTipoComp[0] $codinv','".$_POST[cuentacon][$x]."','".$tercero[0]."','".$_POST[codcc][$x]."','$_POST[nombre]','','0','".$_POST[valortotal2][$x]."','1','$vigusu','$rowTipoComp[0]','$codinv','".$_POST[codinard][$x]."','".$_POST[cantidadd][$x]."')";
								mysql_query($sqlr,$linkbd) or die($varcontable1=1);
							}else{
								$varcontable1=1;
							}
							
							if($_POST[cuentacre][$x]!=""){
								$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado, vigencia,tipo_comp,numerotipo,numacti,cantarticulo) VALUES ('$rowTipoComp[0] $codinv','".$_POST[cuentacre][$x]."','".$tercero[0]."','".$_POST[codcc][$x]."','$_POST[nombre]','','".$_POST[valortotal2][$x]."','0','1','$vigusu','$rowTipoComp[0]','$codinv','".$_POST[codinard][$x]."','".$_POST[cantidadd][$x]."')";
								mysql_query($sqlr,$linkbd) or die($varcontable2=1);
							}else{
								$varcontable2=1;
							}
							
							if($_POST[cuentacon][$x]!=""){
								$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado, vigencia,tipo_comp,numerotipo,numacti,cantarticulo) VALUES ('$rowTipoComp[0] $codinv','".$_POST[cuentacon][$x]."','".$tercero[0]."','".$_POST[codcc2][$x]."','$_POST[nombre]','','".$_POST[valortotal2][$x]."','0','1','$vigusu','$rowTipoComp[0]','$codinv','".$_POST[codinard][$x]."','".$_POST[cantidadd][$x]."')";
								mysql_query($sqlr,$linkbd) or die($varcontable3=1);
							}else{
								$varcontable3=1;
							}
							
							if($_POST[cuentacre][$x]!=""){
								$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado, vigencia,tipo_comp,numerotipo,numacti,cantarticulo) VALUES ('$rowTipoComp[0] $codinv','".$_POST[cuentacre][$x]."','".$tercero[0]."','".$_POST[codcc2][$x]."','$_POST[nombre]','','0','".$_POST[valortotal2][$x]."','1','$vigusu','$rowTipoComp[0]','$codinv','".$_POST[codinard][$x]."','".$_POST[cantidadd][$x]."')";
								mysql_query($sqlr,$linkbd) or die($varcontable4=1);
							}else{
								$varcontable4=1;
							}
							
						}
						
						$sqlr="INSERT INTO comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia, estado) VALUES ($codinv,'$rowTipoComp[0]','$fechaf','$_POST[nombre]',0,$totalcc,$totalcc,0,'1')";
						mysql_query($sqlr,$linkbd) or die($varcontable5=1);
						if($varcontable1!=0 || $varcontable2!=0 || $varcontable3!=0 || $varcontable4!=0 || $varcontable5!=0 || $varinventario1!=0 || $varinventario2!=0 || $varinventario3!=0 || $varinventario4!=0)
						{
						echo "<script>despliegamodalm('visible','2','Error no se almaceno');</script>";
						}
						
					break;
						case 5:
							$totalcab=$varcontable1=$varcontable2=$varcontable3=$varinventario1=0;
							for($x=0;$x<count($_POST[codinard]);$x++)
							{
								$sql="SELECT codigo,tipocuenta,cuenta,cc FROM conceptoscontables_det WHERE conceptoscontables_det.codigo='".$_POST[dcuentas][$x]."' and conceptoscontables_det.modulo=3 and conceptoscontables_det.tipo='C' AND conceptoscontables_det.cuenta!='' AND conceptoscontables_det.cc = '".$_POST[dcc][$x]."' AND  conceptoscontables_det.estado = 'S' AND conceptoscontables_det.fechainicial=(SELECT MAX(T3.fechainicial) FROM conceptoscontables_det T3 WHERE  T3.codigo=conceptoscontables_det.codigo AND T3.cc = '".$_POST[dcc][$x]."' AND T3.modulo='3' AND T3.debito='S' AND T3.estado='S' AND T3.fechainicial<='$fechaf') LIMIT 1";
								$res = mysql_query($sql,$linkbd);
								$conceptoscont = mysql_fetch_row($res);
							
								$sqlr="INSERT INTO almginventario_det(codigo,unspsc,codart,solicitud,cantidad_salida,valorunit,valortotal,unidad,tipomov,tiporeg, bodega,codcuentacre,cc) VALUES ('$codinv', '".$_POST[codunsd][$x]."','".$_POST[codinard][$x]."','$_POST[docum]','".$_POST[cantidadd][$x]."','".$_POST[valore][$x]."','".$_POST[valortotal1][$x]."','".$_POST[unidadd][$x]."', '$_POST[tipomov]','$_POST[tipoentra]','".$_POST[codbodd][$x]."','".$conceptoscont[0]."','".$_POST[dcc][$x]."')";
								$res=mysql_query($sqlr,$linkbd) or die($varinventario1=1);
								//CREDITO
								if($_POST[cuentacon][$x]!=""){
									$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado, vigencia,tipo_comp,numerotipo,numacti,cantarticulo) VALUES ('$rowTipoComp[0] $codinv','".$_POST[cuentacon][$x]."','".$_POST[tercero]."','".$_POST[dcc][$x]."','$_POST[nombre]','','0','".$_POST[valortotal1][$x]."','1','$vigusu','$rowTipoComp[0]','$codinv','".$_POST[codinard][$x]."','".$_POST[cantidadd][$x]."')";
									mysql_query($sqlr,$linkbd) or die($varcontable1=1);
								}else{
									$varcontable1=1;
								}
								
								//DEBITO
								if($conceptoscont[2]!=""){
									$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado, vigencia,tipo_comp,numerotipo,numacti,cantarticulo) VALUES ('$rowTipoComp[0] $codinv','".$conceptoscont[2]."','".$_POST[tercero]."','".$_POST[dcc][$x]."','$_POST[nombre]','','".$_POST[valortotal1][$x]."','0','1','$vigusu','$rowTipoComp[0]','$codinv','".$_POST[codinard][$x]."','".$_POST[cantidadd][$x]."')";
									mysql_query($sqlr,$linkbd) or die($varcontable2=1);
								}else{
									$varcontable2=1;
								}

								$sqlr="UPDATE almactoajustesalarticu SET saldo=saldo-".$_POST[cantidadd][$x]." WHERE idacto=".$_POST[docum]." AND codigo=".$_POST[codinard][$x];
								mysql_query($sqlr,$linkbd);
							}
							
							$sqlr="UPDATE almactoajustesal SET valorsaldo=valorsaldo-".$sumvalortotal." WHERE id=".$_POST[docum];
							mysql_query($sqlr,$linkbd);
							
							$sqlr="INSERT INTO comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia, estado) VALUES ($codinv,$rowTipoComp[0],'$fechaf','$_POST[nombre]',0,$sumvalortotal,$sumvalortotal,0,'1')";
							mysql_query($sqlr,$linkbd) or die($varcontable3=1);
							if($varcontable1!=0 || $varcontable2!=0 || $varcontable3!=0 ||$varinventario1!=0)
							{
							echo "<script>despliegamodalm('visible','2','Error no se almaceno');</script>";
							}
						break;
						case 6:
							//Aqui logica para almacenar salida directa
							$valtotf=0;
							$totalcab=0;
							for($x=0;$x<count($_POST[codinard]);$x++){
								$valtotf=str_replace('.','',$_POST[cantidadd][$x]);
								$totalcab+=$valtotf;
								//CACULAR VALOR DE SALIDA KARDEX PROMEDIO PONDERADO
								if($valtotf>0){
									$sqlpp = "SELECT T2.valorunit,T2.cantidad_entrada,T2.cantidad_salida,T2.unidad FROM almginventario T1 INNER JOIN almginventario_det T2 ON CONCAT(T1.consec,T1.tipomov)=CONCAT(T2.codigo,T2.tipomov) WHERE T2.codart='".$_POST[codinard][$x]."'";
									//echo $sqlpp;
									$data = view($sqlpp);
									$valtotal = 0;
									$canttotal = 0;
									foreach ($data as $key => $val) {
										$f1 = almconsulta_factorarticulo($_POST[codinard][$x],$val[unidad]);
										$rec = 1/$f1;
										$rec_val = $val[valorunit];
										$f2 = almconsulta_factorarticulo($_POST[codinard][$x],$_POST[undadd][$x]);
										$res = 1/$f2;
										$res_val = ($rec_val*$res)/$rec;
										$cantidad_entrada = ($val[cantidad_entrada]*$rec)/$res;
										$cantidad_salida = ($val[cantidad_salida]*$rec)/$res;
										$valtotal += ($res_val*$cantidad_entrada)-($res_val*$cantidad_salida);
										$canttotal += $cantidad_entrada-$cantidad_salida;
									}
									$valor_unit = $valtotal/$canttotal;
								}else{
									$valor_unit = 0;
								}
								$valtotall = $valtotf*$valor_unit;
								
								//COMPROBANTE DEBITO
								$sql="SELECT T3.fechainicial,T3.cuenta,T3.cc FROM conceptoscontables T2 INNER JOIN conceptoscontables_det T3 ON T3.codigo = T2.codigo WHERE T2.almacen='S' AND T3.tipo='C' AND T3.cuenta<>'' AND T3.modulo='3' AND T3.cc='".$_POST[ccd][$x]."' AND T3.fechainicial<'".$nfecha."' AND T2.codigo='".$_POST[agcuen][$x]."' ORDER BY T3.fechainicial DESC LIMIT 1";
								$row = view($sql);
								$sql="INSERT INTO comprobante_det(id_comp,cuenta,tercero,centrocosto,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo,numacti,cantarticulo) VALUES ('$rowTipoComp[0] $_POST[numero]','".$row[0][cuenta]."','".$tercero[0]."','".$row[0][cc]."','$_POST[nombre]',$valtotall,0,1,'$vigusu','$rowTipoComp[0]','$_POST[numero]','".$_POST[codinard][$x]."','".$_POST[cantidadd][$x]."')";
								view($sql);
								
								//COMPROBANTE CREDITO
								$ginv = substr($_POST[codinard][$x], 0, 4);
								$sql="SELECT T2.fechainicial,T2.cuenta,T2.cc FROM almgrupoinv T1 INNER JOIN conceptoscontables_det T2 ON T2.codigo = T1.concepent WHERE T2.modulo='5' AND T2.tipo='AE' AND T2.cuenta<>'' AND T1.codigo='".$ginv."' AND T2.fechainicial<'".$nfecha."' ORDER BY T2.fechainicial DESC LIMIT 1";
								$row = view($sql);
								$sql="INSERT INTO comprobante_det(id_comp,cuenta,tercero,centrocosto,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo,numacti,cantarticulo) VALUES ('$rowTipoComp[0] $_POST[numero]','".$row[0][cuenta]."','".$tercero[0]."','".$row[0][cc]."','$_POST[nombre]',0,$valtotall,1,'$vigusu','$rowTipoComp[0]','$_POST[numero]','".$_POST[codinard][$x]."','".$_POST[cantidadd][$x]."')";
								view($sql);

								//DETALLES INVENTARIO
								$sqlr="INSERT INTO almginventario_det (codigo,unspsc,codart,solicitud,cantidad_salida,valorunit,valortotal,unidad,tipomov,tiporeg, bodega,codcuentacre,cc,concepto) VALUES ('$_POST[numero]', '".$_POST[codunsd][$x]."','".$_POST[codinard][$x]."','$_POST[docum]','".$_POST[cantidadd][$x]."','".$valor_unit."','".$valtotall."','".$_POST[undadd][$x]."', '$_POST[tipomov]','$_POST[tipoentra]','".$_POST[codbodd][$x]."','".$row[0][cuenta]."','".$row[0][cc]."','".$_POST[agcuen][$x]."')";
								view($sqlr);

							}
							//CABECERA COMPROBANTE
							$totalcab = $totalcab*$valor_unit;
							$sql="INSERT INTO comprobante_cab(numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) VALUES ('$_POST[numero]','$rowTipoComp[0]','$nfecha','$_POST[nombre]','0','$totalcab','$totalcab','0','1')";
							view($sql);
						break;
					}
				}else{
					$tercero = view("SELECT nit FROM configbasica LIMIT 1");
					$tercero = explode('-', $tercero[0][nit]);
					switch($_POST[tipoentra]){
						//**** crear el detalle del concepto para reversiones para salida reservas
						case 1: 
							$sumvalortotal = 0;
							for($x=0;$x<$_POST[contad];$x++){
								//DATOS DEL DETALLE
								$sql = "SELECT T1.solicitud,T1.valorunit,T1.valortotal,T1.codcuentacre,T1.cc FROM almginventario_det T1 WHERE T1.id_det = '".$_POST[dcoddetalle][$x]."' LIMIT 1";
								$data = view($sql);
								//DETALLE REVERSION
								$sqlr="INSERT INTO almginventario_det (codigo,unspsc,codart,solicitud,cantidad_entrada,valorunit,valortotal,unidad,tipomov,tiporeg, bodega,codcuentacre,cc) VALUES ('$_POST[numero]', '".$_POST[codunsd][$x]."','".$_POST[codinard][$x]."','$_POST[docum]','".$_POST[cantidadd][$x]."','".$data[0][valorunit]."','".$data[0][valortotal]."','".$_POST[unidadd][$x]."', '$_POST[tipomov]','$_POST[tipoentra]','".$_POST[codbodd][$x]."','".$data[0][codcuentacre]."','".$data[0][cc]."')";
								view($sqlr);
							
								//CUENTA DEL CONCEPTO
								$sql="SELECT T3.fechainicial,T3.cuenta,T3.cc FROM almreservas_det T1 INNER JOIN conceptoscontables T2 ON T1.cuenta = T2.codigo INNER JOIN conceptoscontables_det T3 ON T3.codigo = T2.codigo WHERE T2.almacen='S' AND T3.tipo='C' AND T3.cuenta<>'' AND T3.modulo='3' AND T1.cc=T3.cc AND T1.codreserva='".$data[0][solicitud]."' AND T1.articulo = '".$_POST[codinard][$x]."' AND T3.fechainicial<'".$nfecha."' ORDER BY T3.fechainicial DESC LIMIT 1";
								$row = view($sql);
								//COMPROBANTE DEBITO
								$sql="INSERT INTO comprobante_det(id_comp,cuenta,tercero,centrocosto,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo,numacti,cantarticulo) VALUES ('$rowTipoComp[0] $_POST[numero]','".$row[0][cuenta]."','".$tercero[0]."','".$row[0][cc]."','$_POST[nombre]',$valtotall,0,1,'$vigusu','$rowTipoComp[0]','$_POST[numero]','".$_POST[codinard][$x]."','".$_POST[cantidadd][$x]."')";
								view($sql);
								
								//CUENTA DEL CONCEPTO
								$ginv = substr($_POST[codinard][$x], 0, 4);
								$sql="SELECT T2.fechainicial,T2.cuenta,T2.cc FROM almgrupoinv T1 INNER JOIN conceptoscontables_det T2 ON T2.codigo = T1.concepent INNER JOIN almreservas_det T3 ON T3.cc = T2.cc WHERE T2.modulo='5' AND T2.tipo='AE' AND T2.cuenta<>'' AND T1.codigo='".$ginv."' AND T3.codreserva='".$data[0][solicitud]."' AND T2.fechainicial<'".$nfecha."' ORDER BY T2.fechainicial DESC LIMIT 1";
								$row = view($sql);
								//COMPROBANTE CREDITO
								$sql="INSERT INTO comprobante_det(id_comp,cuenta,tercero,centrocosto,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo,numacti,cantarticulo) VALUES ('$rowTipoComp[0] $_POST[numero]','".$row[0][cuenta]."','".$tercero[0]."','".$row[0][cc]."','$_POST[nombre]',0,$valtotall,1,'$vigusu','$rowTipoComp[0]','$_POST[numero]','".$_POST[codinard][$x]."','".$_POST[cantidadd][$x]."')";
								view($sql);

								//***RESERVA ENTREGADA REVERSADA***
								//ACTUALIZAR ESTADO DEL DETALLE DE LA RESERVA
								$sql="UPDATE almreservas_det SET estado='S' WHERE codreserva='".$data[0][solicitud]."' AND articulo='".$_POST[codinard][$x]."' AND unidad='".$_POST[unidadd][$x]."'";
								view($sql);
								//BUSCAR DETALLES DE RESERVA NO ENTREGADOS
								$sql="SELECT estado FROM almreservas_det WHERE codreserva='".$data[0][solicitud]."'";
								$data = view($sql);
								$bandera = true;
								foreach ($data  as $key => $val) {
									if ($val[estado]!='ENT') {
										$bandera = false;
									}
								}
								//ACTUALIZAR ESTADO DE LA RESERVA
								if (!$bandera) {
									$sql="UPDATE almreservas SET estado='S' WHERE codigo='$_POST[docum]'";
									view($sql);
								}
								$sumvalortotal += $data[0][valortotal];
							}
							$sqlr="INSERT INTO comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia, estado) VALUES ($_POST[numero],$rowTipoComp[0],'$fechaf','$_POST[nombre]',0,$sumvalortotal,$sumvalortotal,0,'2')";
							view($sqlr);
						break;
						case 6:
							//Aqui logica para reversion de salida directa
						break;
					}
				}
				//**** crear el detalle del concepto para salida devoluciones
				if(count($_POST[devolved])>0){
					for($x=0;$x<$_POST[contad];$x++){
						$sqlr="insert into almginventario_det (codigo, unspsc, codart, cantidad, unidad, tipomov, bodega) values ('$codinv', '".$_POST[codunsd][$x]."','".$_POST[codinard][$x]."','".$_POST[cantidadd][$x]."','".$_POST[unidadd][$x]."', '$_POST[tipomov]','".$_POST[codbodd][$x]."')";
						$res=mysql_query($sqlr,$linkbd);
						//BUSCA PRODUCTOS POR BODEGA
						$sqlr="SELECT almarticulos_exis.existencia, almarticulos_det.factor FROM almarticulos_exis INNER JOIN almarticulos_det ON almarticulos_exis.articulo=almarticulos_det.articulo WHERE almarticulos_exis.articulo='".$_POST[codinard][$x]."' AND almarticulos_exis.bodega='".$_POST[codbodd][$x]."' AND almarticulos_det.unidad='".$_POST[unidadd][$x]."'";
						$rart=mysql_query($sqlr,$linkbd);
						//ACTUALIZA CANTIDAD PRODUCTOS POR BODEGA
						if(mysql_num_rows($rart)!=0){
							$wart=mysql_fetch_array($rart);
							$exis=$wart[0]-($_POST[cantidadd][$x]*$wart[1]);
							$sql="UPDATE almarticulos_exis SET existencia='$exis' WHERE articulo='".$_POST[codinard][$x]."' AND bodega='".$_POST[codbodd][$x]."'";
							$res=mysql_query($sql,$linkbd);
						}
						//ACTUALIZA CANTIDAD TOTAL DE ARTICULOS
						$sqlr="SELECT SUM(existencia) FROM almarticulos_exis WHERE articulo='".$_POST[codinard][$x]."'";
						$rart=mysql_query($sqlr,$linkbd);
						$wart=mysql_fetch_array($rart);
						$sql="UPDATE almarticulos SET existencia='$wart[0]' WHERE CONCAT(grupoinven,codigo)='".$_POST[codinard][$x]."'";
						$res=mysql_query($sql,$linkbd);
					}
				}
				//**** crear el detalle del concepto para salida traslados
				if(count($_POST[traslad])>0){
					for($x=0;$x<$_POST[contad];$x++){
						$sqlr="insert into almginventario_det (codigo, unspsc, codart, cantidad, unidad, tipomov, bodega) values ('$codinv', '".$_POST[codunsd][$x]."','".$_POST[codinard][$x]."','".$_POST[cantidadd][$x]."','".$_POST[unidadd][$x]."', '$_POST[tipomov]','".$_POST[codbodd][$x]."')";
						$res=mysql_query($sqlr,$linkbd);
						//BUSCA PRODUCTOS POR BODEGA
						$sqlr="SELECT almarticulos_exis.existencia, almarticulos_det.factor FROM almarticulos_exis INNER JOIN almarticulos_det ON almarticulos_exis.articulo=almarticulos_det.articulo WHERE almarticulos_exis.articulo='".$_POST[codinard][$x]."' AND almarticulos_exis.bodega='".$_POST[codbodd][$x]."' AND almarticulos_det.unidad='".$_POST[unidadd][$x]."'";
						$rart=mysql_query($sqlr,$linkbd);
						//ACTUALIZA CANTIDAD PRODUCTOS POR BODEGA
						if(mysql_num_rows($rart)!=0){
							$wart=mysql_fetch_array($rart);
							$exis=$wart[0]-($_POST[cantidadd][$x]*$wart[1]);
							$sql="UPDATE almarticulos_exis SET existencia='$exis' WHERE articulo='".$_POST[codinard][$x]."' AND bodega='".$_POST[codbodd][$x]."'";
							$res=mysql_query($sql,$linkbd);
						}
						//ACTUALIZA CANTIDAD TOTAL DE ARTICULOS
						$sqlr="SELECT SUM(existencia) FROM almarticulos_exis WHERE articulo='".$_POST[codinard][$x]."'";
						$rart=mysql_query($sqlr,$linkbd);
						$wart=mysql_fetch_array($rart);
						$sql="UPDATE almarticulos SET existencia='$wart[0]' WHERE CONCAT(grupoinven,codigo)='".$_POST[codinard][$x]."'";
						$res=mysql_query($sql,$linkbd);
					}
				}
				//**** crear el detalle del concepto para salida deterioro o baja
				if(count($_POST[bajad])>0){
				for($x=0;$x<$_POST[contad];$x++){
					$sqlr="insert into almginventario_det (codigo, unspsc, codart, cantidad, unidad, tipomov, bodega) values ('$codinv', '".$_POST[codunsd][$x]."','".$_POST[codinard][$x]."','".$_POST[cantidadd][$x]."','".$_POST[unidadd][$x]."', '$_POST[tipomov]','".$_POST[codbodd][$x]."')";
		  			$res=mysql_query($sqlr,$linkbd);
					//BUSCA PRODUCTOS POR BODEGA
					$sqlr="SELECT almarticulos_exis.existencia, almarticulos_det.factor FROM almarticulos_exis INNER JOIN almarticulos_det ON almarticulos_exis.articulo=almarticulos_det.articulo WHERE almarticulos_exis.articulo='".$_POST[codinard][$x]."' AND almarticulos_exis.bodega='".$_POST[codbodd][$x]."' AND almarticulos_det.unidad='".$_POST[unidadd][$x]."'";
					$rart=mysql_query($sqlr,$linkbd);
					//ACTUALIZA CANTIDAD PRODUCTOS POR BODEGA
					if(mysql_num_rows($rart)!=0){
						$wart=mysql_fetch_array($rart);
						$exis=$wart[0]-($_POST[cantidadd][$x]*$wart[1]);
						$sql="UPDATE almarticulos_exis SET existencia='$exis' WHERE articulo='".$_POST[codinard][$x]."' AND bodega='".$_POST[codbodd][$x]."'";
			  			$res=mysql_query($sql,$linkbd);
					}
					//ACTUALIZA CANTIDAD TOTAL DE ARTICULOS
					$sqlr="SELECT SUM(existencia) FROM almarticulos_exis WHERE articulo='".$_POST[codinard][$x]."'";
					$rart=mysql_query($sqlr,$linkbd);
					$wart=mysql_fetch_array($rart);
					$sql="UPDATE almarticulos SET existencia='$wart[0]' WHERE CONCAT(grupoinven,codigo)='".$_POST[codinard][$x]."'";
		  			$res=mysql_query($sql,$linkbd);
				}
		 	}
		  //**** crear el detalle del concepto para salida por ajuste
		  /*
			if(count($_POST[salajustad])>0){
				for($x=0;$x<$_POST[contad];$x++){
					$sqlr="insert into almginventario_det (codigo, unspsc, codart, cantidad, unidad, tipomov, bodega) values ('$codinv', '".$_POST[codunsd][$x]."','".$_POST[codinard][$x]."','".$_POST[cantidadd][$x]."','".$_POST[unidadd][$x]."', '$_POST[tipomov]','".$_POST[codbodd][$x]."')";
		  			$res=mysql_query($sqlr,$linkbd);
					//BUSCA PRODUCTOS POR BODEGA
					$sqlr="SELECT almarticulos_exis.existencia, almarticulos_det.factor FROM almarticulos_exis INNER JOIN almarticulos_det ON almarticulos_exis.articulo=almarticulos_det.articulo WHERE almarticulos_exis.articulo='".$_POST[codinard][$x]."' AND almarticulos_exis.bodega='".$_POST[codbodd][$x]."' AND almarticulos_det.unidad='".$_POST[unidadd][$x]."'";
					$rart=mysql_query($sqlr,$linkbd);
					//ACTUALIZA CANTIDAD PRODUCTOS POR BODEGA
					if(mysql_num_rows($rart)!=0){
						$wart=mysql_fetch_array($rart);
						$exis=$wart[0]-($_POST[cantidadd][$x]*$wart[1]);
						$sql="UPDATE almarticulos_exis SET existencia='$exis' WHERE articulo='".$_POST[codinard][$x]."' AND bodega='".$_POST[codbodd][$x]."'";
			  			$res=mysql_query($sql,$linkbd);
					}
					//ACTUALIZA CANTIDAD TOTAL DE ARTICULOS
					$sqlr="SELECT SUM(existencia) FROM almarticulos_exis WHERE articulo='".$_POST[codinard][$x]."'";
					$rart=mysql_query($sqlr,$linkbd);
					$wart=mysql_fetch_array($rart);
					$sql="UPDATE almarticulos SET existencia='$wart[0]' WHERE CONCAT(grupoinven,codigo)='".$_POST[codinard][$x]."'";
		  			$res=mysql_query($sql,$linkbd);
				}
		 	}
			*/
			echo"<script>
				despliegamodalm('visible','1','Se ha almacenado la Gestion de Inventario con Exito');
			</script>";
		}
	}
	else
	{
		echo"<script>
				despliegamodalm('visible','2','Falta asignarle el tipo de comprobante contable a los tipo de movimiento.');
			</script>";
	}
	}
	?>	
</form>
</td></tr>     
</table>
</body>
</html>