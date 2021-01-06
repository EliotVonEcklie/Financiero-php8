function verDetalle(id, tipocom, vigencia, tipomov){
	if($('#detalle'+id).css('display')=='none'){
		$('#detalle'+id).css('display','block');
		$('#img'+id).attr('src','imagenes/minus.gif');
	}
	else{
		$('#detalle'+id).css('display','none');
		$('#img'+id).attr('src','imagenes/plus.gif');
	}
	var toLoad= 'ws/detalle_egresos.php';
	$.post(toLoad,{tipocom:tipocom, vigencia:vigencia, tipomov:tipomov},function (data){
		$('#detalle'+id).html(data.detalle);
		return false;
	},'json');
}

function verDetallerp(id, tipocom, vigencia, tipomov){
	if($('#detalle'+id).css('display')=='none'){
		$('#detalle'+id).css('display','block');
		$('#img'+id).attr('src','imagenes/minus.gif');
	}
	else{
		$('#detalle'+id).css('display','none');
		$('#img'+id).attr('src','imagenes/plus.gif');
	}
	var toLoad= 'ws/detalle_rp.php';
	$.post(toLoad,{tipocom:tipocom, vigencia:vigencia, tipomov:tipomov},function (data){
		$('#detalle'+id).html(data.detalle);
		return false;
	},'json');
}

function verDetalleSaldos(id, sector, vigencia){
	if($('#detalle'+id).css('display')=='none'){
		$('#detalle'+id).css('display','block');
		$('#img'+id).attr('src','imagenes/minus.gif');
	}
	else{
		$('#detalle'+id).css('display','none');
		$('#img'+id).attr('src','imagenes/plus.gif');
	}
	var toLoad= 'ws/detalle_saldos.php';
	$.post(toLoad,{sector:sector, vigencia:vigencia},function (data){
		$('#detalle'+id).html(data.detalle);
		return false;
	},'json');
}

function verDetallePredial(id, codcat, ord, tot){
	if($('#detalle'+id).css('display')=='none'){
		$('#detalle'+id).css('display','block');
		$('#img'+id).attr('src','imagenes/minus.gif');
	}
	else{
		$('#detalle'+id).css('display','none');
		$('#img'+id).attr('src','imagenes/plus.gif');
	}
	var toLoad= 'ws/detalle_predial.php';
	$.post(toLoad,{codcat:codcat, ord:ord, tot:tot},function (data){
		$('#detalle'+id).html(data.detalle);
		return false;
	},'json');
}

function verDetalleFuentes(id, meta,vigenciai,vigenciaf){
	if($('#detalle'+id).css('display')=='none'){
		$('#detalle'+id).css('display','block');
		$('#img'+id).attr('src','imagenes/minus.gif');
	}
	else{
		$('#detalle'+id).css('display','none');
		$('#img'+id).attr('src','imagenes/plus.gif');
	}
	
	var toLoad= 'ws/detalle_fuentes.php';
	$.post(toLoad,{meta:meta,vigenciai:vigenciai,vigenciaf:vigenciaf },function (data){
		$('#detalle'+id).html(data.detalle);
		return false;
	},'json');

}

function verDetalleFuentesCompara(id, meta,vigenciai,vigenciaf){
	if($('#detalle'+id).css('display')=='none'){
		$('#detalle'+id).css('display','block');
		$('#img'+id).attr('src','imagenes/minus.gif');
	}
	else{
		$('#detalle'+id).css('display','none');
		$('#img'+id).attr('src','imagenes/plus.gif');
	}
	
	var toLoad= 'ws/detalle_fuentes_compara.php';
	$.post(toLoad,{meta:meta,vigenciai:vigenciai,vigenciaf:vigenciaf },function (data){
		$('#detalle'+id).html(data.detalle);
		return false;
	},'json');

}


function verpoai(id,codigo,vigencia1,vigencia2)
{
	if($('#detalle'+id).css('display')=='none'){
			$('#detalle'+id).css('display','block');
			$('#img'+id).attr('src','imagenes/minus.gif');
		}
		else{
			$('#detalle'+id).css('display','none');
			$('#img'+id).attr('src','imagenes/plus.gif');
		}
		var toLoad= 'ws/detalle_poai.php';
		$.post(toLoad,{codigo:codigo,vigencia1:vigencia1,vigencia2:vigencia2},function (data){
			
			$('#detalle'+id).html(data.detalle);
			return false;
		},'json');
}

