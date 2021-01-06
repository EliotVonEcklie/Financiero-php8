<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	date_default_timezone_set('UTC');
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<title>:: SPID - Almacen</title>
        <?php require "head.php"; ?>
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
						case "8":	document.getElementById('ventana2').src="inve-ginventario-documentoegreso.php";break;
						case "9":	document.getElementById('ventana2').src="inve-ginventario-artotros.php";break;
						case "10":	document.getElementById('ventana2').src="inve-ventana-articulos.php";break;
						case "11":	document.getElementById('ventana2').src="inve-ventana-ajuste.php?tipoEntrada=107";break;
						case "12":	document.getElementById('ventana2').src="inve-ventana-ajuste.php?tipoEntrada=104";break;
						case "13":	document.getElementById('ventana2').src="inve-ventana-trasladosreversion.php";break;
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
			function respuestaconsulta(pregunta, variable)
			{
				switch(pregunta)
				{
					case "1":	
						document.getElementById('oculto').value="2";
						document.form2.submit();
						break;
					case "2":
						document.form2.elimina.value=variable;
						document.form2.sw.value=document.getElementById('tipomov').value ;
						var tipoentra = document.getElementById('tipoentra').value;
						if(tipoentra=='04'){
							var codigosexis=document.getElementsByName('articulo[]');
							var codigoart = document.getElementsByName('codinard[]').item(variable).value;
							var pos = -1;
							for(var i=0;i<codigosexis.length;i++){
								if(codigosexis.item(i).value == codigoart){
									pos = i;
									break;
								}
							}
							document.getElementsByName('saldo[]').item(pos).value = parseInt(document.getElementsByName('saldo[]').item(pos).value)+parseInt(document.getElementsByName('cantidadd[]').item(pos).value);
						}
						
						document.form2.submit();
						break;
					case "3":
						document.form2.eliminacc.value=variable;
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
				if(_opc==7)
				{
					if(document.getElementById('docum').value!=""){
						document.getElementById('busqueda').value='7';
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
			function buscarReserva(codres, cednit, nom1, nom2, ape1, ape2)
			{
				document.getElementById('docum').value=codres;
				document.getElementById('ndocum').value=cednit+' - '+nom1+' '+nom2+' '+ape1+' '+ape2;
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
			function cambiarTipoEntrada(){document.getElementById('limpiar').value=1; document.form2.submit();}
			function validar(){document.form2.submit();}
			function resetear(){
				document.getElementById('reset').value=1;
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
			function agregardetalle(pos)//*************** DETALLE ENTRADA COMPRA  ************************
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
			function eliminar(variable)//*************** DETALLE ENTRADA DONACIONES ************************
			{despliegamodalm('visible','5','Esta Seguro de Eliminar','2',variable);}
			function eliminarcc(variable)
			{despliegamodalm('visible','5','Esta Seguro de Eliminar','3',variable);}
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
			function agregardetotrascompra()//**************** DETALLE OTRAS ENTRADAS DE COMPRA**********************************
			{
				var validacion01=document.getElementById('tipomov').value;
				var validacion02=document.getElementById('tipoentra').value;
				var validacion03=document.getElementById('bodega').value;
				var validacion04=document.getElementById('numarti').value;
				var validacion05=document.getElementById('cuentrans').value;
				var validacion06=document.getElementById('unimed').value;
				if(validacion01!='-1' && validacion02!='-1' && validacion03!='-1' && validacion04.trim()!='' && validacion05!='-1'  && validacion06!='')
				{
					document.form2.codart.value=document.getElementById('articulo').value;
					document.form2.cantart.value=document.getElementById('numarti').value;
					document.form2.numart.value=document.getElementById('numarti').value;
					document.form2.nomart.value=document.getElementById('narticulo').value;
					document.form2.umedida.value=document.getElementById('unimed').value;
					document.form2.codbod.value=document.getElementById('bodega').value;
					document.form2.nombod.value=document.form2.bodega.options[document.form2.bodega.selectedIndex].text;
					var valorrubros=document.getElementsByName('dvalores[]');
					var pagoscheck=document.getElementsByName('pagosselec[]');
					var totalrubros=valorrubros.length;
					var sumar=0;
					for(x=0;x<totalrubros;x++)
					{
						if(pagoscheck.item(x).checked){sumar=sumar+parseFloat(valorrubros.item(x).value);}
					}
					document.form2.vdisponiblerubros.value=sumar;
					document.form2.valoregreso.value=sumar;
					
					document.form2.agregadet.value=1;
					document.form2.submit();
				}
				else {despliegamodalm('visible','2','Faltan datos para completar el registro');}
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
				var validacion12=document.getElementById('cuenta').value;
				
				if(validacion01!='-1' && validacion02!='-1' && validacion03.item(pos).value!='-1' && validacion04.item(pos).value.trim()!='' && validacion06.item(pos).value!='' && validacion07.item(pos).value!='' && validacion08.item(pos).value!='' && validacion09.item(pos).value!='' && validacion10!='' && validacion12!='-1')
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
			
			function agregardetdonacionmov()//**************** DETALLE OTRAS ENTRADAS DE COMPRA**********************************
			{
				
				var validacion01=document.getElementById('tipomov').value;
				var validacion02=document.getElementById('tipoentra').value;
				
				var validacion03=document.getElementById('bodega').value;
				var validacion04=document.getElementById('numarti').value;
				var validacion06=document.getElementById('unimed').value;
				var validacion07=document.getElementById('articulo').value;
				var validacion08=document.getElementById('narticulo').value;
				var validacion09=document.getElementById('valorunitario').value;
				var validacion10=document.getElementById('valor').value;
				
				if(validacion01!='-1' && validacion02!='-1' && validacion03!='-1' && validacion04.trim()!='' && validacion06!='' && validacion07!='' && validacion08!='' && validacion09!='' && validacion10!='')
				{
					
					document.form2.codart.value=document.getElementById('articulo').value;
					document.form2.cantart.value=document.getElementById('numarti').value;
					document.form2.numart.value=document.getElementById('numarti').value;
					document.form2.nomart.value=document.getElementById('narticulo').value;
					document.form2.umedida.value=document.getElementById('unimed').value;
					document.form2.codbod.value=document.getElementById('bodega').value;
					if(parseInt(validacion04.trim())<= 0){
						despliegamodalm('visible','2','La cantidad de productos no puede ser menor o igual a cero');
					}else{
						if(parseFloat(validacion09)<=0){
							despliegamodalm('visible','2','El valor unitario no puede ser menor o igual a cero');
						}else{
							var arreglototal = document.getElementsByName("valortotal1[]");
							var total = 0;
							for(var i=0;i < arreglototal.length; i++){
								total+=parseFloat(arreglototal.item(i).value);
							}
							total+= parseFloat(validacion09)*parseInt(validacion04.trim());
							
							if(parseFloat(validacion10)< total){
								despliegamodalm('visible','2','El valor total no puede ser menor o igual al autorizado');
							}else{
								document.form2.agregadet.value=1;
								document.form2.submit();
							}
						}
					}
					
				}
				else {despliegamodalm('visible','2','Faltan datos para completar el registro');}
				
			}
			function agregarenttraslado(pos)//*************** DETALLE ENTRADA TRASLADOS ************************
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
			function agregardetentajuste()//*************** DETALLE ENTRADA AJUSTES ************************
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
			function agregardetreserva(pos)//*************** DETALLE SALIDA RESERVA ************************
			{
				var validacion01=document.getElementById('tipomov').value;
				var validacion02=document.getElementById('tipoentra').value;
				var validacion03=document.getElementById('docum').value;
				var validacion04=document.getElementById('saler['+pos+']').value;
				var validacion05=document.getElementById('bodega['+pos+']').value;
				if(validacion01!='-1' && validacion02!='-1' && validacion03.trim()!='' && validacion04.trim()!='' && validacion05!='-1')
				{
					document.form2.unsart.value=document.getElementById('codunsr['+pos+']').value;
					document.form2.codart.value=document.getElementById('codartr['+pos+']').value;
					document.form2.cantart.value=document.getElementById('saler['+pos+']').value;
					document.form2.numart.value=document.getElementById('cantidadr['+pos+']').value;
					document.form2.nomart.value=document.getElementById('nomartr['+pos+']').value;
					document.form2.umedida.value=document.getElementById('unimed['+pos+']').value;
					document.form2.codbod.value=document.getElementById('bodega['+pos+']').value;
					document.form2.agregadet.value=1;
					//document.form2.busqueda.value=1;
					document.form2.submit();
				}
				else {despliegamodalm('visible','2','Faltan datos para completar el registro');}
			}
			function agregardetdevolucion(pos)//*************** DETALLE SALIDA DEVOLUCION ************************
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
			function agregardetreversion(pos)//*************** DETALLE REVERSION ************************
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
			function agregardettrasladobodegas(opc)//*************** DETALLE SALIDA TRASLADOS ************************
			{
				if(opc == "1"){
					var validacion01=document.getElementById('tipomov').value;
					var validacion02=document.getElementById('tipoentra').value;
					var validacion03=document.getElementById('articulo').value;
					var validacion04=document.getElementById('narticulo').value;
					var validacion05=document.getElementById('bodega').value;
					var validacion07=document.getElementById('bodeganu').value;
					var validacion08 = document.getElementById('cantbodtras').value;
					var validacion09 = document.getElementById('valunit').value;
					
					if(validacion01!='-1' && validacion02!='-1' && validacion03.trim()!='' && validacion04.trim()!='' && validacion05.trim()!='' && validacion07!='-1' && validacion08!='' && validacion09!=''){
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
			function agregardetbaja()//*************** DETALLE SALIDA DETERIORO O BAJA ************************
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
			function eliminares(variable){
				document.form2.posAjuste.value='';
				despliegamodalm('visible','5','Esta Seguro de Eliminar','2',variable);
				}
			function guardar()//************* guardar ************
			{
				var validacion01=document.getElementById('tipomov').value;
				var validacion02=document.getElementById('tipoentra').value;
				var validacion03=document.getElementById('docum').value;
				var validacion04=document.getElementById('nombre').value;
				if(validacion01!='-1' && validacion02!='-1' && validacion03.trim()!='' && validacion04.trim()!='')
				{despliegamodalm('visible','4','Esta Seguro de Guardar','1','0');}
				else
				{
					document.form2.numero.focus();
					document.form2.numero.select();
					despliegamodalm('visible','2','Faltan Datos para Completar el Registro');
				}
			}
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
				document.form2.sw.value=document.getElementById('tipomov').value ;
				document.form2.submit();
			}
			function agregartodo()
			{
				var totalreg=document.form2.totalreg.value;
				if(totalreg==0){
					despliegamodalm('visible','2','Faltan Datos para Completar el Registro');
				}else{
					
					document.form2.agregatot.value=1;
					document.form2.submit();	
				}
				
	
			}
			function marcar(objeto,posicion)
			{	
				var pagoscheck=document.getElementsByName('pagosselec[]');
				var valasignado=document.getElementsByName('dvalores[]');
				var valdisponible=document.getElementsByName('dvdisponible[]');
				
											
				
				if(objeto.checked){pagoscheck.item(posicion).checked=true;}
				else 
				{
					if (parseFloat(valasignado.item(posicion).value) == parseFloat(valdisponible.item(posicion).value))
					{pagoscheck.item(posicion).checked=false;}	
					else{pagoscheck.item(posicion).checked=true;}	
						
				}
			}
			function visualizar(){
				document.form2.action='inve-buscagestioninventario.php';
				document.form2.submit(); 
				document.form2.action='';
				document.form2.target='';
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
					<a  class="tooltip bottom mgbt" onClick="location.href='inve-gestioninventarioentrada.php'"><img src="imagenes/add.png"/><span class="tiptext">Nuevo</span></a>
					<a  class="tooltip bottom mgbt" onClick="guardar()"><img src="imagenes/guarda.png"/><span class="tiptext">Guardar</span></a>
					<a  class="tooltip bottom mgbt" onClick="visualizar()"><img src="imagenes/busca.png"/><span class="tiptext">Buscar</span></a>
					<a  class="tooltip bottom mgbt" onClick="mypop=window.open('inve-principal.php','','');mypop.focus();"><img src="imagenes/nv.png"/><span class="tiptext">Nueva Ventana</span></a>
					<a onClick="mypop=window.open('<?php echo $url2; ?>','','');mypop.focus();" class="tooltip bottom mgbt"><img src="imagenes/duplicar_pantalla.png"><span class="tiptext">Duplicar pestaña</span></a>
					<a  class="tooltip bottom mgbt" onClick="location.href='inve-menuinventario.php'"><img src="imagenes/iratras.png"><span class="tiptext">Atrás</span></a>
				</td>
			</tr>
      	</table>
		<?php
			$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
			$nomuser=$_SESSION[usuario];
			$vigencia=$vigusu;
			if (!isset($_POST[oculto])) {
				$_POST[fecha]=date('d/m/Y');
				$_POST[tipomov]='1';
			}
			if($_POST[oculto]=="")
			{	$_POST[oculto]=0;
				$_POST[actcheck]=0;
			}
			if(($_POST[tabgroup1]=='')||(!isset($_POST[tabgroup1]))){
				$_POST[tabgroup1]=1;
			}
			switch($_POST[tabgroup1])
			{
				case 1:	$check1='checked';break;
				case 2:	$check2='checked';break;
			}
		?>
		<div id="bgventanamodal2">
			<div id="ventanamodal2">
				<IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
				</IFRAME>
			</div>
		</div>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>		  
		<form name="form2" method="post" action=""> 
			<input type="hidden"  name="limpiar"  id="limpiar" value="<?php echo $_POST[limpiar]?>"/>
            <input type="hidden"  name="oculto"  id="oculto" value="<?php echo $_POST[oculto]?>"/>	
            <input type="hidden" name="valfocus" id="valfocus" value="0"/>
            <input type='hidden' name='unsart' id='unsart' value="<?php echo $_POST[unsart]?>"/> 
            <input type='hidden' name='cantart' id='cantart' value="<?php echo $_POST[cantart]?>"/> 
            <input type='hidden' name='uniart' id='uniart' value="<?php echo $_POST[uniart]?>"/> 
            <input type='hidden' name='umedida' id='umedida' value="<?php echo $_POST[umedida]?>"/> 
            <input type='hidden' name='numart' id='numart' value="<?php echo $_POST[numart]?>"/> 
            <input type='hidden' name='nomart' id='nomart' value="<?php echo $_POST[nomart]?>"/> 
            <input type='hidden' name='codbod' id='codbod' value="<?php echo $_POST[codbod]?>"/> 
            <input type='hidden' name='codbod2' id='codbod2' value="<?php echo $_POST[codbod2]?>"/> 
            <input type='hidden' name='codart' id='codart' value="<?php echo $_POST[codart]?>"/> 
            <input type='hidden' name='grupo' id='grupo' value="<?php echo $_POST[grupo]?>"/> 
            <input type='hidden' name='hddent' id='hddent' value="<?php echo $_POST[hddent]?>"/> 
			
   			<?php
				if($_POST[tipomov]!=-1&&$_POST[tipoentra]!=-1&&$_POST[tipomov]!=""&&$_POST[tipoentra]!="")
				{
					$sql="SELECT consec FROM almginventario WHERE tipomov='$_POST[tipomov]' AND tiporeg='$_POST[tipoentra]' ORDER BY consec DESC";
					$res=mysql_query($sql);
					if(mysql_num_rows($res)!=0){$winv=mysql_fetch_array($res);$codinv=$winv[0]+1;}
					else{$codinv=1;}
					$_POST[numero]=$codinv;
					$totalcc = 0;
				}
			?>
			<table class="inicio ancho" style='width:99.7%;'>
    			<tr >
        			<td class="titulos" colspan="8" width="100%">.: Gesti&oacute;n de Inventarios </td>
                    <td class="boton02" onClick="location.href='inve-principal.php'">Cerrar</td>
    			</tr>
      			<tr>
					<td class="saludo1" style="width:5%">Consecutivo:</td>
                    <input type='hidden' name='nombod' id='nombod' value="<?php echo $_POST[nombod]?>"/> 
					<input type='hidden' name='nombod2' id='nombod2' value="<?php echo $_POST[nombod2]?>"/>
                    <input type='hidden' name='coddetalle' id='coddetalle' value="<?php echo $_POST[coddetalle]?>"/> 
                    <input type='hidden' name='agregadet' id='agregadet' value='<?php echo $_POST[agregadet] ?>'/>
					<input type='hidden' name='agregadet2' id='agregadet2' value='<?php echo $_POST[agregadet2] ?>'/>
                    <input type='hidden' name='agregatot' id='agregatot' value='<?php echo $_POST[agregatot] ?>'/>
                    <input type="hidden" name="verart" id="verart" value="<?php echo $_POST[verart]?>"/>	
                    <input type="hidden" name="busqueda" id="busqueda" value="<?php echo $_POST[busqueda]?>"/> 
          			<td style="width:8%"><input type="text" id="numero" name="numero"  style="width:100%; text-align:center" value="<?php echo $_POST[numero] ?>" readonly></td>
          			<td class="saludo1" style="width:10%;">Fecha Registro:</td>
          			<td style="width:9%"><input type="text" name="fecha" id="fc_1198971545" title="DD/MM/YYYY" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)" maxlength="10" style="width: 70%"/>&nbsp;<img src="imagenes/calendario04.png" title="Calendario"  onClick="displayCalendarFor('fc_1198971545');" class="icobut" /></td>
                    <input type="hidden" name="chacuerdo" value="1"/>
		 			<td class="saludo1" style="width:8%">Descripci&oacute;n:</td>
          			<td style="width:25%"><input type="text" id="nombre" name="nombre" style="width:100%;" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[nombre]?>"/></td>
	   				<td class="saludo1" style="width:14%">Tipo de Movimiento: </td>
          			<td style="width:14%">
                        <select name="tipomov" id="tipomov" onChange="validar()"  style="width:100%;" >
                            <option value="-1">Seleccione ....</option>
                            <option value="1" <?php if($_POST[tipomov]=='1') echo "SELECTED"; ?>>1 - Entrada</option>
                            <option value="3" <?php if($_POST[tipomov]=='3') echo "SELECTED"; ?>>2 - Reversi&oacute;n de Entrada</option>
                        </select>
       				</td>
                    <input type="hidden" name="sw" id="sw" value="<?php echo $_POST[tipomov];?>"/>
	   				<td style="width:7%"></td>
       			</tr>
  			</table>	
			<?php 
				ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
				$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
				/*
				if($_POST[limpiar]!=''){
					$_POST[docum]="";
					$_POST[ndocum]="";
					$_POST[valor]="";
					$_POST[tercero]="";
					$_POST[ntercero]="";
					unset($_POST[limpiar]);
				}
				*/
				if($_POST[tipomov]==1 || $_POST[tipomov]=="" || $_POST[tipomov]==-1)
				{
					echo"
            			<table class='inicio ancho' style='width:99.7%;'>
                			<tr><td colspan='12' class='titulos2'>Gesti&oacute;n Inventario - Entrada</td></tr>
                			<tr>
                    			<td class='saludo1' style='width:7%'>Tipo Entrada</td>
                    			<td style='width:7%'>
                        			<select name='tipoentra' id='tipoentra' onChange='cambiarTipoEntrada()'>
                            			<option value='-1'>Seleccione ....</option>";
                 	$sqlr="SELECT * FROM almtipomov WHERE tipom='$_POST[tipomov]' AND estado='S' ORDER BY tipom, codigo";
                 	$resp = mysql_query($sqlr,$linkbd);
               		while($row =mysql_fetch_row($resp)) 
					{
                    	if($row[0]==$_POST[tipoentra])
						{
							$_POST[tipoentra]=$row[0];
							$_POST[ntipoentra]=$row[2];
               				echo "<option value='$row[0]' SELECTED>$row[1]$row[0] - $row[2]</option>";
                      	}
                     	else {echo "<option value='$row[0]'>$row[1]$row[0] - $row[2]</option>"; }
                  	}   
                    echo"            
                        			</select>
                    			</td>";
                    if($_POST[tipoentra]==0 || $_POST[tipoentra]==-1)//ENTRADA manual
					{
						echo" 
                   				<td style='width:34%'></td>
                    			<td style='width:34%'></td>
								<td></td>
               				</tr>
            			</table>";
  			 			
                    } //FIN ENTRADA POR DONACIONES
					if($_POST[tipoentra]==1)//ENTRADA POR COMPRA
					{
						echo"
								<input type='hidden' name='ntipoentra' id='ntipoentra' value='$_POST[ntipoentra]'/> 
								<input type='hidden' id='codiun' name='codiun' value='$_POST[codiun]'/>
								<input type='hidden' id='numcan' name='numcan' value='$_POST[numcan]'/>
								<input type='hidden' id='valunitp' name='valunitp' value='$_POST[valunitp]'/>
								<input type='hidden' id='vtotal' name='vtotal' value='$_POST[vtotal]'/>
								<input type='hidden' id='totalreg' name='totalreg' value='$_POST[totalreg]'/>
                    			<td class='saludo1' style='width:6%'>Documento</td>
                    			<td style='width:12%;'><input type='text' name='docum' id='docum' value='$_POST[docum]' onBlur=\"guiabuscar('1');\" onKeyPress='javascript:return solonumeros(event)' onKeyUp='return tabular(event,this)' style='width:80%'/>&nbsp;<img src='imagenes/find02.png' onClick=\"despliegamodal2('visible','1');\" class='icobut' title='Lista de documentos'/></td>
                    			<td style='width:20%;'><input type='text' name='ndocum' id='ndocum' value='$_POST[ndocum]' style='width:100%; text-transform:uppercase' readonly/></td>
								<td class='saludo1' >Centro Costo</td>
								<td style='width:25%;'>
									<select name='centrocosto' id='centrocosto'  onKeyUp='return tabular(event,this)' style='width:73%;' onChange='validar();'>
										<option value=''>Seleccione ...</option>";
							$sqlr="select *from centrocosto where estado='S' order by id_cc	";
							$res=mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($res)) 
							{
								if("$row[0]"==$_POST[centrocosto]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
								else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
							}	 	
							echo"
									</select>
								</td>
								
                			</tr>
           				</table>
    					<div class='subpantalla'  style='height:58%; width:99.5%; overflow:hidden;'>
    						<div class='subpantallac' style='height:45%;overflow-x:hidden;'>";
                		if($_POST[busqueda]!="")
						{
                    		if($_POST[busqueda]=="1")
							{
                       	 		$nresul=buscasoladquisicion($_POST[docum]);
                        		if(count($nresul)>0)
								{
                           			echo "
									<script>
                                		document.form2.busqueda.value=0;
                                		buscarDocum('$nresul[2]','$nresul[1]','$nresul[0]','$nresul[3]','$nresul[4]','$nresul[5]');
                            		</script>";
                        		}
                       			else
								{
                           			echo "
									<script>
                                		document.getElementById('valfocus').value='1';
                               			despliegamodalm('visible','2','Código del Documento Incorrecto');
                           			</script>";
                        		}
                    		}
                		}//FIN BUSQUEDA	
						if ($_POST[verart]==1)
						{
							$codigos = explode("-", $_POST[codiun]);	
							$cantidades = explode("-", $_POST[numcan]);	
							$valunitp = explode("-", $_POST[valunitp]);	
							$pos=0;
							$numreg=count($codigos);
							echo "
							<script>document.getElementById('totalreg').value='$numreg';</script>
							<table class='inicio ancho'>
								<tr class='titulos'><td colspan='13'><input type='button' name='todos' id='todos' value=' Registrar Todos ' onClick='agregartodo()' style='background-color:#36D000 !important;float:right'></td></tr>";
							foreach ($codigos as $cod)
							{
								if($cantidades[$pos]=="") $cantidades[$pos]=0;
								if($valunitp[$pos]=="") $valunitp[$pos]=0;
   								echo"
								<tr>
									<td class='saludo1' style='width:5%'>UNSPSC:</td> 
									<td style='width:8%'><input type='text' id='coduns[$pos]' name='coduns[$pos]' onKeyUp='return tabular(event,this)' value='$cod' readonly style='width:100%;'/></td>
									<td class='saludo1' style='width:5%'>Articulo:</td>
									<td style='width:15%'>
										<select id='codinar[$pos]' name='codinar[$pos]' style='width:100%' onchange='javascript:form2.nomart.value= this.options[this.selectedIndex].text;'> 
											<option value='-1'>Seleccione ....</option>";
								$c=0;
								$sqlr="SELECT almarticulos.codigo, almarticulos.grupoinven, almarticulos.nombre, almarticulos_det.unidad FROM almarticulos INNER JOIN almarticulos_det ON CONCAT(almarticulos.grupoinven,almarticulos.codigo)=almarticulos_det.articulo where almarticulos.estado='S' AND almarticulos_det.principal='1' AND almarticulos.codunspsc = $cod  ORDER BY almarticulos.codigo";
								$resp = mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp))
								{
									$c=$c+1;	
									$i=$row[0];
									$unimed=$row[3];
									$str="$row[1]$row[0]";
									if($str==$_POST[codinar][$pos])
									{
										echo"<option value='$row[1]$row[0]' SELECTED>$row[1]$row[0] - $row[2]</option>"; 
									}
									else {echo"<option value='$row[1]$row[0]'>$row[1]$row[0] - $row[2]</option>";}
								}   
								echo"
										</select>
										<input type='hidden' name='unimed[$pos]' id='unimed[$pos]' value='$unimed' />
				    					<input type='hidden' name='codinarnom[$pos]' value='".$_POST[codinarnom][$pos]."'/>
									</td>
									<td class='saludo1' style='width:6%'>Cantidad </td>
        							<td style='width:6%'><input type='text' name='cantidad[$pos]' id='cantidad[$pos]' value='".number_format($cantidades[$pos],0,',','.')."' onKeyPress='javascript:return solonumerossinpuntos(event)' onKeyUp='return tabular(event,this)' style='text-align:center; width:100%;'/></td>
									<td class='saludo1' style='width:5%'>Vr.Unit: </td>
									<td style='width:10%'><input type='text' name='valunit[$pos]' id='valunit[$pos]' value='".number_format($valunitp[$pos],0,',','.')."' onKeyPress='javascript:return solonumeros(event)' onKeyUp='return tabular(event,this)' style='text-align:right; width:100%'/></td> 
									<td class='saludo1' style='width:5%'>Ingresa: </td>
									<td style='width:10%'><input type='text' name='ingresa[$pos]' id='ingresa[$pos]' value='' onKeyPress='javascript:return solonumeros(event)' onKeyUp='return tabular(event,this)' style='text-align:right; width:100%'/></td> 
									<td class='saludo1' style='width:5%'>Bodega:</td>
									<td>
										<select id='bodega[$pos]' name='bodega[$pos]' onchange='javascript:form2.nombod.value= this.options[this.selectedIndex].text;'> 
											<option value='-1'>Seleccione ....</option>";
								$sqlr="SELECT * FROM almbodegas WHERE estado='S' ORDER BY id_cc";
								$resp = mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp))
								{
									if($row[0]==$_POST[bodega][$pos]){echo"<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
									else {echo"<option value='$row[0]'>$row[0] - $row[1]</option>";}
			    				}   
		 						echo "
										</select>
									</td>
		  							<td class='saludo1' style='width:5%'><em name='registrar' id='registrar' type='button' class='botonflecha' style='width:100%; height:22px' onClick=\"agregardetalle('$pos')\">Registrar</em></td>
								</tr>";
								$pos =$pos+1;
							}
							echo "
							</table>";
						}
						echo"
							</div>
   							<div class='subpantallac' style='height:50%; overflow-x:hidden;'>
								<table class='inicio'>
									<tr><td class='titulos' colspan='9'>Detalle Gesti&oacute;n Inventario - Entrada</td></tr>
									<tr class='titulos2'>
        								<td style='width:10%'>Codigo UNSPSC</td>
        								<td style='width:10%'>Codigo Articulo</td>
            							<td style='width:20%'>Nombre Articulo</td>
            							<td style='width:5%'>Cantidad</td>
            							<td style='width:20%'>Bodega</td>
										<td style='width:15%'>Centro de Costo</td>
            							<td style='width:7%'>Valor Unitario</td>
            							<td style='width:7%'>Valor Total</td>
           								<td style='width:5%'><img src='imagenes/del.png'/></td>
            							<input type='hidden' name='elimina' id='elimina'>
										<input type='hidden' name='contad' id='contad' value='$_POST[contad]'/>
      								</tr>";
						if($_POST[elimina]!='')
						{ 
							$posi=$_POST[elimina];
							unset($_POST[codunsd][$posi]);
							unset($_POST[codinard][$posi]);
							unset($_POST[codartd][$posi]);
							unset($_POST[grupod][$posi]);
							unset($_POST[nomartd][$posi]);
							unset($_POST[codbodd][$posi]);
							unset($_POST[bodegad][$posi]);
							unset($_POST[unidadd][$posi]);
							unset($_POST[cantidadd][$posi]);
							unset($_POST[valunitd][$posi]);
							unset($_POST[valtotd][$posi]);
							unset($_POST[cuentacon][$posi]);
							unset($_POST[dcc][$posi]);
							$_POST[codunsd]= array_values($_POST[codunsd]); 
							$_POST[codinard]= array_values($_POST[codinard]); 
							$_POST[nomartd]= array_values($_POST[nomartd]); 		 		 
							$_POST[codbodd]= array_values($_POST[codbodd]); 		 		 
							$_POST[bodegad]= array_values($_POST[bodegad]); 		 		 
							$_POST[unidadd]= array_values($_POST[unidadd]); 		 		 
							$_POST[cantidadd]= array_values($_POST[cantidadd]); 
							$_POST[valunitd]= array_values($_POST[valunitd]); 
							$_POST[valtotd]= array_values($_POST[valtotd]); 
							$_POST[cuentacon]= array_values($_POST[cuentacon]); 
							$_POST[dcc]= array_values($_POST[dcc]); 
							
							echo"<script>document.getElementById('contad').value=".count($_POST[codinard]).";</script>";
						}
						if($_POST[agregatot]=='1')//-- Agregar todos los articulos
						{
							$cantreg=$_POST[totalreg];
							$flag=false;
							for($i=0; $i<$cantreg; $i++)
							{
								if($_POST[codinar][$i]=="-1" || $_POST[bodega][$i]=="-1" || $_POST[ingresa][$i]=="")
								{
									$flag=true;
									break;
								}
							}
							if($flag){echo "<script>despliegamodalm('visible','2','No pueden existir campos vacios'); </script>";}
							else
							{
								for($i=0; $i<$cantreg; $i++)
								{
									
									$codgrupo= substr($_POST[codinar][$i], 0, 4);
									//Pendiente
									$sqlrcumdon="SELECT T2.cuenta FROM almgrupoinv T1, conceptoscontables_det T2 WHERE  T1.codigo='$codgrupo' AND T1.concepent=T2.codigo AND T2.cc = '$_POST[centrocosto]' AND T2.modulo='5' AND T2.debito='S' AND T2.estado='S' AND T2.fechainicial=(SELECT MAX(T3.fechainicial) FROM conceptoscontables_det T3 WHERE  T3.codigo=T2.codigo AND T3.cc = '$_POST[centrocosto]' AND T3.modulo='5' AND T3.debito='S' AND T3.estado='S' AND T3.fechainicial<='$fechaf')";
									$rescumdon = mysql_query($sqlrcumdon,$linkbd);
									$cuentadeb = mysql_fetch_row($rescumdon);
									
									$cantmp=str_replace('.','',$_POST[ingresa][$i]);
									$unitmp=str_replace('.','',$_POST[valunit][$i]);
									$_POST[codunsd][]=$_POST[coduns][$i];
									$_POST[codinard][]=$_POST[codinar][$i];
									$_POST[nomartd][]=$_POST[codinarnom][$i];
									$_POST[codbodd][]=$_POST[bodega][$i];
									$_POST[bodegad][]=$_POST[bodega][$i];
									$_POST[unidadd][]=$_POST[ingresa][$i];
									$_POST[cantidadd][]=$_POST[cantidad][$i];
									$_POST[valunitd][]=$_POST[valunit][$i];
									$_POST[cuentacon][]=$cuentadeb[0];
									$_POST[dcc][]=$_POST[centrocosto];
									$_POST[valtotd][]=number_format($unitmp*$cantmp,0,',','.');	
								}
								echo"<script>document.getElementById('agregatot').value='0';</script>";
							}
						}
						if($_POST[agregadet]=='1')
						{
							$cantmp=str_replace('.','',$_POST[cantart]);
							$unitmp=str_replace('.','',$_POST[uniart]);
							$numart=0; $posicion=-1;
							//VALIDA1: QUE NO SUPERE LAS CANTIDAD REGISTRADAS EN LA ENTRADA
							for ($x=0;$x < count($_POST[codinard]);$x++)
							{
								if($_POST[unsart]==$_POST[codunsd][$x]){$numart+=$_POST[cantidadd][$x];}
							}
							$numart+=$_POST[cantart];
							//VALIDA2: QUE SUME CANTIDADES AL SACAR EL MISMO ARTICULO
							for ($x=0;$x < count($_POST[codinard]);$x++)
							{
								if(($_POST[codart]==$_POST[codinard][$x])&&($_POST[codbod]==$_POST[codbodd][$x]))
								{
									$posicion=$x;
									$totalart=$_POST[cantidadd][$x];
								}
							}
							$totalart+=$_POST[cantart];
							//FIN VALIDA2
							if($numart<=$_POST[numart])
							{
								if($posicion<=-1)
								{
									$codgrupo= substr($_POST[codart], 0, 4);
									//Pendiente
									$sqlrcumdon="SELECT T2.cuenta FROM almgrupoinv T1, conceptoscontables_det T2 WHERE  T1.codigo='$codgrupo' AND T1.concepent=T2.codigo AND T2.cc = '$_POST[centrocosto]' AND T2.modulo='5' AND T2.debito='S' AND T2.estado='S' AND T2.fechainicial=(SELECT MAX(T3.fechainicial) FROM conceptoscontables_det T3 WHERE  T3.codigo=T2.codigo AND T3.cc = '$_POST[centrocosto]' AND T3.modulo='5' AND T3.debito='S' AND T3.estado='S' AND T3.fechainicial<='$fechaf')";
									//echo $sqlrcumdon;
									$rescumdon = mysql_query($sqlrcumdon,$linkbd);
									$cuentadeb = mysql_fetch_row($rescumdon);
									
									$_POST[codunsd][]=$_POST[unsart];
									$_POST[codinard][]=$_POST[codart];
									$_POST[nomartd][]=$_POST[nomart];
									$_POST[codbodd][]=$_POST[codbod];
									$_POST[bodegad][]=$_POST[nombod];
									$_POST[unidadd][]=$_POST[umedida];
									$_POST[cantidadd][]=$_POST[cantart];
									$_POST[valunitd][]=$unitmp;
									$_POST[cuentacon][]=$cuentadeb[0];
									$_POST[valtotd][]=$unitmp*$cantmp;
									$_POST[dcc][] = $_POST[centrocosto];
								}	
								else{$_POST[cantidadd][$posicion]=$totalart;}
							}
							else{echo"<script>despliegamodalm('visible','2','La Cantidad de Articulos a Ingresar Supera la Cantidad descrita en la Entrada');</script>";}
							echo"
							<script>
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
									<input type='hidden' name='unidadd[]' value='".$_POST[unidadd][$x]."'/>
									<input type='hidden' name='cantidadd[]' value='".$_POST[cantidadd][$x]."'>
									<input type='hidden' name='bodegad[]' value='".$_POST[bodegad][$x]."'/>
									<input type='hidden' name='codbodd[]' value='".$_POST[codbodd][$x]."'/>
									<input type='hidden' name='valunitd[]' value='".$_POST[valunitd][$x]."'/>
									<input type='hidden' name='valtotd[]' value='".$_POST[valtotd][$x]."'>
									<input type='hidden' name='cuentacon[]' value='".$_POST[cuentacon][$x]."'>
									<input type='hidden' name='dcc[]' value='".$_POST[dcc][$x]."'>
									<tr class='$iter'/>
										<td>".$_POST[codunsd][$x]."</td> 
										<td>".$_POST[codinard][$x]."</td> 
										<td>".$_POST[nomartd][$x]."</td>
										<td>".$_POST[cantidadd][$x]."</td>
										<td>".$_POST[bodegad][$x]."</td>
										<td>".$_POST[dcc][$x]."</td>
										<td>".$_POST[valunitd][$x]."</td>
										<td>".$_POST[valtotd][$x]."</td>
										<td style='width:5%'><img src='imagenes/del.png' onclick='eliminar($x)' class='icobut'></td>
									</tr>";
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
		 				}	 
		 				echo"
								</table>
							</div>
						</div>";
					}  //FIN ENTRADA POR COMPRA
					if($_POST[tipoentra]==2)
					{
					?> 
	    			<td class="saludo1" width="34%" style="font-weight: bold">Bodega
                        <input id="codiun" name="codiun" type="hidden" value="<?php echo $_POST[codiun]?>">
                        <input id="numcan" name="numcan" type="hidden" value="<?php echo $_POST[numcan]?>">
                        <input id="valunitp" name="valunitp" type="hidden" value="<?php echo $_POST[valunitp]?>">
                        <input id="vtotal" name="vtotal" type="hidden" value="<?php echo $_POST[vtotal]?>">
                        <input id="docum" name="docum" type="hidden" value="ENTRADA POR DONACION">
                        <select name="bodega" id="bodega">
                            <option value="-1">Seleccione ....</option>
                            <?php
                            $sqlr="Select * from almbodegas where estado='S' ORDER BY id_cc";
                            $resp = mysql_query($sqlr,$linkbd);
                            while($row =mysql_fetch_row($resp)) {
                                $i=$row[0];
                                echo "<option value=$row[0] ";
                                if($i==$_POST[bodega]){
                                    echo "SELECTED";
                                    $_POST[bodega]=$row[0];
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
			    	<td class="saludo1" width="8%" style="font-weight: bold">.: Artículos</td>
                    <td style="width:12%;">
                    	<input type="text" name="articulo" id="articulo" value="<?php echo $_POST[articulo]?>" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="guiabuscar('1');" style="width:80%"/>&nbsp;
						<a href="#" onClick="despliegamodal2('visible','7');"><img src="imagenes/buscarep.png"/></a>
                    </td>
                    <td style="width:20%;">
                    	<input type="text" name="narticulo" id="narticulo" value="<?php echo $_POST[narticulo]?>" style="width:100%;text-transform:uppercase" readonly/>
                   	</td>
			    	<td class="saludo1" width="10%" style="font-weight: bold">.: Cantidad</td>
		          	<td style="width:8%;">
        		       	<input type="text" name="numdona" id="numdona" value="<?php echo $_POST[numdona]?>" style="width:100%; text-align:right;" />
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
						<em name='regdona' id='regdona' type='button' class="botonflecha" onClick='agregardetdonacion()' >Confirmar</em>
                    </td>
       			</tr>
           	</table>
    	</div>
    	<div class="subpantallac" style="height:86%; overflow-x:hidden;">
		<table class="inicio">
			<tr>
    			<td class="titulos" colspan="7">Detalle Gesti&oacute;n Inventario - Entrada por Donaciones</td>
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
 			 	unset($_POST[donad][$posi]);
			 	unset($_POST[cantidadd][$posi]);
			 	unset($_POST[unidadd][$posi]);
			 	unset($_POST[codbodd][$posi]);
			 	unset($_POST[bodegad][$posi]);
			 	$_POST[codunsd]= array_values($_POST[codunsd]); 
			 	$_POST[codinard]= array_values($_POST[codinard]); 
			 	$_POST[nomartd]= array_values($_POST[nomartd]); 		 		 
		 		$_POST[donad]= array_values($_POST[donad]); 
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

				//VALIDA1: SUMA ARTICULOS
				for ($x=0;$x < count($_POST[codinard]);$x++){
					if($_POST[codart]==$_POST[codinard][$x]){
						$posicion=$x;
						$numart+=$_POST[cantidadd][$x];
					}
				}
				$numart+=$_POST[cantart];
				//FIN VALIDA1
				
				if($posicion<=-1){
				 	$_POST[codunsd][]=$_POST[unsart];
					$_POST[codinard][]=$_POST[codart];
				 	$_POST[nomartd][]=$_POST[nomart];
		  			$_POST[donad][]=$_POST[numart];
			 		$_POST[cantidadd][]=$_POST[cantart];
				 	$_POST[unidadd][]=$_POST[umedida];
				 	$_POST[codbodd][]=$_POST[codbod];
				 	$_POST[bodegad][]=$_POST[nombod];
				}	
				else{
					$_POST[cantidadd][$posicion]=$numart;
				}
				echo"<script>
					document.getElementById('agregadet').value='0';
					document.getElementById('contad').value=".count($_POST[codinard]).";
				</script>";
			}
			$iter='saludo1a';
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
						<input name='donad[]' value='".$_POST[donad][$x]."' type='hidden'>
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
}//FIN ENTRADA POR DONACIONES
					if($_POST[tipoentra]==3)//ENTRADA POR TRASLADOS
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
								$_POST[cantbodact] = totalinventario($_POST[articulo],$_POST[bodega]);
								$_POST[saldobod] = $_POST[cantbodact];
							}
							if($_POST[centrocosto]!="-1"){
								$_POST[cantccact] = totalinventario($_POST[articulo],'',$_POST[centrocosto]);
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
        	<td class="titulos2" style="width: 13%">Código Articulo</td>
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
        	<td class="titulos2" style="width: 13%">Código Articulo</td>
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
				//Se obtiene la cuenta contable que acredita
				$codgrupo= substr($_POST[articulo], 0, 4);
				$sqlrpat="SELECT cuentapatrimonio FROM almparametros";
				$respat = mysql_query($sqlrpat,$linkbd);
				$cuentapat=mysql_fetch_row($respat);
				
				//Se obtiene la cuenta contable que debita
				$sqlrcumdon="SELECT T2.cuenta FROM almgrupoinv T1, conceptoscontables_det T2 WHERE  T1.codigo='$codgrupo' AND T1.concepent=T2.codigo AND T2.cc = '$_POST[centrocosto]' AND T2.modulo='5' AND T2.debito='S' AND T2.estado='S' AND T2.fechainicial=(SELECT MAX(T3.fechainicial) FROM conceptoscontables_det T3 WHERE  T3.codigo=T2.codigo AND T3.cc = '$_POST[centrocosto]' AND T3.modulo='5' AND T3.debito='S' AND T3.estado='S' AND T3.fechainicial<='$fechaf')";
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
}//FIN ENTRADA POR TRASLADOS

if($_POST[tipoentra]==4)//ENTRADA POR AJUSTES
{
	
echo"
				<td class='saludo1' style='width:6%;'>Documento</td>
				<input type='hidden' id='ntipoentra' name='ntipoentra' value='$_POST[ntipoentra]'/> 
				<input type='hidden' id='codiun' name='codiun'  value='$_POST[codiun]'/>
				<input type='hidden' id='valunitp' name='valunitp' value='$_POST[valunitp]'/>
				<input type='hidden' id='ccselect' name='ccselect' value='$_POST[ccselect]'/>
				<input type='hidden' id='controlaAjuste' name='controlaAjuste' value='$_POST[controlaAjuste]' />
				<td style='width:12%;'>
					<input type='text' name='docum' id='docum' value='$_POST[docum]' onKeyPress='javascript:return solonumeros(event)' onKeyUp='return tabular(event,this)' onBlur=\"guiabuscar('4');\" style='width:80%'/>&nbsp;<img class='icobut' src='imagenes/find02.png'  title='Lista de actos por ajuste' onClick=\"despliegamodal2('visible','12');\"/></td>
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
				$sqlm="SELECT * FROM conceptoscontables WHERE tipo='EA' and modulo='5' ORDER BY codigo";
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
		<div class="subpantallac" style="height:18.5%; overflow-x:hidden;">
			<table class="inicio ancho">
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
					
						$sql = "SELECT codigo,descripcion,unumedida,cantidad,valor,saldo FROM almactoajusteentarticu WHERE idacto='$_POST[docum]' AND tipo_mov=104 AND estado='S' ";
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
					<td class='saludo1' style='width:4%;'>Art&iacute;culo</td>
					<td style='width:7%;'>
						<input type='text' name='articulo[]' value='".$_POST[articulo][$x]."' onKeyPress='javascript:return solonumeros(event)' onKeyUp='return tabular(event,this)' onBlur='guiabuscar1(1);' style='width:95%' readonly/></td>
					<td style='width:10%;'>
						<input type='text' name='narticulo[]' value='".$_POST[narticulo][$x]."' style='width:100%;text-transform:uppercase' readonly/>
					</td>
					<td class='saludo1' style='width:3%;'>Saldo</td>
					<td style='width:3%;'><input type='text' name='saldo[]' value='".$_POST[saldo][$x]."' style='width:100%; text-align:right;' onKeyPress='javascript:return solonumeros(event)' readonly/> </td>
					<td class='saludo1' style='width:5%;'>Cantidad</td>
					<td style='width:3%;'><input type='text' name='numarti[]' onKeyPress='javascript:return solonumerossinpuntos(event)' value='".$_POST[numarti][$x]."' style='width:100%; text-align:right;' onKeyPress='javascript:return solonumeros(event)'/> </td>
					<td class='saludo1' style='width:7%;'>Valor Unitario</td>
					<td style='width:5%;'><input type='text' name='valorunitario[]' value='".$_POST[valorunitario][$x]."' style='width:100%; text-align:right;' onKeyPress='javascript:return solonumeros(event)' readonly/></td>
					<td class='saludo1' width='4%' style='font-weight: bold'>Bodega</td>
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

					<td class='saludo1' width='7%' style='font-weight: bold'>Centro Costo</td>
					<td width='10%'>
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
					<td class='saludo1' width='3%' style='font-weight: bold'>U.M</td>
					<td width='17%'>
						<input type='text' name='unimed[]' value='".$_POST[unimed][$x]."' style='width: 43%;' readonly/>
						<em name='regajus' id='regajus' type='button' class='botonflecha' style='width:40%; height:22px' onClick='agregardetajuste($x)' >Agregar</em>
						
					</td>
				</tr>";
				
					}

				?>
				

			</table>
		</div>
	<div class="subpantallac" style="height:34%; overflow-x:hidden;">
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
			<input type='hidden' name='posAjuste' id='posAjuste' value="<?php $_POST[posAjuste]?>"/>
			<input type='hidden' name='elimina' id='elimina'/>
			<input type='hidden' name='contad' id='contad' value='<?php $_POST[contad] ?>'/>
			<?php	
			//var_dump($_POST[posAjuste]);		 
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
				$pos = $_POST[posAjuste];
				//FIN VALIDA1
				$valorto=$_POST[valorunitario][$pos]*$numart;
				
				
				$codgrupo= substr($_POST[codart], 0, 4);
				
				$codarticulo= substr($_POST[codart], -5);
				
				$sqlrcumdon="SELECT T2.cuenta FROM almgrupoinv T1, conceptoscontables_det T2 WHERE  T1.codigo='$codgrupo' AND T1.concepent=T2.codigo AND T2.cc = '".$_POST[centrocosto][$pos]."' AND T2.modulo='5' AND T2.debito='S' AND T2.estado='S' AND T2.fechainicial=(SELECT MAX(T3.fechainicial) FROM conceptoscontables_det T3 WHERE  T3.codigo=T2.codigo AND T3.cc = '".$_POST[centrocosto][$pos]."' AND T3.modulo='5' AND T3.debito='S' AND T3.estado='S' AND T3.fechainicial<='$fechaf')";

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
					<td colspan='4'></td>
				</tr>";
			 ?>
		</table>
	</div>
<?php
//FIN ENTRADA POR AJUSTES
}

if($_POST[tipoentra]==5)//TRASLADO ENTRE BODEGAS
{
	$_POST[saldobod] = 0;
	$_POST[saldocc] = 0;
	if(!isset($_POST[valunit]))
	{
		$_POST[valunit] = 0;
	}
	if(!isset($_POST[valunitcc]))
	{
		$_POST[valunitcc] = 0;
	}
	
	$_POST[docum] = $_POST[numero];
	if($_POST[articulo]!='')
	{
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
		
		if($_POST[bodega]!="-1")
		{
			$_POST[cantbodact] = totalinventario($_POST[articulo],$_POST[bodega]);
			$_POST[saldobod] = $_POST[cantbodact];
		}
		if($_POST[centrocosto]!="-1")
		{
			$_POST[cantccact] = totalinventario($_POST[articulo],'',$_POST[centrocosto]);
			$_POST[saldocc] = $_POST[cantccact];
		}
	}
	?>
		<td class="saludo1" style="width:5%" style="font-weight: bold">Articulo:</td>
		<input type='hidden' name='ntipoentra' id='ntipoentra' value="<?php echo $_POST[ntipoentra]?>" > 
		<input id="codiun" name="codiun" type="hidden" value="<?php echo $_POST[codiun]?>">
		<input id="numcan" name="numcan" type="hidden" value="<?php echo $_POST[numcan]?>">
		<input id="valunitp" name="valunitp" type="hidden" value="<?php echo $_POST[valunitp]?>">
		<input id="vtotal" name="vtotal" type="hidden" value="<?php echo $_POST[vtotal]?>">
		<input id="docum" name="docum" type="hidden" value="<?php echo $_POST[docum]?>" >
		<td style="width:5%;" >
			<input type="text" name="articulo" id="articulo" value="<?php echo $_POST[articulo]?>" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="guiabuscar('1');" style="width:80%"/>&nbsp;<img class="icobut" src="imagenes/find02.png"  title="Lista de Articulos" onClick="despliegamodal2('visible','10');"/></a>
		</td>
		<td width="80%">
			<input type="text" name="narticulo" id="narticulo" value="<?php echo $_POST[narticulo]?>" style="width:100%;text-transform:uppercase" readonly/>
		</td>
			
		</tr>
		<tr>
		<td class="saludo1" style="width:10%" style="font-weight: bold">Centro costo:</td>
			<td width="20%">
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
			<td class="saludo1" style="font-weight: bold">Bodega</td>
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
			
		</tr>
	</table>
    <div class="subpantalla"  style="height:54%; width:99.8%; overflow:hidden;display:flex">
   		<div class="subpantallac" style="height:100%;width:100%; overflow-x:hidden">
			<table class="inicio ancho">
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
					<td style="width:8%"><input type="text" name="cantbodtras" id="cantbodtras" onKeyPress="javascript:return solonumerossinpuntos(event)" value="<?php echo $_POST[cantbodtras]?>" style="width:95%" /> </td>
					<td class="saludo1" style="font-weight: bold; width: 8%">Saldo</td>
					<td width="25%">
						<input type="text" name="saldobod" id="saldobod" value="<?php echo $_POST[saldobod]?>" style="width:40%; margin-right:10%" readonly/>
						<em name="regbodtraslado" id="regbodtraslado" type="button" class="botonflecha" onClick="agregardettrasladobodegas('1')" >Agregar</em>
					</td>
				</tr>
			</table>
			<table class="inicio">
				<tr>
					<td class="titulos2" style="width: 13%">Código Articulo</td>
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
	</div>
<?php 
}
/*
?> 
	<td class="saludo1" width="6%" style="font-weight: bold">Documento</td>
	<input type='hidden' name='ntipoentra' id='ntipoentra' value="<?php echo $_POST[ntipoentra]?>" > 
	<input id="codiun" name="codiun" type="hidden" value="<?php echo $_POST[codiun]?>">
	<input id="numcan" name="numcan" type="hidden" value="<?php echo $_POST[numcan]?>">
	<input id="valunitp" name="valunitp" type="hidden" value="<?php echo $_POST[valunitp]?>">
	<input id="vtotal" name="vtotal" type="hidden" value="<?php echo $_POST[vtotal]?>">
	<td style="width:12%;">
		<input type="text" name="docum" id="docum" value="<?php echo $_POST[docum]?>" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="guiabuscar('1');" style="width:80%"/>&nbsp;<a href="#" onClick="despliegamodal2('visible','1');"><img src="imagenes/buscarep.png"/></a>
	</td>
	<td  width="50%">
		<input type="text" name="ndocum" id="ndocum" value="<?php echo $_POST[ndocum]?>" style="width:100%;text-transform:uppercase" readonly/>
	</td>
</tr>
</table>
<div class="subpantalla"  style="height:62%; width:99.8%; overflow-x:hidden;">
<div class="subpantallac" style="height:47%; overflow-x:hidden;">
  	<?php
	if($_POST[busqueda]!=""){
		if($_POST[busqueda]=="1"){
			$nresul=buscasoladquisicion($_POST[docum]);
			if(count($nresul)>0){
				echo "<script>
					document.form2.busqueda.value=0;
					buscarDocum('".$nresul[2]."', '".$nresul[1]."', '".$nresul[0]."', '".$nresul[3]."', '".$nresul[4]."', '".$nresul[5]."');
				</script>";
			}
			else{
				echo "<script>
					document.getElementById('valfocus').value='1';
					despliegamodalm('visible','2','Código del Documento Incorrecto');
				</script>";
			}
		}
	}		
	//FIN BUSQUEDA
	if ($_POST[verart]==1){
		$codigos = explode("-", $_POST[codiun]);	
		$cantidades = explode("-", $_POST[numcan]);	
		$valunitp = explode("-", $_POST[valunitp]);	
		$pos=0;
		echo "<table class='inicio'>";
		foreach ($codigos as $cod){
			if($cantidades[$pos]=="") $cantidades[$pos]=0;
			if($valunitp[$pos]=="") $valunitp[$pos]=0;
   			echo"<tr>
				<td class='saludo1' style='width:5%'>UNSPSC:</td> 
				<td style='width:8%'>
					<input type='text' id='coduns[".$pos."]' name='coduns[".$pos."]' onKeyUp='return tabular(event,this)' value='$cod' readonly=readonly style='width:100%;' >
				</td>
				<td class='saludo1' style='width:5%'>Articulo:</td>
				<td colspan='1'>
					<select id='codinar[".$pos."]' name='codinar[".$pos."]' onchange='javascript:form2.nomart.value=this.options[this.selectedIndex].text;'> 
						<option value='-1'>Seleccione ....</option>";
						$c=0;
						$sqlr="SELECT almarticulos.codigo, almarticulos.grupoinven, almarticulos.nombre, almarticulos_det.unidad FROM almarticulos INNER JOIN almarticulos_det ON CONCAT(almarticulos.grupoinven,almarticulos.codigo)=almarticulos_det.articulo where almarticulos.estado='S' AND almarticulos_det.principal='1' AND almarticulos.codunspsc = $cod ORDER BY almarticulos.codigo";
						$resp = mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_row($resp)){
							$c=$c+1;	
							$i=$row[0];
							$unimed=$row[3];
							if($i==$_POST[codinar]){
								$_POST[codinar]=$row[1].$row[0];
								echo"<option value='".$row[1].$row[0]."' SELECTED>".$row[1].$row[0]." - ".$row[2]."</option>"; 
							}
							else{
								echo"<option value='".$row[1].$row[0]."'>".$row[1].$row[0]." - ".$row[2]."</option>"; 
							}
						}   
					echo "</select>
					<input name='unimed[".$pos."]' id='unimed[".$pos."]' type='hidden' value='".$unimed."' >
				</td>
				<td class='saludo1' style='width:6%'>Cantidad </td>
        		<td style='width:10%'>
					<input name='cantidad[".$pos."]' id='cantidad[".$pos."]' type='text' value='".number_format($cantidades[$pos],0,',','.')."' onKeyPress='javascript:return solonumeros(event)' onKeyUp='return tabular(event,this)' style='text-align:center; width:100%;'  >
				</td>
				<td class='saludo1' style='width:5%' style='font-weight: bold; '>Vr.Unit: </td>
				<td style='width:10%'>  
					<input name='valunit[".$pos."]' id='valunit[".$pos."]' type='text' value='".number_format($valunitp[$pos],0,',','.')."' onKeyPress='javascript:return solonumeros(event)' onKeyUp='return tabular(event,this)' style='text-align:right; width:100%'  > 
				</td> 
				<td class='saludo1' style='width:5%'>Ingresa: </td>
				<td style='width:10%'>  
					<input name='ingresa[".$pos."]' id='ingresa[".$pos."]' type='text' value='' onKeyPress='javascript:return solonumeros(event)' onKeyUp='return tabular(event,this)' style='text-align:right; width:100%' > 
				</td> 
				<td class='saludo1' style='width:5%'>Bodega:</td>
				<td colspan='1'>
					<select id='bodega[".$pos."]' name='bodega[".$pos."]' onchange='javascript:form2.nombod.value=this.options[this.selectedIndex].text;'> 
						<option value='-1'>Seleccione ....</option>";
						$sqlr="SELECT * FROM almbodegas WHERE estado='S' ORDER BY id_cc";
						$resp = mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_row($resp)){
							$i=$row[0];
							if($i==$_POST[bodega]){
								$_POST[bodega]=$row[0];
								echo"<option value='".$row[0]."' SELECTED>".$row[0]." - ".$row[1]."</option>"; 
							}
							else{
								echo"<option value='".$row[0]."'>".$row[0]." - ".$row[1]."</option>"; 
							}
			    		}   
		 			echo "</select>
				</td>
		  		<td class='saludo1' style='width:5%'>
					<input name='registrar' id='registrar' type='button' value='Registrar' style='width:100%; height:22px' onClick='agregardetalle(".$pos.")' > 
				</td>
			</tr>";
			$pos =$pos+1;
		}
		echo "</table>";
	}
	?>
	</div>
   	<div class="subpantallac" style="height:50%; overflow-x:hidden;">
	<table class="inicio">
		<tr>
    		<td class="titulos" colspan="8">Detalle Gesti&oacute;n Inventario - Entrada</td>
       	</tr>
		<tr>
        	<td class="titulos2">Codigo UNSPSC</td>
        	<td class="titulos2">Codigo Articulo</td>
            <td class="titulos2">Nombre Articulo</td>
            <td class="titulos2">Cantidad</td>
            <td class="titulos2">Bodega</td>
            <td class="titulos2">Valor Unitario</td>
            <td class="titulos2">Valor Total</td>
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
		 	unset($_POST[codartd][$posi]);
		 	unset($_POST[grupod][$posi]);
		 	unset($_POST[nomartd][$posi]);
		 	unset($_POST[codbodd][$posi]);
		 	unset($_POST[bodegad][$posi]);
		 	unset($_POST[unidadd][$posi]);
 		 	unset($_POST[cantidadd][$posi]);
		 	unset($_POST[valunitd][$posi]);
		 	unset($_POST[valtotd][$posi]);
		 	$_POST[codunsd]= array_values($_POST[codunsd]); 
		 	$_POST[codinard]= array_values($_POST[codinard]); 
		 	$_POST[nomartd]= array_values($_POST[nomartd]); 		 		 
		 	$_POST[codbodd]= array_values($_POST[codbodd]); 		 		 
		 	$_POST[bodegad]= array_values($_POST[bodegad]); 		 		 
		 	$_POST[unidadd]= array_values($_POST[unidadd]); 		 		 
		 	$_POST[cantidadd]= array_values($_POST[cantidadd]); 
		  	$_POST[valunitd]= array_values($_POST[valunitd]); 
		  	$_POST[valtotd]= array_values($_POST[valtotd]); 
			echo"<script>
				document.getElementById('contad').value=".count($_POST[codinard]).";
			</script>";
		}

		if($_POST[agregadet]=='1'){
			$cantmp=str_replace('.','',$_POST[cantart]);
			$unitmp=str_replace('.','',$_POST[uniart]);
			$numart=0; $posicion=-1;

			//VALIDA1: QUE NO SUPERE LAS CANTIDAD REGISTRADAS EN LA ENTRADA
			for ($x=0;$x < count($_POST[codinard]);$x++){
				if($_POST[unsart]==$_POST[codunsd][$x]){
					$numart+=$_POST[cantidadd][$x];
				}
			}
			$numart+=$_POST[cantart];

			//VALIDA2: QUE SUME CANTIDADES AL SACAR EL MISMO ARTICULO
			for ($x=0;$x < count($_POST[codinard]);$x++){
				if(($_POST[codart]==$_POST[codinard][$x])&&($_POST[codbod]==$_POST[codbodd][$x])){
					$posicion=$x;
					$totalart=$_POST[cantidadd][$x];
				}
			}
			$totalart+=$_POST[cantart];
			//FIN VALIDA2
			if($numart<=$_POST[numart]){
				if($posicion<=-1){
				 	$_POST[codunsd][]=$_POST[unsart];
		 			$_POST[codinard][]=$_POST[codart];
				 	$_POST[nomartd][]=$_POST[nomart];
				 	$_POST[codbodd][]=$_POST[codbod];
				 	$_POST[bodegad][]=$_POST[nombod];
				 	$_POST[unidadd][]=$_POST[umedida];
			  		$_POST[cantidadd][]=$_POST[cantart];
				 	$_POST[valunitd][]=$_POST[uniart];
		 			$_POST[valtotd][]=number_format($unitmp*$cantmp,0,',','.');
				}	
				else{
					$_POST[cantidadd][$posicion]=$totalart;
				}
			}
			else{
				echo"<script>
					despliegamodalm('visible','2','La Cantidad de Articulos a Ingresar Supera la Cantidad descrita en la Entrada');
				</script>";
			}
			echo"<script>
				document.getElementById('agregadet').value='0';
				document.getElementById('contad').value=".count($_POST[codinard]).";
			</script>";
		}
		$iter='saludo1a';
        $iter2='saludo2';
		for ($x=0;$x< count($_POST[codinard]);$x++){
	 		echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\">
				<td style='width:10%'>
					<input class='inpnovisibles' name='codunsd[]' value='".$_POST[codunsd][$x]."' type='text' style='width:100%' readonly>
				</td> 
				<td  style='width:10%'>
					<input class='inpnovisibles' name='codinard[]' value='".$_POST[codinard][$x]."' type='text'  style='width:100%' readonly>
				</td> 
				<td  style='width:30%'>
					<input class='inpnovisibles' name='nomartd[]' value='".$_POST[nomartd][$x]."' type='text' style='width:100%' readonly>
					<input class='inpnovisibles' name='unidadd[]' value='".$_POST[unidadd][$x]."' type='hidden' style='width:100%' readonly>
				</td>
				<td style='width:5%'>
					<input class='inpnovisibles' name='cantidadd[]' value='".$_POST[cantidadd][$x]."' type='text'  style='width:100%' readonly>
				</td>
				<td  style='width:25%'>
					<input class='inpnovisibles' name='bodegad[]' value='".$_POST[bodegad][$x]."' type='text' style='width:100%' readonly>
					<input class='inpnovisibles' name='codbodd[]' value='".$_POST[codbodd][$x]."' type='hidden' style='width:100%' readonly>
				</td>
				<td style='width:7%'>
					<input class='inpnovisibles' name='valunitd[]' value='".$_POST[valunitd][$x]."' type='text' style='width:100%; text-align:right;' readonly>
				</td>
				<td  style='width:8%'>
					<input class='inpnovisibles' name='valtotd[]' value='".$_POST[valtotd][$x]."' type='text' style='width:100%; text-align:right;' readonly>
				</td>
				<td style='width:5%'>
					<a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a>
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
<?php */
//FIN ENTRADA EN TRANSITO

					switch ($_POST[tipoentra])
					{
						case 6:	//INICIO OTRAS ENTRADAS POR COMPRAS
						{
							echo" 
								<td class='saludo1' style='width:6%;'>Documento</td>
								<input type='hidden' id='ntipoentra' name='ntipoentra' value='$_POST[ntipoentra]'/> 
								<input type='hidden' id='codiun' name='codiun'  value='$_POST[codiun]'/>
								<input type='hidden' id='valunitp' name='valunitp' value='$_POST[valunitp]'/>
								<input type='hidden' id='dcuentas' name='dcuentas' value='$_POST[dcuentas]'/>
								<input type='hidden' id='terceroegreso' name='terceroegreso' value='$_POST[terceroegreso]'/>
								<input type='hidden' id='vigenciaorden' name='vigenciaorden' value='$_POST[vigenciaorden]'/>
								<input type='hidden' id='vdisponiblerubros' name='vdisponiblerubros' value='$_POST[vdisponiblerubros]'/>
								<input type='hidden' id='actcheck' name='actcheck' value='$_POST[actcheck]'/>
								<td style='width:12%;'>
									<input type='text' name='docum' id='docum' value='$_POST[docum]' onKeyPress='javascript:return solonumeros(event)' onKeyUp='return tabular(event,this)' onBlur=\"guiabuscar1('1');\" style='width:75%'/>&nbsp;<img class='icobut' src='imagenes/find02.png'  title='Lista de Registros Presupuestales' onClick=\"despliegamodal2('visible','8');\"/></td>
								<td colspan='4'><input type='text' name='ndocum' id='ndocum' value='$_POST[ndocum]' style='width:100%;text-transform:uppercase' readonly/></td>
							</tr>
							<tr>
								<td class='saludo1' >Valor</td>
								<td><input type='text' name='valoregreso' id='valoregreso' value='$_POST[valoregreso]' readonly/></td>
								<td class='saludo1' >Centro Costo</td>
								<td>
									<select name='centrocosto' id='centrocosto'  onKeyUp='return tabular(event,this)' style='width:100%;' onChange='validar();'>
										<option value=''>Seleccione ...</option>";
							$sqlr="select *from centrocosto where estado='S' order by id_cc	";
							$res=mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($res)) 
							{
								if("$row[0]"==$_POST[centrocosto]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
								else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
							}	 	
							echo"
									</select>
								</td>
								<td class='saludo1' style='width:2cm;'>Bodega</td>
								<td> 
									<select name='bodega' id='bodega' onChange='validar();'> 
										<option value='-1'>Seleccione ....</option>";
										$sqlr="Select * from almbodegas where estado='S' ORDER BY id_cc";
										$resp = mysql_query($sqlr,$linkbd);
										while($row =mysql_fetch_row($resp)) 
										{
											if($row[0]==$_POST[bodega])
											{
												echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";
												$_POST[bodega]=$row[0];
												$_POST[nbode]=$row[1];
											}
										   else	{ echo "<option value='$row[0]'>$row[0] - $row[1]</option>";} 
										}   
							echo"
									</select>
								</td>
							</tr>
						</table>";?>
						<div class="tabs" style="height:53%">
                            <div class="tab">
                                <input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
                                <label for="tab-1">Art&iacute;culos</label>
                                <div class="content" style="overflow:hidden;">
                                    <div class="subpantallac" style="height:24%; overflow:hidden;">
                                        <table class="inicio ancho">
                                            <tr>
                                                <td class="saludo1" style="width:8%;">.: Art&iacute;culos</td>
                                                <td style="width:12%;">
                                                    <input type="text" name="articulo" id="articulo" value="<?php echo $_POST[articulo]?>" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="guiabuscar1('1');" style="width:80%"/>&nbsp;<img class="icobut" src="imagenes/find02.png"  title="Lista de Articulos" onClick="despliegamodal2('visible','10');"/></td>
                                                <td colspan="5">
                                                    <input type="text" name="narticulo" id="narticulo" value="<?php echo $_POST[narticulo]?>" style="width:100%;text-transform:uppercase" readonly/>
                                                </td>
                                                 <td class="saludo1" style="width:8%;">.: Cuenta Trans:</td>
                                                 <td style="width:20%;">
                                                 	<select id='cuentrans' name='cuentrans' style="width:90%;">
                                                    	<option value='-1'>Seleccione ....</option>
                                                    	<?php
                                                    	$sqlr="SELECT T1.cuenta,T1.codigo FROM conceptoscontables_det T1 WHERE T1.estado='S' AND T1.modulo='5' AND T1.tipo='AT' AND T1.cc='$_POST[centrocosto]' AND T1.fechainicial=(SELECT MAX(T2.fechainicial) FROM conceptoscontables_det T2 WHERE T2.codigo=T1.codigo AND T2.estado='S' AND T2.modulo='5' AND T2.tipo='AT' AND T2.cc='$_POST[centrocosto]' AND fechainicial<='$fechaf')";
														$resp = mysql_query($sqlr,$linkbd);
                                                        while ($row =mysql_fetch_row($resp))
                                                        {
															$sqlrnc="SELECT nombre FROM conceptoscontables WHERE modulo='5' AND tipo='AT' AND codigo='$row[1]'";
															$respnc = mysql_query($sqlrnc,$linkbd);
															$rownc =mysql_fetch_row($respnc);
															$codcuenta="$row[1]<->$row[0]";
                                                            if($codcuenta==$_POST[cuentrans])
															{echo"<option value='$codcuenta' SELECTED>$row[0] - $rownc[0]</option>";}
                                                            else {echo"<option value='$codcuenta'>$row[0] - $rownc[0]</option>";}
                                                        }   
														?>
                                                    </select>
                                                 </td>
                                          	</tr>
                                           	<tr>
                                                <td class="saludo1">.: Cantidad</td>
                                                <td><input type="text" name="numarti" id="numarti" onKeyPress="javascript:return solonumerossinpuntos(event)" value="<?php echo $_POST[numarti]?>" style="width:100%; text-align:right;" /> </td>
                                                <td class="saludo1" style="width:10%;">.: Valor Unitario</td>
                                                <td style="width:10%;"><input type="text" name="valoregre" id="valoregre" value="<?php echo $_POST[valoregre]?>" style="width:100%; text-align:right;" /></td>
                                                <td class="saludo1" width="5%" style="font-weight: bold">.: U.M</td>
                                                <td width="20%">
                                                	<?php
                                                        $sqlr="SELECT unidad FROM almarticulos_det WHERE articulo='$_POST[articulo]' ORDER BY principal DESC, id_det ASC LIMIT 1";
                                                        $resp = view($sqlr); 
                                                    ?>
													<input type="text" name="unimed" id="unimed" value="<?php echo  $resp[0][unidad]; ?>" style="width: 80%;" readonly/>
												</td>
												<td class="saludo1" width="8%" style="font-weight: bold">..: Bodega:</td>
												<td>
                                                    <input type="text" value="<?php echo $_POST[bodega].' - '.$_POST[nbode];?>" style="text-transform:uppercase" readonly/>
                                                </td>
                                                <td class="saludo1" width="10%">
                                                    <em name='regdona' id='regdona' type='button' class="botonflecha" onClick='agregardetotrascompra()' >Agregar</em>
                                                </td>
                                            </tr>
                                        </table>
                    </div>
                                    <div class="subpantallac" style="height:68%; overflow-x:hidden;">
                                    <table class="inicio ancho">
                                        <tr>
                                            <td class="titulos" colspan="9">Detalle Gesti&oacute;n Inventario - Entrada por Compra</td>
                                        </tr>
                                        <tr class="titulos2">
                                            <td>Cuenta</td>
                                            <td>C&oacute;digo Articulo</td>
                                            <td>Nombre Articulo</td>
                                            <td>Bodega</td>
                                            <td>Cantidad</td>
                                            <td>Valor Unitario</td>
                                            <td>Valor Total</td>
                                            <td>U.M</td>
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
                                            unset($_POST[cuentacon][$posi]);
											unset($_POST[cuentacre][$posi]);
                                            unset($_POST[tipcredit][$posi]);
                                            unset($_POST[dcc][$posi]);
                                            $_POST[codunsd]= array_values($_POST[codunsd]); 
                                            $_POST[codinard]= array_values($_POST[codinard]); 
                                            $_POST[nomartd]= array_values($_POST[nomartd]);
                                            $_POST[cantidadd]= array_values($_POST[cantidadd]); 
                                            $_POST[unidadd]= array_values($_POST[unidadd]); 
                                            $_POST[codbodd]= array_values($_POST[codbodd]); 
                                            $_POST[bodegad]= array_values($_POST[bodegad]); 
                                            $_POST[valortotal1]= array_values($_POST[valortotal1]);
                                            $_POST[cuentacon]= array_values($_POST[cuentacon]);
											$_POST[cuentacre]= array_values($_POST[cuentacre]);
                                            $_POST[tipcredit]= array_values($_POST[tipcredit]);
                                            $_POST[dcc] = array_values($_POST[dcc]);
                                            echo"<script> document.getElementById('contad').value=".count($_POST[codinard])."; </script>";
                                        }
                                        $valorto=0;
                                        if($_POST[agregadet]=='1')
                                        {
                                            $cantmp=str_replace('.','',$_POST[cantart]);
                                            $numart=0; $posicion=-1;
                                            //VALIDA1: SUMA ARTICULOS
                                            for ($x=0;$x < count($_POST[codinard]);$x++)
                                            {
                                                if(($_POST[codart]==$_POST[codinard][$x])&&($_POST[umedida]==$_POST[unidadd][$x])&&($_POST[codbod]==$_POST[codbodd][$x])&&($_POST[centrocosto]==$_POST[dcc][$x]))
                                                {
                                                    $posicion=$x;
                                                    $numart+=$_POST[cantidadd][$x];
                                                }
                                            }
                                            $numart+=$_POST[cantart];
                                            //FIN VALIDA1
                                            $valortot=$_POST[valoregre]*$numart;
                                            $valorto+=$valortot;
                                            if($valorto<=$_POST[vdisponiblerubros])
                                            {
												$codgrupo= substr($_POST[codart], 0, 4);
												$sqlrcum="SELECT T2.cuenta FROM almgrupoinv T1, conceptoscontables_det T2 WHERE  T1.codigo='$codgrupo' AND T1.concepent=T2.codigo AND T2.cc = '$_POST[centrocosto]' AND T2.modulo='5' AND T2.debito='S' AND T2.estado='S' AND T2.fechainicial=(SELECT MAX(T3.fechainicial) FROM conceptoscontables_det T3 WHERE  T3.codigo=T2.codigo AND T3.cc = '$_POST[centrocosto]' AND T3.modulo='5' AND T3.debito='S' AND T3.estado='S' AND T3.fechainicial<='$fechaf')";
												$respcum=mysql_query($sqlrcum,$linkbd);
												$rowcum=mysql_fetch_row($respcum);
												if($rowcum[0]!='' && $rowcum[0]!=null)
												{
													if($posicion<=-1)
													{
														$_POST[codunsd][]=$_POST[unsart];
														$_POST[codinard][]=$_POST[codart];
														$_POST[nomartd][]=$_POST[nomart];
														$_POST[cantidadd][]=$_POST[cantart];
														$_POST[valore][]=$_POST[valoregre];
														$_POST[unidadd][]=$_POST[umedida];
														$_POST[codbodd][]=$_POST[codbod];
														$_POST[bodegad][]=$_POST[nombod];
														$_POST[valortotal1][]=$valorto;
														$_POST[cuentacon][]=$rowcum[0];
														$cuentadeb=explode('<->',$_POST[cuentrans]);
														$_POST[cuentacre][]= $cuentadeb[1];
                                           				$_POST[tipcredit][]= $cuentadeb[0];
                                           				$_POST[dcc][] = $_POST[centrocosto];
													}	
													else{
														$_POST[cantidadd][$posicion]=$numart;
														$_POST[valortotal1][$posicion]=$valorto;
													}
													echo"<script>
														document.getElementById('agregadet').value='0';
														document.form2.articulo.value='';
														document.form2.narticulo.value='';
														document.form2.numarti.value='';
														document.form2.valoregre.value='';
														document.form2.cuentrans.value='-1';
														document.getElementById('contad').value=".count($_POST[codinard]).";
													</script>";
												}
												else{echo "<script> alert('El articulo no tiene cuenta debito parametrizada');</script>"; }
                                            }
                                            else {echo "<script> alert('El articulo excede el valor del egreso');</script>"; }
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
                                                <input type='hidden' name='valore[]' value='".$_POST[valore][$x]."'/>
                                                <input type='hidden' name='cuentacon[]' value='".$_POST[cuentacon][$x]."'/>
												<input type='hidden' name='cuentacre[]' value='".$_POST[cuentacre][$x]."'/>
												<input type='hidden' name='tipcredit[]' value='".$_POST[tipcredit][$x]."'/>
												<input type='hidden' name='dcc[]' value='".$_POST[dcc][$x]."'/>
                                                <td style='width:10%'>".$_POST[cuentacon][$x]."</td> 
                                                <td style='width:10%'>".$_POST[codinard][$x]."</td> 
                                                <td style=''>".$_POST[nomartd][$x]."</td>
                                                <td style='width:20%'>".$_POST[bodegad][$x]."</td>
                                                <td style='width:5%;text-align:right;'>".$_POST[cantidadd][$x]."</td>
                                                <td style='width:8%;text-align:right;'>$ ".number_format($_POST[valore][$x],0,',','.')."</td>
                                                <td style='width:10%;text-align:right;'>$ ".number_format($_POST[valortotal1][$x],0,',','.')."</td>
                                                <td style='width:6%;text-align:right;'>".$_POST[unidadd][$x]."</td>
                                                <td style='width:5%'><img src='imagenes/del.png' class='icobut' onclick='eliminar($x)'></td>
                                            </tr>";
                                            $aux=$iter;
                                            $iter=$iter2;
                                            $iter2=$aux;
                                         }	 
                                         $sumvalortotal=array_sum($_POST[valortotal1]);
                                         echo"
                                            <tr>
                                                <td colspan='6'></td>
                                                <td style='text-align:right;'>$".number_format($sumvalortotal,0,',','.')."</td>
                                                <td colspan='2'></td>
                                            </tr>";
                                         ?>
                                    </table>
                                </div>
                                </div>
                            </div>
                            <div class="tab">
                                <input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?>>
                                <label for="tab-2">Registro Presupuestal</label>
                                <div class="content" style="overflow-x:hidden;">
                                    <table class="inicio">
                                        <tr><td colspan="6" class="titulos">Detalles Registro Presupuestal</td></tr>                  
                                        <tr class="titulos2">
                                            <td style='width:15%'>Cuenta</td>
                                            <td>Nombre Cuenta</td>
                                            <td style='width:30%'>Recurso</td>
                                            <td style='width:10%'>Valor Asignado</td>
                                            <td style='width:10%'>Saldo Disponible</td>
                                            <td style='width:3%'>-</td>
                                        </tr>
                                        <?php
                                            if($_POST[docum]!='')
                                            {
                                                $sqlraux="SELECT SUM(valortotal) FROM almginventario  WHERE codmov='$_POST[docum]' AND 	tipomov='1' AND vigenciadoc='$vigusu' AND estado='S'";
                                                $resaux=mysql_query($sqlraux,$linkbd);
                                                $rowaux=mysql_fetch_row($resaux);
                                                $sumvalortotalaux=$rowaux[0]+$sumvalortotal;
                                                $_POST[totalc]=0;
                                                $x=0;
                                                $iter='saludo1a';
                                                $iter2='saludo2';
                                                $sqlropd="SELECT id_cdpdetalle,cuenta,valor FROM pptorp_detalle  WHERE consvigencia = '$_POST[docum]' AND tipo_mov='201' AND vigencia='$vigusu' ORDER BY id_cdpdetalle";
                                                $resopd=mysql_query($sqlropd,$linkbd);
                                                while($rowopd=mysql_fetch_row($resopd))
                                                {	
                                                    $descuenta=buscaNombreCuenta($rowopd[1],$_POST[vigenciaorden]); 
                                                    $desrecursos=buscafuenteppto($rowopd[1],$_POST[vigenciaorden]);	
                                                    $chk='';
                                                    $ch=esta_en_array($_POST[pagosselec], $rowopd[0]);
                                                    if($ch==1 || $_POST[actcheck]==1)
                                                    {
                                                        $chk="checked";
                                                        if(($rowopd[2]-$sumvalortotalaux)>0)
                                                        {$valdisponible=$rowopd[2]-$sumvalortotalaux;$sumvalortotalaux=0;}
                                                        else{$valdisponible=0;$sumvalortotalaux=$sumvalortotalaux-$rowopd[2];}
                                                    }	
                                                    else{$valdisponible=$rowopd[2];}
                                                    echo "
                                                    <input type='hidden' name='dcuentas[]' value='$rowopd[1]'/>
                                                    <input type='hidden' name='dncuentas[]' value='$descuenta'/>
                                                    <input type='hidden' name='drecursos[]' value='$desrecursos'/>
                                                    <input type='hidden' name='dvalores[]' value='$rowopd[2]'/>
                                                    <input type='hidden' name='dvdisponible[]' value='$valdisponible'/>
                                                    <input type='hidden' name='dopdcc[]' value='$rowopd[3]'/>
                                                    <input type='hidden' name='codigoid[]' value='$rowopd[0]'/>
                                                    <tr class='$iter'>
                                                        <td>$rowopd[1]</td>
                                                        <td>$descuenta</td>
                                                        <td>$desrecursos</td>
                                                        <td style='text-align:right;'>$ ".number_format($rowopd[2],0,',','.')."</td>
                                                        <td style='text-align:right;'>$ ".number_format($valdisponible,0,',','.')."</td>
                                                        <td><input type='checkbox' name='pagosselec[]' value='$rowopd[0]' $chk onClick='marcar(this,$x);' class='defaultcheckbox'>&nbsp;&nbsp;$dsb2</td>
                                                        
                                                    </tr>";
                                                    $_POST[totalc]=$_POST[totalc]+$rowopd[2];
                                                    $_POST[totalcf]=number_format($_POST[totalc],$_SESSION["ndecimales"],$_SESSION["spdecimal"],$_SESSION["spmillares"]);
                                                    $aux=$iter;
                                                    $iter=$iter2;
                                                    $iter2=$aux;
                                                    $x++;
                                                }
                                                echo"<script>document.form2.actcheck.value='0';</script>";
                                                
                                            }
                                        ?>
                                    </table>
                                </div>
                            </div>
                        </div>
<?php 
} break;

case 7:  //ENTRADA POR DONACION
	echo"
				<td class='saludo1' style='width:6%;'>Documento</td>
				<input type='hidden' id='ntipoentra' name='ntipoentra' value='$_POST[ntipoentra]'/> 
				<input type='hidden' id='codiun' name='codiun'  value='$_POST[codiun]'/>
				<input type='hidden' id='valunitp' name='valunitp' value='$_POST[valunitp]'/>
				<input type='hidden' id='ccselect' name='ccselect' value='$_POST[ccselect]'/>
				<input type='hidden' id='controlaDonacion' name='controlaDonacion' value='$_POST[controlaDonacion]' />
				<td style='width:12%;'>
					<input type='text' name='docum' id='docum' value='$_POST[docum]' onKeyPress='javascript:return solonumeros(event)' onKeyUp='return tabular(event,this)' onBlur=\"guiabuscar('4');\" style='width:80%'/>&nbsp;<img class='icobut' src='imagenes/find02.png'  title='Lista de actos por ajuste' onClick=\"despliegamodal2('visible','11');\"/></td>
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
				$sqlm="SELECT * FROM conceptoscontables WHERE tipo='ED' and modulo='5' ORDER BY codigo";
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
		<div class="subpantallac" style="height:18.5%; overflow-x:hidden;">
			<table class="inicio ancho" >
				<tr>
					<td class="titulos2" colspan="15">Art&iacute;culos</td>
				</tr>
				<?php

					if($_POST[controlaDonacion]==''){
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
					
						$sql = "SELECT codigo,descripcion,unumedida,cantidad,valor,saldo FROM almactoajusteentarticu WHERE idacto='$_POST[docum]' AND tipo_mov=107 AND estado='S' ";
						//echo $sql;
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
					<td class='saludo1' style='width:4%;'>Art&iacute;culo</td>
					<td style='width:7%;'>
						<input type='text' name='articulo[]' value='".$_POST[articulo][$x]."' onKeyPress='javascript:return solonumeros(event)' onKeyUp='return tabular(event,this)' onBlur='guiabuscar1(1);' style='width:95%' readonly/></td>
					<td style='width:10%;'>
						<input type='text' name='narticulo[]' value='".$_POST[narticulo][$x]."' style='width:100%;text-transform:uppercase' readonly/>
					</td>
					<td class='saludo1' style='width:3%;'>Saldo</td>
					<td style='width:3%;'><input type='text' name='saldo[]' value='".$_POST[saldo][$x]."' style='width:100%; text-align:right;' onKeyPress='javascript:return solonumeros(event)' readonly/> </td>
					<td class='saludo1' style='width:5%;'>Cantidad</td>
					<td style='width:3%;'><input type='text' name='numarti[]' value='".$_POST[numarti][$x]."' style='width:100%; text-align:right;' onKeyPress='javascript:return solonumerossinpuntos(event)'/> </td>
					<td class='saludo1' style='width:7%;'>Valor Unitario</td>
					<td style='width:5%;'><input type='text' name='valorunitario[]' value='".$_POST[valorunitario][$x]."' style='width:100%; text-align:right;' onKeyPress='javascript:return solonumeros(event)' readonly/></td>
					<td class='saludo1' width='5%' style='font-weight: bold'>.: Bodega</td>
					<td style='width:12%;'>
					<input type='hidden' name='nbodega[]' value='".$_POST[nbodega][$x]."' /> 
					<select name='bodega[]' onChange='document.form2.controlaDonacion.value=0; validar();' style='width:100%'> 
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

					<td class='saludo1' width='5%' style='font-weight: bold'>.: Centro Costo</td>
					<td width='10%'>
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
					<td width='17%'>
						<input type='text' name='unimed[]' value='".$_POST[unimed][$x]."' style='width: 43%;' readonly/>
						<em class='botonflecha' name='regajus' id='regajus' type='button' style='width:40%; height:22px' onClick='agregardetajuste($x)' >Agregar</em>
						
					</td>
				</tr>";
				
					}

				?>
				

			</table>
		</div>
	<div class="subpantallac" style="height:34%; overflow-x:hidden;">
		<table class="inicio ancho">
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
			<input type='hidden' name='posAjuste' id='posAjuste' value="<?php $_POST[posAjuste]?>"/>
			<input type='hidden' name='elimina' id='elimina'/>
			<input type='hidden' name='contad' id='contad' value='<?php $_POST[contad] ?>'/>
			<?php	
			//var_dump($_POST[posAjuste]);		 
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
				$pos = $_POST[posAjuste];
				//FIN VALIDA1
				$valorto=$_POST[valorunitario][$pos]*$numart;
				
				
				$codgrupo= substr($_POST[codart], 0, 4);
				
				$codarticulo= substr($_POST[codart], -5);
				
				$sqlrcumdon="SELECT T2.cuenta FROM almgrupoinv T1, conceptoscontables_det T2 WHERE  T1.codigo='$codgrupo' AND T1.concepent=T2.codigo AND T2.cc = '".$_POST[centrocosto][$pos]."' AND T2.modulo='5' AND T2.debito='S' AND T2.estado='S' AND T2.fechainicial=(SELECT MAX(T3.fechainicial) FROM conceptoscontables_det T3 WHERE  T3.codigo=T2.codigo AND T3.cc = '".$_POST[centrocosto][$pos]."' AND T3.modulo='5' AND T3.debito='S' AND T3.estado='S' AND T3.fechainicial<='$fechaf')";

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
					<td colspan='4'></td>
				</tr>";
			 ?>
		</table>
	</div>
<?php
  /* echo" 
								<td class='saludo1' style='width:6%;'>Documento</td>
								<input type='hidden' id='ntipoentra' name='ntipoentra' value='$_POST[ntipoentra]'/> 
								<input type='hidden' id='codiun' name='codiun'  value='$_POST[codiun]'/>
								<input type='hidden' id='valunitp' name='valunitp' value='$_POST[valunitp]'/>
								<input type='hidden' id='ccselect' name='ccselect' value='$_POST[ccselect]'/>
								<td style='width:12%;'>
									<input type='text' name='docum' id='docum' value='$_POST[docum]' onKeyPress='javascript:return solonumeros(event)' onKeyUp='return tabular(event,this)' onBlur=\"guiabuscar('7');\" style='width:80%'/>&nbsp;<img class='icobut' src='imagenes/find02.png'  title='Lista de Registros Presupuestales' onClick=\"despliegamodal2('visible','11');\"/></td>
								<td colspan='2' style='width:20%'><input type='text' name='ndocum' id='ndocum' value='$_POST[ndocum]' style='width:100%;text-transform:uppercase' readonly/></td>
								<td class='saludo1' >Centro Costo</td>
								<td>
									<select name='centrocosto' id='centrocosto'  onKeyUp='return tabular(event,this)' style='width:73%;' onChange='validar();'>
										<option value=''>Seleccione ...</option>";
							$sqlr="select *from centrocosto where estado='S' and id_cc='$_POST[ccselect]' order by id_cc	";
							$_POST[centrocosto] = $_POST[ccselect];
							$res=mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($res)) 
							{
								if("$row[0]"==$_POST[centrocosto]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
								else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
							}	 	
							echo"
									</select>
								</td>
							</tr>
							<tr>
								<td class='saludo1' >Valor Autorizado</td>
								<td>
								<input type='hidden' name='valorh' id='valorh' value='$_POST[valorh]'/>
								<input type='text' name='valor' id='valor' value='$_POST[valor]' style='width:100%' readonly/>
								</td>
								<td class='saludo1' style='width:6%;'>Donante</td>
								<td>
									<input type='text' name='tercero' id='tercero' value='$_POST[tercero]' onKeyPress='javascript:return solonumeros(event)' onKeyUp='return tabular(event,this)' onBlur=\"guiabuscar1('1');\" style='width:100%'/ readonly></td>
								<td colspan='2' style='width:20%'><input type='text' name='ntercero' id='ntercero' value='$_POST[ntercero]' style='width:100%;text-transform:uppercase' readonly/></td>
								
								<td class='saludo1' style='width:2cm;'>Bodega</td>
								<td> 
									<input type='hidden' name='nbodega' id='nbodega' value='$_POST[nbodega]' /> 
									<select name='bodega' id='bodega' onChange='validar();' style='width:73%'> 
										<option value='-1'>Seleccione ....</option>";
										$sqlr="Select * from almbodegas where estado='S' ORDER BY id_cc";
										$resp = mysql_query($sqlr,$linkbd);
										while($row =mysql_fetch_row($resp)) 
										{
											if($row[0]==$_POST[bodega])
											{
												echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";
												$_POST[bodega]=$row[0];
												$_POST[nbodega]=$row[1];
											}
										   else	{ echo "<option value='$row[0]'>$row[0] - $row[1]</option>";} 
										}   
							echo"
									</select>
								</td>
							</tr>
						</table>";?>
						<div class="subpantallac" style="height:18.5%; overflow:hidden;">
							<table class="inicio">
								<tr>
									<td class="titulos2" colspan="10">Art&iacute;culos</td>
								</tr>
								<tr>
									<td class="saludo1" style="width:8%;">.: Art&iacute;culo</td>
									<td style="width:12%;">
										<input type="text" name="articulo" id="articulo" value="<?php echo $_POST[articulo]?>" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="guiabuscar1('1');" style="width:80%"/>&nbsp;<img class="icobut" src="imagenes/find02.png"  title="Lista de Articulos" onClick="despliegamodal2('visible','10');"/></td>
									<td>
										<input type="text" name="narticulo" id="narticulo" value="<?php echo $_POST[narticulo]?>" style="width:100%;text-transform:uppercase" readonly/>
									</td>
									<td class="saludo1" style="width:8%;">.: Cantidad</td>
									<td><input type="text" name="numarti" id="numarti" value="<?php echo $_POST[numarti]?>" style="width:100%; text-align:right;" onKeyPress="javascript:return solonumeros(event)"/> </td>
									<td class="saludo1" style="width:10%;">.: Valor Unitario</td>
									<td style="width:8%;"><input type="text" name="valorunitario" id="valorunitario" value="<?php echo $_POST[valorunitario]?>" style="width:100%; text-align:right;" onKeyPress="javascript:return solonumeros(event)"/></td>
									<td class="saludo1" width="8%" style="font-weight: bold">.: U.M</td>
									<td width="25%">
										<?php
											$sqlr="SELECT unidad FROM almarticulos_det WHERE articulo='$_POST[articulo]' ORDER BY principal DESC, id_det ASC LIMIT 1";
											$resp = view($sqlr); 
										?>
										<input type="text" name="unimed" id="unimed" value="<?php echo  $resp[0][unidad]; ?>" style="width: 43%;" readonly/>
										<input name='regdona' id='regdona' type='button' value='Agregar' style='width:40%; height:22px' onClick='agregardetdonacionmov()' > 
									</td>
								</tr>
			
							</table>
						</div>
						<div class="subpantallac" style="height:82%; overflow-x:hidden;">
							<table class="inicio">
								<tr>
									<td class="titulos" colspan="8">Detalle Gesti&oacute;n Inventario - Entrada por Donacion</td>
								</tr>
								<tr class="titulos2">
									<td>C&oacute;digo Articulo</td>
									<td>Nombre Articulo</td>
									<td>Bodega</td>
									<td>Cantidad</td>
									<td>Valor Unitario</td>
									<td>Valor Total</td>
									<td>U.M</td>
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
									$_POST[dcc] = array_values($_POST[dcc]);
									$_POST[cuentacon] = array_values($_POST[cuentacon]);
									
									echo"<script> document.getElementById('contad').value=".count($_POST[codinard])."; </script>";
								}
								$valorto=0;
								if($_POST[agregadet]=='1')
								{
									$sql = "";
									$cantmp=str_replace('.','',$_POST[cantart]);
									$numart=0; $posicion=-1;
									//VALIDA1: SUMA ARTICULOS
									for ($x=0;$x < count($_POST[codinard]);$x++)
									{
										if(($_POST[codart]==$_POST[codinard][$x])&&($_POST[umedida]==$_POST[unidadd][$x])&&($_POST[codbod]==$_POST[codbodd][$x])&&($_POST[centrocosto]==$_POST[dcc][$x]))
										{
											$posicion=$x;
											$numart+=$_POST[cantidadd][$x];
										}
									}
									$numart+=$_POST[cantart];
									//FIN VALIDA1
									$valorto=$_POST[valorunitario]*$numart;
									
									$codgrupo= substr($_POST[codart], 0, 4);
									
									$codarticulo= substr($_POST[codart], -5);
									
									$sqlrcumdon="SELECT T2.cuenta FROM almgrupoinv T1, conceptoscontables_det T2 WHERE  T1.codigo='$codgrupo' AND T1.concepent=T2.codigo AND T2.cc = '$_POST[centrocosto]' AND T2.modulo='5' AND T2.debito='S' AND T2.estado='S' AND T2.fechainicial=(SELECT MAX(T3.fechainicial) FROM conceptoscontables_det T3 WHERE  T3.codigo=T2.codigo AND T3.cc = '$_POST[centrocosto]' AND T3.modulo='5' AND T3.debito='S' AND T3.estado='S' AND T3.fechainicial<='$fechaf')";
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
										$_POST[valore][]=$_POST[valorunitario];
										$_POST[unidadd][]=$_POST[umedida];
										$_POST[codbodd][]=$_POST[codbod];
										$_POST[bodegad][]=$_POST[nbodega];
										$_POST[valortotal1][]=$valorto;
										$_POST[dcc][] = $_POST[centrocosto];
										$_POST[cuentacon][] = $cuentadeb[0];
									}	
									else{
										$_POST[cantidadd][$posicion]=$numart;
										$_POST[valortotal1][$posicion]=$valorto;
									}
									echo"<script>
										document.getElementById('agregadet').value='0';
										document.form2.articulo.value='';
										document.form2.narticulo.value='';
										document.form2.numarti.value='';
										document.form2.valorunitario.value='';
										document.getElementById('contad').value=".count($_POST[codinard]).";
									</script>";

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
										<input type='hidden' name='valore[]' value='".$_POST[valore][$x]."'/>
										<input type='hidden' name='dcc[]' value='".$_POST[dcc][$x]."'/>
										<input type='hidden' name='cuentacon[]' value='".$_POST[cuentacon][$x]."'/>
										<td style='width:10%'>".$_POST[codinard][$x]."</td> 
										<td style=''>".$_POST[nomartd][$x]."</td>
										<td style='width:20%'>".$_POST[bodegad][$x]."</td>
										<td style='width:5%;text-align:right;'>".$_POST[cantidadd][$x]."</td>
										<td style='width:8%;text-align:right;'>$ ".number_format($_POST[valore][$x],0,',','.')."</td>
										<td style='width:10%;text-align:right;'>$ ".number_format($_POST[valortotal1][$x],0,',','.')."</td>
										<td style='width:6%;text-align:right;'>".$_POST[unidadd][$x]."</td>
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
<?php*/
break;
//FIN ENTRADA MANUAL POR COMPRA
					}
}  
//FIN TIPO MOV 1
?> 

<!--REVERSIONES -->
<?php 
if($_POST[tipomov]>2)
{
?> 
	<table class="inicio ancho">
		<tr>
    		<td colspan="5" class="titulos2">Gesti&oacute;n Inventario - Reversiones</td>
       	</tr>
		<tr>
			<td class="saludo1" width="6%">Tipo Reversi&oacute;n</td>
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
				<input type="text" name="docum" id="docum" value="<?php echo $_POST[docum]?>" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="guiabuscar('4');" style="width:80%"/>&nbsp;<img class="icobut" src="imagenes/find02.png" title="Lista de Documentos" onclick="despliegamodal2('visible','4');resetear();">
				</td>
					<td width="50%">
						<input type="text" name="ndocum" id="ndocum" value="<?php echo $_POST[ndocum]?>" style="width:100%;text-transform:uppercase" readonly/>
					</td>
				</tr>
			</table>
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
				<input type="text" name="docum" id="docum" value="<?php echo $_POST[docum]?>" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="guiabuscar('4');" style="width:80%"/>&nbsp;<img class="icobut" src="imagenes/find02.png" title="Lista de Documentos" onclick="despliegamodal2('visible','13');resetear();">
				</td>
					<td width="50%">
						<input type="text" name="ndocum" id="ndocum" value="<?php echo $_POST[ndocum]?>" style="width:100%;text-transform:uppercase" readonly/>
					</td>
				</tr>
			</table>
			     
   	<div class="subpantalla"  style="height:50%; width:99.8%; overflow:hidden;display:flex">
	
		<div class="subpantallac" style="height:100%;width:50%; overflow-x:hidden">
			
			<table class="inicio ancho">
				<tr>
					<td class="titulos" colspan="7">Reversion traslado entre bodegas</td>
				</tr>
				<tr>
					<td class="titulos2" style="width: 13%">Código Articulo</td>
					<td class="titulos2" style="width: 17%">Nombre Articulo</td>
					<td class="titulos2" style="width: 15%">Valor Unitario</td>
					<td class="titulos2" style="width: 17%">Bodega Actual</td>
					<td class="titulos2" style="width: 17%">Bodega a Trasladar</td>
					<td class="titulos2" style="width: 10%">Cantidad a Reversar</td>
					<input type='hidden' name='elimina' id='elimina'>
					<input name='contad' id='contad' value='<?php $_POST[contad] ?>' type='hidden' style='width:100%' readonly>
				</tr>
				<?php			 
				
				if(!empty($_POST[docum])){
					
					$sql="SELECT coddocumento,coddetalleentrada,coddetallesalida,codarticulo,unspsc FROM almtraslados WHERE coddocumento=$_POST[docum] AND tipotraslado='BODEGA' AND estado='S' ";
					$resp=mysql_query($sql,$linkbd);
					while($row = mysql_fetch_row($resp)){
						//Detalle entrada
						$sqlr="SELECT cantidad_entrada,valorunit,valortotal,unidad,bodega,cc FROM almginventario_det WHERE id_det=".$row[1]." AND codigo=".$row[0]." AND tipomov=1 ";
						$respent=mysql_query($sqlr,$linkbd);
						//Detalle salida
						$sqlr="SELECT cantidad_salida,valorunit,valortotal,unidad,bodega FROM almginventario_det WHERE id_det=".$row[2]." AND codigo=".$row[0]." AND tipomov=1 ";
						$respsal=mysql_query($sqlr,$linkbd);
						
						$grupo = substr($row[3],0,4);
						$codigo = substr($row[3],4);
						$sqln = "SELECT nombre FROM almarticulos WHERE grupoinven='$grupo' AND codigo='$codigo' AND estado='S'";
						$resn = mysql_query($sqln,$linkbd);
						$rown = mysql_fetch_row($resn);
							
						$_POST[codunsd][]=$row[4];
						$_POST[codinard][]=$row[3];
						$_POST[nomartd][]=$rown[0];
						$_POST[cantidadd][]=$respsal[0];
						$_POST[unidadd][]=$respsal[3];
						$_POST[codbodd][]=$respsal[4];
						
						$sqlb1="SELECT nombre FROM almbodegas where estado='S' AND id_cc=".$respsal[4]." ";
						$resb1 = mysql_query($sqlb1,$linkbd);
						$rowb1 = mysql_fetch_row($resb1);
						
						$_POST[bodegad][]=$rowb1[0];
						$_POST[codbodd2][]=$respent[4];
						
						$sqlb2="SELECT nombre FROM almbodegas where estado='S' AND id_cc=".$respent[4]." ";
						$resb2 = mysql_query($sqlb2,$linkbd);
						$rowb2 = mysql_fetch_row($resb2);
						
						$_POST[bodegad2][]=$rowb2[0];
						$_POST[valore][]=$respent[1];
						$_POST[valortotal1][]=$respent[2];
						$_POST[dccbod][]=$respent[5];
					}
					
					
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
						<td class="titulos" colspan="7">Reversion traslado entre centros de costo</td>
					</tr>
					<tr>
						<td class="titulos2" style="width: 13%">Código Articulo</td>
						<td class="titulos2" style="width: 17%">Nombre Articulo</td>
						<td class="titulos2" style="width: 15%">Valor Unitario</td>
						<td class="titulos2" style="width: 17%">C.C Actual</td>
						<td class="titulos2" style="width: 17%">C.C a Trasladar</td>
						<td class="titulos2" style="width: 10%">Cantidad a Reversar</td>
						<input type='hidden' name='eliminacc' id='eliminacc'>
						<input name='contadcc' id='contadcc' value='<?php $_POST[contadcc] ?>' type='hidden' style='width:100%' readonly>
					</tr>
					<?php			 
					 if(!empty($_POST[docum])){
						
						$sql="SELECT coddocumento,coddetalleentrada,coddetallesalida,codarticulo,unspsc FROM almtraslados WHERE coddocumento=$_POST[docum] AND tipotraslado='CENTROCOSTO' AND estado='S' ";
						$resp=mysql_query($sql,$linkbd);
						while($row = mysql_fetch_row($resp)){
							//Detalle entrada
							$sqlr="SELECT cantidad_entrada,valorunit,valortotal,unidad,cc,bodega FROM almginventario_det WHERE id_det=".$row[1]." AND codigo=".$row[0]." AND tipomov=1 ";
							$respent=mysql_query($sqlr,$linkbd);
							//Detalle salida
							$sqlr="SELECT cantidad_salida,valorunit,valortotal,unidad,cc FROM almginventario_det WHERE id_det=".$row[2]." AND codigo=".$row[0]." AND tipomov=1 ";
							$respsal=mysql_query($sqlr,$linkbd);
							
							$grupo = substr($row[3],0,4);
							$codigo = substr($row[3],4);
							$sqln = "SELECT nombre FROM almarticulos WHERE grupoinven='$grupo' AND codigo='$codigo' AND estado='S'";
							$resn = mysql_query($sqln,$linkbd);
							$rown = mysql_fetch_row($resn);
								
							$_POST[codunsd2][]=$row[4];
							$_POST[codinard2][]=$row[3];
							$_POST[nomartd2][]=$rown[0];
							$_POST[cantidadd2][]=$respsal[0];
							$_POST[unidadd2][]=$respsal[3];
							$_POST[codcc][]=$respsal[4];
							
							$sqlb2="select nombre from centrocosto where estado='S' AND id_cc=".$respsal[4]." ";
							$resb1 = mysql_query($sqlb1,$linkbd);
							$rowb1 = mysql_fetch_row($resb1);
							
							$_POST[ccd][]=$rowb1[0];
							$_POST[codcc2][]=$respent[4];
							
							$sqlb2="select nombre from centrocosto where estado='S' AND id_cc=".$respent[4]." ";
							$resb2 = mysql_query($sqlb2,$linkbd);
							$rowb2 = mysql_fetch_row($resb2);
							
							$_POST[ccd2][]=$rowb2[0];
							$_POST[valore2][]=$respent[1];
							$_POST[valortotal2][]=$respent[2];
							$_POST[codboddcc][]=$respent[5];
							
							//Se obtiene la cuenta contable que acredita
							$sqlrpat="SELECT cuentapatrimonio FROM almparametros";
							$respat = mysql_query($sqlrpat,$linkbd);
							$cuentapat=mysql_fetch_row($respat);
							
							//Se obtiene la cuenta contable que debita
							$sqlrcumdon="SELECT T2.cuenta FROM almgrupoinv T1, conceptoscontables_det T2 WHERE  T1.codigo='$grupo' AND T1.concepent=T2.codigo AND T2.cc = '$_POST[centrocosto]' AND T2.modulo='5' AND T2.debito='S' AND T2.estado='S' AND T2.fechainicial=(SELECT MAX(T3.fechainicial) FROM conceptoscontables_det T3 WHERE  T3.codigo=T2.codigo AND T3.cc = '$_POST[centrocosto]' AND T3.modulo='5' AND T3.debito='S' AND T3.estado='S' AND T3.fechainicial<='$fechaf')";
							$rescumdon = mysql_query($sqlrcumdon,$linkbd);
							$cuentart = mysql_fetch_row($rescumdon);
						}
						
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
						</tr>";
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
						$total2+=($_POST[cantidadd2][$x]);
						$totalcc+=($_POST[valortotal2][$x]);
					 }
						$_POST[saldocc] = $_POST[saldocc] - $saldocc;
						echo "<script> document.getElementById('saldocc').value = parseInt(document.getElementById('saldocc').value)-$saldocc;</script>";
						echo "<tr class='saludo2'><td colspan='5'></td><td>".$total2."</td>";
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
			<div class="subpantallac" style="height:50%; overflow-x:hidden;">
        
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
    	        <td class="titulos2">Cantidad U.M</td>
    	        <td class="titulos2">Bodega</td>
            	<input type='hidden' name='elimina' id='elimina'>
            	<input type='hidden' name='reset' id='reset'>
				<input name='contad' id='contad' value='<?php $_POST[contad] ?>' type='hidden' style='width:100%' readonly>
    	  	</tr>
			<?php	
		 
			if(!empty($_POST[docum]))
			{
				$sql = "SELECT 1 FROM almginventario_revtotal WHERE coddocumento=$_POST[docum] AND movimiento=2";
				$res=mysql_query($sql,$linkd);
				$cantreg=mysql_num_rows($res);
				if($cantreg==0){
					$sql = "SELECT unspsc,codart,cantidad_entrada,unidad,bodega,cc FROM almginventario_det WHERE codigo='$_POST[docum]' WHERE tipomov=1";
					$res=mysql_query($sql,$linkbd);
					while($row = mysql_fetch_row($res)){
						//Obteniendo el nombre del articulo
						$grupo = substr($row[1],0,4);
						$codigo = substr($row[1],4);
						$sqln = "SELECT nombre FROM almarticulos WHERE grupoinven='$grupo' AND codigo='$codigo' AND estado='S'";
						$resn = mysql_query($sqln,$linkbd);
						$rown = mysql_fetch_row($resn);
						//Se obtiene la cuenta contable asociada al articulo
						$sqlrcumdon="SELECT T2.cuenta FROM almgrupoinv T1, conceptoscontables_det T2 WHERE  T1.codigo='$grupo' AND T1.concepent=T2.codigo AND T2.cc = '".$row[5]."' AND T2.modulo='5' AND T2.debito='S' AND T2.estado='S' AND T2.fechainicial=(SELECT MAX(T3.fechainicial) FROM conceptoscontables_det T3 WHERE  T3.codigo=T2.codigo AND T3.cc = '".$row[5]."' AND T3.modulo='5' AND T3.debito='S' AND T3.estado='S' AND T3.fechainicial<='$fechaf')";
						$rescumdon = mysql_query($sqlrcumdon,$linkbd);
						$cuentadeb = mysql_fetch_row($rescumdon);
				
						//Obteniendo el nombre de la bodega
						$sqlb2="SELECT nombre FROM almbodegas where estado='S' AND id_cc=".$row[4]." ";
						$resb2 = mysql_query($sqlb2,$linkbd);
						$rowb2 = mysql_fetch_row($resb2);
						
						//Se consulta el tercero
						$sqltercero = "SELECT doctercero FROM almactoajusteent WHERE id=$codinv";
						$restercero = mysql_query($sqltercero,$linkbd);
						$rowtercero =  mysql_fetch_row($restercero);
						
						$_POST[codunsd][] = $row[0];
						$_POST[codinard][] = $row[1];
						$_POST[nomartd][] = $rown[0];
						$_POST[revertid][] = $row[2];
						$_POST[cantidadd][] = $row[2];
						$_POST[unidadd][] = $row[3];
						$_POST[codbodd][] = $row[4];
						$_POST[bodegad][] = $rowb2[0];
						$_POST[cuentacon][] = $cuentadeb[0];
						$_POST[dcc][] = $row[5];
						$_POST[dtercero][] = $rowtercero[0];
						
					}
				}
				
			}
			
			$iter='saludo1a';
	        $iter2='saludo2';
			for ($x=0;$x< count($_POST[codinard]);$x++)
			{
				echo "<input name='cuentacon[]' value='".$_POST[cuentacon][$x]."' type='hidden'>";
				echo "<input name='dcc[]' value='".$_POST[dcc][$x]."' type='hidden'>";
				echo "<input name='dtercero[]' value='".$_POST[dtercero][$x]."' type='hidden'>";
				
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
					</td>
				</tr>";
				$aux=$iter;
				$iter=$iter2;
				$iter2=$aux;
			 }	 
			 ?>
		</table>
	</div>
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
				case 7:
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
				<td style="width: 60%"></td>
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

<?php 

//********** GUARDAR EL COMPROBANTE ***********
if($_POST[oculto]=="2")
{
	echo'<script>document.form2.oculto.value=0</script>';
	//ID tabla
	$codinv=$_POST[numero];
	//rutina de guardado cabecera
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	$sq="select max(bodega2) from almginventario ";
	$rs=mysql_query($sq,$linkbd);
	$rw = mysql_fetch_row($rs);
	$numacta=$rw[0]+1;
	$sqlrTipoComp = "SELECT tipo_comp FROM almtipomov WHERE tipom='$_POST[tipomov]' AND codigo='$_POST[tipoentra]'";
	$resTipoComp = mysql_query($sqlrTipoComp,$linkbd);
	$rowTipoComp = mysql_fetch_row($resTipoComp);
	if($rowTipoComp[0]!='' && $rowTipoComp[0]!=0)
	{
		$sqlr="insert into almginventario (consec,fecha,tipomov,tiporeg,codmov,valortotal,usuario,estado,nombre,bodega1,bodega2,vigenciadoc,cc) values ('$codinv','$fechaf','$_POST[tipomov]','$_POST[tipoentra]','$_POST[docum]','$sumvalortotal','$_SESSION[cedulausu]','S','$_POST[nombre]', '$_POST[codbod]', '$numacta','$vigusu','$_POST[centrocosto]')";
		if(!mysql_query($sqlr,$linkbd)){echo"<script>despliegamodalm('visible','2','Error no se almaceno');</script>";}
		else
		{
			if($_POST[tipomov]==1){
				$tercero = view("SELECT nit FROM configbasica LIMIT 1");
				$tercero = explode('-', $tercero[0][nit]);
				switch ($_POST[tipoentra]){
					
					case 1:
					$solicitud=$_POST[docum];
					$sql="SELECT pptorp.tercero FROM contrasoladquisiciones,pptocdp,pptorp WHERE contrasoladquisiciones.codsolicitud='$solicitud' AND  contrasoladquisiciones.codcdp=pptocdp.consvigencia AND pptocdp.tipo_mov=201 AND pptocdp.vigencia='$vigusu' AND pptorp.idcdp = pptocdp.consvigencia AND pptorp.vigencia ='$vigusu' AND pptorp.tipo_mov=201  ";
					$res=mysql_query($sql,$linkbd);
					$row = mysql_fetch_row($res);
					if(!is_null($row[0]) && !empty($row[0]))
						$tercero=$row[0];
					else
						$tercero=0;
				
						$sql="SELECT codigo,tipocuenta,cuenta,cc FROM conceptoscontables_det WHERE conceptoscontables_det.tipo='AE' AND conceptoscontables_det.modulo=5 and conceptoscontables_det.cuenta!='' AND  conceptoscontables_det.estado = 'S' AND conceptoscontables_det.fechainicial=(SELECT MAX(T3.fechainicial) FROM conceptoscontables_det T3 WHERE  T3.codigo=conceptoscontables_det.codigo AND T3.cc = '$_POST[centrocosto]' AND T3.modulo='5' AND T3.credito='S' AND T3.estado='S' AND T3.fechainicial<='$fechaf') LIMIT 1";
						$res = mysql_query($sql,$linkbd);
						$conceptoscont = mysql_fetch_row($res);
						$total = 0;
						$totalcab=$varcontable1=$varcontable2=$varcontable3=$varinventario1=0;
						for($x=0;$x<count($_POST[codinard]);$x++)
						{
							$sqlr="INSERT INTO almginventario_det (codigo,unspsc,codart,solicitud,cantidad_entrada,valorunit,valortotal,unidad,tipomov,tiporeg, bodega,codcuentacre,cc) VALUES ('$codinv', '".$_POST[codunsd][$x]."','".$_POST[codinard][$x]."','$_POST[docum]','".$_POST[cantidadd][$x]."','".$_POST[valore][$x]."','".$_POST[valortotal1][$x]."','".$_POST[unidadd][$x]."', '$_POST[tipomov]','$_POST[tipoentra]','".$_POST[codbodd][$x]."','".$conceptoscont[0]."','".$_POST[dcc][$x]."')";
							$res=mysql_query($sqlr,$linkbd) or die($varinventario1=1);

							//DEBITO
							if($_POST[cuentacon][$x]!=""){
								$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado, vigencia,tipo_comp,numerotipo,numacti,cantarticulo) VALUES ('$rowTipoComp[0] $codinv','".$_POST[cuentacon][$x]."','".$tercero."','".$_POST[dcc][$x]."','$_POST[nombre]','','".$_POST[valtotd][$x]."','0','1','$vigusu','$rowTipoComp[0]','$codinv','".$_POST[codinard][$x]."','".$_POST[cantidadd][$x]."')";
								mysql_query($sqlr,$linkbd) or die($varcontable1=1);
							}else{
								$varcontable1=1;
							}
							
							//CREDITO
							if($conceptoscont[2]!=""){
								$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado, vigencia,tipo_comp,numerotipo,numacti,cantarticulo) VALUES ('$rowTipoComp[0] $codinv','".$conceptoscont[2]."','".$tercero."','".$_POST[dcc][$x]."','$_POST[nombre]','','0','".$_POST[valtotd][$x]."','1','$vigusu','$rowTipoComp[0]','$codinv','".$_POST[codinard][$x]."','".$_POST[cantidadd][$x]."')";
								mysql_query($sqlr,$linkbd) or die($varcontable2=1);
							}else{
								$varcontable2=1;
							}
							
							$total += (double)($_POST[valtotd][$x]);
						}

						$sqlr="INSERT INTO comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia, estado) VALUES ($codinv,$rowTipoComp[0],'$fechaf','$_POST[nombre]',0,$total,$total,0,'1')";
						mysql_query($sqlr,$linkbd) or die($varcontable3=1);
						
						if($varcontable1!=0 || $varcontable2!=0 || $varcontable3!=0 ||$varinventario1!=0)
						{
						echo "<script>despliegamodalm('visible','2','Error no se almaceno');</script>";
						}
					break;
					case 3: //***ENTRADA POR TRASLADOS
						for($x=0;$x<$_POST[contad];$x++)
						{
							//Salida de bodega
							$sqlr="INSERT INTO almginventario_det (codigo,unspsc,codart,solicitud,cantidad_salida,valorunit,valortotal,unidad,tipomov,tiporeg, bodega,codcuentacre,cc) VALUES ('$codinv', '".$_POST[codunsd][$x]."','".$_POST[codinard][$x]."','$_POST[docum]','".$_POST[cantidadd][$x]."','".$_POST[valore][$x]."','".$_POST[valortotal1][$x]."','".$_POST[unidadd][$x]."', '$_POST[tipomov]','$_POST[tipoentra]','".$_POST[codbodd][$x]."','".$_POST[tipcredit][$x]."','".$_POST[dccbod][$x]."')";
							$res=mysql_query($sqlr,$linkbd) or die($varinventario1=1);
							$codsalida=mysql_insert_id();
							//Entrada a bodega
							$sqlr="INSERT INTO almginventario_det (codigo,unspsc,codart,solicitud,cantidad_entrada,valorunit,valortotal,unidad,tipomov,tiporeg, bodega,codcuentacre,cc) VALUES ('$codinv', '".$_POST[codunsd][$x]."','".$_POST[codinard][$x]."','$_POST[docum]','".$_POST[cantidadd][$x]."','".$_POST[valore][$x]."','".$_POST[valortotal1][$x]."','".$_POST[unidadd][$x]."', '$_POST[tipomov]','$_POST[tipoentra]','".$_POST[codbodd2][$x]."','".$_POST[tipcredit][$x]."','".$_POST[dccbod][$x]."')";
							$res=mysql_query($sqlr,$linkbd) or die($varinventario2=1);
							$codentrada=mysql_insert_id();
							//Registrar traslado
							$sqlr="INSERT INTO almtraslados(coddocumento,coddetalleentrada,coddetallesalida,codarticulo,unspsc,tipotraslado,estado) VALUES ($codinv,$codentrada,$codsalida,'".$_POST[codinard][$x]."','".$_POST[codunsd][$x]."','BODEGA','S')";
							mysql_query($sqlr,$linkbd);
						}
						
						for($x=0;$x<$_POST[contadcc];$x++)
						{
							//Salida de CC
							$sqlr="INSERT INTO almginventario_det (codigo,unspsc,codart,solicitud,cantidad_salida,valorunit,valortotal,unidad,tipomov,tiporeg, bodega,codcuentacre,cc) VALUES ('$codinv', '".$_POST[codunsd2][$x]."','".$_POST[codinard2][$x]."','$_POST[docum]','".$_POST[cantidadd2][$x]."','".$_POST[valore2][$x]."','".$_POST[valortotal2][$x]."','".$_POST[unidadd2][$x]."', '$_POST[tipomov]','$_POST[tipoentra]','".$_POST[codboddcc][$x]."','".$_POST[tipcredit][$x]."','".$_POST[codcc][$x]."')";
							$res=mysql_query($sqlr,$linkbd) or die($varinventario3=1);
							$codsalida=mysql_insert_id();
							//Entrada de CC
							$sqlr="INSERT INTO almginventario_det (codigo,unspsc,codart,solicitud,cantidad_entrada,valorunit,valortotal,unidad,tipomov,tiporeg, bodega,codcuentacre,cc) VALUES ('$codinv', '".$_POST[codunsd2][$x]."','".$_POST[codinard2][$x]."','$_POST[docum]','".$_POST[cantidadd2][$x]."','".$_POST[valore2][$x]."','".$_POST[valortotal2][$x]."','".$_POST[unidadd2][$x]."', '$_POST[tipomov]','$_POST[tipoentra]','".$_POST[codboddcc][$x]."','".$_POST[tipcredit][$x]."','".$_POST[codcc2][$x]."')";
							$res=mysql_query($sqlr,$linkbd) or die($varinventario4=1);
							$codentrada=mysql_insert_id();
							//DOBLE PARTIDA CONTABLE TRASLADOS
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
							
							//DOBLE PARTIDA CONTABLE TRASLADOS
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
							
							//Registrar traslado
							$sqlr="INSERT INTO almtraslados(coddocumento,coddetalleentrada,coddetallesalida,codarticulo,unspsc,tipotraslado,estado) VALUES ($codinv,$codentrada,$codsalida,'".$_POST[codinard2][$x]."','".$_POST[codunsd2][$x]."','CENTROCOSTO','S')";
							mysql_query($sqlr,$linkbd);
						}
						
						$sqlr="INSERT INTO comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia, estado) VALUES ($codinv,$rowTipoComp[0],'$fechaf','$_POST[nombre]',0,$totalcc,$totalcc,0,'1')";
						mysql_query($sqlr,$linkbd) or die($varcontable5=1);
						if($varcontable1!=0 || $varcontable2!=0 || $varcontable3!=0 || $varcontable4!=0 || $varcontable5!=0 || $varinventario1!=0 || $varinventario2!=0 || $varinventario3!=0 || $varinventario4!=0)
						{
						echo "<script>despliegamodalm('visible','2','Error no se almaceno');</script>";
						}
						
					break;
					case 4: //***ENTRADA POR AJUSTE
						$totalcab=$varcontable1=$varcontable2=$varcontable3=$varinventario1=0;
						for($x=0;$x<count($_POST[codinard]);$x++)
						{
							$sql="SELECT codigo,tipocuenta,cuenta,cc FROM conceptoscontables_det WHERE conceptoscontables_det.codigo='".$_POST[dcuentas][$x]."' AND conceptoscontables_det.tipo='EA' AND conceptoscontables_det.modulo=5 and conceptoscontables_det.cuenta!='' AND  conceptoscontables_det.estado = 'S' AND conceptoscontables_det.cc = '".$_POST[dcc][$x]."' AND conceptoscontables_det.fechainicial=(SELECT MAX(T3.fechainicial) FROM conceptoscontables_det T3 WHERE  T3.codigo=conceptoscontables_det.codigo AND T3.cc = '".$_POST[dcc][$x]."' AND T3.tipo='EA' AND T3.modulo='5' AND T3.credito='S' AND T3.estado='S' AND T3.fechainicial<='$fechaf') LIMIT 1";
							$res = mysql_query($sql,$linkbd);
							$conceptoscont = mysql_fetch_row($res);
						
							$sqlr="INSERT INTO almginventario_det(codigo,unspsc,codart,solicitud,cantidad_entrada,valorunit,valortotal,unidad,tipomov,tiporeg, bodega,codcuentacre,cc) VALUES ('$codinv', '".$_POST[codunsd][$x]."','".$_POST[codinard][$x]."','$_POST[docum]','".$_POST[cantidadd][$x]."','".$_POST[valore][$x]."','".$_POST[valortotal1][$x]."','".$_POST[unidadd][$x]."', '$_POST[tipomov]','$_POST[tipoentra]','".$_POST[codbodd][$x]."','".$conceptoscont[0]."','".$_POST[dcc][$x]."')";
							$res=mysql_query($sqlr,$linkbd) or die($varinventario1=1);
							
							//DEBITO
							if($_POST[cuentacon][$x]!=""){
								$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado, vigencia,tipo_comp,numerotipo,numacti,cantarticulo) VALUES ('$rowTipoComp[0] $codinv','".$_POST[cuentacon][$x]."','".$_POST[tercero]."','".$_POST[dcc][$x]."','$_POST[nombre]','','".$_POST[valortotal1][$x]."','0','1','$vigusu','$rowTipoComp[0]','$codinv','".$_POST[codinard][$x]."','".$_POST[cantidadd][$x]."')";
								mysql_query($sqlr,$linkbd) or die($varcontable1=1);
							}
							
							//CREDITO
							if($conceptoscont[2]!=""){
								$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado, vigencia,tipo_comp,numerotipo,numacti,cantarticulo) VALUES ('$rowTipoComp[0] $codinv','".$conceptoscont[2]."','".$_POST[tercero]."','".$_POST[dcc][$x]."','$_POST[nombre]','','0','".$_POST[valortotal1][$x]."','1','$vigusu','$rowTipoComp[0]','$codinv','".$_POST[codinard][$x]."','".$_POST[cantidadd][$x]."')";
								mysql_query($sqlr,$linkbd) or die($varcontable2=1);
							}
							
							
							$sqlr="UPDATE almactoajusteentarticu SET saldo=saldo-".$_POST[cantidadd][$x]." WHERE tipo_mov='1$_POST[tipoentra]' AND idacto=".$_POST[docum]." AND codigo=".$_POST[codinard][$x];
							mysql_query($sqlr,$linkbd);
						}
						
						$sqlr="UPDATE almactoajusteent SET valorsaldo=valorsaldo-".$sumvalortotal." WHERE tipo_mov='1".$_POST[tipoentra]."' AND consecutivo=".$_POST[docum];
						mysql_query($sqlr,$linkbd);
						
						
						
						$sqlr="INSERT INTO comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia, estado) VALUES ($codinv,$rowTipoComp[0],'$fechaf','$_POST[nombre]',0,$sumvalortotal,$sumvalortotal,0,'1')";
						mysql_query($sqlr,$linkbd) or die($varcontable3=1);
						if($varcontable1!=0 || $varcontable2!=0 || $varcontable3!=0 ||$varinventario1!=0)
						{
						echo "<script>despliegamodalm('visible','2','Error no se almaceno');</script>";
						}
					break;
					case 5:
						for($x=0;$x<$_POST[contad];$x++)
						{
							$sqlr = "UPDATE ";
							//Salida de bodega
							$sqlr="INSERT INTO almginventario_det (codigo,unspsc,codart,solicitud,cantidad_salida,valorunit,valortotal,unidad,tipomov,tiporeg, bodega,codcuentacre,cc) VALUES ('$codinv', '".$_POST[codunsd][$x]."','".$_POST[codinard][$x]."','$_POST[docum]','".$_POST[cantidadd][$x]."','".$_POST[valore][$x]."','".$_POST[valortotal1][$x]."','".$_POST[unidadd][$x]."', '$_POST[tipomov]','$_POST[tipoentra]','".$_POST[codbodd][$x]."','".$_POST[tipcredit][$x]."','".$_POST[dccbod][$x]."')";
							$res=mysql_query($sqlr,$linkbd) or die($varinventario1=1);
							$codsalida=mysql_insert_id();
							//Entrada a bodega
							$sqlr="INSERT INTO almginventario_det (codigo,unspsc,codart,solicitud,cantidad_entrada,valorunit,valortotal,unidad,tipomov,tiporeg, bodega,codcuentacre,cc) VALUES ('$codinv', '".$_POST[codunsd][$x]."','".$_POST[codinard][$x]."','$_POST[docum]','".$_POST[cantidadd][$x]."','".$_POST[valore][$x]."','".$_POST[valortotal1][$x]."','".$_POST[unidadd][$x]."', '$_POST[tipomov]','$_POST[tipoentra]','".$_POST[codbodd2][$x]."','".$_POST[tipcredit][$x]."','".$_POST[dccbod][$x]."')";
							$res=mysql_query($sqlr,$linkbd) or die($varinventario2=1);
							$codentrada=mysql_insert_id();
							//Registrar traslado
							$sqlr="INSERT INTO almtraslados(coddocumento,coddetalleentrada,coddetallesalida,codarticulo,unspsc,tipotraslado,estado) VALUES ($codinv,$codentrada,$codsalida,'".$_POST[codinard][$x]."','".$_POST[codunsd][$x]."','BODEGA','S')";
							mysql_query($sqlr,$linkbd);
						}
					break;
					case 6:	//**OTRAS ENTRADAS POR COMPRA
					{
						$totalcab=$varcontable1=$varcontable2=$varcontable3=$varinventario1=0;
						for($x=0;$x<$_POST[contad];$x++)
						{
							$sqlr="INSERT INTO almginventario_det (codigo,unspsc,codart,solicitud,cantidad_entrada,valorunit,valortotal,unidad,tipomov,tiporeg, bodega,codcuentacre,cc) VALUES ('$codinv', '".$_POST[codunsd][$x]."','".$_POST[codinard][$x]."','$_POST[docum]','".$_POST[cantidadd][$x]."','".$_POST[valore][$x]."','".$_POST[valortotal1][$x]."','".$_POST[unidadd][$x]."', '$_POST[tipomov]','$_POST[tipoentra]','".$_POST[codbodd][$x]."','".$_POST[tipcredit][$x]."','".$_POST[dcc][$x]."')";
							$res=mysql_query($sqlr,$linkbd) or die($varinventario1=1);
							//CONCEPTO CONTABLE OTRAS ENTRADAS POR COMPRA DEBITO
							if($_POST[cuentacon][$x]!=""){
								$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado, vigencia,tipo_comp,numerotipo,numacti,cantarticulo) VALUES ('$rowTipoComp[0] $codinv','".$_POST[cuentacon][$x]."','".$tercero[0]."','".$_POST[dcc][$x]."','$_POST[nombre]','','".$_POST[valortotal1][$x]."','0','1','$vigusu','$rowTipoComp[0]','$codinv','".$_POST[codinard][$x]."','".$_POST[cantidadd][$x]."')";
								mysql_query($sqlr,$linkbd) or die($varcontable1=1);
							}else{
								$varcontable1=1;
							}
							
							if($_POST[cuentacre][$x]!=""){
								$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado, vigencia,tipo_comp,numerotipo,numacti,cantarticulo) VALUES ('$rowTipoComp[0] $codinv','".$_POST[cuentacre][$x]."','".$tercero[0]."','".$_POST[dcc][$x]."','$_POST[nombre]','','0','".$_POST[valortotal1][$x]."','1','$vigusu','$rowTipoComp[0]','$codinv','".$_POST[codinard][$x]."','".$_POST[cantidadd][$x]."')";
								mysql_query($sqlr,$linkbd) or die($varcontable2=1);
							}else{
								$varcontable2=1;
							}
							
						}
						for($x=0;$x<count($_POST[dcuentas]);$x++)
						{
							$consec=selconsecutivo("almginventario_cpp","id");
							$sqlru="INSERT INTO almginventario_cpp (id,codigo,cuenta,ncuenta,recurso,valorasignado,valordisponible,estado,tipomov) VALUE ('$consec','$codinv','".$_POST[dcuentas][$x]."','".$_POST[dncuentas][$x]."','".$_POST[drecursos][$x]."','".$_POST[dvalores][$x]."','".$_POST[dvdisponible][$x]."','S','ARC')";
							mysql_query($sqlru,$linkbd);
							$valoregreso=$_POST[dvalores][$x]-$_POST[dvdisponible][$x];
						}
						$sqlr="INSERT INTO comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia, estado) VALUES ($codinv,$rowTipoComp[0],'$fechaf','$_POST[nombre]',0,$sumvalortotal,$sumvalortotal,0,'1')";
						mysql_query($sqlr,$linkbd) or die($varcontable3=1);
						if($varcontable1!=0 || $varcontable2!=0 || $varcontable3!=0 ||$varinventario1!=0)
						{
						echo "<script>despliegamodalm('visible','2','Error no se almaceno');</script>";
						}
					}break;
					case 7: //***ENTRADA POR DONACION
				
						//$sql="SELECT codigo,tipocuenta,cuenta,cc FROM conceptoscontables_det WHERE conceptoscontables_det.tipo='ED' AND conceptoscontables_det.modulo=5 and conceptoscontables_det.cuenta!='' AND  conceptoscontables_det.estado = 'S' AND conceptoscontables_det.fechainicial=(SELECT MAX(T3.fechainicial) FROM conceptoscontables_det T3 WHERE  T3.codigo=conceptoscontables_det.codigo AND T3.cc = '$_POST[centrocosto]' AND T3.modulo='5' AND T3.credito='S' AND T3.estado='S' AND T3.fechainicial<='$fechaf') LIMIT 1";
						
						$totalcab=$varcontable1=$varcontable2=$varcontable3=$varinventario1=0;
						for($x=0;$x<count($_POST[codinard]);$x++)
						{
							$sql="SELECT codigo,tipocuenta,cuenta,cc FROM conceptoscontables_det WHERE conceptoscontables_det.codigo='".$_POST[dcuentas][$x]."' AND conceptoscontables_det.tipo='ED' AND conceptoscontables_det.modulo=5 and conceptoscontables_det.cuenta!='' AND  conceptoscontables_det.estado = 'S' AND conceptoscontables_det.cc = '".$_POST[dcc][$x]."' AND conceptoscontables_det.fechainicial=(SELECT MAX(T3.fechainicial) FROM conceptoscontables_det T3 WHERE  T3.codigo=conceptoscontables_det.codigo AND T3.cc = '".$_POST[dcc][$x]."' AND T3.tipo='ED' AND T3.modulo='5' AND T3.credito='S' AND T3.estado='S' AND T3.fechainicial<='$fechaf') LIMIT 1";
							//echo $sql;
							$res = mysql_query($sql,$linkbd);
							$conceptoscont = mysql_fetch_row($res);
							$sqlr="INSERT INTO almginventario_det (codigo,unspsc,codart,solicitud,cantidad_entrada,valorunit,valortotal,unidad,tipomov,tiporeg, bodega,codcuentacre,cc) VALUES ('$codinv', '".$_POST[codunsd][$x]."','".$_POST[codinard][$x]."','$_POST[docum]','".$_POST[cantidadd][$x]."','".$_POST[valore][$x]."','".$_POST[valortotal1][$x]."','".$_POST[unidadd][$x]."', '$_POST[tipomov]','$_POST[tipoentra]','".$_POST[codbodd][$x]."','".$conceptoscont[0]."','".$_POST[dcc][$x]."')";
							$res=mysql_query($sqlr,$linkbd) or die($varinventario1=1);
							//DEBITO
							if($_POST[cuentacon][$x]!=""){
								$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado, vigencia,tipo_comp,numerotipo,numacti,cantarticulo) VALUES ('$rowTipoComp[0] $codinv','".$_POST[cuentacon][$x]."','".$_POST[tercero]."','".$_POST[dcc][$x]."','$_POST[nombre]','','".$_POST[valortotal1][$x]."','0','1','$vigusu','$rowTipoComp[0]','$codinv','".$_POST[codinard][$x]."','".$_POST[cantidadd][$x]."')";
								mysql_query($sqlr,$linkbd) or die($varcontable1=1);
							}else{
								$varcontable1=1;
							}
							
							//CREDITO
							if($conceptoscont[2]!=""){
								$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado, vigencia,tipo_comp,numerotipo,numacti,cantarticulo) VALUES ('$rowTipoComp[0] $codinv','".$conceptoscont[2]."','".$_POST[tercero]."','".$_POST[dcc][$x]."','$_POST[nombre]','','0','".$_POST[valortotal1][$x]."','1','$vigusu','$rowTipoComp[0]','$codinv','".$_POST[codinard][$x]."','".$_POST[cantidadd][$x]."')";
								mysql_query($sqlr,$linkbd) or die($varcontable2=1);
							}else{
								$varcontable2=1;
							}
							$sqlr="UPDATE almactoajusteentarticu SET saldo=saldo-".$_POST[cantidadd][$x]." WHERE tipo_mov='1$_POST[tipoentra]' AND idacto=".$_POST[docum]." AND codigo=".$_POST[codinard][$x];
							mysql_query($sqlr,$linkbd);
						}
						
						$sqlr="UPDATE almactoajusteent SET valorsaldo=valorsaldo-".$sumvalortotal." WHERE tipo_mov='1".$_POST[tipoentra]."' AND consecutivo=".$_POST[docum];
						mysql_query($sqlr,$linkbd);

						$sqlr="INSERT INTO comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia, estado) VALUES ($codinv,$rowTipoComp[0],'$fechaf','$_POST[nombre]',0,$sumvalortotal,$sumvalortotal,0,'1')";
						mysql_query($sqlr,$linkbd) or die($varcontable3=1);
						if($varcontable1!=0 || $varcontable2!=0 || $varcontable3!=0 ||$varinventario1!=0)
						{
							echo "<script>despliegamodalm('visible','2','Error no se almaceno');</script>";
						}
					break;
				}
			}else{
				$tercero = view("SELECT nit FROM configbasica LIMIT 1");
				$tercero = explode('-', $tercero[0][nit]);
				switch ($_POST[tipoentra]){
					//**** Reversion de entrada por traslado
					case 3: 
						//Se inserta el comprobante de reversion total
						$sql="INSERT INTO almginventario_revtotal(coddocumento,detalle,movimiento) VALUES ($codinv,'".$_POST[nombre]."','".$_POST[tipomov]."')";
						if(mysql_query($sql,$linkbd)){
							//Actualizar traslado
							$sql="UPDATE almtraslados SET estado='R' WHERE coddocumento='$codinv' ";
							mysql_query($sqlr,$linkbd);
							
							for($x=0;$x<$_POST[contadcc];$x++)
							{
								//DOBLE PARTIDA CONTABLE TRASLADOS
								$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado, vigencia,tipo_comp,numerotipo,numacti,cantarticulo) VALUES ('$rowTipoComp[0] $codinv','".$_POST[cuentacon][$x]."','".$tercero[0]."','".$_POST[codcc][$x]."','$_POST[nombre]','','".$_POST[valortotal2][$x]."','0','2','$vigusu','$rowTipoComp[0]','$codinv','".$_POST[codinard][$x]."','".$_POST[cantidadd][$x]."')";
								mysql_query($sqlr,$linkbd) or die($varcontable1=1);
								$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado, vigencia,tipo_comp,numerotipo,numacti,cantarticulo) VALUES ('$rowTipoComp[0] $codinv','".$_POST[cuentacre][$x]."','".$tercero[0]."','".$_POST[codcc][$x]."','$_POST[nombre]','','0','".$_POST[valortotal2][$x]."','2','$vigusu','$rowTipoComp[0]','$codinv','".$_POST[codinard][$x]."','".$_POST[cantidadd][$x]."')";
								mysql_query($sqlr,$linkbd) or die($varcontable2=1);
								//DOBLE PARTIDA CONTABLE TRASLADOS
								$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado, vigencia,tipo_comp,numerotipo,numacti,cantarticulo) VALUES ('$rowTipoComp[0] $codinv','".$_POST[cuentacon][$x]."','".$tercero[0]."','".$_POST[codcc2][$x]."','$_POST[nombre]','','0','".$_POST[valortotal2][$x]."','2','$vigusu','$rowTipoComp[0]','$codinv','".$_POST[codinard][$x]."','".$_POST[cantidadd][$x]."')";
								mysql_query($sqlr,$linkbd) or die($varcontable3=1);
								$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado, vigencia,tipo_comp,numerotipo,numacti,cantarticulo) VALUES ('$rowTipoComp[0] $codinv','".$_POST[cuentacre][$x]."','".$tercero[0]."','".$_POST[codcc2][$x]."','$_POST[nombre]','','".$_POST[valortotal2][$x]."','0','2','$vigusu','$rowTipoComp[0]','$codinv','".$_POST[codinard][$x]."','".$_POST[cantidadd][$x]."')";
								mysql_query($sqlr,$linkbd) or die($varcontable4=1);
								
							}
							
							$sqlr="INSERT INTO comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia, estado) VALUES ($codinv,52,'$fechaf','$_POST[nombre]',0,$totalcc,$totalcc,0,'2')";
							mysql_query($sqlr,$linkbd) or die($varcontable5=1);
							if($varcontable1!=0 || $varcontable2!=0 || $varcontable3!=0 || $varcontable4!=0 || $varcontable5!=0 || $varinventario1!=0 || $varinventario2!=0 || $varinventario3!=0 || $varinventario4!=0)
							{
							echo "<script>despliegamodalm('visible','2','Error no se almaceno');</script>";
							}
						}
						
					break;
					
					case 4:
						//Se inserta el comprobante de reversion total
						$sql="INSERT INTO almginventario_revtotal(coddocumento,detalle,movimiento) VALUES ($codinv,'".$_POST[nombre]."','".$_POST[tipomov]."')";
						if(mysql_query($sql,$linkbd)){
							
							for($x=0;$x<count($_POST[codinard]);$x++)
							{
								//DOBLE PARTIDA CONTABLE TRASLADOS
								$sql="SELECT codigo,tipocuenta,cuenta,cc FROM conceptoscontables_det WHERE conceptoscontables_det.codigo='".$_POST[dcuentas][$x]."' AND conceptoscontables_det.tipo='EA' AND conceptoscontables_det.modulo=5 and conceptoscontables_det.cuenta!='' AND  conceptoscontables_det.estado = 'S' AND conceptoscontables_det.cc = '".$_POST[dcc][$x]."' AND conceptoscontables_det.fechainicial=(SELECT MAX(T3.fechainicial) FROM conceptoscontables_det T3 WHERE  T3.codigo=conceptoscontables_det.codigo AND T3.cc = '".$_POST[dcc][$x]."' AND T3.tipo='EA' AND T3.modulo='5' AND T3.credito='S' AND T3.estado='S' AND T3.fechainicial<='$fechaf') LIMIT 1";
								$res = mysql_query($sql,$linkbd);
								$conceptoscont = mysql_fetch_row($res);
								
								if($_POST[cuentacon][$x]!=""){
									//DEBITO
									$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado, vigencia,tipo_comp,numerotipo,numacti,cantarticulo) VALUES ('$rowTipoComp[0] $codinv','".$_POST[cuentacon][$x]."','".$_POST[dtercero][$x]."','".$_POST[dcc][$x]."','$_POST[nombre]','','0','".$_POST[valortotal1][$x]."','2','$vigusu','$rowTipoComp[0]','$codinv','".$_POST[codinard][$x]."','".$_POST[cantidadd][$x]."')";
									mysql_query($sqlr,$linkbd) or die($varcontable1=1);
								}
								
								
								if($conceptoscont[2]!=""){
									//CREDITO
									$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado, vigencia,tipo_comp,numerotipo,numacti,cantarticulo) VALUES ('$rowTipoComp[0] $codinv','".$conceptoscont[2]."','".$_POST[dtercero][$x]."','".$_POST[dcc][$x]."','$_POST[nombre]','','".$_POST[valortotal1][$x]."','0','2','$vigusu','$rowTipoComp[0]','$codinv','".$_POST[codinard][$x]."','".$_POST[cantidadd][$x]."')";
									mysql_query($sqlr,$linkbd) or die($varcontable2=1);
								}
							
								
							}
						}
						
					break;
				}
			}

			
			//**FIN entrada en transito
			
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