function verDetalleGastos(id,cuenta, unidadEjecutora='', medioPago='', vigencia='',codInv='')
{//alert(unidadEjecutora);
	if($('#detalle'+id).css('display')=='none'){
			$('#detalletr'+id).css('display','block');
			$('#detalle'+id).css('display','block');
			$('#img'+id).attr('src','imagenes/minus.gif');
		}
		else{
			$('#detalletr'+id).css('display','none');
			$('#detalle'+id).css('display','none');
			$('#img'+id).attr('src','imagenes/plus.gif');
		}
		var toLoad= 'ws/detalle_presupuesto_gastos.php';
		$.post(toLoad,{cuenta:cuenta,unidadEjecutora:unidadEjecutora, medioPago:medioPago, vigencia:vigencia, codInv:codInv},function (data){
			
			$('#detalle'+id).html(data.detalle);
			return false;
		},'json');
}

function verDetalleIngresos(id,cuenta, unidadEjecutora='', medioPago='', vigencia='')
{
	//alert(medioPago);
	if($('#detalle'+id).css('display')=='none'){
			$('#detalletr'+id).css('display','block');
			$('#detalle'+id).css('display','block');
			$('#img'+id).attr('src','imagenes/minus.gif');
		}
		else{
			$('#detalletr'+id).css('display','none');
			$('#detalle'+id).css('display','none');
			$('#img'+id).attr('src','imagenes/plus.gif');
		}
		var toLoad= 'ws/detalle_presupuesto_ingresos.php';
		$.post(toLoad,{cuenta:cuenta,unidadEjecutora:unidadEjecutora, medioPago:medioPago, vigencia:vigencia},function (data){
			
			$('#detalle'+id).html(data.detalle);
			return false;
		},'json');
}

function verDetallePredialAcumulado(id, codcat,ceros,data){
	var json=eval(data);
	var str="0";
	var nuevo=str.repeat(ceros);
	var ultcod=nuevo.concat(codcat);
	if($('#detalle'+id).css('display')=='none'){
		$('#detalle'+id).css('display','block');
		$('#img'+id).attr('src','imagenes/minus.gif');
	}
	else{
		$('#detalle'+id).css('display','none');
		$('#img'+id).attr('src','imagenes/plus.gif');
	}

		tabla="<table width='90%'>";
		tabla+="<tr class='titulos'>";
		tabla+="<td >Cedula Catastral</td>";
		tabla+="<td>Predial</td>";
		tabla+="<td>Interes Predial</td>";
		tabla+="<td>Desc.Interes Predial</td>";
		tabla+="<td>Sobretasa Bomberial</td>";
		tabla+="<td>Interes Bomberial</td>";
		tabla+="<td>Sobretasa Ambiental</td>";
		tabla+="<td>Interes Ambiental</td>";
		tabla+="<td>Descuentos</td>";
		tabla+="<td>Valor Total</td>";
		tabla+="</tr>";
		for(var i=0;i<json.length; i++){
			tabla+="<tr class='zebra1'>";
			tabla+="<td>"+ultcod+"</td>";
			tabla+="<td>"+json[i].predial+"</td>";
			tabla+="<td>"+json[i].ipredial+"</td>";
			tabla+="<td>"+json[i].descipred+"</td>";
			tabla+="<td>"+json[i].bomberil+"</td>";
			tabla+="<td>"+json[i].ibomberil+"</td>";
			tabla+="<td>"+json[i].ambiental+"</td>";
			tabla+="<td>"+json[i].iambiental+"</td>";
			tabla+="<td>"+json[i].descuentos+"</td>";
			tabla+="<td>"+json[i].total+"</td>";
			tabla+="</tr>";
		}
		tabla+="</table>";
		$('#detalle'+id).html(tabla);
		return false;
}

function verDetallePreFactura(id, codcat,ceros,data){
	var json=eval(data);
	var str="0";
	var nuevo=str.repeat(ceros);
	var ultcod=nuevo.concat(codcat);
	if($('#detalle'+id).css('display')=='none'){
		$('#detalle'+id).css('display','block');
		$('#img'+id).attr('src','imagenes/minus.gif');
	}
	else{
		$('#detalle'+id).css('display','none');
		$('#img'+id).attr('src','imagenes/plus.gif');
	}

		tabla="<table width='100%'>";
		tabla+="<tr class='titulos'>";
		tabla+="<td ></td>";
		tabla+="<td >Vigencia</td>";
		tabla+="<td >Cedula Catastral</td>";
		tabla+="<td>Predial</td>";
		tabla+="<td>Sobretasa Bomberial</td>";
		tabla+="<td>Sobretasa Ambiental</td>";
		tabla+="<td>Valor Total</td>";
		tabla+="</tr>";
		for(var i=0;i<json.length; i++){
			var objson = { predial : json[i].predial, bomberil : json[i].bomberil, ambiental : json[i].ambiental , total : json[i].total }
			tabla+="<tr class='zebra1'>";
			tabla+="<td><input type='checkbox' name='itempredio[]' checked onChange='acumularPorPredio("+ id +",this,"+JSON.stringify(objson)+")'/>  </td>";
			tabla+="<td> "+json[i].vigencia+"</td>";
			tabla+="<td>"+ultcod+"</td>";
			tabla+="<td> $ "+new Intl.NumberFormat("de-DE").format(json[i].predial)+"</td>";
			tabla+="<td>$ "+new Intl.NumberFormat("de-DE").format(json[i].bomberil)+"</td>";
			tabla+="<td> $ "+new Intl.NumberFormat("de-DE").format(json[i].ambiental)+"</td>";
			tabla+="<td> $ "+new Intl.NumberFormat("de-DE").format(json[i].total)+"</td>";
			tabla+="</tr>";
		}
		tabla+="</table>";
		$('#detalle'+id).html(tabla);
		return false;
}

function verDetalleRadicacion(id, radicado){
	if($('#detalle'+id).css('display')=='none'){
		$('#detalle'+id).css('display','block');
		$('#img'+id).attr('src','imagenes/minus.gif');
	}
	else{
		$('#detalle'+id).css('display','none');
		$('#img'+id).attr('src','imagenes/plus.gif');
	}
	var toLoad= 'ws/detalle_radicacion.php';
	$.post(toLoad,{radicado:radicado},function (data){
		$('#detalle'+id).html(data.detalle);
		return false;
	},'json');
}

function verDetalleDescNom(id, nomina, tercero){
	if($('#detalle'+id).css('display')=='none'){
		$('#detalle'+id).css('display','block');
		$('#img'+id).attr('src','imagenes/minus.gif');
	}
	else{
		$('#detalle'+id).css('display','none');
		$('#img'+id).attr('src','imagenes/plus.gif');
	}
	var toLoad= 'ws/detalle_desc_nomina.php';
	$.post(toLoad,{nomina:nomina, tercero:tercero},function (data){
		$('#detalle'+id).html(data.detalle);
		return false;
	},'json');
}

function scrollToId(id){
    $('html,body').animate({
        scrollTop: $("#"+id).offset().top
    },'slow');
}

function verChat(){
	if($('#divchat').css('display')=='none'){
		$('#divchat').css('display','block');
	}
	else{
		$('#divchat').css('display','none');
	}
}
//*** carga rubros gastos bancarios */
function cargarubroGB()
{
// alert("entro");
 var numerorp=$("#rp").val();
 var vigenciarp=$("#vigencia").val();
 var parametros = {
	"numerorp": numerorp,        
	"vigenciarp": vigenciarp,        
};
// alert("rp:"+numerorp+"vigencia"+vigenciarp);
$.ajax({
	data: parametros,
	type: 'POST',
	url: 'Controllers/cargarubros.php',
	beforeSend: function () {        
	},        
	success: function (response) {
	$('#rubros').html(response);
	}
});
}
//***fin */
//****busca tercero */
function bterceros(documento,ndocumento)
{
 var tercero=$('#'+documento).val();
 if(tercero!="")
 {
 var nombreproceso='BUSCARTERCERO';
 var parametros = {
	"NOMBRE_PROCESO": nombreproceso,        
	"tercero": tercero,        
		};
$.ajax({
	data: parametros,
	type: 'POST',
	url: 'css/cargasfunciones.php',
	beforeSend: function () {        
	},        
	success: function (response) {
	if(response=="")
	{
		swal("SPID","Tercero No existe","warning");
	}
	else
	{
	$('#'+ndocumento).val(response);
	}
  }
 });
}
}
/** fin buscatercero */
//****busca Entidad reciproca */
function buscaNombreEntidad(idEntidad, entidad)
{
	var id_entidad=$('#'+idEntidad).val();
 	if(id_entidad!="")
 	{
		var nombreproceso='BUSCARENTIDAD';
		var parametros = {
			"NOMBRE_PROCESO": nombreproceso,        
			"id_entidad": id_entidad,        
		};
		$.ajax({
			data: parametros,
			type: 'POST',
			url: 'css/cargasfunciones.php',
			beforeSend: function () {        
			},        
			success: function (response) 
			{
				console.log(parametros);
				if(response=="")
				{
					swal("SPID","Entidad No existe","warning");
				}
				else
				{
					$('#'+entidad).val(response);
				}
			}
 		});
	}
}
/** fin buscar entidad */
function actualizaresponsable(placa,tercero)
{
	//alert("i");
	var activoplaca=$("#"+placa).val();
	var responsable=$("#"+tercero).val();
	if(tercero!="")
	{
	var nombreproceso='ACTUALIZARESPONSABLEACTIVO';
	var parametros = {
	   "NOMBRE_PROCESO": nombreproceso,        
	   "tercero": responsable,
	   "placa":activoplaca,        
		   };
   $.ajax({
	   data: parametros,
	   type: 'POST',
	   url: 'css/cargasfunciones.php',
	   beforeSend: function () {        
	   },        
	   success: function (response) {
		//alert(response);
	   if(response=="1")
	   {
		   swal("SPID","Responsable del Activo Actualizado","success");
	   }
	   if(response=="error")
	   {
	    swal("SPID","El Responsable del Activo no se ha Actualizado","error");
	   }
	 }
	});
   }
}
/**grupo activos */
function grupo_activos()
{
 var clase=$("#clasificacion").val();	
 
	var parametros = {      
	   "clase": clase,        
		   };
   $.ajax({
	   data: parametros,
	   type: 'POST',
	   url: 'Controllers/grupos_activos.php',
	   beforeSend: function () {        
	   },        
	   success: function (response) {
		$("#grupo").html(response);	
	 }
	});
}
function tipos_activos()
{
 var clase=$("#clasificacion").val();	
 var grupo=$("#grupo").val();	
	var parametros = {      
	   "clase": clase,  
	   "grupo": grupo,        
		   };
   $.ajax({
	   data: parametros,
	   type: 'POST',
	   url: 'Controllers/tipos_activos.php',
	   beforeSend: function () {        
	   },        
	   success: function (response) {
		$("#tipo").html(response);	
	 }
	});
}

function agregardetalle_JQ()
{
	var clase=$("#clasificacion").val();	
 	var grupo=$("#grupo").val();	
	var nfila = $("#tabla-activo-det tbody tr").length;
	var idfila = nfila;
	var htmlTags = '<tr id="' + idfila + '">' +
			'<td id="">' + nfila + '</td>' +
			'<td id="Clase">' + clase + '</td>' +
			'<td id="Grupo">' + grupo + '</td>' +
			'<td id="Tipo">' + clase + '</td>' +
			'<td id="Disposicion">' + grupo + '</td>' +
			'<td id="Secretaria">' + clase + '</td>' +
			'<td id="Supervisor">' + grupo + '</td>' +
			'<td>' + '<input type="button" class="btn btn-danger " value="Eliminar" onclick="eliminarfilaOC(' + idfila + ')">' + '</td>' +
			'</tr>';
	$('#tabla-activo-det tbody').append(htmlTags);
}
//**** ELIMINAR FILA ORDEN COMPRA */
function eliminarfilaOC(codigofila) {
	//alert('st:'+codigofila);        
	$('#tabla-activo-det tr#' + codigofila).remove();
}
//******   */

//**** guardar activo en construccion *******/
function activocontruc_guardar()
{
	//alert("entra");
	var fecha=$("#fc_1198971545").val();	
	var descripcion=$("#descripcab").val();
	var nombreproceso="CONSTRUCCIONCURSO_GUARDAR";
	//alert("f"+fecha);
	var parametros = {      
		"NOMBRE_PROCESO": nombreproceso, 
		"fecha": fecha,  
		"descripcion": descripcion,        
			};
	swal({ title: "¿Estas Seguro de Guardar?",
    text: "Se creara un activo en construccion!",
    type: "warning",
    showCancelButton: true,
	confirmButtonColor: '#59B7E4',
	cancelButtonColor: '#D64423',
    confirmButtonText: 'Si, Estoy Seguro!',
    cancelButtonText: "No, Cancelar!",
    closeOnConfirm: false,
    closeOnCancel: false },
	function(isConfirm){
			if (isConfirm){
	$.ajax({
		data: parametros,
		type: 'POST',
		url: 'css/funciones_guardado.php',
		beforeSend: function () {        
		},        
		success: function (response) {
			//alert("v"+response);
			if(response!="ERROR")
			{
				swal("SPID","Se ha Creado el Activo en Construccion No "+response,"success","mUY BIEN");
			}
			if(response=="ERROR")
			{
			 swal("SPID","No Se ha Creado el Activo en Construccion", "error","ffff");
			}
	  }
	 }); 
	}
	else {
        swal("Cancelado", "Continua modificando la informacion del activo en construccion :)", "success");
      }
	});
}
//**** fin de guardar *****/

// forma de pago
$(document).ready(function() 
{
	$('#formaDePago').change(function() 
	{
		if ($(this).val() == '2') {
			$('#formaDePagoLabel').html('Cheque:');
		} else if($(this).val() == '1') {
			$('#formaDePagoLabel').html('Transferencia:');
		}
		else
		{
			$('#formaDePagoLabel').html('');
		}
	});
});

//ventanas mensajes
function despliegamodalm(_valor,_tip,mensa,pregunta)
{
	document.getElementById("bgventanamodalm").style.visibility=_valor;
	if(_valor=="hidden"){document.getElementById('ventanam').src="";}
	else
	{
		switch(_tip)
		{
			case "1":	document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
			case "2":	document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
			case "3":	document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
			case "4":	document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
		}
	}
}
